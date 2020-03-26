<?php
header('Content-type:text/html; charset=utf-8');
include_once ('db_connect.php');

class credits {

    function insert($credits, $user_id){
        $mysqli = getConnected();
        // $query='SET CHARACTER SET utf8';
        $query= "INSERT INTO credits VALUES (NULL, '$credits', '$user_id', NOW(), 1)";
        // echo $query;
        $mysqli->query($query);
        return $mysqli->insert_id;
    }

    function insertLogs($credits, $user_id){
        $mysqli = getConnected();
        // $query='SET CHARACTER SET utf8';
        $query= "INSERT INTO credits_logs VALUES (NULL, '$user_id', '$credits', NOW(), 1)";
        // echo $query;
        $mysqli->query($query);
        return $mysqli->insert_id;
    }


    function update($credit, $user_id){
        $mysqli = getConnected();
        $sql = ' UPDATE `credits` SET credit = credit - '.$credit.' WHERE US_ID_FK='.$user_id;
      //  echo $sql;
        if (mysqli_query($mysqli, $sql)) {
            return true;
        } else {
            return "Error updating record: " . mysqli_error($mysqli);
        }
    }
    function getRowByUserID($user_id){
        $mysqli = getConnected();
        $query = "SELECT * FROM credits WHERE US_ID_FK = ".$user_id." and active=1";
        $result = mysqli_query($mysqli, $query);
        $row   = mysqli_fetch_row($result);
        return $row;
    }

}

?>