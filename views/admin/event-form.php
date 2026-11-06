<?php
$v = fn(string $k, $default = '') => old($k, $event[$k] ?? $default);
$err = fn(string $k) => error_for($k) ? '<div class="error-text"><i data-lucide="alert-circle"></i>' . e(error_for($k)) . '</div>' : '';
$cls = fn(string $k) => 'field' . (error_for($k) ? ' has-error' : '');
$deadline = $v('registration_deadline');
if ($deadline) $deadline = str_replace(' ', 'T', substr((string) $deadline, 0, 16));
$hasOld = !empty($GLOBALS['__old']);
$waitlist = $hasOld ? !empty(old('waitlist_enabled')) : (bool) ($event['waitlist_enabled'] ?? true);
?>
<div class="page-title">
  <div>
    <a href="/admin/acara" class="btn btn-ghost btn-sm" style="margin-bottom:8px"><i data-lucide="arrow-left"></i> Kembali</a>
    <h1><?= $event ? 'Kemaskini Acara' : 'Acara Baharu' ?></h1>
    <p><?= $event ? e($event['title']) : 'Isi butiran acara. Anda boleh simpan sebagai draf dahulu.' ?></p>
  </div>
  <?php if ($event): ?><a href="/acara/<?= e($event['slug']) ?>" target="_blank" class="btn"><i data-lucide="external-link"></i> Lihat laman awam</a><?php endif; ?>
</div>

