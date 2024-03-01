<?php

session_start();

if (!isset($_SESSION['Benutzername'])) {
    header('location: ../login.html');
    exit;
} else if ($_SESSION['Position'] != 'Webadmin') {
    header('location: ../login.html');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKV | Neues Mitglied</title>
    <link rel="stylesheet" type="text/css" href="css/root.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <script src="js/header.js"></script>
    <script src="js/footer.js"></script>
    <script>
        function validateForm() {
            var password = document.getElementById("passwort").value;
            var confirmPassword = document.getElementById("passwort2").value;

            if (password !== confirmPassword) {
                alert("Die Passwörter stimmen nicht überein!");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<header class="header"></header>

<main>
    <form action="neuesMitglied.php" method="post" onsubmit="return validateForm()">
        <label for="benutzername">Benutzername</label>
        <input id="benutzername" name="benutzername" type="text" placeholder="Benutzername" required>
        <label for="passwort">Passwort</label>
        <input id="passwort" name="passwort" type="password" placeholder="Passwort" required>
        <input id="passwort2" type="password" placeholder="Passwort wiederholen" required>
        <label for="fullName">Ganzer Name</label>
        <input id="fullName" name="fullName" type="text" placeholder="Ganzer Name" required>
        <label for="gruppe">Gruppe</label>
        <select id="gruppe" name="gruppe">
            <option value="Volleys">Volleys</option>
            <option value="Männerballett">Männerballett</option>
            <option value="Zuckerpuppen">Zuckerpuppen</option>
            <option value="WildKidz">WildKidz</option>
            <option value="Fundus">Fundus</option>
        </select>

        <label for="position">Position</label>
        <select id="position" name="position">
            <option value="Webadmin">Webadmin</option>
            <option value="Vorstand">Vorstand</option>
            <option value="ER">ER</option>
            <option value="PK">PK</option>
            <option value="Mitglied">Mitglied</option>
        </select>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" placeholder="Email" required>

        <button type="submit">Registrieren</button>
    </form>
</main>

<div class="sponsor-infinite-carrousel"></div>
<footer class="footer"></footer>
<div class="STTB"></div>
<script src="js/scrollToTopBtn.js"></script>
</body>
</html>
