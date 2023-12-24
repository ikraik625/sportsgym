<?php ?>
<script type="text/javascript">



jQuery(document).ready(function($)



{



	"use strict";



	var date = new Date();



	date.setDate(date.getDate()-0);



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



	$('#curr_date').datepicker(



	{



		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



	 	<?php



		if(get_option('gym_enable_datepicker_privious_date')=='no')



		{



		?>



			minDate: 'today',



		<?php



		}



		?>	



	 	autoclose: true



   	});



    $('#record_date').datepicker(



    {



	 	dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



	 	<?php



		if(get_option('gym_enable_datepicker_privious_date')=='no')



		{



		?>



			minDate:'today',



		<?php



		}



		?>	



	 	autoclose: true



   	});



	$('#workout_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	$(".display-members").select2();



} );



</script>



<?php 	



if($active_tab == 'addworkout')



{



	$workoutmember_id=0;



	if(isset($_REQUEST['workoutmember_id']))



		$workoutmember_id=esc_attr($_REQUEST['workoutmember_id']);



		$view=0;



		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view')



		{



			$view=1;



			?>



			<form method="post" class="form-horizontal">  



				<div class="col-md-12">



					<h2><?php echo esc_html(MJ_gmgt_get_display_name($_REQUEST['workoutmember_id'])).'\'s '; ?> <?php esc_html_e('Workout','gym_mgt')?></h2>



				</div>



				<div class="form-body user_form"> <!-- user_form Strat-->   



					<div class="row"><!--Row Div Strat-->



						<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



							<div class="form-group input">



								<div class="col-md-12 form-control">



									<input id="curr_date" class="form-control" type="text" value="<?php if(isset($_POST['tcurr_date'])) echo esc_attr($_POST['tcurr_date']); else echo esc_attr(MJ_gmgt_getdate_in_input_box(date("Y-m-d")));?>"  name="tcurr_date" readonly>



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



						<div class="col-md-12 my-workouts-display float_left_res">



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



									<div class="col-md-12 workout_datalist no-padding dis_flex view_workout_background_color"> 



										<div class="col-md-3 sets-row div_padding_30">	



											<div class="workout_box row">



												<div class="gmgt-card-member-bg center col-md-3 margin_top_20px padding_0" id="card-sets-bg">



													<h2 class="activity_box_number"><?php echo 1 ;?></h2>



												</div>



												<div class="col-md-8 margin_top_10px padding_right_0">



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



										<div class="col-md-3 sets-row div_padding_30">	



											<div class="workout_box row">



												<div class="gmgt-card-member-bg center col-md-3 margin_top_20px padding_0" id="card-reps-bg">



													<h2 class="activity_box_number_reps activity_box_number"><?php echo 2 ;?></h2>



												</div>



												<div class="col-md-8 margin_top_10px padding_right_0">



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



										<div class="col-md-3 sets-row div_padding_30">	



											<div class="workout_box row">



												<div class="gmgt-card-member-bg center col-md-3 margin_top_20px padding_0" id="card-kg-bg">



													<h2 class="activity_box_number_kg activity_box_number"><?php echo 3 ;?></h2>



												</div>



												<div class="col-md-8 margin_top_10px padding_right_0">



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



										<div class="col-md-3 sets-row div_padding_30">	



											<div class="workout_box row">



												<div class="gmgt-card-member-bg center col-md-3 margin_top_20px padding_0" id="card-time-bg">



													<h2 class="activity_box_number_time activity_box_number"><?php echo 4 ;?></h2>



												</div>



												<div class="col-md-8 margin_top_10px padding_right_0">



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



			<div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->



				<form name="workout_form" action="" method="post" class="form-horizontal" id="workout_form"><!--WORKOUT FORM STRAT-->



					<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



					<input type="hidden" name="daily_workout_id" value="<?php echo esc_attr($workoutmember_id);?>"  />



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Workout Log Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat-->



							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<!-- <label class="ml-1 custom-top-label top" for="refered"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



								<?php if($view){ $member_id=$result->member_id; }elseif(isset($_POST['member_id'])){$member_id=sanitize_text_field($_POST['member_id']);}else{$member_id='';}?>



								<select name="member_id" class="form-control display-members max_width_100" id="member_list">



									<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



										<?php $get_members = array('role' => 'member');



										$membersdata=get_users($get_members);



										 if(!empty($membersdata))



										 {



											foreach ($membersdata as $member)



											{



												if( $member->membership_status == "Continue" && $member->member_type == "Member")



												{



												?>



												<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



											<?php



												}



											}



										 }?>



							    </select>



							</div>



							<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="record_date" class="form-control  validate[required] date_picker" type="text" userid="<?php echo get_current_user_id();?>"  name="record_date" value="<?php if($view){ echo esc_attr($result->record_date);}elseif(isset($_POST['record_date'])){ echo esc_attr($_POST['record_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>



										<label class="date_label" for="Description"><?php esc_html_e('Record Date','gym_mgt');?><span class="require-field">*</span></label>



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



							<div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 workout_area padding_0 res_margin_left_15px">



								<div class="form-group input">



									<div class='work_out_datalist'>



										<div class='col-sm-10'><span class='col-md-10'><?php esc_html_e('Select Record Date For Today Workout','gym_mgt');?></span></div>



									</div>



								</div>



							</div>



							



						</div>



					</div>



					<!------------   save btn  -------------->  



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">



								<input type="submit" value="<?php if($view){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_workout" class="save_member_validate btn save_btn	"/>



							</div>



						</div>



					</div>



				</form><!--WORKOUT FORM END-->



			</div><!--PANEL BODY DIV END-->



			<?php 



		}



}



?>