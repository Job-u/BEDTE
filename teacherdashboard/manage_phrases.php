<?php
session_start();
include("../phpsql/config.php");

// Only teacher access
if (!isset($_SESSION['valid']) || ($_SESSION['role'] ?? '') !== 'teacher') {
    header("Location: ../profile/login.php");
    exit();
}

$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['phrase_id'] ?? 0;
    $english = trim($_POST['english'] ?? '');
    $casiguran = trim($_POST['casiguran'] ?? '');
    $tagalog = trim($_POST['tagalog'] ?? '');
    $category = $_POST['category'] ?? 'Other';
    $userId = $_SESSION['id'];

    if (empty($english) || empty($casiguran) || empty($tagalog)) {
        $message = 'All text fields are required.';
        $messageType = 'error';
    } else {
        // Handle file upload
        $audioPath = '';
        if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
            $audioDir = '../audio/' . $category . '/';
            if (!file_exists($audioDir)) {
                mkdir($audioDir, 0777, true);
            }
            
            // Sanitize filename
            $audioName = strtolower(str_replace(' ', '_', $english)) . '.wav';
            $targetPath = $audioDir . $audioName;
            
            // Move uploaded file
            if (move_uploaded_file($_FILES['audio']['tmp_name'], $targetPath)) {
                $audioPath = 'audio/' . $category . '/' . $audioName;
            } else {
                $message = 'Error uploading audio file.';
                $messageType = 'error';
            }
        }

        if (empty($message)) {
            if ($id > 0) {
                // Update existing phrase
                $sql = "UPDATE phrases SET english=?, casiguran_agta=?, filipino=?, category=?" . 
                       (!empty($audioPath) ? ", audio_path=?" : "") . " WHERE id=?";
                $stmt = mysqli_prepare($con, $sql);
                
                if (!empty($audioPath)) {
                    mysqli_stmt_bind_param($stmt, 'sssssi', $english, $casiguran, $tagalog, $category, $audioPath, $id);
                } else {
                    mysqli_stmt_bind_param($stmt, 'ssssi', $english, $casiguran, $tagalog, $category, $id);
                }
                
                if (mysqli_stmt_execute($stmt)) {
                    $message = 'Phrase updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating phrase: ' . mysqli_error($con);
                    $messageType = 'error';
                }
            } else {
                // Insert new phrase
                $sql = "INSERT INTO phrases (english, casiguran_agta, filipino, category, audio_path, created_by) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, 'sssssi', $english, $casiguran, $tagalog, $category, $audioPath, $userId);
                
                if (mysqli_stmt_execute($stmt)) {
                    $message = 'Phrase added successfully!';
                    $messageType = 'success';
                    
                    // Clear form
                    $_POST = array();
                } else {
                    $message = 'Error adding phrase: ' . mysqli_error($con);
                    $messageType = 'error';
                }
            }
        }
    }
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = mysqli_prepare($con, "DELETE FROM phrases WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    if (mysqli_stmt_execute($stmt)) {
        $message = 'Phrase deleted successfully!';
        $messageType = 'success';
    } else {
        $message = 'Error deleting phrase: ' . mysqli_error($con);
        $messageType = 'error';
    }
}

// Handle edit action
$editData = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($con, "SELECT * FROM phrases WHERE id = $id");
    $editData = mysqli_fetch_assoc($result);
}

