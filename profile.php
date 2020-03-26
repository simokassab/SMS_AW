<?php
ob_start(); 
session_start();
include('includes/header.php'); ?>
<body>
<?php 
    $id = $_SESSION['user_id'];
    //echo $id;
    include('includes/nav.php'); 
    include_once('classes/users.php');
    include_once('classes/login.php');
    
    $log= new login();
    $user= new users();
    $logged=$log->checklogin();
    if(!$logged)
        header("Location: login.php");
    $row=$user->getRowByID($id);
   // print_r($row);
    ?>
<h1 class='titlee'> Profile</h1>
<div class="container-fluid">
  	<hr>
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
            <div id="body-overlay"><div><img src="./img/loading.gif" width="64px" height="64px"/></div></div>
                <div class="bgColor">
                    <form id="uploadForm" action="requests/uploadimage.php" method="post">
                        <div id="targetOuter" >
                            <div id="targetLayer"></div>
                            <img src="./img/photo.png"  class="icon-choose-image" />
                            <div class="icon-choose-image" >

                            <input name="userImage" id="userImage" type="file" class="inputFile" onChange="showPreview(this);" />
                            </div>
                        </div>
                        <div>
                        <input type="submit" value="Upload Photo" class="btn btn-info btnSubmit btn-sm" />
                    </form>
            </div>
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <form class="form-horizontal" role="form" name='edit' id='edit'  method='POST' enctype="multipart/form-data">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" disabled  id="username1" name='username1' value='<?php echo $row['username']; ?>'>
            <input type="hidden" class="form-control"  id="username" name='username' value='<?php echo $row['username']; ?>'>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password"  id='password' value='<?php echo $row['password']; ?>' disabled>
            <a href='changepassword.php' class='changepass'>Change Password </a>
        </div>
        <div class="form-group">
            <label for="password">Email:</label>
            <input type="email" class="form-control" id="email" name='email' required  value='<?php echo $row['email']; ?>'>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" rows="5" id="address" name='address'><?php echo $row['address']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control phone" id="phone" name='phone'   value='<?php echo $row['phone']; ?>'>
        </div>
        <div class="form-group">
            <label for="company">Company:</label>
            <input type="text" class="form-control" id="company" name='company' value='<?php echo $row['company']; ?>'>
        </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" id='save'  value="Save">
              <span></span>
              <input type="reset" class="btn btn-default" value="Cancel">
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>

</div>
<script>
function showPreview(objFileInput) {
    if (objFileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (e) {
            
           $("#targetLayer").html('<img src="'+e.target.result+'"  class="image--profile" />');
			$("#targetLayer").css('opacity','0.7');
			$(".icon-choose-image").css('opacity','0.5');
        }
		fileReader.readAsDataURL(objFileInput.files[0]);
    }
}

$(document).ready(function (e) {
    $(".phone").on("keypress keyup blur",function (event) {   
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
    });
    $("#targetLayer").html(' <img class="image--profile" src="<?php echo $row['photo']; ?>"   />');
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "requests/uploadimage.php",
			type: "POST",
			data:  new FormData(this),
			beforeSend: function(){$("#body-overlay").show();},
			contentType: false,
    	    processData:false,
			success: function(data)
		    {
			$("#targetLayer").html(data);
			$("#targetLayer").css('opacity','1');
			setInterval(function() {$("#body-overlay").hide(); },500);
			},
		  	error: function() 
	    	{
                
	    	} 	        
	   });
    }));
    $("#edit").on("submit", function(event){
        event.preventDefault();
        $.ajax({
            url: './requests/editprofile.php',
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            processData:false,
        success: function(data) {
            console.log(data);
            $.notify("User has been updated", "success");
            window.setTimeout(function () {
            location.reload();
           // location.href = "./groups.php#view";
            }, 1000); 
            }
        });
    });
});
</script>

</body>