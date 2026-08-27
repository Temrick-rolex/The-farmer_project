<?php $tf_flash = flash_get(); ?>
<?php if ($tf_flash): ?>
<?php $tone = $tf_flash['type'] === 'error' ? 'error' : ($tf_flash['type'] === 'info' ? 'info' : 'success'); ?>
<div class="dash-flash dash-flash-<?= e($tone) ?>" role="status" style="position:fixed;top:calc(var(--nav-h) + 12px);right:16px;z-index:240;max-width:min(420px,92vw);box-shadow:var(--shadow-lg)">
    <i class="fa-solid fa-circle-info"></i>
    <span><?= e($tf_flash['message']) ?></span>
</div>
<?php endif; ?>
