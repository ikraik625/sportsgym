<?php 







 //WORKOUT CLASS START







class MJ_gmgt_workout







{







    //ADD WORKOUT FUNCTION







	public function MJ_gmgt_add_workout($data)







	{







		$obj_gym = new MJ_gmgt_Gym_management(get_current_user_id());







		global $wpdb;







		$table_workout = $wpdb->prefix. 'gmgt_daily_workouts';		







		$workoutdata['record_date']=$curr_date=MJ_gmgt_get_format_for_db(sanitize_text_field($data['record_date']));







		$workoutdata['note']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['note']));







		$workoutdata['workout_id']=sanitize_text_field($data['user_workout_id']);







		$workoutdata['created_date']=date("Y-m-d");







		$workoutdata['created_by']=get_current_user_id();







		if($obj_gym->role=='administrator' || $obj_gym->role=='staff_member')







		{







			$workoutdata['member_id']=sanitize_text_field($data['member_id']);







		}







		if($obj_gym->role=='member')







		{







			$workoutdata['member_id']=get_current_user_id();







		}







		if($data['action']=='edit')







		{







			$workoutid['id']=sanitize_text_field($data['daily_workout_id']);	







			$result=$wpdb->update( $table_workout, $workoutdata ,$workoutid);







			$user_data = get_userdata($data['member_id']);







			gym_append_audit_log(''.esc_html__('Workout Updated','gym_mgt').' ('.$user_data->display_name.')',$data['daily_workout_id'],get_current_user_id(),'edit','Workout');







			return $result;







		}







		else







		{







			$result=$wpdb->insert( $table_workout, $workoutdata );







			$insertid=$wpdb->insert_id;







			$user_data = get_userdata($data['member_id']);







			gym_append_audit_log(''.esc_html__('Workout Added','gym_mgt').' ('.$user_data->display_name.')',$insertid,get_current_user_id(),'insert','Workout');







			$result=$this->MJ_gmgt_add_user_workouts($insertid,$data);







			$abc=$wpdb->insert_id;







			//assign workout SEND MAIL NOTIFICATION







			$asignby=sanitize_text_field($data['asigned_by']);


			$staff_id  = get_user_meta( $data['member_id'], 'staff_id', true );
			
			
			$userdata=get_userdata($staff_id);

			$username=$userdata->display_name;

			$useremail=$userdata->user_email;



			$userid=$userdata->ID;







			$recorddate=$workoutdata['record_date'];







			$gymname=get_option( 'gmgt_system_name' );







			$day_name = date('l', strtotime($workoutdata['created_date']));







			$arr['[GMGT_STAFF_MEMBERNAME]']=$username;	







			$arr['[GMGT_DAY_NAME]']=$day_name;



			$arr['[GMGT_USERNAME]']=$user_data->display_name;







			$arr['[GMGT_DATE]']=$workoutdata['created_date'];







			$arr['[GMGT_GYM_NAME]']=$gymname;







			$subject =get_option('Submit_Workouts_Subject');







			$sub_arr['[GMGT_STAFF_MEMBERNAME]']=$gymname;







			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);







			$message = get_option('Submit_Workouts_Template');







			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



			

			$invoice=MJ_gmgt_submit_workout_html_content($workoutdata['member_id'],$recorddate);







            $invoic_concat=$message_replacement. $invoice;







			$to[]=$useremail; 







			MJ_gmgt_send_mail_text_html($to,$subject,$invoic_concat);

			// send daily workout mail to member
						

			$subject =get_option('Submit_Workouts_Subject_for_member');
			$sub_arr['[GMGT_STAFF_MEMBERNAME]']=$gymname;
			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);


			$arr_member['[GMGT_DAY_NAME]']=$day_name;
			$arr_member['[GMGT_USERNAME]']=$user_data->display_name;
			$arr_member['[GMGT_DATE]']=$workoutdata['created_date'];
			$arr_member['[GMGT_GYM_NAME]']=$gymname;
			$message = get_option('Submit_Workouts_Template_for_member');
			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);
			$invoice=MJ_gmgt_submit_workout_html_content($workoutdata['member_id'],$recorddate);
			$invoic_concat=$message_replacement. $invoice;
			$to[]=$user_data->user_email;

			$member_mail = 	MJ_gmgt_send_mail_text_html($to,$subject,$invoic_concat);

			


			



			$title= esc_attr__("Submit workouts to you.","gym_mgt");







			$body_data=esc_attr__("Submit new workouts from.","gym_mgt");







			//Send Push Notification //



			$device_token=get_user_meta( $data['asigned_by'], 'device_token',true);


			$payload = array(

				'to' => $device_token,







				'sound' => 'default',







				'title'=> $title,







				'body' => $body_data.' '.$workoutdata['record_date'],







				// 'sound' => true,







				'priority' => 'high',







				'vibrate' => [0, 250, 250, 250],







				'data' => ['type' => 'Workouts'],







			);



		



			MJ_gmgt_send_pushnotification($payload);







			return $result;







		}







	}







	//GET ALL WORKOUT FUNCTION







	public function MJ_gmgt_get_all_workout()







	{







		global $wpdb;







		$table_workout = $wpdb->prefix. 'gmgt_daily_workouts';







		$result = $wpdb->get_results("SELECT * FROM $table_workout");







		return $result;







	}







	//GET SINGLE WORKOUT FUNCTION







	public function MJ_gmgt_get_single_workout($id)







	{







		global $wpdb;







		$table_workout = $wpdb->prefix. 'gmgt_daily_workouts';







		$result = $wpdb->get_row("SELECT * FROM $table_workout where id=".$id);







		return $result;







	}







	//GET WORKOUT FOR MEMBER ID







	public function MJ_gmgt_get_member_workout($role,$id)







	{







		global $wpdb;







		$table_workout = $wpdb->prefix. 'gmgt_daily_workouts';







		if($role=='member')







			$result = $wpdb->get_results("SELECT * FROM $table_workout where member_id=".$id);







		elseif($role=='staff_member')







			$result = $wpdb->get_results("SELECT * FROM $table_workout where assigned_by=".$id);







		else







			$result = $wpdb->get_results("SELECT * FROM $table_workout");







		return $result;







	}







	//DELETE WORKOUT FOR MEMBER ID







	public function MJ_gmgt_delete_workout($id)







	{







		global $wpdb;







		$table_workout = $wpdb->prefix. 'gmgt_daily_workouts';







		$member_id = $wpdb->get_row("SELECT member_id FROM $table_workout where id=".$id);







		$user_data = get_userdata($member_id);







		gym_append_audit_log(''.esc_html__('Workout Deleted','gym_mgt').' ('.$user_data->display_name.')',$id,get_current_user_id(),'delete','Workout');







		$result = $wpdb->query("DELETE FROM $table_workout where id= ".$id);











		return $result;







	}







	//ADDD  USER WORKOUT FUNCTION







	public function MJ_gmgt_add_user_workouts($id,$data)







	{







		global $wpdb;







		$table_workout = $wpdb->prefix. 'gmgt_user_workouts';







		if(!empty($data['workouts_array']))







		{







			foreach($data['workouts_array'] as $val)







			{







				







				$user_workoutdata['user_workout_id']=$id;







				$user_workoutdata['workout_name']=sanitize_text_field($data['workout_name_'.$val]);







				$user_workoutdata['sets']=sanitize_text_field($data['sets_'.$val]);







				$user_workoutdata['reps']=sanitize_text_field($data['reps_'.$val]);







				$user_workoutdata['kg']=sanitize_text_field($data['kg_'.$val]);







				$user_workoutdata['rest_time']=sanitize_text_field($data['rest_'.$val]);







				$result=$wpdb->insert( $table_workout, $user_workoutdata );







				$workout_id = $wpdb->insert_id;







				gym_append_audit_log(''.esc_html__('Member Workout Added','gym_mgt').' ('.$user_workoutdata['workout_name'].')',$workout_id,get_current_user_id(),'insert','Workout');



			}







			  return $result;







		}







		else







		 {







			  return false;







		 }







	}







	//ADD MEASURMENT FUNCTION







	public function MJ_gmgt_add_measurement($data,$member_image_url='')







	{







		global $wpdb;







		$measurement_image="";







		if($member_image_url!='')







		{







			$measurement_image=$member_image_url;







		}







		elseif($data['gmgt_progress_image']!='')







		{







			$measurement_image=$data['gmgt_progress_image'];







		}







		$table_gmgt_measurment = $wpdb->prefix. 'gmgt_measurment';







		$workoutdata['user_id']=sanitize_text_field($data['user_id']);







		$workoutdata['result_measurment']=MJ_gmgt_strip_tags_and_stripslashes($data['result_measurment']);







		$workoutdata['gmgt_progress_image']=$measurement_image;







		$workoutdata['result']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['result']));		







		$workoutdata['result_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['result_date']));







		$workoutdata['created_date']=date("Y-m-d");







		$workoutdata['created_by']=get_current_user_id();







		if($data['action']=='edit')







		{







			$workoutid['measurment_id']=$data['measurment_id'];







			$result=$wpdb->update( $table_gmgt_measurment, $workoutdata ,$workoutid);







			$user_data = get_userdata($data['user_id']);







			gym_append_audit_log(''.esc_html__('Measurement Updated','gym_mgt').' ('.$user_data->display_name.')',$data['measurment_id'],get_current_user_id(),'edit','Measurement');







			return $result;







		}







		else







		{







			$result=$wpdb->insert( $table_gmgt_measurment, $workoutdata );







			$measurment_id = $wpdb->insert_id;



			$user_data = get_userdata($data['user_id']);



			gym_append_audit_log(''.esc_html__('Measurement Added','gym_mgt').' ('.$user_data->display_name.')',$measurment_id,get_current_user_id(),'insert','Measurement');







			return $wpdb->insert_id;







		}







	}







	//GET ALL MEASURMENT FUNCTION







	public function MJ_gmgt_get_all_measurement()







	{







		global $wpdb;







		$table_gmgt_measurment = $wpdb->prefix. 'gmgt_measurment';







		$result = $wpdb->get_results("SELECT * FROM $table_gmgt_measurment");







		return $result;







	}







	public function MJ_gmgt_get_all_measurement_by_userid($user_id)







	{







		global $wpdb;







		$table_gmgt_measurment = $wpdb->prefix. 'gmgt_measurment';







		$result = $wpdb->get_results("SELECT * FROM $table_gmgt_measurment where user_id = ".$user_id." ORDER BY  result_date DESC");







		return $result;







	}







	public function MJ_gmgt_get_measurement_deleteby_id($measurement)







	{







		global $wpdb;







		$table_gmgt_measurment = $wpdb->prefix. 'gmgt_measurment';







		$user_id = $wpdb->get_row("SELECT user_id FROM $table_gmgt_measurment where measurment_id = $measurement");







		$user_data = get_userdata($user_id);







		gym_append_audit_log(''.esc_html__('Measurement Deleted','gym_mgt').' ('.$user_data->display_name.')',$measurement,get_current_user_id(),'delete','Measurement');







		$result = $wpdb->query("DELETE FROM $table_gmgt_measurment where measurment_id= ".$measurement);







		return $result;







	}







	//GET SINGLE MEASURMENT FUNCTION







	public function MJ_gmgt_get_single_measurement($measurment_id)







	{







		global $wpdb;







		$table_gmgt_measurment = $wpdb->prefix. 'gmgt_measurment';







		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_measurment where measurment_id = $measurment_id");







		return $result;







	}







	//GET MEMBER TODAY WORKOUT FUNCTION


	public function MJ_gmgt_get_member_today_workouts($id,$date)

	{

		global $wpdb;

		$table_daily_workouts = $wpdb->prefix. 'gmgt_daily_workouts';

		$table_user_workouts = $wpdb->prefix. 'gmgt_user_workouts';

		$today_data = $wpdb->get_row("SELECT * FROM $table_daily_workouts where record_date = '$date' AND member_id=$id");

	
		if(!empty($today_data))

		{

			$result = $wpdb->get_results("SELECT * FROM $table_user_workouts where user_workout_id=".$today_data->id);
		
		}

		if(!empty($result))

			return $result;

	}

	//GET USER WORKOUT FUNCTION

	public function MJ_gmgt_get_user_workouts($workoutid,$activityname)

	{

		global $wpdb;

        $table_daily_workouts = $wpdb->prefix. 'gmgt_daily_workouts';

        $today_data = $wpdb->get_row("SELECT workout_id FROM $table_daily_workouts where id = $workoutid");		

		$table_gmgt_workout_data= $wpdb->prefix. 'gmgt_workout_data';

		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_workout_data where workout_id= $today_data->workout_id AND workout_name='$activityname'");

		return $result;

	}

	//ADDD  USER WORKOUT FUNCTION

	public function MJ_gmgt_add_user_workouts_api($id,$data)

	{

		global $wpdb;

		$table_workout = $wpdb->prefix. 'gmgt_user_workouts';

		if(!empty($data['workouts_array']))

		{

			foreach($data['workouts_array'] as $val)

			{

				$user_workoutdata['user_workout_id']=$id;

				$user_workoutdata['workout_name']=$val['workoutName'];

				$user_workoutdata['sets']=$val['sets'];

				$user_workoutdata['kg']=$val['kg'];

				$user_workoutdata['reps']=$val['reps'];

				$user_workoutdata['rest_time']=$val['resttime'];

				$result=$wpdb->insert( $table_workout, $user_workoutdata );

			}

			  return $result;

		}

		else

		 {

			  return false;

		 }

	} 

	public function MJgmgt_get_all_measurement_by_userid_datewise($user_id,$date)

	{


		global $wpdb;

		$table_gmgt_measurment = $wpdb->prefix. 'gmgt_measurment';

		$result = $wpdb->get_results("SELECT * FROM $table_gmgt_measurment where user_id = '$user_id' and  created_date = '$date' ORDER BY  result_date DESC");

		return $result;

	}

}

?>