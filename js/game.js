// filepath: e:\xampp\htdocs\BEDTE_DEMO\js\game.js
// --- DOM Element Selectors ---
const main = document.querySelector('.main');
const homeSection = document.querySelector('.home');
const quizSection = document.querySelector('.quiz-section');
const quizBox = document.querySelector('.quiz-box');
const resultBox = document.querySelector('.result-box');
const popupInfo = document.querySelector('.popup-info');

// Buttons
const multiChoiceBtn = document.querySelector('.multi-btn');
const fillBlankBtn = document.querySelector('.fill-btn');
const easyBtn = document.querySelector('.easy-btn');
const mediumBtn = document.querySelector('.medium-btn');
const hardBtn = document.querySelector('.hard-btn');
const exitBtn = document.querySelector('.exit-btn');
const nextBtn = document.querySelector('.next-btn');
const tryAgainBtn = document.querySelector('.TryAgain-btn');
const goHomeBtn = document.querySelector('.gohome-btn');

// --- Game State Variables ---
let activeGameMode = '';
let activeDifficulty = '';
let currentQuestions = [];
let questionCount = 0;
let questionNumb = 1;
let userScore = 0;

// --- Event Listeners ---

// Mode Selection
multiChoiceBtn.onclick = () => {
    activeGameMode = 'Multiple Choice';
    showDifficultyPopup();
};

fillBlankBtn.onclick = () => {
    activeGameMode = 'Fill In The Blank';
    showDifficultyPopup();
};

// Difficulty Selection
easyBtn.onclick = () => { startGame('EASY'); };
mediumBtn.onclick = () => { startGame('MEDIUM'); };
hardBtn.onclick = () => { startGame('HARD'); };

exitBtn.onclick = () => {
    popupInfo.classList.remove('active');
    main.classList.remove('active');
};

// Quiz Navigation
nextBtn.onclick = () => {
    if (questionCount < currentQuestions.length - 1) {
        questionCount++;
        questionNumb++;
        showQuestion(questionCount);
        nextBtn.classList.remove('active');
    } else {
        showResult();
    }
};

tryAgainBtn.onclick = () => {
    quizBox.classList.add('active');
    resultBox.classList.remove('active');
    resetGame();
    showQuestion(questionCount);
};

goHomeBtn.onclick = () => {
    // Reload the page to reset everything and show fresh scores
    window.location.reload();
};


// --- Core Functions ---

function showDifficultyPopup() {
    popupInfo.classList.add('active');
    main.classList.add('active');
}

function startGame(difficulty) {
    activeDifficulty = difficulty;
    // Ensure questions exist for the selected mode and difficulty
    if (allQuestions[activeGameMode] && allQuestions[activeGameMode][difficulty]) {
        currentQuestions = allQuestions[activeGameMode][difficulty];
    } else {
        console.error(`Questions not found for mode: ${activeGameMode}, difficulty: ${difficulty}`);
        // Optionally, show an error to the user and return to the home screen
        alert("Sorry, something went wrong. Questions for this mode are not available.");
        window.location.reload();
        return;
    }
    
    popupInfo.classList.remove('active');
    homeSection.classList.remove('active'); // Hide the home section
    main.classList.remove('active'); // Unblur the background
    quizSection.classList.add('active');
    quizBox.classList.add('active');

    resetGame();
    showQuestion(questionCount);
}

function resetGame() {
    questionCount = 0;
    questionNumb = 1;
    userScore = 0;
    nextBtn.classList.remove('active');
}

function showQuestion(index) {
    const questionText = document.querySelector('.question-text');
    const optionList = document.querySelector('.option-list');
    const difficultyLabel = document.getElementById('difficulty-label');

    difficultyLabel.textContent = activeDifficulty;
    // Update difficulty label styling to match difficulty
    difficultyLabel.classList.remove('easy', 'medium', 'hard');
    if (activeDifficulty === 'EASY') difficultyLabel.classList.add('easy');
    if (activeDifficulty === 'MEDIUM') difficultyLabel.classList.add('medium');
    if (activeDifficulty === 'HARD') difficultyLabel.classList.add('hard');
    questionText.textContent = `${currentQuestions[index].numb}. ${currentQuestions[index].question}`;
    
    optionList.innerHTML = ''; // Clear previous options/inputs

    // Toggle visibility of Next button depending on game mode
    if (activeGameMode === 'Fill In The Blank') {
        nextBtn.classList.remove('active');
        nextBtn.style.display = 'none';
    } else {
        nextBtn.style.display = 'inline-block';
        nextBtn.classList.remove('active');
    }

    if (activeGameMode === 'Multiple Choice') {
        let options = currentQuestions[index].options;
        options.forEach(optionText => {
            const optionDiv = document.createElement('div');
            optionDiv.classList.add('option');
            optionDiv.innerHTML = `<span>${optionText}</span>`;
            optionDiv.setAttribute('onclick', 'optionSelected(this)');
            optionList.appendChild(optionDiv);
        });
    } else if (activeGameMode === 'Fill In The Blank') {
        optionList.innerHTML = `
            <div class="fill-in-container">
                <input type="text" class="fill-input" placeholder="Type your answer here..." required>
                <button class="fill-submit-btn" disabled>Submit Answer</button>
            </div>`;
        
        const fillInput = optionList.querySelector('.fill-input');
        const fillSubmitBtn = optionList.querySelector('.fill-submit-btn');

        // Enable/disable submit button based on input
        fillInput.addEventListener('input', () => {
            const hasValue = fillInput.value.trim().length > 0;
            fillSubmitBtn.disabled = !hasValue;
            fillInput.classList.remove('error');
        });

        const handleSubmit = () => {
            const answer = fillInput.value.trim();
            if (answer === '') {
                fillInput.classList.add('error');
                fillInput.placeholder = 'Please enter an answer!';
                return;
            }
            checkFillAnswer(answer, currentQuestions[index].answer);
        };

        fillSubmitBtn.onclick = handleSubmit;
        fillInput.onkeypress = (e) => {
            if (e.key === 'Enter' && !fillSubmitBtn.disabled) {
                handleSubmit();
            }
        };
    }
    
    updateQuestionCounter(questionNumb);
    updateHeaderScore();
}

