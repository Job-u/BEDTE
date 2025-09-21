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
        <ul class="nav_items">
            <div class="item">
                <li><a href="manage_scores.php">Student Scores</a></li>
                <li><a href="manage_questions.php">Manage Questions</a></li>
            </div>
            <div class="nav_btn">
                <a href="../phpsql/logout.php"><button class="btn btn2">Logout</button></a>
            </div>
        </ul>
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

            <!-- Quick Actions -->
            <div class="action-cards">
                <a href="manage_scores.php" class="action-card">
                    <i class="ri-bar-chart-box-line"></i>
                    <h3>View Student Scores</h3>
                    <p>Check student performance and progress</p>
                </a>

                <a href="manage_questions.php" class="action-card">
                    <i class="ri-question-line"></i>
                    <h3>Manage Questions</h3>
                    <p>Add or modify game questions</p>
                </a>
            </div>
        </div>
    </section>
</body>
</html>