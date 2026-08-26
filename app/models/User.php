<?php
/**
 * User model — placeholder for the MySQL-backed implementation.
 *
 * Suggested table: users (see database/schema.sql)
 *   id, name, email, password_hash, phone, address, city, country,
 *   role ENUM('customer','farmer','admin'), payment, created_at
 */
class User
{
    public static function find(int $id): ?array
    {
        // TODO: SELECT * FROM users WHERE id = ?
        return null;
    }

    public static function findByEmail(string $email): ?array
    {
        // TODO: SELECT * FROM users WHERE email = ?
        return null;
    }

    public static function create(array $data): int
    {
        // TODO: INSERT — hash password with password_hash() first. Never store plaintext.
        return 0;
    }
}
