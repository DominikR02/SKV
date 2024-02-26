document.addEventListener('DOMContentLoaded', function () {
    // Lade den Header
    fetch('../../SKV/module/footer.html')
        .then(response => response.text())
        .then(data => {
            // Füge den Footer in alle Elemente mit der Klasse 'footer' ein
            const headerElements = document.getElementsByClassName('footer');
            Array.from(headerElements).forEach(function (footerElement) {
                footerElement.innerHTML = data;
            });
        })
        .catch(error => console.error('Error fetching header:', error));

    fetch('../../SKV/module/STTB.html')
        .then(response => response.text())
        .then(data => {
            // Füge den STTB in alle Elemente mit der Klasse 'STTB' ein
            const headerElements = document.getElementsByClassName('STTB');
            Array.from(headerElements).forEach(function (footerElement) {
                footerElement.innerHTML = data;
            });
        })
        .catch(error => console.error('Error fetching header:', error));
});