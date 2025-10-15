document.addEventListener('DOMContentLoaded', function() {
    // Build dataset from existing audio files (relative to phrase/phrase.php)
    const base = '..';
    const items = [
        // Greetings
        { key: 'What is your name?', path: `${base}/audio/Greetings/what is your name.wav` },
        { key: 'Goodbye', path: `${base}/audio/Greetings/goodbye.wav` },
        { key: 'Thank you', path: `${base}/audio/Greetings/thank you.wav` },
        { key: "I'm sorry", path: `${base}/audio/Greetings/im sorry.wav` },
        { key: 'Yes', path: `${base}/audio/Greetings/yes.wav` },
        { key: 'No', path: `${base}/audio/Greetings/no.wav` },
        { key: 'My name is', path: `${base}/audio/Greetings/my name is.wav` },
        { key: 'Good afternoon', path: `${base}/audio/Greetings/good afternoon.wav` },
        { key: 'Good evening', path: `${base}/audio/Greetings/good evening.wav` },
        { key: 'Good morning', path: `${base}/audio/Greetings/good morning.wav` },
        { key: 'Good noon', path: `${base}/audio/Greetings/good noon.wav` },
        { key: 'Good to see you', path: `${base}/audio/Greetings/good to see you.wav` },
        { key: 'How about you?', path: `${base}/audio/Greetings/how about you.wav` },
        { key: 'How are you?', path: `${base}/audio/Greetings/how are you.wav` },
        { key: 'I am fine', path: `${base}/audio/Greetings/i am fine.wav` },
        { key: 'Glad to meet you', path: `${base}/audio/Greetings/glad to meet you.wav` },

        // Words
        { key: 'Family', path: `${base}/audio/Words/family.wav` },
        { key: 'Happy', path: `${base}/audio/Words/happy.wav` },
        { key: 'Near', path: `${base}/audio/Words/near.wav` },
        { key: 'Cold', path: `${base}/audio/Words/cold.wav` },

        // Weather
        { key: 'Rainy', path: `${base}/audio/Weather/rainy.wav` },
        { key: 'Cloudy', path: `${base}/audio/Weather/cloudy.wav` },
        { key: 'Summer', path: `${base}/audio/Weather/summer.wav` },
        { key: 'Rainy season', path: `${base}/audio/Weather/rainy season.wav` },
        { key: 'Warm', path: `${base}/audio/Weather/warm.wav` },
        { key: 'Windy', path: `${base}/audio/Weather/windy.wav` },

        // Animals
        { key: 'Dog', path: `${base}/audio/Animals/dog.wav` },

        // Daily Use Expressions
        { key: 'Excuse me', path: `${base}/audio/Daily_Use_Expressions/excuse me.wav` },
        { key: "Im leaving", path: `${base}/audio/Daily_Use_Expressions/im leaving.wav` },
        { key: 'Can you help me', path: `${base}/audio/Daily_Use_Expressions/can you help me.wav` },
        { key: 'What can I do for you', path: `${base}/audio/Daily_Use_Expressions/what can i do for you.wav` },
        { key: 'I understand', path: `${base}/audio/Daily_Use_Expressions/i understand.wav` },

        // Question Words
        { key: 'What', path: `${base}/audio/Question_Words/what.wav` },
        { key: 'When', path: `${base}/audio/Question_Words/when.wav` },
        { key: 'Where', path: `${base}/audio/Question_Words/where.wav` },
        { key: 'Which', path: `${base}/audio/Question_Words/which.wav` },
        { key: 'Who', path: `${base}/audio/Question_Words/who.wav` },
        { key: 'Why', path: `${base}/audio/Question_Words/why.wav` },
        { key: 'How much', path: `${base}/audio/Question_Words/how much.wav` },

        // Colors
        { key: 'Blue', path: `${base}/audio/Colors/blue.wav` },
        { key: 'Red', path: `${base}/audio/Colors/red.wav` },
        { key: 'White', path: `${base}/audio/Colors/white.wav` },
        { key: 'Black', path: `${base}/audio/Colors/black.wav` },
        { key: 'Green', path: `${base}/audio/Colors/green.wav` },
        { key: 'Yellow', path: `${base}/audio/Colors/yellow.wav` },
        { key: 'Brown', path: `${base}/audio/Colors/brown.wav` },
        { key: 'Gray', path: `${base}/audio/Colors/gray.wav` },
        { key: 'Pink', path: `${base}/audio/Colors/pink.wav` },
        { key: 'Orange', path: `${base}/audio/Colors/orange.wav` },
        { key: 'Violet', path: `${base}/audio/Colors/violet.wav` },

        // Family Members
        { key: 'Grandfather', path: `${base}/audio/Family_Members/grandfather.wav` },
        { key: 'Grandmother', path: `${base}/audio/Family_Members/grandmother.wav` },
        { key: 'Father', path: `${base}/audio/Family_Members/father.wav` },
        { key: 'Mother', path: `${base}/audio/Family_Members/mother.wav` },
        { key: 'Older Brother', path: `${base}/audio/Family_Members/older brother.wav` },
        { key: 'Older Sister', path: `${base}/audio/Family_Members/older sister.wav` },
        { key: 'Youngest Sibling', path: `${base}/audio/Family_Members/youngest sibling.wav` },
        { key: 'Husband', path: `${base}/audio/Family_Members/husband.wav` },
        { key: 'Wife', path: `${base}/audio/Family_Members/wife.wav` },
        { key: 'Son', path: `${base}/audio/Family_Members/son.wav` },
        { key: 'Daughter', path: `${base}/audio/Family_Members/daughter.wav` },
        { key: 'Aunt', path: `${base}/audio/Family_Members/aunt.wav` },
        { key: 'Cousin', path: `${base}/audio/Family_Members/cousin.wav` },
        { key: 'Uncle', path: `${base}/audio/Family_Members/uncle.wav` },
        { key: 'Niece', path: `${base}/audio/Family_Members/niece.wav` },
        { key: 'Nephew', path: `${base}/audio/Family_Members/nephew.wav` },

        // Buying and Selling
        { key: 'How much? How many?', path: `${base}/audio/Buying_and_Selling/how much how many.wav` },
        { key: 'How much for two', path: `${base}/audio/Buying_and_Selling/how much for two.wav` },
        { key: 'I will get two', path: `${base}/audio/Buying_and_Selling/i will get two.wav` },
        { key: 'Okay you can get them', path: `${base}/audio/Buying_and_Selling/okay you can get them.wav` },
        { key: 'It is fifty pesos', path: `${base}/audio/Buying_and_Selling/it is fifty pesos.wav` },
        { key: 'The two are 100 pesos', path: `${base}/audio/Buying_and_Selling/the two are 100 pesos.wav` },

        // Giving Directions
        { key: 'Where are you going', path: `${base}/audio/Giving_Directions/where are you going.wav` },
        { key: 'Im going to the garden', path: `${base}/audio/Giving_Directions/im going to the garden.wav` },
        { key: 'The garden is by the river', path: `${base}/audio/Giving_Directions/the garden is by the river.wav` },
        { key: 'Whose garden is it', path: `${base}/audio/Giving_Directions/whose garden is it.wav` },
        { key: 'It is my garden', path: `${base}/audio/Giving_Directions/it is my garden.wav` }
    ];

    // Updated translations map
    const translations = {
        // Greetings and Common Phrases
        'What is your name?': { filipino: 'Ano ang pangalan mo?', casiguran_agta: 'Anya i ngahen moa' },
        'Goodbye': { filipino: 'Paalam.', casiguran_agta: 'Naydén kako dén' },
        'Thank you': { filipino: 'Maraming salamat.', casiguran_agta: 'Me ado a salamat' },
        "I'm sorry": { filipino: 'Patawarin mo ako.', casiguran_agta: 'Patawadén nék mo' },
        'Yes': { filipino: 'Opo', casiguran_agta: 'On' },
        'No': { filipino: 'Hindi po', casiguran_agta: 'Ewan be' },
        'My name is': { filipino: 'Ako si', casiguran_agta: 'Saken ti' },
        'Good to see you': { filipino: 'Buti na lang nakita kita', casiguran_agta: 'Meta' },
        'How are you?': { filipino: 'Kamusta ka na?', casiguran_agta: 'Kumusta kam dén' },
        'I am fine': { filipino: 'Mabuti naman.', casiguran_agta: 'Ma ige be' },
        'Glad to meet you': { filipino: 'Masaya akong makilala ka', casiguran_agta: 'Mesahat ék a matenggi taka' },
        'Good afternoon': { filipino: 'Magandang hapon', casiguran_agta: 'Memahal a apon' },
        'Good noon': { filipino: 'Magandang tanghali', casiguran_agta: 'Memahal a tanghali' },
        'Good evening': { filipino: 'Magandang gabi', casiguran_agta: 'Memahal a kélép' },
        'Good morning': { filipino: 'Magandang umaga', casiguran_agta: 'Memahal a gagabi' },
        'How about you?': { filipino: 'Kayo po? / Ikaw?', casiguran_agta: 'Sikam' },

        // Family Members
        'Grandfather': { filipino: 'Lolo', casiguran_agta: 'Boboy lakay' },
        'Grandmother': { filipino: 'Lola', casiguran_agta: 'Boboy bakés' },
        'Father': { filipino: 'Tatay', casiguran_agta: 'Améng' },
        'Mother': { filipino: 'Nanay', casiguran_agta: 'Inéng' },
        'Older Brother': { filipino: 'Kuya', casiguran_agta: 'Kakéng' },
        'Older Sister': { filipino: 'Ate', casiguran_agta: 'Kakéng' },
        'Youngest Sibling': { filipino: 'Bunso', casiguran_agta: 'Depos' },
        'Husband': { filipino: 'Asawang lalaki', casiguran_agta: 'Asawa a lalaki' },
        'Wife': { filipino: 'Asawang babae', casiguran_agta: 'Asawa a babe' },
        'Son': { filipino: 'Anak na lalaki', casiguran_agta: 'Anak a lalake' },
        'Daughter': { filipino: 'Anak na babae', casiguran_agta: 'Anak a babe' },
        'Aunt': { filipino: 'Tiya', casiguran_agta: 'Dada' },
        'Cousin': { filipino: 'Pinsan', casiguran_agta: 'Pensan' },
        'Uncle': { filipino: 'Tiyo', casiguran_agta: 'Lele' },
        'Niece': { filipino: 'Pamangkin', casiguran_agta: 'Anéng' },
        'Nephew': { filipino: 'Pamangkin', casiguran_agta: 'Anéng' },

        // Weather
        'Cloudy': { filipino: 'Maulap', casiguran_agta: 'Me habuhab' },
        'Summer': { filipino: 'Tag-init', casiguran_agta: 'Tag init' },
        'Rainy season': { filipino: 'Tag-ulan', casiguran_agta: 'Tag udén' },
        'Warm': { filipino: 'Mainit', casiguran_agta: 'Me pasi' },
        'Windy': { filipino: 'Maulap', casiguran_agta: 'Me pahés' },

        // Daily Use Expressions
        'Excuse me': { filipino: 'Makikiraan po', casiguran_agta: 'Mékidiman kame' },
        "I'm leaving": { filipino: 'Aalis na po ako', casiguran_agta: 'Még dema kamedén' },
        'Can you help me': { filipino: 'Maaari mo ba akong tulungan?', casiguran_agta: 'Pwede ék moy tulungan' },
        'What can I do for you': { filipino: 'Ano po ang magagawa ko para sa inyo?', casiguran_agta: 'Anyá i magimet koa para dekam' },
        'I understand': { filipino: 'Naiintindihan ko', casiguran_agta: 'Meentendian ko' },

        // Question Words
        'What': { filipino: 'Ano?', casiguran_agta: 'Anya' },
        'When': { filipino: 'Kailan?', casiguran_agta: 'Ni kesya' },
        'Where': { filipino: 'Saan?', casiguran_agta: 'Tahe' },
        'Which': { filipino: 'Alin?', casiguran_agta: 'Nahe' },
        'Who': { filipino: 'Sino?', casiguran_agta: 'Te esya' },
        'Why': { filipino: 'Bakit?', casiguran_agta: 'Ata ay' },
        'How much': { filipino: 'Magkano?', casiguran_agta: 'Sanganya?' },

        // Colors
        'Blue': { filipino: 'Asul', casiguran_agta: 'Asul' },
        'Red': { filipino: 'Pula', casiguran_agta: 'Medingat' },
        'White': { filipino: 'Puti', casiguran_agta: 'Melatak' },
        'Black': { filipino: 'Itim', casiguran_agta: 'mengitet' },
        'Green': { filipino: 'Berde', casiguran_agta: 'Kumanidon' },
        'Yellow': { filipino: 'Dilaw', casiguran_agta: 'Medilaw' },
        'Brown': { filipino: 'Kulay tsokolate', casiguran_agta: 'Tsokolate' },
        'Gray': { filipino: 'Kulay abo', casiguran_agta: 'Kulay abo' },
        'Pink': { filipino: 'Rosas', casiguran_agta: 'Rosas' },
        'Orange': { filipino: 'Dalandan', casiguran_agta: 'Kuman a don' },
        'Violet': { filipino: 'Lila', casiguran_agta: 'Kuman a pensél' },

        // Buying and Selling
        'How much? How many?': { filipino: 'Magkano? Ilan?', casiguran_agta: 'Sanganya?' },
        'How much for two': { filipino: 'Magkano ang dalawa?', casiguran_agta: 'Sangan éduwa' },
        'I will get two': { filipino: 'Kukuha ako ng dalawa', casiguran_agta: 'Mangalap pékta éduwa' },
        'Okay, you can get them': { filipino: 'Sige kunin mo na', casiguran_agta: 'Nay alapén mo dén' },
        'It is fifty pesos': { filipino: 'Limampung piso ito', casiguran_agta: 'Lima apulo ye' },
        'The two are 100 pesos': { filipino: 'Isang daang piso ang dalawa', casiguran_agta: 'Esa a daan éduwa' },

        // Giving Directions
        'Where are you going': { filipino: 'Saan ka pupunta?', casiguran_agta: 'Ahe ka umange' },
        'Im going to the garden': { filipino: 'Pupunta ako sa halamanan', casiguran_agta: 'Ange ékta sikaw' },
        'The garden is by the river': { filipino: 'Malapit sa ilog ang halamanan', casiguran_agta: 'Adene ta dinom ya tu sikaw' },
        'Whose garden is it': { filipino: 'Kaninong halamanan iyon?', casiguran_agta: 'Kini esya a sikaw ya' },
        'It is my garden': { filipino: 'Sa akin ang halamanan', casiguran_agta: 'Ko o ko a sikaw' }
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
