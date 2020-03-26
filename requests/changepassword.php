<?php
ob_start();
session_start();
include_once('../classes/users.php');
$cr= new users();
$result="";
//echo $_POST['oldpass'];
$oldpass=  hash('sha256', $_POST['oldpass']);
$old =  $cr->getOldPassword($_SESSION['user_id']);

//echo $oldpass."<br/>".$old;

if($oldpass!=$old){
    $result=0;
}
else {
    $newpassword=hash('sha256', $_POST['password']);
    if($cr->changepassword($newpassword, $_POST['userid'])){
        $result=1;
    }

}
echo $result;


//print_r($old);
?>

