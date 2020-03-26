<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('../../classes/campaigns.php');
include_once('../../classes/land_page.php');
include_once('../../classes/links.php');
$cmp= new campaigns();
$land_page = new land_page();

$link= new links();
$template=$_POST['template'];
$host= $_SERVER['SERVER_NAME'].'/SMS/grapjs/index.php';
$status='progress';
if($_SESSION['filter']==1)
    //$camp_id = $cmp->insert($_POST['campname'], $_POST['camptype'], '', $_SESSION['user_id'], 0, 0,'', '', '' ,   $status, 1);
 $camp_id = $cmp->insertJobs($_POST['campname'], $_POST['camptype'], '' , '', $_SESSION['user_id'], $_SESSION['weight'], 0, 0,'', '', '' ,
  '', 'ONGOING', 1);
else
    $camp_id = $cmp->insertJobs($_POST['campname'], $_POST['camptype'], '' , '', $_SESSION['user_id'], $_SESSION['weight'], 0, 0,'', '', '' ,
       '', 'WAITING', 0);
$land_page_id = $land_page->insert('', '', '', '', 0, $camp_id);
$parameters='campid='.$camp_id."&landid=".$land_page_id."&camptype=".$_POST['camptype'];
$shortlinkid = $link->insertName($host, $parameters);
echo $link->getLinkByID($shortlinkid);
?>


