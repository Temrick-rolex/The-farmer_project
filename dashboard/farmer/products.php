<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['farmer', 'admin']);
$user = current_user();
$tf_role = 'farmer';
$tf_page = 'products';
$tf_heading = 'Inventory';
$tf_title = 'Inventory · The Farmer';
$products = Product::forVendor($user['uid']);
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
                <?php if (empty($products)): ?>
                <tr><td colspan="5" class="muted">No products yet. Add one from the orchard.</td></tr>
                <?php endif; ?>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><strong><?= e($p['name']) ?></strong></td>
                    <td><?= e($p['stock']) ?></td>
                    <td><?= e(money($p['price_xaf'])) ?></td>
                    <td><span class="badge <?= tf_status_ok($p['status']) ? '' : 'orange' ?>"><?= e(tf_status_label($p['status'])) ?></span></td>
                    <td class="cell-actions">
                        <a class="btn btn-outline btn-sm" href="<?= e(url('dashboard/farmer/product-edit.php?id=' . (int) $p['id'])) ?>"><i class="fa-solid fa-pen"></i> Edit</a>
                        <?php if (in_array($p['status'], ['pending', 'rejected'], true)): ?>
                        <form action="<?= e(url('process.php')) ?>" method="POST" style="display:inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="delete_product">
                            <input type="hidden" name="product_id" value="<?= (int) $p['id'] ?>">
                            <button class="btn btn-danger btn-sm" type="submit" data-confirm="Remove this listing?"><i class="fa-solid fa-trash-can"></i> Delete</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
