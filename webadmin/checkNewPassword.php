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
    header('location: ../login.html');
    exit;
}

$oldPass = $_POST['altesPasswort'];
$newPass = $_POST['neuesPasswort'];

// Entferne md5, da Sie password_verify verwenden sollten
if (password_verify($oldPass, $_SESSION['Passwort'])) {
    $benutzername = $_SESSION['Benutzername'];
    $newPassHashed = password_hash($newPass, PASSWORD_DEFAULT);

    // Aktualisiere das Passwort in der Datenbank
    $updatePasswordQuery = "UPDATE `mitglieder` SET `Passwort`='$newPassHashed', `InitialPasswort`='F' WHERE `Benutzername`='$benutzername'";
    $updatePasswordResult = mysqli_query($con, $updatePasswordQuery);

    if ($updatePasswordResult) {
        $_SESSION['Passwort'] = $newPassHashed;
        header('location: ../mitgliederbereich.php');
        exit;
    } else {
        echo "Fehler beim Aktualisieren des Passworts.";
    }
} else {
    // Falsches altes Passwort
    echo "Falsches altes Passwort.";
}

?>
