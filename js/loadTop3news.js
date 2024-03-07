document.addEventListener('DOMContentLoaded', function () {
    fetch('../../SKV/module/top3news.html')
        .then(response => response.text())
        .then(data => {
            // Füge den Infinite-Loop in alle Elemente mit der Klasse 'sponsor-infinite-carrousel' ein
            const headerElements = document.getElementsByClassName('top3news');
            Array.from(headerElements).forEach(function (footerElement) {
                footerElement.innerHTML = data;
            });
        })
        .catch(error => console.error('Error fetching header:', error));
});

function showHiddenContent(date) {
    // Find the nearest hidden-text element
    var readMoreLink = document.getElementById('rml-' +date);
    var hiddenText = document.getElementById('a-' + date);

    readMoreLink.style.display = "none";
    hiddenText.style.display = "block";
}

function notShowHiddenContent (date) {
    var readMoreLink = document.getElementById('rml-' +date);
    var hiddenText = document.getElementById('a-' + date);
    readMoreLink.style.display = "block";
    hiddenText.style.display = "none";
}