<?php
declare(strict_types=1);

use App\Events;
use App\Mailer;
use App\Registrations;

/** @var App\Router $router */

function require_admin(array $roles = []): array
{
    $a = admin();
    if (!$a) {
        $_SESSION['intended'] = $_SERVER['REQUEST_URI'] ?? '/admin';
        redirect('/admin/login');
    }
    if ($roles && !in_array($a['role'], $roles, true)) abort(403, 'Anda tidak mempunyai akses ke halaman ini.');
    return $a;
}

/** Build WHERE clause for the participant list / export from query params. */
function registration_filters(array $q): array
{
    $where = ['1=1'];
    $args = [];
    if (!empty($q['event'])) { $where[] = 'r.event_id = ?'; $args[] = (int) $q['event']; }
    if (!empty($q['status']) && isset(STATUS_LABELS[$q['status']])) { $where[] = 'r.status = ?'; $args[] = $q['status']; }
    if (!empty($q['type']) && isset(EVENT_TYPES[$q['type']])) { $where[] = 'e.type = ?'; $args[] = $q['type']; }
    if (!empty($q['zone'])) { $where[] = 'r.zone = ?'; $args[] = (string) $q['zone']; }
    if (!empty($q['q'])) {
        $where[] = '(r.full_name LIKE ? OR r.email LIKE ? OR r.ic_no LIKE ? OR r.ref_code LIKE ? OR r.agency LIKE ?)';
        $like = '%' . trim((string) $q['q']) . '%';
        array_push($args, $like, $like, $like, $like, $like);
    }
    return [implode(' AND ', $where), $args];
}

/** Sanitise the JSON produced by the custom-question builder. */
function normalize_custom_fields(string $json): ?string
{
    $in = json_decode($json, true);
    if (!is_array($in)) return null;
    $out = [];
    $used = [];
    foreach (array_slice($in, 0, 20) as $i => $f) {
        $label = trim((string) ($f['label'] ?? ''));
        if ($label === '') continue;
        $type = in_array($f['type'] ?? '', ['text', 'textarea', 'select', 'radio', 'checkbox'], true) ? $f['type'] : 'text';
        $key = preg_replace('/[^a-z0-9_]/', '', strtolower((string) ($f['key'] ?? ''))) ?: 'q' . ($i + 1);
        while (isset($used[$key])) $key .= '_' . ($i + 1);
        $used[$key] = true;
        $opts = [];
        if (in_array($type, ['select', 'radio', 'checkbox'], true)) {
            $opts = array_values(array_unique(array_filter(array_map(fn($o) => mb_substr(trim((string) $o), 0, 120), (array) ($f['options'] ?? [])))));
            if (!$opts) continue; // a choice question needs choices
        }
        $out[] = ['key' => $key, 'label' => mb_substr($label, 0, 200), 'type' => $type, 'options' => $opts, 'required' => !empty($f['required'])];
    }
    return $out ? json_encode($out, JSON_UNESCAPED_UNICODE) : null;
}

/* ================= Auth ================= */

$router->get('/admin/login', function () {
    if (admin()) redirect('/admin');
    view('admin/login', ['title' => 'Log Masuk Admin'], null);
});

$router->post('/admin/login', function () {
    verify_csrf();
    if (too_many_attempts('admin', 5, 15)) {
        flash('error', 'Terlalu banyak cubaan log masuk. Sila cuba lagi selepas 15 minit.');
        redirect('/admin/login');
    }
    $id = trim((string) ($_POST['username'] ?? ''));
    $pw = (string) ($_POST['password'] ?? '');
    $st = db()->prepare('SELECT * FROM admins WHERE (username = ? OR email = ?) AND is_active = 1 LIMIT 1');
    $st->execute([$id, $id]);
    $a = $st->fetch();
    if (!$a || !password_verify($pw, $a['password_hash'])) {
        record_attempt('admin');
        with_input(['login' => 'Nama pengguna atau kata laluan tidak sah.']);
        redirect('/admin/login');
    }
    clear_attempts('admin');
    if (password_needs_rehash($a['password_hash'], PASSWORD_DEFAULT)) {
        db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash($pw, PASSWORD_DEFAULT), $a['id']]);
    }
    session_regenerate_id(true);
    $_SESSION['admin'] = ['id' => (int) $a['id'], 'name' => $a['name'], 'email' => $a['email'], 'username' => $a['username'], 'role' => $a['role']];
    db()->prepare('UPDATE admins SET last_login_at = NOW() WHERE id = ?')->execute([$a['id']]);
    audit('login');
    flash('success', 'Selamat datang kembali, ' . $a['name'] . '!');
    $to = $_SESSION['intended'] ?? '/admin';
    unset($_SESSION['intended']);
    redirect(str_starts_with($to, '/admin') ? $to : '/admin');
});

