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

        // Bestimme die aktuelle Zeit
        $currentTimestamp = time();
        // Berechne den Zeitpunkt, der 10 Minuten nach der aktuellen Zeit liegt
        $newTimestamp = $currentTimestamp + (1 * 60); // 10 Minuten in Sekunden
        // Konvertiere den neuen Zeitstempel in ein Datumsformat für MySQL
        $newDatetime = date('Y-m-d H:i:s', $newTimestamp);
        // Formuliere die SQL-Abfrage mit dem aktualisierten Zeitstempel
        $updatePasswordQuery = "UPDATE `mitglieder` SET `MAGeraet`='$geraet', `MAGeraetGueltigAb`='$newDatetime' WHERE `Benutzername`='$benutzername'";
        $updatePasswordResult = mysqli_query($con, $updatePasswordQuery);

        // Überprüfen, ob die Aktualisierung erfolgreich war
        if ($updatePasswordResult) {
            $_SESSION['MAGeraet'] = $geraet;
            $_SESSION['MAGeraetGueltigAb'] = $newDatetime;
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
