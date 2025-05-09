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

        <!--bootstrap link-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">        
        
        <!--customised stylesheet-->
        <link href="css/community.css" rel="stylesheet">

        <!--favicon for iOS Safari, Android Chrome, Windows 8 and 10, Mac OS El Capitan Safari, Classic, desktop browsers and Manifest-->
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicon-120x120.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    
        <!--set tile and address bar colour-->
        <meta name="msapplication-TileColor" content="#414287">
        <meta name="theme-color" content="#414287">

        <title>EpiCare - Community</title>
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
                    <li class="nav-item"><a href="myinfo.php" class="nav-link">My info</a></li>
                    <li class="nav-item"><a href="community.php" class="nav-link active">Community</a></li>
                    <li class="nav-item"><a href="resources.php" class="nav-link">Resources</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Log out</a></li>
                </ul>
            </nav>
            <main>
                <!--button to add message-->
                <button type="button" class="btn btn-primary" id="add-message" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    Add Message
                </button>
                <h2 class="text-center">Community Forum</h2>
                <?php
				try {
					// include the file with the function for the database connection
					require_once('functions.php');

					// get database connection
					$dbConn = getConnection();

                    //Check if user_id exists
                    if (isset($_SESSION['user_id'])) {

                        //if user_id exists store user_id in variable
                        $user_id = $_SESSION[ 'user_id']; 

                        //sql to retrive username and post details 
                        $selectSQL =  "SELECT e.*, u.username
                            FROM epicare_community e
                            JOIN epicare_users u ON e.user_id = u.user_id";

                        //Execute query and fetch data
                        $queryResult = $dbConn->query( $selectSQL );

                        //print results in table
                        echo "<table>
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody> ";

                        //while loop is used print each message 
                        while ($forum = $queryResult->fetchObject()) {
                            $username = $forum->username;
                            $message = $forum->message;
                            echo "
                            <tr>
                                <td>$username</td>
                                <td>" . filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS) . "</td>
                                <td>{$forum->comm_date}</td>
                            </tr>
                        
                            ";
                        }
                        echo "</tbody>
                        </table>";
                    } else {

                        //Output error message
                        echo "<h1 class='profile-error text-center'>There was a problem verifying your account.</h1>\n";
                        echo "<p class='profile-error text-center'>Please log in and <a href='login.php'>try again</a></p>";
                    }
				}
				catch (Exception $e) {

					//Output error message
                    echo "<h1 class='profile-error text-center'>There was a problem.</h1>\n";
                    echo "<p class='profile-error text-center'>Please <a href='community.php'>try again</a></p>";
        
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

        <!--modal to add message-->
        <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEventModalLabel">Add Message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="eventForm" action="communityProcess.php" method="post">
                            <div class="mb-3">
                                <input type="hidden" id="hiddenDateTime" name="hiddenDateTime" value="">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            </div>
                            <!--submit button -->
                            <button id="saveButton" type="submit" class="btn btn-primary">Submit</button>
                        </form>
                     </div>
                </div>
            </div>
        </div>

        <!-- Event Listeners for Modal -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
           
            //when user cicks add emssage modal will open
            var addMessageBtn = document.getElementById("add-message");
            addMessageBtn.addEventListener("click", function () {
                var addEventModal = new bootstrap.Modal(document.getElementById('addEventModal'));
                addEventModal.show();
            });

            //event listeneer for submit button
            var form = document.getElementById("eventForm");
            form.addEventListener("submit", function (event) {

                // Prevent default form submission
                event.preventDefault();

                //current date and time for hiddeen value in form
                var currentDateTime = new Date().toISOString();
                document.getElementById("hiddenDateTime").value = currentDateTime;

                // Submit form
                form.submit();
            });
        });
        </script>

        <!--boostrap and fontawesome lnks-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/799d082bbd.js" crossorigin="anonymous"></script>
    </body>
</html>