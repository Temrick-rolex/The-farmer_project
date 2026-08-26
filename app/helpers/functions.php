<?php
/**
 * Shared helpers — escaping, URLs, money, current user.
 */

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Build an app URL from a root-relative path. Always forward slashes. */
function url(string $path = ''): string
{
    $path = str_replace('\\', '/', $path);
    if ($path === '' || $path === '/') {
        return BASE_URL . '/index.php';
    }
    return BASE_URL . '/' . ltrim($path, '/');
}

/** Build an asset URL (CSS, JS, images). */
function asset(string $path): string
{
    $path = str_replace('\\', '/', $path);
    return ASSET_URL . '/' . ltrim($path, '/');
}

function tf_active(string $page, string $current): string
{
    return $page === $current ? 'active' : '';
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user']) && is_array($_SESSION['user']);
}

function current_user(): array
{
    if (is_logged_in()) {
        return $_SESSION['user'];
    }
    return $GLOBALS['TF_DEMO_USER'] ?? [
        'id'         => '01XJ00F',
        'name'       => 'John Doe',
        'first_name' => 'John',
        'email'      => 'johndoe@gmail.com',
        'phone'      => '+237 605 048 910',
        'address'    => 'Yaoundé, Simbock — Mendong',
        'city'       => 'Yaoundé',
        'country'    => 'Cameroon',
        'role'       => 'customer',
        'gender'     => 'Male',
        'payment'    => 'Mobile money',
        'member_since' => '2024',
        'avatar'     => 'Image/profile.jpg',
        'wallet'     => 12400,
    ];
}

function user_initials(array $user = null): string
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

function tf_role_home(string $role = null): string
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

function tf_role_label(string $role = null): string
{
    $map = [
        'customer' => 'Customer',
        'farmer'   => 'Farmer / Vendor',
        'admin'    => 'Administrator',
    ];
    $role = $role ?: (current_user()['role'] ?? 'customer');
    return $map[$role] ?? ucfirst($role);
}

function redirect(string $path): void
{
    $target = preg_match('#^https?://#', $path) ? $path : url($path);
    header('Location: ' . $target);
    exit;
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
