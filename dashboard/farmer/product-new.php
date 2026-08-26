<?php
require_once dirname(__DIR__, 2) . '/app/includes/init.php';
$tf_role = 'farmer';
$tf_page = 'product-new';
$tf_heading = 'Add a product';
$tf_title = 'Add product · The Farmer';
require TF_DASHBOARD . '/includes/layout-start.php';
?>

<section class="dash-welcome">
    <div>
        <h2>List a new harvest item</h2>
        <p>Admin reviews every listing before it appears in the shop. Price in whole XAF.</p>
    </div>
</section>

<section class="panel form-card">
    <form action="<?= e(url('process.php')) ?>" method="POST">
        <input type="hidden" name="action" value="add_product">
        <div class="form-row">
            <div class="field">
                <label for="pname">Product name</label>
                <input type="text" id="pname" name="name" placeholder="e.g. Fresh Limes — 3 kg" required>
            </div>
            <div class="field">
                <label for="pcat">Category</label>
                <select id="pcat" name="category">
                    <option value="trees">Trees</option>
                    <option value="fresh">Fresh fruit</option>
                    <option value="juice">Juice &amp; cellar</option>
                    <option value="experience">Experiences</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="field">
                <label for="pprice">Price (XAF)</label>
                <input type="number" id="pprice" name="price_xaf" min="100" step="100" placeholder="3500" required>
            </div>
            <div class="field">
                <label for="pstock">Stock</label>
                <input type="number" id="pstock" name="stock" min="0" step="1" placeholder="20" required>
            </div>
        </div>
        <div class="field">
            <label for="pdesc">Description</label>
            <input type="text" id="pdesc" name="description" placeholder="Picked this week in Simbock, ready for Yaoundé delivery.">
        </div>
        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-plus"></i> Submit for review</button>
    </form>
</section>

<?php require TF_DASHBOARD . '/includes/layout-end.php'; ?>
