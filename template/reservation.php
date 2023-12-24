<?php $curr_user_id=get_current_user_id();

$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);

$obj_reservation=new MJ_gmgt_reservation;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'reservationlist';

//access right

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

//SAVE Reservation DATA

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

				<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

					<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

					</button>

					<p><?php esc_html_e('End Time should be greater than Start Time.','gym_mgt');?></p>

				</div>

				<?php 

			}

			else

			{	

				$result=$obj_reservation->MJ_gmgt_add_reservation($_POST);

				if($result['msg']!='reserved')

				{

					if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app')

					{

						wp_redirect ( home_url().'?dashboard=user&page=reservation&page_action=web_view_hide&reservation_list_app_view=reservationlist_app&message=2');

					}

					else

					{

						wp_redirect ( home_url().'?dashboard=user&page=reservation&tab=reservationlist&message=2');

					}

				}

				else

				{

					if(isset($result['msg']))

					{

						$_REQUEST['reservation_id']=$result['id'];

						?>

						<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

							<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

							</button>

							<p><?php esc_html_e('This Date is Already Reserved.','gym_mgt');?></p>

						</div>

					<?php

					}

				}

			}	

		}

		else

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

			$post_date=date("Y-m-d", strtotime($_POST['event_date']) );

			$all_data=$obj_reservation->MJ_gmgt_get_all_reservation();

	

			if(in_array($post_date,array_column($all_data,'event_date')) && in_array(sanitize_text_field($_POST['end_time']).':'.sanitize_text_field($_POST['end_min']).':'.sanitize_text_field($_POST['end_ampm']),array_column($all_data,'end_time')) && in_array(sanitize_text_field($_POST['start_time']).':'.$_POST['start_min'].':'.sanitize_text_field($_POST['start_ampm']),array_column($all_data,'start_time')))

			{

				$time_validation='2';

			}

			if($time_validation=='1')

			{

			?>

					<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

					<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

					</button>

						<p><?php esc_html_e('End Time should be greater than Start Time','gym_mgt');?></p>

					</div>

			<?php 

			}

			elseif($time_validation=='2')

			{

			?>

				<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

					<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

					</button>

					<p><?php esc_html_e('This time and date already reserved.','gym_mgt');?></p>

				</div>

			<?php 

			}

			else

			{



				$result=$obj_reservation->MJ_gmgt_add_reservation($_POST);



				if($result!="reserved")

				{

					if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app')

					{

						wp_redirect ( home_url().'?dashboard=user&page=reservation&page_action=web_view_hide&reservation_list_app_view=reservationlist_app&message=1');

					}

					else

					{

						wp_redirect ( home_url().'?dashboard=user&page=reservation&tab=reservationlist&message=1');

					}

					

				}

				else

				{

					?>

					<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

						<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

						</button>

						<p><?php esc_html_e('This time and date already reserved.','gym_mgt');?></p>

					</div>

					<?php

				}

			}

			

		}

	}

}

//Delete Reservation DATA

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

{

	$result=$obj_reservation->MJ_gmgt_delete_reservation($_REQUEST['reservation_id']);

	if($result)

	{

		if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app')

		{

			wp_redirect ( home_url().'?dashboard=user&page=reservation&page_action=web_view_hide&reservation_list_app_view=reservationlist_app&message=3');

		}

		else

		{

			wp_redirect ( home_url().'?dashboard=user&page=reservation&tab=reservationlist&message=3');

		}

		

	}

}

if(isset($_REQUEST['message']))

{

	$message =esc_attr($_REQUEST['message']);

	if($message == 1)

	 {?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e('Reservation added successfully.','gym_mgt');?></p>

		</div>

	<?php

	}

	elseif($message == 2)

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e("Reservation updated successfully.",'gym_mgt');?></p>

		</div>

	<?php 

	}

	elseif($message == 3) 

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e('Reservation deleted successfully.','gym_mgt');?></p>

		</div>

	<?php

	}

}

?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";
	$(".display-members").select2();

	var date = new Date();

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

            date.setDate(date.getDate()-0);

             $('#event_date').datepicker({

			 dateFormat:'<?php  echo get_option('gmgt_datepicker_format'); ?>',	

	         <?php

			if(get_option('gym_enable_datepicker_privious_date')=='no')

			{

			?>

				minDate:'today',

				startDate: date,

			<?php

			}

			?>	

             autoclose: true

           }); 	

		$('#reservation_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

} );

