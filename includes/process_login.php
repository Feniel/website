<?php
include_once 'function_login.php';
include_once 'db_connect.php';

echo $_POST['email'];
echo $_POST['p'];
echo '<br>';

sec_session_start();
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; 
 
    if (login($email, $password, $mysqli) == true) { 
        header('Location: ../sites/main.php');
    } else { 
        header('Location: ../index.php?error=1');
    }
} else { 
    echo 'Invalid Request';
}