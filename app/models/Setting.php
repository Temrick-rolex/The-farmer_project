<?php
class Setting
{
    private static array $cache = [];

    public static function get(string $key, string $default = ''): string
    {
        if (!TF_DB_OK) {
            return $default;
        }
        if (array_key_exists($key, self::$cache)) {
            return self::$cache[$key];
        }
        $row = Database::fetch('SELECT setting_value FROM platform_settings WHERE setting_key = ?', [$key]);
        self::$cache[$key] = $row ? (string) $row['setting_value'] : $default;
        return self::$cache[$key];
    }

    public static function set(string $key, string $value): void
    {
        Database::run(
            'INSERT INTO platform_settings (setting_key, setting_value) VALUES (?,?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)',
            [$key, $value]
        );
        self::$cache[$key] = $value;
    }

    public static function all(): array
    {
        if (!TF_DB_OK) {
            return [];
        }
        $out = [];
        foreach (Database::fetchAll('SELECT setting_key, setting_value FROM platform_settings') as $row) {
            $out[$row['setting_key']] = $row['setting_value'];
        }
        return $out;
    }
}
