<?php
class User
{
    public static function present(array $row): array
    {
        $name = (string) ($row['name'] ?? '');
        $parts = preg_split('/\s+/', trim($name)) ?: ['User'];
        return [
            'uid'          => (int) $row['id'],
            'id'           => (string) $row['public_id'],
            'name'         => $name,
            'first_name'   => $parts[0],
            'email'        => (string) $row['email'],
            'phone'        => (string) ($row['phone'] ?? ''),
            'address'      => (string) ($row['address'] ?? ''),
            'city'         => (string) ($row['city'] ?? TF_CITY),
            'country'      => (string) ($row['country'] ?? TF_COUNTRY),
            'role'         => (string) $row['role'],
            'gender'       => (string) ($row['gender'] ?? ''),
            'payment'      => (string) ($row['payment'] ?? 'Mobile money'),
            'member_since' => date('Y', strtotime((string) ($row['created_at'] ?? 'now'))),
            'avatar'       => (string) ($row['avatar'] ?: 'Image/profile.jpg'),
            'wallet'       => (int) ($row['wallet_xaf'] ?? 0),
            'language'     => (string) ($row['language'] ?? 'english'),
            'theme'        => (string) ($row['theme'] ?? 'light'),
            'currency'     => (string) ($row['currency'] ?? 'xaf'),
            'status'       => (string) ($row['status'] ?? 'active'),
            'dob'          => $row['dob'] ?? null,
        ];
    }

    public static function find(int $id): ?array
    {
        if (!TF_DB_OK) {
            return null;
        }
        return Database::fetch('SELECT * FROM users WHERE id = ? LIMIT 1', [$id]);
    }

    public static function findByEmail(string $email): ?array
    {
        if (!TF_DB_OK) {
            return null;
        }
        return Database::fetch('SELECT * FROM users WHERE email = ? LIMIT 1', [strtolower($email)]);
    }

    public static function findByLogin(string $login): ?array
    {
        if (!TF_DB_OK) {
            return null;
        }
        $login = trim($login);
        $row = Database::fetch(
            'SELECT * FROM users WHERE email = ? OR name = ? OR public_id = ? LIMIT 1',
            [strtolower($login), $login, $login]
        );
        return $row;
    }

    public static function nextPublicId(): string
    {
        do {
            $id = strtoupper(substr(bin2hex(random_bytes(5)), 0, 7));
            $exists = Database::fetch('SELECT id FROM users WHERE public_id = ?', [$id]);
        } while ($exists);
        return $id;
    }

    public static function create(array $data): int
    {
        Database::run(
            'INSERT INTO users (public_id, name, email, password_hash, phone, address, city, country, role, payment, gender, dob)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?)',
            [
                self::nextPublicId(),
                $data['name'],
                strtolower($data['email']),
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['phone'] ?? null,
                $data['address'] ?? null,
                $data['city'] ?? TF_CITY,
                $data['country'] ?? 'Cameroon',
                $data['role'] ?? 'customer',
                $data['payment'] ?? 'Mobile money',
                $data['gender'] ?? null,
                $data['dob'] ?? null,
            ]
        );
        return Database::lastId();
    }

    public static function updateProfile(int $id, array $data): void
    {
        Database::run(
            'UPDATE users SET name = ?, email = ?, phone = ?, address = ?, payment = ?, city = ? WHERE id = ?',
            [
                $data['name'],
                strtolower($data['email']),
                $data['phone'] ?? null,
                $data['address'] ?? null,
                $data['payment'] ?? 'Mobile money',
                $data['city'] ?? TF_CITY,
                $id,
            ]
        );
    }

    public static function updatePassword(int $id, string $plain): void
    {
        Database::run('UPDATE users SET password_hash = ? WHERE id = ?', [
            password_hash($plain, PASSWORD_DEFAULT),
            $id,
        ]);
    }

    public static function updateSettings(int $id, array $data): void
    {
        Database::run(
            'UPDATE users SET language = ?, theme = ?, currency = ? WHERE id = ?',
            [
                $data['language'] ?? 'english',
                $data['theme'] ?? 'light',
                $data['currency'] ?? 'xaf',
                $id,
            ]
        );
    }

    public static function all(): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        return Database::fetchAll('SELECT * FROM users ORDER BY created_at DESC');
    }

    public static function count(): int
    {
        if (!TF_DB_OK) {
            return 0;
        }
        $row = Database::fetch('SELECT COUNT(*) AS c FROM users');
        return (int) ($row['c'] ?? 0);
    }

    public static function setStatus(int $id, string $status): void
    {
        if (!in_array($status, ['active', 'suspended'], true)) {
            return;
        }
        Database::run('UPDATE users SET status = ? WHERE id = ?', [$status, $id]);
    }

    public static function verifyPassword(array $row, string $plain): bool
    {
        return password_verify($plain, (string) $row['password_hash']);
    }
}
