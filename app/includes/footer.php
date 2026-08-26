<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <a class="brand" href="<?= e(url('index.php')) ?>">
                    <img src="<?= e(asset('Image/RO.png')) ?>" alt="The Farmer logo">
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
                    <li><a href="<?= e(url('index.php')) ?>">Home</a></li>
                    <li><a href="<?= e(url('product.php')) ?>">Products</a></li>
                    <li><a href="<?= e(url('opportunity.php')) ?>">Opportunities</a></li>
                    <li><a href="<?= e(url('regform.php')) ?>">Log in / Register</a></li>
                </ul>
            </div>
            <div>
                <h4>Programs</h4>
                <ul>
                    <li><a href="<?= e(url('opportunity.php')) ?>">Partnership</a></li>
                    <li><a href="<?= e(url('opportunity.php')) ?>">Mentorship</a></li>
                    <li><a href="<?= e(url('opportunity.php')) ?>">Get employed</a></li>
                    <li><a href="<?= e(url('opportunity.php')) ?>">The Farmer News</a></li>
                </ul>
            </div>
            <div>
                <h4>Contact</h4>
                <div class="contact-row"><i class="fa-solid fa-location-dot"></i><span><?= e(TF_ADDRESS) ?></span></div>
                <div class="contact-row"><i class="fa-solid fa-phone"></i><a href="tel:+237605048910"><?= e(TF_PHONE) ?></a></div>
                <div class="contact-row"><i class="fa-solid fa-envelope"></i><a href="mailto:<?= e(TF_EMAIL) ?>"><?= e(TF_EMAIL) ?></a></div>
                <form id="newsletterForm" class="field" style="margin-top:18px" action="<?= e(url('process.php')) ?>" method="POST">
                    <input type="hidden" name="action" value="newsletter">
                    <label for="newsletterEmail">Get daily farm news</label>
                    <div style="display:flex;gap:8px">
                        <input type="email" id="newsletterEmail" name="email" placeholder="Your email" required>
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
<?php require TF_APP . '/includes/cart.php'; ?>
<script src="<?= e(asset('JS/main.js')) ?>"></script>
</body>
</html>
