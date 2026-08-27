<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_login();
$user = current_user();
$tf_role = $user['role'];
$tf_page = 'opportunities';
$tf_heading = 'Saved opportunities';
$tf_title = 'Saved opportunities · The Farmer';
$saved = Opportunity::savedBy($user['uid']);
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Programs you follow</h2>
        <p>Partnership, mentorship and jobs — the community side of The Farmer.</p>
    </div>
    <a class="btn btn-primary" href="<?= e(url('opportunity.php')) ?>">Browse programs</a>
</section>

<section class="quick-grid">
    <?php if (empty($saved)): ?>
    <article class="quick-card">
        <div class="feature-icon"><i class="fa-solid fa-bookmark"></i></div>
        <div>
            <h3>Nothing saved yet</h3>
            <p>Open Opportunities and apply — we call within 48 hours.</p>
        </div>
    </article>
    <?php endif; ?>
    <?php foreach ($saved as $op): ?>
    <article class="quick-card">
        <div class="feature-icon"><i class="fa-solid <?= e($op['icon'] ?: 'fa-handshake') ?>"></i></div>
        <div>
            <h3><?= e($op['title']) ?></h3>
            <p>Applied <?= e(date('j M Y', strtotime($op['applied_at']))) ?> · <strong><?= e(tf_status_label($op['application_status'])) ?></strong></p>
        </div>
    </article>
    <?php endforeach; ?>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
