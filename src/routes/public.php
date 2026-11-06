<?php
declare(strict_types=1);

use App\Events;
use App\Ics;
use App\Mailer;
use App\Qr;
use App\Registrations;
use App\Ticket;

/** @var App\Router $router */

$router->get('/', function () {
    $events = Events::upcoming();
    $stats = db()->query("SELECT
        (SELECT COUNT(*) FROM registrations WHERE status <> 'cancelled') AS participants,
        (SELECT COUNT(*) FROM events WHERE status <> 'draft') AS events,
        (SELECT COUNT(DISTINCT agency) FROM registrations) AS agencies")->fetch();
    view('public/home', ['events' => array_slice($events, 0, 6), 'stats' => $stats, 'title' => 'Utama']);
});

$router->get('/acara', function () {
    $type = isset(EVENT_TYPES[$_GET['jenis'] ?? '']) ? $_GET['jenis'] : null;
    $availableTypes = array_values(array_unique(array_column(Events::upcoming(), 'type')));
    view('public/events', ['events' => Events::upcoming($type), 'type' => $type, 'availableTypes' => $availableTypes, 'title' => 'Senarai Acara']);
});

$router->get('/acara/{slug}', function (string $slug) {
    $event = Events::findBySlug($slug);
    if (!$event || $event['status'] === 'draft') abort(404, 'Acara tidak dijumpai.');
    view('public/event', ['event' => $event, 'title' => $event['title']]);
});

$router->post('/acara/{slug}/daftar', function (string $slug) {
    verify_csrf();
    $event = Events::findBySlug($slug);
    if (!$event || $event['status'] === 'draft') abort(404);
    if (!Events::acceptsRegistrations($event)) {
        flash('error', $event['closed_message'] ?: 'Pendaftaran untuk acara ini telah ditutup.');
        redirect('/acara/' . $slug);
    }
    // Honeypot: bots fill hidden "website" field
    if (!empty($_POST['website'])) redirect('/acara/' . $slug);

    [$data, $errors] = Registrations::validate($_POST, $event);
    if ($errors) {
        with_input($errors);
        flash('error', 'Sila semak semula maklumat yang bertanda merah.');
        redirect('/acara/' . $slug . '#borang');
    }
    try {
        $reg = Registrations::create($event, $data);
    } catch (RuntimeException $ex) {
        with_input();
        flash('error', $ex->getMessage());
        redirect('/acara/' . $slug . '#borang');
    }
    $code = $reg['status'] === 'waitlisted' ? 'waitlist' : 'confirm';
    $sent = Mailer::sendTemplate($code, $reg);
    $_SESSION['just_registered'] = $reg['token'];
    $_SESSION['mail_sent'] = $sent;
    redirect('/tiket/' . $reg['token']);
});

/* ---------------- Ticket (token acts as the secret link) ---------------- */

$ticket = function (string $token): array {
    $reg = Registrations::findByToken($token);
    if (!$reg) abort(404, 'Tiket tidak dijumpai.');
    return $reg;
};

$router->get('/tiket/{token}', function (string $token) use ($ticket) {
    $reg = $ticket($token);
    $fresh = ($_SESSION['just_registered'] ?? null) === $token;
    $mailSent = $_SESSION['mail_sent'] ?? null;
    unset($_SESSION['just_registered'], $_SESSION['mail_sent']);
    view('public/ticket', ['reg' => $reg, 'fresh' => $fresh, 'mailSent' => $mailSent, 'title' => 'Tiket ' . $reg['ref_code']]);
});

$router->get('/tiket/{token}/qr.png', function (string $token) use ($ticket) {
    $reg = $ticket($token);
    header('Content-Type: image/png');
    header('Cache-Control: private, max-age=86400');
    echo Qr::png($reg['token']);
});

$router->get('/tiket/{token}/pdf', function (string $token) use ($ticket) {
    $reg = $ticket($token);
    header('Content-Type: application/pdf');
    header('Content-Disposition: ' . (isset($_GET['papar']) ? 'inline' : 'attachment') . '; filename="Tiket-' . $reg['ref_code'] . '.pdf"');
    echo Ticket::pdf($reg);
});

$router->get('/tiket/{token}/ics', function (string $token) use ($ticket) {
    $reg = $ticket($token);
    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $reg['ref_code'] . '.ics"');
    echo Ics::forRegistration($reg);
});

