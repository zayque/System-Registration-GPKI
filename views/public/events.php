<section class="page-hero" style="padding-bottom:90px">
  <div class="container">
    <div class="crumbs"><a href="/">Utama</a><i data-lucide="chevron-right"></i><span>Acara</span></div>
    <h1>Senarai Acara</h1>
    <p style="color:rgba(255,255,255,.85);max-width:60ch;margin:0">Latihan, seminar, bengkel dan acara lain yang dibuka untuk pendaftaran.</p>
  </div>
</section>
<section style="margin-top:-56px;position:relative;z-index:2;padding-bottom:40px">
  <div class="container">
    <div class="card" style="padding:14px 18px;margin-bottom:24px;overflow-x:auto">
      <div class="row-between">
        <div class="segmented" role="tablist">
          <a href="/acara" class="<?= !$type ? 'active' : '' ?>">Semua</a>
          <?php foreach ($availableTypes as $t): ?>
            <a href="/acara?jenis=<?= e($t) ?>" class="<?= $type === $t ? 'active' : '' ?>"><?= e(type_label($t)) ?></a>
          <?php endforeach; ?>
        </div>
        <span class="muted small"><?= count($events) ?> acara dijumpai</span>
      </div>
    </div>
    <?php if ($events): ?>
      <div class="grid grid-3">
        <?php foreach ($events as $e) partial('event-card', ['e' => $e]); ?>
      </div>
    <?php else: ?>
      <div class="card empty">
        <div class="empty-ico"><i data-lucide="calendar-x"></i></div>
        <h3>Tiada acara dijumpai</h3>
        <p>Tiada acara <?= $type ? e(strtolower(type_label($type))) . ' ' : '' ?>yang akan datang buat masa ini.</p>
      </div>
    <?php endif; ?>
  </div>
</section>
