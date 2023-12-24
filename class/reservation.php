<?php  

//RESERVATION CLASS START  

class MJ_gmgt_reservation

{	

	//ADD RESERVATION DATA

	public function MJ_gmgt_add_reservation($data)

	{

		global $wpdb;

		$table_reservation = $wpdb->prefix. 'gmgt_reservation';

		$reservationdata['event_name']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['event_name']));

		$reservationdata['event_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['event_date']));

		$reservationdata['start_time']=sanitize_text_field($data['start_time']).':'.$data['start_min'].':'.sanitize_text_field($data['start_ampm']);

		$reservationdata['end_time']=sanitize_text_field($data['end_time']).':'.sanitize_text_field($data['end_min']).':'.sanitize_text_field($data['end_ampm']);

		$reservationdata['place_id']=sanitize_text_field($data['event_place']);

		$reservationdata['staff_id']=sanitize_text_field($data['staff_id']);

		$reservationdata['created_date']=date("Y-m-d");

		$reservationdata['created_by']=get_current_user_id();

		$start_time_24_hours=MJ_gmgt_get_reservation_time_in_24_hours($reservationdata['start_time']);

		$end_time_24_hours=MJ_gmgt_get_reservation_time_in_24_hours($reservationdata['end_time']);

		$reserved_class="";

		$reserv_datedata = $wpdb->get_results("SELECT * FROM $table_reservation where event_date ='".$reservationdata['event_date']."' and place_id ='".$reservationdata['place_id']."' and id!=".$data['reservation_id']);

		if(!empty($reserv_datedata))

		{	

			foreach($reserv_datedata as $retrieved_data)

			{			

				$reserved_start_time_24_hours=MJ_gmgt_get_reservation_time_in_24_hours($retrieved_data->start_time);

				$reserved_end_time_24_hours=MJ_gmgt_get_reservation_time_in_24_hours($retrieved_data->end_time);

				if(($reserved_start_time_24_hours > $start_time_24_hours && $reserved_start_time_24_hours < $end_time_24_hours) || ($reserved_end_time_24_hours > $start_time_24_hours && $reserved_end_time_24_hours < $end_time_24_hours) || ($reserved_start_time_24_hours < $start_time_24_hours && $reserved_end_time_24_hours > $end_time_24_hours) || ($reserved_start_time_24_hours > $start_time_24_hours && $reserved_end_time_24_hours < $end_time_24_hours))	
				{

					$reserved_class="reserved";

				}

			}

		}	

		

		if($data['action']=='edit')

		{

			$reservationid['id']=$data['reservation_id'];

			if($reserved_class=="")

				$result=$wpdb->update( $table_reservation, $reservationdata ,$reservationid);

			else

				$result=array('id'=>$data['reservation_id'],'msg'=>'reserved');


				gym_append_audit_log(''.esc_html__('Reservation Updated','gym_mgt').' ('.$data['event_name'].')',$data['reservation_id'],get_current_user_id(),'edit',$_REQUEST['page']);

			return $result;

		}

		else

		{			

			$getresult = $wpdb->get_results("SELECT * FROM $table_reservation where event_date ='".$reservationdata['event_date']."' and place_id ='".$reservationdata['place_id']."'");

			if(!empty($getresult))

			{

				foreach($getresult as $retrieved_data)

				{					

					$reserved_start_time_24_hours=MJ_gmgt_get_reservation_time_in_24_hours($retrieved_data->start_time);

					$reserved_end_time_24_hours=MJ_gmgt_get_reservation_time_in_24_hours($retrieved_data->end_time);

					if(($reserved_start_time_24_hours > $start_time_24_hours && $reserved_start_time_24_hours < $end_time_24_hours) || ($reserved_end_time_24_hours > $start_time_24_hours && $reserved_end_time_24_hours < $end_time_24_hours) || ($reserved_start_time_24_hours < $start_time_24_hours && $reserved_end_time_24_hours > $end_time_24_hours) || ($reserved_start_time_24_hours > $start_time_24_hours && $reserved_end_time_24_hours < $end_time_24_hours))

					{	

						$reserved_class="reserved";

					}								

				}

			}

			

			if($reserved_class == "reserved")

			{

				$result="reserved";

			}

			else

			{	

				$result=$wpdb->insert( $table_reservation, $reservationdata );		

				$reservation_id = $wpdb->insert_id;
				
				gym_append_audit_log(''.esc_html__('Reservation Added','gym_mgt').' ('.$data['event_name'].')',$reservation_id,get_current_user_id(),'insert',$_REQUEST['page']);

				$titlename=get_the_title($data['event_place']);			

				//add resrvation 				

				 $gymname=get_option( 'gmgt_system_name' );

				$page_link=home_url().'/?dashboard=user&page=reservation&tab=reservationlist';

				$staffdata=get_userdata($data['staff_id']);

				$staffemail=$staffdata->user_email;

				$staff_name=$staffdata->display_name;

				$arr['[GMGT_STAFF_MEMBERNAME]']=$staff_name;	

				$arr['[GMGT_EVENT_NAME]']=MJ_gmgt_strip_tags_and_stripslashes($data['event_name']);	

				$arr['[GMGT_GYM_NAME]']=$gymname;

				$arr['[GMGT_EVENT_DATE]']=$reservationdata['event_date'];

				$arr['[GMGT_EVENT_PLACE]']=$titlename;

				$arr['[GMGT_START_TIME]']=$reservationdata['start_time'];

				$arr['[GMGT_END_TIME]']=$reservationdata['end_time'];

				$arr['[GMGT_PAGE_LINK]']=$page_link;

				$subject =get_option('Add_Reservation_Subject');

				$sub_arr['[GMGT_EVENT_NAME]']=MJ_gmgt_strip_tags_and_stripslashes($data['event_name']);

				$sub_arr['[GMGT_EVENT_PLACE]']=$titlename;

				$sub_arr['[GMGT_GYM_NAME]']=$gymname;

				$sub_arr['[GMGT_EVENT_DATE]']=$reservationdata['event_date'];

				$sub_arr['[GMGT_START_TIME]']=$reservationdata['start_time'];

				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);

				$message = get_option('Add_Reservation_Template');	

				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);

				$to[]=$staffemail;

				MJ_gmgt_send_mail($to,$subject,$message_replacement);				

			}

			return $result;

		}

	}

	//get all reservation

	public function MJ_gmgt_get_all_reservation()

	{

		global $wpdb;

		$table_reservation = $wpdb->prefix. 'gmgt_reservation';

		$result = $wpdb->get_results("SELECT * FROM $table_reservation ORDER BY event_date DESC");

		return $result;	

	}

	//get reservation by created_by

	public function MJ_gmgt_get_reservation_by_created_by()

	{

		global $wpdb;

		$table_reservation = $wpdb->prefix. 'gmgt_reservation';

		$user_id=get_current_user_id();

		$result = $wpdb->get_results("SELECT * FROM $table_reservation where created_by=$user_id");

		return $result;	

	}

	//get single reservation

	public function MJ_gmgt_get_single_reservation($id)

	{

		global $wpdb;

		$table_reservation = $wpdb->prefix. 'gmgt_reservation';

		$result = $wpdb->get_row("SELECT * FROM $table_reservation where id=".$id);

		return $result;

	}

	//delete reservation

	public function MJ_gmgt_delete_reservation($id)

	{

		global $wpdb;

		$table_reservation = $wpdb->prefix. 'gmgt_reservation';

		$event_name = $wpdb->get_row("SELECT event_name FROM $table_reservation WHERE id=$id");

		gym_append_audit_log(''.esc_html__('Reservation Deleted','gym_mgt').' ('.$event_name->event_name.')',$id,get_current_user_id(),'delete',$_REQUEST['page']);

		$result = $wpdb->query("DELETE FROM $table_reservation where id= ".$id);


		return $result;

	}

	//get all reservation

	public function MJ_gmgt_get_all_reservation_dashboard()

	{

		global $wpdb;

		$table_reservation = $wpdb->prefix. 'gmgt_reservation';

	

		$result = $wpdb->get_results("SELECT * FROM $table_reservation order by id desc limit 3");

		return $result;	

	}

	//get reservation by created_by dashboard

	public function MJ_gmgt_get_reservation_by_created_by_dashboard()

	{

		global $wpdb;

		$table_reservation = $wpdb->prefix. 'gmgt_reservation';

		$user_id=get_current_user_id();

		$result = $wpdb->get_results("SELECT * FROM $table_reservation where created_by=$user_id order by id desc limit 3");

		return $result;	

	}

}

//RESERVATION CLASS END  

?>