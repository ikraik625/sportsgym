<?php 
$obj_class=new MJ_gmgt_classschedule;
$apikey = get_option('gmgt_mailchimp_api');
$api = new MJ_gmgt_GYM_MCAPI();
$result=$api->MCAPI($apikey);
$api->useSecure(true);
$active_tab = isset($_GET['tab'])?$_GET['tab']:'mailchimp_setting';
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
	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('news_letter');
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
			if ('news_letter' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
			{
				if($user_access_edit=='0')
				{	
					MJ_gmgt_access_right_page_not_access_message_for_management();
					die;
				}			
			}
			if ('news_letter' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
			{
				if($user_access_delete=='0')
				{	
					MJ_gmgt_access_right_page_not_access_message_for_management();
					die;
				}	
			}
			if ('news_letter' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
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
<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->
	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->
		<?php 
		//SAVE MAILCHIMP API DATA
		if(isset($_REQUEST['save_setting']))
		{
			update_option( 'gmgt_mailchimp_api', esc_attr($_REQUEST['gmgt_mailchimp_api']));
			$message = esc_html__("Setting added successfully.","gym_mgt");
		}
		//SYNCRONIZE USER EMAIL WITH MAILCHIMP
		if(isset($_REQUEST['sychroniz_email']))
		{
			$retval = $api->lists();
			$subcsriber_emil = array();
			if(isset($_REQUEST['syncmail']))
			{
				$syncmail = esc_attr($_REQUEST['syncmail']);
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
						{
							$subcsriber_emil[] = array('fname'=>$firstname,'lname'=>$lastname,'email'=>$user_info->user_email); 
						}
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
					$list_id = esc_attr($_REQUEST['list_id']); // where to get it read above
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
			$message = esc_html__("Synchronize Mail Successfully.","gym_mgt");
		}
		//SEND MAILCHIMP
		if(isset($_REQUEST['send_campign']))
		{
			$nonce = $_POST['_wpnonce'];
			if (wp_verify_nonce( $nonce, 'send_campign_nonce' ) )
			{
				$retval = $api->campaigns();
				$retval1 = $api->lists();
				$emails = array();
				$listId = esc_attr($_REQUEST['list_id']);
				$campaignId =esc_attr($_REQUEST['camp_id']);
				$listmember = $api->listMembers($listId, 'subscribed', null, 0, 5000 );
				foreach($listmember['data'] as $member)
				{			
					$emails[] = sanitize_email($member['email']);
				}
				$retval2 = $api->campaignSendTest($campaignId, $emails);
				if ($api->errorCode)
				{			
					$message = esc_html__("Campaign Tests Not Sent!","gym_mgt");
				} 
				else 
				{
					$message = esc_html__("Campaign Tests Sent!","gym_mgt");
				}
			}
		}
		if(isset($message))
		{
		?>
			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">
				<p><?php echo esc_html($message);?></p>
				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>
			</div>
		<?php 
		}
		?>
		<div class="row"><!-- ROW DIV START-->
			<div class="col-md-12 padding_0"><!-- COL 12 DIV START-->
				<div class="panel-body "><!-- PANEL BODY DIV START-->
					<ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->
						<li class="<?php if($active_tab=='mailchimp_setting'){?>active<?php }?>">
							<a href="?page=gmgt_newsletter&tab=mailchimp_setting" class="padding_left_0 tab <?php echo $active_tab == 'mailchimp_setting' ? 'nav-tab-active' : ''; ?>">
							<?php echo esc_html__('Setting', 'gym_mgt'); ?></a>
						</li>
						<li class="<?php if($active_tab=='sync'){?>active<?php }?>">
							<a href="?page=gmgt_newsletter&tab=sync" class="padding_left_0 tab <?php echo $active_tab == 'sync' ? 'nav-tab-active' : ''; ?>">
							<?php esc_html_e('Sync Mail', 'gym_mgt'); ?></a>
						</li>
						<li class="<?php if($active_tab=='campaign'){?>active<?php }?>">
							<a href="?page=gmgt_newsletter&tab=campaign" class="padding_left_0 tab <?php echo $active_tab == 'campaign' ? 'nav-tab-active' : ''; ?>">
							<?php echo esc_html__('Campaign', 'gym_mgt'); ?></a>
						</li>
					</ul><!-- NAV TAB WRAPPER MENU END-->
					<?php 						
					if($active_tab == 'mailchimp_setting')
					{ ?>
						<div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->
							<form name="newsletterform" method="post" id="newsletterform" class="form-horizontal"><!--NEWSSLETER FORM STRAT-->
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
								if($user_access_add == '1')
								{
									?>
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
							</form><!--NEWSSLETER FORM END-->
						</div><!--PANEL BODY DIV END-->
					<?php 
					}
					if($active_tab == 'sync')
					{
						require_once GMS_PLUGIN_DIR. '/admin/news-letter/sync.php';
					}
					if($active_tab == 'campaign')
					{
						require_once GMS_PLUGIN_DIR. '/admin/news-letter/campaign.php';
					}
					?>
				</div><!-- PANEL BODY DIV END-->
			</div><!-- COL 12 DIV END-->
		</div><!-- ROW DIV END-->

	</div><!--MAIN_LIST_MARGING_15px END  -->
</div><!-- PAGE INNNER DIV END-->