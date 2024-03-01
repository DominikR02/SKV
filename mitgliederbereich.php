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
    <link rel="stylesheet" type="text/css" href="css/root.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <script src="js/header.js"></script>
    <script src="js/footer.js"></script>
</head>
<body>
<header class="header"></header>

<main>
    <div class="personal-info">
        <h1>Persönliche Informationen</h1>
        <h3>Position</h3>
        <p id="position"><?php echo $_SESSION['Position']; ?></p>
    </div>
    <div class="Webadmin" style="display: none">
        <h1>Webadminbereich</h1>
        <a href="webadmin/neuesMitgliedForm.php">Neues Mitglied hinzufügen</a>
        <p>RamoRich | Ramona123 | Vorstand</p>
        <p>ElkeRitt | Elke123 | ER</p>
        <p>AnkeMiet | Anke123 | PK</p>
        <p>AndrRich | Andreas123 | Mitglied</p>
    </div>
    <div class="Webadmin Vorstand" style="display: none">
        <h1>Vorstandsbereich</h1>
    </div>
    <div class="Webadmin Vorstand ER" style="display: none">
        <h1>ER-Bereich</h1>
    </div>
    <div class="Webadmin Vorstand ER PK" style="display: none">
        <h1>PK-Bereich</h1>
    </div>
    <div class="Webadmin Vorstand ER PK Mitglied">
        <h1>Mitgliederbereich</h1>
    </div>
    <a href="logout.php">Logout</a>
</main>

<div class="sponsor-infinite-carrousel"></div>
<footer class="footer"></footer>
<div class="STTB"></div>
<script src="js/scrollToTopBtn.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userPosition = document.getElementById('position').innerHTML;
        console.log(userPosition);

        switch (userPosition) {
            case 'Webadmin':
                Array.from(document.getElementsByClassName('Webadmin')).forEach(function (person) {
                    person.style.display = "block";
                });
                break;
            case 'Vorstand':
                Array.from(document.getElementsByClassName('Vorstand')).forEach(function (person) {
                    person.style.display = "block";
                });
                break;
            case 'ER':
                Array.from(document.getElementsByClassName('ER')).forEach(function (person) {
                    person.style.display = "block";
                });
                break;
            case 'PK':
                Array.from(document.getElementsByClassName('PK')).forEach(function (person) {
                    person.style.display = "block";
                });
                break;
        };
    });
</script>
</body>
</html>
