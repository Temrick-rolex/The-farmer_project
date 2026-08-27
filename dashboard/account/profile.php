<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_login();
$user = current_user();
$tf_role = $user['role'] ?? 'customer';
$tf_page = 'profile';
$tf_heading = 'Profile';
$tf_title = 'Profile · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="profile-head">
    <img src="<?= e(asset($user['avatar'])) ?>" alt="Profile picture of <?= e($user['name']) ?>">
    <div class="ph-info">
        <h2><?= e($user['name']) ?></h2>
        <div class="ph-meta">
            <span class="badge"><i class="fa-solid fa-id-badge"></i> ID <?= e($user['id']) ?></span>
            <span class="badge orange"><i class="fa-solid fa-earth-africa"></i> <?= e($user['country']) ?></span>
            <span class="badge">Member since <?= e($user['member_since']) ?></span>
            <span class="badge"><?= e(tf_role_label($tf_role)) ?></span>
        </div>
    </div>
</section>

<section class="panel form-card">
    <div class="panel-head" style="padding-left:0;padding-right:0">
        <h3><i class="fa-solid fa-id-card"></i> Your details</h3>
    </div>
    <form id="profileForm" class="profile-form is-locked" action="<?= e(url('process.php')) ?>" method="POST" style="margin-top:18px">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="update_profile">
        <div class="form-row">
            <div class="field">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" value="<?= e($user['name']) ?>" required readonly>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= e($user['email']) ?>" required readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="<?= e($user['phone']) ?>" readonly>
            </div>
            <div class="field">
                <label for="payment">Payment method</label>
                <select id="payment" name="payment" disabled>
                    <option value="Cash" <?= $user['payment'] === 'Cash' ? 'selected' : '' ?>>Cash</option>
                    <option value="Mobile money" <?= $user['payment'] === 'Mobile money' || $user['payment'] === 'momo' ? 'selected' : '' ?>>Mobile money</option>
                    <option value="Visa" <?= $user['payment'] === 'Visa' ? 'selected' : '' ?>>Visa</option>
                    <option value="Bank card" <?= $user['payment'] === 'Bank card' || $user['payment'] === 'card' ? 'selected' : '' ?>>Bank card</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="address">Delivery address</label>
                <input type="text" id="address" name="address" value="<?= e($user['address']) ?>" readonly>
            </div>
            <div class="field">
                <label for="city">City</label>
                <input type="text" id="city" name="city" value="<?= e($user['city']) ?>" readonly>
            </div>
        </div>
        <div class="profile-actions">
            <button class="btn btn-primary" type="button" id="profileEditBtn"><i class="fa-solid fa-pen"></i> Update profile</button>
            <button class="btn btn-primary" type="submit" id="profileSaveBtn" hidden><i class="fa-solid fa-floppy-disk"></i> Save changes</button>
            <button class="btn btn-outline" type="button" id="profileCancelBtn" hidden>Cancel</button>
        </div>
    </form>
</section>

<section class="info-grid">
    <div class="info-card">
        <h3><i class="fa-solid fa-address-card"></i> Contact</h3>
        <div class="info-row"><span class="k"><i class="fa-solid fa-envelope"></i> Email</span><span class="v"><?= e($user['email']) ?></span></div>
        <div class="info-row"><span class="k"><i class="fa-solid fa-phone"></i> Phone</span><span class="v"><?= e($user['phone']) ?></span></div>
        <div class="info-row"><span class="k"><i class="fa-solid fa-location-dot"></i> Address</span><span class="v"><?= e($user['address']) ?></span></div>
        <div class="info-row"><span class="k"><i class="fa-solid fa-flag"></i> Country</span><span class="v"><?= e($user['country']) ?></span></div>
    </div>
    <div class="info-card">
        <h3><i class="fa-solid fa-shield-halved"></i> Security</h3>
        <div class="info-row"><span class="k"><i class="fa-solid fa-id-badge"></i> User ID</span><span class="v"><?= e($user['id']) ?></span></div>
        <div class="info-row"><span class="k"><i class="fa-solid fa-user"></i> Gender</span><span class="v"><?= e($user['gender']) ?></span></div>
        <div class="info-row"><span class="k"><i class="fa-solid fa-key"></i> Password</span><span class="v">••••••••</span></div>
        <p class="muted small" style="margin-top:14px">Passwords are never shown. Change yours from Settings.</p>
        <div class="info-actions">
            <a class="btn btn-outline btn-sm" href="<?= e(url('dashboard/account/settings.php')) ?>#password"><i class="fa-solid fa-key"></i> Change password</a>
        </div>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
