<section class="section" style="padding-top:40px;background:radial-gradient(900px 380px at 50% -5%, var(--bg-accent), transparent)">
  <div class="container" style="max-width:860px">
    <div class="row-between" style="margin-bottom:22px">
      <div>
        <span class="kicker">Tiket Saya</span>
        <h2 style="margin:0">Salam, <?= e(ucwords(strtolower($regs[0]['full_name'] ?? ''))) ?></h2>
        <p class="muted" style="margin:4px 0 0"><?= count($regs) ?> pendaftaran dijumpai</p>
      </div>
      <form method="post" action="/tiket-saya/keluar"><?= csrf_field() ?><button class="btn btn-sm"><i data-lucide="log-out"></i> Keluar</button></form>
    </div>
    <div class="card">
      <?php foreach ($regs as $r): $past = $r['event_date'] < date('Y-m-d'); ?>
        <div class="reg-item t-<?= e($r['event_type']) ?>">
          <div class="date-chip" aria-hidden="true">
            <div class="dc-m"><?= e(mb_substr(BULAN_BM[(int) date('n', strtotime($r['event_date']))], 0, 3)) ?></div>
            <div class="dc-d"><?= date('j', strtotime($r['event_date'])) ?></div>
            <div class="dc-w"><?= date('Y', strtotime($r['event_date'])) ?></div>
          </div>
          <div class="grow">
            <div class="row" style="gap:6px;margin-bottom:4px">
              <span class="badge badge-plain tag-<?= e($r['event_type']) ?>"><?= e(type_label($r['event_type'])) ?></span>
              <?= status_badge($r['status']) ?>
              <?php if ($past): ?><span class="badge badge-gray badge-plain">Telah berlalu</span><?php endif; ?>
            </div>
            <h4><?= e($r['event_title']) ?></h4>
            <div class="muted small"><span class="mono"><?= e($r['ref_code']) ?></span> · <?= e($r['venue_name']) ?></div>
          </div>
          <div class="row" style="gap:6px">
            <a class="btn btn-sm btn-icon" href="/tiket/<?= e($r['token']) ?>/pdf" title="Muat turun PDF" aria-label="Muat turun PDF"><i data-lucide="download"></i></a>
            <a class="btn btn-sm btn-primary" href="/tiket/<?= e($r['token']) ?>">Lihat tiket <i data-lucide="arrow-right"></i></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
