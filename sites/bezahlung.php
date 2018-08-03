<?php
include_once '../includes/login/functions_login.php';
include_once '../includes/dbconnect.php';

sec_session_start();

$user = $_SESSION['username'];
$serverkosten = 1.21;
$countUser = 14;

$query = "SELECT id FROM members WHERE username = '$user'";
$ergebnis = mysqli_query($db, $query);
$id = mysqli_fetch_object($ergebnis)->id;
$query = "SELECT guthaben FROM members WHERE id = '$id'";
$ergebnis = mysqli_query($db, $query);
$guthaben = mysqli_fetch_object($ergebnis)->guthaben;
//$query = "SELECT COUNT(id) AS Anzahl FROM transaktion WHERE id = '$id' LIMIT 12";
//$ergebnis = mysqli_query($db, $query);
//$anzahl = mysqli_fetch_object($ergebnis)->Anzahl;
$query = "SELECT transId, datum, guthabenNach, transaktion, notiz FROM transaktion WHERE id = '$id' LIMIT 10";
$ergebnis = mysqli_query($db, $query);

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
    <script src="../includes/bezahlung.js"></script>
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
            <th>Transaktions ID</th>
            <th>Datum</th>
            <th>Guthaben</th>
            <th>Transaktion</th>
            <th>Notiz</th>
            </span>
        </tr>
            <?php
            while($row = mysqli_fetch_array( $ergebnis , MYSQLI_ASSOC )){
                echo "<tr><td>";
                echo $row['transId'];
                echo "</td><td>";
                echo $row['datum'];
                echo "</td><td>";
                $tmp = substr($row['guthabenNach'], 0, 1);
                if($row['guthabenNach'] >= 0){
                    echo "<span id='green'>". $row['guthabenNach'] ." €</span>";
                }else{
                    echo "<span id='red'>". $row['guthabenNach'] ." €</span>";
                }
                echo "</td><td>";
                echo $row['transaktion'];
                echo "</td><td>";
                echo $row['notiz'];
                echo "</td></tr>";
            }
            ?>
    </table>
</div>
<div id="placeholder4"></div>
<div id="output">
    <h3>Aktuelles Guthaben:
        <?php
            if($guthaben >= 0){
                echo "<span id='green'>". $guthaben ." €</span>";
            }else{
                echo "<span id='red'>". $guthaben ." €</span>";
            }
        ?>
    </h3>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var username = "<?php echo $user; ?>";
        var id = <?php echo $id; ?>;
    });
</script>
<?php
else :
    header('Location: ../index.php?error=2');
endif;
?>
</body>
</html>