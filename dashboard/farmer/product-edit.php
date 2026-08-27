<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
require_role(['farmer', 'admin']);
$user = current_user();
$id = (int) ($_GET['id'] ?? 0);
$p = Product::find($id);
?>
<?php if (!$p || ((int) $p['vendor_id'] !== $user['uid'] && $user['role'] !== 'admin')): ?>
<?php redirect('dashboard/farmer/products.php'); ?>
<?php endif; ?>
<?php
$tf_role = 'farmer';
$tf_page = 'products';
$tf_heading = 'Edit product';
$tf_title = 'Edit product · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2><?= e($p['name']) ?></h2>
        <p>Price in whole XAF. Stock 0 marks a live item sold out.</p>
    </div>
</section>

<section class="panel form-card">
    <form action="<?= e(url('process.php')) ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="update_product">
        <input type="hidden" name="product_id" value="<?= (int) $p['id'] ?>">
        <div class="form-row">
            <div class="field">
                <label for="pname">Product name</label>
                <input type="text" id="pname" name="name" value="<?= e($p['name']) ?>" required>
            </div>
            <div class="field">
                <label for="pcat">Category</label>
                <select id="pcat" name="category">
                    <option value="trees" <?= $p['category'] === 'trees' ? 'selected' : '' ?>>Trees</option>
                    <option value="fresh" <?= $p['category'] === 'fresh' ? 'selected' : '' ?>>Fresh fruit</option>
                    <option value="juice" <?= $p['category'] === 'juice' ? 'selected' : '' ?>>Juice &amp; cellar</option>
                    <option value="experience" <?= $p['category'] === 'experience' ? 'selected' : '' ?>>Experiences</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="pprice">Price (XAF)</label>
                <input type="number" id="pprice" name="price_xaf" min="100" step="100" value="<?= (int) $p['price_xaf'] ?>" required>
            </div>
            <div class="field">
                <label for="pstock">Stock</label>
                <input type="number" id="pstock" name="stock" min="0" step="1" value="<?= (int) $p['stock'] ?>" required>
            </div>
        </div>
        <div class="field">
            <label for="pdesc">Description</label>
            <input type="text" id="pdesc" name="description" value="<?= e($p['description']) ?>">
        </div>
        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save product</button>
    </form>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
