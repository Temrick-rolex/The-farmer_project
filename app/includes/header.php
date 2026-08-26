<?php
/** Public storefront navbar. Profile & Settings live in the dashboard only. */
$tf_nav = $tf_nav ?? '';
$tf_logged = is_logged_in();
?>
<header class="nav">
    <div class="container nav-inner">
        <a class="brand" href="<?= e(url('index.php')) ?>">
            <img src="<?= e(asset('Image/RO.png')) ?>" alt="The Farmer logo">
            <span class="brand-name">The <b>Farmer</b></span>
        </a>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="<?= e(url('index.php')) ?>" class="<?= e(tf_active('home', $tf_nav)) ?>">Home</a>
            <a href="<?= e(url('product.php')) ?>" class="<?= e(tf_active('products', $tf_nav)) ?>">Products</a>
            <a href="<?= e(url('opportunity.php')) ?>" class="<?= e(tf_active('opportunity', $tf_nav)) ?>">Opportunities</a>
        </nav>
        <div class="nav-actions">
            <button class="icon-btn theme-toggle" aria-label="Toggle dark mode" type="button"><i class="fa-solid fa-moon"></i></button>
            <a class="icon-btn cart-link" href="<?= e(url('product.php')) ?>" aria-label="Open cart"><i class="fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a>
            <?php if ($tf_logged): ?>
                <a class="btn btn-outline btn-sm signup-btn" href="<?= e(tf_role_home()) ?>">Dashboard</a>
            <?php else: ?>
                <a class="btn btn-outline btn-sm" href="<?= e(url('regform.php')) ?>">Log in</a>
                <a class="btn btn-accent btn-sm signup-btn" href="<?= e(url('regform.php')) ?>">Register</a>
            <?php endif; ?>
            <button class="icon-btn nav-burger" aria-label="Menu" aria-expanded="false" type="button"><i class="fa-solid fa-bars"></i></button>
        </div>
    </div>
</header>
