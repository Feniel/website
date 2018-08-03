<?php
/**
 * Das sind die Login-Angaben für die Datenbank
 */

define("HOST", "localhost");     // Der Host mit dem du dich verbinden willst.
define("USER", "test");    // Der Datenbank-Benutzername.
define("PASSWORD", "hallo123");    // Das Datenbank-Passwort.
define("DATABASE", "secure_login");    // Der Datenbankname.

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);