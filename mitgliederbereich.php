<?php
session_start();

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
</head>
<body onload="generateQr()"> <!-- generateQr() beim Laden der Seite aufrufen -->

<header class="header"></header>

<main>
    <div class="personal-info">
        <h1>Persönliche Informationen</h1>
        <h3>Position</h3>
        <p id="position"><?php echo $_SESSION['Position']; ?></p>
    </div>
    <div class="qrcode-container">
        <div class="qrcode"></div>
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
<script>
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
