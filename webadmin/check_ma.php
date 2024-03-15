<?php

session_start();

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
if (isset($_POST['user'])) {
    // MAGeraet-Wert aus dem POST-Parameter erhalten
    $user = $_POST['user'];

    // Session-Variable `Benutzername` überprüfen (Voraussetzung: Sitzung wurde bereits gestartet)
    if (isset($_SESSION['Benutzername'])) {
        // MAGeraet in der Datenbank aktualisieren
        $userabfrage = "SELECT * FROM `mitglieder` WHERE `Benutzername` = '$user' LIMIT 1";
        $userabf = mysqli_query($con, $userabfrage);

        // Überprüfen, ob die Aktualisierung erfolgreich war
        if ($userabf) {
            $gu = mysqli_fetch_assoc($userabf);
            $_SESSION['MAGeraet'] = $gu['MAGeraet'];
            $_SESSION['MAGeraetGueltigAb'] = $gu['MAGeraetGueltigAb'];
            $_SESSION['LastScanMA'] = $gu['LastScanMA'];
            echo json_encode(array(
                'success' => true,
                'message' => 'MAGeraet erfolgreich aktualisiert.',
                'MAGeraet' => $gu['MAGeraet'],
                'MAGeraetGueltigAb' => $gu['MAGeraetGueltigAb'],
                'lastScanMA' => $gu['LastScanMA']
            ));
        } else {
            echo "Fehler beim Aktualisieren des MAGeraet.";
        }
    } else {
        echo "Session 'Benutzername' wurde nicht gefunden.";
    }
} else {
    echo "Das 'user'-Parameter wurde nicht übergeben.";
}

?>