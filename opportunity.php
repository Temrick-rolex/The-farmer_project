<?php
require_once __DIR__ . '/app/includes/init.php';
$tf_nav = 'opportunity';
$tf_title = 'Opportunities · The Farmer';
$tf_description = 'Partnership, mentorship, jobs and community programs from The Farmer in Cameroon.';
$opps = Opportunity::allLive();
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
                <?php foreach ($opps as $op): ?>
                <article class="oppo-card">
                    <div class="feature-icon<?= in_array($op['type'], ['mentorship', 'giveaway', 'sale'], true) ? ' alt' : '' ?>"><i class="fa-solid <?= e($op['icon'] ? $op['icon'] : 'fa-handshake') ?>"></i></div>
                    <h3><?= e($op['title']) ?></h3>
                    <p><?= e($op['body']) ?></p>
                    <?php if (is_logged_in()): ?>
                    <form action="<?= e(url('process.php')) ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="apply_opportunity">
                        <input type="hidden" name="opportunity_id" value="<?= (int) $op['id'] ?>">
                        <button class="card-link" type="submit"><?= e($op['cta_label'] ? $op['cta_label'] : 'Apply') ?> <i class="fa-solid fa-arrow-right"></i></button>
                    </form>
                    <?php else: ?>
                    <a class="card-link" href="<?= e(url('regform.php')) ?>"><?= e($op['cta_label'] ? $op['cta_label'] : 'Apply') ?> <i class="fa-solid fa-arrow-right"></i></a>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
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
