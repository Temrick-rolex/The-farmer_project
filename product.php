<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products · The Farmer</title>
    <meta name="description" content="Shop mature fruit trees, fresh citrus, juice and farm experiences from The Farmer in Cameroon.">
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
            <a href="index.php">Home</a>
            <a href="product.php" class="active">Products</a>
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
    <!-- ============ PAGE HERO ============ -->
    <section class="page-hero" style="--hero-img:url('Assets/Image/product-images/88423a61-a94d-4d96-ba54-62aa4372992c_1500x1875.jpeg')">
        <div class="container">
            <div class="crumb"><a href="index.php">Home</a><span class="sep">/</span><span>Products</span></div>
            <h1>Shop the harvest</h1>
            <p>Mature trees, fresh fruit and farm-made juice — picked and packed in Yaoundé, delivered to your door.</p>
        </div>
    </section>

    <!-- ============ SHOP ============ -->
    <section class="section" style="padding-top:40px">
        <div class="container">
            <div class="shop-toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="productSearch" placeholder="Search products… (e.g. orange, juice, tree)" aria-label="Search products">
                </div>
                <div class="chips" id="catChips">
                    <button class="chip active" data-cat="all">All</button>
                    <button class="chip" data-cat="trees">Trees</button>
                    <button class="chip" data-cat="fresh">Fresh fruit</button>
                    <button class="chip" data-cat="juice">Juice &amp; cellar</button>
                    <button class="chip" data-cat="experience">Experiences</button>
                </div>
                <span class="results-count" id="resultsCount"></span>
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

                <article class="product-card" data-id="p2" data-name="Mature Tangerine Tree" data-cat="trees">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/Tangerine-SpotlessFruitsIndia_1024x1024.png" alt="Mature tangerine tree" loading="lazy">
                        <span class="pc-tag">Trees</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Mature Tangerine Tree</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></span><span>4.5</span></div>
                        <p class="pc-desc">Dense, reliable tangerine canopy. Plant it once, harvest it every winter for years.</p>
                        <div class="pc-foot">
                            <span class="pc-price">25,000 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p2"><i class="fa-solid fa-cart-plus"></i> Add</button>
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

                <article class="product-card" data-id="p4" data-name="Fresh Lemons — 3 kg" data-cat="fresh">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/27554428-lemon-fruits-with-leaves-isolated-on-white.jpg" alt="Fresh lemons" loading="lazy">
                        <span class="pc-tag">Fresh fruit</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Fresh Lemons — 3 kg</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></span><span>4.5</span></div>
                        <p class="pc-desc">Bright, zesty lemons picked in the morning for maximum juice and aroma.</p>
                        <div class="pc-foot">
                            <span class="pc-price">2,800 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p4"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>

                <article class="product-card" data-id="p5" data-name="Fresh Limes — 3 kg" data-cat="fresh">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/Lime-copy-scaled-1.jpg" alt="Fresh limes" loading="lazy">
                        <span class="pc-tag">Fresh fruit</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Fresh Limes — 3 kg</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star off"></i></span><span>4.3</span></div>
                        <p class="pc-desc">Fragrant green limes, perfect for juice, tea, marinades and cooking.</p>
                        <div class="pc-foot">
                            <span class="pc-price">2,500 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p5"><i class="fa-solid fa-cart-plus"></i> Add</button>
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

                <article class="product-card" data-id="p8" data-name="Fresh Lemon Juice — 1 L" data-cat="juice">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/bottle-lemon-juice-fresh-lemons-25336807.jpg" alt="Fresh lemon juice in a bottle" loading="lazy">
                        <span class="pc-tag">Juice &amp; cellar</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Fresh Lemon Juice — 1 L</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star off"></i></span><span>4.4</span></div>
                        <p class="pc-desc">Sun-bright lemon juice, pressed to order in our farm kitchen.</p>
                        <div class="pc-foot">
                            <span class="pc-price">1,800 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p8"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>

                <article class="product-card" data-id="p9" data-name="Sparkling Grapefruit — 750 ml" data-cat="juice">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/cd2304634ba009da07e0e2f77650cedc0cf695de213a16fd6171548fed4629d4.jpg" alt="Sparkling grapefruit bottle" loading="lazy">
                        <span class="pc-tag">Juice &amp; cellar</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Sparkling Grapefruit — 750 ml</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star off"></i></span><span>4.2</span></div>
                        <p class="pc-desc">Our cellar's pink sparkling grapefruit — dry, fizzy and festive.</p>
                        <div class="pc-foot">
                            <span class="pc-price">8,500 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p9"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>

                <article class="product-card" data-id="p10" data-name="Natural Orange Wine — 750 ml" data-cat="juice">
                    <div class="pc-media">
                        <img src="Assets/Image/product-images/images2.jpeg" alt="Natural orange wine bottle and glass" loading="lazy">
                        <span class="pc-tag">Juice &amp; cellar</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Natural Orange Wine — 750 ml</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></span><span>4.7</span></div>
                        <p class="pc-desc">Vegan orange wine from our own harvest. No added sugars, yeasts or sulphites.</p>
                        <div class="pc-foot">
                            <span class="pc-price">9,000 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p10"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>

                <article class="product-card" data-id="p11" data-name="Farm Visit & Self-Harvest" data-cat="experience">
                    <div class="pc-media">
                        <img src="Assets/Image/farm6.jpg" alt="Crop rows at the farm" loading="lazy">
                        <span class="pc-tag">Experiences</span>
                        <span class="pc-badge">Popular</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Farm Visit &amp; Self-Harvest</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span><span>5.0</span></div>
                        <p class="pc-desc">Spend a day with our growers, pick your own fruit basket and take the harvest home.</p>
                        <div class="pc-foot">
                            <span class="pc-price">15,000 <small>XAF / person</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p11"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>

                <article class="product-card" data-id="p12" data-name="Orchard Box — 1 month" data-cat="experience">
                    <div class="pc-media">
                        <img src="Assets/Image/farm5.jpg" alt="Orchard box with fresh fruit and juice" loading="lazy">
                        <span class="pc-tag">Experiences</span>
                    </div>
                    <div class="pc-body">
                        <h3 class="pc-name">Orchard Box — 1 month</h3>
                        <div class="pc-rating"><span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i></span><span>4.6</span></div>
                        <p class="pc-desc">A weekly box of seasonal citrus, fresh juice and farm news delivered to your door.</p>
                        <div class="pc-foot">
                            <span class="pc-price">12,000 <small>XAF</small></span>
                            <button class="btn btn-primary btn-sm" data-add="p12"><i class="fa-solid fa-cart-plus"></i> Add</button>
                        </div>
                    </div>
                </article>
            </div>

            <div class="shop-empty" id="shopEmpty">
                <i class="fa-solid fa-magnifying-glass"></i>
                <h3>No products found</h3>
                <p class="muted">Try a different search or category.</p>
            </div>
        </div>
    </section>
