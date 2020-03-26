<?php 
    include_once ('db_connect.php');

    class categories {

        function insert($name){
            $mysqli = getConnected();
            $query = "INSERT INTO categories VALUES (NULL, '$name', NOW(), 1)";
            echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $mysqli = getConnected();
            $stmt = $mysqli->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $name){
            $mysqli = getConnected();
            $sql = ' UPDATE categories SET name="'.$name.'" WHERE id='.$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function getAll(){
            $mysqli = getConnected();
            $sql = "Select * FROM `categories`";
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_object($Rslt);
            return $rows;
        }
        
        function getRowByID($id){
            $mysqli = getConnected();
            $query = "SELECT * FROM categories WHERE id = ".$id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }

        function getNameByID($id){
            $mysqli = getConnected();
            $query = "SELECT name FROM categories WHERE id = ".$id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row[0];
        }
        
    }

?>