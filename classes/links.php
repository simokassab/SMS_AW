<?php
include_once ('db_connect.php');

class links
{

    function insert($host, $parameters)
    {
        check:
        $perm='MK'.rand(100000, 999999);
        $mysqli = getConnected();
        $query="select id from links where shortlink='".$perm."' ";
        $result = mysqli_query($mysqli, $query);
        $row   = mysqli_fetch_row($result);
        if(!$row[0]){
            $query = "INSERT INTO links VALUES (NULL, '$perm', '$host', '$parameters',  NOW(), 1)";
            //echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }
        else {
            goto check;
        }

    }

    function generateRandomString($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function insertName($host, $parameters)
    {
        check:
        $perm=$this->generateRandomString(4);
        $mysqli = getConnected();
        $query1="select id from links where shortlink='".$perm."' ";
        $result = mysqli_query($mysqli, $query1);
        //echo $query1;
        $row   = mysqli_fetch_row($result);
        if(!$row[0]){
            $query = "INSERT INTO links VALUES (NULL, '$perm', '$host', '$parameters',  NOW(), 1)";
         //   echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }
        else {
            goto check;
        }

    }

    function getLinkByID($id){
        $mysqli = getConnected();
        $query = "SELECT shortlink FROM links WHERE id = ".$id;
        $result = mysqli_query($mysqli, $query);
        $row   = mysqli_fetch_row($result);
        return $row[0];
    }

    function parByShortLink($shortlink){
        $mysqli = getConnected();
        $query = "SELECT parameters FROM links WHERE shortlink ='".$shortlink."'";
        $result = mysqli_query($mysqli, $query);
        $row   = mysqli_fetch_row($result);
        return $row[0];
    }
    function getLinkByCampID($camp_id)
    {
        $mysqli = getConnected();
        $sql = "SELECT shortlink from links where parameters LIKE '%$camp_id%' and active=1";
        // echo $sql;
        $result = mysqli_query($mysqli, $sql);
        $row   = mysqli_fetch_row($result);
        return $row[0];
    }

}
?>