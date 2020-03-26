<?php
include_once('db_connect.php');

class contacts
{

    function generateContactToken($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function insert($fname, $lname, $email, $address, $gender, $groups, $msisdn, $user_id)
    {
        $mysqli = getConnected();
        $token = $this->generateContactToken(6);
        $query = "INSERT INTO contacts_$user_id VALUES (NULL, '$fname', '$lname', '$email', '$gender', '$address', '$msisdn', '$groups', '$token', NOW(), 1)";
        // echo $query;
        $mysqli->query($query);
        $inserted = $mysqli->insert_id;
        // $query1 = "INSERT INTO token_contact VALUES (NULL, '$token','$user_id' , '$inserted', NOW(), 1)";
        ///   $mysqli->query($query1);
        return $inserted;
    }

    function checkExisting($msisdn, $userid, $grs)
    {
        $cnt = 0;
        $mysqli = getConnected();
        $sql = "Select * FROM `contacts_$userid` where msisdn='$msisdn'";
        $Rslt = mysqli_query($mysqli, $sql);
        if ($Rslt) {
            $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
            if (empty($rows)) {
                return 'OK'; //not found
            } else { // if found
                $sqll = "Select * FROM `contacts_$userid` where msisdn='$msisdn' and active=0";
                $Rsltt = mysqli_query($mysqli, $sqll);
                if ($Rsltt) {
                    $cnt = mysqli_num_rows($Rsltt);
                    $rowss = mysqli_fetch_all($Rsltt, MYSQLI_ASSOC);
                    if (!empty($rowss)) { // if found and active =0
                        $ss = 1;
                        $grs.=",";
                        $stmt = $mysqli->prepare("UPDATE contacts_$userid SET active=? , GRS_ID_FK=? WHERE   msisdn='$msisdn'"); //set active =1
                        $stmt->bind_param('is', $ss, $grs);
                        $stmt->execute();
                        $stmt->close();
                        return "U-";
                    } else { // if found and active = 1
                        $sql1 = "Select * FROM `contacts_$userid` where msisdn='$msisdn' and GRS_ID_FK like '%$grs%' ";
                        //echo $sql1;
                        $Rslt1 = mysqli_query($mysqli, $sql1);
                        $rows1 = mysqli_fetch_all($Rslt1, MYSQLI_ASSOC);
                        if (empty($rows1)) {
                            $old_grps = $rows[0]['GRS_ID_FK'];
                            $new_groups = $old_grps . $grs . ',';
                            $stmt = $mysqli->prepare("UPDATE contacts_$userid SET GRS_ID_FK=? WHERE   msisdn='$msisdn'");
                            $stmt->bind_param('s', $new_groups);
                            $stmt->execute();
                            $stmt->close();
                            return 'UDPATED';
                        } else { //found number and same group
                            return 'NOTHING';
                        }
                    }
                }
            }
        } else {
            return 'Error';
        }
    }

    function checkExistingGr($msisdn, $userid, $grs)
    {
        $cnt = 0;
        $mysqli = getConnected();
        $sql = "Select * FROM `contacts_$userid` where msisdn='$msisdn'";
        $Rslt = mysqli_query($mysqli, $sql);
        if ($Rslt) {
            $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
            if (empty($rows)) {
                return 'OK'; //not found
            } else { // if found
                $sqll = "Select * FROM `contacts_$userid` where msisdn='$msisdn' and active=0";
                $Rsltt = mysqli_query($mysqli, $sqll);
                if ($Rsltt) {
                    $cnt = mysqli_num_rows($Rsltt);
                    $rowss = mysqli_fetch_all($Rsltt, MYSQLI_ASSOC);

                    if (!empty($rowss)) { // if found and active =0
                        $ss = 1;
                        $grp = $rowss[0]['GRS_ID_FK'];
                        //  echo "old: ".$rowss[0]['GRS_ID_FK'];
                        $gr = $grp . $grs . ",";
                        //  echo "<br>new: ".$gr;
                        $stmt = $mysqli->prepare("UPDATE contacts_$userid SET active=? , GRS_ID_FK=? WHERE   msisdn='$msisdn'"); //set active =1
                        $stmt->bind_param('is', $ss, $gr);
                        $stmt->execute();
                        $stmt->close();
                        return "U-";
                    } else { // if found and active = 1
                        $sql1 = "Select * FROM `contacts_$userid` where msisdn='$msisdn' and GRS_ID_FK like '%$grs%' ";
                        //echo $sql1;
                        $Rslt1 = mysqli_query($mysqli, $sql1);
                        $rows1 = mysqli_fetch_all($Rslt1, MYSQLI_ASSOC);
                        if (empty($rows1)) {
                            $old_grps = $rows[0]['GRS_ID_FK'];
                            $new_groups = $old_grps . $grs . ',';
                            $stmt = $mysqli->prepare("UPDATE contacts_$userid SET GRS_ID_FK=? WHERE   msisdn='$msisdn'");
                            $stmt->bind_param('s', $new_groups);
                            $stmt->execute();
                            $stmt->close();
                            return 'U-';
                        } else { //found number and same group
                            return 'NOTHING';
                        }
                    }
                }
            }
        } else {
            return 'Error';
        }
    }

    function delete($id, $user_id)
    {
        $mysqli = getConnected();
      //  $grs="";
        $stmt = $mysqli->prepare("UPDATE contacts_$user_id SET active=0 , GRS_ID_FK='' WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        /*$sql = "delete from contacts_$user_id  WHERE id=" . $id;
        // echo $sql;
        if (mysqli_query($mysqli, $sql)) {
            return true;
        } else {
            return "Error updating record: " . mysqli_error($mysqli);
        }*/
    }

    function update($fname, $lname, $email, $address, $gender, $groups, $msisdn, $user_id, $id)
    {
        $mysqli = getConnected();
        $sql = ' UPDATE contacts_' . $user_id . ' SET firstname="' . $fname . '", lastname="' . $lname . '", email="' . $email . '", 
            address="' . $address . '", gender="' . $gender . '", GRS_ID_FK="' . $groups . '", MSISDN="' . $msisdn . '" WHERE id=' . $id;
        // echo $sql;
        if (mysqli_query($mysqli, $sql)) {
            return true;
        } else {
            return "Error updating record: " . mysqli_error($mysqli);
        }
    }

    function updateGrInContact($gr_id, $user_id, $id)
    {
        $mysqli = getConnected();
        // if($gr_id==""){
        //   $sql = ' UPDATE contacts_'.$user_id.' SET active=0 WHERE id='.$id;
        //  }
        //  else {
        $sql = ' UPDATE contacts_' . $user_id . ' SET  GRS_ID_FK="' . $gr_id . '" WHERE id=' . $id;
        //  }
        // echo $sql."<br/>";
        if (mysqli_query($mysqli, $sql)) {
            return true;
        } else {
            return "Error updating record: " . mysqli_error($mysqli);
        }
    }

    function getAll($userid)
    {
        $mysqli = getConnected();
        $sql = "Select * FROM `contacts_$userid` where active=1 and GRS_ID_FK<>''";
        //echo $sql;
        $Rslt = mysqli_query($mysqli, $sql);
        if ($Rslt) {
            $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
            return $rows;
        } else {
            return "";
        }

    }

    function getRowByGRID($gr_id, $userid)
    {
        $mysqli = getConnected();
        $query = "SELECT * FROM contacts_$userid WHERE GRS_ID_FK LIKE '%" . $gr_id . ",%'  and active=1";
       // echo $query;
        $Rslt = mysqli_query($mysqli, $query);

        $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
        return $rows;
    }

    function getMSISDNByGRID($userid, $where)
    {
        $mysqli = getConnected();
        $query = "SELECT DISTINCT MSISDN, token as TOK  FROM contacts_$userid WHERE active ='1' and ( $where ";

        //  echo $query;
        $Rslt = mysqli_query($mysqli, $query);
        $rows = mysqli_fetch_all($Rslt, MYSQLI_ASSOC);
        return $rows;
    }

    function getRowByID($id, $userid)
    {
        $mysqli = getConnected();
        $query = "SELECT * FROM contacts_$userid WHERE id = " . $id . " and active=1";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function getRowByUserID($user_id)
    {
        $mysqli = getConnected();
        $query = "SELECT * FROM groups WHERE US_ID_FK = " . $user_id . " and active=1";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_row($result);
        return $row;
    }

    function getContactsCountByGRID($userid, $where)
    {
        $mysqli = getConnected();
        $query = "SELECT count(id) as CNT FROM contacts_$userid WHERE active ='1' and ( $where";
        //echo $query;
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_row($result);
        return $row;
    }
}

?>