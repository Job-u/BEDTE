<?php
session_start();
include("../phpsql/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="../style/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="box form-box">
        <a class="home-btn" href="../homepage.html">← Home</a>

        <?php
        if(isset($_POST['submit'])) {
            $email = mysqli_real_escape_string($con, trim($_POST['email']));
            $password = $_POST['password']; // Don't escape password before hashing

            $stmt = $con->prepare("SELECT * FROM users WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                if(password_verify($password, $row['Password'])) {
                    if(!$row['email_verified']) {
                        echo "<div class='message error'>Please verify your email before logging in.</div>";
                    } elseif ($row['Role'] === 'teacher' && !$row['teacher_approved']) {
                        echo "<div class='message error'>Teacher account pending admin approval.</div>";
                    } else {
                        $dbRole = $row['Role'] ?? '';
                        $normalizedRole = strtolower(trim($dbRole));

                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['username'] = $row['Username'] ?? '';
                        $_SESSION['age'] = $row['Age'] ?? '';
                        $_SESSION['id'] = $row['Id'] ?? $row['id'] ?? '';
                        $_SESSION['role'] = $normalizedRole;

                        if ($normalizedRole === 'teacher') {
                            header("Location: ../teacherdashboard/teacherdashboard.php");
                        } else {
                            header("Location: ../userdashboard/userdashboard.php");
                        }
                        exit();
                    }
                } else {
                    echo "<div class='message error'>Invalid email or password</div>";
                }
            } else {
                echo "<div class='message error'>Invalid email or password</div>";
            }
        }
        ?>

        <header>Login</header>
        <form action="" method="post" novalidate>
            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <i id="togglePassword" class="ri-eye-off-line" aria-hidden="true"></i>
                </div>
            </div>

            <div class="links forgot">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>

            <div class="field" style="margin-top:12px;">
                <input type="submit" class="btn" name="submit" value="Login">
            </div>

            <div class="links" style="margin-top:8px;">
                Don't have account? <a href="register.php">Sign Up Now</a>
            </div>
        </form>
    </div>
  </div>

<script>
(function(){
  const toggle = document.getElementById('togglePassword');
  const input = document.getElementById('password');
  if(!toggle || !input) return;

  // ensure styling-compatible initial state
  input.type = 'password';
  toggle.classList.remove('ri-eye-line');
  toggle.classList.add('ri-eye-off-line');

  toggle.addEventListener('click', function(){
    if(input.type === 'password'){
      input.type = 'text';
      this.classList.remove('ri-eye-off-line');
      this.classList.add('ri-eye-line');
    } else {
      input.type = 'password';
      this.classList.remove('ri-eye-line');
      this.classList.add('ri-eye-off-line');
    }
  });
})();
</script>
</body>
</html>