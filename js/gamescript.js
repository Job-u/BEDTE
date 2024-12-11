
const multiBtn = document.querySelector('.multi-btn');
const fillBtn = document.querySelector('.fill-btn');
const quizTitle = document.querySelector('#title');
const popupInfo = document.querySelector('.popup-info');
const exitBtn = document.querySelector('.exit-btn');
const main = document.querySelector('.main');
const easyBtn = document.querySelector('.easy-btn');
const quizSection = document.querySelector('.quiz-section');
const quizBox = document.querySelector('.quiz-box');
const resultBox = document.querySelector('.result-box');
const tryAgainBtn = document.querySelector('.TryAgain-btn');
const goHomeBtn = document.querySelector('.gohome-btn');
const mediumBtn = document.querySelector('.medium-btn');
const hardBtn = document.querySelector('.hard-btn');

let currentMode = '';
let currentDifficulty = 'easy';
let questionCount = 0;
let questionNumb = 1;
let userScore = 0;

multiBtn.onclick = () => {
    popupInfo.classList.add('active');
    main.classList.add('active');
    currentMode = 'MULTIPLE';
    quizTitle.textContent ="MULTIPLE CHOICE";
}

fillBtn.onclick = () => {
    popupInfo.classList.add('active');
    main.classList.add('active');
    currentMode = 'FILL';
    quizTitle.textContent ="FILL IN THE BLACK CHOICE";
}
exitBtn.onclick = () => {
    popupInfo.classList.remove('active');
    quizBox.classList.remove('active');
    main.classList.remove('active');
    quizSection.classList.remove('active');
    document.querySelector('.home').classList.add('active');

}
easyBtn.onclick = () => {
    quizSection.classList.add('active');
    popupInfo.classList.remove('active');
    main.classList.remove('active');
    quizBox.classList.add('active');

    if (currentMode === 'MULTIPLE' ) {
        showmultiQuestions(0);
    } else if (currentMode === 'FILL' ) {
        showfillQuestions(0,easyfillquestion);
    }
    questionCounter(1);
    headerScore();
    currentDifficulty = 'easy';
    updateDifficultyText();
   
}
mediumBtn.onclick = () => {
    quizSection.classList.add('active');
    popupInfo.classList.remove('active');
    main.classList.remove('active');
    quizBox.classList.add('active');

    if (currentMode === 'MULTIPLE' ) {
        mediumQuestions(0);
    } else if (currentMode === 'FILL' ) {
        showfillQuestions(0, mediumfillquestion);
    }

    questionCounter(1);
    headerScore();
    currentDifficulty = 'medium';
    updateDifficultyText();
    
}
hardBtn.onclick = () => {
    quizSection.classList.add('active');
    popupInfo.classList.remove('active');
    main.classList.remove('active');
    quizBox.classList.add('active');

    if (currentMode === 'MULTIPLE' ) {
        hardQuestions(0);
    } else if (currentMode === 'FILL' ) {
        showfillQuestions(0,hardfillquestion);
    }

    questionCounter(1);
    headerScore();
    currentDifficulty = 'hard';
    updateDifficultyText();

}
tryAgainBtn.onclick = () => {
    quizBox.classList.add('active');
    nextBtn.classList.remove('active');
    resultBox.classList.remove('active');
    popupInfo.classList.add('active');
    main.classList.add('active');
     questionCount = 0;
     questionNumb = 1;
     userScore = 0;
     showmultiQuestions(questionCount);
     questionCounter(questionNumb);
     headerScore();
     
}
goHomeBtn.onclick = () => {
    quizSection.classList.remove('active');
    nextBtn.classList.remove('active');
    resultBox.classList.remove('active');

     questionCount = 0;
     questionNumb = 1;
     userScore = 0;
     showmultiQuestions(questionCount);
     questionCounter(questionNumb);
     
     headerScore();

}
const nextBtn = document.querySelector('.next-btn');
nextBtn.disabled = true;

