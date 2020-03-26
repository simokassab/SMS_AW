<?php
ob_start();
session_start();
include_once('../classes/users.php');
$us= new users();
//$gr_add=$gr->update($_GET['id'], $_GET['name'], $_GET['description']);
echo $us->update($_SESSION['user_id'], $_POST['username'], $_POST['email'], $_POST['address'], $_POST['phone'], $_POST['company']);


?>