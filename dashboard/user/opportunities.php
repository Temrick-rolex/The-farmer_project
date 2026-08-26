<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'customer';
$tf_page = 'opportunities';
$tf_heading = 'Saved opportunities';
$tf_title = 'Saved opportunities · The Farmer';
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
    <?php foreach ($TF_SAVED_OPPORTUNITIES as $op): ?>
    <article class="quick-card">
        <div class="feature-icon"><i class="fa-solid <?= e($op['icon']) ?>"></i></div>
        <div>
            <h3><?= e($op['title']) ?></h3>
            <p>Applied <?= e($op['applied']) ?> · <strong><?= e($op['status']) ?></strong></p>
        </div>
    </article>
    <?php endforeach; ?>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
