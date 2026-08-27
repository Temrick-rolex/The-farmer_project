<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['admin']);
$tf_role = 'admin';
$tf_page = 'settings';
$tf_heading = 'System settings';
$tf_title = 'System settings · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Platform controls</h2>
        <p>Defaults for currency, delivery and the public storefront. Personal theme still lives under User management → Settings.</p>
    </div>
    <a class="btn btn-outline" href="<?= e(url('dashboard/account/settings.php')) ?>">My account settings</a>
</section>

<section class="settings-grid">
    <article class="set-card">
        <h3><span class="feature-icon"><i class="fa-solid fa-coins"></i></span> Commerce</h3>
        <p>Storefront settlement currency is XAF. Thresholds are stored as whole francs.</p>
        <form action="<?= e(url('process.php')) ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="update_system">
            <div class="field">
                <label for="free_delivery_threshold">Free delivery threshold (XAF)</label>
                <input type="number" id="free_delivery_threshold" name="free_delivery_threshold" min="0" step="100" value="<?= e(setting('free_delivery_threshold', '20000')) ?>">
            </div>
            <div class="field">
                <label for="delivery_fee">Delivery fee (XAF)</label>
                <input type="number" id="delivery_fee" name="delivery_fee" min="0" step="100" value="<?= e(setting('delivery_fee', '1000')) ?>">
            </div>
            <div class="field">
                <label for="free_delivery_city">Free-delivery city</label>
                <input type="text" id="free_delivery_city" name="free_delivery_city" value="<?= e(setting('free_delivery_city', 'Yaoundé')) ?>">
            </div>
            <button class="btn btn-primary btn-sm" type="submit">Save commerce</button>
        </form>
    </article>
    <article class="set-card">
        <h3><span class="feature-icon alt"><i class="fa-solid fa-headset"></i></span> Support</h3>
        <p>Shown on the public site and in order messages.</p>
        <form action="<?= e(url('process.php')) ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="update_system">
            <div class="field">
                <label for="support_phone">Phone</label>
                <input type="text" id="support_phone" name="support_phone" value="<?= e(setting('support_phone', TF_PHONE)) ?>">
            </div>
            <div class="field">
                <label for="support_email">Email</label>
                <input type="email" id="support_email" name="support_email" value="<?= e(setting('support_email', TF_EMAIL)) ?>">
            </div>
            <button class="btn btn-primary btn-sm" type="submit">Save support</button>
        </form>
        <ul class="feature-list" style="margin-top:18px">
            <li><i class="fa-solid fa-circle-check"></i> password_hash() on register</li>
            <li><i class="fa-solid fa-circle-check"></i> Prepared statements for MySQL</li>
            <li><i class="fa-solid fa-circle-check"></i> CSRF tokens on every POST</li>
        </ul>
    </article>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
