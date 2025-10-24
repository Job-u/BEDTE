
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
    <link rel="stylesheet" href="../style/story.css">
    <link rel="stylesheet" href="../style/phrase.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">

    <title>Daily Phrase</title>
</head>
<body>


<nav class="navbar">
        <a href="../userdashboard/userdashboard.php"><div class="logo">
            <img src="../img/LOGO.png" alt="">
            <span>BEDTE</span>
        </div></a>
        <ul class="nav_items" id="nav_links">
                <div class="item">
            <li><a href="../aboutus/aboutus.php">Project Team</a></li>
            <li><a href="../contact/contactus.php">Contact Us</a></li>
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

    <section class="sec" id="features">
        <div class="left">
            <h1>Phrase of the Day</h1>
            <div id="phrase-container" class="boxes phrase-container">
                <div class="top_heading phrase-top-heading">Today’s Phrase</div>
                <div id="daily-phrase" class="heading" style="margin:0;">&nbsp;</div>
                <p id="daily-translation" class="para">&nbsp;</p>
                <div class="phrase-audio-button">
                    <button id="phrase-play" class="audio-play-button" title="Play audio" aria-label="Play Audio">
                        <i class="ri-play-circle-fill"></i>
                        <span class="audio-play-label">Play Audio</span>
                    </button>
                </div>
                <!-- In phrase.php, make sure you have this audio element -->
<audio id="phrase-audio" preload="auto">
    <source src="" type="audio/wav">
    Your browser does not support the audio element.
</audio>
            </div>
        </div>
        
                

   
   

    </section>


    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/phrase.js"></script>
</body>
</html>
