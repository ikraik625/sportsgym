<?php 
$obj_class=new MJ_gmgt_classschedule;

$obj_membership=new MJ_gmgt_membership;

$obj_guest_booking = new MJ_gmgt_guest_booking;

$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'classlist';

$role=MJ_gmgt_get_roles(get_current_user_id());

if($role == 'administrator')

{

	$user_access_add=1;

	$user_access_edit=1;

	$user_access_delete=1;

	$user_access_view=1;

}

else

{

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('class-schedule');

	$user_access_add=$user_access['add'];

	$user_access_edit=$user_access['edit'];

	$user_access_delete=$user_access['delete'];

	$user_access_view=$user_access['view'];

	if (isset ( $_REQUEST ['page'] ))

	{	

		if($user_access_view=='0')

		{	

			MJ_gmgt_access_right_page_not_access_message_for_management();

			die;

		}

		if(!empty($action))

		{

			if ('class-schedule' == $user_access['page_link'] && ($action=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('class-schedule' == $user_access['page_link'] && ($action=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('class-schedule' == $user_access['page_link'] && ($action=='insert'))

			{

				if($user_access_add=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			} 

		}

	}

}

?>

<!-- POP up code -->

<div class="popup-bg z_index_100000">

    <div class="overlay-content">

		<div class="modal-content">

		   <div class="category_list"></div>

		</div>

    </div> 

</div>

<!-- End POP-UP Code -->

<div class="page-inner min_height_1631"><!-- PAGE INNNER DIV START-->

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

		<?php 

		//SAVE Class DATA

		if(isset($_POST['save_class']))

		{	

			$nonce = $_POST['_wpnonce'];

			if (wp_verify_nonce( $nonce, 'save_class_nonce' ) )

			{

				$start_date=MJ_gmgt_get_format_for_db($_POST['start_date']);

				$end_date=MJ_gmgt_get_format_for_db($_POST['end_date']);
				
				if($start_date <=  $end_date)
				{

					if(isset($action) && $action=='edit')
					{

						$time_validation=0;
												
						/* start_ampm equal to end_ampm */
						if(sanitize_text_field($_POST['start_ampm']) == sanitize_text_field($_POST['end_ampm']) )

						{
							/* start_time is 12 & end_time less than 12 OR end_time is 12 & start_time greater than 12*/
							if (sanitize_text_field($_POST['start_time']) == 12 && sanitize_text_field($_POST['end_time']) < 12 || sanitize_text_field($_POST['end_time']) == 12 && sanitize_text_field($_POST['start_time']) > 12) 
							{
								$time_validation ='0';	
							}
							/* Start_time greater than end_time */
							elseif(sanitize_text_field($_POST['end_time']) < sanitize_text_field($_POST['start_time']))
							{
								$time_validation ='1';	
							}
							/* start_time equal to end_time but start_min greater than end_min */
							elseif(sanitize_text_field($_POST['end_time']) ==  sanitize_text_field($_POST['start_time']) && sanitize_text_field($_POST['start_min']) > sanitize_text_field($_POST['end_min']) )
							{
								$time_validation ='1';
							}
							/* start_time & end_time are same or start_min & end_min are same */
							elseif(sanitize_text_field($_POST['end_time']) ==  sanitize_text_field($_POST['start_time']) && sanitize_text_field($_POST['start_min']) == sanitize_text_field($_POST['end_min']) )
							{
								$time_validation ='1';
							}
							else{
								$time_validation ='0';
							}

						}
						else
						{
								$time_validation='0';
						}

						if($time_validation =='1')
						{
							?>
							<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">
								<p><?php esc_html_e('End Time should be greater than Start Time.','gym_mgt');?></p>
								<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
							</div>
							<?php 
						}
						else
						{
                            //EDIT CLASS//							
							$result=$obj_class->MJ_gmgt_add_class($_POST);
							if($result)
							{
								wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=classlist&message=2');
							}
						}				
					}

					else
					{	
						$time_validation=0;
						if(!empty($_POST['start_time']))
						{
							foreach($_POST['start_time'] as $key=>$start_time)
							{
								/* start_ampm equal to end_ampm */
								if($_POST['start_ampm'][$key] == $_POST['end_ampm'][$key] )
								{
									/* start_time is 12 & end_time less than 12 OR end_time is 12 & start_time greater than 12*/
								    if($_POST['start_time'][$key] == 12 && $_POST['end_time'][$key] < 12 || $_POST['end_time'][$key] == 12 && $_POST['start_time'][$key] > 12)
									{
										$time_validation ='0';
									}
									/* Start_time greater than end_time */
									elseif(sanitize_text_field($_POST['end_time'][$key]) < sanitize_text_field($_POST['start_time'][$key]))
									{
										$time_validation ='1';	
									}
									/* start_time equal to end_time but start_min greater than end_min */
									elseif(sanitize_text_field($_POST['end_time'][$key]) ==  sanitize_text_field($_POST['start_time'][$key]) && sanitize_text_field($_POST['start_min'][$key]) > sanitize_text_field($_POST['end_min'][$key]) )
									{
										$time_validation ='1';
									}
									/* start_time & end_time are same or start_min & end_min are same */
									elseif(sanitize_text_field($_POST['end_time'][$key]) ==  sanitize_text_field($_POST['start_time'][$key]) && sanitize_text_field($_POST['start_min'][$key]) == sanitize_text_field($_POST['end_min'][$key]) )
									{
										$time_validation ='1';
									}
									else{
										$time_validation ='0';
									}
								}
								else
								{
									$time_validation ='0';	
								}
							}
						}
						if($time_validation =='1')
						{
							?>

							<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

								<p><?php esc_html_e('End Time should be greater than Start Time.','gym_mgt');?></p>

								<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

							</div>

							<?php 

						}
						else
						{
							//ADD CLASS
							$result=$obj_class->MJ_gmgt_add_class($_POST);
							
							global $wpdb;
							$table_class = $wpdb->prefix. 'gmgt_class_schedule';

							$class_shedule_data = $wpdb->get_row("SELECT * FROM $table_class where class_id=$result");
							$day_name = json_decode($class_shedule_data->day);
							
							if($_POST['create_virtual_classroom'] == "1")
							{
								foreach($day_name as $day)
								{
									$metting_data=array(
										'start_time'=>$class_shedule_data->start_time,
										'password'=>$_POST['password'],
										'agenda'=>$_POST['agenda'],
										'end_time'=>$class_shedule_data->end_time,
										'days'=>$day,
										'staff_id'=>$_POST['staff_id'],
										'start_date'=>MJ_gmgt_get_format_for_db($_POST['start_date']),
										'end_date'=>MJ_gmgt_get_format_for_db($_POST['end_date']),
										'class_name'=>$_POST['class_name'],
										'class_id'=>$class_shedule_data->class_id,
									);
									$zoom_meeting_result = $obj_virtual_classroom->MJ_gmgt_create_meeting_in_zoom($metting_data);
								}
							}
							
							if($result)
							{
								$wizard = MJ_gmgt_setup_wizard_steps_updates('step5_class');
								wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=classlist&message=1');

							}

						}

					}

				}

				else

				{ ?>

					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

						<p><?php esc_html_e('End Date should be greater than Start Date','gym_mgt');?></p>

						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

					</div>  

				<?php 

				}

			}

		}

		//Delete Class DATA	AND Booked CLASS DATA	

		if(isset($action)&& $action=='delete')

		{

				//Delete Guest Data

				if(esc_attr($_REQUEST['guest_id']))

				{

					$result=$obj_guest_booking->MJ_gmgt_delete_guest_booking(esc_attr($_REQUEST['guest_id']));

					if($result)

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=guest_list&message=5');

					}

				}

				

				if(esc_attr($_REQUEST['class_id']))
				{
					global $wpdb;
					/* 
					$table_name = $wpdb->prefix .'gmgt_class_schedule';
					$result =$wpdb->get_row("SELECT * FROM $table_name WHERE class_id=".$_REQUEST['class_id']);
					$my_array_data = json_decode($result->day, TRUE);
					$index = array_search($_REQUEST['daykey'], $my_array_data); 
					unset($my_array_data[$index]);
					$array_value = array_values($my_array_data);
					$comma_separated = json_encode($array_value);
					$classdata['day'] = $comma_separated; 
					$classid['class_id'] = $_REQUEST['class_id'];
					$result=$wpdb->update( $table_name, $classdata ,$classid); */
					$result=$obj_class->MJ_gmgt_delete_class(esc_attr($_REQUEST['class_id']));
					if($result)
					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=classlist&message=3');

					}

				}

				else

				{

					$result=$obj_class->MJ_gmgt_delete_booked_class(esc_attr($_REQUEST['class_booking_id']));

					if($result)

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=booking_list&message=4');

					}

				}

		}

		//Selected CLASS DATA Delete	

		if(isset($_REQUEST['delete_selected']))

		{		

			if(!empty($_REQUEST['selected_id']))

			{

				foreach($_REQUEST['selected_id'] as $id)

				{

					$delete_class=$obj_class->MJ_gmgt_delete_class($id);

					if($delete_class)

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_class&tab=classlist&message=3');

					}

				}

			}

			else

			{

				echo '<script language="javascript">';

				echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';

				echo '</script>';

			}

		}

		if(isset($_POST['create_meeting']))

		{

			$nonce = $_POST['_wpnonce'];

			if ( wp_verify_nonce( $nonce, 'create_meeting_admin_nonce' ) )

			{

				

				$result = $obj_virtual_classroom->MJ_gmgt_create_meeting_in_zoom($_POST);

				if($result)

				{

					wp_redirect ( admin_url().'admin.php?page=gmgt_virtual_class&tab=meeting_list&message=1');

				}

					

			}

		}

		if(isset($_REQUEST['message']))

		{

			$message =esc_attr($_REQUEST['message']);

			if($message == 1)

			{

			?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Class added successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php

			}

			elseif($message == 2)

			{

			?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("Class updated successfully.",'gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php 			

			}

			elseif($message == 3) 

			{

			?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Class deleted successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php				

			}

			elseif($message == 4) 

			{

			?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Booked Class deleted successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php				

			}

			elseif($message == 5) 

			{

			?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Guest Class deleted successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php				

			}

		}

		?>

		<div class="row"><!-- ROW DIV START-->

			<div class="col-md-12 padding_0"><!-- COL 12 DIV START-->

				<div class="panel-body "><!-- PANEL BODY DIV START-->

					<ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->

						<li class="<?php if($active_tab=='classlist'){?>active<?php }?>">

							<a href="?page=gmgt_class&tab=classlist" class="padding_left_0 tab <?php echo $active_tab == 'classlist' ? 'nav-tab-active' : ''; ?>">

							<?php echo esc_html__('Class List', 'gym_mgt'); ?></a>

						</li>

						<!-- <a href="?page=gmgt_class&tab=classlist" class="nav-tab <?php echo $active_tab == 'classlist' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="dashicons dashicons-menu"></span> '.esc_html__('Class List', 'gym_mgt'); ?></a> -->

						<?php
						$action = "";
						if(!empty($_REQUEST['action']))
						{
							$action = $_REQUEST['action'];
						}
						if(isset($action) && $action == 'edit')

						{?>

							<li class="<?php if($active_tab=='addclass' || $action == 'edit'){?>active<?php }?>">

								<a href="?page=gmgt_class&tab=addclass&action=edit&class_id=<?php echo esc_attr($_REQUEST['class_id']);?>" class="padding_left_0 tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Edit Class', 'gym_mgt'); ?></a>  

							</li>

						<?php

						}

						else

						{

							if($user_access_add == '1')

							{

								?>

								<li class="<?php if($active_tab=='addclass' || $action == 'edit'){?>active<?php }?>">

									<a href="?page=gmgt_class&tab=addclass" class="padding_left_0 tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Add Class', 'gym_mgt'); ?>

									</a>

								</li>

								<?php

							}

						}

						?>

							<li class="<?php if($active_tab=='schedulelist'){?>active<?php }?>">

								<a href="?page=gmgt_class&tab=schedulelist" class="padding_left_0 tab <?php echo $active_tab == 'schedulelist' ? 'nav-tab-active' : ''; ?>">

								<?php echo esc_html__('Schedule List', 'gym_mgt'); ?></a>

							</li>

							<li class="<?php if($active_tab=='booking_list'){?>active<?php }?>">

								<a href="?page=gmgt_class&tab=booking_list" class="padding_left_0 tab <?php echo $active_tab == 'booking_list' ? 'nav-tab-active' : ''; ?>">

								<?php echo esc_html__('Booking List', 'gym_mgt'); ?></a>

							</li>

							<li class="<?php if($active_tab=='guest_list'){?>active<?php }?>">

								<a href="?page=gmgt_class&tab=guest_list" class="padding_left_0 tab <?php echo $active_tab == 'guest_list' ? 'nav-tab-active' : ''; ?>">

								<?php echo  esc_html__('Guest Booking List','gym_mgt'); ?></a>

							</li>

					</ul><!-- NAV TAB WRAPPER MENU END-->

					<?php 	

					if($active_tab == 'classlist')

					{ 		

						$classdata=$obj_class->MJ_gmgt_get_all_classes();

						if(!empty($classdata))

						{				

							?>	

							<script type="text/javascript">

								$(document).ready(function()

								{

									"use strict";

									jQuery('#class_list').DataTable({

										// "responsive": true,

										dom: 'lifrtp',

										"aoColumns":[

												{"bSortable": false},

												{"bSortable": false},

												{"bSortable": true},

												{"bSortable": true},

												{"bSortable": true},

												{"bSortable": true},

												{"bSortable": true},

												{"bSortable": false}],

										language:<?php echo MJ_gmgt_datatable_multi_language();?>  

									});

									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

									$('.select_all').on('click', function(e)

											{

												if($(this).is(':checked',true))  

												{

													$(".sub_chk").prop('checked', true);  

												}  

												else  

												{  

													$(".sub_chk").prop('checked',false);  

												} 

											});

									$("body").on("change",".sub_chk",function(){

								

										if(false == $(this).prop("checked"))

										{ 

											$(".select_all").prop('checked', false); 

										}

										if ($('.sub_chk:checked').length == $('.sub_chk').length )

										{

											$(".select_all").prop('checked', true);

										}

									});

									$(".delete_selected").on('click', function()

									{	

										if ($('.select-checkbox:checked').length == 0 )

										{

											alert("<?php esc_html_e('Please select at least one record','gym_mgt');?>");

											return false;

										}

										else

										{

											var proceed = confirm("<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>");

											if (proceed) {

												return true;

											} else {

												return false;

											}

										}

									});

								});

							</script>

							<form name="wcwm_report" action="" method="post"><!-- CLASS LIST FORM START-->						

								<div class="panel-body padding_0"><!-- PANEL BODY DIV START-->

									<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START-->

										<table id="class_list" class="display" cellspacing="0" width="100%"><!-- TABLE CLASS LIST START-->

											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

												<tr>

													<th class="padding_0"><input type="checkbox" class="select_all"></th>

													<th><?php esc_html_e('Photo','gym_mgt');?></th>

													<th><?php esc_html_e('Class Name','gym_mgt');?></th>

													<th><?php esc_html_e('Staff Name','gym_mgt');?></th>

													<th><?php esc_html_e('Start Time','gym_mgt');?></th>

													<th><?php esc_html_e('End Time','gym_mgt');?></th>

													<th><?php esc_html_e('Day','gym_mgt');?></th>

													<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

												</tr>

											</thead>
							 

											<tbody>

											<?php 										

												//$classdata=$obj_class->MJ_gmgt_get_all_classes();

												if(!empty($classdata))

												{

													$i=0;

													foreach ($classdata as $retrieved_data)

													{
														if(!empty($retrieved_data->video_entry))
														{
															$video_data=json_decode($retrieved_data->video_entry);
														}
														
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

															<td class="checkbox_width_10px">

																<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->class_id); ?>">

															</td>

															<td class="user_image width_50px profile_image_prescription padding_left_0">	

																<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

																</p>

															</td>

															<td class="classname">

																<a href="#" class="view_details_popup" id="<?php echo esc_attr($retrieved_data->class_id)?>" type="<?php echo 'view_class';?>"><?php echo esc_html($retrieved_data->class_name);?></a>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>

															</td>

															<td class="staff">

																<?php $display_name=MJ_gmgt_get_user_full_display_name($retrieved_data->staff_id);echo esc_html($display_name);?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Name','gym_mgt');?>" ></i>

															</td>

															<td class="starttime">

																<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->start_time));?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time','gym_mgt');?>" ></i>

															</td>

															<td class="endtime">

																<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->end_time));?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Time','gym_mgt');?>" ></i>

															</td>

															<td class="day">

																<?php 

																$days_array=json_decode($retrieved_data->day);

																$days_string=array();

																if(!empty($days_array))

																{

																	foreach($days_array as $day)

																	{

																		//$days_string[]=substr($day,0,3);

																		$days_class_schedule=substr($day,0,3);

																		$days_string[]=__($days_class_schedule,'gym_mgt');

																	}

																}

																echo implode(", ",$days_string);

																?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>

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

																					<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->class_id)?>" type="<?php echo 'view_class';?>"> <i class="fa fa-eye"></i><?php esc_html_e('View','gym_mgt');?> 

																					</a>

																				</li>

																				<?php if($user_access_edit == '1')

																				{ ?>	

																					<li class="float_left_width_100 border_bottom_item">

																						<a href="?page=gmgt_class&tab=addclass&action=edit&class_id=<?php echo esc_attr($retrieved_data->class_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>

																						</a>

																					</li>

																					<?php

																				}

																				if($user_access_delete =='1')

																				{ ?>

																					<li class="float_left_width_100">

																						<a href="?page=gmgt_class&tab=classlist&action=delete&class_id=<?php echo esc_attr($retrieved_data->class_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																					</li>

																					<?php 

																				} ?>

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

										</table><!-- TABLE CLASS LIST END-->

										<!-------- Delete And Select All Button ----------->

										<div class="print-button pull-left">

											<button class="btn btn-success btn-sms-color">

												<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">

												<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>

											</button>

											<?php 

											if($user_access_delete =='1')

											{ ?>

												<button data-toggle="tooltip"  id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>

												<?php 

											} 

											?>

										</div>

										<!-------- Delete And Select All Button ----------->

										

									</div><!-- TABLE RESPONSIVE DIV END-->		

								</div><!-- PANEL BODY DIV END-->

							</form><!-- CLASS LIST FORM END-->

							<?php 

						}

						else

						{
							if($user_access_add == 1)
							{
								?>

								<div class="no_data_list_div"> 

									<a href="<?php echo admin_url().'admin.php?page=gmgt_class&tab=addclass';?>">

										<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >

									</a>

									<div class="col-md-12 dashboard_btn margin_top_20px">

										<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>

									</div> 

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

						}

					}						

					if($active_tab == 'addclass')

					{

						require_once GMS_PLUGIN_DIR. '/admin/class-schedule/add_class.php';

					}

					if($active_tab == 'schedulelist')

					{

						require_once GMS_PLUGIN_DIR. '/admin/class-schedule/schedule_list.php';

					}

					if($active_tab == 'booking_list')

					{

					require_once GMS_PLUGIN_DIR. '/admin/class-schedule/booking_list.php';

					}

					if($active_tab == 'guest_list')

					{

					require_once GMS_PLUGIN_DIR. '/admin/class-schedule/guest_list.php';

					}

					?>

				</div><!-- PANEL BODY DIV END-->

			</div><!-- COL 12 DIV END-->

		</div><!-- ROW DIV END-->

		

	</div><!--MAIN_LIST_MARGING_15px END  -->

</div><!-- PAGE INNNER DIV END-->