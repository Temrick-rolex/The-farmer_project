<?php
$pid = $p['id'];
$cat = $p['category'];
$badge = trim($p['badge'] ?? '');
$img = $p['image_path'] ?? 'Image/farm5.jpg';
$lazy = !empty($p['_eager']) ? '' : ' loading="lazy"';
?>
<article class="product-card" data-id="<?= e($pid) ?>" data-name="<?= e($p['name']) ?>" data-cat="<?= e($cat) ?>">
    <div class="pc-media">
        <img src="<?= e(asset($img)) ?>" alt="<?= e($p['name']) ?>"<?= $lazy ?>>
        <span class="pc-tag"><?= e(product_category_label($cat)) ?></span>
        <?php if ($badge !== ''): ?>
            <span class="pc-badge"><?= e($badge) ?></span>
        <?php endif; ?>
    </div>
    <div class="pc-body">
        <h3 class="pc-name"><?= e($p['name']) ?></h3>
        <div class="pc-rating"><?= stars_html($p['rating_avg'] ?? 0) ?><span><?= e(number_format($p['rating_avg'] ?? 0, 1)) ?></span></div>
        <p class="pc-desc"><?= e($p['description'] ?? '') ?></p>
        <div class="pc-foot">
            <span class="pc-price"><?= e(number_format($p['price_xaf'], 0, '.', ',')) ?> <small>XAF<?= $cat === 'experience' && (int) $pid === 11 ? ' / person' : '' ?></small></span>
            <?php if (($p['status'] ?? '') === 'sold_out' || (int) ($p['stock'] ?? 0) <= 0): ?>
                <button class="btn btn-outline btn-sm" type="button" disabled>Sold out</button>
            <?php else: ?>
                <button class="btn btn-primary btn-sm" data-add="<?= e($pid) ?>" type="button"><i class="fa-solid fa-cart-plus"></i> Add</button>
            <?php endif; ?>
        </div>
    </div>
</article>
