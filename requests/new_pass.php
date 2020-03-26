<?php
$errors = [];
$user_id = "";
// connect to database
$db = mysqli_connect('localhost', 'root', '', 'bulk');
//if (isset($_POST['new_password'])) {
    $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);
    // Grab to token that came from the email link
    if(isset($_POST['token'])){
        $token = $_POST['token'];
    }
    else {
        $token ="";
    }
    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");

    if (count($errors) == 0) {
        // select email address of user from the password_reset table
        $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
        //echo $sql;
        $results = mysqli_query($db, $sql);
        $email = mysqli_fetch_assoc($results)['email'];

        if ($email) {
            $new_pass =hash("sha256", $new_pass);
            $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
            echo $sql;
            $results = mysqli_query($db, $sql);
            $sql1 = "delete from password_reset WHERE email='$email' ";
            echo $sql1;
            $results1 = mysqli_query($db, $sql1);
            echo "OK";
        }
        else {
            echo"NOK";
        }
    }
//}

?>