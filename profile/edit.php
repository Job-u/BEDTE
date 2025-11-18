<?php
session_start();
include("../phpsql/config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

if(!isset($_SESSION['valid'])){ header("Location: login.php"); exit(); }

function mask_email($email){
    if (!$email) return '';
    $parts = explode('@', $email);
    $local = $parts[0];
    $domain = $parts[1] ?? '';
    if(strlen($local) <= 2) return str_repeat('*', strlen($local)) . '@' . $domain;
    return substr($local,0,1) . str_repeat('*', max(0,strlen($local)-2)) . substr($local,-1) . '@' . $domain;
}

function sendNewEmailVerification($toEmail, $code){
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bedteproject@gmail.com';
        $mail->Password = 'bejkmgcdjulpnkwl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('bedteproject@gmail.com','BEDTE System');
        $mail->addAddress($toEmail);

        $verifyLink = "http://" . $_SERVER['HTTP_HOST'] . "/BEDTE_DEMO/profile/verify_code.php?email=" . urlencode($toEmail);
        $mail->isHTML(true);
        $mail->Subject = 'Verify your new email for BEDTE';
        $mail->Body = "<p>Your verification code is: <strong>{$code}</strong></p>
                       <p><a href='{$verifyLink}' style='background:#11999E;color:#fff;padding:8px 12px;text-decoration:none;border-radius:5px;'>Verify Email</a></p>
                       <p>This code expires in 10 minutes.</p>";
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('New email verify mail error: ' . $mail->ErrorInfo);
        return false;
    }
}

$id = (int)$_SESSION['id'];
// fetch current data for display
$query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");
$result = mysqli_fetch_assoc($query);
$displayEmail = mask_email($result['Email'] ?? '');

$error = $msg = $email_indicator = '';

