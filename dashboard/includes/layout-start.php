<?php
$tf_dashboard = true;
$tf_body_class = 'dash-body';
$tf_title = $tf_title ?? 'Dashboard · The Farmer';
$tf_description = $tf_description ?? 'Your The Farmer workspace.';
$tf_role = $tf_role ?? (current_user()['role'] ?? 'customer');
$tf_page = $tf_page ?? 'overview';
$tf_heading = $tf_heading ?? 'Dashboard';
require TF_APP . '/includes/head.php';
?>
<div class="dash" id="dashShell">
    <?php require TF_DASHBOARD . '/includes/sidebar.php'; ?>
    <div class="dash-main">
        <?php require TF_DASHBOARD . '/includes/topbar.php'; ?>
        <div class="dash-content">
            <?php $tf_flash = flash_get(); ?>
            <?php if ($tf_flash): ?>
            <div class="dash-flash dash-flash-<?= e($tf_flash['type']) ?>" role="status">
                <i class="fa-solid fa-circle-info"></i>
                <span><?= e($tf_flash['message']) ?></span>
            </div>
            <?php endif; ?>
