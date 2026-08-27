<?php
class Opportunity
{
    public static function allLive(): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll("SELECT * FROM opportunities WHERE status = 'live' ORDER BY id ASC");
    }

    public static function all(): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll(
            'SELECT o.*, u.name AS creator_name
               FROM opportunities o
               LEFT JOIN users u ON u.id = o.created_by
              ORDER BY o.created_at DESC'
        );
    }

    public static function find(int $id): ?array
    {
        if (!TF_DB_OK) {
            return null;
        }
        return Database::fetch('SELECT * FROM opportunities WHERE id = ? LIMIT 1', [$id]);
    }

    public static function apply(int $userId, int $opportunityId, string $status = 'pending'): void
    {
        Database::run(
            'INSERT INTO opportunity_applications (user_id, opportunity_id, status)
             VALUES (?,?,?)
             ON DUPLICATE KEY UPDATE status = VALUES(status), updated_at = CURRENT_TIMESTAMP',
            [$userId, $opportunityId, $status]
        );
    }

    public static function savedBy(int $userId): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll(
            'SELECT o.*, a.status AS application_status, a.created_at AS applied_at
               FROM opportunity_applications a
               JOIN opportunities o ON o.id = a.opportunity_id
              WHERE a.user_id = ?
              ORDER BY a.created_at DESC',
            [$userId]
        );
    }

    public static function setStatus(int $id, string $status): void
    {
        if (!in_array($status, ['draft', 'pending', 'live', 'closed'], true)) {
            return;
        }
        Database::run('UPDATE opportunities SET status = ? WHERE id = ?', [$status, $id]);
    }

    public static function countLive(): int
    {
        if (!TF_DB_OK) {
            return 0;
        }
        $row = Database::fetch("SELECT COUNT(*) AS c FROM opportunities WHERE status = 'live'");
        return (int) ($row['c'] ?? 0);
    }

    public static function countPending(): int
    {
        if (!TF_DB_OK) {
            return 0;
        }
        $row = Database::fetch("SELECT COUNT(*) AS c FROM opportunities WHERE status = 'pending'");
        return (int) ($row['c'] ?? 0);
    }

    public static function countForUser(int $userId): int
    {
        $row = Database::fetch(
            "SELECT COUNT(*) AS c FROM opportunity_applications WHERE user_id = ? AND status IN ('pending','accepted','saved')",
            [$userId]
        );
        return (int) ($row['c'] ?? 0);
    }
}
