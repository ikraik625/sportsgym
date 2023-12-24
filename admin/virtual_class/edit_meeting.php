<?php

$meeting_data = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_data_in_zoom($_REQUEST['meeting_id']);

//var_dump($meeting_data);

//die;
?>

<script type="text/javascript">

$(document).ready(function() {

	$('#meeting_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

	$("#end_date").datepicker({

       	    dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

	    minDate:0

   	 });

} );

</script>

<div class="panel-body padding_0">   

    <form name="route_form" action="" method="post" class="form-horizontal" id="meeting_form">

        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

		<input type="hidden" name="meeting_id" value="<?php echo $_REQUEST['meeting_id'];?>">

		<input type="hidden" name="class_id" value="<?php echo $meeting_data->class_id;?>">

		<input type="hidden" name="class_name" value="<?php echo $meeting_data->title;?>">

		<input type="hidden" name="duration" value="<?php echo $meeting_data->duration;?>">

		<input type="hidden" name="days" value="<?php echo $meeting_data->weekdays;?>">

		<input type="hidden" name="start_time" value="<?php echo $meeting_data->start_time;?>">

		<input type="hidden" name="end_time" value="<?php echo $meeting_data->end_time;?>">

		<input type="hidden" name="staff_id" value="<?php echo $meeting_data->staff_id;?>">

		<input type="hidden" name="start_date" value="<?php echo $meeting_data->start_date;?>">

		<input type="hidden" name="end_date" value="<?php echo $meeting_data->end_date;?>">

		<input type="hidden" name="zoom_meeting_id" value="<?php echo $meeting_data->zoom_meeting_id;?>">

		<input type="hidden" name="uuid" value="<?php echo $meeting_data->uuid;?>">

		<input type="hidden" name="meeting_join_link" value="<?php echo $meeting_data->meeting_join_link;?>">

		<input type="hidden" name="meeting_start_link" value="<?php echo $meeting_data->meeting_start_link;?>">

		<div class="header">	

			<h3 class="first_hed"><?php esc_html_e('Virtual Class Information','gym_mgt');?></h3>

		</div>

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="class_name" class="form-control" maxlength="50" type="text" value="<?php echo $meeting_data->title; ?>" name="class_name" disabled>

							<label class="" for="member_id"><?php esc_html_e('Class Name','gym_mgt');?></label>

						</div>

					</div>

				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="start_time" class="form-control" type="text" value="<?php echo $meeting_data->start_time; ?>" name="start_time" disabled>

							<label class="" for="member_id"><?php esc_html_e('Start Time','gym_mgt');?></label>

						</div>

					</div>

				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="end_time" class="form-control form-label" type="text" value="<?php echo $meeting_data->end_time; ?>" name="end_time" disabled>

							<label class="" for="member_id"><?php esc_html_e('End Time','gym_mgt');?></label>

						</div>

					</div>

				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="start_date" class="form-control validate[required] text-input" type="text" name="start_date" value="<?php echo mj_gmgt_getdate_in_input_box($meeting_data->start_date); ?>" disabled>

							<label class="" for="member_id"><?php esc_html_e('Start Date','gym_mgt');?></label>

						</div>

					</div>

				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="end_date" class="form-control validate[required] text-input" type="text" name="end_date" value="<?php echo mj_gmgt_getdate_in_input_box($meeting_data->end_date); ?>">

							<label class="" for="member_id"><?php esc_html_e('End Date','gym_mgt');?></label>

						</div>

					</div>

				</div>

				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 note_text_notice">

					<div class="form-group input">

						<div class="col-md-12 note_border margin_bottom_15px_res">

							<div class="form-field">

								<textarea name="agenda" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="500" id=""><?php echo $meeting_data->agenda; ?></textarea>

								<span class="txt-title-label"></span>

								<label class="text-area address active" for=""><?php esc_html_e('Description','gym_mgt');?></label>

							</div>

						</div>

					</div>

				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="password" class="form-control validate[minSize[8],maxSize[12]]" type="password" value="<?php echo $meeting_data->password; ?>" name="password">

							<label class="" for="member_id"><?php esc_html_e('Password','gym_mgt');?></label>

						</div>

					</div>

				</div>

				<?php wp_nonce_field( 'edit_meeting_admin_nonce' ); ?>

			</div>

		</div>

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-sm-6 col-md-6 col-lg-6">        	

					<input type="submit" value="<?php  _e('Save Meeting','gym_mgt'); ?>" name="edit_meeting" class="btn save_btn" />

				</div>   

			</div> 

		</div>      

    </form>

</div>