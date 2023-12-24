<?php 

$obj_message= new MJ_gmgt_message;

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

	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('message');

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

			if ('message' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))

			{

				if($user_access_edit=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}			

			}

			if ('message' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))

			{

				if($user_access_delete=='0')

				{	

					MJ_gmgt_access_right_page_not_access_message_for_management();

					die;

				}	

			}

			if ('message' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))

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

//SAVE MESSAGE DATA

if(isset($_POST['save_message']))

{

	$nonce = $_POST['_wpnonce'];

	if (wp_verify_nonce( $nonce, 'save_message_nonce' ) )

	{

		$created_date = date("Y-m-d H:i:s");

		$subject_post = MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($_POST['subject']));

		$message_body = MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($_POST['message_body']));

		$created_date = date("Y-m-d H:i:s");

		$tablename="Gmgt_message";

		$role=$_POST['receiver'];

		if(isset($_REQUEST['class_id']))

		$class_id = esc_attr($_REQUEST['class_id']);

		$upload_docs_array=array();

		if(!empty($_FILES['message_attachment']['name']))

		{

			$count_array=count($_FILES['message_attachment']['name']);

			for($a=0;$a<$count_array;$a++)

			{			

				foreach($_FILES['message_attachment'] as $image_key=>$image_val)

				{		

					$document_array[$a]=array(

					'name'=>$_FILES['message_attachment']['name'][$a],

					'type'=>$_FILES['message_attachment']['type'][$a],

					'tmp_name'=>$_FILES['message_attachment']['tmp_name'][$a],

					'error'=>$_FILES['message_attachment']['error'][$a],

					'size'=>$_FILES['message_attachment']['size'][$a]

					);							

				}

			}				

			foreach($document_array as $key=>$value)		

			{	

				$get_file_name=$document_array[$key]['name'];

				$upload_docs_array[]=$obj_message->MJ_gmgt_load_multiple_documets($value,$value,$get_file_name);				

			} 				

		}

		$upload_docs_array_filter=array_filter($upload_docs_array);	

		if(!empty($upload_docs_array_filter))

		{

			$attachment=implode(',',$upload_docs_array_filter);

		}

		else

		{

			$attachment='';

		}

		if($role == 'member' || $role == 'staff_member' || $role == 'accountant')

		{			

			$userdata=MJ_gmgt_get_user_notice($role,esc_attr($_REQUEST['class_id']));

			if(!empty($userdata))

			{		

				$mail_id = array();

				$i = 0;

				foreach($userdata as $user)

				{

					if($role == 'parent' && $class_id != 'all')

					{

						$mail_id[]=$user['ID'];

					}

					else

					{ 

						$mail_id[]=$user->ID;						

					}

					$i++;

				}

				$post_id = wp_insert_post( array(

					'post_status' => 'publish',

					'post_type' => 'message',

					'post_title' => $subject_post,

					'post_content' =>$message_body

				) );	

				foreach($mail_id as $user_id)

				{

					$reciever_id = $user_id;

					$message_data=array('sender'=>get_current_user_id(),

						'receiver'=>$user_id,

						'subject'=>$subject_post,

						'message_body'=>$message_body,

						'date'=>$created_date,

						'status' =>0,

						'post_id' =>$post_id

					);

					MJ_gmgt_insert_record($tablename,$message_data);

					$senderuserdata = get_userdata(get_current_user_id());



					//Send PUSH Notification APP //



					$device_token=get_user_meta( $user_id, 'device_token',true); 



					



				     $title= esc_attr__("You have received new message.","gym_mgt");



		             $body_data=esc_attr__("You have received new message from","gym_mgt");



		 



		                    $payload = array(



				            'to' => $device_token,



				            'sound' => 'default',



				            'title'=> $title,



				            'body' => "".$body_data." ".MJ_gmgt_get_user_full_display_name(get_current_user_id())." ".$message_body,



				            // 'sound' => true,



				            'priority' => 'high',



				            'vibrate' => [0, 250, 250, 250],



				            'data' => ['type' => 'Message'],



				        );



				    MJ_gmgt_send_pushnotification($payload);     



				    //END SEND PUSH NOTification //



					//-----MESSAGE SEND NOTIFICATION-------

					$gymname=get_option( 'gmgt_system_name' );

					$userdata = get_userdata($user_id);

					

					$page_link=home_url().'/?dashboard=user&page=message&tab=inbox';

					$arr['[GMGT_RECEIVER_NAME]']=MJ_gmgt_get_user_full_display_name($user_id);	

					$arr['[GMGT_GYM_NAME]']=$gymname;

					$arr['[GMGT_SENDER_NAME]']=MJ_gmgt_get_user_full_display_name(get_current_user_id());

					$arr['[GMGT_MESSAGE_CONTENT]']=$message_body;

					$arr['[GMGT_MESSAGE_LINK]']=$page_link;

					$subject =get_option('message_received_subject');

					$sub_arr['[GMGT_SENDER_NAME]']=MJ_gmgt_get_user_full_display_name(get_current_user_id());

					$sub_arr['[GMGT_GYM_NAME]']=$gymname;

					$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);

					$message_template = get_option('message_received_template');	

					$message_replacement = MJ_gmgt_string_replacemnet($arr,$message_template);

					$to=$userdata->user_email;

					MJ_gmgt_send_mail($to,$subject,$message_replacement);

				}

					$result=add_post_meta($post_id, 'message_for',$role);

					$result=add_post_meta($post_id, 'gmgt_class_id',$_REQUEST['class_id']);

					$result=add_post_meta($post_id, 'message_attachment',$attachment);

			}

			else

			{

				$post_id = wp_insert_post( array(

					'post_status' => 'publish',

					'post_type' => 'message',

					'post_title' => $subject_post,

					'post_content' =>$message_body

				

				) );

				$user_id =$_POST['receiver'];

				$message_data=array('sender'=>get_current_user_id(),

					'receiver'=>$user_id,

					'subject'=>$subject_post,

					'message_body'=>$message_body,

					'date'=>$created_date,

					'status' =>0,

					'post_id' =>$post_id

				);

				MJ_gmgt_insert_record($tablename,$message_data);

				$result=add_post_meta($post_id, 'message_for','user');

				$result=add_post_meta($post_id, 'message_gmgt_user_id',$user_id);

				$result=add_post_meta($post_id, 'message_attachment',$attachment);

				$senderuserdata = get_userdata(get_current_user_id());



				//Send PUSH Notification APP //

				$device_token=get_user_meta( $user_id, 'device_token',true); 



				$title= esc_attr__("You have received new message.","gym_mgt");

				$body_data=esc_attr__("You have received new message from","gym_mgt");



					 $payload = array(

					 'to' => $device_token,

					 'sound' => 'default',

					 'title'=> $title,

					 'body' => "".$body_data." ".MJ_gmgt_get_user_full_display_name(get_current_user_id())." ".$message_body,

					 // 'sound' => true,

					 'priority' => 'high',

					 'vibrate' => [0, 250, 250, 250],

					 'data' => ['type' => 'Message'],



				);



				MJ_gmgt_send_pushnotification($payload);



				 $response = curl_exec($curl);

				 $err = curl_error($curl);

				 curl_close($curl);



				//END SEND PUSH NOTification //





				//-----MESSAGE SEND NOTIFICATION-------

					$gymname=get_option( 'gmgt_system_name' );

					$userdata = get_userdata($user_id);

					

					$page_link=home_url().'/?dashboard=user&page=message&tab=inbox';

					$arr['[GMGT_RECEIVER_NAME]']=MJ_gmgt_get_user_full_display_name($user_id);	

					$arr['[GMGT_GYM_NAME]']=$gymname;

					$arr['[GMGT_SENDER_NAME]']=MJ_gmgt_get_user_full_display_name(get_current_user_id());

					$arr['[GMGT_MESSAGE_CONTENT]']=$message_body;

					$arr['[GMGT_MESSAGE_LINK]']=$page_link;

					$subject =get_option('message_received_subject');

					$sub_arr['[GMGT_SENDER_NAME]']=MJ_gmgt_get_user_full_display_name(get_current_user_id());;

					$sub_arr['[GMGT_GYM_NAME]']=$gymname;

					$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);

					$message_template = get_option('message_received_template');	

					$message_replacement = MJ_gmgt_string_replacemnet($arr,$message_template);

						$to=$userdata->user_email;

							MJ_gmgt_send_mail($to,$subject,$message_replacement);

			}

		}

		else

		{

			$user_id =sanitize_text_field($_POST['receiver']);

			$post_id = wp_insert_post( array(

				'post_status' => 'publish',

				'post_type' => 'message',

				'post_title' => $subject_post,

				'post_content' =>$message_body

			) );

			$message_data=array('sender'=>get_current_user_id(),

				'receiver'=>$user_id,

				'subject'=>$subject_post,

				'message_body'=>$message_body,

				'date'=>$created_date,

				'status' =>0,

				'post_id' =>$post_id

			);

			MJ_gmgt_insert_record($tablename,$message_data);

			$result=add_post_meta($post_id, 'message_for','user');

			$result=add_post_meta($post_id, 'message_gmgt_user_id',$user_id);

			$result=add_post_meta($post_id, 'message_attachment',$attachment);

			$senderuserdata = get_userdata(get_current_user_id());



			//Send PUSH Notification APP //

				$device_token=get_user_meta( $user_id, 'device_token',true); 

				$title= esc_attr__("You have received new message.","gym_mgt");

			 	$body_data=esc_attr__("You have received new message from","gym_mgt");

				   $payload = array(

				   'to' => $device_token,

				   'sound' => 'default',

				   'title'=> $title,

				   'body' => "".$body_data." ".MJ_gmgt_get_user_full_display_name(get_current_user_id())." ".$message_body,

				   // 'sound' => true,

				   'priority' => 'high',

				   'vibrate' => [0, 250, 250, 250],

				   'data' => ['type' => 'Message'],

			   );



				MJ_gmgt_send_pushnotification($payload);



		    //END SEND PUSH NOTification //





			//-----MESSAGE SEND NOTIFICATION-------

			$gymname=get_option( 'gmgt_system_name' );

			$userdata = get_userdata($user_id);

			

			$page_link=home_url().'/?dashboard=user&page=message&tab=inbox';

			$arr['[GMGT_RECEIVER_NAME]']=MJ_gmgt_get_user_full_display_name($user_id);	

			$arr['[GMGT_GYM_NAME]']=$gymname;

			$arr['[GMGT_SENDER_NAME]']=MJ_gmgt_get_user_full_display_name(get_current_user_id());

			$arr['[GMGT_MESSAGE_CONTENT]']=$message_body;

			$arr['[GMGT_MESSAGE_LINK]']=$page_link;

			$subject =get_option('message_received_subject');

			$sub_arr['[GMGT_SENDER_NAME]']=MJ_gmgt_get_user_full_display_name(get_current_user_id());

			$sub_arr['[GMGT_GYM_NAME]']=$gymname;

			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);

			$message_template = get_option('message_received_template');	

			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message_template);

			$to=$userdata->user_email;

					MJ_gmgt_send_mail($to,$subject,$message_replacement);	

		}	

	}

}

