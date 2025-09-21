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
    <title>Story Reader - BEDTE</title>
    <link rel="stylesheet" href="../style/homepage.css">
    <link rel="stylesheet" href="../style/story.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
<section class="background" id="home">
<nav class="navbar">
    <a href="../userdashboard/userdashboard.php">
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
        <section class="story-reading-container">
            <!-- Navigation Bar -->
            <div class="story-nav">
                <a href="../userdashboard/userdashboard.php" class="back-btn">
                    <i class="ri-arrow-left-line"></i>
                    Back to Dashboard
                </a>
                <a href="story.php" class="back-btn">
                    <i class="ri-book-line"></i>
                    All Stories
                </a>
                <div class="story-progress">
                    Story <span id="current-story">1</span> of 4
                </div>
            </div>

            <!-- Story Title and Meta -->
            <div class="story-title">
                <h1 id="story-title">Loading Story...</h1>
                <h2 id="story-subtitle" class="story-subtitle"></h2>
                <div class="story-meta">
                    <span><i class="ri-time-line"></i> <span id="story-duration">5 minutes</span></span>
                    <span><i class="ri-star-line"></i> <span id="story-difficulty">Level 1</span></span>
                </div>
                <!-- Audio Button -->
                <div class="audio-button-container">
                    <button id="play-story-audio" class="audio-play-button">
                        <i class="ri-play-circle-fill"></i>
                        <span>Listen to Story</span>
                    </button>
                </div>
            </div>

            <!-- Storybook Layout -->
            <div class="storybook-container" id="storybook-container">
                <!-- Story pages will be populated by JavaScript -->
            </div>

            <!-- Hidden Audio Element -->
            <audio id="story-audio" preload="metadata">
                <source id="audio-source" src="../audio/story1.mp3" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>


            <!-- Navigation Buttons -->
            <div class="navigation-buttons">
                <button id="prev-story" class="nav-btn">
                    <i class="ri-arrow-left-line"></i>
                    Previous Story
                </button>
                <button id="next-story" class="nav-btn">
                    Next Story
                    <i class="ri-arrow-right-line"></i>
                </button>
            </div>
        </section>
    </section>

    <script src="../js/homepage.js"></script>
    <script src="../js/story.js"></script>
    <script>
        // Initialize story reader
        document.addEventListener('DOMContentLoaded', function() {
            const storyId = getCurrentStoryId();
            loadStory(storyId);
            updateNavigationButtons(storyId);
            
            // Add audio button event listener
            document.getElementById('play-story-audio').addEventListener('click', toggleAudio);
        });

        function loadStory(storyId) {
            const storyData = getStoryData(storyId);
            
            // Update page content
            document.getElementById('story-title').textContent = storyData.title;
            document.getElementById('story-subtitle').textContent = storyData.subtitle || '';
            document.getElementById('current-story').textContent = storyId;
            
            // Create storybook layout
            createStorybookLayout(storyData);
            
            // Update audio source
            const audioElement = document.getElementById('story-audio');
            const audioSource = document.getElementById('audio-source');
            audioSource.src = storyData.audio;
            audioElement.load();
            
            // Update difficulty and duration based on story
            const difficultyMap = {
                1: 'Level 1',
                2: 'Level 1', 
                3: 'Level 2',
                4: 'Level 1'
            };
            
            const durationMap = {
                1: '5 minutes',
                2: '6 minutes',
                3: '7 minutes', 
                4: '4 minutes'
            };
            
            document.getElementById('story-difficulty').textContent = difficultyMap[storyId];
            document.getElementById('story-duration').textContent = durationMap[storyId];
            
            // Update page title
            document.title = `${storyData.title}`;
        }

        function createStorybookLayout(storyData) {
            const container = document.getElementById('storybook-container');
            container.innerHTML = '';
            
            if (storyData.sentences) {
                // Use the structured sentences data - ensure proper order
                storyData.sentences.forEach((sentence, index) => {
                    const page = document.createElement('div');
                    page.className = 'story-page';
                    
                    // Ensure we use the correct image in sequence
                    const imageSrc = storyData.images[index] || sentence.image;
                    
                    page.innerHTML = `
                        <div class="story-image">
                            <img src="${imageSrc}" alt="Story Illustration ${index + 1}" loading="lazy">
                        </div>
                        <div class="story-text-content">
                            <p class="main-text">${sentence.text}</p>
                            ${sentence.translation ? `<p class="translation">${sentence.translation}</p>` : ''}
                        </div>
                    `;
                    
                    container.appendChild(page);
                });
            } else {
                // Fallback to old format for stories without sentence structure
                const lines = storyData.content.split('\n');
                let currentImageIndex = 0;
                
                lines.forEach(line => {
                    if (line.trim() === '') return;
                    
                    const page = document.createElement('div');
                    page.className = 'story-page';
                    
                    const imageSrc = storyData.images[currentImageIndex] || storyData.images[0];
                    
                    if (line.includes('(') && line.includes(')')) {
                        // This is a translation line - don't create a new page
                        const lastPage = container.lastElementChild;
                        if (lastPage) {
                            const textContent = lastPage.querySelector('.story-text-content');
                            if (textContent) {
                                textContent.innerHTML += `<p class="translation">${line}</p>`;
                            }
                        }
                    } else {
                        // This is the main text line - increment image index
                        page.innerHTML = `
                            <div class="story-image">
                                <img src="${imageSrc}" alt="Story Illustration" loading="lazy">
                            </div>
                            <div class="story-text-content">
                                <p class="main-text">${line}</p>
                            </div>
                        `;
                        container.appendChild(page);
                        currentImageIndex++;
                    }
                });
            }
        }

        function formatStoryContent(content) {
            // Split content into lines and format for better readability
            const lines = content.split('\n');
            let formattedContent = '';
            
            lines.forEach(line => {
                if (line.trim() === '') {
                    formattedContent += '<br>';
                } else if (line.includes('(') && line.includes(')')) {
                    // This is a translation line
                    formattedContent += `<p class="translation">${line}</p>`;
                } else {
                    // This is the main text line
                    formattedContent += `<p class="main-text">${line}</p>`;
                }
            });
            
            return formattedContent;
        }

        function updateNavigationButtons(storyId) {
            const prevBtn = document.getElementById('prev-story');
            const nextBtn = document.getElementById('next-story');
            
            // Enable/disable navigation buttons
            prevBtn.disabled = storyId == 1;
            nextBtn.disabled = storyId == 4;
            
            // Update button styles
            if (prevBtn.disabled) {
                prevBtn.style.opacity = '0.5';
                prevBtn.style.cursor = 'not-allowed';
            } else {
                prevBtn.style.opacity = '1';
                prevBtn.style.cursor = 'pointer';
            }
            
            if (nextBtn.disabled) {
                nextBtn.style.opacity = '0.5';
                nextBtn.style.cursor = 'not-allowed';
            } else {
                nextBtn.style.opacity = '1';
                nextBtn.style.cursor = 'pointer';
            }
        }

        // Audio control
        let isPlaying = false;
        
        function toggleAudio() {
            const audioElement = document.getElementById('story-audio');
            const playButton = document.getElementById('play-story-audio');
            
            if (isPlaying) {
                audioElement.pause();
                playButton.innerHTML = '<i class="ri-play-circle-fill"></i><span>Listen to Story</span>';
                isPlaying = false;
            } else {
                audioElement.play();
                playButton.innerHTML = '<i class="ri-pause-circle-fill"></i><span>Pause Story</span>';
                isPlaying = true;
            }
        }

    </script>
</body>
</html>

