<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('../../classes/campaigns.php');
include_once('../../classes/queue.php');

$campaign= new campaigns();
$queue= new queue();
$campaign->delete($_POST['campid']);
$queue->deleteByCampID($_POST['campid']);
?>