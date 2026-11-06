<?php
$icon = fn(string $a) => match (true) {
    str_starts_with($a, 'login'), str_starts_with($a, 'logout') => ['log-in', 'tone-blue'],
    str_starts_with($a, 'checkin') => ['scan-line', 'tone-green'],
    str_contains($a, 'delete') => ['trash-2', 'tone-rose'],
    str_starts_with($a, 'export') => ['file-down', 'tone-violet'],
    str_starts_with($a, 'event') => ['calendar', 'tone-indigo'],
    str_starts_with($a, 'admin') => ['user-cog', 'tone-amber'],
    default => ['activity', 'tone-indigo'],
};
?>
<div class="page-title"><div><h1>Log Audit</h1><p>Rekod semua tindakan yang dibuat oleh pentadbir.</p></div></div>
<div class="card">
  <?php if (!$rows): ?><div class="empty"><div class="empty-ico"><i data-lucide="history"></i></div><p>Tiada aktiviti lagi.</p></div><?php endif; ?>
  <div class="table-wrap">
    <table class="table">
      <?php if ($rows): ?><thead><tr><th>Tindakan</th><th>Butiran</th><th>Oleh</th><th>IP</th><th>Masa</th></tr></thead><?php endif; ?>
      <tbody>
      <?php foreach ($rows as $r): [$ico, $tone] = $icon($r['action']); ?>
        <tr>
          <td><div class="row" style="gap:10px;flex-wrap:nowrap"><div class="k-ico <?= $tone ?>" style="width:32px;height:32px;border-radius:9px;display:grid;place-items:center"><i data-lucide="<?= $ico ?>" style="width:15px;height:15px"></i></div><span class="mono small"><?= e($r['action']) ?></span></div></td>
          <td class="small" style="max-width:380px">
            <?php if ($r['entity'] === 'registration' && $r['entity_id']): ?><a href="/admin/peserta/<?= (int) $r['entity_id'] ?>">#<?= (int) $r['entity_id'] ?></a> <?php endif; ?>
            <?= e($r['details']) ?>
          </td>
          <td class="small nowrap"><?= e($r['admin_name'] ?? '—') ?></td>
          <td class="mono xs muted"><?= e($r['ip']) ?></td>
          <td class="small muted nowrap"><?= e(date('j/n/Y g:i:s A', strtotime($r['created_at']))) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php if ($pages > 1): ?><div class="card-footer row-between"><span class="small muted">Halaman <?= $page ?> / <?= $pages ?></span><?php partial('pagination', ['page' => $page, 'pages' => $pages]); ?></div><?php endif; ?>
</div>
