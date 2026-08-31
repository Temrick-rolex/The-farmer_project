<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['admin']);
$tf_role = 'admin';
$tf_page = 'users';
$tf_heading = 'User management';
$tf_title = 'Users · The Farmer';
$users = User::all();
$me = current_user();
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>People on the platform</h2>
        <p>Customers, growers and staff. Roles come from the account — they cannot be faked at login.</p>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-users"></i> Directory</h3>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>ID</th><th>Name</th><th>Role</th><th>City</th><th>Joined</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr><td colspan="7" class="muted">No users in the directory.</td></tr>
                <?php endif; ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= e($u['public_id']) ?></td>
                    <td><strong><?= e($u['name']) ?></strong><br><span class="muted small"><?= e($u['email']) ?></span></td>
                    <td><?= e(tf_role_label($u['role'])) ?></td>
                    <td><?= e($u['city']) ?></td>
                    <td><?= e(date('Y', strtotime($u['created_at']))) ?></td>
                    <td><span class="badge <?= $u['status'] === 'active' ? '' : 'orange' ?>"><?= e(tf_status_label($u['status'])) ?></span></td>
                    <td>
                        <?php if ((int) $u['id'] !== $me['uid']): ?>
                        <form action="<?= e(url('process.php')) ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="toggle_user">
                            <input type="hidden" name="user_id" value="<?= (int) $u['id'] ?>">
                            <button class="btn btn-outline btn-sm" type="submit"><?= $u['status'] === 'active' ? 'Suspend' : 'Reactivate' ?></button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
