<?php
require_once __DIR__ . '/app/includes/init.php';
$tf_nav = 'opportunity';
$tf_title = 'Opportunities · The Farmer';
$tf_description = 'Partnership, mentorship, jobs and community programs from The Farmer in Cameroon.';
require TF_APP . '/includes/head.php';
require TF_APP . '/includes/header.php';
?>

<main>
    <section class="page-hero" style="--hero-img:url('<?= e(asset('Image/farm2.jpg')) ?>')">
        <div class="container">
            <div class="crumb"><a href="<?= e(url('index.php')) ?>">Home</a><span class="sep">/</span><span>Opportunities</span></div>
            <h1>Grow with The Farmer</h1>
            <p>Six ways to work with us — become a partner, learn from our growers, get hired, or simply stay close to the field.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="oppo-grid">
                <article class="oppo-card">
                    <div class="feature-icon"><i class="fa-solid fa-handshake"></i></div>
                    <h3>Partnership Program</h3>
                    <p>Become an official The Farmer partner: sell on our shelves, buy our trees at partner prices and co-market the harvest across Cameroon and Central Africa.</p>
                    <a class="card-link" href="<?= e(url('regform.php')) ?>">Apply as partner <i class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="oppo-card">
                    <div class="feature-icon alt"><i class="fa-solid fa-hands-holding-child"></i></div>
                    <h3>Mentorship Program</h3>
                    <p>Learn from our best tutors — soil preparation, irrigation, citrus care and how to turn a plot of land into a real, profitable business.</p>
                    <a class="card-link" href="<?= e(url('regform.php')) ?>">Find a mentor <i class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="oppo-card">
                    <div class="feature-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <h3>Get Employed</h3>
                    <p>Well-paid seasonal and permanent roles on our farm and with our partner companies — from nursery care and orchard work to delivery driving.</p>
                    <a class="card-link" href="<?= e(url('regform.php')) ?>">See open roles <i class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="oppo-card">
                    <div class="feature-icon alt"><i class="fa-solid fa-newspaper"></i></div>
                    <h3>The Farmer News</h3>
                    <p>Daily updates straight from the field: harvest news, weather, market prices and new opportunities as they happen.</p>
                    <button class="card-link" type="button" data-demo="The Farmer News drops here daily — coming soon (demo)">Read the latest <i class="fa-solid fa-arrow-right"></i></button>
                </article>
                <article class="oppo-card">
                    <div class="feature-icon"><i class="fa-solid fa-gift"></i></div>
                    <h3>Gift &amp; Giveaway</h3>
                    <p>Join our G&amp;GA program: monthly giveaways of free trees, fruit baskets and harvest tours for the community. Awesome prizes, easy entry.</p>
                    <a class="card-link" href="<?= e(url('regform.php')) ?>">Join the next draw <i class="fa-solid fa-arrow-right"></i></a>
                </article>
                <article class="oppo-card">
                    <div class="feature-icon alt"><i class="fa-solid fa-bolt"></i></div>
                    <h3>Big Sales Show</h3>
                    <p>Our BSS events: the whole harvest at the best prices of the season — 48 hours only, once a quarter, in Yaoundé.</p>
                    <button class="card-link" type="button" data-demo="Big Sales Show dates are announced in The Farmer News (demo)">Get the date <i class="fa-solid fa-arrow-right"></i></button>
                </article>
                <article class="oppo-card soon">
                    <div class="feature-icon"><i class="fa-solid fa-star"></i></div>
                    <h3>Coming soon…</h3>
                    <p>New programs are sprouting in our greenhouse. Follow The Farmer News for early access and founding-member perks.</p>
                    <span class="badge orange" style="align-self:flex-start">Stay tuned</span>
                </article>
            </div>
        </div>
    </section>

    <section class="section alt">
        <div class="container">
            <div class="section-head">
                <p class="eyebrow">How it works</p>
                <h2>Three steps to get started</h2>
            </div>
            <div class="about-grid">
                <article class="feature-card">
                    <div class="feature-icon"><span style="font-family:var(--font-head);font-size:22px">1</span></div>
                    <h3>Create your account</h3>
                    <p>Sign up in under two minutes — all we need is your name, phone number and where to find you.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon alt"><span style="font-family:var(--font-head);font-size:22px">2</span></div>
                    <h3>Pick a program</h3>
                    <p>Choose the path that fits you: partner, mentee, employee — or join several at once.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon"><span style="font-family:var(--font-head);font-size:22px">3</span></div>
                    <h3>We call you</h3>
                    <p>Our team reviews every application personally and calls you within 48 hours with the next steps.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="cta-band" style="--hero-img:url('<?= e(asset('Image/farm6.jpg')) ?>')">
        <div class="hero-bg"></div>
        <div class="hero-scrim"></div>
        <div class="container">
            <h2>Your seat at the table is waiting</h2>
            <p>Join hundreds of growers, buyers and families already growing with The Farmer.</p>
            <div class="hero-cta">
                <a class="btn btn-accent btn-lg" href="<?= e(url('regform.php')) ?>"><i class="fa-solid fa-user-plus"></i> Create an account</a>
                <a class="btn btn-ghost btn-lg" href="<?= e(url('product.php')) ?>">Browse products</a>
            </div>
        </div>
    </section>
</main>

<?php require TF_APP . '/includes/footer.php'; ?>
