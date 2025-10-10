
document.addEventListener('DOMContentLoaded', function() {
    // Build dataset from existing audio files (relative to phrase/phrase.php)
    const base = '..';
    const items = [
        // Greetings (audio/Greetings)
        { key: 'What is your name?', path: `${base}/audio/Greetings/what is your name.wav` },
        { key: 'Good afternoon', path: `${base}/audio/Greetings/good afternoon.wav` },
        { key: 'Good evening', path: `${base}/audio/Greetings/good evening.wav` },
        { key: 'Good morning', path: `${base}/audio/Greetings/good morning.wav` },
        { key: 'Good noon', path: `${base}/audio/Greetings/good noon.wav` },
        { key: 'Good to see you', path: `${base}/audio/Greetings/good to see you.wav` },
        { key: 'How about you?', path: `${base}/audio/Greetings/how about you.wav` },
        { key: 'How are you?', path: `${base}/audio/Greetings/how are you.wav` },
        { key: 'I am fine', path: `${base}/audio/Greetings/i am fine.wav` },
        { key: 'Glad to meet you', path: `${base}/audio/Greetings/glad to meet you.wav` },

        // Words (audio/Words)
        { key: 'Family', path: `${base}/audio/Words/family.wav` },
        { key: 'Happy', path: `${base}/audio/Words/happy.wav` },
        { key: 'Near', path: `${base}/audio/Words/near.wav` },
        { key: 'Rainy', path: `${base}/audio/Words/rainy.wav` },

        // Animals (audio/Animals)
        { key: 'Dog', path: `${base}/audio/Animals/dog.wav` },

        // Family Members (audio/Family_Members)
        { key: 'Aunt', path: `${base}/audio/Family_Members/aunt.wav` },
        { key: 'Cousin', path: `${base}/audio/Family_Members/cousin.wav` },
        { key: 'Nephew/Niece', path: `${base}/audio/Family_Members/nephew niece.wav` },
        { key: 'Daughter', path: `${base}/audio/Family_Members/daughter.wav` },
        { key: 'Father', path: `${base}/audio/Family_Members/father.wav` },
        { key: 'Older Brother/Sister', path: `${base}/audio/Family_Members/older brother sister.wav` },
        { key: 'Grandfather', path: `${base}/audio/Family_Members/grandfather.wav` },
        { key: 'Grandmother', path: `${base}/audio/Family_Members/grandmother.wav` },
        { key: 'Husband', path: `${base}/audio/Family_Members/husband.wav` },
        { key: 'Mother', path: `${base}/audio/Family_Members/mother.wav` },
        { key: 'Son', path: `${base}/audio/Family_Members/son.wav` },
        { key: 'Uncle', path: `${base}/audio/Family_Members/uncle.wav` },
        { key: 'Wife', path: `${base}/audio/Family_Members/wife.wav` },
        { key: 'Youngest Sibling', path: `${base}/audio/Family_Members/youngest sibling.wav` },
    ];

    // Translations map (subset aligned with chatbot translations)
    const translations = {
        'What is your name?': { filipino: 'Ano ang pangalan mo?', casiguran_agta: 'anya i ngahen moa' },
        'Good afternoon': { filipino: 'Magandang hapon', casiguran_agta: 'memahal a apon' },
        'Good evening': { filipino: 'Magandang gabi', casiguran_agta: 'memahal a kélép' },
        'Good morning': { filipino: 'Magandang umaga', casiguran_agta: 'memahal a gagabi' },
        'Good noon': { filipino: 'Magandang tanghali', casiguran_agta: '' },
        'Good to see you': { filipino: 'Buti na lang nakita kita', casiguran_agta: 'meta' },
        'How about you?': { filipino: 'Kayo po? / Ikaw?', casiguran_agta: 'sikam' },
        'How are you?': { filipino: 'Kamusta ka na?', casiguran_agta: 'kumusta kam dén' },
        'I am fine': { filipino: 'Mabuti naman.', casiguran_agta: 'ma ige be' },
        'Glad to meet you': { filipino: 'Masaya akong makilala ka.', casiguran_agta: 'mesahat ék a matenggi taka' },

        'Family': { filipino: 'Pamilya', casiguran_agta: 'Mététena' },
        'Happy': { filipino: 'Masaya', casiguran_agta: 'Mesahat' },
        'Near': { filipino: 'Malapit', casiguran_agta: 'Asadek' },
        'Rainy': { filipino: 'Maulan', casiguran_agta: 'Me uden' },

        'Dog': { filipino: 'Aso', casiguran_agta: 'Aso' },

        'Grandfather': { filipino: 'Lolo', casiguran_agta: 'boboy lakay' },
        'Grandmother': { filipino: 'Lola', casiguran_agta: 'boboy bakés' },
        'Father': { filipino: 'Tatay', casiguran_agta: 'améng' },
        'Mother': { filipino: 'Nanay', casiguran_agta: 'inéng' },
        'Husband': { filipino: 'Asawang lalaki', casiguran_agta: 'asawa a lalaki' },
        'Wife': { filipino: 'Asawang babae', casiguran_agta: 'asawa a babe' },
        'Son': { filipino: 'Anak na lalaki', casiguran_agta: 'anak a lalake' },
        'Daughter': { filipino: 'Anak na babae', casiguran_agta: 'anak a babe' },
        'Aunt': { filipino: 'Tiya', casiguran_agta: 'Dada' },
        'Cousin': { filipino: 'Pinsan', casiguran_agta: 'Pensan' },
        'Uncle': { filipino: 'Tiyo', casiguran_agta: '' },
        'Youngest Sibling': { filipino: 'Bunso', casiguran_agta: 'depos' }
    };

    function getDailyIndex(length) {
        const now = new Date();
        // Use YYYY-DOY for deterministic rotation across months/years
        const start = new Date(now.getFullYear(), 0, 0);
        const diff = now - start;
        const oneDay = 1000 * 60 * 60 * 24;
        const dayOfYear = Math.floor(diff / oneDay);
        return dayOfYear % length;
    }

    function setPhraseOfTheDay() {
        if (!items.length) return;
        const idx = getDailyIndex(items.length);
        const entry = items[idx];
        const phraseEl = document.getElementById('daily-phrase');
        const translationEl = document.getElementById('daily-translation');
        const audio = document.getElementById('phrase-audio');

        const t = translations[entry.key] || { filipino: '', casiguran_agta: '' };
        // Main highlighted phrase should be Casiguran Agta if available; fallback to English key
        phraseEl.textContent = t.casiguran_agta && t.casiguran_agta.trim().length > 0 ? t.casiguran_agta : entry.key;
        // Show English and Filipino as supporting translations (English from key, Filipino from map)
        const translationParts = [];
        translationParts.push(`English: ${entry.key}`);
        if (t.filipino) translationParts.push(`Filipino: ${t.filipino}`);
        translationEl.textContent = translationParts.join('  |  ');

        // Ensure proper encoding for spaces
        audio.src = encodeURI(entry.path);
    }

    function setupPlayButton() {
        const btn = document.getElementById('phrase-play');
        const audio = document.getElementById('phrase-audio');
        const icon = btn.querySelector('i');
        const labelEl = btn.querySelector('.audio-play-label');

        function setState(playing) {
            icon.setAttribute('class', playing ? 'ri-pause-circle-fill' : 'ri-play-circle-fill');
            btn.setAttribute('aria-label', playing ? 'Pause Audio' : 'Play Audio');
            btn.title = playing ? 'Pause audio' : 'Play audio';
            if (labelEl) labelEl.textContent = playing ? 'Pause Audio' : 'Play Audio';
        }

        btn.addEventListener('click', function() {
            if (audio.paused) {
                audio.play().then(() => setState(true)).catch(() => {/* ignore */});
            } else {
                audio.pause();
                setState(false);
            }
        });

        audio.addEventListener('ended', function() { setState(false); });
        audio.addEventListener('pause', function() { setState(false); });
        audio.addEventListener('play', function() { setState(true); });
    }

    setPhraseOfTheDay();
    setupPlayButton();
});

