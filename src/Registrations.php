<?php
declare(strict_types=1);

namespace App;

use RuntimeException;

final class Registrations
{
    /** Validate public form input against the event's questions. Returns [cleanData, errors]. */
    public static function validate(array $in, array $event): array
    {
        $d = [
            'full_name' => mb_strtoupper(trim((string) ($in['full_name'] ?? ''))),
            'email'     => strtolower(trim((string) ($in['email'] ?? ''))),
            'ic_no'     => preg_replace('/\D/', '', (string) ($in['ic_no'] ?? '')),
            'mobile_no' => preg_replace('/\D/', '', (string) ($in['mobile_no'] ?? '')),
            'office_no' => preg_replace('/\D/', '', (string) ($in['office_no'] ?? '')),
            'agency'    => trim((string) ($in['agency'] ?? '')),
            'ministry'  => trim((string) ($in['ministry'] ?? '')),
            'grade'     => mb_strtoupper(trim((string) ($in['grade'] ?? ''))),
            'state'     => trim((string) ($in['state'] ?? '')),
        ];
        $e = [];
        if (mb_strlen($d['full_name']) < 3) $e['full_name'] = 'Sila masukkan nama penuh.';
        if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $e['email'] = 'Format e-mel tidak sah (contoh: nama@agensi.gov.my).';
        if (!preg_match('/^\d{12}$/', $d['ic_no'])) $e['ic_no'] = 'No. MyKad mestilah 12 digit tanpa sengkang.';
        elseif (!self::icDateValid($d['ic_no'])) $e['ic_no'] = 'Tarikh lahir pada No. MyKad tidak sah.';
        if (!preg_match('/^01\d{8,9}$/', $d['mobile_no'])) $e['mobile_no'] = 'No. telefon bimbit tidak sah (contoh: 0123456789).';
        if ($d['office_no'] !== '' && !preg_match('/^\d{9,12}$/', $d['office_no'])) $e['office_no'] = 'No. telefon pejabat tidak sah.';
        if ($d['agency'] === '') $e['agency'] = 'Sila masukkan nama agensi.';
        if ($d['ministry'] !== '' && !in_array($d['ministry'], array_column(lookup_items('ministries'), 'name'), true)) $e['ministry'] = 'Sila pilih dari senarai.';
        if ($d['grade'] === '') $e['grade'] = 'Sila masukkan jawatan / gred.';
        $states = array_column(lookup_items('states'), null, 'name');
        if (!isset($states[$d['state']])) $e['state'] = 'Sila pilih negeri.';
        [$d['answers'], $qErrors] = self::validateAnswers(custom_fields($event), (array) ($in['q'] ?? []));
        $e += $qErrors;
        if (empty($in['consent'])) $e['consent'] = 'Sila bersetuju dengan pengisytiharan.';

        if (isset($states[$d['state']])) {
            $zones = array_column(lookup_items('zones'), 'name', 'id');
            $d['zone'] = $zones[$states[$d['state']]['zone_id']] ?? null;
        }
        return [$d, $e];
    }

    /** Validate answers to custom questions. Returns [answers, errors keyed "q.{key}"]. */
    public static function validateAnswers(array $fields, array $in, bool $enforceRequired = true): array
    {
        $answers = [];
        $errors = [];
        foreach ($fields as $f) {
            $key = (string) ($f['key'] ?? '');
            if ($key === '') continue;
            $raw = $in[$key] ?? null;
            $opts = array_map('strval', (array) ($f['options'] ?? []));
            switch ($f['type'] ?? 'text') {
                case 'checkbox':
                    $val = array_values(array_intersect(array_filter((array) $raw, 'is_string'), $opts));
                    $empty = !$val;
                    break;
                case 'select':
                case 'radio':
                    $val = in_array((string) $raw, $opts, true) ? (string) $raw : '';
                    $empty = $val === '';
                    break;
                default:
                    $val = mb_substr(trim((string) $raw), 0, ($f['type'] ?? '') === 'textarea' ? 2000 : 255);
                    $empty = $val === '';
            }
            if ($empty && !empty($f['required']) && $enforceRequired) {
                $errors['q.' . $key] = 'Soalan ini wajib dijawab.';
            }
            if (!$empty) $answers[$key] = $val;
        }
        return [$answers, $errors];
    }

