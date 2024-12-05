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
    <title>Daily Phrase</title>
</head>
<body>

    <section class="background" id="home">
        <nav class="navbar">
            <div class="logo">
                <a href="../userdashboard/userdashboard.php"><img src="../img/back.png" alt=""></a>
                <span>BEDTE</span>
            </div>
            <ul class="nav_items" id="nav_links">
                <div class="item">
                    <li><a href="#">The Developers</a></li>
                    <li><a href="#">Contact Us</a></li>
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
        
        <div class="box" id="phrases">
   <div class="head">
      <h1 class="heading">Word of the Day</h1>
   </div>     

   <!-- This is where the word of the day will be displayed -->
   <p id="daily-phrase" class="phrase-text"></p>
</div>

    </section>

    <footer>
        <div class="sec footer_container"></div>
        <div class="footer_bar">
            copyright @ 2024 BEDTE Developers. All rights reserved
        </div>
    </footer>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/phrase.js"></script>
</body>
</html>
