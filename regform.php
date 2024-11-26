<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/CSS/regform.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="Assets/CSS/login.css">
    <link rel="stylesheet" href="Assets\fontawesome\css\all.css">
</head>
<body>
            <div id="login">
                <div>
                <form action="" method="$_POST">
                    <div>
                    <i class="fas fa-user 2x"></i>
                    <input type="text" placeholder="Enter your name" name="logname" id="loginname">
                    </div>
                       <div>
                         <i class="fas fa-lock 2x"></i>
                         <input type="password" placeholder="Eter password" name="logpasswd" id="loginpassword">
                       </div>
                       
                        <input type="submit" value="LogIn" name="login" id="loginbutton">

                        <div id="box">
                            <p>Remember me </p>
                        <input type="checkbox" id="check">
                        </div>
                        <p>No account ? <a onclick="closemodal()">SignUp</a></p>
                </form>
                </div>
            </div>
    <main>
        <a href="index.php">
           <button class="close">
                    &times;
           </button>
        </a> 
                <form action="" method="$_POST" class="form">
                    <input type="text" placeholder="Enter full name" name="Uname">
                    <input type="email" placeholder="Enter Email" name="email">
                    <input type="password" placeholder="enter password" name="passwd">
                    <input type="password" placeholder="confirm password" name="confirmpass">
                    <input type="date" placeholder="" name="dob">
                    <div class="telnum">
                        <p>select countrycode :</p>
                        <select name="countrycode" id="c-code">
                            <option value="+237">+237</option>
                            <option value="+237">+236</option>
                            <option value="+237">+235</option>
                            <option value="+237">+234</option>
                            <option value="+237">+233</option>
                            <option value="+237">+232</option>
                        </select>
                    <input type="text" placeholder="enter telephone number" name="telnum" id="telnum">
                    </div>
                    <input type="text" placeholder="enter your adress" name="adress">
                   <div class="paysection">
                   <p>select payement mode :</p>
                    <select name="paymentmode" id="paymod">
                                    <option value="cash">Cash</option>
                                    <option value="crypto">Crypto</option>
                                    <option value="visa">Visa</option>
                                    <option value="card">Bank card</option>
                                    </select>
                   </div>
                    <div class="countrygender">
                        <p>select country :</p>
                        <select name="country" id="country">
                            <option value="cameroon">Cameroon</option>
                            <option value="canada">Canada</option>
                            <option value="china">China</option>
                            <option value="france">France</option>
                        </select>
                        <p>select gender :</p>
                        <select name="gender" id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="others">others</option>
                        </select>
                    </div>
                    <input type="submit" value="SignUp" name="signup" class="signup">
                    
                        <div class="log">
                            <p>already have an account ? <a onclick="openmodal()">LogIn</a></p>
                        </div>
                </form>
    </main>
</body>
<script>
    function openmodal(){
        document.getElementById('login').setAttribute('style','display:block');
    }
    function closemodal(){
        document.getElementById('login').setAttribute('style','display:none');
    }
</script>
</html>