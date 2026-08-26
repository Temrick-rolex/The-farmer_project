<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = current_user()['role'] ?? 'customer';
$tf_page = 'messages';
$tf_heading = 'Messages / Support';
$tf_title = 'Messages · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Inbox</h2>
        <p>Support replies within a day. Mentors and the harvest desk write here too.</p>
    </div>
    <a class="btn btn-outline" href="mailto:<?= e(TF_EMAIL) ?>"><i class="fa-solid fa-envelope"></i> Email the farm</a>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-comments"></i> Recent threads</h3>
    </div>
    <div class="msg-list">
        <?php foreach ($TF_MESSAGES as $msg): ?>
        <article class="msg-row<?= !empty($msg['unread']) ? ' unread' : '' ?>">
            <span class="avatar a1"><?= e(strtoupper(substr($msg['from'], 0, 1))) ?></span>
            <div>
                <strong><?= e($msg['from']) ?></strong>
                <p><?= e($msg['preview']) ?></p>
            </div>
            <time><?= e($msg['time']) ?></time>
        </article>
        <?php endforeach; ?>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
