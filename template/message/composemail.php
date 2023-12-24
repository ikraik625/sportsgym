<?php

$obj_message= new MJ_gmgt_message;

//SAVE MESSAGE DATA

if(isset($_POST['save_message']))

{

	$nonce = $_POST['_wpnonce'];

	if (wp_verify_nonce( $nonce, 'save_message_nonce' ) )

	{

		$created_date = date("Y-m-d H:i:s");

		$subject = MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($_POST['subject']));

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

		if($role == 'member' || $role == 'staff_member' || $role == 'accountant' || $role == 'administrator')

		{

			$userdata=MJ_gmgt_get_user_notice($role,$_REQUEST['class_id']);

			if(!empty($userdata))

			{

				$mail_id = array();

				$i = 0;

					foreach($userdata as $user)

					{

						if($role == 'parent' && $class_id != 'all')

						$mail_id[]=$user['ID'];

						else 

							$mail_id[]=$user->ID;

						$i++;

					}

				$post_id = wp_insert_post( array(

						'post_status' => 'publish',

						'post_type' => 'message',

						'post_title' => $subject,

						'post_content' =>$message_body

				) );

				foreach($mail_id as $user_id)

				{

					$reciever_id = $user_id;

					$message_data=array('sender'=>get_current_user_id(),

							'receiver'=>$user_id,

							'subject'=>$subject,

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

						'body' => "".$body_data." ".$senderuserdata->display_name." ".$message_body,

						// 'sound' => true,

						'priority' => 'high',

						'vibrate' => [0, 250, 250, 250],

						'data' => ['type' => 'Message'],

					);

				    MJ_gmgt_send_pushnotification($payload);

		              

				    //END SEND PUSH NOTification //



					//-----MESSAGE SEND NOTIFICATION TEMPLATE-------

					 $userdata = get_userdata($user_id);

					 $role=$userdata->roles;

					 $reciverrole=$role[0];

					 if($reciverrole == 'administrator' ) 

					 {

						$page_link=admin_url().'admin.php?page=Gmgt_message&tab=inbox';

					 }

					 else

					 {

						$page_link=home_url().'/?dashboard=user&page=message&tab=inbox';

					 } 

					$gymname=get_option( 'gmgt_system_name' );

					$userdata = get_userdata($user_id);

					

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

				$result=add_post_meta($post_id, 'message_for',$role);

				$result=add_post_meta($post_id, 'gmgt_class_id',$_REQUEST['class_id']);

				$result=add_post_meta($post_id, 'message_attachment',$attachment);

			}

			else

			{

				$post_id = wp_insert_post( array(

					'post_status' => 'publish',

					'post_type' => 'message',

					'post_title' => $subject,

					'post_content' =>$message_body

			

				) );

				$user_id =$_POST['receiver'];

				$message_data=array('sender'=>get_current_user_id(),

						'receiver'=>$user_id,

						'subject'=>$subject,

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

					'body' => "".$body_data." ".$senderuserdata->display_name." ".$message_body,

					// 'sound' => true,

					'priority' => 'high',

					'vibrate' => [0, 250, 250, 250],

					'data' => ['type' => 'Message'],

				);

				MJ_gmgt_send_pushnotification($payload);



				//END SEND PUSH NOTification //





				//-----MESSAGE SEND NOTIFICATION TEMPLATE-------

				$userdata = get_userdata($user_id);

				$role=$userdata->roles;

				$reciverrole=$role[0];

				if($reciverrole == 'administrator' ) 

				{

					$page_link=admin_url().'admin.php?page=Gmgt_message&tab=inbox';

				}

				else

				{

					$page_link=home_url().'/?dashboard=user&page=message&tab=inbox';

				} 

				$gymname=get_option( 'gmgt_system_name' );

				$userdata = get_userdata($user_id);

				

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

				$result=add_post_meta($post_id, 'message_for','user');

				$result=add_post_meta($post_id, 'message_gmgt_user_id',$user_id);

				$result=add_post_meta($post_id, 'message_attachment',$attachment);

			}

		}

		else

		{

			$post_id = wp_insert_post( array(

					'post_status' => 'publish',

					'post_type' => 'message',

					'post_title' => $subject,

					'post_content' =>$message_body

			) );

			$user_id =$_POST['receiver'];

			$message_data=array('sender'=>get_current_user_id(),

					'receiver'=>$user_id,

					'subject'=>$subject,

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

				 'body' => "".$body_data." ".$senderuserdata->display_name." ".$message_body,

				 // 'sound' => true,

				 'priority' => 'high',

				 'vibrate' => [0, 250, 250, 250],

				 'data' => ['type' => 'Message'],

			);



			MJ_gmgt_send_pushnotification($payload);

			//END SEND PUSH NOTification //





			//-----MESSAGE SEND NOTIFICATION-------

			$userdata = get_userdata($user_id);

			$role=$userdata->roles;

			$reciverrole=$role[0];

			if($reciverrole == 'administrator' ) 

			{

				$page_link=admin_url().'admin.php?page=Gmgt_message&tab=inbox';

			}

			else

			{

				$page_link=home_url().'/?dashboard=user&page=message&tab=inbox';

			} 

			$gymname=get_option( 'gmgt_system_name' );

			$userdata = get_userdata($user_id);

			

			

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

	

			$result=add_post_meta($post_id, 'message_for','user');

			$result=add_post_meta($post_id, 'message_gmgt_user_id',$user_id);

			$result=add_post_meta($post_id, 'message_attachment',$attachment);

		}

	}

}

