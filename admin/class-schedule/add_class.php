<script type="text/javascript">



$(document).ready(function() 



{



	"use strict";



	$('#group_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	$('#add_staff_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



	$('#day').multiselect(



	{



		nonSelectedText :'<?php esc_html_e('Select Day','gym_mgt');?>',



		includeSelectAllOption: true,



		allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



	    selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



		templates: {



	            button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



	        },



		buttonContainer: '<div class="dropdown" />'



	});	



	$('#specialization').multiselect(



	{



		nonSelectedText :'<?php esc_html_e('Select Specialization','gym_mgt');?>',



		includeSelectAllOption: true,



		allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



	    selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



		templates: {



	            button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



	        },



		buttonContainer: '<div class="dropdown" />'



	});	



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



	



	$(".day_validation_submit").on('click',function()



	{



		checked = $(".day_validation .dropdown-menu input:checked").length;



		if(!checked)



		{



			alert("<?php esc_html_e('Please select Atleast One Day.','gym_mgt');?>");



			return false;



		}



	});



	$(".day_validation_submit").on('click',function()



	{



	  	checked = $(".multiselect_validation_membership .dropdown-menu input:checked").length;



		if(!checked)



		{



		  	alert("<?php esc_html_e('Please select Atleast One membership.','gym_mgt');?>");



		  	return false;



		}



	});



	$(".specialization_submit").on('click',function()



	{



	  	checked = $(".multiselect_validation_specialization .dropdown-menu input:checked").length;



		if(!checked)



		{



	  		alert("<?php esc_html_e('Please Select Atleast one specialization.','gym_mgt');?>");



	  		return false;



		}



	});



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



	var date = new Date();



	date.setDate(date.getDate()-0);



	$('.class_date').datepicker({



		<?php



		if(get_option('gym_enable_datepicker_privious_date')=='no')

		{

		?>

			minDate:'today',



			startDate: date,

		<?php

		}

		?>

	dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



	autoclose: true



	});



	jQuery('.birth_date').datepicker(



	{



		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



		maxDate : 0,



		changeMonth: true,



        changeYear: true,



        yearRange:'-65:+25',



		beforeShow: function (textbox, instance) 



		{



			instance.dpDiv.css(



			{



				marginTop: (-textbox.offsetHeight) + 'px'                   



			});



		},    



        onChangeMonthYear: function(year, month, inst) {



            jQuery(this).val(month + "/" + year);



        }                    



	});



	//------ADD STAFF MEMBER AJAX----------



	$('#add_staff_form').on('submit', function(e)



	{



		e.preventDefault();



		var form = $(this).serialize();



		var valid = $('#add_staff_form').validationEngine('validate');



		if (valid == true) {



			$('.modal').modal('hide');



		}



		$.ajax({



			type:"POST",



			url: $(this).attr('action'),



			data:form,



			success: function(data)



			{					



				if(data!="")



				{ 



					$('#add_staff_form').trigger("reset");



					$('#staff_id').append(data);

member_type

				}



			},



			error: function(data)



			{



			}



		})



	});



} );



</script>



<?php



if($active_tab == 'addclass')



{



	$class_id=0;



	if(isset($_REQUEST['class_id']))



	{



		$class_id=esc_attr($_REQUEST['class_id']);



	}



	$edit=0;



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$edit=1;



		$result = $obj_class->MJ_gmgt_get_single_class($class_id);



	}



	?>		

	<script type="text/javascript">

	jQuery(document).ready(function($)

	{

		$(".create_virtual_classroom").click(function () 

		{

			var value = $('input:checkbox[name=create_virtual_classroom]').is(':checked');

			if(value == true)

			{

				$(".create_virtual_classroom_div").addClass("create_virtual_classroom_div_block");  

				$(".create_virtual_classroom_div").removeClass("create_virtual_classroom_div_none");  

			}

			else

			{

				$(".create_virtual_classroom_div").addClass("create_virtual_classroom_div_none");

				$(".create_virtual_classroom_div").removeClass("create_virtual_classroom_div_block");

			}

		});

		$("#start_date_new").datepicker(

		{

	        dateFormat: "yy-mm-dd",

			minDate:0,

	        onSelect: function (selected) {

	            var dt = new Date(selected);

	            dt.setDate(dt.getDate() + 0);

	            $("#end_date").datepicker("option", "minDate", dt);

	        }

	    });

	    $("#end_date_new").datepicker(

		{

	       dateFormat: "yy-mm-dd",

		   minDate:0,

	        onSelect: function (selected) {

	            var dt = new Date(selected);

	            dt.setDate(dt.getDate() + 0);

	            $("#start_date").datepicker("option", "maxDate", dt);

	        }

	    });

		



		// $(".end_ampm").click(function () 

		// {

		// 	var start_time = $('.start_time').val();

		// 	var start_min = $('.start_min').val();

		// 	var start_ampm = $('.start_ampm').val();



		// 	var end_time = $('.end_time').val();

		// 	var end_min = $('.end_min').val();

		// 	var	end_ampm = $('.end_ampm').val();

		

		// 	if(start_time == end_time && start_min == end_min && start_ampm == end_ampm)

		// 	{

		// 		alert("You can't select same time of Start time and End time.");

		// 	}

		// });

	});

	</script>

    <div class="panel-body padding_0"><!-- PANEL BODY DIV START-->



        <form name="group_form" action="" method="post" class="form-horizontal" id="group_form"><!-- CLASS FORM START-->



			 <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



			<input type="hidden" name="class_id" value="<?php echo esc_attr($class_id);?>" />







			<div class="header">	



				<h3 class="first_hed"><?php esc_html_e('Class Information','gym_mgt');?></h3>



			</div>



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="group_name" class="form-control validate[required,custom[popup_category_validation]]  text-input" type="text" maxlength="50" value="<?php if($edit){ echo esc_attr($result->class_name);}elseif(isset($_POST['class_name'])) echo esc_attr($_POST['class_name']);?>" name="class_name">



								<label class="" for="class_name"><?php esc_html_e('Class Name','gym_mgt');?><span class="require-field">*</span></label>



							</div>



						</div>



					</div>



					<!--nonce-->



					<?php wp_nonce_field( 'save_class_nonce' ); ?>



					<!--nonce-->







					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">



						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>



						<?php 



						$get_staff = array('role' => 'Staff_member');



						$staffdata=get_users($get_staff);?>



						<select name="staff_id" class="form-control validate[required] max_width_100" id="staff_id">



							<option value=""><?php esc_html_e('Select Staff Member ','gym_mgt');?></option>



							<?php



							if($edit)



							{



								$staff_data=$result->staff_id;



							}



							elseif(isset($_POST['staff_id']))



							{



								$staff_data=sanitize_text_field($_POST['staff_id']);



							}



							else



							{



								$staff_data="";



							}



							if(!empty($staffdata))



							{



								foreach($staffdata as $staff)



								{



									$role_title="";



									$postdata=get_post($staff->role_type);



									if(isset($postdata))



										$role_title=$postdata->post_title;



									



									echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).' ('.esc_html($role_title).') </option>';



								}



							}



							?>



						</select>



					</div>



					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">					



						<button type="button" class="btn add_btn" data-bs-toggle="modal" data-bs-target="#myModal_add_staff_member"> <?php esc_html_e('Add','gym_mgt');?></button>			



					</div>



					



					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">



						<label class="ml-1 custom-top-label top" for="middle_name"><?php esc_html_e('Select Assistant Staff Member','gym_mgt');?></label>



						<?php 



						$get_staff = array('role' => 'Staff_member');



						$staffdata=get_users($get_staff);?>



						<select name="asst_staff_id" class="form-control max_width_100" id="asst_staff_id">



							<option value=""><?php esc_html_e('Select Assistant Staff Member ','gym_mgt');?></option>



							<?php if($edit)



							{



								$assi_staff_data=$result->asst_staff_id;



							}



							elseif(isset($_POST['asst_staff_id']))



							{



								$assi_staff_data=sanitize_text_field($_POST['asst_staff_id']);



							}



							else



							{



								$assi_staff_data="";



							}



							if(!empty($staffdata))



							{



								foreach($staffdata as $staff)



								{



									$role_title="";



									$postdata=get_post($staff->role_type);



									if(isset($postdata))



									{



										$role_title=$postdata->post_title;



										echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($assi_staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).' ('.esc_html($role_title).')</option>';



									}



								}



							}



							?>



						</select>



					</div>



					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">			



						<button type="button" class="btn add_btn" data-bs-toggle="modal" data-bs-target="#myModal_add_staff_member"> <?php esc_html_e('Add','gym_mgt');?></button>



					</div>







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_member gmgt_day_validation_top smgt_multiple_select">



						<!-- <label class="col-sm-2 control-label form-label" for="day"><?php esc_html_e('Select Day','gym_mgt');?><span class="require-field">*</span></label> -->



						<select class="form-control validate[required]"  name="day[]" id="day"  multiple="multiple">



							<?php



							$class_days=array();



							if($edit)



							{



								$class_days=json_decode($result->day);



							}



							foreach (MJ_gmgt_days_array() as $key=>$day)



							{



								$selected = "";



								if(in_array($key,$class_days))



									$selected = "selected";



								echo '<option value="'.esc_attr($key).'"'.esc_attr($selected).'>'.esc_html($day).'</option>';



							}



							?>



						</select>



					</div>







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="class_date"  class="form-control class_date validate[required] date_picker" type="text"  



								value="<?php if($edit){ echo MJ_gmgt_getdate_in_input_box($result->start_date);}elseif(isset($_POST['start_date'])){ echo esc_attr($_POST['start_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));}?>" name="start_date">



								<label class="date_label" for="invoice_date"><?php esc_html_e('Start Date','gym_mgt');?><span class="require-field">*</span></label>                                  



							</div>



						</div>



					</div>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="end_date"  class="form-control class_date validate[required] date_picker" type="text" value="<?php if($edit){ echo MJ_gmgt_getdate_in_input_box($result->end_date);}elseif(isset($_POST['end_date'])){ echo esc_attr($_POST['end_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));}?>" name="end_date">



								<label class="date_label" for="End"><?php esc_html_e('End Date','gym_mgt');?><span class="text-danger"> *</span></label>



							</div>



						</div>



					</div>







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px gmgt_day_validation_top res_margin_bottom_20px multiselect_validation_membership smgt_multiple_select">



						<!-- <label class="col-sm-2 control-label form-label" for="day"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label> -->



						<select class="form-control validate[required]"  name="membership_id[]" id="membership_id"  multiple="multiple">



							<?php 



							$membersdata=array();



							$data=array();



							if($edit)



							{



								$membersdata = $obj_class->MJ_gmgt_get_class_members($class_id);



								foreach($membersdata as $key=>$val)





									$data[]= $val->membership_id;



								}



							}



							?>



							<?php $membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>



							<?php



							if (!empty($membershipdata)) 



							{



								foreach ($membershipdata as $membership)



								{



									$selected = "";



									if(in_array($membership->membership_id,$data))



										$selected = "selected";



									echo '<option value="'.esc_attr($membership->membership_id).'"'.esc_attr($selected).'>'.esc_html($membership->membership_label).'</option>';



								}



							}



							?>



						</select>	



					</div>



					



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input  class="form-control validate[required] text-input" min="0" onkeypress="if(this.value.length==3) return false;" type="number" value="<?php if($edit){ echo esc_attr($result->member_limit);}elseif(isset($_POST['member_limit'])) echo esc_attr($_POST['member_limit']);?>" name="member_limit">



								<label class="" for="quentity"><?php esc_html_e('Member Limit','gym_mgt');?><span class="require-field">*</span></label>



							</div>



						</div>



					</div>







					<?php	



					if($edit)



					{



						?>



						<div class="mb-3 row">



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



								<label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label>



								<?php 



								if($edit)



								{



									$start_time_data = explode(":", $result->start_time);



								



								}



								?>



								<select name="start_time" class="form-control validate[required] start_time">



									<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



									<?php 



										for($i =1 ; $i <= 12 ; $i++)



										{



											?>



											<option value="<?php echo esc_attr($i);?>" <?php  if($edit) selected(esc_attr($start_time_data[0]),esc_attr($i));  ?>><?php echo esc_html($i);?></option>



											<?php



										}



										?>



								</select>



							</div>



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



								<select name="start_min" class="form-control validate[required]">



									<?php 



									foreach(MJ_gmgt_minute_array() as $key=>$value)



									{?>



										<option value="<?php echo esc_attr($key);?>" <?php  if($edit) selected(esc_attr($start_time_data[1]),esc_attr($key));  ?>><?php echo esc_html($value);?></option>



									<?php



									}



									?>



								</select>



							</div>



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



								<select name="start_ampm" class="form-control validate[required]">



									<option value="am" <?php  if($edit) if(isset($start_time_data[2])) selected(esc_attr($start_time_data[2]),'am');  ?>><?php esc_html_e('am','gym_mgt');?></option>



									<option value="pm" <?php  if($edit) if(isset($start_time_data[2])) selected(esc_attr($start_time_data[2]),'pm');  ?>><?php esc_html_e('pm','gym_mgt');?></option>



								</select>



							</div>



						</div>



						<div class="mb-3 row">



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



								<label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label>



								<?php 



								if($edit)



								{



									$end_time_data = explode(":", $result->end_time);



								}



								?>



								<select name="end_time" class="form-control validate[required] end_time">



									<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



									<?php 



										for($i =1 ; $i <= 12 ; $i++)



										{



										?>



											<option value="<?php echo esc_attr($i);?>" <?php  if($edit) selected(esc_attr($end_time_data[0]),esc_attr($i));  ?>><?php echo esc_html($i);?></option>



										<?php



										}



									?>



								</select>



							</div>



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



								<select name="end_min" class="form-control validate[required]">



									<?php 



									foreach(MJ_gmgt_minute_array() as $key=>$value)



									{



									?>



										<option value="<?php echo esc_attr($key);?>" <?php  if($edit) selected(esc_attr($end_time_data[1]),esc_attr($key));  ?>><?php echo esc_html($value);?></option>



									<?php



									}



									?>



								</select>



							</div>



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">	



								<select name="end_ampm" class="form-control validate[required]">				



									<option value="am" <?php  if($edit) if(isset($end_time_data[2])) selected(esc_attr($end_time_data[2]),'am'); ?>><?php esc_html_e('am','gym_mgt');?></option>



									<option value="pm" <?php  if($edit) if(isset($end_time_data[2])) selected(esc_attr($end_time_data[2]),'pm');  ?>><?php esc_html_e('pm','gym_mgt');?></option>	



								</select>



							</div>	



						</div>	



						<?php



					}



					else



					{



						?>



							<div class="add_more_time_entry">



								<div class="time_entry">



									<div class="mb-3 row">



										<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



											<label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label>



											<select name="start_time[]" class="form-control validate[required] max_width_100 start_time">



												<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



													<?php 



													for($i =1 ; $i <= 12 ; $i++)



													{



													?>



														<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>



													<?php



													}



													?>



											</select>



										</div>



										<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input">



											<select name="start_min[]" class="form-control validate[required] margin_top_10_res start_min">



												<?php 



												foreach(MJ_gmgt_minute_array() as $key=>$value)



												{?>



													<option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option>



												<?php



												}



												?>



											</select>



										</div>



										<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input width_102">



											<select name="start_ampm[]" class="form-control validate[required] margin_top_10_res start_ampm">



												<option value="am"><?php esc_html_e('am','gym_mgt');?></option>



												<option value="pm"><?php esc_html_e('pm','gym_mgt');?></option>



											</select>



										</div>



									</div>



									



									<div class="mb-3 row">



										<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



											<label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label>



											<select name="end_time[]" class="form-control validate[required] end_time">



												<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



													<?php 



														for($i =1 ; $i <= 12 ; $i++)



														{



														?>



															<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>



														<?php



														}



													?>



											</select>



										</div>



										<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input">



											<select name="end_min[]" class="form-control validate[required] margin_top_10_res end_min">



												<?php 



												foreach(MJ_gmgt_minute_array() as $key=>$value)



												{



												?>



													<option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option>



												<?php



												}



												?>



											</select>



										</div>

 

										<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input width_102">	



											<select name="end_ampm[]" class="form-control validate[required] margin_top_10_res end_ampm">



												<option value="am"><?php esc_html_e('am','gym_mgt');?></option>



												<option value="pm"><?php esc_html_e('pm','gym_mgt');?></option>



											</select>



										</div>	



										<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>"  id="add_new_entry" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr">



										</div>



									</div>



									<hr>



									<!-- <div class="mb-3 row">



										<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



											<hr>



										</div>



									</div> -->



								</div>



							</div>







						<?php



					}



					?>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



						<div class="form-group">



							<div class="col-md-12 form-control input_color_height">



								<div class="">



									<label class="custom-top-label" for="quentity"><?php esc_html_e('Class Color','gym_mgt');?></label>



									<input type="color" value="<?php if($edit){ echo esc_attr($result->color);}elseif(isset($_POST['class_color'])) echo esc_attr($_POST['class_color']);?>" name="class_color" >



								</div>



							</div>



						</div>



					</div>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px">



						<div class="form-group">



							<div class="col-md-12 form-control">



								<div class="row padding_radio">



									<div class="">



										<label class="custom-top-label" for="gmgt_membershipimage"><?php esc_html_e('Frontend Class Booking','gym_mgt');?></label>



										<input type="checkbox" class="check_box_input_margin"  name="gmgt_class_book_approve" value="yes" <?php if($edit){ if($result->gmgt_class_book_approve == 'yes') { echo 'checked'; } }?> /> <?php esc_html_e('Enable','gym_mgt'); ?>



									</div>



								</div>



							</div>



						</div>



					</div>







				</div><!--Row Div End--> 



			</div><!-- user_form End-->   

			<?php 

			if(get_option('gmgt_enable_virtual_classschedule') == "yes")

			{

				if(!$edit)

				{ 

					?>

					<!-- Create Virtual Classroom --> 

					<div class="form-body user_form">

						<div class="row">

							<div class="col-md-6 rtl_margin_top_15px">

								<div class="form-group">

									<div class="col-md-12 form-control input_height_50px">

										<div class="row padding_radio">

											<div class="input-group input_checkbox">

												<label class="custom-top-label"><?php esc_html_e('Create Virtual Class','gym_mgt');?></label>													

												<div class="checkbox checkbox_lebal_padding_8px">

													<label>

														<input type="checkbox" id="isCheck" class="margin_right_checkbox_css create_virtual_classroom" name="create_virtual_classroom"  value="1" />&nbsp;&nbsp;<?php esc_attr_e('Enable','gym_mgt');?>

													</label>

												</div>

											</div>

										</div>												

									</div>

								</div>

							</div>

						</div>

					</div>

					<div class="form-body user_form create_virtual_classroom_div create_virtual_classroom_div_none margin_top_15px">

						<div class="row">

							<div class="col-md-6">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input class="form-control validate[custom[address_description_validation]]" type="text" name="agenda" value="">

										<label for="userinput1" class=""><?php esc_html_e('Topic','gym_mgt');?></label>

									</div>

								</div>

							</div>

							<div class="col-md-6">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input class="form-control text-input" type="password" name="password" value="">

										<label for="userinput1" class=""><?php esc_html_e('Password','gym_mgt');?></label>

									</div>

								</div>

							</div>

						</div>

					</div>

					<?php 

				}

			}

			?>



			<div class="form-body user_form">



				<div class="row">



					<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><!--save btn--> 



						<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_class" class="btn save_btn day_validation_submit"/>



					</div>



				</div><!--Row Div End--> 



			</div><!-- user_form End-->



        </form><!-- CLASS FORM END-->



    </div><!-- PANEL BODY DIV END-->



	<script>		



	function add_entry()



	{



		// ADD ENTRY 



		$(".add_more_time_entry").append('<div class="time_entry"><div class="form-group"><div class="mb-3 row"><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label><select name="start_time[]" class="form-control validate[required] max_width_100"><option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>  <?php for($i =0 ; $i <= 12 ; $i++) { ?> <option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option> <?php } ?></select></div><div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input"><select name="start_min[]" class="form-control validate[required] margin_top_10_res"> <?php foreach(MJ_gmgt_minute_array() as $key=>$value){ ?> <option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option><?php }?></select></div><div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input width_102"><select name="start_ampm[]" class="form-control validate[required] margin_top_10_res"><option value="am"><?php esc_html_e('am','gym_mgt');?></option><option value="pm"><?php esc_html_e('pm','gym_mgt');?></option></select></div></div></div><div class="form-group"><div class="mb-3 row"><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label><select name="end_time[]" class="form-control validate[required]"><option value=""><?php esc_html_e('Select Time','gym_mgt');?></option> <?php for($i =0 ; $i <= 12 ; $i++){ ?><option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option><?php } ?></select></div><div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input"><select name="end_min[]" class="form-control validate[required] margin_top_10_res"><?php foreach(MJ_gmgt_minute_array() as $key=>$value) { ?><option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option><?php } ?></select></div><div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input width_102"><select name="end_ampm[]" class="form-control validate[required] margin_top_10_res"><option value="am"><?php esc_html_e('am','gym_mgt');?></option><option value="pm"><?php esc_html_e('pm','gym_mgt');?></option></select></div><div class="col-sm-1 symptoms_deopdown_div rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""> </div></div><hr></div></div>');			



	}



	// REMOVING ENTRY



	function deleteParentElement(n)



	{



		alert("<?php esc_html_e('Do you really want to delete this time Slots?','gym_mgt');?>");



		n.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode.parentNode.parentNode);



	}



	</script>



