<?php
    include_once ('db_connect.php');

    class events
    {

        function insert($event, $camp_id, $token_id)
        {
            $mysqli = getConnected();
            $query = "INSERT INTO events VALUES (NULL, '$camp_id', '$token_id', '$event', 0,  NOW(), 1)";
           // echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function updateEnded($id, $ended)
        {
            $mysqli = getConnected();
            $sql = ' UPDATE events SET ended="' . $ended. '" WHERE id=' . $id;
           // echo $sql;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function getAll()
        {
            $mysqli = getConnected();
            $sql = "Select * FROM events where active=1";
            // echo $sql;
            $Rslt = mysqli_query($mysqli, $sql);
            if ($Rslt) {
                $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
                return $rows;
            } else {
                return "";
            }
        }

        function getCountByEvent($event, $camp_id)
        {
            $mysqli = getConnected();
            $sql = "select count(id) as CNT from events where event='$event' and CAMP_ID_FK=$camp_id and active=1";
            // echo $sql;
            $result = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_array($result);
            return $row[0];
        }

        function getCountByEventByToken($event, $camp_id, $tokenid)
        {
            $mysqli = getConnected();
            $sql = "select count(id) as CNT from events where event='$event' and  TOKEN_ID_FK='$tokenid' and CAMP_ID_FK=$camp_id and active=1";
            // echo $sql;
            $result = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_array($result);
            return $row[0];
        }

        function getCountYTEnded($camp_id)
        {
            $mysqli = getConnected();
            $sql = "select count(id) as CNT from events where event='YTPLAYED' and ended=1 and CAMP_ID_FK=$camp_id and active=1";
            $result = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_array($result);
            return $row[0];
        }

        function getCountYTEndedByToken($camp_id, $tokenid)
        {
            $mysqli = getConnected();
            $sql = "select count(id) as CNT from events where event='YTPLAYED' and ended=1 and TOKEN_ID_FK='$tokenid' and CAMP_ID_FK=$camp_id and active=1";
            $result = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_array($result);
            return $row[0];
        }


    }

?>