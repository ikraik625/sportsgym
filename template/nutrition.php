<?php 



$curr_user_id=get_current_user_id();



$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



$obj_nutrition=new MJ_gmgt_nutrition;



$active_tab = isset($_GET['tab'])?$_GET['tab']:'nutritionlist';



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



		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='view'))



		{



			if($user_access['add']=='0')



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



//SAVE Nutrition DATA



if(isset($_POST['save_nutrition']))



{



	$nonce = $_POST['_wpnonce'];



	if (wp_verify_nonce( $nonce, 'save_nutrition_nonce' ) )



	{



		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



		{		



			$result=$obj_nutrition->MJ_gmgt_add_nutrition($_POST);



			if($result)



			{



				if(isset($_REQUEST['nutrition_list_app']) && $_REQUEST['nutrition_list_app'] == 'nutritionlist_app')



				{



					wp_redirect ( home_url() .'?dashboard=user&page=nutrition&tab=nutritionlist&page_action=web_view_hide&nutrition_list_app=nutritionlist_app&message=2');



				}



				else



				{



					wp_redirect ( home_url() .'?dashboard=user&page=nutrition&tab=nutritionlist&message=2');



				}	



				//wp_redirect ( home_url().'?dashboard=user&page=nutrition&tab=nutritionlist&message=2');



			}	



		}



		else



		{



			$result=$obj_nutrition->MJ_gmgt_add_nutrition($_POST);



			if($result)



			{



				if(isset($_REQUEST['nutrition_list_app']) && $_REQUEST['nutrition_list_app'] == 'nutritionlist_app')



				{



					wp_redirect ( home_url() .'?dashboard=user&page=nutrition&tab=nutritionlist&page_action=web_view_hide&nutrition_list_app=nutritionlist_app&message=1');



				}



				else



				{



					wp_redirect ( home_url() .'?dashboard=user&page=nutrition&tab=nutritionlist&message=1');



				}	



				//wp_redirect ( home_url().'?dashboard=user&page=nutrition&tab=nutritionlist&message=1');



			}



		}



	}	



}



//DELETE Nutrition DATA	



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



{	



	$result=$obj_nutrition->MJ_gmgt_delete_nutrition($_REQUEST['nutrition_id']);



	if($result)



	{



		if(isset($_REQUEST['nutrition_list_app']) && $_REQUEST['nutrition_list_app'] == 'nutritionlist_app')



		{



			wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&page_action=web_view_hide&nutrition_list_app=nutritionlist_app&message=3');



		}



		else



		{



			wp_redirect ( home_url() .'?dashboard=user&page=assign-workout&tab=workoutassignlist&message=3');



		}	



	//	wp_redirect ( home_url().'?dashboard=user&page=nutrition&tab=nutritionlist&message=3');



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



			<?php esc_html_e('Nutrition added successfully.','gym_mgt');?>



		</div>



		<?php 	



	}



	elseif($message == 2)



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Nutrition updated successfully.','gym_mgt');?>



		</div>



		<?php 	



	}



	elseif($message == 3) 



	{



		?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<?php esc_html_e('Nutrition deleted successfully.','gym_mgt');?>



		</div>



		<?php		



	}



}



?>



