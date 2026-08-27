<?php
/**
 * PDO connection. Credentials come from .env (see .env.example) or the
 * DB_* constants in config.php.
 */
class Database
{
    private static ?PDO $pdo = null;
    private static ?string $error = null;

    public static function pdo(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $host = DB_HOST;
        $port = defined('DB_PORT') ? DB_PORT : '3306';
        $name = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $charset = DB_CHARSET;

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";

        self::$pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);

        return self::$pdo;
    }

    public static function connected(): bool
    {
        try {
            self::pdo();
            return true;
        } catch (Throwable $e) {
            self::$error = $e->getMessage();
            return false;
        }
    }

    public static function error(): ?string
    {
        return self::$error;
    }

    public static function run(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetch(string $sql, array $params = []): ?array
    {
        $row = self::run($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::run($sql, $params)->fetchAll();
    }

    public static function lastId(): int
    {
        return (int) self::pdo()->lastInsertId();
    }
}
