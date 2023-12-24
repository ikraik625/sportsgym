<?php $curr_user_id=get_current_user_id();

$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);

$obj_activity=new MJ_gmgt_activity;

$obj_membership=new MJ_gmgt_membership;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'activitylist';

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

//SAVE ACTIVITY DATA

if(isset($_POST['save_activity']))

{

	$nonce = $_POST['_wpnonce'];

	if (wp_verify_nonce( $nonce, 'save_activity_nonce' ) )

	{

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

		{

			$result=$obj_activity->MJ_gmgt_add_activity($_POST);

			if($result)

			{

				if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

				{

					wp_redirect ( home_url().'?dashboard=user&page=activity&tab=activitylist&page_action=web_view_hide&activity_list_app=activitylist_app&message=2');

				}

				else

				{

					wp_redirect ( home_url().'?dashboard=user&page=activity&tab=activitylist&message=2');

				}

			}

		}

		else

		{

			$result=$obj_activity->MJ_gmgt_add_activity($_POST);

			if($result)

			{

				if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app')

				{

					wp_redirect ( home_url().'?dashboard=user&page=activity&tab=activitylist&page_action=web_view_hide&activity_list_app=activitylist_app&message=1');

				}

				else

				{

					wp_redirect ( home_url().'?dashboard=user&page=activity&tab=activitylist&message=1');

				}

				//wp_redirect ( home_url().'?dashboard=user&page=activity&tab=activitylist&message=1');

			}

		}

	}

}

//DELETE ACTIVITY DATA

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

{

	$result=$obj_activity->MJ_gmgt_delete_activity($_REQUEST['activity_id']);

	if($result)

	{

		if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app')

		{

			wp_redirect ( home_url().'?dashboard=user&page=activity&tab=activitylist&page_action=web_view_hide&activity_list_app=activitylist_app&message=3');

		}

		else

		{

			wp_redirect ( home_url().'?dashboard=user&page=activity&tab=activitylist&message=3');

		}

	//	wp_redirect ( home_url().'?dashboard=user&page=activity&tab=activitylist&message=3');

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

			<p><?php esc_html_e('Activity added successfully.','gym_mgt');?></p>

		</div>

		<?php 		

	}

	elseif($message == 2)

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e("Activity updated successfully.",'gym_mgt');?></p>

		</div>

		<?php 		

	}

	elseif($message == 3) 

	{?>

		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

			</button>

			<p><?php esc_html_e('Activity deleted successfully.','gym_mgt');?></p>

		</div>

		<?php			

	}

}

?>



