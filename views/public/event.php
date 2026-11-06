<?php
use App\Events;
use App\Registrations;

[$stateLabel, $stateTone] = Events::stateLabel($event);
$open = Events::acceptsRegistrations($event);
$left = Events::seatsLeft($event);
$pct = Events::fillPercent($event);
$willWaitlist = $open && $left === 0;
$err = fn(string $k) => error_for($k) ? '<div class="error-text"><i data-lucide="alert-circle"></i>' . e(error_for($k)) . '</div>' : '';
$cls = fn(string $k) => error_for($k) ? 'field has-error' : 'field';
$oldQ = (array) old('q', []);
$questions = custom_fields($event);
$zonesById = array_column(lookup_items('zones'), 'name', 'id');
$statesByZone = [];
foreach (lookup_items('states') as $s) $statesByZone[$zonesById[$s['zone_id']]][] = $s['name'];
?>
<section class="page-hero t-<?= e($event['type']) ?>">
  <div class="container">
    <div class="crumbs"><a href="/">Utama</a><i data-lucide="chevron-right"></i><a href="/acara">Acara</a><i data-lucide="chevron-right"></i><span><?= e(type_label($event['type'])) ?></span></div>
    <div class="row" style="gap:8px;margin-bottom:12px">
      <span class="badge badge-plain"><?= e(type_label($event['type'])) ?></span>
      <span class="badge"><?= e($stateLabel) ?></span>
      <?php if ($event['zone_name']): ?><span class="badge badge-plain">Zon <?= e($event['zone_name']) ?></span><?php endif; ?>
    </div>
    <h1><?= e($event['title']) ?></h1>
  </div>
</section>

