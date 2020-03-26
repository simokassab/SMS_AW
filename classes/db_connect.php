<?php 
include_once ('DB.php');
function getConnected() {
    $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    $mysqli->set_charset('utf8');
    if($mysqli->connect_error) 
      die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    return $mysqli;
 }

?>