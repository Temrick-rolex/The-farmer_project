<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['admin']);
$tf_role = 'admin';
$tf_page = 'overview';
$tf_heading = 'Platform overview';
$tf_title = 'Admin dashboard · The Farmer';
$users = User::all();
$queue = Product::pendingApproval();
$opps = Opportunity::all();
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>The Farmer at a glance</h2>
        <p>Users, revenue and programs across Cameroon — Yaoundé shop plus partner farms.</p>
    </div>
    <a class="btn btn-outline" href="<?= e(url('dashboard/admin/settings.php')) ?>"><i class="fa-solid fa-sliders"></i> System settings</a>
</section>

<section class="stat-grid">
    <article class="stat-card">
        <div class="feature-icon"><i class="fa-solid fa-users"></i></div>
        <div>
            <div class="k">Total users</div>
            <div class="v"><?= e(User::count()) ?></div>
            <div class="hint">Customers, farmers, staff</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon alt"><i class="fa-solid fa-chart-column"></i></div>
        <div>
            <div class="k">Total revenue</div>
            <div class="v"><?= e(money(Order::revenue())) ?></div>
            <div class="hint">Paid orders in XAF</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon"><i class="fa-solid fa-handshake"></i></div>
        <div>
            <div class="k">Live programs</div>
            <div class="v"><?= e(Opportunity::countLive()) ?></div>
            <div class="hint"><?= e(Opportunity::countPending()) ?> awaiting review</div>
        </div>
    </article>
</section>

<section class="split-2">
    <section class="panel">
        <div class="panel-head">
            <h3><i class="fa-solid fa-user-check"></i> User management</h3>
            <a class="btn btn-outline btn-sm" href="<?= e(url('dashboard/admin/users.php')) ?>">Open</a>
        </div>
        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr><th>Name</th><th>Role</th><th>City</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr><td colspan="3" class="muted">No accounts yet.</td></tr>
                    <?php endif; ?>
                    <?php foreach (array_slice($users, 0, 5) as $u): ?>
                    <tr>
                        <td>
                            <strong><?= e($u['name']) ?></strong><br>
                            <span class="muted small"><?= e($u['public_id']) ?></span>
                        </td>
                        <td><?= e(tf_role_label($u['role'])) ?></td>
                        <td><?= e($u['city']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel">
        <div class="panel-head">
            <h3><i class="fa-solid fa-clipboard-check"></i> Approval queue</h3>
            <a class="btn btn-outline btn-sm" href="<?= e(url('dashboard/admin/products.php')) ?>">Review</a>
        </div>
        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr><th>Product</th><th>Vendor</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($queue)): ?>
                    <tr><td colspan="2" class="muted">Queue is clear.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($queue as $row): ?>
                    <tr>
                        <td>
                            <strong><?= e($row['name']) ?></strong><br>
                            <span class="muted small"><?= e(money($row['price_xaf'])) ?></span>
                        </td>
                        <td><?= e($row['vendor_name']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-handshake"></i> Opportunity program moderation</h3>
        <a class="btn btn-outline btn-sm" href="<?= e(url('dashboard/admin/opportunities.php')) ?>">Moderate</a>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>Program</th><th>Type</th><th>From</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php if (empty($opps)): ?>
                <tr><td colspan="4" class="muted">No programs yet.</td></tr>
                <?php endif; ?>
                <?php foreach ($opps as $row): ?>
                <tr>
                    <td><strong><?= e($row['title']) ?></strong></td>
                    <td><?= e(ucfirst($row['type'])) ?></td>
                    <td><?= e($row['creator_name'] ?? 'The Farmer') ?></td>
                    <td><span class="badge <?= tf_status_ok($row['status']) ? '' : 'orange' ?>"><?= e(tf_status_label($row['status'])) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
