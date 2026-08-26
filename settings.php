<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings · The Farmer</title>
    <meta name="description" content="Your The Farmer preferences: language, theme, currency, support and account.">
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
            <a href="product.php">Products</a>
            <a href="opportunity.php">Opportunity</a>
            <a href="settings.php" class="active">Settings</a>
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
    <section class="page-hero" style="--hero-img:url('Assets/Image/farm1.jpg')">
        <div class="container">
            <div class="crumb"><a href="index.php">Home</a><span class="sep">/</span><span>Settings</span></div>
            <h1>Settings</h1>
            <p>Make The Farmer yours — language, theme, currency and more.</p>
        </div>
    </section>

    <section class="section" style="padding-top:40px">
        <div class="container">
            <div class="settings-grid">

                <!-- preferences -->
                <div class="set-card">
                    <h3><span class="feature-icon"><i class="fa-solid fa-language"></i></span> Preferences</h3>
                    <p>Your choices are saved on this device and applied automatically.</p>
                    <div class="field">
                        <label for="lang">Language</label>
                        <select name="language" id="lang" data-pref="tf-lang">
                            <option value="english">English</option>
                            <option value="french">Français</option>
                            <option value="spanish">Español</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="themeSelect">Theme</label>
                        <select name="theme" id="themeSelect" data-pref="tf-theme">
                            <option value="light">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="paymod">Display currency</label>
                        <select name="currency" id="paymod" data-pref="tf-currency">
                            <option value="xaf">XAF (frs)</option>
                            <option value="usdt">USDT ($)</option>
                            <option value="gbp">Pound (£)</option>
                            <option value="eur">Euro (€)</option>
                        </select>
                    </div>
                </div>

                <!-- rate us -->
                <div class="set-card">
                    <h3><span class="feature-icon alt"><i class="fa-solid fa-star"></i></span> Rate us</h3>
                    <p>How was your experience with The Farmer so far?</p>
                    <div class="rate-stars" id="rateStars" role="radiogroup" aria-label="Rate us out of 5 stars">
                        <button type="button" aria-label="1 star"><i class="fa-solid fa-star"></i></button>
                        <button type="button" aria-label="2 stars"><i class="fa-solid fa-star"></i></button>
                        <button type="button" aria-label="3 stars"><i class="fa-solid fa-star"></i></button>
                        <button type="button" aria-label="4 stars"><i class="fa-solid fa-star"></i></button>
                        <button type="button" aria-label="5 stars"><i class="fa-solid fa-star"></i></button>
                    </div>
                    <p class="muted small" style="margin-top:14px">Your feedback keeps our farm — and our team — growing.</p>
                </div>

                <!-- support -->
                <div class="set-card">
                    <h3><span class="feature-icon"><i class="fa-solid fa-circle-question"></i></span> Support &amp; help</h3>
                    <p>Questions about an order, a tree or a program? Our team answers within a day.</p>
                    <div class="set-actions">
                        <button class="btn btn-primary btn-sm" data-demo="Chat with support arrives with the backend (demo)"><i class="fa-solid fa-comments"></i> Chat with support</button>
                        <button class="btn btn-outline btn-sm" data-demo="Help center coming soon (demo)"><i class="fa-solid fa-book-open-reader"></i> Help center</button>
                    </div>
                    <details style="margin-top:18px">
                        <summary>Quick answers</summary>
                        <p><strong>Delivery:</strong> 24–48 h in Yaoundé, 3–5 days nationwide.</p>
                        <p><strong>Trees:</strong> delivered in their pots, with a planting guide and 1 season of free grower support.</p>
                        <p><strong>Returns:</strong> fresh fruit can be exchanged within 24 h of delivery.</p>
                    </details>
                </div>

                <!-- about -->
                <div class="set-card">
                    <h3><span class="feature-icon alt"><i class="fa-solid fa-file-contract"></i></span> About The Farmer</h3>
                    <p>Who we are, in our own words.</p>
                    <details>
                        <summary>Read our story</summary>
                        <p>The Farmer started as a small citrus plot near Yaoundé and a simple idea: farmers should sell directly to the families that eat their fruit. Today we are a collective of growers, a shop, a mentorship school and a community — all under one green roof.</p>
                        <p>Every purchase supports our growers, our apprentices and the next season's seedlings.</p>
                    </details>
                </div>

                <!-- contact -->
                <div class="set-card">
                    <h3><span class="feature-icon"><i class="fa-solid fa-envelope"></i></span> Contact us</h3>
                    <p>Reach the farm directly — we answer everything, even the "is this orange?" questions.</p>
                    <div class="info-row"><span class="k"><i class="fa-solid fa-location-dot"></i> Farm</span><span class="v">Simbock / Mendong, Yaoundé</span></div>
                    <div class="info-row"><span class="k"><i class="fa-solid fa-phone"></i> Phone</span><span class="v">+237 605 048 910</span></div>
                    <div class="set-actions" style="margin-top:18px">
                        <a class="btn btn-accent btn-sm" href="mailto:temrick4@gmail.com"><i class="fa-solid fa-envelope-circle-check"></i> Email us</a>
                        <a class="btn btn-outline btn-sm" href="tel:+237605048910"><i class="fa-solid fa-phone"></i> Call the farm</a>
                    </div>
                </div>

                <!-- account -->
                <div class="set-card">
                    <h3><span class="feature-icon alt"><i class="fa-solid fa-user"></i></span> Account</h3>
                    <p>Signed in as <strong>John Doe</strong> (ID 01XJ00F).</p>
                    <div class="set-actions">
                        <a class="btn btn-outline btn-sm" href="profile.php"><i class="fa-solid fa-id-badge"></i> My profile</a>
                        <button class="btn btn-danger btn-sm" id="logoutBtn" data-confirm="Log out of The Farmer?" data-done="Logged out (demo)"><i class="fa-solid fa-right-from-bracket"></i> Log out</button>
                    </div>
                </div>

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
