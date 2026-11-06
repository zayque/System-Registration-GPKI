<?php
declare(strict_types=1);

$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';

// Load .env when running outside docker-compose (compose already injects env vars)
if (is_file($root . '/.env') && !getenv('DB_HOST')) {
    foreach (file($root . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if ($line[0] === '#' || !str_contains($line, '=')) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $_ENV[$k] = trim($v, "\"'");
    }
}

date_default_timezone_set('Asia/Kuala_Lumpur');
ini_set('display_errors', env('APP_DEBUG', false) ? '1' : '0');
error_reporting(E_ALL);

session_name('hadirin_session');
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();

// Expose one-shot old input / errors to the views, then clear them.
$GLOBALS['__old'] = $_SESSION['_old'] ?? [];
$GLOBALS['__errors'] = $_SESSION['_errors'] ?? [];
unset($_SESSION['_old'], $_SESSION['_errors']);

set_exception_handler(function (Throwable $e) {
    error_log((string) $e);
    http_response_code(500);
    if (env('APP_DEBUG', false)) {
        echo '<pre style="padding:20px;white-space:pre-wrap">' . e((string) $e) . '</pre>';
    } else {
        view('public/error', ['code' => 500, 'message' => 'Ralat sistem. Sila cuba sebentar lagi.', 'title' => 'Ralat']);
    }
});

$router = new App\Router();
require $root . '/src/routes/public.php';
require $root . '/src/routes/admin.php';
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
