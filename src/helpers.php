<?php
declare(strict_types=1);

use App\Database;

function env(string $key, mixed $default = null): mixed
{
    $v = $_ENV[$key] ?? getenv($key);
    if ($v === false || $v === null || $v === '') {
        return $default;
    }
    return match (strtolower((string) $v)) {
        'true' => true,
        'false' => false,
        default => $v,
    };
}

function db(): PDO
{
    return Database::pdo();
}

/** Escape for HTML output. */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_url(): string
{
    return rtrim((string) env('APP_URL', 'http://localhost:8080'), '/');
}

function url(string $path = ''): string
{
    return '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    $file = dirname(__DIR__) . '/public/assets/' . ltrim($path, '/');
    $v = is_file($file) ? filemtime($file) : 1;
    return '/assets/' . ltrim($path, '/') . '?v=' . $v;
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function back(): never
{
    $ref = $_SERVER['HTTP_REFERER'] ?? '/';
    // only allow same-host redirects
    $host = parse_url($ref, PHP_URL_HOST);
    if ($host && $host !== ($_SERVER['HTTP_HOST'] ?? '') && $host !== parse_url('http://' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST)) {
        $ref = '/';
    }
    redirect($ref);
}

/** Render a view inside a layout. */
function view(string $name, array $data = [], ?string $layout = 'public'): void
{
    $viewFile = dirname(__DIR__) . '/views/' . $name . '.php';
    extract($data, EXTR_SKIP);
    ob_start();
    require $viewFile;
    $content = ob_get_clean();
    if ($layout === null) {
        echo $content;
        return;
    }
    require dirname(__DIR__) . '/views/layouts/' . $layout . '.php';
}

function partial(string $name, array $data = []): void
{
    extract($data, EXTR_SKIP);
    require dirname(__DIR__) . '/views/partials/' . $name . '.php';
}

function json_response(array $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function abort(int $code = 404, string $message = 'Halaman tidak dijumpai'): never
{
    http_response_code($code);
    view('public/error', ['code' => $code, 'message' => $message, 'title' => (string) $code]);
    exit;
}

/* ---------------- Request ---------------- */

function input(string $key, mixed $default = null): mixed
{
    $v = $_POST[$key] ?? $_GET[$key] ?? $default;
    return is_string($v) ? trim($v) : $v;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function client_ip(): string
{
    return substr($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0', 0, 45);
}

/* ---------------- Session: flash, old input, errors ---------------- */

function flash(string $type, string $message): void
{
    $_SESSION['_flash'][] = ['type' => $type, 'message' => $message];
}

function take_flashes(): array
{
    $f = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return $f;
}

function with_input(array $errors = []): void
{
    $_SESSION['_old'] = $_POST;
    $_SESSION['_errors'] = $errors;
}

function old(string $key, mixed $default = ''): mixed
{
    return $GLOBALS['__old'][$key] ?? $default;
}

function error_for(string $key): ?string
{
    return $GLOBALS['__errors'][$key] ?? null;
}

/* ---------------- CSRF ---------------- */

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $sent = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
        abort(403, 'Sesi telah tamat. Sila muat semula halaman dan cuba lagi.');
    }
}

/* ---------------- Rate limiting ---------------- */

function too_many_attempts(string $scope, int $max, int $minutes): bool
{
    $st = db()->prepare('SELECT COUNT(*) FROM login_attempts WHERE scope = ? AND ip = ? AND created_at > (NOW() - INTERVAL ? MINUTE)');
    $st->execute([$scope, client_ip(), $minutes]);
    return (int) $st->fetchColumn() >= $max;
}

function record_attempt(string $scope): void
{
    db()->prepare('INSERT INTO login_attempts (scope, ip) VALUES (?, ?)')->execute([$scope, client_ip()]);
}

function clear_attempts(string $scope): void
{
    db()->prepare('DELETE FROM login_attempts WHERE scope = ? AND ip = ?')->execute([$scope, client_ip()]);
}

/* ---------------- Audit ---------------- */

function audit(string $action, ?string $entity = null, ?int $entityId = null, ?string $details = null): void
{
    db()->prepare('INSERT INTO audit_log (admin_id, action, entity, entity_id, details, ip) VALUES (?,?,?,?,?,?)')
        ->execute([$_SESSION['admin']['id'] ?? null, $action, $entity, $entityId, $details ? mb_substr($details, 0, 500) : null, client_ip()]);
}

/* ---------------- Formatting (Bahasa Melayu) ---------------- */

const BULAN_BM = [1 => 'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];
const HARI_BM = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];

function tarikh_bm(?string $date): string
{
    if (!$date) return '-';
    $t = strtotime($date);
    return date('j', $t) . ' ' . BULAN_BM[(int) date('n', $t)] . ' ' . date('Y', $t);
}

function hari_bm(?string $date): string
{
    return $date ? HARI_BM[(int) date('w', strtotime($date))] : '-';
}

function masa_bm(?string $time): string
{
    if (!$time) return '-';
    $t = strtotime($time);
    $h = (int) date('G', $t);
    $suffix = $h < 12 ? 'pagi' : ($h < 14 ? 'tengah hari' : ($h < 19 ? 'petang' : 'malam'));
    return date('g:i', $t) . ' ' . $suffix;
}

function datetime_bm(?string $dt): string
{
    return $dt ? tarikh_bm($dt) . ', ' . date('g:i A', strtotime($dt)) : '-';
}

/** Event types: key => [label, ref prefix, icon]. Colours live in app.css (.t-{key}). */
const EVENT_TYPES = [
    'latihan'     => ['Latihan', 'LT', 'graduation-cap'],
    'seminar'     => ['Seminar', 'SM', 'presentation'],
    'bengkel'     => ['Bengkel', 'BK', 'wrench'],
    'persidangan' => ['Persidangan', 'PS', 'mic'],
    'webinar'     => ['Webinar', 'WB', 'monitor-play'],
    'majlis'      => ['Majlis', 'MJ', 'party-popper'],
];

function type_label(string $type): string
{
    return EVENT_TYPES[$type][0] ?? ucfirst($type);
}

/** RGB pairs used for gradients in PDF tickets and emails. */
function type_colors(string $type): array
{
    return match ($type) {
        'seminar'     => ['#6d28d9', '#c026d3'],
        'bengkel'     => ['#0f766e', '#0ea5e9'],
        'persidangan' => ['#b45309', '#e11d48'],
        'webinar'     => ['#0c4a6e', '#0284c7'],
        'majlis'      => ['#be123c', '#f59e0b'],
        default       => ['#0a1f44', '#1e40af'],
    };
}

/** Decode an event's custom question definitions. */
function custom_fields(array $event): array
{
    $f = json_decode((string) ($event['custom_fields'] ?? ''), true);
    return is_array($f) ? $f : [];
}

/** Human readable value of one answer. */
function answer_text(mixed $v): string
{
    return is_array($v) ? implode(', ', $v) : (string) ($v ?? '');
}

const STATUS_LABELS = [
    'registered' => ['Berdaftar', 'blue'],
    'waitlisted' => ['Menunggu', 'amber'],
    'attended'   => ['Hadir', 'green'],
    'absent'     => ['Tidak Hadir', 'rose'],
    'cancelled'  => ['Dibatalkan', 'gray'],
];

function status_badge(string $status): string
{
    [$label, $tone] = STATUS_LABELS[$status] ?? [$status, 'gray'];
    return '<span class="badge badge-' . $tone . '">' . e($label) . '</span>';
}

function mask_ic(string $ic): string
{
    return substr($ic, 0, 6) . '-**-' . substr($ic, -4);
}

function initials(string $name): string
{
    $parts = preg_split('/\s+/', trim($name)) ?: [];
    $s = '';
    foreach (array_slice($parts, 0, 2) as $p) {
        $s .= mb_strtoupper(mb_substr($p, 0, 1));
    }
    return $s ?: '?';
}

function slugify(string $text): string
{
    $text = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $text), '-'));
    return $text ?: 'acara';
}

function admin(): ?array
{
    return $_SESSION['admin'] ?? null;
}

function lookup_items(string $table): array
{
    static $cache = [];
    if (!isset($cache[$table])) {
        $allowed = ['zones', 'states', 'ministries'];
        if (!in_array($table, $allowed, true)) return [];
        $cache[$table] = db()->query("SELECT * FROM {$table} ORDER BY " . ($table === 'zones' ? 'id' : 'name'))->fetchAll();
    }
    return $cache[$table];
}
