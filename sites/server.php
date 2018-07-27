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
<body>
<?php
if (login_check($mysqli) == true) :

    include '../includes/nav.php';
?>
<div id="placeholder2"></div>
<div id="placeholder3"></div>
<div id="table">
    <table class="table" style="background-color: dimgrey">
        <tr>
            <span id="head">
            <th>ID</th>
            <th>Datum</th>
            <th>Name</th>
            <th>Guthaben</th>
            <th>Transaktion</th>
            </span>
        </tr>
        <tr>
            <td>1</td>
            <td>12.3.1996</td>
            <td>Tim</td>
            <td>12€</td>
            <td style="color: red">-3.60€</td>
        </tr>
    </table>
</div>
<?php
else :
    header('Location: ../index.php?error=2');
endif;
?>
</body>
</html>