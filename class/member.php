<?php   

//MEMBER CLASS START   

class MJ_gmgt_member

{

	//MEMBER DATA ADD	

	public function MJ_gmgt_gmgt_add_user($data)

	{

		global $wpdb;

		$table_members = $wpdb->prefix. 'usermeta';

		$table_gmgt_groupmember = $wpdb->prefix.'gmgt_groupmember';

		$table_income=$wpdb->prefix.'gmgt_income_expense';
		

		//-------usersmeta table data--------------

		if(isset($data['member_type']))

		$usermetadata['member_type']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['member_type']));

		if(isset($data['gender']))

		$usermetadata['gender']=sanitize_text_field($data['gender']);

		if(isset($data['birth_date']))

		$usermetadata['birth_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['birth_date']));

		if(isset($data['address']))

		$usermetadata['address']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['address']));

		if(isset($data['city_name']))

		$usermetadata['city_name']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['city_name']));

		if(isset($data['state_name']))

		$usermetadata['state_name']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['state_name']));

		if(isset($data['zip_code']))

		$usermetadata['zip_code']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['zip_code']));

		if(isset($data['mobile']))

		$usermetadata['mobile']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['mobile']));

		if(isset($data['phone']))

		$usermetadata['phone']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['phone']));

		if(isset($data['gmgt_user_avatar']))

		$usermetadata['gmgt_user_avatar']=esc_url_raw($data['gmgt_user_avatar']);

		if($data['role']=='staff_member')

		{

			if(isset($data['role_type']))



			$usermetadata['role_type']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['role_type']));



			if(isset($data['activity_category']))



			$usermetadata['activity_category']=implode(',',$data['activity_category']);



		}



		if($data['role']=='member')



		{



			if(isset($data['member_id']))



			$usermetadata['member_id']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['member_id']));



			if(isset($data['member_type']))



				$usermetadata['member_type']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['member_type']));



			if(isset($data['height']))



				$usermetadata['height']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['height']));



			if(isset($data['weight']))



				$usermetadata['weight']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['weight']));



			if(isset($data['chest']))



				$usermetadata['chest']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['chest']));



			if(isset($data['waist']))



				$usermetadata['waist']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['waist']));



			if(isset($data['thigh']))



				$usermetadata['thigh']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['thigh']));



			if(isset($data['arms']))



				$usermetadata['arms']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['arms']));



			if(isset($data['fat']))



				$usermetadata['fat']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['fat']));



			if(isset($data['staff_id']))



				$usermetadata['staff_id']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['staff_id']));



			if(isset($data['intrest_area']))



				$usermetadata['intrest_area']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['intrest_area']));



			if(isset($data['source']))



				$usermetadata['source']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['source']));



			if(isset($data['reference_id']))



				$usermetadata['reference_id']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['reference_id']));



			if(!empty($data['inqiury_date']))



			{



				$usermetadata['inqiury_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['inqiury_date']));



			}



			if(!empty($data['triel_date']))



			{



				$usermetadata['triel_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['triel_date']));



			}



			if(isset($data['membership_id']))



				$usermetadata['membership_id']=MJ_gmgt_strip_tags_and_stripslashes($data['membership_id']);



			if(isset($data['membership_status']))



				$usermetadata['membership_status']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['membership_status']));



			if(isset($data['auto_renew']))



				$usermetadata['auto_renew']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['auto_renew']));



			if(!empty($data['begin_date']))



			{



				$usermetadata['begin_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['begin_date']));



			}



			if(!empty($data['end_date']))



			{



				$usermetadata['end_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['end_date']));



			}



			if(!empty($data['first_payment_date']))



			{



				$usermetadata['first_payment_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['first_payment_date']));



			}



			if(isset($data['member_convert']))



				$roledata['role']=sanitize_text_field($data['member_convert']);			



		}



		if(isset($data['email']))



		$userdata['user_login']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_user($data['email']));



		if(isset($data['email']))



		$userdata['user_email']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_email($data['email']));



		$userdata['user_nicename']=NULL;



		$userdata['user_url']=NULL;



		if(isset($data['first_name']))



			$userdata['display_name']=MJ_gmgt_strip_tags_and_stripslashes($data['first_name'])." ".MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['last_name']));



		if($data['password'] != "")



			$userdata['user_pass']=MJ_gmgt_password_validation(sanitize_text_field($data['password']));



		if($data['action']=='edit')



		{



			$userdata['ID']=$data['user_id'];



			$memberclass = MJ_gmgt_get_current_user_classis($data['user_id']);



			$tbl_class = $wpdb->prefix .'gmgt_member_class';



			if(!empty($memberclass))



			{



				$wheredataa['member_id']=sanitize_text_field($data['user_id']);



				foreach($memberclass as $class_id)



				{



					$where['class_id']=$class_id;



					$wpdb->delete( $tbl_class, $wheredataa ); 



				}



			}



			if(isset($data['class_id']))



			{



				foreach($data['class_id'] as $key=>$newclass)



				{



					$wpdb->insert($tbl_class,array('member_id'=>sanitize_text_field($data['user_id']),'class_id'=>$newclass));



				}



			}



			$user_id =sanitize_text_field($data['user_id']);	



			wp_update_user($userdata);



			// ==============Audit log START=============

		

			if($data['role'] == 'member')

			{

				gym_append_audit_log(''.esc_html__('Member Updated','gym_mgt').' ('.$userdata['display_name'].')',$user_id,get_current_user_id(),'edit',$_REQUEST['page']);

			}

			elseif($data['role'] == 'staff_member')

			{

				gym_append_audit_log(''.esc_html__('Staff Member Updated','gym_mgt').' ('.$userdata['display_name'].')',$user_id,get_current_user_id(),'edit',$_REQUEST['page']);

			}

			elseif($data['role'] == 'accountant')

			{

				gym_append_audit_log(''.esc_html__('Accountant Updated','gym_mgt').' ('.$userdata['display_name'].')',$user_id,get_current_user_id(),'edit',$_REQUEST['page']);

			}

			if(!empty($_POST['relation'])){
				update_user_Meta($user_id, 'relation', $_POST['relation'] );
			}

			// ==============Audit log END=============



			if(!empty($roledata))



			{



				$u = new WP_User($user_id);



				$u->remove_role( 'member' );



				$u->add_role( 'staff_member');	



			}			



				$returnans=update_user_meta( $user_id, 'first_name', MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['first_name'])) );



				$returnans=update_user_meta( $user_id, 'last_name', MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['last_name'])) );

				
				if ( ! empty( $_POST['relation'] ) ) {
				update_user_Meta( $user_id, 'relation', $_POST['relation'] );
				}



				$gymname=get_option( 'gmgt_system_name' );



				$to[] = MJ_gmgt_strip_tags_and_stripslashes(sanitize_email($data['email']));



				$subject = get_option('registration_title'); 



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject1 = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$search=array('[GMGT_MEMBERNAME]','[GMGT_MEMBERID]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[EMAIL_ID]','[PASSWORD]','[GMGT_GYM_NAME]');



				$membership_name=MJ_gmgt_get_membership_name(sanitize_text_field($data['membership_id']));



				$replace = array(MJ_gmgt_get_user_full_display_name($user_id),sanitize_text_field($data['member_id']),sanitize_text_field($data['begin_date']),sanitize_text_field($data['end_date']),$membership_name,sanitize_email($data['email']),sanitize_text_field($data['password']),get_option( 'gmgt_system_name' ));

				$message_replacement = str_replace($search, $replace,get_option('registration_mailtemplate')); 
				
				if($data['role']=='member')

				{



					MJ_gmgt_send_mail($to,$subject1,$message_replacement); 



				}



				//under registration mail start



				$role=$data['role'];



				if(!empty($role))



				{



					$role_name_new=str_replace("_"," ",$role);



				}



				$gymname=get_option( 'gmgt_system_name' );



				$login_link=home_url();



			



				$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($user_id);	



				$arr['[GMGT_GYM_NAME]']=$gymname;



				$arr['[GMGT_ROLE_NAME]']=$role_name_new;



				$arr['[GMGT_Username]']=$data['email'];



				$arr['[GMGT_PASSWORD]']=MJ_gmgt_password_validation(sanitize_text_field($data['password']));



				$arr['[GMGT_LOGIN_LINK]']=$login_link;



				$subject =get_option('Add_Other_User_in_System_Subject');



				$sub_arr['[GMGT_ROLE_NAME]']=$role_name_new;



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$message = get_option('Add_Other_User_in_System_Template');	



				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



				$to[]=MJ_gmgt_strip_tags_and_stripslashes(sanitize_email($data['email']));



				



				//under registration mail end



				foreach($usermetadata as $key=>$val)



				{



					$returnans=update_user_meta( $user_id, $key,$val );



				}

				



				if(isset($data['group_id']))

				{

					$obj_group=new MJ_gmgt_group;

					if(!empty($data['group_id']))

					{						

						if($this->MJ_gmgt_member_exist_ingrouptable($user_id))

						$this->MJ_gmgt_delete_member_from_grouptable($user_id);

						$groupname_array=array();

						foreach($data['group_id'] as $id)

						{								



							$group_data['group_id']=$id;



							$group_data['member_id']=$user_id;



							$group_data['created_date']=date("Y-m-d");



							$group_data['created_by']=get_current_user_id();	



							$group_inserted=$wpdb->insert( $table_gmgt_groupmember, $group_data );

							$group_id_last= $wpdb->insert_id;

							if($group_inserted)

							{

								$groupdata=$obj_group->MJ_gmgt_get_single_group($group_id_last);

								$groupname_array[]=$groupdata->group_name;

							}

							

						}

						$groupname=implode(" ",$groupname_array);

					    //Send Mail Notification To Group//

						$gymname=get_option( 'gmgt_system_name' );



						$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($user_id);	



						$arr['[GMGT_GROUPNAME]']=$groupname;	



						$arr['[GMGT_GYM_NAME]']=$gymname;						



						$subject =get_option('Member_Added_In_Group_subject');



						$sub_arr['[GMGT_GYM_NAME]']=$gymname;



						$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



						$message = get_option('Member_Added_In_Group_Template');	



						$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



						$to=strip_tags(sanitize_email($data['email']));



						MJ_gmgt_send_mail($to,$subject,$message_replacement);





					}



				}		



				else



				{



					$this->MJ_gmgt_delete_member_from_grouptable($user_id);



				}			



				return $user_id;



		}



		else



		{			



			$user_id = wp_insert_user( $userdata );


			if ( ! empty( $_POST['relation'] ) ) {
				update_user_Meta( $user_id, 'relation', $_POST['relation'] );
			}


			// ==============Audit log START=============



			if($data['role'] == 'member')

			{

				gym_append_audit_log(''.esc_html__('Member Added','gym_mgt').' ('.$userdata['display_name'].')',$user_id,get_current_user_id(),'insert',$_REQUEST['page']);

			}

			elseif($data['role'] == 'staff_member')

			{

				gym_append_audit_log(''.esc_html__('Staff Member Added','gym_mgt').' ('.$userdata['display_name'].')',$user_id,get_current_user_id(),'insert',$_REQUEST['page']);

			}

			elseif($data['role'] == 'accountant')

			{

				gym_append_audit_log(''.esc_html__('Accountant Added','gym_mgt').' ('.$userdata['display_name'].')',$user_id,get_current_user_id(),'insert',$_REQUEST['page']);

			} 



			// ==============Audit log END=============



			$gymname=get_option( 'gmgt_system_name' );



			$to[] = MJ_gmgt_strip_tags_and_stripslashes(sanitize_email($data['email']));



			$subject = get_option('registration_title'); 



			$sub_arr['[GMGT_GYM_NAME]']=$gymname;



			$subject1 = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



			$search=array('[GMGT_MEMBERNAME]','[GMGT_MEMBERID]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[EMAIL_ID]','[PASSWORD]','[GMGT_GYM_NAME]');



			$membership_name=MJ_gmgt_get_membership_name(sanitize_text_field($data['membership_id']));



			$replace = array(MJ_gmgt_get_user_full_display_name($user_id),sanitize_text_field($data['member_id']),sanitize_text_field($data['begin_date']),sanitize_text_field($data['end_date']),$membership_name,sanitize_email($data['email']),sanitize_text_field($data['password']),get_option( 'gmgt_system_name' ));



			$message_replacement = str_replace($search, $replace,get_option('registration_mailtemplate'));
	
			

			if($data['role']=='member')



			{



				MJ_gmgt_send_mail($to,$subject1,$message_replacement); 



			}



			//user registration mail start



			$role=$data['role'];



			if(!empty($role))



			{



				$role_name_new=str_replace("_"," ",$role);



			}



			$gymname=get_option( 'gmgt_system_name' );



			$login_link=home_url();



			$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($user_id);	



			$arr['[GMGT_GYM_NAME]']=$gymname;



			$arr['[GMGT_ROLE_NAME]']=$role_name_new;



			$arr['[GMGT_Username]']=$data['email'];



			$arr['[GMGT_PASSWORD]']=MJ_gmgt_password_validation(sanitize_text_field($data['password']));



			$arr['[GMGT_LOGIN_LINK]']=$login_link;



			$subject =get_option('Add_Other_User_in_System_Subject');



			$sub_arr['[GMGT_ROLE_NAME]']=$role_name_new;



			$sub_arr['[GMGT_GYM_NAME]']=$gymname;



			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



			$message = get_option('Add_Other_User_in_System_Template');	



			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



			$to[]=MJ_gmgt_strip_tags_and_stripslashes(sanitize_email($data['email']));



			MJ_gmgt_send_mail($to,$subject,$message_replacement);



			//user registration mail end



			$user = new WP_User($user_id);



			$user->set_role(strip_tags($data['role']));



			if($data['role']=='member')



			{



				$usermetadata['membership_status']="Continue";



				if(isset($data['class_id']))



				{



					$MemberClassData = array();



					$MemberClassData['member_id']=$user_id;



					$tbl_MemberClass = $wpdb->prefix . 'gmgt_member_class';



					foreach($data['class_id'] as $key=>$class_id){



						$MemberClassData['class_id']=$class_id; 



						$wpdb->insert($tbl_MemberClass,$MemberClassData);



					}



				}



			}





			foreach($usermetadata as $key=>$val)



			{



				$returnans=add_user_meta( $user_id, $key,$val, true );



			}



			if(isset($data['first_name']))



			$returnans=update_user_meta( $user_id, 'first_name', MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['first_name'])));



			if(isset($data['last_name']))



			$returnans=update_user_meta( $user_id, 'last_name', MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['last_name'])));



			if(isset($data['group_id']))



				if(!empty($data['group_id']))



				{			



					foreach($data['group_id'] as $id)



					{							



						$group_data['group_id']=$id;



						$group_data['member_id']=$user_id;						



						$group_data['created_date']=date("Y-m-d");



						$group_data['created_by']=get_current_user_id();



						$wpdb->insert( $table_gmgt_groupmember, $group_data );



						$gymname=get_option( 'gmgt_system_name' );



						$obj_group=new MJ_gmgt_group;



						$groupdata=$obj_group->MJ_gmgt_get_single_group($id);



						$groupname=$groupdata->group_name;	







						



						$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($user_id);	



						$arr['[GMGT_GROUPNAME]']=$groupname;	



						$arr['[GMGT_GYM_NAME]']=$gymname;



						$subject =get_option('Member_Added_In_Group_subject');



						$sub_arr['[GMGT_GROUPNAME]']=$groupname;



						$sub_arr['[GMGT_GYM_NAME]']=$gymname;



						$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



						$message = get_option('Member_Added_In_Group_Template');	



						$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



						$to[]=MJ_gmgt_strip_tags_and_stripslashes(sanitize_email($data['email']));



						MJ_gmgt_send_mail($to,$subject,$message_replacement);







						// Approve mail.


						$to[]= MJ_gmgt_strip_tags_and_stripslashes(sanitize_email($data['email']));



						$login_link=home_url();



						$subject =get_option( 'Member_Approved_Template_Subject' ); 



						$gymname=get_option( 'gmgt_system_name' );


						$member_name=MJ_gmgt_get_user_full_display_name($user_id);



						$sub_arr['[GMGT_GYM_NAME]']=$gymname;



						$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



						$arr['[GMGT_MEMBERNAME]']=MJ_gmgt_get_user_full_display_name($user_id);	



						$arr['[GMGT_LOGIN_LINK]']=$login_link;	



						$arr['[GMGT_GYM_NAME]']=$gymname;


						$membership_name=MJ_gmgt_get_membership_name($membership_id);



						



						$message=get_option('Member_Approved_Template');



						$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



							







						 MJ_gmgt_send_mail($to,$subject,$message_replacement);		



					}



				}



				if($data['role']=='member')



				{



					//invoice number generate



					$result_invoice_no=$wpdb->get_results("SELECT * FROM $table_income");



					if(empty($result_invoice_no))



					{							



						$invoice_no='00001';



					}



					else



					{							



						$result_no=$wpdb->get_row("SELECT invoice_no FROM $table_income where invoice_id=(SELECT max(invoice_id) FROM $table_income)");



						$last_invoice_number=$result_no->invoice_no;



						$invoice_number_length=strlen($last_invoice_number);



						



						if($invoice_number_length=='5')



						{



							$invoice_no = str_pad($last_invoice_number+1, 5, 0, STR_PAD_LEFT);



						}



						else	



						{



							$invoice_no='00001';



						}				



					}

					$status = 'Unpaid';

					$plan_id = MJ_gmgt_generate_membership_end_income_invoice_with_payment_offline_payment($invoice_no,$user_id,$data['membership_id'],$data['begin_date'],$data['end_date'],$status,$data['coupon_id']);

					
					//membership invoice mail send



					$insert_id=$plan_id;

				



					$paymentlink=home_url().'?dashboard=user&page=membership_payment';



					$gymname=get_option( 'gmgt_system_name' );



					$userdata=get_userdata(sanitize_text_field($data['member_id']));



					$arr['[GMGT_USERNAME]']=$userdata->display_name;	



					$arr['[GMGT_GYM_NAME]']=$gymname;



					$arr['[GMGT_PAYMENT_LINK]']=$paymentlink;



					$subject =get_option('generate_invoice_subject');



					$sub_arr['[GMGT_GYM_NAME]']=$gymname;



					$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



					$message = get_option('generate_invoice_template');	



					$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



					$to[]=$userdata->user_email;



					$type='membership_invoice';



					MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$insert_id,$type);



				}



			return $user_id;



		}



	}



	//add membership payment details



	public function MJ_gmgt_add_membership_payment_detail($data)

	{



		global $wpdb;



		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



		$result = $wpdb->insert($table_gmgt_membership_payment,$data);



		$lastid = $wpdb->insert_id;



		return $lastid;



	}

		

	// UPDATE MEMBERSHIP PAYMENT DETAILS

	public function MJ_gmgt_update_membership_payment_detail($data,$plan_id)

	{

		global $wpdb;



		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



		$result = $wpdb->update($table_gmgt_membership_payment,$data,$plan_id);



		return $result;



	}

	

	// ADD COUPON USAGE DETAILS



	public function MJ_gmgt_add_coupon_usage_detail($data)

	{



		global $wpdb;



		$table_gmgt_coupon_usage = $wpdb->prefix. 'gmgt_coupon_usage';



		$result = $wpdb->insert($table_gmgt_coupon_usage,$data);



		$lastid = $wpdb->insert_id;



		return $lastid;



	}

	

	//get all groups



	public function MJ_gmgt_get_all_groups()



	{



		global $wpdb;



		$table_members = $wpdb->prefix. 'gmgt_groups';



		$result = $wpdb->get_results("SELECT * FROM $table_members");



		return $result;	



	}



	//get single group



	public function MJ_gmgt_get_single_group($id)



	{



		global $wpdb;



		$table_members = $wpdb->prefix. 'gmgt_groups';



		$result = $wpdb->get_row("SELECT * FROM $table_members where id=".$id);



		return $result;



	}



	//delete user data for user



	public function MJ_gmgt_delete_usedata($record_id)

	{

		$user_meta=get_userdata($record_id);



		$user_roles=$user_meta->roles[0];



		// ==============Audit log start=============

	

		if($user_roles == 'member')

		{

			gym_append_audit_log(''.esc_html__('Member Deleted','gym_mgt').' ('.$user_meta->display_name.')',$record_id,get_current_user_id(),'delete',$_REQUEST['page']);

		}

		elseif($user_roles == 'staff_member')

		{

			gym_append_audit_log(''.esc_html__('Staff Member Deleted','gym_mgt').' ('.$user_meta->display_name.')',$record_id,get_current_user_id(),'delete',$_REQUEST['page']);

		}

		elseif($user_roles == 'accountant')

		{

			gym_append_audit_log(''.esc_html__('Accountant Deleted','gym_mgt').' ('.$user_meta->display_name.')',$record_id,get_current_user_id(),'delete',$_REQUEST['page']);

		}

		// ==============Audit log end=============

		

		global $wpdb;



		$table_name = $wpdb->prefix . 'usermeta';



		$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';



		$result1=$wpdb->query($wpdb->prepare("DELETE FROM $table_gmgt_groupmember WHERE member_id= %d",$record_id));



		$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE user_id= %d",$record_id));



		$retuenval=wp_delete_user( $record_id );



		//delete all data for member //

		

		if($user_roles=='member')



		{



			if($retuenval)



			{



				$result=$this->MJ_gmgt_delete_all_member_data($record_id);



			}



		}



		//end delete all data//



		return $retuenval;



	}



	//member exits in group table



	public function MJ_gmgt_member_exist_ingrouptable($member_id)



	{		



		global $wpdb;	



		$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';



		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_groupmember where member_id=".$member_id);



		if(!empty($result))



			return true;



		return false;



	}



	//delete member from group table



	public function MJ_gmgt_delete_member_from_grouptable($member_id)



	{



		global $wpdb;



		$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';



		$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_gmgt_groupmember WHERE member_id= %d",$member_id));



	}



	//get all join group



	public function MJ_gmgt_get_all_joingroup($member_id)



	{



		global $wpdb;



		$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';



		$result = $wpdb->get_results("SELECT group_id FROM $table_gmgt_groupmember where member_id=".$member_id,ARRAY_A);



		return $result;



	}



	//convert group array



	public function MJ_gmgt_convert_grouparray($join_group)



	{



		$groups = array();



		foreach($join_group as $group)



			$groups[] = $group['group_id'];



		return $groups;



	}	



	//Delete All Memebr Data//



	public function MJ_gmgt_delete_all_member_data($member_id)



	{



		global $wpdb;



		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



		$table_gmgt_store = $wpdb->prefix. 'gmgt_store';



		$table_gmgt_income_expense = $wpdb->prefix. 'gmgt_income_expense';



		$gmgt_membership_payment=$wpdb->query($wpdb->prepare("DELETE FROM $table_gmgt_membership_payment WHERE member_id= %d",$member_id));



		$gmgt_store=$wpdb->query($wpdb->prepare("DELETE FROM $table_gmgt_store WHERE member_id= %d",$member_id));



		$gmgt_income_expense=$wpdb->query($wpdb->prepare("DELETE FROM $table_gmgt_income_expense WHERE supplier_name= %d",$member_id));



	}

	// EXTEND MEMBERSHIP DATA	
	public function MJ_gmgt_extend_membership($data)
	{
		global $wpdb;
		

		$table_gmgt_extend_membership = $wpdb->prefix.'gmgt_extend_membership';

		$extend_data['member_id'] = sanitize_text_field($data['member_id']);

		$extend_data['membership_id'] = sanitize_text_field($data['membership_id']);

		$extend_data['begin_date'] = MJ_gmgt_get_format_for_db(sanitize_text_field($data['begin_date']));

		$extend_data['end_date'] = MJ_gmgt_get_format_for_db(sanitize_text_field($data['end_date']));

		$extend_data['extend_day'] = sanitize_text_field($data['extend_day']);

		$extend_data['new_end_date'] = MJ_gmgt_get_format_for_db(sanitize_text_field($data['new_end_date']));

		// DATA ADD IN EXTEND MEMBERSHIP TABLE
		$extend_id = $wpdb->insert($table_gmgt_extend_membership, $extend_data);

		// EXTEND MEMBERSHIP UPDATE IN USER META
		update_user_meta( $data['member_id'],'end_date',MJ_gmgt_get_format_for_db(sanitize_text_field($data['new_end_date'])));
		$newStatus = 'Continue';
		update_user_meta($data['member_id'], 'membership_status', $newStatus);
		
	
		// EXTEND MEMBERSHIP UPDATE IN MEMBERSHIP PAYMENT
		$table_gmgt_membership_payment=$wpdb->prefix.'Gmgt_membership_payment';
		$end_date = MJ_gmgt_get_format_for_db(sanitize_text_field($data['new_end_date']));
		$membership_data = MJ_gmgt_get_membership_payment_data_by_memberid_membership_id_start_date(
			$data['member_id'],
			$data['membership_id'],
			MJ_gmgt_get_format_for_db(sanitize_text_field($data['begin_date']))
		);
		if ($membership_data) {
			$whereid = $membership_data->mp_id;
			$payment_data['end_date'] = $end_date;
			$payment_data['membership_status'] = $newStatus;
			$result = $wpdb->update($table_gmgt_membership_payment, $payment_data, ['mp_id' => $whereid]);
		} 
		return $extend_id;
		
	}
	


}






//MEMBER CLASS END   



?>