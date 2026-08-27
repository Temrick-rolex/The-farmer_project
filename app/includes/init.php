<?php
/**
 * Bootstrap — include this at the top of every public and dashboard page.
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once TF_APP . '/helpers/functions.php';
require_once TF_APP . '/config/database.php';

spl_autoload_register(static function (string $class): void {
    $file = TF_APP . '/models/' . $class . '.php';
    if (is_readable($file)) {
        require_once $file;
    }
});

if (!defined('TF_DB_OK')) {
    define('TF_DB_OK', Database::connected());
}

if (!TF_DB_OK && empty($_SESSION['db_warned'])) {
    $_SESSION['db_warned'] = 1;
    flash_set(
        'error',
        'MySQL is not connected. Import database/the_farmer.sql and copy .env.example to .env.'
    );
}
