<?php
ob_start();
session_start();
include_once('classes/login.php');
header("Location: campaigns.php");
$log= new login();
$res=$log->checklogin();

if(!$res)
    header("Location: login.php");
?>
<?php include('includes/header.php'); ?>
<style>

</style>

<script>
$(
function(){
	$('a.maxmin').click(
	function(){
		$(this).parent().siblings('.dragbox-content').toggle();
	});

	$('a.delete').click(
	function(){
		var sel = confirm('do you want to delete the widget?');
		if(sel)
		{
			//$(this).parent().siblings('.dragbox-content').css('display', 'none ');
			//$(this).parent().css('display', 'none ');
		}
	}
	);

	$('.column').sortable({
	connectWith: '.column',
	handle: 'h2',
	cursor: 'move',
	placeholder: 'placeholder',
	forcePlaceholderSize: true,
	opacity: 0.1,
	stop: function(event, ui)
		{
			$(ui.item).find('h2').click();
			var sortorder='';

			$('.column').each(function(){
				var itemorder=$(this).sortable('toArray');
				var columnId=$(this).attr('id');
				sortorder+=columnId+'='+itemorder.toString()+'&';
			});
			sortorder = sortorder.substring(0, sortorder.length - 1)
			//alert('SortOrder: '+sortorder);
            $.cookie("SortOrder", sortorder);
		}

	}).disableSelection();
});
</script>
<?php include('includes/nav.php');?>
    <!-- Begin page content -->
    <div id="column1" class="column">
        <div class="dragbox" id="item1" >
            <h2> Latest 'Sent Campaigns'
            <a href="#" class="maxmin opIcons"> <i class="fa fa-eye-slash" style="color:white;font-size:12px;"></i></a>
            </h2>
            <div class="dragbox-content" >
                <!-- Panel Content Here -->
            </div>
        </div>
        <div class="dragbox" id="item2" >
            <h2>Web Page view
            <a href="#" class="maxmin opIcons"> <i class="fa fa-eye-slash" style="color:white;font-size:12px;"></i></a>
            </h2>
            <div class="dragbox-content" >
                <!-- Panel Content Here -->
	        </div>
	    </div>
    </div>

    <div id="column2" class="column">
        <div class="dragbox" id="item3" >
            <h2>Latest 'Scheduled Campaigns'
            <a href="#" class="maxmin opIcons"> <i class="fa fa-eye-slash" style="color:white;font-size:12px;"></i></a>
            </h2>
            <div class="dragbox-content" >
                <!-- Panel Content Here -->
            </div>
        </div>
        <div class="dragbox" id="item4" >
            <h2>Deleted Campaigns
            <a href="#" class="maxmin opIcons"> <i class="fa fa-eye-slash" style="color:white;font-size:12px;"></i></a>
            </h2>
            <div class="dragbox-content" >
                <!-- Panel Content Here -->
	        </div>
	    </div>
    </div>

</div><!-- for wrapper -->
<?php // include('includes/footer.php'); ?>


