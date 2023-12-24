<?php  $curr_user_id=get_current_user_id();



$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



$obj_workouttype=new MJ_gmgt_workouttype;



$obj_workout=new MJ_gmgt_workout;



$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'workoutlist';



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



?>



<script type="text/javascript">



$(document).ready(function() 



{



	"use strict";



	jQuery('#workout_list').DataTable(



	{



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



<!-- POP up code -->



<div class="popup-bg">



    <div class="overlay-content">



		<div class="modal-content">



			<div class="invoice_data"></div>



        </div>



    </div> 



</div>



<!-- End POP-UP Code -->



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



				<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



					<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



					</button>



					<?php esc_html_e('Today Can Not Assign Workout.','gym_mgt');?>



				</div>



				<?php



			}



			if($result)



			{



				if(isset($_REQUEST['workout_list_app_view']) && $_REQUEST['workout_list_app_view'] == 'workoutlist_app')



				{



					wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&page_action=web_view_hide&workout_list_app_view=workoutlist_app&message=2');



				}



				else



				{



					wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=2');



				}



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



					<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



						<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



						</button>



						<?php esc_html_e('Today Can Not Assign Workout.','gym_mgt');?>



					</div>



					<?php



				}



				if(isset($result))



				{



					if(isset($_REQUEST['workout_list_app_view']) && $_REQUEST['workout_list_app_view'] == 'workoutlist_app')



					{



						wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&page_action=web_view_hide&workout_list_app_view=workoutlist_app&message=1');



					}



					else



					{



						wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=1');



					}



					//wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=1');



				}



			}



			else



			{?>



				<div id="message" class="updated below-h2">



					<p><?php esc_html_e('Workout Log Is Already Available That Day.','gym_mgt');?></p>



				</div>



	  <?php }



		}



	}



}



//SAVE MEASUREMENT DATA



if(isset($_POST['save_measurement']))



{



	if(isset($_FILES['gmgt_progress_image']) && !empty($_FILES['gmgt_progress_image']) && $_FILES['gmgt_progress_image']['size'] !=0)



	{			



		if($_FILES['gmgt_progress_image']['size'] > 0)



			 $member_image=MJ_gmgt_load_documets($_FILES['gmgt_progress_image'],'gmgt_progress_image','pimg');



			$member_image_url=content_url().'/uploads/gym_assets/'.$member_image;					



	}



	else



	{		



		if(isset($_REQUEST['hidden_upload_user_progress_image']))



			$member_image=esc_url($_REQUEST['hidden_upload_user_progress_image']);



			$member_image_url=$member_image;



	}



	$ext=MJ_gmgt_check_valid_extension($member_image_url);



	if(!$ext == 0)



	{		



		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



		{		



			$result=$obj_workout->MJ_gmgt_add_measurement($_POST,$member_image_url);



			if($result)



			{



				if(isset($_REQUEST['workout_list_app_view']) && $_REQUEST['workout_list_app_view'] == 'workoutlist_app')



				{



					wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&page_action=web_view_hide&workout_list_app_view=workoutlist_app&message=2');



				}



				else



				{



					wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=5');



				}



				//wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&message=2');



			}



		}



		else



		{



			$result=$obj_workout->MJ_gmgt_add_measurement($_POST,$member_image_url);



			if($result)



			{



				if(isset($_REQUEST['workout_list_app_view']) && $_REQUEST['workout_list_app_view'] == 'workoutlist_app')



				{



					wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&page_action=web_view_hide&workout_list_app_view=workoutlist_app&message=4');



				}



				else



				{



					wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=4');



				}



				//wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&message=1');



			}				



		}	



	}			



	else



	{?>



		<div id="message" class="updated below-h2 ">



			<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>



		</div>



	<?php 



	}			



}



//DELETE WORKOUT DATA



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



{		



	$result=$obj_workout->MJ_gmgt_delete_workout($_REQUEST['daily_workout_id']);



	if($result)



	{



		if(isset($_REQUEST['workout_list_app_view']) && $_REQUEST['workout_list_app_view'] == 'workoutlist_app')



		{



			wp_redirect ( home_url().'?dashboard=user&page=workouts&tab=workoutlist&page_action=web_view_hide&workout_list_app_view=workoutlist_app&message=3');



		}



		else



		{



			wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=3');



		}



		//wp_redirect ( home_url() . '?dashboard=user&page=workouts&tab=workoutlist&message=3');



	}



}



if(isset($_REQUEST['message']))



