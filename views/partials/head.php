<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(($title ?? '') ? $title . ' · ' : '') ?><?= e(env('APP_NAME', 'Hadirin')) ?></title>
<meta name="description" content="Daftar acara, latihan dan seminar dalam talian dengan e-tiket kod QR dan daftar masuk pantas.">
<meta name="theme-color" content="#0a1f44">
<link rel="icon" type="image/svg+xml" href="<?= asset('img/favicon.svg') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= asset('css/app.css') ?>">
<script>
  (function () {
    var t = null;
    try { t = localStorage.getItem('hadirin-theme'); } catch (e) {}
    if (!t) t = matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', t);
  })();
  window.__flashes = <?= json_encode(take_flashes(), JSON_HEX_TAG | JSON_UNESCAPED_UNICODE) ?>;
</script>
<script defer src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js"></script>
