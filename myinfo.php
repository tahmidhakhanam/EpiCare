<?php
//Session variables are stored in a folder specified below
//sessionData path
ini_set( "session.save_path", "/home/unn_w17017369/public_html/sessionData" );

//Create a new session with a session ID
session_start();

//code to generate reprot -  this had to be moved to the top to work correctly
//Check if user_id exists
if (isset($_SESSION['user_id'])) {

    //if user_id exists store user_id in variable
    $user_id = $_SESSION[ 'user_id']; 

    //code to generate report 
    if (isset($_POST['generate_report'])) {

        // include the file with the function for the database connection
        require_once('functions.php');

        // get database connection
        $dbConn = getConnection();

        try {
            $reportSQL = "SELECT
                u.firstname, u.surname, t.name, t.dose, t.frequency, t.side_effects, s.seizure_type, s.warnings, s.sleep, s.triggers, s.psr, s.location, s.comments, a.doctor_name, a.location,
                CURDATE() AS date_of_report
            FROM
                epicare_users u
                LEFT JOIN epicare_treatments t ON u.user_id = t.user_id
                LEFT JOIN epicare_seizures s ON u.user_id = s.user_id
                LEFT JOIN epicare_apps a ON u.user_id = a.user_id
            WHERE
                u.user_id = $user_id";

            //Execute query and fetch data
            $reportResult = $dbConn->query( $reportSQL );
            $report = $reportResult->fetchObject();

            //CSV content header
            $csvContent = "First name, Last name, Treatment name, Treatment dose, Treatment frequency, Treatment side effects, Seizure type, Seizure warnings (0=no, 1=yes), During sleep (0=no, 1=yes), Seizure triggers, post seizure reaction, Seizure location, Seizure comments, Appointment doctor, Appointment location, Date of Report\n";

            // If there is data for the user, format it into a CSV row
            if ($report) {
                $csvContent .= "{$report->firstname},{$report->surname},{$report->name},{$report->dose},{$report->frequency},{$report->side_effects},{$report->seizure_type},{$report->warnings},{$report->sleep},{$report->triggers},{$report->psr},{$report->location},{$report->comments},{$report->doctor_name},{$report->location},{$report->date_of_report}\n";
            }


            // Set the HTTP headers for CSV download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="user_report.csv"');
            header('Cache-Control: max-age=0');

            // Output the CSV content
            echo $csvContent;

            // Exit to avoid any additional output
            exit;                       
        }
        catch (Exception $e) {

            //Output error message
            echo "<h1 class='profile-error text-center'>There was a problem generating your report.</h1>\n";
            echo "<p class='profile-error text-center'>Please <a href='myinfo.php'>try again</a></p>";

            //Log errors
            log_error($e);
        }
    } else {
        //Output error message
        //echo "<h1 class='profile-error text-center'>There was a problem verifying your account. 1</h1>\n";
       // echo "<p class='profile-error text-center'>Please log in and <a href='login.php'>try again</a></p>";
    }
}
?>

