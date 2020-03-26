<?php
ob_start();
session_start();
include_once('../../classes/groups.php');
include_once('../../classes/contacts.php');
$gr= new groups();
$cr= new contacts();
$rep='';
if(isset($_GET['id'])) {
    $contacts=$cr->getRowByGRID($_GET['id'], $_SESSION['user_id']);
   // print_R($contacts);
    echo "ID=". $_GET['id']."<br/>";
        foreach($contacts as $c){
            echo $c['GRS_ID_FK']."<br/>";
            $rep = str_replace($_GET['id'].",","", $c['GRS_ID_FK']);
            $cr->updateGrInContact($rep, $_SESSION['user_id'], $c['id']);
        }
    $gr_add=$gr->delete($_GET['id']);
   // echo $gr_add;
}

?>