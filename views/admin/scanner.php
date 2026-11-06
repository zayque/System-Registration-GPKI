<div class="page-title">
  <div><h1>Imbas Kehadiran</h1><p>Imbas kod QR pada e-tiket peserta atau masukkan no. rujukan secara manual.</p></div>
  <form method="get" class="row">
    <select class="select" name="event" data-autosubmit style="min-width:280px" aria-label="Pilih acara">
      <?php if (!$events): ?><option value="">Tiada acara aktif</option><?php endif; ?>
      <?php foreach ($events as $ev): ?>
        <option value="<?= (int) $ev['id'] ?>" <?= $selected === (int) $ev['id'] ? 'selected' : '' ?>><?= e(tarikh_bm($ev['event_date'])) ?> · <?= e(mb_strimwidth($ev['title'], 0, 50, '…')) ?></option>
      <?php endforeach; ?>
    </select>
  </form>
</div>

<div class="scanner-shell">
  <div class="stack">
    <div class="card">
      <div class="card-header">
        <h3 class="row" style="gap:8px"><i data-lucide="camera"></i> Kamera</h3>
        <div class="row" style="gap:6px">
          <label class="checkbox small" style="align-items:center"><input type="checkbox" id="sound-on" checked> Bunyi</label>
          <button class="btn btn-sm" id="cam-toggle"><i data-lucide="power"></i> <span>Mula</span></button>
        </div>
      </div>
      <div class="card-body">
        <div id="reader"><div class="empty" style="color:#94a3b8;padding:90px 20px"><div class="empty-ico" style="background:rgba(255,255,255,.08);color:#fff"><i data-lucide="scan-line"></i></div><p style="margin:0">Klik <strong style="color:#fff">Mula</strong> untuk mengaktifkan kamera</p></div></div>
        <form id="manual-form" class="row" style="margin-top:16px;flex-wrap:nowrap">
          <div class="input-icon" style="flex:1"><i data-lucide="keyboard"></i><input class="input mono" id="manual-code" placeholder="No. rujukan, cth: LT-7F3K9Q" autocomplete="off" style="text-transform:uppercase"></div>
          <button class="btn btn-primary" type="submit"><i data-lucide="check"></i> Sahkan</button>
        </form>
        <p class="xs muted" style="margin:10px 0 0">Petua: pengimbas kod bar USB juga boleh digunakan. Klik pada kotak di atas dan imbas.</p>
      </div>
    </div>
  </div>

  <div class="stack">
    <div class="scan-result" id="result" aria-live="polite">
      <div class="sr-ico"><i data-lucide="qr-code"></i></div>
      <h3 id="result-title" style="margin-bottom:4px">Sedia untuk imbas</h3>
      <p class="muted small" id="result-msg" style="margin:0">Keputusan imbasan akan dipaparkan di sini.</p>
      <div id="result-person" class="hidden" style="margin-top:16px;padding-top:16px;border-top:1px solid color-mix(in srgb, currentColor 15%, transparent)">
        <div style="font-weight:800;font-size:1.15rem" id="rp-name"></div>
        <div class="small muted" id="rp-agency"></div>
        <div class="row" style="justify-content:center;gap:8px;margin-top:8px"><span class="badge badge-gray badge-plain mono" id="rp-ref"></span><span class="badge badge-blue badge-plain" id="rp-role"></span></div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row-between" style="align-items:flex-end">
          <div><div class="muted small" style="font-weight:700">Hadir</div><div class="big-counter"><span id="c-att">0</span><span class="muted" style="font-size:1.4rem"> / <span id="c-conf">0</span></span></div></div>
          <div class="right"><div class="muted small" style="font-weight:700">Peratus</div><div style="font-size:1.6rem;font-weight:800" id="c-pct">0%</div></div>
        </div>
        <div class="progress" style="margin-top:12px;height:10px"><span id="c-bar" style="width:0"></span></div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3>Daftar masuk terkini</h3><a href="/admin/peserta?event=<?= (int) $selected ?>&status=attended" class="btn btn-ghost btn-sm">Semua</a></div>
      <div id="recent"><div class="card-body muted small">Belum ada.</div></div>
    </div>
  </div>
</div>