$router->post('/tiket/{token}/batal', function (string $token) use ($ticket) {
    verify_csrf();
    $reg = $ticket($token);
    if (!in_array($reg['status'], ['registered', 'waitlisted'], true) || $reg['event_date'] < date('Y-m-d')) {
        flash('error', 'Pendaftaran ini tidak boleh dibatalkan.');
        redirect('/tiket/' . $token);
    }
    $promoted = Registrations::cancel($reg);
    Mailer::sendTemplate('cancelled', array_merge($reg, ['status' => 'cancelled']), false);
    if ($promoted) Mailer::sendTemplate('promoted', $promoted);
    flash('success', 'Pendaftaran anda telah dibatalkan. Terima kasih kerana memaklumkan.');
    redirect('/tiket/' . $token);
});

$router->post('/tiket/{token}/tidak-hadir', function (string $token) use ($ticket) {
    verify_csrf();
    $reg = $ticket($token);
    $reason = trim((string) ($_POST['reason'] ?? ''));
    if (mb_strlen($reason) < 5) {
        flash('error', 'Sila nyatakan sebab ketidakhadiran (sekurang-kurangnya 5 aksara).');
        redirect('/tiket/' . $token);
    }
    if ($reg['status'] === 'attended') {
        flash('error', 'Kehadiran anda telah direkodkan.');
        redirect('/tiket/' . $token);
    }
    $wasRegistered = $reg['status'] === 'registered';
    $isFuture = $reg['event_date'] >= date('Y-m-d');
    $pdo = db();
    $pdo->beginTransaction();
    // Before the event: notifying absence frees the seat. After: it's recorded as "absent" with a reason.
    $pdo->prepare('UPDATE registrations SET status = ?, absence_reason = ? WHERE id = ?')
        ->execute([$isFuture ? 'cancelled' : 'absent', mb_substr($reason, 0, 1000), $reg['id']]);
    $promoted = ($isFuture && $wasRegistered) ? Registrations::promoteNext((int) $reg['event_id']) : null;
    $pdo->commit();
    if ($promoted) Mailer::sendTemplate('promoted', $promoted);
    flash('success', 'Terima kasih. Makluman ketidakhadiran anda telah direkodkan.');
    redirect('/tiket/' . $token);
});

/* ---------------- Lookup (email + MyKad) ---------------- */

$router->get('/semak', function () {
    view('public/lookup', ['title' => 'Semak Pendaftaran']);
});

$router->post('/semak', function () {
    verify_csrf();
    if (too_many_attempts('lookup', 10, 15)) {
        flash('error', 'Terlalu banyak cubaan. Sila cuba lagi selepas 15 minit.');
        redirect('/semak');
    }
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $ic = preg_replace('/\D/', '', (string) ($_POST['ic_no'] ?? ''));
    $regs = ($email && $ic) ? Registrations::findForParticipant($email, $ic) : [];
    if (!$regs) {
        record_attempt('lookup');
        with_input(['lookup' => 'Tiada pendaftaran dijumpai untuk e-mel dan No. MyKad ini.']);
        redirect('/semak');
    }
    session_regenerate_id(true);
    $_SESSION['participant'] = ['email' => $email, 'ic' => $ic, 'at' => time()];
    redirect('/tiket-saya');
});

$router->get('/tiket-saya', function () {
    $p = $_SESSION['participant'] ?? null;
    if (!$p || time() - $p['at'] > 1800) {
        unset($_SESSION['participant']);
        flash('info', 'Sila sahkan identiti anda untuk melihat tiket.');
        redirect('/semak');
    }
    $regs = Registrations::findForParticipant($p['email'], $p['ic']);
    view('public/my-tickets', ['regs' => $regs, 'title' => 'Tiket Saya']);
});

$router->post('/tiket-saya/keluar', function () {
    verify_csrf();
    unset($_SESSION['participant']);
    redirect('/semak');
});
