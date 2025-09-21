<?php 
   session_start();

   include("../phpsql/config.php");
   if(!isset($_SESSION['valid']) || !isset($_SESSION['id'])){
    header("Location: ../profile/login.php");
    exit();
   }

   // --- FETCH USER'S BEST SCORES ---
   $userId = (int)$_SESSION['id'];
   $best_scores = [
       'Multiple Choice' => ['EASY' => 0, 'MEDIUM' => 0, 'HARD' => 0],
       'Fill In The Blank' => ['EASY' => 0, 'MEDIUM' => 0, 'HARD' => 0]
   ];

   $query = "SELECT game_mode, difficulty, MAX(score) as best_score FROM scores WHERE user_id = ? GROUP BY game_mode, difficulty";
   if ($stmt = $con->prepare($query)) {
       $stmt->bind_param("i", $userId);
       if ($stmt->execute()) {
           // Use bind_result to avoid dependency on mysqlnd get_result()
           $stmt->bind_result($game_mode, $difficulty, $best_score);
           while ($stmt->fetch()) {
               if (isset($best_scores[$game_mode][$difficulty])) {
                   $best_scores[$game_mode][$difficulty] = (int)$best_score;
               }
           }
       }
       $stmt->close();
   }
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible"content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Choose Mode  </title>
        <link rel="stylesheet" href="../style/gamestyle.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">
    
    </head>
    <body>
    
        <main class="main">
            <header class="header">
                <nav class="navbar">
                    <a href="../userdashboard/userdashboard.php">
                        <div class="logo">
                            <img src="../img/LOGO.png" alt="">
                            <span>BEDTE</span>
                        </div>
                    </a>
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
    
            <!-- Home Section (Visible by default) -->
            <section class="home active">
                <div class="home-content">
                    <h1>SELECT MODE</h1>
                    
                    <div class="game-modes-container">
                        <div class="game-mode-card">
                            <h3>Multiple Choice</h3>
                            <div class="best-scores">
                                <p>Your Best Scores:</p>
                                <span>Easy: <strong><?php echo $best_scores['Multiple Choice']['EASY']; ?></strong></span>
                                <span>Medium: <strong><?php echo $best_scores['Multiple Choice']['MEDIUM']; ?></strong></span>
                                <span>Hard: <strong><?php echo $best_scores['Multiple Choice']['HARD']; ?></strong></span>
                            </div>
                            <button class="ho-btn multi-btn">Play Now</button>
                        </div>
                        <div class="game-mode-card">
                            <h3>Fill In The Blank</h3>
                            <div class="best-scores">
                                <p>Your Best Scores:</p>
                                <span>Easy: <strong><?php echo $best_scores['Fill In The Blank']['EASY']; ?></strong></span>
                                <span>Medium: <strong><?php echo $best_scores['Fill In The Blank']['MEDIUM']; ?></strong></span>
                                <span>Hard: <strong><?php echo $best_scores['Fill In The Blank']['HARD']; ?></strong></span>
                            </div>
                            <button class="ho-btn fill-btn">Play Now</button>
                        </div>
                    </div>
                </div>    
            </section>

            <!-- Quiz Section (Hidden by default) -->
            <section class="quiz-section">
               <div class="quiz-box">
                    <h1>BEDTE Quiz</h1>
                    <div class="quiz-header">
                        <span id="difficulty-label">EASY</span>
                        <span class="header-score">Score: 0 / 5</span>
                    </div>
                    <h2 class="question-text"></h2>
                    <div class="option-list"></div>
                    <div class="quiz-footer">
                        <span class="question-total">1 of 0 Questions</span>
                        <button class="next-btn">Next</button>
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

