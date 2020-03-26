<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('../classes/users.php');
include_once('../classes/sender.php');
include_once('../classes/credits.php');
$us = new users();
$sender = new sender();
$credit = new credits();
$zip = new ZipArchive();
$currentDir = $_SERVER['DOCUMENT_ROOT'];
$uploadDirectory = "/SMS/CMS/public/new_users/";
$errors = []; // Store all foreseen and unforseen errors here

//$fileName1 = $_FILES['file1']['photo'];
//$fileSize = $_FILES['file1']['size'];
//$fileTmpName1  = $_FILES['file1']['tmp_name'];
//$fileType = $_FILES['file1']['type'];
//$file="";
$user_id = $us->insert($_POST['fullname'], $_POST['username'],  $_POST['email'], hash("sha256", $_POST['password']),  $_POST['address'],  $_POST['phone'],  $_POST['company'],  '');

//if (isset($_POST['submit'])) {
$zip_name =$currentDir . $uploadDirectory."user_".$user_id.".zip";
for ($i = 1; $i <= 7; $i++) {
    $file="";
    $file = $_FILES['file' . $i]['name'];
    if(!isset($file))
    {

       continue;
    }
    else {
        if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
        {
            echo "Sorry ZIP creation failed at this time, please contact the admin";
            $us->delete($user_id);
            break;
        }
        $countfiles = count($_FILES['file'.$i]['name']);
          for( $j=0 ; $j < $countfiles ; $j++ ) {

              $fileName = $_FILES['file' . $i]['name'][$j];
             // echo $fileName;
              $fileTmpName = $_FILES['file' . $i]['tmp_name'][$j];
              $uploadPath = $currentDir . $uploadDirectory . basename($fileName);
             // move_uploaded_file($fileTmpName, $uploadPath);
            //  echo "-".$didUpload."-";
              if ( move_uploaded_file($fileTmpName, $uploadPath)) {
                  $zip->addFile($uploadPath, basename($fileName) );

              }
          }
      }
    $zip->close();
  }


    $sender_id = $sender->insert($_POST['sender'], $user_id );
    $credit->insert(0, $user_id);
    $mysql1 = getConnected();
    $contact = "CREATE TABLE `contacts_".$user_id."` (
                  `id` int(10) NOT NULL AUTO_INCREMENT, `firstname` varchar(191) DEFAULT NULL,
                  `lastname` varchar(191)  DEFAULT NULL,
                  `email` varchar(191)  DEFAULT NULL,
                  `gender` varchar(191)  DEFAULT NULL,
                  `address` varchar(191) DEFAULT NULL,
                  `MSISDN` BIGINT(20) NOT NULL,
                  `GRS_ID_FK` varchar(191) NOT NULL,
                  `TOKEN` varchar(191) NOT NULL,
                  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  `active` int(11) NOT NULL, PRIMARY KEY (`id`))
                  ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;";
    $mysql1->query($contact);
    $mysql1->close();
    $status = $us->insert_status($user_id, 0, "");


$files = array_diff(glob($currentDir.$uploadDirectory."/*"), glob($currentDir.$uploadDirectory."/*.zip"));
foreach($files as $file) {
    if(is_file($file))
        unlink($file); // delete file
}

$body = "New Customer Registration. please check it on https://smscorp.iq.zain.com/SMS/CMS/public/users/".$user_id;
$sender = 'MW_ADMIN';
$number = '9647827851178';
//$response = file_get_contents('http://');
echo "OK";

//}
?>