nextBtn.onclick = () => {
    if (currentMode === 'MULTIPLE') {
         if (currentDifficulty === 'easy' && questionCount < questions.length - 1) {
            questionCount++;
            showmultiQuestions(questionCount);
         } else if  (currentDifficulty === 'medium' && questionCount < mediumquestions.length - 1) {
               questionCount++;
               mediumQuestions(questionCount);
        } else if  (currentDifficulty === 'hard' && questionCount < hardquestions.length - 1) {
              questionCount++;
              hardQuestions(questionCount);
          } else {
             showResultBox();
    }
        } else if (currentMode === 'FILL'){
            if(currentDifficulty === 'easy' && questionCount <  easyfillquestion.length - 1){
                questionCount++;
                showfillQuestions(questionCount);
            } else if  (currentDifficulty === 'medium' && questionCount <  mediumfillquestion.length - 1){
                questionCount++;
                showfillQuestions(questionCount);
         } else if  (currentDifficulty === 'hard' && questionCount <  hardfillquestion.length - 1){
            questionCount++;
            showfillQuestions(questionCount);

            } else {
                showResultBox();

            }
            }
                  
         questionNumb++;
         questionCounter(questionNumb);

        nextBtn.disabled = true;
        nextBtn.classList.remove('active');
}


const optionList = document.querySelector('.option-list');

function showmultiQuestions(index) {
    const questionText = document.querySelector('.question-text');
    questionText.textContent= `${questions[index].numb}. ${questions[index].easyquestion}`;

let optionTag =`
    <div class="option"><span>${questions[index].option[0]}</span></div>
    <div class="option"><span>${questions[index].option[1]}</span></div>
    <div class="option"><span>${questions[index].option[2]}</span></div>
    <div class="option"><span>${questions[index].option[3]}</span></div> `;
    optionList.innerHTML = optionTag;

    const option = document.querySelectorAll('.option');
    for (let i = 0; i < option.length; i++) {
        option[i].setAttribute('onclick','optionSelected(this)');

    }

}   

function mediumQuestions(index) {
    const questionText = document.querySelector('.question-text');
    questionText.textContent = `${mediumquestions[index].numb}. ${mediumquestions[index].mediumquestion}`;

let optionTag =`
    <div class="option"><span>${mediumquestions[index].medium[0]}</span></div>
    <div class="option"><span>${mediumquestions[index].medium[1]}</span></div>
    <div class="option"><span>${mediumquestions[index].medium[2]}</span></div>
    <div class="option"><span>${mediumquestions[index].medium[3]}</span></div> `;
    optionList.innerHTML = optionTag;

    const option = document.querySelectorAll('.option');
    for (let i = 0; i < option.length; i++) {
        option[i].setAttribute('onclick','optionSelected(this)');
    }
    
}   

function hardQuestions(index)  {
    const questionText = document.querySelector('.question-text');
    questionText.textContent= `${hardquestions[index].numb}. ${hardquestions[index].hardquestion}`;

let optionTag =`
    <div class="option"><span>${hardquestions[index].hard[0]}</span></div>
    <div class="option"><span>${hardquestions[index].hard[1]}</span></div>
    <div class="option"><span>${hardquestions[index].hard[2]}</span></div>
    <div class="option"><span>${hardquestions[index].hard[3]}</span></div> `;
    optionList.innerHTML = optionTag;

    const option = document.querySelectorAll('.option');
    for (let i = 0; i < option.length; i++) {
        option[i].setAttribute('onclick','optionSelected(this)');

    }

}  


function showfillQuestions(index, questionSet) {
    const questionText = document.querySelector('.question-text');

    const currentQuestion = questionSet[index];
    questionText.textContent = `${currentQuestion.numb}. ${currentQuestion.mediumblanksquestions ||currentQuestion.easyquestions ||currentQuestion.hardblanksquestions}`;
    let inputbox = `<input type="text" class="fill-input" placeholder="Your answer here">`;
    optionList.innerHTML = inputbox;

    const input = document.querySelector('.fill-input');

    input.addEventListener('input',  () => {
        nextBtn.disabled = input.value.trim() === "";
        nextBtn.classList.toggle('active', !nextBtn.disabled);

    });

    nextBtn.onclick = () => {
        const userAnswer = input.value.trim();
        const correctAnswer = currentQuestion.answer;


        let message;
        if(userAnswer === correctAnswer){                                                                                                           
           userScore++;
           message ="You are correct!"; 
        }else{
            message =`  Incorrect! The correct answer is: ${correctAnswer}`;
        }


        showPopup(message);

        questionCount++;
        questionNumb++;
        questionCounter(questionNumb);


        if (questionCount <  questionSet.length) {
            showfillQuestions(questionCount, questionSet);
            
        }else{
            showResultBox();
        }
        headerScore();
    };
        nextBtn.disabled = true;
}

