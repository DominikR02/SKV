<?php
    session_start();

    define('host', 'localhost');
    define('user', 'SKV-Webadmin');
    define('pass', 'SKV1979');
    define('db', 'skv-web');

    $con = mysqli_connect(host, user, pass, db);
    if (!$con) {
        echo "Es besteht derzeit keine Verbindung zur Datenbank. <br>Bitte versuchen sie es später erneut.";
    } else {
        //Datenbank erfolgreich verbunden
        $username = $_POST['username'];
        $pass = md5($_POST['password']);

        echo $username."<br>";
        echo $pass."<br>";

        $userabfrage = "SELECT * FROM `mitglieder` WHERE `Benutzername` = '$username' AND `Passwort` = '$pass' LIMIT 1";
        $userabf = mysqli_query($con, $userabfrage);

        if(!mysqli_num_rows($userabf)) {
            echo "Benutzer nicht gefunden";
        } else {
            $gu = mysqli_fetch_array($userabf);
            //Session mit Benutzernamen setzen
            $_SESSION['Benutzername'] = $gu['Benutzername'];
            //Hat alles Geklappt
            header('location: mitgliederbereich.php');
            exit;
        }

    }
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Handbuch | Login</title>
    <style>
        body, html {
            background: royalblue;
            font-family: "Times New Roman";
            font-size: 14px;
            font-weight: 400;
        }

        .wrap {
            margin: 0 auto;
        }

        .login {
            width: 300px;
            margin-top: 35vh;
            text-align: center;
        }

        .login img {
            width: 400px;
            animation: bounce 1.3s;
        }

        .login input[type=text],
        .login input[type=password] {
            opacity: 1;
            display: block;
            border: none;
            outline: none;
            width: 280px;
            padding: 10px;
            margin: 20px 0 0 0;
            border-radius: 10px;
        }

        .login input[type=text] {
            animation: bounce1 1.3s;
            -webkit-appearance: none;
        }

        .login input[type=password] {
            animation: bounce2 1.6s;
        }

        .login button[type=submit] {
            border: 0;
            outline: none;
            padding: 13px 18px;
            margin: 40px 0 0 0;
            border-radius: 10px;
            font-weight: 600;
            animation: bounce3 1.9s;
        }

        @keyframes bounce {
            0% {
                transform: translateY(-250px);
                opacity: 0;
            }
        }

        @keyframes bounce1 {
            0% {
                opacity: 0;
            }
            20% {
                transform: translateY(-120px);
                opacity: 0;
            }
        }

        @keyframes bounce2 {
            0% {
                opacity: 0;
            }
            50% {
                transform: translateY(-50px);
                opacity: 0;
            }
        }

        @keyframes bounce3 {
            0% {
                opacity: 0;
            }
            70% {
                transform: translateY(-60px);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
<form class="login wrap" action="login.php" method="post">
    <img src="https://skvonline.de/images/logo.png">
    <input type="text" name="username" id="benutzername" placeholder="Benutzername" required>
    <input type="password" name="password" id="passwort" placeholder="Passwort" required>
    <button type="submit" name="submit">Einloggen</button>
</form>
</body>
</html>
