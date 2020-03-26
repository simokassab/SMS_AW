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
<script>
$(document).ready(function (e) {
    $('#table').DataTable( {
        responsive: true,
        "pagingType": "full_numbers"
    } );
    var res = $(location).attr('href').split("#");
    if(!res[1]){
        $('.view').removeClass('active');
        $('#vieww').removeClass('active');
        $('.new').addClass('active');
        $('#new').addClass('active');
    }
    else {
        //
        if(res[1]=='view'){
            $('.new').removeClass('active');
            $('#new').removeClass('active');
            $('.view').addClass('active');
            $('#vieww').addClass('active');
        }
    }
    
    $('.add_group').on('click', function () {
       // alert($('.name_').val());
        var name_= $('.name_').val();
        var desc=$('#description_').val();
        if (name_=='' && desc==''){
            $('#errorname').css('display', 'block');
            $('#errorname').html('Required field <i class="fa fa-exclamation"></i>');
            $('#errordesc').css('display', 'block');
            $('#errordesc').html('Required field <i class="fa fa-exclamation"></i>');
        }
        else if (name_=='' && desc!=''){
            $('#errorname').css('display', 'block');
            $('#errorname').html('Required field <i class="fa fa-exclamation"></i>');
            $('#errordesc').css('display', 'none');
        }
        else if (name_!='' && desc==''){
            $('#errorname').css('display', 'none');
            $('#errordesc').css('display', 'block');
            $('#errordesc').html('Required field <i class="fa fa-exclamation"></i>');
        }
        else {
            event.preventDefault();
            $.ajax({
                url: "./requests/groups/addgroup.php",
                type: "GET",
                data: 'name_='+name_+'&description_='+desc,
                success: function(data)
                {
                    console.log(data);
                // window.location.href = 'your_url';
                $.notify("New Group has been Added.", "success");
                 window.setTimeout(function () {
                    location.reload();
                      location.href = "<?php echo LINK; ?>/groups.php#view";
                   }, 1000);
                },
                error: function() 
                {
                    
                } 	        
            });
        }
    });
});
</script>
<body class='bg'>
<!-- modal -->
<div id="show" class="modal  fade " role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">ID :</label>
                        <b id="i" />
                    </div>
                    <div class="form-group">
                        <label for="">Title :</label>
                        <b id="ti"/>
                    </div>
                    <div class="form-group">
                        <label for="">Body :</label>
                        <b id="by"/>
                    </div>
                </div>
            </div>
        </div>           
</div>
    <div id="myModal"class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="modal">
                <div class="form-group">
                    <label class="control-label col-sm-2"for="id">ID</label>
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
                <br>
                Contacts in this group will be removed !
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
</div>