<script type="text/javascript">



	$(document).ready(function() 



	{



		"use strict";



		jQuery('#nutrition_list').DataTable({



			// "responsive": true,



			"order": [[ 0, "asc" ]],



			dom: 'lifrtp',



			"aoColumns":[



						{"bSortable": false},



						{"bSortable": true},



						{"bSortable": true},



						{"bSortable": false}],



					language:<?php echo MJ_gmgt_datatable_multi_language();?>	



			});



			$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



			$('#nutrition_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



			$(".display-members").select2();



			$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



			$(".start_date").datepicker(



			{	



				dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



				minDate:0,



				onSelect: function (selected) {



				var dt = new Date(selected);



				dt.setDate(dt.getDate() + 0);



				$(".end_date").datepicker("option", "minDate", dt);



			}



		});



		$(".end_date").datepicker(



		{		



		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



			onSelect: function (selected) {



				var dt = new Date(selected);



				dt.setDate(dt.getDate() - 0);



				$(".start_date").datepicker("option", "maxDate", dt);



			}



		});



		$(".add_nutrition_val").on('click',function()



		{



			$(".add_nutrition_val").addClass("add_nutrition_data");



		});



		$(".save_nutration_btn").on('click',function()



		{

			

			if(!($(".add_nutrition_val").hasClass('add_nutrition_data')))



			{



				alert("<?php esc_html_e('Please Click on Step-1 Add Workout first','gym_mgt');?>");



				return false;



			}

			

			

		});

		// $("#add_nutrition").on('click',function()

		// {

		// 	var checkedavtivity_id = $('input[name="avtivity_id[]"]:checked').length;

		// 	if (checkedavtivity_id == 0)

		// 	{

		// 		$(".nutrition_validation_div").addClass("nutrition_validation_div_block");

		// 		return false;

		// 	}

		// 	if (checkedavtivity_id > 0)

		// 	{

		// 		$(".nutrition_validation_div").removeClass("nutrition_validation_div_block");

		// 		return true;

		// 	}

		// });

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



<div class="panel-body panel-white padding_0 gms_main_list float_left_width_100"><!-- PANEL BODY DIV START -->



	<div class="tab-content padding_0"><!-- TAB CONTENT DIV START -->



	<?php 



	if($active_tab == 'nutritionlist')



	{ 



		?>	



		<form name="wcwm_report" action="" method="post"><!-- Nutrition LIST FORM START -->



			<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->



				<?php



				if($obj_gym->role=='member')



				{



					$nutrition_logdata=MJ_gmgt_get_user_nutrition(get_current_user_id());



					



					if(empty($nutrition_logdata)) 



					{



						?>



						<div class="calendar-event-new"> 



							<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



						</div>



						<?php



					} 



					if(isset($nutrition_logdata))



						foreach($nutrition_logdata as $row)



						{



							$all_logdata=MJ_gmgt_get_nutritiondata($row->id); 



							$arranged_workout=MJ_gmgt_set_nutrition_array($all_logdata);



							?>



							 <div class="workout_<?php echo $row->id;?> workout-block"><!-- WORKOUT BLOCK DIV START -->



							 	<div class="panel-headingaa">



									<div class="row">



										<div class="col-sm-8 d-flex align-items-center">



											<h3 class="panel-title"><i class="fa fa-calendar"></i> 



												<?php



												esc_html_e('Start From ','gym_mgt');



												echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box( $row->start_date )."</span>";



												esc_html_e(' To ','gym_mgt');



												echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->expire_date ); 



												?>



											</h3>



										</div>



										<div class="col-sm-4 row view_workout_btn_width_height" >



											<div class="col-md-6">



												<a href="?page=nutrition&print=print" target="_blank" class="btn_margin_top_10px btn save_btn pull-right margin_left_10 ml_res_10px mb_res_10px" <?php if(empty($nutrition_logdata)){ ?> disabled <?php } ?>><?php esc_html_e('Print Nutrition','gym_mgt');?></a>



											</div>



											



											<div class="col-md-6">



												<a href="?page=nutrition&nutrition_pdf=nutrition_pdf" target="_blank" class="btn btn_margin_top_10px save_btn ml_res_10px pull-right" <?php if(empty($nutrition_logdata)){ ?> disabled <?php } ?>> <?php esc_html_e('PDF Nutrition','gym_mgt');?></a>



											</div>



													



										</div>



									</div>				



								</div>										



								<div class="panel-white"><!-- PANEL WHITE DIV START -->



									<?php



									if(!empty($arranged_workout))



									{ 



										?>



										<div class="work_out_datalist_header">



											<div class="col-md-4 col-sm-4 col-xs-4 width_40_per_res">  



												<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>



											</div>



											<div class="col-md-8 col-sm-8 col-xs-8 width_100_per_res res_css_nutration_div">



												<span class="col-md-3 width_60_per_res  hidden-xs margin_left_60_min float_left"><?php esc_html_e('Time','gym_mgt');?></span>



												<span class="col-md-3"><?php esc_html_e('Description','gym_mgt');?></span>



											</div>



										</div>



										<?php 



										foreach($arranged_workout as $key=>$rowdata)



										{



											?>



											<div class="work_out_datalist dis_flex">



												<div class="col-md-3 col-sm-3 col-xs-12 day_name">  



													<?php 



													



													if($key== 'Sunday')



													{



														echo esc_html_e('Sunday','gym_mgt');



													}



													elseif($key == 'Monday')



													{



														echo esc_html_e('Monday','gym_mgt');



													}



													elseif($key == 'Tuesday')



													{



														echo esc_html_e('Tuesday','gym_mgt');



													}



													elseif($key == 'Wednesday')



													{



														echo esc_html_e('Wednesday','gym_mgt');



													}



													elseif($key == 'Thursday')



													{



														echo esc_html_e('Thursday','gym_mgt');



													}



													elseif($key == 'Friday')



													{



														echo esc_html_e('Friday','gym_mgt');



													}



													elseif($key== 'Saturday')



													{



														echo esc_html_e('Saturday','gym_mgt');



													}



													?>



												</div>



												<div class="col-md-9 col-sm-9 col-xs-12">



													<?php



													foreach($rowdata as $row)



													{	



														echo $row."<br>";			



													} 



													?>



												</div>



											</div>



											<?php 



										}	



									} 



									?>											



								</div><!-- PANEL WHITE DIV END -->



							</div><!-- WORKOUT BLOCK DIV END -->



						<?php 



						}	



				}



				else



				{



					?>



					<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->



						<table id="nutrition_list" class="display" cellspacing="0" width="100%"><!-- TABLE Nutrition LIST START -->

							<thead class="<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

								<tr>

									<th><?php esc_html_e('Photo','gym_mgt');?></th>

									<th><?php esc_html_e('Member Name','gym_mgt');?></th>

									<th><?php esc_html_e('Member Goal','gym_mgt');?></th>

									<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>

								</tr>

							</thead>

							<tbody>



							<?php



							$get_members = array('role' => 'member');



							$membersdata=get_users($get_members);



							if(!empty($membersdata))



							{



								foreach ($membersdata as $retrieved_data)



								{



									if( $retrieved_data->member_type == "Member" && $retrieved_data->membership_status == "Continue")



									{



										?>



										<tr>



											<td class="user_image"><?php $uid=$retrieved_data->ID;



												$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



												if(empty($userimage)){



													echo '<img src='.get_option( 'gmgt_nutrition_thumb' ).' id="width_50" class="height_50 img-circle"  />';



												}



												else



													echo '<img src='.$userimage.' id="width_50" class="height_50 img-circle" />';



											?></td>



											<td class="member">



												<?php $user=get_userdata($retrieved_data->ID);



												$display_label=$user->display_name;



												$memberid=get_user_meta($retrieved_data->ID,'member_id',true);



												$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->ID));



												if($display_label)

												{

													echo esc_html($display_label);



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



												?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Goal','gym_mgt');?>" ></i>



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



															if(isset($_REQUEST['nutrition_list_app']) && $_REQUEST['nutrition_list_app'] == 'nutritionlist_app')
															{


																
																?>



																<li class="float_left_width_100">



																	<a href="?dashboard=user&page=nutrition&tab=addnutrition&action=view&nutrition_list_app=nutritionlist_app&page_action=web_view_hide&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-edit"></i><?php esc_html_e('Edit Nutrition', 'gym_mgt' ) ;?></a>



																</li>



																<?php
																


															}



															else



															{


																if($user_access['edit'] == '1'){
																?>



																<li class="float_left_width_100">



																	<a href="?dashboard=user&page=nutrition&tab=addnutrition&action=view&workoutmember_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-edit"></i><?php esc_html_e('Edit Nutrition', 'gym_mgt' ) ;?></a>



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



							}?>



							</tbody>             



						</table><!-- TABLE Nutrition LIST END -->



					</div><!-- TABLE RESPONSIVE DIV END -->



				<?php 



				}



				?>



			</div><!-- PANEL BODY END-->



	    </form>	<!-- Nutrition LIST FORM END -->	



		<?php 



	}



	if($active_tab == 'addnutrition')



	{



	 	$nutrition_id=0;



	 	$edit=0;



	 	if(isset($_REQUEST['workouttype_id']))



	 		$workouttype_id=$_REQUEST['workouttype_id'];



	 	if(isset($_REQUEST['workoutmember_id']))



		{



	 		$edit=0;



	 		$member_id=$_REQUEST['workoutmember_id'];



	 		$nutrition_logdata=MJ_gmgt_get_user_nutrition($member_id);



			



	 	}



		?>



        <div class="panel-body padding_0"><!-- PANEL BODY START-->



			<form name="nutrition_form" action="" method="post" class="form-horizontal" id="nutrition_form"><!--Nutrition FORM START-->



				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



				<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



				<input type="hidden" name="nutrition_id" value="<?php echo esc_attr($nutrition_id);?>"  />



				<div class="header">	



					<h3 class="first_hed"><?php esc_html_e('Nutrition Information','gym_mgt');?></h3>



				</div>



				<div class="form-body user_form"> <!-- user_form Strat-->   



					<div class="row"><!--Row Div Strat-->



						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

							<?php if(isset($_POST['member_id'])){ $member_id=$_POST['member_id'];}else{$member_id=$_REQUEST['workoutmember_id'];}?>



							<select id="member_list" class="form-control display-members" name="member_id" required="true">



								<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



									<?php



                                    //$member_id=0;		



																



									$get_members = array('role' => 'member');



									$membersdata=get_users($get_members);



									if(!empty($membersdata))



									{



										foreach ($membersdata as $member)



										{



											if( $member->membership_status == "Continue")



											{?>



												<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



										<?php



											}



										}



									}?>



							</select>



						</div>



						<?php wp_nonce_field( 'save_nutrition_nonce' ); ?>



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



						<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



							<div class="form-group input">



								<div class="col-md-12 form-control">



								<input id="Start_date" class="start_date form-control validate[required] text-input" type="text" value="<?php if(isset($_POST['start_date'])){echo esc_attr($_POST['start_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" name="start_date" readonly>



									<label class="" for="date"><?php esc_html_e('Start Date','gym_mgt');?><span class="require-field">*</span></label>



								</div>



							</div>



						</div>



						<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



							<div class="form-group input">



								<div class="col-md-12 form-control">



								<input id="end_date" class="form-control validate[required] text-input end_date"  type="text" value="<?php if(isset($_POST['end_date'])){echo $_POST['end_date'];}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" name="end_date" readonly>



									<label class="" for="date"><?php esc_html_e('End Date','gym_mgt');?><span class="require-field">*</span></label>



								</div>



							</div>



						</div>



						<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 rtl_margin_top_15px" >



							<div class="form-group">



								<div class="col-md-12 form-control">



									<div class="row padding_radio">



										<div class="checkbox">



											<label class="custom-top-label" for="member_convert"><?php esc_html_e('Select Days','gym_mgt');?><span class="require-field">*</span></label>



											<?php



											foreach (MJ_gmgt_days_array() as $key=>$name)



											{



												?>


											<label class="day_margin">
												<input type="checkbox" class="" value="" name="day[]" value="<?php echo esc_attr($key);?>" id="<?php echo esc_attr($key);?>" data-val="day">&nbsp;&nbsp;<span class="margin_right_50px" id="<?php echo "lebal_".$key;?>"><?php echo esc_html($name); ?></span>
											</label>


												<?php



											}



											?>



										</div>												



									</div>



								</div>



							</div>



						</div>	



						<div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 input_margin_top_15px">



							<div class="activity_list form-group input">



								<div class="col-md-12 form-control">



									<input id="" class="form-control" maxlength="150" type="text" name="" placeholder="<?php esc_html_e('Nutrition Details','gym_mgt'); ?>*" value="" disabled>

								

								</div>



								<div class="col-md-12 form-control title_background_color div_padding_bottom_0px">



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Break Fast','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;margin-right:10px;" type="checkbox" value="" name="avtivity_id[]" value="breakfast" class="nutrition_check" id="breakfast"  activity_title = "" data-val="nutrition_time"><?php esc_html_e('Break Fast','gym_mgt');?>



										</div>



										



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_breakfast"></div>



										</div>



									</div>



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Mid Morning Snacks','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;margin-right:10px;" type="checkbox" value="" name="avtivity_id[]" value="midmorning_snack" class="nutrition_check" id="midmorning_snack"  activity_title = "" data-val="nutrition_time"><?php esc_html_e('Mid Morning Snacks','gym_mgt');?>



										</div>



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_midmorning_snack"></div>



										</div>



									</div>



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Lunch','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;margin-right:10px;" type="checkbox" value="" name="avtivity_id[]" value="lunch" class="nutrition_check" id="lunch" activity_title = "" data-val="nutrition_time"><?php esc_html_e('Lunch','gym_mgt');?>



										</div>



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_lunch"></div>



										</div>



									</div>



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Afternoon Snacks','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;margin-right:10px;" type="checkbox" value="" name="avtivity_id[]" value="afternoon_snack" class="nutrition_check" id="afternoon_snack"  activity_title = "" data-val="nutrition_time"><?php esc_html_e('Afternoon Snacks','gym_mgt');?>



										</div>



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_afternoon_snack"></div>



										</div>



									</div>



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Dinner','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;margin-right:10px;" type="checkbox" value="" name="avtivity_id[]" value="dinner" class="nutrition_check" id="dinner"  activity_title = "" data-val="nutrition_time"><?php esc_html_e('Dinner','gym_mgt');?>



										</div>



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_dinner"></div>



										</div>



									</div>



									<div class="clear"></div>



								</div>



							</div>



						</div>	



					</div>



				</div>



				<div class="form-body user_form">



					<div class="row">



						<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6" style="margin-top:15px;">



							<input type="button" value="<?php esc_html_e('Step-1 Add Nutrition','gym_mgt');?>" name="save_nutrition" id="add_nutrition" class="btn save_member_validate save_btn add_nutrition_val"/>



						</div>



						<div id="display_nutrition_list" class="clear_both" style="margin-top:15px;"></div>



						<div class="clear"></div>



						<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6 input" style="margin-top:15px;">



							<input type="submit" value="<?php if($edit){ esc_html_e('Step 2 Save Nutrition Plan','gym_mgt'); }else{ esc_html_e('Step 2 Save Nutrition Plan','gym_mgt');}?>" name="save_nutrition" class="btn save_btn save_nutration_btn"/>



						</div>



					</div>		



				</div>



			</form><!--Nutrition FORM END-->



        </div><!--PANEL BODY DIV END-->



		<?php 



		if(isset($nutrition_logdata))



     	foreach($nutrition_logdata as $row)



		{



			$all_logdata=MJ_gmgt_get_nutritiondata($row->id);



			$arranged_workout=MJ_gmgt_set_nutrition_array($all_logdata);



			?>



			<div class="workout_<?php echo esc_attr($row->id);?> workout-block"><!--WORKOUT BLOCK DIV START-->



				<div class="panel-heading">



					<h3 class="panel-title"><i class="fa fa-calendar"></i> 



					<?php echo "Start From <span class='work_date'>".MJ_gmgt_getdate_in_input_box(esc_html($row->start_date))."</span> To <span class='work_date'>".MJ_gmgt_getdate_in_input_box(esc_html($row->expire_date)); ?>



					<?php



					if($user_access['delete']=='1')



					{



					?>		



						<span class="removenutrition badge badge-delete pull-right" id="<?php echo esc_attr($row->id);?>">X</span>



					<?php



					}



					?>



					</h3>						



				</div>



				<div class="panel-white"><!--PANEL WHITE DIV START-->



					<?php



					if(!empty($arranged_workout))



					{



					?>



					<div class="work_out_datalist_header">



						<div class="col-md-3">  



						<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>



						</div>



						<div class="col-md-9">



						<span class="col-md-6"><?php esc_html_e('Description','gym_mgt');?></span>



						</div>



					</div>



					<?php 



					foreach($arranged_workout as $key=>$rowdata)



					{?>



						<div class="work_out_datalist dis_flex">



							<div class="col-md-3 day_name">  



								<?php echo esc_html__($key,"gym_mgt");?>



							</div>



							<div class="col-md-9">



								<?php 



								foreach($rowdata as $row)



								{										



									echo $row."<br>";



								} 



								?>



							</div>



						</div>



				<?php } 



					}?>



				</div><!--PANEL WHITE DIV END-->



			</div><!--WORKOUT BLOCK DIV END-->



     	 <?php



		}	



	}



	?>



	</div><!-- TAB CONTENT DIV END -->



</div><!-- PANEL BODY DIV END -->