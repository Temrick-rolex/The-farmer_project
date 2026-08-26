<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'admin';
$tf_page = 'products';
$tf_heading = 'Product approval';
$tf_title = 'Product approval · The Farmer';
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
                <?php foreach ($TF_APPROVAL_QUEUE as $row): ?>
                <tr>
                    <td><strong><?= e($row['product']) ?></strong></td>
                    <td><?= e($row['vendor']) ?></td>
                    <td><?= e(money($row['price'])) ?></td>
                    <td><?= e($row['submitted']) ?></td>
                    <td class="cell-actions">
                        <button class="btn btn-primary btn-sm" type="button" data-demo="Approved (demo) — will write to products.status"><i class="fa-solid fa-check"></i> Approve</button>
                        <button class="btn btn-danger btn-sm" type="button" data-confirm="Reject this listing?" data-done="Rejected (demo)"><i class="fa-solid fa-xmark"></i> Reject</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
