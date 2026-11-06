<?php
/** Brand lockup. Name comes from APP_NAME in .env. Options: $href, $sub, $light (bool). */
$brandName = (string) env('APP_NAME', 'Hadirin');
?>
<a href="<?= e($href ?? '/') ?>" class="brand" <?= !empty($light) ? 'style="color:#fff"' : '' ?>>
  <span class="brand-mark" <?= !empty($light) ? 'style="background:rgba(255,255,255,.15)"' : '' ?>><i data-lucide="ticket-check"></i></span>
  <span class="brand-text"><?= e($brandName) ?><small <?= !empty($light) ? 'style="color:rgba(255,255,255,.7)"' : '' ?>><?= e($sub ?? 'Pendaftaran Acara & Kehadiran') ?></small></span>
</a>
