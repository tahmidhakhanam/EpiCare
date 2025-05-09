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
            <?php
            //Retrieve variables from login
            $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;
            $password = filter_has_var(INPUT_POST, 'password') ? $_POST['password']: null;
            
            //Remove any whitespace from variables
            $username = trim($username);
            $password = trim($password);

            //Check if username or password is empty
            if (empty($username) || empty($password)) {

                //If empty display message
                echo "<h1>LOGIN FAILED</h1>
                <p>You need to provide a username and password. Please <a href='login.php'>try again.</a></p>\n";
            }
            else {
                try {
                    require_once("functions.php");

                    //Make database connection
                    $dbConn = getConnection();
                    
                    //Query database
                    $querySQL = "SELECT *
                                FROM epicare_users
                                WHERE username = :username";
                    
                    //Prepare SQL statement using PDO
                    $stmt = $dbConn->prepare($querySQL);
                    
                    //Execute query using PDO
                    $stmt->execute(array(':username' => $username));
                    
                    //Retreive user record
                    $user = $stmt->fetchObject();
                    
                    //If user exists
                    if ($user) {
                        //Hash password
                        $password_hash = $user->password_hash;
                        //if password is verified password
                        if (password_verify($password, $password_hash)) {
                            //Set session variable-logged-in to true
                            $_SESSION['logged-in'] = true;

                            //Store user id in session variable-user_id
                            $_SESSION['user_id'] = $user->user_id;

                            //redirect page to home
                            header('Location: index.php'); 	
                        } 
                    }
                    else {
                        //Output message if username or password does not exist
                        echo "<div class='container'>
                            <div class='text-center py-5'>
                            <h1>The username or password entered is incorrect. Please <span class='try-again'><a href='login.php'>try again.</a></span></h1>
                            </div>
                            </div>\n";
                    }
                }
                catch (Exception $e) {
                    //Output error message
                    echo "<div class='container'>
                            <div class='text-center py-5'>
                            <h1>Sorry there was a problem. Please <span class='try-again'><a href='login.php'>try again.</a></span></h1>
                            </div>
                            </div>\n";
                    //Log error 
                    log_error($e);
                }
            }
            ?>
        </main>

        <!--start of footer-->
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