<?php
ob_start();
session_start();
include('../classes/login.php');
$log=new login();

if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$sourcePath = $_FILES['userImage']['tmp_name'];
$targetPath = "./uploads/".$_FILES['userImage']['name'];

if(move_uploaded_file($sourcePath,"../uploads/".$_FILES['userImage']['name'])) {
$logs=$log->changeImage($_SESSION['user_id'], $targetPath);
?>
<img src="<?php echo $targetPath; ?>" width="200px" height="200px" class="image--profile" />
<?php
}
}
}
?>