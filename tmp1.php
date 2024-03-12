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
    <title>QR-Code Generator</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="css/root.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <script src="js/header.js"></script>
    <script src="js/footer.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body onload="generateQr()">
<header class="header"></header>
<div class="container">
    <h1>QR-Code Generator</h1>
    <div class="qrcode-container">
        <div class="qrcode"></div>
    </div>
    <input type="text" placeholder="Füge eine URL oder Text ein und drücke ENTER" id="textInput" oninput="generateQr()"/>
    <input type="text" placeholder="Gib den Namen des QR-Codes ein." id="filenameInput">
    <div class="buttons">
        <button onclick="generateQr()" style="margin-right: 8%">Generiere</button>
        <button onclick="downloadQrCode()">Download</button>
    </div>
</div>

<div class="sponsor-infinite-carrousel"></div>
<footer class="footer"></footer>
<div class="STTB"></div>
<script src="js/scrollToTopBtn.js"></script>
<script>
    function generateQr() {
        const inputValue = "Hallo";
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
