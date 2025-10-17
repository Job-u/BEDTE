<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet">
    <title>Register</title>
    <style>
.password-wrapper{
    position: relative;
    display: flex;
    align-items: center;
}

.password-wrapper input{
    width: 100%;
    padding-right: 45px;
    height: 40px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding-left: 10px;
    outline: none;
}

.password-wrapper i{
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #999;
    font-size: 1.3rem;
    transition: color 0.3s ease;
}
.password-wrapper i:hover{
    color: #11999E;
}

.password-wrapper input:focus + i {
  color: #11999E;
}

/* Terms and Conditions Checkbox Styles */
        .terms-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .terms-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            max-height: 70vh;
            overflow-y: auto;
        }

        .terms-content h2 {
            color: #473829;
            margin-bottom: 1rem;
        }

        .terms-content h3 {
            color: #11999E;
            font-size: 1.1rem;
            margin: 1.5rem 0 0.5rem 0;
        }

        .terms-content p, 
        .terms-content ul {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .terms-content ul {
            list-style-type: disc;
            margin-left: 1.5rem;
        }

        .terms-content li {
            margin-bottom: 0.5rem;
        }

        .terms-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .terms-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }

        .accept-btn {
            background: #11999E;
            color: white;
        }

        .decline-btn {
            background: #dc3545;
            color: white;
        }

        /* Terms Checkbox Styles */
.terms-field {
    margin: 1rem 0;
}

.terms-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
}

.terms-checkbox input[type="checkbox"] {
    width: 16px;
    height: 16px;
    margin: 0;
    cursor: pointer;
}

.terms-checkbox label {
    font-size: 0.95rem;
    color: #666;
    margin: 0;
    cursor: pointer;
    white-space: nowrap;
}

.terms-link {
    color: #11999E;
    text-decoration: none;
    font-size: 0.95rem;
    white-space: nowrap;
    cursor: pointer;
}

.terms-link:hover {
    text-decoration: underline;
    color: #0E3663;
}

