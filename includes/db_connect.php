<?php
/**
 * Das sind die Login-Angaben für die Datenbank
 */

define("HOST", "localhost");     // Der Host mit dem du dich verbinden willst.
define("USER", "user");    // Der Datenbank-Benutzername.
define("PASSWORD", "hallo123");    // Das Datenbank-Passwort.
define("DATABASE", "website");    // Der Datenbankname.

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
