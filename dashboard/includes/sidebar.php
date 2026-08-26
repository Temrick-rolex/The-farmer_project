<?php
$user = current_user();
$tf_role = $tf_role ?? ($user['role'] ?? 'customer');
$tf_page = $tf_page ?? 'overview';
$home = tf_role_home($tf_role);
?>
<aside class="dash-sidebar" id="dashSidebar" aria-label="Dashboard">
    <div class="dash-brand">
        <a href="<?= e(url('index.php')) ?>">
            <img src="<?= e(asset('Image/RO.png')) ?>" alt="The Farmer logo">
            <span>The <b>Farmer</b></span>
        </a>
        <button class="icon-btn dash-sidebar-close" type="button" data-sidebar-close aria-label="Close menu"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="dash-user">
        <img src="<?= e(asset($user['avatar'])) ?>" alt="Avatar of <?= e($user['name']) ?>">
        <div>
            <strong><?= e($user['name']) ?></strong>
            <span><?= e(tf_role_label($tf_role)) ?> · <?= e($user['city']) ?></span>
        </div>
    </div>

    <nav class="dash-nav">
        <p class="dash-nav-label">Workspace</p>

        <?php if ($tf_role === 'farmer'): ?>
            <a class="<?= e(tf_active('overview', $tf_page)) ?>" href="<?= e(url('dashboard/farmer/index.php')) ?>"><i class="fa-solid fa-chart-line"></i> Dashboard Overview</a>
            <a class="<?= e(tf_active('products', $tf_page)) ?>" href="<?= e(url('dashboard/farmer/products.php')) ?>"><i class="fa-solid fa-seedling"></i> Inventory</a>
            <a class="<?= e(tf_active('orders', $tf_page)) ?>" href="<?= e(url('dashboard/farmer/orders.php')) ?>"><i class="fa-solid fa-box-open"></i> Orders to fulfil</a>
            <a class="<?= e(tf_active('product-new', $tf_page)) ?>" href="<?= e(url('dashboard/farmer/product-new.php')) ?>"><i class="fa-solid fa-plus"></i> Add product</a>
            <a class="<?= e(tf_active('messages', $tf_page)) ?>" href="<?= e(url('dashboard/user/messages.php')) ?>"><i class="fa-solid fa-comments"></i> Messages / Support</a>
        <?php elseif ($tf_role === 'admin'): ?>
            <a class="<?= e(tf_active('overview', $tf_page)) ?>" href="<?= e(url('dashboard/admin/index.php')) ?>"><i class="fa-solid fa-gauge-high"></i> Dashboard Overview</a>
            <a class="<?= e(tf_active('users', $tf_page)) ?>" href="<?= e(url('dashboard/admin/users.php')) ?>"><i class="fa-solid fa-users"></i> User management</a>
            <a class="<?= e(tf_active('products', $tf_page)) ?>" href="<?= e(url('dashboard/admin/products.php')) ?>"><i class="fa-solid fa-clipboard-check"></i> Product approval</a>
            <a class="<?= e(tf_active('opportunities', $tf_page)) ?>" href="<?= e(url('dashboard/admin/opportunities.php')) ?>"><i class="fa-solid fa-handshake"></i> Opportunity moderation</a>
            <a class="<?= e(tf_active('messages', $tf_page)) ?>" href="<?= e(url('dashboard/user/messages.php')) ?>"><i class="fa-solid fa-comments"></i> Messages / Support</a>
        <?php else: ?>
            <a class="<?= e(tf_active('overview', $tf_page)) ?>" href="<?= e(url('dashboard/user/index.php')) ?>"><i class="fa-solid fa-chart-line"></i> Dashboard Overview</a>
            <a class="<?= e(tf_active('orders', $tf_page)) ?>" href="<?= e(url('dashboard/user/orders.php')) ?>"><i class="fa-solid fa-bag-shopping"></i> My Orders</a>
            <a class="<?= e(tf_active('opportunities', $tf_page)) ?>" href="<?= e(url('dashboard/user/opportunities.php')) ?>"><i class="fa-solid fa-bookmark"></i> Saved Opportunities</a>
            <a class="<?= e(tf_active('messages', $tf_page)) ?>" href="<?= e(url('dashboard/user/messages.php')) ?>"><i class="fa-solid fa-comments"></i> Messages / Support</a>
        <?php endif; ?>

        <p class="dash-nav-label">User management</p>
        <a class="<?= e(tf_active('profile', $tf_page)) ?>" href="<?= e(url('dashboard/account/profile.php')) ?>"><i class="fa-solid fa-id-badge"></i> Profile</a>
        <a class="<?= e(tf_active('settings', $tf_page)) ?>" href="<?= e(url('dashboard/account/settings.php')) ?>"><i class="fa-solid fa-gears"></i> Settings</a>
    </nav>

    <div class="dash-sidebar-foot">
        <a class="dash-store-link" href="<?= e(url('index.php')) ?>"><i class="fa-solid fa-store"></i> Back to shop</a>
        <form action="<?= e(url('process.php')) ?>" method="POST">
            <input type="hidden" name="action" value="logout">
            <button class="btn btn-danger btn-block" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Log out</button>
        </form>
    </div>
</aside>
<div class="dash-scrim" id="dashScrim" data-sidebar-close hidden></div>
