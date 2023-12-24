<?php 

//ACTIVITY CLASS START  

class MJ_gmgt_activity

{	

	//ADD ACTIVITY DATA

	public function MJ_gmgt_add_activity($data)

	{

		global $wpdb;

		$obj_membership=new MJ_gmgt_membership;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

		$table_gmgt_membership_activities = $wpdb->prefix.'gmgt_membership_activities';



		$activitydata['activity_cat_id']=sanitize_text_field($data['activity_cat_id']);

		$activitydata['activity_title']=sanitize_text_field(MJ_gmgt_strip_tags_and_stripslashes($data['activity_title']));

		$activitydata['activity_assigned_to']=sanitize_text_field($data['staff_id']);

		$activitydata['activity_added_date']=date("Y-m-d");

		$activitydata['activity_added_by']=get_current_user_id();

		$video_entry=$this->MJ_gmgt_get_entry_video($data);

		$activitydata['video_entry']=$video_entry;



		if($data['action']=='edit')

		{

			$activityid['activity_id']=sanitize_text_field($data['activity_id']);

			$result=$wpdb->update( $table_activity, $activitydata ,$activityid);

			gym_append_audit_log(''.esc_html__('Activity Updated','gym_mgt').' ('.$data['activity_title'].')',$data['activity_id'],get_current_user_id(),'edit',$_REQUEST['page']);
		
			if(!empty($data['membership_id']))

			{



				$this->MJ_gmgt_delete_activity_membership($data['activity_id']);

				

				foreach($data['membership_id'] as $val)

				{				

					$assignactivitydata['activity_id']=sanitize_text_field($data['activity_id']);

					$assignactivitydata['membership_id']=sanitize_text_field($val);

					$assignactivitydata['created_date']=sanitize_text_field(date("Y-m-d"));

					$assignactivitydata['created_by']=get_current_user_id();

					$wpdb->insert( $table_gmgt_membership_activities, $assignactivitydata );

					$result1=$obj_membership->MJ_gmgt_update_membership_activity_category($val,$data['activity_cat_id']);					
					
				}
				return $result1;

			}
			
		}

		else

		{

			$result=$wpdb->insert( $table_activity, $activitydata );

			$activity_id=$wpdb->insert_id;

			gym_append_audit_log(''.esc_html__('Activity Added','gym_mgt').' ('.$data['activity_title'].')',$activity_id,get_current_user_id(),'insert',$_REQUEST['page']);

			if(!empty($data['membership_id']))

			{

				foreach($data['membership_id'] as $val)

				{

					$assignactivitydata['activity_id']=sanitize_text_field($activity_id);

					$assignactivitydata['membership_id']=sanitize_text_field($val);

					$assignactivitydata['created_date']=sanitize_text_field(date("Y-m-d"));

					$assignactivitydata['created_by']=get_current_user_id();

					$wpdb->insert( $table_gmgt_membership_activities, $assignactivitydata );

					$obj_membership->MJ_gmgt_update_membership_activity_category($val,$data['activity_cat_id']);

				}

			}

			return $result;

		}

	}

	//--------Video entry----------------

	public function MJ_gmgt_get_entry_video($data)

	{

		$all_video_title=$data['video_title'];

		if(count(array_filter($all_video_title)) == count($all_video_title)) 

		{

			$all_video_link=$data['video_link'];

			$entry_data=array();

			$i=0;

			foreach($all_video_title as $one_entry)

			{

				if(!empty($one_entry))

				{

					$entry_data[]= array('video_title'=>MJ_gmgt_strip_tags_and_stripslashes($one_entry),

								'video_link'=>$all_video_link[$i]);

					$i++;

				}			

			}

			return json_encode($entry_data);

		}

	}

	//get all activity//

	public function MJgmet_all_activity()

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

		$result = $wpdb->get_results("SELECT * FROM $table_activity ORDER BY activity_id DESC");

