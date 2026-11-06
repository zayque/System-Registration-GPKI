<?php
declare(strict_types=1);

namespace App;

use FPDF;

/** Printable e-ticket (PDF) with QR code. */
final class Ticket
{
    private static function t(string $s): string
    {
        return (string) iconv('UTF-8', 'windows-1252//TRANSLIT', $s);
    }

    public static function pdf(array $reg): string
    {
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetTitle(self::t('Tiket ' . $reg['ref_code']));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $x = 20; $y = 20; $w = 170; $h = 120;
        [$r, $g, $b] = sscanf(type_colors($reg['event_type'])[0], '#%02x%02x%02x');

        // Card background + header band
        $pdf->SetDrawColor(226, 232, 240);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect($x, $y, $w, $h, 'DF');
        $pdf->SetFillColor($r, $g, $b);
        $pdf->Rect($x, $y, $w, 26, 'F');

        // Brand mark: white tile with the app initial
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect($x + 7, $y + 6, 14, 14, 'F');
        $pdf->SetTextColor($r, $g, $b);
        $pdf->SetFont('Helvetica', 'B', 13);
        $pdf->SetXY($x + 7, $y + 6);
        $pdf->Cell(14, 14, self::t(mb_strtoupper(mb_substr((string) env('APP_NAME', 'Hadirin'), 0, 1))), 0, 0, 'C');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY($x + 26, $y + 6);
        $pdf->Cell(100, 5, self::t('E-TIKET ' . strtoupper(type_label($reg['event_type']))), 0, 2);
        $pdf->SetFont('Helvetica', 'B', 13);
        $pdf->SetX($x + 26);
        $pdf->MultiCell(105, 6, self::t($reg['event_title']));

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY($x + $w - 46, $y + 7);
        $pdf->Cell(40, 4, self::t('No. Rujukan'), 0, 2, 'R');
        $pdf->SetFont('Courier', 'B', 14);
        $pdf->Cell(40, 7, $reg['ref_code'], 0, 0, 'R');

        // Details
        $rows = [
            ['Nama Peserta', $reg['full_name']],
            ['No. MyKad', mask_ic($reg['ic_no'])],
            ['Organisasi', $reg['agency']],
            ['Tarikh', tarikh_bm($reg['event_date']) . ' (' . hari_bm($reg['event_date']) . ')'],
            ['Masa', masa_bm($reg['start_time']) . ' - ' . masa_bm($reg['end_time'])],
            ['Tempat', trim($reg['venue_name'] . ($reg['venue_address'] ? ', ' . $reg['venue_address'] : ''))],
        ];
        $cy = $y + 34;
        foreach ($rows as [$label, $value]) {
            $pdf->SetXY($x + 8, $cy);
            $pdf->SetTextColor(100, 116, 139);
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(100, 4, self::t(strtoupper($label)), 0, 2);
            $pdf->SetTextColor(15, 23, 42);
            $pdf->SetFont('Helvetica', 'B', 10.5);
            $pdf->MultiCell(105, 5, self::t($value));
            $cy = $pdf->GetY() + 2.5;
        }

        // QR
        $tmp = tempnam(sys_get_temp_dir(), 'qr') . '.png';
        file_put_contents($tmp, Qr::png($reg['token'], 10));
        $pdf->Image($tmp, $x + $w - 56, $y + 36, 48, 48);
        @unlink($tmp);
        $pdf->SetTextColor(100, 116, 139);
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->SetXY($x + $w - 60, $y + 86);
        $pdf->MultiCell(56, 3.6, self::t('Imbas kod ini di kaunter pendaftaran pada hari acara.'), 0, 'C');

        // Status chip
        [$label] = STATUS_LABELS[$reg['status']] ?? [$reg['status']];
        $pdf->SetXY($x + $w - 56, $y + 96);
        $pdf->SetFillColor(240, 253, 244);
        $pdf->SetTextColor(21, 128, 61);
        if ($reg['status'] === 'waitlisted') { $pdf->SetFillColor(255, 251, 235); $pdf->SetTextColor(180, 83, 9); }
        if ($reg['status'] === 'cancelled') { $pdf->SetFillColor(241, 245, 249); $pdf->SetTextColor(71, 85, 105); }
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->Cell(48, 8, self::t(strtoupper($label)), 0, 0, 'C', true);

        // Footer
        $pdf->SetDrawColor(203, 213, 225);
        $pdf->Line($x + 8, $y + $h - 12, $x + $w - 8, $y + $h - 12);
        $pdf->SetXY($x + 8, $y + $h - 10);
        $pdf->SetTextColor(100, 116, 139);
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->Cell($w - 16, 4, self::t(env('APP_NAME', 'Hadirin') . '  •  Dijana pada ' . date('d/m/Y g:i A') . '  •  Sila bawa tiket ini (cetak atau di telefon).'), 0, 0, 'C');

        return $pdf->Output('S');
    }
}
