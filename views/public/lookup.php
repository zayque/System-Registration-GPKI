<div class="lookup-wrap">
  <div class="container lookup-card">
    <div class="card fade-in">
      <div class="card-body" style="padding:34px">
        <div class="icon-hero"><i data-lucide="ticket"></i></div>
        <h2 class="center" style="margin-bottom:6px">Semak Pendaftaran</h2>
        <p class="center muted small" style="margin-bottom:24px">Masukkan e-mel dan No. MyKad yang digunakan semasa mendaftar untuk melihat, memuat turun atau membatalkan tiket anda.</p>
        <?php if (error_for('lookup')): ?>
          <div class="alert alert-error" style="margin-bottom:18px"><i data-lucide="search-x"></i><div><?= e(error_for('lookup')) ?></div></div>
        <?php endif; ?>
        <form method="post" action="/semak" class="stack">
          <?= csrf_field() ?>
          <div class="field">
            <label for="email">E-mel</label>
            <div class="input-icon"><i data-lucide="mail"></i><input class="input" type="email" id="email" name="email" value="<?= e(old('email')) ?>" placeholder="nama@organisasi.com" required autocomplete="email"></div>
          </div>
          <div class="field">
            <label for="ic_no">No. MyKad</label>
            <div class="input-icon">
              <i data-lucide="id-card"></i>
              <input class="input mono" type="password" id="ic_no" name="ic_no" placeholder="12 digit" inputmode="numeric" maxlength="12" required autocomplete="off">
              <button type="button" class="btn btn-ghost btn-icon btn-sm input-action" data-reveal="#ic_no" aria-label="Papar No. MyKad"><i data-lucide="eye"></i></button>
            </div>
          </div>
          <button type="submit" class="btn btn-gradient btn-lg btn-block"><i data-lucide="search"></i> Semak</button>
        </form>
      </div>
    </div>
    <p class="center muted small" style="margin-top:18px">Belum mendaftar? <a href="/acara">Lihat acara yang dibuka</a></p>
  </div>
</div>
