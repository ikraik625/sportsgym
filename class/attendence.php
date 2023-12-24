<?php 

//ATTENDANCE CLASS START  

class MJ_gmgt_attendence

{	

	//add attendence

	public function MJ_gmgt_add_attendence($curr_date,$class_id,$user_id,$attend_by,$status,$attendance_type)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		$check_insrt_or_update =$this->MJ_gmgt_check_has_attendace($user_id,$class_id,MJ_gmgt_get_format_for_db($curr_date));

		if(empty($check_insrt_or_update))

		{

			$savedata =$wpdb->insert($table_name,array('attendence_date' =>MJ_gmgt_get_format_for_db($curr_date),

				'attendence_by' =>$attend_by,

				'class_id' =>$class_id, 'user_id' =>$user_id,'status' =>$status,'role_name'=>'member','attendance_type'=>$attendance_type));

			$user_data = get_userdata($user_id);

			$attendence_id = $wpdb->insert_id;

				gym_append_audit_log(''.esc_html__('Member Attendance Added','gym_mgt').' ('.$user_data->display_name.')',$attendence_id,get_current_user_id(),'insert',$_REQUEST['page']);

		}

		else 

		{

			$savedata =$wpdb->update($table_name,

					array('attendence_by' =>$attend_by,'status' =>$status),

					array('attendence_date' =>MJ_gmgt_get_format_for_db($curr_date),'class_id' =>$class_id,'user_id' =>$user_id));

				$user_data = get_userdata($user_id);
				$attendence_id = $wpdb->insert_id;
				
				gym_append_audit_log(''.esc_html__('Member Attendance Updated','gym_mgt').' ('.$user_data->display_name.')',$attendence_id,get_current_user_id(),'edit',$_REQUEST['page']);

		}

	}

	//check has attendance

	public function MJ_gmgt_check_has_attendace($user_id,$class_id,$attendace_date)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		return $results=$wpdb->get_row("SELECT * FROM $table_name WHERE attendence_date='$attendace_date' and class_id=$class_id and user_id =".$user_id);

	}

	//check attendance

	public function MJ_gmgt_check_attendence($userid,$class_id,$date)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		$curr_date=$date;

		$result=$wpdb->get_row("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and class_id='$class_id' and user_id=".$userid);

		return $result;

	

	}

	//check staff attendance

	public function MJ_gmgt_check_staff_attendence($userid,$date)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		$curr_date=$date;

		$result=$wpdb->get_row("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and user_id=".$userid);

		return $result;

	

	}

	//take staff attendance

	public function MJ_gmgt_is_take_staff_attendence($userid,$date)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		$result=$wpdb->get_row("SELECT * FROM $table_name WHERE attendence_date='$date'  AND user_id=".$userid);

		

		if(!empty($result))

			return true;

		else

			return false;

	}

	//insert staff attendance

	public function MJ_gmgt_insert_staff_attendance($curr_date,$user_id,$attend_by,$status)

	{

				

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		$check_insrt_or_update =$this->MJ_gmgt_check_staff_attendence($user_id,$curr_date);

	

		if(empty($check_insrt_or_update))

		{

			$savedata =$wpdb->insert($table_name,array('attendence_date' =>$curr_date,

					'attendence_by' =>$attend_by,

					 'user_id' =>$user_id,'status' =>$status,'role_name'=>'staff_member'));

		}

		else

		{

			$savedata =$wpdb->update($table_name,

					array('attendence_by' =>$attend_by,'status' =>$status),

					array('attendence_date' =>$curr_date,'user_id' =>$user_id));

		}

	}

	//take attendence

	public function MJ_gmgt_is_take_attendance($member_id,$class_id,$date)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		$result=$wpdb->get_row("SELECT * FROM $table_name WHERE attendence_date='$date' and class_id = $class_id AND user_id=".$member_id);

		if(!empty($result))

			return true;

		else 

			return false;

		

	}

	//save attendance

	public function MJ_gmgt_save_attendence($curr_date,$class_id,$attendence,$attend_by,$status,$attendance_type)

	{

		

		global $wpdb;

		$role='member';

		$table_name = $wpdb->prefix . "gmgt_attendence";	

		$curr_date=MJ_gmgt_get_format_for_db($curr_date);

		if(!empty($attendence))

		{

			foreach($attendence as $member_id)

			{		

				if($this->MJ_gmgt_is_take_attendance($member_id,$class_id,$curr_date))

				{

					

					$savedata=$result=$wpdb->update($table_name,array('attendence_by' =>$attend_by,'status' =>$status),array('attendence_date' =>$curr_date,'class_id' =>$class_id,'user_id' =>$member_id,'attendance_type'=>$attendance_type));	

					$user_data = get_userdata($member_id);

					$attendence_id = $wpdb->insert_id;
		
						gym_append_audit_log(''.esc_html__('Member Attendance Updated','gym_mgt').' ('.$user_data->display_name.')',$attendence_id,get_current_user_id(),'edit',$_REQUEST['page']);

					if($savedata)

					{

						$table_booking_class = $wpdb->prefix. 'gmgt_booking_class';	

						$booking_list=$wpdb->get_results("SELECT * FROM $table_booking_class WHERE class_id=$class_id and member_id=$member_id and class_booking_date='$curr_date'");

						foreach($booking_list as $booking_list_data)

						{

							

							if(isset($booking_list))

							{

								$booking['id']=$booking_list_data->id;			

								$bookingdata['booking_status']='present';			

								$result=$wpdb->update( $table_booking_class, $bookingdata ,$booking);

							}

						}

				    }	

				}

				else 

				{

					

					$savedata=$wpdb->insert($table_name,array('attendence_date' =>$curr_date,'attendence_by' =>$attend_by,'class_id' =>$class_id, 'user_id' =>$member_id,'status' =>$status,'role_name'=>$role,'attendance_type'=>$attendance_type));	

					$user_data = get_userdata($member_id);

					$attendence_id = $wpdb->insert_id;

					gym_append_audit_log(''.esc_html__('Member Attendance Added','gym_mgt').' ('.$user_data->display_name.')',$attendence_id,get_current_user_id(),'insert',$_REQUEST['page']);

				}

			}

		}

		return $savedata;		

	}

	//show today attendance

	public function MJ_gmgt_show_today_attendence($class_id,$role)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		$curr_date=date("Y-m-d");

		return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and class_id=$class_id and role_name='$role'",ARRAY_A);

		

	}

	//update attendance

	public function MJ_gmgt_update_attendence($membersdata,$curr_date,$class_id,$attendence,$attend_by,$status,$table_name)

	{

		global $wpdb;		

		$curr_date=date("Y-m-d",strtotime($curr_date));

		if($status=='Present')

			$new_status='Absent';

		else

			$new_status='Present';

		 	foreach($membersdata as $stud)

			{

				if(in_array($stud->ID ,$attendence))

				{

					

					

					 $result=$wpdb->update($table_name,array('attendence_by' =>$attend_by,'status' =>$status),array('attendence_date' =>$curr_date,'class_id' =>$class_id,'user_id' =>$stud->ID));

				}

				

			}		

			return $result;

	}

	//save teacher attandance

	public function MJ_gmgt_save_teacher_attendence($curr_date,$attendence,$attend_by,$status)

	{		

		$role='staff_member';

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";		

		$curr_date=MJ_gmgt_get_format_for_db($curr_date);

		

			foreach($attendence as $member_id)

			{

				

				if($this->MJ_gmgt_is_take_staff_attendence($member_id,$curr_date))

				{				 

					$savedata=$result=$wpdb->update($table_name,array('attendence_by' =>$attend_by,'status' =>$status),array('attendence_date' =>$curr_date,'user_id' =>$member_id));					

					$user_data = get_userdata($member_id);

					$attendence_id = $wpdb->insert_id;

					gym_append_audit_log(''.esc_html__('Staff Attendance Added','gym_mgt').' ('.$user_data->display_name.')',$attendence_id,get_current_user_id(),'insert',$_REQUEST['page']);
				}

				else

				{				 

					$savedata=$wpdb->insert($table_name,array('attendence_date' =>$curr_date,'attendence_by' =>$attend_by, 'user_id' =>$member_id,'status' =>$status,'role_name'=>$role));					

					$user_data = get_userdata($member_id);

					$attendence_id = $wpdb->insert_id;

					gym_append_audit_log(''.esc_html__('Staff Attendance Added','gym_mgt').' ('.$user_data->display_name.')',$attendence_id,get_current_user_id(),'insert',$_REQUEST['page']);
				}

			}				

		return $savedata;		

	}

	//show today teacher attendance

	public function MJ_gmgt_show_today_teacher_attendence($role)

	{

		global $wpdb;

		$table_name = $wpdb->prefix . "gmgt_attendence";

		$curr_date=date("Y-m-d");

		return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE attendence_date='$curr_date' and role_name='$role'",ARRAY_A);

	}

	//update teacher attandance

	public function MJ_gmgt_update_teacher_attendence($curr_date,$attendence,$attend_by,$status,$table_name)

	{

		 global $wpdb;		 

		$get_members = array('role' => 'staff_member');

		$membersdata=get_users($get_members);

		foreach($membersdata as $stud)

		{			

			if(in_array($stud->ID ,$attendence))

			{

				

				$result=$wpdb->update($table_name,array('attendence_by' =>$attend_by,'status' =>$status),array('attendence_date' =>$curr_date,'user_id' =>$stud->ID));

			}		

		}

		return $result;		

	}

	//save attendance

	public function MJ_gmgt_save_attendence_api($curr_date,$class_id,$member_id,$attend_by,$status)

	{

		

		global $wpdb;

		$role='member';

		$table_name = $wpdb->prefix . "gmgt_attendence";

			

		//$curr_date=MJ_gmgt_get_format_for_db($curr_date);



		if(!empty($member_id))

		{

			/* foreach($attendence as $member_id)

			{	 */	

				if($this->MJ_gmgt_is_take_attendance($member_id,$class_id,$curr_date))

				{

					

					$savedata=$result=$wpdb->update($table_name,array('attendence_by' =>$attend_by,'status' =>$status),array('attendence_date' =>$curr_date,'class_id' =>$class_id,'user_id' =>$member_id));	

				

					if($savedata)

					{

						$table_booking_class = $wpdb->prefix. 'gmgt_booking_class';	

						$booking_list=$wpdb->get_results("SELECT * FROM $table_booking_class WHERE class_id=$class_id and member_id=$member_id and class_booking_date='$curr_date'");

						foreach($booking_list as $booking_list_data)

						{

							

							if(isset($booking_list))

							{

								$booking['id']=$booking_list_data->id;			

								$bookingdata['booking_status']='present';			

								$result=$wpdb->update( $table_booking_class, $bookingdata ,$booking);

							}

						}

				    }	

				}

				else 

				{

					

					$savedata=$wpdb->insert($table_name,array('attendence_date' =>$curr_date,'attendence_by' =>$attend_by,'class_id' =>$class_id, 'user_id' =>$member_id,'status' =>$status,'role_name'=>$role));	

					

				}

			//}

		}

		return $savedata;		

	}

}

//ATTENDANCE CLASS END  

?>