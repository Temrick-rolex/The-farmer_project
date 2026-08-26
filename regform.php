<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up / Log in · The Farmer</title>
    <meta name="description" content="Create your The Farmer account or log in to shop fresh citrus from Cameroon.">
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

<div class="auth">
    <!-- ============ MEDIA PANEL ============ -->
    <div class="auth-media">
        <img src="Assets/Image/farm2.jpg" alt="Tractor working the fields at the farm">
        <div class="hero-scrim"></div>
        <div class="auth-media-top">
            <img src="Assets/Image/RO.png" alt="The Farmer logo">
            <span>The Farmer</span>
        </div>
        <div class="auth-media-inner">
            <h2>Plant something good today.</h2>
            <p>One account for everything: shop the harvest, track your orders, join programs and get daily news from the field.</p>
        </div>
    </div>

    <!-- ============ FORM PANEL ============ -->
    <div class="auth-side">
        <div class="auth-card">
            <h1>Good to see you</h1>
            <p class="sub">New to The Farmer? Create an account. Already a member? Just log in.</p>

            <div class="tabs" role="tablist">
                <button class="tab active" data-panel="signupPanel" role="tab" aria-selected="true">Create account</button>
                <button class="tab" data-panel="loginPanel" role="tab" aria-selected="false">Log in</button>
            </div>

            <!-- SIGN UP -->
            <form id="signupForm">
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
                    <div class="field">
                        <label for="su-gender">Gender</label>
                        <select id="su-gender" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Create my account</button>
                    <p class="auth-foot">Already have an account? <button type="button" class="tab-link" data-panel="loginPanel">Log in</button></p>
                </div>
            </form>

            <!-- LOG IN -->
            <form id="loginForm">
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
                    <label class="remember"><input type="checkbox" name="remember" id="check"> Remember me</label>
                    <button type="submit" class="btn btn-accent btn-block btn-lg">Log in</button>
                    <p class="auth-foot">No account yet? <button type="button" class="tab-link" data-panel="signupPanel">Create one</button></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="Assets/JS/main.js"></script>
</body>
</html>
