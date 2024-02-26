// Scroll-to-Top Funktion mit Smooth Scroll-Effekt
function scrollToTop() {
    // Die `behavior`-Eigenschaft wird auf "smooth" gesetzt
    // um einen sanften Scroll-Effekt zu erzeugen
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Scroll-Event Listener für das Ein- und Ausblenden des Buttons
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scrollToTopBtn.style.display = "block";
    } else {
        scrollToTopBtn.style.display = "none";
    }
}