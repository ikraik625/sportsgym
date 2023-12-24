<?php 

//WORKOUT TYPE CLASS

class MJ_gmgt_workouttype

{	

    //ADD WORKOUT FUNCTION

	public function MJ_gmgt_add_workouttype($data)

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_assign_workout';

		$workoutdata['user_id']=$data['member_id'];

		$workoutdata['level_id']=$data['level_id'];

		$workoutdata['description']=MJ_gmgt_strip_tags_and_stripslashes($data['description']);

		$workoutdata['start_date']=MJ_gmgt_get_format_for_db($data['start_date']);		

		$workoutdata['end_date']= MJ_gmgt_get_format_for_db($data['last_date']);

		$workoutdata['created_date']=date("Y-m-d");

		$workoutdata['created_by']=get_current_user_id();

		$new_array = array();

		$i = 0;

		$phpobj = array();

		if(!empty($data['activity_list']))

		{

			foreach($data['activity_list'] as $val)

			{

				$data_value = json_decode($val);

				$phpobj[] = json_decode(stripslashes($val),true);

			}

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

						echo $val2['activity']['activity'];

						$activity['activity'][] =array('activity'=>$val2['activity']['activity'],

													'reps'=>$val2['activity']['reps'],

													'sets'=>$val2['activity']['sets'],

													'kg'=>$val2['activity']['kg'],

													'time'=>$val2['activity']['time'],

						) ;

					}

			}

			$resultarray[] = array_merge($day, $activity);

		}

		if($data['action']=='edit')

		{

			$workoutid['id']=sanitize_text_field($data['assign_workout_id']);	

			$result=$wpdb->update( $table_workout, $workoutdata ,$workoutid);

			return $result;

		}

		else

		{

			$result=0;

			if(!empty($phpobj)){

				$result=$wpdb->insert( $table_workout, $workoutdata );

				$assign_workout_id = $wpdb->insert_id;

				$this->MJ_gmgt_assign_workout_detail($assign_workout_id,$resultarray);



				$workout_date=''.$workoutdata['start_date'] .' To '.$workoutdata['end_date'];

				$device_token=get_user_meta( $data['member_id'], 'device_token',true); 



				$title= esc_attr__("New workouts assigned to you.","gym_mgt");

		        $body_data=esc_attr__("You have been assigned new workouts from.","gym_mgt");

		        //Send Push Notification //

		        $payload = array(

					'to' => $device_token,

					'sound' => 'default',

					'title'=> $title,

					'body' => $body_data.' '.$workout_date,

					// 'sound' => true,

					'priority' => 'high',

					'vibrate' => [0, 250, 250, 250],

					'data' => ['type' => 'Workouts'],

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

				$message_content ="You have assigned new workouts for ".$workoutdata['start_date']." To ". $workoutdata['end_date']." At ".$gymname;

				$args = array();

				$args['mobile']=$mobile_number;

				$args['message_from']="Assign Workout";

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

					$message_content ="You have assigned new workouts for ".$workoutdata['start_date']." To ". $workoutdata['end_date']." At ".$gymname;

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

			//SEND WORKOUT MAIL NOTIFICATION

			$userdata=get_userdata(sanitize_text_field($data['member_id']));

			$username=$userdata->display_name;

			$useremail=$userdata->user_email;

			$gymname=get_option( 'gmgt_system_name' );

		    $page_link='<a href='.home_url().'?dashboard=user&page=assign-workout>View Workout</a>';

			$arr['[GMGT_MEMBERNAME]']=$username;	

			$arr['[GMGT_GYM_NAME]']=$gymname;

			$arr['[GMGT_STARTDATE]']=$workoutdata['start_date'];

			$arr['[GMGT_ENDDATE]']=$workoutdata['end_date'];

			$arr['[GMGT_PAGE_LINK]']=$page_link;

			$subject =get_option('Assign_Workouts_Subject');			

			$sub_arr['[GMGT_GYM_NAME]']=$gymname;

			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);

			$message = get_option('Assign_Workouts_Template');

			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);

            $invoice=MJ_gmgt_Assign_Workouts_Add_Html_Content($assign_workout_id);

            $invoic_concat=$message_replacement. $invoice;			

			$to[]=$useremail;

		    MJ_gmgt_send_mail_text_html($to,$subject,$invoic_concat);

			//SEND WORKOUT MAIL NOTIFICATION END

			}

			return $result;

		}

	}

	//ASIGN WORKOUT DETAILS FUNCTION

	public function MJ_gmgt_assign_workout_detail($workout_id,$work_outdata)

	{

		

		//get_userdata

		if(!empty($work_outdata))

		{

			global $wpdb;

			$table_workout = $wpdb->prefix. 'gmgt_workout_data';

			$workout_data = array();

			foreach($work_outdata as  $value)

			{				

				foreach($value['day'] as $day)

				{

					echo "day".$day;

					foreach($value['activity']  as $actname)

					{						

						$workout_data['day_name'] = $day;

						$workout_data['workout_name'] = $actname['activity'];

						$workout_data['sets'] = $actname['sets'];

						$workout_data['reps'] = $actname['reps'];

						$workout_data['kg'] = $actname['kg'];

						$workout_data['time'] = $actname['time'];

						$workout_data['workout_id'] = $workout_id;

						$workout_data['created_date'] = date("Y-m-d");

						$workout_data['create_by'] = get_current_user_id();

						$result=$wpdb->insert( $table_workout, $workout_data );

					}

				}

			}			

		}

	}

	//GET ALL ASIGN WORKOUT  FUNCTION

	public function MJ_gmgt_get_all_assignworkout()

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_assign_workout';

		$result = $wpdb->get_results("SELECT * FROM $table_workout");

		return $result;

	}	

	//GET ALL ASIGN WORKOUT TYPE  FUNCTION

	public function MJ_gmgt_get_all_workouttype()

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_workouts';

		$result = $wpdb->get_results("SELECT * FROM $table_workout");

		return $result;

	}

	//GET OWN ASIGN WORKOUT   FUNCTION

	public function MJ_gmgt_get_own_assigned_workout($role,$id)

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_workouts';

		if($role=='member')

		{

			$result = $wpdb->get_results("SELECT * FROM $table_workout where member_id=".$id);

		}

		else

		{

			$result = $wpdb->get_results("SELECT * FROM $table_workout where created_by=".$id);

		}

		return $result;

	}

	

	//GET SINGE  ASIGN WORKOUT  TYPE  FUNCTION

	public function MJ_gmgt_get_single_workouttype($id)

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_workouts';

		$result = $wpdb->get_row("SELECT * FROM $table_workout where id=".$id);

		return $result;

	}

	public function MJ_gmgt_get_assigned_workout($id)

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_workouts';

		$result = $wpdb->get_results("SELECT * FROM $table_workout where member_id=".$id);

		return $result;

	}

	//DELETE WORKOUT TYPE FUNCTION

	public function MJ_gmgt_delete_workouttype($id)

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_workouts';

		$result = $wpdb->query("DELETE FROM $table_workout where id= ".$id);

		return $result;

	}

	//GET SINGLE WORKOUT DATA 

	public function MJ_gmgt_get_single_workoutdata($id)

	{

		global $wpdb;

		$table_workout = $wpdb->prefix.'gmgt_workout_data';

		$result = $wpdb->get_row("SELECT *FROM $table_workout where id=".$id);

		return $result;

	}

	//GET singal ASIGN WORKOUT  FUNCTION

	public function MJ_gmgt_get_singal_assignworkout($id)

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_assign_workout';	

		$result = $wpdb->get_row("SELECT * FROM $table_workout WHERE workout_id=$id");

		return $result;

	}	

	public function MJ_gmgt_update_user_workouts_logs($data)

	{

		foreach ($data['id'] as $key => $value)

		{

			global $wpdb;

		    $table_gmgt_workout_data = $wpdb->prefix. 'gmgt_workout_data';

	       

			$sets=$data['sets'][$key];

			$reps=$data['reps'][$key];

			$kg=$data['kg'][$key];

			$time=$data['time'][$key];

			

			$workout_data_id['id']=$value;

			$workout_data['sets']=$sets;

			$workout_data['reps']=$reps;

			$workout_data['kg']=$kg;

			$workout_data['time']=$time;

			$result=$wpdb->update( $table_gmgt_workout_data, $workout_data ,$workout_data_id);

		}

		return $data['workout_id'];

	}

}

//END CLASS 

?>