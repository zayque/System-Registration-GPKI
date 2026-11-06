<?php
$err = fn(string $k) => error_for($k) ? '<div class="error-text">' . e(error_for($k)) . '</div>' : '';
$cls = fn(string $k) => 'field' . (error_for($k) ? ' has-error' : '');
?>
<div class="page-title"><div><h1>Profil &amp; Kata Laluan</h1><p>Kemaskini maklumat akaun anda.</p></div></div>
<form method="post" class="grid grid-2" style="align-items:start;max-width:980px">
  <?= csrf_field() ?>
  <div class="card">
    <div class="card-header"><h3>Maklumat Akaun</h3></div>
    <div class="card-body stack">
      <div class="row" style="gap:14px;margin-bottom:6px"><div class="avatar" style="width:56px;height:56px;border-radius:18px;font-size:1.1rem"><?= e(initials($me['name'])) ?></div><div><strong><?= e($me['username']) ?></strong><div class="small muted" style="text-transform:capitalize"><?= e($me['role']) ?> · sejak <?= e(tarikh_bm($me['created_at'])) ?></div></div></div>
      <div class="<?= $cls('name') ?>"><label>Nama</label><input class="input" name="name" value="<?= e(old('name', $me['name'])) ?>" required><?= $err('name') ?></div>
      <div class="<?= $cls('email') ?>"><label>E-mel</label><input class="input" type="email" name="email" value="<?= e(old('email', $me['email'])) ?>" required><?= $err('email') ?><span class="hint">E-mel ujian templat dihantar ke alamat ini.</span></div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><h3>Tukar Kata Laluan</h3></div>
    <div class="card-body stack">
      <div class="<?= $cls('current_password') ?>"><label>Kata laluan semasa</label><input class="input" type="password" name="current_password" autocomplete="current-password"><?= $err('current_password') ?></div>
      <div class="<?= $cls('new_password') ?>"><label>Kata laluan baharu</label><input class="input" type="password" name="new_password" minlength="8" autocomplete="new-password"><?= $err('new_password') ?><span class="hint">Sekurang-kurangnya 8 aksara. Kosongkan jika tidak mahu tukar.</span></div>
      <div class="<?= $cls('confirm_password') ?>"><label>Sahkan kata laluan baharu</label><input class="input" type="password" name="confirm_password" autocomplete="new-password"><?= $err('confirm_password') ?></div>
    </div>
    <div class="card-footer row" style="justify-content:flex-end"><button class="btn btn-primary"><i data-lucide="save"></i> Simpan perubahan</button></div>
  </div>
</form>
