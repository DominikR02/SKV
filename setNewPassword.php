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
    <title>SKV | Passwort ändern</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" type="text/css" href="css/root.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <script src="js/header.js"></script>
    <script src="js/footer.js"></script>

    <link rel="stylesheet" type="text/css" href="css/forms.css">
</head>
<body>

<main>
    <form class="form wrap" action="webadmin/checkNewPassword.php" method="post">
        <img src="img/logo-headline.png">
        <input type="password" id="altesPasswort" name="altesPasswort" placeholder="Altes Passwort" required>
        <input type="password" id="neuesPasswort" name="neuesPasswort" placeholder="Neues Passwort" required>
        <input type="password" id="neuesPasswort2" name="neuesPasswort2" placeholder="Neues Passwort wiederholen" required>
        <button type="submit" name="submit">Passwort ändern</button>
    </form>
</main>

<div class="sponsor-infinite-carrousel"></div>
</body>
</html>
