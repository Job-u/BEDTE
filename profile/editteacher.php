<?php 
   session_start();

   include("../phpsql/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: login.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">
    <title>Change Profile</title>
</head>
<body>
<section class="background" id="home">
<nav class="navbar">
<a href="../teacherdashboard/teacherdashboard.php"><div class="logo">
        <img src="../img/LOGO.png" alt="">
        <span>BEDTE</span>
    </div></a>
    <ul class="nav_items" id="nav_links">
            <div class="item">
        <li><a href="../teacherdashboard/manage_scores.php">Student Scores</a></li>
        <li><a href="../teacherdashboard/manage_questions.php">Manage Questions</a></li>
            </div>

            <?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

            while($result = mysqli_fetch_assoc($query)){
                $res_Uname = $result['Username'];
                $res_Email = $result['Email'];
                $res_Age = $result['Age'];
                $res_id = $result['Id'];
            }
            
            echo "<a href='../profile/editteacher.php?Id=$res_id'>$res_Uname</a>";
            ?>

        <div class="nav_btn">
        <a href="../phpsql/logout.php"><button class="btn btn2">Logout</button></a>
        </div>
    </ul>
    <div class="nav_menu" id="menu_btn">
        <i class="ri-menu-line"></i>
    </div>
</nav>
</section>

<section class="sec">
    <div class="container">
        <div class="box form-box">
            <?php 
               if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
                $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

                $id = $_SESSION['id'];

                $update_sql = "UPDATE users SET Username='$username', Email='$email', Age='$age'";

                if ($new_password !== '') {
                    if (strlen($new_password) < 8 || !preg_match('/[A-Z]/', $new_password)) {
                        echo "<div class='message'>
                                <p>Password must be at least 8 characters and contain at least one capital letter.</p>
                              </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                        exit();
                    }
                    if ($new_password !== $confirm_password) {
                        echo "<div class='message'>
                                <p>New password and confirm password do not match.</p>
                              </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                        exit();
                    }
                    $update_sql .= ", Password='$new_password'";
                }

                $update_sql .= " WHERE Id=$id";
                $edit_query = mysqli_query($con,$update_sql) or die("error occurred");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Profile Updated!</p>
                </div> <br>";
              echo "<a href='../userdashboard/userdashboard.php'><button class='btn'>Go Home</button>";
       
                }
               }else{

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                }

            ?>

            
            <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>
                
                <div class="field input">
                    <label for="new_password">New Password (optional)</label>
                    <input type="password" name="new_password" id="new_password" autocomplete="off" placeholder="At least 8 chars, 1 capital letter">
                </div>
                <div class="field input">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" autocomplete="off">
                </div>
                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
                
            </form>
        </div>
        <?php } ?>
    </div>
</section>


    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/homepage.js"></script>
</body>
</html>
