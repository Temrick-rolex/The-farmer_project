<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/settings.css">
    <link rel="stylesheet" href="Assets\fontawesome\css\all.css">
</head>
<body>
<nav class="navigation-bar">
        <div class="logo">
            <img src="Assets\Image\RO.png" alt="logo" class="img">
            <p>
                The Farmer
            </p>
        </div>
        <div class="menu">
            <ul>
            <a href="index.php"><li ><i class="fas fa-home"></i> Home</li></a> 
                <a href="product.php"><li><i class="fas fa-cart-shopping"></i> Product</li></a>
                <a href="opportunity.php"><li><i class="fas fa-rocket"></i> Opportunity</li></a>
                <a href="settings.php"><li class="active"><i class="fas fa-gears"></i> Settings</li></a>
            </ul>
        </div>
        <div class="profile">
                <div class="relative">
                    <a href="profile.php">
                    <i class="fas fa-user fa-2x icon"></i>
                    </a>
                    <div class="message">
                        <p>profile</p>
                    </div>
                </div>
                <div class="signup">
                       <!--  <a href="regform.php">
                            <button>
                                SignUp
                            </button>
                        </a>   -->
                </div>
        </div>
    </nav>
    <main>


        <div class="setting1">

                    <div class="action0">
                        <i class="fas fa-language fa-2x"></i>
                        <p>Select language :</p>
                            <select name="language" id="lang">
                                <option value="english">English</option>
                                <option value="french">French</option>
                                <option value="spanish">Spanish</option>
                            </select>
                    </div>
                    <div class="action1">
                        <i class="fas fa-users-gear fa-2x"></i>
                            <p>Support Team & Help</p>
                    </div>
                    <div class="action2">
                        <i class="fas fa-book-open-reader fa-2x"></i>
                        <p>
                            About Us
                        </p>
                    </div>
                    <div class="action3">
                        <i class="fas fa-toggle-off fa-2x"></i>
                            <p>
                                Switch theme
                            </p>   
                    </div>

        </div>
        <div class="setting2">

                    <div class="action4">
                    <i class="fas fa-star fa-2x"></i>
                    <p>Rate Us</p>
                    </div>
                    <div class="action5">
                        <i class="fas fa-landmark fa-2x"></i>
                                <p>
                                    select divident :
                                </p>
                                <select name="paymentmode" id="paymod">
                                    <option value="cash">xaf(frs)</option>
                                    <option value="crypto">USDT($)</option>
                                    <option value="visa">pound()</option>
                                    <option value="card">euro()</option>
                                </select>
                    </div>
                    <div class="action6" onclick="window.location.href='mailto:temrick4@gmail.com'">
                        <i class="fas fa-envelope-circle-check fa-2x"></i>
                           <p>Contact Us</p>
                    </div>
                    <div class="action7">
                    <i class="fas fa-arrow-right-from-bracket fa-2x"></i>
                            <p>LogOut</p>
                    </div>

        </div>


    </main>
</body>
</html>