{



	$message =esc_attr($_REQUEST['message']);



	if($message == 1)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Workout inserted successfully.','gym_mgt');?>



		</div>



		<?php 				



	}



	elseif($message == 2)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Workout updated successfully.','gym_mgt');?>



		</div>



		<?php 				



	}



	elseif($message == 3) 



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Workout deleted successfully.','gym_mgt');?>



		</div>



		<?php



	}



	if($message == 4)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Measurement inserted successfully.','gym_mgt');?>



		</div>



		<?php 				



	}



	if($message == 5)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Measurement updated successfully.','gym_mgt');?>



		</div>



		<?php 				



	}



}



?>



<div class="panel-body padding_0 gms_main_list panel-white float_left_width_100_res"><!-- PANEL BODY DIV START-->



	<div class="tab-content padding_0"><!-- TAB CONTENT DIV START-->



		<?php 



		if($active_tab == 'workoutlist')



		{



			?>



			<div class="tab-pane <?php if($active_tab == 'workoutlist') echo "fade active in";?>" id="workoutlist"><!-- TAB PANE DIV START-->



				<div class="panel-body padding_0"><!-- PANEL BODY DIV START-->



					<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START-->



						<table id="workout_list" class="display" cellspacing="0" width="100%"><!-- TABLE WORKOUT LIST START-->

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



								if($obj_gym->role == 'member')



								{



									$user_id = get_current_user_id();



									?>



									<tr>



										<td class="user_image width_50px padding_left_0"><?php 



										$userimage=get_user_meta($user_id, 'gmgt_user_avatar', true);



											if(empty($userimage))



											{



												echo '<img src='.get_option( 'gmgt_assign_workout_thumb' ).' id="width_50" class="height_50 img-circle"  />';



											}



											else



											{



												echo '<img src='.$userimage.' id="width_50" class="height_50 img-circle" />';



											}



										?></td>



										<td class="membername">



											<?php $user=get_userdata($user_id);



											$display_label=$user->display_name;



											$memberid=get_user_meta($user_id,'member_id',true);



											$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($user_id));



											if($display_label)

											{

												echo esc_html($display_label);



											}



											?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



										</td>



										<td><?php echo MJ_gmgt_get_membership_name(esc_html($user->membership_id));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i></td>



										<td class="joining date"><?php if($user->member_type!='Prospect'){ echo MJ_gmgt_getdate_in_input_box(esc_html($user->begin_date)); }else{ echo "N/A"; }?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Joining Date','gym_mgt');?>" ></i></td>



										<td class="joining date"><?php if($user->member_type!='Prospect'){ echo MJ_gmgt_getdate_in_input_box(MJ_gmgt_check_membership(esc_html($user->ID))); }else{ echo "N/A"; }?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Expiry Date','gym_mgt');?>" ></i></td>



										<td class="action"> 



											<div class="gmgt-user-dropdown">



												<ul class="" style="margin-bottom: 0px !important;">



													<li class="">



														<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



															<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



														</a>



														<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



														<?php



														if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $user_id==$curr_user_id))



														{



															?>



															<li class="float_left_width_100">



																<a href="?dashboard=user&page=workouts&tab=addworkout&action=view&workoutmember_id=<?php echo esc_attr($user_id);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>



															</li>	



															<li class="float_left_width_100">



																<a href="#" class="view-measurement-popup float_left_width_100" data-val="<?php echo esc_attr($user_id);?>"><i class="fa fa-eye"></i><?php esc_html_e('View Measurement', 'gym_mgt' ) ;?></a>



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



								}



								else



								{						



									$get_members = array('role' => 'member');



									$membersdata=get_users($get_members);



									if(!empty($membersdata))



									{



										foreach ($membersdata as $retrieved_data)



										{



											?>							



											<tr>



												<td class="user_image width_50px padding_left_0">



													<?php 



													$userimage=get_user_meta($retrieved_data->ID, 'gmgt_user_avatar', true);



													if(empty($userimage))



													{



														echo '<img src='.get_option( 'gmgt_assign_workout_thumb' ).' id="width_50" class="height_50 img-circle"  />';



													}



													else



													{



														echo '<img src='.$userimage.' id="width_50" class="height_50 img-circle" />';



													}



													?>



												</td>



												<td class="membername">



													<?php 



													$user=get_userdata($retrieved_data->ID);



													$display_label=$user->display_name;



													$memberid=get_user_meta($retrieved_data->ID,'member_id',true);



													$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID));



														if($display_label)

														{

															echo esc_html($display_label);



														}



													?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



												</td>



												<td><?php echo MJ_gmgt_get_membership_name(esc_html($user->membership_id));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Name','gym_mgt');?>" ></i></td>



												<td class="joining date"><?php if($user->member_type!='Prospect'){ echo MJ_gmgt_getdate_in_input_box(esc_html($user->begin_date)); }else{ echo "N/A"; }?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Joining Date','gym_mgt');?>" ></i></td>



												<td class="joining date"><?php if($user->member_type!='Prospect'){ echo MJ_gmgt_getdate_in_input_box(MJ_gmgt_check_membership(esc_html($user->ID))); }else{ echo "N/A"; }?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Expiry Date','gym_mgt');?>" ></i></td>



												<td class="action"> 



													<div class="gmgt-user-dropdown">



														<ul class="" style="margin-bottom: 0px !important;">



															<li class="">



																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																</a>



																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																<?php



																if($obj_gym->role == 'staff_member' || ($obj_gym->role == 'member' && $retrieved_data->ID==$curr_user_id))



																{



																	if(isset($_REQUEST['workout_list_app_view']) == 'workoutlist_app')



																	{



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=workouts&tab=addworkout&action=view&page_action=web_view_hide&workout_list_app_view=workoutlist_app&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>



																		</li>	



																		<li class="float_left_width_100">



																			<a href="#" class="view-measurement-popup float_left_width_100" page_action="web_view_hide" data-val="<?php echo esc_attr($retrieved_data->ID);?>"><i class="fa fa-eye"></i><?php esc_html_e('View Measurement', 'gym_mgt' ) ;?></a>



																		</li>	



																		<?php



																	}



																	else



																	{



																		?>



																		<li class="float_left_width_100">



																			<a href="?dashboard=user&page=workouts&tab=addworkout&action=view&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>



																		</li>	



																		<li class="float_left_width_100">



																			<a href="#" class="view-measurement-popup float_left_width_100" page_action="web" data-val="<?php echo esc_attr($retrieved_data->ID);?>"><i class="fa fa-eye"></i><?php esc_html_e('View Measurement', 'gym_mgt' ) ;?></a>



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



										} 							



									}



								}



								?>



							</tbody>



						</table><!-- TABLE WORKOUT LIST END-->



					</div><!-- TABLE RESPONSIVE DIV END-->



				</div><!-- PANEL BODY DIV END-->



			</div><!-- TAB PANE DIV END-->



			<?php 



		}



		if($active_tab == 'addworkout')



		{



			?>



			<script type="text/javascript">



				$(document).ready(function() 



				{



					"use strict";



					$('#workout_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



					$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



					var date = new Date();



					date.setDate(date.getDate()-0);



					$('#curr_date').datepicker({



					<?php



						if(get_option('gym_enable_datepicker_privious_date')=='no')



						{



						?>



							minDate:'today',



							startDate: date,



						<?php



						}



						?>	



					dateFormat:'<?php echo get_option('gmgt_datepicker_format');?>',	



					autoclose: true



					});



					$('#record_date').datepicker({



					dateFormat:'<?php echo get_option('gmgt_datepicker_format');?>',	



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



					$(".display-members").select2();



					$("body").on("click","#save_workout",function(){



						var checked = $(".dropdown-menu input:checked").length;







						var e = document.getElementById("member_list");



						var optionSelIndex = e.options[e.selectedIndex].value;



						var optionSelectedText = e.options[e.selectedIndex].text;



						if (optionSelIndex == 0) {



							alert("<?php esc_html_e('Please select atleast one member','gym_mgt');?>");



							return false;



						}



					}); 



				});



			</script>



			<?php	



			$daily_workout_id=0;



			if(isset($_REQUEST['daily_workout_id']))



				$daily_workout_id=$_REQUEST['daily_workout_id'];



				$edit=0;



				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



				{



					$edit=1;



					$result = $obj_workout->MJ_gmgt_get_single_workout($daily_workout_id);	



				}



				?>



			<div class="tab-pane <?php if($active_tab == 'addworkout') echo "fade active in";?>"><!-- TAB PANE DIV START -->



			<?php 



			$workoutmember_id=0;



			if(isset($_REQUEST['workoutmember_id']))



			$workoutmember_id=$_REQUEST['workoutmember_id'];



			$view=0;



			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')



			{



				$view=1;



				?>



				<div class="panel-body padding_0"> <!-- PANEL BODY DIV START-->



					<form id="workout_log_form" method="post" class="form-horizontal">  



						<div class="col-md-12">



							<h2><?php echo MJ_gmgt_get_display_name($_REQUEST['workoutmember_id']).'\'s '; ?> <?php esc_html_e('Workout','gym_mgt')?></h2>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat-->



								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="curr_date" class="form-control"  type="text" value="<?php if(isset($_POST['tcurr_date'])) echo esc_attr($_POST['tcurr_date']);	else echo esc_attr(MJ_gmgt_getdate_in_input_box(date("Y-m-d")));?>" name="tcurr_date" readonly>



											<label class="" for="Description"><?php esc_html_e('Date','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-md-3 col-lg-3 col-sm-3 col-xl-3">



									<input type="submit" value="<?php esc_html_e('View Workouts','gym_mgt');?>" name="view_workouts"  class="btn save_btn"/>



								</div>



							</div>



						</div>



					</form>



				</div> <!-- PANEL BODY DIV END-->



				<div class="clearfix"> </div>



				<?php 



				if(isset($_REQUEST['view_workouts']) || isset($_REQUEST['view_workouts']))



				{								

					$tcurrent_date=MJ_gmgt_get_format_for_db($_POST['tcurr_date']);

					$today_workouts=$obj_workout->MJ_gmgt_get_member_today_workouts($workoutmember_id,$tcurrent_date);
				}
				else{
					$tcurrent_date=date("Y-m-d");

					$today_workouts=$obj_workout->MJ_gmgt_get_member_today_workouts($workoutmember_id,$tcurrent_date);
				}
				
					if(!empty($today_workouts))



					{



						?>



						<div class="col-md-12 my-workouts-display ">



							<?php 



							foreach($today_workouts as $value)



							{



								$workoutid=$value->user_workout_id;



								$activity_name=$value->workout_name;



								$workflow_category=$obj_workout->MJ_gmgt_get_user_workouts($workoutid,$activity_name);



								if($workflow_category->sets!='0')



								{



									if($value->sets > $workflow_category->sets)



									{



										$sets_progress=100;



									}



									else



									{



										$sets_progress=$value->sets*100/$workflow_category->sets;



									}



								}



								else



								{



									$sets_progress=100;



								}



								if($workflow_category->reps!='0')



								{	



									if($value->reps > $workflow_category->reps)



									{



										$reps_progress=100;



									}



									else



									{						



										$reps_progress=$value->reps*100/$workflow_category->reps;



									}



								}



								else



								{



									$reps_progress=100;



								}



								if($workflow_category->kg!='0')



								{



									if($value->kg > $workflow_category->kg)



									{



										$kg_progress=100;



									}



									else



									{	



										$kg_progress=$value->kg*100/$workflow_category->kg;



									}



								}



								else



								{



									$kg_progress=100;



								}



								if($workflow_category->time!='0')



								{



									if($value->rest_time > $workflow_category->time)



									{



										$rest_time_progress=100;



									}



									else



									{	



										$rest_time_progress=$value->rest_time*100/$workflow_category->time;



									}



								}



								else



								{



									$rest_time_progress=100;



								}



								?>



								<div class='col-md-12 activity-data no-padding'>



									<div class="header">	



										<h3 class="first_hed"><?php echo esc_html($value->workout_name);?></h3>



									</div>



									<div class="col-md-12 workout_datalist no-padding dis_flex view_workout_background_color staff_app_workout_detail"> 



										<div class="col-md-3 sets-row div_padding_30 staff_app_workout_padding_margin">	



											<div class="workout_box row">



												<div class="gmgt-card-member-bg center col-md-3 staff_app_workout_margin margin_top_20px padding_0" id="card-sets-bg">



													<h2 class="activity_box_number"><?php echo 1 ;?></h2>



												</div>



												<div class="col-md-8 margin_top_10px padding_right_0 staff_app_workout_width">



													<div class="gmgt-card-number">



														<h3><?php esc_html_e('Sets','gym_mgt');?></h3>



													</div>



													<div class="activity_progress_line"><div style="height:3px;background-color:#44CB7F;width:<?php echo esc_html($sets_progress); ?>%;"></div></div>



													<div class="gmgt-card-title">



														<span><?php echo esc_html($value->sets);?> <?php esc_html_e('Out Of','gym_mgt');?> <?php echo esc_html($workflow_category->sets);?> <?php esc_html_e('Sets','gym_mgt');?></span>



													</div>



												</div>



												



											</div>										



										</div>



										<div class="col-md-3 sets-row div_padding_30 staff_app_workout_padding_margin">	



											<div class="workout_box row">



												<div class="gmgt-card-member-bg center col-md-3 staff_app_workout_margin margin_top_20px padding_0" id="card-reps-bg">



													<h2 class="activity_box_number_reps activity_box_number"><?php echo 2 ;?></h2>



												</div>



												<div class="col-md-8 margin_top_10px padding_right_0 staff_app_workout_width">



													<div class="gmgt-card-number">



														<h3><?php esc_html_e('Reps','gym_mgt');?></h3>



													</div>



													<div class="activity_progress_line"><div style="height:3px;background-color:#44CB7F;width:<?php echo esc_html($reps_progress); ?>%;"></div></div>



													<div class="gmgt-card-title">



														<span><?php echo esc_html($value->reps);?> <?php esc_html_e('Out Of','gym_mgt');?> <?php echo esc_html($workflow_category->reps);?> <?php esc_html_e('Reps','gym_mgt');?></span>



													</div>



												</div>



											</div>										



										</div>



										<div class="col-md-3 sets-row div_padding_30 staff_app_workout_padding_margin">	



											<div class="workout_box row">



												<div class="gmgt-card-member-bg center col-md-3 staff_app_workout_margin margin_top_20px padding_0" id="card-kg-bg">



													<h2 class="activity_box_number_kg activity_box_number"><?php echo 3 ;?></h2>



												</div>



												<div class="col-md-8 margin_top_10px padding_right_0 staff_app_workout_width">



													<div class="gmgt-card-number">



														<h3><?php esc_html_e('Kg','gym_mgt');?></h3>



													</div>



													<div class="activity_progress_line"><div style="height:3px;background-color:#44CB7F;width:<?php echo esc_html($kg_progress); ?>%;"></div></div>



													<div class="gmgt-card-title">



														<span><?php echo esc_html($value->kg);?> <?php esc_html_e('Out Of','gym_mgt');?> <?php echo esc_html($workflow_category->kg);?> <?php esc_html_e('Kg','gym_mgt');?></span>



													</div>



												</div>



											</div>										



										</div>



										<div class="col-md-3 sets-row div_padding_30 staff_app_workout_padding_margin">	



											<div class="workout_box row">



												<div class="gmgt-card-member-bg center staff_app_workout_margin col-md-3 margin_top_20px padding_0" id="card-time-bg">



													<h2 class="activity_box_number_time activity_box_number"><?php echo 4 ;?></h2>



												</div>



												<div class="col-md-8 margin_top_10px padding_right_0 staff_app_workout_width">



													<div class="gmgt-card-number">



														<h3><?php esc_html_e('Rest Time','gym_mgt');?></h3>



													</div>



													<div class="activity_progress_line"><div style="height:3px;background-color:#44CB7F;width:<?php echo esc_html($rest_time_progress); ?>%;"></div></div>



													<div class="gmgt-card-title">



														<span><?php echo esc_html($value->rest_time);?> <?php esc_html_e('Out Of','gym_mgt');?> <?php echo esc_html($workflow_category->time);?> <?php esc_html_e('Time','gym_mgt');?></span>



													</div>



												</div>



											</div>										



										</div>



									</div>								



								</div>



								<div class="border_line"></div>		



								<?php



							}



							?>							



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



			else



			{



				?>



				<div class="panel-body padding_0"> <!-- PANEL BODY DIV START-->



					<form name="workout_form" action="" method="post" class="form-horizontal" id="workout_form"> <!-- WORKOUT FORM  START-->



						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



						<input type="hidden" name="daily_workout_id" value="" />



						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Workout Log Information','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat-->



								<?php 



								if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant')



								{



									?>



									<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



										<!-- <label class="ml-1 custom-top-label top" for="refered"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



										<?php if($view){ $member_id=$result->member_id; }elseif(isset($_POST['member_id'])){$member_id=sanitize_text_field($_POST['member_id']);}else{$member_id='';}?>



										<select id="member_list" class="form-control display-members"  name="member_id" >



											<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



											<?php $get_members = array('role' => 'member');



											$membersdata=get_users($get_members);



											if(!empty($membersdata))



											{



												foreach ($membersdata as $member){ 



												if( $member->membership_status == "Continue")



														{?>



													<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



												<?php }



												}



											}?>



										</select>



									</div>



									<?php 



								}



								else



								{



									?>



									<input type="hidden" id="member_list" name="member_id" value="<?php echo esc_attr($curr_user_id);?>">



									<?php 



								}



								?>



								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="record_date" class="form-control  validate[required]" type="text" userid="<?php echo get_current_user_id();?>"  name="record_date" value="<?php if($view){ echo esc_attr($result->record_date);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>



											<label class="" for="Description"><?php esc_html_e('Record Date','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<?php wp_nonce_field( 'save_workout_nonce' ); ?>



								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="note" class="form-control validate[custom[address_description_validation]]" maxlength="150" type="text" name="note" value="<?php if($view){echo esc_textarea($result->note); }elseif(isset($_POST['note'])) echo esc_textarea($_POST['note']); ?>">



											<label class="" for="Note"><?php esc_html_e('Note','gym_mgt');?></label>



										</div>



									</div>



								</div>



						



								<div class="header workout_detail_title_span">	



									<h3 class="first_hed_activity first_hed"><?php esc_html_e('Workout','gym_mgt'); ?><span class="require-field">*</span></h3>



								</div>



								<div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 input_margin_top_15px workout_area padding_0 res_margin_left_15px workout_width_93">

								<?php
								 $user_id=$curr_user_id;

								 global $wpdb;
							
								 $table_name = $wpdb->prefix."gmgt_assign_workout";
							 
								 $table_gmgt_workout_data = $wpdb->prefix."gmgt_workout_data";
							 
								 $record_date = date('Y-m-d');
							 
								 $day_name = date('l', strtotime($record_date));
							 
								 $sql = "Select *From $table_name as workout,$table_gmgt_workout_data as workoutdata where  workout.user_id = $user_id 
							 
								 AND  workout.workout_id = workoutdata.workout_id 
							 
								 AND workoutdata.day_name = '$day_name'
							 
								 AND '".$record_date."' between workout.Start_date and workout.End_date ";
							 
								 $result = $wpdb->get_results($sql);	
								 if(!empty($result))
								{
									foreach ($result as $retrieved_data)
									{
										$workout_id=$retrieved_data->workout_id;
										?>
										<div class='work_out_datalist form-group'>
											<div class='col-sm-12 col-md-12 col-xs-12 form-control title_background_color div_padding_bottom_0px'>
												<div class='header workout_detail_title_span'>	
													<h3 class='first_hed_activity first_hed'><?php echo esc_html($retrieved_data->workout_name);?></h3>
												</div>
												<div class='row activity_background_white'>
													<div class='col-md-3 d-flex align-items-center padding_10px'>
														<span class='col-md-12 col-sm-12 col-xs-12 no-padding'><?php echo esc_html("Assign Workout");?></span>
													</div>
													<input type='hidden' name='asigned_by' value='<?php echo $retrieved_data->create_by;?>'>
													<input type='hidden' name='workouts_array[]' value='<?php echo $retrieved_data->id;?>'>
													<input type='hidden' name='workout_name_<?php echo $retrieved_data->id;?>' value='<?php echo $retrieved_data->workout_name;?>'>
													<div class='col-md-9'>
														<div class='form-body user_form'>
															<div class='row'>
																<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>
																	<div class='form-group input'>
																		<div class='col-md-12 form-control'>
																			<input class='form-control validate[required]' type='text' placeholder='<?php echo $retrieved_data->sets." ".esc_html__('Sets','gym_mgt');?>' readonly disabled>
																			<label class='active'><?php echo esc_html__('Sets','gym_mgt');?></label>
																		</div>
																	</div>
																</div>
																<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>
																	<div class='form-group input'>
																		<div class='col-md-12 form-control'>
																			<input class='form-control validate[required]' type='text' placeholder='<?php echo $retrieved_data->reps." ".esc_html__('Reps','gym_mgt');?>' readonly disabled>
																			<label class='active'><?php echo esc_html__('Reps','gym_mgt');?></label>
																		</div>
																	</div>
																</div>
																<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>
																	<div class='form-group input'>
																		<div class='col-md-12 form-control'>
																			<input class='form-control validate[required]' type='text' placeholder='<?php echo $retrieved_data->kg." ".esc_html__('Kg','gym_mgt');?>' readonly disabled>
																			<label class='active'><?php echo esc_html__('Kg','gym_mgt');?></label>
																		</div>
																	</div>
																</div>
																<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>
																	<div class='form-group input'>
																		<div class='col-md-12 form-control'>
																			<input class='form-control validate[required]' type='text' placeholder='<?php echo $retrieved_data->time." ".esc_html__('Min','gym_mgt');?>' readonly disabled>
																			<label class='active'><?php echo esc_html__('Rest Time','gym_mgt');?></label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class='row activity_background_white'>
													<div class='col-md-3 d-flex align-items-center padding_10px'>
														<span class='col-md-12 col-sm-12 col-xs-12 no-padding'><?php echo esc_html("Your Workout");?></span>
													</div>
													<div class='col-md-9'>
														<div class='form-body user_form'>
															<div class='row'>
																<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>
																	<div class='form-group input'>
																		<div class='col-md-12 form-control'>
																			<input class='form-control my-workouts validate[required,max[<?php echo $retrieved_data->sets;?>]]' value="<?php echo $retrieved_data->sets;?>" id='sets' name='sets_<?php echo $retrieved_data->id;?>' type='number' min='0' onKeyPress='<?php if('this.value.length'==3) return false;?>' >
																			<label class='active'><?php echo esc_html__('Sets','gym_mgt');?></label>
																		</div>
																	</div>
																</div>
																<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>
																	<div class='form-group input'>
																		<div class='col-md-12 form-control'>
																			<input class='form-control my-workouts validate[required,max[<?php echo $retrieved_data->reps;?>]]' value="<?php echo $retrieved_data->reps;?>" id='reps' name='reps_<?php echo $retrieved_data->id;?>' type='number' min='0' onKeyPress='<?php if('this.value.length'==3) return false;?>'>
																			<label class='active'><?php echo esc_html__('Reps','gym_mgt');?></label>
																		</div>
																	</div>
																</div>
																<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>
																	<div class='form-group input'>
																		<div class='col-md-12 form-control'>
																			<input class='form-control my-workouts validate[required,max[<?php echo $retrieved_data->kg;?>]]' step='0.01' value="<?php echo $retrieved_data->kg;?>" id='kg' name='kg_<?php echo $retrieved_data->id;?>' type='number' min='0' onKeyPress='<?php if('this.value.length'==6) return false;?>'>
																			<label class='active'><?php echo esc_html__('Kg','gym_mgt');?></label>
																		</div>
																	</div>
																</div>
																<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>
																	<div class='form-group input'>
																		<div class='col-md-12 form-control'>
																			<input class='form-control my-workouts validate[required,max[<?php echo $retrieved_data->time;?>]]' id='rest' value="<?php echo $retrieved_data->time;?>" name='rest_<?php echo $retrieved_data->id;?>' type='number' min='0' onKeyPress='<?php if('this.value.length'==3) return false;?>'>
																			<label class='active'><?php echo esc_html__('Rest Time','gym_mgt');?></label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<input type='hidden' value='<?php echo $workout_id;?>' name='user_workout_id'>
										<?php
									}
								}
								?>

									<div class="form-group input">



										<div class='work_out_datalist'>



											<div class='col-sm-10'><span class='col-md-10'><?php esc_html_e('Select Record Date For Today Workout','gym_mgt');?></span></div>



										</div>



									</div>



								</div>



							</div>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">



									<input type="submit" value="<?php if($view){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_workout" class="btn <?php if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant'){ echo 'save_member_validate'; } ?> save_btn	"/>



								</div>



							</div>



						</div>



					</form> <!-- WORKOUT FORM  END-->



				</div><!--PANEL BODY DIV END-->	



				<?php 



			}



		}



		if($active_tab == 'addmeasurement')



		{



			$edit = 0;



			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



			{	



				$edit=1;



				$result = $obj_workout->MJ_gmgt_get_single_measurement($_REQUEST['measurment_id']);



			}



			?>



			<script type="text/javascript">



				$(document).ready(function() 



				{



					"use strict";



					$('#workout_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



					$(".display-members").select2();



					var date = new Date();



					$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



					date.setDate(date.getDate()-0);



					$('#result_date').datepicker({



					<?php



					if(get_option('gym_enable_datepicker_privious_date')=='no')



					{



					?>



						minDate:'today',



						startDate: date,



					<?php



					}



					?>	

					maxDate:'today',

					dateFormat:'<?php echo get_option('gmgt_datepicker_format');?>',	



					autoclose: true



				});



									



				} );



			</script>



			<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->



				<form name="workout_form" action="" method="post" class="form-horizontal" id="workout_form" enctype="multipart/form-data"><!-- WORKOUT FORM START-->



				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



					<input type="hidden" name="measurment_id" value="<?php if(isset($_REQUEST['measurment_id'])) echo esc_attr($_REQUEST['measurment_id']);?>">



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Measurement Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat-->



							<?php 



							if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant')



							{



								?>



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<!-- <label class="ml-1 custom-top-label top" for="refered"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



									<?php if($edit){ $member_id=$result->user_id; }elseif(isset($_REQUEST['user_id'])){$member_id=esc_attr($_REQUEST['user_id']);}else{$member_id='';}?>



									<select id="member_list" class="form-control display-members" required="true" name="user_id">							<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



										<?php $get_members = array('role' => 'member');



										$membersdata=get_users($get_members);



										if(!empty($membersdata))



										{



											foreach ($membersdata as $member){



												if( $member->membership_status == "Continue")



													{



												?>



												<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html($member->display_name)." - ".esc_html($member->member_id); ?> </option>



											<?php }



											}



										}?>



									</select>



								</div>



								<?php 



							}



							else



							{



								?>



								<input type="hidden" id="member_list" name="user_id" value="<?php echo esc_attr($curr_user_id);?>">



								<?php 



							} ?>



							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<label class="ml-1 custom-top-label top" for="refered"><?php esc_html_e('Result Measurement','gym_mgt');?><span class="require-field">*</span></label>



								<?php



								if($edit)



								{



									$measument=$result->result_measurment;



								}



								elseif(isset($_REQUEST['result_measurment']))



								{



									$measument = esc_attr($_REQUEST['result_measurment']);



								}



								else



								{



									$measument="";



								}?>



								<select name="result_measurment" class="form-control validate[required] " id="result_measurment">



									<option value=""><?php  esc_html_e('Select Result Measurement ','gym_mgt');?></option>



									<?php 	



									foreach(MJ_gmgt_measurement_array() as $key=>$element)



									{



									if($element == 'Height')



										{



											$unit= get_option( 'gmgt_height_unit' );



										}



									elseif($element == 'Weight')



									{



										$unit= get_option( 'gmgt_weight_unit' );



									}



									elseif($element == 'Chest')



									{



										$unit= get_option( 'gmgt_chest_unit' );



									}



									elseif($element == 'Waist')



									{



										$unit= get_option( 'gmgt_waist_unit' );



									}



									elseif($element == 'Thigh')



									{



										$unit= get_option( 'gmgt_thigh_unit' );



									}



									elseif($element == 'Arms')



									{



										$unit= get_option( 'gmgt_arms_unit' );



									}



										elseif($element == 'Fat')



									{



										$unit= get_option( 'gmgt_fat_unit' );



									}



										



										echo '<option value='.esc_attr($key).' '.selected(esc_attr($measument),esc_attr($key)).'>'.esc_html__($element,'gym_mgt').' - '.esc_html__($unit,'gym_mgt').'</option>';



									}



									?>



								</select>



							</div>



							<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="result" class="form-control validate[required] text-input decimal_number" min="0" step="0.01" onKeyPress="if(this.value.length==6) return false;" type="number" value="<?php if($edit){ echo esc_attr($result->result);}elseif(isset($_POST['result'])) echo esc_attr($_POST['result']);?>" name="result">



										<label class="" for="Description"><?php esc_html_e('Result','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="result_date" class="form-control validate[required]"  type="text"  name="result_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->result_date));} elseif(isset($_POST['result_date'])){ echo $_POST['result_date'];} else echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); ?>" readonly>



										<label class="" for="Description"><?php esc_html_e('Record Date','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control upload-profile-image-patient">



										<label class="ustom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>



										<div class="col-sm-12">



											<input type="text" id="display_none" id="gmgt_user_avatar_url" class="form-control" name="gmgt_progress_image"  readonly value="<?php if($edit)echo esc_url( $user_info->gmgt_progress_image );elseif(isset($_POST['gmgt_progress_image'])) echo esc_url($_POST['gmgt_progress_image']); ?>" />



										



											<input type="hidden" name="hidden_upload_user_progress_image" value="<?php if($edit){ echo esc_url($result->gmgt_progress_image);}elseif(isset($_POST['gmgt_progress_image'])) echo esc_url($_POST['gmgt_progress_image']);?>">



											<input id="upload_user_avatar_image"  class="image-preview-show" name="gmgt_progress_image" onchange="MJ_gmgt_fileCheck(this);" type="file" class="form-control file" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />



										</div>



									</div>



									<div class="clearfix"></div>



									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">



										<div id="upload_user_avatar_preview" class="upload_user_avatar_preview">



											<?php 



											if($edit) 



											{						



												if($result->gmgt_progress_image == "")



												{ 



														?>



													<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_measurement_thumb' )); ?>">



													<?php 



												}



												else 



												{



													?>



													<img class="image_preview_css" src="<?php if($edit) echo esc_url( $result->gmgt_progress_image ); ?>" />



													<?php 



												}



											}



											else 



											{



												?>



												<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_measurement_thumb' )); ?>">



												<?php 



											}



											?>



										</div>



									</div>



								</div>



							</div>



						</div>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat-->



							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



								<input type="submit" value="<?php if($edit){ esc_html_e('Save Measurement','gym_mgt'); }else{ esc_html_e('Save Measurement','gym_mgt');}?>" name="save_measurement" class="<?php if($obj_gym->role=='staff_member' || $obj_gym->role=='accountant') { echo "save_member_validate"; } ?> btn save_btn"/>



							</div>



						</div>



					</div>



				</form><!-- WORKOUT FORM END-->



			</div><!-- PANEL BODY DIV START-->



			<?php



		}



			?>



		</div><!-- TAB PANE DIV END -->



	</div><!-- TAB CONTENT DIV END-->



	<?php ?>



	<script type="text/javascript">



	function MJ_gmgt_fileCheck(obj)



	{



		var fileExtension = ['jpeg', 'jpg', 'png', 'bmp',''];



		if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)



		{



			alert("<?php esc_html_e("Only .jpeg, .jpg, .png, .bmp formats are allowed.",'gym_mgt');?>");



			$(obj).val('');



		}								



	}



	</script>