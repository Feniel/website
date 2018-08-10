<?php
include_once 'db_connect.php';


date_default_timezone_set("Europe/Berlin");
$timestamp = time();
$datum = date("d.m.Y - H:i", $timestamp);

$mon = @date(F);
$tag = @date(j);

$serverkosten = 1.21;
$countUser = 14;

function kostenUpdate() {
    kostenNachtragen();
    global $mysqli, $mon, $tag, $serverkosten, $countUser;
    $query = "SELECT serverkosten FROM monate WHERE monat = '$mon'";
    $ergebnis = mysqli_query($mysqli, $query);
    $tmp = mysqli_fetch_object($ergebnis)->serverkosten;
    if($tmp == 'o'){
        if($tag >= 15){
            mysqli_query($mysqli, "UPDATE monate SET serverkosten = 'x' WHERE monat = '$mon'");
            $counter = 1;
            while($counter <= $countUser){
                $tmp = getGuthabenById($counter);
                $guthaben = $tmp - $serverkosten;
                setGuthabenById($guthaben,$counter);
                $tmp = getMaxTransId();
                $monAusgabe = "15 " . $mon;
                mysqli_query($mysqli, "INSERT INTO transaktion VALUES ('$tmp', '$counter', '$monAusgabe', '$guthaben', '-1.21', 'monatliche Serverkosten')");
                $counter++;
            }
        }
    }
}

function kostenNachtragen(){
    global $mon, $mysqli, $serverkosten, $countUser;
    $query = "SELECT nr FROM monate WHERE monat = '$mon'";
    $ergebnis = mysqli_query($mysqli, $query);
    $nr = mysqli_fetch_object($ergebnis)->nr;
    $counter = 1;
    while($counter<$nr){
        $query = "SELECT serverkosten FROM monate WHERE nr = '$counter'";
        $ergebnis = mysqli_query($mysqli, $query);
        $value = mysqli_fetch_object($ergebnis)->serverkosten;
        if($value == 'o'){
            $query = "SELECT monat FROM monate WHERE nr = '$counter'";
            $ergebnis = mysqli_query($mysqli, $query);
            $tcMon = mysqli_fetch_object($ergebnis)->monat;
            mysqli_query($mysqli, "UPDATE monate SET serverkosten = 'x' WHERE monat = '$tcMon'");
            $counter2 = 1;
            while($counter2 <= $countUser){
                $tmp = getGuthabenById($counter2);
                $guthaben = $tmp - $serverkosten;
                setGuthabenById($guthaben,$counter2);
                $tmp = getMaxTransId();
                $monAusgabe = "15 " . $tcMon;
                mysqli_query($mysqli, "INSERT INTO transaktion VALUES ('$tmp', '$counter2', '$monAusgabe', '$guthaben', '-1.21', 'monatliche Serverkosten')");
                $counter2++;
            }
        }
    }
}

function getMaxTransId() {
    global $mysqli;
    $query = "SELECT MAX(transId) AS Expr FROM transaktion";
    $ergebnis = mysqli_query($mysqli, $query);
    $tmp = mysqli_fetch_object($ergebnis)->Expr;
    $tmp++;
    return $tmp;
}

function getUserId(){
    global $user,$mysqli;
    $query = "SELECT id FROM members WHERE username = '$user'";
    $ergebnis = mysqli_query($mysqli, $query);
    $id = mysqli_fetch_object($ergebnis)->id;
    return $id;
}

function getGuthabenById($id){
    global $mysqli;
    $query = "SELECT guthaben FROM members WHERE id = '$id'";
    $ergebnis = mysqli_query($mysqli, $query);
    $tmp = mysqli_fetch_object($ergebnis)->guthaben;
    return $tmp;
}

function setGuthabenById($set, $id){
    global $mysqli;
    mysqli_query($mysqli, "UPDATE members SET guthaben = '$set' WHERE id = '$id'");
}