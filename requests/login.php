<?php 
ob_start();
session_start();
include_once ('../classes/login.php');

$log = new login();


if (isset($_POST['btn-login'])) {
    $email = $_POST['email'];
    $upass = $_POST['pass'];
    $reslt = $log->login_($email, $upass);
    //echo $reslt;
    if($reslt=='done'){
        header("Location: ../groups.php");
    }
    elseif($reslt=='badpass'){
        header("Location: ../login.php?action=b");
    }
    else {
        header("Location: ../login.php?action=n");
    }
}
?>