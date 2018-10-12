<?php
include_once '../includes/login/functions_login.php';
include_once '../includes/functions.php';

sec_session_start();

$user = $_SESSION['username'];

kostenUpdate();

if (isset($_POST['transaktion']) && isset($_POST['notiz'])) {
    global $db, $datum;
    $transId = getMaxTransId();
    $id = $_POST['id'];
    $date = $datum;
    $transaktion = $_POST['transaktion'];
    $notiz = $_POST['notiz'];

    $type = substr($transaktion, 0, 1);
    $length = strlen($transaktion);
    $value = substr($transaktion, 1, $length);

    if($type == "+"){
        $tmp = getGuthabenById($id);
        $guthaben = $tmp + $value;
        setGuthabenById($guthaben,$id);
    }elseif ($type == "-"){
        $tmp = getGuthabenById($id);
        $guthaben = $tmp - $value;
        setGuthabenById($guthaben,$id);
    }

    $guthabenNach = $guthaben;

    mysqli_query($mysqli, "INSERT INTO transaktion VALUES ('$transId', '$id', '$date', '$guthabenNach', '$transaktion', '$notiz')");
}
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
    if($user != "TimF"){
        header('Location: ../sites/main.php');
    }
    include '../includes/nav.php';
    ?>
    <div id="placeholder2"></div>
    <div id="placeholder3"></div>
    <div id="cont">
        <h3>Transaktion hinzufügen</h3>
        <form action="editor.php" method="post" name="test">
            <div id="colorBlack">
                <select name="id">
                    <option value="1">Tim</option>
                    <option value="2">Ricardo</option>
                    <option value="3">Marco</option>
                    <option value="4">Max</option>
                    <option value="5">Bluhm</option>
                    <option value="6">Alexej</option>
                    <option value="7">Thomas</option>
                    <option value="8">Steffan</option>
                    <option value="9">Simon</option>
                    <option value="10">Tarek</option>
                    <option value="11">TimG</option>
                    <option value="12">Kathi</option>
                    <option value="13">Micha</option>
                    <option value="14">Pascal</option>
                </select>
            </div>
            <br><br>
            <input type="text" name="transaktion" id="transaktion" class="form-control input-sm chat-input" placeholder="transaktion (+ / -)" />
            <br>
            <input type="text" name="notiz" id="notiz" class="form-control input-sm chat-input" placeholder="notiz" />
            <br>
            <input type="submit" name="proc" class="btn btn-primary btn-md" value="Proceed">
        </form>
        <br><br>
        <strong>Beispiel:</strong><br>
        Tim<br>
        +24<br>
        Jaehrliche Einzahlung<br><br>
        Keine Umlaute in der Notiz nutzen !
    </div>
<?php
else :
    header('Location: ../index.php?error=2');
endif;
?>
</body>
</html>