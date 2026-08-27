<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['farmer', 'admin']);
$user = current_user();
$tf_role = 'farmer';
$tf_page = 'orders';
$tf_heading = 'Orders to fulfil';
$tf_title = 'Farmer orders · The Farmer';
$orders = Order::forVendor($user['uid']);
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
                <tr><th>Order</th><th>Buyer</th><th>Item</th><th>City</th><th>Amount</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                <?php if (!$orders): ?>
                <tr><td colspan="7" class="muted">No orders to fulfil.</td></tr>
                <?php endif; ?>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><strong><?= e($o['public_id'] ?? $o['id']) ?></strong></td>
                    <td><?= e($o['buyer']) ?></td>
                    <td><?= e($o['item']) ?></td>
                    <td><?= e($o['city']) ?></td>
                    <td><?= e(money($o['amount'])) ?></td>
                    <td><span class="badge <?= tf_status_ok($o['status']) ? '' : 'orange' ?>"><?= e(tf_status_label($o['status'])) ?></span></td>
                    <td>
                        <?php if (!in_array($o['status'], ['delivered', 'completed', 'cancelled'], true)): ?>
                        <form action="<?= e(url('process.php')) ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="fulfill_order">
                            <input type="hidden" name="order_id" value="<?= (int) $o['id'] ?>">
                            <select name="status" aria-label="Update status">
                                <option value="packing" <?= $o['status'] === 'packing' ? 'selected' : '' ?>>Packing</option>
                                <option value="in_delivery" <?= $o['status'] === 'in_delivery' ? 'selected' : '' ?>>In delivery</option>
                                <option value="delivered">Delivered</option>
                            </select>
                            <button class="btn btn-primary btn-sm" type="submit">Update</button>
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
