<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
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
        <p>Storefront settlement currency is XAF. Display conversion is optional.</p>
        <div class="field">
            <label>Default currency</label>
            <input type="text" value="XAF (CFA franc)" readonly>
        </div>
        <div class="field">
            <label>Free delivery threshold</label>
            <input type="text" value="20,000 XAF · Yaoundé" readonly>
        </div>
    </article>
    <article class="set-card">
        <h3><span class="feature-icon alt"><i class="fa-solid fa-shield-halved"></i></span> Safety</h3>
        <p>Passwords are hashed. Never display or log plaintext credentials.</p>
        <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check"></i> password_hash() on register</li>
            <li><i class="fa-solid fa-circle-check"></i> Prepared statements for MySQL</li>
            <li><i class="fa-solid fa-circle-check"></i> CSRF tokens on every POST</li>
        </ul>
    </article>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
