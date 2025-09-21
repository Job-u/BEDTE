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
$result = mysqli_query($con, $query);
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
    <!-- Same navbar as teacherdashboard.php -->
    <nav class="navbar">
        <!-- ... navbar content ... -->
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

        <table class="scores-table">
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
                <?php while($row = mysqli_fetch_assoc($result)): ?>
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
</body>
</html>