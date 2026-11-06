<?php
declare(strict_types=1);

namespace App;

final class Ics
{
    public static function forRegistration(array $reg): string
    {
        $tz = 'Asia/Kuala_Lumpur';
        $d = str_replace('-', '', $reg['event_date']);
        $start = $d . 'T' . str_replace(':', '', substr($reg['start_time'], 0, 5)) . '00';
        $end = $d . 'T' . str_replace(':', '', substr($reg['end_time'], 0, 5)) . '00';
        $esc = fn(string $s) => addcslashes($s, ",;\\");
        $loc = trim($reg['venue_name'] . ($reg['venue_address'] ? ', ' . $reg['venue_address'] : ''));
        $lines = [
            'BEGIN:VCALENDAR', 'VERSION:2.0', 'PRODID:-//Hadirin//Pendaftaran Acara//MS', 'CALSCALE:GREGORIAN', 'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:' . $reg['token'] . '@hadirin',
            'DTSTAMP:' . gmdate('Ymd\THis\Z'),
            "DTSTART;TZID={$tz}:{$start}",
            "DTEND;TZID={$tz}:{$end}",
            'SUMMARY:' . $esc($reg['event_title']),
            'LOCATION:' . $esc($loc),
            'DESCRIPTION:' . $esc('No. Rujukan: ' . $reg['ref_code'] . ' — Tiket: ' . base_url() . '/tiket/' . $reg['token']),
            'BEGIN:VALARM', 'TRIGGER:-P1D', 'ACTION:DISPLAY', 'DESCRIPTION:Peringatan: ' . $esc($reg['event_title']), 'END:VALARM',
            'END:VEVENT', 'END:VCALENDAR',
        ];
        return implode("\r\n", $lines) . "\r\n";
    }
}