$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'inbox';

?>

<script type="text/javascript">

	$(document).ready(function()

	{

		"use strict";

		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

		$('.sdate').datepicker({dateFormat: "yy-mm-dd"}); 

		$('.edate').datepicker({dateFormat: "yy-mm-dd"});  

	} );

</script>

<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

		<?php

		if(isset($result))

		{ ?>

			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">

				<p><?php esc_html_e('Message Sent Successfully!','gym_mgt');?></p>

				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>

			</div>

			<?php

		}	

		?>

		<div class="row"><!-- ROW DIV START-->

			<div class="col-md-12 padding_0"><!-- COL 12 DIV START-->

				<div class="panel-body "><!-- PANEL BODY DIV START-->

					<!-- <div class="row mailbox-header">

						<div class="col-md-2 col-sm-3 col-xs-4">

							<a class="btn btn-success btn-block" href="?page=Gmgt_message&tab=compose"><?php esc_html_e('Compose','gym_mgt');?></a>

						</div>

						<div class="col-md-10 col-sm-9 col-xs-8">

							<h2><?php

								if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox'))

								{

									echo esc_html__('Inbox','gym_mgt');

								}

								elseif(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'sentbox')

								{

									echo esc_html__('Sent Item','gym_mgt');

								}

								elseif(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'compose')

								{

									echo esc_html__('Compose','gym_mgt');

								}

								?>

							</h2>

						</div>                               

					</div>		 -->

					<!-- <div class="col-md-12 padding_0"> -->

						<ul class="nav nav-tabs panel_tabs margin_left_1per list-unstyled mailbox-nav">

							<li <?php if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox')){?>class="active"<?php }?>>

								<a href="?page=Gmgt_message&tab=inbox" class="gmgt_inbox_tab"><?php esc_html_e('Inbox','gym_mgt');?>

									<span class="gmgt_inbox_count_number badge font_weight_700 badge-success pull-right">

										<?php echo MJ_gmgt_count_unread_message(get_current_user_id());?>

									</span>

								</a>

							</li>

							<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox'){?>class="active"<?php }?>>

								<a href="?page=Gmgt_message&tab=sentbox"><?php esc_html_e('Sent','gym_mgt');?></a>

							</li>   

							</li>

							<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'compose'){?>class="active"<?php }?>>

								<a href="?page=Gmgt_message&tab=compose" class="padding_left_0 tab"><?php esc_attr_e('Compose','gym_mgt');?></a>

							</li>	              

						</ul>

					<!-- </div> -->

					<!-- <div class="col-md-10 float_left float_unset_Res"> -->

						<?php  

							if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox')

							{

								require_once GMS_PLUGIN_DIR. '/admin/message/sendbox.php';

							}

							if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox'))

							{

								require_once GMS_PLUGIN_DIR. '/admin/message/inbox.php';

							}

							if(isset($_REQUEST['tab']) && ($_REQUEST['tab'] == 'compose'))

							{

								require_once GMS_PLUGIN_DIR. '/admin/message/composemail.php';

							}

							if(isset($_REQUEST['tab']) && ($_REQUEST['tab'] == 'view_message'))

							{

								require_once GMS_PLUGIN_DIR. '/admin/message/view_message.php';

							}

						?>

				</div><!-- PANEL BODY DIV END-->

			</div><!-- COL 12 DIV END-->

		</div><!-- ROW DIV END-->

		

	</div><!--MAIN_LIST_MARGING_15px END  -->

</div><!-- Page-inner END-->