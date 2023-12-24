<?php ?>



<script type="text/javascript">



jQuery(document).ready(function($) 



{



	"use strict";



	$(".display-members").select2();



	$('#nutrition_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);	



	$(".start_date").datepicker(



	{



		<?php



		if(get_option('gym_enable_datepicker_privious_date')=='no')



		{



		?>



			minDate:'today',



		<?php



		}



		?>	



		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



		minDate:0,



		onSelect: function (selected)



		{



    		var dt = new Date(selected);



    		dt.setDate(dt.getDate() + 0);



    		$(".end_date").datepicker("option", "minDate", dt);



    	}



    });



    $(".end_date").datepicker(



    {



		<?php



		if(get_option('gym_enable_datepicker_privious_date')=='no')



		{



		?>



			minDate:'today',



		<?php



		}



		?>	



       	dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



        onSelect: function (selected) 



        {



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

	// $(".save_nutration_btn").on('click',function()

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

} );



</script>



<?php 	



if($active_tab == 'addnutrition')



{



	$nutrition_id=0;



	$edit=0;



	$member_id=0;



	if(isset($_REQUEST['workoutmember_id']))



	{



		$edit=1;



		$workoutmember_id=esc_attr($_REQUEST['workoutmember_id']);			



		$nutrition_logdata=MJ_gmgt_get_user_nutrition($workoutmember_id);			



	}



	?>



        <div class="panel-body padding_0"><!--PANEL BODY DIV START-->



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



							<!-- <label class="ml-1 custom-top-label top" for="refered"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



							<?php if($edit){ $member_id=$workoutmember_id; }elseif(isset($_REQUEST['member_id'])){$member_id=sanitize_text_field($_REQUEST['member_id']);}else{$member_id='';}?>



							<select id="member_list" class="form-control display-members" name="member_id" required="true">



								<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



									<?php $get_members = array('role' => 'member');



									$membersdata=get_users($get_members);



									if(!empty($membersdata))



									{



										foreach ($membersdata as $member)



										{



											if( $member->membership_status == "Continue"  && $member->member_type == "Member")



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



								<input id="Start_date" class="start_date form-control validate[required] text-input date_picker" type="text" value="<?php if(isset($_POST['start_date'])){echo esc_attr($_POST['start_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" name="start_date" readonly>



									<label class="date_label" for="date"><?php esc_html_e('Start Date','gym_mgt');?><span class="require-field">*</span></label>



								</div>



							</div>



						</div>



						<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



							<div class="form-group input">



								<div class="col-md-12 form-control">



								<input id="end_date" class="form-control validate[required] text-input end_date date_picker"  type="text" value="<?php if(isset($_POST['end_date'])){echo $_POST['end_date'];}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" name="end_date" readonly>



									<label class="date_label" for="date"><?php esc_html_e('End Date','gym_mgt');?><span class="require-field">*</span></label>



								</div>



							</div>



						</div>



						<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 rtl_margin_top_15px">



							<div class="form-group">



								<div class="col-md-12 form-control">



									<div class="row padding_radio">



										<div class="checkbox check_day">



											<label class="custom-top-label" for="member_convert"><?php esc_html_e('Select Days','gym_mgt');?><span class="require-field">*</span></label>



											<?php



											foreach (MJ_gmgt_days_array() as $key=>$name)



											{



												?>

											<label class="day_margin">

												<input type="checkbox" class="check_day" value="" name="day[]" value="<?php echo esc_attr($key);?>" id="<?php echo esc_attr($key);?>" data-val="day"><span class="margin_right_50px" id="<?php echo "lebal_".$key;?>"><?php echo esc_html($name); ?></span>

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



									<input id="" class="form-control " maxlength="150" type="text" name="" placeholder="<?php esc_html_e('Nutrition Details','gym_mgt'); ?>*" value="" disabled>



								</div>



								<div class="col-md-12 form-control title_background_color div_padding_bottom_0px">



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('BreakFast Nutrition','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;" type="checkbox" value="" name="avtivity_id[]" value="breakfast" class="nutrition_check" id="breakfast"  activity_title = "" data-val="nutrition_time"><?php esc_html_e('Break Fast','gym_mgt');?>



										</div>



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_breakfast"></div>



										</div>



									</div>



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Mid Morning Snacks Nutrition','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;" type="checkbox" value="" name="avtivity_id[]" value="midmorning_snack" class="nutrition_check" id="midmorning_snack"  activity_title = "" data-val="nutrition_time"><?php esc_html_e('Mid Morning Snacks','gym_mgt');?>



										</div>



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_midmorning_snack"></div>



										</div>



									</div>



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Lunch Nutrition','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;" type="checkbox" value="" name="avtivity_id[]" value="lunch" class="nutrition_check" id="lunch" activity_title = "" data-val="nutrition_time"><?php esc_html_e('Lunch','gym_mgt');?>



										</div>



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_lunch"></div>



										</div>



									</div>



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Afternoon Snacks Nutrition','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;" type="checkbox" value="" name="avtivity_id[]" value="afternoon_snack" class="nutrition_check" id="afternoon_snack"  activity_title = "" data-val="nutrition_time"><?php esc_html_e('Afternoon Snacks','gym_mgt');?>



										</div>



										<div class="col-md-9 textarea_height_and_margin">



											<div id="txt_afternoon_snack"></div>



										</div>



									</div>



									<div class="header workout_detail_title_span">	



										<h3 class="first_hed_activity first_hed"><?php esc_html_e('Dinner Nutrition','gym_mgt'); ?></h3>



									</div>



									<div class="row activity_background_white">



										<div class="col-md-3 d-flex align-items-center padding_10px">



											<input style="position: relative;opacity: 1;" type="checkbox" value="" name="avtivity_id[]" value="dinner" class="nutrition_check" id="dinner"  activity_title = "" data-val="nutrition_time"><?php esc_html_e('Dinner','gym_mgt');?>



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



						<?php 



						if($user_access_add == '1')



						{



							?>



							<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6" style="margin-top:15px;">



								<input type="button" value="<?php esc_html_e('Step-1 Add Nutrition','gym_mgt');?>" name="save_nutrition" id="add_nutrition" class="btn save_member_validate add_nutrition_day save_btn add_nutrition_val"/>



							</div>



							<?php



						}



						?>



						<div id="display_nutrition_list" class="clear_both" style="margin-top:15px;"></div>



						<div class="clear"></div>



						<?php 



						if($user_access_add == '1')



						{



							?>



							<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6 input" style="margin-top:15px;">



								<input type="submit" value="<?php if($edit){ esc_html_e('Step 2 Save Nutrition Plan','gym_mgt'); }else{ esc_html_e('Step 2 Save Nutrition Plan','gym_mgt');}?>" name="save_nutrition" class="btn save_btn save_nutration_btn"/>



							</div>



							<?php



						}



						?>



					</div>		



				</div>



			</form><!--Nutrition FORM END-->



        </div><!--PANEL BODY DIV END-->



<?php 



}



if(isset($nutrition_logdata))



foreach($nutrition_logdata as $row)



{



	$all_logdata=MJ_gmgt_get_nutritiondata($row->id); 



	$arranged_workout=MJ_gmgt_set_nutrition_array($all_logdata);



	?>



		<div class="workout_<?php echo $row->id;?> workout-block"><!--WORKOUT BLOCK DIV START-->



			<div class="panel-heading nutartion_plan_res row">



				<div class="col-md-10 width_80px_res">



					<h3 class="panel-title"><i class="fa fa-calendar"></i> 



					<?php



						esc_html_e('Start From ','gym_mgt');



						echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box(esc_html($row->start_date))."</span>";



						esc_html_e(' To ','gym_mgt');



						echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box(esc_html($row->expire_date)); 



					?>



					</h3>



				</div>



				<div class='col-md-2 width_20px_res'>



					<?php 



					if($user_access_delete =='1')



					{ 



						?>



						<div class="col-md-6" style="float: right;margin-bottom:5px;">



							<a class="removenutrition btn_margin_top_10px btn dlt_btn pull-right margin_left_10 mb_res_10px" id="<?php echo $row->id;?>"><?php esc_html_e('Delete','gym_mgt');?></a>



						</div>



						



						<!-- <span class="removenutrition badge badge-delete pull-right" id="<?php echo $row->id;?>">X</span> -->



						<?php 



					} ?>	



				</div>			



			</div>



			<div class="panel-white"><!--PANEL WHITE DIV START-->



				<?php



				if(!empty($arranged_workout))



				{



					?>



					<div class="work_out_datalist_header">



						<div class="col-md-3 col-sm-3 col-xs-3">  



							<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>



						</div>



						<div class="col-md-9 col-sm-9 col-xs-9">



							<span class="col-md-6"><?php esc_html_e('Description','gym_mgt');?></span>



						</div>



					</div>



					<?php 



					foreach($arranged_workout as $key=>$rowdata)



					{



						?>



						<div class="work_out_datalist dis_flex rtl_margin_top_15px">



							<div class="col-md-3 col-sm-3 col-xs-12 day_name">  



								<?php 



								//echo esc_html($key);



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



			</div><!--PANEL WHITE DIV END-->



		</div><!--WORKOUT BLOCK DIV END-->



<?php



}	



?>