$router->post('/admin/logout', function () {
    verify_csrf();
    if (admin()) audit('logout');
    unset($_SESSION['admin']);
    session_regenerate_id(true);
    flash('info', 'Anda telah log keluar.');
    redirect('/admin/login');
});

/* ================= Dashboard ================= */

$router->get('/admin', function () {
    require_admin();
    $pdo = db();
    $kpi = $pdo->query("SELECT
        SUM(status <> 'cancelled') AS total,
        SUM(status IN ('registered','attended','absent')) AS confirmed,
        SUM(status = 'attended') AS attended,
        SUM(status = 'waitlisted') AS waitlisted,
        SUM(status = 'cancelled') AS cancelled,
        SUM(created_at >= CURDATE() - INTERVAL 7 DAY AND status <> 'cancelled') AS week
        FROM registrations")->fetch();
    $kpi['upcoming'] = (int) $pdo->query("SELECT COUNT(*) FROM events WHERE status = 'open' AND event_date >= CURDATE()")->fetchColumn();
    $pastConfirmed = (int) $pdo->query("SELECT COUNT(*) FROM registrations r JOIN events e ON e.id = r.event_id WHERE e.event_date <= CURDATE() AND r.status IN ('registered','attended','absent')")->fetchColumn();
    $pastAttended = (int) $pdo->query("SELECT COUNT(*) FROM registrations r JOIN events e ON e.id = r.event_id WHERE e.event_date <= CURDATE() AND r.status = 'attended'")->fetchColumn();
    $kpi['rate'] = $pastConfirmed ? round($pastAttended / $pastConfirmed * 100) : null;

    // Registrations per day (last 30 days)
    $rows = $pdo->query("SELECT DATE(created_at) d, COUNT(*) c FROM registrations WHERE created_at >= CURDATE() - INTERVAL 29 DAY GROUP BY d")->fetchAll(PDO::FETCH_KEY_PAIR);
    $daily = [];
    for ($i = 29; $i >= 0; $i--) {
        $d = date('Y-m-d', strtotime("-{$i} day"));
        $daily[] = ['label' => date('j/n', strtotime($d)), 'value' => (int) ($rows[$d] ?? 0)];
    }
    $byZone = $pdo->query("SELECT COALESCE(zone,'Lain') label, COUNT(*) value FROM registrations WHERE status <> 'cancelled' GROUP BY zone ORDER BY value DESC")->fetchAll();
    $byType = array_map(fn($r) => ['label' => type_label($r['label']), 'value' => (int) $r['value']],
        $pdo->query("SELECT e.type label, COUNT(*) value FROM registrations r JOIN events e ON e.id = r.event_id WHERE r.status <> 'cancelled' GROUP BY e.type ORDER BY value DESC")->fetchAll());
    $byMinistry = $pdo->query("SELECT COALESCE(ministry, 'Tidak dinyatakan') label, COUNT(*) value FROM registrations WHERE status <> 'cancelled' GROUP BY ministry ORDER BY value DESC LIMIT 8")->fetchAll();
    $byAgency = $pdo->query("SELECT agency label, COUNT(*) value FROM registrations WHERE status <> 'cancelled' GROUP BY agency ORDER BY value DESC LIMIT 8")->fetchAll();

    $events = array_values(array_filter(Events::all(), fn($e) => $e['event_date'] >= date('Y-m-d') && $e['status'] !== 'draft'));
    usort($events, fn($a, $b) => strcmp($a['event_date'], $b['event_date']));
    $recent = $pdo->query('SELECT r.*, e.title AS event_title, e.type AS event_type FROM registrations r JOIN events e ON e.id = r.event_id ORDER BY r.created_at DESC LIMIT 8')->fetchAll();

    view('admin/dashboard', compact('kpi', 'daily', 'byZone', 'byType', 'byMinistry', 'byAgency', 'events', 'recent') + ['title' => 'Papan Pemuka'], 'admin');
});

/* ================= Events ================= */

$router->get('/admin/acara', function () {
    require_admin();
    view('admin/events', ['events' => Events::all(), 'title' => 'Acara'], 'admin');
});

$eventForm = function (?array $event) {
    view('admin/event-form', ['event' => $event, 'title' => $event ? 'Kemaskini Acara' : 'Acara Baharu'], 'admin');
};

$saveEvent = function (?int $id) {
    $d = [
        'type' => isset(EVENT_TYPES[$_POST['type'] ?? '']) ? $_POST['type'] : 'latihan',
        'title' => trim((string) ($_POST['title'] ?? '')),
        'description' => trim((string) ($_POST['description'] ?? '')) ?: null,
        'zone_id' => (int) ($_POST['zone_id'] ?? 0) ?: null,
        'state_id' => (int) ($_POST['state_id'] ?? 0) ?: null,
        'event_date' => (string) ($_POST['event_date'] ?? ''),
        'start_time' => (string) ($_POST['start_time'] ?? ''),
        'end_time' => (string) ($_POST['end_time'] ?? ''),
        'venue_name' => trim((string) ($_POST['venue_name'] ?? '')),
        'venue_address' => trim((string) ($_POST['venue_address'] ?? '')) ?: null,
        'capacity' => max(1, (int) ($_POST['capacity'] ?? 0)),
        'waitlist_enabled' => !empty($_POST['waitlist_enabled']) ? 1 : 0,
        'registration_deadline' => ($_POST['registration_deadline'] ?? '') ? str_replace('T', ' ', (string) $_POST['registration_deadline']) : null,
        'closed_message' => trim((string) ($_POST['closed_message'] ?? '')) ?: null,
        'status' => in_array($_POST['status'] ?? '', ['draft', 'open', 'closed'], true) ? $_POST['status'] : 'open',
        'custom_fields' => normalize_custom_fields((string) ($_POST['custom_fields'] ?? '')),
    ];
    $errors = [];
    if (mb_strlen($d['title']) < 5) $errors['title'] = 'Tajuk sekurang-kurangnya 5 aksara.';
    if (!DateTime::createFromFormat('Y-m-d', $d['event_date'])) $errors['event_date'] = 'Tarikh tidak sah.';
    if (!preg_match('/^\d{2}:\d{2}/', $d['start_time'])) $errors['start_time'] = 'Masa mula tidak sah.';
    if (!preg_match('/^\d{2}:\d{2}/', $d['end_time'])) $errors['end_time'] = 'Masa tamat tidak sah.';
    elseif ($d['end_time'] <= $d['start_time']) $errors['end_time'] = 'Masa tamat mesti selepas masa mula.';
    if ($d['venue_name'] === '') $errors['venue_name'] = 'Sila masukkan nama tempat.';
    if ($errors) {
        with_input($errors);
        flash('error', 'Sila betulkan ralat pada borang.');
        redirect($id ? "/admin/acara/{$id}/edit" : '/admin/acara/baru');
    }
    $pdo = db();
    if ($id) {
        $d['slug'] = Events::uniqueSlug($d['title'], $id);
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($d)));
        $pdo->beginTransaction();
        $pdo->prepare("UPDATE events SET $set WHERE id = :id")->execute($d + ['id' => $id]);
        // Capacity may have grown: promote people from the waitlist.
        $promoted = [];
        while ($p = Registrations::promoteNext($id)) $promoted[] = $p;
        $pdo->commit();
        foreach ($promoted as $p) Mailer::sendTemplate('promoted', $p);
        audit('event.update', 'event', $id, $d['title']);
        flash('success', 'Acara dikemaskini.' . ($promoted ? ' ' . count($promoted) . ' peserta dinaikkan dari senarai menunggu.' : ''));
    } else {
        $d['slug'] = Events::uniqueSlug($d['title']);
        $cols = implode(', ', array_keys($d));
        $ph = implode(', ', array_map(fn($k) => ":$k", array_keys($d)));
        $pdo->prepare("INSERT INTO events ($cols) VALUES ($ph)")->execute($d);
        $id = (int) $pdo->lastInsertId();
        audit('event.create', 'event', $id, $d['title']);
        flash('success', 'Acara baharu berjaya dicipta.');
    }
    redirect('/admin/acara');
};

