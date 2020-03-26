<?php
ob_start();
session_start();


//print_r($_GET['t']);
?>
<?php include('includes/header.php'); ?>
<?php
function generateRandomString($length = 50) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$errors = [];
$user_id = "";
// connect to database
$db = mysqli_connect('localhost', 'root', '', 'bulk');
if (isset($_POST['reset-password'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    // ensure that the user exists on our system
    $query = "SELECT phone FROM users WHERE email='$email'";
    $results = mysqli_query($db, $query);

    if (empty($email)) {
        array_push($errors, "Your email is required");
    }else if(mysqli_num_rows($results) <= 0) {
        array_push($errors, "Sorry, no user exists on our system with that email");
    }
    // generate a unique random token of length 100
    $token = bin2hex(generateRandomString());

    if (count($errors) == 0) {
        $phone =  mysqli_fetch_assoc($results)['phone'];
        // store token in the password-reset database table against the user's email
        $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";
        $results = mysqli_query($db, $sql);
        $text = "Hi there, click on this <a href=\"https://smscorp.iq.zain.com/SMS/new_pass.php?token=" . $token . "\">link</a> to reset your password on our site";
        $response = file_get_contents('http://localhost:8800/PhoneNumber='.$phone.'&sender=smscorp&text='.$text.'&SMSCROute=SMPP%20-%20172.16.36.50:31113');
        $msg = wordwrap($msg,70);

        header('location: pending.php?phone=' . $phone);
    }
}
?>
<body >
<br><br>
<h1 class='titlee'> Reset password</h1>
<?php include('messages.php'); ?>
<hr>
<?php
?>
<div class="container-fluid" >

    <form  method="post" action="enter_email.php" id="form" enctype="multipart/form-data">
        <div class="row">
            <div class="col col-sm-12">
                <center>
                    <div class="form-group">
                        <label for="email" style="text-align: left!important;">Your email address</label>
                        <input type="email" id="email" class="form-control" required name="email" style="width:20%;">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="reset-password" class="form-control btn btn-success" style="width:20%;">Submit</button>
                    </div>
                </center>

            </div>
            <?php //include('messages.php'); ?>

        </div>
        <br>
        <hr style="border-bottom: 2px solid black">
    </form>
</div>

</body>

