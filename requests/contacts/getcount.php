<?php
ob_start();
session_start();
include_once('../../classes/contacts.php');
$cr= new contacts();
if(isset($_POST['groups'])){
    $grps=$_POST['groups'];
//print_r($grps);
//echo (sizeof($grps));
    $count=0;
    $where='';
    if (sizeof($grps) > 1) {
        foreach($grps as $gr){
            $where.=" GRS_ID_FK like '%".$gr.",%' OR";

        }
        $where=preg_replace('/OR$/', '', $where);
        $where.=" )";
        $temp = $cr->getContactsCountByGRID($_SESSION['user_id'], $where);
        $count=$count + $temp[0];
    }
    else {
        $where="GRS_ID_FK like '%".$grps[0].",%'";
        // $where.=" and active=1";
        $where.=" )";
        $temp = $cr->getContactsCountByGRID($_SESSION['user_id'], $where);
        $count=$count + $temp[0];
    }

    echo $count;
}
else {
    echo 0;
}


?>