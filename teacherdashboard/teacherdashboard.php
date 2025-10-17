<?php
session_start();

// Redirect if not logged in or not a teacher
if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../profile/login.php");
    exit();
}

include("../phpsql/config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - BEDTE</title>
    <link rel="stylesheet" href="../style/userdashboard.css">
    <link rel="stylesheet" href="../style/teacherdashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">
</head>
<body>
    <nav class="navbar">
    <a href="teacherdashboard.php">
        <div class="logo">
            <img src="../img/LOGO.png" alt="">
            <span>BEDTE</span>
        </div>
    </a>
    <ul class="nav_items" id="nav_links">
        <div class="item">
            <li><a href="manage_scores.php">Student Scores</a></li>
            <li><a href="manage_questions.php">Manage Questions</a></li>
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

    <section class="sec">
        <div class="dashboard-grid">
            <!-- Quick Stats -->
            <div class="stats-card">
                <h3>Total Students</h3>
                <?php
                $query = mysqli_query($con, "SELECT COUNT(*) as count FROM users WHERE role='student'");
                $result = mysqli_fetch_assoc($query);
                echo "<p class='stat-number'>" . $result['count'] . "</p>";
                ?>
            </div>

            <div class="stats-card">
                <h3>Total Games Played</h3>
                <?php
                $query = mysqli_query($con, "SELECT COUNT(*) as count FROM scores");
                $result = mysqli_fetch_assoc($query);
                echo "<p class='stat-number'>" . $result['count'] . "</p>";
                ?>
            </div>

            <div class="stats-card">
                <h3>Average Score</h3>
                <?php
                $query = mysqli_query($con, "SELECT AVG(score) as avg_score FROM scores");
                $result = mysqli_fetch_assoc($query);
                echo "<p class='stat-number'>" . round($result['avg_score'], 1) . "</p>";
                ?>
            </div>

            <div class="stats-card">
                <h3>Active Today</h3>
                <?php
                $query = mysqli_query($con, "SELECT COUNT(DISTINCT user_id) as count FROM scores WHERE DATE(played_on) = CURDATE()");
                $result = mysqli_fetch_assoc($query);
                echo "<p class='stat-number'>" . $result['count'] . "</p>";
                ?>
            </div>

            <!-- Quick Actions -->
            <div class="action-cards">
                <a href="manage_scores.php" class="action-card">
                    <i class="ri-bar-chart-box-line"></i>
                    <h3>Student Scores</h3>
                    <p>View and analyze student performance data</p>
                </a>

                <a href="manage_questions.php" class="action-card">
                    <i class="ri-question-line"></i>
                    <h3>Question Bank</h3>
                    <p>Add or modify game questions</p>
                </a>


            <!-- Recent Activity -->
            <div class="recent-activity">
                <h3>Recent Activity</h3>
                <div class="activity-list">
                    <?php
                    $query = mysqli_query($con, "
                        SELECT u.Username, s.game_mode, s.difficulty, s.score, s.played_on 
                        FROM scores s 
                        JOIN users u ON s.user_id = u.Id 
                        ORDER BY s.played_on DESC 
                        LIMIT 5
                    ");
                    while($row = mysqli_fetch_assoc($query)) {
                        echo "<div class='activity-item'>";
                        echo "<div class='activity-icon'><i class='ri-gamepad-line'></i></div>";
                        echo "<div class='activity-details'>";
                        echo "<p><strong>" . htmlspecialchars($row['Username']) . "</strong> completed ";
                        echo htmlspecialchars($row['game_mode']) . " (" . htmlspecialchars($row['difficulty']) . ") ";
                        echo "with score " . htmlspecialchars($row['score']) . "</p>";
                        echo "<small>" . date('M d, Y H:i', strtotime($row['played_on'])) . "</small>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <footer>

<div class="sec footer_container">
    <div class="footer_col">
        <h4>about</h4>
        <ul class="footer_links">
            <li><a href="../aboutus/aboutusteacher.php">project team</a></li>
            <li><a href="#">features</a></li>
        </ul>
    </div>
    <div class="footer_col">
        <h4>company</h4>
        <ul class="footer_links">
            <li><a href="https://www.facebook.com/laspinas.sti.edu" target="_blank">partners</a></li>
        </ul>
    </div>
    <div class="footer_col">
        <h4>support</h4>
        <ul class="footer_links">
            <li><a href="../profile/editteacher.php">account</a></li>
            <li><a href="../contact/contactusteacher.php">support center</a></li>
        </ul>
    </div>
    <div class="footer_col">
        <div class="footer_logo logo">
            <img src="../img/LOGO.png" alt="">
            <span>BEDTE</span>
        </div>

        <ul class="footer_socials">
            <li><a href="https://www.instagram.com/bedte_socials" target="_blank"><i class="ri-instagram-fill"></i></a></li>
            <li><a href="https://www.facebook.com/share/1EG68fR2Vf/" target="_blank"><i class="ri-facebook-fill"></i></a></li>
            <li><a href="https://x.com/BEDTE_x" target="_blank"><i class="ri-twitter-fill"></i></a></li>
        </ul>
    </div>
</div>
<div class="footer_bar">
    copyright @ 2024 BEDTE Developers. All right reserved
</div>
</footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/homepage.js"></script>
</body>
</html>