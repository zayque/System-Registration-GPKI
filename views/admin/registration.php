<?php
$v = fn(string $k) => old($k, $reg[$k] ?? '');
$questions = custom_fields($reg);
$answers = json_decode((string) $reg['answers'], true) ?: [];
$err = fn(string $k) => error_for($k) ? '<div class="error-text">' . e(error_for($k)) . '</div>' : '';
$cls = fn(string $k) => 'field' . (error_for($k) ? ' has-error' : '');
$isStaff = admin()['role'] === 'staff';
$statusBtn = function (string $status, string $icon, string $label, string $tone = '') use ($reg) {
    if ($reg['status'] === $status) return '';
    return '<form method="post" action="/admin/peserta/' . (int) $reg['id'] . '/status"' . ($status === 'cancelled' ? ' data-confirm="Batalkan pendaftaran ini? Peserta dalam senarai menunggu akan dinaikkan secara automatik." data-confirm-label="Batalkan"' : '') . '>'
        . csrf_field() . '<input type="hidden" name="status" value="' . $status . '"><button class="btn btn-sm btn-block ' . $tone . '" style="justify-content:flex-start"><i data-lucide="' . $icon . '"></i> ' . $label . '</button></form>';
};
?>
<div class="page-title">
  <div>
    <a href="/admin/peserta?event=<?= (int) $reg['event_id'] ?>" class="btn btn-ghost btn-sm" style="margin-bottom:8px"><i data-lucide="arrow-left"></i> Senarai peserta</a>
    <div class="row" style="gap:14px">
      <div class="avatar" style="width:52px;height:52px;border-radius:16px;font-size:1.05rem"><?= e(initials($reg['full_name'])) ?></div>
      <div>
        <h1 style="margin:0"><?= e($reg['full_name']) ?></h1>
        <div class="row" style="gap:8px;margin-top:4px"><span class="mono small muted"><?= e($reg['ref_code']) ?></span><?= status_badge($reg['status']) ?></div>
      </div>
    </div>
  </div>
  <div class="row">
    <a href="/tiket/<?= e($reg['token']) ?>" target="_blank" class="btn"><i data-lucide="ticket"></i> Lihat tiket</a>
    <a href="/tiket/<?= e($reg['token']) ?>/pdf" class="btn"><i data-lucide="download"></i> PDF</a>
  </div>
</div>

