<?php $next = $events[0] ?? null; ?>
<section class="hero">
  <div class="container hero-grid">
    <div class="fade-in">
      <span class="eyebrow"><b>BAHARU</b> Tiket kod QR &amp; daftar masuk pantas</span>
      <h1>Daftar acara anda dalam 2 minit.</h1>
      <p class="lead">Latihan, seminar, bengkel atau persidangan: pilih acara, isi borang, dan terima e-tiket berkod QR terus ke e-mel anda. Tunjukkan di kaunter pada hari acara, dan siap.</p>
      <div class="hero-actions">
        <a href="/acara" class="btn btn-white btn-lg"><i data-lucide="calendar-plus"></i> Lihat Acara</a>
        <a href="/semak" class="btn btn-glass btn-lg"><i data-lucide="ticket"></i> Semak Tiket Saya</a>
      </div>
      <div class="hero-stats">
        <div><strong data-countup="<?= (int) $stats['participants'] ?>">0</strong><span>Peserta berdaftar</span></div>
        <div><strong data-countup="<?= (int) $stats['events'] ?>">0</strong><span>Acara dianjurkan</span></div>
        <div><strong data-countup="<?= (int) $stats['agencies'] ?>">0</strong><span>Agensi terlibat</span></div>
      </div>
    </div>
    <div class="hero-visual" aria-hidden="true">
      <div class="float-card fc-ticket">
        <div class="row-between" style="margin-bottom:12px">
          <span class="badge badge-plain tag-<?= e($next['type'] ?? 'latihan') ?>">E-Tiket</span>
          <span class="mono xs" style="color:#64748b"><?= e((EVENT_TYPES[$next['type'] ?? 'latihan'][1] ?? 'EV')) ?>-7F3K9Q</span>
        </div>
        <div class="row" style="gap:14px;flex-wrap:nowrap;align-items:flex-start">
          <div class="fc-qr"></div>
          <div>
            <div style="font-weight:800;font-size:.95rem;line-height:1.3;color:#0f172a"><?= e($next['title'] ?? 'Bengkel Kepimpinan 2026') ?></div>
            <div class="xs" style="color:#64748b;margin-top:6px"><?= e($next ? tarikh_bm($next['event_date']) : '') ?></div>
          </div>
        </div>
      </div>
      <div class="float-card fc-cap">
        <div class="xs" style="color:#64748b;font-weight:700">Kapasiti</div>
        <div style="font-weight:800;font-size:1.4rem;color:#0f172a">42 / 50</div>
        <div class="progress" style="background:#eef2ff"><span style="width:84%"></span></div>
      </div>
      <div class="float-card fc-ok">
        <div class="ok-ico"><i data-lucide="check"></i></div>
        <div><div style="font-weight:800;color:#0f172a">Daftar masuk berjaya</div><div class="xs" style="color:#64748b">9:12 pagi · Kaunter A</div></div>
      </div>
    </div>
  </div>
</section>

