<?php

// Datenbankverbindung herstellen
define('host', 'localhost');
define('user', 'SKV-Webadmin');
define('pass', 'SKV1979');
define('db', 'skv-web');

$con = mysqli_connect(host, user, pass, db);

// Überprüfen, ob die Verbindung erfolgreich war
if (mysqli_connect_errno()) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Fehler beim Verbinden zur MySQL-Datenbank: ' . mysqli_connect_error()
    ));
    exit();
}

// Überprüfen, ob der 'user'-Parameter übergeben wurde
if (isset($_POST['user'])) {
    // User-Wert aus dem POST-Parameter erhalten
    $user = $_POST['user'];

    // Datenbankabfrage
    $query = "SELECT * FROM `mitglieder` WHERE `Benutzername`='$user'";
    $result = mysqli_query($con, $query);

    // Überprüfen, ob die Abfrage erfolgreich war
    if ($result) {
        // Überprüfen, ob ein Datensatz gefunden wurde
        if (mysqli_num_rows($result) > 0) {
            // Datensatz vorhanden, Daten extrahieren
            $row = mysqli_fetch_assoc($result);
            $lastScanDB = $row['LastScanMA'];
            $deviceIDDB = $row['MAGeraet'];

            // Daten als JSON zurückgeben
            echo json_encode(array(
                'success' => true,
                'lastScanDB' => $lastScanDB,
                'deviceIDDB' => $deviceIDDB
            ));
        } else {
            // Kein Datensatz gefunden
            echo json_encode(array(
                'success' => false,
                'message' => 'Keine Informationen für den angegebenen Benutzer gefunden.'
            ));
        }
    } else {
        // Fehler bei der Datenbankabfrage
        echo json_encode(array(
            'success' => false,
            'message' => 'Fehler bei der Datenbankabfrage: ' . mysqli_error($con)
        ));
    }
} else {
    // 'user'-Parameter nicht übergeben
    echo json_encode(array(
        'success' => false,
        'message' => 'Der "user"-Parameter wurde nicht übergeben.'
    ));
}

// Datenbankverbindung schließen
mysqli_close($con);

?>
