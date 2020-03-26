<?php 
ob_start();
session_start();
session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['created_at']);

header("Location: ../index.php");
?>