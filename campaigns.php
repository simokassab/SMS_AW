<?php
ob_start();
session_start();
include_once('classes/login.php');
include_once('classes/groups.php');
include_once('classes/contacts.php');
include_once('classes/links.php');
include_once('classes/categories.php');
include_once('classes/campaigns.php');
include_once('classes/templates.php');
include_once('classes/sender.php');
$log = new login();
$gr = new groups();
$link = new links();
$cr = new contacts();
$cmp = new campaigns();
$cat = new categories();
$temp = new templates();
$send = new sender();

$cmpbyid = '';
$cmtype = '';

$temps = $temp->getAll();
$cats = $cat->getAll();
//print_r($temps);
$res = $log->checklogin();

$cr_all = $cr->getAll($_SESSION['user_id']);

$gr_all = $gr->getAll($_SESSION['user_id']);


$viewcamp = $cmp->getAllview($_SESSION['user_id']);
$socialcamp = $cmp->getAllSocial($_SESSION['user_id']);

$scheduledcamp = $cmp->getScheduledview($_SESSION['user_id']);
$sentcamp = $cmp->getSentview($_SESSION['user_id']);
$pendingcamp = $cmp->getPendingCampaign($_SESSION['user_id']);
$deletedcamp = $cmp->getDeletedCampaigns($_SESSION['user_id']);

if (!$res) header("Location: login.php");

$shortlink = '';
$campaign = '';
$parameters = '';
$campid = '';
$camptype = '';
if (isset($_GET['l'])) {
    if (file_exists('./c/' . $_GET['l'] . '.php')) {
        $shortlink = $_GET['l'];
        $parameters = $link->parByShortLink($shortlink);
        $par = explode("&", $parameters);
        $par1 = explode("=", $par[0]);
        $campid = $par1[1]; //camp id
        // echo $campid;
        $cmpbyid = $cmp->getRowByID($campid); //get Campaign by ID
        $campaign = $cmpbyid[1]; //campaign name
        $cmtype = 'advanced'; // campaign type
        //echo $cmpbyid[1]; campaign name
        $par2 = explode("=", $par[1]);
        $landid = $par2[1]; //landinig page  id
    } else {
        header("Location: 404.php");
    }
}
if (isset($_GET['s'])) {
    if (file_exists('./c/' . $_GET['s'] . '.php')) {
        $shortlink = $_GET['s'];
        $parameters = $link->parByShortLink($shortlink);
        $par = explode("&", $parameters);
        $par1 = explode("=", $par[0]);
        $campid = $par1[1]; //camp id
        // echo $campid;
        $cmpbyid = $cmp->getRowByID($campid); //get Campaign by ID
        $scampaign = $cmpbyid[1]; //campaign name
        $cmtype = 'social'; // campaign type
        //echo $cmpbyid[1]; campaign name
        $par2 = explode("=", $par[1]);
        $landid = $par2[1]; //landinig page  id
        $cmp->updateStatus($campid, 'SOCIAL');
    } else {
        header("Location: 404.php");
    }
}

?>
<?php include('includes/header.php'); ?>

<script>
    $(document).ready(function (e) {

        $('#scheduledtable').DataTable({
            responsive: true,
            "pagingType": "full_numbers"
        });
        $('#senttable').DataTable({
            responsive: true,
            "pagingType": "full_numbers"
        });


    });
</script>

