<?php
include_once 'functions_login.php';

sec_session_start();
global $mysqli;

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p'];

    if (login($email, $password, $mysqli) == true) {
//        header('Location: ../../sites/main.php');
        echo "404";
    } else { 
//        header('Location: ../../index.php?error=1');
        echo "550";
    }
} else { 
    echo 'Invalid Request';
}