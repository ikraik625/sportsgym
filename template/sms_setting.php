<?php 
$current_sms_service_active =get_option( 'gmgt_sms_service');
$role_access_right = array();
$role_access_right=get_option('gmgt_access_right_staff_member');
$access_right = $role_access_right['staff_member']['sms_setting'];
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
	wp_redirect ( home_url() . '?dashboard=user&page=sms_setting&message=1');
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
<?php
$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
switch($message)
{
	case '1':
		$message_string = esc_html__('SMS Settings Updated Successfully.','gym_mgt');
		break;
}

if($message)
{ 
	?>
	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>
		</button>
		<?php echo $message_string;?>
	</div>
	<?php 
} 
?>
<div class="panel-white padding_0 gms_main_list">
	<div class="panel-body padding_0"> 
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
												<input id="checkbox" type="radio" <?php echo checked($current_sms_service_active,'msg91');?> name="select_serveice" class="label_set marign_left_0_res" value="msg91">  <?php esc_html_e('MSG91','gym_mgt');?>
											</label>&nbsp;&nbsp;
											<label class="radio-inline custom_radio">
												<input id="checkbox" type="radio" <?php echo checked($current_sms_service_active,'clickatell');?>  name="select_serveice" class="label_set marign_left_0_res" value="clickatell"> <?php esc_html_e('Clickatell','gym_mgt');?> 
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
										<label class="" for="sms_auth_key"><?php esc_html_e('Authentication Key11','gym_mgt');?><span class="require-field">*</span></label>
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
					</div>
				</div>
			</div>
			<?php 
			if($access_right['add'] == 1 || $access_right['edit'] == 1 )
			{ 
				?>
				<div class="form-body user_form"> <!-- user_form Strat-->   
					<div class="row"><!--Row Div Strat--> 
						<div class="col-md-6 col-sm-6 col-xs-12 mt-2"><!--save btn-->  	     	
							<input type="submit" value="<?php  esc_html_e('Save','gym_mgt');?>" name="save_sms_setting" class="btn save_btn" />
						</div>
					</div><!--Row Div End--> 
				</div><!-- user_form End--> 
				<?php 
			} 
			?>
		</form>
		<div class="clearfix"> </div>
	</div>
</div>