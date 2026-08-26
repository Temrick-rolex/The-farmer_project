<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$user = current_user();
$tf_role = $user['role'] ?? 'customer';
$tf_page = 'settings';
$tf_heading = 'Settings';
$tf_title = 'Settings · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Make The Farmer yours</h2>
        <p>Language, theme and display currency. Settlement on the farm stays in XAF.</p>
    </div>
</section>

<section class="settings-grid">
    <div class="set-card">
        <h3><span class="feature-icon"><i class="fa-solid fa-language"></i></span> Preferences</h3>
        <p>Saved on this device and applied automatically.</p>
        <form action="<?= e(url('process.php')) ?>" method="POST">
            <input type="hidden" name="action" value="update_settings">
            <div class="field">
                <label for="lang">Language</label>
                <select name="language" id="lang" data-pref="tf-lang">
                    <option value="english">English</option>
                    <option value="french">Français</option>
                    <option value="spanish">Español</option>
                </select>
            </div>
            <div class="field">
                <label for="themeSelect">Theme</label>
                <select name="theme" id="themeSelect" data-pref="tf-theme">
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                </select>
            </div>
            <div class="field">
                <label for="paymod">Display currency</label>
                <select name="currency" id="paymod" data-pref="tf-currency">
                    <option value="xaf">XAF (frs)</option>
                    <option value="usdt">USDT ($)</option>
                    <option value="eur">Euro (€)</option>
                </select>
            </div>
            <button class="btn btn-primary btn-sm" type="submit">Save preferences</button>
        </form>
    </div>

    <div class="set-card" id="password">
        <h3><span class="feature-icon alt"><i class="fa-solid fa-key"></i></span> Change password</h3>
        <p>We never display your current password. Use at least 8 characters.</p>
        <form action="<?= e(url('process.php')) ?>" method="POST">
            <input type="hidden" name="action" value="change_password">
            <div class="field">
                <label for="current_password">Current password</label>
                <div class="pw-wrap">
                    <input type="password" id="current_password" name="current_password" autocomplete="current-password" required>
                    <button type="button" class="pw-toggle" data-for="current_password" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="field">
                <label for="new_password">New password</label>
                <div class="pw-wrap">
                    <input type="password" id="new_password" name="new_password" autocomplete="new-password" minlength="8" required>
                    <button type="button" class="pw-toggle" data-for="new_password" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="field">
                <label for="confirm_password">Confirm new password</label>
                <div class="pw-wrap">
                    <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" minlength="8" required>
                    <button type="button" class="pw-toggle" data-for="confirm_password" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <button class="btn btn-primary btn-sm" type="submit">Update password</button>
        </form>
    </div>

    <div class="set-card">
        <h3><span class="feature-icon"><i class="fa-solid fa-star"></i></span> Rate us</h3>
        <p>How was your experience with The Farmer so far?</p>
        <div class="rate-stars" id="rateStars" role="radiogroup" aria-label="Rate us out of 5 stars">
            <button type="button" aria-label="1 star"><i class="fa-solid fa-star"></i></button>
            <button type="button" aria-label="2 stars"><i class="fa-solid fa-star"></i></button>
            <button type="button" aria-label="3 stars"><i class="fa-solid fa-star"></i></button>
            <button type="button" aria-label="4 stars"><i class="fa-solid fa-star"></i></button>
            <button type="button" aria-label="5 stars"><i class="fa-solid fa-star"></i></button>
        </div>
    </div>

    <div class="set-card">
        <h3><span class="feature-icon alt"><i class="fa-solid fa-circle-question"></i></span> Support</h3>
        <p>Questions about an order, a tree or a program? We answer within a day.</p>
        <div class="set-actions">
            <a class="btn btn-primary btn-sm" href="<?= e(url('dashboard/user/messages.php')) ?>"><i class="fa-solid fa-comments"></i> Open inbox</a>
            <a class="btn btn-outline btn-sm" href="tel:+237605048910"><i class="fa-solid fa-phone"></i> Call the farm</a>
        </div>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
