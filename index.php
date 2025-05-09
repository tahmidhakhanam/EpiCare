<?php
// Session variables are stored in a folder specified below
// sessionData path
ini_set("session.save_path", "/home/unn_w17017369/public_html/sessionData");

// Create a new session with a session ID
session_start();
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!--customized stylesheet-->
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
        <div class="epicare">
            <p>EpiCare</p>
        </div>
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

            <!--add event button-->
            <button type="button" class="btn btn-primary" id="add-event" data-bs-toggle="modal" data-bs-target="#addEventModal">
                Add Event
            </button>

            <!--calendar headings-->
            <div class="calendar">
                <table>
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!--rest of the calendar is generated using functions-->
                        <?php
                        try {
                            // Link functions to get db connection, error functions, and log in functions
                            require_once("functions.php");

                            // Connect to the database
                            $dbConn = getConnection();

                            // check if user_id exists
                            if (isset($_SESSION['user_id'])) {

                                // if user_id exists store user_id in variable
                                $user_id = $_SESSION['user_id'];

                                
                            } else {

                                // Output error message
                                echo "<h1 class='profile-error text-center'>There was a problem verifying your account.</h1>\n";
                                echo "<p class='profile-error text-center'>Please log in and <a href='login.php'>try again</a></p>";
                            }
                        } catch (Exception $e) {

                            // Output error message
                            echo "<h1 class='profile-error text-center'>There was a problem.</h1>\n";
                            echo "<p class='profile-error text-center'>Please <a href='index.php'>try again</a></p>";

                            // Log errors
                            log_error($e);
                        }

                        // function to get the first day of the month
                        function getFirstDayOfMonth($year, $month)
                        {
                            return date("w", strtotime("{$year}-{$month}-01"));
                        }

                        // function to get days
                        function getDaysInMonth($year, $month)
                        {
                            return date("t", strtotime("{$year}-{$month}-01"));
                        }

                        // Calculate current month and year and store in variables
                        $currentMonth = date('n');
                        $currentYear = date('Y');

                        $firstDay = getFirstDayOfMonth($currentYear, $currentMonth);
                        $daysInMonth = getDaysInMonth($currentYear, $currentMonth);

                        // generate calendar table
                        echo '<tr>';

                        // calculate empty cells before the first day and print
                        for ($i = 0; $i < $firstDay; $i++) {
                            echo '<td></td>';
                        }

                        // print days
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            echo '<td>';
                            echo "<div class='day'>$day</div>";

                            //retrieve events for the current day
                            $currentDate = date("Y-m-d", strtotime("{$currentYear}-{$currentMonth}-{$day}"));
                            $events = getEventsForDate($dbConn, $currentDate, $user_id);

                            //display events
                            foreach ($events as $event) {
                                echo "<div class='event'>{$event['event_type']}</div>";
                            }
                            echo '</td>';

                            // print a new row for each week
                            if (($day + $firstDay) % 7 === 0 && $day < $daysInMonth) {
                                echo '</tr><tr>';
                            }
                        }

                        // calculate empty cells at the end of the month and print
                        $lastDayOfWeek = ($firstDay + $daysInMonth) % 7;
                        for ($i = $lastDayOfWeek; $i < 6; $i++) {
                            echo '<td></td>';
                        }
                        echo '</tr>';

                        //function to retrive evnts events for specific user
                        function getEventsForDate($dbConn, $date, $loggedInUserId)
                        {
                            $sql = "SELECT * FROM epicare_events WHERE event_date = :date AND user_id = :user_id";
                            $stmt = $dbConn->prepare($sql);

                            // Bind parameters
                            $stmt->bindParam(':date', $date);
                            $stmt->bindParam(':user_id', $loggedInUserId);

                            //execute the query
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            return $result;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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

            <!-- This JavaScript snippet will automatically update the copyright year, depending on the user's time settings -->
            <script type="text/javascript">
                document.write(new Date().getFullYear());
            </script> EpiCare. All Rights Reserved.</small></p>
        </div>
    </footer>

    <!--this code is only called if the user adds an event-->
    <!--modal to add an event-->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--start of modal form-->
                    <form id="eventForm" action="eventProcess.php" method="post">
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Event Date:</label>

                            <!--function to display current date but user can manually change if they wanted to-->
                            <?php
                            $currentDate = date('Y-m-d');
                            ?>
                            <input type="date" class="form-control" id="eventDate" name="eventDate" value="<?php echo $currentDate; ?>" required>
                        </div>

                        <!--dropdown for event type-->
                        <div class="mb-3">
                            <label for="eventType" class="form-label">Event Type:</label>
                            <select class="form-select" id="eventType" name="eventType">
                                <option value="seizure">Seizure</option>
                                <option value="mood">Mood</option>
                                <option value="appointment">Appointment</option>
                            </select>
                        </div>

                        <!--seizure form - only visible is seizure is selected as event type-->
                        <div id="seizureFields" class="mb-3 dynamic-fields">

                            <!--dropdown list for seizure type-->
                            <label for="seizureType" class="form-label">Seizure Type:</label>
                            <select class="form-select" id="seizureType" name="seizureType">
                                <option value="gtc">Generalized Tonic Clonic Seizure</option>
                                <option value="gas">Generalized Absence Seizure</option>
                                <option value="gms">Generalized Motor Seizure</option>
                                <option value="fas">Focal Aware Seizure</option>
                                <option value="fis">Focal Impaired Seizure</option>
                                <option value="other">Other</option>
                            </select>

                            <!--warning and sleep checkboxes-->
                            <div class="form-check">
                                <input class="checkbox" class="form-check-input" type="checkbox" id="warnings" name="warnings">
                                <label class="form-check-label" for="warnings">Warnings</label>
                            </div>
                            <div class="form-check">
                                <input class="checkbox" class="form-check-input" type="checkbox" id="duringSleep" name="duringSleep">
                                <label class="form-check-label" for="duringSleep">During Sleep</label>
                            </div>

                            <!--dropdown list for triggers and post-seizure reactions-->
                            <label for="triggers" class="form-label">Triggers:</label>
                            <select class="form-select" id="triggers" name="triggers" multiple onchange="updateSelectedOptions('triggers', 'selectedTriggers')">
                                <option value="none" selected>None</option>
                                <option value="stress">Stress</option>
                                <option value="lackOfSleep">Lack of Sleep</option>
                                <option value="tired">Tired</option>
                                <option value="missedDose">Missed Dose</option>
                                <option value="period">Period</option>
                                <option value="sickness">Sickness</option>
                                <option value="alcohol">Alcohol</option>
                                <option value="otherTriggers">Other</option>
                            </select>
                            <div id="selectedTriggers" class="selected-options"></div>

                            <label for="postReactions" class="form-label">Post Seizure Reactions:</label>
                            <select class="form-select" id="postReactions" name="postReactions" multiple onchange="updateSelectedOptions('postReactions', 'selectedReactions')">
                                <option value="none" selected>None</option>
                                <option value="confusion">Confusion</option>
                                <option value="paralysis">Paralysis</option>
                                <option value="muscleSoreness">Muscle Soreness</option>
                                <option value="fatigue">Fatigue</option>
                                <option value="nausea">Nausea</option>
                                <option value="deepSleep">Deep Sleep</option>
                                <option value="otherReactions">Other</option>
                            </select>
                            <div id="selectedReactions" class="selected-options"></div>

                            <!--location and comments-->
                            <div class="mb-3">
                                <label for="location" class="form-label">Location:</label>
                                <input type="text" class="form-control" id="location" name="location">
                            </div>
                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments:</label>
                                <input type="text" class="form-control" id="comments" name="comments">
                            </div>
                        </div>
                        <!--end of seizure form-->

                        <!--start of moods form-->
                        <div id="moodFields" class="mb-3 dynamic-fields">
                            <label for="mood" class="form-label">Mood:</label>
                            <div class="mood-scale">
                                <!--mood emojis-->
                                <span class="mood-emoji unhappy">&#128577;</span>
                                <!--mood scale 1-10-->
                                <input type="range" id="mood" name="mood" min="1" max="10" step="1" value="5" oninput="updateMoodLabel()">
                                <span class="mood-emoji happy">&#128512;</span>
                                <span id="selectedMoodLabel">5</span>
                            </div>
                        </div>
                        <!--end of moods form-->

                        <!--start of appointments form-->
                        <div id="appointmentFields" class="mb-3 dynamic-fields">
                            <div class="mb-3">
                                <label for="doctorName" class="form-label">Name of Doctor:</label>
                                <input type="text" class="form-control" id="doctorName" name="doctorName">
                            </div>
                            <div class="mb-3">
                                <label for="appointmentLocation" class="form-label">Location:</label>
                                <input type="text" class="form-control" id="appointmentLocation" name="appointmentLocation">
                            </div>
                        </div>
                        <!--end of appointments form-->

                        <!--submit button -->
                        <button id="saveButton" type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--event listeners for modal-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //hide modal 
            document.querySelectorAll('.dynamic-fields').forEach(function (field) {
                field.style.display = 'none';
            });

            //show seizure form by default
            document.getElementById('seizureFields').style.display = 'block';
            console.log('Seizure form is displayed by default.');

            //show form based on selected event type
            document.getElementById('eventType').addEventListener('change', function () {
                document.querySelectorAll('.dynamic-fields').forEach(function (field) {
                    field.style.display = 'none';
                });
                var selectedType = this.value;
                document.getElementById(selectedType + 'Fields').style.display = 'block';
            });
        });
    </script>

    <!--functions used in modal-->
    <script>
        
        //displays selected options for users - seizure form
        function updateSelectedOptions(dropdownId, containerId) {
            var selectedOptions = [];
            var dropdown = document.getElementById(dropdownId);

            for (var i = 0; i < dropdown.options.length; i++) {
                if (dropdown.options[i].selected) {
                    selectedOptions.push(dropdown.options[i].text);
                }
            }

            var container = document.getElementById(containerId);
            container.innerHTML = selectedOptions.join(', ');
        }

        //displays updated value on mood scale as user inputs - mood form 
        function updateMoodLabel() {
            var moodInput = document.getElementById('mood');
            var moodLabel = document.getElementById('selectedMoodLabel');
            moodLabel.textContent = moodInput.value;
        }
    </script>

    <!--bootstrap and fontawesome links-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/799d082bbd.js" crossorigin="anonymous"></script>
</body>

</html>

