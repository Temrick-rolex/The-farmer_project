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

define('TF_PASSWORD_MIN', 8);
define('TF_DEBUG', getenv('APP_DEBUG') === '1');
define('TF_CSP_NONCE', base64_encode(random_bytes(16)));

if (!TF_DEBUG) {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

define('TF_SESSION_NAME', 'tf_sid');
define('TF_SESSION_IDLE', 7200);           // 2 hours without Remember me
define('TF_SESSION_ABSOLUTE', 86400 * 7);  // 7 days max without Remember me
define('TF_SESSION_REMEMBER', 86400 * 30); // 30 days with Remember me
define('TF_SESSION_ROTATE', 900);          // re-issue id every 15 minutes

$tfSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || ((string) ($_SERVER['SERVER_PORT'] ?? '') === '443')
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

$tfCookiePath = BASE_URL === '' ? '/' : rtrim(BASE_URL, '/') . '/';
define('TF_SESSION_SECURE', $tfSecure);
define('TF_SESSION_PATH', $tfCookiePath);

ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.use_trans_sid', '0');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_secure', $tfSecure ? '1' : '0');
ini_set('session.gc_maxlifetime', (string) TF_SESSION_REMEMBER);
ini_set('session.sid_length', '48');
ini_set('session.sid_bits_per_character', '6');
ini_set('session.lazy_write', '1');

if (session_status() === PHP_SESSION_NONE) {
    session_name(TF_SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => $tfCookiePath,
        'secure'   => $tfSecure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