if(isset($result))

{ ?>

	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">

		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>

		</button>

		<p><?php esc_html_e('Message Sent Successfully!','gym_mgt');?></p>

	</div>

	<?php 

}	

?>

<script type="text/javascript">

	$(document).ready(function() 

	{

		"use strict";

		$('#message_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

		jQuery("body").on("change", ".input-file[type=file]", function ()

		{ 

			"use strict";

			var file = this.files[0]; 		

			var ext = $(this).val().split('.').pop().toLowerCase(); 

			//Extension Check 

			if($.inArray(ext, [,'pdf','doc','docx','xls','xlsx','ppt','pptx','gif','png','jpg','jpeg','']) == -1)

			{

				alert('<?php esc_html_e("Only pdf,doc,docx,xls,xlsx,ppt,pptx,gif,png,jpg,jpeg formate are allowed.","gym_mgt") ?>');

				$(this).replaceWith('<input class="btn_top input-file" name="message_attachment[]" type="file" />');

				return false; 

			} 

			//File Size Check 

			if (file.size > 20480000) 

			{

				alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','gym_mgt');?>");

				$(this).replaceWith('<input class="btn_top input-file" name="message_attachment[]" type="file" />'); 

				return false; 

			}

		});	
		$(".display-members").select2();

	} );

	function add_new_attachment()

	{

		$(".attachment_div").append('<div class="row"><div class="col-md-10"><div class="form-group input"><div class="col-md-12 form-control input_height_47px"><label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="photo"><?php esc_html_e('Attachment','gym_mgt');?></label><div class="col-sm-12"><input  class="col-md-12 input-file" name="message_attachment[]" type="file" /></div></div></div></div><div class="col-sm-2 mb-3 rtl_margin_top_15px"><input type="image" onclick="delete_attachment(this)" alt="" src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" class="remove_cirtificate doc_label float_right input_btn_height_width"></div></div>');

	}

	function delete_attachment(n)

	{

		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);				

	}

</script>