<section class="overlap">
  <div class="container">
    <div class="card" style="padding:8px">
      <div class="grid grid-4" style="gap:0">
        <?php foreach ([
          ['shield-check', 'Selamat', 'Data dilindungi & disulitkan'],
          ['qr-code', 'Tiket QR', 'Imbas di kaunter, tiada beratur'],
          ['mail-check', 'Pengesahan E-mel', 'Terima tiket & jemputan kalendar'],
          ['list-checks', 'Senarai Menunggu', 'Auto-sahkan bila ada kekosongan'],
        ] as [$ico, $t, $d]): ?>
        <div class="row" style="padding:16px 18px;flex-wrap:nowrap">
          <div class="info-item"><div class="ii-ico"><i data-lucide="<?= $ico ?>"></i></div><div><strong><?= $t ?></strong><div class="muted small"><?= $d ?></div></div></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head">
      <div>
        <span class="kicker">Akan Datang</span>
        <h2>Acara yang dibuka untuk pendaftaran</h2>
        <p>Tempat adalah terhad dan diberikan mengikut siapa cepat dia dapat.</p>
      </div>
      <a href="/acara" class="btn">Semua acara <i data-lucide="arrow-right"></i></a>
    </div>
    <?php if ($events): ?>
      <div class="grid grid-3">
        <?php foreach ($events as $e) partial('event-card', ['e' => $e]); ?>
      </div>
    <?php else: ?>
      <div class="card empty">
        <div class="empty-ico"><i data-lucide="calendar-x"></i></div>
        <h3>Tiada acara buat masa ini</h3>
        <p>Sila kembali semula kemudian. Acara baharu akan diumumkan di sini.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="section" style="background:var(--surface);border-block:1px solid var(--border)">
  <div class="container">
    <div class="section-head" style="justify-content:center;text-align:center">
      <div><span class="kicker">Cara Ia Berfungsi</span><h2>Empat langkah mudah</h2></div>
    </div>
    <div class="steps">
      <div class="card step"><div class="s-ico"><i data-lucide="search"></i></div><h3>Pilih acara</h3><p>Lihat tarikh, lokasi dan baki tempat bagi setiap latihan atau seminar.</p></div>
      <div class="card step"><div class="s-ico"><i data-lucide="file-pen-line"></i></div><h3>Isi borang</h3><p>Borang pintar dengan semakan automatik. Tiada lagi ralat format.</p></div>
      <div class="card step"><div class="s-ico"><i data-lucide="ticket"></i></div><h3>Terima e-tiket</h3><p>Tiket PDF berkod QR dihantar ke e-mel, siap dengan jemputan kalendar.</p></div>
      <div class="card step"><div class="s-ico"><i data-lucide="scan-line"></i></div><h3>Imbas &amp; masuk</h3><p>Tunjuk kod QR di kaunter. Kehadiran direkod secara automatik.</p></div>
    </div>
  </div>
</section>

<section class="section" id="soalan">
  <div class="container container-sm">
    <div class="center" style="margin-bottom:24px"><span class="kicker">Soalan Lazim</span><h2>Ada soalan?</h2></div>
    <div class="card"><div class="card-body faq">
      <details open><summary>Bagaimana saya tahu pendaftaran saya berjaya?</summary><p>Anda akan dibawa ke halaman e-tiket sejurus selepas mendaftar dan menerima e-mel pengesahan bersama kod QR. Anda juga boleh menyemak bila-bila masa melalui menu <a href="/semak">Semak Pendaftaran</a> menggunakan e-mel dan No. MyKad.</p></details>
      <details><summary>Bagaimana jika kuota telah penuh?</summary><p>Pendaftaran anda akan dimasukkan ke dalam senarai menunggu. Jika ada peserta yang membatalkan, sistem akan mengesahkan tempat anda secara automatik mengikut giliran dan menghantar e-mel makluman.</p></details>
      <details><summary>Saya tidak dapat hadir. Apa perlu saya buat?</summary><p>Buka tiket anda dan klik "Batal Pendaftaran" atau "Maklum Tidak Hadir". Tempat anda akan diberikan kepada peserta dalam senarai menunggu.</p></details>
      <details><summary>Saya tidak menerima e-mel pengesahan.</summary><p>Semak folder spam/junk. Anda juga boleh memuat turun e-tiket PDF terus dari halaman Semak Pendaftaran.</p></details>
      <details><summary>Perlukah saya mencetak tiket?</summary><p>Tidak wajib. Kod QR di telefon bimbit sudah memadai untuk diimbas di kaunter pendaftaran.</p></details>
    </div></div>
  </div>
</section>

<section class="section-tight">
  <div class="container">
    <div class="cta-band">
      <div><h2>Sudah mendaftar?</h2><p>Lihat e-tiket, muat turun PDF, atau batalkan pendaftaran anda.</p></div>
      <a href="/semak" class="btn btn-white btn-lg"><i data-lucide="ticket"></i> Semak Pendaftaran</a>
    </div>
  </div>
</section>
