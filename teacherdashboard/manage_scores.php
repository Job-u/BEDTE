<?php

session_start();
if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../profile/login.php");
    exit();
}

include("../phpsql/config.php");

// Get scores with user information
$query = "SELECT u.Username, s.game_mode, s.difficulty, s.score, s.played_on 
          FROM scores s 
          JOIN users u ON s.user_id = u.Id 
          ORDER BY s.played_on DESC";
$scores_result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student Scores - BEDTE</title>
    <link rel="stylesheet" href="../style/userdashboard.css">
    <link rel="stylesheet" href="../style/teacherdashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">
</head>
<body>
    <!-- Navbar -->
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
                <li><a href="manage_phrases.php" class="active">Manage Phrases</a></li>
            </div>

            <?php 
                
                $id = $_SESSION['id'];
                $user_query = mysqli_query($con,"SELECT * FROM users WHERE Id=$id");

                while($user_result = mysqli_fetch_assoc($user_query)){
                    $res_Uname = $user_result['Username'];
                    $res_Email = $user_result['Email'];
                    $res_Age = $user_result['Age'];
                    $res_id = $user_result['Id'];
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
        <h2>Student Scores</h2>
        
        <div class="filters">
            <select id="gameMode">
                <option value="">All Game Modes</option>
                <option value="Multiple Choice">Multiple Choice</option>
                <option value="Fill In The Blank">Fill in the Blank</option>
            </select>
            
            <select id="difficulty">
                <option value="">All Difficulties</option>
                <option value="EASY">Easy</option>
                <option value="MEDIUM">Medium</option>
                <option value="HARD">Hard</option>
            </select>
        </div>

        <div class="scores-table-wrapper">
        <table class="scores-table data-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Game Mode</th>
                    <th>Difficulty</th>
                    <th>Score</th>
                    <th>Date Played</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($scores_result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Username']); ?></td>
                    <td><?php echo htmlspecialchars($row['game_mode']); ?></td>
                    <td><?php echo htmlspecialchars($row['difficulty']); ?></td>
                    <td><?php echo htmlspecialchars($row['score']); ?></td>
                    <td><?php echo date('M d, Y H:i', strtotime($row['played_on'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </section>

    <script>
        // Add filtering functionality
        document.getElementById('gameMode').addEventListener('change', filterTable);
        document.getElementById('difficulty').addEventListener('change', filterTable);

        function filterTable() {
            const gameMode = document.getElementById('gameMode').value.toLowerCase();
            const difficulty = document.getElementById('difficulty').value.toLowerCase();
            const rows = document.querySelectorAll('.scores-table tbody tr');

            rows.forEach(row => {
                const gameModeCell = row.cells[1].textContent.toLowerCase();
                const difficultyCell = row.cells[2].textContent.toLowerCase();
                
                const gameModeMatch = !gameMode || gameModeCell.includes(gameMode);
                const difficultyMatch = !difficulty || difficultyCell.includes(difficulty);

                row.style.display = gameModeMatch && difficultyMatch ? '' : 'none';
            });
        }
    </script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/homepage.js"></script>
</body>
</html>