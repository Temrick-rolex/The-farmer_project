<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'farmer';
$tf_page = 'products';
$tf_heading = 'Inventory';
$tf_title = 'Inventory · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Your listed harvest</h2>
        <p>Stock counts and farm-gate prices in XAF. Sold-out items stay visible until you restock.</p>
    </div>
    <a class="btn btn-accent" href="<?= e(url('dashboard/farmer/product-new.php')) ?>"><i class="fa-solid fa-plus"></i> Add new product</a>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-seedling"></i> Products</h3>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>Product name</th><th>Stock</th><th>Price (XAF)</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($TF_FARMER_PRODUCTS as $p): ?>
                <tr>
                    <td><strong><?= e($p['name']) ?></strong></td>
                    <td><?= e($p['stock']) ?></td>
                    <td><?= e(money($p['price'])) ?></td>
                    <td><span class="badge <?= $p['status'] === 'Live' ? '' : 'orange' ?>"><?= e($p['status']) ?></span></td>
                    <td class="cell-actions">
                        <button class="btn btn-outline btn-sm" type="button" data-demo="Edit form arrives with the product model (demo)"><i class="fa-solid fa-pen"></i> Edit</button>
                        <button class="btn btn-danger btn-sm" type="button" data-confirm="Remove this product from the shop?" data-done="Product removed (demo)"><i class="fa-solid fa-trash-can"></i> Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
