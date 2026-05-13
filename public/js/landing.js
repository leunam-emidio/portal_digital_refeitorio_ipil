const menuToggle = document.querySelector('.burger');
const navLinks = document.querySelector('.nav-links');
const navItems = document.querySelectorAll('.nav-links a');

if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('open');
        menuToggle.classList.toggle('active');
    });
}

navItems.forEach((item) => {
    item.addEventListener('click', () => {
        if (navLinks.classList.contains('open')) {
            navLinks.classList.remove('open');
            menuToggle.classList.remove('active');
        }
    });
});

window.addEventListener('scroll', () => {
    const header = document.querySelector('.header');
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 15);
});
