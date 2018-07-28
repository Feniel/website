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

<center>Auf dieser Seite können leider noch keine Daten angeboten werden.<br>
Mit freundlichen Grüßen ihr LeNerds Tech Support</center>

<?php
else :
    header('Location: ../index.php?error=2');
endif;
?>
</body>
</html>