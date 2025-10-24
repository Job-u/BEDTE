<?php
session_start();
include("../phpsql/config.php");

// If accessed via link with ?email=... try to load the real DB row and show the DB email
$display_email = '';
if (isset($_GET['email'])) {
    $requested = trim(urldecode($_GET['email']));
    // normalize
    $requested_norm = strtolower($requested);
    $stmt = $con->prepare("SELECT * FROM users WHERE LOWER(Email) = ? OR LOWER(new_email) = ?");
    $stmt->bind_param("ss", $requested_norm, $requested_norm);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        // choose the email the code will be sent to (if new_email pending, show that)
        $display_email = $row['new_email'] ? $row['new_email'] : $row['Email'];
        // do not set admin session here — only store in session if we need flow continuity
        $_SESSION['verify_email'] = $display_email;
    } else {
        // fallback to GET value but normalized
        $_SESSION['verify_email'] = $requested;
        $display_email = $requested;
    }
} elseif (isset($_SESSION['verify_email'])) {
    $display_email = $_SESSION['verify_email'];
} else {
    header("Location: register.php");
    exit();
}

$status_message = '';

if(isset($_POST['verify'])) {
    $code = mysqli_real_escape_string($con, $_POST['code']);
    $email = $display_email;

    $email_norm = strtolower(trim($email));
    $stmt = $con->prepare("SELECT * FROM users WHERE LOWER(Email) = ? OR LOWER(new_email) = ?");
    $stmt->bind_param("ss", $email_norm, $email_norm);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res && $res->num_rows > 0) {
        $user = $res->fetch_assoc();
        $now = time();

        if(!empty($user['verification_code']) && $user['verification_code'] === $code) {
            $expiry = $user['verification_code_expiry'] ?? null;
            if($expiry && strtotime($expiry) > $now) {
                if(!empty($user['temp_registration'])) {
                    $temp = json_decode($user['temp_registration'], true);
                    // Hash the password if it wasn't already
                    $password = isset($temp['password']) ? password_hash($temp['password'], PASSWORD_DEFAULT) : $temp['password'];
                    
                    $up = $con->prepare("UPDATE users SET 
                        Username=?, 
                        Age=?, 
                        Password=?, 
                        Role=?, 
                        email_verified=1, 
                        verification_code=NULL, 
                        verification_code_expiry=NULL, 
                        temp_registration=NULL 
                        WHERE Id=?");
                    
                    $up->bind_param("sissi", 
                        $temp['username'],
                        $temp['age'],
                        $password,
                        $temp['role'],
                        $user['Id']
                    );
                    
                    if($up->execute()) {
                        unset($_SESSION['verify_email']);
                        $status_message = "<div class='message success'>Email verified! You can now <a href='login.php'>login</a>.</div>";
                    } else {
                        $status_message = "<div class='message error'>Error updating account details.</div>";
                        error_log("Verify update error: " . $up->error);
                    }
                } else {
                    // Simple email verification (no temp data)
                    $up = $con->prepare("UPDATE users SET email_verified=1, verification_code=NULL, verification_code_expiry=NULL WHERE Id=?");
                    $up->bind_param("i", $user['Id']);
                    if($up->execute()) {
                        unset($_SESSION['verify_email']);
                        $status_message = "<div class='message success'>Email verified! You can now <a href='login.php'>login</a>.</div>";
                    }
                }
            } else {
                $status_message = "<div class='message error'>Verification code expired.</div>";
            }
        }
        // new email verification
        elseif(!empty($user['new_email_verification_code']) && $user['new_email_verification_code'] === $code) {
            $expiry = $user['new_email_verification_expiry'] ?? null;
            if($expiry && strtotime($expiry) > $now) {
                $up = $con->prepare("UPDATE users SET Email = ?, new_email = NULL, new_email_verification_code = NULL, new_email_verification_expiry = NULL, email_verified = 1 WHERE Id = ?");
                $newEmail = $user['new_email'];
                $up->bind_param("si", $newEmail, $user['Id']);
                $up->execute();
                unset($_SESSION['verify_email']);
                $status_message = "<div class='message success'>New email verified and updated. Please <a href='login.php'>login</a> again.</div>";
            } else {
                $status_message = "<div class='message error'>Verification code expired.</div>";
            }
        } else {
            $status_message = "<div class='message error'>Invalid verification code.</div>";
        }
    } else {
        $status_message = "<div class='message error'>No account found for this email.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"><title>Verify Email</title><link rel="stylesheet" href="../style/profile.css"></head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Verify Your Email</header>
            <?php if($status_message) echo $status_message; ?>
            <form action="" method="post">
                <div class="field input">
                    <label>Enter Verification Code</label>
                    <input type="text" name="code" maxlength="6" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="verify" value="Verify Code">
                </div>
                <p class="text-center">Check your email (<?php echo htmlspecialchars($display_email); ?>) for the verification code</p>
            </form>
        </div>
    </div>
</body>
</html>