<?php
$isWait = $reg['status'] === 'waitlisted';
$isActive = in_array($reg['status'], ['registered', 'attended'], true);
$canCancel = in_array($reg['status'], ['registered', 'waitlisted'], true) && $reg['event_date'] >= date('Y-m-d');
$canAbsent = in_array($reg['status'], ['registered', 'waitlisted'], true);
$position = null;
if ($isWait) {
    $st = db()->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ? AND status = 'waitlisted' AND (created_at < ? OR (created_at = ? AND id <= ?))");
    $st->execute([$reg['event_id'], $reg['created_at'], $reg['created_at'], $reg['id']]);
    $position = (int) $st->fetchColumn();
}
$base = '/tiket/' . e($reg['token']);
?>
<section class="section" style="padding-top:40px;background:radial-gradient(900px 380px at 50% -5%, var(--bg-accent), transparent)">
  <div class="container" style="max-width:920px">
    <?php if ($fresh): ?>
      <div class="center fade-in" style="margin-bottom:28px">
        <div class="success-burst <?= $isWait ? 'is-wait' : '' ?>"><i data-lucide="<?= $isWait ? 'hourglass' : 'check' ?>"></i></div>
        <h1 style="font-size:clamp(1.6rem,3.5vw,2.2rem)"><?= $isWait ? 'Anda dalam senarai menunggu' : 'Pendaftaran berjaya!' ?></h1>
        <p class="muted" style="max-width:56ch;margin:0 auto">
          <?php if ($isWait): ?>
            Kuota telah penuh. Anda berada di <strong>giliran #<?= $position ?></strong>. Kami akan menghantar e-mel jika tempat anda disahkan.
          <?php else: ?>
            Terima kasih, <?= e($reg['full_name']) ?>. Simpan e-tiket ini dan tunjukkan kod QR di kaunter pada hari acara.
          <?php endif; ?>
        </p>
        <?php if ($mailSent === false): ?>
          <div class="alert alert-warning" style="max-width:560px;margin:16px auto 0;text-align:left"><i data-lucide="mail-warning"></i><div>E-mel pengesahan tidak dapat dihantar buat masa ini. Sila muat turun tiket PDF di bawah sebagai rujukan.</div></div>
        <?php elseif ($mailSent): ?>
          <p class="small" style="margin-top:10px;color:var(--green)"><i data-lucide="mail-check" style="vertical-align:-3px"></i> Salinan telah dihantar ke <strong><?= e($reg['email']) ?></strong></p>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="row-between no-print" style="margin-bottom:20px">
        <div><span class="kicker">E-Tiket</span><h2 style="margin:0">Tiket Pendaftaran Anda</h2></div>
        <?php if (!empty($_SESSION['participant'])): ?><a href="/tiket-saya" class="btn btn-sm"><i data-lucide="arrow-left"></i> Semua tiket saya</a><?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($reg['status'] === 'cancelled'): ?>
      <div class="alert alert-error" style="margin-bottom:18px"><i data-lucide="x-circle"></i><div><strong>Pendaftaran ini telah dibatalkan.</strong> Kod QR tidak lagi sah. <a href="/acara/<?= e($reg['event_slug']) ?>">Daftar semula</a> jika masih ada tempat.</div></div>
    <?php elseif ($reg['status'] === 'absent'): ?>
      <div class="alert alert-info" style="margin-bottom:18px"><i data-lucide="info"></i><div>Direkodkan sebagai <strong>tidak hadir</strong><?= $reg['absence_reason'] ? ': “' . e($reg['absence_reason']) . '”' : '' ?></div></div>
    <?php elseif ($reg['status'] === 'attended'): ?>
      <div class="alert alert-success" style="margin-bottom:18px"><i data-lucide="badge-check"></i><div>Kehadiran direkodkan pada <strong><?= e(datetime_bm($reg['checked_in_at'])) ?></strong>. Terima kasih kerana hadir!</div></div>
    <?php elseif ($isWait && !$fresh): ?>
      <div class="alert alert-warning" style="margin-bottom:18px"><i data-lucide="hourglass"></i><div>Anda di <strong>giliran #<?= $position ?></strong> dalam senarai menunggu. Kod QR akan aktif setelah tempat disahkan.</div></div>
    <?php endif; ?>

    <div class="ticket t-<?= e($reg['event_type']) ?> fade-in">
      <div class="ticket-head">
        <div>
          <div class="xs" style="opacity:.8;font-weight:700;text-transform:uppercase;letter-spacing:.1em"><?= e(type_label($reg['event_type'])) ?></div>
          <h2><?= e($reg['event_title']) ?></h2>
        </div>
        <div class="ref"><small>No. Rujukan</small><strong><?= e($reg['ref_code']) ?></strong></div>
      </div>
      <div class="ticket-main">
        <div class="ticket-grid">
          <div><small>Nama Peserta</small><strong><?= e($reg['full_name']) ?></strong></div>
          <div><small>Status</small><?= status_badge($reg['status']) ?></div>
          <div><small>No. MyKad</small><strong class="mono"><?= e(mask_ic($reg['ic_no'])) ?></strong></div>
          <div><small>Organisasi</small><strong><?= e($reg['agency']) ?></strong></div>
          <div><small>Tarikh</small><strong><?= e(tarikh_bm($reg['event_date'])) ?> (<?= e(hari_bm($reg['event_date'])) ?>)</strong></div>
          <div><small>Masa</small><strong><?= e(masa_bm($reg['start_time'])) ?> – <?= e(masa_bm($reg['end_time'])) ?></strong></div>
          <div style="grid-column:1/-1"><small>Tempat</small><strong><?= e($reg['venue_name']) ?></strong><?php if ($reg['venue_address']): ?><div class="muted small"><?= e($reg['venue_address']) ?></div><?php endif; ?></div>
        </div>
      </div>
      <div class="ticket-stub">
        <div class="qr-frame <?= $isActive ? '' : 'dim' ?>"><img src="<?= $base ?>/qr.png" alt="Kod QR tiket <?= e($reg['ref_code']) ?>" width="180" height="180"></div>
        <div class="small muted" style="max-width:200px"><?= $isActive ? 'Imbas kod ini di kaunter pendaftaran' : 'Kod QR tidak aktif' ?></div>
      </div>
    </div>

    <div class="row no-print" style="justify-content:center;margin-top:24px">
      <a href="<?= $base ?>/pdf" class="btn btn-primary"><i data-lucide="download"></i> Muat Turun PDF</a>
      <a href="<?= $base ?>/ics" class="btn"><i data-lucide="calendar-plus"></i> Tambah ke Kalendar</a>
      <button type="button" class="btn" onclick="window.print()"><i data-lucide="printer"></i> Cetak</button>
      <?php if ($canCancel || $canAbsent): ?>
      <div class="dropdown">
        <button class="btn" data-dropdown><i data-lucide="more-horizontal"></i> Lagi</button>
        <div class="dropdown-menu">
          <?php if ($canAbsent): ?><button type="button" data-modal-open="#absent-modal"><i data-lucide="calendar-x"></i> Maklum tidak hadir</button><?php endif; ?>
          <?php if ($canCancel): ?>
          <form method="post" action="<?= $base ?>/batal" data-confirm="Pendaftaran anda akan dibatalkan dan tempat diberikan kepada peserta lain. Teruskan?" data-confirm-label="Ya, batalkan">
            <?= csrf_field() ?><button type="submit" class="danger"><i data-lucide="x-circle"></i> Batal pendaftaran</button>
          </form>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <div class="card no-print" style="margin-top:28px">
      <div class="card-body row" style="gap:16px;flex-wrap:nowrap;align-items:flex-start">
        <div class="ii-ico" style="width:40px;height:40px;border-radius:12px;background:var(--amber-soft);color:var(--amber);display:grid;place-items:center;flex-shrink:0"><i data-lucide="bookmark"></i></div>
        <div>
          <strong>Simpan pautan ini</strong>
          <p class="muted small" style="margin:4px 0 10px">Pautan ini ialah akses peribadi ke tiket anda. Jangan kongsikan dengan orang lain.</p>
          <button type="button" class="btn btn-sm btn-soft" data-copy="<?= e(base_url() . '/tiket/' . $reg['token']) ?>"><i data-lucide="copy"></i> Salin pautan tiket</button>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if ($canAbsent): ?>
<div class="modal" id="absent-modal" role="dialog" aria-modal="true" aria-labelledby="absent-title">
  <div class="modal-dialog">
    <form method="post" action="<?= $base ?>/tidak-hadir" class="card-body">
      <?= csrf_field() ?>
      <h3 id="absent-title">Maklum ketidakhadiran</h3>
      <p class="muted small">Makluman awal membolehkan tempat anda diberikan kepada peserta dalam senarai menunggu.</p>
      <div class="field">
        <label for="reason">Sebab tidak dapat hadir <span class="req">*</span></label>
        <textarea class="textarea" id="reason" name="reason" required minlength="5" maxlength="1000" placeholder="Contoh: Bertugas luar kawasan pada tarikh tersebut."></textarea>
      </div>
      <div class="row" style="justify-content:flex-end;margin-top:18px">
        <button type="button" class="btn" data-modal-close>Batal</button>
        <button type="submit" class="btn btn-primary"><i data-lucide="send"></i> Hantar makluman</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
