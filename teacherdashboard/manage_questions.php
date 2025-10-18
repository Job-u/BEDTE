<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../profile/login.php");
    exit();
}

include("../phpsql/config.php");

// Handle question submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameMode = mysqli_real_escape_string($con, $_POST['gameMode']);
    $difficulty = mysqli_real_escape_string($con, $_POST['difficulty']);
    $question = mysqli_real_escape_string($con, $_POST['question']);
    $answer = mysqli_real_escape_string($con, $_POST['answer']);
    $options = isset($_POST['options']) ? array_map(function($opt) use ($con) {
        return mysqli_real_escape_string($con, $opt);
    }, $_POST['options']) : [];

    // Add question to database
    $query = "INSERT INTO questions (game_mode, difficulty, question, correct_answer) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssss", $gameMode, $difficulty, $question, $answer);
    
    if ($stmt->execute()) {
        $question_id = $stmt->insert_id;
        
        // If multiple choice, add options
        if ($gameMode === 'Multiple Choice' && !empty($options)) {
            $opt_query = "INSERT INTO question_options (question_id, option_text) VALUES (?, ?)";
            $opt_stmt = $con->prepare($opt_query);
            
            foreach ($options as $option) {
                $opt_stmt->bind_param("is", $question_id, $option);
                $opt_stmt->execute();
            }
        }
        
        $success_message = "Question added successfully!";
    } else {
        $error_message = "Error adding question: " . $stmt->error;
    }
}

// Get existing questions
$questions = [];
$query = "SELECT * FROM questions ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $questions[] = $row;
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
            <!-- Add Question Form -->
            <div class="form-container">
                <h2 id="formTitle">Add New Question</h2>
                <form id="questionForm" class="question-form">
                    <input type="hidden" id="questionId" name="questionId">
                    <input type="hidden" id="operation" name="operation" value="create">
                    
                    <div class="form-group">
                        <label for="gameMode">Game Mode</label>
                        <select name="gameMode" id="gameMode" required>
                            <option value="Multiple Choice">Multiple Choice</option>
                            <option value="Fill In The Blank">Fill in the Blank</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="difficulty">Difficulty Level</label>
                        <select name="difficulty" id="difficulty" required>
                            <option value="EASY">Easy</option>
                            <option value="MEDIUM">Medium</option>
                            <option value="HARD">Hard</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="question">Question Text</label>
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

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="submitBtn">Add Question</button>
                        <button type="button" class="btn-cancel" id="cancelBtn" style="display: none;">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Existing Questions Table -->
            <div class="existing-questions">
                <h2>Question Bank</h2>
                <div class="filters">
                    <select id="filterMode">
                        <option value="">All Game Modes</option>
                        <option value="Multiple Choice">Multiple Choice</option>
                        <option value="Fill In The Blank">Fill in the Blank</option>
                    </select>
                    <select id="filterDifficulty">
                        <option value="">All Difficulties</option>
                        <option value="EASY">Easy</option>
                        <option value="MEDIUM">Medium</option>
                        <option value="HARD">Hard</option>
                    </select>
                </div>

                <div class="scores-table-wrapper">
                <table class="data-table scores-table">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Mode</th>
                            <th>Difficulty</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($questions as $q): ?>
                        <tr data-id="<?php echo $q['id']; ?>">
                            <td><?php echo htmlspecialchars($q['question']); ?></td>
                            <td><?php echo htmlspecialchars($q['game_mode']); ?></td>
                            <td><?php echo htmlspecialchars($q['difficulty']); ?></td>
                            <td>
                                <button class="btn-edit" onclick="editQuestion(<?php echo $q['id']; ?>)">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button class="btn-delete" onclick="deleteQuestion(<?php echo $q['id']; ?>)">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </section>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/homepage.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionForm = document.getElementById('questionForm');
            const formTitle = document.getElementById('formTitle');
            const submitBtn = document.getElementById('submitBtn');
            const cancelBtn = document.getElementById('cancelBtn');

            // Show/hide options based on game mode
            document.getElementById('gameMode').addEventListener('change', function() {
                const optionsContainer = document.getElementById('optionsContainer');
                optionsContainer.style.display = 
                    this.value === 'Multiple Choice' ? 'block' : 'none';
            });

            // Handle form submission
            questionForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const operation = document.getElementById('operation').value;
                
                // Add options array if multiple choice
                if (formData.get('gameMode') === 'Multiple Choice') {
                    const options = Array.from(document.querySelectorAll('[name="options[]"]'))
                                        .map(input => input.value)
                                        .filter(value => value.trim() !== '');
                    formData.set('options', JSON.stringify(options));
                }

                try {
                    const response = await fetch('../phpsql/question_operations.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    
                    if (result.status === 'success') {
                        alert(result.message);
                        window.location.reload();
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (error) {
                    alert('Error: ' + error.message);
                }
            });

            // Edit question
            window.editQuestion = async function(id) {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                const data = {
                    question: row.querySelector('td:nth-child(1)').textContent,
                    gameMode: row.querySelector('td:nth-child(2)').textContent,
                    difficulty: row.querySelector('td:nth-child(3)').textContent
                };

                // Update form
                document.getElementById('questionId').value = id;
                document.getElementById('operation').value = 'update';
                document.getElementById('gameMode').value = data.gameMode;
                document.getElementById('difficulty').value = data.difficulty;
                document.getElementById('question').value = data.question;

                // Update UI
                formTitle.textContent = 'Edit Question';
                submitBtn.textContent = 'Update Question';
                cancelBtn.style.display = 'inline-block';
                
                // Scroll to form
                questionForm.scrollIntoView({ behavior: 'smooth' });
            };

            // Delete question
            window.deleteQuestion = async function(id) {
                if (confirm('Are you sure you want to delete this question?')) {
                    const formData = new FormData();
                    formData.append('operation', 'delete');
                    formData.append('id', id);

                    try {
                        const response = await fetch('../phpsql/question_operations.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();
                        
                        if (result.status === 'success') {
                            alert(result.message);
                            window.location.reload();
                        } else {
                            alert('Error: ' + result.message);
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                }
            };

            // Cancel edit
            cancelBtn.addEventListener('click', function() {
                questionForm.reset();
                document.getElementById('operation').value = 'create';
                document.getElementById('questionId').value = '';
                formTitle.textContent = 'Add New Question';
                submitBtn.textContent = 'Add Question';
                cancelBtn.style.display = 'none';
            });
        });
    </script>
</body>
</html>