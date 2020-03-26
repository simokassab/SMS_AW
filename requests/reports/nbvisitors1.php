<?php
ob_start();
session_start();
include_once ('../../classes/db_connect.php');
    $mysqli = getConnected();
    $sql = "SELECT count(visitors.id) as Visitors, DATE(visitors.date) as date_ FROM visitors, campaigns where campaigns.US_ID_FK=".$_SESSION['user_id']."
                      and campaigns.active=1 and visitors.date > ( CURDATE() - INTERVAL 15 DAY ) and visitors.CAMP_ID_FK=campaigns.id group by date_";
    $Rslt = mysqli_query($mysqli,$sql);
    $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
    echo json_encode($rows);
