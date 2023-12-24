<?php 



//MEMBERSHIP CLASS START   



class MJ_gmgt_membership



{	



	//MEMBERSHIP DATA ADD



	public function MJ_gmgt_add_membership($data,$member_image_url)



	{		



		global $wpdb;



		$obj_activity=new MJ_gmgt_activity;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		//------- membership  table data --------------



		$membershipdata['membership_label']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['membership_name']));



		$membershipdata['membership_cat_id']=sanitize_text_field($data['membership_category']);



		$membershipdata['membership_length_id']=sanitize_text_field($data['membership_period']);		



		$membershipdata['membership_class_limit']=sanitize_text_field($data['member_limit']);



		if(isset($data['on_of_member']))



		{



			$membershipdata['on_of_member']=sanitize_text_field($data['on_of_member']);



		}



		else



		{



			$membershipdata['on_of_member']=0;		



		}



		$membershipdata['classis_limit']=sanitize_text_field($data['classis_limit']);		



		if(isset($data['on_of_classis']))



		{



			$membershipdata['on_of_classis']=sanitize_text_field($data['on_of_classis']);



		}



		else



		{



			$membershipdata['on_of_classis']=0;



		}



		if(isset($data['gmgt_membership_recurring']))



		{



			$membershipdata['gmgt_membership_recurring']="yes";



		}



		else



		{



			$membershipdata['gmgt_membership_recurring']="no";



		}



		$membershipdata['install_plan_id']=sanitize_text_field($data['installment_plan']);



		$membershipdata['membership_amount']=sanitize_text_field($data['membership_amount']);



		$membershipdata['installment_amount']=sanitize_text_field($data['installment_amount']);



		$membershipdata['signup_fee']=sanitize_text_field($data['signup_fee']);



		$membershipdata['membership_description']=$data['description'];



		$membershipdata['gmgt_membershipimage']=$member_image_url;



		$membershipdata['created_date']=date("Y-m-d");



		$membershipdata['created_by_id']=get_current_user_id();	



		$membershipdata['activity_cat_status']=1;	



		if(isset($data['tax']))



		{



			$membershipdata['tax']=implode(",",(array)$data['tax']);		



		}



		else



		{



			$membershipdata['tax']=null;		



		}	



		if(isset($data['activity_cat_id']))



		{



			$membershipdata['activity_cat_id']=implode(",",(array)$data['activity_cat_id']);		



		}



		else



		{



			$membershipdata['activity_cat_id']=null;



		}



		if(isset($data['gmgt_membership_class_book_approve']))



		{



			$membershipdata['gmgt_membership_class_book_approve']= 'yes';		



		}



		else



		{



			$membershipdata['gmgt_membership_class_book_approve']= 'no';



		}



		



		if($data['action']=='edit')



		{



			$membershipid['membership_id']=sanitize_text_field($data['membership_id']);



			$result=$wpdb->update( $table_membership, $membershipdata ,$membershipid);



			gym_append_audit_log(''.esc_html__('Membership Updated','gym_mgt').' ('.$data['membership_name'].')',$data['membership_id'],get_current_user_id(),'edit',$_REQUEST['page']);



			//-------------- OLD CLINET CODE ----------------//

			$gym_recurring_enable=get_option("gym_recurring_enable");



			if($data['gmgt_membership_recurring'] == "yes" && $gym_recurring_enable == "yes")



			{



				require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';



				$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");



				$gmgt_currency_code=get_option("gmgt_currency_code");



				$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");



				if(empty($gmgt_stripe_product_id))



				{



					$stripe = new \Stripe\StripeClient($gmgt_stripe_secret_key);



					//--------- Product create in user stripe account ------------//



					$product = $stripe->products->create([



					'name' => 'GYM Management System',



					]);



					update_option('gmgt_stripe_product_id', $product->id);



					$get_membership_details=$this->MJ_gmgt_get_single_membership($data['membership_id']);



					$stripe_plan_id=$get_membership_details->stripe_plan_id;



					if(empty($stripe_plan_id))



					{



						//--------- Price create in user stripe account ------------//



						$price = $stripe->prices->create([



							'unit_amount' => $data['membership_amount']*100,



							'nickname' => $data['membership_name'],



							'currency' => $gmgt_currency_code,



							'recurring' => ['interval' => 'day','interval_count' => $data['membership_period']],



							'product' => $product->id,



						]);



						$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");



						$membershipdata1['stripe_plan_id']= $price->id;	



						$membershipdata1['stripe_product_id']= $gmgt_stripe_product_id;	



						$membershipid1['membership_id']=sanitize_text_field($data['membership_id']);



						$result123=$wpdb->update( $table_membership, $membershipdata1 ,$membershipid1);



					}



				}



				else



				{



					$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");



					$gmgt_currency_code=get_option("gmgt_currency_code");



					$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");



					$stripe = new \Stripe\StripeClient($gmgt_stripe_secret_key);



					$get_membership_details=$this->MJ_gmgt_get_single_membership($data['membership_id']);



					$stripe_plan_id=$get_membership_details->stripe_plan_id;



					if(empty($stripe_plan_id))



					{



						//--------- Price create in client stripe account ------------//



						$price = $stripe->prices->create([



							'unit_amount' => $data['membership_amount']*100,



							'nickname' => $data['membership_name'],



							'currency' => $gmgt_currency_code,



							'recurring' => ['interval' => 'day','interval_count' => $data['membership_period']],



							'product' => $gmgt_stripe_product_id,



						]);



						$membershipdata1['stripe_plan_id']= $price->id;	



						$membershipdata1['stripe_product_id']= $gmgt_stripe_product_id;	



						$membershipid1['membership_id']=sanitize_text_field($data['membership_id']);



						$result123=$wpdb->update( $table_membership, $membershipdata1 ,$membershipid1);



					}



				}



			}

			//-------------- OLD CLINET CODE ----------------//

			$obj_activity->MJ_gmgt_add_membership_activities($data);



			return $result;



		}



		else



		{



		



			$result=$wpdb->insert( $table_membership, $membershipdata );

			$membership_id=$wpdb->insert_id;

			gym_append_audit_log(''.esc_html__('Membership Added','gym_mgt').' ('.$data['membership_name'].')',$membership_id,get_current_user_id(),'insert',$_REQUEST['page']);

			if($result)



			{



				$result=$wpdb->insert_id;

				//-------------- OLD CLINET CODE ----------------//

				$gym_recurring_enable=get_option("gym_recurring_enable");



				if($data['gmgt_membership_recurring'] == "yes" && $gym_recurring_enable == "yes")



				{



					require_once GMS_PLUGIN_DIR . '/lib/stripe/init.php';



					$gmgt_currency_code=get_option("gmgt_currency_code");



					$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");



					$gmgt_stripe_secret_key=get_option("gmgt_stripe_secret_key");



					if(empty($gmgt_stripe_product_id))



					{



						try {	



							$stripe = new \Stripe\StripeClient($gmgt_stripe_secret_key);



							//--------- Product create in user stripe account ------------//



							$product = $stripe->products->create([



							'name' => 'GYM Management System',



							]);



							update_option('gmgt_stripe_product_id', $product->id);



							//--------- Price create in user stripe account ------------//



							$price = $stripe->prices->create([



								'unit_amount' => $data['membership_amount']*100,



								'nickname' => $data['membership_name'],



								'currency' => $gmgt_currency_code,



								'recurring' => ['interval' => 'day','interval_count' => $data['membership_period']],



								'product' => $product->id,



							]);



							$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");



							$membershipdata1['stripe_plan_id']= $price->id;	



							$membershipdata1['stripe_product_id']= $gmgt_stripe_product_id;	



							$membershipid1['membership_id']=sanitize_text_field($result);



							$result123=$wpdb->update( $table_membership, $membershipdata1 ,$membershipid1);



						}



						catch(\Stripe\Error\Card $e) 



						{



							// Since it's a decline, \Stripe\Error\Card will be caught



							$body = $e->getJsonBody();



							$err  = $body['error'];



						  



							print('Status is:' . $e->getHttpStatus() . "\n");



							print('Type is:' . $err['type'] . "\n");



							print('Code is:' . $err['code'] . "\n");



							// param is '' in this case



							print('Param is:' . $err['param'] . "\n");



							print('Message is:' . $err['message'] . "\n");



						} catch (\Stripe\Error\RateLimit $e) {



							// Too many requests made to the API too quickly



						} catch (\Stripe\Error\InvalidRequest $e) {



						// Invalid parameters were supplied to Stripe's API



						} catch (\Stripe\Error\Authentication $e) {



						// Authentication with Stripe's API failed



							echo $e;



							die;



						// (maybe you changed API keys recently)



						} catch (\Stripe\Error\ApiConnection $e) {



						// Network communication with Stripe failed



							echo $e;



							die;



						} catch (\Stripe\Error\Base $e) {



							echo $e;



							die;



						// Display a very generic error to the user, and maybe send



						// yourself an email



						} catch (Exception $e) {



							echo $e;



							die;



						// Something else happened, completely unrelated to Stripe



						}



						  



					}



					else



					{



						try {



							//--------- Price create in user stripe account ------------//



							$stripe = new \Stripe\StripeClient($gmgt_stripe_secret_key);



							$price = $stripe->prices->create([



								'unit_amount' => $data['membership_amount']*100,



								'nickname' => $data['membership_name'],



								'currency' => $gmgt_currency_code,



								'recurring' => ['interval' => 'day','interval_count' => $data['membership_period']],



								'product' => $gmgt_stripe_product_id,



							]);



							$gmgt_stripe_product_id=get_option("gmgt_stripe_product_id");



							$membershipdata1['stripe_plan_id']= $price->id;	



							$membershipdata1['stripe_product_id']= $gmgt_stripe_product_id;	



							$membershipid1['membership_id']=sanitize_text_field($result);



							$result123=$wpdb->update( $table_membership, $membershipdata1 ,$membershipid1);



						}



						catch(\Stripe\Error\Card $e) 



						{



							// Since it's a decline, \Stripe\Error\Card will be caught



							$body = $e->getJsonBody();



							$err  = $body['error'];



						  



							print('Status is:' . $e->getHttpStatus() . "\n");



							print('Type is:' . $err['type'] . "\n");



							print('Code is:' . $err['code'] . "\n");



							// param is '' in this case



							print('Param is:' . $err['param'] . "\n");



							print('Message is:' . $err['message'] . "\n");



						} catch (\Stripe\Error\RateLimit $e) {



							// Too many requests made to the API too quickly



						} catch (\Stripe\Error\InvalidRequest $e) {



						// Invalid parameters were supplied to Stripe's API



						} catch (\Stripe\Error\Authentication $e) {



						// Authentication with Stripe's API failed



							echo $e;



							die;



						// (maybe you changed API keys recently)



						} catch (\Stripe\Error\ApiConnection $e) {



						// Network communication with Stripe failed



							echo $e;



							die;



						} catch (\Stripe\Error\Base $e) {



							echo $e;



							die;



						// Display a very generic error to the user, and maybe send



						// yourself an email



						} catch (Exception $e) {



							echo $e;



							die;



						// Something else happened, completely unrelated to Stripe



						}



					}



				}

				//-------------- OLD CLINET CODE ----------------//

			}



			$data['membership_id']=$result;



			$obj_activity->MJ_gmgt_add_membership_activities($data);



			return $result;



		}	



	}



	//get all membership



	public function MJ_gmgt_get_all_membership()



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership ORDER BY membership_id DESC");



		return $result;	



	}



	//get member own membership



	public function MJ_gmgt_get_member_own_membership($membership_id)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership where membership_id=$membership_id");



		return $result;	



	}



	public function MJ_gmgt_new_get_member_own_membership($membership_id)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership where membership_id=$membership_id ORDER BY membership_id desc limit 5");



		return $result;	



	}



	//get  membership by created by



	public function MJ_gmgt_get_membership_by_created_by($user_id)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership where created_by_id=$user_id");



		return $result;	



	}



	public function MJ_gmgt_new_get_membership_by_created_by($user_id)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership where created_by_id=$user_id ORDER BY membership_id desc limit 5");



		return $result;	



	}



	//get single membership



	public function MJ_gmgt_get_single_membership($id)



	{



		if($id == '')



		return '';



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_row("SELECT * FROM $table_membership where membership_id= ".$id);



		return $result;



	}



	//delete membership



	public function MJ_gmgt_delete_membership($id)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$membership_label = $wpdb->get_row("SELECT membership_label FROM $table_membership where membership_id= ".$id);



		gym_append_audit_log(''.esc_html__('Membership Deleted','gym_mgt').' ('.$membership_label->membership_label.')',$id,get_current_user_id(),'delete',$_REQUEST['page']);



		$result = $wpdb->query("DELETE FROM $table_membership where membership_id= ".$id);



		return $result;



	}



	//update membership  image



	public function MJ_gmgt_update_membershipimage($id,$imagepath)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$image['gmgt_membershipimage']=$imagepath;



		$membershipid['membership_id']=$id;



		return $result=$wpdb->update( $table_membership, $image, $membershipid);



	}



	//get membership activities



	public function MJ_gmgt_get_membership_activities($id)



	{



		global $wpdb;



		$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';



	



		$result = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where membership_id= ".$id);



		return $result;	



	}	



	//update membership Activity Category



	public function MJ_gmgt_update_membership_activity_category($membership_id,$category_id)



	{

		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		



		$membership_data = $wpdb->get_row("SELECT * FROM $table_membership where membership_id= ".$membership_id);



		



		$activity_cat_id_array=explode(",",$membership_data->activity_cat_id);

		// var_dump($category_id);

		// var_dump(in_array($category_id, $activity_cat_id_array));

		if (in_array($category_id, $activity_cat_id_array))



		{

			

			array_push($activity_cat_id_array,$category_id);	



			$membershipdata['activity_cat_id']=implode(',',array_filter($activity_cat_id_array));



			$membershipid['membership_id']=$membership_id;



			$result=$wpdb->update( $table_membership, $membershipdata, $membershipid);



			return $result;



		}



		else



		{	



			return $result= "";



		}	



	}



	//get all membership



	public function MJ_gmgt_get_all_membership_dashboard()



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership ORDER BY membership_id DESC limit 3");



		return $result;	



	}



	//get member own membership dashboard



	public function MJ_gmgt_get_member_own_membership_dashboard($membership_id)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership where membership_id=$membership_id ORDER BY membership_id DESC limit 3");



		return $result;	



	}



	//get  membership by created by dashboard



	public function MJ_gmgt_get_membership_by_created_by_dashboard($user_id)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership where created_by_id=$user_id ORDER BY membership_id DESC limit 3");



		return $result;	



	}



    public function MJ_gmgt_get_member_credit_class($member_id,$membership_id)



	{



		global $wpdb;



	    $gmgt_member_class_limit = $wpdb->prefix. 'gmgt_member_class_limit';



	    $member_class_limit = $wpdb->get_row("SELECT * FROM $gmgt_member_class_limit where member_id=$member_id AND membership_id=$membership_id");



		if(!empty($member_class_limit))



		{



			return $member_class_limit->class_limit;	



		}



	} 



	public function MJ_gmgt_get_recurring_membership_list()



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership where gmgt_membership_recurring = 'yes'");



		return $result;	



	}



	public function MJ_gmgt_get_recurring_membership_list_without_current_membership($membership_id)



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership where gmgt_membership_recurring = 'yes' AND membership_id !=".$membership_id);



		return $result;	



	}







	 //------ New-design functon ------//



	public function MJ_gmgt_get_new_all_membership_dashboard()



	{



		global $wpdb;



		$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



		$result = $wpdb->get_results("SELECT * FROM $table_membership ORDER BY membership_id DESC limit 3");



		return $result;	



	}



}



//MEMBERSHIP CLASS END



?>