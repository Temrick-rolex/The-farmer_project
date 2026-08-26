<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'customer';
$tf_page = 'orders';
$tf_heading = 'My orders';
$tf_title = 'My orders · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Order history</h2>
        <p>Every basket, tree and farm visit billed in XAF. Delivery in Yaoundé is free over 20,000 XAF.</p>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-bag-shopping"></i> All orders</h3>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>Order</th><th>Product</th><th>Date</th><th>Amount</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php foreach ($TF_ORDERS as $order): ?>
                <tr>
                    <td><strong><?= e($order['id']) ?></strong></td>
                    <td><?= e($order['item']) ?></td>
                    <td><?= e($order['date']) ?></td>
                    <td><?= e(money($order['amount'])) ?></td>
                    <td><span class="badge <?= $order['tone'] === 'ok' ? '' : 'orange' ?>"><?= e($order['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
