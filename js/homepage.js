//navbar scroll
window.addEventListener('scroll', function(){
    let navbar = document.querySelector('.navbar');
    if(this.window.scrollY > 20){
        navbar.classList.add('scrolled')
    }else{
        navbar.classList.remove('scrolled')
    }
})
// navbar toggle (unified with phrase.php)
const menuBtn = document.getElementById('menu_btn');
const navLinks = document.getElementById('nav_links');
const menuIcon = document.querySelector('.nav_menu i');

if (menuBtn && navLinks && menuIcon) {
    menuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        navLinks.classList.toggle('open');
        const isOpen = navLinks.classList.contains('open');
        menuIcon.setAttribute('class', isOpen ? 'ri-close-line' : 'ri-menu-line');
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        const clickedInsideMenu = menuBtn.contains(e.target) || navLinks.contains(e.target);
        if (!clickedInsideMenu && navLinks.classList.contains('open')) {
            navLinks.classList.remove('open');
            menuIcon.setAttribute('class', 'ri-menu-line');
        }
    });
}

//Animation

const scrollRevealOption = {
    distance:'50px',
    origin:'bottom',
    duration:1000
}

ScrollReveal().reveal('.left h1',{
    ...scrollRevealOption,
    delay:500,
});
ScrollReveal().reveal('.left p',{
    ...scrollRevealOption,
    delay:1000,
});
ScrollReveal().reveal('.main btn',{
    ...scrollRevealOption,
    delay:1500,
});
ScrollReveal().reveal('.right img',{
    ...scrollRevealOption,
    origin:'right'
});
ScrollReveal().reveal('.top_heading',{
    ...scrollRevealOption,
    delay:500,
});
ScrollReveal().reveal('.heading',{
    ...scrollRevealOption,
    delay:500,
});
ScrollReveal().reveal('.para',{
    ...scrollRevealOption,
    delay:500,
});
ScrollReveal().reveal('.box',{
    ...scrollRevealOption,
    delay:1000,
});
ScrollReveal().reveal('.right_box li',{
    ...scrollRevealOption,
    delay:500,
});
ScrollReveal().reveal('.box1 .boxes',{
    ...scrollRevealOption,
    delay:500,
});
ScrollReveal().reveal('.footer_col',{
    ...scrollRevealOption,
    delay:500,
});

