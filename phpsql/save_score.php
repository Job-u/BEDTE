<?php
session_start();
header('Content-Type: application/json');
include("config.php");

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

// Get data from the POST request sent by JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['game_mode']) && isset($data['difficulty']) && isset($data['score'])) {
    $userId = $_SESSION['id'];
    $gameMode = $data['game_mode'];
    $difficulty = $data['difficulty'];
    $score = $data['score'];

    // Prepare and execute the SQL statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO scores (user_id, game_mode, difficulty, score) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $userId, $gameMode, $difficulty, $score);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Score saved successfully.']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'Failed to save score: ' . $stmt->error]);
    }

    $stmt->close();
    $con->close();
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid or incomplete data received.']);
}
?>