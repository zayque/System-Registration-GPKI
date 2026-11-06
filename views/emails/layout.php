<?php
/** @var string $bodyText  @var string $subject  @var array $registration */
$reg = $registration;
[$c1, $c2] = type_colors($reg['event_type'] ?? 'latihan');
$link = base_url() . '/tiket/' . $reg['token'];
$paras = array_filter(preg_split("/\R{2,}/", trim($bodyText)));
?>
<!doctype html>
<html lang="ms"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"><title><?= e($subject) ?></title></head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#0f172a">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:32px 12px">
  <tr><td align="center">
    <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 10px 30px rgba(15,23,42,.08)">
      <tr><td style="background:<?= $c1 ?>;background-image:linear-gradient(135deg,<?= $c1 ?>,<?= $c2 ?>);padding:28px 32px;color:#fff">
        <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;opacity:.85;font-weight:700"><?= e(env('APP_NAME', 'Hadirin')) ?> · <?= e(type_label($reg['event_type'] ?? 'latihan')) ?></div>
        <div style="font-size:20px;font-weight:800;margin-top:6px;line-height:1.3"><?= e($reg['event_title']) ?></div>
      </td></tr>
      <tr><td style="padding:28px 32px 8px;font-size:15px;line-height:1.65;color:#334155">
        <?php foreach ($paras as $p): ?>
          <p style="margin:0 0 16px"><?= nl2br(e($p)) ?></p>
        <?php endforeach; ?>
      </td></tr>
      <tr><td style="padding:0 32px 24px">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:14px">
          <tr><td style="padding:16px 20px">
            <div style="font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:1px;font-weight:700">No. Rujukan</div>
            <div style="font-family:Consolas,Menlo,monospace;font-size:20px;font-weight:700;letter-spacing:1px;color:#0f172a"><?= e($reg['ref_code']) ?></div>
          </td></tr>
        </table>
      </td></tr>
      <tr><td align="center" style="padding:0 32px 32px">
        <a href="<?= e($link) ?>" style="display:inline-block;background:<?= $c1 ?>;color:#ffffff;text-decoration:none;font-weight:700;padding:14px 28px;border-radius:12px;font-size:15px">Lihat E-Tiket Saya</a>
      </td></tr>
      <tr><td style="padding:18px 32px;background:#f8fafc;border-top:1px solid #e5e7eb;font-size:12px;color:#64748b;text-align:center">
        E-mel ini dijana secara automatik. Sila jangan balas e-mel ini.<br>© <?= date('Y') ?> <?= e(env('APP_NAME', 'Hadirin')) ?>
      </td></tr>
    </table>
  </td></tr>
</table>
</body></html>
