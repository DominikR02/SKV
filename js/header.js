document.addEventListener('DOMContentLoaded', function () {
    // Lade den Header
    fetch('../../SKV/module/header.html')
        .then(response => response.text())
        .then(data => {
            // Füge den Header in alle Elemente mit der Klasse 'header' ein
            const headerElements = document.getElementsByClassName('header');
            Array.from(headerElements).forEach(function (headerElement) {
                headerElement.innerHTML = data;

                // Holen Sie sich den Inhalt des webapp_modal von der geladenen header.html
                const webappModalContent = headerElement.querySelector('#webapp_modal').innerHTML;

                // Füge den Inhalt in #webapp_modal ein
                const webappModal = document.getElementById('webapp_modal');
                webappModal.innerHTML = webappModalContent;

                // Führe den restlichen Code aus, der auf #webapp_modal zugreift
                const menuCheckbox = document.getElementById('menu_checkbox');
                const screenWidth = window.innerWidth;

                menuCheckbox.addEventListener('change', function () {
                    webappModal.style.display = this.checked ? 'block' : 'none';
                });

                // Dynamisch den Inhalt des Modals erstellen
                const navList = document.querySelector('nav');
                webappModal.innerHTML = navList.innerHTML;

                // Dynamisch Datenschutz- und Impressum-Links hinzufügen
                const footerLinks = document.createElement('div');
                footerLinks.className = 'footer-links';
                footerLinks.innerHTML =
                    '<p><a href="#">FAQ</a> | <a href="#">Kontakt</a> | <a href="#">Über uns</a></p>' +
                    '<p><a href="../../SKV/datenschutz.html">Datenschutz</a> | <a href="../../SKV/impressum.html">Impressum</a></p>';
                webappModal.appendChild(footerLinks);

                // JavaScript für Bildschirmbreite > 450px
                if (screenWidth > 450) {
                    menuCheckbox.checked = false;
                    webappModal.style.display = 'none';
                }

                // Event Listener für Änderungen der Bildschirmbreite
                window.addEventListener('resize', function () {
                    const newScreenWidth = window.innerWidth;

                    if (newScreenWidth > 450) {
                        menuCheckbox.checked = false;
                        webappModal.style.display = 'none';
                    }
                });
            });
        })
        .catch(error => console.error('Error fetching header:', error));
});