		return $result;	

	}

	//get all activity by activity category//

	public function MJ_gmgt_get_all_activity_by_activity_category($activity_category_list)

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

		$category_array_to_string = implode("','",$activity_category_list);

		$result = $wpdb->get_results("SELECT * FROM $table_activity where activity_cat_id IN ('".$category_array_to_string."')");

		return $result;	

	}

	//get all activity by Activity added by//

	public function MJ_gmgt_get_all_activity_by_activity_added_by($user_id)

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

	

		$result = $wpdb->get_results("SELECT * FROM $table_activity where activity_added_by=$user_id");

		return $result;	

	}

	public function MJ_gmgt_new_get_all_activity_by_activity_added_by($user_id)

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

	

		$result = $wpdb->get_results("SELECT * FROM $table_activity where activity_added_by=$user_id order by activity_id DESC limit 3");

		return $result;	

	}

	//get single activity//

	public function MJ_gmgt_get_single_activity($id)

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

		$result = $wpdb->get_row("SELECT * FROM $table_activity where activity_id=".$id);

		return $result;

	}

	//delete activity//

	public function MJ_gmgt_delete_activity($id)

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

		$activity_title = $wpdb->get_row("SELECT activity_title FROM $table_activity where activity_id=".$id);

		gym_append_audit_log(''.esc_html__('Activity Deleted','gym_mgt').' ('.$activity_title->activity_title.')',$id,get_current_user_id(),'delete',$_REQUEST['page']);

		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';

		$result = $wpdb->query("DELETE FROM $table_activity where activity_id= ".$id);

		$wpdb->query("DELETE FROM $table_gmgt_membership_activities where activity_id= ".$id);


		return $result;

	}

	//check activity membership//

	public function MJ_gmgt_check_activity_membership($data)

	{

		global $wpdb;

		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';

		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_membership_activities where activity_id= ".$data['activity_id']." AND membership_id=".$data['membership_id']);

		

		if(!empty($result))

		{

			return $result->id;

		}

		else

		{

			return false;  

		}

	}

	//get activity membership//

	public function MJ_gmgt_get_activity_membership($id)

	{

		global $wpdb;

		$result=array();

		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';

		$memberships = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where activity_id= ".$id);

		if(!empty($memberships))

		{

			foreach($memberships as $row)

			{

				$result[]=$row->membership_id;

			}

			return $result;

		}

		else

		{

			return $result;

		}

	}

	//get membership activity//

	public function MJ_gmgt_get_membership_activity($id)

	{

		global $wpdb;

		$result=array();

		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';

		$activities = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where membership_id= ".$id);

		if(!empty($activities))

		{

			foreach($activities as $row)

			{

				$result[]=$row->activity_id;

			}

			return $result;

		}

		else

		{

			return $result;

		}

	}

	//get membership activity category//

	public function MJ_gmgt_get_membership_activity_category($activity_id_array)

	{

		global $wpdb;

		$result=array();

		$category_array_to_string = implode("','",$activity_id_array);

		$table_gmgt_activity = $wpdb->prefix. 'gmgt_activity';

		$activities = $wpdb->get_results("SELECT * FROM $table_gmgt_activity where activity_id IN ('".$category_array_to_string."')");

		

		if(!empty($activities))

		{

			foreach($activities as $row)

			{

				$result[]=$row->activity_cat_id;

			}

			return $result;

		}

		else

		{

			return $result;

		}

	}

	//delete  activity membership//

	public function MJ_gmgt_delete_activity_membership($id)

	{

		global $wpdb;

		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';

		$wpdb->query("DELETE FROM $table_gmgt_membership_activities where activity_id= ".$id);

	}

	//delete membership activities//

	public function MJ_gmgt_delete_membership_activities($id)

	{

		global $wpdb;

		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';

		$wpdb->query("DELETE FROM $table_gmgt_membership_activities where membership_id= ".$id);

	}

	//add membership activity//

	public function MJ_gmgt_add_membership_activities($data)

	{

		global $wpdb;

		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';

		if(!empty($data['activity_id']))

		{

			$this->MJ_gmgt_delete_membership_activities($data['membership_id']);

			foreach($data['activity_id'] as $val)

			{				

				$assignactivitydata['activity_id']=$val;

				$assignactivitydata['membership_id']=$data['membership_id'];

				$assignactivitydata['created_date']=date("Y-m-d");

				$assignactivitydata['created_by']=get_current_user_id();

				$result=$wpdb->insert( $table_gmgt_membership_activities, $assignactivitydata );

			}

			return $result;			

		}

	}

	//delete membership activity//

	public function MJ_gmgt_delete_membership_activity($id)

	{

		global $wpdb;

		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';

		$result=$wpdb->query("DELETE FROM $table_gmgt_membership_activities where id= ".$id);

		return $result;

	}



    //get activity by assigned id//

	public function MJ_gmgt_get_activity_staffmemberwise($id)

	{

		global $wpdb;

		$result=array();

		$table_gmgt_activity = $wpdb->prefix. 'gmgt_activity';

		$activities = $wpdb->get_results("SELECT * FROM $table_gmgt_activity where activity_assigned_to= ".$id);

		if(!empty($activities)){

			foreach($activities as $row)

			{

				$result[]=$row->activity_title;

			}

			return $result;

		}

		else

		{

			return $result;

		}

	}	

	//get all activity//

	public function MJgmet_all_activity_dashboard()

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

	

		$result = $wpdb->get_results("SELECT * FROM $table_activity ORDER BY activity_id DESC limit 3");

		return $result;	

	}

	//get all activity by Activity added by Dashboeard//

	public function MJ_gmgt_get_all_activity_by_activity_added_by_dashboard($user_id)

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

	

		$result = $wpdb->get_results("SELECT * FROM $table_activity where activity_added_by=$user_id ORDER BY activity_id DESC limit 3");

		return $result;	

	}

	public function MJgmet_all_activity_by_activity_ids($member_activity_ids)

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

		$result = $wpdb->get_results("SELECT * FROM $table_activity where activity_id IN ( $member_activity_ids ) ");

		return $result;	

	}

	public function MJgmet_new_all_activity_by_activity_ids($member_activity_ids)

	{

		global $wpdb;

		$table_activity = $wpdb->prefix. 'gmgt_activity';

		$result = $wpdb->get_results("SELECT * FROM $table_activity where activity_id IN ( $member_activity_ids ) ORDER BY activity_id DESC limit 3");

		return $result;	

	}

	 //------ New-design functon ------//

	 public function MJgmet_new_all_activity_dashboard()

	 {

		 global $wpdb;

		 $table_activity = $wpdb->prefix. 'gmgt_activity';

	 

		 $result = $wpdb->get_results("SELECT * FROM $table_activity ORDER BY activity_id DESC limit 3");

		 return $result;	

	 }

	 

}

//ACTIVITY CLASS END  

?>