<?php
header('Content-Type: application/json');
include("config.php");

// Determine operation
$operation = $_GET['operation'] ?? $_POST['operation'] ?? null;

if (!$operation) {
    echo json_encode(["status" => "error", "message" => "No operation specified."]);
    exit;
}

switch ($operation) {

    // ✅ FETCH ALL PHRASES
    case 'fetch_all':
        $result = mysqli_query($con, "SELECT * FROM phrases ORDER BY id DESC");
        $phrases = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $phrases[] = $row;
        }
        echo json_encode(["status" => "success", "phrases" => $phrases]);
        break;

    // ✅ ADD PHRASE
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["status" => "error", "message" => "Invalid request method."]);
            exit;
        }

        $casiguran = mysqli_real_escape_string($con, $_POST['casiguran'] ?? '');
        $tagalog = mysqli_real_escape_string($con, $_POST['tagalog'] ?? '');
        $english = mysqli_real_escape_string($con, $_POST['english'] ?? '');
        $category = mysqli_real_escape_string($con, $_POST['category'] ?? '');
        $audioPath = '';

        // Handle audio upload
        if (isset($_FILES['audio']) && $_FILES['audio']['error'] == 0) {
            $targetDir = "../audio/phrases/";
            if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = uniqid() . "_" . basename($_FILES["audio"]["name"]);
            $targetFile = $targetDir . $fileName;

            $allowedTypes = ['mp3', 'wav', 'ogg'];
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (!in_array($fileType, $allowedTypes)) {
                echo json_encode(["status" => "error", "message" => "Invalid audio format."]);
                exit;
            }

            if (move_uploaded_file($_FILES["audio"]["tmp_name"], $targetFile)) {
                $audioPath = $fileName;
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to upload audio file."]);
                exit;
            }
        }

        $stmt = $con->prepare("INSERT INTO phrases (casiguran_text, tagalog_text, english_text, category, audio_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $casiguran, $tagalog, $english, $category, $audioPath);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Phrase added successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add phrase."]);
        }
        break;

    // ✅ UPDATE PHRASE
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["status" => "error", "message" => "Invalid request method."]);
            exit;
        }

        $id = intval($_POST['id'] ?? 0);
        $casiguran = mysqli_real_escape_string($con, $_POST['casiguran'] ?? '');
        $tagalog = mysqli_real_escape_string($con, $_POST['tagalog'] ?? '');
        $english = mysqli_real_escape_string($con, $_POST['english'] ?? '');
        $category = mysqli_real_escape_string($con, $_POST['category'] ?? '');
        $audioPath = '';

        // Check if new audio is uploaded
        if (isset($_FILES['audio']) && $_FILES['audio']['error'] == 0) {
            $targetDir = "../audio/phrases/";
            if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

            // Get old audio path to delete
            $res = mysqli_query($con, "SELECT audio_path FROM phrases WHERE id = $id");
            if ($row = mysqli_fetch_assoc($res)) {
                $oldFile = "../audio/phrases/" . $row['audio_path'];
                if (file_exists($oldFile)) unlink($oldFile);
            }

            $fileName = uniqid() . "_" . basename($_FILES["audio"]["name"]);
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES["audio"]["tmp_name"], $targetFile)) {
                $audioPath = $fileName;
            }
        }

        if ($audioPath) {
            $stmt = $con->prepare("UPDATE phrases SET casiguran_text=?, tagalog_text=?, english_text=?, category=?, audio_path=? WHERE id=?");
            $stmt->bind_param("sssssi", $casiguran, $tagalog, $english, $category, $audioPath, $id);
        } else {
            $stmt = $con->prepare("UPDATE phrases SET casiguran_text=?, tagalog_text=?, english_text=?, category=? WHERE id=?");
            $stmt->bind_param("ssssi", $casiguran, $tagalog, $english, $category, $id);
        }

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Phrase updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update phrase."]);
        }
        break;

    // ✅ DELETE PHRASE
    case 'delete':
        $id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid ID."]);
            exit;
        }

        $res = mysqli_query($con, "SELECT audio_path FROM phrases WHERE id = $id");
        if ($row = mysqli_fetch_assoc($res)) {
            $file = "../audio/phrases/" . $row['audio_path'];
            if (file_exists($file)) unlink($file);
        }

        $stmt = $con->prepare("DELETE FROM phrases WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Phrase deleted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete phrase."]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid operation."]);
        break;
}
?>
