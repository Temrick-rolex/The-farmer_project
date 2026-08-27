<?php
/**
 * The Farmer — application configuration.
 * Shared hosting friendly: web root is the project root.
 */
if (defined('TF_BOOTSTRAPPED')) {
    return;
}
define('TF_BOOTSTRAPPED', true);

define('TF_ROOT', dirname(__DIR__, 2));
define('TF_APP', TF_ROOT . '/app');
define('TF_DASHBOARD', TF_ROOT . '/dashboard');
define('TF_ASSETS_DIR', TF_ROOT . '/Assets');

$tfEnvFile = TF_ROOT . '/.env';
if (is_readable($tfEnvFile)) {
    foreach (file($tfEnvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $tfLine) {
        $tfLine = trim($tfLine);
        if ($tfLine === '' || $tfLine[0] === '#') {
            continue;
        }
        if (strpos($tfLine, '=') === false) {
            continue;
        }
        [$tfK, $tfV] = explode('=', $tfLine, 2);
        $tfK = trim($tfK);
        $tfV = trim($tfV, " \t\"'");
        if ($tfK !== '' && getenv($tfK) === false) {
            putenv($tfK . '=' . $tfV);
            $_ENV[$tfK] = $tfV;
        }
    }
}

/**
 * Compute a root-relative base URL so asset paths work from any
 * nested page (dashboard/user/index.php, public pages, etc.).
 * Always uses forward slashes — never Windows backslashes.
 */
$tfDocRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
$tfAppRoot = realpath(TF_ROOT);
if ($tfDocRoot && $tfAppRoot && strpos(str_replace('\\', '/', $tfAppRoot), str_replace('\\', '/', $tfDocRoot)) === 0) {
    $tfRel = str_replace('\\', '/', substr($tfAppRoot, strlen($tfDocRoot)));
    $tfRel = '/' . trim($tfRel, '/');
    define('BASE_URL', $tfRel === '/' ? '' : rtrim($tfRel, '/'));
} else {
    define('BASE_URL', '');
}

define('ASSET_URL', BASE_URL . '/Assets');

define('TF_APP_NAME', 'The Farmer');
define('TF_CURRENCY', 'XAF');
define('TF_COUNTRY', 'Cameroon');
define('TF_CITY', 'Yaoundé');
define('TF_PHONE', '+237 605 048 910');
define('TF_EMAIL', 'temrick4@gmail.com');
define('TF_ADDRESS', 'Simbock / Mendong, Yaoundé — Cameroon');

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'the_farmer');
define('DB_USER', getenv('DB_USER') !== false && getenv('DB_USER') !== '' ? getenv('DB_USER') : 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_CHARSET', 'utf8mb4');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
