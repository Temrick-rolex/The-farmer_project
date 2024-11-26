<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/profile.css">
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
                <a href="settings.php"><li><i class="fas fa-gears"></i> Settings</li></a>
            </ul>
        </div>
        <div class="profile">
                <div class="relative">
                    <a href="profile.php">
                    <i class="fas fa-user fa-2x active " ></i>
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
<div class="profil">
    <div class="profiltop">
                <div class="profilim">
                <img src="Assets/Image/profile.jfif" alt="profile-img" class="profile-img">
                </div>
    <div class="logininfo">
        <label for="user-ID">User-ID :
            <input type="text" value="01xj00f" readonly>
        </label>
        <label for="password">Password :
            <input type="password" value="457780" readonly>
            <i class="fas fa-eye-slash view"></i>
            <i class="fas fa-copy copy"></i>
        </label>
        <button>
            change password
        </button>
    </div>

    </div>
    <div class="profilbottom">
        <label for="name">Name :  
            <input type="" value="John Doe" readonly>
            <i class="fas fa-user"></i>
        </label>
        <label for="email">Email :  
            <input type="email" value="johndoe@gmail.com" readonly>
            <i class="fas fa-envelope"></i>
        </label>
        <label for="telnum">Tel num : 
            <input type="" value="+237-605-048-910" readonly>
            <i class="fas fa-phone-flip"></i>
        </label>
        <label for="adress">Address : 
            <input type="none" value="yaounde simbock,mendong" readonly>
            <i class="fas fa-address-card"></i>
        </label>
        <label for="paymode">Paymode : 
            <input type="text" value="Cash" readonly>
            <i class="fab fa-cc-mastercard"></i>
        </label>

        <label for="country">Country : 
            <input type="country" value="Cameroon" readonly>
            <i class="fas fa-flag"></i>
        </label>
        <label for="gender">Gender : 
            <input type="gender" value="Male" readonly>
            <i class="fas fa-child"></i>
        </label>

        <div class="actions">
                <button class="del">
                   <i class="fas fa-trash-can"></i> 
                   delete acount
                </button>
                <button class="edit">
                    <i class="fas fa-pen-clip"></i>
                    edit profile
                </button>
        </div>
    </div>


</div>


    </main>
</body>
</html>