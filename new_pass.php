<?php
if(!isset($_GET['token'])){
    header('Location: 404.php');
}
include('includes/header.php');


?>

<body>
<br><br>
<h1 class='titlee'> Reset password</h1>
<?php //include('messages.php'); ?>
<hr>

<div class="container-fluid" >

    <form  method="post" id="myform" action="./requests/new_pass.php"  enctype="multipart/form-data">
        <div class="row">
            <div class="col col-sm-12">
                <center>
                    <?php //include('messages.php'); ?>
                    <div class="form-group">
                        <label>New password</label>
                        <input type="password" name="new_pass" id="new_pass" class="form-control" required style="width:20%;">
                    </div>
                    <div class="form-group">
                        <label>Confirm new password</label>
                        <input type="password" name="new_pass_c" id="new_pass_c" class="form-control" required style="width:20%;">
                        <input type="hidden" name="token" id="token" value="<?php echo $_GET['token']; ?>">
                    </div>
                    <span id="msg"></span>
                    <div class="form-group">
                        <button type="button" name="new_password" id="submit" class="form-control btn btn-success" style="width:20%;">Submit</button>
                    </div>
                </center>

            </div>
            <?php //include('messages.php'); ?>

        </div>
        <br>
        <hr style="border-bottom: 2px solid black">
    </form>
</div>
<script>
    jQuery(document).ready(function(){
        $("#submit").click(function(event){
            //alert('d');
            if ($("#new_pass").val() != $("#new_pass_c").val()) {
                $("#msg").html("Password doesnt not match").css("color","red");
               // event.preventDefault();
            }else{
                $("#msg").html("Password matched").css("color","green");
                var form = $("#myform");
                var formData = new FormData(form[0]);
                var token =
                $.ajax({
                    url: './requests/new_pass.php',
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                         $("#submit").val("Loading...");
                         $("#submit").attr("disabled", true);
                    },
                    success: function (data) {
                        if(data=="OK"){
                            $.notify("Password has been changed successfully.. please login now", "success");
                            window.setTimeout(function () {
                                window.location.href="index.php";
                            }, 3000);
                        }
                        else {
                            $.notify("Token doesnt exist !", "error");
                        }
                        console.log(data);
                    },
                });
            }
        });
    });
</script>
</body>