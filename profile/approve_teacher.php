<?php
session_start();
include("../phpsql/config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

function sendVerificationCode($email, $code) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bedteproject@gmail.com';
        $mail->Password = 'bejkmgcdjulpnkwl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('bedteproject@gmail.com', 'BEDTE System');
        $mail->addAddress($email);

        $verifyLink = "http://" . $_SERVER['HTTP_HOST'] . "/BEDTE_DEMO/profile/verify_code.php?email=" . urlencode($email);

        $mail->isHTML(true);
        $mail->Subject = 'Teacher Registration Approved - Verify Your Email';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; padding: 20px;'>
                <h2>Your Teacher Registration was Approved!</h2>
                <p>Your verification code is: <strong style='font-size: 24px; color: #11999E;'>{$code}</strong></p>
                <p><a href='{$verifyLink}' style='background: #11999E; color: white; padding: 10px 20px; text-decoration: none;'>Verify Email</a></p>
            </div>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Verification email error: " . $mail->ErrorInfo);
        return false;
    }
}

if(isset($_GET['token']) && isset($_GET['action'])) {
    $token = mysqli_real_escape_string($con, $_GET['token']);
    $action = mysqli_real_escape_string($con, $_GET['action']);

    // fetch the pending user row by token
    $stmt = $con->prepare("SELECT Id, Email, Username FROM users WHERE approval_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userId = (int)$user['Id'];
        $userEmail = strtolower(trim($user['Email'])); // normalize

        if($action === 'approve') {
            // validate email before sending
            if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                echo "<div class='message error'>Cannot approve: teacher has invalid email on file.</div>";
                exit;
            }
            // optional DNS check (non-blocking)
            $domain = substr(strrchr($userEmail, "@"), 1);
            if ($domain && !checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
                // still allow but log and inform admin
                error_log("Warning: approved teacher email domain has no MX/A record: $userEmail");
                echo "<div class='message warning'>Warning: teacher email domain appears invalid, email may not be delivered.</div>";
            }

            $verification_code = sprintf('%06d', mt_rand(0, 999999));
            $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            // update by Id and token to ensure single target
            $update = $con->prepare("UPDATE users SET teacher_approved = 1, verification_code = ?, verification_code_expiry = ?, approval_token = NULL WHERE Id = ? AND approval_token = ?");
            // types: s = verification_code, s = expiry, i = Id, s = approval_token
            $update->bind_param("ssis", $verification_code, $expiry, $userId, $token);
            
            // use the user's Id in the WHERE to avoid accidental updates of other rows
            if($update->execute()) {
                // send verification to the teacher's email
                if(sendVerificationCode($userEmail, $verification_code)) {
                    echo "<div class='message success'>Teacher approved. Verification email sent to $userEmail.</div>";
                } else {
                    echo "<div class='message warning'>Teacher approved but failed to send verification email (check logs).</div>";
                }
            } else {
                echo "<div class='message error'>Error approving teacher.</div>";
                error_log("DB update error approve_teacher: " . $con->error);
            }
        } elseif($action === 'reject') {
            $delete = $con->prepare("DELETE FROM users WHERE Id = ? AND approval_token = ?");
            $delete->bind_param("is", $userId, $token);
            if($delete->execute()) {
                echo "<div class='message success'>Teacher registration rejected and removed.</div>";
            } else {
                echo "<div class='message error'>Error rejecting registration.</div>";
            }
        }
    } else {
        echo "<div class='message error'>Invalid or expired approval token.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Approval</title>
    <link rel="stylesheet" href="../style/profile.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Teacher Registration Approval</header>
            <div id="message">
                <?php 
                if(isset($error)) {
                    echo "<div class='message error'>$error</div>";
                } else if(isset($success)) {
                    echo "<div class='message success'>$success</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>