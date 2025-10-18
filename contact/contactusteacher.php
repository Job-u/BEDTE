<?php 
   session_start();

   include("../phpsql/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: ../profile/login.php");
    exit();
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/contactus.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">
    <title>Contact</title>
</head>
<body>

<section class="background" id="home">
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

            <?php 
                
                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");
    
                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                    $res_id = $result['Id'];
                }
                
                echo "<a href='../profile/editteacher.php?Id=$res_id'>$res_Uname</a>";
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

    <div class="contact-container">
        <form action="https://api.web3forms.com/submit" method="POST" class="contact-left">
            <div class="contact-left-title">
                <h2>Connect With Us</h2>
                <hr>
            </div>
            <input type="hidden" name="access_key" value="97d75076-7ed5-4c0f-a823-fe9a668dd29e">
            <input type="text" name="name" placeholder="Your Name" class="contact-inputs" required>
            <input type="email" name="email" placeholder="Your Email" class="contact-inputs" required>
            <textarea name="message" placeholder="Your Message" class="contact-inputs" required></textarea>
            <button type="submit">Submit</button>
        </form>
        <div class="contact-right">
           <a href="../teacherdashboard/teacherdashboard.php"> <img src="../img/LOGO.png" alt=""></a>
        </div>
    </div>



<script src="https://unpkg.com/scrollreveal"></script>
<script src="../js/homepage.js"></script>
    
</body>
</html>