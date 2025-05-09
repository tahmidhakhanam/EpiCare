
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
                //The code is retrieving contact id but its just called contact name so it doenst disrupt other code
                $contact = filter_has_var(INPUT_POST, 'contactName') ? $_POST['contactName']: null;

                //Remove whitespace from data
		        $contact = trim($contact);

				try {
					// include the file with the function for the database connection
					require_once('functions.php');

					// get database connection
					$dbConn = getConnection();

                    //Check if user_id exists
                    if (isset($_SESSION['user_id'])) {
                        //if user_id exists store user_id in variable
                        $user_id = $_SESSION[ 'user_id']; 

                        //sql to retrieve users phone number
                        $selectSQL = "SELECT phone
                        FROM epicare_contacts
                        WHERE contact_id = $contact";

                        //Execute query and fetch data
                        $SQLResult = $dbConn->query( $selectSQL );
                        $sql = $SQLResult->fetchObject();

                        //if $sql (phone number) exixsts then 
                        if (isset($sql) && !is_null($sql) && $sql !== "") {

                            //store carrier's email-to-SMS gateway (T-mobile)
                            $carrierGateway = '@tmomail.net'; 
                            $message = 'Its time to take your medication!';

                            //email address to send message to
                            $to = $sql . $carrierGateway;

                            //for email
                            $subject = 'EpiCare Reminder';
                            $headers = 'From: epicare@northumbria.ac.uk'; 
                            //send email 
                            mail($to, $subject, $message, $headers);

                            echo 'It worked.';

                            //redirect to community forum
                            //header('Location: community.php');
                        } else {
                            //Output error message
                    echo "<h1 class='profile-error text-center'>This contact does not have phone number</h1>\n";
                    echo "<p class='profile-error text-center'>Click<a href='myinfo.php'> here</a> to return to my Info </p>";
                        }
				    }
                }
				catch (Exception $e) {

					//Output error message
                    echo "<h1 class='profile-error text-center'>There was a problem.</h1>\n";
                    echo "<p class='profile-error text-center'>Please try <a href='myinfo.php'>try again</a></p>";
        
                    //Log errors
                    log_error($e);
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