function showPopup(message) {
    const popup = document.querySelector('.popup');
    const popupMessage = document.querySelector('#pupMessage');
    const closeBtn = document.querySelector('.pupCloseBtn');

    
    popupMessage.textContent = message;
    popup.style.display = 'flex';

    closeBtn.onclick = () => {
        popup.style.display = 'none';
    };

    
    window.onclick = (event) => {
        if (event.target === popup ) {
            popup.style.display = 'none';
        }
    };
}

function updateDifficultyText() {
    const difficultySpan = document.querySelector('.quiz-header span:first-child');
    

    if (currentDifficulty ==='easy'){
        difficultySpan.textContent = 'EASY';
        difficultySpan.classList.add('easy');
    } else if (currentDifficulty === 'medium') {
        difficultySpan.textContent = 'MEDIUM';
        difficultySpan.classList.add('medium');
    } else if (currentDifficulty === 'hard'){
        difficultySpan.textContent = 'HARD';
        difficultySpan.classList.add('hard');
    }
}

function optionSelected(answer) {
    let userAnswer = answer.textContent;
    let correctAnswer ;
    let allOptions = optionList.children.length;

    if (currentDifficulty === 'easy') {
        correctAnswer = questions[questionCount].answer;
    }else if (currentDifficulty === 'medium')  {
        correctAnswer = mediumquestions[questionCount].answer;
    }else if (currentDifficulty === 'hard')  {
        correctAnswer = hardquestions[questionCount].answer;
    }

    if (userAnswer == correctAnswer){
        answer.classList.add('correct');
        userScore += 1;
        headerScore();
    } else {
        answer.classList.add('incorrect');

        for (let i = 0; i <  allOptions; i++) {
            if (optionList.children[i].textContent == correctAnswer) {
                optionList.children[i].setAttribute('class','option correct');
            }
        }
    }

    for (let i = 0; i <  allOptions; i++) {
        optionList.children[i].classList.add('disabled');
    }
    nextBtn.disabled = false;
    nextBtn.classList.add('active');

}

function questionCounter(index) {  
    const questionTotal = document.querySelector('.question-total');
    if(currentMode === 'FILL'){
        questionTotal.textContent = `${index }  of  ${ easyfillquestion.length} questions `;
     } else if  (currentDifficulty === 'easy') {
        questionTotal.textContent = `${index }  of  ${questions.length} questions `;
    } else if (currentDifficulty === 'medium') {
        questionTotal.textContent =  `${index }  of  ${mediumquestions.length} questions `;
    } else  if (currentDifficulty === 'hard')  {
        questionTotal.textContent =  `${index }  of  ${hardquestions.length} questions `;
    }

}

function headerScore() {
    const headerScoreText = document.querySelector('.header-score');
    let totalQuestions;
    if (currentMode ==='FILL'){
        totalQuestions =  easyfillquestion.length;
    } else if (currentDifficulty ==='easy'){
        totalQuestions = questions.length;
    } else if (currentDifficulty === 'medium') {
        totalQuestions = mediumquestions.length;
    } else if (currentDifficulty === 'hard') {
        totalQuestions = hardquestions.length;
    }

    headerScoreText.textContent = `Score: ${userScore} / ${totalQuestions}`;
}


