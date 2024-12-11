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
    <title>BEDTE Chatbot</title>
   <a href="#"><link rel="stylesheet" href="../style/chatbot.css"></a>
</head>
<body>

    <nav class="navbar">
        <a href="../userdashboard/userdashboard.php"><div class="logo">
            <img src="../img/LOGO.png" alt="">
            <span>BEDTE</span>
        </div>
        <ul class="nav_items" id="nav_links">
                <div class="item">
            <li><a href="../aboutus/aboutus.php">Project Team</a></li>
            <li><a href="../contact/contact.html">Contact Us</a></li>
                </div></a>
    
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
    
    <div class="chat-container">
        <div class="chat-header">
            <h1>BEDTE Chatbot</h1>
        </div>
        <div class="chat-messages" id="chat-messages"></div>
        <div class="chat-input-container">
            <input type="text" id="user-input" placeholder="Type your message...">
  
            <button id="send-button">Send</button>
        </div>
    </div>
    <script src="../js/chatbot.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/homepage.js"></script>
</body>
</html>