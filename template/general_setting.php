<div class="min_height_1631"><!--PAGE INNNER DIV START-->



	<?php 

    $role_access_right = array();

    $role_access_right=get_option('gmgt_access_right_staff_member');

    $access_right = $role_access_right['staff_member']['general_setting'];



	//	SAVE GENERAL SETTINGS DATA

	if(isset($_POST['save_setting']))

	{

		if(!empty($_POST['gmgt_stripe_secret_key']) && $_POST['gmgt_stripe_publishable_key'])

		{

			try {

				require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';

				require_once  GMS_PLUGIN_DIR .'/lib/stripe/lib/Stripe.php';

				$stripe = new \Stripe\StripeClient(

					$_POST['gmgt_stripe_secret_key']

				);

				$ch = $stripe->customers->all(['limit' => 3]);

				/* $optionval=MJ_gmgt_option();

				foreach($optionval as $key=>$val)

				{

					if(isset($_POST[$key]))

					{

					  $result=update_option( $key, $_POST[$key]);

					}

				} */

	

			}

			catch(\Stripe\Error\Card $e) {

				

			// Since it's a decline, \Stripe\Error\Card will be caught

			$body = $e->getJsonBody();

			$err  = $body['error'];

			

			print('Status is:' . $e->getHttpStatus() . "\n");

			print('Type is:' . $err['type'] . "\n");

			print('Code is:' . $err['code'] . "\n");

			// param is '' in this case

			print('Param is:' . $err['param'] . "\n");

			print('Message is:' . $err['message'] . "\n");

			} catch (\Stripe\Error\RateLimit $e) {

				

			// Too many requests made to the API too quickly

			} catch (\Stripe\Error\InvalidRequest $e) {

				

			// Invalid parameters were supplied to Stripe's API

			} catch (\Stripe\Error\Authentication $e) {

				

			// Authentication with Stripe's API failed

			// (maybe you changed API keys recently)

			} catch (\Stripe\Error\ApiConnection $e) {

				

			// Network communication with Stripe failed

			} catch (\Stripe\Error\Base $e) {

				

			// Display a very generic error to the user, and maybe send

			// yourself an email

			} catch (Exception $e) {

				

			// Something else happened, completely unrelated to Stripe

			}

		}

        

		$txturl=$_POST['gmgt_system_logo'];

		$txturl1=$_POST['gmgt_gym_background_image'];

		$ext=MJ_gmgt_check_valid_extension($txturl);

		$ext1=MJ_gmgt_check_valid_extension($txturl1);

       

		if(!$ext == 0 && !$ext1==0)

		{

			/* $optionval= MJ_gmgt_option();

			foreach($optionval as $key=>$val)

			{

				if(isset($_POST[$key]))

				{

				  $result=update_option( $key, $_POST[$key]);

				}

			} */

		}			

		else

		{

		?>

			<div id="message" class="updated below-h2 ">

				<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>

			</div>

		<?php 

		}



		$optionval= MJ_gmgt_option();

		var_dump($optionval);

		die;

		foreach($optionval as $key=>$val)

		{

			if(isset($_POST[$key]))

			{

			  $result=update_option( $key, $_POST[$key]);

			}

		}		

		//	UPDATE GENERAL SETTINGS OPTION

		if(isset($_REQUEST['gym_recurring_enable']))

		{

			update_option( 'gym_recurring_enable', 'yes' );

		}

		else 

		{

			update_option( 'gym_recurring_enable', 'no' );

		}

		if(isset($_REQUEST['gmgt_paymaster_pack']))

		{

			update_option( 'gmgt_paymaster_pack', 'yes' );

		}

		else

		{

			update_option( 'gmgt_paymaster_pack', 'no' );

		}

		if(isset($_REQUEST['gym_enable_sandbox']))

		{

			update_option( 'gym_enable_sandbox', 'yes' );

		}

		else 

		{
{promptPosition : "bottomLeft"
			update_option( 'gym_enable_sandbox', 'no' );

		}

		if(isset($_REQUEST['gym_enable_memberlist_for_member']))

		{

			update_option( 'gym_enable_memberlist_for_member', 'yes' );

		}

		else

		{

			update_option( 'gym_enable_memberlist_for_member', 'no' );

		}

		if(isset($_REQUEST['gym_enable_membership_alert_message']))

		{

			update_option( 'gym_enable_membership_alert_message', 'yes' );

		}

		else

		{	

			update_option( 'gym_enable_membership_alert_message', 'no' );

		}		

		if(isset($_REQUEST['gym_enable_membership_expired_message']))

		{

			update_option( 'gym_enable_membership_expired_message', 'yes' );

		}

		else

		{	

			update_option( 'gym_enable_membership_expired_message', 'no' );

		}	

		if(isset($_REQUEST['gym_enable_member_can_message']))

		{

			update_option( 'gym_enable_member_can_message', 'yes' );

		}

		else

		{

			update_option( 'gym_enable_member_can_message', 'no' );

		}

		if(isset($_REQUEST['gym_enable_trainee_memberlist_for_staffmember']))

		{

			update_option( 'gym_enable_trainee_memberlist_for_staffmember', 'yes' );

		}

		else

		{

			update_option( 'gym_enable_trainee_memberlist_for_staffmember', 'no' );

		}		

			

		if(isset($_REQUEST['gym_enable_notifications']))

		{

			update_option( 'gym_enable_notifications', 'yes' );

		}

		else 

		{

			update_option( 'gym_enable_notifications', 'no' );

		}

		if(isset($_REQUEST['gym_enable_past_attendance']))

		{

			update_option( 'gym_enable_past_attendance', 'yes' );

		}

		else 

		{

			update_option( 'gym_enable_past_attendance', 'no' );

		}

		if(isset($_REQUEST['gym_enable_datepicker_privious_date']))

		{

			update_option( 'gym_enable_datepicker_privious_date', 'yes' );

		}

		else 

		{

			update_option( 'gym_enable_datepicker_privious_date', 'no' );

		}

		if(isset($_REQUEST['gym_enable_Registration_Without_Payment']))

		{

			update_option( 'gym_enable_Registration_Without_Payment', 'yes' );

		}

		else 

		{

			update_option( 'gym_enable_Registration_Without_Payment', 'no' );

		}

		if(isset($_REQUEST['gym_frontend_class_booking']))

		{

			update_option( 'gym_frontend_class_booking', 'yes' );

		}

		else 

		{

			update_option( 'gym_frontend_class_booking', 'no' );

		}

		if(isset($_REQUEST['gym_class_cancel_booking']))

		{

			update_option( 'gym_class_cancel_booking', 'yes' );

		}

		else 

		{

			update_option( 'gym_class_cancel_booking', 'no' );

		}

		if(isset($_REQUEST['gmgt_member_approve']))

		{

			update_option( 'gmgt_member_approve', 'yes' );

		}

		else 

		{

			update_option( 'gmgt_member_approve', 'no' );

		}

		if(isset($_REQUEST['gmgt_enable_virtual_classschedule']))

		{

			update_option( 'gmgt_enable_virtual_classschedule', 'yes' );

		}

		else 

		{

			update_option( 'gmgt_enable_virtual_classschedule', 'no' );

		}

		if(isset($result))

		{?>	

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('General Settings updated successfully.','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

		<?php 

		}

	}

	?>

	<script type="text/javascript">

	$(document).ready(function()

	{

		"use strict";

		$('#setting_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	



		var gmgt_one_time_payment_setting = $('.gmgt_one_time_payment_setting').val();

		if(gmgt_one_time_payment_setting == '1')

		{

			$('.recurring_label').hide();

			$("#gym_recurring_enable").removeAttr("disabled");

			$(".stripe_div").show();

		}

		else

		{

			$('.recurring_label').show();

			$("#gym_recurring_enable").attr("disabled","disabled");

			$(".stripe_div").hide();

		}

		$(".gmgt_one_time_payment_setting").on('change',function()

		{

			var gmgt_one_time_payment_setting = $('.gmgt_one_time_payment_setting').val();

			if(gmgt_one_time_payment_setting == '1')

			{

				$('.recurring_label').hide();

				$("#gym_recurring_enable").removeAttr("disabled");

				$(".stripe_div").show();

			}

			else

			{

				$('.recurring_label').show();

				$("#gym_recurring_enable").attr("disabled","disabled");

				$(".stripe_div").hide();

			}

		});

	} );

	</script>

    <style>

        .checkbox input[type=checkbox]{

            margin-right: 10px;

        }

    </style>

	<div id="main-wrapper"><!--MAIN WRAPPER DIV START-->

	    <div class="panel panel-white"><!--PANEL WHITE DIV START-->

			<div class="panel-body"><!--PANEL BODY DIV START-->

				<h2>	

					<?php  echo esc_html__( 'General Settings', 'gym_mgt'); ?>

				</h2>

		        <div class="panel-body"><!--PANEL BODY DIV START-->

					<form name="setting_form" action="" method="post" class="form-horizontal" id="setting_form"><!--GENERAL SETTINGS FORM START-->

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_system_name"><?php esc_html_e('Gym Name','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_system_name" class="form-control validate[required,custom[popup_category_validation]]" maxlength="50" type="text" value="<?php echo get_option( 'gmgt_system_name' );?>"  name="gmgt_system_name">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_staring_year"><?php esc_html_e('Starting Year','gym_mgt');?></label>

								<div class="col-sm-8">

									<input id="gmgt_staring_year" class="form-control" min="0" type="number" onKeyPress="if(this.value.length==4) return false;" value="<?php echo get_option( 'gmgt_staring_year' );?>"  name="gmgt_staring_year">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_gym_address"><?php esc_html_e('Gym Address','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_gym_address" class="form-control validate[required,custom[address_description_validation]]" maxlength="150" type="text" value="<?php echo get_option( 'gmgt_gym_address' );?>"  name="gmgt_gym_address">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_contact_number"><?php esc_html_e('Official Phone Number','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_contact_number" class="form-control validate[required,custom[phone_number]] phone_validation"  minlength="6" maxlength="15" type="text" value="<?php echo get_option( 'gmgt_contact_number' );?>"  name="gmgt_contact_number">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label"  for="gmgt_contact_number"><?php esc_html_e('Alternate Phone Number','gym_mgt');?></label>

								<div class="col-sm-8">

									<input  class="form-control validate[custom[phone_number]] phone_validation"  minlength="6" maxlength="15" type="text" value="<?php echo get_option( 'gmgt_alternate_contact_number' );?>"  name="gmgt_alternate_contact_number">

								</div>

							</div>

						</div>

						<div class="form-group" class="form-control" id="">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_contry"><?php esc_html_e('Country','gym_mgt');?></label>

								<div class="col-sm-8">

									<?php 							

									$url = plugins_url( 'countrylist.xml', __FILE__ );

									$xml =simplexml_load_string(MJ_gmgt_get_remote_file($url));

									?>

									<select name="gmgt_contry" class="form-control validate[required]" id="smgt_contry">

										<option value=""><?php esc_html_e('Select Country','gym_mgt');?></option>

										<?php

											foreach($xml as $country)

											{  

											?>

											 	<option value="<?php echo esc_attr($country->name);?>" <?php selected(get_option( 'gmgt_contry' ), esc_attr($country->name));  ?>><?php echo esc_html($country->name);?></option>

										<?php }?>

									</select> 

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_email"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text" value="<?php echo get_option( 'gmgt_email' );?>"  name="gmgt_email">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_datepicker_format"><?php esc_html_e('Date Format','gym_mgt');?>

								</label>

								<div class="col-sm-8">

									<?php $date_format_array = MJ_gmgt_datepicker_dateformat();

									if(get_option( 'gmgt_datepicker_format' ))

									{

										$selected_format = get_option( 'gmgt_datepicker_format' );

									}

									else

										$selected_format = 'Y-m-d';

									?>

									<select id="gmgt_datepicker_format" class="form-control" name="gmgt_datepicker_format">

										<?php 

										foreach($date_format_array as $key=>$value)

										{

											echo '<option value="'.esc_attr($value).'" '.selected(esc_attr($selected_format),esc_attr($value)).'>'.esc_html($value).'</option>';

										}

										?>

									</select>

								</div>

							</div>

						</div>					

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_email"><?php esc_html_e('Gym Logo','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input type="text" id="gmgt_user_avatar_url" name="gmgt_system_logo" class=""  readonly value="<?php  echo get_option( 'gmgt_system_logo' ); ?>" />

									<input id="upload_user_avatar_button" type="button" class="button" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />

									<span class="description"><?php esc_html_e('Upload image.', 'gym_mgt' ); ?></span> 

									<div id="upload_user_avatar_preview">

										<img class="image_preview_css" src="<?php  echo get_option( 'gmgt_system_logo' ); ?>" />		

									</div>

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="hmgt_cover_image"><?php esc_html_e('Profile Cover Image','gym_mgt');?></label>

								<div class="col-sm-8">			

									<input type="text" id="gmgt_gym_background_image" name="gmgt_gym_background_image" readonly value="<?php  echo get_option( 'gmgt_gym_background_image' ); ?>" />	

									<input id="upload_image_button" type="button" class="button upload_user_cover_button" value="<?php esc_html_e( 'Upload Cover Image', 'gym_mgt' ); ?>" />

									<span class="description"><?php esc_html_e('Upload Cover Image', 'gym_mgt' ); ?></span>                     

									<div id="upload_gym_cover_preview" class="min_height_100 margin_top_5">

										<img class="width_100 height_300" src="<?php  echo get_option( 'gmgt_gym_background_image' ); ?>" />

									</div>

								</div>

							</div>

						</div>

						<div class="header"><hr>

							<h3><?php esc_html_e('Measurement Units','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_weight_unit"><?php esc_html_e('Weight','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_weight_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_weight_unit' );?>"  name="gmgt_weight_unit">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_height_unit"><?php esc_html_e('Height','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_height_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_height_unit' );?>"  name="gmgt_height_unit">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_chest_unit"><?php esc_html_e('Chest','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_chest_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_chest_unit' );?>"  name="gmgt_chest_unit">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_waist_unit"><?php esc_html_e('Waist','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_waist_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_waist_unit' );?>"  name="gmgt_waist_unit">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_thigh_unit"><?php esc_html_e('Thigh','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_thigh_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_thigh_unit' );?>"  name="gmgt_thigh_unit">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_arms_unit"><?php esc_html_e('Arms','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_arms_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_arms_unit' );?>"  name="gmgt_arms_unit">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_fat_unit"><?php esc_html_e('Fat','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_fat_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_fat_unit' );?>"  name="gmgt_fat_unit">

								</div>

							</div>

						</div>

						<div class="header">	

						<hr>

							<h3><?php esc_html_e('Paypal Setting','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_enable_sandbox"><?php esc_html_e('Enable Sandbox','gym_mgt');?></label>

								<div class="col-sm-8">

									<div class="checkbox col-sm-8 margin_top_8">

										<label>

											<input type="checkbox" name="gym_enable_sandbox" class="marign_left_0_res" value="1" <?php echo checked(get_option('gym_enable_sandbox'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

									  </label>

								  </div>

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_paypal_email"><?php esc_html_e('Paypal Email Id','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<input id="gmgt_paypal_email" class="form-control validate[required,custom[email]]  text-input" maxlength="100" type="text" value="<?php echo get_option( 'gmgt_paypal_email' );?>"  name="gmgt_paypal_email">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_currency_code"><?php esc_html_e('Select Currency','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<select name="gmgt_currency_code" class="form-control validate[required] text-input">

									  <option value=""> <?php esc_html_e('Select Currency','gym_mgt');?></option>

									  <option value="AED" <?php echo selected(get_option( 'gmgt_currency_code' ),'AED');?>>

									  <?php esc_html_e('United Arab Emirates Dirham','gym_mgt');?></option>

									  <option value="AFA" <?php echo selected(get_option( 'gmgt_currency_code' ),'AFA');?>>

									  <?php esc_html_e('Afghan Afghani','gym_mgt');?></option>

									  <option value="ALL" <?php echo selected(get_option( 'gmgt_currency_code' ),'ALL');?>>

									  <?php esc_html_e('Albanian Lek','gym_mgt');?></option>

									  <option value="DZD" <?php echo selected(get_option( 'gmgt_currency_code' ),'DZD');?>>

									  <?php esc_html_e('Algerian Dinar','gym_mgt');?></option>

									  <option value="ARS" <?php echo selected(get_option( 'gmgt_currency_code' ),'ARS');?>>

									  <?php esc_html_e('Argentine Peso','gym_mgt');?></option>

									  <option value="AOA" <?php echo selected(get_option( 'gmgt_currency_code' ),'AOA');?>>

									  <?php esc_html_e('Angolan Kwanza','gym_mgt');?></option>

									  <option value="AMD" <?php echo selected(get_option( 'gmgt_currency_code' ),'AMD');?>>

									  <?php esc_html_e('Armenian Dram','gym_mgt');?></option>

									  <option value="AWG" <?php echo selected(get_option( 'gmgt_currency_code' ),'AWG');?>>

									  <?php esc_html_e('Aruban Florin','gym_mgt');?></option>

									  <option value="AZN" <?php echo selected(get_option( 'gmgt_currency_code' ),'AZN');?>>

									  <?php esc_html_e('Azerbaijani Manat','gym_mgt');?></option>

									  <option value="AUD" <?php echo selected(get_option( 'gmgt_currency_code' ),'AUD');?>>

									  <?php esc_html_e('Australian Dollar','gym_mgt');?></option>

									  <option value="BSD" <?php echo selected(get_option( 'gmgt_currency_code' ),'BSD');?>>

									  <?php esc_html_e('Bahamian Dollar','gym_mgt');?></option>

									  <option value="BHD" <?php echo selected(get_option( 'gmgt_currency_code' ),'BHD');?>>

									  <?php esc_html_e('Bahraini Dinar','gym_mgt');?></option>

									  <option value="BBD" <?php echo selected(get_option( 'gmgt_currency_code' ),'BBD');?>>

									  <?php esc_html_e('Barbadian Dollar','gym_mgt');?></option>

									  <option value="BEF" <?php echo selected(get_option( 'gmgt_currency_code' ),'BEF');?>>

									  <?php esc_html_e('Belgian Franc','gym_mgt');?></option>

									  <option value="BTN" <?php echo selected(get_option( 'gmgt_currency_code' ),'BTN');?>>

									  <?php esc_html_e('Bhutanese Ngultrum','gym_mgt');?></option>

									  <option value="BTC" <?php echo selected(get_option( 'gmgt_currency_code' ),'BTC');?>>

									  <?php esc_html_e('Bitcoin','gym_mgt');?></option>

									  <option value="BND" <?php echo selected(get_option( 'gmgt_currency_code' ),'BND');?>>

									  <?php esc_html_e('Brunei Dollar','gym_mgt');?></option>

									  <option value="BGN" <?php echo selected(get_option( 'gmgt_currency_code' ),'BGN');?>>

									  <?php esc_html_e('Bulgarian Lev','gym_mgt');?></option>

									  <option value="BRL" <?php echo selected(get_option( 'gmgt_currency_code' ),'BRL');?>>

									  <?php esc_html_e('Brazilian Real','gym_mgt');?> </option>

									  <option value="CAD" <?php echo selected(get_option( 'gmgt_currency_code' ),'CAD');?>>

									  <?php esc_html_e('Canadian Dollar','gym_mgt');?></option>

									  <option value="CZK" <?php echo selected(get_option( 'gmgt_currency_code' ),'CZK');?>>

									  <?php esc_html_e('Czech Koruna','gym_mgt');?></option>

									  <option value="KYD" <?php echo selected(get_option( 'gmgt_currency_code' ),'KYD');?>>

									  <?php esc_html_e('Cayman Islands Dollar','gym_mgt');?></option>

									  <option value="XAF" <?php echo selected(get_option( 'gmgt_currency_code' ),'XAF');?>>

									  <?php esc_html_e('CFA Franc BEAC','gym_mgt');?></option>

									  <option value="DKK" <?php echo selected(get_option( 'gmgt_currency_code' ),'DKK');?>>

									  <?php esc_html_e('Danish Krone','gym_mgt');?></option>

									  <option value="EUR" <?php echo selected(get_option( 'gmgt_currency_code' ),'EUR');?>>

									  <?php esc_html_e('Euro','gym_mgt');?></option>

									  <option value="EEK" <?php echo selected(get_option( 'gmgt_currency_code' ),'EEK');?>>

									  <?php esc_html_e('Estonian Kroon','gym_mgt');?></option>

									  <option value="FKP" <?php echo selected(get_option( 'gmgt_currency_code' ),'FKP');?>>

									  <?php esc_html_e('Falkland Islands Pound','gym_mgt');?></option>

									  <option value="DEM" <?php echo selected(get_option( 'gmgt_currency_code' ),'DEM');?>>

									  <?php esc_html_e('German Mark','gym_mgt');?></option>

									  <option value="GIP" <?php echo selected(get_option( 'gmgt_currency_code' ),'GIP');?>>

									  <?php esc_html_e('Gibraltar Pound','gym_mgt');?></option>



									  <option value="HKD" <?php echo selected(get_option( 'gmgt_currency_code' ),'HKD');?>>

									  <?php esc_html_e('Hong Kong Dollar','gym_mgt');?></option>

									  <option value="HUF" <?php echo selected(get_option( 'gmgt_currency_code' ),'HUF');?>>

									  <?php esc_html_e('Hungarian Forint','gym_mgt');?> </option>

									  <option value="INR" <?php echo selected(get_option( 'gmgt_currency_code' ),'INR');?>>

									  <?php esc_html_e('Indian Rupee','gym_mgt');?></option>

									  <option value="ILS" <?php echo selected(get_option( 'gmgt_currency_code' ),'ILS');?>>

									  <?php esc_html_e('Israeli New Sheqel','gym_mgt');?></option>

									  <option value="JPY" <?php echo selected(get_option( 'gmgt_currency_code' ),'JPY');?>>

									  <?php esc_html_e('Japanese Yen','gym_mgt');?></option>

									  <option value="MYR" <?php echo selected(get_option( 'gmgt_currency_code' ),'MYR');?>>

									  <?php esc_html_e('Malaysian Ringgit','gym_mgt');?></option>

									  <option value="MXN" <?php echo selected(get_option( 'gmgt_currency_code' ),'MXN');?>>

									  <?php esc_html_e('Mexican Peso','gym_mgt');?></option>

									  <option value="NOK" <?php echo selected(get_option( 'gmgt_currency_code' ),'NOK');?>>

									  <?php esc_html_e('Norwegian Krone','gym_mgt');?></option>

									  <option value="NAD" <?php echo selected(get_option( 'gmgt_currency_code' ),'NAD');?>>

									  <?php esc_html_e('Namibian Dollar','gym_mgt');?></option>

									  <option value="NPR" <?php echo selected(get_option( 'gmgt_currency_code' ),'NPR');?>>

									  <?php esc_html_e('Nepalese Rupee','gym_mgt');?></option>



									  <option value="NGN" <?php echo selected(get_option( 'gmgt_currency_code' ),'NGN');?>>

									  <?php esc_html_e('Nigerian Naira','gym_mgt');?></option>

									  

									  <option value="NZD" <?php echo selected(get_option( 'gmgt_currency_code' ),'NZD');?>>

									  <?php esc_html_e('New Zealand Dollar','gym_mgt');?></option>

									  <option value="PHP" <?php echo selected(get_option( 'gmgt_currency_code' ),'PHP');?>>

									  <?php esc_html_e('Philippine Peso','gym_mgt');?></option>

									  <option value="PLN" <?php echo selected(get_option( 'gmgt_currency_code' ),'PLN');?>>

									  <?php esc_html_e('Polish Zloty','gym_mgt');?></option>

									  <option value="GBP" <?php echo selected(get_option( 'gmgt_currency_code' ),'GBP');?>>

									  <?php esc_html_e('Pound Sterling','gym_mgt');?></option>

									  <option value="PKR" <?php echo selected(get_option( 'gmgt_currency_code' ),'PKR');?>>

									  <?php esc_html_e('Pakistani Rupee','gym_mgt');?></option>

									  <option value="QAR" <?php echo selected(get_option( 'gmgt_currency_code' ),'QAR');?>>

									  <?php esc_html_e('Qatari Rial','gym_mgt');?></option>

									  <option value="RUB" <?php echo selected(get_option( 'gmgt_currency_code' ),'RUB');?>>

									  <?php esc_html_e('Russian Ruble','gym_mgt');?></option>



									  <option value="SGD" <?php echo selected(get_option( 'gmgt_currency_code' ),'SGD');?>>

									  <?php esc_html_e('Singapore Dollar','gym_mgt');?></option>

									  <option value="SEK" <?php echo selected(get_option( 'gmgt_currency_code' ),'SEK');?>>

									  <?php esc_html_e('Swedish Krona','gym_mgt');?></option>

									  <option value="SEK" <?php echo selected(get_option( 'gmgt_currency_code' ),'SEK');?>>

									  <?php esc_html_e('Serbian Dinar','gym_mgt');?></option>



									  <option value="CHF" <?php echo selected(get_option( 'gmgt_currency_code' ),'CHF');?>>

									  <?php esc_html_e('Swiss Franc','gym_mgt');?></option>

									  <option value="TWD" <?php echo selected(get_option( 'gmgt_currency_code' ),'TWD');?>>

									 <?php esc_html_e('Taiwan New Dollar','gym_mgt');?></option>

									 <option value="TTD" <?php echo selected(get_option( 'gmgt_currency_code' ),'TTD');?>>

									  <?php esc_html_e('Trinidad/Tobago Dollar','gym_mgt');?></option>

									  <option value="THB" <?php echo selected(get_option( 'gmgt_currency_code' ),'THB');?>>

									  <?php esc_html_e('Thai Baht','gym_mgt');?></option>

									  <option value="TRY" <?php echo selected(get_option( 'gmgt_currency_code' ),'TRY');?>>

									  <?php esc_html_e('Turkish Lira','gym_mgt');?></option>

									  <option value="USD" <?php echo selected(get_option( 'gmgt_currency_code' ),'USD');?>>

									  <?php esc_html_e('U.S. Dollar','gym_mgt');?></option>

									  <option value="R" <?php echo selected(get_option( 'gmgt_currency_code' ),'R');?>>

									  <?php esc_html_e('South African rand','gym_mgt');?></option>

									  <option value="LKR" <?php echo selected(get_option( 'gmgt_currency_code' ),'LKR');?>>

									  <?php esc_html_e('Sri Lankan Rupee','gym_mgt');?></option>

									  <option value="SHP" <?php echo selected(get_option( 'gmgt_currency_code' ),'SHP');?>>

									  <?php esc_html_e('St. Helena Pound','gym_mgt');?></option>

									  <option value="SRD" <?php echo selected(get_option( 'gmgt_currency_code' ),'SRD');?>>

									  <?php esc_html_e('Surinamese Dollar','gym_mgt');?></option>

									  <option value="TMT" <?php echo selected(get_option( 'gmgt_currency_code' ),'TMT');?>>

									  <?php esc_html_e('Turkmenistani Manat','gym_mgt');?></option>

									  <option value="UAH" <?php echo selected(get_option( 'gmgt_currency_code' ),'UAH');?>>

									  <?php esc_html_e('Ukrainian Hryvnia','gym_mgt');?></option>

									  <option value="ZMK" <?php echo selected(get_option( 'gmgt_currency_code' ),'ZMK');?>>

									  <?php esc_html_e('Zambian Kwacha','gym_mgt');?></option>

									  



									</select>

								</div>

								<div class="col-sm-1">

									<span class="font_size_23"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>

								</div>

							</div>

						</div>

						<div class="header">	

							<hr>

							<h3><?php esc_html_e('One-time Payment setting','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_one_time_payment_setting"><?php esc_html_e('One-time Payment setting','gym_mgt');?><span class="require-field">*</span></label>

								<div class="col-sm-8">

									<select name="gmgt_one_time_payment_setting" class="form-control validate[required] text-input gmgt_one_time_payment_setting">

									  <option value=""> <?php esc_html_e('Select Payment method','gym_mgt');?></option>

									  <option value="0" <?php echo selected(get_option( 'gmgt_one_time_payment_setting' ),'0');?>>

									  <?php esc_html_e('Paypal','gym_mgt');?></option>

									  <option value="1" <?php echo selected(get_option( 'gmgt_one_time_payment_setting' ),'1');?>>

									  <?php esc_html_e('Stripe','gym_mgt');?></option>

									</select>

								</div>

							</div>

							<div class="mb-3 row recurring_label">

								<div class="offset-sm-2 col-sm-12">

									<span class=""><?php esc_html_e('For the PayPal payment recurring option not available, if you want to use recurring payment then select stripe and Enable Recurring option.','gym_mgt');?></span>

								</div>

							</div>

						</div>

						<div class="header">	

						<hr>

							<h3><?php esc_html_e('Recurring Setting','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_recurring_enable"><?php esc_html_e('Enable Recurring ','gym_mgt');?></label>

								<div class="col-sm-8">

									<div class="checkbox col-sm-8 margin_top_8">

										<label>

											<input id="gym_recurring_enable" type="checkbox" name="gym_recurring_enable" class="marign_left_0_res gym_recurring_enable" value="1" <?php echo checked(get_option('gym_recurring_enable'),'yes');?> disabled/><?php esc_html_e('Enable','gym_mgt');?>

									  </label>

								  </div>

								</div>

							</div>

							<div class="stripe_div">

								<h3><?php esc_html_e('Stripe Setting','gym_mgt');?></h3>

								<div class="mb-3 row">

									<label class="col-sm-2 control-label form-label" for="gmgt_stripe_secret_key"><?php esc_html_e('Secret Key','gym_mgt');?><span class="require-field">*</span></label>

									<div class="col-sm-8">

										<input id="gmgt_stripe_secret_key" class="form-control text-input validate[required]" maxlength="500" type="text" value="<?php echo get_option( 'gmgt_stripe_secret_key' );?>"  name="gmgt_stripe_secret_key">

									</div>

								</div>

								<div class="mb-3 row">

									<label class="col-sm-2 control-label form-label" for="gmgt_stripe_publishable_key"><?php esc_html_e('Publishable Key','gym_mgt');?><span class="require-field">*</span></label>

									<div class="col-sm-8">

										<input id="gmgt_stripe_publishable_key" class="form-control text-input validate[required]" maxlength="500" type="text" value="<?php echo get_option( 'gmgt_stripe_publishable_key' );?>"  name="gmgt_stripe_publishable_key">

									</div>

								</div>

							</div>

						</div>

						<?php if(is_plugin_active('paymaster/paymaster.php')) { ?> 

						<div class="form-group">

							<div class="mb-3 row">

								<label for="gmgt_paymaster_pack" class="col-sm-2 control-label form-label"><?php esc_html_e('Use Paymaster Payment Gateways','gym_mgt');?></label>

								<div class="col-sm-4">

									<div class="checkbox margin_top_8">

										<label><input type="checkbox" class="marign_left_0_res" value="yes" <?php echo checked(get_option('gmgt_paymaster_pack'),'yes');?> name="gmgt_paymaster_pack"><?php esc_html_e('Enable','gym_mgt') ?> </label>

								  	</div>

								</div>

							</div>

						</div>

						<?php } ?>

						<div class="header">	<hr>

							<h3><?php esc_html_e('Bank Details','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_paypal_email"><?php esc_html_e('Name of the A/c holder','gym_mgt');?><span class="require-field"></span></label>

								<div class="col-sm-8">

									<input id="gmgt_system_name" class="form-control validate[custom[onlyLetter_specialcharacter]" maxlength="50" type="text" value="<?php echo get_option( 'gmgt_bank_holder_name' );?>"  name="gmgt_bank_holder_name">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_paypal_email"><?php esc_html_e('Name of the A/c Bank','gym_mgt');?><span class="require-field"></span></label>

								<div class="col-sm-8">

									<input id="gmgt_system_name" class="form-control validate[custom[onlyLetter_specialcharacter]" maxlength="50" type="text" value="<?php echo get_option( 'gmgt_bank_name' );?>"  name="gmgt_bank_name">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_paypal_email"><?php esc_html_e('Account Number','gym_mgt');?><span class="require-field"></span></label>

								<div class="col-sm-8">

									<input id="gmgt_system_name" class="form-control phone_validation"  min="0" type="number" onKeyPress="if(this.value.length==30) return false;" value="<?php echo get_option( 'gmgt_bank_acount_number' );?>"  name="gmgt_bank_acount_number">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_paypal_email"><?php esc_html_e('IFSC Code','gym_mgt');?><span class="require-field"></span></label>

								<div class="col-sm-8">

									<input id="gmgt_system_name" class="form-control validate[custom[onlyLetterNumber]" maxlength="30" type="text" value="<?php echo get_option( 'gmgt_bank_ifsc_code' );?>"  name="gmgt_bank_ifsc_code">

								</div>

							</div>

						</div>

						<div class="header">	<hr>

							<h3><?php esc_html_e('Mail Notification In System','gym_mgt');?></h3>

						</div>

						<!-- notification template   -->

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_enable_notifications"><?php esc_html_e('Enable Mail Notification In System','gym_mgt');?></label>

								<div class="col-sm-8 margin_top_8">

									<div class="checkbox">

										<label>

											<input type="checkbox" class="marign_left_0_res" name="gym_enable_notifications"  value="1" <?php echo checked(get_option('gym_enable_notifications'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

									  	</label>

								  	</div>

								</div>

							</div>

						</div>

						<!-- end notification template   -->

						<div class="header">	<hr>

							<h3><?php esc_html_e('Membership Expiration Mail Notification','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_enable_sandbox"><?php esc_html_e('Enable Membership Expiration Mail Notification','gym_mgt');?></label>

								<div class="col-sm-8 margin_top_8">

									<div class="checkbox col-sm-8 margin_top_8">

										<label>

											<input type="checkbox" class="marign_left_0_res" name="gym_enable_membership_alert_message"  value="yes" <?php echo checked(get_option('gym_enable_membership_alert_message'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

									  	</label>

								  	</div>

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_reminder_before_days"><?php esc_html_e('Reminder Before Days','gym_mgt');?></label>

								<div class="col-sm-8">

									<input id="gmgt_reminder_before_days" class="form-control" min="0" type="number" onKeyPress="if(this.value.length==4) return false;" value="<?php echo get_option( 'gmgt_reminder_before_days' );?>"  name="gmgt_reminder_before_days">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_paypal_email"><?php esc_html_e('Reminder Subject','gym_mgt');?><span class="require-field"></span></label>

								<div class="col-sm-8">

									<input class="form-control validate[required] text-input onlyletter_number_space_validation" maxlength="100" value="<?php echo get_option( 'gmgt_reminder_subject' );?>" type="text" name="gmgt_reminder_subject">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_reminder_message"><?php esc_html_e('Reminder Message','gym_mgt');?></label>

								<div class="col-sm-8">

									<textarea name="gym_reminder_message" class="form-control"><?php echo get_option('gym_reminder_message');?>

									</textarea>

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for=""><?php esc_html_e('ShortCodes For Notification Mail Message Content','gym_mgt'); ?></label>

								<div class="col-sm-8">

									<label>[GMGT_MEMBERNAME]</label> <br>

									<label>[GMGT_STARTDATE]</label><br>

									<label>[GMGT_ENDDATE]</label><br>

									<label>[GMGT_MEMBERSHIP]</label><br>

									<label>[GMGT_GYM_NAME]</label><br>

								</div>

							</div>

						</div>

						<div class="header">	<hr>

							<h3><?php esc_html_e('Memberships Runs out Mail Notification','gym_mgt');?></h3>

						</div>

							<div class="form-group">

								<div class="mb-3 row">

									<label class="col-sm-2 control-label form-label" for="gym_enable_sandbox"><?php esc_html_e('Enable Mail Notification Memberships Runs out','gym_mgt');?></label>

									<div class="col-sm-8 margin_top_8">

										<div class="checkbox col-sm-8 margin_top_8">

											<label>

												<input type="checkbox" class="marign_left_0_res" name="gym_enable_membership_expired_message"  value="yes" <?php echo checked(get_option('gym_enable_membership_expired_message'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

										  	</label>

									 	</div>

									</div>

								</div>

							</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_paypal_email"><?php esc_html_e('Mail Expire Subject','gym_mgt');?><span class="require-field"></span></label>

								<div class="col-sm-8">

									<input class="form-control validate[required] text-input onlyletter_number_space_validation" maxlength="100" value="<?php echo get_option( 'gmgt_expire_subject' );?>" type="text" name="gmgt_expire_subject">

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_expire_message"><?php esc_html_e('Mail Expire Message','gym_mgt');?></label>

								<div class="col-sm-8">

									<textarea name="gym_expire_message" class="form-control"><?php echo get_option('gym_expire_message');?>

									</textarea>

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for=""><?php esc_html_e('ShortCodes For Notification Mail Message Content','gym_mgt'); ?></label>

								<div class="col-sm-8">

									<label>[GMGT_MEMBERNAME]</label> <br>

									<label>[GMGT_STARTDATE]</label><br>

									<label>[GMGT_ENDDATE]</label><br>

									<label>[GMGT_MEMBERSHIP]</label><br>

									<label>[GMGT_GYM_NAME]</label><br>

								</div>

							</div>

						</div>

	

						<div class="header"><hr>

							<h3><?php esc_html_e('Attendance Setting','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_enable_past_attendance"><?php esc_html_e("Past Date Attendance","gym_mgt");?></label>

								<div class="col-sm-8 margin_top_8">

									<div class="checkbox">

										<label>

											<input type="checkbox" class="marign_left_0_res" name="gym_enable_past_attendance"  value="yes" <?php echo checked(get_option('gym_enable_past_attendance'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

									  </label>

								  </div>

								</div>

							</div>

						</div>

						<div class="header"><hr>

							<h3><?php esc_html_e('Datepicker Setting','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for=""><?php esc_html_e("Past Date","gym_mgt");?></label>

								<div class="col-sm-8 margin_top_8">

									<div class="checkbox">

										<label>

											<input type="checkbox" class="marign_left_0_res" name="gym_enable_datepicker_privious_date"  value="yes" <?php echo checked(get_option('gym_enable_datepicker_privious_date'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

									  	</label>

								  	</div>

								</div>

							</div>

						</div>

						<div class="header"><hr>

							<h3><?php esc_html_e('Member Register With Payment','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for=""><?php esc_html_e("Member Registration With Payment","gym_mgt");?></label>

								<div class="col-sm-8 margin_top_8">

									<div class="checkbox">

										<label>

											<input type="checkbox" class="marign_left_0_res" name="gym_enable_Registration_Without_Payment"  value="yes" <?php echo checked(get_option('gym_enable_Registration_Without_Payment'),'yes');?>/><?php esc_html_e('Yes','gym_mgt');?>

									  	</label>

								  	</div>

								</div>

							</div>

						</div>

						<script>

						$(document).ready(function()

						{

							"use strict";

							$(function() 

							{

								"use strict";

							  	$("#cancel_booking_check").on("click",function()

							  	{

							  		"use strict";

									$(".datetime_checkbox").toggle(this.checked);

							 	});

							});

						});

						</script>

						<div class="header">	

							<hr>

							<h3><?php esc_html_e('Class Booking Setting','gym_mgt');?></h3>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_frontend_class_booking"><?php esc_html_e("FrontEnd Class Booking","gym_mgt");?></label>

								<div class="col-sm-8 margin_top_8">

									<div class="checkbox">

										<label>

											<input type="checkbox" class="marign_left_0_res" name="gym_frontend_class_booking"  value="yes" <?php echo checked(get_option('gym_frontend_class_booking'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

									  </label>

								  </div>

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_class_cancel_booking"><?php esc_html_e("Cancel Class Booked","gym_mgt");?></label>

								<div class="col-sm-8 margin_top_8">

									<div class="checkbox">

										<label>

											<input id="cancel_booking_check"  class="marign_left_0_res" type="checkbox" name="gym_class_cancel_booking"  value="yes" <?php echo checked(get_option('gym_class_cancel_booking'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

									  </label>

								  </div>

								</div>

							</div>

						</div>	

						<div class="form-group datetime_checkbox">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gym_cancel_before_time"><?php esc_html_e('Cancel Before Time','gym_mgt');?></label>

								<div class="col-sm-8">

									<input id="gym_cancel_before_time" class="form-control" min="0" type="number" onKeyPress="if(this.value.length==2) return false;"  placeholder="<?php esc_html_e('01 Hours','gym_mgt');?>"value="<?php echo get_option( 'gym_cancel_before_time' );?>"  name="gym_cancel_before_time">

								</div>

							</div>

						</div>

						<div class="header">	

							<hr>

							<h3><?php esc_html_e('Member Approval Setting','gym_mgt');?></h3>

						</div>

						<div class="form-group margin_bottom_5px">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_member_approve"><?php esc_html_e("Admin Approval","gym_mgt");?></label>

								<div class="col-sm-8 margin_bottom_5px margin_top_8">

									<div class="checkbox">

										<label>

											<input type="checkbox" class="marign_left_0_res" name="gmgt_member_approve"  value="yes" <?php echo checked(get_option('gmgt_member_approve'),'yes');?>/><?php esc_html_e('Yes','gym_mgt');?>

									  </label>

								  </div>

								</div>

							</div>

						</div>	



						<div class="head">

							<hr>

							<h4 class="section"><?php esc_html_e('Virtual class schedule setting(Zoom)','gym_mgt');?></h4>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_enable_virtual_classschedule"><?php esc_html_e('Virtual class schedule','gym_mgt');?></label>

								<div class="col-sm-8 margin_top_8"> 

									<div class="checkbox">

										<label>

											<input type="checkbox" class="marign_left_0_res" name="gmgt_enable_virtual_classschedule"  value="1" <?php echo checked(get_option('gmgt_enable_virtual_classschedule'),'yes');?>/><?php esc_html_e('Enable','gym_mgt');?>

									</label>

								</div>

							</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_virtual_classschedule_client_id"><?php esc_html_e('Client Id','gym_mgt');?></label>

								<div class="col-sm-8">

									<input id="gmgt_virtual_classschedule_client_id" class="form-control text-input" type="text" value="<?php echo get_option( 'gmgt_virtual_classschedule_client_id' );?>"  name="gmgt_virtual_classschedule_client_id">

									<span class="description"><?php esc_html_e('That will be provided by zoom.', 'gym_mgt' ); ?></span>

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="gmgt_virtual_classschedule_client_secret_id"><?php esc_html_e('Client Secret Id','gym_mgt');?></label>

								<div class="col-sm-8">

									<input id="gmgt_virtual_classschedule_client_secret_id" class="form-control text-input" type="text" value="<?php echo get_option( 'gmgt_virtual_classschedule_client_secret_id' );?>"  name="gmgt_virtual_classschedule_client_secret_id">

									<span class="description"><?php esc_html_e('That will be provided by zoom.', 'gym_mgt' ); ?></span>

								</div>

							</div>

						</div>

						<div class="form-group">

							<div class="mb-3 row">

								<label class="col-sm-2 control-label form-label" for="smgt_virtual_classroom_client_id"><?php esc_html_e('Redirect URL','gym_mgt');?></label>

								<div class="col-sm-8">

									<input id="" class="form-control text-input" type="text" value="<?php echo site_url().'?page=callback';?>"  name="" disabled>

									<span class="description"><?php esc_html_e('Please copy this Redirect URL and add in your zoom account Redirect URL.', 'gym_mgt' ); ?></span>

								</div>

							</div>

						</div>

                        <?php if($access_right['add'] == 1 || $access_right['edit'] == 1 ){ ?>

						<div class="offset-sm-2 col-lg-8 col-md-8 col-sm-8 col-xs-12">

							<input type="submit" value="<?php esc_html_e('Save', 'gym_mgt' ); ?>" name="save_setting" class="btn btn-success margin_top_20"/>

						</div>

                        <?php } ?>

					</form><!--GENERAL SETTINGS FORM END-->

	            </div><!--PANEL BODY DIV END-->

            </div><!--PANEL BODY DIV END-->

        </div><!--PANEL WHITE DIV END-->

    </div><!--MAIN WRAPPER DIV END-->

</div><!--PAGE INNNER DIV END-->