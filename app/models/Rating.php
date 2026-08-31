<?php
class Rating
{
    public static function save(int $userId, int $stars): void
    {
        $stars = max(1, min(5, $stars));
        Database::run(
            'INSERT INTO ratings (user_id, stars) VALUES (?,?)
             ON DUPLICATE KEY UPDATE stars = VALUES(stars)',
            [$userId, $stars]
        );
    }
}
