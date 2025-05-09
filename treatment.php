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
        <link href="css/myinfo.css" rel="stylesheet">

        <!--favicon for iOS Safari, Android Chrome, Windows 8 and 10, Mac OS El Capitan Safari, Classic, desktop browsers and Manifest-->
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicon-120x120.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    
        <!--set tile and address bar colour-->
        <meta name="msapplication-TileColor" content="#414287">
        <meta name="theme-color" content="#414287">

        <title>EpiCare - My Info</title>
    </head>
    <body>
        <header class="header">

            <!--display logo in header-->
            <div class="logo">
                <img src="images/logo_blue.png" alt="logo">
            </div>
            <div class="epicare"><p>EpiCare</p></div>
        </header>
        <!--container used to implement flex between nav and main-->
        <div class="container-main">
            <nav>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
                    <li class="nav-item"><a href="index.php" class="nav-link">Diary</a></li>
                    <li class="nav-item"><a href="myinfo.php" class="nav-link active">My info</a></li>
                    <li class="nav-item"><a href="community.php" class="nav-link">Community</a></li>
                    <li class="nav-item"><a href="resources.php" class="nav-link">Resources</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Log out</a></li>
                </ul>
            </nav>
            <main>
            <?php
                //Retrieve forum variables from modal
                $name = filter_has_var(INPUT_POST, 'medName') ? $_POST['medName']: null;
                $dose = filter_has_var(INPUT_POST, 'dose') ? $_POST['dose']: null;
                $frequency = filter_has_var(INPUT_POST, 'frequency') ? $_POST['frequency']: null;
                $sideEffects = filter_has_var(INPUT_POST, 'sideEffects') ? $_POST['sideEffects']: null;

                //Remove whitespace from data
		        $name = trim($name);
                $dose = trim($dose);
                $frequency = trim($frequency);
                $sideEffects = trim($sideEffects);

                //sanitise variables
                $name = filter_var($name, FILTER_SANITIZE_STRING);
                $dose = filter_var($dose, FILTER_SANITIZE_STRING);

                if (empty($name)) {

                    //Output error message
                    echo "<h1 class='profile-error text-center'>Name is required field.</h1>\n";
                    echo "<p class='profile-error text-center'>Click<a href='myinfo.php'> here</a> to return to my Info </p>";
                } else if (empty($dose)) {

                    //Output error message
                    echo "<h1 class='profile-error text-center'>Dose is required field.</h1>\n";
                    echo "<p class='profile-error text-center'>Click<a href='myinfo.php'> here</a> to return to my Info </p>";
                } else {
                    try {
                        // include the file with the function for the database connection
                        require_once('functions.php');

                        // get database connection
                        $dbConn = getConnection();

                        //Check if user_id exists
                        if (isset($_SESSION['user_id'])) {
                            //if user_id exists store user_id in variable
                            $user_id = $_SESSION[ 'user_id']; 

                            //sql to insert treatement record 
                            $insertSQL = "INSERT INTO epicare_treatments (user_id, name, dose, frequency, side_effects) VALUES (:user_id, :name, :dose, :frequency, :side_effects)";

                            //Execute query
                            $stmt = $dbConn->prepare($insertSQL);
                            $stmt->execute(array(':user_id' => $user_id, ':name' => $name, ':dose' => $dose, ':frequency'=> $frequency, ':side_effects' => $sideEffects));

                            //redirect to myinfo
                            header('Location: myinfo.php');
				        } else {
                            //Output error message
                            echo "<h1 class='profile-error text-center'>There was a problem verifying your account.</h1>\n";
                            echo "<p class='profile-error text-center'>Please log in and <a href='login.php'>try again</a></p>";
                        }  
                    }
                    catch (Exception $e) {

                        //Output error message
                        echo "<h1 class='profile-error text-center'>There was a problem adding your treatment.</h1>\n";
                        echo "<p class='profile-error text-center'>Please <a href='myinfo.php'>try again</a></p>";
            
                        //Log errors
                        log_error($e);
                    }
                }
				?>
            </main>
        </div>
        
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

        <!--bootstrap and fontawesoe links-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/799d082bbd.js" crossorigin="anonymous"></script> 
    </body>
</html>