<?php
$eventId = (int) $selected;
$scripts = <<<HTML
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
(function () {
  const EVENT = {$eventId};
  const csrf = document.querySelector('meta[name="csrf-token"]').content;
  const el = id => document.getElementById(id);
  const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  let scanner = null, running = false, busy = false, last = { code: null, at: 0 };

  function beep(ok) {
    if (!el('sound-on').checked) return;
    try {
      const ctx = new (window.AudioContext || window.webkitAudioContext)();
      const o = ctx.createOscillator(), g = ctx.createGain();
      o.connect(g); g.connect(ctx.destination);
      o.frequency.value = ok ? 880 : 220; o.type = ok ? 'sine' : 'square';
      g.gain.setValueAtTime(.15, ctx.currentTime); g.gain.exponentialRampToValueAtTime(.001, ctx.currentTime + (ok ? .18 : .4));
      o.start(); o.stop(ctx.currentTime + (ok ? .18 : .4));
    } catch (e) {}
    if (navigator.vibrate) navigator.vibrate(ok ? 80 : [60, 60, 60]);
  }

  function show(res) {
    const box = el('result');
    box.className = 'scan-result ' + res.state;
    void box.offsetWidth; box.classList.add('flash');
    const icon = { ok: 'check', warn: 'repeat', err: 'x' }[res.state];
    box.querySelector('.sr-ico').innerHTML = '<i data-lucide="' + icon + '"></i>';
    el('result-title').textContent = { ok: 'Berjaya!', warn: 'Sudah hadir', err: 'Tidak sah' }[res.state];
    el('result-msg').textContent = res.message;
    const p = res.participant;
    el('result-person').classList.toggle('hidden', !p);
    if (p) { el('rp-name').textContent = p.name; el('rp-agency').textContent = p.agency; el('rp-ref').textContent = p.ref; el('rp-role').textContent = p.org || ''; }
    Hadirin.icons();
  }

  async function submit(code) {
    code = (code || '').trim();
    if (!code || busy) return;
    if (code === last.code && Date.now() - last.at < 4000) return; // debounce same code
    last = { code, at: Date.now() };
    busy = true;
    try {
      const body = new URLSearchParams({ code, event: EVENT, _csrf: csrf });
      const r = await fetch('/admin/imbas', { method: 'POST', body, headers: { 'Accept': 'application/json' } });
      const res = await r.json();
      show(res); beep(res.state === 'ok');
      refresh();
    } catch (e) {
      show({ state: 'err', message: 'Ralat rangkaian. Cuba lagi.' }); beep(false);
    } finally { busy = false; }
  }

  async function refresh() {
    if (!EVENT) return;
    const r = await fetch('/admin/imbas/statistik?event=' + EVENT);
    const { stats, recent } = await r.json();
    const att = +stats.attended || 0, conf = +stats.confirmed || 0, pct = conf ? Math.round(att / conf * 100) : 0;
    el('c-att').textContent = att; el('c-conf').textContent = conf; el('c-pct').textContent = pct + '%'; el('c-bar').style.width = pct + '%';
    el('recent').innerHTML = recent.length ? recent.map(p =>
      '<div class="list-row"><div class="avatar sm">' + esc(p.full_name.split(' ').slice(0, 2).map(w => w[0]).join('')) + '</div>' +
      '<div class="grow"><strong>' + esc(p.full_name) + '</strong><small>' + esc(p.agency) + '</small></div><span class="xs muted nowrap">' + esc(p.time) + '</span></div>'
    ).join('') : '<div class="card-body muted small">Belum ada.</div>';
  }

  el('cam-toggle').addEventListener('click', async () => {
    const btn = el('cam-toggle');
    if (running) {
      await scanner.stop(); running = false;
      btn.querySelector('span').textContent = 'Mula';
      return;
    }
    el('reader').innerHTML = '';
    scanner = scanner || new Html5Qrcode('reader');
    try {
      await scanner.start({ facingMode: 'environment' }, { fps: 10, qrbox: (w, h) => { const s = Math.floor(Math.min(w, h) * 0.7); return { width: s, height: s }; } }, submit, () => {});
      running = true; btn.querySelector('span').textContent = 'Henti';
    } catch (e) {
      el('reader').innerHTML = '<div class="empty" style="color:#fda4af;padding:80px 20px"><p>Kamera tidak dapat diakses. Benarkan akses kamera atau gunakan input manual.<br><small>Nota: kamera memerlukan HTTPS atau localhost.</small></p></div>';
    }
  });

  el('manual-form').addEventListener('submit', e => { e.preventDefault(); submit(el('manual-code').value); el('manual-code').value = ''; });
  refresh(); setInterval(refresh, 15000);
})();
</script>
HTML;
?>
