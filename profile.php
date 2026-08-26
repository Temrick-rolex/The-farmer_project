<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My profile · The Farmer</title>
    <meta name="description" content="Manage your The Farmer account, contact details and recent orders.">
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
    <section class="page-hero" style="--hero-img:url('Assets/Image/farm3.jpg')">
        <div class="container">
            <div class="crumb"><a href="index.php">Home</a><span class="sep">/</span><span>My profile</span></div>
            <h1>My profile</h1>
            <p>Your account details, contact information and order history — all in one place.</p>
        </div>
    </section>

    <section class="section" style="padding-top:40px">
        <div class="container">

            <!-- profile header -->
            <div class="profile-head">
                <img src="Assets/Image/profile.jpg" alt="Profile picture of John Doe">
                <div class="ph-info">
                    <h2>John Doe</h2>
                    <div class="ph-meta">
                        <span class="badge"><i class="fa-solid fa-id-badge"></i> ID 01XJ00F</span>
                        <span class="badge orange"><i class="fa-solid fa-earth-africa"></i> Cameroon</span>
                        <span class="badge">Member since 2024</span>
                    </div>
                </div>
                <button class="btn btn-outline" data-demo="Profile editing arrives with the backend (demo)"><i class="fa-solid fa-pen-clip"></i> Edit profile</button>
            </div>

            <!-- info grid -->
            <div class="info-grid">
                <div class="info-card">
                    <h3><i class="fa-solid fa-address-card"></i> Contact details</h3>
                    <div class="info-row"><span class="k"><i class="fa-solid fa-envelope"></i> Email</span><span class="v">johndoe@gmail.com</span></div>
                    <div class="info-row"><span class="k"><i class="fa-solid fa-phone"></i> Phone</span><span class="v">+237 605 048 910</span></div>
                    <div class="info-row"><span class="k"><i class="fa-solid fa-location-dot"></i> Address</span><span class="v">Yaoundé, Simbock — Mendong</span></div>
                    <div class="info-row"><span class="k"><i class="fa-solid fa-flag"></i> Country</span><span class="v">Cameroon</span></div>
                </div>
                <div class="info-card">
                    <h3><i class="fa-solid fa-user"></i> Account</h3>
                    <div class="info-row"><span class="k"><i class="fa-solid fa-id-badge"></i> User ID</span><span class="v">01XJ00F</span></div>
                    <div class="info-row">
                        <span class="k"><i class="fa-solid fa-wallet"></i> Payment method</span>
                        <span class="v">Cash</span>
                    </div>
                    <div class="info-row"><span class="k"><i class="fa-solid fa-user"></i> Gender</span><span class="v">Male</span></div>
                    <div class="info-row">
                        <span class="k"><i class="fa-solid fa-shield-halved"></i> Password</span>
                        <span class="v">
                            <input type="password" id="profilePassword" value="457780" readonly style="border:none;background:transparent;font-weight:700;width:90px;text-align:right;cursor:default">
                            <button class="pw-toggle" data-for="profilePassword" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                        </span>
                    </div>
                    <div class="info-actions">
                        <button class="btn btn-outline btn-sm" data-demo="Password change arrives with the backend (demo)"><i class="fa-solid fa-key"></i> Change password</button>
                        <button class="btn btn-danger btn-sm" data-confirm="Are you sure you want to delete your account? This cannot be undone." data-done="Account deleted (demo)"><i class="fa-solid fa-trash-can"></i> Delete account</button>
                    </div>
                </div>
            </div>

            <!-- recent orders -->
            <div class="orders">
                <h3>Recent orders</h3>
                <table>
                    <thead>
                        <tr><th>Order</th><th>Item</th><th>Total</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>TF-1042</strong><br><span class="muted small">12 Aug 2026</span></td>
                            <td>Mixed Citrus Platter — 6 kg</td>
                            <td>6,000 XAF</td>
                            <td><span class="badge"><i class="fa-solid fa-circle-check"></i> Delivered</span></td>
                        </tr>
                        <tr>
                            <td><strong>TF-1017</strong><br><span class="muted small">28 Jul 2026</span></td>
                            <td>Mature Orange Tree (Valencia)</td>
                            <td>30,000 XAF</td>
                            <td><span class="badge orange"><i class="fa-solid fa-truck-fast"></i> In delivery</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p style="text-align:center;margin-top:44px">
                <a class="btn btn-primary" href="product.php"><i class="fa-solid fa-basket-shopping"></i> Continue shopping</a>
                <a class="btn btn-outline" href="settings.php" style="margin-left:10px"><i class="fa-solid fa-gears"></i> Settings</a>
            </p>
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
