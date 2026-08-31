<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['farmer', 'admin']);
$user = current_user();
$tf_role = 'farmer';
$tf_page = 'overview';
$tf_heading = 'Farm overview';
$tf_title = 'Farmer dashboard · The Farmer';
$products = Product::forVendor($user['uid']);
$orders = Order::forVendor($user['uid']);
$sales = Order::salesForVendor($user['uid']);
$pending = Order::pendingCountForVendor($user['uid']);
$soldOut = Product::countStatus($user['uid'], 'sold_out');
$pendingListings = Product::countStatus($user['uid'], 'pending');
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Good day, grower <?= e($user['first_name']) ?>.</h2>
        <p>Track sales, restock citrus and fulfil orders heading out of Simbock / Mendong.</p>
    </div>
    <a class="btn btn-accent" href="<?= e(url('dashboard/farmer/product-new.php')) ?>"><i class="fa-solid fa-plus"></i> Add new product</a>
</section>

<section class="stat-grid">
    <article class="stat-card">
        <div class="feature-icon alt"><i class="fa-solid fa-coins"></i></div>
        <div>
            <div class="k">Total sales</div>
            <div class="v"><?= e(money($sales)) ?></div>
            <div class="hint">From paid orders</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon"><i class="fa-solid fa-seedling"></i></div>
        <div>
            <div class="k">Products listed</div>
            <div class="v"><?= e(count($products)) ?></div>
            <div class="hint"><?= e($pendingListings) ?> pending · <?= e($soldOut) ?> sold out</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon alt"><i class="fa-solid fa-box-open"></i></div>
        <div>
            <div class="k">Pending orders</div>
            <div class="v"><?= e($pending) ?></div>
            <div class="hint">To pack or deliver</div>
        </div>
    </article>
</section>

<section class="cta-strip">
    <div>
        <h3>List something new from the orchard</h3>
        <p>Trees, baskets, juice or a farm visit — priced in XAF, reviewed by admin.</p>
    </div>
    <a class="btn btn-ghost" href="<?= e(url('dashboard/farmer/product-new.php')) ?>">Add new product</a>
</section>

<section class="split-2">
    <section class="panel">
        <div class="panel-head">
            <h3><i class="fa-solid fa-warehouse"></i> Inventory</h3>
            <a class="btn btn-outline btn-sm" href="<?= e(url('dashboard/farmer/products.php')) ?>">Manage</a>
        </div>
        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr><th>Product</th><th>Stock</th><th>Price</th><th></th></tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                    <tr><td colspan="4" class="muted">No listings yet.</td></tr>
                    <?php endif; ?>
                    <?php foreach (array_slice($products, 0, 4) as $p): ?>
                    <tr>
                        <td><strong><?= e($p['name']) ?></strong></td>
                        <td><?= e($p['stock']) ?></td>
                        <td><?= e(money($p['price_xaf'])) ?></td>
                        <td><span class="badge <?= tf_status_ok($p['status']) ? '' : 'orange' ?>"><?= e(tf_status_label($p['status'])) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <div class="panel-head">
            <h3><i class="fa-solid fa-truck-fast"></i> To fulfil</h3>
            <a class="btn btn-outline btn-sm" href="<?= e(url('dashboard/farmer/orders.php')) ?>">All</a>
        </div>
        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr><th>Buyer</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                    <tr><td colspan="2" class="muted">No sales yet.</td></tr>
                    <?php endif; ?>
                    <?php foreach (array_slice($orders, 0, 4) as $o): ?>
                    <tr>
                        <td>
                            <strong><?= e($o['buyer']) ?></strong><br>
                            <span class="muted small"><?= e($o['item']) ?> · <?= e($o['city']) ?></span>
                        </td>
                        <td><span class="badge <?= tf_status_ok($o['status']) ? '' : 'orange' ?>"><?= e(tf_status_label($o['status'])) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
