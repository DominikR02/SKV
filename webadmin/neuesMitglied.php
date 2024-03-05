<?php
session_start();

if (!isset($_SESSION['Benutzername'])) {
    //header('location: ../login.html');
    //exit;
} else if ($_SESSION['Position'] != 'Webadmin') {
    //header('location: ../login.html');
    //exit;
}

define('host', 'localhost');
define('user', 'SKV-Webadmin');
define('pass', 'SKV1979');
define('db', 'skv-web');

$con = mysqli_connect(host, user, pass, db);
if (!$con) {
    echo "Es besteht derzeit keine Verbindung zur Datenbank. <br>Bitte versuchen sie es später erneut.";
} else {
    $username = mysqli_real_escape_string($con, $_POST['benutzername']);
    $pass = password_hash($_POST['passwort'], PASSWORD_DEFAULT);
    $fullName = mysqli_real_escape_string($con, $_POST['fullName']);
    $gruppe = mysqli_real_escape_string($con, $_POST['gruppe']);
    $position = mysqli_real_escape_string($con, $_POST['position']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    echo "Benutzername: $username<br>";
    echo "Passwort: $pass<br>";
    echo "FullName: $fullName<br>";
    echo "Gruppe: $gruppe<br>";
    echo "Position: $position<br>";
    echo "Email: $email<br>";

    $userabfrage = "INSERT INTO `mitglieder`(`Benutzername`, `Passwort`, `Klarname`, `Gruppe`, `Position`, `Email`, `InitialPasswort`) VALUES ('$username','$pass','$fullName','$gruppe','$position','$email', 'T')";
    $userabf = mysqli_query($con, $userabfrage);

    if ($userabf) {
        // Erfolgsmeldung oder Weiterleitung
        header('location: ../mitgliederbereich.php');
        exit;
    } else {
        header('location: neuesMitgliedForm.php');
        exit;
    }
}
?>

