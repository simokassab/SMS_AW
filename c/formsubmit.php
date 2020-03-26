<?php
ob_start();
session_start();
include_once "../classes/form.php";

$form = new form();

echo $_POST['inputs_'];
echo $_POST['campid_'];
echo $_POST['shortlink_'];

$form->insert($_POST['campid_'],$_POST['shortlink_'],  $_POST['inputs_'], $_POST['tokenid']);
?>