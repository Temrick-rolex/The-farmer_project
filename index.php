<?php
require_once __DIR__ . '/app/includes/init.php';
$tf_nav = 'home';
$tf_title = 'The Farmer — Fresh citrus from Cameroon';
$tf_description = 'The Farmer grows healthy citrus in Cameroon. Buy mature fruit trees, fresh produce and juice, or join our farmer programs.';
$featured = Product::featured(4);
require TF_APP . '/includes/head.php';
require TF_APP . '/includes/header.php';
?>

<main>
    <section class="hero" style="--hero-img:url('<?= e(asset('Image/farm.jpg')) ?>')">
        <div class="hero-bg"></div>
        <div class="hero-scrim"></div>
        <div class="container">
            <div class="hero-inner">
                <p class="hero-eyebrow"><i class="fa-solid fa-earth-africa"></i> Yaoundé · Cameroon</p>
                <h1>From our orchards <span>to your family.</span></h1>
                <p class="hero-sub">The Farmer grows healthy citrus in Cameroon — buy mature fruit trees, fresh produce and juice, or join the programs that help young farmers thrive.</p>
                <div class="hero-cta">
                    <a class="btn btn-accent btn-lg" href="<?= e(url('product.php')) ?>"><i class="fa-solid fa-basket-shopping"></i> Shop the harvest</a>
                    <a class="btn btn-ghost btn-lg" href="<?= e(url('opportunity.php')) ?>">Become a partner</a>
                </div>
                <ul class="hero-stats">
                    <li><strong>120+</strong><span>trees ready to plant</span></li>
                    <li><strong>500+</strong><span>families served</span></li>
                    <li><strong>6</strong><span>programs for farmers</span></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section" id="about">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">Who we are</p>
                <h2>A Cameroonian farm collective</h2>
                <p>We grow citrus on rich highland soil and sell directly from our farm to your family — no middlemen, no cold storage, just fresh fruit.</p>
            </div>
            <div class="about-grid">
                <article class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-seedling"></i></div>
                    <h3>What we grow</h3>
                    <p>Valencia oranges, tangerines, lemons and limes — plus fresh juice and a small cellar of sparkling fruit drinks made from our own harvest.</p>
                    <ul class="feature-list">
                        <li><i class="fa-solid fa-circle-check"></i> Mature trees, ready to bear fruit</li>
                        <li><i class="fa-solid fa-circle-check"></i> Fresh produce picked the same week</li>
                        <li><i class="fa-solid fa-circle-check"></i> Farm-gate prices, zero middlemen</li>
                    </ul>
                </article>
                <article class="feature-card">
                    <div class="feature-icon alt"><i class="fa-solid fa-users"></i></div>
                    <h3>What we do</h3>
                    <p>More than a shop — we build a farming community: mentorship for new growers, partnerships for buyers, and real jobs on our farm.</p>
                    <ul class="feature-list">
                        <li><i class="fa-solid fa-circle-check"></i> Mentorship by experienced growers</li>
                        <li><i class="fa-solid fa-circle-check"></i> Partnership &amp; supply programs</li>
                        <li><i class="fa-solid fa-circle-check"></i> Farm visits and harvest days</li>
                    </ul>
                </article>
                <article class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-truck-fast"></i></div>
                    <h3>How we deliver</h3>
                    <p>Order today, pick up in Yaoundé (Simbock / Mendong) or get city delivery. Trees travel in their pots, ready to plant on day one.</p>
                    <ul class="feature-list">
                        <li><i class="fa-solid fa-circle-check"></i> Same-day pickup in Yaoundé</li>
                        <li><i class="fa-solid fa-circle-check"></i> Careful, protected tree transport</li>
                        <li><i class="fa-solid fa-circle-check"></i> Cash, mobile money or card</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <section class="section alt" id="featured">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">This week at the farm</p>
                <h2>Featured from the harvest</h2>
                <p>A few of our bestsellers, picked this week and packed for your table.</p>
            </div>
            <div class="product-grid">
                <?php foreach ($featured as $p): ?>
                    <?php $p['_eager'] = true; require TF_APP . '/includes/product-card.php'; ?>
                <?php endforeach; ?>
            </div>
            <p style="text-align:center;margin-top:38px">
                <a class="btn btn-outline" href="<?= e(url('product.php')) ?>">View all products <i class="fa-solid fa-arrow-right"></i></a>
            </p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">Life at the farm</p>
                <h2>A day in the orchard</h2>
            </div>
            <div class="carousel">
                <img src="<?= e(asset('Image/product-images/88423a61-a94d-4d96-ba54-62aa4372992c_1500x1875.jpeg')) ?>" alt="Valencia orange canopy full of fruit" class="active">
                <img src="<?= e(asset('Image/product-images/images-7.jpeg')) ?>" alt="Citrus harvest platter" loading="lazy">
                <img src="<?= e(asset('Image/farm2.jpg')) ?>" alt="Tractor working the fields" loading="lazy">
                <img src="<?= e(asset('Image/farm3.jpg')) ?>" alt="Green field at sunset" loading="lazy">
                <img src="<?= e(asset('Image/farm6.jpg')) ?>" alt="Crop rows stretching to the horizon" loading="lazy">
                <img src="<?= e(asset('Image/farm1.jpg')) ?>" alt="Sunset over the orchard" loading="lazy">
                <div class="carousel-dots" role="tablist" aria-label="Carousel slides"></div>
            </div>
        </div>
    </section>

    <section class="section alt">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">Testimonials</p>
                <h2>What our customers say</h2>
            </div>
            <div class="quote-grid">
                <article class="quote">
                    <i class="fa-solid fa-quote-left q-icon"></i>
                    <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                    <p>I bought two mature orange trees in March and they have been fruiting ever since. Delivery to Yaoundé was fast and very careful.</p>
                    <div class="quote-who">
                        <span class="avatar a1">BN</span>
                        <div><strong>Bella Ngwa</strong><span>Yaoundé</span></div>
                    </div>
                </article>
                <article class="quote">
                    <i class="fa-solid fa-quote-left q-icon"></i>
                    <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></span>
                    <p>The mentorship program helped me plan my first citrus plot. The tutors really know the land and they take time to explain everything.</p>
                    <div class="quote-who">
                        <span class="avatar a2">JM</span>
                        <div><strong>Jean-Claude Mbarga</strong><span>Bafoussam</span></div>
                    </div>
                </article>
                <article class="quote">
                    <i class="fa-solid fa-quote-left q-icon"></i>
                    <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                    <p>The best fresh oranges I have had outside the farm itself. I now order a basket every single week for my family.</p>
                    <div class="quote-who">
                        <span class="avatar a3">AS</span>
                        <div><strong>Aminata Salla</strong><span>Bamenda</span></div>
                    </div>
                </article>
                <article class="quote">
                    <i class="fa-solid fa-quote-left q-icon"></i>
                    <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star off"></i></span>
                    <p>Great platform overall. The harvest tour was fun for the kids and the fruit we picked was even better than the shop basket.</p>
                    <div class="quote-who">
                        <span class="avatar a4">PE</span>
                        <div><strong>Patrick Etoundi</strong><span>Douala</span></div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">Our sponsors &amp; partners</p>
            </div>
            <div class="sponsors">
                <a href="https://www.novadesign." target="_blank" rel="noopener"><img src="<?= e(asset('Image/logo-entreprise-2.png')) ?>" alt="Nova Collective Design" loading="lazy"></a>
                <a href="https://www.Myfarmpicker." target="_blank" rel="noopener"><img src="<?= e(asset('Image/or.jpeg')) ?>" alt="My Farm Picker" loading="lazy"></a>
                <a href="https://iaicameroun.com/" target="_blank" rel="noopener"><img src="<?= e(asset('Image/iai.webp')) ?>" alt="IAI Cameroon" loading="lazy"></a>
            </div>
        </div>
    </section>

    <section class="cta-band" style="--hero-img:url('<?= e(asset('Image/farm1.jpg')) ?>')">
        <div class="hero-bg"></div>
        <div class="hero-scrim"></div>
        <div class="container">
            <h2>Ready to put roots in the ground?</h2>
            <p>Join The Farmer today — plant a tree, stock your table, or build your own farm with our programs.</p>
            <div class="hero-cta">
                <a class="btn btn-accent btn-lg" href="<?= e(url('regform.php')) ?>"><i class="fa-solid fa-user-plus"></i> Create an account</a>
                <a class="btn btn-ghost btn-lg" href="<?= e(url('opportunity.php')) ?>">Explore opportunities</a>
            </div>
        </div>
    </section>
</main>

<?php require TF_APP . '/includes/footer.php'; ?>
