<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('../classes/users.php');
$us= new users();
// Now we check if the data was submitted, isset will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	die ('Please complete the registration form!<br><a href="register.html">Back</a>');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty...
	die ('Please complete the registration form!<br><a href="register.html">Back</a>');
}
// We need to check if the account with that username exists
    $exist=$us->checkuser($_POST['email']);
	// Store the result so we can check if the account exists in the database.
	if ($exist) {
		// Username already exists
		echo 'Email exists, please choose another!<br><a href="register.html">Back</a>';
	} else {
            $password = hash('sha256', $_POST['password']);
            $newuser=$us->insert($_POST['username'],$_POST['email'], $password, '', '', '','');
            echo $us->createContactTable($newuser);
			echo 'You have successfully registered, you can now login!<br><a href="../login.php">Login</a>';
	}

?>