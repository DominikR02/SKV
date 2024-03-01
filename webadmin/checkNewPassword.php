<?php

session_start();

define('host', 'localhost');
define('user', 'SKV-Webadmin');
define('pass', 'SKV1979');
define('db', 'skv-web');

$con = mysqli_connect(host, user, pass, db);
if (!$con) {
    echo "Es besteht derzeit keine Verbindung zur Datenbank. <br>Bitte versuchen sie es später erneut.";
}

if (!isset($_SESSION['Benutzername'])) {
    header('location: ../login.html');
    exit;
}

$oldPass = md5($_POST['altesPasswort']);
$newPass = md5($_POST['neuesPasswort']);

echo $_SESSION['Passwort']."<br>";
echo $oldPass;

if ($_SESSION['Passwort'] === $oldPass) {
    $benutzername = $_SESSION['Benutzername'];

    // Aktualisiere das Passwort in der Datenbank
    $updatePasswordQuery = "UPDATE `mitglieder` SET `Passwort`='$newPass', `InitialPasswort`='F' WHERE `Benutzername`='$benutzername'";
    $updatePasswordResult = mysqli_query($con, $updatePasswordQuery);

    if ($updatePasswordResult) {
        $_SESSION['Passwort'] = $newPass;
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
