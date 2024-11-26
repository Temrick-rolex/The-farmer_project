<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets\CSS\index.css">
    <link rel="stylesheet" href="Assets\fontawesome\css\all.css">
    <link rel="shortcut icon" href="Assets/Image/RO.png" type="image/x-icon">
</head>
<body>
    <nav class="navigation-bar">
        <div class="logo">
            <img src="Assets/Image/RO.png" alt="logo" class="img">
            <p>
                The Farmer
            </p>
        </div>
        <div class="menu">
            <ul>
            <a href="index.php"><li class="active"><i class="fas fa-home"></i> Home</li></a> 
                <a href="product.php"><li><i class="fas fa-cart-shopping"></i> Product</li></a>
                <a href="opportunity.php"><li><i class="fas fa-rocket"></i> Opportunity</li></a>
                <a href="settings.php"><li><i class="fas fa-gears"></i> Settings</li></a>
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
                        <a href="regform.php">
                            <button>
                                SignUp
                            </button>
                        </a>  
                </div>
        </div>
    </nav>

    <main class="main">
        <div class="top">
            <div class="desc">
                    <p>who are we ?</p>
                    <p id="desc">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis officia et, velit animi molestias aut dicta. 
                    Repellat expedita aperiam sit cupiditate a nihil reiciendis eveniet iusto unde. Fugit, natus illum!
                    </p>
            </div>
            <div class="activity">
                    <p>what do we do ?</p>
                    <p id="activity">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis officia et, velit animi molestias aut dicta. 
                    Repellat expedita aperiam sit cupiditate a nihil reiciendis eveniet iusto unde. Fugit, natus illum!
                    </p>
            </div>
        </div>
        <div class="slides">
                     <div class="set1" alt="farm image section">
                     <img src="Assets/Image/farm.jpg" alt="image1" class="image fade">
                     <img src="Assets/Image/farm1.jpg" alt="image2" class="image fade">
                     <img src="Assets/Image/farm2.jpg" alt="image3" class="image fade">
                     <img src="Assets/Image/farm3.jpg" alt="image4" class="image fade">
                     <img src="Assets/Image/farm5.jpg" alt="image5" class="image fade">
                     <img src="Assets/Image/farm6.jpg" alt="image6" class="image fade">
                     </div>
                     <div class="set2">
                     <img src="Assets/Image/orange2.png" alt="image1" class="image fade">
                     <img src="Assets/Image/orange.png" alt="image2" class="image fade">
                     <img src="Assets/Image/orange3.png" alt="image3" class="image fade">
                     </div>
                     <div class="set3">
                     <img src="Assets/Image/orange3.png" alt="image1" class="image fade">
                     <img src="Assets/Image/orange.png" alt="image2" class="image fade">
                     <img src="Assets/Image/orange2.png" alt="image3" class="image fade">
                     </div>
                    

        </div>
        <div class="testimony">
            <div id="testimony1">
                <div class="img">
                    <img src="Assets/Image/orange.png" alt="">

                    <br><p style="margin-left: 5px;">John Doe</p>
                </div>
                <div class="rating-text">
                    <div class="rating">
                    <p style="color: black; padding-right:30px;">1&middot;</p>
                        &#9733;
                        &#9733;
                        &#9733;
                        &#9733;
                        &#9734;
                    </div>
                <div class="text">
                      <p>Really nice plateform it helped me save my farm but there are still little bugs to fix</p>
                </div>
                </div>
            </div>
            <div id="testimony1">
                <div class="img">
                <img src="Assets/Image/orange.png" alt="">

                <br><p style="margin-left: 5px;">Jane Doe</p>
                </div>
                <div class="rating-text">
                    <div class="rating">
                    <p style="color: black; padding-right:30px;">2&middot;</p>
                    &#9733;
                    &#9733;
                    &#9733;
                    &#9734;
                    &#9734;
                    </div>
                <div class="text">
                <p>Really nice plateform it helped me save my farm but there are still little bugs to fix</p>
                </div>
                </div>
            </div>
            <div id="testimony1">
                <div class="img">
                <img src="Assets/Image/orange.png" alt="">

                <br><p style="margin-left: 5px;">John Doe</p>
                </div>
                <div class="rating-text">
                    <div class="rating">
                        <p style="color: black; padding-right:30px;">3&middot;</p>
                    &#9733;
                    &#9733;
                    &#9733;
                    &#9733;
                    &#9734;
                    </div>
                <div class="text">
                <p>Really nice plateform it helped me save my farm but there are still little bugs to fix</p>
                </div>
                </div>
            </div>
            <div id="testimony1">
                <div class="img">
                <img src="Assets/Image/orange.png" alt="">

                <br><p style="margin-left: 5px;">Jane Doe</p>
                </div>
                <div class="rating-text">
                    <div class="rating">
                         <p style="color: black; padding-right:30px;">4 &middot;</p>
                    &#9733;
                    &#9733;
                    &#9733;
                    &#9733;
                    &#9734;
                    </div>
                <div class="text">
                <p>Really nice plateform it helped me save my farm but there are still little bugs to fix</p>
                </div>
                </div>
            </div>
        </div>
        <div class="others">
            <div class="sponsors">
                <p>Our sponsors & parteners</p>
                  <a href="https://www.novadesign.">  <img src="Assets/Image/logo entreprise 2.png" alt="nova collective design"></a>
                  <a href="https://www.Myfarmpicker.">  <img src="Assets/Image/or.jpeg" alt="my farm picker"></a>
                  <a href="https://iaicameroun.com/">  <img src="Assets/Image/iai.webp" alt="IAI cameroon"></a>
            </div>
            <!-- <div class="partners">
                <p>Our partners</p> 
        
            </div> -->
        </div>
        <footer>
        <div class="terms">
         <a href="#"><p>Terms & Policy</p></a>
        </div>
        <div class="faq">
        <a href="#"><p>FAQ ?</p></a>
        </div>
        <div class="copyright">
        <p> Copyright &#169;2024<br>The FarmerProject,all right reserved</p>
        </div>
        <div class="socialprofil">
            <p>follow our social medias</p>
            <a href="#"><i class="fab fa-telegram fa-1x iform"></i></a>
            <a href="#"><i class="fab fa-facebook fa-1x iform1"></i></a>
            <a href="#"><i class="fab fa-instagram fa-1x iform2"></i></a>
            <a href="#"><i class="fab fa-twitter fa-1x iform3"></i></a>
            <a href="#"><i class="fab fa-tiktok fa-1x iform4"></i></a>
            <a href="#"><i class="fab fa-discord fa-1x iform5"></i></a>
            <a href="#"><i class="fab fa-youtube fa-1x iform6"></i></a>
        </div>
        <div class="sitemap">
                <p>wants to visite ? <a href="">check map</a></p>
        </div>
         <div class="pagetop">
                   <a href="#"><p>Go to Top</p></a> 
         </div>
         <div class="newsteller">
                <p>interested in daily updates ? <a href=""> get news !</a></p>
               
         </div>
    </footer>
    </main>
</body>
</html>