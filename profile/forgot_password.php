<?php
session_start();
include("../phpsql/config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

$status = '';

function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bedteproject@gmail.com';            // REPLACE if needed
        $mail->Password   = 'bejkmgcdjulpnkwl';                  // REPLACE if needed
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('bedteproject@gmail.com', 'BEDTE System');
        $mail->addAddress($email);

        // encode token for safe URL transport
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/BEDTE_DEMO/profile/reset_password.php?token=" . urlencode($token);
        $mail->isHTML(true);
        $mail->Subject = 'BEDTE - Password Reset';
        $mail->Body    = "<p>You requested a password reset. Click the link below to create a new password:</p>
                          <p><a href='$resetLink'>$resetLink</a></p>
                          <p>If you didn't request this, ignore this email.</p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Reset mail error: ' . $mail->ErrorInfo);
        return false;
    }
}

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    // Only allow reset for verified accounts
    $token = bin2hex(random_bytes(32));
    // change expiry to 15 minutes:
    $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    $stmt = $con->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE Email = ? AND email_verified = TRUE");
    $stmt->bind_param("sss", $token, $expiry, $email);
    $stmt->execute();

    if($stmt->affected_rows > 0 && sendResetEmail($email, $token)) {
        $status = "<div class='message success'>If the email exists and is verified, a reset link was sent.</div>";
    } else {
        // Do not reveal whether email exists — keep message generic
        $status = "<div class='message success'>If the email exists and is verified, a reset link was sent.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../style/profile.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Reset Password</header>

            <?php if($status) echo $status; ?>

            <form action="" method="post">
                <div class="field input">
                    <label for="email">Enter your verified email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Send Reset Link">
                </div>
                <div class="links">
                    <a href="login.php">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>