<div class="mailbox-content padding_0"><!-- MAILBOX CONTENT DIV START -->

	<h2>

		<?php  

		$edit=0;

		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

		{

			 echo esc_html__( 'Edit Message', 'gym_mgt');

			 $edit=1;

			 $exam_data= get_exam_by_id($_REQUEST['exam_id']);

		}

		?>

	</h2>

	<?php

	$msg_url= GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png";

	if(isset($message))

		// echo '<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert"><button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="'.$msg_url.'" alt=""></span></button><p>'.$message.'</p></div>';

	?>

	<form name="class_form" action="" method="post" class="form-horizontal padding_bottom_50" id="message_form" enctype="multipart/form-data"><!-- COMPOSE MAIL FORM START -->

		<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

		

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

					<!-- <label class="ml-1 custom-top-label top" for="to"><?php esc_html_e('Message To','gym_mgt');?><span class="require-field">*</span></label> -->

					<select name="receiver" class="form-control validate[required] text-input message_to display-members" id="to">

						<?php

						$curr_user_id=get_current_user_id();

						$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



						$role = $obj_gym->role;

						if($role == 'member')

						{

						?>

						<option value=""><?php esc_html_e('Select User','gym_mgt');?></option>

						<?php 

						}

						else

						{ ?>

						<option value="member"><?php esc_html_e('Members','gym_mgt');?></option>

						<option value="staff_member"><?php esc_html_e('Staff Members','gym_mgt');?></option>

						<option value="accountant"><?php esc_html_e('Accountant','gym_mgt');?></option>

						<option value="administrator"><?php esc_html_e('Admin','gym_mgt');?></option>

						<?php 

						}

						echo MJ_gmgt_get_all_user_in_message();

						?>

					</select>

				</div>

				<?php

				if($role != 'member')

				{

					?>

					<div id="smgt_select_class" class="display_class_css col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

						<label class="ml-1 custom-top-label top" for="sms_template"><?php esc_html_e('Select Class','gym_mgt');?></label>

						<select name="class_id"  id="class_list" class="form-control">

							<option value="all"><?php esc_html_e('All','gym_mgt');?></option>

							<?php

							foreach(MJ_gmgt_get_allclass() as $classdata)

							{  

								?>

								<option  value="<?php echo esc_attr($classdata['class_id']);?>" ><?php echo esc_html($classdata['class_name']);?></option>

								<?php 

							}?>

						</select>

					</div>

					<?php

				}

				?>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="subject" class="form-control validate[required,custom[popup_category_validation]] onlyletter_number_space_validation" type="text" maxlength="100" name="subject" value="<?php if($edit){ echo $exam_data->exam_date;}?>">

							<label class="" for="subject"><?php esc_html_e('Subject','gym_mgt');?><span class="require-field">*</span></label>

						</div>

					</div>

				</div>

				<!--nonce-->

				<?php wp_nonce_field( 'save_message_nonce' ); ?>

				<!--nonce-->

				<div class="col-md-6 note_text_notice">

					<div class="form-group input">

						<div class="col-md-12 note_border margin_bottom_15px_res">

							<div class="form-field">

								<textarea name="message_body" id="message_body" class="textarea_height_47px form-control validate[required]" maxlength="500"><?php if($edit){ echo esc_textarea($exam_data->exam_comment);}?></textarea>

								<span class="txt-title-label"></span>

								<label class="text-area address activ" for="subject"><?php esc_html_e('Message Comment','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

				</div>

			</div><!--Row Div End--> 

		</div><!-- user_form End--> 

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-md-6 attachment_div">

					<div class="row">

						<div class="col-md-10">	

							<div class="form-group input">

								<div class="col-md-12 form-control input_height_47px">	

									<label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="photo"><?php esc_html_e('Attachment','gym_mgt');?></label>

									<div class="col-sm-12">	

										<input  class="col-md-12 input-file " name="message_attachment[]" type="file" />

									</div>

								</div>

							</div>

						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 mb-3 rtl_margin_top_15px">	

							<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_new_attachment()" alt="" class="more_attachment add_cirtificate float_right" id="add_more_sibling">

							<!-- <input type="button" value="<?php esc_html_e('Add More Attachment','gym_mgt') ?>"  onclick="add_new_attachment()" class="btn more_attachment btn-primary"> -->

						</div>

					</div>

				</div>	

			</div><!--Row Div End--> 

		</div><!-- user_form End--> 



		<!------------   save btn  -------------->  

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  	

					<input type="submit" value="<?php if($edit){ esc_html_e('Save Message','gym_mgt'); }else{ esc_html_e('Send Message','gym_mgt');}?>" name="save_message" class="btn save_btn"/>

				</div>

			</div><!--Row Div End--> 

		</div><!-- user_form End--> 



	</form><!-- COMPOSE MAIL FORM END -->

</div><!-- MAILBOX CONTENT DIV END -->