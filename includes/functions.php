<?php
include_once 'db_connect.php';



//Datumeinstellungen
date_default_timezone_set("Europe/Berlin");
$timestamp = time();
$datum = date("d.m.Y - H:i", $timestamp);

//Nur der Monat
$mon = @date(F);
//Nur der Tag
$tag = @date(j);

//Die Standart Serverkosten pro Monat
$serverkosten = 1.21;
//Die Anzahl der User
$countUser = 14;


/*
 * Wird aufgerufen um jedem User die monatlichen Serverkossten vom Guthaben zu subtrahieren.
 */
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

/*
 * Prüft ab August durch ob dem entsprechenden Monat schon kostenUpdate ausgeführt wurde und führt es gegebenenfalls aus.
 */
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
        $counter++;
    }
}

/*
 * Gibt die maximale Transaktions ID aus der trasnaktions Tabelle aus.
 */
function getMaxTransId() {
    global $mysqli;
    $query = "SELECT MAX(transId) AS Expr FROM transaktion";
    $ergebnis = mysqli_query($mysqli, $query);
    $tmp = mysqli_fetch_object($ergebnis)->Expr;
    $tmp++;
    return $tmp;
}

/*
 * Gibt anhand der aus dem cookie entnommenden usernamen die id aus
 */
function getUserId(){
    global $user,$mysqli;
    $query = "SELECT id FROM members WHERE username = '$user'";
    $ergebnis = mysqli_query($mysqli, $query);
    $id = mysqli_fetch_object($ergebnis)->id;
    return $id;
}

/*
 * Gibt das aktuelle Guthaben anhand der id aus.
 *
 * @param id die id dessen guthaben ausgegeben werden soll
 */
function getGuthabenById($id){
    global $mysqli;
    $query = "SELECT guthaben FROM members WHERE id = '$id'";
    $ergebnis = mysqli_query($mysqli, $query);
    $tmp = mysqli_fetch_object($ergebnis)->guthaben;
    return $tmp;
}

/*
 * Setzt das guthaben anhand der id
 *
 * @param set der wert auf den das guthaben gesetzt werden soll
 *
 * @param id die id dessen guthaben geändert werden soll
 */
function setGuthabenById($set, $id){
    global $mysqli;
    mysqli_query($mysqli, "UPDATE members SET guthaben = '$set' WHERE id = '$id'");
}