<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/profile.css">
    <title>Register</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">

        <?php 
         
         include("../phpsql/config.php");
         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $password = $_POST['password'];
            $role = $_POST['role'];

         //--- VALIDATION ADDED ---

         // 1. Validate Email Format
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='message'>
                      <p>Please enter a valid email address!</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         // 2. Validate Password Strength
         else if (strlen($password) > 8 || !preg_match('/[A-Z]/', $password)) {
            echo "<div class='message'>
                      <p>Password must be 8 characters or less and contain at least one capital letter.</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         else {
             //verifying the unique email
             $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

             if(mysqli_num_rows($verify_query) !=0 ){
                echo "<div class='message'>
                          <p>This email is used, Try another One Please!</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
             }
             else{
    
                mysqli_query($con,"INSERT INTO users(Username,Email,Age,Password,Role) VALUES('$username','$email','$age','$password','$role')") or die("Error Occured");
    
                echo "<div class='message'>
                          <p>Registration successfully!</p>
                      </div> <br>";
                echo "<a href='login.php'><button class='btn'>Login Now</button>";
             
    
             }
         }

         }else{
         
        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="role">Register as:</label>
                    <select name="role" id="role" required>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <small>Must be at least 8 characters long and contain one capital letter.</small>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="login.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>
