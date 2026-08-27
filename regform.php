<?php
require_once __DIR__ . '/app/includes/init.php';
$tf_nav = 'auth';
$tf_title = 'Sign up / Log in · The Farmer';
$tf_description = 'Create your The Farmer account or log in to shop fresh citrus from Cameroon.';
require TF_APP . '/includes/head.php';
require TF_APP . '/includes/header.php';
?>

<div class="auth">
    <div class="auth-media">
        <img src="<?= e(asset('Image/farm2.jpg')) ?>" alt="Tractor working the fields at the farm">
        <div class="hero-scrim"></div>
        <div class="auth-media-top">
            <img src="<?= e(asset('Image/RO.png')) ?>" alt="The Farmer logo">
            <span>The Farmer</span>
        </div>
        <div class="auth-media-inner">
            <h2>Plant something good today.</h2>
            <p>One account for everything: shop the harvest, track your orders, join programs and get daily news from the field.</p>
        </div>
    </div>

    <div class="auth-side">
        <div class="auth-card">
            <h1>Good to see you</h1>
            <p class="sub">New to The Farmer? Create an account. Already a member? Just log in.</p>

            <div class="tabs" role="tablist">
                <button class="tab active" data-panel="signupPanel" role="tab" aria-selected="true" type="button">Create account</button>
                <button class="tab" data-panel="loginPanel" role="tab" aria-selected="false" type="button">Log in</button>
            </div>

            <form id="signupForm" action="<?= e(url('process.php')) ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="register">
                <div id="signupPanel" class="form-panel active">
                    <div class="field">
                        <label for="su-name">Full name</label>
                        <input type="text" id="su-name" name="Uname" placeholder="e.g. Amadou Bello" autocomplete="name">
                        <span class="field-error"></span>
                    </div>
                    <div class="field">
                        <label for="su-email">Email</label>
                        <input type="email" id="su-email" name="email" placeholder="you@example.com" autocomplete="email">
                        <span class="field-error"></span>
                    </div>
                    <div class="form-row">
                        <div class="field">
                            <label for="su-pass">Password</label>
                            <div class="pw-wrap">
                                <input type="password" id="su-pass" name="passwd" placeholder="Min. 6 characters" autocomplete="new-password">
                                <button type="button" class="pw-toggle" data-for="su-pass" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                            </div>
                            <span class="field-error"></span>
                        </div>
                        <div class="field">
                            <label for="su-conf">Confirm password</label>
                            <div class="pw-wrap">
                                <input type="password" id="su-conf" name="confirmpass" placeholder="Repeat password" autocomplete="new-password">
                                <button type="button" class="pw-toggle" data-for="su-conf" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                            </div>
                            <span class="field-error"></span>
                        </div>
                    </div>
                    <div class="field">
                        <label for="su-dob">Date of birth</label>
                        <input type="date" id="su-dob" name="dob">
                        <span class="field-error"></span>
                    </div>
                    <div class="field">
                        <label for="su-tel">Phone number</label>
                        <div style="display:flex;gap:8px">
                            <select name="countrycode" id="c-code" style="width:110px;padding:12px 8px;border:1.5px solid var(--line);border-radius:12px;background:var(--surface)" aria-label="Country code">
                                <option value="+237">+237 CM</option>
                                <option value="+236">+236 TD</option>
                                <option value="+235">+235 NE</option>
                                <option value="+234">+234 NG</option>
                                <option value="+233">+233 GH</option>
                                <option value="+232">+232 SL</option>
                            </select>
                            <input type="tel" id="su-tel" name="telnum" placeholder="6XX XXX XXX">
                        </div>
                        <span class="field-error"></span>
                    </div>
                    <div class="field">
                        <label for="su-addr">Delivery address</label>
                        <input type="text" id="su-addr" name="adress" placeholder="Quarter, city, region">
                        <span class="field-error"></span>
                    </div>
                    <div class="form-row">
                        <div class="field">
                            <label for="paymod">Payment mode</label>
                            <select id="paymod" name="paymentmode">
                                <option value="cash">Cash</option>
                                <option value="momo">Mobile money</option>
                                <option value="visa">Visa</option>
                                <option value="card">Bank card</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="su-country">Country</label>
                            <select id="su-country" name="country">
                                <option value="cameroon">Cameroon</option>
                                <option value="chad">Chad</option>
                                <option value="niger">Niger</option>
                                <option value="nigeria">Nigeria</option>
                                <option value="ghana">Ghana</option>
                                <option value="sierra-leone">Sierra Leone</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="field">
                            <label for="su-gender">Gender</label>
                            <select id="su-gender" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="account_type">I am a</label>
                            <select id="account_type" name="account_type">
                                <option value="customer">Customer</option>
                                <option value="farmer">Farmer / vendor</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Create my account</button>
                    <p class="auth-foot">Already have an account? <button type="button" class="tab-link" data-panel="loginPanel">Log in</button></p>
                </div>
            </form>

            <form id="loginForm" action="<?= e(url('process.php')) ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="login">
                <div id="loginPanel" class="form-panel">
                    <div class="field">
                        <label for="li-user">Name or email</label>
                        <input type="text" id="li-user" name="logname" placeholder="Your name or email" autocomplete="username">
                        <span class="field-error"></span>
                    </div>
                    <div class="field">
                        <label for="li-pass">Password</label>
                        <div class="pw-wrap">
                            <input type="password" id="li-pass" name="logpasswd" placeholder="Your password" autocomplete="current-password">
                            <button type="button" class="pw-toggle" data-for="li-pass" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                        </div>
                        <span class="field-error"></span>
                    </div>
                    <p class="muted small" style="margin:-6px 0 16px">Your workspace opens from the role saved on your account. Demo password: <strong>Farmer2026!</strong></p>
                    <label class="remember"><input type="checkbox" name="remember" id="check"> Remember me</label>
                    <button type="submit" class="btn btn-accent btn-block btn-lg">Log in</button>
                    <p class="auth-foot">No account yet? <button type="button" class="tab-link" data-panel="signupPanel">Create one</button></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= e(asset('JS/main.js')) ?>"></script>
</body>
</html>
