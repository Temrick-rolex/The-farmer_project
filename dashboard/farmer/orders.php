<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'farmer';
$tf_page = 'orders';
$tf_heading = 'Orders to fulfil';
$tf_title = 'Farmer orders · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Recent sales</h2>
        <p>Pack in the farm kitchen, then city delivery or pickup in Yaoundé.</p>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-box-open"></i> Fulfilment queue</h3>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>Order</th><th>Buyer</th><th>Item</th><th>City</th><th>Amount</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php foreach ($TF_FARMER_ORDERS as $o): ?>
                <tr>
                    <td><strong><?= e($o['id']) ?></strong></td>
                    <td><?= e($o['buyer']) ?></td>
                    <td><?= e($o['item']) ?></td>
                    <td><?= e($o['city']) ?></td>
                    <td><?= e(money($o['amount'])) ?></td>
                    <td><span class="badge orange"><?= e($o['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