<?php






?>



<!----------ADD STAFF MEMBER POPUP------------->



<style type="text/css">



	.dropdown .multiselect {



    min-width: 50%;



}



</style>



<div class="modal fade" id="myModal_add_staff_member" tabindex="-1" aria-labelledby="myModal_add_staff_member" aria-hidden="true" role="dialog"><!-- MODAL MAIN DIV START-->



    <div class="modal-dialog modal-lg"><!-- MODAL DIALOG DIV START-->



		<div class="modal-content float_and_width"><!-- MODAL CONTENT DIV START-->



			<div class="modal-header float_left_width_100 mb-3 pop_btn_bg">



				<h3 class="modal-title float_left"><?php esc_html_e('Add Staff Member','gym_mgt');?></h3>



				<button type="button" class="close float_right" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></button>



			</div>







			<div class="modal-body float_and_width"><!-- MODAL BODY DIV START-->



				<form name="staff_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal float_and_width" id="add_staff_form" enctype="multipart/form-data">	<!-- Staff MEMBER FORM START-->



					<?php



					$user_info="";



					 $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="MJ_gmgt_add_staff_member">



					<input type="hidden" name="role" value="staff_member" />



					<input type="hidden" name="user_id" value="<?php echo esc_attr($staff_member_id);?>"  />



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Personal Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat-->



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input"  maxlength="50" type="text" value="<?php if(isset($_POST['first_name'])) echo esc_attr($_POST['first_name']);?>" name="first_name" >



										<label class="" for="first_name"><?php esc_html_e('First Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="middle_name" class="form-control validate[custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if(isset($_POST['middle_name'])) echo esc_attr($_POST['middle_name']);?>" name="middle_name" >



										<label class="" for="middle_name"><?php esc_html_e('Member Type','gym_mgt');?></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="last_name" class="form-control validate[custom[onlyLetter_specialcharacter]] text-input"  maxlength="50" text-input="" type="text" value="<?php if(isset($_POST['last_name'])) echo esc_attr($_POST['last_name']);?>" name="last_name" >



										<label class="" for="last_name"><?php esc_html_e('Last Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



								<div class="form-group">



									<div class="col-md-12 form-control">



										<div class="row padding_radio">



											<div class="input-group">



												<label class="custom-top-label" for="gender"><?php esc_html_e('Gender','gym_mgt');?><span class="require-field">*</span></label>



												<div class="col-sm-7 marign_left_20_res">



													<?php $genderval = "male"; if(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>



													<label class="radio-inline custom_radio">



														<input type="radio" value="male" class="tog" name="gender" <?php checked( 'male', esc_html($genderval)); ?> /><?php esc_html_e('Male','gym_mgt');?>



													</label>



													<label class="radio-inline custom_radio">



														<input type="radio" value="female" class="tog" name="gender" <?php checked( 'female', esc_html($genderval)); ?>/><?php esc_html_e('Female','gym_mgt');?>



													</label>



												</div>



											</div>



										</div>



									</div>		



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input  class="form-control validate[required] birth_date" type="text"  name="birth_date" value="<?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); ?>"  readonly>



										<label class="date_of_birth_label" for="birth_date"><?php esc_html_e('Date of Birth','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">



								<label class="ml-1 custom-top-label top" for="role_type"><?php esc_html_e('Assign Role','gym_mgt');?><span class="require-field">*</span></label>



								<select class="form-control" name="role_type" id="role_type" >



									<option value=""><?php esc_html_e('Select Role','gym_mgt');?></option>



									<?php



									if(isset($_REQUEST['role_type']))



									{



										$category =esc_attr($_REQUEST['role_type']);  



									}



									else



									{ 



										$category = "";



									}



									$role_type=MJ_gmgt_get_all_category('role_type');



									if(!empty($role_type))



									{



										foreach ($role_type as $retrive_data)



										{



											echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';



										}



									}



									?>



								</select>



							</div>	



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3 rtl_margin_top_15px">	



								<button id="addremove" model="role_type" class="add_btn"><?php esc_html_e('Add','gym_mgt');?></button>



							</div>







							<div class="rtl_margin_top_15px col-sm-12 col-md-4 col-lg-4 col-xl-4 res_margin_bottom_20px multiselect_validation_specialization smgt_multiple_select">



								<select class="form-control"  name="activity_category[]" id="specialization"  multiple="multiple" >



									<?php 



									if(isset($_REQUEST['activity_category']))



									{



										$category =esc_attr($_REQUEST['activity_category']);  



									}



									else



									{ 



										$category = array();



									}



									$activity_category=MJ_gmgt_get_all_category('activity_category');



									if(!empty($activity_category))



									{



										foreach ($activity_category as $retrive_data)



										{



											$selected = "";



											if(in_array($retrive_data->ID,$category))



												$selected = "selected";



											echo '<option value="'.esc_attr($retrive_data->ID).'"'.esc_attr($selected).'>'.esc_attr($retrive_data->post_title).'</option>';



										}



									}



									?>



								</select>								



							</div>	



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 res_margin_bottom_20px rtl_margin_top_15px">



								<button id="addremove" model="activity_category" class="add_btn"><?php esc_html_e('Add','gym_mgt');?></button>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End-->







					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Login Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text" name="email" value="<?php if(isset($_POST['email'])) echo esc_attr($_POST['email']);?>" >



										<label class="" for="email"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?> space_validation" minlength="8" maxlength="12" type="password" name="password" value="" >



										<label class="" for="password"><?php esc_html_e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>



									</div>



								</div>



							</div>



							<div class="col-md-6">



								<div class="row">



									<div class="col-md-5">



										<div class="form-group input margin_bottom_0">



											<div class="col-md-12 form-control">



												<input type="text" readonly value="+<?php echo esc_attr(MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry')));?>"  class="form-control" name="phonecode">



												<label for="phonecode" class="pl-2 popup_countery_code_css"><?php esc_html_e('Country Code','gym_mgt');?><span class="required red">*</span></label>



											</div>											



										</div>



									</div>



									<div class="col-md-7">



										<div class="form-group input margin_bottom_0">



											<div class="col-md-12 form-control">



												<input id="mobile" class="form-control margin_top_10_res validate[required,custom[phone_number]] text-input phone_validation" type="text" name="mobile" minlength="6" maxlength="15" value="<?php if(isset($_POST['mobile'])) echo esc_attr($_POST['mobile']);?>" >



												<label class="" for="mobile"><?php esc_html_e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>



								</div>



							</div> 



						</div><!--Row Div End--> 



					</div><!-- user_form End-->  



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Contact Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="address" class="form-control text-input" type="text" maxlength="150"  name="address" value="<?php if(isset($_POST['address'])) echo esc_attr($_POST['address']);?>" >



										<label class="" for="address"><?php esc_html_e('Address','gym_mgt');?></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="city_name" class="form-control text-input" type="text" maxlength="50" name="city_name" value="<?php if(isset($_POST['city_name'])) echo esc_attr($_POST['city_name']);?>" >



										<label class="" for="city_name"><?php esc_html_e('City','gym_mgt');?></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="zip_code" class="form-control " maxlength="15" type="text" name="zip_code" value="<?php if(isset($_POST['zip_code'])) echo esc_attr($_POST['zip_code']);?>" >



										<label class="" for="zip_code"><?php esc_html_e('Zip Code','gym_mgt');?></label>							



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="phone" class="form-control validate[custom[phone_number]] text-input phone_validation" minlength="6" maxlength="15" type="text" name="phone" value="<?php if(isset($_POST['phone'])) echo esc_attr($_POST['phone']);?>" >



										<label class="" for="phone"><?php esc_html_e('Phone','gym_mgt');?></label>



									</div>



								</div>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Profile Image','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control upload-profile-image-patient">



										<label class="ustom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>



										<div class="col-sm-12 display_flex">



											<input type="text" id="gmgt_user_avatar_url1" class="form-control gmgt_user_avatar_url" name="gmgt_user_avatar"  readonly value="<?php if(isset($_POST['gmgt_user_avatar'])) echo esc_url($_POST['gmgt_user_avatar']); ?>" />



											<input id="upload_user_avatar_button1" type="button" class="button upload_image_btn upload_user_avatar_button" style="float: right;" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />



										</div>



									</div>



									<div class="clearfix"></div>



									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">



										<div id="upload_user_avatar_preview1" class="upload_user_avatar_preview" >



											<img class="image_preview_css margin_bottom_0px" src="<?php echo esc_url(get_option( 'gmgt_Staffmember_logo' )); ?>">



										</div>



									</div>



								</div>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 





					<!------------   save btn  -------------->  



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  



								<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Add Staff','gym_mgt');}?>" name="save_staff" id="add_staff_member" class="btn save_btn specialization_submit "  />



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 	



				</form><!-- Staff MEMBER FORM END-->



			</div>	<!-- MODAL BODY DIV END-->	



		</div><!-- MODAL CONTENT DIV END-->



	</div><!-- MODAL DIALOG DIV END-->



</div><!-- MODAL MAIN DIV END-->