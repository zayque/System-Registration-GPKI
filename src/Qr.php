<?php
declare(strict_types=1);

namespace App;

use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

final class Qr
{
    /** Payload the check-in scanner understands. */
    public static function payload(string $token): string
    {
        return 'HDR:' . $token;
    }

    /** Raw PNG bytes. */
    public static function png(string $token, int $scale = 10): string
    {
        $options = new QROptions([
            'outputType'    => QROutputInterface::GDIMAGE_PNG,
            'outputBase64'  => false,
            'eccLevel'      => EccLevel::M,
            'scale'         => $scale,
            'quietzoneSize' => 2,
        ]);
        return (new QRCode($options))->render(self::payload($token));
    }
}
