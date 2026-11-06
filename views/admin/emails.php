<?php
$vars = ['{nama}' => 'Nama peserta', '{acara}' => 'Tajuk acara', '{tarikh}' => 'Tarikh acara', '{hari}' => 'Hari', '{masa}' => 'Masa mula–tamat', '{tempat}' => 'Tempat & alamat', '{rujukan}' => 'No. rujukan', '{pautan}' => 'Pautan e-tiket'];
$canEdit = admin()['role'] !== 'staff';
?>
<div class="page-title">
  <div><h1>Templat E-mel</h1><p>E-mel automatik yang dihantar kepada peserta. Gunakan pemboleh ubah untuk maklumat dinamik.</p></div>
</div>

<div class="grid" style="grid-template-columns:240px minmax(0,1fr) minmax(0,1fr);align-items:start" id="email-grid">
  <div class="card" style="padding:8px">
    <?php foreach ($templates as $t): ?>
      <a href="?t=<?= e($t['code']) ?>" class="side-link" style="color:var(--text-2);<?= $current && $current['code'] === $t['code'] ? 'background:var(--primary-soft);color:var(--primary)' : '' ?>">
        <i data-lucide="<?= str_starts_with($t['code'], 'confirm') ? 'mail-check' : ($t['code'] === 'waitlist' ? 'hourglass' : ($t['code'] === 'promoted' ? 'party-popper' : 'mail-x')) ?>"></i> <?= e($t['label']) ?>
      </a>
    <?php endforeach; ?>
  </div>

  <?php if ($current): ?>
  <form method="post" action="/admin/emel/<?= e($current['code']) ?>" class="card" id="tpl-form">
    <?= csrf_field() ?>
    <div class="card-header"><h3><?= e($current['label']) ?></h3><span class="xs muted">Dikemaskini <?= e(datetime_bm($current['updated_at'])) ?></span></div>
    <div class="card-body stack">
      <div class="field"><label for="subject">Subjek</label><input class="input" id="subject" name="subject" value="<?= e($current['subject']) ?>" <?= $canEdit ? '' : 'readonly' ?>></div>
      <div class="field"><label for="body">Kandungan</label><textarea class="textarea" id="body" name="body" rows="16" style="font-size:.9rem" <?= $canEdit ? '' : 'readonly' ?>><?= e($current['body']) ?></textarea>
        <span class="hint">Baris kosong memisahkan perenggan. Kod QR &amp; fail kalendar dilampirkan secara automatik untuk pengesahan.</span></div>
      <div class="field"><span class="label">Pemboleh ubah (klik untuk sisip)</span>
        <div class="template-vars"><?php foreach ($vars as $k => $d): ?><button type="button" data-var="<?= e($k) ?>" title="<?= e($d) ?>"><?= e($k) ?></button><?php endforeach; ?></div></div>
    </div>
    <?php if ($canEdit): ?>
    <div class="card-footer row" style="justify-content:flex-end">
      <button class="btn" name="send_test" value="1"><i data-lucide="send"></i> Simpan &amp; hantar ujian</button>
      <button class="btn btn-primary"><i data-lucide="save"></i> Simpan</button>
    </div>
    <?php endif; ?>
  </form>

  <div class="card">
    <div class="card-header"><h3>Pratonton</h3><span class="badge badge-gray badge-plain">Data contoh</span></div>
    <div class="card-body">
      <div class="small" style="margin-bottom:10px"><span class="muted">Subjek:</span> <strong id="pv-subject"></strong></div>
      <div class="email-preview"><iframe id="pv-frame" title="Pratonton e-mel" sandbox=""></iframe></div>
    </div>
  </div>
  <?php endif; ?>
</div>
<style>@media (max-width:1280px){#email-grid{grid-template-columns:1fr 1fr!important}#email-grid>.card:first-child{grid-column:1/-1;display:flex;flex-wrap:wrap}}@media (max-width:860px){#email-grid{grid-template-columns:1fr!important}}</style>

<?php $scripts = <<<'HTML'
<script>
(function () {
  const form = document.getElementById('tpl-form');
  if (!form) return;
  const subject = form.elements.subject, body = form.elements.body;
  const csrf = document.querySelector('meta[name="csrf-token"]').content;
  let t;
  async function preview() {
    const r = await fetch('/admin/emel/pratonton', { method: 'POST', body: new URLSearchParams({ subject: subject.value, body: body.value, _csrf: csrf }) });
    const d = await r.json();
    document.getElementById('pv-subject').textContent = d.subject;
    document.getElementById('pv-frame').srcdoc = d.html;
  }
  [subject, body].forEach(el => el.addEventListener('input', () => { clearTimeout(t); t = setTimeout(preview, 300); }));
  let lastFocus = body;
  [subject, body].forEach(el => el.addEventListener('focus', () => lastFocus = el));
  document.querySelectorAll('[data-var]').forEach(b => b.addEventListener('click', () => {
    const el = lastFocus, v = b.dataset.var, s = el.selectionStart ?? el.value.length;
    el.value = el.value.slice(0, s) + v + el.value.slice(el.selectionEnd ?? s);
    el.focus(); el.selectionStart = el.selectionEnd = s + v.length;
    preview();
  }));
  preview();
})();
</script>
HTML; ?>
