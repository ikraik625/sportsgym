<?php

//MESSAGE CLASS START    

class MJ_gmgt_message

{

	/*-------DELETE MESSAGE FUNCTION------------*/

	public function MJ_gmgt_delete_message($mid)

	{

		global $wpdb;

		$table_gmgt_message = $wpdb->prefix. 'Gmgt_message';

		$result = $wpdb->query("DELETE FROM $table_gmgt_message where message_id= ".$mid);

		$receiver =$wpdb->get_row("SELECT receiver  FROM $table_name where message_id = $mid");

		$user_data = get_userdata($receiver);

		gym_append_audit_log(''.esc_html__('Message Deleted','gym_mgt').' ('.$user_data->display_name.')',$mid,get_current_user_id(),'delete',$_REQUEST['page']);

		return $result;

	}

	/*-------COUNT SEND MESSAGES------------*/

	public function MJ_gmgt_count_send_item($user_id)

	{

		global $wpdb;

		$posts = $wpdb->prefix."posts";

		$total =$wpdb->get_var("SELECT Count(*) FROM ".$posts." Where post_type = 'hmgt_message' AND post_author = $user_id");

		return $total;

	}

	// LOAD Multiple DOCUMENTS 

	public function MJ_gmgt_load_multiple_documets($file,$type,$nm)

	{	

		$parts = pathinfo($type['name']);

		

		$inventoryimagename = time()."-".rand().".".isset($parts['extension']);

		$document_dir = WP_CONTENT_DIR;

		$document_dir .= '/uploads/gym_assets/';

		$document_path = $document_dir;

		if (!file_exists($document_path)) {

			mkdir($document_path, 0777, true);		

		}

		$imagepath="";	

		if (move_uploaded_file($type['tmp_name'], $document_path.$inventoryimagename)) 

		{

			 $imagepath= $inventoryimagename; 

		}

		return $imagepath;

	}

	/*----------SEND REPLAY MESSAGES-------------*/

	public function MJ_gmgt_send_replay_message($data)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_message_replies";

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

				$upload_docs_array[]=MJ_gmgt_load_multiple_documets($value,$value,$get_file_name);				

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

		$result='';

		if(!empty($data['receiver_id']))

		{

			foreach($data['receiver_id'] as $receiver_id)

			{

				$messagedata['message_id'] = sanitize_text_field($data['message_id']);

				$messagedata['sender_id'] = sanitize_text_field($data['user_id']);

				$messagedata['receiver_id'] = sanitize_text_field($receiver_id);

				$messagedata['message_comment'] = MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['replay_message_body']));

				$messagedata['message_attachment'] =$attachment;

				$messagedata['status'] =0;

				$messagedata['created_date'] = date("Y-m-d h:i:s");

			}

		}

		$result=$wpdb->insert( $table_name, $messagedata );

		$senderuserdata = get_userdata(sanitize_text_field($data['user_id']));

		//$receiverdata = get_userdata(sanitize_text_field($data['receiver_id']));

		//Send PUSH Notification APP //

			$title= esc_attr__("You have received new message.","gym_mgt");

			$body_data=esc_attr__("You have received new message from","gym_mgt");

		 	$device_token=get_user_meta( $data['receiver_id'], 'device_token',true); 



			$payload = array(

				 'to' => $device_token,

				 'sound' => 'default',

				 'title'=> $title,

				 'body' => "".$body_data." ".$senderuserdata->display_name." ".$data['replay_message_body'],

				 // 'sound' => true,

				 'priority' => 'high',

				 'vibrate' => [0, 250, 250, 250],

				 'data' => ['type' => 'Message'],

			);

			MJ_gmgt_send_pushnotification($payload);



		//END SEND PUSH NOTification //



		   	$gymname=get_option( 'gmgt_system_name' );

			$userdata = get_userdata(sanitize_text_field($data['receiver_id']));

			

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

		

			$arr['[GMGT_RECEIVER_NAME]']=MJ_gmgt_get_user_full_display_name($data['receiver_id']);	

			$arr['[GMGT_GYM_NAME]']=$gymname;

			$arr['[GMGT_SENDER_NAME]']=MJ_gmgt_get_user_full_display_name($data['user_id']);

			$arr['[GMGT_MESSAGE_CONTENT]']=MJ_gmgt_strip_tags_and_stripslashes($data['replay_message_body']);

			$arr['[GMGT_MESSAGE_LINK]']=$page_link;

			$subject =get_option('message_received_subject');

			$sub_arr['[GMGT_SENDER_NAME]']=MJ_gmgt_get_user_full_display_name($data['user_id']);;

			$sub_arr['[GMGT_GYM_NAME]']=$gymname;

			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);

			$message = get_option('message_received_template');	

			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);

				$to[]=$userdata->user_email;

				MJ_gmgt_send_mail($to,$subject,$message_replacement);

			if($result)	

		return $result;		

	}

	/*---------FETCH ALL REPLAY--------------------*/

	public function MJ_gmgt_get_all_replies($id)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_message_replies";

		return $result =$wpdb->get_results("SELECT *  FROM $table_name where message_id = $id");

	}

	/*-------COUNT REPLAY MESSAGE------------*/

	public function MJ_gmgt_count_reply_item($id)

	{

		global $wpdb;

		$tbl_name = $wpdb->prefix .'gmgt_message_replies';

		

		$result=$wpdb->get_var("SELECT count(*)  FROM $tbl_name where message_id = $id");

		return $result;

	}

	/*-------DELETE REPLAY MESSAGE------------*/

	public function MJ_gmgt_delete_reply($id)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_message_replies";

		$reply_id['id']=$id;

		return $result=$wpdb->delete( $table_name, $reply_id);

	}	

}

//MESSAGE CLASS END

?>