$router->get('/admin/acara/baru', function () use ($eventForm) { require_admin(); $eventForm(null); });
$router->post('/admin/acara/baru', function () use ($saveEvent) { require_admin(); verify_csrf(); $saveEvent(null); });
$router->get('/admin/acara/{id}/edit', function (string $id) use ($eventForm) {
    require_admin();
    $ev = Events::find((int) $id) ?? abort(404);
    $eventForm($ev);
});
$router->post('/admin/acara/{id}/edit', function (string $id) use ($saveEvent) {
    require_admin(); verify_csrf();
    Events::find((int) $id) ?? abort(404);
    $saveEvent((int) $id);
});
$router->post('/admin/acara/{id}/salin', function (string $id) {
    require_admin(); verify_csrf();
    $ev = Events::find((int) $id) ?? abort(404);
    $title = $ev['title'] . ' (Salinan)';
    db()->prepare('INSERT INTO events (type, title, slug, description, zone_id, state_id, event_date, start_time, end_time, venue_name, venue_address, capacity, waitlist_enabled, registration_deadline, closed_message, custom_fields, status)
        SELECT type, ?, ?, description, zone_id, state_id, event_date, start_time, end_time, venue_name, venue_address, capacity, waitlist_enabled, registration_deadline, closed_message, custom_fields, \'draft\' FROM events WHERE id = ?')
        ->execute([$title, Events::uniqueSlug($title), $id]);
    $new = (int) db()->lastInsertId();
    audit('event.duplicate', 'event', $new, $title);
    flash('success', 'Acara disalin sebagai draf. Sila kemaskini tarikh dan butiran.');
    redirect("/admin/acara/{$new}/edit");
});
$router->post('/admin/acara/{id}/padam', function (string $id) {
    require_admin(['superadmin', 'admin']); verify_csrf();
    $ev = Events::find((int) $id) ?? abort(404);
    db()->prepare('DELETE FROM events WHERE id = ?')->execute([$id]);
    audit('event.delete', 'event', (int) $id, $ev['title'] . " ({$ev['confirmed']} peserta)");
    flash('success', 'Acara dan semua pendaftarannya telah dipadam.');
    redirect('/admin/acara');
});