function showResultBox(){
    quizBox.classList.remove('active');
    resultBox.classList.add('active');

    const scoreText = document.querySelector('.score-text');
    scoreText.textContent = `Your Score ${userScore} out of ${currentDifficulty === 'easy' ? questions.length : currentDifficulty === 'medium'? mediumquestions.length : currentDifficulty === 'hard'? hardquestions.length : 0}`;

    const circularProgress = document.querySelector('.circular-progress');
    const ProgressValue = document.querySelector('.progress-value');
    
    let progressStartValue = 0;
    let progressEndValue = (userScore / (currentDifficulty === 'easy' ? questions.length : currentDifficulty === 'medium'? mediumquestions.length : currentDifficulty === 'hard'? hardquestions.length : 1)) *100;
    let speed = 20;

    let progress = setInterval(() => {
        progressStartValue++;
        
        ProgressValue.textContent = `${Math.min(progressStartValue,progressEndValue)}%`;
        circularProgress.style.background = `conic-gradient( #c40094  ${Math.min(progressStartValue * 3.6)}deg, rgba(233, 214, 214, .1) 0deg)`;
        
        if (progressStartValue >= progressEndValue) {
            clearInterval(progress);
        }

    }, speed);

const multiBtn = document.querySelector('.multi-btn');
const fillBtn = document.querySelector('.fill-btn');
const quizTitle = document.querySelector('#title');
const popupInfo = document.querySelector('.popup-info');
const exitBtn = document.querySelector('.exit-btn');
const main = document.querySelector('.main');
const easyBtn = document.querySelector('.easy-btn');
const quizSection = document.querySelector('.quiz-section');
const quizBox = document.querySelector('.quiz-box');
const resultBox = document.querySelector('.result-box');
const tryAgainBtn = document.querySelector('.TryAgain-btn');
const goHomeBtn = document.querySelector('.gohome-btn');
const mediumBtn = document.querySelector('.medium-btn');
const hardBtn = document.querySelector('.hard-btn');

let currentMode = '';
let currentDifficulty = 'easy';
let questionCount = 0;
let questionNumb = 1;
let userScore = 0;

multiBtn.onclick = () => {
    popupInfo.classList.add('active');
    main.classList.add('active');
    currentMode = 'MULTIPLE';
    quizTitle.textContent ="MULTIPLE CHOICE";
}

fillBtn.onclick = () => {
    popupInfo.classList.add('active');
    main.classList.add('active');
    currentMode = 'FILL';
    quizTitle.textContent ="FILL IN THE BLACK CHOICE";
}
exitBtn.onclick = () => {
    popupInfo.classList.remove('active');
    quizBox.classList.remove('active');
    main.classList.remove('active');
    quizSection.classList.remove('active');
    document.querySelector('.home').classList.add('active');

}
easyBtn.onclick = () => {
    quizSection.classList.add('active');
    popupInfo.classList.remove('active');
    main.classList.remove('active');
    quizBox.classList.add('active');

    if (currentMode === 'MULTIPLE' ) {
        showmultiQuestions(0);
    } else if (currentMode === 'FILL' ) {
        showfillQuestions(0,easyfillquestion);
    }
    questionCounter(1);
    headerScore();
    currentDifficulty = 'easy';
    updateDifficultyText();
   
}
mediumBtn.onclick = () => {
    quizSection.classList.add('active');
    popupInfo.classList.remove('active');
    main.classList.remove('active');
    quizBox.classList.add('active');

    if (currentMode === 'MULTIPLE' ) {
        mediumQuestions(0);
    } else if (currentMode === 'FILL' ) {
        showfillQuestions(0, mediumfillquestion);
    }

    questionCounter(1);
    headerScore();
    currentDifficulty = 'medium';
    updateDifficultyText();
    
}
hardBtn.onclick = () => {
    quizSection.classList.add('active');
    popupInfo.classList.remove('active');
    main.classList.remove('active');
    quizBox.classList.add('active');

    if (currentMode === 'MULTIPLE' ) {
        hardQuestions(0);
    } else if (currentMode === 'FILL' ) {
        showfillQuestions(0,hardfillquestion);
    }

    questionCounter(1);
    headerScore();
    currentDifficulty = 'hard';
    updateDifficultyText();

}
tryAgainBtn.onclick = () => {
    quizBox.classList.add('active');
    nextBtn.classList.remove('active');
    resultBox.classList.remove('active');
    popupInfo.classList.add('active');
    main.classList.add('active');
     questionCount = 0;
     questionNumb = 1;
     userScore = 0;
     showmultiQuestions(questionCount);
     questionCounter(questionNumb);
     headerScore();
     
}
goHomeBtn.onclick = () => {
    quizSection.classList.remove('active');
    nextBtn.classList.remove('active');
    resultBox.classList.remove('active');

     questionCount = 0;
     questionNumb = 1;
     userScore = 0;
     showmultiQuestions(questionCount);
     questionCounter(questionNumb);
     
     headerScore();

}
const nextBtn = document.querySelector('.next-btn');
nextBtn.disabled = true;

nextBtn.onclick = () => {
    if (currentMode === 'MULTIPLE') {
         if (currentDifficulty === 'easy' && questionCount < questions.length - 1) {
            questionCount++;
            showmultiQuestions(questionCount);
         } else if  (currentDifficulty === 'medium' && questionCount < mediumquestions.length - 1) {
               questionCount++;
               mediumQuestions(questionCount);
        } else if  (currentDifficulty === 'hard' && questionCount < hardquestions.length - 1) {
              questionCount++;
              hardQuestions(questionCount);
          } else {
             showResultBox();
    }
        } else if (currentMode === 'FILL'){
            if(currentDifficulty === 'easy' && questionCount <  easyfillquestion.length - 1){
                questionCount++;
                showfillQuestions(questionCount);
            } else if  (currentDifficulty === 'medium' && questionCount <  mediumfillquestion.length - 1){
                questionCount++;
                showfillQuestions(questionCount);
         } else if  (currentDifficulty === 'hard' && questionCount <  hardfillquestion.length - 1){
            questionCount++;
            showfillQuestions(questionCount);

            } else {
                showResultBox();

            }
            }
                  
         questionNumb++;
         questionCounter(questionNumb);

        nextBtn.disabled = true;
        nextBtn.classList.remove('active');
}


const optionList = document.querySelector('.option-list');

function showmultiQuestions(index) {
    const questionText = document.querySelector('.question-text');
    questionText.textContent= `${questions[index].numb}. ${questions[index].easyquestion}`;

let optionTag =`
    <div class="option"><span>${questions[index].option[0]}</span></div>
    <div class="option"><span>${questions[index].option[1]}</span></div>
    <div class="option"><span>${questions[index].option[2]}</span></div>
    <div class="option"><span>${questions[index].option[3]}</span></div> `;
    optionList.innerHTML = optionTag;

    const option = document.querySelectorAll('.option');
    for (let i = 0; i < option.length; i++) {
        option[i].setAttribute('onclick','optionSelected(this)');

    }

}   

function mediumQuestions(index) {
    const questionText = document.querySelector('.question-text');
    questionText.textContent = `${mediumquestions[index].numb}. ${mediumquestions[index].mediumquestion}`;

let optionTag =`
    <div class="option"><span>${mediumquestions[index].medium[0]}</span></div>
    <div class="option"><span>${mediumquestions[index].medium[1]}</span></div>
    <div class="option"><span>${mediumquestions[index].medium[2]}</span></div>
    <div class="option"><span>${mediumquestions[index].medium[3]}</span></div> `;
    optionList.innerHTML = optionTag;

    const option = document.querySelectorAll('.option');
    for (let i = 0; i < option.length; i++) {
        option[i].setAttribute('onclick','optionSelected(this)');
    }
    
}   

function hardQuestions(index)  {
    const questionText = document.querySelector('.question-text');
    questionText.textContent= `${hardquestions[index].numb}. ${hardquestions[index].hardquestion}`;

let optionTag =`
    <div class="option"><span>${hardquestions[index].hard[0]}</span></div>
    <div class="option"><span>${hardquestions[index].hard[1]}</span></div>
    <div class="option"><span>${hardquestions[index].hard[2]}</span></div>
    <div class="option"><span>${hardquestions[index].hard[3]}</span></div> `;
    optionList.innerHTML = optionTag;

    const option = document.querySelectorAll('.option');
    for (let i = 0; i < option.length; i++) {
        option[i].setAttribute('onclick','optionSelected(this)');

    }

}  


function showfillQuestions(index, questionSet) {
    const questionText = document.querySelector('.question-text');

    const currentQuestion = questionSet[index];
    questionText.textContent = `${currentQuestion.numb}. ${currentQuestion.mediumblanksquestions ||currentQuestion.easyquestions ||currentQuestion.hardblanksquestions}`;
    let inputbox = `<input type="text" class="fill-input" placeholder="Your answer here">`;
    optionList.innerHTML = inputbox;

    const input = document.querySelector('.fill-input');

    input.addEventListener('input',  () => {
        nextBtn.disabled = input.value.trim() === "";
        nextBtn.classList.toggle('active', !nextBtn.disabled);

    });

    nextBtn.onclick = () => {
        const userAnswer = input.value.trim();
        const correctAnswer = currentQuestion.answer;


        let message;
        if(userAnswer === correctAnswer){                                                                                                           
           userScore++;
           message ="Correct"; 
        }else{
            message =`  incorrect! The answer is: ${correctAnswer}`;
        }


        showPopup(message);

        questionCount++;
        questionNumb++;
        questionCounter(questionNumb);


        if (questionCount <  questionSet.length) {
            showfillQuestions(questionCount, questionSet);
            
        }else{
            showResultBox();
        }
        headerScore();
    };
        nextBtn.disabled = true;
}

function showPopup(message) {
    const popup = document.querySelector('.popup');
    const popupMessage = document.querySelector('#pupMessage');
    const closeBtn = document.querySelector('.pupCloseBtn');

    
    popupMessage.textContent = message;
    popup.style.display = 'flex';

    closeBtn.onclick = () => {
        popup.style.display = 'none';
    };

    
    window.onclick = (event) => {
        if (event.target === popup ) {
            popup.style.display = 'none';
        }
    };
}

function updateDifficultyText() {
    const difficultySpan = document.querySelector('.quiz-header span:first-child');
    

    if (currentDifficulty ==='easy'){
        difficultySpan.textContent = 'EASY';
        difficultySpan.classList.add('easy');
    } else if (currentDifficulty === 'medium') {
        difficultySpan.textContent = 'MEDIUM';
        difficultySpan.classList.add('medium');
    } else if (currentDifficulty === 'hard'){
        difficultySpan.textContent = 'HARD';
        difficultySpan.classList.add('hard');
    }
}

function optionSelected(answer) {
    let userAnswer = answer.textContent;
    let correctAnswer ;
    let allOptions = optionList.children.length;

    if (currentDifficulty === 'easy') {
        correctAnswer = questions[questionCount].answer;
    }else if (currentDifficulty === 'medium')  {
        correctAnswer = mediumquestions[questionCount].answer;
    }else if (currentDifficulty === 'hard')  {
        correctAnswer = hardquestions[questionCount].answer;
    }

    if (userAnswer == correctAnswer){
        answer.classList.add('correct');
        userScore += 1;
        headerScore();
    } else {
        answer.classList.add('incorrect');

        for (let i = 0; i <  allOptions; i++) {
            if (optionList.children[i].textContent == correctAnswer) {
                optionList.children[i].setAttribute('class','option correct');
            }
        }
    }

    for (let i = 0; i <  allOptions; i++) {
        optionList.children[i].classList.add('disabled');
    }
    nextBtn.disabled = false;
    nextBtn.classList.add('active');

}

function questionCounter(index) {  
    const questionTotal = document.querySelector('.question-total');
    if(currentMode === 'FILL'){
        questionTotal.textContent = `${index }  of  ${ easyfillquestion.length} questions `;
     } else if  (currentDifficulty === 'easy') {
        questionTotal.textContent = `${index }  of  ${questions.length} questions `;
    } else if (currentDifficulty === 'medium') {
        questionTotal.textContent =  `${index }  of  ${mediumquestions.length} questions `;
    } else  if (currentDifficulty === 'hard')  {
        questionTotal.textContent =  `${index }  of  ${hardquestions.length} questions `;
    }

}

function headerScore() {
    const headerScoreText = document.querySelector('.header-score');
    let totalQuestions;
    if (currentMode ==='FILL'){
        totalQuestions =  easyfillquestion.length;
    } else if (currentDifficulty ==='easy'){
        totalQuestions = questions.length;
    } else if (currentDifficulty === 'medium') {
        totalQuestions = mediumquestions.length;
    } else if (currentDifficulty === 'hard') {
        totalQuestions = hardquestions.length;
    }

    headerScoreText.textContent = `Score: ${userScore} / ${totalQuestions}`;
}


function showResultBox(){
    quizBox.classList.remove('active');
    resultBox.classList.add('active');

    const scoreText = document.querySelector('.score-text');
    scoreText.textContent = `Your Score ${userScore} out of ${currentDifficulty === 'easy' ? questions.length : currentDifficulty === 'medium'? mediumquestions.length : currentDifficulty === 'hard'? hardquestions.length : 0}`;

    const circularProgress = document.querySelector('.circular-progress');
    const ProgressValue = document.querySelector('.progress-value');
    
    let progressStartValue = 0;
    let progressEndValue = (userScore / (currentDifficulty === 'easy' ? questions.length : currentDifficulty === 'medium'? mediumquestions.length : currentDifficulty === 'hard'? hardquestions.length : 1)) *100;
    let speed = 20;

    let progress = setInterval(() => {
        progressStartValue++;
        
        ProgressValue.textContent = `${Math.min(progressStartValue,progressEndValue)}%`;
        circularProgress.style.background = `conic-gradient( #c40094  ${Math.min(progressStartValue * 3.6)}deg, rgba(233, 214, 214, .1) 0deg)`;
        
        if (progressStartValue >= progressEndValue) {
            clearInterval(progress);
        }

    }, speed);
}
}

