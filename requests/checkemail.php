<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('../classes/users.php');
$us = new users();


$check = $us->checkuser($_POST['email']);
$username = $us->checkUsername($_POST['username']);
$phone = $us->checkPhone($_POST['phone']);

if(($check) && ($username)&& ($phone)){
echo "0";
}
else if(($check) && (!$username)&& (!$phone)) { //email exist
    echo "-1";
}

else if((!$check) && ($username)&& (!$phone)) { //username exist
    echo "-2";
}

else if((!$check) && (!$username)&& ($phone)) { //phone exist
    echo "-3";
}

else if(($check) && (!$username)&& ($phone)) { //phone and email exist
    echo "-4";
}

else if((!$check) && ($username)&& ($phone)) { //phone and username exist
    echo "-5";
}

else if(($check) && ($username)&& (!$phone)) { //email and username exist
    echo "-6";
}

else {
    echo "1";
}
?>