// Navbar scroll effect
window.addEventListener('scroll', function(){
    let navbar = document.querySelector('.navbar');
    if(this.window.scrollY > 20){
        navbar.classList.add('scrolled')
    }else{
        navbar.classList.remove('scrolled')
    }
});

// Navbar toggle
const menuBtn = document.getElementById('menu_btn')
const navLinks = document.getElementById('nav_links')
const menuIcon = document.querySelector('i')

menuBtn.addEventListener('click', (e) => {
    navLinks.classList.toggle('open')
    const isOpen = navLinks.classList.contains('open')
    menuIcon.setAttribute('class', isOpen ? 'ri-close-line' : 'ri-menu-line')
})

// Scroll Reveal Animation
const scrollRevealOption = {
    distance: '50px',
    origin: 'bottom',
    duration: 1000
}

ScrollReveal().reveal('.left h1', {
    ...scrollRevealOption,
    delay: 500,
});
ScrollReveal().reveal('.left p', {
    ...scrollRevealOption,
    delay: 1500,
});
ScrollReveal().reveal('.main btn', {
    ...scrollRevealOption,
    delay: 1500,
});
ScrollReveal().reveal('.right img', {
    ...scrollRevealOption,
    origin: 'right'
});
ScrollReveal().reveal('.top_heading', {
    ...scrollRevealOption,
    delay: 500,
});
ScrollReveal().reveal('.heading', {
    ...scrollRevealOption,
    delay: 1000,
});
ScrollReveal().reveal('.para', {
    ...scrollRevealOption,
    delay: 500,
});
ScrollReveal().reveal('.box', {
    ...scrollRevealOption,
    delay: 1000,
});
ScrollReveal().reveal('.right_box li', {
    ...scrollRevealOption,
    delay: 500,
});
ScrollReveal().reveal('.box1 .boxes', {
    ...scrollRevealOption,
    delay: 500,
});
ScrollReveal().reveal('.footer_col', {
    ...scrollRevealOption,
    delay: 500,
});