</script>

<div class="panel-body panel-white padding_0"><!-- PANEL BODY DIV START-->

	<div class="tab-content padding_0"><!-- TAB CONTENT DIV START-->

		<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

			<?php 

			if($active_tab == 'reservationlist')

			{ 

				

				if($user_access['own_data']=='1')

				{

					$reservationdata=$obj_reservation->MJ_gmgt_get_reservation_by_created_by();

				}

				else

				{

					$reservationdata=$obj_reservation->MJ_gmgt_get_all_reservation();

				}	



				if(!empty($reservationdata))

				{

					?>	



					<script type="text/javascript">

						$(document).ready(function() 

						{

							"use strict";

							jQuery('#reservation_list').DataTable({

							// "responsive": true,

							"order": [[ 0, "asc" ]],

							dom: 'lifrtp',

							"aoColumns":[

										{"bSortable": false},

										{"bSortable": true},

										{"bSortable": true},

										{"bSortable": true},

										{"bSortable": true},

										{"bSortable": true},	

										{"bSortable": true},  

										<?php

										if($user_access['edit']=='1' || $user_access['delete']=='1')

										{	

										?>

											{"bSortable": false}

										<?php

										}

									?>

										],

								language:<?php echo MJ_gmgt_datatable_multi_language();?>			

							});

							$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

						} );

					</script>

					<form name="wcwm_report" action="" method="post"><!--Reservation LIST FORM START-->

						<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START-->

								<table id="reservation_list" class="display" cellspacing="0" width="100%"><!-- RESPONSIVE LIST TABLE START-->

									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

										<tr>

										<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>

											<th><?php esc_html_e('Event Name', 'gym_mgt' ) ;?></th>

											<th><?php esc_html_e('Event Date', 'gym_mgt' ) ;?></th>

											<th><?php esc_html_e('Event Place', 'gym_mgt' ) ;?></th>

											<th><?php esc_html_e('Start Time', 'gym_mgt' ) ;?></th>

											<th><?php esc_html_e('End Time', 'gym_mgt' ) ;?></th>

											<th><?php esc_html_e('Reserved By', 'gym_mgt' ) ;?></th>

											<?php

											if($user_access['edit']=='1' || $user_access['delete']=='1')

											{	

											?>	

												<th class="text_align_end"><?php esc_html_e('Action', 'gym_mgt' ) ;?></th>		

											<?php

											}

											?>		

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

													<td class="user_image width_50px profile_image_prescription padding_left_0">	

														<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Reservation.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

														</p>

													</td>

													<td class="eventname">

														<?php if($obj_gym->role == 'staff_member')

														{

															if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app')

															{

																?>

																<?php echo esc_html($retrieved_data->event_name);?>

																<?php 

															}

															else 

															{

																?>

																<a href="?dashboard=user&page=reservation&tab=addreservation&action=edit&reservation_id=<?php echo esc_attr($retrieved_data->id);?>"><?php echo esc_html($retrieved_data->event_name);?></a>

																<?php 

															}

														}

														else

														{

															?>

															<?php echo esc_html($retrieved_data->event_name);?>

															<?php

														}

														?>

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

													<?php

													if($user_access['edit']=='1' || $user_access['delete']=='1')

													{	

														?>

														<td class="action"> 

															<div class="gmgt-user-dropdown">

																<ul class="" style="margin-bottom: 0px !important;">

																	<li class="">

																		<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">

																			<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >

																		</a>

																		<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

															

																			<?php

																			if($user_access['edit']=='1')

																			{

																				if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app')

																				{

																					?>

																					<li class="float_left_width_100 border_bottom_item">

																						<a href="?dashboard=user&page=reservation&tab=addreservation&action=edit&page_action=web_view_hide&reservation_list_app_view=reservationlist_app&reservation_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php

																				}

																				else

																				{

																					?>

																					<li class="float_left_width_100 border_bottom_item">

																						<a href="?dashboard=user&page=reservation&tab=addreservation&action=edit&reservation_id=<?php echo esc_attr($retrieved_data->id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php

																				}

																			}

																			if($user_access['delete']=='1')

																			{

																				if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app')

																				{

																				?>	

																					<li class="float_left_width_100">

																						<a href="?dashboard=user&page=reservation&tab=reservationlist&action=delete&page_action=web_view_hide&reservation_list_app_view=reservationlist_app&reservation_id=<?php echo 	esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																					</li>

																					<?php

																				}

																				else

																				{

																					?>	

																					<li class="float_left_width_100">

																						<a href="?dashboard=user&page=reservation&tab=reservationlist&action=delete&reservation_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																					</li>

																					<?php

																				}

																			}

																			?>

																		</ul>

																	</li>

																</ul>

															</div>	

														</td>

														<?php

													}

													?>	  

												</tr>

												<?php 

												$i++;

											} 

										}?>

									</tbody>

								</table><!-- RESPONSIVE LIST TABLE END-->

							</div><!-- TABLE RESPONSIVE DIV END-->

						</div><!-- PANEL BODY DIV END-->

					</form><!-- RESPONSIVE LIST FORM END-->

					<?php 

				}

				else

				{

					if($user_access['add']=='1')

					{

						?>

						<div class="no_data_list_div"> 

							<a href="
							<?php 
							if(isset($_REQUEST['reservation_list_app_view']) && $_REQUEST['reservation_list_app_view'] == 'reservationlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')
							{
								echo "?dashboard=user&page=reservation&tab=addreservation&page_action=web_view_hide&reservation_list_app_view=reservationlist_app&action=insert";
							}
							else
							{
								echo home_url().'?dashboard=user&page=reservation&tab=addreservation&&action=insert';
							}
							?>">

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

				$reservation_id=0;

				$edit=0;

				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

				{

					$edit=1;

					$reservation_id=$_REQUEST['reservation_id'];

					$result = $obj_reservation->MJ_gmgt_get_single_reservation($reservation_id);

					

				}?>

				<!-- POP up code -->

				<div class="popup-bg">

				<div class="overlay-content">

						<div class="modal-content">

							<div class="category_list"></div>

						</div>

					</div> 

				</div>

				<!-- End POP-UP Code -->

				<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->

					<form name="reservation_form" action="" method="post" class="form-horizontal" id="reservation_form"><!-- Reservation FORM START -->

						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

						<input type="hidden" name="reservation_id" value="<?php echo esc_attr($reservation_id);?>"  />

						<input type="hidden" name="staff_id" value="<?php echo get_current_user_id();?>"  />

						

						<div class="header">	

							<h3 class="first_hed"><?php esc_html_e('Reservation Information','gym_mgt');?></h3>

						</div>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

									<div class="form-group input">

										<div class="col-md-12 form-control">

											<input id="event_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" type="text" maxlength="100" value="<?php if($edit){ echo esc_attr($result->event_name);}elseif(isset($_POST['event_name'])) echo esc_attr($_POST['event_name']);?>" name="event_name">

											<label class="" for="event_name"><?php esc_html_e('Event Name','gym_mgt');?><span class="require-field">*</span></label>

										</div>

									</div>

								</div>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

									<div class="form-group input">

										<div class="col-md-12 form-control">

											<input id="event_date" class="form-control" type="text"  name="event_date" value="<?php if($edit){ if($result->event_date == "0000-00-00"){ echo "0000-00-00"; }else{ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->event_date)); } }elseif(isset($_POST['event_date'])){ echo esc_attr($_POST['event_date']); }else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>

											<label class="" for="event_date"><?php esc_html_e('Event Date','gym_mgt');?></label>

										</div>

									</div>

								</div>

								<!--nonce-->

								<?php wp_nonce_field( 'save_group_nonce' ); ?>

								<!--nonce-->

								<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

									<label class="ml-1 custom-top-label top" for="event_place"><?php esc_html_e('Event Place','gym_mgt');?><span class="require-field">*</span></label>

									<select class="form-control validate[required] max_width_100" name="event_place" id="event_place">

										<option value=""><?php esc_html_e('Select Event Place','gym_mgt');?></option>

										<?php

										if(isset($_REQUEST['event_place']))

										{

											$category =esc_attr($_REQUEST['event_place']);  

										}

										elseif($edit)

										{

											$category =$result->place_id;

										}

										else

										{ 

											$category = "";

										}

										$mambership_category=MJ_gmgt_get_all_category('event_place');

										if(!empty($mambership_category))

										{

											foreach ($mambership_category as $retrive_data)

											{

												echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';

											}

										}

										?>

									</select>

								</div>

								<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">

									<button id="addremove" class="add_btn" model="event_place"><?php esc_html_e('Add','gym_mgt');?></button>

								</div>



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

									<!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label> -->

									<?php

									$get_staff = array('role' => 'Staff_member');

									$staffdata=get_users($get_staff);?>

									<select name="staff_id" class="form-control validate[required] max_width_100 display-members" id="staff_id">

										<option value=""><?php esc_html_e('Select Staff Member','gym_mgt');?></option>

										<?php 

										if($edit)

										{

											$staff_data=$result->staff_id;

										}

										elseif(isset($_POST['staff_id']))

										{

											$staff_data=sanitize_text_field($_POST['staff_id']);

										}

										else

										{

											$staff_data="";

										}

										if(!empty($staffdata))

										{

											foreach($staffdata as $staff)

											{

												

												echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).'</option>';

											}

										}

										?>

									</select>

								</div>	



								<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

									<label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label>	

									<?php 

									if($edit)

									{

										$start_time_data = explode(":", $result->start_time);

									}

									?>

									<select name="start_time" class="form-control validate[required] max_width_100">

										<option value=""><?php esc_html_e('Start Time','gym_mgt');?></option>

										<?php 

											for($i =0 ; $i <= 12 ; $i++)

											{

											?>

												<option value="<?php echo esc_attr($i);?>" <?php  if($edit) selected(esc_attr($start_time_data[0]),esc_attr($i));  ?>><?php echo esc_html($i);?></option>

											<?php

											}

										?>

									</select>

								</div>	

								<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

									<select name="start_min" class="form-control validate[required]">

									<?php 

										foreach(MJ_gmgt_minute_array() as $key=>$value)

										{?>

										<option value="<?php echo esc_attr($key);?>" <?php  if($edit) selected(esc_attr($start_time_data[1]),esc_attr($key)); ?>><?php echo esc_html($value);?></option>

										<?php

										}

									?>

									</select>

								</div>

								<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

									<select name="start_ampm" class="form-control validate[required] ">

										<option value="am" <?php  if($edit) if(isset($start_time_data[2])) selected(esc_attr($start_time_data[2]),'am');  ?>><?php esc_html_e('am','gym_mgt');?></option>

										<option value="pm" <?php  if($edit) if(isset($start_time_data[2])) selected(esc_attr($start_time_data[2]),'pm');  ?>><?php esc_html_e('pm','gym_mgt');?></option>

									</select>

								</div>

								

							

								<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

									<label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label>

									<?php 

									if($edit)

									{

										$end_time_data = explode(":", $result->end_time);

									}

									?>

									<select name="end_time" class="form-control validate[required]">

										<option value=""><?php esc_html_e('End Time','gym_mgt');?></option>

										<?php 

											for($i =0 ; $i <= 12 ; $i++)

											{

											?>

											<option value="<?php echo esc_attr($i);?>" <?php  if($edit) selected(esc_attr($end_time_data[0]),esc_attr($i));  ?>><?php echo esc_html($i);?></option>

											<?php

											}

										?>

									</select>

								</div>

								<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

									<select name="end_min" class="form-control validate[required] ">

										<?php 

										foreach(MJ_gmgt_minute_array() as $key=>$value)

										{  ?>

											<option value="<?php echo esc_attr($key);?>" <?php if($edit) selected(esc_attr($end_time_data[1]),esc_attr($key));  ?>><?php echo esc_html($value);?></option>

											<?php

										} ?>

									</select>

								</div>					

								<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

									<select name="end_ampm" class="form-control validate[required] ">

										<option value="am" <?php  if($edit) if(isset($end_time_data[2])) selected(esc_attr($end_time_data[2]),'am'); ?> ><?php esc_html_e('am','gym_mgt');?></option>

										<option value="pm" <?php  if($edit) if(isset($end_time_data[2]))selected(esc_attr($end_time_data[2]),'pm');  ?>><?php esc_html_e('pm','gym_mgt');?></option>

									</select>

								</div>	

							</div><!--Row Div End--> 

						</div><!-- user_form End-->  

						<!------------   save btn  -------------->  

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat-->  

								<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  				

									<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_group" class="btn save_btn"/>

								</div>		

							</div><!--Row Div End--> 

						</div><!-- user_form End-->



					</form><!-- Reservation FORM END -->

				</div><!-- PANEL BODY DIV END-->

				<?php 

			}

			?>

		</div><!--MAIN_LIST_MARGING_15px END  -->

	</div><!-- TAB CONTENT DIV END-->

</div><!-- PANEL BODY DIV END-->