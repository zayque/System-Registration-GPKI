<div class="lookup-wrap">
  <div class="container center" style="max-width:520px">
    <div class="icon-hero"><i data-lucide="<?= ($code ?? 404) == 404 ? 'map-pinned' : 'alert-octagon' ?>"></i></div>
    <div class="mono muted" style="font-size:.9rem;font-weight:700">RALAT <?= (int) ($code ?? 404) ?></div>
    <h1 style="font-size:2rem;margin:8px 0 10px"><?= ($code ?? 404) == 404 ? 'Halaman tidak dijumpai' : 'Ada sesuatu yang tidak kena' ?></h1>
    <p class="muted"><?= e($message ?? '') ?></p>
    <div class="row" style="justify-content:center;margin-top:20px">
      <a href="/" class="btn btn-primary"><i data-lucide="home"></i> Ke halaman utama</a>
      <a href="javascript:history.back()" class="btn">Kembali</a>
    </div>
  </div>
</div>
