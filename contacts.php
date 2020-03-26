<?php
ob_start();
session_start();
include_once('classes/login.php');
include_once('classes/groups.php');
include_once('classes/contacts.php');
$log = new login();
$gr = new groups();
$cr = new contacts();
$res = $log->checklogin();

if ((isset($_GET['grid'])) && ($_GET['grid'] != 0)) {
    $cr_all = $cr->getRowByGRID($_GET['grid'], $_SESSION['user_id']);
} else {
    $cr_all = $cr->getAll($_SESSION['user_id']);
}


$gr_all = $gr->getAll($_SESSION['user_id']);

//print_r($cr_all);
if (!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>

<script>

    $(document).ready(function (e) {
        let jQuery = $('#table').DataTable({
            responsive: true,
            "pagingType": "full_numbers"
        });

        function phonenumber(inputtxt) {
            var phoneno = /^\d{13}$/;
            var phonenon = /^\d{11}$/;
            if (((inputtxt.value.match(phoneno))) && (inputtxt.slice(0, 3) == '964')) {
                return true;
            } else {
                alert("message");
                return false;
            }
        }

        $('.add_contact').on('click', function (event) {
            // alert($('.name_').val());
            var msisdn = $('#msisdn').val();
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var email = $('#email').val();
            var address = $('#address').val();
            var gender = $('input[name=gender]:checked').val();
            var groups = $('#groups').val();
            var userid = <?php echo $_SESSION['user_id']; ?>;
            // alert(gender);
            var check = 0;

            if (msisdn == '' && groups == '') {
                $('#errorphone').css('display', 'block');
                $('#errorphone').html('Required field <i class="fa fa-exclamation"></i>');
                $('#errorgroups').css('display', 'block');
                $('#errorgroups').html('Required field <i class="fa fa-exclamation"></i>');
                check = 0;
            } else if (msisdn == '' && groups != '') {
                $('#errorphone').css('display', 'block');
                $('#errorphone').html('Required field <i class="fa fa-exclamation"></i>');
                $('#errorgroups').css('display', 'none');
                check = 0;
            } else if (msisdn != '' && groups == '') {
                $('#errorphone').css('display', 'none');
                $('#errorgroups').css('display', 'block');
                $('#errorgroups').html('Required field <i class="fa fa-exclamation"></i>');
                check = 0;
            } else {
                if (msisdn.length == '11') {
                    msisdn = msisdn.substring(1);
                    msisdn = "964" + msisdn;
                }
                if ((msisdn.length == '15') && (msisdn.slice(0, 2)) == "00") { //00964
                    msisdn = msisdn.substring(2);
                }
                if ((msisdn.length == '14') && (msisdn.slice(0, 1)) == "+") { //+964
                    msisdn = msisdn.substring(1);
                }
                if (msisdn.length == '10') {
                    //msisdn = msisdn.substring(1);
                    msisdn = "964" + msisdn;
                }
                console.log(msisdn);
                if (msisdn.length < 10) {
                    $('#errorphone').css('display', 'block');
                    $('#errorphone').html('Not Valid..<i class="fa fa-exclamation"></i>');
                    check = 0;
                } else if ((msisdn.length == '13') && (msisdn.substring(0, 3) != "964")) {
                    $('#errorphone').css('display', 'block');
                    $('#errorphone').html('Not Valid.. should starts with 964 <i class="fa fa-exclamation"></i>');
                    check = 0;
                } else if ((msisdn.substring(3, 5) !== "78") && (msisdn.substring(3, 5) !== "79")) {
                    $('#errorphone').css('display', 'block');
                    $('#errorphone').html('Not Valid.. Not Zain customer (78 or 79) <i class="fa fa-exclamation"></i>');
                    check = 0;
                } else {
                    check = 1;
                }
                console.log(msisdn.substring(3, 5));

            }
            if (check === 1) {
                $('#errorphone').css('display', 'none');
                $('#errorgroups').css('display', 'none');
                //alert(msisdn);
                event.preventDefault();
                $.ajax({
                    url: "./requests/contacts/addcontact.php",
                    type: "GET",
                    data: 'fname=' + fname + '&lname=' + lname + '&email=' + email + '&address=' + address + '&gender=' + gender + '&groups=' + groups + ',&msisdn=' + msisdn + '&user_id=' + userid,
                    success: function (data) {
                        console.log(data);
                        // window.location.href = 'your_url';
                        $.notify("New Contact has been Added.", "success");
                        // window.setTimeout(function () {
                        //  location.reload();
                        //   location.href = "<?php echo LINK; ?>/contacts.php#view";
                        //  }, 1000);
                    },
                    error: function () {

                    }
                });
            }
        });
    });
</script>
<body class='bg'>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="id">ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fid" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name</label>
                        <div class="col-sm-10">
                            <input type="name" class="form-control" id="t">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="description">Description</label>
                        <div class="col-sm-10">
                            <textarea type="name" class="form-control" id="b"></textarea>
                        </div>
                    </div>
                </form>
                <!-- Form Delete Post -->
                <div class="deleteContent">
                    Are You sure want to delete <span class="title"></span>?
                    This contact will be removed from all assigned groups !
                    <span class="hidden id"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn actionBtn" data-dismiss="modal">
                    <span id="footer_action_button" class="glyphicon"></span>
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class="glyphicon glyphicon"></span>close
                </button>
            </div>
        </div>
    </div>
</div>
<?php include('includes/nav.php'); ?>
<h1 class='titlee'> Contacts</h1><br/>
<!-- Begin page content -->
<div class="container-fluid" style='padding:3% !important;'>
    <div id="navbar-example">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" id='navitm'>
                <a class="nav-link active view" data-toggle="tab" href="#vieww" role="tab">View/ Edit Contact</a>
            </li>
            <li class="nav-item" id='navitm'>
                <a class="nav-link  new" data-toggle="tab" href="#new" role="tab">New Contact</a>
            </li>

            <li class="nav-item" id='navitm'>
                <a class="nav-link upload" data-toggle="tab" href="#up" role="tab">Upload Contacts</a>
            </li>
        </ul>
        <!-- Tab panes {Fade}  -->
        <div class="tab-content" id='content1'>
            <div class="tab-pane" id="new" name="new" role="tabpanel"><br/>
                <form method='post' action='groups.php'>
                    <h3 style='text-align:center;'>Add Contact</h3>
                    <hr/>
                    <div class='row' style='margin:0 2% 2% 2%;'>
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label class="control-label" for="fname">First Name :</label>
                                <input type="text" class="form-control fname" id="fname" name="fname"
                                       placeholder="First Name">
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label class="control-label" for="lname">Last Name:</label>
                                <input type="text" class="form-control" id="lname" name="lname"
                                       placeholder="Last Name">
                            </div>
                        </div>
                    </div>
                    <div class='row' style='margin:0 2% 2% 2%;'>
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label class="control-label" for="msisdn">Phone Number*:</label>
                                <input type="number" class="form-control" id="msisdn" name="msisdn"
                                       placeholder="Phone Number">
                                <p id='errorphone' class="error text-center alert alert-danger"
                                   style='display:none;'></p>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label class="control-label" for="email">Email:</label>
                                <input type="email" class="form-control fname" id="email" name="email"
                                       placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class='row' style='margin:0 2% 2% 2%;'>
                        <div class='col-sm-3'>
                            <div class="form-group">
                                <label class="control-label" for="groups">Groups*:</label><br/>
                                <select id="groups" multiple="multiple" name='groups'>
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
                                            filter: '<li class="multiselect-item filter"><div class="input-group"><input class="form-control multiselect-search" type="text"></div></li>',
                                            filterClearBtn: ''
                                        },

                                        onInitialized: function (select, container) {
                                            // hide checkboxes
                                            // container.find('input[type=checkbox]').addClass('d-none');
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <div class='col-sm-3'>
                            <div class="form-group">Gender:<br/>
                                <div data-toggle="buttons" class='radio' style='margin-top:2%;'>
                                    <label class="btn btn-primary btn-circle btn-lg" title='Male'> <input type="radio"
                                                                                                          name="gender"
                                                                                                          value="male"><i
                                                class="fa fa-male"></i></label>
                                    <label class="btn btn-danger  btn-circle btn-lg" title='Female'><input type="radio"
                                                                                                           name="gender"
                                                                                                           value="female"><i
                                                class="fa fa-female"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <label class="control-label" for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address"
                                       placeholder="Address">
                            </div>
                        </div>
                    </div>
                    <div style='margin: 0 auto;text-align:center;'>
                        <a class="btn btn-warning add_contact" style='width:300px;'>
                            <span class="fa fa-plus"></span>&nbsp;&nbsp;&nbsp;&nbsp;Save Contact
                        </a><br/><br/>
                    </div>
                </form>
            </div>
            <div class="tab-pane active" id="vieww" name='vieww' role="tabpanel">
                <br/>
                <div class='cont'>
                    <table id='table' class="table  table-bordered hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>Phone</th>
                            <th>Name</th>
                            <th>Groups</th>
                            <th>Email</th>
                            <th class="text-center">

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($cr_all != "") {
                            foreach ($cr_all as $cc) {
                                ?>
                                <tr class='group<?php echo $cc['id']; ?>'>
                                    <td style="width:15% !important; "><?php echo $cc['MSISDN']; ?></td>
                                    <td style="width:15% !important;"><?php echo $cc['firstname'] . " " . $cc['lastname']; ?></td>
                                    <?php
                                    $p = "";
                                    $grs = $cc['GRS_ID_FK'];
                                    $gr = explode(",", $grs);
                                    //if($gr[2])
                                    foreach ($gr_all as $grp) {
                                        if (in_array($grp['id'], $gr)) {
                                            if ($gr[1] == "")
                                                $p .= $grp['name'];
                                            else {
                                                $p .= $grp['name'] . ", ";
                                            }
                                        } else {

                                        }
                                    }
                                    if (substr($p, -2) == ", ") {
                                        $p = substr($p, 0, -2);
                                    }
                                    $email = "";
                                    if (strlen($cc['email']) > 20) {
                                        $email = substr($cc['email'], 0, 20) . "...";
                                    } else {
                                        $email = $cc['email'];
                                    }
                                    ?>
                                    <td style="width:25% !important;"><?php echo $p; ?></td>
                                    <td style="width:20% !important;"
                                        title="<?php echo $email; ?>"><?php echo $email; ?></td>
                                    <td class="text-center" style="width:20% !important;">
                                        <a href="editcontact.php?id=<?php echo $cc['id'] ?>" title="View/Edit Contact"
                                           id="<?php echo $cc['id'] ?>" class="btn btn-info btn-sm viewcontact">
                                            <i class="fa fa-eye" style='color:white;'></i>
                                        </a>
                                        <a href="#" class="delete-modal btn btn-danger btn-sm" title="Delete Contact"
                                           data-id="<?php echo $cc['id'] ?>"
                                           data-title="<?php echo $cc['MSISDN'] ?>"
                                           data-body="<?php echo $cc['email'] ?>">
                                            <i class="fa fa-trash" style='color:white;'></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php }

                        } else {
                            //echo "no data";
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane " id="up" name="up" role="tabpanel">
                <form id='formupload' method="POST" enctype="multipart/form-data">
                    <h4 style='text-align:center;'>Upload Contacts</h4>
                    <div id="smartwizard" style='margin:0 2% 2% 2%;'>
                        <ul>
                            <li><a href="#step-1">Step 1<br/><small>Select a Group</small></a></li>
                            <li><a href="#step-2">Step 2<br/><small>Upload Excel File</small></a></li>
                        </ul>
                        <div>
                            <div id="step-1"><br/>
                                <h2>Select The Group</h2><br/>
                                <div id="form-step-0">
                                    <div class="form-group">
                                        <select class="form-control" required="required" name='up_grp' id='up_grp'>
                                            <option value="">Choose the Group</option>
                                            <?php
                                            foreach ($gr_all as $g) {
                                                echo "<option value='" . $g['id'] . "'>" . $g['name'] . "</option>";
                                            }
                                            ?>
                                        </select><br/>
                                    </div>
                                </div>
                            </div>
                            <div id="step-2"><br/>
                                <h2>Upload your File (Excel File)</h2><br/>
                                <div id="form-step-1" role="form" data-toggle="validator">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Choose your File</label>
                                        <input type="file" id="excel" name='excel'
                                               accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                               onchange="ValidateSingleInput(this)">
                                    </div>
                                </div>
                                <a href="contacts.xlsx"><img src="img/contacts.PNG" title="Sample Template here"
                                                             style="border: 2px solid #F4F4F4; border-radius: 5px;"></a>
                                <hr>
                                
                            </div>
                        </div>
                    </div>
                </form>
                <div id='result' style='margin:3% !important;'></div>
            </div><!-- tab pane-->

        </div>
    </div>
    <div>
        <script>
            //check if its excel or not
            var _validFileExtensions = [".xls", ".xlsx"];

            function ValidateSingleInput(oInput) {
                if (oInput.type == "file") {
                    var sFileName = oInput.value;
                    if (sFileName.length > 0) {
                        var blnValid = false;
                        for (var j = 0; j < _validFileExtensions.length; j++) {
                            var sCurExtension = _validFileExtensions[j];
                            if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                                blnValid = true;
                                break;
                            }
                        }
                        if (!blnValid) {
                            alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                            oInput.value = "";
                            return false;
                        }
                    }
                }
                return true;
            }

            $(document).ready(function () {
                $('#smartwizard').smartWizard("reset");
                $('#excel').change(function () {
                    $('#formupload').submit();
                });
                $('#formupload').on('submit', function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: 'requests/contacts/upload.php',
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $('#result').html("<center><h3>Loading...</h3></center>");
                            $.notify("Uploading..", "info");
                            $('#result').html(data);
                            window.setTimeout(function () {
                                // location.reload();
                                $('#result').html(data);
                            }, 2000);
                        }
                    })
                });
                $('#excel').filestyle({
                    buttonName: 'btn-info',
                    buttonText: 'Select Your Excel'
                });
                $(document).on('click', '.delete-modal', function () {

                    $('#footer_action_button').text(" Delete");
                    $('#footer_action_button').removeClass('glyphicon-check');
                    $('#footer_action_button').addClass('glyphicon-trash');
                    $('.actionBtn').removeClass('btn-success');
                    $('.actionBtn').addClass('btn-danger');
                    $('.actionBtn').addClass('delete');
                    $('.modal-title').text('Delete Post');
                    $('.id').text($(this).data('id'));
                    $('.deleteContent').show();
                    $('.form-horizontal').hide();
                    $('.title').html($(this).data('title'));
                    $('#myModal').modal('show');
                });
                //
                $('.modal-footer').on('click', '.delete', function () {
                    //   alert($('.id').text());
                    $.ajax({
                        type: 'GET',
                        url: './requests/contacts/deletecontact.php',
                        data: 'id=' + $('.id').text(),
                        success: function (data) {
                            $.notify("Contact has been deleted", "error");
                            window.setTimeout(function () {
                                location.reload();
                                location.href = "./contacts.php#view";
                            }, 1000);
                        }
                    });
                });
                var btnFinish = $('<button></button>').text('Upload')
                    .addClass('btn btn-info')
                    .on('click', function () {
                        if ($('#up_grp').val() == "") {
                            alert("Still have an error");
                        } else if ($('.bootstrap-filestyle > input').val() == "") {
                            alert("Still have an error.. select a file");
                        }
                    });
                var btnCancel = $('<button></button>').text('Cancel')
                    .addClass('btn btn-danger')
                    .on('click', function () {
                        $('#smartwizard').smartWizard("reset");
                        $('#up_grp').val("");
                        $('.bootstrap-filestyle > input').val("");
                    });

                $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'arrows',
                    transitionEffect: 'fade',
                    toolbarSettings: {
                        toolbarPosition: 'bottom',
                        toolbarExtraButtons: [btnCancel]
                    },
                    anchorSettings: {
                        markDoneStep: true, // add done css
                        markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                        removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                        enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                    }
                });

                $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                    var elmForm = $("#form-step-" + stepNumber);
                    // stepDirection === 'forward' :- this condition allows to do the form validation
                    // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                    if (stepDirection === 'forward' && elmForm) {
                        elmForm.validator('validate');
                        var elmErr = elmForm.children('.has-error');
                        if (elmErr && elmErr.length > 0) {
                            // Form validation failed
                            return false;
                        }
                    }
                    return true;
                });
                $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
                    // Enable finish button only on last step
                    if (stepNumber == 3) {
                        $('.btn-finish').removeClass('disabled');
                    } else {
                        $('.btn-finish').addClass('disabled');
                    }
                });
            });

        </script>
        <?php //include('includes/footer.php'); ?>
