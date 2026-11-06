<?php
$f = fn(string $k) => (string) ($_GET[$k] ?? '');
$tabUrl = function (?string $status) { $q = $_GET; unset($q['page']); if ($status) $q['status'] = $status; else unset($q['status']); return '?' . http_build_query($q); };
$allCount = array_sum($counts);
$exportQs = http_build_query(array_diff_key($_GET, ['page' => 1]));
$isStaff = admin()['role'] === 'staff';
?>
<div class="page-title">
  <div><h1>Peserta</h1><p><?= number_format($total) ?> rekod<?= $f('q') ? ' untuk carian “' . e($f('q')) . '”' : '' ?></p></div>
  <div class="row">
    <a href="/admin/peserta/eksport?<?= e($exportQs) ?>" class="btn"><i data-lucide="file-spreadsheet"></i> Eksport CSV</a>
    <a href="/admin/imbas<?= $f('event') ? '?event=' . (int) $f('event') : '' ?>" class="btn btn-primary"><i data-lucide="scan-line"></i> Imbas Kehadiran</a>
  </div>
</div>

<div class="card">
  <div style="padding:14px 20px 0;overflow-x:auto">
    <div class="segmented">
      <a href="<?= e($tabUrl(null)) ?>" class="<?= !$f('status') ? 'active' : '' ?>">Semua <span class="muted">(<?= $allCount ?>)</span></a>
      <?php foreach (STATUS_LABELS as $k => [$label]): ?>
        <a href="<?= e($tabUrl($k)) ?>" class="<?= $f('status') === $k ? 'active' : '' ?>"><?= e($label) ?> <span class="muted">(<?= (int) ($counts[$k] ?? 0) ?>)</span></a>
      <?php endforeach; ?>
    </div>
  </div>
  <form class="filters" method="get">
    <?php if ($f('status')): ?><input type="hidden" name="status" value="<?= e($f('status')) ?>"><?php endif; ?>
    <div class="input-icon grow"><i data-lucide="search"></i><input class="input" style="width:100%" type="search" name="q" value="<?= e($f('q')) ?>" placeholder="Cari nama, MyKad, e-mel, organisasi atau no. rujukan…"></div>
    <select class="select" name="event" data-autosubmit aria-label="Acara">
      <option value="">Semua acara</option>
      <?php foreach ($events as $ev): ?><option value="<?= (int) $ev['id'] ?>" <?= $f('event') === (string) $ev['id'] ? 'selected' : '' ?>><?= e(mb_strimwidth($ev['title'], 0, 48, '…')) ?></option><?php endforeach; ?>
    </select>
    <select class="select" name="zone" data-autosubmit aria-label="Zon">
      <option value="">Semua zon</option>
      <?php foreach (lookup_items('zones') as $z): ?><option <?= $f('zone') === $z['name'] ? 'selected' : '' ?>><?= e($z['name']) ?></option><?php endforeach; ?>
    </select>
    <button class="btn btn-sm" type="submit" style="height:40px"><i data-lucide="filter"></i> Tapis</button>
    <?php if ($f('q') || $f('event') || $f('zone')): ?><a href="/admin/peserta" class="btn btn-ghost btn-sm" style="height:40px">Set semula</a><?php endif; ?>
  </form>

  <?php if (!$rows): ?>
    <div class="empty"><div class="empty-ico"><i data-lucide="user-search"></i></div><h3>Tiada peserta dijumpai</h3><p>Cuba ubah penapis atau kata kunci carian.</p></div>
  <?php else: ?>
  <form method="post" action="/admin/peserta/pukal" id="bulk-form" data-confirm="Teruskan tindakan pukal untuk peserta yang dipilih?" data-confirm-tone="primary">
    <?= csrf_field() ?>
    <div class="filters hidden" id="bulk-bar" style="background:var(--primary-soft)">
      <strong class="small" style="color:var(--primary)"><span id="bulk-count">0</span> dipilih</strong>
      <select class="select" name="action" required aria-label="Tindakan pukal">
        <option value="">Pilih tindakan…</option>
        <option value="attended">Tanda hadir</option>
        <option value="absent">Tanda tidak hadir</option>
        <option value="resend">Hantar semula e-mel</option>
        <?php if (!$isStaff): ?><option value="delete">Padam</option><?php endif; ?>
      </select>
      <button class="btn btn-primary btn-sm" style="height:40px">Laksana</button>
    </div>
    <div class="table-wrap">
      <table class="table">
        <thead><tr>
          <th style="width:36px"><input type="checkbox" id="check-all" aria-label="Pilih semua" style="accent-color:var(--primary);width:16px;height:16px"></th>
          <th>Peserta</th><th>Acara</th><th>Organisasi</th><th>Jawatan</th><th>Status</th><th>Didaftar</th><th></th>
        </tr></thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><input type="checkbox" name="ids[]" value="<?= (int) $r['id'] ?>" class="row-check" aria-label="Pilih <?= e($r['full_name']) ?>" style="accent-color:var(--primary);width:16px;height:16px"></td>
            <td>
              <a href="/admin/peserta/<?= (int) $r['id'] ?>" class="person" style="color:inherit">
                <div class="avatar sm"><?= e(initials($r['full_name'])) ?></div>
                <div><strong><?= e($r['full_name']) ?></strong><small class="mono"><?= e($r['ref_code']) ?></small> <small>· <?= e($r['email']) ?></small></div>
              </a>
            </td>
            <td style="min-width:200px"><span class="badge badge-plain tag-<?= e($r['event_type']) ?>" style="margin-bottom:4px"><?= e(type_label($r['event_type'])) ?></span><div class="small" style="line-height:1.35"><?= e(mb_strimwidth($r['event_title'], 0, 50, '…')) ?></div></td>
            <td style="min-width:160px"><div class="small"><?= e($r['agency']) ?></div><div class="xs muted"><?= e($r['state']) ?></div></td>
            <td class="small" style="min-width:120px"><?= e($r['grade']) ?></td>
            <td><?= status_badge($r['status']) ?><?php if ($r['checked_in_at']): ?><div class="xs muted" style="margin-top:3px"><?= e(date('g:i A', strtotime($r['checked_in_at']))) ?></div><?php endif; ?></td>
            <td class="nowrap xs muted"><?= e(date('j/n/Y', strtotime($r['created_at']))) ?><br><?= e(date('g:i A', strtotime($r['created_at']))) ?></td>
            <td>
              <div class="actions">
                <?php if ($r['status'] === 'registered'): ?>
                  <button type="submit" form="st-<?= (int) $r['id'] ?>" class="btn btn-success btn-sm" title="Tanda hadir"><i data-lucide="check"></i></button>
                <?php endif; ?>
                <a href="/admin/peserta/<?= (int) $r['id'] ?>" class="btn btn-ghost btn-icon btn-sm" title="Butiran" aria-label="Butiran"><i data-lucide="chevron-right"></i></a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </form>
  <?php foreach ($rows as $r): if ($r['status'] !== 'registered') continue; ?>
    <form method="post" action="/admin/peserta/<?= (int) $r['id'] ?>/status" id="st-<?= (int) $r['id'] ?>" class="hidden"><?= csrf_field() ?><input type="hidden" name="status" value="attended"></form>
  <?php endforeach; ?>
  <div class="card-footer row-between">
    <span class="small muted">Halaman <?= $page ?> / <?= $pages ?> · <?= number_format($total) ?> rekod</span>
    <?php partial('pagination', ['page' => $page, 'pages' => $pages]); ?>
  </div>
  <?php endif; ?>
</div>

<?php $scripts = <<<'HTML'
<script>
(function () {
  const all = document.getElementById('check-all');
  if (!all) return;
  const boxes = Array.from(document.querySelectorAll('.row-check'));
  const bar = document.getElementById('bulk-bar'), count = document.getElementById('bulk-count');
  const sync = () => { const n = boxes.filter(b => b.checked).length; count.textContent = n; bar.classList.toggle('hidden', n === 0); all.checked = n === boxes.length; all.indeterminate = n > 0 && n < boxes.length; };
  all.addEventListener('change', () => { boxes.forEach(b => b.checked = all.checked); sync(); });
  boxes.forEach(b => b.addEventListener('change', sync));
})();
</script>
HTML; ?>
