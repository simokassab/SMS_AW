<?php
header('Content-type:text/html; charset=utf-8');
include_once ('db_connect.php');

class sender {

    function insert($sender, $user_id){
        $mysqli = getConnected();
        // $query='SET CHARACTER SET utf8';
        $query= "INSERT INTO sender VALUES (NULL, '$sender', '$user_id', NOW(), 1)";
        // echo $query;
        $mysqli->query($query);
        return $mysqli->insert_id;
    }

    function getAll($us_id){
        $mysqli = getConnected();
        $sql = "Select * FROM sender where US_ID_FK='$us_id'";
        // echo $sql;
        $Rslt = mysqli_query($mysqli, $sql);
        if ($Rslt) {
            $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
            return $rows;
        } else {
            return "";
        }
    }

    function getRowByID($id)
    {
        $mysqli = getConnected();
        $query = "SELECT * FROM sender WHERE id = " . $id;
        //echo $query;
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_row($result);
        return $row;
    }





}

?>