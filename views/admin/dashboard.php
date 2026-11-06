<?php use App\Events; ?>
<div class="page-title">
  <div>
    <h1>Selamat datang, <?= e(explode(' ', admin()['name'])[0]) ?> 👋</h1>
    <p>Ringkasan pendaftaran dan kehadiran setakat <?= e(datetime_bm(date('Y-m-d H:i:s'))) ?>.</p>
  </div>
  <div class="row">
    <a href="/admin/peserta/eksport" class="btn"><i data-lucide="file-down"></i> Eksport CSV</a>
    <a href="/admin/acara/baru" class="btn btn-primary"><i data-lucide="plus"></i> Acara Baharu</a>
  </div>
</div>

<div class="grid grid-4" style="margin-bottom:20px">
  <div class="card kpi"><div class="k-ico tone-indigo"><i data-lucide="users"></i></div><div><small>Jumlah Pendaftaran</small><strong data-countup="<?= (int) $kpi['total'] ?>">0</strong><div class="k-sub"><b>+<?= (int) $kpi['week'] ?></b> dalam 7 hari</div></div></div>
  <div class="card kpi"><div class="k-ico tone-green"><i data-lucide="user-check"></i></div><div><small>Hadir</small><strong data-countup="<?= (int) $kpi['attended'] ?>">0</strong><div class="k-sub">Kadar kehadiran: <?= $kpi['rate'] !== null ? $kpi['rate'] . '%' : '—' ?></div></div></div>
  <div class="card kpi"><div class="k-ico tone-amber"><i data-lucide="hourglass"></i></div><div><small>Senarai Menunggu</small><strong data-countup="<?= (int) $kpi['waitlisted'] ?>">0</strong><div class="k-sub"><?= (int) $kpi['cancelled'] ?> pembatalan</div></div></div>
  <div class="card kpi"><div class="k-ico tone-violet"><i data-lucide="calendar-check"></i></div><div><small>Acara Dibuka</small><strong data-countup="<?= (int) $kpi['upcoming'] ?>">0</strong><div class="k-sub">Akan datang</div></div></div>
</div>

<div class="grid" style="grid-template-columns:minmax(0,2fr) minmax(0,1fr);margin-bottom:20px">
  <div class="card">
    <div class="card-header"><h3>Pendaftaran 30 hari lepas</h3><span class="badge badge-blue badge-plain"><?= array_sum(array_column($daily, 'value')) ?> pendaftaran</span></div>
    <div class="card-body"><div class="chart-box"><canvas id="chart-daily" aria-label="Graf pendaftaran harian"></canvas></div></div>
  </div>
  <div class="card">
    <div class="card-header"><h3>Mengikut Zon</h3></div>
    <div class="card-body"><div class="chart-box"><canvas id="chart-zone" aria-label="Carta mengikut zon"></canvas></div></div>
  </div>
</div>

<div class="grid grid-2" style="margin-bottom:20px">
  <div class="card">
    <div class="card-header"><h3>Acara Akan Datang</h3><a href="/admin/acara" class="btn btn-ghost btn-sm">Semua <i data-lucide="arrow-right"></i></a></div>
    <?php if (!$events): ?>
      <div class="empty"><div class="empty-ico"><i data-lucide="calendar-plus"></i></div><p>Tiada acara akan datang.</p><a class="btn btn-primary btn-sm" href="/admin/acara/baru">Cipta acara</a></div>
    <?php endif; ?>
    <?php foreach (array_slice($events, 0, 5) as $e): $pct = Events::fillPercent($e); [$lbl, $tone] = Events::stateLabel($e); ?>
      <div class="list-row">
        <div class="date-chip" style="width:52px" aria-hidden="true">
          <div class="dc-m"><?= e(mb_substr(BULAN_BM[(int) date('n', strtotime($e['event_date']))], 0, 3)) ?></div>
          <div class="dc-d" style="font-size:1.25rem;padding-bottom:4px"><?= date('j', strtotime($e['event_date'])) ?></div>
        </div>
        <div class="grow">
          <strong><a href="/admin/peserta?event=<?= (int) $e['id'] ?>" style="color:inherit"><?= e($e['title']) ?></a></strong>
          <div class="row" style="gap:10px;margin-top:6px;flex-wrap:nowrap">
            <div class="progress <?= $pct >= 100 ? 'is-full' : ($pct >= 80 ? 'is-warn' : '') ?>" style="flex:1"><span data-w="<?= $pct ?>" style="width:0"></span></div>
            <small class="nowrap"><?= (int) $e['confirmed'] ?>/<?= (int) $e['capacity'] ?></small>
          </div>
        </div>
        <span class="badge badge-<?= $tone ?>"><?= e($lbl) ?></span>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="card">
    <div class="card-header"><h3>Pendaftaran Terkini</h3><a href="/admin/peserta" class="btn btn-ghost btn-sm">Semua <i data-lucide="arrow-right"></i></a></div>
    <?php if (!$recent): ?><div class="empty"><p>Belum ada pendaftaran.</p></div><?php endif; ?>
    <?php foreach ($recent as $r): ?>
      <a class="list-row" href="/admin/peserta/<?= (int) $r['id'] ?>" style="color:inherit">
        <div class="avatar sm"><?= e(initials($r['full_name'])) ?></div>
        <div class="grow"><strong><?= e($r['full_name']) ?></strong><small><?= e($r['agency']) ?> · <?= e(type_label($r['event_type'])) ?></small></div>
        <div class="right"><?= status_badge($r['status']) ?><div class="xs muted" style="margin-top:4px"><?= e(date('j/n g:i A', strtotime($r['created_at']))) ?></div></div>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<div class="grid grid-3">
  <div class="card"><div class="card-header"><h3>Mengikut Jenis Acara</h3></div><div class="card-body"><div class="chart-box sm"><canvas id="chart-type"></canvas></div></div></div>
  <div class="card"><div class="card-header"><h3>Organisasi Induk Teratas</h3></div><div class="card-body"><div class="chart-box sm"><canvas id="chart-ministry"></canvas></div></div></div>
  <div class="card"><div class="card-header"><h3>Organisasi Teratas</h3></div><div class="card-body"><div class="chart-box sm"><canvas id="chart-agency"></canvas></div></div></div>
