<?php   

//Nutrition CLASS START 

class MJ_gmgt_nutrition

{	

	//ADD Nutrition DATA

	public function MJ_gmgt_add_nutrition($data)

	{

		global $wpdb;

		$table_nutrition = $wpdb->prefix. 'gmgt_nutrition';

		$nutritiondata['user_id']=sanitize_text_field($data['member_id']);		

		$nutritiondata['start_date']=date('Y-m-d',strtotime(sanitize_text_field($data['start_date'])));

		$nutritiondata['expire_date']=date('Y-m-d',strtotime(sanitize_text_field($data['end_date'])));

		$nutritiondata['created_date']=date("Y-m-d");

		$nutritiondata['created_by']=get_current_user_id();

		$phpobj = array();

		foreach($data['nutrition_list'] as $val)

		{

			$data_value = json_decode($val);

			$phpobj[] = json_decode(stripslashes($val),true);

		}

		$j=0;

		$final_array = array();

		$resultarray =array();

		foreach($phpobj as $key => $val)

		{			

			$day = array();

			$activity = array();

			foreach($val as $key=>$key_val)

			{				

				if($key == "days")

				foreach($key_val as $val1)

				{

					$day['day'][] =$val1['day_name'] ;

				}

				if($key == "activity")

				foreach($key_val as $val2)

				{	

					$activity['activity'][] =array('activity'=>$val2['activity']['activity'],

												'value'=>stripslashes($val2['activity']['value'])										

					);

				}				

			}

			$resultarray[] = array_merge($day, $activity);

		}

		if($data['action']=='edit')

		{

			$productid['id']=sanitize_text_field($data['nutrition_id']);

			$result=$wpdb->update( $table_nutrition, $nutritiondata ,$productid);

			$user_data = get_userdata($data['member_id']);

			gym_append_audit_log(''.esc_html__('Nutrition Updated','gym_mgt').' ('.$user_data->display_name.')',$data['nutrition_id'],get_current_user_id(),'edit',$_REQUEST['page']);

			return $result;

		}

		else

		{

			$result=$wpdb->insert( $table_nutrition, $nutritiondata );

			$nutrition_id = $wpdb->insert_id;

			$user_data = get_userdata($data['member_id']);

			gym_append_audit_log(''.esc_html__('Nutrition Added','gym_mgt').' ('.$user_data->display_name.')',$nutrition_id,get_current_user_id(),'insert',$_REQUEST['page']);

			$this->MJ_gmgt_nutrition_detail($nutrition_id,$resultarray);

			$userdata=get_userdata(sanitize_text_field($data['member_id']));

			$username=$userdata->display_name;

			$useremail=$userdata->user_email;

			$gymname=get_option( 'gmgt_system_name' );

		    $page_link='<a href='.home_url().'?gym-management/?dashboard=user&page=nutrition>View Nutrition</a>';

			$arr['[GMGT_MEMBERNAME]']=$username;	

			$arr['[GMGT_GYM_NAME]']=$gymname;

			$arr['[GMGT_STARTDATE]']=$nutritiondata['start_date'];

			$arr['[GMGT_ENDDATE]']=$nutritiondata['expire_date'];

			$arr['[GMGT_PAGE_LINK]']=$page_link;

			$subject =get_option('Assign_Nutrition_Schedule_Subject');

			$sub_arr['[GMGT_GYM_NAME]']=$gymname;

			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);

			$message = get_option('Assign_Nutrition_Schedule_Template');

			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);			

            $invoice=MJ_gmgt_asign_nutristion_content_send_mail($nutrition_id);		 

            $invoic_concat=$message_replacement. $invoice;				

			$to[]=$useremail;

		    MJ_gmgt_send_mail_text_html($to,$subject,$invoic_concat);



			$nutrision_date=''.$nutritiondata['start_date'].' To '.$nutritiondata['expire_date'];

			$device_token=get_user_meta( $data['member_id'], 'device_token',true); 



		    //Send Push Notification //

		    $title= esc_attr__("New Nutrition Schedule assigned to you.","gym_mgt");

		    $body_data=esc_attr__("You have been assigned a new nutrition schedule.","gym_mgt");

		    $payload = array(

				    'to' => $device_token,

				    'sound' => 'default',

				    'title'=> $title,

				    'body' => $body_data.' '.$nutrision_date,

				    // 'sound' => true,

				    'priority' => 'high',

				    'vibrate' => [0, 250, 250, 250],

				    'data' => ['type' => 'Nutritionplan'],

				);



	        MJ_gmgt_send_pushnotification($payload);

			

			//------------- SEND MESSAGE --------------------//

