<?php 
   session_start();

   include("../phpsql/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: login.php");
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/userdashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">
    <title>Home Page</title>
</head>
<body>

    <section class="background" id="home">
<nav class="navbar">
    <div class="logo">
        <img src="../img/LOGO.png" alt="">
        <span>BEDTE</span>
    </div>
    <ul class="nav_items" id="nav_links">
            <div class="item">
        <li><a href="../aboutus/aboutus.php">Project Team</a></li>
        <li><a href="../contact/contact.html">Contact Us</a></li>
            </div>

            <?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

            while($result = mysqli_fetch_assoc($query)){
                $res_Uname = $result['Username'];
                $res_Email = $result['Email'];
                $res_Age = $result['Age'];
                $res_id = $result['Id'];
            }
            
            echo "<a href='../profile/edit.php?Id=$res_id'>$res_Uname</a>";
            ?>

        <div class="nav_btn">
        <a href="../phpsql/logout.php"><button class="btn btn2">Logout</button></a>
        </div>
    </ul>
    <div class="nav_menu" id="menu_btn">
        <i class="ri-menu-line"></i>
    </div>
    </nav>
    </section>

<section class="sec" id="features">
    <div class="left">
        <h1>Hello, <b><?php echo $res_Uname ?></b>!</p></h1>
    </div>
<div class="head">
    <h1 class="heading">What would you like to explore today?</h1>
</div>

<div class="box">
    <a href="../game/gamemode.php" class="box-link">
        <div class="boxes">
        <i class="ri-gamepad-line"></i>
            <h1>Play Game</h1>
            <p class="para">Test your knowledge and have fun learning!</p>
        </div>
    </a>
        
    <a href="../chatbot/chatbot.php" class="box-link">
        <div class="boxes">
        <i class="ri-robot-line"></i>
            <h1>Converse with AI</h1>
            <p class="para">Ask me anything in Casiguran Agta, Tagalog, or English!</p>
        </div>
    </a>
        
    <a href="../phrase/phrase.php" class="box-link">
        <div class="boxes">
        <i class="ri-calendar-check-line"></i>
            <h1>Phrase of the Day</h1>
            <p class="para">Learn a new word or phrase every day!</p>
        </div>
    </a>
</div>
</section>

<footer>

<div class="sec footer_container">
    <div class="footer_col">
        <h4>about</h4>
        <ul class="footer_links">
            <li><a href="#">about us</a></li>
            <li><a href="#">features</a></li>
        </ul>
    </div>
    <div class="footer_col">
        <h4>company</h4>
        <ul class="footer_links">
            <li><a href="#">my BEDTE</a></li>
            <li><a href="#">partners</a></li>
        </ul>
    </div>
    <div class="footer_col">
        <h4>support</h4>
        <ul class="footer_links">
            <li><a href="edit.php">account</a></li>
            <li><a href="#">support center</a></li>
            <li><a href="#">feedback</a></li>
        </ul>
    </div>
    <div class="footer_col">
        <div class="footer_logo logo">
            <img src="../img/LOGO.png" alt="">
            <span>BEDTE</span>
        </div>

        <ul class="footer_socials">
            <li><a href="#"><i class="ri-instagram-fill"></i></a></li>
            <li><a href="#"><i class="ri-facebook-fill"></i></a></li>
            <li><a href="#"><i class="ri-twitter-fill"></i></a></li>
        </ul>
    </div>
</div>
<div class="footer_bar">
    copyright @ 2024 BEDTE Developers. All right reserved
</div>
</footer>
</body>
</html>

<script src="https://unpkg.com/scrollreveal"></script>
<script src="../js/homepage.js"></script>
</body>
