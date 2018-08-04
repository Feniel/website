<?php
include_once '../includes/login/functions_login.php';

sec_session_start();

$user = $_SESSION['username'];
?>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>LeNerds</title>
    <!-- Bootstrap imports -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel= "stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap‐theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom Imports -->
    <link rel="stylesheet" type="text/css" href="../sheets/nav.css"/>
    <link rel="stylesheet" type="text/css" href="../sheets/inner.css"/>
    <link rel="icon" href="media/favicon.png"/>
</head>
<?php
if (login_check($mysqli) == true) :

    include '../includes/nav.php';
?>
<div id="placeholder2"></div>
<div id="placeholder3"></div>
<div id="info">
    Wir haben seit dem 25 Februar 2018 bei Strato das Paket V-Server Linux V40 gemietet.<br><br>
    <table width=300>
        <tr>
            <th>Komponent</th>
            <th>Information</th>
        </tr>
        <tr>
            <td>Prozessor</td>
            <td>6 CPU vCores</td>
        </tr>
        <tr>
            <td>RAM</td>
            <td>12 GB</td>
        </tr>
        <tr>
            <td>Datenspeicher</td>
            <td>600 GB SSD/HDD</td>
        </tr>
        <tr>
            <td>Anbindung</td>
            <td>500 MBit/s</td>
        </tr>
        <tr>
            <td>Betriebssystem</td>
            <td>Ubuntu 16.04 LTS</td>
        </tr>
    </table>
    <h6>
        Auf dem Server sind folgende Spieleserver vorhanden:<br>
        Minecraft, CsGO<br>
        Unter <a href="http://81.169.174.67:2812/">Monit</a> können die einzelnen Dienste eingesehen werden<br>
        monit<br>
        xxxxx
    </h6>
</div>
<div id="output">
    <h3>IP Adresse : 81.169.174.67
    </h3>
</div>
<?php
else :
    header('Location: ../index.php?error=2');
endif;
?>
</body>
</html>