</main>

<!-- ============ CART ============ -->
<button class="cart-fab" id="cartFab" aria-label="Open cart">
    <i class="fa-solid fa-cart-shopping"></i>
    <span class="fab-count">0</span>
</button>
<div class="cart-overlay" id="cartOverlay"></div>
<aside class="cart-drawer" id="cartDrawer" aria-label="Shopping cart" aria-hidden="true">
    <header class="cart-head">
        <h2><i class="fa-solid fa-basket-shopping"></i> Your cart</h2>
        <button class="icon-btn" id="cartClose" aria-label="Close cart"><i class="fa-solid fa-xmark"></i></button>
    </header>
    <div class="cart-user">
        <img src="Assets/Image/profile.jpg" alt="Profile picture of John Doe">
        <div>
            <strong>John Doe</strong>
            <span>Yaoundé, Cameroon · ID 01XJ00F</span>
        </div>
    </div>
    <div class="cart-items" id="cartItems"></div>
    <div class="cart-empty" id="cartEmpty">
        <i class="fa-solid fa-basket-shopping"></i>
        <p>Your cart is empty</p>
        <span class="small muted">Add some fresh fruit from the harvest!</span>
    </div>
    <footer class="cart-foot" style="display:none">
        <div class="cart-line"><span>Subtotal</span><span id="cartSubtotal">0 XAF</span></div>
        <div class="cart-line"><span>Delivery</span><span id="cartDelivery">—</span></div>
        <div class="cart-line total"><span>Total</span><span id="cartTotal">0 XAF</span></div>
        <button class="btn btn-accent btn-block" id="checkoutBtn"><i class="fa-solid fa-wallet"></i> Checkout</button>
        <p class="cart-note">Free delivery in Yaoundé on orders over 20,000 XAF</p>
    </footer>
</aside>

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
