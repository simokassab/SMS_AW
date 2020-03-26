<?php
ob_start();
session_start();
include_once('../../classes/contacts.php');
$cr= new contacts();
$groups = $_GET['groups'];
$grs='';
$grps= explode(',' , $groups);
foreach ($grps as $g){
    $s = $cr->checkExisting($_GET['msisdn'], $_SESSION['user_id'], $g);
    if ($s == 'OK'){
        $cr_add=$cr->insert($_GET['fname'], $_GET['lname'], $_GET['email'], $_GET['address'], $_GET['gender'], $g.',', $_GET['msisdn'], $_GET['user_id']);
        echo $cr_add;
    }
    else {
        echo $s;
    }
}

//$s = $cr->checkExisting($_GET['msisdn'], $_SESSION['user_id'], $_GET['groups']);


?>