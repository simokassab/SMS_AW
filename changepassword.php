<?php
ob_start();
session_start();
header('Content-type:text/html; charset=utf-8');
include_once('classes/login.php');
include_once('classes/groups.php');
$log= new login();
$gr= new groups();
$res=$log->checklogin();

$gr_all=$gr->getAll($_SESSION['user_id']);


if(!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>
<body class='bg'>
<?php include('includes/nav.php');?>
<h1 class='titlee'> Change Password</h1>
<!-- Begin page content -->
<div class="container-fluid">
    <div style='background-color:white;'><br/>
    <form id="formCheckPassword" name="formCheckPassword" style='background-color:white; margin:2%;' method='post'>
    <input name='userid' id='userid' type='hidden' value='<?php echo $_SESSION['user_id']; ?>' >
        <div class="form-group">
            <label class="control-label" for="body">Old Password :</label>
            <input type="password" class="form-control" name="oldpass" id="oldpass" />
            <p id='errorpassword' class="error text-center alert alert-danger" style='display:none;'></p>
            
        </div>
        <div class="form-group">
            <label class="control-label" for="body">New Password :</label>
            <input type="password" class="form-control" name="password" id="password" />
            
        </div>
        <div class="form-group">
            <label class="control-label" for="body">Confirm Password :</label>
            <input type="password" class="form-control" name="cfmPassword" id="cfmPassword"  />
        </div>
        <div style='margin: 0 auto;text-align:center;'>
            <button type='submit' class="btn btn-warning change_pass" id='submitbutton' >
            <span class="fa fa-plus"></span>&nbsp;&nbsp;&nbsp;&nbsp;Change Password
            </button><br/><br/>
        </div>
    </form>
    
    </div>
</div>
<script>
$(document).ready(function () {
	$('#submitbutton').click(function() {  
    	// validate and process form here  
		$('#formCheckPassword').validate({
			rules: {
                password: {
                    required: true,
                    minlength: 5
                },
                oldpass: {
                    required: true
                },
                cfmPassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }
            },
			submitHandler:function(form) {

				var oldpass = $('#oldpass').val();
				var password = $('#password').val(); 
				var cfmPassword = $('#cfmPassword').val();  
				var userid = $('#userid').val();  
				var dataString = 'oldpass=' + oldpass + '&password='+ password + '&cfmPassword=' + cfmPassword+'&userid='+userid;
				$.ajax({  
				  type: 'POST',
				  url: 'requests/changepassword.php',
				  data: dataString,
				  success: function(data){
                    //alert(data);
                    if(data==0){
                        $("#errorpassword").html("Password Doesnt Match");
                        $("#errorpassword").css('display', 'block');
                       //alert("ok");
                    }
                    else {
                        $.notify("Password Has been changed, you will be logged out..", "success");
                        window.setTimeout(function () {
                            location.href = "requests/logout.php";
                            }, 2000);
                    }
                }
				})
			}
		});
	});
});

</script>