<?php
$err = fn(string $k) => error_for($k) ? '<div class="error-text">' . e(error_for($k)) . '</div>' : '';
$roles = ['superadmin' => ['Superadmin', 'violet', 'Akses penuh termasuk urus pentadbir'], 'admin' => ['Admin', 'blue', 'Urus acara, peserta & templat'], 'staff' => ['Kakitangan', 'gray', 'Imbas kehadiran & lihat sahaja']];
$me = admin();
?>
<div class="page-title">
  <div><h1>Pentadbir</h1><p>Akaun yang boleh log masuk ke panel urusetia.</p></div>
  <button class="btn btn-primary" data-modal-open="#add-admin"><i data-lucide="user-plus"></i> Tambah Pentadbir</button>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Nama</th><th>Nama Pengguna</th><th>Peranan</th><th>Log Masuk Terakhir</th><th>Status</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($admins as $a): [$rl, $rt] = $roles[$a['role']]; ?>
        <tr>
          <td><div class="person"><div class="avatar sm"><?= e(initials($a['name'])) ?></div><div><strong><?= e($a['name']) ?><?= (int) $a['id'] === $me['id'] ? ' <span class="badge badge-blue badge-plain">Anda</span>' : '' ?></strong><small><?= e($a['email']) ?></small></div></div></td>
          <td class="mono small"><?= e($a['username']) ?></td>
          <td><span class="badge badge-<?= $rt ?> badge-plain"><?= $rl ?></span></td>
          <td class="small muted nowrap"><?= $a['last_login_at'] ? e(datetime_bm($a['last_login_at'])) : 'Belum pernah' ?></td>
          <td><?= $a['is_active'] ? '<span class="badge badge-green">Aktif</span>' : '<span class="badge badge-gray">Tidak aktif</span>' ?></td>
          <td>
            <?php if ((int) $a['id'] !== $me['id']): ?>
            <div class="actions">
              <form method="post" action="/admin/pentadbir/<?= (int) $a['id'] ?>/reset" data-confirm="Jana kata laluan sementara baharu untuk <?= e($a['name']) ?>?" data-confirm-tone="primary" data-confirm-label="Jana"><?= csrf_field() ?><button class="btn btn-ghost btn-sm"><i data-lucide="key-round"></i> Set semula</button></form>
              <form method="post" action="/admin/pentadbir/<?= (int) $a['id'] ?>/toggle"><?= csrf_field() ?><button class="btn btn-sm <?= $a['is_active'] ? 'btn-danger' : 'btn-success' ?>"><?= $a['is_active'] ? 'Nyahaktif' : 'Aktifkan' ?></button></form>
            </div>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal <?= $GLOBALS['__errors'] ? 'open' : '' ?>" id="add-admin" role="dialog" aria-modal="true">
  <div class="modal-dialog" style="max-width:520px">
    <form method="post" action="/admin/pentadbir" class="card-body stack">
      <?= csrf_field() ?>
      <h3>Tambah Pentadbir</h3>
      <div class="field"><label>Nama penuh</label><input class="input" name="name" value="<?= e(old('name')) ?>" required><?= $err('name') ?></div>
      <div class="form-grid">
        <div class="field"><label>E-mel</label><input class="input" type="email" name="email" value="<?= e(old('email')) ?>" required><?= $err('email') ?></div>
        <div class="field"><label>Nama pengguna</label><input class="input" name="username" value="<?= e(old('username')) ?>" required><?= $err('username') ?></div>
      </div>
      <div class="field"><label>Kata laluan</label><input class="input" type="password" name="password" minlength="8" required autocomplete="new-password"><?= $err('password') ?></div>
      <div class="field"><span class="label">Peranan</span>
        <div style="display:grid;gap:8px">
          <?php foreach ($roles as $k => [$l, , $d]): ?>
            <label class="radio-card"><input type="radio" name="role" value="<?= $k ?>" <?= old('role', 'admin') === $k ? 'checked' : '' ?>><span class="rc"><span><strong><?= $l ?></strong><small><?= $d ?></small></span></span></label>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="row" style="justify-content:flex-end"><button type="button" class="btn" data-modal-close>Batal</button><button class="btn btn-primary"><i data-lucide="user-plus"></i> Tambah</button></div>
    </form>
  </div>
</div>