</div>

<?php
$chartData = json_encode([
    'daily' => $daily, 'zone' => $byZone, 'type' => $byType,
    'ministry' => array_map(fn($r) => ['label' => ucwords(strtolower(str_replace(['KEMENTERIAN ', 'PENTADBIRAN KERAJAAN NEGERI '], ['', 'Negeri '], $r['label']))), 'value' => (int) $r['value']], $byMinistry),
    'agency' => array_map(fn($r) => ['label' => $r['label'], 'value' => (int) $r['value']], $byAgency),
], JSON_HEX_TAG | JSON_UNESCAPED_UNICODE);
$scripts = <<<HTML
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {
  const data = {$chartData};
  const charts = [];
  const css = n => getComputedStyle(document.documentElement).getPropertyValue(n).trim();
  const palette = ['#1e40af', '#3b82f6', '#0ea5e9', '#10b981', '#f59e0b', '#93c5fd', '#14b8a6', '#f43f5e'];
  function build() {
    charts.forEach(c => c.destroy()); charts.length = 0;
    Chart.defaults.font.family = '"Plus Jakarta Sans", system-ui, sans-serif';
    Chart.defaults.color = css('--muted');
    Chart.defaults.borderColor = css('--border');
    const grid = { color: css('--border'), drawTicks: false };
    const tooltip = { backgroundColor: '#0f172a', padding: 10, cornerRadius: 10, titleFont: { weight: '700' } };
    const ctx = document.getElementById('chart-daily').getContext('2d');
    const g = ctx.createLinearGradient(0, 0, 0, 280); g.addColorStop(0, 'rgba(37,99,235,.35)'); g.addColorStop(1, 'rgba(37,99,235,0)');
    charts.push(new Chart(ctx, { type: 'line',
      data: { labels: data.daily.map(d => d.label), datasets: [{ data: data.daily.map(d => d.value), borderColor: '#2563eb', backgroundColor: g, fill: true, tension: .4, borderWidth: 2.5, pointRadius: 0, pointHoverRadius: 5, pointBackgroundColor: '#2563eb' }] },
      options: { maintainAspectRatio: false, interaction: { intersect: false, mode: 'index' }, plugins: { legend: { display: false }, tooltip },
        scales: { x: { grid: { display: false }, ticks: { maxTicksLimit: 8 } }, y: { beginAtZero: true, grid, border: { display: false }, ticks: { precision: 0, padding: 8 } } } } }));
    const doughnut = (id, rows) => charts.push(new Chart(document.getElementById(id), { type: 'doughnut',
      data: { labels: rows.map(r => r.label), datasets: [{ data: rows.map(r => r.value), backgroundColor: palette, borderColor: css('--surface'), borderWidth: 3, hoverOffset: 6 }] },
      options: { maintainAspectRatio: false, cutout: '68%', plugins: { tooltip, legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 14, boxWidth: 8 } } } } }));
    const bars = (id, rows, horizontal) => charts.push(new Chart(document.getElementById(id), { type: 'bar',
      data: { labels: rows.map(r => r.label), datasets: [{ data: rows.map(r => r.value), backgroundColor: horizontal ? '#2563eb' : palette, borderRadius: 8, borderSkipped: false, maxBarThickness: 26 }] },
      options: { indexAxis: horizontal ? 'y' : 'x', maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip },
        scales: { x: { grid: horizontal ? grid : { display: false }, beginAtZero: true, ticks: { precision: 0 }, border: { display: false } },
                  y: { grid: horizontal ? { display: false } : grid, beginAtZero: true, ticks: { precision: 0, autoSkip: false, callback(v) { const l = this.getLabelForValue(v); return horizontal && l.length > 18 ? l.slice(0, 17) + '…' : l; } }, border: { display: false } } } } }));
    doughnut('chart-zone', data.zone);
    doughnut('chart-type', data.type);
    bars('chart-ministry', data.ministry, true);
    bars('chart-agency', data.agency, true);
  }
  build();
  document.addEventListener('themechange', build);
})();
</script>
HTML;
?>
<style>@media (max-width:1100px){.admin-content .grid[style*="2fr"]{grid-template-columns:1fr!important}}</style>
