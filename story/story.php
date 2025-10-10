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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Selection - BEDTE</title>
    <link rel="stylesheet" href="../style/homepage.css">
    <link rel="stylesheet" href="../style/story.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css">
</head>
<body>
    <section class="background" id="home">
<nav class="navbar">
    <a href="../userdashboard/userdashboard.php" style="text-decoration: none;">
        <div class="logo">
            <img src="../img/LOGO.png" alt="">
            <span>BEDTE</span>
        </div>
    </a>
    <ul class="nav_items" id="nav_links">
            <div class="item">
        <li><a href="../aboutus/aboutus.php">Project Team</a></li>
        <li><a href="../contact/contactus.php">Contact Us</a></li>
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
            
            echo "<a href='../profile/edit.php?Id=$res_id'>$res_Uname</a>";
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

        <section class="story-selection-container">
            <div class="story-header">
                <h2 class="heading">Pick A Story To Listen And Read</h2>
                <p class="para">Select a story below to begin your journey. Each story includes audio narration, beautiful illustrations, and cultural insights.</p>
            </div>

            <div class="stories-grid">
                <div class="story-card" data-story="1">
                    <div class="story-image">
                        <img src="../img/story1_1.png" alt="Asò ni Dada Agò" id="story1-img">
                        <div class="story-overlay">
                            <i class="ri-play-circle-line"></i>
                        </div>
                    </div>
                    <div class="story-content">
                        <h3>Asò ni Dada Agò</h3>
                        <h4>Ang Aso ni Dada Agò</h4>
                        <p>Meet Kuyéng, Dada Agò's dog who loves visiting the market and eating leftover meat. A simple story about a beloved pet.</p>
                        <div class="story-meta">
                            <span class="duration"><i class="ri-time-line"></i> 5 minutes</span>
                            <span class="difficulty"><i class="ri-star-line"></i> Level 1</span>
                        </div>
                    </div>
                </div>

                <div class="story-card" data-story="2">
                    <div class="story-image">
                        <img src="../img/story2_1.png" alt="Ti Lipéng sakay tu Manok" id="story2-img">
                        <div class="story-overlay">
                            <i class="ri-play-circle-line"></i>
                        </div>
                    </div>
                    <div class="story-content">
                        <h3>Ti Lipéng sakay tu Manok</h3>
                        <h4>Si Lipéng at ang Ibon</h4>
                        <p>Lipéng climbs a tree to see a bird's nest, but when she touches the bird, it flies away, leaving her sad.</p>
                        <div class="story-meta">
                            <span class="duration"><i class="ri-time-line"></i> 6 minutes</span>
                            <span class="difficulty"><i class="ri-star-line"></i> Level 1</span>
                        </div>
                    </div>
                </div>

                <div class="story-card" data-story="3">
                    <div class="story-image">
                        <img src="../img/story3_1.png" alt="Tu Anak ti Tagu-Tagu" id="story3-img">
                        <div class="story-overlay">
                            <i class="ri-play-circle-line"></i>
                        </div>
                    </div>
                    <div class="story-content">
                        <h3>Tu Anak ti Tagu-Tagu</h3>
                        <h4>Ang Batang si Tagu-Tagu</h4>
                        <p>Follow Tagu-Tagu's daily life - going to school, fishing for crabs, and helping his family by selling them to buy rice.</p>
                        <div class="story-meta">
                            <span class="duration"><i class="ri-time-line"></i> 7 minutes</span>
                            <span class="difficulty"><i class="ri-star-line"></i> Level 2</span>
                        </div>
                    </div>
                </div>

                <div class="story-card" data-story="4">
                    <div class="story-image">
                        <img src="../img/story4_1.png" alt="To Ogsa" id="story4-img">
                        <div class="story-overlay">
                            <i class="ri-play-circle-line"></i>
                        </div>
                    </div>
                    <div class="story-content">
                        <h3>To Ogsa</h3>
                        <h4>Ang Usa</h4>
                        <p>A story about a deer that Boboy Eda encounters while hunting. The deer runs away when shot with an arrow.</p>
                        <div class="story-meta">
                            <span class="duration"><i class="ri-time-line"></i> 4 minutes</span>
                            <span class="difficulty"><i class="ri-star-line"></i> Level 1</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../js/homepage.js"></script>
    <script src="../js/story.js"></script>
</body>
</html>