<?php
if ($pages <= 1) return;
$q = $_GET;
$link = function (int $p) use ($q) { $q['page'] = $p; return '?' . http_build_query($q); };
$window = array_unique(array_filter([1, $page - 1, $page, $page + 1, $pages], fn($p) => $p >= 1 && $p <= $pages));
sort($window);
?>
<nav class="pagination" aria-label="Halaman">
  <?php if ($page > 1): ?><a href="<?= e($link($page - 1)) ?>" aria-label="Sebelum"><i data-lucide="chevron-left"></i></a><?php endif; ?>
  <?php $prev = 0; foreach ($window as $p): ?>
    <?php if ($p - $prev > 1): ?><span>…</span><?php endif; ?>
    <?php if ($p === $page): ?><span class="current"><?= $p ?></span><?php else: ?><a href="<?= e($link($p)) ?>"><?= $p ?></a><?php endif; ?>
  <?php $prev = $p; endforeach; ?>
  <?php if ($page < $pages): ?><a href="<?= e($link($page + 1)) ?>" aria-label="Seterusnya"><i data-lucide="chevron-right"></i></a><?php endif; ?>
</nav>
