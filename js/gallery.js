// JavaScript für die Lightbox-Funktionalität
let currentImageIndex = 0;
const lightbox = document.getElementById('lightbox');
const lightboxImage = document.getElementById('lightboxImage');
const lightboxCaption = document.getElementById('lightboxCaption');
const galleryImages = document.querySelectorAll('.galleryGrid .gridItem img');

function showLightbox(index) {
    currentImageIndex = index;
    lightboxImage.src = galleryImages[index].src;
    lightboxCaption.innerText = galleryImages[index].alt;
    lightbox.style.display = 'flex';
}

function hideLightbox() {
    lightbox.style.display = 'none';
}

function changeImage(direction) {
    currentImageIndex += direction;
    if (currentImageIndex < 0) {
        currentImageIndex = galleryImages.length - 1;
    } else if (currentImageIndex >= galleryImages.length) {
        currentImageIndex = 0;
    }
    lightboxImage.src = galleryImages[currentImageIndex].src;
    lightboxCaption.innerText = galleryImages[currentImageIndex].alt;
}

function handleKeyboardEvents(event) {
    switch (event.key) {
        case 'ArrowLeft':
            changeImage(-1);
            break;
        case 'ArrowRight':
            changeImage(1);
            break;
        case 'Escape':
            hideLightbox();
            break;
    }
}

// Klick-Event für jedes Bild hinzufügen
galleryImages.forEach((image, index) => {
    image.addEventListener('click', () => showLightbox(index));
});

// Klick-Event für das Schließen außerhalb des Bildes hinzufügen
lightbox.addEventListener('click', (event) => {
    if (event.target === lightbox) {
        hideLightbox();
    }
});

// Tastatur-Events überwachen
document.addEventListener('keydown', handleKeyboardEvents);