<?php
class Message
{
    public static function inbox(int $userId): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll(
            'SELECT m.*, COALESCE(u.name, ?) AS sender_name
               FROM messages m
               LEFT JOIN users u ON u.id = m.sender_id
              WHERE m.recipient_id = ?
              ORDER BY m.created_at DESC',
            ['The Farmer Support', $userId]
        );
    }

    public static function send(?int $senderId, int $recipientId, string $subject, string $body): void
    {
        Database::run(
            'INSERT INTO messages (sender_id, recipient_id, subject, body) VALUES (?,?,?,?)',
            [$senderId, $recipientId, $subject, $body]
        );
    }

    public static function unreadCount(int $userId): int
    {
        if (!TF_DB_OK) {
            return 0;
        }
        $row = Database::fetch(
            'SELECT COUNT(*) AS c FROM messages WHERE recipient_id = ? AND is_read = 0',
            [$userId]
        );
        return (int) ($row['c'] ?? 0);
    }

    public static function markRead(int $userId): void
    {
        if (!TF_DB_OK || $userId < 1) {
            return;
        }
        Database::run('UPDATE messages SET is_read = 1 WHERE recipient_id = ?', [$userId]);
    }
}
