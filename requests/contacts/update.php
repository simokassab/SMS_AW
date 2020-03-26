<?php
ob_start();
session_start();
include_once('../../classes/contacts.php');
$cr= new contacts();
//insert($fname, $lname, $email, $address, $gender, $groups, $msisdn, $user_id)
    $cr_add=$cr->update($_GET['fname'], $_GET['lname'], $_GET['email'], $_GET['address'], $_GET['gender'], $_GET['groups'], $_GET['msisdn'], $_GET['user_id'], $_GET['id']);


?>