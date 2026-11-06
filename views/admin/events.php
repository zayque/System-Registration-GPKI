<?php use App\Events; ?>
<div class="page-title">
  <div><h1>Acara</h1><p>Urus acara, kapasiti, soalan tambahan dan status pendaftaran.</p></div>
  <a href="/admin/acara/baru" class="btn btn-primary"><i data-lucide="plus"></i> Acara Baharu</a>
</div>

<div class="card">
  <?php if (!$events): ?>
    <div class="empty"><div class="empty-ico"><i data-lucide="calendar-plus"></i></div><h3>Belum ada acara</h3><p>Cipta acara pertama untuk mula menerima pendaftaran.</p><a href="/admin/acara/baru" class="btn btn-primary">Cipta Acara</a></div>
  <?php else: ?>
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Acara</th><th>Tarikh</th><th>Kapasiti</th><th>Hadir</th><th>Status</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($events as $e): $pct = Events::fillPercent($e); [$lbl, $tone] = Events::stateLabel($e); ?>
        <tr>
          <td style="min-width:280px">
            <div class="row" style="gap:6px;margin-bottom:4px"><span class="badge badge-plain tag-<?= e($e['type']) ?>"><?= e(type_label($e['type'])) ?></span><?php if ($e['zone_name']): ?><span class="xs muted">Zon <?= e($e['zone_name']) ?></span><?php endif; ?></div>
            <strong><a href="/admin/peserta?event=<?= (int) $e['id'] ?>" style="color:inherit"><?= e($e['title']) ?></a></strong>
            <div class="xs muted"><i data-lucide="map-pin" style="width:12px;height:12px;vertical-align:-2px"></i> <?= e($e['venue_name']) ?></div>
          </td>
          <td class="nowrap"><strong><?= e(tarikh_bm($e['event_date'])) ?></strong><div class="xs muted"><?= e(hari_bm($e['event_date'])) ?>, <?= e(masa_bm($e['start_time'])) ?></div></td>
          <td style="min-width:160px">
            <div class="row-between xs" style="margin-bottom:6px"><span><strong><?= (int) $e['confirmed'] ?></strong> / <?= (int) $e['capacity'] ?></span><?php if ($e['waitlisted']): ?><span class="badge badge-amber badge-plain">+<?= (int) $e['waitlisted'] ?> menunggu</span><?php endif; ?></div>
            <div class="progress <?= $pct >= 100 ? 'is-full' : ($pct >= 80 ? 'is-warn' : '') ?>"><span data-w="<?= $pct ?>" style="width:0"></span></div>
          </td>
          <td class="nowrap"><?= (int) $e['attended'] ?><?php if ($e['confirmed']): ?> <span class="xs muted">(<?= round($e['attended'] / $e['confirmed'] * 100) ?>%)</span><?php endif; ?></td>
          <td><span class="badge badge-<?= $tone ?>"><?= e($lbl) ?></span></td>
          <td>
            <div class="actions">
              <a class="btn btn-ghost btn-icon btn-sm" href="/acara/<?= e($e['slug']) ?>" target="_blank" title="Lihat laman awam" aria-label="Lihat laman awam"><i data-lucide="external-link"></i></a>
              <a class="btn btn-ghost btn-icon btn-sm" href="/admin/imbas?event=<?= (int) $e['id'] ?>" title="Imbas kehadiran" aria-label="Imbas kehadiran"><i data-lucide="scan-line"></i></a>
              <a class="btn btn-ghost btn-icon btn-sm" href="/admin/acara/<?= (int) $e['id'] ?>/edit" title="Kemaskini" aria-label="Kemaskini"><i data-lucide="pencil"></i></a>
              <div class="dropdown">
                <button class="btn btn-ghost btn-icon btn-sm" data-dropdown aria-label="Lagi"><i data-lucide="more-vertical"></i></button>
                <div class="dropdown-menu">
                  <a href="/admin/peserta?event=<?= (int) $e['id'] ?>"><i data-lucide="users"></i> Lihat peserta</a>
                  <a href="/admin/peserta/eksport?event=<?= (int) $e['id'] ?>"><i data-lucide="file-down"></i> Eksport CSV</a>
                  <button type="button" data-copy="<?= e(base_url() . '/acara/' . $e['slug']) ?>"><i data-lucide="link"></i> Salin pautan daftar</button>
                  <form method="post" action="/admin/acara/<?= (int) $e['id'] ?>/salin"><?= csrf_field() ?><button type="submit"><i data-lucide="copy"></i> Salin acara</button></form>
                  <?php if (admin()['role'] !== 'staff'): ?>
                  <hr>
                  <form method="post" action="/admin/acara/<?= (int) $e['id'] ?>/padam" data-confirm="Acara &quot;<?= e($e['title']) ?>&quot; dan <?= (int) $e['confirmed'] + (int) $e['waitlisted'] ?> pendaftaran akan dipadam secara kekal." data-confirm-label="Padam acara">
                    <?= csrf_field() ?><button type="submit" class="danger"><i data-lucide="trash-2"></i> Padam</button>
                  </form>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>
