<?php ?>

<script type="text/javascript">

	$(document).ready(function()

	{

		"use strict";
		$(".display-members").select2();

		$('#reservation_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

		$('#event_date').datepicker(

		{

			<?php

			if(get_option('gym_enable_datepicker_privious_date')=='no')

			{

			?>

				minDate:'today',

			<?php

			}

			?>	

			autoclose: true,

			dateFormat:' <?php  echo get_option('gmgt_datepicker_format'); ?>',

			beforeShow: function (textbox, instance)

			{

			instance.dpDiv.css({

			marginTop: (-textbox.offsetHeight) + 'px'                  

			});

			},    

			onChangeMonthYear: function(year, month, inst) {

			jQuery(this).val(month + "/" + year);

			} 

		}); 

	} );

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

<?php 	

if($active_tab == 'addreservation')

{

	$reservation_id=0;

	$edit=0;

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

	{

		$edit=1;

		$reservation_id=esc_attr($_REQUEST['reservation_id']);

		$result = $obj_reservation->MJ_gmgt_get_single_reservation($reservation_id);

	}

	?>
    <div class="panel-body padding_0"><!--PANEL BODY DIV START-->

		<form name="reservation_form" action="" method="post" class="form-horizontal" id="reservation_form"><!--RESERVATION FORM START-->

			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

			<input type="hidden" name="reservation_id" value="<?php echo esc_attr($reservation_id);?>"  />

			<div class="header">	

				<h3 class="first_hed"><?php esc_html_e('Reservation Information','gym_mgt');?></h3>

			</div>

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="event_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" type="text" maxlength="100" value="<?php if($edit){ echo esc_attr($result->event_name);}elseif(isset($_POST['event_name'])) echo esc_attr($_POST['event_name']);?>" name="event_name">

								<label class="" for="event_name"><?php esc_html_e('Event Name','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="event_date" class="form-control date_picker" type="text"  name="event_date" value="<?php if($edit){ if($result->event_date == "0000-00-00"){ echo "0000-00-00"; }else{ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->event_date)); } }elseif(isset($_POST['event_date'])){ echo esc_attr($_POST['event_date']); }else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>

								<label class="date_label" for="event_date"><?php esc_html_e('Event Date','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<!--nonce-->

					<?php wp_nonce_field( 'save_group_nonce' ); ?>

					<!--nonce-->

					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

						<label class="ml-1 custom-top-label top" for="event_place"><?php esc_html_e('Event Place','gym_mgt');?><span class="require-field">*</span></label>

						<select class="form-control validate[required] max_width_100" name="event_place" id="event_place">

							<option value=""><?php esc_html_e('Select Event Place','gym_mgt');?></option>

							<?php

							if(isset($_REQUEST['event_place']))

							{

								$category =esc_attr($_REQUEST['event_place']);  

							}

							elseif($edit)

							{

								$category =$result->place_id;

							}

							else

							{ 

								$category = "";

							}

							$mambership_category=MJ_gmgt_get_all_category('event_place');

							if(!empty($mambership_category))

							{

								foreach ($mambership_category as $retrive_data)

								{

									echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';

								}

							}

							?>

						</select>

					</div>

					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">

						<button id="addremove" class="add_btn" model="event_place"><?php esc_html_e('Add','gym_mgt');?></button>

					</div>

					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

						<!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label> -->

						<?php

						$get_staff = array('role' => 'Staff_member');

						$staffdata=get_users($get_staff);?>

						<select name="staff_id" class="form-control  display-members max_width_100" id="staff_id">

							<option value=""><?php esc_html_e('Select Staff Member','gym_mgt');?></option>

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

									

									echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).'</option>';

								}

							}

							?>

						</select>

					</div>	

					<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

						<label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label>	

						<?php 

						if($edit)

						{

							$start_time_data = explode(":", $result->start_time);

						}

						?>

						<select name="start_time" class="form-control validate[required] max_width_100 start_time">

							<option value=""><?php esc_html_e('Start Time','gym_mgt');?></option>

							<?php 

								for($i =0 ; $i <= 12 ; $i++)

								{

								?>

									<option value="<?php echo esc_attr($i);?>" <?php  if($edit) selected(esc_attr($start_time_data[0]),esc_attr($i));  ?>><?php echo esc_html($i);?></option>

								<?php

								}

							?>

						</select>

					</div>	

					<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

						<select name="start_min" class="form-control validate[required] start_min">

						<?php 

							foreach(MJ_gmgt_minute_array() as $key=>$value)

							{?>

							<option value="<?php echo esc_attr($key);?>" <?php  if($edit) selected(esc_attr($start_time_data[1]),esc_attr($key)); ?>><?php echo esc_html($value);?></option>

							<?php

							}

						?>

						</select>

					</div>

					<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

						<select name="start_ampm" class="form-control validate[required] start_ampm">

							<option value="am" <?php  if($edit) if(isset($start_time_data[2])) selected(esc_attr($start_time_data[2]),'am');  ?>><?php esc_html_e('am','gym_mgt');?></option>

							<option value="pm" <?php  if($edit) if(isset($start_time_data[2])) selected(esc_attr($start_time_data[2]),'pm');  ?>><?php esc_html_e('pm','gym_mgt');?></option>

						</select>

					</div>

					

				

					<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

						<label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label>

						<?php 

						if($edit)

						{

							$end_time_data = explode(":", $result->end_time);

						}

						?>

						<select name="end_time" class="form-control validate[required] end_time">

							<option value=""><?php esc_html_e('End Time','gym_mgt');?></option>

							<?php 

								for($i =0 ; $i <= 12 ; $i++)

								{

								?>

								<option value="<?php echo esc_attr($i);?>" <?php  if($edit) selected(esc_attr($end_time_data[0]),esc_attr($i));  ?>><?php echo esc_html($i);?></option>

								<?php

								}

							?>

						</select>

					</div>

					<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

						<select name="end_min" class="form-control validate[required] end_min">

							<?php 

							foreach(MJ_gmgt_minute_array() as $key=>$value)

							{  ?>

								<option value="<?php echo esc_attr($key);?>" <?php if($edit) selected(esc_attr($end_time_data[1]),esc_attr($key));  ?>><?php echo esc_html($value);?></option>

								<?php

							} ?>

						</select>

					</div>					

					<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">

						<select name="end_ampm" class="form-control validate[required] end_ampm">

							<option value="am" <?php  if($edit) if(isset($end_time_data[2])) selected(esc_attr($end_time_data[2]),'am'); ?> ><?php esc_html_e('am','gym_mgt');?></option>

							<option value="pm" <?php  if($edit) if(isset($end_time_data[2]))selected(esc_attr($end_time_data[2]),'pm');  ?>><?php esc_html_e('pm','gym_mgt');?></option>

						</select>

					</div>	

				</div><!--Row Div End--> 

			</div><!-- user_form End-->  

			<!------------   save btn  -------------->  

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat-->  

					<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  				

						<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_group" class="btn save_btn save_reservation"/>

					</div>		

				</div><!--Row Div End--> 

			</div><!-- user_form End-->  		

		</form><!--RESERVATION FORM END-->

    </div><!--PANEL BODY END-->

<?php 

}

?>