<?php
session_start();

define('host', 'localhost');
define('user', 'SKV-Webadmin');
define('pass', 'SKV1979');
define('db', 'skv-web');

$con = mysqli_connect(host, user, pass, db);
if (!$con) {
    echo "Es besteht derzeit keine Verbindung zur Datenbank. <br>Bitte versuchen Sie es später erneut.";
} else {
    // Datenbank erfolgreich verbunden
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);

    $userabfrage = "SELECT * FROM `mitglieder` WHERE `Benutzername` = '$username' LIMIT 1";
    $userabf = mysqli_query($con, $userabfrage);

    if ($userabf) {
        $gu = mysqli_fetch_assoc($userabf);
        if (password_verify($pass, $gu['Passwort'])) {
            // Passwort ist korrekt
            $_SESSION['Benutzername'] = $gu['Benutzername'];
            $_SESSION['Position'] = $gu['Position'];
            $_SESSION['Passwort'] = $gu['Passwort'];
            $_SESSION['LastScanMA'] = $gu['LastScanMA'];

            if ($gu['InitialPasswort'] == 'T') {
                // Hat alles geklappt
                header('location: setNewPassword.php');
                exit;
            } else {
                // Hat alles geklappt
                header('location: mitgliederbereich.php');
                exit;
            }
        } else {
            echo "Falsches Passwort";
        }
    } else {
        echo "Benutzer nicht gefunden";
    }
}
?>
