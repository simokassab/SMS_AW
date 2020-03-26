<?php
date_default_timezone_set("Asia/Beirut");
header("X-XSS-Protection: 1; mode=block");
include_once('./classes/credits.php');
$credit = new credits();
$credits = $credit->getRowByUserID($_SESSION['user_id']);
?>
<body class='bg'>
<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header" style=""><a href='index.php'>
                <img src='img/logo@4x.png' class='img-responsive' style='width:85%;    '></a>

        </div>
        <ul class="list-unstyled components">
            <li class='hov' id='grp'>
                <a href="groups.php">
                    <i class="fas fa-users"></i>
                    Groups
                </a>
            </li>
            <li class='hov' id='cont'>
                <a href="contacts.php">
                    <i class="fas fa-user-circle"></i>
                    Contacts
                </a>
            </li>
            <li class='hov' id='camp'>
                <a href="campaigns.php">
                    <i class="fas fa-bullhorn "></i>
                    Campaigns
                </a>
            </li>
            <li class='hov'>
                <a href="reports.php" id='rep'>
                    <i class="fas fa-chart-line "></i>
                    Reports
                </a>
            </li>
        </ul>
        <p style="text-align: center">SMS:</p>
        <p style="text-align: center; color: #38B9C2; font-size: larger"><?php echo $credits[1]; ?>
        </p>
        <div class='foot small'>Powered By:
            <img src='img/homelogo.png' style='width:100px;'></img>
        </div>
    </nav>

    <!-- Page Content Holder -->
    <div id="content">
        <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
            <span></span>
        </button>

        <ul id="nav">
            <li>
                <a href="#"><img src='<?php echo $_SESSION['photo'] ?>' class='img-responsive image--cover'>
                    <br/>Me&nbsp;<i class="fas fa-sort-down"></i></a>
                <ul class='submen' id='subb'>
                    <li style='text-align:center; margin-top:10%; border:0 !important; '>
                        <img src='<?php echo $_SESSION['photo'] ?>' class='img-responsive image--cover1'><br/>
                        <strong><?php echo $_SESSION['username']; ?></strong>
                    </li>
                    <li>
                        <hr>
                        <a href="profile.php"><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;&nbsp;Profile</a></li>
                    <!--li><a href="packages.php"><i class="fa fa-boxes"></i>&nbsp;&nbsp;&nbsp;&nbsp;Packages</a></li-->
                    <li><a href="#" id='logout'><i class="fa fa-sign-out-alt"></i>&nbsp;&nbsp;&nbsp;&nbsp;Logout</a>
                    </li>
                </ul>
            </li>

        </ul>
        <br/><br/>
        <hr/>
        <script>

            $(document).ready(function () {
                $('#nav > li').on('click', function () {
                    // alert('dsda');
                    $('.image--cover').css('border', '3px solid #38B9C2');
                    $('#subb').slideToggle("fast", function () {
                        $('.image--cover').css('border', 'none');
                    });
                });
                var res = $(location).attr('href');
                console.log(res);
                if (res.indexOf("groups") >= 0) {

                    $('#grp').addClass('active');
                    $(document).prop('title', 'Groups');
                } else if (res.indexOf("contact") >= 0) {
                    console.log('contact');
                    $('#cont').addClass('active');
                    $(document).prop('title', 'Contacts');
                } else if (res.indexOf("campaign") >= 0) {
                    console.log('camp');
                    $('#camp').addClass('active');
                    $(document).prop('title', 'Campaigns');
                } else if (res.indexOf("reports.php") >= 0) {
                    $('#rep').addClass('active');
                    $(document).prop('title', 'Reports');
                }
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                    $(this).toggleClass('active');
                });


                $('#logout').on('click', function () {
                    event.preventDefault();
                    $.notify("You will be logged out ..", "info");
                    window.setTimeout(function () {
                        location.href = "requests/logout.php";
                    }, 1500);
                });
                $("[rel='tooltip']").tooltip();
            });
        </script>