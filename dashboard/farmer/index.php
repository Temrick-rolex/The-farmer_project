<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'farmer';
$tf_page = 'overview';
$tf_heading = 'Farm overview';
$tf_title = 'Farmer dashboard · The Farmer';
$user = current_user();
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
            <div class="v">1,245,000 XAF</div>
            <div class="hint">This season</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon"><i class="fa-solid fa-seedling"></i></div>
        <div>
            <div class="k">Products listed</div>
            <div class="v">12</div>
            <div class="hint">1 sold out</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon alt"><i class="fa-solid fa-box-open"></i></div>
        <div>
            <div class="k">Pending orders</div>
            <div class="v">5</div>
            <div class="hint down">3 still to pack</div>
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
                    <?php foreach (array_slice($TF_FARMER_PRODUCTS, 0, 4) as $p): ?>
                    <tr>
                        <td><strong><?= e($p['name']) ?></strong></td>
                        <td><?= e($p['stock']) ?></td>
                        <td><?= e(money($p['price'])) ?></td>
                        <td><span class="badge <?= $p['status'] === 'Live' ? '' : 'orange' ?>"><?= e($p['status']) ?></span></td>
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
                    <?php foreach (array_slice($TF_FARMER_ORDERS, 0, 4) as $o): ?>
                    <tr>
                        <td>
                            <strong><?= e($o['buyer']) ?></strong><br>
                            <span class="muted small"><?= e($o['item']) ?> · <?= e($o['city']) ?></span>
                        </td>
                        <td><span class="badge orange"><?= e($o['status']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
