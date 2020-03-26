<?php
ob_start();
session_start();
include_once('../../classes/groups.php');
$gr= new groups();
if((isset($_GET['name'])) && (isset($_GET['description'])) && (isset($_GET['id']))) {
    $gr_add=$gr->update($_GET['id'], $_GET['name'], $_GET['description']);
   // echo $gr_add;
}

?>