<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'admin';
$tf_page = 'opportunities';
$tf_heading = 'Opportunity moderation';
$tf_title = 'Opportunities · The Farmer';
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
                <?php foreach ($TF_OPPORTUNITY_QUEUE as $row): ?>
                <tr>
                    <td><strong><?= e($row['title']) ?></strong></td>
                    <td><?= e($row['type']) ?></td>
                    <td><?= e($row['from']) ?></td>
                    <td><span class="badge <?= $row['status'] === 'Live' ? '' : 'orange' ?>"><?= e($row['status']) ?></span></td>
                    <td class="cell-actions">
                        <button class="btn btn-primary btn-sm" type="button" data-demo="Published (demo)"><i class="fa-solid fa-bullhorn"></i> Publish</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
