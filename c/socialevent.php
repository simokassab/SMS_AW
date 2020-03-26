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

if($_POST['social']=="facebook"){
    echo $events->insert('FACEBOOK',$campid, $_POST['tokenid'] );
}
else if($_POST['social']=="twitter"){
    echo $events->insert('TWITTER',$campid, $_POST['tokenid'] );
}

else if($_POST['social']=="insta"){
    echo $events->insert('INSTAGRAM',$campid, $_POST['tokenid'] );
}

else {
    echo $events->insert('LINKEDIN',$campid, $_POST['tokenid'] );
}


?>