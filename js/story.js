// Story Selection and Reading Functionality

document.addEventListener('DOMContentLoaded', function() {
    // Story selection functionality
    const storyCards = document.querySelectorAll('.story-card');
    
    storyCards.forEach(card => {
        card.addEventListener('click', function() {
            const storyId = this.getAttribute('data-story');
            openStory(storyId);
        });
    });

    // Audio functionality for story reading page
    let currentAudio = null;
    let isPlaying = false;
    
    const playBtn = document.getElementById('play-btn');
    const audioProgress = document.getElementById('audio-progress');
    const audioProgressBar = document.getElementById('audio-progress-bar');
    const currentTimeDisplay = document.getElementById('current-time');
    const durationDisplay = document.getElementById('duration');
    const volumeSlider = document.getElementById('volume-slider');
    const audioElement = document.getElementById('story-audio');

    if (playBtn && audioElement) {
        // Play/Pause functionality
        playBtn.addEventListener('click', togglePlayPause);
        
        // Progress bar functionality
        audioProgress.addEventListener('click', function(e) {
            if (audioElement.duration) {
                const rect = this.getBoundingClientRect();
                const pos = (e.clientX - rect.left) / rect.width;
                audioElement.currentTime = pos * audioElement.duration;
            }
        });
        
        // Volume control
        volumeSlider.addEventListener('input', function() {
            audioElement.volume = this.value / 100;
        });
        
        // Audio event listeners
        audioElement.addEventListener('loadedmetadata', function() {
            durationDisplay.textContent = formatTime(audioElement.duration);
            volumeSlider.value = audioElement.volume * 100;
        });
        
        audioElement.addEventListener('timeupdate', function() {
            const progress = (audioElement.currentTime / audioElement.duration) * 100;
            audioProgressBar.style.width = progress + '%';
            currentTimeDisplay.textContent = formatTime(audioElement.currentTime);
        });
        
        audioElement.addEventListener('ended', function() {
            playBtn.innerHTML = '<i class="ri-play-line"></i>';
            isPlaying = false;
        });
    }

    // Navigation buttons
    const backToStoriesBtn = document.getElementById('back-to-stories');
    const nextStoryBtn = document.getElementById('next-story');
    const prevStoryBtn = document.getElementById('prev-story');

    if (backToStoriesBtn) {
        backToStoriesBtn.addEventListener('click', function() {
            window.location.href = 'story.php';
        });
    }

    if (nextStoryBtn) {
        nextStoryBtn.addEventListener('click', function() {
            const currentStory = getCurrentStoryId();
            const nextStory = Math.min(4, parseInt(currentStory) + 1);
            if (nextStory != currentStory) {
                openStory(nextStory);
            }
        });
    }

    if (prevStoryBtn) {
        prevStoryBtn.addEventListener('click', function() {
            const currentStory = getCurrentStoryId();
            const prevStory = Math.max(1, parseInt(currentStory) - 1);
            if (prevStory != currentStory) {
                openStory(prevStory);
            }
        });
    }
});

// Function to open a story
function openStory(storyId) {
    window.location.href = `story_reader.php?story=${storyId}`;
}

// Function to get current story ID from URL
function getCurrentStoryId() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('story') || '1';
}

// Audio control functions
function togglePlayPause() {
    const audioElement = document.getElementById('story-audio');
    const playBtn = document.getElementById('play-btn');
    
    if (isPlaying) {
        audioElement.pause();
        playBtn.innerHTML = '<i class="ri-play-line"></i>';
        isPlaying = false;
    } else {
        audioElement.play();
        playBtn.innerHTML = '<i class="ri-pause-line"></i>';
        isPlaying = true;
    }
}

// Function to format time in MM:SS format
function formatTime(seconds) {
    if (isNaN(seconds)) return '0:00';
    
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60);
    return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
}

