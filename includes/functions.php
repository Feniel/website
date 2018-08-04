<?php
include_once '../includes/dbconnect.php';


date_default_timezone_set("Europe/Berlin");
$timestamp = time();
$datum = date("d.m.Y - H:i", $timestamp);

$mon = @date(F);
$tag = @date(j);

function getId() {
    $i = 1;
    while (file_exists("../media/cont/thumbs/thumb"+ $i +".gif")) {
        $i++;
    }
    return $i;
}

function kostenUpdate() {
    kostenNachtragen();
    global $db, $mon, $tag, $user;
    $serverkosten = 1.21;
    $countUser = 14;
    $query = "SELECT serverkosten FROM monate WHERE monat = '$mon'";
    $ergebnis = mysqli_query($db, $query);
    $tmp = mysqli_fetch_object($ergebnis)->serverkosten;
    if($tmp == 'o'){
        if($tag >= 15){
            mysqli_query($db, "UPDATE monate SET serverkosten = 'x' WHERE monat = '$mon'");
            $counter = 1;
            while($counter <= $countUser){
                $query = "SELECT guthaben FROM members WHERE id = '$counter'";
                $ergebnis = mysqli_query($db, $query);
                $tmp = mysqli_fetch_object($ergebnis)->guthaben;
                $guthaben = $tmp - $serverkosten;
                mysqli_query($db, "UPDATE members SET guthaben = '$guthaben' WHERE id = '$counter'");
                $query = "SELECT id FROM members WHERE username = '$user'";
                $ergebnis = mysqli_query($db, $query);
                $id = mysqli_fetch_object($ergebnis)->id;
                $query = "SELECT MAX(transId) AS Expr FROM transaktion";
                $ergebnis = mysqli_query($db, $query);
                $tmp = mysqli_fetch_object($ergebnis)->Expr;
                $tmp++;
                $monAusgabe = "15 " . $mon;
                mysqli_query($db, "INSERT INTO transaktion VALUES ('$tmp', '$id', '$monAusgabe', '$guthaben', '-1.21', 'monatliche Serverkosten')");
                $counter++;
            }
        }
    }
}

function kostenNachtragen(){
    global $mon, $db;
    $query = "SELECT nr FROM monate WHERE monat = '$mon'";
    $ergebnis = mysqli_query($db, $query);
    $tmp = mysqli_fetch_object($ergebnis)->nr;
}