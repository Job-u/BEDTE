<?php
session_start();
include("config.php");

if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'teacher') {
    http_response_code(403);
    exit(json_encode(['status' => 'error', 'message' => 'Unauthorized']));
}

function updateGameQuestionsFile($con) {
    // Get the existing file content to preserve default questions
    $currentContent = file_get_contents("../js/gamequestion.js");
    
    // Extract the defaultQuestions part
    $defaultQuestionsStart = strpos($currentContent, 'const defaultQuestions');
    $defaultQuestionsEnd = strpos($currentContent, 'let customQuestions');
    $defaultQuestionsCode = substr($currentContent, $defaultQuestionsStart, $defaultQuestionsEnd - $defaultQuestionsStart);

    // Initialize customQuestions with starting numbers based on default questions
    $startingNumbers = [
        'Multiple Choice' => [
            'EASY' => 6,    // Default has 5 questions
            'MEDIUM' => 6,  // Default has 4 questions
            'HARD' => 6     // Default has 5 questions
        ],
        'Fill In The Blank' => [
            'EASY' => 6,    // Default has 5 questions
            'MEDIUM' => 6,  // Default has 5 questions
            'HARD' => 6     // Default has 5 questions
        ]
    ];

    // Initialize customQuestions array
    $customQuestions = [
        'Multiple Choice' => ['EASY' => [], 'MEDIUM' => [], 'HARD' => []],
        'Fill In The Blank' => ['EASY' => [], 'MEDIUM' => [], 'HARD' => []]
    ];

    $query = "SELECT * FROM questions ORDER BY game_mode, difficulty";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $gameMode = $row['game_mode'];
        $difficulty = $row['difficulty'];
        
        // Calculate the correct question number
        $questionNumber = $startingNumbers[$gameMode][$difficulty]++;

        $questionData = [
            'numb' => $questionNumber,
            'question' => $row['question'],
            'answer' => $row['correct_answer']
        ];

        if ($gameMode === 'Multiple Choice') {
            $optionsQuery = "SELECT option_text FROM question_options WHERE question_id = {$row['id']} ORDER BY id";
            $optionsResult = mysqli_query($con, $optionsQuery);
            $options = [];
            while ($option = mysqli_fetch_assoc($optionsResult)) {
                $options[] = $option['option_text'];
            }
            $questionData['options'] = $options;
        }

        $customQuestions[$gameMode][$difficulty][] = $questionData;
    }

    // Create the new file content
    $jsContent = $defaultQuestionsCode . "\n\n";
    $jsContent .= "let customQuestions = " . json_encode($customQuestions, JSON_PRETTY_PRINT) . ";\n\n";
    $jsContent .= "// Combine default and custom questions\n";
    $jsContent .= "const allQuestions = {\n";
    $jsContent .= "    \"Multiple Choice\": {\n";
    $jsContent .= "        \"EASY\": [...defaultQuestions[\"Multiple Choice\"][\"EASY\"], ...customQuestions[\"Multiple Choice\"][\"EASY\"]],\n";
    $jsContent .= "        \"MEDIUM\": [...defaultQuestions[\"Multiple Choice\"][\"MEDIUM\"], ...customQuestions[\"Multiple Choice\"][\"MEDIUM\"]],\n";
    $jsContent .= "        \"HARD\": [...defaultQuestions[\"Multiple Choice\"][\"HARD\"], ...customQuestions[\"Multiple Choice\"][\"HARD\"]]\n";
    $jsContent .= "    },\n";
    $jsContent .= "    \"Fill In The Blank\": {\n";
    $jsContent .= "        \"EASY\": [...defaultQuestions[\"Fill In The Blank\"][\"EASY\"], ...customQuestions[\"Fill In The Blank\"][\"EASY\"]],\n";
    $jsContent .= "        \"MEDIUM\": [...defaultQuestions[\"Fill In The Blank\"][\"MEDIUM\"], ...customQuestions[\"Fill In The Blank\"][\"MEDIUM\"]],\n";
    $jsContent .= "        \"HARD\": [...defaultQuestions[\"Fill In The Blank\"][\"HARD\"], ...customQuestions[\"Fill In The Blank\"][\"HARD\"]]\n";
    $jsContent .= "    }\n";
    $jsContent .= "};\n";

    // Write to file
    file_put_contents("../js/gamequestion.js", $jsContent);
}

// Handle different operations
$operation = $_POST['operation'] ?? '';

switch ($operation) {
    case 'create':
        $gameMode = mysqli_real_escape_string($con, $_POST['gameMode']);
        $difficulty = mysqli_real_escape_string($con, $_POST['difficulty']);
        $question = mysqli_real_escape_string($con, $_POST['question']);
        $answer = mysqli_real_escape_string($con, $_POST['answer']);
        
        $stmt = $con->prepare("INSERT INTO questions (game_mode, difficulty, question, correct_answer) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $gameMode, $difficulty, $question, $answer);
        
        if ($stmt->execute()) {
            $questionId = $stmt->insert_id;
            
            // If multiple choice, add options
            if ($gameMode === 'Multiple Choice' && isset($_POST['options'])) {
                $options = json_decode($_POST['options']);
                $optStmt = $con->prepare("INSERT INTO question_options (question_id, option_text) VALUES (?, ?)");
                
                foreach ($options as $option) {
                    $optStmt->bind_param("is", $questionId, $option);
                    $optStmt->execute();
                }
            }
            
            updateGameQuestionsFile($con);
            echo json_encode(['status' => 'success', 'message' => 'Question added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add question']);
        }
        break;

    case 'update':
        $id = (int)$_POST['id'];
        $gameMode = mysqli_real_escape_string($con, $_POST['gameMode']);
        $difficulty = mysqli_real_escape_string($con, $_POST['difficulty']);
        $question = mysqli_real_escape_string($con, $_POST['question']);
        $answer = mysqli_real_escape_string($con, $_POST['answer']);
        
        $stmt = $con->prepare("UPDATE questions SET game_mode=?, difficulty=?, question=?, correct_answer=? WHERE id=?");
        $stmt->bind_param("ssssi", $gameMode, $difficulty, $question, $answer, $id);
        
        if ($stmt->execute()) {
            // Update options if multiple choice
            if ($gameMode === 'Multiple Choice' && isset($_POST['options'])) {
                // Delete existing options
                mysqli_query($con, "DELETE FROM question_options WHERE question_id = $id");
                
                // Add new options
                $options = json_decode($_POST['options']);
                $optStmt = $con->prepare("INSERT INTO question_options (question_id, option_text) VALUES (?, ?)");
                
                foreach ($options as $option) {
                    $optStmt->bind_param("is", $id, $option);
                    $optStmt->execute();
                }
            }
            
            updateGameQuestionsFile($con);
            echo json_encode(['status' => 'success', 'message' => 'Question updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update question']);
        }
        break;

    case 'delete':
        $id = (int)$_POST['id'];
        
        if (mysqli_query($con, "DELETE FROM questions WHERE id = $id")) {
            updateGameQuestionsFile($con);
            echo json_encode(['status' => 'success', 'message' => 'Question deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete question']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid operation']);
        break;
}
?>