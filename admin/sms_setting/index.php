<?php 

$role=MJ_gmgt_get_roles(get_current_user_id());

if($role == 'administrator')

{

	$user_access_add=1;

	$user_access_edit=1;

	$user_access_delete=1;

	$user_access_view=1;

}

else

{

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('sms_setting');

	$user_access_add=$user_access['add'];

	$user_access_edit=$user_access['edit'];

	$user_access_delete=$user_access['delete'];

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

			if ('sms_setting' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('sms_setting' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('sms_setting' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

$current_sms_service_active =get_option( 'gmgt_sms_service');

if(isset($_REQUEST['save_sms_setting']))

{

	if(isset($_REQUEST['select_serveice']) && $_REQUEST['select_serveice'] == 'msg91')

	{

		$custm_sms_service = array();

		$result=get_option( 'gmgt_msg91_sms_service');

		$custm_sms_service['msg91_senderID'] = trim($_REQUEST['msg91_senderID']);

		$custm_sms_service['sms_auth_key'] = trim($_REQUEST['sms_auth_key']);

		$custm_sms_service['sms_route'] = $_REQUEST['sms_route'];

		

		$result=update_option('gmgt_msg91_sms_service',$custm_sms_service );

		$result=update_option('gmgt_sms_service','msg91' );



	}	

	wp_redirect ( admin_url() . 'admin.php?page=gmgt_sms_setting&message=1');

}

if(isset($_REQUEST['select_serveice']) && $_REQUEST['select_serveice'] == 'clickatell')

{

	$custm_sms_service = array();

	$result=get_option('gmgt_clickatell_sms_service');

	

	$custm_sms_service['username'] = trim($_REQUEST['username']);

	$custm_sms_service['password'] = $_REQUEST['password'];

	$custm_sms_service['api_key'] = $_REQUEST['api_key'];

	$custm_sms_service['sender_id'] = $_REQUEST['sender_id'];

	

	$result=update_option( 'gmgt_clickatell_sms_service',$custm_sms_service );

	$result=update_option( 'gmgt_sms_service','clickatell' );

}

?>



<script type="text/javascript">

	$(document).ready(function() {

		"use strict";

		$('#sms_setting_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

	} );

</script>



<div class="page-inner">

	<div class="gms_main_list" class="marks_list"><!-- MAIN_LIST_MARGING_15px START -->

		<?php

		$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';

		switch($message)

		{

			case '1':

				$message_string = esc_html__('SMS Settings Updated Successfully.','gym_mgt');

				break;

		}

	

		if($message)

		{ ?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php echo $message_string;?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

			<?php 

		} ?>

		<div class="row"><!--ROW DIV START-->

			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->

				<div class="panel-body"><!--PANEL BODY DIV START-->

					<form action="" method="post" class="form-horizontal" id="sms_setting_form"> 

						<div class="header">	

							<h3 class="first_hed"><?php esc_html_e('SMS Setting Information','gym_mgt');?></h3>

						</div>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px">

									<div class="form-group">

										<div class="col-md-12 form-control">

											<div class="row padding_radio">

												<div class="input-group">

													<label class="custom-top-label" for="enable"><?php esc_html_e('Select Message Service','gym_mgt');?></label>

													<div class="d-inline-block gender_line_height_24px">

														<label class="radio-inline custom_radio">

															<input id="checkbox" type="radio" <?php echo checked($current_sms_service_active,'msg91');?> name="select_serveice" class="label_set top" value="msg91"><?php esc_html_e('MSG91','gym_mgt');?>

														</label>&nbsp;&nbsp;

														<label class="radio-inline custom_radio">

															<input id="checkbox" type="radio" <?php echo checked($current_sms_service_active,'clickatell');?>  name="select_serveice" class="label_set top" value="clickatell"><?php esc_html_e('Clickatell','gym_mgt');?> 

														</label> 

													</div>

												</div>

											</div>		

										</div>

									</div>

								</div>



							</div><!--Row Div End--> 

						</div><!-- user_form End--> 

						<div id="sms_setting_block">

							<div class="form-body user_form"> <!-- user_form Strat-->   

								<div class="row"><!--Row Div Strat--> 

									<?php 

									if($current_sms_service_active == 'msg91')

									{

										$msg91=get_option('gmgt_msg91_sms_service');

										?>

											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

												<div class="form-group input">

													<div class="col-md-12 form-control">

														<input id="sms_auth_key" class="form-control validate[required]" type="text" value="<?php if(!empty($msg91['sms_auth_key'])){ echo esc_attr($msg91['sms_auth_key']); } ?>" name="sms_auth_key">

														<label class="" for="sms_auth_key"><?php esc_html_e('Authentication Key','gym_mgt');?><span class="require-field">*</span></label>

													</div>

												</div>

											</div>

											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

												<div class="form-group input">

													<div class="col-md-12 form-control">

														<input id="msg91_senderID" class="form-control validate[required] text-input" type="text" name="msg91_senderID" value="<?php if(!empty($msg91['msg91_senderID'])){  echo esc_attr($msg91['msg91_senderID']); } ?>">

														<label class="" for="msg91_senderID"><?php esc_html_e('SenderID','gym_mgt');?><span class="require-field">*</span></label>

													</div>

												</div>

											</div>

											<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

												<div class="form-group input">

													<div class="col-md-12 form-control">

														<input id="sms_route" class="form-control validate[required] text-input" type="text" name="sms_route" value="<?php if(!empty($msg91['sms_route'])){  echo esc_attr($msg91['sms_route']); } ?>">

														<label class="" for="sms_route"><?php esc_html_e('Route','gym_mgt');?><span class="require-field">*</span></label>

													</div>

												</div>

											</div>

											<div class="form-group">

												<div class="mb-3 row">

													<label class="col-sm-10" for="sms_route"><b><?php esc_html_e('If your operator supports multiple routes then give one route name. Eg: route=1 for promotional, route=4 for transactional SMS.','gym_mgt');?></b></label>

												</div>

											</div>	

										<?php

									}

									if($current_sms_service_active == 'clickatell')

									{

										$clickatell=get_option('gmgt_clickatell_sms_service');

										?>

										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

											<div class="form-group input">

												<div class="col-md-12 form-control">

													<input id="username" class="form-control validate[required]" type="text" value="<?php echo esc_attr($clickatell['username']);?>" name="username">

													<label class="" for="username"><?php esc_html_e('Username','gym_mgt');?><span class="require-field">*</span></label>

												</div>

											</div>

										</div>

										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

											<div class="form-group input">

												<div class="col-md-12 form-control">

													<input id="password" class="form-control validate[required]" type="text" value="<?php echo esc_attr($clickatell['password']);?>" name="password">

													<label class="" for="password"><?php esc_html_e('Password','gym_mgt');?><span class="require-field">*</span></label>

												</div>

											</div>

										</div>

										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

											<div class="form-group input">

												<div class="col-md-12 form-control">

													<input id="api_key" class="form-control validate[required]" type="text" value="<?php echo esc_attr($clickatell['api_key']);?>" name="api_key">

													<label class="" for="api_key"><?php esc_html_e('API Key','gym_mgt');?><span class="require-field">*</span></label>

												</div>

											</div>

										</div>

										<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

											<div class="form-group input">

												<div class="col-md-12 form-control">

													<input id="sender_id" class="form-control validate[required]" type="text" value="<?php echo esc_attr($clickatell['sender_id']);?>" name="sender_id">

													<label class="" for="sender_id"><?php esc_html_e('Sender Id','gym_mgt');?><span class="require-field">*</span></label>

												</div>

											</div>

										</div>

										<?php 

									}

									?>

								</div><!--Row Div End--> 

							</div><!-- user_form End--> 

						</div>

						<?php 

						if($user_access_add == '1' OR  $user_access_edit == '1')

						{ ?>

							<!------------   save btn  -------------->  

							<div class="form-body user_form"> <!-- user_form Strat-->   

								<div class="row"><!--Row Div Strat--> 

									<div class="col-md-6 col-sm-6 col-xs-12 mt-2"><!--save btn-->  	     	

										<input type="submit" value="<?php  esc_html_e('Save','gym_mgt');?>" name="save_sms_setting" class="btn save_btn" />

									</div>

								</div><!--Row Div End--> 

							</div><!-- user_form End--> 

							<?php  

						}?>

					</form>

				</div>

				<div class="clearfix"> </div>

			</div>

		</div>

	</div><!-- MAIN_LIST_MARGING_15px END -->

</div><!--PAGE INNER DIV END-->

<?php ?>