const slideshow = document.querySelector('.slideshow');
const slides = document.querySelector('.slides');

// Simples Autoplay
let currentIndex = 0;

function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.children.length;
    updateSlide();
}

function updateSlide() {
    const offset = -currentIndex * 100 + '%';
    slides.style.transform = 'translateX(' + offset + ')';
}

setInterval(nextSlide, 5000); // Ändere 3000 auf die gewünschte Dauer zwischen den Bildern in Millisekunden