<?php 

$obj_class=new MJ_gmgt_classschedule;

$obj_activity=new MJ_gmgt_activity;

$obj_workouttype=new MJ_gmgt_workouttype;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'workouttypelist';

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

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('assign-workout');

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

			if ('assign-workout' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('assign-workout' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('assign-workout' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

<div class="popup-bg">

    <div class="overlay-content">

		<div class="modal-content">

			<div class="category_list"> </div>

		</div>

    </div> 

</div>



<!-- End POP-UP Code -->

<div class="page-inner min_height_1631">

	<?php 

	if(isset($_POST['save_workouttype']))

	{

		$nonce = $_POST['_wpnonce']; 

		if (wp_verify_nonce( $nonce, 'save_workouttype_nonce' ) )

		{	

			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

			{						

				$result=$obj_workouttype->MJ_gmgt_add_workouttype($_POST);

				if($result)

				{

					wp_redirect ( admin_url().'admin.php?page=gmgt_workouttype&tab=workouttypelist&message=2');

				}	

			}

			else

			{

				$result=$obj_workouttype->MJ_gmgt_add_workouttype($_POST);

				if($result)

				{

					wp_redirect ( admin_url().'admin.php?page=gmgt_workouttype&tab=workouttypelist&message=1');

				}

			}

		}

	}

	if(isset($_POST['save_workoutlog']))

	{

		$result=$obj_workouttype->MJ_gmgt_update_user_workouts_logs($_POST);

			if($result)

			{

				wp_redirect ( admin_url().'admin.php?page=gmgt_workouttype&tab=workouttypelist&message=2');				

			}

	}

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

	{

		$result=$obj_workouttype->MJ_gmgt_delete_workouttype($_REQUEST['workouttype_id']);

		if($result)

		{

			wp_redirect ( admin_url().'admin.php?page=gmgt_workouttype&tab=workouttypelist&message=3');

		}

	}

	if(isset($_REQUEST['message']))

	{

		$message =esc_attr($_REQUEST['message']);

		if($message == 1)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Workout added successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php	

		}

		elseif($message == 2)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e("Workout updated successfully.",'gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php	

		}

		elseif($message == 3) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Workout deleted successfully','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php

		}

	}

	?>

	<div id="" class="gms_main_list">

		<div class="row">

			<div class="col-md-12">

				<div class="float_left_width_100">

					<div class="">

						<?php						

						if($active_tab == 'workouttypelist')

						{ 

							$get_members = array('role' => 'member');

							$membersdata=get_users($get_members);

							if(!empty($membersdata))

							{

								?>	

								<script type="text/javascript">

									$(document).ready(function() 

									{

										"use strict";

										jQuery('#assignworkout_list').DataTable({

										// "responsive": true,

										"order": [[ 1, "asc" ]],

										dom: 'lifrtp',

										"aoColumns":[

													{"bSortable": false},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": false}],

												language:<?php echo MJ_gmgt_datatable_multi_language();?>		  

										});

										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

									} );

								</script>

								<form name="wcwm_report" action="" method="post"><!--WORKOUT TYPE LIST FORM START-->

									<div class="attendance_list"><!--PANEL BODY DIV START-->

										<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

											<table id="assignworkout_list" class="display" cellspacing="0" width="100%"><!--WORKOUT TYPE LIST TABLE START-->

												<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
													<tr>
														<th><?php esc_html_e('Photo','gym_mgt');?></th>
														<th><?php esc_html_e('Member Name','gym_mgt');?></th>
														<th><?php esc_html_e('Member Intrest Area','gym_mgt');?></th>
														<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>
													</tr>
												</thead>
												<tbody>

												<?php

												//GET ALL MEMBER DATA

												if(!empty($membersdata))

												{

													foreach ($membersdata as $retrieved_data)

													{

														if( $retrieved_data->member_type == "Member" && $retrieved_data->membership_status == "Continue")

														{

															?>

															<tr>

																<td class="user_image width_50px padding_left_0"><?php $uid=$retrieved_data->ID;

																	$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);

																	if(empty($userimage))

																	{

																		echo '<img src='.get_option( 'gmgt_assign_workout_thumb' ).' height="50px" width="50px" class="img-circle" />';

																	}

																	else

																	{

																		echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';

																	}

																?>

																</td>

																<td class="member">

																	<a href="?page=gmgt_workouttype&tab=addworkouttype&action=edit&workoutmember_id=<?php echo $retrieved_data->ID;?>">

																	<?php $user=get_userdata($retrieved_data->ID);

																	echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID)) ;?></a>

																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>

																</td>

																<td class="member-goal">

																	<?php 

																	$intrestid=get_user_meta($retrieved_data->ID,'intrest_area',true);

																	if(!empty($intrestid))

																	{

																		echo get_the_title($intrestid);

																	}

																	else

																	{

																		echo "N/A";

																	}

																	?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Intrest Area','gym_mgt');?>" ></i>

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

																						<a href="?page=gmgt_workouttype&tab=addworkouttype&action=view&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View Workouts', 'gym_mgt' ) ;?></a>

																					</li>	

																				</ul>

																			</li>

																		</ul>

																	</div>	

																</td>

															</tr>

															<?php 

														}

													} 

												}

												?>

												</tbody>

											</table><!--WORKOUT TYPE LIST TABLE END-->

										</div><!--TABLE RESPONSIVE DIV END-->

									</div><!--PANEL BODY DIV END-->

								</form><!--WORKOUT TYPE LIST FORM END-->

								<?php

							}

							else

							{
								if($user_access_add == 1)
								{
									?>

									<div class="no_data_list_div"> 

										<a href="<?php echo admin_url().'admin.php?page=gmgt_workouttype&tab=addworkouttype';?>">

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

						</div><!--PANEL BODY DIV END-->

						<?php 

					}

					if($active_tab == 'addworkouttype')

					{

						require_once GMS_PLUGIN_DIR. '/admin/workout-type/add_workout_type.php';

					}

					if($active_tab == 'editworkouttype')

					{

						require_once GMS_PLUGIN_DIR. '/admin/workout-type/edit_workout_type.php';

					}

					if($active_tab == 'view_video')

					{

						require_once GMS_PLUGIN_DIR. '/admin/workout-type/view_video.php';

					}

					?>

				</div><!--PANEL WHITE DIV END-->

			</div><!--COL 12 DIV END-->

		</div><!--ROW DIV END-->

	</div><!--MAIN WRAPPER DIV END-->

</div><!--PAGE INNER DIV END-->