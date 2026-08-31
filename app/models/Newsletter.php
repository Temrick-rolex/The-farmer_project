<?php
class Newsletter
{
    public static function subscribe(string $email): bool
    {
        $email = strtolower(trim($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        Database::run(
            'INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)',
            [$email]
        );
        return true;
    }
}
