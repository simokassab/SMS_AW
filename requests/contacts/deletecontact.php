<?php
ob_start();
session_start();
include_once('../../classes/contacts.php');
$gr= new contacts();
if(isset($_GET['id'])) {
    $gr_add=$gr->delete($_GET['id'], $_SESSION['user_id']);
   // echo $gr_add;
}

?>