/* Disabled button style */
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .terms-content::-webkit-scrollbar {
            width: 8px;
        }

        .terms-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .terms-content::-webkit-scrollbar-thumb {
            background: #11999E;
            border-radius: 4px;
        }

        /* Terms and Conditions Layout */
        .register-container {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 2rem;
            min-height: 90vh;
            padding: 2rem;
        }

        .form-box {
            flex: 0 1 450px;
            margin: 0;
        }

        .terms-container {
            flex: 0 1 600px;
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
                        0 32px 64px -48px rgba(0, 0, 0, 0.5);
            max-height: 80vh;
            overflow-y: auto;
            display: block;
            position: sticky;
            top: 2rem;
        }

        .terms-container h2 {
            color: #473829;
            font-size: 25px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #E4F9F5;
            margin-bottom: 20px;
        }

        .terms-content h3 {
            color: #11999E;
            font-size: 1.1rem;
            margin: 1.5rem 0 0.5rem 0;
        }

        .terms-content p, 
        .terms-content ul {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .terms-content ul {
            list-style-type: disc;
            margin-left: 1.5rem;
        }

        .terms-content li {
            margin-bottom: 0.5rem;
        }

        /* Scrollbar styling */
        .terms-container::-webkit-scrollbar {
            width: 8px;
        }

        .terms-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .terms-container::-webkit-scrollbar-thumb {
            background: #11999E;
            border-radius: 4px;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .register-container {
                flex-direction: column;
                align-items: center;
            }

            .terms-container {
                position: relative;
                top: 0;
                max-height: 500px;
                width: 100%;
                max-width: 600px;
            }
        }



    </style>
</head>
<body>
      <div class="container">
        <div class="box form-box">

        <?php 
         
         include("../phpsql/config.php");
         if(isset($_POST['submit'])){
            if(!isset($_POST['terms_accepted'])){
                echo "<div class='message'>
                      <p>You must accept the terms and conditions to register.</p>
                  </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            } else {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
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
         else if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password)) {
            echo "<div class='message'>
                      <p>Password must be at least 8 characters and contain at least one capital letter.</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         else if ($password !== $confirm_password ) {
            echo "<div class='message'>
                         <p>Password and confirm password do not match.</p>
                      </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }

         else {
             // verifying the unique email
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
                    <div class="password-wrapper">
                    <input type="password" name="password" id="password" autocomplete="off" required>
                    <i class="ri-eye-off-line togglePassword" id="togglePassword"></i>
                    </div>
                    <small id="passwordHelp">Must be at least 8 characters and contain one capital letter.</small>
                </div>
                <div class="field input">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="password-wrapper">
                    <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
                    <i class="ri-eye-off-line togglePassword" id="toggleConfirmPassword"></i>
                    </div>
                </div>

                <div class="field terms-field">
    <div class="terms-checkbox">
        <input type="checkbox" name="terms_accepted" id="terms_accepted" disabled>
        <label for="terms_accepted">I agree to the</label>
        <a href="#" onclick="showTerms(event)" class="terms-link">Terms and Conditions</a>
    </div>
</div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" id="registerBtn" disabled>
                </div>
                <div class="links">
                    Already a member? <a href="login.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>

      <!-- Terms and Conditions Modal -->
    <div class="terms-modal" id="termsModal">
        <div class="terms-content">
            <h2>Terms and Conditions</h2>
            <div class="terms-text">
                <h3>1. Introduction</h3>
                <p>Welcome to BEDTE (Bridging Endangered Dialect to Tagalog or English). By creating an account, you agree to these terms and conditions.</p>

                <h3>2. Data Privacy and Protection</h3>
                <p>
                In compliance with the Data Privacy Act of 2012 (Republic Act No. 10173), BEDTE (Bridging Endangered Dialect to Tagalog or English) is committed to protecting your personal data.  
                We ensure that all personal information collected is processed lawfully, fairly, and transparently, and used only for legitimate educational and research purposes related to language preservation.
                </p>

                <p>
                By creating an account, you give your consent to the collection, storage, and processing of your personal data for the purposes outlined in this document. You also have the right to:
                </p>

                <ul>
                    <li>Access your personal information upon request</li>
                    <li>Correct or update inaccurate data</li>
                    <li>Withdraw consent or request deletion of your data, subject to applicable laws</li>
                </ul>

                <p>
                All data will be securely stored and handled with the highest level of confidentiality to ensure your privacy and protection.
                </p>

                <h3>3. Data Collection and Usage</h3>
                <p>We collect and store the following information:</p>
                <ul>
                    <li>Your username and email address</li>
                    <li>Your age</li>
                    <li>Your role (student/teacher)</li>
                    <li>Your learning progress and game scores</li>
                    <li>Usage patterns and interaction with learning materials</li>
                </ul>

                <h3>4. Purpose of Data Collection</h3>
                <p>Your data is collected and used for:</p>
                <ul>
                    <li>Creating and maintaining your user account</li>
                    <li>Tracking your learning progress</li>
                    <li>Improving our educational content and game features</li>
                    <li>Providing personalized learning experiences</li>
                    <li>Academic research purposes in language preservation</li>
                </ul>

                <h3>5. User Privacy</h3>
                <p>We are committed to protecting your privacy:</p>
                <ul>
                    <li>Your personal information will not be shared with third parties</li>
                    <li>Your learning data will be used anonymously for research</li>
                    <li>You can request to view or delete your data at any time</li>
                </ul>

                <h3>6. User Responsibilities</h3>
                <p>As a user, you agree to:</p>
                <ul>
                    <li>Provide accurate and truthful information</li>
                    <li>Maintain the confidentiality of your account</li>
                    <li>Use the platform for educational purposes only</li>
                    <li>Respect intellectual property rights</li>
                </ul>

                <h3>7. Platform Usage</h3>
                <p>The platform includes:</p>
                <ul>
                    <li>Interactive language learning games</li>
                    <li>Translation tools for Casiguran Agta</li>
                    <li>Progress tracking and scoring systems</li>
                    <li>Educational content and materials</li>
                </ul>

                <h3>8. Content Usage</h3>
                <p>All content, including:</p>
                <ul>
                    <li>Language translations</li>
                    <li>Educational materials</li>
                    <li>Audio recordings</li>
                    <li>Images and graphics</li>
                </ul>
                <p>are protected by copyright and may only be used for personal educational purposes.</p>
            </div>
            <div class="terms-buttons">
                <button class="terms-btn decline-btn" onclick="closeTerms()">Decline</button>
                <button class="terms-btn accept-btn" onclick="acceptTerms()">Accept</button>
            </div>



    <script>
        
    const termsCheckbox = document.getElementById('terms_accepted');
    const registerBtn = document.getElementById('registerBtn');
    const termsModal = document.getElementById('termsModal');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const togglePassword = document.getElementById('togglePassword');
    const passwordHelp = document.getElementById('passwordHelp');
    const confirmpasswordHelp = document.getElementById('confirmpasswordHelp');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        this.classList.toggle('ri-eye-off-line');
        this.classList.toggle('ri-eye-line');
    });

    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
        confirmPasswordInput.type = type;
        this.classList.toggle('ri-eye-off-line');
        this.classList.toggle('ri-eye-line');
    });

    // Initially disabled until user accepts terms via modal
    registerBtn.disabled = true;
    registerBtn.style.opacity = '0.5';

    // Live password validation feedback
    passwordInput.addEventListener('input', function() {
        const value = this.value;
        const valid = value.length >= 8 && /[A-Z]/.test(value);
        passwordHelp.textContent = valid ? 'Password meets requirements.' : 'Must be at least 8 characters and contain one capital letter.';
        passwordHelp.style.color = valid ? '#0E9F6E' : '#666';
    });

    function showTerms(event) {
        event.preventDefault();
        termsModal.style.display = 'flex';
        // Hide buttons until scrolled to bottom
        const buttons = document.querySelector('.terms-buttons');
        buttons.style.display = 'none';
        const content = document.querySelector('.terms-content');
        content.scrollTop = 0;
        // If content doesn't overflow, show buttons immediately
        const maybeShowButtons = () => {
            const scrollable = content.scrollHeight > content.clientHeight + 2; // tolerance
            if (!scrollable) {
                buttons.style.display = 'flex';
                content.removeEventListener('scroll', onScroll);
            }
        };
        const onScroll = () => {
            const atBottom = Math.ceil(content.scrollTop + content.clientHeight) >= content.scrollHeight;
            if (atBottom) {
                buttons.style.display = 'flex';
                content.removeEventListener('scroll', onScroll);
            }
        };
        content.addEventListener('scroll', onScroll);
        // Re-check after layout
        setTimeout(maybeShowButtons, 50);
    }

    function closeTerms() {
        termsModal.style.display = 'none';
        termsCheckbox.checked = false;
        termsCheckbox.disabled = true;
        registerBtn.disabled = true;
        registerBtn.style.opacity = '0.5';
    }

    function acceptTerms() {
        termsModal.style.display = 'none';
        termsCheckbox.disabled = false;
        termsCheckbox.checked = true;
        registerBtn.disabled = false;
        registerBtn.style.opacity = '1';
    }

    // Close modal if clicking outside
    window.onclick = function(event) {
        if (event.target == termsModal) {
            closeTerms();
        }
    }
</script>

</body>
</html>
