<?php
session_start();
header('Content-Type: text/event-stream'); // mandatory headers for SSE to work
header('Cache-Control: no-cache'); // mandatory headers for SSE to work



include_once('classes/campaigns.php');

$camp = new campaigns();
$us_id = $_GET['US_ID'];
$job_id = $_GET['job_id'];
$data = array();
$data   = $camp->getProgressByUSID($us_id, $job_id);
    $total = $data['CNT'];
    $i = $data['REM'];
    echo 'data:' . $total ."-".$i."\n\n";
     echo "\n\n";
    ob_flush();
    flush();
    usleep(100000); // sleep 0.5s for the exemple purpose

//}

