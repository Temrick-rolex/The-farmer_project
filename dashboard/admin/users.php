<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'admin';
$tf_page = 'users';
$tf_heading = 'User management';
$tf_title = 'Users · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>People on the platform</h2>
        <p>Customers, growers and staff. Roles control which dashboard they land in.</p>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-users"></i> Directory</h3>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>ID</th><th>Name</th><th>Role</th><th>City</th><th>Joined</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php foreach ($TF_ADMIN_USERS as $u): ?>
                <tr>
                    <td><?= e($u['id']) ?></td>
                    <td><strong><?= e($u['name']) ?></strong></td>
                    <td><?= e($u['role']) ?></td>
                    <td><?= e($u['city']) ?></td>
                    <td><?= e($u['joined']) ?></td>
                    <td><span class="badge"><?= e($u['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
