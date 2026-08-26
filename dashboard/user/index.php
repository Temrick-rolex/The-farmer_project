<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'customer';
$tf_page = 'overview';
$tf_heading = 'Overview';
$tf_title = 'Customer dashboard · The Farmer';
$user = current_user();
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Welcome back, <?= e($user['first_name']) ?>.</h2>
        <p>Your citrus orders, saved programs and wallet — all from Yaoundé to your door.</p>
    </div>
    <a class="btn btn-accent" href="<?= e(url('product.php')) ?>"><i class="fa-solid fa-basket-shopping"></i> Shop the harvest</a>
</section>

<section class="stat-grid">
    <article class="stat-card">
        <div class="feature-icon"><i class="fa-solid fa-bag-shopping"></i></div>
        <div>
            <div class="k">Total orders</div>
            <div class="v">8</div>
            <div class="hint">+2 this month</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon alt"><i class="fa-solid fa-handshake"></i></div>
        <div>
            <div class="k">Active opportunities</div>
            <div class="v">2</div>
            <div class="hint">1 accepted · 1 in review</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon"><i class="fa-solid fa-wallet"></i></div>
        <div>
            <div class="k">Wallet / dividend</div>
            <div class="v"><?= e(money($user['wallet'])) ?></div>
            <div class="hint">Available in XAF</div>
        </div>
    </article>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-receipt"></i> Recent orders</h3>
        <a class="btn btn-outline btn-sm" href="<?= e(url('dashboard/user/orders.php')) ?>">View all</a>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>Product</th><th>Date</th><th>Amount</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($TF_ORDERS, 0, 4) as $order): ?>
                <tr>
                    <td>
                        <strong><?= e($order['item']) ?></strong><br>
                        <span class="muted small"><?= e($order['id']) ?></span>
                    </td>
                    <td><?= e($order['date']) ?></td>
                    <td><?= e(money($order['amount'])) ?></td>
                    <td><span class="badge <?= $order['tone'] === 'ok' ? '' : 'orange' ?>"><?= e($order['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="quick-grid">
    <a class="quick-card" href="<?= e(url('dashboard/account/profile.php')) ?>">
        <div class="feature-icon"><i class="fa-solid fa-id-badge"></i></div>
        <div>
            <h3>Update profile</h3>
            <p>Name, phone, delivery address in Yaoundé or beyond.</p>
        </div>
    </a>
    <a class="quick-card" href="<?= e(url('dashboard/account/settings.php')) ?>">
        <div class="feature-icon alt"><i class="fa-solid fa-gears"></i></div>
        <div>
            <h3>Settings</h3>
            <p>Language, theme and currency (XAF / USDT / €).</p>
        </div>
    </a>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
