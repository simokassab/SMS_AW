<?php 
include_once ('db_connect.php');

    class users {

        function insert($full_name, $username, $email, $password, $address, $phone, $company, $photo){
            $mysqli = getConnected();
            $query = "INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `address`, `phone`, `company`, `photo`, `active`, `created_at`) 
            VALUES (NULL, '$full_name', '$username', '$email', '$password', '$address', '$phone', '$company', '$photo', '0', NOW());";
            //echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function insert_status($user, $status, $notes){
            $mysqli = getConnected();
            $query = "INSERT INTO `users_status` (`id`, `US_ID`, `status`, `notes`) 
            VALUES (NULL, '$user', '$status', '$notes');";
            //echo $query;
            $mysqli->query($query);
            return $mysqli->insert_id;
        }

        function delete($id){
            $mysqli = getConnected();
            $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute(); 
            $stmt->close();
        }

        function update($id, $username, $email, $address, $phone, $company){
            $mysqli = getConnected();
            $sql = "UPDATE `users` SET `username` = '$username', `email` = '$email', `address` = '$address', `phone` = '$phone', 
                `company` = '$company' WHERE `users`.`id` = ".$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function getOldPassword($user){
            $mysqli = getConnected();
            $query = "SELECT password FROM users WHERE id = ".$user." and active=1";
            //echo $query;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_assoc($result);
            return $row['password'];
        }

        function changepassword($pass, $userid){
            $mysqli = getConnected();
            $sql = "UPDATE `users` SET   `password` = '$pass' WHERE `users`.`id` = ".$userid;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function getAll(){
            $mysqli = getConnected();
            $sql = "Select * FROM `users` where active=1";
            $Rslt = mysqli_query($mysqli,$sql);

            $rows=mysqli_fetch_object($Rslt);
            return $rows;
        }
        

        function getRowByID($id){
            $mysqli = getConnected();
            //echo $mysqli;
            $query = "SELECT * FROM users WHERE id = ".$id." and active=1";
            //echo $query;
            $result = mysqli_query($mysqli, $query);
            $row   = mysqli_fetch_assoc($result);
            return $row;
        }

        function deactivate ($id){
            $mysqli=getConnected();
            $sql = "UPDATE `users` SET `active` = 0 WHERE `users`.`id` = ".$id;
            if (mysqli_query($mysqli, $sql)) {
                return true;
            } else {
                return "Error updating record: " . mysqli_error($mysqli);
            }
        }

        function checkuser($email){
            $mysqli = getConnected();
            $stmt = $mysqli->prepare('SELECT id, password FROM users WHERE email = ?');
            // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
            $stmt->bind_param('s', $email);
            $stmt->execute(); 
            $stmt->store_result(); 
            if ($stmt->num_rows > 0) {
                return true;
            }
            else {
                return false;
            }
        }

        function  createContactTable($user_id){
            $mysqli=getConnected();
            $sql="CREATE TABLE `contacts_".$user_id."` (
                `id` int(10) NOT NULL AUTO_INCREMENT, `firstname` varchar(191) DEFAULT NULL,
                `lastname` varchar(191)  DEFAULT NULL,
                `email` varchar(191)  DEFAULT NULL,
                `gender` varchar(191)  DEFAULT NULL,
                `address` varchar(191) DEFAULT NULL,
                `MSISDN` BIGINT(20) NOT NULL,
                `GRS_ID_FK` varchar(191) NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `active` int(11) NOT NULL, PRIMARY KEY (`id`))
                ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;";
                if (mysqli_query($mysqli, $sql)) {
                    return true;
                } else {
                    return "Error creating table: " . mysqli_error($mysqli);
                }
        }

        function checkUsername($username){
            $mysqli = getConnected();
            $stmt = $mysqli->prepare('SELECT id, password FROM users WHERE username = ?');
            // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                return true;
            }
            else {
                return false;
            }
        }
        function checkPhone($phone){
            $mysqli = getConnected();
            $stmt = $mysqli->prepare('SELECT id, password FROM users WHERE phone = ?');
            // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
            $stmt->bind_param('s', $phone);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                return true;
            }
            else {
                return false;
            }
        }
        
    }

?>