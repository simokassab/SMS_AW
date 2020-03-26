<?php
ob_start();
session_start();
include_once('classes/login.php');
include_once('classes/groups.php');
include_once('classes/contacts.php');
$log= new login();
$cr= new contacts();
$gr= new groups();
$res=$log->checklogin();

$gr_all=$gr->getAll($_SESSION['user_id']);


$id=$_GET['id'];

$cr_all=$cr->getRowByID($id,$_SESSION['user_id']);

//print_r($cr_all);

if(!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>
<script>
</script>
<body class='bg'>
<?php include('includes/nav.php');?>
<h1 class='titlee'>Edit Contact No: <?php echo $cr_all['MSISDN']; ?></h1><br/>
    <!-- Begin page content -->
    <div class="container-fluid" style='background-color:white;'>
            <form action='requests/contacts/update.php' method='post' enctype='multipart/form-data'>
            <input type="hidden" value=" <?php echo $cr_all['id']; ?>" id='id'>
            <div class="form-group">
                <label for="fname">First Name</label>
            <input type="name" class="form-control" id="fname" name='fname' value="<?php echo $cr_all['firstname']; ?>" disabled >
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="name" class="form-control" id="lname" name='lname' value="<?php echo $cr_all['lastname']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $cr_all['email']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="address" class="form-control" id="address" name="address" value="<?php echo $cr_all['address']; ?>" disabled>
            </div>
            <div class="form-group">Gender:<br/>
                <div data-toggle="buttons" class='radio'  style='margin-top:2%;' disabled>
                <?php if( $cr_all['gender']=='male'){
                    echo '<label class="btn btn-primary btn-circle btn-lg" title="Male"> <input type="radio" name="gender" value="male" checked ><i class="fa fa-male" ></i></label>'.
                   '&nbsp;&nbsp;&nbsp;<label class="btn btn-danger  btn-circle btn-lg" title="Female"><input type="radio" name="gender" value="female" ><i class="fa fa-female"></i></label>';
                }
                else {
                    echo '<label class="btn btn-primary btn-circle btn-lg" title="Male"> <input type="radio" name="gender" value="male" ><i class="fa fa-male" ></i></label>&nbsp;&nbsp;&nbsp;'.
                   '<label class="btn btn-danger  btn-circle btn-lg" title="Female"><input type="radio" name="gender" value="female" checked > <i class="fa fa-female"></i></label>';
                } 
                ?>
                </div>
            </div>
             <br/>
            <p id='pgender'><b>Gender: &nbsp;&nbsp;&nbsp;</b><?php echo $cr_all['gender']; ?></p><br/>
            <div class="form-group">
                <label for="msisdn">Phone: </label>
                <input type="msisdn" class="form-control" id="msisdn" name="msisdn" value="<?php echo $cr_all['MSISDN']; ?>" disabled>
                <p id='errorphone' class="error text-center alert alert-danger" style='display:none;'></p>
            </div>
            <br/>
            <div class="form-group" id='groups'>
                <?php 
                    $p='<p id="pselect"><b>Groups: </b>';
                    $grs=$cr_all['GRS_ID_FK'];
                    $gr=explode(",", $grs);
                    foreach($gr_all as $grp){
                        if(in_array($grp['id'], $gr)){
                                $p.=$grp['name'].", "; 
                            }
                            else {
                                
                            }
                           
                    }
                    $p.='</p>'; 
                    echo $p;
                ?>
            </div>
            <div class="form-group" id='selectbox' style='display: none;'>
                <label for="multi-select-demo">Groups</label>
                <select id="groupss" name="groupss" multiple="multiple"  >
                        <?php 
                            $grs=$cr_all['GRS_ID_FK'];
                            $gr=explode(",", $grs);
                            foreach($gr_all as $grp){
                                if(in_array($grp['id'], $gr)){
                                        echo "<option value='".$grp['id']."' selected>".$grp['name']."</option>"; 
                                    }
                                    else {
                                        echo "<option value='".$grp['id']."' >".$grp['name']."</option>";
                                    }
                            }
                        ?>
                </select>
                <p id='errorgroups' class="error text-center alert alert-danger" style='display:none;'></p>
                <script type="text/javascript">
                    $(function() {
                        $('#groupss').multiselect({
                        enableFiltering: true,
                        templates: {
                            li: '<li><a href="javascript:void(0);"><label class="pl-2"></label></a></li>',
                            filter: '<li class="multiselect-item filter"><div class="input-group"><input class="form-control multiselect-search" type="text"></div></li>',
                            filterClearBtn: ''
                        },
                        
                        onInitialized: function(select, container) {
                            // hide checkboxes
                            // container.find('input[type=checkbox]').addClass('d-none');
                        }
                    });
                    });
                </script>
            </div>
            <button type='submit' id='save' class='btn btn-primary' style='display:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
        </form>
        <button  class="btn btn-warning" id="edit"  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button> <br/><br/>
    </div>
    <div>
       
    <script>
 $( document ).ready(function() { 
        $("#edit").click(function(){ 
            event.preventDefault();
            $('#msisdn').prop("disabled", false); 
            $('#optradio').removeAttr("disabled");
            $('#lname').prop("disabled", false); 
            $('#fname').prop("disabled", false); 
            $('#email').prop("disabled", false);  
            $('#address').prop("disabled", false); 
            $('#pgender').css("display", 'none');
            $('#pselect').css("display", 'none');
            $('.radio').removeAttr("disabled");
            $('#selectbox').css("display", 'block');
            $('#save').css("display", 'block');
            $(this).css("display", 'none');
        });
        $("#save").click(function(){ 
            var msisdn= $('#msisdn').val();
            var fname=$('#fname').val();
            var lname=$('#lname').val();
            var id=$('#id').val();
            var email=$('#email').val();
            var address=$('#address').val();
            var gender=$('input[name=gender]:checked').val();
            var groups=$('#groupss').val();
            var userid= <?php echo $_SESSION['user_id']; ?>;
        // alert(gender);
            if (msisdn=='' && groups==''){
                $('#errorphone').css('display', 'block');
                $('#errorphone').html('Required field <i class="fa fa-exclamation"></i>');
                $('#errorgroups').css('display', 'block');
                $('#errorgroups').html('Required field <i class="fa fa-exclamation"></i>');
            }
            else if (msisdn=='' && groups!=''){
                $('#errorphone').css('display', 'block');
                $('#errorphone').html('Required field <i class="fa fa-exclamation"></i>');
                $('#errorgroups').css('display', 'none');
            }
            else if (msisdn!='' && groups==''){
                $('#errorphone').css('display', 'none');
                $('#errorgroups').css('display', 'block');
                $('#errorgroups').html('Required field <i class="fa fa-exclamation"></i>');
            }
            else {
                event.preventDefault();
                $.ajax({
                    url: "./requests/contacts/update.php",
                    type: "GET",
                    data: 'fname='+fname+'&lname='+lname+'&email='+email+'&address='+address+'&gender='+gender+'&groups='+groups+',&msisdn='+msisdn+'&user_id='+userid+'&id='+id,
                    success: function(data)
                    {
                        console.log(data);
                        $.notify("Contact has been Updated.", "success");
                        window.setTimeout(function () {
                            location.reload();
                            location.href = "<?php echo LINK; ?>/contacts.php?grid=4#view";
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
<?php //include('includes/footer.php'); ?>
