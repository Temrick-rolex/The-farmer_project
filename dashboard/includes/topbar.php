<?php
$user = current_user();
$tf_heading = $tf_heading ?? 'Dashboard';
$tf_unread = Message::unreadCount((int) $user['uid']);
?>
<header class="dash-topbar">
    <button class="icon-btn dash-burger" type="button" data-sidebar-open aria-label="Open menu"><i class="fa-solid fa-bars"></i></button>
    <div class="dash-topbar-title">
        <p class="eyebrow">The Farmer · <?= e(tf_role_label($tf_role ?? $user['role'])) ?></p>
        <h1><?= e($tf_heading) ?></h1>
    </div>
    <div class="dash-topbar-actions">
        <button class="icon-btn theme-toggle" type="button" aria-label="Toggle dark mode"><i class="fa-solid fa-moon"></i></button>
        <a class="icon-btn" href="<?= e(url('dashboard/user/messages.php')) ?>" aria-label="Messages">
            <i class="fa-solid fa-bell"></i>
            <?php if ($tf_unread): ?><span class="dash-dot"></span><?php endif; ?>
        </a>
        <a class="dash-top-user" href="<?= e(url('dashboard/account/profile.php')) ?>">
            <img src="<?= e(asset($user['avatar'])) ?>" alt="">
            <span><?= e($user['first_name']) ?></span>
        </a>
    </div>
</header>
