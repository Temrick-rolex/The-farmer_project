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
    redirect_back('index.php');
}

$action = (string) ($_POST['action'] ?? '');

switch ($action) {
    case 'login': {
        if (login_throttle_blocked()) {
            flash_set('error', 'Too many sign-in attempts. Wait 15 minutes and try again.');
            redirect('regform.php');
        }
        $login = trim((string) ($_POST['logname'] ?? ''));
        $pass = (string) ($_POST['logpasswd'] ?? '');
        $row = User::findByLogin($login);
        if (!$row || !User::verifyPassword($row, $pass)) {
            login_throttle_hit();
            flash_set('error', 'Those details do not match an account.');
            redirect('regform.php');
        }
        if ($row['status'] === 'suspended') {
            flash_set('error', 'This account has been suspended. Call the farm.');
            redirect('regform.php');
        }
        login_throttle_clear();
        login_user($row, !empty($_POST['remember']));
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
        $countries = ['cameroon', 'chad', 'niger', 'nigeria', 'ghana', 'sierra-leone'];
        $genders = ['male', 'female', 'other'];
        $tel = preg_replace('/\D+/', '', (string) ($_POST['telnum'] ?? '')) ?? '';
        $addr = trim((string) ($_POST['adress'] ?? ''));
        $minPass = defined('TF_PASSWORD_MIN') ? TF_PASSWORD_MIN : 8;
        if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < $minPass || $pass !== $confirm || strlen($tel) < 8 || strlen($addr) < 4) {
            flash_set('error', 'Please check the highlighted fields and try again.');
            redirect('regform.php');
        }
        if (User::findByEmail($email)) {
            flash_set('error', 'That email already has an account. Log in instead.');
            redirect('regform.php');
        }
        $countryKey = (string) ($_POST['country'] ?? 'cameroon');
        if (!in_array($countryKey, $countries, true)) {
            $countryKey = 'cameroon';
        }
        $genderKey = strtolower((string) ($_POST['gender'] ?? 'other'));
        if (!in_array($genderKey, $genders, true)) {
            $genderKey = 'other';
        }
        $codes = ['+237', '+236', '+235', '+234', '+233', '+232'];
        $code = (string) ($_POST['countrycode'] ?? '+237');
        if (!in_array($code, $codes, true)) {
            $code = '+237';
        }
        $country = ucwords(str_replace('-', ' ', $countryKey));
        $id = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => $pass,
            'phone'    => trim($code . ' ' . (string) ($_POST['telnum'] ?? '')),
            'address'  => $addr,
            'city'     => $addr,
            'country'  => $country,
            'role'     => $role,
            'payment'  => tf_payment_label((string) ($_POST['paymentmode'] ?? 'momo')),
            'gender'   => ucfirst($genderKey),
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
        $pay = trim((string) ($_POST['payment'] ?? $u['payment']));
        $allowedPay = ['Cash', 'Mobile money', 'Visa', 'Bank card'];
        if (!in_array($pay, $allowedPay, true)) {
            $pay = $u['payment'];
        }
        User::updateProfile($u['uid'], [
            'name'    => tf_clip($name, 120),
            'email'   => $email,
            'phone'   => tf_clip(trim((string) ($_POST['phone'] ?? '')), 32),
            'address' => tf_clip(trim((string) ($_POST['address'] ?? '')), 255),
            'payment' => $pay,
            'city'    => tf_clip(trim((string) ($_POST['city'] ?? $u['city'])), 80),
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
        $minPass = defined('TF_PASSWORD_MIN') ? TF_PASSWORD_MIN : 8;
        if (strlen($next) < $minPass || $next !== $again) {
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
        $cat = (string) ($_POST['category'] ?? $p['category']);
        if (!in_array($cat, ['trees', 'fresh', 'juice', 'experience'], true)) {
            $cat = $p['category'];
        }
        $price = (int) ($_POST['price_xaf'] ?? $p['price_xaf']);
        if ($price < 100) {
            $price = (int) $p['price_xaf'];
        }
        Product::update($id, (int) $p['vendor_id'], [
            'name'        => tf_clip(trim((string) ($_POST['name'] ?? $p['name'])), 160),
            'category'    => $cat,
            'description' => tf_clip(trim((string) ($_POST['description'] ?? $p['description'])), 2000),
            'price_xaf'   => $price,
            'stock'       => max(0, (int) ($_POST['stock'] ?? $p['stock'])),
        ]);
        flash_set('success', 'Product updated.');
        redirect('dashboard/farmer/products.php');
    }

    case 'delete_product': {
        require_role(['farmer', 'admin']);
        $u = current_user();
        $id = (int) ($_POST['product_id'] ?? 0);
        $existing = Product::find($id);
        $vendorId = $u['role'] === 'admin' ? (int) ($existing['vendor_id'] ?? 0) : $u['uid'];
        if ($existing) {
            Product::delete($id, $vendorId);
        }
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
        $items = tf_clean_cart($_POST['items'] ?? []);
        try {
            $order = Order::createFromCart($u, $items);
        } catch (RuntimeException $e) {
            if ($isJson) {
                json_response(['ok' => false, 'error' => $e->getMessage()], 422);
            }
            flash_set('error', $e->getMessage());
            redirect('product.php');
        } catch (Throwable $e) {
            if ($isJson) {
                json_response(['ok' => false, 'error' => 'Could not place the order. Try again.'], 500);
            }
            flash_set('error', 'Could not place the order. Try again.');
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
        if (isset($_POST['free_delivery_threshold'])) {
            Setting::set('free_delivery_threshold', (string) max(0, (int) $_POST['free_delivery_threshold']));
        }
        if (isset($_POST['delivery_fee'])) {
            Setting::set('delivery_fee', (string) max(0, (int) $_POST['delivery_fee']));
        }
        if (isset($_POST['free_delivery_city'])) {
            Setting::set('free_delivery_city', tf_clip(trim((string) $_POST['free_delivery_city']), 80));
        }
        if (isset($_POST['support_phone'])) {
            Setting::set('support_phone', tf_clip(trim((string) $_POST['support_phone']), 32));
        }
        if (isset($_POST['support_email'])) {
            $mail = trim((string) $_POST['support_email']);
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                Setting::set('support_email', $mail);
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
        $to = tf_admin_id();
        if ($to < 1) {
            flash_set('error', 'Support is unavailable right now.');
            redirect('dashboard/user/messages.php');
        }
        Message::send(current_user()['uid'], $to, 'Support', tf_clip($body, 2000));
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
        redirect_back('index.php');
    }

    default:
        if ($isJson) {
            json_response(['ok' => false, 'error' => 'Unknown action'], 400);
        }
        flash_set('error', 'Unknown action.');
        redirect('index.php');
}
