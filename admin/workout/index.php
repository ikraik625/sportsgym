<?php 

$obj_workouttype=new MJ_gmgt_workouttype;

$obj_workout=new MJ_gmgt_workout;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'workoutlist';

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

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('workouts');

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

			if ('workouts' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('workouts' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('workouts' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

			<div class="invoice_data">

			 </div>

	    </div>

    </div> 

</div>

<style>

	@media only screen and (max-width: 768px)

	{

			.float_left_res {

			float: none !important;

		}

	}

</style>

<!-- End POP-UP Code -->

<div class="page-inner min_height_1631"><!--PAGE INNER DIV START-->	



	<?php 

	//SAVE WORKOUT DATA

	if(isset($_POST['save_workout']))

	{

		$nonce = $_POST['_wpnonce'];

		if (wp_verify_nonce( $nonce, 'save_workout_nonce' ) )

		{

			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

			{

				if(!empty($_POST['workouts_array']))

				{

					$result=$obj_workout->MJ_gmgt_add_workout($_POST);

				}

				else

				{

				?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("No Workout Available for Today.",'gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			    </div>

				<?php

				}

				if($result)

				{

					wp_redirect ( admin_url().'admin.php?page=gmgt_workout&tab=workoutlist&message=2');

				}

			}

			else

			{	

				$exists_record=MJ_gmgt_check_user_workouts($_POST['member_id'],$_POST['record_date']);

				if($exists_record==0)

				{

					if(!empty($_POST['workouts_array']))

					{

						$result=$obj_workout->MJ_gmgt_add_workout($_POST);

					}

					else

					{

					?>

					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

						<p><?php esc_html_e("No Workout Available for Today.",'gym_mgt');?></p>

						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

					</div>

					<?php

					}

					if(isset($result))

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_workout&tab=workoutlist&message=1');

					}

				}

				else

				{?>

				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

					<p><?php esc_html_e("Workout Log Is Already Available That Day.",'gym_mgt');?></p>

					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			    </div>

		  <?php }			

			}	

		}	

	}

	//DELETE WORKOUT DATA	

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

	{

		$result=$obj_workout->MJ_gmgt_delete_workout($_REQUEST['daily_workout_id']);

		if($result)

		{

			wp_redirect ( admin_url().'admin.php?page=gmgt_workout&tab=workoutlist&message=3');

		}

	}

    if(isset($_REQUEST['message']))

	{

		$message =esc_attr($_REQUEST['message']);

		if($message == 1)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Workout Log added successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

			<?php

		}

		elseif($message == 2)

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e("Workout Log updated successfully.",'gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php	

		}

		elseif($message == 3) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Workout Log deleted successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php		

		}

		elseif($message == 4) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Measurement added successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php	

		}

		elseif($message == 5) 

		{?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Measurement updated successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php	

		}

	}

	//SAVE MEASUREMENT DATA

	if(isset($_POST['save_measurement']))

	{

		$nonce = $_POST['_wpnonce'];

		if (wp_verify_nonce( $nonce, 'save_measurement_nonce' ) )

		{

			if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit')

			{

				$txturl=$_POST['gmgt_progress_image'];

				$ext=MJ_gmgt_check_valid_extension($txturl);

				if(!$ext == 0)

				{

					$result=$obj_workout->MJ_gmgt_add_measurement($_POST);

					if($result)

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_workout&tab=workoutlist&message=5');

					}

				}			

				else

				{ ?>

					<div id="message" class="updated below-h2 ">

						<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>

					</div>				 

					<?php 

				}	

			}

			else

			{

				$txturl=$_POST['gmgt_progress_image'];

				$ext=MJ_gmgt_check_valid_extension($txturl);

				if(!$ext == 0)

				{				

					$result=$obj_workout->MJ_gmgt_add_measurement($_POST);

					if($result)

					{

						wp_redirect ( admin_url().'admin.php?page=gmgt_workout&tab=workoutlist&message=4');

					}

				}			

				else

				{ 

				

				?>

					<div id="message" class="updated below-h2 ">

						<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>

					</div>				 

					<?php 

				}				

			}

		}

	}

	?>

	<div class="gms_main_list"><!--MAIN WRAPPER DIV START-->	

		<div class="row"><!--ROW DIV START-->	

			<div class="col-md-12"><!--COL 12 DIV START-->	

				<?php

				if(isset($_REQUEST['action'])&& $_REQUEST['action']=='view')

				{

					?>

				    <div class="float_left_res_important"><!--PANEL WHITE DIV START-->	

					<?php

				}

				else

				{

					?>

					<div class="float_left_res"><!--PANEL WHITE DIV START-->	

					<?php

				}

				?>

					<div class="panel-body padding_0"><!--PANEL BODY DIV START-->	

						

						<?php 						

						if($active_tab == 'workoutlist')

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

										jQuery('#workout_list').DataTable({

										// "responsive": true,

										"order": [[ 1, "asc" ]],

										dom: 'lifrtp',

										"aoColumns":[

													{"bSortable": false},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": true},

													{"bSortable": false}],

												language:<?php echo MJ_gmgt_datatable_multi_language();?>		  

										});

										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

									} );

								</script>

								<form name="wcwm_report" action="" method="post"><!--WORKOUT LIST FORM START-->	

									<div class="panel-body"><!--PANEL BODY DIV START-->	

										<div class="table-responsive"><!--TABLE RESPONSIVE DIV STRAT-->	

											<table id="workout_list" class="display" cellspacing="0" width="100%"><!--WORKOUT LIST TABLE START-->	
												<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">
													<tr>
														<th><?php esc_html_e('Photo','gym_mgt');?></th>
														<th><?php esc_html_e('Member Name','gym_mgt');?></th>
														<th><?php esc_html_e('Membership Name','gym_mgt');?></th>
														<th><?php esc_html_e('Joining Date','gym_mgt');?></th>
														<th><?php esc_html_e('Expiry Date','gym_mgt');?></th>
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

																		echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';

																?>

																</td>

																<td class="membername">

																	<a href="?page=gmgt_workout&tab=addworkout&action=view&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>">

																	<?php $user=get_userdata($retrieved_data->ID);

																	$display_label=MJ_gmgt_get_member_full_display_name_with_memberid($retrieved_data->ID);

																	echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID)); ?></a>

																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>

																</td>

																<td>

																	<?php 

																	if(isset($retrieved_data->membership_id))

																	{ 

																		if(MJ_gmgt_get_membership_name($retrieved_data->membership_id) !== ' ')

																		{

																			echo esc_html(MJ_gmgt_get_membership_name($retrieved_data->membership_id));

																		}

																		else

																		{

																			echo "N/A";

																		}

																	} 

																	else 

																	{ 

																		echo 'N/A'; 

																	}

																	?>

																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i>

																</td>

																<td class="joining date"><?php if($retrieved_data->member_type!='Prospect'){ echo esc_html(MJ_gmgt_getdate_in_input_box($retrieved_data->begin_date)); }else{ echo "N/A"; }?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Joining Date','gym_mgt');?>" ></i></td>

																<td class="joining date">

																	<?php if($retrieved_data->member_type!='Prospect'){ echo esc_html(MJ_gmgt_getdate_in_input_box(MJ_gmgt_check_membership($retrieved_data->ID))); }else{ echo "N/A"; }?>

																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Expiry Date','gym_mgt');?>" ></i>

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

																						<a href="?page=gmgt_workout&tab=addworkout&action=view&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>

																					</li>	

																					<li class="float_left_width_100">

																						<a href="#" class="view-measurement-popup float_left_width_100" page_action="web" data-val="<?php echo esc_attr($retrieved_data->ID);?>"><i class="fa fa-eye"></i><?php esc_html_e('View Measurement', 'gym_mgt' ) ;?></a>

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

											</table><!--WORKOUT LIST TABLE END-->	

										</div><!--TABLE RESPONSIVE DIV END-->	

									</div><!--PANEL BODY DIV END-->	

								</form><!--WORKOUT LIST FORM END-->	

								<?php 

							}

							else

							{
								if($user_access_add == 1)
								{
									?>

									<div class="no_data_list_div"> 

										<a href="<?php echo admin_url().'admin.php?page=gmgt_workout&tab=addworkout';?>">

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

						if($active_tab == 'addworkout')

						{

							require_once GMS_PLUGIN_DIR. '/admin/workout/add_workout.php';

						}

						if($active_tab == 'addmeasurement')

						{

							require_once GMS_PLUGIN_DIR. '/admin/workout/add_measurement.php';

						}

						?>

					</div><!--PANEL BODY DIV END-->	

              	</div><!--PANEL WHITE DIV END-->	

	        </div><!--COL 12 DIV END-->	

        </div><!--ROW DIV END-->	

    </div><!--MAIN WRAPPER DIV END-->	

</div><!--PAGE INNER DIV END-->	