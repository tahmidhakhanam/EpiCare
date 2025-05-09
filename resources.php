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
        <link href="css/resources.css" rel="stylesheet">

        <!--favicon for iOS Safari, Android Chrome, Windows 8 and 10, Mac OS El Capitan Safari, Classic, desktop browsers and Manifest-->
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicon-120x120.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    
        <!--set tile and address bar colour-->
        <meta name="msapplication-TileColor" content="#414287">
        <meta name="theme-color" content="#414287">

        <title>EpiCare - Resources</title>
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
                <h2>Resources</h2>

                <!--Disaplay articles 3 in a row-->
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 article-container">
                            <div class="article">
                                <a href="https://www.epilepsy.com/parents-and-caregivers/kids/symptoms">
                                    <img src="images/article1.jpg" alt="Signs and Symptoms of Epilepsy in Children">
                                    <h4 class="article-title">Signs and Symptoms of Epilepsy in Children</h4>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 article-container">
                            <div class="article">
                                <a href="https://riseaboveepilepsy.com/9-ways-to-manage-stress-while-living-with-epilepsy/">
                                    <img src="images/article2.jpg" alt="9 Ways to Manage Stress While Living with Epilepsy">
                                    <h4 class="article-title">9 Ways to Manage Stress While Living with Epilepsy</h4>
                                </a>    
                            </div>
                        </div>

                        <div class="col-md-4 article-container">
                            <div class="article">
                                <a href="https://www.neuropace.com/blog/epilepsy-mental-health-depression-anxiety-stress/">
                                    <img src="images/article3.jpg" alt="Epilepsy, Depression, and Stress: Mental Haelth Tips">
                                    <h4 class="article-title">Epilepsy, Depression, and Stress: Mental Haelth Tips</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end f row 1-->

                    <!--row 2-->
                    <div class="row">
                        <div class="col-md-4 article-container">
                            <div class="article">
                                <a href="https://epilepsysociety.org.uk/about-epilepsy/first-aid-epileptic-seizures/seizure-first-aid?gclid=CjwKCAiAiP2tBhBXEiwACslfng4-Mr2yLZYqNdaW4ErwVNPsiyEKNzWrshplmul5P9rtD8qiE4f2BRoCrMgQAvD_BwE">
                                    <img src="images/article4.jpg" alt="Step by Step Guide: Epilepsy First Aid Treatment">
                                    <h4 class="article-title">Step by Step Guide: Epilepsy First Aid Treatment</h4>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 article-container">
                            <div class="article">
                                <a href="https://www.brainfacts.org/diseases-and-disorders/epilepsy/2018/how-do-ketogenic-diets-help-people-with-epilepsy-081418">
                                    <img src="images/article5.jpg" alt="How Ketogenic Diets Help with Epilepsy">
                                    <h4 class="article-title">How Ketogenic Diets Help with Epilepsy</h4>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4 article-container">
                            <div class="article">
                                <a href="https://www.epilepsy.org.uk/living/driving">
                                    <img src="images/article6.jpg" alt="Driving with Epilepsy">
                                    <h4 class="article-title">Driving with Epilepsy</h4>
                                </a>
                            </div>
                        </div>
                    </div>
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

			    <!-- This javascript snippet will automatically update the copyright year, depending on the user's time settings -->
		        <script type="text/javascript">
			        document.write(new Date().getFullYear());
		        </script> EpiCare. All Rights Reserved.</small></p>
            </div>
        </footer>

        <!--bootstrap and fontawesoe links-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/799d082bbd.js" crossorigin="anonymous"></script> 
    </body>
</html>