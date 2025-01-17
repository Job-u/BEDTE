
document.addEventListener('DOMContentLoaded', function() {
    // Array of phrases
    const phrases = [
        "Kumusta! (Hello!)",
        "Magandang araw! (Good day!)",
        "Ano ang iyong pangalan? (What is your name?)",
        "Salamat! (Thank you!)",
        "Paalam! (Goodbye!)",
        "Masaya ako na makilala ka. (Nice to meet you.)"
    ];

    // Function to calculate the current index based on the date
    function getDailyPhrase() {
        const currentDate = new Date();
        const dayIndex = currentDate.getDate() % phrases.length; // Rotate phrases daily
        return phrases[dayIndex];
    }

    // Update the DOM with the daily phrase
    document.getElementById("daily-phrase").textContent = getDailyPhrase();
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
