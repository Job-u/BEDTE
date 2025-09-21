<?php

session_start();
if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../profile/login.php");
    exit();
}

include("../phpsql/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameMode = $_POST['gameMode'];
    $difficulty = $_POST['difficulty'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    
    // For multiple choice questions
    $options = isset($_POST['options']) ? $_POST['options'] : [];
    
    // Update the questions in gamequestion.js
    // Note: This is a simplified version. In production, you'd want to store questions in the database
    $success = true; // Add your question saving logic here
    
    if ($success) {
        $message = "Question added successfully!";
    } else {
        $error = "Error adding question.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions - BEDTE</title>
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
        <h2>Add New Question</h2>

        <form class="question-form" method="POST">
            <div class="form-group">
                <label for="gameMode">Game Mode</label>
                <select name="gameMode" id="gameMode" required>
                    <option value="Multiple Choice">Multiple Choice</option>
                    <option value="Fill In The Blank">Fill in the Blank</option>
                </select>
            </div>

            <div class="form-group">
                <label for="difficulty">Difficulty</label>
                <select name="difficulty" id="difficulty" required>
                    <option value="EASY">Easy</option>
                    <option value="MEDIUM">Medium</option>
                    <option value="HARD">Hard</option>
                </select>
            </div>

            <div class="form-group">
                <label for="question">Question</label>
                <textarea name="question" id="question" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="answer">Correct Answer</label>
                <input type="text" name="answer" id="answer" required>
            </div>

            <div id="optionsContainer" class="form-group">
                <label>Options (for Multiple Choice)</label>
                <div id="optionsList">
                    <input type="text" name="options[]" placeholder="Option 1">
                    <input type="text" name="options[]" placeholder="Option 2">
                    <input type="text" name="options[]" placeholder="Option 3">
                    <input type="text" name="options[]" placeholder="Option 4">
                </div>
            </div>

            <button type="submit" class="btn-submit">Add Question</button>
        </form>
    </section>

    <script>
        // Show/hide options based on game mode
        document.getElementById('gameMode').addEventListener('change', function() {
            const optionsContainer = document.getElementById('optionsContainer');
            optionsContainer.style.display = 
                this.value === 'Multiple Choice' ? 'block' : 'none';
        });
    </script>
</body>
</html>