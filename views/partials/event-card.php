<?php
use App\Events;
[$stateLabel, $stateTone] = Events::stateLabel($e);
$pct = Events::fillPercent($e);
$left = Events::seatsLeft($e);
$t = strtotime($e['event_date']);
?>
<article class="card event-card t-<?= e($e['type']) ?>">
  <div class="ec-top">
    <div class="date-chip" aria-hidden="true">
      <div class="dc-m"><?= e(mb_substr(BULAN_BM[(int) date('n', $t)], 0, 3)) ?></div>
      <div class="dc-d"><?= date('j', $t) ?></div>
      <div class="dc-w"><?= e(hari_bm($e['event_date'])) ?></div>
    </div>
    <div style="min-width:0">
      <div class="row" style="gap:6px">
        <span class="badge badge-plain tag-<?= e($e['type']) ?>"><?= e(type_label($e['type'])) ?></span>
        <span class="badge badge-<?= $stateTone ?>"><?= e($stateLabel) ?></span>
      </div>
      <h3><a href="/acara/<?= e($e['slug']) ?>"><?= e($e['title']) ?></a></h3>
    </div>
  </div>
  <div class="ec-meta">
    <div><i data-lucide="clock"></i> <?= e(masa_bm($e['start_time'])) ?> – <?= e(masa_bm($e['end_time'])) ?></div>
    <div><i data-lucide="map-pin"></i> <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= e($e['venue_name']) ?><?= $e['state_name'] ? ', ' . e($e['state_name']) : '' ?></span></div>
    <?php if ($e['zone_name']): ?><div><i data-lucide="compass"></i> Zon <?= e($e['zone_name']) ?></div><?php endif; ?>
  </div>
  <div class="ec-foot">
    <div class="row-between">
      <span class="muted"><strong style="color:var(--text)"><?= (int) $e['confirmed'] ?></strong> / <?= (int) $e['capacity'] ?> peserta</span>
      <span class="muted"><?= $left > 0 ? "<strong style=\"color:var(--text)\">{$left}</strong> tempat lagi" : 'Penuh' ?></span>
    </div>
    <div class="progress <?= $pct >= 100 ? 'is-full' : ($pct >= 80 ? 'is-warn' : '') ?>"><span data-w="<?= $pct ?>" style="width:0"></span></div>
  </div>
</article>
