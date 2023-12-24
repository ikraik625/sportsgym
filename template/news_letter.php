<?php 
error_reporting(0);
$curr_user_id=get_current_user_id();
$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);
$obj_class=new MJ_gmgt_classschedule;
$apikey = get_option('gmgt_mailchimp_api');
$api = new MJ_gmgt_GYM_MCAPI($apikey);
$active_tab = isset($_GET['tab'])?$_GET['tab']:'mailchimp_setting';
//access right
$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_gmgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_gmgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
		{
			if($user_access['add']=='0')
			{	
				MJ_gmgt_access_right_page_not_access_message();
				die;
			}	
		}
	}
}
//SAVE MAILCHIMP API DATA
// if(isset($_REQUEST['save_setting']))
// {
// 	update_option( 'gmgt_mailchimp_api', $_REQUEST['gmgt_mailchimp_api']);
// 	$message = "Save Setting Successfully.";
// }
//SAVE MAILCHIMP API DATA
if(isset($_REQUEST['save_setting']))
{
	update_option( 'gmgt_mailchimp_api', esc_attr($_REQUEST['gmgt_mailchimp_api']));
	$message = esc_html__("Setting added successfully.","gym_mgt");
	
}
//ADD Synchronize EMAIL DATA
if(isset($_REQUEST['sychroniz_email']))
{
	$retval = $api->lists();
	$subcsriber_emil = array();
	if(isset($_REQUEST['syncmail']))
	{
		$syncmail = $_REQUEST['syncmail'];
		$class_id_array = implode("','",$syncmail);
		global $wpdb;
		$tbl_class = $wpdb->prefix .'gmgt_member_class';
		$result = $wpdb->get_results("SELECT member_id FROM $tbl_class where class_id IN ('".$class_id_array."')");
		$user_id_array=array();
		if(!empty($result))
		{
			foreach ($result as $retrieved_data)
			{
				$user_id_array[]=$retrieved_data->member_id;
			}
		}
		$user_id_array_unique=array_unique($user_id_array);
		if(!empty($user_id_array_unique))
		{
			foreach ($user_id_array_unique as $data)
			{
				$user_info = get_userdata($data);
				$firstname=get_user_meta($user_info->ID,'first_name',true);
				$lastname=get_user_meta($user_info->ID,'last_name',true);
				if(trim($user_info->user_email) !='')
					$subcsriber_emil[] = array('fname'=>$firstname,'lname'=>$lastname,'email'=>$user_info->user_email); 
			}
		}	
	}
	if(!empty($subcsriber_emil))
	{
		foreach ($subcsriber_emil as $value)
		{	
			/* add subscriber start*/
			$email = sanitize_email($value['email']);
			$status = 'subscribed'; // "subscribed" or "unsubscribed" or "cleaned" or "pending"
			$list_id = sanitize_text_field($_REQUEST['list_id']); // where to get it read above
			$api_key = get_option( 'gmgt_mailchimp_api' ); // where to get it read above
			$merge_fields = array('FNAME'=>$value['fname'], 'LNAME'=>$value['lname']);
			$data = array(
			'apikey'        => $api_key,
			'email_address' => $email,
			'status'        => $status,
			'merge_fields'  => $merge_fields
				);
				$mch_api = curl_init(); // initialize cURL connection
			 
				curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
				curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
				curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
				curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
				curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
				curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
				curl_setopt($mch_api, CURLOPT_POST, true);
				curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
				$result = curl_exec($mch_api);
			/* add subscriber end*/
		}
	}
	$message = "Synchronize Mail Successfully.";
}
//SEND CHAMPING MAIL
if(isset($_REQUEST['send_campign']))
{
	$retval = $api->campaigns();
	$retval1 = $api->lists();
	$emails = array();
	$listId = esc_attr($_REQUEST['list_id']);
	$campaignId =esc_attr($_REQUEST['camp_id']);
	$listmember = $api->listMembers($listId, 'subscribed', null, 0, 5000 );
	foreach($listmember['data'] as $member)
	{
		$emails[] = $member['email'];
	}
	$retval2 = $api->campaignSendTest($campaignId, $emails);
	if ($api->errorCode){
		$message = "Campaign Tests Not Sent!\n";
	} else {
		$message = "Campaign Tests Sent!\n";
	}
}
// if(isset($message))
// {
	?>
	<!-- <div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>
		</button>
		<p><?php echo esc_html($message);?></p>
	</div> -->
	<?php
