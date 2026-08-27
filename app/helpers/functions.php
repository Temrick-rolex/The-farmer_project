<?php
/**
 * Shared helpers — escaping, URLs, money, auth, CSRF, security headers.
 */

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function tf_clip(string $value, int $max): string
{
    if (function_exists('mb_substr')) {
        return mb_substr($value, 0, $max);
    }
    return substr($value, 0, $max);
}

function tf_js($value): string
{
    return json_encode(
        $value,
        JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE
    );
}

function csp_nonce(): string
{
    return defined('TF_CSP_NONCE') ? TF_CSP_NONCE : '';
}

function url(string $path = ''): string
{
    $path = str_replace('\\', '/', $path);
    if ($path === '' || $path === '/') {
        return BASE_URL . '/index.php';
    }
    return BASE_URL . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    $path = str_replace('\\', '/', $path);
    $path = ltrim($path, '/');
    if ($path === '' || strpos($path, '..') !== false || preg_match('#^[a-z][a-z0-9+.-]*:#i', $path)) {
        $path = 'Image/profile.jpg';
    }
    return ASSET_URL . '/' . $path;
}

function tf_active(string $page, string $current): string
{
    return $page === $current ? 'active' : '';
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}

function current_user(): array
{
    static $cached = null;
    if ($cached !== null) {
        return $cached;
    }
    if (is_logged_in() && class_exists('User')) {
        $row = User::find((int) $_SESSION['user_id']);
        if ($row) {
            $cached = User::present($row);
            return $cached;
        }
        unset($_SESSION['user_id']);
    }
    $cached = [
        'uid'          => 0,
        'id'           => '',
        'name'         => 'Guest',
        'first_name'   => 'Guest',
        'email'        => '',
        'phone'        => '',
        'address'      => '',
        'city'         => TF_CITY,
        'country'      => TF_COUNTRY,
        'role'         => 'customer',
        'gender'       => '',
        'payment'      => 'Mobile money',
        'member_since' => date('Y'),
        'avatar'       => 'Image/profile.jpg',
        'wallet'       => 0,
        'language'     => 'english',
        'theme'        => 'light',
        'currency'     => 'xaf',
        'status'       => 'active',
    ];
    return $cached;
}

