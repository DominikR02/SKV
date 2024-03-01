<?php

session_start();

if (!isset($_SESSION['Benutzername'])) {
    header('location: ../login.html');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKV | </title>
    <link rel="stylesheet" type="text/css" href="css/root.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <script src="js/header.js"></script>
    <script src="js/footer.js"></script>
</head>
<body>
<header class="header"></header>

<main>
    <form>
        <label for="altesPasswort"></label>
        <input type="password" id="altesPasswort" name="altesPasswort" placeholder="Altes Passwort">
        <label for="neuesPasswort"></label>
        <input type="password" id="neuesPasswort" name="neuesPasswort" placeholder="Altes Passwort">
        <label for="neuesPasswort2"></label>
        <input type="password" id="neuesPasswort2" name="neuesPasswort2" placeholder="Altes Passwort">
    </form>
</main>

<div class="sponsor-infinite-carrousel"></div>
<footer class="footer"></footer>
<div class="STTB"></div>
<script src="js/scrollToTopBtn.js"></script>
</body>
</html>
