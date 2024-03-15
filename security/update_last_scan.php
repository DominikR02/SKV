<?php

// Datenbankverbindung herstellen
define('host', 'localhost');
define('user', 'SKV-Webadmin');
define('pass', 'SKV1979');
define('db', 'skv-web');

$con = mysqli_connect(host, user, pass, db);

// Überprüfen, ob die Verbindung erfolgreich war
if (mysqli_connect_errno()) {
    echo "Fehler beim Verbinden zur MySQL-Datenbank: " . mysqli_connect_error();
    exit();
}

// Überprüfen, ob der 'user' und 'currentTime'-Parameter übergeben wurde
if (isset($_POST['user']) && isset($_POST['currentTime'])) {
    // Benutzername und aktuelle Zeit aus dem POST-Parameter erhalten
    $user = $_POST['user'];
    $currentTime = $_POST['currentTime'];

    // SQL-Abfrage zum Aktualisieren des LastScanMA
    $updateQuery = "UPDATE `mitglieder` SET `LastScanMA`='$currentTime' WHERE `Benutzername`='$user'";

    // SQL-Abfrage ausführen
    $updateResult = mysqli_query($con, $updateQuery);

    // Überprüfen, ob die Aktualisierung erfolgreich war
    if ($updateResult) {
        echo "Letzter Scan erfolgreich aktualisiert.";
    } else {
        echo "Fehler beim Aktualisieren des letzten Scans.";
    }
} else {
    echo "Der 'user' oder 'currentTime'-Parameter wurde nicht übergeben.";
}

// Datenbankverbindung schließen
mysqli_close($con);

?>
