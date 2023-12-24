<?php
$obj_activity=new MJ_gmgt_activity;
	if(isset($_REQUEST['activity_id']))
	{
		$activity_id=$_REQUEST['activity_id'];
	}
	$result = $obj_activity->MJ_gmgt_get_single_activity($activity_id);
?>
<div class="border_panel_body panel-body"><!-- PANEL BODY DIV START-->
	<form name="acitivity_form" action="" method="post" class="form-horizontal material_design_form margin_0px" id="acitivity_form"><!-- ACTIVITY FORM START-->
	<?php
	if(!empty($result->video_entry))
	{
		$all_entry=json_decode($result->video_entry);
		foreach($all_entry as $entry)
		{
		?>
		<div class="col-sm-6 col-xs-12">
			<h2><?php esc_html_e('Video Title : ','gym_mgt');?><?php echo esc_html($entry->video_title);?></h2>
				<?php 
				echo '<iframe class="video_width_height" src='.$entry->video_link.' frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
				?>
		</div>
		<?php
		}
	}else {
	 echo esc_html__('No video available for this activity', 'gym_mgt');
	}
    ?>  
		</form><!--Activity FORM END-->
	</div><!-- PANEL BODY DIV END-->
