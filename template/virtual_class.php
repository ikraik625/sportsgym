<?php 
$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;
$curr_user_id=get_current_user_id();
$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);

//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_gmgt_browser_javascript_check();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'meeting_list';
//--------------- ACCESS WISE ROLE -----------//
$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_gmgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_gmgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_gmgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
		{
			if($user_access['add']=='0')
			{	
				MJ_gmgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}
// EDIT MEETING IN ZOOM
if(isset($_POST['edit_meeting']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'edit_meeting_nonce' ) )
	{
		$result = $obj_virtual_classroom->MJ_gmgt_create_meeting_in_zoom($_POST);
		if($result)
		{
			wp_redirect ( home_url().'?dashboard=user&page=virtual_class&tab=meeting_list&message=2');
			exit();
		}		
	}
}
// DELETE STUDENT IN ZOOM
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result= $obj_virtual_classroom->MJ_gmgt_delete_meeting_in_zoom($_REQUEST['meeting_id']);
	if($result)
	{
		wp_redirect ( home_url().'?dashboard=user&page=virtual_class&tab=meeting_list&message=3');
		exit();
	}
}
?>
<script type="text/javascript">
$(document).ready(function() {
	var table =  jQuery('#meeting_list').DataTable({
	responsive: true,
	 'order': [1, 'asc'],
	 dom: 'lifrtp',
	 "aoColumns":[
	                  {"bSortable": false},
					  {"bSortable": true},
					  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": true},
	                  {"bSortable": false}],
	language:<?php echo MJ_gmgt_datatable_multi_language();?>		
       });	
	   $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");
    $('#meeting_form').validationEngine({{promptPosition : "bottomLeft",maxErrorsPerField: 1}); 
   });  
</script>
<!-- Nav tabs -->
<?php
$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
switch($message)
{
	case '1':
		$message_string = __('Virtual Class Added Successfully.','gym_mgt');
		break;
	case '2':
		$message_string = __('Virtual Class Updated Successfully.','gym_mgt');
		break;
	case '3':
		$message_string = __('Virtual Class Deleted Successfully.','gym_mgt');
		break;
}
if($message)
{ 
	?>
	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>
		</button>
		<?php echo $message_string;?>
	</div>
	<?php 
} 
?>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
	    <div class="modal-content">
		    <div class="view_meeting_detail_popup">
		    </div>
		</div>
	</div>
</div>
<div class="panel-body panel-white padding_0 gms_main_list">
	<!-- Tab panes -->
	<?php
	if($active_tab == 'meeting_list')
	{
		$user_id=get_current_user_id();
		//------- MEETING DATA FOR member ---------//
		if($obj_gym->role == 'member')
		{
			$obj_class=new MJ_gmgt_classschedule;
			$cur_user_class_id = array();
			$curr_user_id=get_current_user_id();
			$cur_user_class_id = MJ_gmgt_get_current_user_classis($user_id);
			$classdata=$obj_class->MJ_gmgt_get_all_classes_by_member($cur_user_class_id);	
			foreach($classdata as $id)
			{
				$meeting_list_data = $obj_virtual_classroom->MJ_gmgt_get_meeting_by_class_id_data_in_zoom($id->class_id);
			}
		}
		//------- MEETING DATA FOR SUPPORT STAFF ---------//
		else
		{
			$meeting_list_data = $obj_virtual_classroom->MJ_gmgt_get_all_meeting_data_in_zoom();
		} 

		if(!empty($meeting_list_data))
		{
			?>
			<div class="panel-body padding_0">
				<form id="frm-example" name="frm-example" method="post">
					<div class="table-responsive">
						<table id="meeting_list" class="display datatable" cellspacing="0" width="100%">
							<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
								<tr>
									<th><?php esc_html_e('Photo','gym_mgt');?></th>
									<th><?php esc_html_e('Class Name','gym_mgt');?></th>
									<th><?php esc_html_e('Staff Member','gym_mgt');?></th>
									<th><?php esc_html_e('Day','gym_mgt');?></th>
									<th><?php esc_html_e('Start To End Date','gym_mgt');?></th>
									<th><?php esc_html_e('Start Time To End Time','gym_mgt');?></th>
									<th><?php esc_html_e('Topic','gym_mgt');?></th>
									<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if($obj_gym->role == 'member')
								{
									$obj_class=new MJ_gmgt_classschedule;
									$cur_user_class_id = array();
									$curr_user_id=get_current_user_id();
									$cur_user_class_id = MJ_gmgt_get_current_user_classis($curr_user_id);
									$classdata=$obj_class->MJ_gmgt_get_all_classes_by_member($cur_user_class_id);
									
									foreach($classdata as $id)
									{
										$i=0;
										$meeting_list_data = $obj_virtual_classroom->MJ_gmgt_get_meeting_by_class_id_data_in_zoom($id->class_id);
										foreach ($meeting_list_data as $retrieved_data)
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
												<td><?php echo $retrieved_data->title;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></td>
												<td><?php echo  MJ_gmgt_get_display_name($retrieved_data->staff_id); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member','gym_mgt');?>" ></td>
												<td style="width: 10%;">
													<?php
														$explode_string = explode("," , $retrieved_data->weekdays);
														$day_name = array();
														foreach($explode_string as $day)
														{
															$day_name[] = __($day , "gym_mgt");
															
														}
														$dayname = implode(',', $day_name);
														echo $dayname;
													?>
													 <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></td>
												<td><?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->start_date); ?> <?php echo _e("To","gym_mgt") ?> <?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start To End Date','gym_mgt');?>" ></td>
												<td><?php echo $retrieved_data->start_time; ?> <?php echo _e("To","gym_mgt") ?> <?php echo $retrieved_data->end_time; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time To End Time','gym_mgt');?>" ></td>
												<td>
													<?php
													if(!empty($retrieved_data->agenda))
													{
														$strlength= strlen($retrieved_data->agenda);
														if($strlength > 50)
															echo substr($retrieved_data->agenda, 0,30).'...';
														else
															echo $retrieved_data->agenda;
													}
													else
													{
														echo "N/A";
													}
													?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Topic','gym_mgt');?>" >
												</td>
												<td class="action"> 
													<div class="gmgt-user-dropdown">
														<ul class="" style="margin-bottom: 0px !important;">
															<li class="">
																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
																</a>
																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																	<li class="float_left_width_100">
																		<a href="<?php echo $retrieved_data->meeting_join_link;?>" class="float_left_width_100" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php esc_html_e('Start Virtual Class', 'gym_mgt' ) ;?></a>
																	</li>	
																</ul>
															</li>
														</ul>
													</div>	
												</td>
											</tr>
											<?php 
											$i++;
										}
									}	
								}
								elseif ($obj_gym->role == 'accountant')
								{
									$i=0;
									foreach ($meeting_list_data as $retrieved_data)
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
											<td><?php echo $retrieved_data->title;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></td>
											<td><?php echo  MJ_gmgt_get_display_name($retrieved_data->staff_id); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member','gym_mgt');?>" ></td>
											<td style="width: 10%;">
												<?php
													$explode_string = explode("," , $retrieved_data->weekdays);
													$day_name = array();
													foreach($explode_string as $day)
													{
														$day_name[] = __($day , "gym_mgt");
														
													}
													$dayname = implode(',', $day_name);
													echo $dayname;
												?>
												<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></td>
											<td><?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->start_date); ?> <?php echo _e("To","gym_mgt") ?> <?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start To End Date','gym_mgt');?>" ></td>
											<td><?php echo $retrieved_data->start_time; ?> <?php echo _e("To","gym_mgt") ?> <?php echo $retrieved_data->end_time; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time To End Time','gym_mgt');?>" ></td>
											<td>
												<?php
												if(!empty($retrieved_data->agenda))
												{
													$strlength= strlen($retrieved_data->agenda);
													if($strlength > 50)
														echo substr($retrieved_data->agenda, 0,30).'...';
													else
														echo $retrieved_data->agenda;
												}
												else
												{
													echo "N/A";
												}
												?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Topic','gym_mgt');?>" >
											</td>
											<td class="action"> 
												<div class="gmgt-user-dropdown">
													<ul class="" style="margin-bottom: 0px !important;">
														<li class="">
															<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
															</a>
															<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																<li class="float_left_width_100">
																	<a href="#" class="show-popup float_left_width_100" meeting_id="<?php echo $retrieved_data->meeting_id; ?>"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?></a>
																</li>
																
															</ul>
														</li>
													</ul>
												</div>	
											</td>
										</tr>
										<?php 
										$i++;
									}
								}
								else
								{
									$i=0;
									foreach ($meeting_list_data as $retrieved_data)
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
											<td><?php echo $retrieved_data->title;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></td>
											<td><?php echo  MJ_gmgt_get_display_name($retrieved_data->staff_id); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member','gym_mgt');?>" ></td>
											<td style="width: 10%;">
												<?php
													$explode_string = explode("," , $retrieved_data->weekdays);
													$day_name = array();
													foreach($explode_string as $day)
													{
														$day_name[] = __($day , "gym_mgt");
														
													}
													$dayname = implode(',', $day_name);
													echo $dayname;
												?>
												 <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></td>
											<td><?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->start_date); ?> <?php echo _e("To","gym_mgt") ?> <?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start To End Date','gym_mgt');?>" ></td>
											<td><?php echo $retrieved_data->start_time; ?> <?php echo _e("To","gym_mgt") ?> <?php echo $retrieved_data->end_time; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time To End Time','gym_mgt');?>" ></td>
											<td>
												<?php
												if(!empty($retrieved_data->agenda))
												{
													$strlength= strlen($retrieved_data->agenda);
													if($strlength > 50)
														echo substr($retrieved_data->agenda, 0,30).'...';
													else
														echo $retrieved_data->agenda;
												}
												else
												{
													echo "N/A";
												}
												?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Topic','gym_mgt');?>" >
											</td>
											<td class="action"> 
												<div class="gmgt-user-dropdown">
													<ul class="" style="margin-bottom: 0px !important;">
														<li class="">
															<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
															</a>
															<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																<?php
																if ($obj_gym->role == 'staff_member')
																{
																	?>
																	<li class="float_left_width_100">
																		<a href="#" class="show-popup float_left_width_100" meeting_id="<?php echo $retrieved_data->meeting_id; ?>"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?></a>
																	</li>
																	<?php
																}
																$date=date("Y-m-d");										
																if($retrieved_data->end_date >= $date)
																{
																	?>
																	<li class="float_left_width_100">
																		<a href="<?php echo $retrieved_data->meeting_start_link;?>" class="float_left_width_100" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php esc_html_e('Start Virtual Class', 'gym_mgt' ) ;?></a>
																	</li>
																	<?php
																}
																?>
																<li class="float_left_width_100">
																	<a href="?dashboard=user&page=virtual_class&tab=view_past_participle_list&action=view&meeting_uuid=<?php echo $retrieved_data->uuid;?>" class="float_left_width_100"><i class="fa fa-eye" aria-hidden="true"></i> <?php esc_html_e('View Past Participle', 'gym_mgt' ) ;?></a>
																</li>
																<?php
																if($user_access['edit']=='1')
																{
																	?>
																	<li class="float_left_width_100 border_bottom_item">
																		<a href="?dashboard=user&page=virtual_class&tab=edit_meeting&action=edit&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class=" float_left_width_100"><i class="fa fa-edit" aria-hidden="true"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>
																	</li>
																	<?php
																}
																if($user_access['delete']=='1')
																{
																	?>
																	<li class="float_left_width_100">
																		<a href="?dashboard=user&page=virtual_class&tab=meeting_list&action=delete&meeting_id=<?php echo $retrieved_data->meeting_id;?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>
																	</li>
																	<?php
																}
																?>
															</ul>
														</li>
													</ul>
												</div>	
											</td>
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
			<div class="calendar-event-new margin_top_12p"> 
				<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
			</div>
			<?php
		}
	}
	elseif($active_tab == 'edit_meeting')
	{
		$meeting_data = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_data_in_zoom($_REQUEST['meeting_id']);
		
		?>
		<script type="text/javascript">
		$(document).ready(function() {
			$('#meeting_form').validationEngine({{promptPosition : "bottomLeft",maxErrorsPerField: 1});
			$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);
			$("#end_date").datepicker({
				dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',
				minDate:0
			});
		} );
		</script>
		<div class="panel-body padding_0">   
			<form name="route_form" action="" method="post" class="form-horizontal" id="meeting_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
				<input type="hidden" name="meeting_id" value="<?php echo esc_attr($_REQUEST['meeting_id']);?>">
				<input type="hidden" name="class_id" value="<?php echo $meeting_data->class_id;?>">
				<input type="hidden" name="class_name" value="<?php echo $meeting_data->title;?>">
				<input type="hidden" name="duration" value="<?php echo $meeting_data->duration;?>">
				<input type="hidden" name="days" value="<?php echo $meeting_data->weekdays;?>">
				<input type="hidden" name="start_time" value="<?php echo $meeting_data->start_time;?>">
				<input type="hidden" name="end_time" value="<?php echo $meeting_data->end_time;?>">
				<input type="hidden" name="staff_id" value="<?php echo $meeting_data->staff_id;?>">
				<input type="hidden" name="start_date" value="<?php echo $meeting_data->start_date;?>">
				<input type="hidden" name="end_date" value="<?php echo $meeting_data->end_date;?>">
				<input type="hidden" name="zoom_meeting_id" value="<?php echo $meeting_data->zoom_meeting_id;?>">
				<input type="hidden" name="uuid" value="<?php echo $meeting_data->uuid;?>">
				<input type="hidden" name="meeting_join_link" value="<?php echo $meeting_data->meeting_join_link;?>">
				<input type="hidden" name="meeting_start_link" value="<?php echo $meeting_data->meeting_start_link;?>">
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Virtual Class Information','gym_mgt');?></h3>
				</div>
				<div class="form-body user_form"> <!-- user_form Strat-->   
					<div class="row"><!--Row Div Strat--> 
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="class_name" class="form-control" maxlength="50" type="text" value="<?php echo $meeting_data->title; ?>" name="class_name" disabled>
									<label class="" for="member_id"><?php esc_html_e('Class Name','gym_mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="start_time" class="form-control" type="text" value="<?php echo $meeting_data->start_time; ?>" name="start_time" disabled>
									<label class="" for="member_id"><?php esc_html_e('Start Time','gym_mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="end_time" class="form-control form-label" type="text" value="<?php echo $meeting_data->end_time; ?>" name="end_time" disabled>
									<label class="" for="member_id"><?php esc_html_e('End Time','gym_mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="start_date" class="form-control validate[required] text-input" type="text" name="start_date" value="<?php echo mj_gmgt_getdate_in_input_box($meeting_data->start_date); ?>" disabled>
									<label class="" for="member_id"><?php esc_html_e('Start Date','gym_mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="end_date" class="form-control validate[required] text-input" type="text" name="end_date" value="<?php echo mj_gmgt_getdate_in_input_box($meeting_data->end_date); ?>">
									<label class="" for="member_id"><?php esc_html_e('End Date','gym_mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 note_text_notice">
							<div class="form-group input">
								<div class="col-md-12 note_border margin_bottom_15px_res">
									<div class="form-field">
										<textarea name="agenda" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="500" id=""><?php echo $meeting_data->agenda; ?></textarea>
										<span class="txt-title-label"></span>
										<label class="text-area address active" for=""><?php esc_html_e('Description','gym_mgt');?></label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="password" class="form-control validate[minSize[8],maxSize[12]]" type="password" value="<?php echo $meeting_data->password; ?>" name="password">
									<label class="" for="member_id"><?php esc_html_e('Password','gym_mgt');?></label>
								</div>
							</div>
						</div>
						<?php wp_nonce_field( 'edit_meeting_nonce' ); ?>
					</div>
				</div>
				<div class="form-body user_form"> <!-- user_form Strat-->   
					<div class="row"><!--Row Div Strat--> 
						<div class="col-sm-6 col-md-6 col-lg-6">        	
							<input type="submit" value="<?php  _e('Save Meeting','gym_mgt'); ?>" name="edit_meeting" class="btn save_btn" />
						</div>   
					</div> 
				</div>    
    		</form>
		</div>
		<?php
	}
	elseif($active_tab == 'view_past_participle_list')
	{
		
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
						<table id="past_participle_list" class="display datatable" cellspacing="0" width="100%">
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
			<div class="calendar-event-new margin_top_12p"> 
				<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
			</div>
			<?php
		}
	}
	?>
</div>