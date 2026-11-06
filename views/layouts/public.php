<?php $path = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/') ?: '/'; ?>
<!doctype html>
<html lang="ms">
<head>
<?php partial('head', ['title' => $title ?? '']); ?>
</head>
<body>
<header class="site-header">
  <div class="container">
    <?php partial('brand'); ?>
    <button class="btn btn-ghost btn-icon nav-toggle" data-nav-toggle aria-label="Menu"><i data-lucide="menu"></i></button>
    <nav class="nav">
      <a href="/" class="<?= $path === '/' ? 'active' : '' ?>"><i data-lucide="home"></i> Utama</a>
      <a href="/acara" class="<?= str_starts_with($path, '/acara') ? 'active' : '' ?>"><i data-lucide="calendar-days"></i> Acara</a>
      <a href="/semak" class="<?= in_array($path, ['/semak', '/tiket-saya'], true) || str_starts_with($path, '/tiket') ? 'active' : '' ?>"><i data-lucide="ticket"></i> Semak Pendaftaran</a>
      <a href="/#soalan"><i data-lucide="help-circle"></i> Soalan Lazim</a>
      <button class="btn btn-ghost btn-icon theme-toggle" data-theme-toggle aria-label="Tukar tema">
        <i data-lucide="moon" class="i-moon"></i><i data-lucide="sun" class="i-sun"></i>
      </button>
    </nav>
  </div>
</header>

<main id="main"><?= $content ?></main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div style="margin-bottom:14px"><?php partial('brand'); ?></div>
        <p class="muted small" style="max-width:40ch">Platform pendaftaran acara yang mudah: e-tiket kod QR, senarai menunggu automatik dan daftar masuk pantas di kaunter.</p>
      </div>
      <div>
        <h4>Pautan</h4>
        <ul>
          <li><a href="/acara">Senarai Acara</a></li>
          <li><a href="/semak">Semak / Batal Pendaftaran</a></li>
          <li><a href="/#soalan">Soalan Lazim</a></li>
        </ul>
      </div>
      <div>
        <h4>Hubungi Urusetia</h4>
        <ul>
          <li class="row" style="gap:8px"><i data-lucide="mail"></i> <a href="mailto:<?= e(env('MAIL_FROM', 'urusetia@example.com')) ?>"><?= e(env('MAIL_FROM', 'urusetia@example.com')) ?></a></li>
          <li class="row" style="gap:8px"><i data-lucide="phone"></i> <span class="muted">03-8000 8000</span></li>
          <li class="row" style="gap:8px"><i data-lucide="clock"></i> <span class="muted">Isnin – Jumaat, 8:30 pagi – 5:00 petang</span></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <?= date('Y') ?> <?= e(env('APP_NAME', 'Hadirin')) ?>. Hak cipta terpelihara.</span>
      <a href="/admin/login" class="muted">Log masuk urusetia</a>
    </div>
  </div>
</footer>
<?php partial('confirm-modal'); ?>
<script src="<?= asset('js/app.js') ?>" defer></script>
<?= $scripts ?? '' ?>
</body>
</html>
