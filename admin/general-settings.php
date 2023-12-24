<?php 

// $role=MJ_gmgt_get_roles(get_current_user_id());

$role=MJ_gmgt_get_roles_for_dashboard(get_current_user_id());



if(in_array("administrator", $role))

{

	$user_access_add=1;



	$user_access_edit=1;



	$user_access_view=1;

}

else

{



	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('general_settings');



	$user_access_add=$user_access['add'];



	$user_access_edit=$user_access['edit'];



	$user_access_view=$user_access['view'];



	if (isset ( $_REQUEST ['page'] ))



	{	



		if($user_access_view=='0')



		{	



			MJ_gmgt_access_right_page_not_access_message_for_management();



			die;



		}



		if(!empty($_REQUEST['action']))



		{



			if ('general_settings' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



			{



				if($user_access_edit=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}			



			}



			if ('general_settings' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



			{



				if($user_access_add=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			} 



		}



	}



}



?>



<div class="page-inner min_height_1631"><!--PAGE INNNER DIV START-->



	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->



		<?php 



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



					$optionval=MJ_gmgt_option();



					foreach($optionval as $key=>$val)



					{



						if(isset($_POST[$key]))



						{



						$result=update_option( $key, $_POST[$key]);



						}



					}



		



				}



				catch(\Stripe\Error\Card $e) {



					var_dump($e);



					//die;



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



					var_dump($e);



					die;



				// Too many requests made to the API too quickly



				} catch (\Stripe\Error\InvalidRequest $e) {



					var_dump($e->message);



					die;



				// Invalid parameters were supplied to Stripe's API



				} catch (\Stripe\Error\Authentication $e) {



					var_dump($e->message);



					die;



				// Authentication with Stripe's API failed



				// (maybe you changed API keys recently)



				} catch (\Stripe\Error\ApiConnection $e) {



					var_dump($e);



					//die;



				// Network communication with Stripe failed



				} catch (\Stripe\Error\Base $e) {



					var_dump($e);



					die;



				// Display a very generic error to the user, and maybe send



				// yourself an email



				} catch (Exception $e) {



					var_dump($e);



					die;



				// Something else happened, completely unrelated to Stripe



				}



			}



			







			$txturl=$_POST['gmgt_system_logo'];



			$txturl1=$_POST['gmgt_gym_other_data_logo'];



			$ext=MJ_gmgt_check_valid_extension($txturl);



			$ext1=MJ_gmgt_check_valid_extension($txturl1);



			if(!$ext == 0 && !$ext1==0)



			{



				$optionval=MJ_gmgt_option();



				foreach($optionval as $key=>$val)



				{



					if(isset($_POST[$key]))



					{

						if($key == "gmgt_system_name" || $key == "gmgt_gym_address" || $key == "gmgt_footer_description")

						{

							$result=update_option( $key, stripslashes($_POST[$key]));

						}

						else

						{

							$result=update_option( $key, $_POST[$key]);

						}



					}



				}



			}			



			else



			{



			?>



				<div id="message" class="updated below-h2 ">



					<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>



				</div>



			<?php 



			}	



			//	UPDATE GENERAL SETTINGS OPTION



			if(isset($_REQUEST['gym_recurring_invoice_enable']))



			{



				update_option( 'gym_recurring_invoice_enable', 'yes' );



			}



			else 



			{



				update_option( 'gym_recurring_invoice_enable', 'no' );



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



			if(isset($_REQUEST['gmgt_heder_enable']))

			{



				update_option( 'gmgt_heder_enable', 'yes' );



			}



			else 



			{



				update_option( 'gmgt_heder_enable', 'no' );



			}



			

			//-------- Card option update for memeber ---------//

			$dashboard_result = get_option("gmgt_dashboard_card_for_member");

			$dashboard_card_access = array();

			

			$dashboard_card_access =	[

										"gmgt_accountant" => isset($_REQUEST['account_card'])?esc_attr($_REQUEST['account_card']):"no",

										"gmgt_staff" => isset($_REQUEST['staff_card'])?esc_attr($_REQUEST['staff_card']):"no",

										"gmgt_notices" => isset($_REQUEST['notice_card'])?esc_attr($_REQUEST['notice_card']):"no",

										"gmgt_messages" => isset($_REQUEST['message_card'])?esc_attr($_REQUEST['message_card']):"no",

										"gmgt_member_status_chart" => isset($_REQUEST['member_status_enable'])?esc_attr($_REQUEST['member_status_enable']):"no",

										"gmgt_invoice_chart" => isset($_REQUEST['invoice_enable'])?esc_attr($_REQUEST['invoice_enable']):"no",

									];

			

			$dashboard_result = update_option( 'gmgt_dashboard_card_for_member',$dashboard_card_access);

		

			//-------- Card option update for staffmemeber ---------//

			$dashboard_result_1 = get_option("gmgt_dashboard_card_for_staffmember");

			$dashboard_card_access_for_staff = array();

			

			$dashboard_card_access_for_staff =	[

										"gmgt_accountant" => isset($_REQUEST['account_card_staff'])?esc_attr($_REQUEST['account_card_staff']):"no",

										"gmgt_staff" => isset($_REQUEST['staff_card_staff'])?esc_attr($_REQUEST['staff_card_staff']):"no",

										"gmgt_notices" => isset($_REQUEST['notice_card_staff'])?esc_attr($_REQUEST['notice_card_staff']):"no",

										"gmgt_messages" => isset($_REQUEST['message_card_staff'])?esc_attr($_REQUEST['message_card_staff']):"no",

										"gmgt_member_status_chart" => isset($_REQUEST['member_status_enable_staff'])?esc_attr($_REQUEST['member_status_enable_staff']):"no",

										"gmgt_invoice_chart" => isset($_REQUEST['invoice_enable_staff'])?esc_attr($_REQUEST['invoice_enable_staff']):"no",

									];

			

			$dashboard_result_1= update_option( 'gmgt_dashboard_card_for_staffmember',$dashboard_card_access_for_staff);



			//-------- Card option update for accountant ---------//

			$dashboard_result_2 = get_option("dashboard_card_access_for_accountant");

			$dashboard_card_access_accountant = array();

			

			$dashboard_card_access_accountant =	[

										"gmgt_accountant" => isset($_REQUEST['account_card_accountant'])?esc_attr($_REQUEST['account_card_accountant']):"no",

										"gmgt_staff" => isset($_REQUEST['staff_card_accountant'])?esc_attr($_REQUEST['staff_card_accountant']):"no",

										"gmgt_notices" => isset($_REQUEST['notice_card_accountant'])?esc_attr($_REQUEST['notice_card_accountant']):"no",

										"gmgt_messages" => isset($_REQUEST['message_card_accountant'])?esc_attr($_REQUEST['message_card_accountant']):"no",

										"gmgt_member_status_chart" => isset($_REQUEST['member_status_enable_accountant'])?esc_attr($_REQUEST['member_status_enable_accountant']):"no",

										"gmgt_invoice_chart" => isset($_REQUEST['invoice_enable_accountant'])?esc_attr($_REQUEST['invoice_enable_accountant']):"no",

									];

			

			$dashboard_result_2=update_option( 'dashboard_card_access_for_accountant',$dashboard_card_access_accountant);

			$wizard = MJ_gmgt_setup_wizard_steps_updates('step1_system_setting');

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



				$('#setting_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



				var gmgt_one_time_payment_setting = $('.gmgt_one_time_payment_setting').val();

				jQuery("body").on("change", ".gmgt_one_time_payment_setting", function(event)

				{

					var gmgt_one_time_payment_setting = $('.gmgt_one_time_payment_setting').val();

					if(gmgt_one_time_payment_setting == '1')

					{

						$(".stripe_div").show();

						$(".paypal_setting_div").hide();

					}

					if(gmgt_one_time_payment_setting == '0')

					{

						$(".stripe_div").hide();

						$(".paypal_setting_div").show();

					}

				} );

				if(gmgt_one_time_payment_setting == '1')



				{



					$('.recurring_label').hide();



					$("#gym_recurring_enable").removeAttr("disabled");



					$(".stripe_div").show();

					$(".paypal_setting_div").hide();

				}



				else



				{

					$(".paypal_setting_div").show();

					$('.recurring_label').hide();



					$("#gym_recurring_enable").removeAttr("disabled");



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



						$('.recurring_label').hide();

 

					   $("#gym_recurring_enable").removeAttr("disabled");



						$(".stripe_div").hide();



					}



				});



			} );



		</script>







		<div class="row"><!--ROW DIV START-->



			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->



				<div class="panel-body"><!--PANEL BODY DIV START-->



					<form name="setting_form" action="" method="post" class="form-horizontal" id="setting_form"><!--GENERAL SETTINGS FORM START-->



						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('General Settings','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_system_name" class="form-control validate[required]" maxlength="50" type="text" value="<?php echo get_option( 'gmgt_system_name' );?>"  name="gmgt_system_name">



											<label class="" for="gmgt_system_name"><?php esc_html_e('Gym Name','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_staring_year" class="form-control" min="0" type="number" onKeyPress="if(this.value.length==4) return false;" value="<?php echo get_option( 'gmgt_staring_year' );?>"  name="gmgt_staring_year">



											<label class="" for="gmgt_staring_year"><?php esc_html_e('Starting Year','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_gym_address" class="form-control validate[required,custom[address_description_validation]]" maxlength="150" type="text" value="<?php echo get_option( 'gmgt_gym_address' );?>"  name="gmgt_gym_address">



											<label class="" for="gmgt_gym_address"><?php esc_html_e('Gym Address','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_contact_number" class="form-control validate[required,custom[phone_number]] phone_validation"  minlength="6" maxlength="15" type="text" value="<?php echo get_option( 'gmgt_contact_number' );?>"  name="gmgt_contact_number">



											<label class="" for="gmgt_contact_number"><?php esc_html_e('Official Phone Number','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input  class="form-control validate[custom[phone_number]] phone_validation"  minlength="6" maxlength="15" type="text" value="<?php echo get_option( 'gmgt_alternate_contact_number' );?>"  name="gmgt_alternate_contact_number">



											<label class=""  for="gmgt_contact_number"><?php esc_html_e('Alternate Phone Number','gym_mgt');?></label>



										</div>



									</div>



								</div>



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<label class="ml-1 custom-top-label top" for="gmgt_contry"><?php esc_html_e('Country','gym_mgt');?></label>



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



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text" value="<?php echo get_option( 'gmgt_email' );?>"  name="gmgt_email">



											<label class="" for="gmgt_email"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<label class="ml-1 custom-top-label top" for="gmgt_datepicker_format"><?php esc_html_e('Date Format','gym_mgt');?></label>



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



				



								<div class="col-md-6">



									<div class="form-group input">



										<div class="col-md-12 form-control upload-profile-image-patient">



											<label class="custom-control-label label_margin_left_15px custom-top-label ml-2" for="gmgt_email"><?php esc_html_e('Gym Header Logo','gym_mgt');?> <span class="require-field">*</span></label>



											<div class="col-sm-12 display_flex">



												<input type="text" id="gmgt_user_avatar_url" name="gmgt_system_logo" class="image_path_dots form-control"  readonly value="<?php  echo get_option( 'gmgt_system_logo' ); ?>" />



												<input id="upload_user_avatar_button" type="button" class="button upload_image_btn" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />



											</div>



										</div>



										<div id="upload_user_avatar_preview" class="gnrl_setting_image_background">



											<img class="image_preview_css" src="<?php  echo get_option( 'gmgt_system_logo' ); ?>" />		



										</div>

										

									</div>

									<p> <span style="font-weight: bold;"><?php esc_html_e('Note', 'gym_mgt' ); ?>:</span><?php esc_html_e('logo Size must be 200 X 54 PX And Color Should Be White.', 'gym_mgt' ); ?></p>

								</div>







								<div class="col-md-6">



									<div class="form-group input">



										<div class="col-md-12 form-control upload-profile-image-patient">



											<label class="label_margin_left_7px custom-control-label custom-top-label ml-2" for="hmgt_cover_image"><?php esc_html_e('Other Logo','gym_mgt');?>(<?php esc_html_e('Invoice, Mail','gym_mgt'); ?>)</label>



											<div class="col-sm-12 display_flex">	



												<input type="text" id="gmgt_gym_background_image" name="gmgt_gym_other_data_logo" class="image_path_dots form-control"  readonly value="<?php  echo get_option( 'gmgt_gym_other_data_logo' ); ?>" />	



												<input id="upload_image_button" type="button" class="button upload_user_cover_button upload_image_btn" value="<?php esc_html_e( 'Upload Cover Image', 'gym_mgt' ); ?>" />



											</div>



										</div>



										<div class="clearfix"></div>



										<!-- <span class="description"><?php esc_html_e('Upload Other Data Logo', 'gym_mgt' ); ?></span>                      -->



										<div id="upload_gym_cover_preview" class="min_height_100 margin_top_5">



											<img class="other_data_logo" src="<?php  echo get_option( 'gmgt_gym_other_data_logo' ); ?>" />



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End--> 





						

						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Payment setting','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<label class="ml-1 custom-top-label top" for="gmgt_one_time_payment_setting"><?php esc_html_e('Payment Method','gym_mgt');?><span class="require-field">*</span></label>



								



									<select name="gmgt_one_time_payment_setting" class="form-control validate[required] text-input gmgt_one_time_payment_setting">



										<option value=""> <?php esc_html_e('Select Payment method','gym_mgt');?></option>



										<option value="0" <?php echo selected(get_option( 'gmgt_one_time_payment_setting' ),'0');?>>



										<?php esc_html_e('Paypal','gym_mgt');?></option>



										<option value="1" <?php echo selected(get_option( 'gmgt_one_time_payment_setting' ),'1');?>>



										<?php esc_html_e('Stripe','gym_mgt');?></option>



									</select>



									<!-- <span class="description recurring_label"><?php esc_html_e('For the PayPal payment recurring option not available, if you want to use recurring payment then select stripe and Enable Recurring option.','gym_mgt');?></span> -->



								</div>



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<div class="row">



										<div class="col-sm-11 col-md-11 col-lg-11 col-xl-11">



											<label class="ml-1 custom-top-label top" for="gmgt_currency_code"><?php esc_html_e('Select Currency','gym_mgt');?><span class="require-field">*</span></label>



											<select name="gmgt_currency_code" class="form-control validate[required] text-input gmgt_currency_dropdown">



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



												<option value="CRC" <?php echo selected(get_option( 'gmgt_currency_code' ),'CRC');?>>



												<?php esc_html_e('Costa Rican Colón','gym_mgt');?></option>

												

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

												<option value="RON" <?php echo selected(get_option( 'gmgt_currency_code' ),'RON');?>>
												<?php esc_html_e('Romanian leu','gym_mgt');?></option>
												
												<option value="RUB" <?php echo selected(get_option( 'gmgt_currency_code' ),'RUB');?>>


												<?php esc_html_e('Russian Ruble','gym_mgt');?></option>







												<option value="SGD" <?php echo selected(get_option( 'gmgt_currency_code' ),'SGD');?>>



												<?php esc_html_e('Singapore Dollar','gym_mgt');?></option>



												<option value="SEK" <?php echo selected(get_option( 'gmgt_currency_code' ),'SEK');?>>



												<?php esc_html_e('Swedish Krona','gym_mgt');?></option>



												<option value="RSD" <?php echo selected(get_option( 'gmgt_currency_code' ),'RSD');?>>



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

                                                 <option value="VND" <?php echo selected(get_option( 'gmgt_currency_code' ),'VND');?>>

												<?php esc_html_e('Vietnamese đồng','gym_mgt');?></option>

												<option value="ZMK" <?php echo selected(get_option( 'gmgt_currency_code' ),'ZMK');?>>



												<?php esc_html_e('Zambian Kwacha','gym_mgt');?></option>



											</select>



										</div>



										<div class="col-sm-1 col-md-1 col-lg-11 col-xl-1 mt-1">



											<span class="font_size_23 gmgt_currency_code"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->



						<div class="paypal_setting_div">

			

							<div class="form-body user_form"> <!-- user_form Strat-->   



								<div class="row"><!--Row Div Strat--> 



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px">



										<div class="form-group mb-3">



											<div class="col-md-12 form-control">



												<div class="row padding_radio">



													<div class="">



														<label class="label_margin_left_0px custom-top-label" for="gym_enable_sandbox"><?php esc_html_e('Enable Sandbox','gym_mgt');?></label>



														<input type="checkbox" name="gym_enable_sandbox" class="res_margin_top_5px margin_right_checkbox_css" value="1" <?php echo checked(get_option('gym_enable_sandbox'),'yes');?>/>



														<lable class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



													</div>												



												</div>



											</div>



										</div>



									</div>



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="gmgt_paypal_email" class="form-control validate[required,custom[email]]  text-input" maxlength="100" type="text" value="<?php echo get_option( 'gmgt_paypal_email' );?>"  name="gmgt_paypal_email">



												<label class="" for="gmgt_paypal_email"><?php esc_html_e('Paypal Email Id','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>



								</div><!--Row Div End--> 



							</div><!-- user_form End-->

						</div>



						<div class="row stripe_div"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="gmgt_stripe_secret_key" class="form-control text-input validate[required]" maxlength="500" type="text" value="<?php echo get_option( 'gmgt_stripe_secret_key' );?>"  name="gmgt_stripe_secret_key">



										<label class="" for="gmgt_stripe_secret_key"><?php esc_html_e('Secret Key','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="gmgt_stripe_publishable_key" class="form-control text-input validate[required]" maxlength="500" type="text" value="<?php echo get_option( 'gmgt_stripe_publishable_key' );?>"  name="gmgt_stripe_publishable_key">



										<label class="" for="gmgt_stripe_publishable_key"><?php esc_html_e('Publishable Key','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



						</div>

						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Recurring Setting','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gym_recurring_invoice_enable"><?php esc_html_e('Enable Recurring Invoices','gym_mgt');?></label>



													<input id="gym_recurring_invoice_enable" type="checkbox" name="gym_recurring_invoice_enable" class="res_margin_top_5px margin_right_checkbox_css gym_recurring_enable" value="1" <?php echo checked(get_option('gym_recurring_invoice_enable'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>



											</div>



										</div>

										<p> <span style="font-weight: bold;"><?php esc_html_e('Note','gym_mgt');?>:</span> <?php esc_html_e('Please set a cronjob to your server. we have given steps in the document.','gym_mgt');?></p>

									</div>



								</div>

								

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

								<div class="form-group input">

									<div class="col-md-12 form-control">

										<input id="gmgt_expired_due_day" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_expired_due_day' );?>"  name="gmgt_expired_due_day">

										<label class="" for="gmgt_expired_due_day"><?php esc_html_e('how many days after the expired Account?','gym_mgt');?><span class="require-field"></span></label>

									</div>

								</div>

                            </div>



								



							</div><!--Row Div End--> 



							



							<div class="row"><!--Row Div Strat--> 



								<?php 



								if(is_plugin_active('paymaster/paymaster.php')) 



								{ ?> 



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



										<div class="form-group mb-3">



											<div class="col-md-12 form-control">



												<div class="row padding_radio">



													<div class="">



														<label for="gmgt_paymaster_pack" class="label_margin_left_0px custom-top-label"><?php esc_html_e('Use Paymaster Payment Gateways','gym_mgt');?></label>



														<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" value="yes" <?php echo checked(get_option('gmgt_paymaster_pack'),'yes');?> name="gmgt_paymaster_pack">



														<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt') ?> </label>



													</div>



												</div>



											</div>



										</div>



									</div>



									<?php 



								} ?>







							</div><!--Row Div End--> 



						</div><!-- user_form End-->	



						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Mail Notification Settings','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<!-- notification template   -->



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gym_enable_notifications"><?php esc_html_e('Enable Mail Notification In System','gym_mgt');?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gym_enable_notifications"  value="1" <?php echo checked(get_option('gym_enable_notifications'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>												



											</div>



										</div>



									</div>



								</div>



								<!-- end notification template   -->







							</div><!--Row Div End--> 



						</div><!-- user_form End-->







						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Membership Expiration Mail Notification','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gym_enable_sandbox"><?php esc_html_e('Expiration Mail Notification','gym_mgt');?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gym_enable_membership_alert_message"  value="yes" <?php echo checked(get_option('gym_enable_membership_alert_message'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>



											</div>



										</div>



									</div>



								</div>







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_reminder_before_days" class="form-control" min="0" type="number" onKeyPress="if(this.value.length==4) return false;" value="<?php echo get_option( 'gmgt_reminder_before_days' );?>"  name="gmgt_reminder_before_days">



											<label class="" for="gym_reminder_before_days"><?php esc_html_e('Reminder Before Days','gym_mgt');?></label>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->







						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Memberships Runs out Mail Notification','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gym_enable_sandbox"><?php esc_html_e('Memberships Runs out','gym_mgt');?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gym_enable_membership_expired_message"  value="yes" <?php echo checked(get_option('gym_enable_membership_expired_message'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>



											</div>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->





						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">

									<h3 class="first_hed"><?php esc_html_e('Attendance Setting','gym_mgt');?></h3>

									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gym_enable_past_attendance"><?php esc_html_e("Past Date Attendance","gym_mgt");?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gym_enable_past_attendance"  value="yes" <?php echo checked(get_option('gym_enable_past_attendance'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>



											</div>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">

									<h3 class="first_hed"><?php esc_html_e('Datepicker Setting','gym_mgt');?></h3>

									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Past Date","gym_mgt");?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gym_enable_datepicker_privious_date"  value="yes" <?php echo checked(get_option('gym_enable_datepicker_privious_date'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>



											</div>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->





						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Member Register Setting','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gmgt_member_approve"><?php esc_html_e("Member Approval","gym_mgt");?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gmgt_member_approve"  value="yes" <?php echo checked(get_option('gmgt_member_approve'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Yes','gym_mgt');?></label>



												</div>



											</div>



										</div>



									</div>	



								</div>	



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Member Register With Payment","gym_mgt");?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gym_enable_Registration_Without_Payment"  value="yes" <?php echo checked(get_option('gym_enable_Registration_Without_Payment'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Yes','gym_mgt');?></label>



												</div>



											</div>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->



						

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



							<h3 class="first_hed"><?php esc_html_e('Class Booking Setting','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gym_frontend_class_booking"><?php esc_html_e("FrontEnd Class Booking","gym_mgt");?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gym_frontend_class_booking"  value="yes" <?php echo checked(get_option('gym_frontend_class_booking'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>



											</div>



										</div>



									</div>



								</div>







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gym_class_cancel_booking"><?php esc_html_e("Cancel Class Booked","gym_mgt");?></label>



													<input id="cancel_booking_check"  class="res_margin_top_5px margin_right_checkbox_css" type="checkbox" name="gym_class_cancel_booking"  value="yes" <?php echo checked(get_option('gym_class_cancel_booking'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>



											</div>



										</div>	



									</div>



								</div>	







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 datetime_checkbox">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gym_cancel_before_time" class="form-control" min="0" type="number" onKeyPress="if(this.value.length==2) return false;"  placeholder="<?php esc_html_e('01 Hours','gym_mgt');?>"value="<?php echo get_option( 'gym_cancel_before_time' );?>"  name="gym_cancel_before_time">



											<label class="" for="gym_cancel_before_time"><?php esc_html_e('Cancel Before Time(Days)','gym_mgt');?></label>



										</div>



									</div>



								</div>







							</div><!--Row Div End--> 



						</div><!-- user_form End-->





						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Virtual class schedule setting(Zoom)','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">



									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for="gmgt_enable_virtual_classschedule"><?php esc_html_e('Virtual class schedule','gym_mgt');?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gmgt_enable_virtual_classschedule"  value="1" <?php echo checked(get_option('gmgt_enable_virtual_classschedule'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>



												</div>



											</div>



										</div>



									</div>



								</div>







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_virtual_classschedule_client_id" class="form-control text-input" type="text" value="<?php echo get_option( 'gmgt_virtual_classschedule_client_id' );?>"  name="gmgt_virtual_classschedule_client_id">



											<label class="" for="gmgt_virtual_classschedule_client_id"><?php esc_html_e('Client Id','gym_mgt');?></label>



										</div>



										<span class="description"><?php esc_html_e('That will be provided by zoom.', 'gym_mgt' ); ?></span>



									</div>



								</div>



								



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_virtual_classschedule_client_secret_id" class="form-control text-input" type="text" value="<?php echo get_option( 'gmgt_virtual_classschedule_client_secret_id' );?>"  name="gmgt_virtual_classschedule_client_secret_id">



											<label class="" for="gmgt_virtual_classschedule_client_secret_id"><?php esc_html_e('Client Secret Id','gym_mgt');?></label>



										</div>



										<span class="description"><?php esc_html_e('That will be provided by zoom.', 'gym_mgt' ); ?></span>



									</div>



								</div>







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="" class="form-control text-input" type="text" value="<?php echo site_url().'?page=callback';?>"  name="" disabled>



											<label class="" for="smgt_virtual_classroom_client_id"><?php esc_html_e('Redirect URL','gym_mgt');?></label>



										</div>



										<span class="description"><?php esc_html_e('Please copy this Redirect URL and add in your zoom account Redirect URL.', 'gym_mgt' ); ?></span>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">

									<h3 class="first_hed"><?php esc_html_e('Datatable Header Settings','gym_mgt');?></h3>

									<div class="form-group mb-3">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Header","gym_mgt");?></label>



													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="gmgt_heder_enable"  value="1" <?php echo checked(get_option('gmgt_heder_enable'),'yes');?>/>



													<label class="res_margin_top_5px"><?php esc_html_e('Enable','gym_mgt');?></label>

												</div>



											</div>



										</div>



									</div>	



								</div>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

									<h3 class="first_hed"><?php esc_html_e('Footer setting','gym_mgt');?></h3>

									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_footer_description" class="form-control text-input" type="text" minlength="6" maxlength="250" value="<?php echo stripslashes(get_option( 'gmgt_footer_description' ));?>"  name="gmgt_footer_description">



											<label class="" for="gmgt_footer_description"><?php esc_html_e('Footer Description','gym_mgt');?></label>



										</div>



									</div>



								</div>



									



							</div>



						</div>





						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Measurement Units','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_weight_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_weight_unit' );?>"  name="gmgt_weight_unit">



											<label class="" for="gmgt_weight_unit"><?php esc_html_e('Weight','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_height_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_height_unit' );?>"  name="gmgt_height_unit">



											<label class="" for="gmgt_height_unit"><?php esc_html_e('Height','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_chest_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_chest_unit' );?>"  name="gmgt_chest_unit">



											<label class="" for="gmgt_chest_unit"><?php esc_html_e('Chest','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_waist_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_waist_unit' );?>"  name="gmgt_waist_unit">



											<label class="" for="gmgt_waist_unit"><?php esc_html_e('Waist','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_thigh_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_thigh_unit' );?>"  name="gmgt_thigh_unit">



											<label class="" for="gmgt_thigh_unit"><?php esc_html_e('Thigh','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_arms_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_arms_unit' );?>"  name="gmgt_arms_unit">



											<label class="" for="gmgt_arms_unit"><?php esc_html_e('Arms','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_fat_unit" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="20" type="text" value="<?php echo get_option( 'gmgt_fat_unit' );?>"  name="gmgt_fat_unit">



											<label class="" for="gmgt_fat_unit"><?php esc_html_e('Fat','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->



						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Bank Details','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_system_name" class="form-control validate[custom[onlyLetter_specialcharacter]" maxlength="50" type="text" value="<?php echo get_option( 'gmgt_bank_holder_name' );?>"  name="gmgt_bank_holder_name">



											<label class="" for="gmgt_paypal_email"><?php esc_html_e('Name of the A/c holder','gym_mgt');?><span class="require-field"></span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_system_name" class="form-control validate[custom[onlyLetter_specialcharacter]" maxlength="50" type="text" value="<?php echo get_option( 'gmgt_bank_name' );?>"  name="gmgt_bank_name">



											<label class="" for="gmgt_paypal_email"><?php esc_html_e('Name of the A/c Bank','gym_mgt');?><span class="require-field"></span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_system_name" class="form-control phone_validation"  min="0" type="number" onKeyPress="if(this.value.length==30) return false;" value="<?php echo get_option( 'gmgt_bank_acount_number' );?>"  name="gmgt_bank_acount_number">



											<label class="" for="gmgt_paypal_email"><?php esc_html_e('Account Number','gym_mgt');?><span class="require-field"></span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="gmgt_system_name" class="form-control validate[custom[onlyLetterNumber]" maxlength="30" type="text" value="<?php echo get_option( 'gmgt_bank_ifsc_code' );?>"  name="gmgt_bank_ifsc_code">



											<label class="" for="gmgt_paypal_email"><?php esc_html_e('IFSC Code','gym_mgt');?><span class="require-field"></span></label>



										</div>



									</div>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->



						<div class="header">	

							<h3 class="first_hed"><?php esc_html_e('Dashboard Card setting For Member','gym_mgt');?></h3>

						</div>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat--> 

								<?php 

								$dashboard_card = get_option("gmgt_dashboard_card_for_member"); 

								?>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Card","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" <?php echo checked($dashboard_card['gmgt_accountant'],"yes");?> value="yes" name="account_card">

													<label class="res_margin_top_5px"><?php esc_html_e('Account','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="staff_card"  value="yes" <?php echo checked($dashboard_card['gmgt_staff'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Staff-Member','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="notice_card"  value="yes" <?php echo checked($dashboard_card['gmgt_notices'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Notice','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="message_card"  value="yes" <?php echo checked($dashboard_card['gmgt_messages'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Message','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Member Status Chart","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="member_status_enable"  value="yes" <?php echo checked($dashboard_card['gmgt_member_status_chart'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Show','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Invoice Card","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="invoice_enable"  value="yes" <?php echo checked($dashboard_card['gmgt_invoice_chart'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Show','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

							</div>

						</div>



						<div class="header">	

							<h3 class="first_hed"><?php esc_html_e('Dashboard Card setting For Staff-Member','gym_mgt');?></h3>

						</div>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat--> 

								<?php $dashboard_card_for_staff = get_option("gmgt_dashboard_card_for_staffmember"); ?>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Card","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" <?php echo checked($dashboard_card_for_staff['gmgt_accountant'],"yes");?> value="yes" name="account_card_staff">

													<label class="res_margin_top_5px"><?php esc_html_e('Account','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="staff_card_staff"  value="yes" <?php echo checked($dashboard_card_for_staff['gmgt_staff'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Staff-Member','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="notice_card_staff"  value="yes" <?php echo checked($dashboard_card_for_staff['gmgt_notices'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Notice','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="message_card_staff"  value="yes" <?php echo checked($dashboard_card_for_staff['gmgt_messages'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Message','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Member Status Chart","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="member_status_enable_staff"  value="yes" <?php echo checked($dashboard_card_for_staff['gmgt_member_status_chart'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Show','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Invoice Card","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="invoice_enable_staff"  value="yes" <?php echo checked($dashboard_card_for_staff['gmgt_invoice_chart'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Show','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

							</div>

						</div>



						<div class="header">	

							<h3 class="first_hed"><?php esc_html_e('Dashboard Card setting For Accountant','gym_mgt');?></h3>

						</div>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat--> 

								<?php $dashboard_card_for_accountant = get_option("dashboard_card_access_for_accountant"); ?>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Card","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" <?php echo checked($dashboard_card_for_accountant['gmgt_accountant'],"yes");?> value="yes" name="account_card_accountant">

													<label class="res_margin_top_5px"><?php esc_html_e('Account','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="staff_card_accountant"  value="yes" <?php echo checked($dashboard_card_for_accountant['gmgt_staff'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Staff-Member','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="notice_card_accountant"  value="yes" <?php echo checked($dashboard_card_for_accountant['gmgt_notices'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Notice','gym_mgt');?></label>

													&nbsp;&nbsp;&nbsp;&nbsp;

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="message_card_accountant"  value="yes" <?php echo checked($dashboard_card_for_accountant['gmgt_messages'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Message','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Member Status Chart","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="member_status_enable_accountant"  value="yes" <?php echo checked($dashboard_card_for_accountant['gmgt_member_status_chart'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Show','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

								<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 margin_top_15px_rs rtl_margin_top_15px">

									<div class="form-group mb-3">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="">

													<label class="label_margin_left_0px custom-top-label" for=""><?php esc_html_e("Invoice Card","gym_mgt");?></label>

													<input type="checkbox" class="res_margin_top_5px margin_right_checkbox_css" name="invoice_enable_accountant"  value="yes" <?php echo checked($dashboard_card_for_accountant['gmgt_invoice_chart'],"yes");?>/>

													<label class="res_margin_top_5px"><?php esc_html_e('Show','gym_mgt');?></label>

												</div>

											</div>

										</div>

									</div>	

								</div>	

							</div>

						</div>

						<?php 



						if($user_access_add == '1' OR  $user_access_edit == '1')



						{ ?>



							<!------------   save btn  -------------->  



							<div class="form-body user_form"> <!-- user_form Strat-->   



								<div class="row"><!--Row Div Strat--> 



									<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  



										<input type="submit" value="<?php esc_html_e('Save', 'gym_mgt' ); ?>" name="save_setting" class="btn save_btn margin_top_20"/>



									</div>



								</div><!--Row Div End--> 



							</div><!-- user_form End-->



							<?php 



						} 



						?>



					</form><!--GENERAL SETTINGS FORM END-->



				</div><!--PANEL BODY DIV END-->



			</div><!--PANEL WHITE DIV END-->



		</div><!--MAIN WRAPPER DIV END-->







	</div><!-- MAIN_LIST_MARGING_15px END -->



</div><!--PAGE INNER DIV END-->