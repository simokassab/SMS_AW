<?php
ob_start();
session_start();
header("Content-type: text/json");
include_once ('../../classes/db_connect.php');
$mysqli = getConnected();
if($_GET['p']=='camp'){
    $sql1 = "select  count(visitors.id) as visitor from visitors, campaigns WHERE campaigns.active=1 and campaigns.US_ID_FK=".$_SESSION['user_id']." 
             and campaigns.id=".$_GET['campid']."    and campaigns.id=visitors.CAMP_ID_FK 
                      and DATE(visitors.date)=CURRENT_DATE ";
}
else {
    $sql1 = "select  count(visitors.id) as visitor from visitors, campaigns WHERE campaigns.active=1 and campaigns.US_ID_FK=".$_SESSION['user_id']." and campaigns.id=visitors.CAMP_ID_FK 
                      and DATE(visitors.date)=CURRENT_DATE ";
}


$Rslt1 = mysqli_query($mysqli,$sql1);
while($row = $Rslt1->fetch_array()){

    $rows[] = $row;
}
foreach($rows as $row){

    $datetime = time()  * 1000;

    $temp = floatval($row['visitor']);

    $data = array($datetime, $temp);
}

echo(json_encode($data));


?>