<body class='bg'>
<div class="modal fade" id="OpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Zain Contacts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label for="governorate" class="col-form-label">Governorate:</label>
                                <select name="governorate[]" id="governorate" class="form-control" multiple="multiple">
                                    <option value="Al Anbar">Al Anbar</option>
                                    <option value="Babil">Babil</option>
                                    <option value="Baghdad">Baghdad</option>
                                    <option value="Basra">Basra</option>
                                    <option value="Dhi Qar">Dhi Qar</option>
                                    <option value="Al-Qadisiyyah">Al-Qādisiyyah</option>
                                    <option value="Diyala">Diyala</option>
                                    <option value="Dohuk">Dohuk</option>
                                    <option value="Erbil">Erbil</option>
                                    <option value="Halabja">Halabja</option>
                                    <option value="Karbala">Karbala</option>
                                    <option value="Kirkuk">Kirkuk</option>
                                    <option value="Maysan">Maysan</option>
                                    <option value="Muthanna">Muthanna</option>
                                    <option value="Najaf">Najaf</option>
                                    <option value="Nineveh">Nineveh</option>
                                    <option value="Saladin">Saladin</option>
                                    <option value="Sulaymaniyah">Sulaymaniyah</option>
                                    <option value="Wasit">Wasit</option>
                                </select>
                                <script type="text/javascript">
                                    $(function () {
                                        $('#governorate').multiselect({
                                            enableFiltering: true,
                                            templates: {
                                                li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
                                                filter: '<li class="multiselect-item filter"><div class="input-group">' +
                                                    '<input class="form-control multiselect-search" type="text"></div></li>',
                                                filterClearBtn: ''
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <label for="brand" class="col-form-label">Brands:</label><br>
                            <select name="brand[]" id="brand" class="form-control" multiple="multiple">
                                <option value="apple">Apple</option>
                                <option value="HTC">HTC</option>
                                <option value="huawei">Huawei</option>
                                <option value="lenovo">Lenovo</option>
                                <option value="LG">LG</option>
                                <option value="nokia">Nokia</option>
                                <option value="samsung">Samsung</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#brand').multiselect({
                                        enableFiltering: true,
                                        templates: {
                                            li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
                                            filter: '<li class="multiselect-item filter"><div class="input-group">' +
                                                '<input class="form-control multiselect-search" type="text"></div></li>',
                                            filterClearBtn: ''
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <div class="col col-md-4">
                            <label for="type" class="col-form-label">Type:</label><br>
                            <select name="type[]" id="type_" class="form-control" multiple="multiple">
                                <option value="apple">Apple</option>
                                <option value="HTC">HTC</option>
                                <option value="huawei">Huawei</option>
                                <option value="lenovo">Lenovo</option>
                                <option value="LG">LG</option>
                                <option value="nokia">Nokia</option>
                                <option value="samsung">Samsung</option>
                            </select>
                            <script type="text/javascript">
                                $(function () {
                                    $('#type_').multiselect({
                                        enableFiltering: true,
                                        templates: {
                                            li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
                                            filter: '<li class="multiselect-item filter"><div class="input-group">' +
                                                '<input class="form-control multiselect-search" type="text"></div></li>',
                                            filterClearBtn: ''
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>
<?php include('includes/nav.php'); ?>
<h1 class='titlee'> Campaigns</h1><br/>
<!-- Begin page content -->
<div class="container-fluid" style='padding:3% !important;'>
    <div id="navbar-example">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" id='navitm' style='width:20% !important;'>
                <a class="nav-link active view" data-toggle="tab" id="senttab" href="#vieww" role="tab">All
                    Campaigns</a>
            </li>
            <li class="nav-item" id='navitm' style='width:16% !important;'>
                <a class="nav-link  new" data-toggle="tab" href="#new" id="newtab" role="tab">New</a>
            </li>
            <li class="nav-item" id='navitm' style='width:16% !important;'>
                <a class="nav-link  new" data-toggle="tab" href="#sch" role="tab">Scheduled </a>
            </li>
            <li class="nav-item" id='navitm' style='width:16% !important;'>
                <a class="nav-link  new" data-toggle="tab" href="#sent" role="tab">Sent</a>
            </li>
            <li class="nav-item" id='navitm' style='width:16% !important;'>
                <a class="nav-link  new" data-toggle="tab" href="#pending" role="tab">Pending</a>
            </li>
            <li class="nav-item" id='navitm' style='width:16% !important;'>
                <a class="nav-link upload" data-toggle="tab" href="#delet" role="tab">Deleted </a>
            </li>
        </ul>
        <!-- Tab panes {Fade}  -->
        <div class="tab-content" id='content1'>
            <div class="tab-pane" id="new" name="new" role="tabpanel"><br/>
                <form id='campaign' name="campaign" method="POST" enctype="multipart/form-data"><br/>
                    <div id="result"></div>
                    <h4 style='text-align:center;'>Start New Campaign</h4> <br/>
                    <div id="smartwizard" style='margin:0 2% 2% 2%;'>
                        <ul>
                            <li><a href="#step-1">Step 1<br/>
                                    <small>Campaign Name</small>
                                </a></li>
                            <li><a href="#step-2">Step 2<br/>
                                    <small>Campaign Type</small>
                                </a></li>
                            <li><a href="#step-3">Step 3<br/>
                                    <small id="camptitle"></small>
                                </a></li>
                            <li id="st4"><a href="#step-4">Step 4<br/>
                                    <small id="campdate">Sending Date</small>
                                </a></li>
                            <li id="st5"><a href="#step-5">Step 5<br/>
                                    <small id="campdate">Summary</small>
                                </a></li>
                        </ul>
                        <div id="list">
                            <div id="step-1"><br/>
                                <h2>Campaign Name: </h2><br/>
                                <div id="form-step-0" role="form" data-toggle="validator">
                                    <div class="form-group">
                                        <input type="name" class="form-control" id="grpname" name='grpname'
                                               value="<?php echo $campaign; ?>" requireds>
                                    </div>
                                    <br/>
                                </div>
                                <p id='errorname1' class="error text-center alert alert-danger"
                                   style='display:none;'></p>
                            </div>
                            <div id="step-2"><br/>
                                <h2>Choose Type</h2><br/>
                                <section id="plans">
                                    <div class="container">
                                        <div class="row">
                                            <!-- item -->
                                            <div class="col-md-4 text-center">
                                                <input type="hidden" id="camptype" name="camptype">
                                                <div class="panel panel-danger panel-pricing">
                                                    <div class="panel-body text-center"><i class="fa fa-comments"></i>
                                                        <p class='headerr'>Regular SMS</p>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <a id="regular" class="btn btn-lg btn-block btn-danger"
                                                           style='color:white !important; font-weight: bold;' href="#">Select</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /item -->
                                            <!-- item -->
                                            <div class="col-md-4 text-center">
                                                <div class="panel panel-warning panel-pricing">
                                                    <div class="panel-body text-center"><i class="fa fa-boxes"></i>
                                                        <p>Advanced</p>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <a id="advanced" class="btn btn-lg btn-block btn-warning"
                                                           style='color:white !important;font-weight: bold;' href="#">Select</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /item -->
                                            <!-- item -->
                                            <div class="col-md-4 text-center">
                                                <div class="panel panel-warning panel-pricing">
                                                    <div class="panel-body text-center"><i class="fab fa-facebook"></i>
                                                        <p>Social Media</p>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <a id="social" class="btn btn-lg btn-block btn-success"
                                                           style='color:white !important;font-weight: bold;' href="#">Select</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /item -->
                                        </div>
                                        <br/><br/>
                                    </div>
                                </section>
                            </div>
                            <div id="step-3" style="text-align: center;">
                                <h2 id="camptype"></h2><br/>
                                <div id="form-step-2" role="form" data-toggle="validator">
                                    <div class="row">
                                        <div class="col col-sm-3">
                                            <div class="form-group sender">
                                                <label class="control-label" for="sender">Sender*:</label>
                                                <select id="sender" class="form-control" name='sender'>
                                                    <option value="null">Select the Sender</option>
                                                    <?php
                                                    $sender = $send->getAll($_SESSION['user_id']);
                                                    foreach ($sender as $s) {
                                                        echo "<option value='" . $s['id'] . "'>" . $s['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col col-sm-3">
                                            <div id="reg" class="reg">
                                                <div class="form-group">
                                                    <label class="control-label" for="groups">Groups*:</label><br>
                                                    <select id="groups" class="form-control" multiple="multiple"
                                                            name='groups[]'>
                                                        <?php
                                                        foreach ($gr_all as $gr) {
                                                            echo "<option value='" . $gr['id'] . "'>" . $gr['name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <p id='errorgroups' class="error text-center alert alert-danger"
                                                       style='display:none;'></p>
                                                </div>
                                                <script type="text/javascript">
                                                    $(function () {
                                                        $('#groups').multiselect({
                                                            enableFiltering: true,
                                                            templates: {
                                                                li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
                                                                filter: '<li class="multiselect-item filter"><div class="input-group">' +
                                                                    '<input class="form-control multiselect-search" type="text"></div></li>',
                                                                filterClearBtn: ''
                                                            }
                                                        });
                                                    });
                                                </script>
                                                <input type="hidden" id="campgroups" name="campgroups">
                                                <div class="radio sendingtype">
                                                    <label><input type="radio" name="sendingtype" value="broadcast"
                                                                  checked>Braodcast</label>
                                                    <label><input type="radio" name="sendingtype" value="customized">Customized
                                                    </label>
                                                </div>
                                            </div>
                                            <a id="oper" data-target="#OpModal" href="#OyModal" data-toggle="modal"  class="btn btn-primary"
                                               style="color: white !important;">Operator Contacts</a>
                                        </div>

                                        <div class="col col-sm-3" id="pri">
                                            <label class="form-control-label" for="priority"
                                                   style="margin-right: 100%;">Priority</label>
                                            <select name="priority" id="priority" style="width: 100px;"
                                                    class="form-control">
                                                <option value="1">HIGH</option>
                                                <option value="2">MEDUIM</option>
                                                <option value="3">LOW</option>
                                            </select>
                                        </div>

                                        <div class="col col-sm-3 points">
                                            <label class="form-control-label" for="point">SMS</label>
                                            <input type="text" class="form-control"
                                                   style="width: 60px; margin-left: 43%;" id="point" name="point"
                                                   readonly="true"/>
                                        </div>

                                    </div>
                                    <br>
                                    <span id="count" style="color: #38B9C2; font-weight: bolder;"></span>
                                    <br>
                                    <div class="row" id="regdiv">
                                        <div class="col col-sm-8">
                                            <div class="form-group">
                                                <label class="control-label" for="textarea" role="form"
                                                       data-toggle="validator">SMS Body*:</label>
                                                <textarea class="form-control" id="textarea" name="textarea"></textarea>
                                            </div>
                                            <div class="form-group" style="display: none;" id="textandlink"
                                                 style="display: none;">
                                                <label class="control-label" for="textarea" role="form"
                                                       data-toggle="validator">SMS Body + Landing page Link*:</label>
                                                <textarea class="form-control" id="textarea1" name="textarea1"
                                                          readonly="true"></textarea>
                                            </div>
                                            <div id="textarea_feedback"></div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col col-sm-12" style="text-align: center;">
                                            <p id='errorname' class="error text-center alert alert-danger"
                                               style='display:none;'></p>
                                        </div>
                                    </div>
                                    <!--  Advanced Campaign -->
                                    <div id="adv" style="display: none;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12"><h3>Predefined Templates</h3></div>
                                                <br/>
                                                <div class="category-filter pb-5">
                                                    <button type="button"
                                                            class="btn btn-outline-primary category-button active mr-3"
                                                            data-filter="all">All
                                                    </button>
                                                    <?php
                                                    include_once('classes/db_connect.php');
                                                    $mysql = getConnected();
                                                    $result = mysqli_query($mysql, "CALL `GetCategories`") or die("Query fail: " . mysqli_error());

                                                    //loop the result set
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        // echo $row['name'];
                                                        echo '<button type="button" class="btn btn-outline-primary category-button mr-3" data-filter="' . $row['name'] . '">' . $row['name'] . '</button>';
                                                    }
                                                    ?>
                                                    <script type="text/javascript">
                                                        $('.category-filter .category-button').categoryFilter();
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row tiles">
                                            <?php
                                            foreach ($temps as $t) {
                                                echo '<div class="col-sm-6 col-md-4 col-lg-3 filter mb-5 canvass ' . $cat->getNameByID($t['CAT_ID_FK']) . '" >
                                                <img src="img/templates_canvas/' . $t['canvas'] . '" class="img-fluid img-responsive" data-target="' . $t['id'] . '" >
                                            </div>';
                                            }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3>Used Templates</h3>
                                            </div>
                                            <br/>
                                        </div>
                                        <div class="row">
                                        </div>
                                    </div>
                                    <!--  Social Campaign -->
                                    <div id="soc" style="display: none;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12"><h3>Predefined Templates</h3></div>
                                                <br/>
                                                <div class="category-filter pb-5">
                                                    <button type="button"
                                                            class="btn btn-outline-primary category-button active mr-3"
                                                            data-filter="all">All
                                                    </button>
                                                    <?php
                                                    include_once('classes/db_connect.php');
                                                    $mysql = getConnected();
                                                    $result = mysqli_query($mysql, "CALL `GetCategories`") or die("Query fail: " . mysqli_error());

                                                    //loop the result set
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        // echo $row['name'];
                                                        echo '<button type="button" class="btn btn-outline-primary category-button mr-3" data-filter="' . $row['name'] . '">' . $row['name'] . '</button>';
                                                    }
                                                    ?>
                                                    <script type="text/javascript">
                                                        $('.category-filter .category-button').categoryFilter();
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row tiles">
                                            <?php
                                            foreach ($temps as $t) {
                                                echo '<div class="col-sm-6 col-md-4 col-lg-3 filter mb-5 canvass ' . $cat->getNameByID($t['CAT_ID_FK']) . '" >
                                                <img src="img/templates_canvas/' . $t['canvas'] . '" class="img-fluid img-responsive" data-target="' . $t['id'] . '" >
                                            </div>';
                                            }
                                            ?>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3>Used Templates</h3>
                                            </div>
                                            <br/>
                                        </div>
                                        <div class="row">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-4"><br/><br>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="control-label" for="datetimepicker5">Pick a date</label>
                                            <input type="text" class="form-control datetimepicker-input"
                                                   id="datetimepicker5" name="datetimepicker5"
                                                   data-toggle="datetimepicker" data-target="#datetimepicker5"/>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {

                                                $('#datetimepicker5').datetimepicker({
                                                    minDate: new Date(),
                                                    format: 'YYYY-MM-DD HH:mm:ss',
                                                    icons: {
                                                        time: "fa fa-clock",
                                                        date: "fa fa-calendar",
                                                        up: "fa fa-arrow-up",
                                                        down: "fa fa-arrow-down"
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div id="step-5"><br/>
                                <div class="container"><h2 style="text-align: center;">Summary: </h2>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-sm-5" id="linkpreview">
                                            <h5>Your Link</h5>
                                            <div class="thumbnail-container">
                                                <div class="thumbnail">
                                                    <iframe src="<?php echo LINK . 'c/' . $shortlink . ".php?iframe=1" ?>"
                                                            frameborder="1" onload="this.style.opacity = 1"
                                                            style="width:100%;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            Campaign Name: <span class="summary" id="scampname"></span><br/>
                                            <hr/>
                                            Campaign Type: <span class="summary" id="scamptype"></span><br/>
                                            <hr/>
                                            Sender: <span class="summary" id="ssender"></span><br/>
                                            <hr/>
                                            Selected Groups: <span class="summary" id="scampgroups"></span><br>
                                            <hr/>
                                            <div class="form-group">
                                                <label class="control-label" for="textarea" role="form">SMS
                                                    Body:</label>
                                                <textarea class="form-control" id="scampbody" readonly="true"
                                                          name="scampbody"></textarea>
                                            </div>
                                            <hr/>
                                            Sending Date: <span class="summary" id="scampdate"></span><br/>
                                            <hr/>
                                            Deduced Credits: <span class="summary" id="scredits"></span><br/>
                                            <hr/>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <input type="hidden" id="linkcampid" name="linkcampid"
                                                   value="<?php echo $campid; ?>">
                                            <input type="hidden" id="credits_" name="credits_">
                                        </div>
                                        <div class="col-sm-11">
                                            <button type="submit" class="btn btn-success" id="sumitreg"
                                                    style="width: 100%;">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <div id="smartwizard1" style='margin:0 2% 2% 2%; display: none;'>
                    <ul>
                        <li><a href="#step-11">Step 1<br/>
                                <small>Campaign Name</small>
                            </a></li>
                        <li><a href="#step-22">Step 2<br/>
                                <small>Campaign Type</small>
                            </a></li>
                        <li><a href="#step-33">Step 3<br/>
                                <small>Summary</small>
                            </a></li>
                    </ul>
                    <div id="list">
                        <div id="step-11"><br/>
                            <h2>Campaign Name: </h2><br/>
                            <div id="form-step-0" role="form" data-toggle="validator">
                                <div class="form-group">
                                    <input type="name" class="form-control" id="sgrpname" name='sgrpname'
                                           value="<?php echo $scampaign; ?>" required>
                                </div>
                                <br/>
                            </div>
                            <p id='errorname1' class="error text-center alert alert-danger" style='display:none;'></p>
                        </div>
                        <div id="step-22"><br/><br/>
                            <section id="plans">
                                <div class="container">
                                    <div class="row">
                                        <!-- item -->
                                        <div class="col-md-4 text-center">
                                            <div class="panel panel-warning panel-pricing">
                                                <div class="panel-body text-center"><i class="fab fa-facebook"></i>
                                                    <p>Social Media</p>
                                                </div>
                                                <div class="panel-footer">
                                                    <a id="social" disabled class="btn btn-lg btn-block btn-success"
                                                       style='color:white !important;font-weight: bold;' href="#">Selected</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /item -->
                                    </div>
                                    <br/><br/>
                                </div>
                            </section>
                        </div>
                        <div id="step-33"><br/>
                            <div class="container"><h2 style="text-align: center;">Summary: </h2>
                                <hr/>
                                <div class="row">
                                    <div class="col-sm-5" id="linkpreview">
                                        <h5>Your Link</h5>
                                        <div class="thumbnail-container">
                                            <div class="thumbnail">
                                                <iframe src="<?php echo LINK . 'c/' . $shortlink . ".php?iframe=1" ?>"
                                                        frameborder="1" onload="this.style.opacity = 1"
                                                        style="width:100%;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        Campaign Name: <span class="summary" id="sscampname"></span><br/>
                                        <hr/>
                                        Campaign Type: <span class="summary" id="sscamptype"></span><br/>
                                        <hr/>
                                        <div class="leader-half kids0514-share">Share this on:
                                            <a href="" class="facebook" target="_blank">
                                                <i class="fab fa-facebook" alt="Share your Link on Facebook"></i>
                                            </a>
                                            <a href="" class="twitter" target="_blank">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a class="google" href="" target="_blank">
                                                <i class="fab fa-google-plus-g"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!-- tab pane-->
            <div class="tab-pane active" id="vieww" name='vieww' role="tabpanel" style="padding: 15px;">
                <br/>
                <div class='cont'>
                    <table id='table' class="table  table-bordered hover" style="width:100%">
                        <thead>
                        <tr>
                            <th style="width: 10% !important;">Name</th>
                            <th style="width: 10% !important;">Type</th>
                            <th style="width: 10% !important;">Status</th>
                            <th style="width: 20% !important;">SMS Body</th>
                            <th style="width: 10% !important;">Sending Date</th>
                            <th style="width: 10% !important;">Sender</th>
                            <th style="width: 10% !important;">Zain Approval</th>
                            <th style="width: 10% !important;">Progress</th>
                            <th class="text-center">Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($viewcamp as $cmp) {
                            ?>
                            <tr id='<?php echo $cmp['id']; ?>' class="campidtable">
                                <td><?php echo $cmp['name']; ?></td>
                                <td><?php echo $cmp['type']; ?></td>
                                <?php
                                if ($cmp['sent'] == '1') {
                                    echo '<td style="color: #4CB848; font-weight: bolder">SENT</td>';
                                } else if (($cmp['type'] == 'social') &&($cmp['sent'] == '')) {
                                    echo '<td style="color: #38B9C2; font-weight: bolder">Social</td>';
                                } else  if ($cmp['sent'] == '0') {
                                    echo '<td style="color: #EB078C; font-weight: bolder">IN QUEUE</td>';
                                }
                                else  if ($cmp['sent'] == '-2') {
                                    echo '<td style="color:red; font-weight: bolder">STOPPED</td>';
                                }
                                else  if ($cmp['sent'] == '-1') {
                                    echo '<td style="color: #0055aa; font-weight: bolder">WAITING</td>';
                                }
                                ?>
                                <td><?php if ($cmp['body'] === NULL) {
                                        echo "Social Campaign !";
                                    } else  echo substr($cmp['body'], 0, 60)."..."; ?></td>
                                <td><?php if ($cmp['sending_date'] === NULL) {
                                        echo $cmp['created_at'];
                                    } else  echo $cmp['sending_date']; ?></td>
                                <td><?php if ($cmp['SENDER_FK_ID'] === NULL) {
                                        echo "Social Campaign !";
                                    } else  echo $cmp['SENDER_FK_ID']; ?></td>
                                <td><?php if ($cmp['approved'] == 1) {
                                        echo "<span style='color: #4CB848;font-weight: bolder'> YES </span>";
                                    } else if ($cmp['approved'] == 0) {
                                        echo "<span style='color: #9153A1;font-weight: bolder'> WAITING</span>";
                                    } else {
                                        echo "<span style='color: #EB078C;font-weight: bolder'> REJECTED</span>";
                                    } ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="myBar_<?php echo $cmp['id'] ; ?>" class="progress-bar" role="progressbar"
                                              aria-valuemin="0" aria-valuemax="100" style="width:1%; background-color: #38B9C2; border-radius: 8px;">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 text-center">
                                        <p id="h5_<?php echo $cmp['id'] ; ?>">&nbsp;</p>
                                        <span><i id="perc_<?php echo $cmp['id'] ; ?>"></i></span>
                                    </div>
                                    <script>

                                  $(document).ready(function () {
                                      var sse = $.SSE("./test1.php?US_ID=<?php echo $_SESSION['user_id'] ; ?>&job_id=<?php echo $cmp['id'] ; ?>", {
                                          onMessage: function(event){
                                              var str = event.data.split("-");
                                              var perc = (str[1] * 100) / str[0];
                                              if(str[1]==str[0]) {
                                                  $("#myBar_<?php echo $cmp['id']; ?>").css('background-color', "green");
                                                  sse.stop();
                                              }
                                              $("#myBar_<?php echo $cmp['id'] ; ?>").css('width', perc+"%");
                                              $("#h5_<?php echo $cmp['id'] ; ?>").html(str[1] + " / "+str[0]);
                                              $("#perc_<?php echo $cmp['id'] ; ?>").html(Math.round(perc)+"%");
                                              //console.log("Message"); console.log(e);
                                          }
                                      });
                                      sse.start();
                                  });
                                    </script>
                                </td>
                                <?php if ($cmp['sent'] != '1') { ?>
                                    <td class="text-center">
                                        <a href="#" title='Delete Campaign' class="btn btn-danger btn-sm delete">
                                            <i class="fa fa-trash-alt" style='color:white;'></i>
                                        </a>
                                          <a href="#" title='Stop Campaign'  class="btn btn-warning btn-sm stop " >
                                                <i class="fas fa-stop-circle"  style='color:white;'></i>
                                          </a>
                                    </td>
                                <?php } else {
                                    echo '<td class="text-center">
                                              <a href="./campreports.php?i=' . $cmp["id"] . '" title="View Report" id="viewreport"  class="btn btn-success btn-sm">
                                           <i class="fas fa-chart-bar" style="color:white;"></i>
                                        </a>              
                                            </td>';
                                } ?>
                            </tr>
                        <?php } ?>

                        <?php // social campaign
                        foreach ($socialcamp as $cmp) {
                            //  echo $g['']
                            ?>
                            <tr id='<?php echo $cmp['id']; ?>' class="campidtable">
                                <td><?php echo $cmp['name']; ?></td>
                                <td><?php echo $cmp['type']; ?></td>
                                <?php
                                if ($cmp['CMP_STATUS'] == 'SENT') {
                                    echo '<td style="color: #4CB848; font-weight: bolder">' . $cmp['CMP_STATUS'] . '</td>';
                                } else if ($cmp['CMP_STATUS'] == 'SOCIAL') {
                                    echo '<td style="color: #38B9C2; font-weight: bolder">' . $cmp['CMP_STATUS'] . '</td>';
                                } else {
                                    echo '<td style="color: #EB078C; font-weight: bolder">' . $cmp['CMP_STATUS'] . '</td>';
                                }
                                ?>
                                <td>Social Campaign</td>
                                <td><?php echo $cmp['created_at']; ?></td>
                                <td><?php echo "Social Campaign !"; ?></td>
                                <td style="text-align: center;"><a href="./campreports.php?i=<?php echo $cmp['id']; ?>"
                                                                   title='View Report' id="viewreport"
                                                                   class="btn btn-success btn-sm">
                                        <i class="fas fa-chart-bar" style="color:white;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>


            </div><!-- tab pane-->
            <div class="tab-pane " id="sch" name="sch" role="tabpanel" style="padding: 15px;">
                <table id='scheduledtable' class="table  table-bordered hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>SMS Body</th>
                        <th>Sending Date</th>
                        <th>Sender</th>
                        <th class="text-center">Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($scheduledcamp as $cmp) {
                        //  echo $g['']
                        ?>
                        <tr id='<?php echo $cmp['id']; ?>'>
                            <td><?php echo $cmp['name']; ?></td>
                            <td><?php echo $cmp['type']; ?></td>
                            <td style="color: #EB078C; font-weight: bolder"><?php echo $cmp['CMP_STATUS']; ?></td>
                            <td><?php if ($cmp['body'] === NULL) {
                                    echo "Social Campaign !";
                                } else  echo $cmp['body']; ?></td>
                            <td><?php if ($cmp['date'] === NULL) {
                                    echo $cmp['created_at'];
                                } else  echo $cmp['date']; ?></td>
                            <td><?php if ($cmp['S_NAME'] === NULL) {
                                    echo "Social Campaign !";
                                } else  echo $cmp['S_NAME']; ?></td>
                            <td class="text-center">
                                <a href="#" title='Delete Group' class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash-alt" style='color:white;'></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function () {
                        $("#scheduledtable").dataTable().fnDestroy();
                        $("#scheduledtable").DataTable({
                            responsive: true,
                            "pagingType": "full_numbers"
                        });
                        $("#table").dataTable().fnDestroy();
                        $("#table").DataTable({
                            responsive: true,
                            "pagingType": "full_numbers"
                        });
                    });
                </script>
            </div><!-- tab pane-->
            <div class="tab-pane " id="sent" name="sent" role="tabpanel" style="padding: 15px;">
                <br>
                <table id='senttable' class="table  table-bordered hover" style="width:100%; ">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>SMS Body</th>
                        <th>Sending Date</th>
                        <th>Sender</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sentcamp as $cmp) {
                        //  echo $g['']
                        ?>
                        <tr id='<?php echo $cmp['id']; ?>' class="campidtable">
                            <td><?php echo $cmp['name']; ?></td>
                            <td><?php echo $cmp['type']; ?></td>
                            <?php
                            if ($cmp['CMP_STATUS'] == 'SOCIAL') {
                                echo '<td style="color: #38B9C2; font-weight: bolder">' . $cmp['CMP_STATUS'] . '</td>';
                            } else {
                                echo '<td style="color: #4CB848; font-weight: bolder">' . $cmp['CMP_STATUS'] . '</td>';
                            }
                            ?>
                            <td><?php if ($cmp['body'] === NULL) {
                                    echo "Social Campaign !";
                                } else  echo $cmp['body']; ?></td>
                            <td><?php if ($cmp['date'] === NULL) {
                                    echo $cmp['created_at'];
                                } else  echo $cmp['date']; ?></td>
                            <td><?php if ($cmp['S_NAME'] === NULL) {
                                    echo "Social Campaign !";
                                } else  echo $cmp['S_NAME']; ?></td>
                            <td><a href="./campreports.php?i=<?php echo $cmp['id']; ?>" title='View Report'
                                   id="viewreports" class="btn btn-success btn-sm">
                                    <i class="fas fa-chart-bar" style="color:white;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php }
                    foreach ($socialcamp as $cmp) {
                        //  echo $g['']
                        ?>
                        <tr id='<?php echo $cmp['id']; ?>' class="campidtable">
                            <td><?php echo $cmp['name']; ?></td>
                            <td><?php echo $cmp['type']; ?></td>
                            <?php
                            if ($cmp['CMP_STATUS'] == 'SENT') {
                                echo '<td style="color: #4CB848; font-weight: bolder">' . $cmp['CMP_STATUS'] . '</td>';
                            } else if ($cmp['CMP_STATUS'] == 'SOCIAL') {
                                echo '<td style="color: #38B9C2; font-weight: bolder">' . $cmp['CMP_STATUS'] . '</td>';
                            } else {
                                echo '<td style="color: #EB078C; font-weight: bolder">' . $cmp['CMP_STATUS'] . '</td>';
                            }
                            ?>
                            <td>Social Campaign</td>
                            <td><?php echo $cmp['created_at']; ?></td>
                            <td><?php echo "Social Campaign !"; ?></td>
                            <td><a href="./campreports.php?i=<?php echo $cmp['id']; ?>" title='View Report'
                                   id="viewreports" class="btn btn-success btn-sm">
                                    <i class="fas fa-chart-bar" style="color:white;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function () {
                        $("#senttable").dataTable().fnDestroy();
                        $("#senttable").DataTable({
                            responsive: true,
                            "pagingType": "full_numbers"
                        });
                    });
                </script>
            </div><!-- tab pane-->
            <div class="tab-pane " id="pending" name="pending" role="tabpanel" style="padding: 15px;">
                <table id='pendingtable' class="table  table-bordered hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>SMS Body</th>
                        <th>Sending Date</th>
                        <th>Sender</th>
                        <th class="text-center">Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pendingcamp as $cmp) {
                        //  echo $g['']
                        ?>
                        <tr id='<?php echo $cmp['id']; ?>'>
                            <td><?php echo $cmp['name']; ?></td>
                            <td><?php echo $cmp['type']; ?></td>
                            <td style="color: #EB078C; font-weight: bolder"><?php echo $cmp['CMP_STATUS']; ?></td>
                            <td><?php if ($cmp['body'] === NULL) {
                                    echo "Social Campaign !";
                                } else  echo $cmp['body']; ?></td>
                            <td><?php if ($cmp['date'] === NULL) {
                                    echo $cmp['created_at'];
                                } else  echo $cmp['date']; ?></td>
                            <td><?php if ($cmp['S_NAME'] === NULL) {
                                    echo "Social Campaign !";
                                } else  echo $cmp['S_NAME']; ?></td>
                            <td class="text-center">
                                <a href="#" title='Delete Group' class="btn btn-danger btn-sm delete">
                                    <i class="fa fa-trash-alt" style='color:white;'></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function () {
                        $("#pendingtable").dataTable().fnDestroy();
                        $("#pendingtable").DataTable({
                            responsive: true,
                            "pagingType": "full_numbers"
                        });
                        $('.delete').click(function (e) {
                            e.preventDefault();
                            var campid = $('.campidtable').attr('id');

                            var formData = {
                                'campid': campid
                            };
                            console.log(formData);
                            if (confirm("do you really want to delete this campaign")) {
                                $.ajax({
                                    url: "./requests/campaigns/delete.php",
                                    type: "post",
                                    data: formData,
                                    success: function (d) {
                                        $.notify("Campaign Deleted", "error");
                                        console.log(d);
                                        window.setTimeout(function () {
                                            location.href = 'campaigns.php';
                                        }, 2000);

                                    }
                                });
                            } else {

                            }


                        });
                    });
                </script>
            </div><!-- tab pane-->
            <div class="tab-pane " id="delet" name="delet" role="tabpanel" style="padding: 15px;">
                <table id='deletetable' class="table  table-bordered hover" style="width:100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>SMS Body</th>
                        <th>Sending Date</th>
                        <th>Sender</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($deletedcamp as $cmp) {
                        //  echo $g['']
                        ?>
                        <tr id='<?php echo $cmp['id']; ?>'>
                            <td><?php echo $cmp['name']; ?></td>
                            <td><?php echo $cmp['type']; ?></td>
                            <td style="color: #EB078C; font-weight: bolder">Deleted</td>
                            <td><?php if ($cmp['body'] === NULL) {
                                    echo "Social Campaign !";
                                } else  echo $cmp['body']; ?></td>
                            <td><?php if ($cmp['date'] === NULL) {
                                    echo $cmp['created_at'];
                                } else  echo $cmp['date']; ?></td>
                            <td><?php if ($cmp['S_NAME'] === NULL) {
                                    echo "Social Campaign !";
                                } else  echo $cmp['S_NAME']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function () {
                        $("#deletetable").dataTable().fnDestroy();
                        $("#deletetable").DataTable({
                            responsive: true,
                            "pagingType": "full_numbers"
                        });
                    });
                </script>
            </div><!-- tab pane-->

        </div>
    </div>
    <div>
        <script>



            function nl2br(str, is_xhtml) {
                if (typeof str === 'undefined' || str === null) {
                    return '';
                }
                var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
                return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
            }

            var typee = '<?php echo $cmtype; ?>';

            console.log(typee);
            var redirect = '<?php echo $shortlink; ?>';// check if the page is redirected to campaign page


            $(document).ready(function () {

                var urll = window.location;

                var countt = 0;
                var points = 0;
                $.ajaxSetup({cache: false}); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
                // setInterval(function () {
                //     $('#table').load('./requests/campaigns/getCampaigns.php');
                //     $('#scheduledtable').load('./requests/campaigns/getscheduledcampaigns.php');
                //     $('#senttable').load('./requests/campaigns/getsentcampaigns.php');
                // }, 10000);
                $('#groups').on('change', function (e) {
                    var count = 0;
                    groups = $(this).val();
                    var formData = {
                        'groups': groups
                    };
                    $.ajax({
                        url: "./requests/contacts/getcount.php",
                        type: "post",
                        data: formData,
                        success: function (d) {
                            count = d;
                            if (d > 0) {
                                $.notify(count + " contacts selected", "info");
                                //$("#count").html(d+' contacts selected');
                            }
                            countt = d;
                        }
                    });
                });

                $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'circles',
                    transitionEffect: 'slide',
                    anchorSettings: {
                        markDoneStep: true, // add done css
                        markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                        removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be clea#EB078C
                        enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                    }
                });
                $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                    // var elmForm = $("#form-step-" + stepNumber);
                    //alert(stepNumber);
                    if ((stepNumber === 0) && (stepDirection === 'forward')) {
                        if ($('#grpname').val() == '') {
                            $('#errorname1').css('display', 'block');
                            $('#errorname1').html('Please Fill the Campaign name');
                            return false;
                        } else {
                            $('#errorname1').css('display', 'none');
                            $('.sw-btn-next').css('display', 'none');
                        }
                    } else {
                        $('.sw-btn-next').css('display', 'block');
                    }
                    if ((stepNumber === 2) && (stepDirection === 'forward')) {

                        if (($('#textarea').val() == '') || ($('#groups').val() == '') || ($('#sender').val() == 'null')) {

                            $('#errorname').css('display', 'block');
                            $('#errorname').html('Please fill all the above data !!');
                            return false;
                        }
                        if (($('#textarea').val() != '') && ($('#groups').val() != '') && ($('#sender').val() != 'null')) {
                            // alert($('#groups').val());
                            $('#errorname').css('display', 'none');
                            $('#errorname').html('');
                            // return false;
                        }

                        if ((stepNumber == 1) && $('#step-3').css('display') == 'block') {
                            console.log('dddas')
                        }

                        $('#campgroups').val($('#groups').val());
                    }
                    return true;
                });
                $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {

                    if (stepNumber == 4) {
                        $('#scampname').html($('#grpname').val());
                        $('#scamptype').html(typee);
                        $('#ssender').html($('#sender').find(":selected").text());
                        var groups = $('#groups').find(":selected").text();
                        ;
                        $('#scampgroups').html(groups);
                        if (redirect == '') {
                            $('#scampbody').html($('#textarea').val());
                        } else {
                            $('#scampbody').html($('#textarea1').val());
                        }
                        $('#scampdate').html($('#datetimepicker5').val());
                        $('#scredits').html(points * countt);
                        $('#credits_').val(points * countt);
                    }

                    if (stepNumber == 4) {
                        $('.sw-btn-next').css('display', 'none');
                        // $('.sw-btn-prev').css('display', 'none');
                        //$('.btn-n').removeClass('disabled');
                    }
                });
                // SMART WIZARD 1 FOR SOCIAL

                $('#smartwizard1').smartWizard({
                    selected: 0,
                    theme: 'circles',
                    transitionEffect: 'slide',
                    anchorSettings: {
                        markDoneStep: true, // add done css
                        markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                        removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be clea#EB078C
                        enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                    }
                });

                $("#smartwizard1").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                    // var elmForm = $("#form-step-" + stepNumber);
                    //alert(stepNumber);
                    if ((stepNumber === 0) && (stepDirection === 'forward')) {

                    } else {
                        -
                            $('.sw-btn-next').css('display', 'block');
                    }

                    return true;
                });
                $("#smartwizard1").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
                    // Enable finish button only on last step
                    //stepNumber);
                    //alert(stepNumber);
                    if (stepNumber == 2) {
                        $('#sscampname').html($('#sgrpname').val());
                        $('#sscamptype').html(typee);
                    }

                    if (stepNumber == 4) {
                        $('.sw-btn-next').css('display', 'none');
                        // $('.sw-btn-prev').css('display', 'none');
                        //$('.btn-n').removeClass('disabled');
                    }
                });

                // end social


                if ((redirect != '') && (typee == 'advanced')) {
                    typee = 'advanced';
                    $('.view').removeClass('active');
                    $('#newtab').addClass('active');
                    $('#vieww').removeClass('active');
                    $('#new').addClass('active');
                    $('#adv').css('display', 'none');
                    $('#linkpreview').css('display', 'block');
                    $('#textandlink').css('display', 'block');
                    $('#camptitle').html('Advanced Campaign');
                    console.log(redirect);
                    $('#advanced').html('Selected'); //after doing the page builder, this redirect to camp page and select advanced by default

                } else if ((redirect != '') && (typee == 'social')) {
                    typee = 'social';
                    $('.view').removeClass('active');
                    $('#newtab').addClass('active');
                    $('#vieww').removeClass('active');
                    $('#new').addClass('active');
                    $('#adv').css('display', 'none');
                    $('#linkpreview').css('display', 'block');
                    $('#textandlink').css('display', 'none');
                    $('#camptitle').html('Social Campaign');
                    $('#st4').css('display', 'none');
                    $('#st5').css('display', 'none');
                    $('#smartwizard').css('display', 'none');
                    $('#smartwizard1').css('display', 'block');
                    $('.facebook').attr('href', 'https://facebook.com/sharer.php?u=' + '<?php echo LINK; ?>c/' + redirect + '.php');
                    $('.twitter').attr('href', 'https://twitter.com/intent/tweet?url=' + '<?php echo LINK; ?>c/' + redirect + '.php');
                    $('.google').attr('href', 'https://plus.google.com/share?url=' + '<?php echo LINK; ?>c/' + redirect + '.php');
                    $('#social').html('Selected'); //after doing the page builder, this redirect to camp page and select advanced by default
                    $('#sscampname').html($('#grpname').val());
                    $('#sscamptype').html(typee);
                } else {
                    $('#linkpreview').css('display', 'none');
                    // location.href='./campaigns.php#step-1';
                }
                $(window).keydown(function (event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
                $('.canvass').click(function () {

                    // $('.canvass').append('test');
                    var targett = $(this).find("img").attr('data-target');
                    // var sender = $('#sender').val();
                    // alert(targett);
                    var campname = $('#grpname').val();
                    var formData = {
                        'campname': campname,
                        'camptype': typee,
                        'template': targett,
                    };
                    console.log(formData);
                    //insert new campaign and new land page ID
                    $.ajax({
                        url: "./requests/campaigns/add_advanced.php",
                        type: "post",
                        data: formData,
                        success: function (d) {
                            $.notify("You will be redirected to Page Builder", "info");
                            console.log(d);
                            window.setTimeout(function () {
                                location.href = 'grapjs/index.php?p=' + targett + '&r=' + d;
                            }, 2000);

                        }
                    });
                });


                $('#textarea').keyup(function () {
                    //  console.log(typee);
                    var text_length = 0;
                    var text = '';
                    var link = '<?php echo LINK; ?>c/' + redirect + '.php';
                    var radio = $('input[name=sendingtype]:checked').val();
                    //  alert( $('#textarea').val().length);
                    // alert(radio);
                    if (redirect != '') {
                        if (radio == 'customized') {
                            link += "?t=xxxxxx";
                            $('#textarea1').val($('#textarea').val() + '\n' + link);
                            text_length = $('#textarea').val().length + link.length;
                        } else {
                            $('#textarea1').val($('#textarea').val() + '\n' + link);
                            text_length = $('#textarea').val().length + link.length;
                        }

                        text = $('#textarea1').val();
                    } else {
                        text_length = $('#textarea').val().length;
                        text = $('#textarea').val();
                    }
                    if (text.match(/[\u0600-\u06FF]/)) { //arabic char

                        if (typee == 'regular') { //regular campaign
                            $('#point').val('1');
                            if ((text_length > 70) && (text_length <= 133)) {
                                $('#point').val('2');
                            }
                            if ((text_length > 133) && (text_length <= 200)) {
                                $('#point').val('3');
                            }
                            if ((text_length > 200) && (text_length <= 267)) {
                                $('#point').val('4');
                            }
                            if ((text_length > 267) && (text_length <= 334)) {
                                $('#point').val('5');
                            }
                            if ((text_length > 334) && (text_length <= 400)) {
                                $('#point').val('6');
                            }
                        } else { // advanced campaign
                            $('#point').val('1');
                            if ((text_length > 70) && (text_length <= 133)) {
                                $('#point').val('2');
                            }
                            if ((text_length > 133) && (text_length <= 200)) {
                                $('#point').val('3');
                            }
                            if ((text_length > 200) && (text_length <= 267)) {
                                $('#point').val('4');
                            }
                            if ((text_length > 267) && (text_length <= 334)) {
                                $('#point').val('5');
                            }
                            if ((text_length > 334) && (text_length <= 400)) {
                                $('#point').val('6');
                            }
                        }
                    } else {

                        if (typee == 'regular') { //regular campaign
                            $('#point').val('1');
                            if ((text_length > 160) && (text_length <= 320)) {
                                $('#point').val('2');
                            }
                            if ((text_length > 320) && (text_length <= 459)) {
                                $('#point').val('3');
                            }
                            if ((text_length > 459) && (text_length <= 612)) {
                                $('#point').val('4');
                            }
                            if ((text_length > 612) && (text_length <= 764)) {
                                $('#point').val('5');
                            }
                            if ((text_length > 764) && (text_length <= 800)) {
                                $('#point').val('6');
                            }
                        } else { //advanced campaign
                            $('#point').val('1');
                            if ((text_length > 160) && (text_length <= 320)) {
                                $('#point').val('2');
                            }
                            if ((text_length > 320) && (text_length <= 459)) {
                                $('#point').val('3');
                            }
                            if ((text_length > 459) && (text_length <= 612)) {
                                $('#point').val('4');
                            }
                            if ((text_length > 612) && (text_length <= 764)) {
                                $('#point').val('5');
                            }
                            if ((text_length > 764) && (text_length <= 800)) {
                                $('#point').val('6');
                            }
                        }
                    }


                    points = $('#point').val();
                    $('#textarea_feedback').html(text_length + ' characters');
                });
                $('.panel-footer > .btn').on('click', function (event) {
                    event.preventDefault();
                    typee = $(this).attr('id');
                    if (typee == 'regular') {
                        $('#reg').css('display', 'block');
                        $('.sendingtype').css('display', 'none');
                        $('#adv').css('display', 'none');
                        $('#soc').css('display', 'none');
                        $('#regular').html('Selected');
                        $('#advanced').html('Select');
                        $('#social').html('Select');
                        $('#camptype').html('Regular Campaign');
                        $('#camptitle').html('Regular Campaign');
                        $('#smartwizard').smartWizard("next");
                        $('#camptype').val(typee);
                    }
                    if ((typee == 'advanced') && (redirect == '')) {
                        $('#adv').css('display', 'block');
                        $('#reg').css('display', 'none');
                        $('#soc').css('display', 'none');
                        $('.sender').css('display', 'none');
                        $('.points').css('display', 'none');
                        $('#regdiv').css('display', 'none');
                        $('#pri').css('display', 'none');
                        $('#oper').css('display', 'none');
                        $('#advanced').html('Selected');
                        $('#regular').html('Select');
                        $('#social').html('Select');
                        $('#camptype').html('Advanced Campaign');
                        $('#camptitle').html('Advanced Campaign');
                        $('#smartwizard').smartWizard("next");
                        $('#camptype').val(typee);
                        $('body').scrollTo('420px', 800);
                    }
                    if ((typee == 'advanced') && (redirect != '')) {
                        $('#adv').css('display', 'none');
                        $('#reg').css('display', 'block');
                        $('#regdiv').css('display', 'block');
                        $('#pri').css('display', 'block');
                        $('#oper').css('display', 'block');
                        $('.sender').css('display', 'block');
                        $('.points').css('display', 'block');
                        $('#soc').css('display', 'none');
                        $('#advanced').html('Selected');
                        $('#regular').html('Select');
                        $('#social').html('Select');
                        $('#camptype').html('Advanced Campaign');
                        $('#camptitle').html('Advanced Campaign');
                        $('#smartwizard').smartWizard("next");
                        $('#camptype').val(typee);
                    }
                    if (typee == 'social') {
                        $('#soc').css('display', 'block');
                        $('#reg').css('display', 'none');
                        $('#adv').css('display', 'none');
                        $('#regdiv').css('display', 'none');
                        $('.points').css('display', 'none');
                        $('#social').html('Selected');
                        $('#regular').html('Select');
                        $('#advanced').html('Select');
                        $('#camptype').html('Social Campaign');
                        $('#camptitle').html('Social Campaign');
                        $('#smartwizard').smartWizard("next");
                        $('#scamptype').val(typee);
                    }
                });
                $('#campaign').on('submit', function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: 'requests/campaigns/add.php',
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            // alert(data);
                            if (data == 'OK') {
                                $.notify("Campaign has been created successfully..", "success");

                                window.setTimeout(function () {
                                    //location.href='./campaigns.php';
                                    $('#result').html(data);
                                }, 2000);
                                console.log(data);
                            } else {

                                $.notify("Not enough credits, please contact the administrator", "error");
                            }
                        }
                    })
                });
            });
        </script>
