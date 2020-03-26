<?php 
header('Content-type:text/html; charset=utf-8');
    include_once ('db_connect.php');

    class groups {

        function insert($name, $description, $user_id){
            $mysqli = getConnected();
           // $query='SET CHARACTER SET utf8'; 
            $query= "INSERT INTO groups VALUES (NULL, '$name', '$description', '$user_id', NOW(), 1)";
           // echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $mysqli = getConnected();
            $stmt = $mysqli->prepare("update groups SET active=0 WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $name, $description){
            $mysqli = getConnected();
            $sql = ' UPDATE groups SET name="'.$name.'", description="'.$description.'" WHERE id='.$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function getAll($userid){
            $mysqli = getConnected();
            $sql = "Select * FROM `groups` where US_ID_FK=".$userid." and active=1";
           // echo $sql;
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
            return $rows;
        }
        

        function getRowByID($id){
            $mysqli = getConnected();
            $query = "SELECT * FROM groups WHERE id = ".$id." and active=1";
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }

        function getRowByUserID($user_id){
            $mysqli = getConnected();
            $query = "SELECT * FROM groups WHERE US_ID_FK = ".$user_id." and active=1";
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }
        
    }

?>