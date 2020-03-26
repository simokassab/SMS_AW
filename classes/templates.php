<?php 
    include_once ('db_connect.php');

    class templates {

        function insert($name, $html_code, $cat_id){
            $mysqli = getConnected();
            $query = "INSERT INTO templates VALUES (NULL, '$name', '$html_code', '$cat_id', NOW(), 1)";
            echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $mysqli = getConnected();
            $stmt = $mysqli->prepare("DELETE FROM templates WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $name, $html_code, $cat_id){
            $mysqli = getConnected();
            $sql = ' UPDATE templates SET name="'.$name.'", html_code="'.$html_code.'", cat_id="'.$cat_id.'" WHERE id='.$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($conn);
            }
        }

        function getAll(){
            $mysqli = getConnected();
            $sql = "Select * FROM `templates`";
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_all($Rslt,MYSQLI_ASSOC);
            return $rows;
        }
        
        function getRowByID($id){
            $mysqli = getConnected();
            $query = "SELECT * FROM templates  WHERE id =$id  and active=1";
            //echo $query;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }

        function getRowByCatID($cat_id){
            $mysqli = getConnected();
            $query = "SELECT * FROM templates WHERE CAT_ID_FK = ".$cat_id;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_row($result);
            return $row;
        }



    }

?>