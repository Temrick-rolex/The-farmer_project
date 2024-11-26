<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/product.css">
    <link rel="stylesheet" href="Assets\fontawesome\css\all.css">
    <link rel="stylesheet" href="Assets/CSS/user-cart.css">
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
                <a href="product.php"><li  class="active"><i class="fas fa-cart-shopping"></i> Product</li></a>
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
                       <!--  <a href="regform.php">
                            <button>
                                SignUp
                            </button>
                        </a>   -->
                </div>
        </div>
    </nav>

    <main class="productgrid">


                <div id="cart">  

                        <div class="cart-container">

                                    <div class="recipt">
                                        <div class="basicinfo">
                                            <img src="Assets/Image/orange.png" alt="">
                                            <label for="user-ID">User-ID :
                                                <input type="text" value="01xj00f" readonly>
                                            </label>
                                            <label for="country">Country : 
                                                    <input type="country" value="Cameroon" readonly>
                                                    <i class="fas fa-flag"></i>
                                            </label>
                                        </div>
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

                                                <div class="action">
                                                    <button class="check">Check list <i class="fas fa-list"></i></button>
                                                    <button class="buy">Buy Now <i class="fas fa-wallet"></i></button>                                                
                                                </div> 
                                    </div>
                                    <div class="list">
                                                        <table border="1" style="text-align: center; text-transform:capitalize;">
                                                             <tr>
                                                                <th>
                                                                    product
                                                                </th>
                                                                <th>quantity</th>
                                                                <th>unit price</th>                                                            
                                                                <th>total price</th>
                                                                <th>actions</th>
                                                             </tr>
                                                             <tr>
                                                                <td>12</td>
                                                                <td>5</td>
                                                                <td>45</td>
                                                                <td>45</td>
                                                                <td>
                                                                  <abbr title="Reduce"><i class="fas fa-minus"></i></abbr>  
                                                                   <abbr title="Add"><i class="fas fa-plus"></i></abbr> 
                                                                    <abbr title="Remove"><i class="fas fa-trash-can"></i></abbr>
                                                                </td>
                                                             </tr>
                                                        </table>
                                                        
                                                    
                                    </div>

                                    <p class="close" onclick="closecart()">
                                    <i class="fas fa-xmark fa-2x" ></i>
                                    </p>
                        </div>


                </div>






   <div class="search-section">
    <input type="text" class="search-bar" placeholder="Search">
    <button class="search-button"><i class="fas fa-search"></i></button>
   </div>
       
        <div class="product0">
            <div class="product-name"> 
                <p>
                    orange tree
                 </p>
            </div>
            <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/Orange-Valencia-Tree.png" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/Tangerine-SpotlessFruitsIndia_1024x1024.png" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/Orange-Fruit-Pieces.jpg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image"> <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>

            <img src="Assets/Image/product-images/Lime-copy-scaled-1.jpg" alt="">
        </div>
        <div class="action">
             <div class="product-name"> <p>orange tree</p></div>
            <div class="product-price">30,000 xaf</div>

            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/27554428-lemon-fruits-with-leaves-isolated-on-white.jpg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/94253411-orange-juice-in-a-glass-bottle-and-orange-fruit-with-green-leaves-isolated-on-white-background.jpg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/bottle-lemon-juice-fresh-lemons-25336807.jpg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/images (7).jpeg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/images (4).jpeg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/images (6).jpeg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/images (8).jpeg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

        <div class="product0">
        <div class="product-name"> <p>orange tree</p></div>
        <div class="product-price">30,000 xaf</div>

        <div class="product-image">
        <div class="description0"> 
            <p id="stars">
                &#9733;
                &#9733;
                &#9733;
                &#9733;
                &#9734;
            </p>
            <p>
                get an entire orange tree when its fruits are already mature and harvest it your self.
            </p>
        </div>
            <img src="Assets/Image/product-images/images (1).jpeg" alt="">
        </div>
        <div class="action">
            <button class="rate"><i class="fas fa-star"></i> Rate</button>
            <button class="more"> <i class="fas fa-plus"></i> More</button>
            <button class="add"> <i class="fas fa-cart-plus"></i> Add to cart</button>
        </div>
        </div>

       

        <div class="user-card-box">
                    <div class="user-card" onclick="opencart()">
                            <div class="count">
                                5
                            </div>
                            <i class="fas fa-cart-arrow-down fa-2x"></i>
                        
                        <div class="hint">
                            <p>
                                check your cart
                            </p>
                        </div>
                    </div>
                </div>

    </main>
</body>
<script>
    function opencart(){
       document.getElementById('cart').setAttribute('style','display:flex;');
    }
    function closecart(){
        document.getElementById('cart').setAttribute('style','display:none;');
    }
</script>
<script src="Assets/JS/product.js"></script>
</html>