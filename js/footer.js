document.addEventListener('DOMContentLoaded', function () {
    fetch('../../SKV/module/infinite-loop.html')
        .then(response => response.text())
        .then(data => {
            // Füge den Infinite-Loop in alle Elemente mit der Klasse 'sponsor-infinite-carrousel' ein
            const headerElements = document.getElementsByClassName('sponsor-infinite-carrousel');
            Array.from(headerElements).forEach(function (footerElement) {
                footerElement.innerHTML = data;
            });
        })
        .catch(error => console.error('Error fetching header:', error));

    //Lade den Footer
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