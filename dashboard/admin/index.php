<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'admin';
$tf_page = 'overview';
$tf_heading = 'Platform overview';
$tf_title = 'Admin dashboard · The Farmer';
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
            <div class="v">2,847</div>
            <div class="hint">+64 this week</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon alt"><i class="fa-solid fa-chart-column"></i></div>
        <div>
            <div class="k">Total revenue</div>
            <div class="v">18.4M XAF</div>
            <div class="hint">Season to date</div>
        </div>
    </article>
    <article class="stat-card">
        <div class="feature-icon"><i class="fa-solid fa-handshake"></i></div>
        <div>
            <div class="k">Active opportunities</div>
            <div class="v">6</div>
            <div class="hint">2 awaiting review</div>
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
                    <?php foreach (array_slice($TF_ADMIN_USERS, 0, 5) as $u): ?>
                    <tr>
                        <td>
                            <strong><?= e($u['name']) ?></strong><br>
                            <span class="muted small"><?= e($u['id']) ?></span>
                        </td>
                        <td><?= e($u['role']) ?></td>
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
                    <?php foreach ($TF_APPROVAL_QUEUE as $row): ?>
                    <tr>
                        <td>
                            <strong><?= e($row['product']) ?></strong><br>
                            <span class="muted small"><?= e(money($row['price'])) ?></span>
                        </td>
                        <td><?= e($row['vendor']) ?></td>
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
                <?php foreach ($TF_OPPORTUNITY_QUEUE as $row): ?>
                <tr>
                    <td><strong><?= e($row['title']) ?></strong></td>
                    <td><?= e($row['type']) ?></td>
                    <td><?= e($row['from']) ?></td>
                    <td><span class="badge <?= $row['status'] === 'Live' ? '' : 'orange' ?>"><?= e($row['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
