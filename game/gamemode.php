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
        <meta http-equiv="X-UA-Compatible"content="IE=edge">
        <meta name="viewport"content="widt=device-width, initial-scale=1.0">
        <title>Choose Mode  </title>
        <link rel="stylesheet" href="../style/gamestyle.css">
    
    </head>
    <body>
    
        <main class="main">
            <header class="header">
                <a href="../userdashboard/userdashboard.php"><nav class="navbar">
                    <div class="logo">
                        <img src="../img/LOGO.png" alt="">
                        <span>BEDTE</span>
                    </div></a>
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
            </header>
    
            <div class="container">
                <section class=" quiz-section">
                   <div class="quiz-box">
                        <h1 id="title"></h1>
                        <div class="quiz-header">
                            <span id ="diffcuLty-label ">EASY</span>
                            <span class="header-score">Score: 0 / 0 </span>
                        </div>
                        <h2 class="question-text">what is a cat? </h2>
                        <div class="option-list"></div>
                        <div class="quiz-footer">
                        <span class="question-total">1 of 0 Questions</span>
                        <button class="next-btn">Next</button>
                        </div>

                        <div class="popup" id="message">
                            <div class="pup-content"> 
                                <h3 id="pupMessage"> Message</h3>
                                <button class="pupCloseBtn">Close</button>
                    
                         </div>
                      </div>
                    </div>
                    <div class="result-box">
                        <h2>Quiz Result!</h2>
                        <div class="percentage-container">
                            <div class="circular-progress">
                                <span class="progress-value">0%</span>
                            </div>
    
                            <span class="score-text">You Scored: 0 out of 0 </span>
                        </div>
                        <div class="buttons">
                            <button class="TryAgain-btn">Try Again</button>
                            <button class="gohome-btn">Go To Home</button>
                        </div>
                    </div>
          </section>
     <section class="home">
            <div class="home-content">
                <h1>SELECT MODE</h1>
                
                <div class="mode-btn">
                <button class="ho-btn multi-btn">Multiple Choice </button>
                <button class="ho-btn fill-btn "> Fill In The Blank</button>
                
            </div> 
            </div>    
         </section>
        </div>
     </main>
    
        <div class="popup-info">
            <h2>Select Level</h2>
            <div class="sel-btn">
            <button class="info-btn easy-btn ">EASY</button>
            <button class="info-btn medium-btn ">MEDIUM</button>
            <button class="info-btn hard-btn ">HARD</button>
        <div class="btn-exit">
            <button class="info-btn exit-btn">Exit Quiz</button>

        </div>
    </div>
    
    
    <script src="../js/gamequestion.js"></script>
    <script src="../js/game.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/homepage.js"></script>
    </body>
    </html>
    
    