    private static function icDateValid(string $ic): bool
    {
        $mm = (int) substr($ic, 2, 2);
        $dd = (int) substr($ic, 4, 2);
        return $mm >= 1 && $mm <= 12 && $dd >= 1 && $dd <= 31;
    }

    /**
     * Create a registration with seat locking. Returns the new registration row.
     * @throws RuntimeException with a user-facing message
     */
    public static function create(array $event, array $d): array
    {
        $pdo = db();
        $pdo->beginTransaction();
        try {
            // Lock the event row so two people can't take the last seat.
            $st = $pdo->prepare('SELECT * FROM events WHERE id = ? FOR UPDATE');
            $st->execute([$event['id']]);
            $ev = $st->fetch();
            if (!$ev) throw new RuntimeException('Acara tidak dijumpai.');

            $st = $pdo->prepare('SELECT id, status, ic_no, email FROM registrations WHERE event_id = ? AND (ic_no = ? OR email = ?)');
            $st->execute([$ev['id'], $d['ic_no'], $d['email']]);
            $existing = $st->fetchAll();
            $reuseId = null;
            foreach ($existing as $row) {
                if ($row['status'] !== 'cancelled') {
                    $field = $row['ic_no'] === $d['ic_no'] ? 'No. MyKad' : 'E-mel';
                    throw new RuntimeException("{$field} ini telah didaftarkan untuk acara ini. Gunakan menu \"Semak Pendaftaran\" untuk melihat tiket anda.");
                }
                $reuseId = $reuseId ?? (int) $row['id'];
            }
            // If re-registering after cancelling, clear any other cancelled row that would collide.
            if ($reuseId) {
                $pdo->prepare("DELETE FROM registrations WHERE event_id = ? AND status = 'cancelled' AND (ic_no = ? OR email = ?) AND id <> ?")
                    ->execute([$ev['id'], $d['ic_no'], $d['email'], $reuseId]);
            }

            $st = $pdo->prepare("SELECT COUNT(*) FROM registrations WHERE event_id = ? AND status IN ('registered','attended','absent')");
            $st->execute([$ev['id']]);
            $confirmed = (int) $st->fetchColumn();

            if ($confirmed < (int) $ev['capacity']) {
                $status = 'registered';
            } elseif ($ev['waitlist_enabled']) {
                $status = 'waitlisted';
            } else {
                throw new RuntimeException($ev['closed_message'] ?: 'Maaf, kuota untuk acara ini telah penuh.');
            }

            $ref = self::newRefCode($ev['type']);
            $token = bin2hex(random_bytes(20));
            $fields = [
                'event_id' => $ev['id'], 'ref_code' => $ref, 'token' => $token,
                'full_name' => $d['full_name'], 'email' => $d['email'], 'ic_no' => $d['ic_no'],
                'mobile_no' => $d['mobile_no'], 'office_no' => $d['office_no'] ?: null,
                'agency' => $d['agency'], 'ministry' => $d['ministry'] ?: null, 'grade' => $d['grade'],
                'answers' => $d['answers'] ? json_encode($d['answers'], JSON_UNESCAPED_UNICODE) : null,
                'state' => $d['state'], 'zone' => $d['zone'] ?? null, 'status' => $status,
            ];
            if ($reuseId) {
                $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($fields)));
                $pdo->prepare("UPDATE registrations SET $set, absence_reason = NULL, checked_in_at = NULL, checked_in_by = NULL, created_at = NOW() WHERE id = :id")
                    ->execute($fields + ['id' => $reuseId]);
                $id = $reuseId;
            } else {
                $cols = implode(', ', array_keys($fields));
                $ph = implode(', ', array_map(fn($k) => ":$k", array_keys($fields)));
                $pdo->prepare("INSERT INTO registrations ($cols) VALUES ($ph)")->execute($fields);
                $id = (int) $pdo->lastInsertId();
            }
            $pdo->commit();
        } catch (\Throwable $ex) {
            $pdo->rollBack();
            throw $ex;
        }
        return self::find($id);
    }

    private static function newRefCode(string $type): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $prefix = EVENT_TYPES[$type][1] ?? 'EV';
        do {
            $code = $prefix . '-';
            for ($i = 0; $i < 6; $i++) $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
            $st = db()->prepare('SELECT 1 FROM registrations WHERE ref_code = ?');
            $st->execute([$code]);
        } while ($st->fetch());
        return $code;
    }

    private const SELECT = 'SELECT r.*, e.title AS event_title, e.type AS event_type, e.slug AS event_slug, e.event_date, e.start_time, e.end_time,
            e.venue_name, e.venue_address, e.capacity, e.waitlist_enabled, e.custom_fields
        FROM registrations r JOIN events e ON e.id = r.event_id';

    public static function find(int $id): ?array
    {
        $st = db()->prepare(self::SELECT . ' WHERE r.id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public static function findByToken(string $token): ?array
    {
        if (!preg_match('/^[a-f0-9]{40}$/', $token)) return null;
        $st = db()->prepare(self::SELECT . ' WHERE r.token = ?');
        $st->execute([$token]);
        return $st->fetch() ?: null;
    }

    public static function findForParticipant(string $email, string $ic): array
    {
        $st = db()->prepare(self::SELECT . ' WHERE r.email = ? AND r.ic_no = ? ORDER BY e.event_date DESC');
        $st->execute([strtolower($email), $ic]);
        return $st->fetchAll();
    }

    /** Cancel and auto-promote the first waitlisted person. Returns the promoted registration (if any). */
    public static function cancel(array $reg): ?array
    {
        $pdo = db();
        $pdo->beginTransaction();
        $pdo->prepare('SELECT id FROM events WHERE id = ? FOR UPDATE')->execute([$reg['event_id']]);
        $pdo->prepare("UPDATE registrations SET status = 'cancelled' WHERE id = ?")->execute([$reg['id']]);
        $promoted = null;
        if ($reg['status'] === 'registered') {
            $promoted = self::promoteNext((int) $reg['event_id']);
        }
        $pdo->commit();
        return $promoted;
    }

    /** Fill free seats from the waitlist (FIFO). Must run inside a transaction. */
    public static function promoteNext(int $eventId): ?array
    {
        $pdo = db();
        $st = $pdo->prepare("SELECT capacity, (SELECT COUNT(*) FROM registrations WHERE event_id = e.id AND status IN ('registered','attended','absent')) AS confirmed FROM events e WHERE id = ?");
        $st->execute([$eventId]);
        $row = $st->fetch();
        if (!$row || $row['confirmed'] >= $row['capacity']) return null;
        $st = $pdo->prepare("SELECT id FROM registrations WHERE event_id = ? AND status = 'waitlisted' ORDER BY created_at ASC, id ASC LIMIT 1");
        $st->execute([$eventId]);
        $id = $st->fetchColumn();
        if (!$id) return null;
        $pdo->prepare("UPDATE registrations SET status = 'registered' WHERE id = ?")->execute([$id]);
        return self::find((int) $id);
    }

    /** Check in by QR token. Returns [ok(bool), message, registration|null]. */
    public static function checkIn(string $token, ?int $eventId, int $adminId): array
    {
        $reg = self::findByToken($token);
        if (!$reg) return [false, 'Kod QR tidak sah atau tidak dikenali.', null];
        if ($eventId && (int) $reg['event_id'] !== $eventId) {
            return [false, 'Peserta ini berdaftar untuk acara lain: ' . $reg['event_title'], $reg];
        }
        return match ($reg['status']) {
            'cancelled'  => [false, 'Pendaftaran ini telah DIBATALKAN.', $reg],
            'waitlisted' => [false, 'Peserta masih dalam SENARAI MENUNGGU.', $reg],
            'attended'   => [true, 'Sudah didaftar masuk pada ' . date('g:i A', strtotime($reg['checked_in_at'])) . '.', $reg + ['_repeat' => true]],
            default      => self::markAttended($reg, $adminId),
        };
    }

    private static function markAttended(array $reg, int $adminId): array
    {
        db()->prepare("UPDATE registrations SET status = 'attended', checked_in_at = NOW(), checked_in_by = ? WHERE id = ?")
            ->execute([$adminId, $reg['id']]);
        audit('checkin', 'registration', (int) $reg['id'], $reg['ref_code']);
        return [true, 'Kehadiran berjaya direkodkan. Selamat datang!', self::find((int) $reg['id'])];
    }
}