<div class="grid" style="grid-template-columns:minmax(0,1fr) 320px;align-items:start" id="reg-detail">
  <form method="post" class="card">
    <?= csrf_field() ?>
    <div class="card-header"><h3>Maklumat Peserta</h3><button class="btn btn-primary btn-sm"><i data-lucide="save"></i> Simpan</button></div>
    <div class="card-body form-grid">
      <div class="<?= $cls('full_name') ?> full"><label>Nama penuh</label><input class="input" name="full_name" value="<?= e($v('full_name')) ?>"><?= $err('full_name') ?></div>
      <div class="<?= $cls('ic_no') ?>"><label>No. MyKad</label><input class="input mono" name="ic_no" maxlength="12" value="<?= e($v('ic_no')) ?>"><?= $err('ic_no') ?></div>
      <div class="<?= $cls('email') ?>"><label>E-mel</label><input class="input" type="email" name="email" value="<?= e($v('email')) ?>"><?= $err('email') ?></div>
      <div class="field"><label>Tel. bimbit</label><input class="input" name="mobile_no" value="<?= e($v('mobile_no')) ?>"></div>
      <div class="field"><label>Tel. pejabat</label><input class="input" name="office_no" value="<?= e($v('office_no')) ?>"></div>
      <div class="field full"><label>Kementerian / Organisasi induk</label>
        <select class="select" name="ministry"><option value="">Tiada</option><?php foreach (lookup_items('ministries') as $m): ?><option <?= $v('ministry') === $m['name'] ? 'selected' : '' ?>><?= e($m['name']) ?></option><?php endforeach; ?>
        <?php if ($v('ministry') && !in_array($v('ministry'), array_column(lookup_items('ministries'), 'name'), true)): ?><option selected><?= e($v('ministry')) ?></option><?php endif; ?></select></div>
      <div class="field"><label>Organisasi</label><input class="input" name="agency" value="<?= e($v('agency')) ?>"></div>
      <div class="field"><label>Jawatan / Gred</label><input class="input" name="grade" value="<?= e($v('grade')) ?>"></div>
      <div class="field full"><label>Negeri</label><select class="select" name="state"><?php foreach (lookup_items('states') as $s): ?><option <?= $v('state') === $s['name'] ? 'selected' : '' ?>><?= e($s['name']) ?></option><?php endforeach; ?></select></div>
      <?php if ($questions): ?>
      <div class="full" style="border-top:1px solid var(--border);padding-top:16px"><h3 style="font-size:.95rem">Soalan Tambahan</h3></div>
      <?php foreach ($questions as $q): $name = 'q[' . $q['key'] . ']'; $val = $answers[$q['key']] ?? ($q['type'] === 'checkbox' ? [] : ''); ?>
        <div class="field full"><label><?= e($q['label']) ?></label>
          <?php if ($q['type'] === 'checkbox'): ?>
            <div class="chips"><?php foreach ($q['options'] as $o): ?><label class="chip"><input type="checkbox" name="<?= e($name) ?>[]" value="<?= e($o) ?>" <?= in_array($o, (array) $val, true) ? 'checked' : '' ?>><span><?= e($o) ?></span></label><?php endforeach; ?></div>
          <?php elseif (in_array($q['type'], ['select', 'radio'], true)): ?>
            <select class="select" name="<?= e($name) ?>"><option value="">—</option><?php foreach ($q['options'] as $o): ?><option <?= $val === $o ? 'selected' : '' ?>><?= e($o) ?></option><?php endforeach; ?></select>
          <?php elseif ($q['type'] === 'textarea'): ?>
            <textarea class="textarea" name="<?= e($name) ?>" rows="3"><?= e($val) ?></textarea>
          <?php else: ?>
            <input class="input" name="<?= e($name) ?>" value="<?= e($val) ?>">
          <?php endif; ?>
        </div>
      <?php endforeach; endif; ?>
      <?php if ($reg['absence_reason']): ?>
        <div class="full alert alert-info"><i data-lucide="message-square"></i><div><strong>Sebab tidak hadir:</strong> <?= e($reg['absence_reason']) ?></div></div>
      <?php endif; ?>
    </div>
  </form>

  <div class="stack">
    <div class="card">
      <div class="card-header"><h3>Acara</h3></div>
      <div class="card-body small stack" style="--gap:8px">
        <div><span class="badge badge-plain tag-<?= e($reg['event_type']) ?>"><?= e(type_label($reg['event_type'])) ?></span></div>
        <strong style="font-size:.95rem"><?= e($reg['event_title']) ?></strong>
        <div class="muted"><i data-lucide="calendar" style="width:14px;height:14px;vertical-align:-2px"></i> <?= e(tarikh_bm($reg['event_date'])) ?>, <?= e(masa_bm($reg['start_time'])) ?></div>
        <div class="muted"><i data-lucide="clock-3" style="width:14px;height:14px;vertical-align:-2px"></i> Didaftar <?= e(datetime_bm($reg['created_at'])) ?></div>
        <?php if ($reg['checked_in_at']): ?><div style="color:var(--green)"><i data-lucide="badge-check" style="width:14px;height:14px;vertical-align:-2px"></i> Hadir <?= e(datetime_bm($reg['checked_in_at'])) ?><?= $checker ? ' oleh ' . e($checker) : '' ?></div><?php endif; ?>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3>Tindakan</h3></div>
      <div class="card-body stack" style="display:grid;gap:8px">
        <?= $statusBtn('attended', 'user-check', 'Tanda hadir', 'btn-success') ?>
        <?= $statusBtn('registered', 'user-plus', $reg['status'] === 'waitlisted' ? 'Sahkan dari senarai menunggu' : 'Tetapkan sebagai berdaftar') ?>
        <?= $statusBtn('absent', 'user-x', 'Tanda tidak hadir') ?>
        <?= $statusBtn('cancelled', 'x-circle', 'Batalkan pendaftaran') ?>
        <form method="post" action="/admin/peserta/<?= (int) $reg['id'] ?>/emel"><?= csrf_field() ?><button class="btn btn-sm btn-block" style="justify-content:flex-start"><i data-lucide="send"></i> Hantar semula e-mel</button></form>
        <?php if (!$isStaff): ?>
        <form method="post" action="/admin/peserta/<?= (int) $reg['id'] ?>/padam" data-confirm="Rekod ini akan dipadam secara kekal." data-confirm-label="Padam"><?= csrf_field() ?><button class="btn btn-sm btn-block btn-danger" style="justify-content:flex-start"><i data-lucide="trash-2"></i> Padam rekod</button></form>
        <?php endif; ?>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3>Sejarah</h3></div>
      <?php if (!$history): ?><div class="card-body muted small">Tiada aktiviti direkodkan.</div><?php endif; ?>
      <ul class="timeline">
        <?php foreach ($history as $h): ?>
          <li><div class="dot tone-indigo"><i data-lucide="activity" style="width:15px;height:15px"></i></div><div><strong class="small"><?= e($h['action']) ?></strong> <span class="xs muted"><?= e($h['details']) ?></span><div class="xs muted"><?= e($h['admin_name'] ?? 'Sistem') ?> · <?= e(date('j/n g:i A', strtotime($h['created_at']))) ?></div></div></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
<style>@media (max-width:1100px){#reg-detail{grid-template-columns:1fr!important}}</style>