/* ================= Participants ================= */

$router->get('/admin/peserta', function () {
    require_admin();
    [$where, $args] = registration_filters($_GET);
    $perPage = 20;
    $page = max(1, (int) ($_GET['page'] ?? 1));
    $st = db()->prepare("SELECT COUNT(*) FROM registrations r JOIN events e ON e.id = r.event_id WHERE $where");
    $st->execute($args);
    $total = (int) $st->fetchColumn();
    $pages = max(1, (int) ceil($total / $perPage));
    $page = min($page, $pages);
    $st = db()->prepare("SELECT r.*, e.title AS event_title, e.type AS event_type, e.event_date FROM registrations r JOIN events e ON e.id = r.event_id
        WHERE $where ORDER BY r.created_at DESC LIMIT $perPage OFFSET " . (($page - 1) * $perPage));
    $st->execute($args);
    $rows = $st->fetchAll();
    $counts = db()->prepare("SELECT r.status, COUNT(*) c FROM registrations r JOIN events e ON e.id = r.event_id WHERE " . registration_filters(array_diff_key($_GET, ['status' => 1]))[0] . " GROUP BY r.status");
    $counts->execute(registration_filters(array_diff_key($_GET, ['status' => 1]))[1]);
    view('admin/registrations', [
        'rows' => $rows, 'total' => $total, 'page' => $page, 'pages' => $pages,
        'counts' => $counts->fetchAll(PDO::FETCH_KEY_PAIR),
        'events' => db()->query('SELECT id, title, event_date FROM events ORDER BY event_date DESC')->fetchAll(),
        'title' => 'Peserta',
    ], 'admin');
});

$router->get('/admin/peserta/eksport', function () {
    require_admin();
    [$where, $args] = registration_filters($_GET);
    $st = db()->prepare("SELECT r.ref_code, e.title, e.type, e.event_date, r.full_name, r.ic_no, r.email, r.mobile_no, r.office_no, r.agency, r.ministry, r.grade,
        r.state, r.zone, r.status, r.checked_in_at, r.absence_reason, r.created_at, r.answers, e.custom_fields
        FROM registrations r JOIN events e ON e.id = r.event_id WHERE $where ORDER BY e.event_date, r.created_at");
    $st->execute($args);
    audit('export.csv', null, null, http_build_query($_GET));

    // One event selected: each custom question gets its own column. Otherwise answers go in one column.
    $event = !empty($_GET['event']) ? Events::find((int) $_GET['event']) : null;
    $fields = $event ? custom_fields($event) : [];
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="peserta-' . ($event ? $event['slug'] : 'semua') . '-' . date('Ymd-His') . '.csv"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF"); // BOM so Excel reads UTF-8
    $head = ['No. Rujukan', 'Acara', 'Jenis', 'Tarikh Acara', 'Nama', 'No. MyKad', 'E-mel', 'Tel. Bimbit', 'Tel. Pejabat', 'Organisasi', 'Organisasi Induk', 'Jawatan/Gred', 'Negeri', 'Zon', 'Status', 'Masa Daftar Masuk', 'Sebab Tidak Hadir', 'Tarikh Daftar'];
    fputcsv($out, $event ? array_merge($head, array_column($fields, 'label')) : array_merge($head, ['Jawapan Tambahan']));
    while ($r = $st->fetch()) {
        $answers = json_decode((string) $r['answers'], true) ?: [];
        $defs = $fields ?: custom_fields($r);
        $row = [$r['ref_code'], $r['title'], type_label($r['type']), $r['event_date'], $r['full_name'], "\t" . $r['ic_no'], // tab keeps MyKad leading zeros in Excel
            $r['email'], $r['mobile_no'], $r['office_no'], $r['agency'], $r['ministry'], $r['grade'], $r['state'], $r['zone'],
            STATUS_LABELS[$r['status']][0] ?? $r['status'], $r['checked_in_at'], $r['absence_reason'], $r['created_at']];
        if ($event) {
            foreach ($fields as $f) $row[] = answer_text($answers[$f['key']] ?? '');
        } else {
            $row[] = implode('; ', array_map(fn($f) => $f['label'] . ': ' . answer_text($answers[$f['key']] ?? '-'), $defs));
        }
        fputcsv($out, $row);
    }
    fclose($out);
});

$router->post('/admin/peserta/pukal', function () {
    $me = require_admin(); verify_csrf();
    $ids = array_map('intval', (array) ($_POST['ids'] ?? []));
    $action = (string) ($_POST['action'] ?? '');
    if (!$ids) { flash('error', 'Tiada peserta dipilih.'); back(); }
    $done = 0;
    foreach ($ids as $id) {
        $reg = Registrations::find($id);
        if (!$reg) continue;
        switch ($action) {
            case 'attended':
                db()->prepare("UPDATE registrations SET status = 'attended', checked_in_at = COALESCE(checked_in_at, NOW()), checked_in_by = ? WHERE id = ?")->execute([$me['id'], $id]);
                break;
            case 'absent':
                db()->prepare("UPDATE registrations SET status = 'absent' WHERE id = ?")->execute([$id]);
                break;
            case 'resend':
                if (in_array($reg['status'], ['registered', 'waitlisted', 'attended'], true)) {
                    Mailer::sendTemplate($reg['status'] === 'waitlisted' ? 'waitlist' : 'confirm', $reg);
                }
                break;
            case 'delete':
                if ($me['role'] === 'staff') { flash('error', 'Kakitangan tidak dibenarkan memadam.'); back(); }
                db()->prepare('DELETE FROM registrations WHERE id = ?')->execute([$id]);
                break;
            default:
                flash('error', 'Tindakan tidak sah.'); back();
        }
        $done++;
    }
    audit('registration.bulk.' . $action, 'registration', null, $done . ' rekod: ' . implode(',', $ids));
    flash('success', "Tindakan berjaya untuk {$done} peserta.");
    back();
});

$router->get('/admin/peserta/{id}', function (string $id) {
    require_admin();
    $reg = Registrations::find((int) $id) ?? abort(404);
    $st = db()->prepare("SELECT a.*, ad.name AS admin_name FROM audit_log a LEFT JOIN admins ad ON ad.id = a.admin_id WHERE a.entity = 'registration' AND a.entity_id = ? ORDER BY a.created_at DESC LIMIT 20");
    $st->execute([$id]);
    $checker = null;
    if ($reg['checked_in_by']) {
        $c = db()->prepare('SELECT name FROM admins WHERE id = ?');
        $c->execute([$reg['checked_in_by']]);
        $checker = $c->fetchColumn();
    }
    view('admin/registration', ['reg' => $reg, 'history' => $st->fetchAll(), 'checker' => $checker, 'title' => $reg['full_name']], 'admin');
});

$router->post('/admin/peserta/{id}', function (string $id) {
    require_admin(); verify_csrf();
    $reg = Registrations::find((int) $id) ?? abort(404);
    $f = [
        'full_name' => mb_strtoupper(trim((string) ($_POST['full_name'] ?? ''))),
        'email' => strtolower(trim((string) ($_POST['email'] ?? ''))),
        'ic_no' => preg_replace('/\D/', '', (string) ($_POST['ic_no'] ?? '')),
        'mobile_no' => preg_replace('/\D/', '', (string) ($_POST['mobile_no'] ?? '')),
        'office_no' => preg_replace('/\D/', '', (string) ($_POST['office_no'] ?? '')) ?: null,
        'agency' => trim((string) ($_POST['agency'] ?? '')),
        'ministry' => trim((string) ($_POST['ministry'] ?? '')),
        'grade' => mb_strtoupper(trim((string) ($_POST['grade'] ?? ''))),
        'state' => (string) ($_POST['state'] ?? ''),
    ];
    $f['ministry'] = $f['ministry'] ?: null;
    [$answers] = Registrations::validateAnswers(custom_fields($reg), (array) ($_POST['q'] ?? []), false);
    $f['answers'] = $answers ? json_encode($answers, JSON_UNESCAPED_UNICODE) : null;
    $errors = [];
    if (mb_strlen($f['full_name']) < 3) $errors['full_name'] = 'Nama tidak sah.';
    if (!filter_var($f['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'E-mel tidak sah.';
    if (!preg_match('/^\d{12}$/', $f['ic_no'])) $errors['ic_no'] = 'MyKad mesti 12 digit.';
    $dup = db()->prepare("SELECT id FROM registrations WHERE event_id = ? AND id <> ? AND (ic_no = ? OR email = ?) AND status <> 'cancelled'");
    $dup->execute([$reg['event_id'], $id, $f['ic_no'], $f['email']]);
    if ($dup->fetch()) $errors['ic_no'] = 'MyKad atau e-mel ini telah digunakan oleh peserta lain dalam acara yang sama.';
    if ($errors) { with_input($errors); flash('error', 'Sila betulkan ralat.'); redirect("/admin/peserta/{$id}"); }
    $states = array_column(lookup_items('states'), 'zone_id', 'name');
    $zones = array_column(lookup_items('zones'), 'name', 'id');
    $f['zone'] = isset($states[$f['state']]) ? $zones[$states[$f['state']]] : $reg['zone'];
    $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($f)));
    try {
        db()->prepare("UPDATE registrations SET $set WHERE id = :id")->execute($f + ['id' => $id]);
    } catch (PDOException $ex) {
        with_input(['ic_no' => 'MyKad atau e-mel ini bertembung dengan rekod lain.']);
        redirect("/admin/peserta/{$id}");
    }
    audit('registration.update', 'registration', (int) $id, $reg['ref_code']);
    flash('success', 'Maklumat peserta dikemaskini.');
    redirect("/admin/peserta/{$id}");
});

$router->post('/admin/peserta/{id}/status', function (string $id) {
    $me = require_admin(); verify_csrf();
    $reg = Registrations::find((int) $id) ?? abort(404);
    $status = (string) ($_POST['status'] ?? '');
    if (!isset(STATUS_LABELS[$status])) abort(400);
    $promoted = null;
    if ($status === 'cancelled') {
        $promoted = Registrations::cancel($reg);
    } elseif ($status === 'attended') {
        db()->prepare("UPDATE registrations SET status = 'attended', checked_in_at = COALESCE(checked_in_at, NOW()), checked_in_by = ? WHERE id = ?")->execute([$me['id'], $id]);
    } else {
        db()->prepare('UPDATE registrations SET status = ?, checked_in_at = IF(? = \'attended\', checked_in_at, NULL) WHERE id = ?')->execute([$status, $status, $id]);
        if ($reg['status'] === 'waitlisted' && $status === 'registered') {
            Mailer::sendTemplate('promoted', Registrations::find((int) $id));
        }
    }
    if ($promoted) Mailer::sendTemplate('promoted', $promoted);
    audit('registration.status', 'registration', (int) $id, "{$reg['status']} → {$status}");
    flash('success', 'Status dikemaskini kepada "' . STATUS_LABELS[$status][0] . '".' . ($promoted ? " {$promoted['full_name']} dinaikkan dari senarai menunggu." : ''));
    back();
});

$router->post('/admin/peserta/{id}/emel', function (string $id) {
    require_admin(); verify_csrf();
    $reg = Registrations::find((int) $id) ?? abort(404);
    $code = match ($reg['status']) { 'waitlisted' => 'waitlist', 'cancelled' => 'cancelled', default => 'confirm' };
    $ok = Mailer::sendTemplate($code, $reg);
    audit('registration.resend', 'registration', (int) $id, $code);
    flash($ok ? 'success' : 'error', $ok ? "E-mel dihantar semula ke {$reg['email']}." : 'Gagal menghantar e-mel. Semak tetapan SMTP.');
    back();
});

$router->post('/admin/peserta/{id}/padam', function (string $id) {
    require_admin(['superadmin', 'admin']); verify_csrf();
    $reg = Registrations::find((int) $id) ?? abort(404);
    db()->prepare('DELETE FROM registrations WHERE id = ?')->execute([$id]);
    audit('registration.delete', 'registration', (int) $id, "{$reg['ref_code']} {$reg['full_name']}");
    flash('success', 'Rekod peserta dipadam.');
    redirect('/admin/peserta');
});

/* ================= QR check-in ================= */

$router->get('/admin/imbas', function () {
    require_admin();
    $events = db()->query("SELECT id, title, event_date FROM events WHERE status <> 'draft' AND event_date >= CURDATE() - INTERVAL 1 DAY ORDER BY event_date")->fetchAll();
    $today = array_values(array_filter($events, fn($e) => $e['event_date'] === date('Y-m-d')));
    $selected = (int) ($_GET['event'] ?? ($today[0]['id'] ?? ($events[0]['id'] ?? 0)));
    view('admin/scanner', ['events' => $events, 'selected' => $selected, 'title' => 'Imbas Kehadiran'], 'admin');
});

$router->get('/admin/imbas/statistik', function () {
    require_admin();
    $eventId = (int) ($_GET['event'] ?? 0);
    $st = db()->prepare("SELECT SUM(status = 'attended') attended, SUM(status IN ('registered','attended','absent')) confirmed FROM registrations WHERE event_id = ?");
    $st->execute([$eventId]);
    $recent = db()->prepare("SELECT full_name, agency, ref_code, checked_in_at FROM registrations WHERE event_id = ? AND status = 'attended' ORDER BY checked_in_at DESC LIMIT 8");
    $recent->execute([$eventId]);
    json_response(['stats' => $st->fetch(), 'recent' => array_map(fn($r) => $r + ['time' => date('g:i A', strtotime($r['checked_in_at']))], $recent->fetchAll())]);
});

$router->post('/admin/imbas', function () {
    $me = require_admin(); verify_csrf();
    $code = trim((string) ($_POST['code'] ?? ''));
    $eventId = (int) ($_POST['event'] ?? 0) ?: null;
    if (str_starts_with($code, 'HDR:')) $code = substr($code, 4);
    // Accept a QR token, a ticket URL, or a typed reference code.
    if (preg_match('#/tiket/([a-f0-9]{40})#', $code, $m)) $code = $m[1];
    if (!preg_match('/^[a-f0-9]{40}$/', $code)) {
        $st = db()->prepare('SELECT token FROM registrations WHERE ref_code = ?');
        $st->execute([strtoupper($code)]);
        $code = (string) ($st->fetchColumn() ?: $code);
    }
    [$ok, $message, $reg] = Registrations::checkIn($code, $eventId, $me['id']);
    $state = !$ok ? 'err' : (!empty($reg['_repeat']) ? 'warn' : 'ok');
    json_response([
        'ok' => $ok, 'state' => $state, 'message' => $message,
        'participant' => $reg ? [
            'name' => $reg['full_name'], 'agency' => $reg['agency'], 'ref' => $reg['ref_code'],
            'org' => $reg['grade'], 'event' => $reg['event_title'], 'id' => $reg['id'],
        ] : null,
    ]);
});

/* ================= Email templates ================= */

$router->get('/admin/emel', function () {
    require_admin();
    $templates = db()->query('SELECT * FROM email_templates ORDER BY id')->fetchAll();
    $code = (string) ($_GET['t'] ?? ($templates[0]['code'] ?? ''));
    $current = null;
    foreach ($templates as $t) if ($t['code'] === $code) $current = $t;
    view('admin/emails', ['templates' => $templates, 'current' => $current ?? $templates[0] ?? null, 'title' => 'Templat E-mel'], 'admin');
});

$sampleReg = function (): array {
    $ev = db()->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 1")->fetch() ?: [];
    return [
        'full_name' => 'AHMAD BIN ALI', 'email' => 'ahmad@agensi.gov.my', 'ref_code' => 'LT-ABC123', 'token' => str_repeat('a', 40),
        'status' => 'registered', 'event_title' => $ev['title'] ?? 'Contoh Acara', 'event_type' => $ev['type'] ?? 'latihan',
        'event_date' => $ev['event_date'] ?? date('Y-m-d'), 'start_time' => $ev['start_time'] ?? '09:00:00', 'end_time' => $ev['end_time'] ?? '17:00:00',
        'venue_name' => $ev['venue_name'] ?? 'Dewan Utama', 'venue_address' => $ev['venue_address'] ?? '',
    ];
};

$router->post('/admin/emel/pratonton', function () use ($sampleReg) {
    require_admin(); verify_csrf();
    [$subject, $html] = Mailer::render(['subject' => (string) ($_POST['subject'] ?? ''), 'body' => (string) ($_POST['body'] ?? '')], $sampleReg());
    json_response(['subject' => $subject, 'html' => $html]);
});

$router->post('/admin/emel/{code}', function (string $code) use ($sampleReg) {
    $me = require_admin(['superadmin', 'admin']); verify_csrf();
    $tpl = Mailer::template($code) ?? abort(404);
    $subject = trim((string) ($_POST['subject'] ?? ''));
    $body = trim((string) ($_POST['body'] ?? ''));
    if ($subject === '' || $body === '') { flash('error', 'Subjek dan kandungan wajib diisi.'); redirect('/admin/emel?t=' . urlencode($code)); }
    db()->prepare('UPDATE email_templates SET subject = ?, body = ? WHERE code = ?')->execute([$subject, $body, $code]);
    audit('email.update', 'email_template', (int) $tpl['id'], $code);
    if (!empty($_POST['send_test'])) {
        [$s, $html, $text] = Mailer::render(['subject' => $subject, 'body' => $body], $sampleReg());
        $ok = Mailer::send($me['email'], $me['name'], '[UJIAN] ' . $s, $html, $text);
        flash($ok ? 'success' : 'error', $ok ? "Templat disimpan & e-mel ujian dihantar ke {$me['email']}." : 'Templat disimpan tetapi e-mel ujian gagal dihantar.');
    } else {
        flash('success', 'Templat e-mel disimpan.');
    }
    redirect('/admin/emel?t=' . urlencode($code));
});

/* ================= Admin users ================= */

$router->get('/admin/pentadbir', function () {
    require_admin(['superadmin']);
    view('admin/admins', ['admins' => db()->query('SELECT * FROM admins ORDER BY created_at')->fetchAll(), 'title' => 'Pentadbir'], 'admin');
});

$router->post('/admin/pentadbir', function () {
    require_admin(['superadmin']); verify_csrf();
    $d = [
        'name' => trim((string) ($_POST['name'] ?? '')),
        'email' => strtolower(trim((string) ($_POST['email'] ?? ''))),
        'username' => strtolower(trim((string) ($_POST['username'] ?? ''))),
        'role' => in_array($_POST['role'] ?? '', ['superadmin', 'admin', 'staff'], true) ? $_POST['role'] : 'staff',
    ];
    $pw = (string) ($_POST['password'] ?? '');
    $errors = [];
    if ($d['name'] === '') $errors['name'] = 'Wajib.';
    if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'E-mel tidak sah.';
    if (!preg_match('/^[a-z0-9_.]{3,40}$/', $d['username'])) $errors['username'] = '3-40 aksara: huruf kecil, nombor, _ atau .';
    if (strlen($pw) < 8) $errors['password'] = 'Sekurang-kurangnya 8 aksara.';
    $st = db()->prepare('SELECT 1 FROM admins WHERE username = ? OR email = ?');
    $st->execute([$d['username'], $d['email']]);
    if ($st->fetch()) $errors['username'] = 'Nama pengguna atau e-mel sudah wujud.';
    if ($errors) { with_input($errors); flash('error', 'Gagal menambah pentadbir.'); redirect('/admin/pentadbir#tambah'); }
    db()->prepare('INSERT INTO admins (name, email, username, password_hash, role) VALUES (?,?,?,?,?)')
        ->execute([$d['name'], $d['email'], $d['username'], password_hash($pw, PASSWORD_DEFAULT), $d['role']]);
    audit('admin.create', 'admin', (int) db()->lastInsertId(), $d['username']);
    flash('success', "Pentadbir {$d['name']} ditambah.");
    redirect('/admin/pentadbir');
});

$router->post('/admin/pentadbir/{id}/toggle', function (string $id) {
    $me = require_admin(['superadmin']); verify_csrf();
    if ((int) $id === $me['id']) { flash('error', 'Anda tidak boleh menyahaktifkan akaun sendiri.'); back(); }
    db()->prepare('UPDATE admins SET is_active = 1 - is_active WHERE id = ?')->execute([$id]);
    audit('admin.toggle', 'admin', (int) $id);
    flash('success', 'Status akaun dikemaskini.');
    back();
});

$router->post('/admin/pentadbir/{id}/reset', function (string $id) {
    require_admin(['superadmin']); verify_csrf();
    $pw = substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes(9))), 0, 10);
    db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash($pw, PASSWORD_DEFAULT), $id]);
    audit('admin.reset_password', 'admin', (int) $id);
    flash('success', "Kata laluan sementara: {$pw} — sila berikan kepada pengguna dan minta mereka menukarnya.");
    back();
});

