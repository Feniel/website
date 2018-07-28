<?php
/**
 * Das sind die Login-Angaben für die Datenbank
 */
define("host", "localhost");     // Der Host mit dem du dich verbinden willst.
define("username", "test");    // Der Datenbank-Benutzername.
define("passwort", "hallo123");    // Das Datenbank-Passwort.
define("datenbank", "server");    // Der Datenbankname.

$db = mysqli_connect(host, username, passwort, datenbank);