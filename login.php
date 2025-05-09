<?php
//Session variables are stored in a folder specified below

//sessionData path
ini_set( "session.save_path", "/home/unn_w17017369/public_html/sessionData" );

//Create a new session with a session ID
session_start();
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">        
        
        <!--customised stylesheet-->
        <link href="css/login.css" rel="stylesheet">

        <!--favicon for iOS Safari, Android Chrome, Windows 8 and 10, Mac OS El Capitan Safari, Classic, desktop browsers and Manifest-->
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicon-120x120.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    
        <!--set tile and address bar colour-->
        <meta name="msapplication-TileColor" content="#414287">
        <meta name="theme-color" content="#414287">

        <title>EpiCare</title>
    </head>
    <body>
        <main>
            
            <!--epicare info-->
            <div class="left-container">
                <img src="images/welcome.png" alt="welcome image">
                <div class="welcome-info">
                    <img src="images/logo_blue.png" alt="EpiCare logo">
                    <h2>EpiCare</h2>
                    <h3>Take control of your Epilepsy.</h3>
                    <p>Epicare is all inclusive healthcare platform designed with your care in mind. Explore our state of the art features and resources to enhance your journey to your optimal health!</p>
                </div>
            </div>

            <!--login form-->
            <div class="right-container">
                <form action="loginprocess.php" method="post">
                    <h2>Login</h2>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" pattern="^[A-Za-z0-9_]{1,15}$" maxlength="20" tabindex="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" minlength="8" tabindex="2" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" id="submit" tabindex="3">Login</button>
                    <!-- these links will not be included to prevent particpants fromt accidnetly changing dummy account or submitting personal info -->
                    <a href="#" class="reset" tabindex="4">Forgot password?</a>
                    <a href="#" class="registration" tabindex="5">Create new account</a>
                </form>
            </div>
        </main>
        <footer>
            <div class="social">
                <div class="footer-socialmedia text-center">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col copyright text-center">
                <p class="pt-4"><small>&copy;
			    <!-- This javascript snippet will automatically update the copyright year, depending on the user's time settings -->
		        <script type="text/javascript">
			        document.write(new Date().getFullYear());
		        </script> EpiCare. All Rights Reserved.</small></p>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/799d082bbd.js" crossorigin="anonymous"></script> 
    </body>
</html>