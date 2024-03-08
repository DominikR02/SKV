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
</head>
<body>
<header class="header"></header>

<main>
    <div class="personal-info">
        <h1>Persönliche Informationen</h1>
        <h3>Position</h3>
        <p id="position"><?php echo $_SESSION['Position']; ?></p>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userPosition = document.getElementById('position').innerHTML;
        console.log(userPosition);

        switch (userPosition) {
            case 'Webadmin':
                document.getElementById('Webadmin').style.display = "block";
                fetch('../../SKV/module/mitgliederbereich/webadmin.html')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('Webadmin').innerHTML = data;
                    });
            case 'Vorstand':
                document.getElementById('Vorstand').style.display = "block";
                fetch('../../SKV/module/mitgliederbereich/vorstand.html')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('Vorstand').innerHTML = data;
                    });
            case 'ER':
                document.getElementById('ER').style.display = "block";
                fetch('../../SKV/module/mitgliederbereich/er.html')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('ER').innerHTML = data;
                    });
            case 'PK':
                document.getElementById('PK').style.display = "block";
                fetch('../../SKV/module/mitgliederbereich/pk.html')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('PK').innerHTML = data;
                    });
                break;
        };
    });
</script>
</body>
</html>
