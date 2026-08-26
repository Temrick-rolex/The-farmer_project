<?php
/**
 * Front-door form handler.
 * Every public and dashboard form POSTs here with `action`.
 * Swap the demo branches for real model calls when MySQL is ready.
 */
require_once dirname(__DIR__) . '/includes/init.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    redirect('index.php');
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'login':
        $name = trim((string) ($_POST['logname'] ?? ''));
        $role = $_POST['role'] ?? 'customer';
        if (!in_array($role, ['customer', 'farmer', 'admin'], true)) {
            $role = 'customer';
        }
        if ($name === '') {
            flash_set('error', 'Please enter your name or email.');
            redirect('regform.php');
        }
        $first = preg_split('/\s+/', $name)[0];
        $_SESSION['user'] = array_merge($TF_DEMO_USER, [
            'name'       => $name,
            'first_name' => $first,
            'email'      => strpos($name, '@') !== false ? $name : 'johndoe@gmail.com',
            'role'       => $role,
        ]);
        flash_set('success', 'Welcome back to The Farmer, ' . $first . '.');
        redirect(tf_role_home($role));
        break;

    case 'register':
        $name = trim((string) ($_POST['Uname'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $pass = (string) ($_POST['passwd'] ?? '');
        $confirm = (string) ($_POST['confirmpass'] ?? '');
        $role = $_POST['account_type'] ?? 'customer';
        if (!in_array($role, ['customer', 'farmer'], true)) {
            $role = 'customer';
        }
        if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6 || $pass !== $confirm) {
            flash_set('error', 'Please check the highlighted fields and try again.');
            redirect('regform.php');
        }
        /* NEVER store a plaintext password. When MySQL lands, use password_hash(). */
        $_SESSION['user'] = array_merge($TF_DEMO_USER, [
            'name'       => $name,
            'first_name' => preg_split('/\s+/', $name)[0],
            'email'      => $email,
            'phone'      => trim(($_POST['countrycode'] ?? '') . ' ' . ($_POST['telnum'] ?? '')),
            'address'    => trim((string) ($_POST['adress'] ?? $TF_DEMO_USER['address'])),
            'country'    => ucfirst((string) ($_POST['country'] ?? 'Cameroon')),
            'role'       => $role,
            'gender'     => ucfirst((string) ($_POST['gender'] ?? '')),
            'payment'    => (string) ($_POST['paymentmode'] ?? 'Mobile money'),
        ]);
        flash_set('success', 'Account created. Welcome to The Farmer, ' . preg_split('/\s+/', $name)[0] . '.');
        redirect(tf_role_home($role));
        break;

    case 'logout':
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        redirect('index.php');
        break;

    case 'update_profile':
        if (is_logged_in()) {
            $_SESSION['user']['name'] = trim((string) ($_POST['name'] ?? current_user()['name']));
            $_SESSION['user']['first_name'] = preg_split('/\s+/', $_SESSION['user']['name'])[0];
            $_SESSION['user']['email'] = trim((string) ($_POST['email'] ?? current_user()['email']));
            $_SESSION['user']['phone'] = trim((string) ($_POST['phone'] ?? current_user()['phone']));
            $_SESSION['user']['address'] = trim((string) ($_POST['address'] ?? current_user()['address']));
            $_SESSION['user']['payment'] = trim((string) ($_POST['payment'] ?? current_user()['payment']));
        }
        flash_set('success', 'Profile updated (demo — persist to MySQL next).');
        redirect('dashboard/account/profile.php');
        break;

    case 'change_password':
        $current = (string) ($_POST['current_password'] ?? '');
        $next = (string) ($_POST['new_password'] ?? '');
        $again = (string) ($_POST['confirm_password'] ?? '');
        if (strlen($next) < 8 || $next !== $again || $current === '') {
            flash_set('error', 'Password not changed. Use 8+ characters and match the confirmation.');
        } else {
            /* password_hash($next, PASSWORD_DEFAULT) — never echo or store plaintext. */
            flash_set('success', 'Password updated. Use this password the next time you log in.');
        }
        redirect('dashboard/account/settings.php');
        break;

    case 'update_settings':
        flash_set('info', 'Preferences saved on this device.');
        redirect('dashboard/account/settings.php');
        break;

    case 'add_product':
        flash_set('success', 'Product submitted for review. An admin will publish it to the shop.');
        redirect('dashboard/farmer/products.php');
        break;

    case 'newsletter':
        flash_set('success', "You're on the list! Fresh news, straight from the field.");
        redirect('index.php');
        break;

    default:
        flash_set('error', 'Unknown action.');
        redirect('index.php');
}
