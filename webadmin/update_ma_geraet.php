<?php

define('host', 'localhost');
define('user', 'SKV-Webadmin');
define('pass', 'SKV1979');
define('db', 'skv-web');
// Verbindung zur Datenbank herstellen
$con = mysqli_connect(host, user, pass, db);

// Überprüfen, ob die Verbindung erfolgreich war
if (mysqli_connect_errno()) {
    echo "Fehler beim Verbinden zur MySQL-Datenbank: " . mysqli_connect_error();
    exit();
}

// Überprüfen, ob das geraet-Parameter übergeben wurde
if (isset($_POST['geraet'])) {
    // MAGeraet-Wert aus dem POST-Parameter erhalten
    $geraet = $_POST['geraet'];

    // Session-Variable `Benutzername` überprüfen (Voraussetzung: Sitzung wurde bereits gestartet)
    session_start();
    if (isset($_SESSION['Benutzername'])) {
        $benutzername = $_SESSION['Benutzername'];

        // MAGeraet in der Datenbank aktualisieren
        $updatePasswordQuery = "UPDATE `mitglieder` SET `MAGeraet`='$geraet' WHERE `Benutzername`='$benutzername'";
        $updatePasswordResult = mysqli_query($con, $updatePasswordQuery);

        // Überprüfen, ob die Aktualisierung erfolgreich war
        if ($updatePasswordResult) {
            $_SESSION['MAGeraet'] = $geraet;
            echo "MAGeraet erfolgreich aktualisiert.";
        } else {
            echo "Fehler beim Aktualisieren des MAGeraet.";
        }
    } else {
        echo "Session 'Benutzername' wurde nicht gefunden.";
    }
} else {
    echo "Das 'geraet'-Parameter wurde nicht übergeben.";
}

// Verbindung zur Datenbank schließen
mysqli_close($con);

?>