<?php
declare(strict_types=1);

namespace App;

final class Events
{
    private const SELECT = "SELECT e.*, z.name AS zone_name, s.name AS state_name,
            (SELECT COUNT(*) FROM registrations r WHERE r.event_id = e.id AND r.status IN ('registered','attended','absent')) AS confirmed,
            (SELECT COUNT(*) FROM registrations r WHERE r.event_id = e.id AND r.status = 'waitlisted') AS waitlisted,
            (SELECT COUNT(*) FROM registrations r WHERE r.event_id = e.id AND r.status = 'attended') AS attended
        FROM events e
        LEFT JOIN zones z ON z.id = e.zone_id
        LEFT JOIN states s ON s.id = e.state_id";

    /** Public listing: published & upcoming. */
    public static function upcoming(?string $type = null): array
    {
        $sql = self::SELECT . " WHERE e.status <> 'draft' AND e.event_date >= CURDATE()";
        $args = [];
        if ($type) { $sql .= ' AND e.type = ?'; $args[] = $type; }
        $sql .= ' ORDER BY e.event_date ASC';
        $st = db()->prepare($sql);
        $st->execute($args);
        return $st->fetchAll();
    }

    public static function all(): array
    {
        return db()->query(self::SELECT . ' ORDER BY e.event_date DESC')->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $st = db()->prepare(self::SELECT . ' WHERE e.id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $st = db()->prepare(self::SELECT . ' WHERE e.slug = ?');
        $st->execute([$slug]);
        return $st->fetch() ?: null;
    }

    public static function seatsLeft(array $e): int
    {
        return max(0, (int) $e['capacity'] - (int) $e['confirmed']);
    }

    public static function fillPercent(array $e): int
    {
        return $e['capacity'] > 0 ? (int) min(100, round($e['confirmed'] / $e['capacity'] * 100)) : 100;
    }

    /** Whether new registrations are accepted (either as confirmed or waitlisted). */
    public static function acceptsRegistrations(array $e): bool
    {
        if ($e['status'] !== 'open') return false;
        if ($e['event_date'] < date('Y-m-d')) return false;
        if ($e['registration_deadline'] && strtotime($e['registration_deadline']) < time()) return false;
        return self::seatsLeft($e) > 0 || (bool) $e['waitlist_enabled'];
    }

    public static function stateLabel(array $e): array
    {
        if ($e['status'] === 'draft') return ['Draf', 'gray'];
        if ($e['status'] === 'closed') return ['Ditutup', 'rose'];
        if ($e['event_date'] < date('Y-m-d')) return ['Selesai', 'gray'];
        if ($e['registration_deadline'] && strtotime($e['registration_deadline']) < time()) return ['Tamat Tempoh', 'rose'];
        if (self::seatsLeft($e) === 0) return $e['waitlist_enabled'] ? ['Senarai Menunggu', 'amber'] : ['Penuh', 'rose'];
        if (self::fillPercent($e) >= 80) return ['Hampir Penuh', 'amber'];
        return ['Dibuka', 'green'];
    }

    public static function venue(array $e): string
    {
        return trim($e['venue_name'] . ($e['venue_address'] ? ', ' . $e['venue_address'] : ''));
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = slugify($title);
        $slug = $base;
        $i = 2;
        while (true) {
            $st = db()->prepare('SELECT id FROM events WHERE slug = ?' . ($ignoreId ? ' AND id <> ' . (int) $ignoreId : ''));
            $st->execute([$slug]);
            if (!$st->fetch()) return $slug;
            $slug = $base . '-' . $i++;
        }
    }
}
