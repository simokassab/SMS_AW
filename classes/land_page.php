<?php
include_once ('db_connect.php');

class land_page
{

    function insert($name, $htmlcode, $link, $expiry_date, $published, $campid)
    {
        $mysqli = getConnected();
        $query = "INSERT INTO landing_page VALUES (NULL, '$name', '$htmlcode', '$link', '$expiry_date', $published, $campid,   NOW(), 1)";
        //echo $query;
        $mysqli->query($query);
        return $mysqli->insert_id;
    }


    function update($name, $htmlcode, $link, $expiry_date, $published, $landid)
    {
        $mysqli = getConnected();
        $query = "UPDATE `landing_page` SET `name` = '$name', `html_code` = '$htmlcode', `link` = '$link', `expiry_date` = '$expiry_date', `published` = '$published' WHERE `landing_page`.`id` =$landid ;";
        //echo $query;
        $query1 = "set GLOBAL max_allowed_packet := (2048*1024*1024)";
        mysqli_query($mysqli, $query1);
        if (mysqli_query($mysqli, $query)) {
            return true;
        } else {
            return "Error updating record: " . mysqli_error($mysqli);
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

}
?>