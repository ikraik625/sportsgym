<?php  $curr_user_id=get_current_user_id();

$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);

$obj_reservation=new MJ_gmgt_reservation;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'reservationlist';

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

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('reservation');

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

		if(!empty($_REQUEST['action']))

		{

			if ('reservation' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('reservation' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('reservation' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

		<?php 

		//SAVE RESERVATION DATA

		if(isset($_POST['save_group']))

		{   

			$nonce = $_POST['_wpnonce'];

			if (wp_verify_nonce( $nonce, 'save_group_nonce' ) )

			{

				if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

				{

					if($_POST['start_ampm'] == $_POST['end_ampm'] )

					{				

						if($_POST['end_time'] < $_POST['start_time'])

						{

							$time_validation='1';

						}

						elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] > $_POST['end_min'] )

						{

							$time_validation='1';

						}

					}

					else

					{

						if($_POST['start_ampm']!='am')

						{

							$time_validation='1';

						}

					}	

					if($time_validation=='1')

					{

						?>

						<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

						<p><?php esc_html_e('End Time should be greater than Start Time','gym_mgt');?></p>

						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

						</div>

					<?php 

					}

					else

					{		

						$result=$obj_reservation->MJ_gmgt_add_reservation($_POST);

						if($result['msg']!='reserved')

						{

							wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=reservationlist&message=2');

						}

						else

						{

							if(isset($result['msg']))

							{

								$_REQUEST['reservation_id']=esc_attr($result['id']);

								?>

									<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

									<p><?php esc_html_e('This time and date already reserved.','gym_mgt');?></p>

									<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

									</div>

								<?php

							}

						}

					}				

				}
				else
				{
					// $full_endtime = $_POST['end_time'].':'.$_POST['end_min'].' '.strtoupper($_POST['end_ampm']);
					// $curr_time = date("H:s A",time());

					

					if($_POST['start_ampm'] == $_POST['end_ampm'] )

					{				

						if($_POST['end_time'] < $_POST['start_time'])

						{

							$time_validation='1';	

						}

						elseif($_POST['end_time'] ==  $_POST['start_time'] && $_POST['start_min'] > $_POST['end_min'] )

						{

							$time_validation='1';

						}				

					}			

					else

					{

						if($_POST['start_ampm']!='am')

						{

							$time_validation='1';

						}				

					}
					

					$post_date=date("Y-m-d", strtotime($_POST['event_date']) );

					$all_data=$obj_reservation->MJ_gmgt_get_all_reservation();

					if(in_array($post_date,array_column($all_data,'event_date')) && in_array(sanitize_text_field($_POST['end_time']).':'.sanitize_text_field($_POST['end_min']).':'.sanitize_text_field($_POST['end_ampm']),array_column($all_data,'end_time')) && in_array(sanitize_text_field($_POST['start_time']).':'.$_POST['start_min'].':'.sanitize_text_field($_POST['start_ampm']),array_column($all_data,'start_time')))

					{

						$time_validation='2';

					}

					if($time_validation=='1')

					{

					?>

						<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

						<p><?php esc_html_e('End Time should be greater than Start Time','gym_mgt');?></p>

						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

						</div>

					<?php 

					}

					elseif($time_validation=='2')

					{

					?>

						<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

						<p><?php esc_html_e('This time and date already reserved.','gym_mgt');?></p>

						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

						</div>

					<?php 

					}

					else

					{

						$result=$obj_reservation->MJ_gmgt_add_reservation($_POST);

						if($result!="reserved")

						{

							wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=reservationlist&message=1');

						}

						else

						{

							wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=addreservation&message=4');

						}

					}

				}

			}

		}

		//DELETE RESERVATION DATA

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

		{

			$result=$obj_reservation->MJ_gmgt_delete_reservation($_REQUEST['reservation_id']);

			if($result)

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=reservationlist&message=3');

			}

		}

		//DELETE Selected RESERVATION DATA	

		if(isset($_REQUEST['delete_selected']))

		{		

			if(!empty($_REQUEST['selected_id']))

			{

				foreach($_REQUEST['selected_id'] as $id)

				{

					$delete_reservation=$obj_reservation->MJ_gmgt_delete_reservation($id);

				}

				if($delete_reservation)

				{

					wp_redirect ( admin_url().'admin.php?page=gmgt_reservation&tab=reservationlist&message=3');

				}

			}

			else

			{

				echo '<script language="javascript">';

				echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';

				echo '</script>';

			}

		}

		if(isset($_REQUEST['message']))

		{

			$message =esc_attr($_REQUEST['message']);

			if($message == 1)

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Reservation added successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php 	

			}

			elseif($message == 2)

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("Reservation updated successfully.",'gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php	

			}

			elseif($message == 3) 

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Reservation deleted successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php		

			}

			elseif($message == 4) 

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('This Date is Already Reserved Event.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

			<?php		

			}

		}

		?>

		<div class="row"><!--ROW DIV START-->

			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->

				<div class="panel-body"><!--PANEL BODY DIV START-->

					<?php

					if($active_tab == 'reservationlist')

					{ 

						$reservationdata=$obj_reservation->MJ_gmgt_get_all_reservation();

						if(!empty($reservationdata))

						{

							?>	

							<script type="text/javascript">

								$(document).ready(function() 

								{

									"use strict";

									jQuery('#reservation_list').DataTable({

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

										if ($('.sub_chk:checked').length == 0 )

										{

											alert("<?php esc_html_e('Please select at least one record','gym_mgt');?>");

											return false;

										}

										else{

											var proceed = confirm("<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>");

											if (proceed) {

												  return true;

											} else {

												return false;

											}

										}

									});

								} );

							</script>

							<form name="wcwm_report" action="" method="post"><!--RESERVATION LIST FORM START-->

								<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

									<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

										<table id="reservation_list" class="display" cellspacing="0" width="100%"><!--RESERVATION LIST TABLE START-->

											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

												<tr>

													<th class="padding_0"><input type="checkbox" class="select_all"></th>

													<th><?php esc_html_e('Photo','gym_mgt');?></th>

													<th><?php esc_html_e('Event Name','gym_mgt');?></th>

													<th><?php esc_html_e('Event Date','gym_mgt');?></th>

													<th><?php esc_html_e('Event Place','gym_mgt');?></th>

													<th><?php esc_html_e('Start Time','gym_mgt');?></th>

													<th><?php esc_html_e('End Time','gym_mgt');?></th>

													<th><?php esc_html_e('Reserved By','gym_mgt');?></th>

													<th  class="text_align_end"><?php esc_html_e('Action', 'gym_mgt' ) ;?></th>

												</tr>

											</thead>

											<tbody>

												<?php 

												if(!empty($reservationdata))

												{

													$i=0;

													foreach ($reservationdata as $retrieved_data)

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

															<td class="checkbox_width_10px">

																<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk" value="<?php echo esc_attr($retrieved_data->id); ?>">

															</td>

															<td class="user_image width_50px profile_image_prescription padding_left_0">	

																<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Reservation.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

																</p>

															</td>

															<td class="eventname">

																<a href="?page=gmgt_reservation&tab=addreservation&action=edit&reservation_id=<?php echo esc_attr($retrieved_data->id);?>"><?php echo esc_html($retrieved_data->event_name);?></a>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Event Name','gym_mgt');?>" ></i>

															</td>

															<td class="date">

																<?php if($retrieved_data->event_date == "0000-00-00"){ echo "0000-00-00"; }else{ echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->event_date)); } ?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Event Date','gym_mgt');?>" ></i>

															</td>

															<td class="place">

																<?php echo  get_the_title(esc_html($retrieved_data->place_id));?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Event Place','gym_mgt');?>" ></i>

															</td>

															<td class="starttime">

																<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->start_time));?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time','gym_mgt');?>" ></i>

															</td>

															<td class="endtime">

																<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->end_time));?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Time','gym_mgt');?>" ></i>

															</td>

															<td class="staff_id">

																<?php echo MJ_gmgt_get_user_full_display_name(esc_html($retrieved_data->staff_id));?>

																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Reserved By','gym_mgt');?>" ></i>

															</td>

															<td class="action"> 

																<div class="gmgt-user-dropdown">

																	<ul class="" style="margin-bottom: 0px !important;">

																		<li class="">

																			<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">

																				<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >

																			</a>

																			<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

																				<?php if($user_access_edit == '1')

																				{ ?>

																					<li class="float_left_width_100 border_bottom_item">

																						<a href="?page=gmgt_reservation&tab=addreservation&action=edit&reservation_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php

																				}															

																				if($user_access_delete =='1')

																				{ ?>

																					<li class="float_left_width_100">

																						<a href="?page=gmgt_reservation&tab=reservationlist&action=delete&reservation_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

												}?>

											</tbody>

										</table><!--RESERVATION LIST TABLE END-->

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

									</div><!--TABLE RESPONSIVE DIV END-->

								</div><!--PANEL BODY DIV END-->

							</form><!--RESERVATION LIST FORM END-->

							<?php 

						}

						else

						{
							if($user_access_add == 1)
							{
								?>

								<div class="no_data_list_div"> 

									<a href="<?php echo admin_url().'admin.php?page=gmgt_reservation&tab=addreservation';?>">

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

					if($active_tab == 'addreservation')

					{

						require_once GMS_PLUGIN_DIR. '/admin/reservation/add_reservation.php';

					}

					?>

				</div><!--PANEL BODY DIV END-->

			</div><!--COL 12 DIV END-->

		</div><!--ROW DIV END-->

	</div><!-- MAIN_LIST_MARGING_15px END -->

</div><!--PAGE INNER DIV END-->