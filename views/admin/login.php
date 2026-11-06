<!doctype html>
<html lang="ms">
<head><?php partial('head', ['title' => $title]); ?></head>
<body>
<div class="auth-page">
  <div class="auth-art">
    <?php partial('brand', ['sub' => 'Panel Urusetia', 'light' => true]); ?>
    <div>
      <h2>Urus acara, peserta &amp; kehadiran di satu tempat.</h2>
      <p>Pantau pendaftaran secara langsung, imbas kod QR peserta, dan eksport laporan dengan satu klik.</p>
      <div class="row" style="gap:10px;margin-top:22px">
        <span class="badge badge-plain" style="background:rgba(255,255,255,.14);color:#fff"><i data-lucide="bar-chart-3" style="width:14px;height:14px"></i> Analitik langsung</span>
        <span class="badge badge-plain" style="background:rgba(255,255,255,.14);color:#fff"><i data-lucide="scan-line" style="width:14px;height:14px"></i> Imbasan QR</span>
        <span class="badge badge-plain" style="background:rgba(255,255,255,.14);color:#fff"><i data-lucide="file-spreadsheet" style="width:14px;height:14px"></i> Eksport CSV</span>
      </div>
    </div>
    <div class="small" style="color:rgba(255,255,255,.6)">© <?= date('Y') ?> <?= e(env('APP_NAME', 'Hadirin')) ?></div>
  </div>
  <div class="auth-form">
    <div class="inner fade-in">
      <div class="row-between" style="margin-bottom:28px">
        <a href="/" class="btn btn-ghost btn-sm"><i data-lucide="arrow-left"></i> Laman utama</a>
        <button class="btn btn-ghost btn-icon theme-toggle" data-theme-toggle aria-label="Tukar tema"><i data-lucide="moon" class="i-moon"></i><i data-lucide="sun" class="i-sun"></i></button>
      </div>
      <h1 style="font-size:1.9rem;margin-bottom:6px">Log masuk</h1>
      <p class="muted" style="margin-bottom:26px">Masukkan butiran akaun urusetia anda.</p>
      <?php if (error_for('login')): ?>
        <div class="alert alert-error" style="margin-bottom:18px"><i data-lucide="alert-circle"></i><div><?= e(error_for('login')) ?></div></div>
      <?php endif; ?>
      <form method="post" action="/admin/login" class="stack">
        <?= csrf_field() ?>
        <div class="field">
          <label for="username">Nama pengguna atau e-mel</label>
          <div class="input-icon"><i data-lucide="user"></i><input class="input" id="username" name="username" value="<?= e(old('username')) ?>" required autofocus autocomplete="username"></div>
        </div>
        <div class="field">
          <label for="password">Kata laluan</label>
          <div class="input-icon">
            <i data-lucide="lock"></i>
            <input class="input" type="password" id="password" name="password" required autocomplete="current-password">
            <button type="button" class="btn btn-ghost btn-icon btn-sm input-action" data-reveal="#password" aria-label="Papar kata laluan"><i data-lucide="eye"></i></button>
          </div>
        </div>
        <button type="submit" class="btn btn-gradient btn-lg btn-block"><i data-lucide="log-in"></i> Log Masuk</button>
      </form>
    </div>
  </div>
</div>
<script src="<?= asset('js/app.js') ?>" defer></script>
</body>
</html>
