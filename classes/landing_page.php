<?php 
    include_once ('./config/db_connect.php');

    class landing_page {

        function insert($name, $html_code, $expiry_date, $published, $user_id){
            $query = "INSERT INTO landing_page VALUES (NULL, '$name', '$html_code', '$expiry_date', '$published', '$user_id', NOW(), 1)";
            echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $stmt = $mysqli->prepare("DELETE FROM landing_page WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $name, $html_code, $expiry_date, $published){
            $sql = ' UPDATE landing_page SET name="'.$name.'", html_code="'.$html_code.'", expiry_date="'.$expiry_date.'", published="'.$published.'" WHERE id='.$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function getAll(){
            $sql = "Select * FROM `landing_page`";
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_object($Rslt);
            return $rows;
        }
        

        function getRowByID($id){
            $query = "SELECT * FROM landing_page WHERE id = ".$id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }

        function getRowByUserID($user_id){
            $query = "SELECT * FROM landing_page WHERE US_ID_FK = ".$user_id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }
        
    }

?>