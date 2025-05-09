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
        <link href="css/index.css" rel="stylesheet">

        <!--favicon for iOS Safari, Android Chrome, Windows 8 and 10, Mac OS El Capitan Safari, Classic, desktop browsers and Manifest-->
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicon-120x120.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    
        <!--set tile and address bar colour-->
        <meta name="msapplication-TileColor" content="#414287">
        <meta name="theme-color" content="#414287">

        <title>EpiCare - Home</title>
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
                    <li class="nav-item"><a href="index.php" class="nav-link active">Diary</a></li>
                    <li class="nav-item"><a href="myinfo.php" class="nav-link">My info</a></li>
                    <li class="nav-item"><a href="community.php" class="nav-link">Community</a></li>
                    <li class="nav-item"><a href="resources.php" class="nav-link">Resources</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Log out</a></li>
                </ul>
            </nav>
            <main>
                <?php
                //Retrieve event variables from modal
                $eventDate = filter_has_var(INPUT_POST, 'eventDate') ? $_POST['eventDate']: null;
                $eventType = filter_has_var(INPUT_POST, 'eventType') ? $_POST['eventType']: null;

                //Remove whitespace from data
                $eventDate = trim($eventDate);
		        $eventType = trim($eventType);

                //validate date format 
                if (validateDateFormat($eventDate)) {

                    //data is valid - continue processing event data
                    try {
                        //Link functions to get db connection, error functions and log in functions
                        require_once( "functions.php" );

                        //Connect to databse
				        $dbConn = getConnection();

                        //Check if user_id exists
                        if (isset($_SESSION['user_id'])) {

                            //if user_id exists store user_id in variable
                            $user_id = $_SESSION[ 'user_id']; 

                            //use try catch block to insert event date 
                            try {

                                //insert data into epicare_events using PDO
                                $sqlEvent = "INSERT INTO epicare_events (user_id, event_date, event_type) VALUES (:user_id, :eventDate, :eventType)";
                                
                                //Execute query
                                $stmtEvent = $dbConn->prepare($sqlEvent);
                                $stmtEvent->execute(array(':user_id' => $user_id, ':eventDate' => $eventDate, ':eventType' => $eventType));

                                //retrieve event last event id (which wil be this one) and store in variable for next query
                                $event_id = $dbConn->lastInsertId();

                                //as there are differrent forms for different event types the evnttype will need to be determined first
                                if ($eventType == "seizure") {

                                    //retrieve variables from seizure form
                                    $seizure_type = filter_has_var(INPUT_POST, 'seizure_type') ? $_POST['seizure_type'] : null;
                                    $warnings = filter_has_var(INPUT_POST, 'warnings') ? $_POST['warnings'] : null;
                                    $sleep = filter_has_var(INPUT_POST, 'sleep') ? $_POST['sleep'] : null;
                                    $triggers = filter_has_var(INPUT_POST, 'triggers') ? $_POST['triggers'] : null;
                                    $psr = filter_has_var(INPUT_POST, 'psr') ? $_POST['psr'] : null;
                                    $location = filter_has_var(INPUT_POST, 'location') ? $_POST['location'] : null;
                                    $comments = filter_has_var(INPUT_POST, 'comments') ? $_POST['comments'] : null;

                                    //remove whitespace from variables
                                    $seizure_type = trim($seizure_type);
                                    $warnings = trim($warnings);
                                    $sleep = trim($sleep);
                                    $triggers = trim($triggers);
                                    $psr = trim($psr);
                                    $location = trim($location);
                                    $comments = trim($comments);

                                    //sanitize location and comments
                                    $location = filter_var($location, FILTER_SANITIZE_STRING);
                                    $comments = filter_var($comments, FILTER_SANITIZE_STRING);

                                    //check length of location
                                    if (strlen($location) < 255) {
                                        try {

                                            //insert data into epicare_seizures using PDO
                                            $sqlSeizure = "INSERT INTO epicare_seizures (user_id, event_id, seizure_type, warnings, sleep, triggers, psr, location, comments) VALUES (:user_id, :event_id, :seizure_type, :warnings, :sleep, :triggers, :psr, :location, :comments)";
                                            
                                            //Execute query
                                            $stmtSeizure = $dbConn->prepare($sqlSeizure);
                                            $stmtSeizure->execute(array(':user_id' => $user_id, ':event_id' => $event_id, ':seizure_type' => $seizure_type, ':warnings' => $warnings, ':sleep' => $sleep, ':triggers' => $triggers, ':psr' => $psr, ':location' => $location, ':comments' => $comments));
                                        }
                                        catch (Exception $e) {

                                            //Output error message
                                            echo "<h1 class='profile-error text-center'>There was a problem recording your seizure.</h1>\n";
                                            echo "<p class='profile-error text-center'>Please <a href='index.php'>try again</a></p>";
                                
                                            //Log errors
                                            log_error($e);
                                        }
                                    } else {
                                        //Output error message
                                        echo "<h1 class='profile-error text-center'>Location is too long. Maximum length is 255 characters.</h1>\n";
                                        echo "<p class='profile-error text-center'>Please log in and <a href='index.php'>try again</a></p>";
                                    }

                                    //redirecct to home page
                                    header('Location: index.php');

                                } else if ($eventType == "mood") {

                                    //retrieve variables from moods form
                                    $mood = filter_has_var(INPUT_POST, 'mood') ? $_POST['mood'] : null;

                                    //remove whitespace from variables
                                    $mood = trim($mood);

                                    //check mood is a number and between 1 to 10
                                    if (is_numeric($mood) && $mood >= 1 && $mood <= 10) {
                                        try {
                                            //insert data into epicare_moods using PDO
                                            $sqlMoods = "INSERT INTO epicare_moods (user_id, event_id, mood_scale) VALUES (:user_id, :event_id, :mood_scale)";
                                            
                                            //Execute query
                                            $stmtMoods = $dbConn->prepare($sqlMoods);
                                            $stmtMoods->execute(array(':user_id' => $user_id, ':event_id' => $event_id, ':mood_scale' => $mood));
                                        }
                                        catch (Exception $e) {

                                            //Output error message
                                            echo "<h1 class='profile-error text-center'>There was a problem processing your mood.</h1>\n";
                                            echo "<p class='profile-error text-center'>Please <a href='index.php'>try again</a></p>";
                                
                                            //Log errors
                                            log_error($e);
                                        }
                                    } else {
                                        //Output error message
                                        echo "<h1 class='profile-error text-center'>Your mood needs to be on a scake from 1-10.</h1>\n";
                                        echo "<p class='profile-error text-center'>Please log in and <a href='index.php'>try again</a></p>";
                                    }

                                    //redirevt to home page
                                    header('Location: index.php');

                                } else if ($eventType == "appointment") {

                                    //retrieve variables from appointments form
                                    $doctor = filter_has_var(INPUT_POST, 'doctorName') ? $_POST['doctorName'] : null;
                                    $app_location = filter_has_var(INPUT_POST, 'appointmentLocation') ? $_POST['appointmentLocation'] : null;

                                    //remove whitespace from variables
                                    $doctor = trim($doctor);
                                    $app_location = trim($app_location);

                                    //check location is less than 255 charcters
                                    if (strlen($app_location) <= 255) {
                                        try {

                                            //insert data into epicare_apps using PDO
                                            $sqlApps = "INSERT INTO epicare_apps (user_id, event_id, doctor_name, location) VALUES (:user_id, :event_id, :doctor_name, :location)";
                                            
                                            //Execute query
                                            $stmtApps = $dbConn->prepare($sqlApps);
                                            $stmtApps->execute(array(':user_id' => $user_id, ':event_id' => $event_id, ':doctor_name' => $doctor, ':location' => $app_location));
                                        }
                                        catch (Exception $e) {

                                            //Output error message
                                            echo "<h1 class='profile-error text-center'>There was a problem logging your appointment.</h1>\n";
                                            echo "<p class='profile-error text-center'>Please <a href='index.php'>try again</a></p>";
                                
                                            //Log errors
                                            log_error($e);
                                        }
                                    } else {
                                        //Output error message
                                        echo "<h1 class='profile-error text-center'>Your location is too long. It needs to be under 255 characters..</h1>\n";
                                        echo "<p class='profile-error text-center'>Please log in and <a href='index.php'>try again</a></p>";
                                    }

                                    //redirect to home page 
                                    header('Location: index.php');
                                }
                            }
                            catch (Exception $e) {

                                //Output error message
                                echo "<h1 class='profile-error text-center'>There was a problem saving your event.</h1>\n";
                                echo "<p class='profile-error text-center'>Please <a href='index.php'>try again</a></p>";
                    
                                //Log errors
                                log_error($e);
                            }

                        } else {

                            //Output error message
                            echo "<h1 class='profile-error text-center'>There was a problem verifying your account.</h1>\n";
                            echo "<p class='profile-error text-center'>Please log in and <a href='login.php'>try again</a></p>";

                        }
                    } 
                    catch (Exception $e) {

                        //Output error message
                        echo "<h1 class='profile-error text-center'>There was a problem.</h1>\n";
                        echo "<p class='profile-error text-center'>Please <a href='index.php'>try again</a></p>";
            
                          //Log errors
                          log_error($e);
                    }

                } else {

                    //date is not valid - output error message
	  		        echo "<h1 class='profile-error text-center'>Date format is not valid</h1>\n";
                    echo "<p class='profile-error text-center'>Please <a href='index.php'>try again</a></p>";
                }

                //function to validate date format
                function validateDateFormat($date) {
                    $d = DateTime::createFromFormat('Y-m-d', $date);
                    return $d && $d->format('Y-m-d') === $date;
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