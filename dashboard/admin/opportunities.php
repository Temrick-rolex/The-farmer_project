<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['admin']);
$tf_role = 'admin';
$tf_page = 'opportunities';
$tf_heading = 'Opportunity moderation';
$tf_title = 'Opportunities · The Farmer';
$opps = Opportunity::all();
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>Community programs</h2>
        <p>Partnerships, mentorship seats and farm jobs waiting to go live.</p>
    </div>
</section>

<section class="panel">
    <div class="panel-head">
        <h3><i class="fa-solid fa-handshake"></i> Program queue</h3>
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr><th>Title</th><th>Type</th><th>From</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($opps as $row): ?>
                <tr>
                    <td><strong><?= e($row['title']) ?></strong></td>
                    <td><?= e(ucfirst($row['type'])) ?></td>
                    <td><?= e($row['creator_name'] ?? 'The Farmer') ?></td>
                    <td><span class="badge <?= tf_status_ok($row['status']) ? '' : 'orange' ?>"><?= e(tf_status_label($row['status'])) ?></span></td>
                    <td class="cell-actions">
                        <?php if ($row['status'] !== 'live'): ?>
                        <form action="<?= e(url('process.php')) ?>" method="POST" style="display:inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="publish_opportunity">
                            <input type="hidden" name="opportunity_id" value="<?= (int) $row['id'] ?>">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-bullhorn"></i> Publish</button>
                        </form>
                        <?php else: ?>
                        <form action="<?= e(url('process.php')) ?>" method="POST" style="display:inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="action" value="close_opportunity">
                            <input type="hidden" name="opportunity_id" value="<?= (int) $row['id'] ?>">
                            <button class="btn btn-outline btn-sm" type="submit">Close</button>
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
