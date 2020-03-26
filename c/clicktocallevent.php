<?php
ob_start();
session_start();
include_once "../classes/events.php";
include_once "../classes/links.php";

$events = new events();
$links = new links();

    $filename= $_POST['filename'];
    $parameters= $links->parByShortLink($filename);
    $par = explode("&", $parameters);
    $par1=explode("=", $par[0]);
    $campid=$par1[1]; //camp id
    echo $events->insert('CLICKTOCALL', $campid, $_POST['tokenid'] );

?>