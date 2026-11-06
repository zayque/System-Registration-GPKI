/* Hadirin — shared UI behaviour */
(function () {
  'use strict';
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));

  const icons = () => window.lucide && window.lucide.createIcons();
  window.Hadirin = { icons };

  /* ---------- Theme ---------- */
  function setTheme(t) {
    document.documentElement.setAttribute('data-theme', t);
    try { localStorage.setItem('hadirin-theme', t); } catch (e) {}
    document.dispatchEvent(new CustomEvent('themechange', { detail: t }));
  }
  $$('[data-theme-toggle]').forEach(b => b.addEventListener('click', () => {
    setTheme(document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
  }));

  /* ---------- Nav / sidebar ---------- */
  $$('[data-nav-toggle]').forEach(b => b.addEventListener('click', () => $('.nav')?.classList.toggle('open')));
  const sidebar = $('.sidebar'), backdrop = $('.sidebar-backdrop');
  $$('[data-sidebar-toggle]').forEach(b => b.addEventListener('click', () => {
    sidebar?.classList.toggle('open'); backdrop?.classList.toggle('open');
  }));
  backdrop?.addEventListener('click', () => { sidebar.classList.remove('open'); backdrop.classList.remove('open'); });

  /* ---------- Toasts ---------- */
  const toastIcons = { success: 'check-circle-2', error: 'alert-circle', info: 'info', warning: 'alert-triangle' };
  function toast(type, message, timeout = 5000) {
    let stack = $('.toast-stack');
    if (!stack) { stack = document.createElement('div'); stack.className = 'toast-stack'; document.body.appendChild(stack); }
    const el = document.createElement('div');
    el.className = 'toast toast-' + type;
    el.setAttribute('role', 'status');
    el.innerHTML = `<div class="t-ico"><i data-lucide="${toastIcons[type] || 'info'}"></i></div><div class="t-msg"></div><button class="t-close" aria-label="Tutup"><i data-lucide="x"></i></button>`;
    el.querySelector('.t-msg').textContent = message;
    stack.appendChild(el);
    icons();
    const close = () => { el.classList.add('leaving'); setTimeout(() => el.remove(), 250); };
    el.querySelector('.t-close').addEventListener('click', close);
    if (timeout) setTimeout(close, timeout);
  }
  window.Hadirin.toast = toast;
  (window.__flashes || []).forEach(f => toast(f.type, f.message));

  /* ---------- Modals ---------- */
  $$('[data-modal-open]').forEach(b => b.addEventListener('click', e => {
    e.preventDefault();
    $(b.dataset.modalOpen)?.classList.add('open');
  }));
  $$('.modal').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m || e.target.closest('[data-modal-close]')) m.classList.remove('open'); });
  });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') $$('.modal.open').forEach(m => m.classList.remove('open')); });

  /* ---------- Confirm dialogs ---------- */
  const confirmModal = $('#confirm-modal');
  let pendingForm = null;
  document.addEventListener('submit', e => {
    const f = e.target;
    if (!f.dataset.confirm || f.dataset.confirmed) return;
    e.preventDefault();
    if (!confirmModal) { if (confirm(f.dataset.confirm)) { f.dataset.confirmed = 1; f.submit(); } return; }
    pendingForm = f;
    $('#confirm-text', confirmModal).textContent = f.dataset.confirm;
    const ok = $('#confirm-ok', confirmModal);
    ok.className = 'btn ' + (f.dataset.confirmTone === 'primary' ? 'btn-primary' : 'btn-danger');
    ok.textContent = f.dataset.confirmLabel || 'Ya, teruskan';
    confirmModal.classList.add('open');
  }, true);
  $('#confirm-ok')?.addEventListener('click', () => {
    if (pendingForm) { pendingForm.dataset.confirmed = 1; pendingForm.requestSubmit ? pendingForm.requestSubmit() : pendingForm.submit(); }
    confirmModal.classList.remove('open');
  });

  /* ---------- Dropdowns ---------- */
  document.addEventListener('click', e => {
    const trigger = e.target.closest('[data-dropdown]');
    $$('.dropdown.open').forEach(d => { if (!trigger || d !== trigger.parentElement) d.classList.remove('open'); });
    if (trigger) { e.preventDefault(); trigger.parentElement.classList.toggle('open'); }
  });

  /* ---------- Copy ---------- */
  $$('[data-copy]').forEach(b => b.addEventListener('click', async () => {
    try { await navigator.clipboard.writeText(b.dataset.copy); toast('success', 'Disalin ke papan klip.'); } catch (e) {}
  }));

  /* ---------- Auto submit (filters) ---------- */
  $$('[data-autosubmit]').forEach(el => el.addEventListener('change', () => el.form.submit()));

  /* ---------- Password reveal ---------- */
  $$('[data-reveal]').forEach(b => b.addEventListener('click', () => {
    const input = $(b.dataset.reveal);
    input.type = input.type === 'password' ? 'text' : 'password';
    b.innerHTML = `<i data-lucide="${input.type === 'password' ? 'eye' : 'eye-off'}"></i>`;
    icons();
  }));

  /* ---------- Countdown ---------- */
  $$('[data-countdown]').forEach(el => {
    const target = new Date(el.dataset.countdown).getTime();
    const parts = { d: $('[data-d]', el), h: $('[data-h]', el), m: $('[data-m]', el), s: $('[data-s]', el) };
    const tick = () => {
      let diff = Math.max(0, target - Date.now()) / 1000;
      const d = Math.floor(diff / 86400); diff -= d * 86400;
      const h = Math.floor(diff / 3600); diff -= h * 3600;
      const m = Math.floor(diff / 60); const s = Math.floor(diff - m * 60);
      parts.d.textContent = d; parts.h.textContent = String(h).padStart(2, '0');
      parts.m.textContent = String(m).padStart(2, '0'); parts.s.textContent = String(s).padStart(2, '0');
    };
    tick(); setInterval(tick, 1000);
  });

  /* ---------- Animated progress bars ---------- */
  requestAnimationFrame(() => $$('.progress > span[data-w]').forEach(s => { s.style.width = s.dataset.w + '%'; }));

  /* ---------- Count-up numbers ---------- */
  $$('[data-countup]').forEach(el => {
    const end = parseInt(el.dataset.countup, 10) || 0;
    if (end === 0 || matchMedia('(prefers-reduced-motion: reduce)').matches) { el.textContent = end.toLocaleString('ms-MY'); return; }
    const start = performance.now(), dur = 900;
    const step = now => {
      const p = Math.min(1, (now - start) / dur);
      el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3))).toLocaleString('ms-MY');
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  });

  /* ---------- Registration form ---------- */
  const regForm = $('#reg-form');
  if (regForm) {
    const digitsOnly = el => el.addEventListener('input', () => { el.value = el.value.replace(/\D/g, ''); });
    $$('[data-digits]', regForm).forEach(digitsOnly);

    const rules = {
      full_name: v => v.trim().length >= 3 || 'Sila masukkan nama penuh.',
      email: v => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v) || 'Format e-mel tidak sah.',
      ic_no: v => /^\d{12}$/.test(v) || 'No. MyKad mestilah 12 digit.',
      mobile_no: v => /^01\d{8,9}$/.test(v) || 'Contoh: 0123456789',
      office_no: v => v === '' || /^\d{9,12}$/.test(v) || 'No. telefon pejabat tidak sah.',
      agency: v => v.trim() !== '' || 'Wajib diisi.',
      grade: v => v.trim() !== '' || 'Wajib diisi.',
      state: v => v !== '' || 'Sila pilih negeri.',
    };
    const showError = (field, msg) => {
      const wrap = field.closest('.field');
      if (!wrap) return;
      let err = $('.error-text', wrap);
      wrap.classList.toggle('has-error', !!msg);
      wrap.classList.toggle('is-valid', !msg && field.value !== '');
      if (msg) {
        if (!err) { err = document.createElement('div'); err.className = 'error-text'; wrap.appendChild(err); }
        err.textContent = msg;
      } else if (err) err.remove();
    };
    const validateField = f => {
      const rule = rules[f.name];
      if (!rule) return true;
      const r = rule(f.value);
      showError(f, r === true ? null : r);
      return r === true;
    };
    Object.keys(rules).forEach(n => {
      const f = regForm.elements[n];
      if (!f) return;
      f.addEventListener('blur', () => validateField(f));
      f.addEventListener('input', () => { if (f.closest('.field').classList.contains('has-error')) validateField(f); updateProgress(); });
      f.addEventListener('change', updateProgress);
    });
    regForm.addEventListener('change', updateProgress);

    function questionAnswered(q) {
      const t = q.dataset.type;
      if (t === 'checkbox' || t === 'radio') return !!$('input:checked', q);
      const f = $('input, textarea, select', q);
      return !!f && f.value.trim() !== '';
    }
    regForm.addEventListener('change', e => {
      const q = e.target.closest('[data-question]');
      if (q && q.classList.contains('has-error') && questionAnswered(q)) { q.classList.remove('has-error'); $('[data-q-error]', q)?.classList.add('hidden'); }
    });

    function updateProgress() {
      const required = ['full_name', 'email', 'ic_no', 'mobile_no', 'agency', 'grade', 'state'];
      let done = required.filter(n => regForm.elements[n] && rules[n](regForm.elements[n].value) === true).length;
      const questions = $$('[data-question][data-required]', regForm);
      done += questions.filter(questionAnswered).length;
      if ($('input[name="consent"]', regForm)?.checked) done++;
      const pct = Math.round(done / (required.length + questions.length + 1) * 100);
      const bar = $('.form-progress span'); if (bar) bar.style.width = pct + '%';
      const lbl = $('[data-progress-label]'); if (lbl) lbl.textContent = pct + '%';
    }
    updateProgress();

    // IC → hint showing date of birth
    const ic = regForm.elements.ic_no, icHint = $('[data-ic-hint]');
    ic?.addEventListener('input', () => {
      if (!icHint) return;
      const v = ic.value;
      if (v.length >= 6) {
        const yy = +v.slice(0, 2), mm = +v.slice(2, 4), dd = +v.slice(4, 6);
        const yr = yy > (new Date().getFullYear() % 100) ? 1900 + yy : 2000 + yy;
        const bulan = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogo','Sep','Okt','Nov','Dis'][mm - 1];
        icHint.textContent = bulan && dd >= 1 && dd <= 31 ? `Tarikh lahir: ${dd} ${bulan} ${yr}` : 'Format: 12 digit tanpa sengkang';
      } else icHint.textContent = 'Format: 12 digit tanpa sengkang';
    });

    regForm.addEventListener('submit', e => {
      let ok = true, first = null;
      Object.keys(rules).forEach(n => { const f = regForm.elements[n]; if (f && !validateField(f)) { ok = false; first = first || f; } });
      $$('[data-question][data-required]', regForm).forEach(q => {
        const answered = questionAnswered(q);
        q.classList.toggle('has-error', !answered);
        $('[data-q-error]', q)?.classList.toggle('hidden', answered);
        if (!answered) { ok = false; first = first || q; }
      });
      const consent = regForm.elements.consent;
      $('[data-consent-error]')?.classList.toggle('hidden', consent.checked);
      if (!consent.checked) { ok = false; first = first || consent; }
      if (!ok) {
        e.preventDefault();
        first?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        first?.focus?.({ preventScroll: true });
        toast('error', 'Sila semak semula maklumat yang bertanda merah.');
        return;
      }
      const btn = $('button[type="submit"]', regForm);
      btn.disabled = true;
      btn.innerHTML = '<i data-lucide="loader-2" class="spin"></i> Menghantar…';
      icons();
    });

  }

  icons();
})();
