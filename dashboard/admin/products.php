<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['admin']);
$tf_role = 'admin';
$tf_page = 'products';
$tf_heading = 'Product approval';
$tf_title = 'Product approval · The Farmer';
$queue = Product::pendingApproval();
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Approval queue</h2>
        <p>New listings from partner farms. Approve to publish in the shop at the stated XAF price.</p>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-clipboard-check"></i> Pending products</h3>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>Product</th><th>Vendor</th><th>Price</th><th>Submitted</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php if (!$queue): ?>
                <tr><td colspan="5" class="muted">Nothing waiting. New listings land here.</td></tr>
                <?php endif; ?>
                <?php foreach ($queue as $row): ?>
                <tr>
                    <td><strong><?= e($row['name']) ?></strong></td>
                    <td><?= e($row['vendor_name']) ?></td>
                    <td><?= e(money($row['price_xaf'])) ?></td>
                    <td><?= e(date('j M Y', strtotime($row['created_at']))) ?></td>
                    <td class="cell-actions">
                        <form action="<?= e(url('process.php')) ?>" method="POST" style="display:inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="approve_product">
                            <input type="hidden" name="product_id" value="<?= (int) $row['id'] ?>">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-check"></i> Approve</button>
                        </form>
                        <form action="<?= e(url('process.php')) ?>" method="POST" style="display:inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="reject_product">
                            <input type="hidden" name="product_id" value="<?= (int) $row['id'] ?>">
                            <button class="btn btn-danger btn-sm" type="submit" data-confirm="Reject this listing?"><i class="fa-solid fa-xmark"></i> Reject</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