<!-- end modal -->
<?php include('includes/nav.php');?>
<h1 class='titlee'> Groups</h1>
    <!-- Begin page content -->
    <div class="container-fluid">
        <div id="navbar-example">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" id='navitm'  >
                    <a class="nav-link active view" data-toggle="tab" href="#vieww" role="tab">View/ Edit Group</a>
                </li>
                <li class="nav-item" id='navitm' >
                    <a class="nav-link  new" data-toggle="tab" href="#new" role="tab">New Group</a>
                </li>
                
                <li class="nav-item"  id='navitm' >
                    <a class="nav-link upload" data-toggle="tab" href="#up" role="tab">Upload Group</a>
                </li>
            </ul>
            <!-- Tab panes {Fade}  -->
            <div class="tab-content" id='content1' >
                <div class="tab-pane  " id="new" name="new" role="tabpanel" ><br/>  
                <form method='post' action='groups.php'>
                    <h3 style='text-align:center;'>Add Group</h3><hr/>
                   <div class='row' style='margin:0 2% 2% 2%;'>
                        <div class='col-sm-6'>
                            <div class="form-group">
                              <label class="control-label" for="title">Name :</label>
                                <input type="text" class="form-control name_" id="name_" name="name_"
                                placeholder="name" >
                                <p id='errorname' class="error text-center alert alert-danger" style='display:none;'></p>
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class="form-group">
                              <label class="control-label" for="body">description :</label>
                                <input type="text" class="form-control" id="description_" name="description_"
                                placeholder="Description" >
                                <p id='errordesc' class="error text-center alert alert-danger" style='display:none;'></p>
                            </div>
                        </div>
                    </div>
                    <div style='margin: 0 auto;text-align:center;'>
                        <a class="btn btn-warning add_group" >
                        <span class="fa fa-plus"></span>&nbsp;&nbsp;&nbsp;&nbsp;Save Group
                        </a><br/><br/>
                    </div>
                    </form>
                </div>
                <div class="tab-pane active" id="vieww" name='vieww' role="tabpanel">
                <br/> 
                <div class='cont' >
                    <table  id='table' class="table  table-bordered hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-center">
                                   
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($gr_all as $gg){
                            //  echo $g['']
                        ?>
                        <tr class='group<?php echo $gg['id']; ?>'>
                            <td><?php echo $gg['name'];?></td>
                            <td><?php echo $gg['description'];?></td>
                            <td class="text-center">
                                <a href="#" title='View Group' data-toggle="modal" data-target="#show" class="show-modal btn btn-info btn-sm" 
                                data-id="<?php echo $gg['id']; ?>" data-title="<?php echo $gg['name']; ?>" data-body="<?php echo $gg['description']; ?>">
                                <i class="fa fa-eye" style='color:white;'></i>
                                </a>
                                <a href="#" title='Edit Group' class="edit-modal btn btn-warning btn-sm" 
                                data-id="<?php echo $gg['id']; ?>" data-title="<?php echo $gg['name']; ?>" data-body="<?php echo $gg['description']; ?>">
                                <i class="fa fa-edit" style='color:white;'></i>
                                </a>
                                <a href="#" title='Delete Group'  class="delete-modal btn btn-danger btn-sm" 
                                data-id="<?php echo $gg['id']; ?>" data-title="<?php echo $gg['name']; ?>" data-body="<?php echo $gg['description']; ?>">
                                <i class="fa fa-trash-alt" style='color:white;'></i>
                                </a>
                                <a target="_blank" href="contacts.php?grid=<?php echo $gg['id']; ?>" title='View Contacts' class="btn btn-primary btn-sm">
                                <i class="fa fa-user-tag" style='color:white;'></i>
                                </a>
                            
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                        </div>
                </div>
                <div class="tab-pane fade" id="up" name="up" role="tabpanel">
                <form id='formupload' method = "POST" enctype = "multipart/form-data"><br/><br/>
                <h4 style='text-align:center;'>Create Group and Upload Contacts</h4>
                    <div id="smartwizard" style='margin:0 2% 2% 2%;'>
                        <ul>
                            <li><a href="#step-1">Step 1<br /><small>Create Group</small></a></li>
                            <li><a href="#step-2">Step 2<br /><small>Upload Excel File</small></a></li>
                        </ul>
                        <div>
                            <div id="step-1"><br/>
                                <h2>Group Name: </h2><br/>
                                <div id="form-step-0" role="form" data-toggle="validator" >
                                    <div class="form-group">
                                        <input type="name" class="form-control" id="grpname" name='grpname' required>
                                    </div><br/>
                                </div>
                            </div>
                            <div id="step-2"><br/> 
                                <h2>Upload your File (Excel File)</h2><br/>
                                <div id="form-step-1" role="form" data-toggle="validator">
                                     <div class="form-group">
                                        <label for="exampleFormControlFile1"></label>
                                        <input type="file"  id="excel" name='excel' 
                                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                        onchange="ValidateSingleInput(this)">
                                    </div>          
                                </div>
                                <a href="contacts.xlsx"><img src="img/contacts.PNG" title="Sample Template here" style="border: 2px solid #5CB85C; border-radius: 5px;"  ></a>
                                <hr>
                            </div>
                        </div>
                    </div>               
                   </form>
                    <div id='result' style='margin:3%;'></div>            
                </div><!-- last tab --> 
            </div>
        </div>
    <div>
<script type="text/javascript">
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
$( document ).ready(function() {
    $('#smartwizard').smartWizard("reset");
    $('#excel').change(function(){
        $('#formupload').submit();
    });
    $('#formupload').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'requests/groups/upload.php',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data){
                $('#result').html("<center><h3>Loading...</h3></center>");
                $.notify("Uploading..", "info");
                window.setTimeout(function () {
                       // location.reload();
                        $('#result').html(data);
                        }, 2000);
            }
        })
    });
    $('#excel').filestyle({
        buttonName : 'btn-info',
        buttonText : 'Select Your Excel'
    });
});
var btnFinish = $('<button></button>').text('Upload')
                    .addClass('btn btn-info')
                    .on('click', function(){
                        if( $('#up_grp').val()==""){
                            alert("Still have an error");
                        }
                        else if($('.bootstrap-filestyle > input').val()==""){
                            alert("Still have an error.. select a file");
                        }
                    });
            var btnCancel = $('<button></button>').text('Cancel')
                            .addClass('btn btn-danger')
                            .on('click', function(){
                                $('#smartwizard').smartWizard("reset");
                                $('#up_grp').val("");
                                $('#grpname').val("");
                            });

            $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'arrows',
                    transitionEffect:'fade',
                    toolbarSettings: {toolbarPosition: 'bottom',
                                      toolbarExtraButtons: [btnCancel]
                                    },
                    anchorSettings: {
                                markDoneStep: true, // add done css
                                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                            }
                 });

            $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $("#form-step-" + stepNumber);
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if(stepDirection === 'forward' && elmForm){
                    elmForm.validator('validate');
                    var elmErr = elmForm.children('.has-error');
                    if(elmErr && elmErr.length > 0){
                        // Form validation failed
                        return false;
                    }
                }
                return true;
            });
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
                // Enable finish button only on last step
                if(stepNumber == 3){
                    $('.btn-finish').removeClass('disabled');
                }else{
                    $('.btn-finish').addClass('disabled');
                }
            });

        $(document).ready(function () {
            // function Edit POST
            $(document).on('click', '.edit-modal', function() {
            $('#footer_action_button').text(" Update ");
            $('#footer_action_button').addClass('glyphicon-check');
            $('#footer_action_button').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('edit');
            $('.modal-title').text('Edit');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            $('#fid').val($(this).data('id'));
            $('#t').val($(this).data('title'));
            $('#b').val($(this).data('body'));
            $('#myModal').modal('show');
            });
            $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'GET',
                url: './requests/groups/updategroup.php',
                data: 'id='+$("#fid").val()+'&name='+ $('#t').val()+'&description='+ $('#b').val(),
            success: function(data) {
                $.notify("Group has been updated", "info");
                window.setTimeout(function () {
                location.reload();
                location.href = "./groups.php#view";
                }, 1000); 
                }
            });
            });

            $(document).on('click', '.delete-modal', function() {
            
            $('#footer_action_button').text(" Delete");
            $('#footer_action_button').removeClass('glyphicon-check');
            $('#footer_action_button').addClass('glyphicon-trash');
            $('.actionBtn').removeClass('btn-success');
            $('.actionBtn').addClass('btn-danger');
            $('.actionBtn').addClass('delete');
            $('.modal-title').text('Delete');
            $('.id').text($(this).data('id'));
            $('.deleteContent').show();
            $('.form-horizontal').hide();
            $('.title').html($(this).data('title'));
            $('#myModal').modal('show');
            });
           // 
            $('.modal-footer').on('click', '.delete', function(){
             //   alert($('.id').text());
                $.ajax({
                    type: 'GET',
                    url: './requests/groups/deletegroup.php',
                    data: 'id=' +$('.id').text(),
                    success: function(data){
                        $.notify("Group has been deleted", "error");
                        window.setTimeout(function () {
                            location.reload();
                            location.href = "./groups.php#view";
                        }, 1000); 
                        }
                });
            });

            // Show function
            $(document).on('click', '.show-modal', function() {
            $('#show').modal('show');
            $('.modal-title').text('');
            $('#i').text($(this).data('id'));
            $('#ti').text($(this).data('title'));
            $('#by').text($(this).data('body'));
           
            });
        });
    </script>
<?php// include('includes/footer.php'); ?>
    </div></div></body>
