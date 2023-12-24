<?php 

$obj_membership=new MJ_gmgt_membership;

$obj_activity=new MJ_gmgt_activity;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'activitylist';

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

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('activity');

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

			if ('activity' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('activity' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('activity' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

		   <div class="category_list"> </div>

        </div>

    </div> 

</div>

<!-- End POP-UP Code -->

<div class="page-inner min_height_1631"><!-- PAGE INNER DIV START-->

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

		<?php 

		//SAVE Activity DATA

		if(isset($_POST['save_activity']))

		{

			$nonce = $_POST['_wpnonce'];

			if (wp_verify_nonce($nonce, 'save_activity_nonce' ) )

			{

				if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

				{	
				
					$result=$obj_activity->MJ_gmgt_add_activity($_POST);

					// if($result)

					// {

						wp_redirect ( admin_url().'admin.php?page=gmgt_activity&tab=activitylist&message=2');

					// }

				}

				else

				{

					$result=$obj_activity->MJ_gmgt_add_activity($_POST);

					if($result)

					{
						$wizard = MJ_gmgt_setup_wizard_steps_updates('step4_activity');
						wp_redirect ( admin_url().'admin.php?page=gmgt_activity&tab=activitylist&message=1');

					}

				}

			}

		}

		//Delete ACTIVITY DATA

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

		{	

			$result=$obj_activity->MJ_gmgt_delete_activity($_REQUEST['activity_id']);

			if($result)

			{

				wp_redirect( admin_url().'admin.php?page=gmgt_activity&tab=activitylist&message=3');

			}

		}

		//selected activity delete//

		if(isset($_REQUEST['delete_selected']))

		{		

			if(!empty($_REQUEST['selected_id']))

			{

				foreach($_REQUEST['selected_id'] as $id)

				{

					$delete_activity=$obj_activity->MJ_gmgt_delete_activity($id);

				}

				if($delete_activity)

				{

					wp_redirect( admin_url().'admin.php?page=gmgt_activity&tab=activitylist&message=3');

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

					<p><?php esc_html_e('Activity added successfully.','gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

				<?php 			

			}

			elseif($message == 2)

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("Activity updated successfully.",'gym_mgt'); ?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

				</div>

				<?php

			}

			elseif($message == 3) 

			{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e('Activity deleted successfully.','gym_mgt');?></p>

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

					if($active_tab == 'activitylist')

					{ 

						$activitydata=$obj_activity->MJgmet_all_activity();

						if(!empty($activitydata))

						{

							?>	

							<script type="text/javascript">

								$(document).ready(function() 

								{

									"use strict";

									jQuery('#activity_list').DataTable({

										// "responsive": true,

										dom: 'lifrtp',

										buttons: [

											'colvis'

										], 

										"aoColumns":[

												{"bSortable": false},

												{"bSortable": false},

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

								

									$('.sub_chk').on('change',function()

									{

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

										else{

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

							<form name="wcwm_report" action="" method="post"><!-- ACTIVITY FORM START-->

								<div class="panel-body padding_0"><!-- PANEL BODY DIV START-->

									<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START-->

										<table id="activity_list" class="display" cellspacing="0" width="100%"><!-- TABLE ACTIVITY LIST START-->

											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

												<tr>

													<th class="padding_0"><input type="checkbox" class="select_all"></th>

													<th><?php esc_html_e('Photo','gym_mgt');?></th>

													<th><?php esc_html_e('Activity Name','gym_mgt') ;?></th>

													<th><?php esc_html_e('Activity Category','gym_mgt') ;?></th>

													<th><?php esc_html_e('Assign Staff Member','gym_mgt');?></th>

													<th class="text_align_end"><?php esc_html_e('Action','gym_mgt' );?></th>

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

														<td class="checkbox_width_10px">

															<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->activity_id); ?>">

														</td>

														

														<td class="user_image width_50px profile_image_prescription padding_left_0">	

															<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

																<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Activity.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

															</p>

														</td>



														<td class="activityname">

															<a href="?page=gmgt_activity&tab=view_membership&action=view&activity_id=<?php echo esc_attr($retrieved_data->activity_id);?>"><?php echo esc_html($retrieved_data->activity_title);?>

															</a> 

															<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Name','gym_mgt');?>" ></i>

														</td>

														<td class="category">

															<?php echo get_the_title($retrieved_data->activity_cat_id);?>

															<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Activity Category','gym_mgt');?>" ></i>

														</td>

														<td class="productquentity">

															<?php 

															if(!empty($retrieved_data->activity_assigned_to))

															{

																$user=get_userdata($retrieved_data->activity_assigned_to);
																if(!empty($user)){
																	echo esc_attr(MJ_gmgt_get_user_full_display_name($retrieved_data->activity_assigned_to));
																}else{
																	echo 'N/A';
																}
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

																				?>

																				<li class="float_left_width_100">

																					<a href="?page=gmgt_activity&tab=view_video&action=view&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php esc_html_e('View Video', 'gym_mgt' ) ;?></a>

																				</li>

																				<?php 

																			}

																				?>

																				<li class="float_left_width_100">

																					<a href="?page=gmgt_activity&tab=view_membership&action=view&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View Membership', 'gym_mgt' ) ;?>

																					</a>

																				</li>

																			<?php if($user_access_edit == '1')

																			{ ?>

																				<li class="float_left_width_100 border_bottom_item">

																					<a href="?page=gmgt_activity&tab=addactivity&action=edit&activity_id=<?php echo esc_attr($retrieved_data->activity_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?>

																					</a>

																				</li>

																			<?php 

																			}

																			if($user_access_delete =='1')

																			{ ?>

																				<li class="float_left_width_100">

																					<a href="?page=gmgt_activity&tab=activitylist&action=delete&activity_id=<?php echo esc_attr($retrieved_data->activity_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>

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

											}?>

											</tbody>

										</table><!-- TABLE ACTIVITY LIST END-->

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

							</form><!-- ACTIVITY FORM END-->

							<?php 

						}

						else

						{

							?>

							<div class="no_data_list_div"> 

								<a href="<?php echo admin_url().'admin.php?page=gmgt_activity&tab=addactivity';?>">

									<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >

								</a>

								<div class="col-md-12 dashboard_btn margin_top_20px">

									<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>

								</div> 

							</div>		

							<?php

						}

					}

					if($active_tab == 'addactivity')

					{

					require_once GMS_PLUGIN_DIR. '/admin/activity/add_activity.php';

					}

					if($active_tab == 'view_membership')

					{

					require_once GMS_PLUGIN_DIR. '/admin/activity/view_membership.php';

					}

					if($active_tab == 'view_video')

					{

					require_once GMS_PLUGIN_DIR. '/admin/activity/view_video.php';

					}

					?>

				</div><!--PANEL BODY DIV END-->

			</div><!--COL 12 DIV END-->

		</div><!--ROW DIV END-->

	</div><!-- MAIN_LIST_MARGING_15px END -->

</div><!--PAGE INNER DIV END-->