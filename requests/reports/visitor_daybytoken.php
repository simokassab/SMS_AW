<?php
ob_start();
session_start();


include_once ('../../classes/visitors.php');
$mysqli = getConnected();

$visitor1 = new visitors();
if($_GET['p']=='reports'){
    $nbcamp = $visitor1->getVisitorsPerday($_SESSION['user_id']);
}
else {
    $nbcamp = $visitor1->getVisitorsPerdayByCampSendtype($_SESSION['user_id'], $_GET['campid'], $_GET['tokenid']);
}



echo $nbcamp[0]['nb'].'<i class="fas fa-eye" style="font-size: 32px; opacity: 0.5; margin-left: 4%;"></i>';