<form method="post" class="grid" style="grid-template-columns:minmax(0,1fr) 340px;align-items:start" id="event-form">
  <?= csrf_field() ?>
  <div class="stack">
    <div class="card">
      <div class="card-header"><h3>Butiran Acara</h3></div>
      <div class="card-body form-grid">
        <div class="field full">
          <span class="label">Jenis acara</span>
          <div class="radio-cards">
            <?php foreach (EVENT_TYPES as $t => [$lbl, $prefix, $ico]): ?>
            <label class="radio-card"><input type="radio" name="type" value="<?= $t ?>" <?= $v('type', 'latihan') === $t ? 'checked' : '' ?>><span class="rc"><span class="ico"><i data-lucide="<?= $ico ?>"></i></span><span><strong><?= e($lbl) ?></strong><small>Rujukan <?= $prefix ?>-XXXXXX</small></span></span></label>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="<?= $cls('title') ?> full"><label for="title">Tajuk <span class="req">*</span></label><input class="input" id="title" name="title" value="<?= e($v('title')) ?>" placeholder="Contoh: Bengkel Kepimpinan Digital 2026" required><?= $err('title') ?></div>
        <div class="field full"><label for="description">Penerangan</label><textarea class="textarea" id="description" name="description" rows="4" placeholder="Objektif, sasaran peserta, perkara yang perlu dibawa…"><?= e($v('description')) ?></textarea></div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3>Tarikh &amp; Lokasi</h3></div>
      <div class="card-body form-grid">
        <div class="<?= $cls('event_date') ?>"><label for="event_date">Tarikh <span class="req">*</span></label><input class="input" type="date" id="event_date" name="event_date" value="<?= e($v('event_date')) ?>" required><?= $err('event_date') ?></div>
        <div class="form-grid" style="gap:12px">
          <div class="<?= $cls('start_time') ?>"><label for="start_time">Mula <span class="req">*</span></label><input class="input" type="time" id="start_time" name="start_time" value="<?= e(substr((string) $v('start_time', '09:00'), 0, 5)) ?>" required><?= $err('start_time') ?></div>
          <div class="<?= $cls('end_time') ?>"><label for="end_time">Tamat <span class="req">*</span></label><input class="input" type="time" id="end_time" name="end_time" value="<?= e(substr((string) $v('end_time', '17:00'), 0, 5)) ?>" required><?= $err('end_time') ?></div>
        </div>
        <div class="<?= $cls('venue_name') ?> full"><label for="venue_name">Nama tempat <span class="req">*</span></label><div class="input-icon"><i data-lucide="building"></i><input class="input" id="venue_name" name="venue_name" value="<?= e($v('venue_name')) ?>" placeholder="Contoh: Dewan Seminar, Hotel Hilton" required></div><?= $err('venue_name') ?></div>
        <div class="field full"><label for="venue_address">Alamat</label><div class="input-icon"><i data-lucide="map-pin"></i><input class="input" id="venue_address" name="venue_address" value="<?= e($v('venue_address')) ?>" placeholder="Jalan, poskod, bandar, negeri"></div></div>
        <div class="field"><label for="zone_id">Zon</label>
          <select class="select" id="zone_id" name="zone_id"><option value="">—</option>
            <?php foreach (lookup_items('zones') as $z): ?><option value="<?= $z['id'] ?>" <?= (string) $v('zone_id') === (string) $z['id'] ? 'selected' : '' ?>><?= e($z['name']) ?></option><?php endforeach; ?>
          </select></div>
        <div class="field"><label for="state_id">Negeri</label>
          <select class="select" id="state_id" name="state_id"><option value="">—</option>
            <?php foreach (lookup_items('states') as $s): ?><option value="<?= $s['id'] ?>" data-zone="<?= $s['zone_id'] ?>" <?= (string) $v('state_id') === (string) $s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option><?php endforeach; ?>
          </select></div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <div><h3>Soalan Tambahan</h3><p class="muted small" style="margin:2px 0 0">Tanya maklumat khusus untuk acara ini, contohnya saiz baju, keperluan diet atau sesi pilihan.</p></div>
        <button type="button" class="btn btn-soft btn-sm" id="qb-add"><i data-lucide="plus"></i> Tambah soalan</button>
      </div>
      <div class="card-body">
        <input type="hidden" name="custom_fields" id="custom_fields" value="<?= e(old('custom_fields', $event['custom_fields'] ?? '[]')) ?>">
        <div id="qb-list"></div>
        <div class="empty" id="qb-empty" style="padding:24px"><p class="small" style="margin:0">Tiada soalan tambahan. Borang hanya akan meminta maklumat asas peserta.</p></div>
        <p class="hint" style="margin:12px 0 0">Untuk jenis <em>Pilihan</em>, masukkan setiap pilihan dipisahkan dengan koma. Soalan baharu tidak akan ditanya kepada peserta yang sudah mendaftar.</p>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3>Mesej Apabila Ditutup</h3></div>
      <div class="card-body"><div class="field"><textarea class="textarea" name="closed_message" rows="3" placeholder="Contoh: Penyertaan telah DITUTUP kerana kuota telah mencukupi."><?= e($v('closed_message')) ?></textarea><span class="hint">Dipaparkan kepada pengguna apabila pendaftaran ditutup atau penuh (tanpa senarai menunggu).</span></div></div>
    </div>
  </div>

  <div class="stack sticky" style="top:86px">
    <div class="card">
      <div class="card-header"><h3>Penerbitan</h3></div>
      <div class="card-body stack">
        <div class="field"><label for="status">Status</label>
          <select class="select" id="status" name="status">
            <?php foreach (['open' => 'Dibuka — terima pendaftaran', 'draft' => 'Draf — tersembunyi', 'closed' => 'Ditutup — papar sahaja'] as $k => $l): ?>
              <option value="<?= $k ?>" <?= $v('status', 'open') === $k ? 'selected' : '' ?>><?= $l ?></option>
            <?php endforeach; ?>
          </select></div>
        <div class="field"><label for="capacity">Kapasiti peserta</label><div class="input-icon"><i data-lucide="users"></i><input class="input" type="number" min="1" max="100000" id="capacity" name="capacity" value="<?= e($v('capacity', 50)) ?>" required></div>
          <?php if ($event && $event['waitlisted']): ?><span class="hint">Menambah kapasiti akan menaikkan <?= (int) $event['waitlisted'] ?> peserta menunggu secara automatik.</span><?php endif; ?></div>
        <label class="checkbox"><input type="checkbox" name="waitlist_enabled" value="1" <?= $waitlist ? 'checked' : '' ?>><span><strong>Senarai menunggu</strong><br><span class="muted small">Terima pendaftaran tambahan apabila penuh</span></span></label>
        <div class="field"><label for="registration_deadline">Tarikh tutup pendaftaran</label><input class="input" type="datetime-local" id="registration_deadline" name="registration_deadline" value="<?= e($deadline) ?>"><span class="hint">Kosongkan untuk tutup pada hari acara.</span></div>
      </div>
      <div class="card-footer row" style="justify-content:flex-end">
        <a href="/admin/acara" class="btn">Batal</a>
        <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Simpan</button>
      </div>
    </div>
    <?php if ($event): ?>
    <div class="card"><div class="card-body">
      <div class="row-between small"><span class="muted">Berdaftar</span><strong><?= (int) $event['confirmed'] ?></strong></div>
      <div class="row-between small"><span class="muted">Menunggu</span><strong><?= (int) $event['waitlisted'] ?></strong></div>
      <div class="row-between small"><span class="muted">Hadir</span><strong><?= (int) $event['attended'] ?></strong></div>
      <hr style="margin:12px 0">
      <a href="/admin/peserta?event=<?= (int) $event['id'] ?>" class="btn btn-soft btn-block btn-sm"><i data-lucide="users"></i> Lihat peserta</a>
    </div></div>
    <?php endif; ?>
  </div>
