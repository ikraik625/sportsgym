<?php

$curr_user_id=get_current_user_id();

$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);

$obj_class=new MJ_gmgt_classschedule;

$obj_workouttype=new MJ_gmgt_workouttype;

$obj_activity=new MJ_gmgt_activity;

$obj_workout=new MJ_gmgt_workout;

$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'workoutassignlist';

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

		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

		{

			if($user_access['delete']=='0')
			{	

				MJ_gmgt_access_right_page_not_access_message();

				die;

			}	

		}

		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='view'))

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

jQuery(document).ready(function($) 

{

	"use strict";

	jQuery('#assignworkout_list').DataTable({

		 "order": [[ 1, "asc" ]],

		 dom: 'lifrtp',

		 "aoColumns":[

					  {"bSortable": false},

	                  {"bSortable": true},

	                  {"bSortable": true},

					  <?php 

						if($obj_gym->role == 'staff_member'|| ($obj_gym->role == 'member' && $retrieved_data->ID==get_current_user_id()))

						{ ?>

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

<?php 

//SAVE WORKOUT TYPE DATA

if(isset($_POST['save_workouttype']))

{

	$nonce = $_POST['_wpnonce'];

	if (wp_verify_nonce($nonce, 'save_workouttype_nonce' ))

	{

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

		{

			$result=$obj_workouttype->MJ_gmgt_add_workouttype($_POST);

			if($result)

			{

				if(isset($_REQUEST['workout_list_app']) && $_REQUEST['workout_list_app'] == 'workoutassignlist_app')

				{

					wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&page_action=web_view_hide&workout_list_app=workoutassignlist_app&message=1');

				}

				else

				{

					wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=1');

				}	

				//wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=2');

			}

		}

		else

		{

			$result=$obj_workouttype->MJ_gmgt_add_workouttype($_POST);

			if($result)

			{

				if(isset($_REQUEST['workout_list_app']) && $_REQUEST['workout_list_app'] == 'workoutassignlist_app')

				{

					wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&page_action=web_view_hide&workout_list_app=workoutassignlist_app&message=1');

				}

				else

				{

					wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=1');

				}	

				//wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=1');

			}

		}

	}

}

//Save Workout Log

if(isset($_POST['save_workoutlog']))

{

	$result=$obj_workouttype->MJ_gmgt_update_user_workouts_logs($_POST);

		if($result)

		{

			if(isset($_REQUEST['workout_list_app']) && $_REQUEST['workout_list_app'] == 'workoutassignlist_app')

			{

				wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&page_action=web_view_hide&workout_list_app=workoutassignlist_app&message=2');

			}

			else

			{

				wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=2');

			}	

		//	wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=2');			

		}

}

//Delete WORKOUT TYPE DATA

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')

{

	$result=$obj_workouttype->MJ_gmgt_delete_workouttype($_REQUEST['assign_workout_id']);

	if($result)

	{

		if(isset($_REQUEST['workout_list_app']) && $_REQUEST['workout_list_app'] == 'workoutassignlist_app')

		{

			wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&page_action=web_view_hide&workout_list_app=workoutassignlist_app&message=3');

		}

		else

		{

			wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=3');

		}	

		//wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=3');

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





			<?php esc_html_e('Workout added successfully.','gym_mgt');?>





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





}





?>





<!-- POP up code -->





<div class="popup-bg">





    <div class="overlay-content">





		<div class="modal-content">





		    <div class="category_list"></div>





        </div>





    </div> 





</div>





<!-- End POP-UP Code -->





<div class="panel-body panel-white padding_0 float_left_width_100 gms_main_list"><!-- PANEL BODY DIV START -->





	<div class="tab-content padding_0"><!-- TAB CONTENT DIV START -->





    	<div class="tab-pane <?php if($active_tab == 'workoutassignlist') echo "fade active in";?>" id="workoutassignlist"><!-- TAB PANE DIV START -->





			<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->





			    <?php 





				if($obj_gym->role == 'member')





				{





					$current_user_id = get_current_user_id();





					$workout_logdata=MJ_gmgt_get_userworkout($current_user_id);
				
					if(!empty($workout_logdata))

					{

						foreach($workout_logdata as $row)

						{
							
							$all_logdata=MJ_gmgt_get_workoutdata($row->workout_id); 

							$arranged_workout=MJ_gmgt_set_workoutarray($all_logdata);

							?>

							<div class="workout_<?php echo $row->workout_id;?> workout-block">

								<div class="panel-headingaa">

									<div class="row gmgt_fn_assign_work">

										<div class="col-sm-7 d-flex align-items-center">

											<h3 class="panel-title"><i class="fa fa-calendar"></i> 

												<?php

												esc_html_e('Start From ','gym_mgt');

												echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box(esc_html($row->start_date))."</span>";

												esc_html_e(' To ','gym_mgt');

												echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box(esc_html($row->end_date))."</span>";





												if(!empty($row->description))





												{





													esc_html_e('  Description : ','gym_mgt');





													echo "<span class='work_date'>".esc_html($row->description)."</span>";





												}





												?>





											</h3>





										</div>





										<div class="col-sm-5 row view_workout_btn_width_height res_marging_0" >





											<div class="col-md-6">





												<a href="?page=assign-workout&print=print&workout_id=<?php echo $row->workout_id;?>" target="_blank" class="btn_margin_top_10px btn save_btn pull-right margin_left_10 mb_res_10px"><?php esc_html_e('Print Workout','gym_mgt');?></a>





											</div>





											





											<div class="col-md-6">





												<a href="?page=assign-workout&workout_pdf=workout_pdf&workout_id=<?php echo $row->workout_id;?>" target="_blank" class="btn btn_margin_top_10px save_btn workout_pdf pull-right"> <?php esc_html_e('PDF Workout','gym_mgt');?></a>





											</div>





													





										</div>





									</div>				





								</div>	





								<div class="panel-white">





									<?php





									if(!empty($arranged_workout))





									{

										



										?>





										<div class="work_out_datalist_header">





											<div class="col-md-2 col-sm-2">  





												<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>





											</div>





											<div class="col-md-10 col-sm-10 hidden-xs dis_flex dis_block_res">





												<span class="col-md-3"><?php esc_html_e('Activity','gym_mgt');?></span>





												<span class="col-md-3"><?php esc_html_e('Sets','gym_mgt');?></span>





												<span class="col-md-2"><?php esc_html_e('Reps','gym_mgt');?></span>





												<span class="col-md-2"><?php esc_html_e('KG','gym_mgt');?></span>





												<span class="col-md-2"><?php esc_html_e('Rest Time','gym_mgt');?></span>





											</div>





										</div>





										<?php 





										foreach($arranged_workout as $key=>$rowdata)





										{
											




											?>





											<div class="work_out_datalist dis_flex dis_block_res">





												<div class="col-md-2 day_name">  





													<?php echo esc_html__($key,"gym_mgt");?>





												</div>





												<div class="col-md-10 col-xs-12 dis_block_res display_block">





														<?php foreach($rowdata as $row){





																echo $row."<div class='clearfix'></div><br>";





														} ?>





												</div>





											</div>





										<?php }





									}





									?>





								</div>





							</div>





				  			<?php 





						}





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





					$get_members = array('role' => 'member');





					$membersdata=get_users($get_members);





					if(!empty($membersdata))





					{





						?>





						<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->





							<table id="assignworkout_list" class="display" cellspacing="0" width="100%"><!-- ASSIGNED WORKOUT TABLE START -->


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





									$get_members = array('role' => 'member');





									$membersdata=get_users($get_members);





									if(!empty($membersdata))





									{





										foreach ($membersdata as $retrieved_data){?>





										<tr>





											<td class="user_image width_50px padding_left_0">





												<?php $uid=$retrieved_data->ID;





												$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);





												if(empty($userimage))





												{





													echo '<img src='.get_option( 'gmgt_assign_workout_thumb' ).' id="width_50" class="height_50 img-circle" />';





												}





												else





												{





													echo '<img src='.$userimage.' id="width_50" class="height_50 img-circle"/>';





												}





												?>





											</td>





											<td class="member">





												<?php if($obj_gym->role == 'staff_member')





												{





													?>





													<?php $user=get_userdata($retrieved_data->ID);





													$display_label=$user->display_name;





													$memberid=get_user_meta($retrieved_data->ID,'member_id',true);





													$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID));





													if($display_label)


													{


														echo esc_html($display_label);





													}





												}





												else





												{





													?>





													<?php $user=get_userdata($retrieved_data->ID);





													$display_label=$user->display_name;





													$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID));





													if($display_label)


													{


														echo esc_html($display_label);





													}





												}





												?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>





											</td>





											<td class="member-goal"><?php $intrestid=get_user_meta($retrieved_data->ID,'intrest_area',true);





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





											<?php 





											if($obj_gym->role == 'staff_member'|| ($obj_gym->role == 'member' && $retrieved_data->ID==get_current_user_id()))





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











																	if(isset($_REQUEST['workout_list_app']) && $_REQUEST['workout_list_app'] == 'workoutassignlist_app')





																	{





																		?>





																		<li class="float_left_width_100">





																			<a href="?dashboard=user&page=assign-workout&tab=assignworkout&action=view&workout_list_app=workoutassignlist_app&page_action=web_view_hide&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View Workouts', 'gym_mgt' ) ;?></a>





																		</li>





																		<?php





																	}





																	else





																	{





																		?>





																		<li class="float_left_width_100">





																			<a href="?dashboard=user&page=assign-workout&tab=assignworkout&action=view&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View Workouts', 'gym_mgt' ) ;?></a>





																		</li>





																		<?php





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





										} 





									}?>





								</tbody>





							</table><!-- ASSIGNED WORKOUT TABLE END -->





						</div><!-- TABLE RESPONSIVE DIV END-->





						<?php





					}





					else





					{





						if($user_access['add'] == 1)





						{





							?>





							<div class="no_data_list_div"> 





								<a href="<?php echo home_url().'?dashboard=user&page=assign-workout&tab=assignworkout';?>">





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





				?>





	    	</div><!-- PANEL BODY DIV END -->





	    </div><!-- TAB PANE DIV END -->





		<script type="text/javascript">





			jQuery(document).ready(function($) 





			{





				"use strict";





				$(".display-members").select2();





				$('#workouttype_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});





				$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);





					$("#start_date").datepicker(





					{	





						dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',





						minDate:0,





						onSelect: function (selected) 





						{





							var dt = new Date(selected);





							dt.setDate(dt.getDate() + 0);





							$("#end_date").datepicker("option", "minDate", dt);





						}





					});





					$("#end_date").datepicker(





					{		





					dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',





						onSelect: function (selected) {





							var dt = new Date(selected);





							dt.setDate(dt.getDate() - 0);





							$("#start_date").datepicker("option", "maxDate", dt);





						}





					});





					$(".add_workouttype_val").on('click',function()





					{





						$(".add_workouttype_val").addClass("add_workouttype_data");





					});





					$(".save_workouttype_btn").on('click',function()





					{





						if(!($(".add_workouttype_val").hasClass('add_workouttype_data')))





						{





							alert("<?php esc_html_e('Please Click on Step-1 Add Workout first','gym_mgt');?>");





							return false;





						}





					});





			} );





		</script>





		<style>





			div#ui-datepicker-div{z-index:99999 !important}





		</style>





		<?php 	





		$workoutmember_id=0;





		$edit=0;





		if(isset($_REQUEST['workouttype_id']))





			$workouttype_id=esc_attr($_REQUEST['workouttype_id']);





		if(isset($_REQUEST['workoutmember_id']))





		{





			$edit=1;





			$workoutmember_id=esc_attr($_REQUEST['workoutmember_id']);





			$workout_logdata=MJ_gmgt_get_userworkout($workoutmember_id);





		}





		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')





		{





			$edit=1;	





		}





		?>	





		<div class="tab-pane <?php if($active_tab == 'assignworkout') echo "fade active in";?>"><!-- TAB PANE DIV START -->





			<?php 





			if($obj_gym->role == 'staff_member' || $obj_gym->role == 'member' )





			{





				?>





				<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->





					<form name="workouttype_form" action="" method="post" class="form-horizontal" id="workouttype_form"><!--WORKOUT TYPE FORM STRAT-->





						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>





						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">





						<input type="hidden" name="assign_workout_id" value="" />





						<div class="header">	





							<h3 class="first_hed"><?php esc_html_e('Assign Workout Information','gym_mgt');?></h3>





						</div>





						<div class="form-body user_form"> <!-- user_form Strat-->   





							<div class="row"><!--Row Div Strat-->





								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">





									<!-- <label class="ml-1 custom-top-label top" for="refered"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->





									<?php if($edit){ $member_id=$workoutmember_id; }elseif(isset($_POST['member_id'])){$member_id=sanitize_text_field($_POST['member_id']);}else{$member_id='';}?>





									<select id="member_list" class="form-control display-members assigned_workout_member_id" name="member_id" required="true">





										<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>





											<?php $get_members = array('role' => 'member');





											$membersdata=get_users($get_members);


											


												if(!empty($membersdata))





												{





												foreach ($membersdata as $member)





												{





													if( $member->membership_status == "Continue")





													{





													?>





													<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>





												<?php





													}





												}





												}?>





									</select>





								</div>





								<div class="col-sm-10 col-md-4 col-lg-4 col-xl-4 input">





									<label class="ml-1 custom-top-label top" for="refered"><?php esc_html_e('Level','gym_mgt');?></label>





									<select class="form-control" name="level_id" id="level_type">





										<option value=""><?php esc_html_e('Select Level','gym_mgt');?></option>





										<?php





										if(isset($_REQUEST['level_id']))





										{





											$category =esc_attr($_REQUEST['level_id']);  





										}





										elseif($edit)





										{





											$category =$result->level_id;





										}





										else





										{ 





											$category = "";





										}





										$measurmentdata=MJ_gmgt_get_all_category('level_type');





										if(!empty($measurmentdata))





										{





											foreach ($measurmentdata as $retrive_data)





											{





												echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';





											}





										}





										?>					





									</select>





								</div>





								<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 mb-3">				





									<button id="addremove" model="level_type" class="btn save_btn"><?php esc_html_e('Add','gym_mgt');?></button>





								</div>





								





								<?php wp_nonce_field( 'save_workouttype_nonce' ); ?>





								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">





									<div class="form-group input">





										<div class="col-md-12 form-control">





											<input id="start_date" class="form-control validate[required]" type="text"  name="start_date" value="<?php if(isset($_POST['start_date'])){ echo esc_attr($_POST['start_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>





											<label class="" for="date"><?php esc_html_e('Start Date','gym_mgt');?><span class="require-field">*</span></label>





										</div>





									</div>





								</div>





								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">





									<div class="form-group input">





										<div class="col-md-12 form-control">





											<input id="end_date" class="form-control validate[required]" type="text"   name="last_date" value="<?php if(isset($_POST['end_date'])){ echo esc_attr($_POST['end_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>





											<label class="" for="date"><?php esc_html_e('End Date','gym_mgt');?><span class="require-field">*</span></label>





										</div>





									</div>





								</div>





								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">





									<div class="form-group input">





										<div class="col-md-12 form-control">





											<input id="description" class="form-control validate[custom[address_description_validation]]" maxlength="150" type="text" name="description" value="<?php if(isset($_POST['description'])) echo esc_textarea($_POST['description']); ?>">





											<label class="" for="Description"><?php esc_html_e('Description','gym_mgt');?></label>





										</div>





									</div>





								</div>





								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">





									<div class="form-group">





										<div class="col-md-12 form-control">





											<div class="row padding_radio">





												<div class="">





													<label class="custom-top-label" for="member_convert"><?php esc_html_e('Send SMS To Member','gym_mgt');?></label>





													<input type="checkbox" id="chk_sms_sent" class="member_convert check_box_input_margin" name="gmgt_sms_service_enable" value="1"> <?php esc_attr_e('Enable','gym_mgt');?>





												</div>												





											</div>





										</div>





									</div>





								</div>





								<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 rtl_margin_top_15px assign_workout">





									<div class="form-group">





										<div class="col-md-12 form-control">





											<div class="row padding_radio">





												<div class="checkbox">





													<label class="custom-top-label" for="member_convert"><?php esc_html_e('Select Days','gym_mgt');?><span class="require-field">*</span></label>





													<?php





													foreach (MJ_gmgt_days_array() as $key=>$value)





													{





														?>





														<input type="checkbox" class="validate[required] checkbox add_workout_bottomspace" value="" name="day[]" value="<?php echo esc_attr($value);?>" id="<?php echo $key;?>" data-val="day">





														<span class="margin_right_50px">





														<?php 





														if($key =='Sunday')





														{





															echo esc_html_e('Sunday','gym_mgt');





															?>&nbsp;&nbsp;<?php





														} 	





														elseif($key =='Monday')





														{





															echo esc_html_e('Monday','gym_mgt');





															?>&nbsp;&nbsp;<?php





														} 	





														elseif($key =='Tuesday')





														{





															echo esc_html_e('Tuesday','gym_mgt');





															?>&nbsp;&nbsp;<?php





														} 	





														elseif($key =='Wednesday')





														{





															echo esc_html_e('Wednesday','gym_mgt');





															?>&nbsp;&nbsp;<?php





														} 	





														elseif($key =='Thursday')





														{





															echo esc_html_e('Thursday','gym_mgt');





															?>&nbsp;&nbsp;<?php





														} 	





														elseif($key =='Friday')





														{





															echo esc_html_e('Friday','gym_mgt');





															?>&nbsp;&nbsp;<?php





														} 	





														elseif($key =='Saturday')





														{





															echo esc_html_e('Saturday','gym_mgt');





															?>&nbsp;&nbsp;<?php





														} 	  





														?>





														</span>





														<?php





													}





													?>





												</div>												





											</div>





										</div>





									</div>





								</div>	





								<script>


									$(document).ready(function() 


									{


										var curr_data = {


											action: 'BindControls',


											dataType: 'json'


										};	 





										$.post(gmgt.ajax, curr_data, function(response) { 	


											var json_obj = JSON.parse(response);


											$('#Activity_category_autocompalte').autocomplete({


												source: json_obj[0]['post_title'],


												minLength: 0,


												scroll: true


											}).focus(function() {


												$(this).autocomplete("search", "");


												$(".ui-autocomplete li").addClass('add_activity_category');


												$(".ui-autocomplete").addClass('add_activity_category_ui');


											});


											return false;


										});	


									});


								</script>


								


								<div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 input_margin_top_15px">


									<div class="header">	


										<h3 class="first_hed"><?php esc_html_e('Workout Detail','gym_mgt');?><span class="require-field">*</span></h3>


									</div>


									<div class="form-group input">





										<div class="col-sm-12 col-xs-12 margin_left_33px margin_bottom_15px" >


											<div id="activity_list_append"></div>


										</div>


										<input type="hidden" class="append_array" name="append_array[]" value="">


										<div class="col-md-12 form-control">


											<div class="form-group col-sm-12 col-xs-12 has-search position_relative">


												<span class="fa fa-search form-control-feedback"></span><input type="text" class="form-control activity_category_input Activity_category_autocompalte min_height" placeholder="<?php esc_html_e('Search Activity Category','gym_mgt');?>" id="Activity_category_autocompalte" />


											</div>


										</div>	


																			


									</div>


								</div>			





							</div>





						</div>





						<div class="form-body user_form">





							<div class="row">





								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6 input" style="margin-top:15px;">





									<input type="button" value="<?php esc_html_e('Step-1 Add Workout','gym_mgt');?>" name="sadd_workouttype" id="add_workouttype" class="btn save_member_validate save_btn add_workouttype_val"/>





								</div>





								<div id="display_rout_list"></div>





								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">





									<input type="submit" value="<?php if($edit){ esc_html_e('Step-2 Save Workout','gym_mgt'); }else{ esc_html_e('Step-2 Save Workout','gym_mgt');}?>" name="save_workouttype" class="btn save_btn save_workouttype_btn"/>





								</div>





							</div>		





						</div>





					</form><!--WORKOUT TYPE FORM END-->





				</div><!-- PANEL BODY DIV END -->





				<?php 





			}





			if($obj_gym->role == 'staff_member'|| ($obj_gym->role == 'member' && $workoutmember_id==get_current_user_id()))





			{





				if(isset($workout_logdata))





				foreach($workout_logdata as $row)





				{





					$all_logdata=MJ_gmgt_get_workoutdata($row->workout_id);





					$arranged_workout=MJ_gmgt_set_workoutarray($all_logdata);





					?>





					<div class="workout_<?php echo $row->workout_id;?> workout-block">





						<div class="panel-headingaa">





							<div class="row">





								<div class="col-sm-8 d-flex align-items-center">





									<h3 class="panel-title" style="line-height: 23px;"><i class="fa fa-calendar"></i> 





										<?php





										esc_html_e('Start From ','gym_mgt');





										echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box(esc_html($row->start_date))."</span>";





										esc_html_e(' To ','gym_mgt');





										echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box(esc_html($row->end_date))."</span>";





										if(!empty($row->description))





										{





											echo "<br>";





											esc_html_e('  Description : ','gym_mgt');





											echo "<span class='work_date'>".esc_html($row->description)."</span>";





										}





										?>





									</h3>





								</div>





								<div class="col-sm-4 row view_workout_btn_width_height" >





									<?php 





									if($user_access['delete']=='1' && $obj_gym->role == 'staff_member')





									{ 





										?>





										<div class="col-md-6">





											<a class="removeworkout btn_margin_top_10px btn dlt_btn pull-right margin_left_10 mb_res_10px" id="<?php echo $row->workout_id;?>"><?php esc_html_e('Delete','gym_mgt');?></a>





										</div>





										<?php 





									}





									if($user_access['edit'] == '1')





									{





										if(isset($_REQUEST['workout_list_app']) && $_REQUEST['workout_list_app'] == 'workoutassignlist_app')





										{





											?>





											<div class="col-md-6">





												<a href="?dashboard=user&page=assign-workout&tab=edit_assignworkout&action=edit&page_action=web_view_hide&workout_list_app=workoutassignlist_app&workoutmember_id=<?php echo $row->workout_id;?>" class="btn btn_margin_top_10px save_btn pull-right"> <?php esc_html_e('Edit','gym_mgt');?></a>





											</div>





											<?php 





										}





										else





										{





											?>





											<div class="col-md-6">





												<a href="?dashboard=user&page=assign-workout&tab=edit_assignworkout&action=edit&workoutmember_id=<?php echo $row->workout_id;?>" class="btn btn_margin_top_10px save_btn pull-right"> <?php esc_html_e('Edit','gym_mgt');?></a>





											</div>





											<?php





										}





									} 





									?>





								</div>





							</div>				





						</div>	





						<div class="panel-white">





							<?php





							if(!empty($arranged_workout))





							{





								?>





								<div class="work_out_datalist_header">





									<div class="col-md-2 col-sm-2">  





										<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>





									</div>





									<div class="col-md-10 col-sm-10 hidden-xs dis_flex dis_block_res">





										<span class="col-md-3"><?php esc_html_e('Activity','gym_mgt');?></span>





										<span class="col-md-3"><?php esc_html_e('Sets','gym_mgt');?></span>





										<span class="col-md-2"><?php esc_html_e('Reps','gym_mgt');?></span>





										<span class="col-md-2"><?php esc_html_e('KG','gym_mgt');?></span>





										<span class="col-md-2"><?php esc_html_e('Rest Time','gym_mgt');?></span>





									</div>





								</div>





								<?php 





								foreach($arranged_workout as $key=>$rowdata)





								{





									?>





									<div class="work_out_datalist dis_flex dis_block_res">





										<div class="col-md-2 day_name">  





											<?php echo esc_html__($key,"gym_mgt");?>





										</div>





										<div class="col-md-10 col-xs-12 dis_block_res display_block">





												<?php foreach($rowdata as $row){





														echo $row."<div class='clearfix'></div><br>";





												} ?>





										</div>





									</div>





								<?php }





							}





							?>





						</div>





					</div>





					<?php





				}						





			}	





			?>





		</div><!-- TAB PANE DIV END -->





		<?php





		if($active_tab == 'edit_assignworkout')





		{





			$workoutmember_id=esc_attr($_REQUEST['workoutmember_id']);				





			$workout_logdata=MJ_gmgt_get_userworkout($workoutmember_id);





			$all_logdata=MJ_gmgt_get_workoutdata($_REQUEST['workoutmember_id']);





			$workout_data = $obj_workouttype->MJ_gmgt_get_singal_assignworkout($_REQUEST['workoutmember_id']);





			$arranged_workout=MJ_gmgt_set_workoutarray_new($all_logdata);





																





			if(!empty($all_logdata))





			{ 





				foreach($workout_logdata as $row)





				{





					?>





					<div class="workout_<?php echo esc_attr($row->workout_id);?> workout-block">





						<!--WORKOUT BLOCK DIV START-->





						<div class="panel-heading height_auto">





							<div class="panel-heading">





								<h3 class="panel-title"><i class="fa fa-calendar"></i>





									<?php 





									esc_html_e('Start From ','gym_mgt');





									echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->start_date)."</span>";





									esc_html_e(' To ','gym_mgt');





									echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->end_date)."</span>&nbsp;";





									if(!empty($row->description))





									{





										esc_html_e('Description : ','gym_mgt');





										echo "<span class='work_date'>".$row->description."</span>";





									}





									?> 





								</h3>	





							</div>						





						</div>





						<?php





				}





					?>





					<div class="">





						<!--PANEL WHITE DIV START-->





						<form name="edit_workout_form" action="" method="post" class="edit_workout_form" id="edit_workout_form">





							<!-- ACTIVITY FORM START-->





							<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'edit';?>





							<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">





							<input type="hidden" name="workout_id" value="<?php echo esc_attr($_REQUEST['workoutmember_id']);?>">





							<div class="table-responsive">





							<table class="table workour_edit_table" width="100%">





								<thead>





									<tr class="assign_workout_table_header_tr">





										<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Day Name','gym_mgt');?></th>





										<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Activity','gym_mgt');?></th>





										<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Sets','gym_mgt');?></th>





										<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('Reps','gym_mgt');?></th>





										<th class="assign_workout_table_header assign_workout_right_border" scope="col"><?php esc_html_e('KG','gym_mgt');?></th>





										<th class="assign_workout_table_header assign_workout_border" scope="col"><?php esc_html_e('Rest Time','gym_mgt');?></th>





									</tr>





								</thead>





								<tbody>





									<?php 





									foreach($arranged_workout as $key=>$rowdata)





									{





										$i=1;										





										foreach($rowdata as $row)





										{ 





											?>





											<input type="hidden" value="<?php echo $row['id']; ?>" name="id[]"/>





											<tr class="assign_workout_table_body_tr">





												<?php 





												if($i == 1)





												{ 





													?>





													<th class="assign_workout_table_body table_body_border_right" scope="row"><?php 





														if($key =='Sunday')





														{





															echo esc_html_e('Sunday','gym_mgt');





														} 	





														elseif($key =='Monday')





														{





															echo esc_html_e('Monday','gym_mgt');





														} 	





														elseif($key =='Tuesday')





														{





															echo esc_html_e('Tuesday','gym_mgt');





														} 	





														elseif($key =='Wednesday')





														{





															echo esc_html_e('Wednesday','gym_mgt');





														} 	





														elseif($key =='Thursday')





														{





															echo esc_html_e('Thursday','gym_mgt');





														} 	





														elseif($key =='Friday')





														{





															echo esc_html_e('Friday','gym_mgt');





														} 	





														elseif($key =='Saturday')





														{





															echo esc_html_e('Saturday','gym_mgt');





														} 	  





														?>





													</th>





													<?php





												}





												else





												{ 





													?>





													<th class="assign_workout_table_body table_body_border_right" scope="row"></th>





													<?php 





												}





												?>





											





												<td class="width_200 assign_workout_table_body table_body_border_right"><span><?php echo $row['workout_name']; ?></span></td>





												<td class="assign_workout_table_body table_body_border_right">





													<input type="number" class="validate[required] form-control text-input workout_validate style_width_admin" min="0"





														onkeypress="if(this.value.length==3) return false;" name="sets[]"





														<?php if($row['sets'] == '-') { ?> value="<?php echo "-";?>" readonly="readonly"





														<?php } else{  ?> value="<?php echo $row['sets']; ?>" <?php } ?>></td>





												<td class="assign_workout_table_body table_body_border_right">





													<input type="number" class="validate[required] form-control text-input workout_validate style_width_admin" min="0"





														onkeypress="if(this.value.length==3) return false;" name="reps[]"





														<?php if($row['reps'] == '-') { ?> value="<?php echo "-";?>" readonly="readonly"





														<?php } else{  ?> value="<?php echo $row['reps']; ?>" <?php } ?>></td>





												<td class="assign_workout_table_body table_body_border_right">





													<input type="number" class="validate[required] form-control text-input workout_validate style_width_admin" min="0"





														onkeypress="if(this.value.length==6) return false;" name="kg[]"





														<?php if($row['kg'] == '-') { ?> value="<?php echo "-";?>" readonly="readonly"





														<?php } else{  ?>value="<?php echo $row['kg']; ?>" <?php } ?>></td>





												<td class="assign_workout_table_body">





													<input type="number" class="validate[required] form-control text-input  workout_validate  style_width_admin" min="0"





														onkeypress="if(this.value.length==3) return false;" name="time[]"





														<?php if($row['time'] == '-') { ?> value="<?php echo "-";?>" readonly="readonly"





														<?php } else{  ?>value="<?php echo $row['time']; ?>" <?php } ?>></td>





												<?php 





												$i++;  





												?>





											</tr>





											<?php





										}





									} 





									?>





								</tbody>





							</table>





							</div>





							<div class="col-md-3 edit_workout_padding_bottom">





								<input type="submit" value="<?php esc_html_e('Save Workout','gym_mgt'); ?>" name="save_workoutlog" class="btn save_btn custom_save_button"/>





							</div>





						</form>





					</div>





					<!--PANEL WHITE DIV END-->





				</div>





				<!--WORKOUT BLOCK DIV END-->





				<?php





			}





		}





		?>	





	</div><!-- TAB CONTENT DIV END -->





</div><!-- PANEL BODY DIV END -->