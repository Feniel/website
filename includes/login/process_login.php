<?php
include_once 'functions_login.php';
include_once 'dbconnect_login.php';

sec_session_start();
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p'];

    if (login($email, $password, $mysqli) == true) {
        header('Location: ../../sites/main.php');
    } else { 
        header('Location: ../../index.php?error=1');
    }
} else { 
    echo 'Invalid Request';
}