</form>
<style>@media (max-width:1100px){#event-form{grid-template-columns:1fr!important}#event-form .sticky{position:static}}</style>
<?php $scripts = <<<'HTML'
<script>
// ---- Custom question builder ----
(function () {
  const hidden = document.getElementById('custom_fields');
  const list = document.getElementById('qb-list');
  const empty = document.getElementById('qb-empty');
  const types = { text: 'Teks ringkas', textarea: 'Teks panjang', select: 'Senarai juntai', radio: 'Pilih satu', checkbox: 'Pilih beberapa' };
  let items = [];
  try { items = JSON.parse(hidden.value || '[]') || []; } catch (e) { items = []; }

  const esc = s => String(s ?? '').replace(/[&<>"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  function sync() {
    hidden.value = JSON.stringify(items.map(it => ({
      key: it.key || '', label: it.label, type: it.type, required: !!it.required,
      options: ['select', 'radio', 'checkbox'].includes(it.type) ? String(it.optionsText ?? (it.options || []).join(', ')).split(',').map(s => s.trim()).filter(Boolean) : [],
    })));
    empty.classList.toggle('hidden', items.length > 0);
  }
  function render() {
    list.innerHTML = items.map((it, i) => {
      const opts = it.optionsText ?? (it.options || []).join(', ');
      const needsOpts = ['select', 'radio', 'checkbox'].includes(it.type);
      return '<div class="qb-row" data-i="' + i + '">' +
        '<input class="input" data-f="label" placeholder="Soalan, cth: Saiz baju" value="' + esc(it.label) + '">' +
        '<select class="select" data-f="type">' + Object.entries(types).map(([k, v]) => '<option value="' + k + '"' + (it.type === k ? ' selected' : '') + '>' + v + '</option>').join('') + '</select>' +
        '<input class="input" data-f="optionsText" placeholder="' + (needsOpts ? 'Pilihan: S, M, L, XL' : 'Tiada pilihan diperlukan') + '" value="' + esc(opts) + '"' + (needsOpts ? '' : ' disabled') + '>' +
        '<label class="checkbox"><input type="checkbox" data-f="required"' + (it.required ? ' checked' : '') + '> Wajib</label>' +
        '<button type="button" class="btn btn-ghost btn-icon btn-sm" data-remove aria-label="Buang soalan" style="height:40px;width:40px"><i data-lucide="trash-2"></i></button>' +
      '</div>';
    }).join('');
    sync();
    Hadirin.icons && Hadirin.icons();
  }
  list.addEventListener('input', e => {
    const row = e.target.closest('.qb-row'); if (!row) return;
    const it = items[+row.dataset.i], f = e.target.dataset.f;
    it[f] = e.target.type === 'checkbox' ? e.target.checked : e.target.value;
    if (f === 'type') render(); else sync();
  });
  list.addEventListener('click', e => {
    if (!e.target.closest('[data-remove]')) return;
    items.splice(+e.target.closest('.qb-row').dataset.i, 1); render();
  });
  document.getElementById('qb-add').addEventListener('click', () => {
    items.push({ label: '', type: 'text', required: false, options: [] }); render();
    list.lastElementChild?.querySelector('input')?.focus();
  });
  document.addEventListener('DOMContentLoaded', render);
  if (window.Hadirin) render();
})();

// Picking a state auto-selects its zone
document.getElementById('state_id').addEventListener('change', e => {
  const z = e.target.selectedOptions[0]?.dataset.zone;
  if (z) document.getElementById('zone_id').value = z;
});
</script>
HTML; ?>
