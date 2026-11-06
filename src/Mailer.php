<?php
declare(strict_types=1);

namespace App;

use PHPMailer\PHPMailer\PHPMailer;

final class Mailer
{
    public static function template(string $code): ?array
    {
        $st = db()->prepare('SELECT * FROM email_templates WHERE code = ?');
        $st->execute([$code]);
        return $st->fetch() ?: null;
    }

    public static function placeholders(array $reg): array
    {
        return [
            '{nama}'    => $reg['full_name'],
            '{acara}'   => $reg['event_title'],
            '{tarikh}'  => tarikh_bm($reg['event_date']),
            '{hari}'    => hari_bm($reg['event_date']),
            '{masa}'    => masa_bm($reg['start_time']) . ' - ' . masa_bm($reg['end_time']),
            '{tempat}'  => trim($reg['venue_name'] . ($reg['venue_address'] ? ', ' . $reg['venue_address'] : '')),
            '{rujukan}' => $reg['ref_code'],
            '{pautan}'  => base_url() . '/tiket/' . $reg['token'],
        ];
    }

    /** Render subject + HTML body for a template and registration. */
    public static function render(array $tpl, array $reg): array
    {
        $map = self::placeholders($reg);
        $subject = strtr($tpl['subject'], $map);
        $text = strtr($tpl['body'], $map);
        ob_start();
        $bodyText = $text;
        $registration = $reg;
        require dirname(__DIR__) . '/views/emails/layout.php';
        $html = ob_get_clean();
        return [$subject, $html, $text];
    }

    /** Send a templated email to a participant. Never throws; returns success flag. */
    public static function sendTemplate(string $code, array $reg, bool $attachQr = true): bool
    {
        $tpl = self::template($code);
        if (!$tpl) return false;
        [$subject, $html, $text] = self::render($tpl, $reg);
        $attachments = [];
        if ($attachQr && in_array($reg['status'], ['registered', 'attended'], true)) {
            $attachments[] = ['data' => Qr::png($reg['token'], 8), 'name' => 'QR-' . $reg['ref_code'] . '.png', 'type' => 'image/png'];
            $attachments[] = ['data' => Ics::forRegistration($reg), 'name' => 'acara.ics', 'type' => 'text/calendar'];
        }
        return self::send($reg['email'], $reg['full_name'], $subject, $html, $text, $attachments);
    }

    public static function send(string $to, string $name, string $subject, string $html, string $text, array $attachments = []): bool
    {
        try {
            $m = new PHPMailer(true);
            $m->isSMTP();
            $m->Host = (string) env('MAIL_HOST', 'mail');
            $m->Port = (int) env('MAIL_PORT', 1025);
            $user = (string) env('MAIL_USER', '');
            if ($user !== '') {
                $m->SMTPAuth = true;
                $m->Username = $user;
                $m->Password = (string) env('MAIL_PASS', '');
            }
            $enc = (string) env('MAIL_ENCRYPTION', '');
            if ($enc !== '') {
                $m->SMTPSecure = $enc;
            } else {
                $m->SMTPAutoTLS = false;
            }
            $m->CharSet = 'UTF-8';
            $m->setFrom((string) env('MAIL_FROM', 'noreply@example.gov.my'), (string) env('MAIL_FROM_NAME', 'Urusetia ' . env('APP_NAME', 'Hadirin')));
            $m->addAddress($to, $name);
            $m->isHTML(true);
            $m->Subject = $subject;
            $m->Body = $html;
            $m->AltBody = $text;
            foreach ($attachments as $a) {
                $m->addStringAttachment($a['data'], $a['name'], PHPMailer::ENCODING_BASE64, $a['type']);
            }
            $m->send();
            return true;
        } catch (\Throwable $ex) {
            error_log('[mail] ' . $ex->getMessage());
            return false;
        }
    }
}
