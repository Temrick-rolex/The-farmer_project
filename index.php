<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Farmer — Fresh citrus from Cameroon</title>
    <meta name="description" content="The Farmer grows healthy citrus in Cameroon. Buy mature fruit trees, fresh produce and juice, or join our farmer programs.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Nunito+Sans:opsz,wght@6..12,400;6..12,600;6..12,700;6..12,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/fontawesome/css/all.css">
    <link rel="stylesheet" href="Assets/CSS/main.css">
    <link rel="shortcut icon" href="Assets/Image/RO.png" type="image/png">
    <script>(function(){try{var t=localStorage.getItem('tf-theme')||(matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light');document.documentElement.setAttribute('data-theme',t);}catch(e){document.documentElement.setAttribute('data-theme','light');}})();</script>
</head>
<body>

<header class="nav">
    <div class="container nav-inner">
        <a class="brand" href="index.php">
            <img src="Assets/Image/RO.png" alt="The Farmer logo">
            <span class="brand-name">The <b>Farmer</b></span>
        </a>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="index.php" class="active">Home</a>
            <a href="product.php">Products</a>
            <a href="opportunity.php">Opportunity</a>
            <a href="settings.php">Settings</a>
        </nav>
        <div class="nav-actions">
            <button class="icon-btn theme-toggle" aria-label="Toggle dark mode"><i class="fa-solid fa-moon"></i></button>
            <a class="icon-btn cart-link" href="product.php" aria-label="Open cart"><i class="fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></a>
            <a class="icon-btn" href="profile.php" aria-label="Your profile"><i class="fa-solid fa-user"></i></a>
            <a class="btn btn-accent btn-sm signup-btn" href="regform.php">Sign up</a>
            <button class="icon-btn nav-burger" aria-label="Menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
        </div>
    </div>
</header>

<main>
    <!-- ============ HERO ============ -->
    <section class="hero" style="--hero-img:url('Assets/Image/farm.jpg')">
        <div class="hero-bg"></div>
        <div class="hero-scrim"></div>
        <div class="container">
            <div class="hero-inner">
                <p class="hero-eyebrow"><i class="fa-solid fa-earth-africa"></i> Yaoundé · Cameroon</p>
                <h1>From our orchards <span>to your family.</span></h1>
                <p class="hero-sub">The Farmer grows healthy citrus in Cameroon — buy mature fruit trees, fresh produce and juice, or join the programs that help young farmers thrive.</p>
                <div class="hero-cta">
                    <a class="btn btn-accent btn-lg" href="product.php"><i class="fa-solid fa-basket-shopping"></i> Shop the harvest</a>
                    <a class="btn btn-ghost btn-lg" href="opportunity.php">Become a partner</a>
                </div>
                <ul class="hero-stats">
                    <li><strong>120+</strong><span>trees ready to plant</span></li>
                    <li><strong>500+</strong><span>families served</span></li>
                    <li><strong>6</strong><span>programs for farmers</span></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ============ WHO WE ARE ============ -->
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

    <!-- ============ FEATURED PRODUCTS ============ -->
    <section class="section alt" id="featured">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">This week at the farm</p>
                <h2>Featured from the harvest</h2>
                <p>A few of our bestsellers, picked this week and packed for your table.</p>
            </div>
            <div class="product-grid">
                <article class="product-card" data-id="p1" data-name="Mature Orange Tree (Valencia)" data-cat="trees">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/88423a61-a94d-4d96-ba54-62aa4372992c_1500x1875.jpeg" alt="Mature orange tree full of fruit">
                        <span class="pc-tag">Trees</span>
                        <span class="pc-badge">Bestseller</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Mature Orange Tree (Valencia)</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span><span>5.0</span></div>
                        <p class="pc-desc">4–5 year old tree, already bearing fruit. Potted, delivered and ready to plant in your yard.</p>
                        <div class="pc-foot">
                            <span class="pc-price">30,000 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p1"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>
                <article class="product-card" data-id="p3" data-name="Fresh Oranges — 5 kg basket" data-cat="fresh">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/Orange-Fruit-Pieces.jpg" alt="Fresh oranges" loading="lazy">
                        <span class="pc-tag">Fresh fruit</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Fresh Oranges — 5 kg basket</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span><span>4.8</span></div>
                        <p class="pc-desc">Hand-picked Valencia oranges, sweet and juicy. Delivered within 48 hours in Yaoundé.</p>
                        <div class="pc-foot">
                            <span class="pc-price">3,500 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p3"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>
                <article class="product-card" data-id="p6" data-name="Mixed Citrus Platter — 6 kg" data-cat="fresh">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/images-7.jpeg" alt="Mixed citrus platter" loading="lazy">
                        <span class="pc-tag">Fresh fruit</span>
                        <span class="pc-badge">New</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Mixed Citrus Platter — 6 kg</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span><span>4.9</span></div>
                        <p class="pc-desc">Our bestsellers on one platter: oranges, tangerines, lemons, limes and grapefruit.</p>
                        <div class="pc-foot">
                            <span class="pc-price">6,000 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p6"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>
                <article class="product-card" data-id="p7" data-name="Fresh Orange Juice — 1 L" data-cat="juice">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/94253411-orange-juice-in-a-glass-bottle-and-orange-fruit-with-green-leaves-isolated-on-white-background.jpg" alt="Fresh orange juice in a bottle" loading="lazy">
                        <span class="pc-tag">Juice &amp; cellar</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Fresh Orange Juice — 1 L</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></span><span>4.6</span></div>
                        <p class="pc-desc">Cold-pressed the same morning. No sugar, no water, no preservatives.</p>
                        <div class="pc-foot">
                            <span class="pc-price">1,800 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p7"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>
            </div>
            <p style="text-align:center;margin-top:38px">
                <a class="btn btn-outline" href="product.php">View all products <i class="fa-solid fa-arrow-right"></i></a>
            </p>
        </div>
    </section>

    <!-- ============ CAROUSEL ============ -->
    <section class="section">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">Life at the farm</p>
                <h2>A day in the orchard</h2>
            </div>
            <div class="carousel">
                <img src="Assets/Image/product-images/88423a61-a94d-4d96-ba54-62aa4372992c_1500x1875.jpeg" alt="Valencia orange canopy full of fruit" class="active">
                <img src="Assets/Image/product-images/images-7.jpeg" alt="Citrus harvest platter" loading="lazy">
                <img src="Assets/Image/farm2.jpg" alt="Tractor working the fields" loading="lazy">
                <img src="Assets/Image/farm3.jpg" alt="Green field at sunset" loading="lazy">
                <img src="Assets/Image/farm6.jpg" alt="Crop rows stretching to the horizon" loading="lazy">
                <img src="Assets/Image/farm1.jpg" alt="Sunset over the orchard" loading="lazy">
                <div class="carousel-dots" role="tablist" aria-label="Carousel slides"></div>
            </div>
        </div>
    </section>

    <!-- ============ TESTIMONIALS ============ -->
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
                        <div><strong>Patrick Etoundi</strong><span>Duala</span></div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- ============ SPONSORS ============ -->
    <section class="section">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">Our sponsors &amp; partners</p>
            </div>
            <div class="sponsors">
                <a href="https://www.novadesign." target="_blank" rel="noopener"><img src="Assets/Image/logo-entreprise-2.png" alt="Nova Collective Design" loading="lazy"></a>
                <a href="https://www.Myfarmpicker." target="_blank" rel="noopener"><img src="Assets/Image/or.jpeg" alt="My Farm Picker" loading="lazy"></a>
                <a href="https://iaicameroun.com/" target="_blank" rel="noopener"><img src="Assets/Image/iai.webp" alt="IAI Cameroon" loading="lazy"></a>
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="cta-band" style="--hero-img:url('Assets/Image/farm1.jpg')">
        <div class="hero-bg"></div>
        <div class="hero-scrim"></div>
        <div class="container">
            <h2>Ready to put roots in the ground?</h2>
            <p>Join The Farmer today — plant a tree, stock your table, or build your own farm with our programs.</p>
            <div class="hero-cta">
                <a class="btn btn-accent btn-lg" href="regform.php"><i class="fa-solid fa-user-plus"></i> Create an account</a>
                <a class="btn btn-ghost btn-lg" href="opportunity.php">Explore opportunities</a>
            </div>
        </div>
    </section>
</main>

<!-- ============ FOOTER ============ -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <a class="brand" href="index.php">
                    <img src="Assets/Image/RO.png" alt="The Farmer logo">
                    <span class="brand-name">The <b>Farmer</b></span>
                </a>
                <p>Fresh citrus from the Cameroonian highlands to your table. We grow it, we pick it, we deliver it — no middlemen.</p>
                <div class="socials">
                    <a href="#" aria-label="Telegram"><i class="fa-brands fa-telegram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#" aria-label="Discord"><i class="fa-brands fa-discord"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div>
                <h4>Explore</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="product.php">Products</a></li>
                    <li><a href="opportunity.php">Opportunity</a></li>
                    <li><a href="profile.php">My profile</a></li>
                </ul>
            </div>
            <div>
                <h4>Programs</h4>
                <ul>
                    <li><a href="opportunity.php">Partnership</a></li>
                    <li><a href="opportunity.php">Mentorship</a></li>
                    <li><a href="opportunity.php">Get employed</a></li>
                    <li><a href="opportunity.php">The Farmer News</a></li>
                </ul>
            </div>
            <div>
                <h4>Contact</h4>
                <div class="contact-row"><i class="fa-solid fa-location-dot"></i><span>Simbock / Mendong, Yaoundé — Cameroon</span></div>
                <div class="contact-row"><i class="fa-solid fa-phone"></i><a href="tel:+237605048910">+237 605 048 910</a></div>
                <div class="contact-row"><i class="fa-solid fa-envelope"></i><a href="mailto:temrick4@gmail.com">temrick4@gmail.com</a></div>
                <form id="newsletterForm" class="field" style="margin-top:18px">
                    <label for="newsletterEmail">Get daily farm news</label>
                    <div style="display:flex;gap:8px">
                        <input type="email" id="newsletterEmail" placeholder="Your email" required>
                        <button class="btn btn-primary" type="submit">Join</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© <span id="year">2026</span> The Farmer Project · All rights reserved</span>
            <div class="links">
                <a href="#" data-demo="Terms &amp; policy page coming soon">Terms &amp; policy</a>
                <a href="#" data-demo="FAQ page coming soon">FAQ</a>
            </div>
        </div>
    </div>
</footer>

<script src="Assets/JS/main.js"></script>
</body>
</html>