if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, trim($_POST['username']));
    $email_input_raw = trim($_POST['email']);
    $email_input = strtolower(mysqli_real_escape_string($con, $email_input_raw));
    $age = isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // Age validation
    if ($age <= 0 || $age > 100) {
        $error = "Please input a valid age.";
    }

    // Password validation
    if (!$error && $new_password !== '') {
        if (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password)) {
            $error = "Password must be at least 8 characters and contain at least one capital letter.";
        } elseif ($new_password !== $confirm_password) {
            $error = "New password and confirm password do not match.";
        }
    }

    // Email change handling
    if (!$error) {
        $current = mysqli_fetch_assoc(mysqli_query($con, "SELECT Email FROM users WHERE Id=$id"));
        $currentEmail = strtolower(trim($current['Email'] ?? ''));

if ($email_input !== '' && $email_input !== $currentEmail) {
    // Validate format using your custom function
    if (!is_real_email($email_input)) {
        $error = "Invalid email format! Please enter a valid and deliverable email.";
        $email_indicator = 'invalid';
    }

    // Uniqueness check (do not allow if Email or new_email already used by another account)
    if (!$error) {
        $uq = $con->prepare("SELECT Id FROM users WHERE (LOWER(Email)=? OR LOWER(new_email)=?) AND Id <> ?");
        $email_norm = strtolower($email_input);
        $uq->bind_param("ssi", $email_norm, $email_norm, $id);
        $uq->execute();
        $uqres = $uq->get_result();
        if ($uqres && $uqres->num_rows > 0) {
            $error = "That email is already in use, please choose another.";
            $email_indicator = 'taken';
        }
    }

    // If all good, create verification for new email
    if (!$error) {
        $code = sprintf('%06d', mt_rand(0,999999));
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $stmt = $con->prepare("UPDATE users SET new_email = ?, new_email_verification_code = ?, new_email_verification_expiry = ? WHERE Id = ?");
        $stmt->bind_param("sssi", $email_input, $code, $expiry, $id);
        if($stmt->execute() && sendNewEmailVerification($email_input, $code)) {
            $msg = "A verification code was sent to your NEW email. Complete verification to apply the change.";
        } else {
            $error = "Failed to send verification to new email.";
        }
    }
}

        // Update username/age and password immediately (email change will apply after verification)
        if (!$error) {
            $update_sql = "UPDATE users SET Username=?, Age=?";
            $params = [$username, $age];
            $types = "si";

            if ($new_password !== '') {
                $update_sql .= ", Password=?";
                $types .= "s";
                $params[] = $new_password;
            }
            $update_sql .= " WHERE Id=?";
            $types .= "i";
            $params[] = $id;

            $stmt2 = $con->prepare($update_sql);
            $stmt2->bind_param($types, ...$params);
            if($stmt2->execute()) {
                if(!$msg) $msg = "Profile updated.";
                // refresh displayed data
                $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");
                $result = mysqli_fetch_assoc($query);
                $displayEmail = mask_email($result['Email'] ?? '');
            } else {
                $error = "Error updating profile: " . $stmt2->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Change Profile</title>
<link rel="stylesheet" href="../style/profile.css">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet">
<style>
.back-link { display:inline-block; margin-bottom:12px; color:#11999E; text-decoration:none; }
.password-wrapper { position:relative; }
.password-wrapper i {
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#666;
    font-size:1.2rem;
}
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; align-items:start; }
.left-col { grid-column: 1 / 2; }
.full-col { grid-column: 1 / -1; }
.field input[disabled] { background:#f5f5f5; }
.email-indicator { font-size:0.9rem; margin-top:6px; }
.email-indicator.taken { color:#d9534f; }
.email-indicator.invalid { color:#f0ad4e; }
.small-help { font-size:0.9rem; margin-top:4px; }
</style>
</head>
<body>
<section class="sec">
<div class="container">
    <div class="box form-box">
        <a class="back-link" href="../userdashboard/userdashboard.php">← Back</a>
        <?php if($error) echo "<div class='message error'>".htmlspecialchars($error)."</div>";
              if($msg) echo "<div class='message success'>".htmlspecialchars($msg)."</div>"; ?>

        <header>Change Profile</header>
        <form action="" method="post" novalidate>
            <div class="field input">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($result['Username'] ?? ''); ?>" required>
            </div>

            <div class="field input">
                <label>Email (current)</label>
                <input type="text" value="<?php echo htmlspecialchars($displayEmail); ?>" disabled>
                <small>To change, enter the NEW email below. New email must be verified to apply.</small>
            </div>

            <div class="field input">
                <label>New Email</label>
                <input type="email" name="email" value="" placeholder="Enter new email (will not replace until verified)">
                <?php if($email_indicator): ?>
                    <div class="email-indicator <?php echo htmlspecialchars($email_indicator); ?>">
                        <?php
                            if($email_indicator === 'taken') echo "That email is already registered.";
                            elseif($email_indicator === 'invalid') echo "Email looks invalid or undeliverable.";
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="field input">
                <label>Age</label>
                <input type="number" name="age" value="<?php echo (int)($result['Age'] ?? ''); ?>" required min="1" max="100">
            </div>

 
                <div class="left-col">
                    <div class="field input">
                        <label>New Password (optional)</label>
                        <div class="password-wrapper">
                            <input type="password" name="new_password" id="new_password">
                            <i id="toggleNewPwd" class="ri-eye-off-line" aria-hidden="true"></i>
                        </div>
                        <small id="passwordHelp" class="small-help">Must be at least 8 characters and contain one capital letter.</small>
                    </div>
                </div>

                <div class="left-col">
                    <div class="field input">
                        <label>Confirm New Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="confirm_password" id="confirm_password">
                            <i id="toggleConfirmPwd" class="ri-eye-off-line" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Update">
            </div>
        </form>

        <script>
        (function wire(tid, iid){
            const t = document.getElementById(tid), i = document.getElementById(iid);
            if(!t||!i) return;
            i.type = 'password';
            t.classList.remove('ri-eye-line'); t.classList.add('ri-eye-off-line');
            t.addEventListener('click', ()=> {
                if(i.type === 'password'){
                    i.type = 'text';
                    t.classList.remove('ri-eye-off-line'); t.classList.add('ri-eye-line');
                } else {
                    i.type = 'password';
                    t.classList.remove('ri-eye-line'); t.classList.add('ri-eye-off-line');
                }
            });
        })('toggleNewPwd','new_password');

        (function(){ // confirm
            const t = document.getElementById('toggleConfirmPwd'), i = document.getElementById('confirm_password');
            if(!t||!i) return;
            i.type = 'password';
            t.classList.remove('ri-eye-line'); t.classList.add('ri-eye-off-line');
            t.addEventListener('click', ()=> {
                if(i.type === 'password'){
                    i.type = 'text';
                    t.classList.remove('ri-eye-off-line'); t.classList.add('ri-eye-line');
                } else {
                    i.type = 'password';
                    t.classList.remove('ri-eye-line'); t.classList.add('ri-eye-off-line');
                }
            });
        })();

        const newPasswordInput = document.getElementById('new_password');
        const passwordHelp = document.getElementById('passwordHelp');

        newPasswordInput.addEventListener('input', function() {
            const value = this.value;
            const valid = value.length >= 8 && /[A-Z]/.test(value);
            passwordHelp.textContent = valid ? 'Password meets requirements.' : 'Must be at least 8 characters and contain one capital letter.';
            passwordHelp.style.color = valid ? '#0E9F6E' : '#666';
        });
        </script>
    </div>
</div>
</section>
</body>
</html>
