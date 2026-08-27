<?php
/**
 * Front-door form / JSON handler.
 * Every mutating request POSTs here with `action`.
 */
require_once dirname(__DIR__) . '/includes/init.php';

$isJson = stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false;
if ($isJson) {
    $payload = json_decode((string) file_get_contents('php://input'), true);
    if (is_array($payload)) {
        $_POST = $payload;
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    if ($isJson) {
        json_response(['ok' => false, 'error' => 'POST required'], 405);
    }
    redirect('index.php');
}

if (!TF_DB_OK) {
    $msg = 'Database unavailable. Import database/the_farmer.sql and set .env.';
    if ($isJson) {
        json_response(['ok' => false, 'error' => $msg], 503);
    }
    flash_set('error', $msg);
    redirect('index.php');
}

if (!csrf_verify()) {
    if ($isJson) {
        json_response(['ok' => false, 'error' => 'Invalid session. Refresh and retry.'], 419);
    }
    $back = $_SERVER['HTTP_REFERER'] ?? url('index.php');
    header('Location: ' . $back);
    exit;
}

$action = (string) ($_POST['action'] ?? '');

switch ($action) {
    case 'login': {
        $login = trim((string) ($_POST['logname'] ?? ''));
        $pass = (string) ($_POST['logpasswd'] ?? '');
        $row = User::findByLogin($login);
        if (!$row || !User::verifyPassword($row, $pass)) {
            flash_set('error', 'Those details do not match an account.');
            redirect('regform.php');
        }
        if ($row['status'] === 'suspended') {
            flash_set('error', 'This account has been suspended. Call the farm.');
            redirect('regform.php');
        }
        login_user($row);
        $view = User::present($row);
        flash_set('success', 'Welcome back to The Farmer, ' . $view['first_name'] . '.');
        redirect(tf_role_home($view['role']));
    }

    case 'register': {
        $name = trim((string) ($_POST['Uname'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $pass = (string) ($_POST['passwd'] ?? '');
        $confirm = (string) ($_POST['confirmpass'] ?? '');
        $role = $_POST['account_type'] ?? 'customer';
        if (!in_array($role, ['customer', 'farmer'], true)) {
            $role = 'customer';
        }
        $tel = preg_replace('/\D+/', '', (string) ($_POST['telnum'] ?? '')) ?? '';
        $addr = trim((string) ($_POST['adress'] ?? ''));
        if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6 || $pass !== $confirm || strlen($tel) < 8 || strlen($addr) < 4) {
            flash_set('error', 'Please check the highlighted fields and try again.');
            redirect('regform.php');
        }
        if (User::findByEmail($email)) {
            flash_set('error', 'That email already has an account. Log in instead.');
            redirect('regform.php');
        }
        $countryKey = (string) ($_POST['country'] ?? 'cameroon');
        $country = ucwords(str_replace('-', ' ', $countryKey));
        $id = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => $pass,
            'phone'    => trim(($_POST['countrycode'] ?? '') . ' ' . ($_POST['telnum'] ?? '')),
            'address'  => $addr,
            'city'     => $addr,
            'country'  => $country,
            'role'     => $role,
            'payment'  => tf_payment_label((string) ($_POST['paymentmode'] ?? 'momo')),
            'gender'   => ucfirst((string) ($_POST['gender'] ?? '')),
            'dob'      => (!empty($_POST['dob']) ? $_POST['dob'] : null),
        ]);
        $row = User::find($id);
        if (!$row) {
            flash_set('error', 'Account created but we could not sign you in. Please log in.');
            redirect('regform.php');
        }
        login_user($row);
        $adminId = tf_admin_id();
        if ($adminId) {
            Message::send($adminId, $id, 'Welcome to The Farmer', 'Your account is ready. Shop the harvest or apply to a program — we are in Simbock / Mendong, Yaoundé.');
        }
        flash_set('success', 'Account created. Welcome to The Farmer, ' . preg_split('/\s+/', $name)[0] . '.');
        redirect(tf_role_home($role));
    }

    case 'logout': {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        redirect('index.php');
    }

    case 'update_profile': {
        require_login();
        $u = current_user();
        $name = trim((string) ($_POST['name'] ?? $u['name']));
        $email = trim((string) ($_POST['email'] ?? $u['email']));
        if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash_set('error', 'Name and a valid email are required.');
            redirect('dashboard/account/profile.php');
        }
        $other = User::findByEmail($email);
        if ($other && (int) $other['id'] !== $u['uid']) {
            flash_set('error', 'That email is already used by another account.');
            redirect('dashboard/account/profile.php');
        }
        User::updateProfile($u['uid'], [
            'name'    => $name,
            'email'   => $email,
            'phone'   => trim((string) ($_POST['phone'] ?? '')),
            'address' => trim((string) ($_POST['address'] ?? '')),
            'payment' => trim((string) ($_POST['payment'] ?? $u['payment'])),
            'city'    => trim((string) ($_POST['city'] ?? $u['city'])),
        ]);
        flash_set('success', 'Profile saved.');
        redirect('dashboard/account/profile.php');
    }

    case 'change_password': {
        require_login();
        $u = current_user();
        $row = User::find($u['uid']);
        $current = (string) ($_POST['current_password'] ?? '');
        $next = (string) ($_POST['new_password'] ?? '');
        $again = (string) ($_POST['confirm_password'] ?? '');
        if (!$row || !User::verifyPassword($row, $current)) {
            flash_set('error', 'Current password is not correct.');
            redirect('dashboard/account/settings.php');
        }
        if (strlen($next) < 8 || $next !== $again) {
            flash_set('error', 'New password must be 8+ characters and match the confirmation.');
            redirect('dashboard/account/settings.php');
        }
        User::updatePassword($u['uid'], $next);
        flash_set('success', 'Password updated. Use it the next time you log in.');
        redirect('dashboard/account/settings.php');
    }

    case 'update_settings': {
        require_login();
        $u = current_user();
        $lang = (string) ($_POST['language'] ?? 'english');
        $theme = (string) ($_POST['theme'] ?? 'light');
        $cur = (string) ($_POST['currency'] ?? 'xaf');
        if (!in_array($lang, ['english', 'french', 'spanish'], true)) {
            $lang = 'english';
        }
        if (!in_array($theme, ['light', 'dark'], true)) {
            $theme = 'light';
        }
        if (!in_array($cur, ['xaf', 'usdt', 'eur'], true)) {
            $cur = 'xaf';
        }
        User::updateSettings($u['uid'], ['language' => $lang, 'theme' => $theme, 'currency' => $cur]);
        flash_set('success', 'Preferences saved to your account.');
        redirect('dashboard/account/settings.php');
    }

    case 'add_product': {
        require_role(['farmer', 'admin']);
        $u = current_user();
        $name = trim((string) ($_POST['name'] ?? ''));
        $price = (int) ($_POST['price_xaf'] ?? 0);
        $stock = (int) ($_POST['stock'] ?? 0);
        $cat = (string) ($_POST['category'] ?? 'fresh');
        if ($name === '' || $price < 100 || !in_array($cat, ['trees', 'fresh', 'juice', 'experience'], true)) {
            flash_set('error', 'Name, category and a price of at least 100 XAF are required.');
            redirect('dashboard/farmer/product-new.php');
        }
        Product::create([
            'vendor_id'   => $u['uid'],
            'name'        => $name,
            'category'    => $cat,
            'description' => trim((string) ($_POST['description'] ?? '')),
            'price_xaf'   => $price,
            'stock'       => max(0, $stock),
        ]);
        flash_set('success', 'Product submitted. An admin will publish it to the shop.');
        redirect('dashboard/farmer/products.php');
    }

    case 'update_product': {
        require_role(['farmer', 'admin']);
        $u = current_user();
        $id = (int) ($_POST['product_id'] ?? 0);
        $p = Product::find($id);
        if (!$p || ((int) $p['vendor_id'] !== $u['uid'] && $u['role'] !== 'admin')) {
            flash_set('error', 'Product not found.');
            redirect('dashboard/farmer/products.php');
        }
        Product::update($id, (int) $p['vendor_id'], [
            'name'        => trim((string) ($_POST['name'] ?? $p['name'])),
            'category'    => (string) ($_POST['category'] ?? $p['category']),
            'description' => trim((string) ($_POST['description'] ?? $p['description'])),
            'price_xaf'   => (int) ($_POST['price_xaf'] ?? $p['price_xaf']),
            'stock'       => (int) ($_POST['stock'] ?? $p['stock']),
        ]);
        flash_set('success', 'Product updated.');
        redirect('dashboard/farmer/products.php');
    }

    case 'delete_product': {
        require_role(['farmer', 'admin']);
        $u = current_user();
        $id = (int) ($_POST['product_id'] ?? 0);
        Product::delete($id, $u['role'] === 'admin' ? (int) (Product::find($id)['vendor_id'] ?? 0) : $u['uid']);
        flash_set('info', 'Pending listing removed.');
        redirect('dashboard/farmer/products.php');
    }

    case 'approve_product':
    case 'reject_product': {
        require_role(['admin']);
        $id = (int) ($_POST['product_id'] ?? 0);
        $p = Product::find($id);
        if ($p) {
            $status = $action === 'approve_product' ? 'live' : 'rejected';
            Product::setStatus($id, $status);
            Message::send(
                current_user()['uid'],
                (int) $p['vendor_id'],
                $status === 'live' ? 'Listing approved' : 'Listing rejected',
                $status === 'live'
                    ? $p['name'] . ' is now live in the shop.'
                    : $p['name'] . ' was not approved. Update it and resubmit.'
            );
            flash_set('success', $p['name'] . ' marked ' . $status . '.');
        }
        redirect('dashboard/admin/products.php');
    }

    case 'publish_opportunity':
    case 'close_opportunity': {
        require_role(['admin']);
        $id = (int) ($_POST['opportunity_id'] ?? 0);
        Opportunity::setStatus($id, $action === 'publish_opportunity' ? 'live' : 'closed');
        flash_set('success', 'Program updated.');
        redirect('dashboard/admin/opportunities.php');
    }

    case 'apply_opportunity': {
        require_login();
        $id = (int) ($_POST['opportunity_id'] ?? 0);
        $opp = Opportunity::find($id);
        if (!$opp || $opp['status'] !== 'live') {
            flash_set('error', 'That program is not open.');
            redirect('opportunity.php');
        }
        Opportunity::apply(current_user()['uid'], $id, 'pending');
        flash_set('success', 'Application sent for “' . $opp['title'] . '”. We call within 48 hours.');
        redirect('dashboard/user/opportunities.php');
    }

    case 'checkout': {
        if (!is_logged_in()) {
            if ($isJson) {
                json_response(['ok' => false, 'error' => 'login', 'redirect' => url('regform.php')], 401);
            }
            flash_set('info', 'Log in to place an order.');
            redirect('regform.php');
        }
        $u = current_user();
        $items = $_POST['items'] ?? [];
        if (!is_array($items)) {
            $items = [];
        }
        try {
            $order = Order::createFromCart($u, $items);
        } catch (Throwable $e) {
            if ($isJson) {
                json_response(['ok' => false, 'error' => $e->getMessage()], 422);
            }
            flash_set('error', $e->getMessage());
            redirect('product.php');
        }
        $adminId = tf_admin_id();
        if ($adminId) {
            Message::send($adminId, $u['uid'], 'Order ' . $order['public_id'], 'We received your order ' . $order['public_id'] . ' for ' . money($order['total']) . '. Our team will call you to confirm delivery in ' . ($u['city'] ?: 'Yaoundé') . '.');
        }
        if ($isJson) {
            json_response(['ok' => true, 'order' => $order['public_id'], 'total' => $order['total']]);
        }
        flash_set('success', 'Order ' . $order['public_id'] . ' placed. We will call you to confirm.');
        redirect('dashboard/user/orders.php');
    }

    case 'fulfill_order': {
        require_role(['farmer', 'admin']);
        $id = (int) ($_POST['order_id'] ?? 0);
        $status = (string) ($_POST['status'] ?? 'packing');
        $vendor = current_user()['role'] === 'admin' ? null : current_user()['uid'];
        Order::setStatus($id, $status, $vendor);
        flash_set('success', 'Order status updated.');
        redirect('dashboard/farmer/orders.php');
    }

    case 'toggle_user': {
        require_role(['admin']);
        $id = (int) ($_POST['user_id'] ?? 0);
        $row = User::find($id);
        if ($row && (int) $row['id'] !== current_user()['uid']) {
            $next = $row['status'] === 'active' ? 'suspended' : 'active';
            User::setStatus($id, $next);
            flash_set('success', $row['name'] . ' is now ' . $next . '.');
        }
        redirect('dashboard/admin/users.php');
    }

    case 'update_system': {
        require_role(['admin']);
        foreach (['free_delivery_threshold', 'delivery_fee', 'free_delivery_city', 'support_phone', 'support_email'] as $key) {
            if (isset($_POST[$key])) {
                Setting::set($key, trim((string) $_POST[$key]));
            }
        }
        flash_set('success', 'System settings saved.');
        redirect('dashboard/admin/settings.php');
    }

    case 'send_message': {
        require_login();
        $body = trim((string) ($_POST['body'] ?? ''));
        if ($body === '') {
            flash_set('error', 'Write a message first.');
            redirect('dashboard/user/messages.php');
        }
        $to = (int) ($_POST['recipient_id'] ?? 6);
        if ($to < 1) {
            $to = 6;
        }
        Message::send(current_user()['uid'], $to, 'Support', $body);
        flash_set('success', 'Message sent.');
        redirect('dashboard/user/messages.php');
    }

    case 'rate': {
        require_login();
        $stars = (int) ($_POST['stars'] ?? 0);
        Rating::save(current_user()['uid'], $stars);
        if ($isJson) {
            json_response(['ok' => true]);
        }
        flash_set('success', 'Thanks for rating us ' . $stars . '/5.');
        redirect('dashboard/account/settings.php');
    }

    case 'newsletter': {
        $email = trim((string) ($_POST['email'] ?? ''));
        if (!Newsletter::subscribe($email)) {
            flash_set('error', 'Please enter a valid email address.');
        } else {
            flash_set('success', "You're on the list! Fresh news, straight from the field.");
        }
        $back = $_SERVER['HTTP_REFERER'] ?? url('index.php');
        header('Location: ' . $back);
        exit;
    }

    default:
        if ($isJson) {
            json_response(['ok' => false, 'error' => 'Unknown action'], 400);
        }
        flash_set('error', 'Unknown action.');
        redirect('index.php');
}
