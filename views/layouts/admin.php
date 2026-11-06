<?php
$path = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
$me = admin();
$active = fn(string $p, bool $exact = false) => ($exact ? $path === $p : str_starts_with($path, $p)) ? 'active' : '';
$waitCount = (int) db()->query("SELECT COUNT(*) FROM registrations r JOIN events e ON e.id = r.event_id WHERE r.status = 'waitlisted' AND e.event_date >= CURDATE()")->fetchColumn();
?>
<!doctype html>
<html lang="ms">
<head>
<?php partial('head', ['title' => $title ?? 'Admin']); ?>
<meta name="csrf-token" content="<?= e(csrf_token()) ?>">
</head>
<body>
<div class="admin-shell">
  <aside class="sidebar">
    <?php partial('brand', ['href' => '/admin', 'sub' => 'Panel Urusetia']); ?>
    <div class="side-label">Utama</div>
    <a class="side-link <?= $active('/admin', true) ?>" href="/admin"><i data-lucide="layout-dashboard"></i> Papan Pemuka</a>
    <a class="side-link <?= $active('/admin/acara') ?>" href="/admin/acara"><i data-lucide="calendar-range"></i> Acara</a>
    <a class="side-link <?= $active('/admin/peserta') ?>" href="/admin/peserta"><i data-lucide="users"></i> Peserta
      <?php if ($waitCount): ?><span class="count" title="Dalam senarai menunggu"><?= $waitCount ?></span><?php endif; ?></a>
    <a class="side-link <?= $active('/admin/imbas') ?>" href="/admin/imbas"><i data-lucide="scan-line"></i> Imbas Kehadiran</a>
    <div class="side-label">Tetapan</div>
    <a class="side-link <?= $active('/admin/emel') ?>" href="/admin/emel"><i data-lucide="mail"></i> Templat E-mel</a>
    <?php if (($me['role'] ?? '') === 'superadmin'): ?>
    <a class="side-link <?= $active('/admin/pentadbir') ?>" href="/admin/pentadbir"><i data-lucide="user-cog"></i> Pentadbir</a>
    <?php endif; ?>
    <a class="side-link <?= $active('/admin/log') ?>" href="/admin/log"><i data-lucide="history"></i> Log Audit</a>
    <a class="side-link <?= $active('/admin/profil') ?>" href="/admin/profil"><i data-lucide="key-round"></i> Profil & Kata Laluan</a>
    <a class="side-link" href="/" target="_blank"><i data-lucide="external-link"></i> Lihat Laman Awam</a>

    <div class="side-foot">
      <div class="avatar"><?= e(initials($me['name'] ?? '?')) ?></div>
      <div class="who"><strong><?= e($me['name'] ?? '') ?></strong><small><?= e($me['role'] ?? '') ?></small></div>
      <form method="post" action="/admin/logout"><?= csrf_field() ?>
        <button type="submit" title="Log keluar" aria-label="Log keluar"><i data-lucide="log-out"></i></button>
      </form>
    </div>
  </aside>
  <div class="sidebar-backdrop"></div>

  <div class="admin-main">
    <header class="topbar">
      <button class="btn btn-ghost btn-icon menu-btn" data-sidebar-toggle aria-label="Menu"><i data-lucide="menu"></i></button>
      <div class="title"><?= e($title ?? 'Admin') ?></div>
      <div class="spacer"></div>
      <form class="topbar-search" action="/admin/peserta" method="get">
        <i data-lucide="search"></i>
        <input class="input" type="search" name="q" placeholder="Cari nama, MyKad, e-mel, rujukan…" value="<?= e($_GET['q'] ?? '') ?>">
      </form>
      <a href="/admin/imbas" class="btn btn-primary btn-sm"><i data-lucide="scan-line"></i><span class="hide-sm">Imbas</span></a>
      <button class="btn btn-ghost btn-icon theme-toggle" data-theme-toggle aria-label="Tukar tema">
        <i data-lucide="moon" class="i-moon"></i><i data-lucide="sun" class="i-sun"></i>
      </button>
    </header>
    <main class="admin-content fade-in"><?= $content ?></main>
  </div>
</div>
<?php partial('confirm-modal'); ?>
<script src="<?= asset('js/app.js') ?>" defer></script>
<?= $scripts ?? '' ?>
</body>
</html>