function login_user(array $row, bool $remember = false): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) $row['id'];
    if ($remember) {
        $p = session_get_cookie_params();
        setcookie(session_name(), session_id(), [
            'expires'  => time() + 60 * 60 * 24 * 30,
            'path'     => $p['path'] ?: '/',
            'domain'   => $p['domain'] ?? '',
            'secure'   => !empty($p['secure']),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}

function user_initials(?array $user = null): string
{
    $user = $user ?: current_user();
    $parts = preg_split('/\s+/', trim((string) ($user['name'] ?? 'U')));
    $ini = '';
    foreach ($parts as $p) {
        if ($p !== '') {
            $ini .= strtoupper(substr($p, 0, 1));
        }
        if (strlen($ini) >= 2) {
            break;
        }
    }
    return $ini !== '' ? $ini : 'U';
}

function money($amount, string $currency = TF_CURRENCY): string
{
    return number_format((int) $amount, 0, '.', ',') . ' ' . $currency;
}

function tf_role_home(?string $role = null): string
{
    $role = $role ?: (current_user()['role'] ?? 'customer');
    if ($role === 'farmer') {
        return url('dashboard/farmer/index.php');
    }
    if ($role === 'admin') {
        return url('dashboard/admin/index.php');
    }
    return url('dashboard/user/index.php');
}

function tf_role_label(?string $role = null): string
{
    $map = [
        'customer' => 'Customer',
        'farmer'   => 'Farmer / Vendor',
        'admin'    => 'Administrator',
    ];
    $role = $role ?: (current_user()['role'] ?? 'customer');
    return $map[$role] ?? ucfirst((string) $role);
}

function redirect(string $path): void
{
    if (preg_match('#^https?://#i', $path)) {
        $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
        $parts = parse_url($path);
        $targetHost = strtolower((string) ($parts['host'] ?? ''));
        if ($host === '' || $targetHost === '' || $targetHost !== $host) {
            $path = url('index.php');
        }
        $target = $path;
    } else {
        $target = url($path);
    }
    header('Location: ' . $target);
    exit;
}

function redirect_back(string $fallback = 'index.php'): void
{
    $ref = (string) ($_SERVER['HTTP_REFERER'] ?? '');
    if ($ref !== '') {
        $parts = parse_url($ref);
        $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
        $refHost = strtolower((string) ($parts['host'] ?? ''));
        $path = (string) ($parts['path'] ?? '');
        if ($host !== '' && $refHost === $host && $path !== '' && strpos($path, '..') === false) {
            header('Location: ' . $ref);
            exit;
        }
    }
    redirect($fallback);
}

function flash_set(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_get(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf']) || !is_string($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_verify(): bool
{
    $sent = $_POST['csrf'] ?? $_SERVER['HTTP_X_CSRF'] ?? '';
    $ok = is_string($sent) && $sent !== '' && hash_equals(csrf_token(), $sent);
    if (!$ok) {
        flash_set('error', 'Your session expired. Please try again.');
    }
    return $ok;
}

function login_throttle_blocked(): bool
{
    $now = time();
    $bucket = $_SESSION['_login_attempts'] ?? ['n' => 0, 't' => $now];
    if ($now - (int) $bucket['t'] > 900) {
        $bucket = ['n' => 0, 't' => $now];
    }
    return (int) $bucket['n'] >= 8;
}

function login_throttle_hit(): void
{
    $now = time();
    $bucket = $_SESSION['_login_attempts'] ?? ['n' => 0, 't' => $now];
    if ($now - (int) $bucket['t'] > 900) {
        $bucket = ['n' => 0, 't' => $now];
    }
    $bucket['n'] = (int) $bucket['n'] + 1;
    $bucket['t'] = (int) $bucket['t'] ?: $now;
    $_SESSION['_login_attempts'] = $bucket;
}

function login_throttle_clear(): void
{
    unset($_SESSION['_login_attempts']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash_set('info', 'Please log in to open your workspace.');
        redirect('regform.php');
    }
    $user = current_user();
    if (($user['status'] ?? 'active') === 'suspended') {
        unset($_SESSION['user_id']);
        flash_set('error', 'This account has been suspended. Call the farm.');
        redirect('regform.php');
    }
}

function require_role(array $roles): void
{
    require_login();
    $role = current_user()['role'] ?? '';
    if (!in_array($role, $roles, true)) {
        flash_set('error', 'You do not have access to that workspace.');
        redirect(tf_role_home());
    }
}

function tf_security_headers(): void
{
    if (headers_sent()) {
        return;
    }
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');
    header('X-XSS-Protection: 0');
    $nonce = csp_nonce();
    $csp = implode('; ', [
        "default-src 'self'",
        "script-src 'self' 'nonce-{$nonce}'",
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com",
        "img-src 'self' data:",
        "connect-src 'self'",
        "frame-ancestors 'self'",
        "base-uri 'self'",
        "form-action 'self'",
        "object-src 'none'",
    ]);
    header('Content-Security-Policy: ' . $csp);
}

function tf_status_label($status): string
{
    $status = str_replace('_', ' ', (string) $status);
    return ucwords($status);
}

function tf_status_ok($status): bool
{
    return in_array((string) $status, ['live', 'delivered', 'completed', 'accepted', 'active', 'paid'], true);
}

function product_category_label(string $cat): string
{
    $map = [
        'trees'      => 'Trees',
        'fresh'      => 'Fresh fruit',
        'juice'      => 'Juice & cellar',
        'experience' => 'Experiences',
    ];
    return $map[$cat] ?? ucfirst($cat);
}

function stars_html($avg): string
{
    $avg = (float) $avg;
    $html = '<span class="stars">';
    for ($i = 1; $i <= 5; $i++) {
        if ($avg >= $i) {
            $html .= '<i class="fa-solid fa-star"></i>';
        } elseif ($avg >= $i - 0.5) {
            $html .= '<i class="fa-solid fa-star-half-stroke"></i>';
        } else {
            $html .= '<i class="fa-regular fa-star off"></i>';
        }
    }
    $html .= '</span>';
    return $html;
}

function tf_payment_label(string $value): string
{
    $map = [
        'cash'  => 'Cash',
        'momo'  => 'Mobile money',
        'visa'  => 'Visa',
        'card'  => 'Bank card',
    ];
    $key = strtolower($value);
    return $map[$key] ?? $value;
}

function tf_slug(string $name): string
{
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug) ?? $name;
    $slug = trim($slug, '-');
    return $slug !== '' ? $slug : 'item-' . bin2hex(random_bytes(3));
}

function json_response(array $payload, int $code = 200): void
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo tf_js($payload);
    exit;
}

function setting(string $key, string $default = ''): string
{
    if (!class_exists('Setting') || !defined('TF_DB_OK') || !TF_DB_OK) {
        return $default;
    }
    return Setting::get($key, $default);
}

function tf_admin_id(): int
{
    if (!defined('TF_DB_OK') || !TF_DB_OK) {
        return 0;
    }
    $row = Database::fetch("SELECT id FROM users WHERE role = 'admin' AND status = 'active' ORDER BY id ASC LIMIT 1");
    return $row ? (int) $row['id'] : 0;
}

function tf_clean_cart($items): array
{
    if (!is_array($items)) {
        return [];
    }
    $out = [];
    foreach ($items as $id => $qty) {
        $pid = (int) $id;
        $q = (int) $qty;
        if ($pid > 0 && $q > 0 && $q <= 99) {
            $out[$pid] = $q;
        }
    }
    return $out;
}
