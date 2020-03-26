<?php
ob_start();
session_start();
include_once('classes/login.php');
$log = new login();
$res = $log->checklogin();

if ($res)
    header("Location: campaigns.php");

include('includes/header.php');
?>
<style>
    body {
        background: url('img/background.png') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
</style>
<body >
<div class='container-fluid'>
    <div class='row'>

        <div class='col col-md-12 col-sm-12 '>
            <div class='login'>
                <?php
                $res = '';
                if (isset($_GET['action'])) {
                    if ($_GET['action'] == 'b')
                        $res = 'Bad Password, Please try again.. :(';
                    else
                        $res = 'User Not Found..';
                    ?>
                    <div class="form-group">
                        <div class="alert alert-danger" style='margin-left:5%; text-align:center;'>
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $res; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="form-style-8">
                    <form class="" method='post' action='./requests/login.php'>
                        <h2 class="h2_login">
                            Welcome back! Please login to your account. </h2>
                        <input type="text" name="email" placeholder="Email / User Name" class="form-control" required /><br/>
                        <input type="password" name='pass' id="inputPassword" class="form-control" placeholder="Password"
                               required>
                        <div class='row' style='margin-top:40px;'>
                            <div class='col-md-6' style='text-align:center;'>
                                <button class="btn  btnlogin" type="submit" name='btn-login'><span>Sign in</span></button>
                            </div>
                            <div class='col-md-6' style='text-align:center;'>
                                <button class="btn btnsign" type="button" name='btn-login'><span >Sign up</span></button>
                            </div>
                        </div>
                        <div class='row' style='margin-top:10px; color:#38B9C2  !important; font-weight: bolder;'>
                            <div class='col-md-4 '>
                            </div>
                            <div class='col-md-4 for'>
                                <a href='enter_email.php' class='forget'>Forget Password?</a>
                            </div>
                            <div class='col-md-4 '>

                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <?php include('includes/footer.php'); ?>
        <script>
            $(document).ready(function (e) {
                $('.btnsign').click(function (e) {
                    location.href = 'signup.php';
                });

            });
        </script>
    </div>
</div>
</body>