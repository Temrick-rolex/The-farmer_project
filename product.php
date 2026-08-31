<?php
require_once __DIR__ . '/app/includes/init.php';
$tf_nav = 'products';
$tf_title = 'Products · The Farmer';
$tf_description = 'Shop mature fruit trees, fresh citrus, juice and farm experiences from The Farmer in Cameroon.';
$products = Product::allLive();
require TF_APP . '/includes/head.php';
require TF_APP . '/includes/header.php';
?>

<main>
    <section class="page-hero" style="--hero-img:url('<?= e(asset('Image/product-images/88423a61-a94d-4d96-ba54-62aa4372992c_1500x1875.jpeg')) ?>')">
        <div class="container">
            <div class="crumb"><a href="<?= e(url('index.php')) ?>">Home</a><span class="sep">/</span><span>Products</span></div>
            <h1>Shop the harvest</h1>
            <p>Mature trees, fresh fruit and farm-made juice — picked and packed in Yaoundé, delivered to your door.</p>
        </div>
    </section>

    <section class="section" style="padding-top:40px">
        <div class="container">
            <div class="shop-toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="productSearch" placeholder="Search products… (e.g. orange, juice, tree)" aria-label="Search products">
                </div>
                <div class="chips" id="catChips">
                    <button class="chip active" data-cat="all" type="button">All</button>
                    <button class="chip" data-cat="trees" type="button">Trees</button>
                    <button class="chip" data-cat="fresh" type="button">Fresh fruit</button>
                    <button class="chip" data-cat="juice" type="button">Juice &amp; cellar</button>
                    <button class="chip" data-cat="experience" type="button">Experiences</button>
                </div>
                <span class="results-count" id="resultsCount"></span>
            </div>

            <div class="product-grid">
                <?php foreach ($products as $p): ?>
                    <?php require TF_APP . '/includes/product-card.php'; ?>
                <?php endforeach; ?>
            </div>

            <?php if (empty($products)): ?>
            <div class="shop-empty show">
                <i class="fa-solid fa-seedling"></i>
                <h3>The shop is empty</h3>
                <p class="muted">Import <code>database/the_farmer.sql</code> and connect MySQL to load the harvest.</p>
            </div>
            <?php endif; ?>

            <div class="shop-empty" id="shopEmpty">
                <i class="fa-solid fa-magnifying-glass"></i>
                <h3>No products found</h3>
                <p class="muted">Try a different search or category.</p>
            </div>
        </div>
    </section>
</main>

<?php require TF_APP . '/includes/footer.php'; ?>