<div class="container" style="padding-bottom:40px">
  <div class="layout-aside">
    <div>
      <?php if ($event['description']): ?>
      <div class="card" style="margin-bottom:24px">
        <div class="card-body">
          <h3 class="row" style="gap:10px"><i data-lucide="info" style="color:var(--primary)"></i> Mengenai acara ini</h3>
          <p class="muted" style="margin:0;white-space:pre-line"><?= e($event['description']) ?></p>
        </div>
      </div>
      <?php endif; ?>

      <?php if (!$open): ?>
        <div class="card empty" id="borang">
          <div class="empty-ico" style="background:var(--rose-soft);color:var(--rose)"><i data-lucide="lock"></i></div>
          <h3>Pendaftaran ditutup</h3>
          <p style="max-width:52ch;margin:0 auto 18px"><?= e($event['closed_message'] ?: 'Pendaftaran untuk acara ini tidak lagi dibuka.') ?></p>
          <a href="/acara" class="btn">Lihat acara lain</a>
        </div>
      <?php else: ?>
      <form id="reg-form" class="card" method="post" action="/acara/<?= e($event['slug']) ?>/daftar" novalidate>
        <div class="form-progress" aria-hidden="true"><span></span></div>
        <?= csrf_field() ?>
        <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">

        <div class="form-section" id="borang">
          <div class="row-between" style="margin-bottom:6px">
            <h2 style="margin:0">Borang Pendaftaran</h2>
            <span class="badge badge-blue badge-plain"><span data-progress-label>0%</span>&nbsp;lengkap</span>
          </div>
          <p class="muted small" style="margin:0">Medan bertanda <span style="color:var(--rose)">*</span> wajib diisi. Maklumat anda hanya digunakan untuk tujuan acara ini.</p>
          <?php if ($willWaitlist): ?>
            <div class="alert alert-warning" style="margin-top:16px"><i data-lucide="hourglass"></i><div><strong>Kuota penuh.</strong> Anda masih boleh mendaftar dan akan dimasukkan ke <strong>senarai menunggu</strong>. Tempat akan disahkan secara automatik jika ada pembatalan.</div></div>
          <?php endif; ?>
        </div>

        <div class="form-section">
          <div class="form-section-head"><div class="num">1</div><div><h3>Maklumat Peribadi</h3><p>Seperti dalam MyKad</p></div></div>
          <div class="form-grid">
            <div class="<?= $cls('full_name') ?> full">
              <label for="full_name">Nama Penuh <span class="req">*</span></label>
              <div class="input-icon"><i data-lucide="user"></i><input class="input" id="full_name" name="full_name" value="<?= e(old('full_name')) ?>" placeholder="Contoh: AHMAD BIN ALI" autocomplete="name" required style="text-transform:uppercase"></div>
              <?= $err('full_name') ?>
            </div>
            <div class="<?= $cls('ic_no') ?>">
              <label for="ic_no">No. MyKad <span class="req">*</span></label>
              <div class="input-icon"><i data-lucide="id-card"></i><input class="input mono" id="ic_no" name="ic_no" value="<?= e(old('ic_no')) ?>" placeholder="900101011234" inputmode="numeric" maxlength="12" data-digits required></div>
              <span class="hint" data-ic-hint>Format: 12 digit tanpa sengkang</span>
              <?= $err('ic_no') ?>
            </div>
            <div class="<?= $cls('email') ?>">
              <label for="email">E-mel <span class="req">*</span></label>
              <div class="input-icon"><i data-lucide="mail"></i><input class="input" type="email" id="email" name="email" value="<?= e(old('email')) ?>" placeholder="nama@organisasi.com" autocomplete="email" required></div>
              <span class="hint">E-tiket akan dihantar ke e-mel ini</span>
              <?= $err('email') ?>
            </div>
            <div class="<?= $cls('mobile_no') ?>">
              <label for="mobile_no">No. Telefon Bimbit <span class="req">*</span></label>
              <div class="input-icon"><i data-lucide="smartphone"></i><input class="input" id="mobile_no" name="mobile_no" value="<?= e(old('mobile_no')) ?>" placeholder="0123456789" inputmode="tel" maxlength="11" data-digits required></div>
              <?= $err('mobile_no') ?>
            </div>
            <div class="<?= $cls('office_no') ?>">
              <label for="office_no">No. Telefon Pejabat</label>
              <div class="input-icon"><i data-lucide="phone"></i><input class="input" id="office_no" name="office_no" value="<?= e(old('office_no')) ?>" placeholder="0388881234" inputmode="tel" maxlength="12" data-digits></div>
              <?= $err('office_no') ?>
            </div>
          </div>
        </div>

        <div class="form-section">
          <div class="form-section-head"><div class="num">2</div><div><h3>Maklumat Organisasi</h3><p>Tempat bertugas dan jawatan semasa</p></div></div>
          <div class="form-grid">
            <div class="<?= $cls('ministry') ?> full">
              <label for="ministry">Kementerian / Organisasi Induk</label>
              <select class="select" id="ministry" name="ministry">
                <option value="">Tiada / Tidak berkaitan</option>
                <?php foreach (lookup_items('ministries') as $m): ?>
                  <option value="<?= e($m['name']) ?>" <?= old('ministry') === $m['name'] ? 'selected' : '' ?>><?= e($m['name']) ?></option>
                <?php endforeach; ?>
              </select>
              <?= $err('ministry') ?>
            </div>
            <div class="<?= $cls('agency') ?>">
              <label for="agency">Organisasi / Jabatan <span class="req">*</span></label>
              <div class="input-icon"><i data-lucide="building-2"></i><input class="input" id="agency" name="agency" value="<?= e(old('agency')) ?>" placeholder="Contoh: Jabatan Digital Negara" required></div>
              <?= $err('agency') ?>
            </div>
            <div class="<?= $cls('grade') ?>">
              <label for="grade">Jawatan / Gred <span class="req">*</span></label>
              <div class="input-icon"><i data-lucide="award"></i><input class="input" id="grade" name="grade" value="<?= e(old('grade')) ?>" placeholder="Contoh: Pegawai Teknologi Maklumat F41" maxlength="60" required></div>
              <?= $err('grade') ?>
            </div>
            <div class="<?= $cls('state') ?> full">
              <label for="state">Negeri Bertugas <span class="req">*</span></label>
              <select class="select" id="state" name="state" required>
                <option value="">Sila pilih…</option>
                <?php foreach ($statesByZone as $zone => $states): ?>
                  <optgroup label="Zon <?= e($zone) ?>">
                    <?php foreach ($states as $s): ?><option value="<?= e($s) ?>" <?= old('state') === $s ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?>
                  </optgroup>
                <?php endforeach; ?>
              </select>
              <?= $err('state') ?>
            </div>
          </div>
        </div>

        <?php if ($questions): ?>
        <div class="form-section">
          <div class="form-section-head"><div class="num">3</div><div><h3>Soalan Tambahan</h3><p>Ditetapkan oleh penganjur acara ini</p></div></div>
          <div class="stack" style="display:grid;gap:22px">
          <?php foreach ($questions as $q):
              $name = 'q[' . $q['key'] . ']';
              $oldVal = $oldQ[$q['key']] ?? ($q['type'] === 'checkbox' ? [] : '');
              $qErr = error_for('q.' . $q['key']);
              $req = !empty($q['required']); ?>
            <div class="field <?= $qErr ? 'has-error' : '' ?>" data-question="<?= e($q['key']) ?>" data-type="<?= e($q['type']) ?>" <?= $req ? 'data-required' : '' ?>>
              <?php if (in_array($q['type'], ['text', 'textarea', 'select'], true)): ?>
                <label for="q-<?= e($q['key']) ?>"><?= e($q['label']) ?> <?= $req ? '<span class="req">*</span>' : '' ?></label>
              <?php else: ?>
                <span class="label"><?= e($q['label']) ?> <?= $req ? '<span class="req" style="color:var(--rose)">*</span>' : '' ?></span>
              <?php endif; ?>
              <?php if ($q['type'] === 'text'): ?>
                <input class="input" id="q-<?= e($q['key']) ?>" name="<?= e($name) ?>" value="<?= e($oldVal) ?>" maxlength="255">
              <?php elseif ($q['type'] === 'textarea'): ?>
                <textarea class="textarea" id="q-<?= e($q['key']) ?>" name="<?= e($name) ?>" rows="3" maxlength="2000"><?= e($oldVal) ?></textarea>
              <?php elseif ($q['type'] === 'select'): ?>
                <select class="select" id="q-<?= e($q['key']) ?>" name="<?= e($name) ?>">
                  <option value="">Sila pilih…</option>
                  <?php foreach ($q['options'] as $o): ?><option <?= $oldVal === $o ? 'selected' : '' ?>><?= e($o) ?></option><?php endforeach; ?>
                </select>
              <?php elseif ($q['type'] === 'radio'): ?>
                <div class="radio-cards" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr))">
                  <?php foreach ($q['options'] as $o): ?>
                    <label class="radio-card"><input type="radio" name="<?= e($name) ?>" value="<?= e($o) ?>" <?= $oldVal === $o ? 'checked' : '' ?>><span class="rc"><span class="ico"><i data-lucide="circle-dot"></i></span><span><strong><?= e($o) ?></strong></span></span></label>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="chips">
                  <?php foreach ($q['options'] as $o): ?>
                    <label class="chip"><input type="checkbox" name="<?= e($name) ?>[]" value="<?= e($o) ?>" <?= in_array($o, (array) $oldVal, true) ? 'checked' : '' ?>><span><?= e($o) ?></span></label>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <div class="error-text <?= $qErr ? '' : 'hidden' ?>" data-q-error><i data-lucide="alert-circle"></i> <?= e($qErr ?: 'Soalan ini wajib dijawab.') ?></div>
            </div>
          <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <div class="form-section">
          <label class="checkbox">
            <input type="checkbox" name="consent" value="1" <?= old('consent') ? 'checked' : '' ?>>
            <span>Saya mengesahkan bahawa maklumat yang diberikan adalah benar dan bersetuju maklumat ini digunakan oleh urusetia bagi tujuan pengurusan acara ini.</span>
          </label>
          <div class="error-text <?= error_for('consent') ? '' : 'hidden' ?>" data-consent-error style="margin-top:6px"><i data-lucide="alert-circle"></i> Sila tandakan pengesahan.</div>
          <button type="submit" class="btn btn-gradient btn-lg btn-block" style="margin-top:22px">
            <i data-lucide="<?= $willWaitlist ? 'hourglass' : 'send' ?>"></i> <?= $willWaitlist ? 'Daftar ke Senarai Menunggu' : 'Hantar Pendaftaran' ?>
          </button>
          <p class="center muted xs" style="margin:12px 0 0"><i data-lucide="lock" style="width:12px;height:12px;vertical-align:-1px"></i> Dilindungi. Satu pendaftaran bagi setiap No. MyKad.</p>
        </div>
      </form>
      <?php endif; ?>
    </div>

    <aside>
      <div class="sticky">
        <div class="card">
          <div class="card-body">
            <div class="info-list">
              <div class="info-item"><div class="ii-ico"><i data-lucide="calendar"></i></div><div><small>Tarikh</small><strong><?= e(tarikh_bm($event['event_date'])) ?></strong><div class="muted small"><?= e(hari_bm($event['event_date'])) ?></div></div></div>
              <div class="info-item"><div class="ii-ico"><i data-lucide="clock"></i></div><div><small>Masa</small><strong><?= e(masa_bm($event['start_time'])) ?> – <?= e(masa_bm($event['end_time'])) ?></strong></div></div>
              <div class="info-item"><div class="ii-ico"><i data-lucide="map-pin"></i></div><div><small>Tempat</small><strong><?= e($event['venue_name']) ?></strong><?php if ($event['venue_address']): ?><div class="muted small"><?= e($event['venue_address']) ?></div><?php endif; ?>
                <a class="small" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query=<?= urlencode(Events::venue($event)) ?>">Buka di peta <i data-lucide="arrow-up-right" style="width:12px;height:12px"></i></a></div></div>
              <?php if ($event['registration_deadline']): ?>
              <div class="info-item"><div class="ii-ico"><i data-lucide="timer"></i></div><div><small>Tutup Pendaftaran</small><strong><?= e(datetime_bm($event['registration_deadline'])) ?></strong></div></div>
              <?php endif; ?>
            </div>
            <hr>
            <div class="seat-box">
              <div class="row-between" style="align-items:flex-end;margin-bottom:10px">
                <div><div class="muted xs" style="font-weight:700;text-transform:uppercase;letter-spacing:.06em">Baki tempat</div><div class="big"><?= $left ?></div></div>
                <div class="right muted small"><?= (int) $event['confirmed'] ?> / <?= (int) $event['capacity'] ?> berdaftar<?php if ($event['waitlisted']): ?><br><?= (int) $event['waitlisted'] ?> menunggu<?php endif; ?></div>
              </div>
              <div class="progress <?= $pct >= 100 ? 'is-full' : ($pct >= 80 ? 'is-warn' : '') ?>"><span data-w="<?= $pct ?>" style="width:0"></span></div>
            </div>
            <?php if ($event['event_date'] >= date('Y-m-d')): ?>
            <div style="margin-top:16px">
              <div class="muted xs" style="font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px">Acara bermula dalam</div>
              <div class="countdown" data-countdown="<?= e($event['event_date'] . 'T' . substr($event['start_time'], 0, 5) . ':00+08:00') ?>">
                <div><strong data-d>0</strong><span>Hari</span></div><div><strong data-h>00</strong><span>Jam</span></div>
                <div><strong data-m>00</strong><span>Min</span></div><div><strong data-s>00</strong><span>Saat</span></div>
              </div>
            </div>
            <?php endif; ?>
          </div>
          <div class="card-footer">
            <a href="/semak" class="btn btn-ghost btn-block btn-sm"><i data-lucide="ticket"></i> Sudah daftar? Semak tiket anda</a>
          </div>
        </div>
      </div>
    </aside>
  </div>
</div>