<!doctype html>
<html lang="en">
   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--bootstrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">        
        
        <!--bootstrap and fontawesoe links-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/799d082bbd.js" crossorigin="anonymous"></script> 

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
                //treatments including side effects
				try {
					// include the file with the function for the database connection
					require_once('functions.php');

					// get database connection
					$dbConn = getConnection();

                    //Check if user_id exists
                    if (isset($_SESSION['user_id'])) {

                        //if user_id exists store user_id in variable
                        $user_id = $_SESSION[ 'user_id']; 

                        try {
                            $treatmentSQL =  "SELECT *
                                FROM epicare_treatments
                                WHERE user_id = $user_id";

                            //Execute query and fetch data
                            $treatmentResult = $dbConn->query( $treatmentSQL );

                            //print out treatments in table - add teratement button will be displayed frst 
                            echo "<h2>Your Treatments</h2>
                           
                            <button type='button' class='btn btn-primary' id='addTreatment' data-bs-toggle='modal' data-bs-target='#addTreatmentModal'>
                                Add Treatment
                            </button>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Dose</th>
                                        <th>Frequency</th>
                                        <th>Side effects</th>
                                    </tr>
                                </thead>
                                <tbody> ";
                                
                                //loop through all treatments to print
                            while ($treatment = $treatmentResult->fetchObject()) {

                                echo "
                                <tr>
                                    <td>" . filter_var($treatment->name, FILTER_SANITIZE_SPECIAL_CHARS) . "</td>
                                    <td>{$treatment->dose} mg</td>
                                    <td>{$treatment->frequency}</td>
                                    <td>{$treatment->side_effects}</td>
                                </tr>
                                ";
                            }
                            echo "</tbody>
                            </table>";
                        }
                        catch (Exception $e) {

                            //Output error message
                            echo "<h1 class='profile-error text-center'>There was a problem retrieving your treatment details.</h1>\n";
                            echo "<p class='profile-error text-center'>Please <a href='myinfo.php'>try again</a></p>";
                
                            //Log errors
                            log_error($e);
                        }

                        //code to diaplay and add contacts 
                        try {
                            
                            //sql to retrive contact details
                            $contactSQL =  "SELECT *
                                FROM epicare_contacts
                                WHERE user_id = $user_id";

                            //Execute query and fetch data
                            $contactResult = $dbConn->query( $contactSQL );

                            //print add contact button and contact details in table
                            echo "<h2>Your Contacts</h2>
                            <button type='button' class='btn btn-primary' id='addContact' data-bs-toggle='modal' data-bs-target='#addContactModal'>
                                Add Contact
                            </button>
                            
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody> ";

                            while ($contact = $contactResult->fetchObject()) {
                                $contact_phone = $contact->phone;

                                echo "
                                <tr>
                                    <td>" . filter_var($contact->name, FILTER_SANITIZE_SPECIAL_CHARS) . "</td>
                                    <td>" . filter_var($contact->email, FILTER_SANITIZE_SPECIAL_CHARS) . "</td>
                                    <td>" . filter_var($contact_phone, FILTER_SANITIZE_SPECIAL_CHARS) . " 
                                        <button type='button' class='btn btn-primary' id='send-reminder' data-bs-toggle='modal' data-bs-target='#sendReminderModal'>
                                        Send reminder
                                        </button>
                                    </td>
                                </tr>
                                ";
                            }
                            echo "</tbody>
                            </table>";
                        }
                        catch (Exception $e) {

                            //Output error message
                            echo "<h1 class='profile-error text-center'>There was a problem retrieving your contact details.</h1>\n";
                            echo "<p class='profile-error text-center'>Please <a href='myinfo.php'>try again</a></p>";
                
                            //Log errors
                            log_error($e);
                        }
                    
                        echo "<form method='post' id='generateReport'>
                                    <button type='submit' class='btn btn-primary' name='generate_report'>Generate Report</button>
                                </form>";

                    } else {
                        //Output error message
                        echo "<h1 class='profile-error text-center'>There was a problem verifying your account.</h1>\n";
                        echo "<p class='profile-error text-center'>Please log in and <a href='login.php'>try again</a></p>";
                    }
				}
				catch (Exception $e) {

					//Output error message
                    echo "<h1 class='profile-error text-center'>There was a problem.</h1>\n";
                    echo "<p class='profile-error text-center'>Please <a href='myinfo.php'>try again</a></p>";
        
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



        <!--start of modal for treatments-->
        <div class="modal fade" id="addTreatmentModal" tabindex="-1" aria-labelledby="addTreatmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTreatmentLabel">Add Treatment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="treatmentForm" action="treatment.php" method="post">

                            <div class="mb-3">
                                <label for="medName" class="form-label">Name*</label>
                                <input type="text" class="form-control" id="medName" name="medName" required>
                            </div>
     
                            <div class="mb-3">
                                <label for="dose" class="form-label">Dose (mg)*</label>
                                <input type="number" class="form-control" id="dose" name="dose" required>
                            </div>

                            <!--drop down list for frequency-->
                            <label id="labelFrequency" for="frequency" class="form-label">Frequency</label>
                            <select class="form-select" id="frequency" name="frequency">
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Yearly">Yearly</option>
                                <option value="Other">Other</option>
                            </select>

                            <!--drop down list for side effects-->
                            <label id="labelSideEffects" for="sideEffects" class="form-label">Side effects</label>
                            <select class="form-select" id="sideEffects" name="sideEffects">
                                <option value="None" selected>None</option>
                                <option value="Unsteadiness">Unsteadiness</option>
                                <option value="Tiredness">Tiredness</option>
                                <option value="Restlessness">Restlessness</option>
                                <option value="Headache">Headache</option>
                                <option value="BlurredVision">Blurred vision</option>
                                <option value="DifficultyInConcentrating">Difficulty in concentrating</option>
                                <option value="Diziness">Diziness</option>
                                <option value="Other">Other</option>
                            </select>
                                                        
                            <button id="add-treatment" type="submit" class="btn btn-primary">Save</button>
                        </form>
                     </div>
                </div>
            </div>
        </div>

        <!--start of modal for contacts-->
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContactLabel">Add Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="contactForm" action="contact.php" method="post">

                            <div class="mb-3">
                                <label for="contactName" class="form-label">Name*</label>
                                <input type="text" class="form-control" id="contactName" name="contactName" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone (optional)</label>
                                <input type="int" class="form-control" id="phone" name="phone" maxlength="11">
                            </div>
                           
                            <button id="add-contact" type="submit" class="btn btn-primary">Save</button>
                        </form>
                     </div>
                </div>
            </div>
        </div>

        <!--start of modal for reminders-->
        <div class="modal fade" id="sendReminderModal" tabindex="-1" aria-labelledby="sendReminderModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendReminderLabel">Send Reminder</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="reminderForm" action="reminder.php" method="post">
                            <div class="mb-3">
                                <div id='contactFields' class='mb-3 dynamic-fields'>
                                    <label for='contactName' class= 'form-label'>Contacts</label>
                                        <select class='form-select' id='contactName' name='contactName'>
                                            <?php

                                            try {
                                                //Check if user_id exists
                                                if (isset($_SESSION['user_id'])) {
                                                    //if user_id exists store user_id in variable
                                                    $user_id = $_SESSION[ 'user_id']; 

                                                    try {
                                                        // include the file with the function for the database connection
                                                        require_once('functions.php');
                    
                                                        // get database connection
                                                        $dbConn = getConnection();
                    
                                                        //sql to retrieve contacts from db
                                                        $contactSQL2 = "SELECT * 
                                                        FROM epicare_contacts
                                                        WHERE user_id = $user_id";
                                    
                                                        // execute the query
                                                        $contactResult2 = $dbConn->query($contactSQL2);

                                                        //display current contacts
                                                        while ($contactR = $contactResult2->fetchObject()) {
                                                            echo "\t
                                                                    <option value='$contactR->contact_id'>$contactR->name</option>
                                                                \n";
                                                        }
                                                    }
                                                    catch (Exception $e) {
                                                        throw new Exception("Problem " . $e->getMessage(), 0, $e);
                                                    }
                                                
                                                } else {
                                                    //Output error message
                                                    echo "<h1 class='profile-error text-center'>There was a problem verifying your account.</h1>\n";
                                                    echo "<p class='profile-error text-center'>Please log in and <a href='login.php'>try again</a></p>";
                                                }
                                            }
                                            catch (Exception $e) {

                                                //Output error message
                                                echo "<h1 class='profile-error text-center'>There was a problem. 2</h1>\n";
                                                echo "<p class='profile-error text-center'>Please <a href='myinfo.php'>try again</a></p>";
                                    
                                                //Log errors
                                                log_error($e);
                                            }
                                            ?>
                                        </select>
                             </div>

                            <!--submit button -->
                            <button id="send-reminder" type="submit" class="btn btn-primary">Submit</button>
                        </form>
                     </div>
                </div>
            </div>
        </div>
       
        <!--JS for modals-->
        <script src="js/reminder.js"></script>
        <script src="js/treatment.js"></script>
        <script src="js/contact.js"></script>  
    </body>
</html>