/* ================= Profile ================= */

$router->get('/admin/profil', function () {
    $me = require_admin();
    $st = db()->prepare('SELECT * FROM admins WHERE id = ?');
    $st->execute([$me['id']]);
    view('admin/profile', ['me' => $st->fetch(), 'title' => 'Profil'], 'admin');
});

$router->post('/admin/profil', function () {
    $me = require_admin(); verify_csrf();
    $st = db()->prepare('SELECT * FROM admins WHERE id = ?');
    $st->execute([$me['id']]);
    $row = $st->fetch();
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $current = (string) ($_POST['current_password'] ?? '');
    $new = (string) ($_POST['new_password'] ?? '');
    $errors = [];
    if ($name === '') $errors['name'] = 'Wajib.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'E-mel tidak sah.';
    if ($new !== '') {
        if (!password_verify($current, $row['password_hash'])) $errors['current_password'] = 'Kata laluan semasa tidak betul.';
        if (strlen($new) < 8) $errors['new_password'] = 'Sekurang-kurangnya 8 aksara.';
        if ($new !== ($_POST['confirm_password'] ?? '')) $errors['confirm_password'] = 'Pengesahan tidak sepadan.';
    }
    if ($errors) { with_input($errors); flash('error', 'Sila betulkan ralat.'); redirect('/admin/profil'); }
    db()->prepare('UPDATE admins SET name = ?, email = ? WHERE id = ?')->execute([$name, $email, $me['id']]);
    if ($new !== '') {
        db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash($new, PASSWORD_DEFAULT), $me['id']]);
        audit('admin.password_change', 'admin', $me['id']);
    }
    $_SESSION['admin']['name'] = $name;
    $_SESSION['admin']['email'] = $email;
    flash('success', 'Profil dikemaskini.' . ($new !== '' ? ' Kata laluan telah ditukar.' : ''));
    redirect('/admin/profil');
});

/* ================= Audit log ================= */

$router->get('/admin/log', function () {
    require_admin();
    $page = max(1, (int) ($_GET['page'] ?? 1));
    $per = 40;
    $total = (int) db()->query('SELECT COUNT(*) FROM audit_log')->fetchColumn();
    $rows = db()->query('SELECT a.*, ad.name AS admin_name FROM audit_log a LEFT JOIN admins ad ON ad.id = a.admin_id ORDER BY a.id DESC LIMIT ' . $per . ' OFFSET ' . (($page - 1) * $per))->fetchAll();
    view('admin/audit', ['rows' => $rows, 'page' => $page, 'pages' => max(1, (int) ceil($total / $per)), 'title' => 'Log Audit'], 'admin');
});