			$current_sms_service 	= 	get_option( 'gmgt_sms_service');

			if(is_plugin_active('sms-pack/sms-pack.php'))

			{

				$userdata=get_userdata(sanitize_text_field($data['member_id']));

				$mobile_number=array(); 

				$gymname=get_option( 'gmgt_system_name' );

				$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;

				$message_content ="You have assigned new nutrition schedule form ".$nutritiondata['start_date']." To ". $nutritiondata['end_date']." At ".$gymname;

				$args = array();

				$args['mobile']=$mobile_number;

				$args['message_from']="Sell Product";

				$args['message']=$message_content;			

				if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')

				{				

					$send = send_sms($args);							

				}

			}

			else

			{	

				if(isset($data['gmgt_sms_service_enable']))

				{	

					$userinfo=get_userdata(esc_attr($data['member_id']));

					$gymname=get_option( 'gmgt_system_name' );						

					$reciever_number = $userinfo->mobile;		

					$message_content ="You have assigned new nutrition schedule form ".$nutritiondata['start_date']." To ". $nutritiondata['end_date']." At ".$gymname;

					if($current_sms_service == 'clickatell')

					{

						$clickatell=get_option('gmgt_clickatell_sms_service');

						$to = $reciever_number;

						$message = str_replace(" ","%20",$message_content);

						$username = $clickatell['username']; //clickatell username

						$password = $clickatell['password']; // clickatell password

						$api_key = $clickatell['api_key'];//clickatell apikey

						$baseurl ="http://api.clickatell.com";									

						$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";									

						$ret = file($url);									

						$sess = explode(":",$ret[0]);

						if ($sess[0] == "OK")

						{

							$sess_id = trim($sess[1]); // remove any whitespace

							$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message";									

							$ret = file($url);

							$send = explode(":",$ret[0]);										

						}				

					}

					if($current_sms_service == 'msg91')

					{

						//MSG91

						$mobile_number= $userinfo->mobile;

						$country_code="+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));

						$message = $message_content; // Message Text

						gmgt_msg91_send_mail_function($mobile_number,$message,$country_code);

					}	

				}							

			}

			//userragistation mail end			

			return $result;

		}	

	}

	//nutrition details

	public function MJ_gmgt_nutrition_detail($workout_id,$work_outdata)

	{

		if(!empty($work_outdata))

		{

			global $wpdb;

			$table_workout = $wpdb->prefix. 'gmgt_nutrition_data';

			$workout_data = array();

			foreach($work_outdata as  $value)

			{

				foreach($value['day'] as $day)

				{					

					foreach($value['activity']  as $actname)

					{						

						$workout_data['day_name'] = $day;

						$workout_data['nutrition_time'] = $actname['activity'];

						$workout_data['nutrition_value'] = $actname['value'];

						$workout_data['nutrition_id'] = $workout_id;

						$workout_data['created_date'] = date("Y-m-d");

						$workout_data['create_by'] = get_current_user_id();

						$result=$wpdb->insert( $table_workout, $workout_data );

						//var_dump($result);die;

					}

				}				

			}

		}

	}

	//get all nutrition

	public function MJ_gmgt_get_all_nutrition()

	{

		global $wpdb;

		$table_nutrition = $wpdb->prefix. 'gmgt_nutrition';

		$result = $wpdb->get_results("SELECT * FROM $table_nutrition");

		return $result;	

	}

	//get single nutrition

	public function MJ_gmgt_get_single_nutrition($id)

	{

		global $wpdb;

		$table_nutrition = $wpdb->prefix. 'gmgt_nutrition';

		$result = $wpdb->get_row("SELECT * FROM $table_nutrition where id=".$id);

		return $result;

	}

	public function MJ_gmgt_get_member_nutrition($id)

	{

		global $wpdb;

		$table_nutrition = $wpdb->prefix. 'gmgt_nutrition';

		$result = $wpdb->get_results("SELECT * FROM $table_nutrition where user_id=".$id);

		return $result;

	}


	//delete nutrition

	public function MJ_gmgt_delete_nutrition($id)

	{

		global $wpdb;

		$table_nutrition = $wpdb->prefix. 'gmgt_nutrition';

		$user_id = $wpdb->get_row("SELECT user_id FROM $table_nutrition where id=".$id);

		$user_data = get_userdata($member_id);

		gym_append_audit_log(''.esc_html__('Nutrition Deleted','gym_mgt').' ('.$user_data->display_name.')',$id,get_current_user_id(),'delete',$_REQUEST['page']);

		$result = $wpdb->query("DELETE FROM $table_nutrition where id= ".$id);

		return $result;

	}

}

//Nutrition CLASS END

?>