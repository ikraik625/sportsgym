<?php ?>



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

		minDate:0,

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



 	// $("#member_list").select2();



});



</script>



<?php 	



if($active_tab == 'addworkouttype')



{        	



	$workoutmember_id=0;



	$edit=0;



	if(isset($_REQUEST['workoutmember_id']))



	{



		$edit=1;



		$workoutmember_id=esc_attr($_REQUEST['workoutmember_id']);				



		$workout_logdata=MJ_gmgt_get_userworkout($workoutmember_id);



	}			



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$edit=1;



	} 



	?>



	<div class="col-md-12"><!--COL 12 DIV STRAT-->



		<div class=""><!--PANEL WHITE DIV STRAT-->



            <div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->



				<form name="workouttype_form" action="" method="post" class="form-horizontal" id="workouttype_form"><!--WORKOUT TYPE FORM STRAT-->



					<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



					<input type="hidden" name="assign_workout_id" value="" />



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Assign Workout Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat-->



							<div class="col-sm-10 col-md-4 col-lg-4 col-xl-4 input">



								<!-- <label class="ml-1 custom-top-label top" for="refered"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



								<?php if($edit){ $member_id=$workoutmember_id; }elseif(isset($_REQUEST['member_id'])){$member_id=sanitize_text_field($_REQUEST['member_id']);}else{$member_id='';}?>



								<select name="member_id" class="form-control display-members assigned_workout_member_id max_width_100" id="member_list" >



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



							<div class="col-sm-2 mb-3">



								<a href="?page=gmgt_member&tab=addmember" class="btn save_btn btn_line_height_33px"> <?php esc_html_e('Add Member','gym_mgt');?></a>



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



								<button id="addremove" model="level_type" class="btn save_btn"><?php esc_html_e('Add Or Remove','gym_mgt');?></button>



							</div>



							



							<?php wp_nonce_field( 'save_workouttype_nonce' ); ?>



							<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="start_date" class="form-control validate[required] date_picker" type="text"  name="start_date" value="<?php if(isset($_POST['start_date'])){ echo esc_attr($_POST['start_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>



										<label class="date_label" for="date"><?php esc_html_e('Start Date','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="end_date" class="form-control validate[required] date_picker" type="text"   name="last_date" value="<?php if(isset($_POST['end_date'])){ echo esc_attr($_POST['end_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>



										<label class="date_label" for="date"><?php esc_html_e('End Date','gym_mgt');?><span class="require-field">*</span></label>



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



							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 rtl_margin_top_15px">



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

										$('.Activity_category_autocompalte').autocomplete({

											source: json_obj[0]['post_title'],

											minLength: 0,

											scroll: true

										}).click(function() {

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

									<div class="col-md-12 form-control" style="display : none;">

										<div class="form-group col-sm-12 col-xs-12 has-search position_relative">

											<span class="fa fa-search form-control-feedback"></span><input type="text" class="form-control activity_category_input Activity_category_autocompalte min_height" placeholder="<?php esc_html_e('Search Activity Category','gym_mgt');?>" id="Activity_category_autocompalt" />

										</div>

									</div>

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



							<?php 



							if($user_access_add == '1')



							{



								?>



								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6 input" style="margin-top:15px;">



									<input type="button" value="<?php esc_html_e('Step-1 Add Workout','gym_mgt');?>" name="sadd_workouttype" id="add_workouttype" class="save_member_validate btn save_btn add_workouttype_val"/>



								</div>



								<div id="display_rout_list" class="rtl_margin_top_15px"></div>



								<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



									<input type="submit" value="<?php if($edit){ esc_html_e('Step-2 Save Workout','gym_mgt'); }else{ esc_html_e('Step-2 Save Workout','gym_mgt');}?>" name="save_workouttype" class="btn save_btn save_workouttype_btn"/>



								</div>



								<?php



							}



							?>



							



						</div>		



					</div>



				</form><!--WORKOUT TYPE FORM END-->



            </div><!--PANEL BODY DIV END-->



        </div>	<!--PANEL WHITE DIV END-->



		<?php



		if(isset($workout_logdata))



		foreach($workout_logdata as $row)



		{



			$all_logdata=MJ_gmgt_get_workoutdata($row->workout_id);



			$activity_category=MJ_gmgt_get_all_category('activity_category');



			foreach ($activity_category as $retrive_data)



			{



				



				$activitydata =MJ_gmgt_get_activity_by_category($retrive_data->ID);



				foreach($activitydata as $activity)



				{ 



					$activity_id[]=$activity->activity_id;



					



					$arranged_workout=MJ_gmgt_set_workoutarray_video($all_logdata,$activity->activity_id);



				}



			}	



			



			?>



			<div class="workout_<?php echo $row->workout_id;?> workout-block"><!--WORKOUT BLOCK DIV START-->



				<div class="panel-headingaa">



					<div class="row">



						<div class="col-sm-8 d-flex align-items-center">



							<h3 class="panel-title" style="line-height: 23px;"><i class="fa fa-calendar"></i>



							<?php 



							esc_html_e('Start From ','gym_mgt');



							echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->start_date)."</span>";



							esc_html_e(' To ','gym_mgt');



							echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->end_date)."</span> &nbsp;"; 



							if(!empty($row->description) && $row->description != ' ')



							{



								echo "<br>";



								esc_html_e(' Description :','gym_mgt');



								echo "<span class='work_date'>".$row->description."</span>";



								//esc_html_e(' )','gym_mgt');



							}



							?> 



							</h3>	



						</div>



						<div class="col-sm-4 row view_workout_btn_width_height" >



						   <?php 



							if($user_access_delete =='1')



							{ 



								?>



								<div class="col-md-6">



									<a class="removeworkout btn_margin_top_10px btn dlt_btn pull-right margin_left_10 mb_res_10px" id="<?php echo $row->workout_id;?>"><?php esc_html_e('Delete','gym_mgt');?></a>



								</div>



								<?php 



							}



							if($user_access_edit == '1')



                            {



								?>



								<div class="col-md-6">



									<a href="?page=gmgt_workouttype&tab=editworkouttype&action=edit&workoutmember_id=<?php echo $row->workout_id;?>" class="btn btn_margin_top_10px save_attendance_btn pull-right"> <?php esc_html_e('Edit','gym_mgt');?></a>



								</div>



								<?php 



							} ?>



						</div>					



					</div>					



				</div>



				<div class="panel-white"><!--PANEL WHITE DIV START-->



					<?php



					if(!empty($arranged_workout))



					{



						?>



						<div class="work_out_datalist_header">



						<div class="col-md-2 col-sm-2">  



						<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>



						</div>



						<div class="col-md-10 col-sm-10 hidden-xs dis_flex">



						<span class="col-md-2 margin_left_5_res"><?php esc_html_e('Activity','gym_mgt');?></span>



						<span class="col-md-2 margin_left_5_res"><?php esc_html_e('Sets','gym_mgt');?></span>



						<span class="col-md-2 margin_left_5_res"><?php esc_html_e('Reps','gym_mgt');?></span>



						<span class="col-md-2 margin_left_5_res"><?php esc_html_e('KG','gym_mgt');?></span>



						<span class="col-md-2 margin_left_5_res"><?php esc_html_e('Rest Time','gym_mgt');?></span>



						</div>



						</div>



						<?php 



						foreach($arranged_workout as $key=>$rowdata)



						{







							?>



							<div class="work_out_datalist dis_flex">



								<div class="col-md-2 day_name">  



									<?php



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



								</div>



								<div class="col-md-10 col-xs-12 ">



								<?php 



								foreach($rowdata as $row)



								{



									



									echo $row."<div class='clearfix'></div> <br>";



								}



								?>



								</div>



							</div>



					 <?php



						} 



					}?>



			   </div><!--PANEL WHITE DIV END-->



		   </div><!--WORKOUT BLOCK DIV END-->



		<?php   



		}	



}



?>