// Get all phrases for the table
$phrases = mysqli_query($con, "SELECT * FROM phrases ORDER BY category, english");
$categories = ['Greetings', 'Common Phrases', 'Daily Use', 'Weather', 'Family', 'Other'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Manage Phrases - BEDTE</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../style/userdashboard.css">
    <link rel="stylesheet" href="../style/teacherdashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet"/>
    <style>
    /* Your existing styles here */
    .container {
        max-width: 1100px;
        margin: 28px auto;
        padding: 0 16px;
    }
    .cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .card {
        background: #fff;
        border-radius: 10px;
        padding: 18px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    .card h3 { margin: 0 0 12px; color: #0E3663; }
    .form-row { display:flex; gap:12px; flex-wrap:wrap; }
    .form-group { flex:1; min-width: 200px; margin-bottom:12px; }
    label { display:block; margin-bottom:6px; font-weight:600; color:#333; }
    input[type="text"], select, input[type="file"] {
        width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:6px;
    }
    .btn { 
        padding:8px 14px; 
        border-radius:8px; 
        border:none; 
        cursor:pointer; 
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .btn-primary { background:#11999E; color:#fff; }
    .btn-secondary { background:#6c757d; color:#fff; }
    .btn-danger { background:#f44336; color:#fff; }
    .btn-sm { padding: 4px 8px; font-size: 0.875rem; }
    table { 
        width:100%; 
        border-collapse:collapse; 
        margin-top: 20px;
    }
    th { 
        background-color: #0E3663;
        color: white;
        text-align: left;
        padding: 12px 8px;
    }
    td { 
        padding:10px 8px; 
        border-bottom:1px solid #eef2f7; 
        vertical-align: middle;
    }
    td.actions { 
        white-space: nowrap;
        text-align: center;
    }
    .small-note { font-size:0.9rem; color:#666; }
    .message { 
        padding:12px; 
        border-radius:6px; 
        margin-bottom:16px;
        display: flex;
        align-items: center;
    }
    .message i { 
        margin-right: 8px;
        font-size: 1.2em;
    }
    .message.success { 
        background:#e6fff6; 
        color:#0E9F6E; 
        border:1px solid #bfeee4; 
    }
    .message.error { 
        background:#fff0f0; 
        color:#c00; 
        border:1px solid #f1c6c6; 
    }
    .audio-preview {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
    }
    .audio-preview audio {
        height: 30px;
    }

    /* Responsive styles */
    @media (max-width: 900px) {
        .cards { grid-template-columns: 1fr; }
        .form-row { flex-direction: column; }
        table { display: block; overflow-x: auto; }
    }
    </style>
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
                $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");
                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_id = $result['Id'];
                }
                echo "<a href='../profile/editteacher.php?Id=$res_id'>$res_Uname</a>";
            ?>
            <div class="nav_btn">
                <a href="../phpsql/logout.php" class="btn btn2">Logout</a>
            </div>
        </ul>
        <div class="nav_menu" id="menu_btn"><i class="ri-menu-line"></i></div>
    </nav>

    <section class="sec">
        <div class="container">
            <!-- Messages -->
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $messageType; ?>">
                    <i class="ri-<?php echo $messageType === 'success' ? 'check-line' : 'close-line'; ?>"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="cards">
                <!-- Left card: Add/Edit form -->
                <div class="card">
                    <h3 id="form-title"><?php echo isset($editData) ? 'Edit Phrase' : 'Add New Phrase'; ?></h3>

                    <form id="phraseForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="phrase_id" value="<?php echo $editData['id'] ?? ''; ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="english">English *</label>
                                <input type="text" id="english" name="english" required 
                                       value="<?php echo htmlspecialchars($editData['english'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="casiguran">Casiguran Agta *</label>
                                <input type="text" id="casiguran" name="casiguran" required
                                       value="<?php echo htmlspecialchars($editData['casiguran_agta'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tagalog">Filipino *</label>
                                <input type="text" id="tagalog" name="tagalog" required
                                       value="<?php echo htmlspecialchars($editData['filipino'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="category">Category *</label>
                                <select id="category" name="category" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat; ?>" 
                                            <?php echo (isset($editData['category']) && $editData['category'] === $cat) ? 'selected' : ''; ?>>
                                            <?php echo $cat; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="audio">Audio (mp3, wav, ogg)</label>
                            <input type="file" id="audio" name="audio" accept="audio/*">
                            <?php if (isset($editData['audio_path']) && !empty($editData['audio_path'])): ?>
                                <div class="audio-preview">
                                    <span>Current: </span>
                                    <audio controls src="../<?php echo htmlspecialchars($editData['audio_path']); ?>"></audio>
                                </div>
                            <?php else: ?>
                                <div class="small-note">Leave empty when updating to keep existing audio.</div>
                            <?php endif; ?>
                        </div>

                        <div style="display:flex; gap:10px; margin-top:16px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line"></i> <?php echo isset($editData) ? 'Update' : 'Add'; ?> Phrase
                            </button>
                            <?php if (isset($editData)): ?>
                                <a href="manage_phrases.php" class="btn btn-secondary">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- Right card: Instructions -->
                <div class="card">
                    <h3>Instructions</h3>
                    <ul style="padding-left: 20px; line-height: 1.6;">
                        <li>Add new phrases that will be available for students to learn.</li>
                        <li>All text fields are required.</li>
                        <li>Audio files should be in MP3, WAV, or OGG format.</li>
                        <li>Audio files will be automatically named based on the English phrase.</li>
                        <li>To edit a phrase, click the edit icon in the table below.</li>
                        <li>To delete a phrase, click the delete icon (use with caution).</li>
                    </ul>
                    
                    <h3 style="margin-top: 20px;">Audio Naming Convention</h3>
                    <p>For consistency, audio files should be named in lowercase with words separated by spaces, similar to the English phrase. For example:</p>
                    <ul style="padding-left: 20px; line-height: 1.6;">
                        <li>English: "How are you?" → Audio: "how are you.wav"</li>
                        <li>English: "Good morning" → Audio: "good morning.wav"</li>
                    </ul>
                </div>
            </div>

            <!-- Phrases Table -->
            <div class="card" style="margin-top: 24px;">
                <h3>Manage Phrases</h3>
                
                <table>
                    <thead>
                        <tr>
                            <th>English</th>
                            <th>Casiguran Agta</th>
                            <th>Filipino</th>
                            <th>Category</th>
                            <th>Audio</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($phrases) > 0): ?>
                            <?php while ($phrase = mysqli_fetch_assoc($phrases)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($phrase['english']); ?></td>
                                    <td><?php echo htmlspecialchars($phrase['casiguran_agta']); ?></td>
                                    <td><?php echo htmlspecialchars($phrase['filipino']); ?></td>
                                    <td><?php echo htmlspecialchars($phrase['category']); ?></td>
                                    <td>
                                        <?php if (!empty($phrase['audio_path'])): ?>
                                            <audio controls style="height: 30px;">
                                                <source src="../<?php echo htmlspecialchars($phrase['audio_path']); ?>" type="audio/wav">
                                                Your browser does not support the audio element.
                                            </audio>
                                        <?php else: ?>
                                            <span class="small-note">No audio</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions">
                                        <a href="?action=edit&id=<?php echo $phrase['id']; ?>" 
                                           class="btn btn-sm" 
                                           style="background: #4CAF50; color: white; margin-right: 4px;"
                                           title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <a href="?action=delete&id=<?php echo $phrase['id']; ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this phrase? This cannot be undone.');"
                                           title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px;">
                                    No phrases found. Add your first phrase using the form above.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        let navbar = document.querySelector('.navbar');
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Navbar toggle
    const menuBtn = document.getElementById('menu_btn');
    const navLinks = document.getElementById('nav_links');
    const menuIcon = document.querySelector('#menu_btn i');

    menuBtn.addEventListener('click', (e) => {
        navLinks.classList.toggle('open');
        const isOpen = navLinks.classList.contains('open');
        menuIcon.setAttribute('class', isOpen ? 'ri-close-line' : 'ri-menu-line');
    });

    // Auto-scroll to form when editing
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($editData)): ?>
            document.getElementById('phraseForm').scrollIntoView({ behavior: 'smooth' });
        <?php endif; ?>
    });
    </script>
</body>
</html>