<script type="text/javascript">

	$(document).ready(function()

	{

		"use strict";

		$('#acitivity_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

		$('#membership_id').multiselect(

		{

			nonSelectedText :'<?php esc_html_e('Select Membership','gym_mgt');?>',

			includeSelectAllOption: true,

			allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

			selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

			templates: {

					button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

				},

			buttonContainer: '<div class="dropdown" />'

		});	

	});

</script>

<!-- POP up code -->

<div class="popup-bg">

    <div class="overlay-content">

		<div class="modal-content">

			<div class="category_list"></div>

        </div>

    </div> 

</div>

<!-- End POP-UP Code -->

<div class="panel-body panel-white padding_0"><!--PANEL WHITE DIV START-->

	<div class="tab-content padding_0"><!--TAB CONTENT DIV END-->

		<?php 

		if($active_tab == 'activitylist')

		{

			if($user_access['own_data']=='1')

			{

				if($obj_gym->role == 'member')

				{

					$member_activity_ids=MJ_gmgt_get_member_activity_by_membership_id();

					$activitydata=$obj_activity->MJgmet_all_activity_by_activity_ids($member_activity_ids);

				}

				else

				{

					$user_id=get_current_user_id();							

					$activitydata=$obj_activity->MJ_gmgt_get_all_activity_by_activity_added_by($user_id);

				}

			}

			else

			{

				$activitydata=$obj_activity->MJgmet_all_activity();

			}

			?>	

			<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->



				<?php

				if(!empty($activitydata))

				{

					?>

					<script type="text/javascript">

						$(document).ready(function() 

						{

							"use strict";

							jQuery('#activity_list').DataTable({

								// "responsive": true,

								"order": [[ 0, "asc" ]],

								dom: 'lifrtp',

								"aoColumns":[

											{"bSortable": false},

											{"bSortable": true},

											{"bSortable": true},

											{"bSortable": true},

											{"bSortable": false}],

									language:<?php echo MJ_gmgt_datatable_multi_language();?>			  

								});

								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

						} );

					</script>

					<div class="tab-pane <?php if($active_tab == 'activitylist') echo "fade active in";?>" >

						<form name="wcwm_report" action="" method="post"><!--ACTIVITY LIST FORM START-->

							<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

								<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

									<table id="activity_list" class="display" cellspacing="0" width="100%"><!--ACTIVITY LIST TABLE START-->

									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
										<tr>
											<th><?php esc_html_e('Photo','gym_mgt');?></th>
											<th><?php esc_html_e('Activity Name', 'gym_mgt' ) ;?></th>
											<th><?php esc_html_e('Activity Category', 'gym_mgt' ) ;?></th>
											<th><?php esc_html_e('Assign Staff Member', 'gym_mgt' ) ;?></th>
											<th class="text_align_end"><?php esc_html_e('Action', 'gym_mgt' ) ;?></th>
												
										</tr>
									</thead>

										<tbody>

											<?php 											

											if(!empty($activitydata))

											{

												$i=0;

												foreach ($activitydata as $retrieved_data)

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

														<td class="user_image width_50px profile_image_prescription padding_left_0">	

															<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

																<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Activity.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

															</p>

														</td>

														<td class="activityname">

															<?php 

															if($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')

															{

																if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app')

																{

																?>

																	<?php echo esc_html($retrieved_data->activity_title);?>

																<?php

																}

																else

																{

																?>

																	<a href="?dashboard=user&page=activity&tab=addactivity&action=edit&activity_id=<?php echo esc_attr($retrieved_data->activity_id);?>"><?php echo esc_html($retrieved_data->activity_title);?></a>

																<?php

																} 

															}

															else

															{

																?>

																	<?php echo esc_html($retrieved_data->activity_title);?>

																<?php  

															} 

															?>

															<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Name','gym_mgt');?>" ></i>

														</td>

														<td class="category">

															<?php echo get_the_title(esc_html($retrieved_data->activity_cat_id));?>

															<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Category','gym_mgt');?>" ></i>

														</td>

														<td class="productquentity">

															<?php 

															$user=get_userdata(esc_html($retrieved_data->activity_assigned_to)); 

															$display_name = MJ_gmgt_get_user_full_display_name(esc_html($user->ID));

															if(isset($display_name))
															{	
																echo esc_html($display_name);
															}
															else
															{
																echo "N/A";
															}

															?>

															<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Assign Staff Member','gym_mgt');?>" ></i>

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

																			if(!empty($video_data[0]->video_link))

																			{

																				if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app')

																				{

																					?>

																					<li class="float_left_width_100">

																						<a href="?dashboard=user&page=activity&tab=view_video&action=view&page_action=web_view_hide&activity_list_app=activitylist_app&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php esc_html_e('View Video', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php 

																				}

																				else

																				{

																					?>

																					<li class="float_left_width_100">

																						<a href="?dashboard=user&page=activity&tab=view_video&action=view&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php esc_html_e('View Video', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php

																				}

																			}

																			if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app')

																			{

																				?>

																				<li class="float_left_width_100">

																					<a href="?dashboard=user&page=activity&tab=view_membership&action=view&page_action=web_view_hide&activity_list_app=activitylist_app&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View Membership', 'gym_mgt' ) ;?></a>

																				</li>

																				<?php

																			}

																			else

																			{

																				?>	 

																				<li class="float_left_width_100">

																					<a href="?dashboard=user&page=activity&tab=view_membership&action=view&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View Membership', 'gym_mgt' ) ;?></a>

																				</li>

																				<?php

																			}

																			if($user_access['edit']=='1')

																			{

																				if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app')

																				{

																					?>

																					<li class="float_left_width_100 border_bottom_item">

																						<a href="?dashboard=user&page=activity&tab=addactivity&action=edit&page_action=web_view_hide&activity_list_app=activitylist_app&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php

																				}

																				else

																				{

																					?>

																					<li class="float_left_width_100 border_bottom_item">

																						<a href="?dashboard=user&page=activity&tab=addactivity&action=edit&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>

																					</li>

																					<?php

																				}

																			}

																			if($user_access['delete']=='1')

																			{

																				if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app')

																				{

																					?>	

																					<li class="float_left_width_100">

																						<a href="?dashboard=user&page=activity&tab=activitylist&action=delete&page_action=web_view_hide&activity_list_app=activitylist_app&activity_id=<?php echo esc_attr($retrieved_data->activity_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

																					</li>

																					<?php

																				}

																				else

																				{

																					?>	

																					<li class="float_left_width_100">

																						<a href="?dashboard=user&page=activity&tab=activitylist&action=delete&activity_id=<?php echo esc_attr($retrieved_data->activity_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

													</tr>

													<?php

													$i++;

												} 

											}?>

										</tbody>

									</table><!--ACTIVITY LIST TABLE END-->

								</div><!--TABLE RESPONSIVE DIV END-->

							</div><!--PANEL BODY DIV END-->

						</form><!--ACTIVITY LIST FORM END-->

					</div>

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
							if(isset($_REQUEST['activity_list_app']) && $_REQUEST['activity_list_app'] == 'activitylist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')
							{
								echo "?dashboard=user&page=activity&tab=addactivity&&action=insert&page_action=web_view_hide&activity_list_app=activitylist_app";
							}
							else
							{
								echo home_url().'?dashboard=user&page=activity&tab=addactivity&&action=insert';
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

				?>

			</div><!--MAIN_LIST_MARGING_15px END  -->

			<?php 

		}

		if($active_tab == 'addactivity')

		{

			$activity_id=0;

			if(isset($_REQUEST['activity_id']))

			$activity_id=$_REQUEST['activity_id'];

			$edit=0;

			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

			{

				$edit=1;

				$result = $obj_activity->MJ_gmgt_get_single_activity($activity_id);

				

			}?>

			<div class="tab-pane <?php if($active_tab == 'addactivity') echo "fade active in";?>" >

				<div class="panel-body padding_0"><!--PANEL BODY DIV START-->

					<form name="acitivity_form" action="" method="post" class="form-horizontal" id="acitivity_form"><!--ACTIVITY FORM START-->

						<?php 

						$action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

						<input type="hidden" name="activity_id" value="<?php echo esc_attr($activity_id);?>"  />

						<div class="header">	

							<h3 class="first_hed"><?php esc_html_e('Activity Information','gym_mgt');?></h3>

						</div>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

									<label class="ml-1 custom-top-label top" for="activity_category"><?php esc_html_e('Activity Category','gym_mgt');?><span class="require-field">*</span></label>	

									<select class="form-control activity_cat_to_staff validate[required] max_width_100" name="activity_cat_id" id="activity_select">

										<option value=""><?php esc_html_e('Select Activity Category','gym_mgt');?></option>

										<?php 

										if(isset($_REQUEST['activity_cat_id']))

										{

											$category =esc_attr($_REQUEST['activity_cat_id']);  

										}

										elseif($edit)

										{

											$category =$result->activity_cat_id;

										}

										else

										{ 

											$category = "";

										}

										$activity_category=MJ_gmgt_get_all_category('activity_category');

										if(!empty($activity_category))

										{

											foreach ($activity_category as $retrive_data)

											{

												echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';

											}

										}?>

									</select>

								</div>

								<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">

									<button id="addremove" class="btn add_btn" model="activity_category"><?php esc_html_e('Add','gym_mgt');?></button>

								</div>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

									<div class="form-group input">

										<div class="col-md-12 form-control">

											<input id="activity_title" class="form-control validate[required,custom[popup_category_validation]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->activity_title);}elseif(isset($_POST['activity_title'])) echo esc_attr($_POST['activity_title']);?>" name="activity_title">

											<label class="" for="activity_title"><?php esc_html_e('Activity Title','gym_mgt');?><span class="require-field">*</span>

											</label>

										</div>

									</div>

								</div>

								<!--nonce-->

									<?php wp_nonce_field( 'save_activity_nonce' ); ?>

								<!--nonce-->

								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

									<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Assign to Staff Member','gym_mgt');?><span class="require-field">*</span>

									</label>	

									<select name="staff_id" class="form-control validate[required] category_to_staff_list max_width_100" id="staff_id">

										<option value=""><?php  esc_html_e('Select Staff Member ','gym_mgt');?></option>

										<?php 

										if($edit)

										{

												

											$get_staff = array('role' => 'Staff_member');

											$staffdata=get_users($get_staff);

											$staff_data=$result->activity_assigned_to;

											if(!empty($staffdata))

											{

												foreach($staffdata as $staff)

												{

													$staff_specialization=explode(',',$staff->activity_category);

													if(in_array($result->activity_cat_id,$staff_specialization))

													{

														echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).'</option>';

													}

												}

											}

										}

										?>

									</select>

								</div>

								<div class="rtl_margin_top_15px col-sm-12 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">

									<?php $membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>

									<select name="membership_id[]" class="form-control  multiselect_validation" multiple="multiple" id="membership_id">

										<?php $getmembership_array=array();

										if($edit)

										{

											$getmembership_array=$obj_activity->MJ_gmgt_get_activity_membership($activity_id);

										}

										elseif(isset($_REQUEST['membership_id']))

										{

											$getmembership_array[]=esc_attr($_REQUEST['membership_id']);

										}

										if(!empty($membershipdata))

										{

											foreach ($membershipdata as $membership){?>

												<option value="<?php echo esc_attr($membership->membership_id);?>" <?php if(in_array($membership->membership_id,$getmembership_array)) echo "selected";?> ><?php echo esc_html($membership->membership_label);?></option>

										<?php }

										} ?>

									</select>

								</div>



								<div class="income_entry_div">

									<?php 					

									if($edit)

									{

										$all_entry=json_decode($result->video_entry);

									}

									else

									{

										if(isset($_POST['video_entry']))

										{		

											$all_data=$obj_activity->MJ_gmgt_get_entry_video($_POST);

											$all_entry=json_decode($all_data);

										}

									}

									if(!empty($all_entry))

									{

										$i=0;

										foreach($all_entry as $entry)

										{

											?>

											<div class="form-body user_form income_fld">

												<div class="row">

													<div class="col-md-6">

														<div class="form-group input">

															<div class="col-md-12 form-control">

																<input id="income_amount" class="form-control text-input" type="text"  value="<?php echo esc_attr($entry->video_title);?>" name="video_title[]" placeholder="<?php esc_html_e('Video title','gym_mgt');?>">

																<label class="" for="income_entry"><?php esc_html_e('Video title','gym_mgt');?></label>

															</div>

														</div>

													</div>

													<div class="col-md-5">

														<div class="form-group input">

															<div class="col-md-12 form-control">

																<input id="income_entry" class="form-control text-input onlyletter_space_validation1" type="text" maxlength="50" value="<?php echo esc_attr($entry->video_link);?>" name="video_link[]" placeholder="<?php esc_html_e('Ex: https://www.youtube.com/embed/X_9VoqR5ojM','gym_mgt');?>">

																<label class="" for="income_entry"><?php esc_html_e('Video Link','gym_mgt');?></label>

															</div>

														</div>

													</div>

													<?php

													if($i == 0 )

													{ 

														?>

														<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">

															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">

														</div>

														<?php

													}

													else

													{

														?>

														<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">

															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt="">

														</div>

														<?php

													}

													?>

													

													<!-- <div class="col-sm-2">

														<button type="button" class="btn btn-default" onclick="deleteParentElement(this)"><i class="entypo-trash"><?php esc_html_e('Delete33','gym_mgt');?></i>

														</button>

													</div> -->

												</div>	

											</div>

											<?php

											$i++;

										}						

									}

									else

									{	?>

										<div class="form-body user_form">

											<div class="row">

												<div class="col-md-6">

													<div class="form-group input">

														<div class="col-md-12 form-control">

															<input id="income_amount" class="form-control text-input" type="text"  value="" name="video_title[]" placeholder="<?php esc_html_e('Video title','gym_mgt');?>" >

															<label class="" for="income_entry"><?php esc_html_e('Video title','gym_mgt');?> </label>

														</div>

													</div>

												</div>

												<div class="col-md-5">

													<div class="form-group input">

														<div class="col-md-12 form-control">

															<input id="income_entry" class="form-control text-input"  type="text" value="" name="video_link[]" placeholder="<?php esc_html_e('Ex: https://www.youtube.com/embed/X_9VoqR5ojM','gym_mgt');?>">

															<label class="" for="income_entry"><?php esc_html_e('Video Link','gym_mgt');?> </label>

														</div>

													</div>

												</div>

												<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">

													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">

												</div>

											</div>

										</div>

										<?php 

									} ?>

								</div>			



							</div><!--Row Div End--> 

						</div><!-- user_form End--> 



						<!------------   save btn  -------------->  

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat--> 

								<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  

									<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_activity" class="btn save_btn"/>

								</div>

							</div><!--Row Div End--> 

						</div><!-- user_form End-->

					</form><!--ACTIVITY FORM END-->

				</div><!--PANEL BODY DIV END-->

			</div>

			<script>

				// CREATING BLANK INVOICE ENTRY

				var blank_income_entry ='';

				$(document).ready(function()

				{

					"use strict"; 

					blank_income_entry = $('.income_entry_div').html();			

				});

				//ADD INCOME ENTRY

				function add_entry()

				{   		

					jQuery(".income_entry_div").append('<div class="form-body user_form income_fld"><div class="row"><div class="col-md-6"><div class="form-group input"><div class="col-md-12 form-control"><input id="income_amount" class="form-control text-input" type="text"  value="" name="video_title[]" placeholder="<?php esc_html_e('Video title','gym_mgt');?>" ><label class="active" for="income_entry"><?php esc_html_e('Video title','gym_mgt');?> </label></div></div></div><div class="col-md-5"><div class="form-group input"><div class="col-md-12 form-control"><input id="income_entry" class="form-control text-input" placeholder="<?php esc_html_e('Ex: https://www.youtube.com/embed/X_9VoqR5ojM','gym_mgt');?>"  type="text" value="" name="video_link[]"><label class="active" for="income_entry"><?php esc_html_e('Video Link','gym_mgt');?></label></div></div></div><div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div>');

				}

				// REMOVING INVOICE ENTRY

				function deleteParentElement(n)

				{

					"use strict";

					var alert_msg=confirm("<?php esc_html_e('Do you really want to delete this record','gym_mgt');?>");

					if(alert_msg == false)

					{

						return false;

					}

					else

					{

						n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);

						return true;

					}

				}

			</script>

			<?php 

		}	

		if($active_tab == 'view_video')

		{

		require_once GMS_PLUGIN_DIR. '/template/view_video.php';

		}

		if($active_tab == 'view_membership')

		{

			?>

			<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

				<script type="text/javascript">

					$(document).ready(function() 

					{	

						"use strict";

						jQuery('#membership_list').DataTable({

							// "responsive": true,

							"order": [[ 1, "asc" ]],

							dom: 'lifrtp',

							"aoColumns":[

										{"bSortable": false},

										{"bSortable": true},

										{"bSortable": true},

										{"bSortable": true},

										{"bSortable": true},

										{"bSortable": true}],

									language:<?php echo MJ_gmgt_datatable_multi_language();?>		  

							});

							$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

					});

				</script>

				<div class="tab-pane <?php if($active_tab == 'view_membership') echo "fade active in";?>" >

					<form name="wcwm_report" action="" method="post"> <!--MEMBERSHIP LIST FORM START-->   

						<div class="panel-body padding_0"><!--PANEL BODY DIV START-->   

							<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->   

								<table id="membership_list" class="display" cellspacing="0" width="100%"><!--MEMBERSHIP LIST TABLE START-->   

									<thead>

										<tr id="height_50">

										<th id="width_50"><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Membership Name', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Membership Amount', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Membership Period', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Installment Plan', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Signup Fee', 'gym_mgt' ) ;?></th> 

										</tr>

									</thead>

									<tfoot>

										<tr>

										<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Membership Name', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Membership Amount', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Membership Period', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Installment Plan', 'gym_mgt' ) ;?></th>

										<th><?php esc_html_e( 'Signup Fee', 'gym_mgt' ) ;?></th>            

										</tr>

									</tfoot>

									<tbody>

									<?php 

									if(isset($_REQUEST['activity_id']))

									{

										$activity_id=esc_attr($_REQUEST['activity_id']);

										$activity_membership_list = $obj_activity->MJ_gmgt_get_activity_membership($activity_id);

									}	

									if(!empty($activity_membership_list))

									{

										foreach ($activity_membership_list as $retrieved_data)

										{

											$obj_membership=new MJ_gmgt_membership;

											$membership_data = $obj_membership->MJ_gmgt_get_single_membership($retrieved_data);

											?>

											<tr>

												<td class="user_image width_50px padding_left_0">

													<?php 

													$userimage=$membership_data->gmgt_membershipimage;

													if(empty($userimage))

													{

														echo '<img src='.get_option( 'gmgt_Membership_logo' ).' height="50px" width="50px" class="img-circle" />';

													}

													else

														echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';

													?>

												</td>



												<td class="membershipname">

													<?php

													if(isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')

													{

														?>

														<?php echo esc_html($membership_data->membership_label);?>

														<?php

													}

													else

													{

														?>

															<?php echo esc_html($membership_data->membership_label);?>

														<?php

													}

													?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>

												</td>

												<td class="">

													<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($membership_data->membership_amount); ?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Amount','gym_mgt');?>" ></i>

												</td>

												<td class="membershiperiod">

													<?php echo esc_html($membership_data->membership_length_id);?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Period (Days)','gym_mgt');?>" ></i>

												</td>

												<td class="installmentplan">

													<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($membership_data->installment_amount);?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Installment Plan','gym_mgt');?>" ></i>

												</td>

												<td class="signup_fee">

													<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($membership_data->signup_fee);?>

													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Signup Fee','gym_mgt');?>" ></i>

												</td>             

											</tr>

											<?php 

										}			

									}

									?>     

									</tbody>        

								</table><!--MEMBERSHIP LIST TABLE END-->   

							</div><!--TABLE RESPONSIVE DIV END-->   

						</div><!--PANEL BODY DIV END-->   

					</form><!--MEMBERSHIP LIST FORM END-->  

				</div>

			</div><!-- MAIN_LIST_MARGING_15px END --> 

			<?php

		}

		?>

  	</div><!--TAB CONTENT DIV END-->

</div><!--PANEL WHITE DIV END-->