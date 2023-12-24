<?php
	if(isset($_REQUEST['activity_id']))
	{
		$activity_id=$_REQUEST['activity_id'];
	}
	$result = $obj_activity->MJ_gmgt_get_single_activity($activity_id);
?>
<div class="border_panel_body panel-body"><!-- PANEL BODY DIV START-->
		<form name="acitivity_form" action="" method="post" class="form-horizontal material_design_form margin_0px" id="acitivity_form"><!-- ACTIVITY FORM START-->
			<div class="row">
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
				}
				else 
				{
					?>
					<div class="calendar-event-new"> 
						<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
					</div>
					<?php
				}
				?>  
			</div>
		</form><!--Activity FORM END-->
	</div><!-- PANEL BODY DIV END-->
