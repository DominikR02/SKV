<?php
session_start();

define('host', 'localhost');
define('user', 'SKV-Webadmin');
define('pass', 'SKV1979');
define('db', 'skv-web');

$con = mysqli_connect(host, user, pass, db);
if (!$con) {
    echo "Es besteht derzeit keine Verbindung zur Datenbank. <br>Bitte versuchen Sie es später erneut.";
}

if (!isset($_SESSION['Benutzername'])) {
    header('location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKV | <?php echo $_SESSION['Benutzername']; ?></title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="css/root.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <script src="js/header.js"></script>
    <script src="js/footer.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>

        @keyframes animateRainbowBorder {
            0% {
                background-position: 0% 0%; /* Beginn des Farbverlaufs */
            }
            100% {
                background-position: 100% 0%; /* Ende des Farbverlaufs */
            }
        }

        .qrcode-container {
            width: 270px;
            padding: 10px;
            text-align: center;
            border-radius: 10px; /* Runde Ecken für einen schönen Effekt */
            background-image: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet, red); /* Regenbogenfarbverlauf für das Hintergrundbild */
            background-size: 1600% 100%; /* 100% Breite, 1600% Höhe für den Farbverlauf */
            animation: animateRainbowBorder 12s linear infinite; /* Unendlich lange Animation */
        }

        .qrcode-container img {
            height: 270px;
            width: 270px;
        }
    </style>
</head>
<body onload="checkMA()"> <!-- generateQr() beim Laden der Seite aufrufen -->

<header class="header"></header>

<main>
    <div class="personal-content">
        <div class="personal-info">
            <h1>Persönliche Informationen</h1>
            <h3>Position</h3>
            <p id="position"><?php echo $_SESSION['Position']; ?></p>
        </div>
        <div class="qrcode-container">
            <h1>Digitaler Ausweis</h1>
            <h2 id="ma-counter"></h2>
            <div class="qrcode"></div>
        </div>
    </div>
    <div id="Webadmin" style="display: none"></div>
    <div id="Vorstand" style="display: none"></div>
    <div id="ER" style="display: none"></div>
    <div id="PK" style="display: none"></div>
    <div id="Mitglied">
        <h1>Mitgliederbereich</h1>
    </div>
    <a href="logout.php">Logout</a>
</main>

<div class="sponsor-infinite-carrousel"></div>
<footer class="footer"></footer>
<div class="STTB"></div>
<script src="js/scrollToTopBtn.js"></script>

<script src="js/mitgliederbereich.js"></script>
<script src="js/md5.js"></script>

<script>
    let MAGeraetDB = '<?php echo $_SESSION['MAGeraet']; ?>';
    let MAGeraetGueltigAb = new Date('<?php echo $_SESSION['MAGeraetGueltigAb']; ?>');
    let lastScanMA = '<?php echo $_SESSION['LastScanMA'] ?>';

    function checkMA() {
        //Session-Variablen checken
        // AJAX-Anfrage senden, um Daten an PHP-Datei zu senden
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'webadmin/check_ma.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    MAGeraetDB = response.MAGeraet;
                    MAGeraetGueltigAb = new Date(response.MAGeraetGueltigAb);
                    lastScanMA = response.lastScanMA;
                    console.log("MAGeraet erfolgreich aktualisiert");
                    // Hier kannst du den Wert von MAGeraetDB weiter verwenden
                } else {
                    console.error('Fehler: ' + response.message);
                }
            } else {
                console.error('Fehler beim Aktualisieren des MAGeraet');
            }
        };
        xhr.send('user=' + encodeURIComponent('<?php echo $_SESSION['Benutzername']; ?>'));

        //Zeit zum ausführen des PHP
        setTimeout(function () {
            const geraet = generateDeviceID();

            if (MAGeraetDB === "NoDevice") {
                const qrcodeContainer = document.querySelector(".qrcode");
                qrcodeContainer.innerHTML = "<button onclick='initializeMA()'>Mitgliedsausweis auf diesem Gerät anzeigen</button>";
            } else if (geraet === MAGeraetDB) {

                const currentDateTime = new Date();

                if (currentDateTime >= MAGeraetGueltigAb) {
                    // Aktuelle Zeit nach MAGeraetGueltigAb
                    generateQr();
                } else {
                    // Aktuelle Zeit vor MAGeraetGueltigAb
                    const qrcodeContainer = document.querySelector(".qrcode");
                    const countdownContainer = document.createElement("div");
                    countdownContainer.classList.add("countdown");
                    qrcodeContainer.appendChild(countdownContainer);

                    // Countdown berechnen
                    const countdownInterval = setInterval(function () {
                        const now = new Date();
                        const distance = MAGeraetGueltigAb - now;

                        // Zeit in Tage, Stunden, Minuten und Sekunden umrechnen
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Countdown im HTML-Container aktualisieren
                        countdownContainer.innerHTML = "Das Mitgliedsausweis-Gerät ist gültig in " + days + " Tage, " + hours + " Stunden, " + minutes + " Minuten und " + seconds + " Sekunden.";

                        // Countdown beenden, wenn MAGeraetGueltigAb erreicht ist
                        if (distance < 0) {
                            clearInterval(countdownInterval);
                            countdownContainer.innerHTML = "Das MA-Gerät ist jetzt gültig!";
                            generateQr();
                        }
                    }, 1000); // Aktualisieren alle 1 Sekunde
                }
            } else {
                const qrcodeContainer = document.querySelector(".qrcode");
                qrcodeContainer.innerHTML = "<button onclick='changMAgeraet()'>Mitgliedsausweis auf diesen Browser umziehen</button>";
                document.getElementById('ma-counter').innerHTML = "";
            }
        }, 1000);
    }

    function initializeMA() {
        const geraet = generateDeviceID();

        // AJAX-Anfrage senden, um Daten an PHP-Datei zu senden
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'webadmin/update_ma_geraet.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.error('Fehler beim Aktualisieren des MAGeraet');
            }
        };
        xhr.send('geraet=' + encodeURIComponent(geraet));

        setTimeout(function () {
            location.reload();
        }, 1000);
    }


    // Funktion zur Generierung einer eindeutigen Geräte-ID
    function generateDeviceID() {
        // Generiere die Geräte-ID unter Verwendung von screen.width, screen.height, Plattform und Gerätenamen
        var deviceID = getCookie('skvDeviceId');

        if (!deviceID) {
            deviceID = Math.random().toString(36).substr(2, 10) + detectPlatform();
            setCookie('skvDeviceId', deviceID, 365);
        }

        // Gib die Geräte-ID zurück
        return md5(deviceID);
        ;
    }

    // Funktion zum Erkennen der Plattform des Geräts
    function detectPlatform() {
        var platform = 'unknown';

        // Überprüfe auf verschiedene Plattformen
        if (navigator.platform.indexOf('Win') !== -1) {
            platform = 'Windows';
        } else if (navigator.platform.indexOf('Mac') !== -1) {
            platform = 'MacOS';
        } else if (navigator.platform.indexOf('Linux') !== -1) {
            platform = 'Linux';
        } else if (navigator.platform.indexOf('iPhone') !== -1) {
            platform = 'iPhone';
        } else if (navigator.platform.indexOf('iPad') !== -1) {
            platform = 'iPad';
        } else if (navigator.platform.indexOf('Android') !== -1) {
            platform = 'Android';
        }

        return platform;
    }

    function changMAgeraet() {
        const proceed = confirm("Der Umzug des Ausweis dauert 6 Stunden. Möchten Sie fortfahren?");

        if (proceed) {
            const geraet = generateDeviceID();

            // AJAX-Anfrage senden, um Daten an PHP-Datei zu senden
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'webadmin/change_ma_geraet.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                } else {
                    console.error('Fehler beim Aktualisieren des MAGeraet');
                }
            };
            xhr.send('geraet=' + encodeURIComponent(geraet));

            setTimeout(function () {
                location.reload();
            }, 1000);
        }
    }

    // Funktion zum Formatieren des Datums im gewünschten Format
    function formatDate(date) {
        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        var hours = date.getHours().toString().padStart(2, '0');
        var minutes = date.getMinutes().toString().padStart(2, '0');
        var seconds = date.getSeconds().toString().padStart(2, '0');
        return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    }

    function generateQr() {
        // Aktuelles Datum (inkl. Zeit)
        var currentDate = formatDate(new Date());

        // Session-Variablen
        var benutzername = "<?php echo $_SESSION['Benutzername'] ?>";
        var passwort = "<?php echo $_SESSION['Passwort'] ?>";

        const inputValue = currentDate + lastScanMA + benutzername + "|" + generateDeviceID();

        const qrcodeContainer = document.querySelector(".qrcode");

        // QRCode-Instanz löschen und neu erstellen
        qrcodeContainer.innerHTML = "";
        let qrcode = new QRCode(qrcodeContainer);

        // Immer den QR-Code generieren, auch wenn das Eingabefeld leer ist
        if (inputValue !== "") {
            qrcode.makeCode(inputValue); // Neuen QR-Code generieren
        }

        startMAcounter();
    }

    function startMAcounter() {
        var duration = 120; // Dauer des Counters in Sekunden (2 Minuten)
        var display = document.getElementById('ma-counter');

        // Funktion zur Aktualisierung des Counters
        function updateCounter() {
            var minutes = Math.floor(duration / 60);
            var seconds = duration % 60;

            // Führende Null hinzufügen, wenn die Anzahl der Minuten oder Sekunden einstellig ist
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            // Counter im div anzeigen
            display.textContent = minutes + ":" + seconds;

            // Wenn der Counter abgelaufen ist, checkMA() aufrufen
            if (duration <= 0) {
                clearInterval(counterInterval);
                checkMA();
            }

            duration--; // Counter aktualisieren
        }

        // Counter zuerst anzeigen, bevor er aktualisiert wird
        updateCounter();

        // Counter alle 1 Sekunde aktualisieren
        var counterInterval = setInterval(updateCounter, 1000);
    }

    // Funktion zum Speichern eines Cookies
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Funktion zum Abrufen eines Cookies
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) == 0) {
                return c.substring(nameEQ.length, c.length);
            }
        }
        return null;
    }
</script>
</body>
</html>