// Story data - Agta Casiguran Stories with multiple images
const storiesData = {
    1: {
        title: "Asò ni Dada Agò",
        subtitle: "Ang Aso ni Dada Agò",
        image: "../img/story1_1.png",
        audio: "../audio/story1.mp3",
        images: [
            "../img/story1_2.png",
            "../img/story1_3.png",
            "../img/story1_4.png",
            "../img/story1_5.png",
            "../img/story1_6.png"
        ],
        content: `te alaga a asò ti dada agò.
(may alagang aso si dada agò.)

kuyéng to ngahen naeye
(kuyeng ang pangalan nito.)

medalas ta palengke ti kuyéng
(madalas nasa palengke si kuyeng.)

mengakan du buhay a laman
(kumakain ng mga tirang karne.)

meunas ye kaya tinumabe atahud
(matakaw ito kaya tumaba.)`,
        sentences: [
            {
                text: "te alaga a asò ti dada agò.",
                translation: "(may alagang aso si dada agò.)",
                image: "../img/story1_2.png"
            },

            {
                text: "kuyéng to ngahen naeye",
                translation: "(kuyeng ang pangalan nito.)",
                image: "../img/story1_3.png"
            },
            {
                text: "medalas ta palengke ti kuyéng",
                translation: "(madalas nasa palengke si kuyeng.)",
                image: "../img/story1_4.png"
            },
            {
                text: "mengakan du buhay a laman",
                translation: "(kumakain ng mga tirang karne.)",
                image: "../img/story1_5.png"
            },
            {
                text: "meunas ye kaya tinumabe atahud",
                translation: "(matakaw ito kaya tumaba.)",
                image: "../img/story1_6.png"
            }
        ],
        wordCount: 26,
        level: "Level 1",
        language: "Agta Casiguran",
        gradeLevel: "Level 1",
        ageAppropriate: true
    },
    2: {
        title: "Ti Lipéng sakay tu Manok",
        subtitle: "Si Lipéng at ang Ibon",
        image: "../img/story2_1.png",
        audio: "../audio/story2.mp3",
        images: [

            "../img/story2_2.png",
            "../img/story2_3.png",
            "../img/story2_4.png",
            "../img/story2_5.png",
            "../img/story2_6.png",
            "../img/story2_7.png",
            "../img/story2_8.png"
        ],
        content: `te neta a lobun ti lipéng ta ontok no ponan.
(nakita ni lipéng ang ibon sa taas ng puno.)

sinangkay ye ni lipéng.
(inakyat ito ni lipéng.)

niseleg na ta lobun.
(sinilip niya ang pugad.)

te manok to lobun.
(may ibon sa pugad.)

bigla nayé a denekép.
(hinawakan niya ito.)

inumegbe tu manok.
(lumipad ang ibon.)

melungkot a inumule ti lipéng.
(malungkot na umuwi si lipéng.)`,
        wordCount: 34,
        level: "Level 1",
        language: "Agta Casiguran",
        gradeLevel: "Level 1",
        ageAppropriate: true
    },
    3: {
        title: "Tu Anak ti Tagu-Tagu",
        subtitle: "Ang Batang si Tagu-Tagu",
        image: "../img/story3_1.png",
        audio: "../audio/story3.mp3",
        images: [

            "../img/story3_2.png",
            "../img/story3_3.png",
            "../img/story3_4.png",
            "../img/story3_5.png",
            "../img/story3_6.png",
            "../img/story3_7.png",
            "../img/story3_8.png",
            "../img/story3_9.png",
            "../img/story3_10.png"
        ],
        content: `sakkén ti tagu-tagu.
(ako si tagu-tagu.)

ta bile ék neenak.
(sa bahay ako ipinanganak.)

még iskul ék.
(nag aaral ako.)

umange ék ta kabekawan.
(pumupunta ako sa pakatan.)

még kébel ék ta guho sakay pangkawet.
(dala ko ang dulos at kawet.)

még dekép ék ta agima.
(manghuhuli ako ng alimango.)

ibenta ko du agum.
(ibinebenta ko ang iba.)

ipamugtong ko ye ta biges.
(ipinambibili ko ng bigas.)

penég deponan me du agum a nabuhay a agima.
(pinag saluhan namin ang mga natirang alimango.)`,
        wordCount: 41,
        level: "Level 2",
        language: "Agta Casiguran",
        gradeLevel: "Level 2",
        ageAppropriate: true
    },
    4: {
        title: "To Ogsa",
        subtitle: "Ang Usa",
        image: "../img/story4_1.png",
        audio: "../audio/story4.mp3",
        images: [
            "../img/story4_2.png",
            "../img/story4_3.png",
            "../img/story4_4.png",
            "../img/story4_5.png",
            "../img/story4_6.png",
            "../img/story4_7.png"
        ],
        content: `te essà ogsa.
(may isang usa.)

dekkél ye.
(malaki ito.)

mangekan ye ta lamon.
(kumakain ito ng damo.)

neta ni boboy eda to ogsa.
(nakita ni boboy eda ang usa.)

agad naye a pinana.
(agad niya itong pinana.)

nakaginan ye.
(nakatakbo ito.)`,
        wordCount: 21,
        level: "Level 1",
        language: "Agta Casiguran",
        gradeLevel: "Level 1",
        ageAppropriate: true
    }
};

// Function to get story data
function getStoryData(storyId) {
    return storiesData[storyId] || storiesData[1];
}

