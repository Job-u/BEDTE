<?php
session_start();
include("../phpsql/config.php");

$debug = true; // set false in production

// get and decode token
$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$token = $token !== '' ? urldecode($token) : '';

if (!$token) {
    header("Location: login.php");
    exit();
}

$status = '';
$valid_token = false;
$user_email = '';
$user_id = null;

$stmt = $con->prepare("SELECT Id, Email, reset_token_expiry FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_email = $row['Email'];
    $user_id = (int)$row['Id'];
    $expiry = $row['reset_token_expiry'];

    // more robust expiry check using strtotime and explicit false handling
    if (empty($expiry)) {
        $status = "<div class='message error'>Invalid or expired reset link.</div>";
        if ($debug) $status .= "<div class='message warning'>Debug: no expiry value stored.</div>";
    } else {
        $expiry_ts = strtotime($expiry);
        if ($expiry_ts === false) {
            $status = "<div class='message error'>Invalid reset link (bad expiry format).</div>";
            if ($debug) $status .= "<div class='message warning'>Debug: expiry value = " . htmlspecialchars($expiry) . "</div>";
        } elseif ($expiry_ts <= time()) {
            $status = "<div class='message error'>Invalid or expired reset link.</div>";
            if ($debug) $status .= "<div class='message warning'>Debug: token expiry = " . htmlspecialchars($expiry) . " (server time: " . date('Y-m-d H:i:s') . ")</div>";
        } else {
            $valid_token = true;
        }
    }
} else {
    $status = "<div class='message error'>Invalid or expired reset link.</div>";
    if ($debug) $status .= "<div class='message warning'>Debug: token not found. Token passed: " . htmlspecialchars($token) . "</div>";
}

if ($valid_token && isset($_POST['submit'])) {
    $password = $_POST['password']; // Don't escape before hashing
    $confirm = $_POST['confirm_password'];

    // Validate password
    if (strlen($password) < 8) {
        $status = "<div class='message error'>Password must be at least 8 characters long.</div>";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $status = "<div class='message error'>Password must contain at least one capital letter.</div>";
    } elseif ($password !== $confirm) {
        $status = "<div class='message error'>Passwords do not match.</div>";
    } else {
        // Hash password before storing
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Use Id + token to avoid relying on DB NOW() (pre-validated expiry above)
        $update = $con->prepare("UPDATE users SET 
            Password = ?, 
            reset_token = NULL, 
            reset_token_expiry = NULL 
            WHERE Id = ? AND reset_token = ?");
        $update->bind_param("sis", $password_hash, $user_id, $token);
        
        if($update->execute()){
            if($update->affected_rows > 0) {
                $status = "<div class='message success'>Password reset successful. <a href='login.php'>Login</a></div>";
                $valid_token = false;
            } else {
                // No rows updated -> token mismatch or already used
                $status = "<div class='message error'>Reset link is invalid or already used. Please request a new one.</div>";
                if ($debug) $status .= "<div class='message warning'>Debug: no rows affected.</div>";
            }
        } else {
            $status = "<div class='message error'>Failed to reset password. Please try again.</div>";
            if ($debug) $status .= "<div class='message warning'>DB error: " . htmlspecialchars($con->error) . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password</title>
<link rel="stylesheet" href="../style/profile.css">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="box form-box">
      <header>Create New Password</header>

      <?php if ($status) echo $status; ?>

      <?php if ($valid_token): ?>
      <form action="" method="post" novalidate>
        <div class="field input">
          <label for="new_password">New Password</label>
          <div class="password-wrapper">
            <input type="password" name="password" id="new_password" required>
            <i id="toggleNewPassword" class="ri-eye-off-line" aria-hidden="true"></i>
          </div>
          <small id="passwordHelp" class="small-help">Must be at least 8 characters and contain one capital letter.</small>
        </div>

        <div class="field input">
          <label for="confirm_password">Confirm Password</label>
          <div class="password-wrapper">
            <input type="password" name="confirm_password" id="confirm_password" required>
            <i id="toggleConfirmNewPassword" class="ri-eye-off-line" aria-hidden="true"></i>
          </div>
        </div>

        <div class="field">
          <input type="submit" class="btn" name="submit" value="Reset Password">
        </div>
      </form>
      <?php endif; ?>

    </div>
  </div>

<script>
(function wire(idToggle, idInput){
  const t = document.getElementById(idToggle), i = document.getElementById(idInput);
  if(!t || !i) return;
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
})('toggleNewPassword','new_password');

(function wireConfirm(){
  const t = document.getElementById('toggleConfirmNewPassword'), i = document.getElementById('confirm_password');
  if(!t || !i) return;
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
</body>
</html>