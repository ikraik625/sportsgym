<?php
$past_participle_list = $obj_virtual_classroom->MJ_gmgt_view_past_participle_list_in_zoom($_REQUEST['meeting_uuid']);

?>
<script type="text/javascript">
$(document).ready(function() 
{
	var table =  jQuery('#past_participle_list').DataTable({
	responsive: true,
	'order': [1, 'asc'],
 	dom: 'lifrtp',
	"aoColumns":[
	        {"bSortable": true},
	    	{"bSortable": true},
			{"bSortable": true},
	    ],
		language:<?php echo MJ_gmgt_datatable_multi_language();?>		
       });	
	   $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");
   }); 
</script>
<?php
if (!empty($past_participle_list->participants))
{
	?>
	<div class="panel-body padding_0">
		<form id="frm-example" name="frm-example" method="post">
			<div class="table-responsive">
				<table id="past_participle_list" class="display" cellspacing="0" width="100%">
					<tbody>
						<?php 
						if (!empty($past_participle_list->participants))
						{
							$i=0;
							foreach($past_participle_list->participants as $retrieved_data)
							{
								if($i == 10)
								{
									$i=0;
								}
								if($i == 0)
								{
									$color_class='smgt_class_color0';
								}
								elseif($i == 1)
								{
									$color_class='smgt_class_color1';
								}
								elseif($i == 2)
								{
									$color_class='smgt_class_color2';
								}
								elseif($i == 3)
								{
									$color_class='smgt_class_color3';
								}
								elseif($i == 4)
								{
									$color_class='smgt_class_color4';
								}
								elseif($i == 5)
								{
									$color_class='smgt_class_color5';
								}
								elseif($i == 6)
								{
									$color_class='smgt_class_color6';
								}
								elseif($i == 7)
								{
									$color_class='smgt_class_color7';
								}
								elseif($i == 8)
								{
									$color_class='smgt_class_color8';
								}
								elseif($i == 9)
								{
									$color_class='smgt_class_color9';
								}
								?>
								<tr>
									<td class="user_image width_50px profile_image_prescription padding_left_0">	
										<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/White_Icons/Virtual_class.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">
										</p>
									</td>
									<td><?php echo $retrieved_data->name;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Name','gym_mgt');?>" ></td>
									<td><?php echo $retrieved_data->useresc_html_email;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Email','gym_mgt');?>" ></td>
								</tr>
								<?php 
								$i++;
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</form>
	</div>
	<?php
}
else
{
	?>
	<div class="calendar-event-new"> 
		<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
	</div>
	<?php
}