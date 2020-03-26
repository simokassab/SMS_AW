<?php

include_once ('db_connect.php');


class login {

    function login_($email, $pass){
        $mysqli = getConnected();
        $password = hash('sha256', $pass); // password hashing using SHA256
       // $mysqli=mysqli();
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE (email= ? OR username= ? ) and active=1");
        $stmt->bind_param("ss", $email, $email);
        /* execute query */
        $stmt->execute();
        //get result
        $res = $stmt->get_result();
        $stmt->close();
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        //print_r($row);
        $count = $res->num_rows;
        //echo $count;
      //  echo $row['password'];
      //  echo "<br/>".$password."<br/>";
        if ($count == 1 && $row['password'] == $password) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['weight'] = $row['weight'];
          //  echo $_SESSION['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['photo'] = $row['photo'];
            $_SESSION['created_at'] = $row['created_at'];
            $_SESSION['filter'] = $row['filter'];
            return "done";
        } elseif ($count == 1) {
            return "badpass";
        } else return "notfound";
    }


    function logout(){
        session_destroy();
        unset($_SESSION['user_id']);
        unset($_SESSION['full_name']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['photo']);
        unset($_SESSION['created_at']);
        unset($_SESSION['filter']);
        return true;
    }

    function changeImage($id, $photo){
        $mysqli = getConnected();
        $sql = ' UPDATE USERS SET PHOTO="'.$photo.'" WHERE id='.$id;
        if (mysqli_query($mysqli, $sql)) {
            $_SESSION['photo']=$photo;
            return true;
        } else {
            return "Error updating record: " . mysqli_error($conn);
        }
    }

    function checklogin(){
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        else {
            return true;
        }
    }

    
}
?>