<?php 	

//TAX CLASS START  

class MJ_gmgt_guest_booking

{		

	//ADD TAX DATA

	public function MJ_gmgt_add_guest_booking($data)

	{		

		global $wpdb;

		$table_guest_booking=$wpdb->prefix .'gmgt_guest_booking';

		$bookingdata['first_name']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['firstname']));

		$bookingdata['last_name']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['lastname']));

		$bookingdata['email_id']=sanitize_text_field($data['email']);

		$bookingdata['phone_number']=sanitize_text_field($data['phonenumber']);

		$bookingdata['created_date']=date("Y-m-d");	

		

		if($data['action']=='edit')

		{	

			$guestid['guest_id']=sanitize_text_field($data['guest_id']);

			$result=$wpdb->update( $table_guest_booking, $bookingdata ,$guestid);	
			
			gym_append_audit_log(''.esc_html__('Guest Booking Updated','gym_mgt').'',get_current_user_id(),get_current_user_id(),'edit',$_REQUEST['page']);

			return $result;

		}

		else

		{

			$result=$wpdb->insert( $table_guest_booking,$bookingdata);	
			
			gym_append_audit_log(''.esc_html__('Guest Booking Added','gym_mgt').'',get_current_user_id(),get_current_user_id(),'insert',$_REQUEST['page']);

			return $result;		

		}

	}

	//get all taxes

	public function MJ_gmgt_get_all_guest_booking()

	{

		global $wpdb;

		$table_guest_booking=$wpdb->prefix .'gmgt_guest_booking';	

		$result = $wpdb->get_results("SELECT * FROM $table_guest_booking ORDER BY created_date DESC");

		return $result;	

	}	

	//delete taxes

	public function MJ_gmgt_delete_guest_booking($id)

	{

		global $wpdb;

		$table_guest_booking=$wpdb->prefix .'gmgt_guest_booking';

		$result = $wpdb->query("DELETE FROM $table_guest_booking where guest_id=".$id);

		gym_append_audit_log(''.esc_html__('Guest Booking Deleted','gym_mgt').'',get_current_user_id(),get_current_user_id(),'delete',$_REQUEST['page']);

		return $result;

	}

	//get single tax data

	public function MJ_gmgt_get_single_guest_booking_data($guest_id)

	{

		global $wpdb;

		$table_guest_booking=$wpdb->prefix .'gmgt_guest_booking';

		$result = $wpdb->get_row("SELECT * FROM $table_guest_booking where guest_id= ".$guest_id);

		return $result;

	}

}

//TAX CLASS END  

?>