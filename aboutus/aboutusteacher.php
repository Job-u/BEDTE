<<?php 
   session_start();

   include("../phpsql/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: ../profile/login.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Font Awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">

    <title>Project Team</title>
    <link rel="stylesheet" href="../style/aboutus.css">
    <link rel="stylesheet" href="../style/userdashboard.css">
    
</head>
<body>

<nav class="navbar">
        <a href="../teacherdashboard/teacherdashboard.php">
            <div class="logo">
                <img src="../img/LOGO.png" alt="">
                <span>BEDTE</span>
            </div>
        </a>
        <ul class="nav_items" id="nav_links">
            <div class="item">
                <li><a href="../teacherdashboard/manage_scores.php">Student Scores</a></li>
                <li><a href="../teacherdashboard/manage_questions.php">Manage Questions</a></li>
            </div>
            <div class="nav_btn">
                <a href="../phpsql/logout.php"><button class="btn btn2">Logout</button></a>
            </div>
        </ul>
        <div class="nav_menu" id="menu_btn">
            <i class="ri-menu-line"></i>
        </div>
    </nav>


    <div class="wrapper">

        <div class="title">
            <h4>Our Team Section</h4>
        </div>

        <div class="card_Container">

            <div class="card">

                <div class="imbBx">
                    <img src="../img/antonio.png" alt="">
                </div>

                <div class="content">
                    <div class="contentBx">
                        <h3>Joemari Antonio Shane <br><span>Lead Programmer</span></h3>
                    </div>
                    <ul class="sci">
                        <li style="--i: 1">
                            <a href="https://www.instagram.com/shaneeezz.0" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        </li>
                        <li style="--i: 2">
                            <a href="https://github.com/mawizxc" target="_blank"><i class="fa-brands fa-github"></i></a>
                        </li>
                        <li style="--i: 3">
                            <a href="https://www.facebook.com/Shane.cutieehehe" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="card">

                <div class="imbBx">
                    <img src="../img/montenegro.png" alt="">
                </div>

                <div class="content">
                    <div class="contentBx">
                        <h3>Job Montenegro <br><span>Assistant Programmer </span></h3>
                    </div>
                    <ul class="sci">
                        <li style="--i: 1">
                            <a href="https://www.instagram.com/montenegrojob_/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        </li>
                        <li style="--i: 2">
                            <a href="https://github.com/Job-u" target="_blank"><i class="fa-brands fa-github"></i></a>
                        </li>
                        <li style="--i: 3">
                            <a href="https://www.facebook.com/job.montenegro.33/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="card">

                <div class="imbBx">
                    <img src="../img/tulio.png" alt="">
                </div>

                <div class="content">
                    <div class="contentBx">
                        <h3>Daniel Denzel Tulio <br><span>System Analyst </span></h3>
                    </div>
                    <ul class="sci">
                        <li style="--i: 1">
                            <a href="https://www.instagram.com/abcdanz_" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        </li>
                        <li style="--i: 2">
                            <a href="https://github.com/abcdanz" target="_blank"><i class="fa-brands fa-github"></i></a>
                        </li>
                        <li style="--i: 3">
                            <a href="https://www.facebook.com/DanielDenzelPogi" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="card">

                <div class="imbBx">
                    <img src="../img/florida.png" alt="">
                </div>

                <div class="content">
                    <div class="contentBx">
                        <h3>Richie Florida <br><span>Designer</span></h3>
                    </div>
                    <ul class="sci">
                        <li style="--i: 1">
                            <a href="https://www.instagram.com/rich.ie12190/" target="_blank"><i class="fa-brands fa-instagram" ></i></a>
                        </li>
                        <li style="--i: 2">
                            <a href="https://github.com/chie1219" target="_blank"><i class="fa-brands fa-github"></i></a>
                        </li>
                        <li style="--i: 3">
                            <a href="https://www.facebook.com/chieflorida19" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
    

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/homepage.js"></script>
</body>
</html>