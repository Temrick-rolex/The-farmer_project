<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_login();
$user = current_user();
$tf_role = $user['role'];
$tf_page = 'messages';
$tf_heading = 'Messages / Support';
$tf_title = 'Messages · The Farmer';
$inbox = Message::inbox($user['uid']);
Message::markRead($user['uid']);
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Inbox</h2>
        <p>Support replies within a day. Mentors and the harvest desk write here too.</p>
    </div>
    <a class="btn btn-outline" href="mailto:<?= e(setting('support_email', TF_EMAIL)) ?>"><i class="fa-solid fa-envelope"></i> Email the farm</a>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-comments"></i> Recent threads</h3>
    </div>
    <div class="msg-list">
        <?php if (empty($inbox)): ?>
        <p class="muted" style="padding:18px">No messages yet. Write to the farm below.</p>
        <?php endif; ?>
        <?php foreach ($inbox as $msg): ?>
        <article class="msg-row<?= empty($msg['is_read']) ? ' unread' : '' ?>">
            <span class="avatar a1"><?= e(strtoupper(substr($msg['sender_name'] ?? 'F', 0, 1))) ?></span>
            <div>
                <strong><?= e($msg['sender_name'] ?? 'The Farmer') ?></strong>
                <p><?= e($msg['subject'] ? $msg['subject'] . ' — ' : '') ?><?= e($msg['body']) ?></p>
            </div>
            <time><?= e(date('j M', strtotime($msg['created_at']))) ?></time>
        </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="panel form-card">
    <div class="panel-head" style="padding-left:0;padding-right:0">
        <h3><i class="fa-solid fa-paper-plane"></i> Write to support</h3>
    </div>
    <form action="<?= e(url('process.php')) ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="send_message">
        <div class="field">
            <label for="body">Message</label>
            <input type="text" id="body" name="body" placeholder="Ask about an order, a tree, or a program…" required maxlength="2000">
        </div>
        <button class="btn btn-primary" type="submit">Send</button>
    </form>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