// }
if(isset($_REQUEST['save_setting']))
{
	if(isset($message))
	{
		?>
			<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>
				</button>
				<p><?php echo esc_html($message);?></p>
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
} );
</script>
<div class="panel-body panel-white padding_0"><!-- PANEL BODY DIV START -->
	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->	
	
		<ul class="nav nav-tabs panel_tabs  mb-3" role="tablist"><!-- NAV TABS MENU START -->
			<li class="<?php if($active_tab=='mailchimp_setting'){?>active<?php }?>">
				<a href="?dashboard=user&page=news_letter&tab=mailchimp_setting" class="nav-tab <?php echo $active_tab == 'mailchimp_setting' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Setting', 'gym_mgt'); ?></a>
			</li>
			<li class="<?php if($active_tab=='sync'){?>active<?php }?>">
				<a href="?dashboard=user&page=news_letter&tab=sync" class="nav-tab <?php echo $active_tab == 'sync' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Sync Mail', 'gym_mgt'); ?></a>
			</li>
			<li class="<?php if($active_tab=='campaign'){?>active<?php }?>">
				<a href="?dashboard=user&page=news_letter&tab=campaign" class="nav-tab responsive_aa<?php echo $active_tab == 'campaign' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Campaign', 'gym_mgt'); ?></a>
			</li>
		</ul><!-- NAV TABS MENU END -->
		<div class="tab-content padding_0"><!-- TAB CONTENT DIV START -->
			<?php
			if($active_tab == 'mailchimp_setting')
			{ ?>
				<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->
					<form name="newsletterform" method="post" id="newsletterform" class="form-horizontal"><!-- MAILCHIMP SETTINGS FORM START -->
						<div class="header">	
							<h3 class="first_hed"><?php esc_html_e('Setting Information','gym_mgt');?></h3>
						</div>
						<div class="form-body user_form"> <!-- user_form Strat-->   
							<div class="row"><!--Row Div Strat--> 

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<div class="form-group input">
										<div class="col-md-12 form-control">
											<input id="gmgt_mailchimp_api" class="form-control" type="text" value="<?php echo get_option( 'gmgt_mailchimp_api' );?>"  name="gmgt_mailchimp_api">
											<label class="" for="wpcrm_mailchimp_api"><?php esc_html_e('Mail Chimp API key','gym_mgt');?></label>
										</div>
									</div>
								</div>
							</div><!--Row Div End--> 
						</div><!-- user_form End--> 

						<?php 
						if($user_access['edit']=='1' OR $user_access['add']=='1' )
						{ ?>	
							<!------------   save btn  -------------->  
							<div class="form-body user_form"> <!-- user_form Strat-->   
								<div class="row"><!--Row Div Strat--> 
									<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  
										<input type="submit" value="<?php esc_html_e('Save', 'gym_mgt' ); ?>" name="save_setting" class="btn save_btn"/>	
									</div>
								</div>
							</div>
							<?php 
						} ?>
					</form><!-- MAILCHIMP SETTINGS FORM END -->
				</div><!-- PANEL BODY DIV END -->
				<?php 
			}
			if($active_tab == 'sync')
			{
				$retval = $api->lists();?>
				<div class="panel-body padding_0"><!-- PANEL BODY DIV START -->
					<form name="template_form" action="" method="post" class="form-horizontal" id="setting_form"><!--Mailing LIST SYNCRONIZE USER FORM STRAT-->
						
						<div class="header">	
							<h3 class="first_hed"><?php esc_html_e('Sync Mail Information','gym_mgt');?></h3>
						</div>
						<div class="form-body user_form"> <!-- user_form Strat-->   
							<div class="row"><!--Row Div Strat--> 


								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">
									<div class="form-group">
										<div class="col-md-12 form-control">
											<div class="row padding_radio">
												<div class="checkbox">
													<label class="custom-top-label" for="enable_quote_tab"><?php esc_html_e('Class List','gym_mgt');?></label>
													<div class="checkbox">
														<div class="row">
															<?php 
															//GET ALL Class DATA
															$classdata=$obj_class->MJ_gmgt_get_all_classes();
															if(!empty($classdata))
															{
																foreach ($classdata as $retrieved_data)
																{?>								
																	<div class="col-md-6 mb-2">
																		<input type="checkbox" class="margin_left_0_res margin_right_5_res margin_right_5" name="syncmail[]"  value="<?php echo esc_attr($retrieved_data->class_id)?>"/><?php echo esc_html($retrieved_data->class_name);?> ( <?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->start_time)).' - '.MJ_gmgt_timeremovecolonbefoream_pm($retrieved_data->end_time);?>)
																	</div>
																<?php 
																}
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">
									<label class="ml-1 custom-top-label top" for="list_id"><?php esc_html_e('Mailing List','gym_mgt');?><span class="require-field">*</span></label>
									<select name="list_id" id="list_id"  class="form-control validate[required]">
										<option value=""><?php esc_html_e('Select list','gym_mgt');?></option>
										<?php 
										//Mailing LIST DATA
										foreach ($retval['data'] as $list)
										{						
											echo '<option value="'.esc_attr($list['id']).'">'.esc_html($list['name']).'</option>';
										}
										?>
									</select>
								</div>

							</div><!--Row Div End--> 
						</div><!-- user_form End--> 
						<?php 
						if($user_access['edit']=='1' OR $user_access['add']=='1' )
						{ 
							?>
							<!------------   save btn  -------------->  
							<div class="form-body user_form"> <!-- user_form Strat-->   
								<div class="row"><!--Row Div Strat--> 
									<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><!--save btn-->    	
										<input type="submit" value="<?php esc_html_e('Sync Mail', 'gym_mgt' ); ?>" name="sychroniz_email" class="btn save_btn"/>
									</div>
								</div><!--Row Div End--> 
							</div><!-- user_form End-->
							<?php 
						} 
						?>
					</form><!--Mailing LIST SYNCRONIZE USER FORM END-->
				</div><!-- PANEL BODY DIV END -->
				<?php 
			}
			if($active_tab == 'campaign')
			{
				$retval = $api->campaigns();
				$retval1 = $api->lists();?>
				<div class="panel-body padding_0"><!-- PANEL BODY DIV STRAT -->
					<form name="student_form" action="" method="post" class="form-horizontal" id="setting_form"><!-- MAILCHIMP FORM START-->
						<div class="header">	
							<h3 class="first_hed"><?php esc_html_e('Campaign Information','gym_mgt');?></h3>
						</div>
						<div class="form-body user_form"> <!-- user_form Strat-->   
							<div class="row"><!--Row Div Strat--> 
								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">
									<label class="ml-1 custom-top-label top" for="quote_form"><?php esc_html_e('Mail Chimp list','gym_mgt');?><span class="require-field">*</span></label>
									<select name="list_id" id="quote_form"  class="form-control validate[required]">
										<option value=""><?php esc_html_e('Select list','gym_mgt');?></option>
										<?php 
										foreach ($retval1['data'] as $list)
										{						
											echo '<option value="'.esc_attr($list['id']).'">'.esc_html($list['name']).'</option>';
										}
										?>
									</select>
								</div>
								<!--nonce-->
								<?php wp_nonce_field( 'send_campign_nonce' ); ?>
								<!--nonce-->
								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">
									<label class="ml-1 custom-top-label top" for="quote_form"><?php esc_html_e('Campaign list','gym_mgt');?><span class="require-field">*</span></label>
									<select name="camp_id" id="quote_form"  class="form-control validate[required]">
										<option value=""><?php esc_html_e('Select Campaign','gym_mgt');?></option>
										<?php 
										foreach ($retval['data'] as $c)
										{						
											echo '<option value="'.esc_attr($c['id']).'">'.esc_html($c['title']).'</option>';
										}
										?>
									</select>
								</div>
							</div><!--Row Div End--> 
						</div><!-- user_form End--> 
						<?php 
						if($user_access['edit']=='1' OR $user_access['add']=='1' )
						{ ?>
							<!------------   save btn  -------------->  
							<div class="form-body user_form"> <!-- user_form Strat-->   
								<div class="row"><!--Row Div Strat--> 
									<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->       	
										<input type="submit" value="<?php esc_html_e('Send Campaign', 'gym_mgt' ); ?>" name="send_campign" class="btn save_btn"/>
									</div>
								</div><!--Row Div End--> 
							</div><!-- user_form End--> 
							<?php 
							} ?>


							<!-- <div class="form-group">
								<div class="mb-3 row">
									<label class="col-sm-2 control-label form-label" for="quote_form"><?php esc_html_e('MailChimp list','gym_mgt');?></label>
									<div class="col-sm-8">
										<select name="list_id" id="quote_form"  class="form-control">
											<option value=""><?php esc_html_e('Select list','gym_mgt');?></option>
											<?php 
											foreach ($retval1['data'] as $list)
											{
												echo '<option value="'.esc_attr($list['id']).'">'.esc_html($list['name']).'</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="mb-3 row">
									<label class="col-sm-2 control-label form-label" for="quote_form"><?php esc_html_e('Campaign list','gym_mgt');?></label>
									<div class="col-sm-8">
										<select name="camp_id" id="quote_form"  class="form-control">
											<option value=""><?php esc_html_e('Select Campaign','gym_mgt');?></option>
											<?php 
											foreach ($retval['data'] as $c)
											{	
												echo '<option value="'.esc_attr($c['id']).'">'.esc_html($c['title']).'</option>';
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<?php if($user_access['edit']=='1' OR $user_access['add']=='1' )
							{ ?>
							<div class="offset-sm-2 col-lg-8 col-md-8 col-sm-8 col-xs-12">        	
								<input type="submit" value="<?php esc_html_e('Send Campaign', 'gym_mgt' ); ?>" name="send_campign" class="btn btn-success"/>
							</div>
							<?php } ?> -->
					</form><!-- MAILCHIMP FORM END-->
				</div><!-- PANEL BODY DIV END -->
			<?php
			}
			?>
		</div><!-- TAB CONTENT DIV END -->
	</div><!--MAIN_LIST_MARGING_15px END  -->
</div><!-- PANEL BODY DIV END -->