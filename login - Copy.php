<?php 
ob_start();
session_start();
include_once('classes/login.php');
$log= new login();
$res=$log->checklogin();

if($res)
    header("Location: campaigns.php");

include('includes/header.php');

?>
<div class='container-fluid'>

    <div class='row'>
        <div class='col-sm-6 back' style=''>
            <img src='img/bg1.png' class="resp" >
        </div>
        <div class='col-sm-6'>
            <div class='login'>
            <h2 style='text-align:center; margin-left:5%; color:#595959; font-size: calc(0.9em + 1vw)!important;'>Welcome back! Please login to your account. </h2>
            <?php
                    $res='';
                    if (isset($_GET['action'])) {
                        if($_GET['action']=='b')
                            $res='Bad Password, Please try again.. :(';
                        else 
                            $res='User Not Found..';
                        ?>
                        <div class="form-group">
                            <div class="alert alert-danger" style='margin-left:5%; text-align:center;'>
                                <span class="glyphicon glyphicon-info-sign" ></span> <?php echo $res; ?>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                <form class="form-style-8" method='post' action='./requests/login.php'>
                    <input type="text" name="email" placeholder="Email / Username"  class="form-control" /><br/>
                    <input type="password" name='pass' id="inputPassword" class="form-control" placeholder="Password" required>

                    <div class='row' style='margin-top:40px;'>
                        <div class='col-md-6' style='text-align:center;'>
                             <button class="btn btn-lg btnlogin" type="submit" name='btn-login'>Log in</button>
                        </div>
                        <div class='col-md-6' style='text-align:center;'>
                             <button class=" btnsign " type="button" name='btn-login'>Sign Up</button>
                        </div>
                    </div>
                    <div class='row' style='margin-top:10px; color: #38B9C2 !important; font-weight: bolder;'>
                        <div class='col-md-6 for' >
                            <a href='enter_email.php' class='forget'>Forget Password</a>
                        </div>
                    </div>
                </form>
            </div>  
        
        </div>
        <?php include('includes/footer.php'); ?>
        <script>
            $(document).ready(function (e) {
                $('.btnsign').click(function(e) {
                    location.href='signup.php';
                });

            });
        </script>
    </div>
</div>