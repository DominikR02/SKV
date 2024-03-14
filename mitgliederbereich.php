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
        .personal-content {
            display: flex;
        }

        .qrcode-container {
            margin-left: 20px;
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
            <h1>Mitgliedsausweis</h1>
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
    function checkMA() {
        const geraet = generateDeviceID();
        const MAGeraetDB = '<?php echo $_SESSION['MAGeraet']; ?>';

        if (MAGeraetDB === "NoDevice") {
            const qrcodeContainer = document.querySelector(".qrcode");
            qrcodeContainer.innerHTML = "<button onclick='initializeMA()'>Mitgliedsausweis auf diesem Gerät anzeigen</button>";
        } else if (geraet === MAGeraetDB) {
            const MAGeraetGueltigAb = new Date('<?php echo $_SESSION['MAGeraetGueltigAb']; ?>');
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
            qrcodeContainer.innerHTML = "<button>Mitgliedsausweis auf dieses Gerät umziehen</button>";
        }
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

        console.log("reload");
    }


    function generateDeviceID() {
        var navigatorInfo = window.navigator;
        var screenInfo = window.screen;

        var deviceID =
            navigatorInfo.userAgent +
            screenInfo.width +
            screenInfo.height +
            screenInfo.colorDepth +
            navigatorInfo.language;

        console.log("DID: " + deviceID);

        return md5(deviceID);
    }

    function generateQr() {
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

        // Aktuelles Datum (inkl. Zeit)
        var currentDate = formatDate(new Date());

        // Session-Variablen
        var lastScanMA = "<?php echo $_SESSION['LastScanMA'] ?>";
        var benutzername = "<?php echo $_SESSION['Benutzername'] ?>";
        var passwort = "<?php echo $_SESSION['Passwort'] ?>";

        const inputValue = currentDate + lastScanMA + benutzername + passwort;

        const qrcodeContainer = document.querySelector(".qrcode");

        // QRCode-Instanz löschen und neu erstellen
        qrcodeContainer.innerHTML = "";
        let qrcode = new QRCode(qrcodeContainer);

        // Immer den QR-Code generieren, auch wenn das Eingabefeld leer ist
        if (inputValue !== "") {
            qrcode.makeCode(inputValue); // Neuen QR-Code generieren
        }
    }
</script>
</body>
</html>
