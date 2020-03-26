<?php
    include_once ('db_connect.php');

    class form
    {

        function insert($camp_id, $shortlink, $data, $token_id)
        {
            $mysqli = getConnected();
            $query = "INSERT INTO forms VALUES (NULL, '$camp_id', '$token_id', '$data', '$shortlink' , NOW(), 1)";
           // echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function getAllByCampID($camp_id)
        {
            $mysqli = getConnected();
            $sql = "Select * FROM forms where CAMP_ID_FK='$camp_id'  and active=1";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function getAllByCampIDTokenId($camp_id, $tokenid)
        {
            $mysqli = getConnected();
            $sql = "Select * FROM forms where CAMP_ID_FK='$camp_id'  and TOKEN_ID_FK='$tokenid' and active=1";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

    }

?>