function optionSelected(answer) {
    let userAnswer = answer.textContent;
    let correctAnswer = currentQuestions[questionCount].answer;
    const allOptions = document.querySelectorAll('.option-list .option');
    
    if (userAnswer === correctAnswer) {
        userScore++;
        answer.classList.add('correct');
    } else {
        answer.classList.add('incorrect');
        // Show correct answer
        allOptions.forEach(opt => {
            if (opt.textContent === correctAnswer) {
                opt.classList.add('correct');
            }
        });
    }

    // Disable all options
    allOptions.forEach(opt => opt.classList.add('disabled'));
    
    nextBtn.classList.add('active');
    updateHeaderScore(); // Update score after selection
}

function checkFillAnswer(userAnswer, correctAnswer) {
    if (!userAnswer.trim()) {
        return; // Don't process empty answers
    }

    const trimmedUserAnswer = userAnswer.trim().toLowerCase();
    const trimmedCorrectAnswer = correctAnswer.toLowerCase();

    // Disable input and button immediately
    const fillInput = document.querySelector('.fill-input');
    const fillSubmitBtn = document.querySelector('.fill-submit-btn');
    fillInput.disabled = true;
    fillSubmitBtn.disabled = true;

    // Add visual feedback
    fillInput.style.backgroundColor = trimmedUserAnswer === trimmedCorrectAnswer ? '#d4edda' : '#f8d7da';
    fillInput.style.borderColor = trimmedUserAnswer === trimmedCorrectAnswer ? '#28a745' : '#dc3545';

    if (trimmedUserAnswer === trimmedCorrectAnswer) {
        userScore++;
    }

    // Move to next question after delay
    setTimeout(() => {
        if (questionCount < currentQuestions.length - 1) {
            questionCount++;
            questionNumb++;
            showQuestion(questionCount);
        } else {
            showResult();
        }
        updateHeaderScore();
    }, 1500);
}

function showResult() {
    quizBox.classList.remove('active');
    resultBox.classList.add('active');

    const scoreText = resultBox.querySelector('.score-text');
    const progressValue = resultBox.querySelector('.progress-value');
    const circularProgress = resultBox.querySelector('.circular-progress');
    
    const percentage = currentQuestions.length > 0 ? Math.round((userScore / currentQuestions.length) * 100) : 0;

    scoreText.textContent = `You Scored: ${userScore} out of ${currentQuestions.length}`;
    progressValue.textContent = `${percentage}%`;
    circularProgress.style.background = `conic-gradient(#c40094 ${percentage * 3.6}deg, rgba(255, 255, 255, .1) 0deg)`;

    saveScore(userScore, activeGameMode, activeDifficulty);
}

// --- Helper Functions ---
function updateQuestionCounter(number) {
    const questionTotal = document.querySelector('.question-total');
    questionTotal.textContent = `${number} of ${currentQuestions.length} Questions`;
}

function updateHeaderScore() {
    const headerScoreText = document.querySelector('.header-score');
    headerScoreText.textContent = `Score: ${userScore} / ${currentQuestions.length}`;
}

async function saveScore(finalScore, gameMode, difficulty) {
    // Only save if the user is logged in (which is handled by PHP session)
    try {
        const response = await fetch('../phpsql/save_score.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                game_mode: gameMode,
                difficulty: difficulty,
                score: finalScore
            })
        });
        if (!response.ok) {
            console.error('Failed to save score. Server responded with:', response.status);
        }
    } catch (error) {
        console.error('Error saving score:', error);
    }
}

// Add this function to validate the input
function validateFillInBlankAnswer() {
    const input = document.querySelector('.fill-blank-input');
    if (!input) return true; // Return true if not in fill-in-blank mode
    
    const answer = input.value.trim();
    if (answer === '') {
        input.classList.add('error');
        input.placeholder = 'Answer required!';
        return false;
    }
    input.classList.remove('error');
    return true;
}

// Modify the next button click handler
nextBtn.addEventListener('click', () => {
    if (quizState.currentQuestionIndex >= quizState.questions.length) {
        showResultBox();
        return;
    }

    // Add validation for fill in the blank
    if (quizState.gameMode === 'Fill In The Blank') {
        if (!validateFillInBlankAnswer()) {
            return; // Prevent proceeding if validation fails
        }
    }

    // ...rest of the next button logic...
});

// Add CSS for error state