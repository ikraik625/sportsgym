<?php 	  



//PAYMENT CLASS START 



class MJ_gmgt_payment



{	



	//ADD Payment DATA



	public function MJ_gmgt_add_payment($data)



	{



		global $wpdb;



		$table_payment=$wpdb->prefix.'gmgt_payment';



		$paymentdata['title']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['payment_title']));



		$paymentdata['member_id']=sanitize_text_field($data['member_id']);



		$paymentdata['due_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['due_date']));		



		$paymentdata['total_amount']=sanitize_text_field($data['total_amount']);



		$paymentdata['discount']=sanitize_text_field($data['discount']);



		$paymentdata['payment_status']=sanitize_text_field($data['payment_status']);		



		$paymentdata['description']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['description']));



		$paymentdata['payment_date']=date("Y-m-d");



		$paymentdata['receiver_id']=get_current_user_id();



		if($data['action']=='edit')



		{



			$paymentid['payment_id']=sanitize_text_field($data['payment_id']);



			$result=$wpdb->update( $table_payment, $paymentdata ,$paymentid);



			return $result;



		}



		else



		{			



			$result=$wpdb->insert( $table_payment,$paymentdata);



			return $result;



		}	



	}



	//get all payment



	public function MJ_gmgt_get_all_payment()



	{



		global $wpdb;



		$table_payment = $wpdb->prefix. 'gmgt_payment';



		$result = $wpdb->get_results("SELECT * FROM $table_payment");



		return $result;	



	}



	//get single payment



	public function MJ_gmgt_get_single_payment($id)



	{



		global $wpdb;



		$table_payment = $wpdb->prefix. 'gmgt_payment';



		$result = $wpdb->get_row("SELECT * FROM $table_payment where payment_id=".$id);



		return $result;



	}



	//get own payment



	public function MJ_gmgt_get_own_payment($id)



	{



		global $wpdb;



		$table_payment = $wpdb->prefix. 'gmgt_payment';



		$result = $wpdb->get_results("SELECT * FROM $table_payment where member_id=".$id);



		return $result;



	}



	//delete payment



	public function MJ_gmgt_delete_payment($id)



	{



		global $wpdb;



		$table_payment = $wpdb->prefix. 'gmgt_payment';



		$result = $wpdb->query("DELETE FROM $table_payment where payment_id= ".$id);



		return $result;



	}



	//--------Income entry----------------



	public function MJ_gmgt_get_entry_records($data)



	{



		$all_income_entry=$data['income_entry'];



		$all_income_amount=$data['income_amount'];



		



		$entry_data=array();



		$i=0;



		foreach($all_income_entry as $one_entry)



		{



			$entry_data[]= array('entry'=>MJ_gmgt_strip_tags_and_stripslashes($one_entry),



						'amount'=>$all_income_amount[$i]);



			$i++;		



		}



		return json_encode($entry_data);



	}



	//add income



	public function MJ_gmgt_add_income($data)



	{



		



		$entry_value=$this->MJ_gmgt_get_entry_records($data);



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$incomedata['invoice_type']=sanitize_text_field($data['invoice_type']);



		$incomedata['invoice_label']=MJ_gmgt_strip_tags_and_stripslashes(stripslashes($data['invoice_label']));



		$incomedata['supplier_name']=MJ_gmgt_strip_tags_and_stripslashes($data['supplier_name']);	



		$incomedata['entry']=$entry_value;



		//count amount by entry



		$value=json_decode($entry_value);



		if(!empty($value))



		{



			$total=0;	



			foreach($value as $entry)



			{



				 $total+=$entry->amount;



			}



		}



		$incomedata['amount']=$total;



		$incomedata['discount']=sanitize_text_field($data['discount']);





		if(isset($data['tax']))



		{



			$incomedata['tax_id']=implode(",",$data['tax']);



		}



		else



		{



			$incomedata['tax_id']=null;	



		}



		$total_after_discount_amount= $total - (int)sanitize_text_field($data['discount']);



		if(!empty($data['tax']))



		{



			$total_tax=0;



			foreach($data['tax'] as $tax_id)



			{



				$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



				//var_dump($tax_percentage);die;



				$tax_amount=$total_after_discount_amount * (int)$tax_percentage / 100;



				//var_dump($tax_amount);die;



				$total_tax=$total_tax + $tax_amount;				



			}



			$total_amount_withtax=$total_after_discount_amount + $total_tax;



		}



		else



		{



			$total_tax=0;			



			$total_amount_withtax=$total_after_discount_amount + $total_tax;



		}



		$incomedata['tax'] = $total_tax;



		$incomedata['total_amount']=$total_amount_withtax;



		$incomedata['receiver_id']=get_current_user_id();



		if($data['action']=='edit')



		{



			$incomedata['invoice_no']=sanitize_text_field($data['invoice_no']);



			$income_dataid['invoice_id']=sanitize_text_field($data['income_id']);



			if(isset($data['paid_amount']))



			{



			$incomedata['paid_amount']=$data['paid_amount'];



			$paid_amount=$data['paid_amount'];



				if($paid_amount == 0 || $paid_amount == 0.00)



				{



					$status="Unpaid";



				}



				elseif($paid_amount < $total_amount_withtax)



				{



					$status="Partially Paid";



				}



				elseif($paid_amount >= $total_amount_withtax)



				{



					$status="Fully Paid";



				}



			}



			$incomedata['payment_status']=$status;



			$result=$wpdb->update( $table_income, $incomedata ,$income_dataid);



			gym_append_audit_log(''.esc_html__('Invoice Updated','gym_mgt').' ('.$data['invoice_label'].')',$income_dataid,get_current_user_id(),'edit',$_REQUEST['page']);



			return $result;



		}



		else



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



			



			$incomedata['invoice_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['invoice_date']));



			$incomedata['invoice_no']=$invoice_no;



			$incomedata['paid_amount']=0;



			$incomedata['payment_status']='Unpaid';



			$incomedata['create_by']=get_current_user_id();



			$result=$wpdb->insert( $table_income,$incomedata);



			$insert_id=$wpdb->insert_id;



			gym_append_audit_log(''.esc_html__('Invoice Added','gym_mgt').' ('.$data['invoice_label'].')',$insert_id,get_current_user_id(),'insert',$_REQUEST['page']);



			//income invoice mail send



			//------------- SEND MESSAGE --------------------//



			$current_sms_service 	= 	get_option( 'gmgt_sms_service');



			if(is_plugin_active('sms-pack/sms-pack.php'))

			{



				$userdata=get_userdata(MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['supplier_name'])));



				$mobile_number=array(); 



				$gymname=get_option( 'gmgt_system_name' );



				$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



				$message_content ="Your payment invoice generated at ".$gymname;



				$args = array();



				$args['mobile']=$mobile_number;



				$args['message_from']="Invoice Payment";



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



					$userinfo=get_userdata(esc_attr($data['supplier_name']));



					$gymname=get_option( 'gmgt_system_name' );						



					$reciever_number = $userinfo->mobile;		



					$message_content ="Your payment invoice generated at ".$gymname;



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



			$gymname=get_option( 'gmgt_system_name' );



			$userdata=get_userdata(MJ_gmgt_strip_tags_and_stripslashes($data['supplier_name']));



			$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($userdata->ID);		



			$arr['[GMGT_GYM_NAME]']=$gymname;



			$subject =get_option('add_income_subject');



			$sub_arr['[GMGT_ROLE_NAME]']=implode(',', $userdata->roles);



			$sub_arr['[GMGT_GYM_NAME]']=$gymname;



			$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



			$message = get_option('add_income_template');	



			$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



			$to=$userdata->user_email;



	



			$type='income';



			MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$insert_id,$type);



			return $result;



			



		}



	}	



	//add income payment



	public function MJ_gmgt_add_income_payment($data)



	{



		global $wpdb;



		$income_data['mp_id']=sanitize_text_field($data['mp_id']);



		$income_data['amount']=sanitize_text_field($data['amount']);



		$income_data['payment_method']=sanitize_text_field($data['payment_method']);



		$paid_amount_data= $this->MJ_gmgt_get_all_income_data_bymp_id(sanitize_text_field($data['mp_id']));



		$total_amount=$paid_amount_data->total_amount;



		$paid_amount=$paid_amount_data->paid_amount;



		$due_amount=$total_amount - $paid_amount;



		$total_paid_amount=	$paid_amount + $income_data['amount'];



		if($total_paid_amount == 0 || $total_paid_amount == 0.00)



		{



			$status="Unpaid";



		}



		elseif($total_paid_amount < $total_amount)



		{



			$status="Partially Paid";



		}



		elseif($total_paid_amount >= $total_amount)



		{



			$status="Fully Paid";



		}	



			$income['payment_status']=$status;



			$income['paid_amount']=$paid_amount + $income_data['amount'];



			$income_id['invoice_id']=sanitize_text_field($data['mp_id']);



			$table_income=$wpdb->prefix.'gmgt_income_expense';



			$table_gmgt_income_payment_history=$wpdb->prefix.'gmgt_income_payment_history';



			$result=$wpdb->update($table_income, $income,$income_id);



			$invoicedata=$this->MJ_gmgt_get_single_income_invoice_bymp_id($data['mp_id']);	



			if($invoicedata->invoice_label!='Sell Product' && $invoicedata->invoice_label!='Fees Payment')



			{				



				$incomedata['invoice_id']=sanitize_text_field($data['mp_id']);



				$incomedata['member_id']=$invoicedata->supplier_name;



				$incomedata['amount']=sanitize_text_field($data['amount']);



				$incomedata['payment_method']=sanitize_text_field($data['payment_method']);	



				$incomedata['payment_description']=sanitize_text_field($data['payment_description']);



				if(isset($data['trasaction_id']))



				{



					$incomedata['trasaction_id']=sanitize_text_field($data['trasaction_id']);



				}



				$incomedata['paid_by_date']=date("Y-m-d");



				$incomedata['created_by']=sanitize_text_field($data['created_by']);



				$result=$wpdb->insert( $table_gmgt_income_payment_history,$incomedata );



				//------------- SEND MESSAGE --------------------//



				$current_sms_service 	= 	get_option( 'gmgt_sms_service');



				if(is_plugin_active('sms-pack/sms-pack.php'))



				{



					$userdata=get_userdata($invoicedata->supplier_name);



					$mobile_number=array(); 



					$gymname=get_option( 'gmgt_system_name' );



					$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



					$message_content ="You have successfully paid your invoice at ".$gymname;



					$args = array();



					$args['mobile']=$mobile_number;



					$args['message_from']="Received Payment";



					$args['message']=$message_content;					



					if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



					{				



						$send = send_sms($args);							



					}



				}



			



				//payment success mail



				$gymname=get_option( 'gmgt_system_name' );



				$member_id=$invoicedata->supplier_name;



				$userdata=get_userdata($member_id);



				$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($member_id);	



				$arr['[GMGT_GYM_NAME]']=$gymname;



				$subject =get_option('payment_received_against_invoice_subject');



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$message = get_option('payment_received_against_invoice_template');	



				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



				$to=$userdata->user_email;



				$type='income';



				MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$data['mp_id'],$type);



				return $result;



			}



			$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



			$table_gmgt_membership_payment_history = $wpdb->prefix .'gmgt_membership_payment_history';



			$gmgt_sales_payment_history = $wpdb->prefix. 'gmgt_sales_payment_history';



			$invoice_no=$this->MJ_gmgt_get_invoice_no_bymp_id($data['mp_id']);



			$membership_payment_id['mp_id']=$this->MJ_gmgt_get_membership_payment_id_invoice_no($invoice_no);



			$membershipid=$this->MJ_gmgt_get_membership_payment_id_invoice_no($invoice_no);



			$mp_id=$this->MJ_gmgt_get_membership_payment_id_invoice_no($invoice_no);



			if(!empty($membershipid))



			{		



				$result=$wpdb->update($table_gmgt_membership_payment, $income,$membership_payment_id);



				



				$feedata['mp_id']=$mp_id;



				$feedata['amount']=sanitize_text_field($data['amount']);



				$feedata['payment_method']=sanitize_text_field($data['payment_method']);	



				$feedata['payment_description']=sanitize_text_field($data['payment_description']);



				if(isset($data['trasaction_id']))



				{



					$feedata['trasaction_id']=sanitize_text_field($data['trasaction_id']);



				}



				$feedata['paid_by_date']=date("Y-m-d");



				$feedata['created_by']=sanitize_text_field($data['created_by']);



				$result=$wpdb->insert( $table_gmgt_membership_payment_history,$feedata );



				//------------- SEND MESSAGE --------------------//



				$current_sms_service 	= 	get_option( 'gmgt_sms_service');



				if(is_plugin_active('sms-pack/sms-pack.php'))



				{



					$member_id=$this->MJ_gmgt_get_member_id_by_mp_id($mp_id);



					$userdata=get_userdata($member_id);



					$mobile_number=array(); 



					$gymname=get_option( 'gmgt_system_name' );



					$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



					$message_content ="You have successfully paid your invoice at ".$gymname;



					$args = array();



					$args['mobile']=$mobile_number;



					$args['message_from']="Received Payment";



					$args['message']=$message_content;					



					if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



					{				



						$send = send_sms($args);							



					}



				}



				//payment success mail



				$gymname=get_option( 'gmgt_system_name' );



				$member_id=$this->MJ_gmgt_get_member_id_by_mp_id($mp_id);



				$userdata=get_userdata($member_id);



				$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($member_id);	



				$arr['[GMGT_GYM_NAME]']=$gymname;



				$subject =get_option('payment_received_against_invoice_subject');



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$message = get_option('payment_received_against_invoice_template');	



				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



				$to=$userdata->user_email;



				$type='membership_invoice';



				MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$mp_id,$type);



				return $result;



			}



			$gmgt_sales_payment_history = $wpdb->prefix. 'gmgt_sales_payment_history';



			$table_sell = $wpdb->prefix. 'gmgt_store';



			$sell_product_data=$this->MJ_gmgt_get_sell_product_id_invoice_no($invoice_no);



			$sell_product_id['id']=$sell_product_data->id;



			$sellid=$sell_product_data->id;



			if(!empty($sellid))



			{				



				$result=$wpdb->update($table_sell, $income,$sell_product_id);



				$saledata['sell_id']=$sell_product_data->id;



				$saledata['member_id']=$sell_product_data->member_id;



				$saledata['amount']=sanitize_text_field($data['amount']);



				$saledata['payment_method']=sanitize_text_field($data['payment_method']);	



				$saledata['payment_description']=sanitize_text_field($data['payment_description']);	



				if(isset($data['trasaction_id']))



				{



					$saledata['trasaction_id']=sanitize_text_field($data['trasaction_id']) ;



				}



				$saledata['paid_by_date']=date("Y-m-d");



				$saledata['created_by']=sanitize_text_field($data['created_by']);



				$result=$wpdb->insert( $gmgt_sales_payment_history,$saledata );



				//------------- SEND MESSAGE --------------------//



				$current_sms_service 	= 	get_option( 'gmgt_sms_service');



				if(is_plugin_active('sms-pack/sms-pack.php'))



				{



					$userdata=get_userdata($sell_product_data->member_id);



					$mobile_number=array(); 



					$gymname=get_option( 'gmgt_system_name' );



					$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



					$message_content ="You have successfully paid your invoice at ".$gymname;



					$args = array();



					$args['mobile']=$mobile_number;



					$args['message_from']="Received Payment";



					$args['message']=$message_content;					



					if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



					{				



						$send = send_sms($args);							



					}



				}



				//payment success mail



				$gymname=get_option( 'gmgt_system_name' );



				$userdata=get_userdata($sell_product_data->member_id);



				$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($sell_product_data->member_id);	



				$arr['[GMGT_GYM_NAME]']=$gymname;



				$subject =get_option('payment_received_against_invoice_subject');



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$message = get_option('payment_received_against_invoice_template');	



				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



				$to=$userdata->user_email;



				$type='sell_invoice';



				MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$sell_product_data->id,$type);



				return $result;



			}



		return $result;			



	}



	// add income payment history



	public function MJ_gmgt_add_income_payment_history($data)



	{







		global $wpdb;



		if($data['payment_method'] == "Stripe")



		{



		  	$income_data['income_id']=sanitize_text_field($data['mp_id']);



		}



		else



		{



			$income_data['income_id']=sanitize_text_field($data['income_id']);



			



		}



		$income_data['amount']=sanitize_text_field($data['amount']);



		$income_data['payment_method']=sanitize_text_field($data['payment_method']);



		



		$paid_amount_data= $this->MJ_gmgt_get_all_income_data_bymp_id($income_data['income_id']);



		$total_amount=$paid_amount_data->total_amount;



		$paid_amount=$paid_amount_data->paid_amount;



		



		$due_amount=$total_amount - $paid_amount;



		



		$total_paid_amount=	$paid_amount + sanitize_text_field($data['amount']);



			if($total_paid_amount == 0 || $total_paid_amount == 0.00)



			{



				$status="Unpaid";



			}



			elseif($total_paid_amount < $total_amount)



			{



				$status="Partially Paid";



			}



			elseif($total_paid_amount >= $total_amount)



			{



				$status="Fully Paid";



			}	



		        $income['payment_status']=$status;



				$income['paid_amount']=$paid_amount + sanitize_text_field($data['amount']);



				$income_id['invoice_id']=sanitize_text_field($income_data['income_id']);



			$table_income=$wpdb->prefix.'gmgt_income_expense';



			$table_gmgt_income_payment_history=$wpdb->prefix.'gmgt_income_payment_history';



			$result=$wpdb->update($table_income, $income,$income_id);



			$invoicedata=$this->MJ_gmgt_get_single_income_invoice_bymp_id($income_data['income_id']);



			if($invoicedata->invoice_label!='Sell Product' && $invoicedata->invoice_label!='Fees Payment')



			{				



				$incomedata['invoice_id']=$income_data['income_id'];



				$incomedata['member_id']=$invoicedata->supplier_name;



				$incomedata['amount']=sanitize_text_field($data['amount']);



				$incomedata['payment_method']=sanitize_text_field($data['payment_method']);	



				if(isset($data['trasaction_id']))



				{



					$incomedata['trasaction_id']=sanitize_text_field($data['trasaction_id']);



				}



				$incomedata['paid_by_date']=date("Y-m-d");



				$incomedata['created_by']=sanitize_text_field($data['created_by']);



				$result=$wpdb->insert( $table_gmgt_income_payment_history,$incomedata );



				//------------- SEND MESSAGE --------------------//



				$current_sms_service 	= 	get_option( 'gmgt_sms_service');



				if(is_plugin_active('sms-pack/sms-pack.php'))



				{



					$userdata=get_userdata($invoicedata->supplier_name);



					$mobile_number=array(); 



					$gymname=get_option( 'gmgt_system_name' );



					$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



					$message_content ="You have successfully paid your invoice at ".$gymname;



					$args = array();



					$args['mobile']=$mobile_number;



					$args['message_from']="Received Payment";



					$args['message']=$message_content;					



					if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



					{				



						$send = send_sms($args);							



					}



				}



				//payment success mail



				$gymname=get_option( 'gmgt_system_name' );



				$member_id=$invoicedata->supplier_name;



				update_user_meta( $member_id,'unpaid_membership_status','Continue');

				

				$userdata=get_userdata($member_id);



				$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($member_id);	



				$arr['[GMGT_GYM_NAME]']=$gymname;



				$subject =get_option('payment_received_against_invoice_subject');



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$message = get_option('payment_received_against_invoice_template');	



				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



				$to=$userdata->user_email;



				$type='income';



				MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$income_data['income_id'],$type);



				return $result;



			}



			



			$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



			$table_gmgt_membership_payment_history = $wpdb->prefix .'gmgt_membership_payment_history';



			$invoice_no=$this->MJ_gmgt_get_invoice_no_bymp_id($income_data['income_id']);



			$membership_payment_id['mp_id']=$this->MJ_gmgt_get_membership_payment_id_invoice_no($invoice_no);



			$membershipid=$this->MJ_gmgt_get_membership_payment_id_invoice_no($invoice_no);



			$mp_id=$this->MJ_gmgt_get_membership_payment_id_invoice_no($invoice_no);



			$member_id=$this->MJ_gmgt_get_member_id_by_mp_id($mp_id);



			update_user_meta( $member_id,'unpaid_membership_status','Continue');



			if(!empty($membershipid))



			{				



				$result=$wpdb->update($table_gmgt_membership_payment, $income,$membership_payment_id);



				$feedata['mp_id']=$mp_id;



				$feedata['amount']=sanitize_text_field($data['amount']);



				$feedata['payment_method']=sanitize_text_field($data['payment_method']);	



				if(isset($data['trasaction_id']))



				{



					$feedata['trasaction_id']=sanitize_text_field($data['trasaction_id']);



				}



				$feedata['paid_by_date']=date("Y-m-d");



				$feedata['created_by']=sanitize_text_field($data['created_by']);



				$result=$wpdb->insert( $table_gmgt_membership_payment_history,$feedata );



				//------------- SEND MESSAGE --------------------//



				$current_sms_service 	= 	get_option( 'gmgt_sms_service');



				if(is_plugin_active('sms-pack/sms-pack.php'))



				{



					$member_id=$this->MJ_gmgt_get_member_id_by_mp_id($mp_id);



					$userdata=get_userdata($member_id);



					$mobile_number=array(); 



					$gymname=get_option( 'gmgt_system_name' );



					$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



					$message_content ="You have successfully paid your invoice at ".$gymname;



					$args = array();



					$args['mobile']=$mobile_number;



					$args['message_from']="Received Payment";



					$args['message']=$message_content;					



					if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



					{				



						$send = send_sms($args);							



					}



				}



				//payment success mail



				$gymname=get_option( 'gmgt_system_name' );



				$member_id=$this->MJ_gmgt_get_member_id_by_mp_id($mp_id);



				$userdata=get_userdata($member_id);



				$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($member_id);	



				$arr['[GMGT_GYM_NAME]']=$gymname;



				$subject =get_option('payment_received_against_invoice_subject');



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$message = get_option('payment_received_against_invoice_template');	



				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



				$to=$userdata->user_email;



				$type='membership_invoice';



				MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$mp_id,$type);



				return $result;



			}



			$gmgt_sales_payment_history = $wpdb->prefix. 'gmgt_sales_payment_history';



			$table_sell = $wpdb->prefix. 'gmgt_store';



			$sell_product_data=$this->MJ_gmgt_get_sell_product_id_invoice_no($invoice_no);



			$sell_product_id['id']=$sell_product_data->id;



			$sellid=$sell_product_data->id;



			if(!empty($sellid))



			{				



				$result=$wpdb->update($table_sell, $income,$sell_product_id);



				$saledata['sell_id']=$sell_product_data->id;



				$saledata['member_id']=$sell_product_data->member_id;



				$saledata['amount']=sanitize_text_field($data['amount']);



				$saledata['payment_method']=sanitize_text_field($data['payment_method']);	



				if(isset($data['trasaction_id']))



				{



					$saledata['trasaction_id']=sanitize_text_field($data['trasaction_id']);



				}



				$saledata['paid_by_date']=date("Y-m-d");



				$saledata['created_by']=sanitize_text_field($data['created_by']);



				$result=$wpdb->insert( $gmgt_sales_payment_history,$saledata );



				//------------- SEND MESSAGE --------------------//



				$current_sms_service 	= 	get_option( 'gmgt_sms_service');



				if(is_plugin_active('sms-pack/sms-pack.php'))



				{



					$userdata=get_userdata($sell_product_data->member_id);



					$mobile_number=array(); 



					$gymname=get_option( 'gmgt_system_name' );



					$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userdata->mobile;



					$message_content ="You have successfully paid your invoice at ".$gymname;



					$args = array();



					$args['mobile']=$mobile_number;



					$args['message_from']="Received Payment";



					$args['message']=$message_content;					



					if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



					{				



						$send = send_sms($args);							



					}



				}



				//payment success mail



				$gymname=get_option( 'gmgt_system_name' );



				$userdata=get_userdata($sell_product_data->member_id);



				$arr['[GMGT_USERNAME]']=MJ_gmgt_get_user_full_display_name($sell_product_data->member_id);	



				$arr['[GMGT_GYM_NAME]']=$gymname;



				$subject =get_option('payment_received_against_invoice_subject');



				$sub_arr['[GMGT_GYM_NAME]']=$gymname;



				$subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



				$message = get_option('payment_received_against_invoice_template');	



				$message_replacement = MJ_gmgt_string_replacemnet($arr,$message);



				$to=$userdata->user_email;



				$type='sell_invoice';



				 



				 MJ_gmgt_send_invoice_generate_mail($to,$subject,$message_replacement,$sell_product_data->id,$type);



				return $result;



			}



		return $result;		



	}



	//get single income invoice by mp id 



	public function MJ_gmgt_get_single_income_invoice_bymp_id($mp_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_row("SELECT * FROM $table_income where invoice_id=$mp_id");



		return $result;		



	}



	//get invoice number by mp id 



	public function MJ_gmgt_get_invoice_no_bymp_id($mp_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_row("SELECT invoice_no FROM $table_income where invoice_id=$mp_id");



		if(!empty($result))



		{



			return $result->invoice_no;		



		}



		



	}



	//get sell id by income id



	public function MJ_gmgt_get_sell_id_by_income_id($invoice_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$result_invoice_no = $wpdb->get_row("SELECT invoice_no FROM $table_income where invoice_id=$invoice_id");



		$invoice_no=$result_invoice_no->invoice_no;



		if(!empty($invoice_no))



		{



			$result = $wpdb->get_row("SELECT id FROM $table_sell where invoice_no=$invoice_no");



			return $result->id;	



		}



		else



		{



			$income_data= $wpdb->get_row("SELECT entry FROM $table_income where invoice_id=$invoice_id");



			$all_entry=json_decode($income_data->entry);



			if(!empty($all_entry))



			{



				foreach($all_entry as $entry)



				{



					$product_name=$entry->entry;



					$amount=$entry->amount;



					$obj_product=new MJ_gmgt_product;



					$product_data = $obj_product->MJ_gmgt_get_product_by_name($product_name);



					$price=$product_data->price;



					$quentity=$amount/$price;	



					$product_id=$product_data->id;



				}



			}



			$result = $wpdb->get_row("SELECT id FROM $table_sell where product_id=$product_id and quentity=$quentity");



			return $result->id;	



		}	



	}



	//get fees id by income id



	public function MJ_gmgt_get_fees_id_by_income_id($invoice_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



		$result_invoice_no = $wpdb->get_row("SELECT invoice_no FROM $table_income where invoice_id=$invoice_id");



		$invoice_no=$result_invoice_no->invoice_no;



		$result = $wpdb->get_row("SELECT mp_id FROM $table_gmgt_membership_payment where invoice_no=$invoice_no");



		return $result->mp_id;		



	}



	//get membership payment id invoice no



	public function MJ_gmgt_get_membership_payment_id_invoice_no($invoice_no)



	{



		global $wpdb;



		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



		$result = $wpdb->get_row("SELECT mp_id FROM $table_gmgt_membership_payment where invoice_no=$invoice_no");



		return $result->mp_id;		



	}



	//get mebership id by mp id



	public function MJ_gmgt_get_member_id_by_mp_id($mpid)



	{



		global $wpdb;



		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



		$result = $wpdb->get_row("SELECT member_id FROM $table_gmgt_membership_payment where mp_id=$mpid");



		return $result->member_id;		



	}



	//get sell product id invoice no



	public function MJ_gmgt_get_sell_product_id_invoice_no($invoice_no)



	{



		global $wpdb;



		$table_sell = $wpdb->prefix. 'gmgt_store';



		$result = $wpdb->get_row("SELECT * FROM $table_sell where invoice_no=$invoice_no");



		return $result;		



	}



	//get all income data by mp id



	public function MJ_gmgt_get_all_income_data_bymp_id($mp_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_row("SELECT * FROM $table_income where invoice_type='income' and invoice_id=$mp_id");



		return $result;		



	}



	//get all income data by invoice number



	public function MJ_gmgt_get_all_income_data_byinvoice_number($invoice_mumber)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_row("SELECT * FROM $table_income where invoice_type='income' and invoice_no=$invoice_mumber");



		return $result;		



	}



	//update income data by mp id



	public function MJ_gmgt_update_incomedata_bymp_id($mp_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_row("SELECT * FROM $table_income where invoice_type='income' and invoice_id=$mp_id");



		return $result;		



	}



	//all income data



	public function MJ_gmgt_get_all_income_data()



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income'");



		return $result;		



	}	



	//all income data by created_by



	public function MJ_gmgt_get_all_income_data_by_created_by($user_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND create_by=$user_id");



		return $result;		



	}	



	public function MJ_gmgt_new_get_all_income_data_by_created_by($user_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND create_by=$user_id order by invoice_id desc limit 5");



		return $result;		



	}	

	public function MJ_gmgt_new_get_member_all_income_data_by_created_by($user_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND create_by=$user_id order by invoice_id desc limit 3");



		return $result;		



	}	



	//get all income data by member



	public function MJ_gmgt_get_all_income_data_by_member()



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		



		$member_id=get_current_user_id();







		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND supplier_name=$member_id");



		return $result;		



	}



	public function MJ_gmgt_new_get_all_income_data_by_member()



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		



		$member_id=get_current_user_id();







		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND supplier_name=$member_id order by invoice_id desc limit 5");



		return $result;		



	}

	public function MJ_gmgt_new_get_member_all_income_data_by_member()



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		



		$member_id=get_current_user_id();







		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND supplier_name=$member_id order by invoice_id desc limit 3");



		return $result;		



	}



	public function MJ_gmgt_get_member_income_data($member_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' and supplier_name=$member_id");



		return $result;		



	}	



	//delete income



	public function MJ_gmgt_delete_income($income_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';



		$table_sell = $wpdb->prefix. 'gmgt_store';



		



		$invoice_no=$this->MJ_gmgt_get_invoice_no_bymp_id($income_id);



		



		$result = $wpdb->query("DELETE FROM $table_income where invoice_id= ".$income_id);



		



		$result_delete_membership_payment = $wpdb->query("DELETE FROM $table_gmgt_membership_payment where invoice_no=".$invoice_no);



		



		$result_delete_sell_product = $wpdb->query("DELETE FROM $table_sell where invoice_no=".$invoice_no);



		return $result;



	}



	//delete expense



	public function MJ_gmgt_delete_expense($expense_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->query("DELETE FROM $table_income where invoice_id= ".$expense_id);



		return $result;



	}



	//get income data by income id



	public function MJ_gmgt_get_income_data($income_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_row("SELECT * FROM $table_income where invoice_id= ".$income_id);



		return $result;



	}



	//-----------Expense-----------------



	public function MJ_gmgt_add_expense($data)



	{



		$entry_value=$this->MJ_gmgt_get_entry_records($data);



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



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



		$incomedata['invoice_no']=$invoice_no;	



		$incomedata['invoice_type']=sanitize_text_field($data['invoice_type']);



		$incomedata['supplier_name']=sanitize_text_field($data['supplier_name']);



		$incomedata['invoice_date']=MJ_gmgt_get_format_for_db(sanitize_text_field($data['invoice_date']));



		$incomedata['payment_status']=sanitize_text_field($data['payment_status']);



		$incomedata['entry']=$entry_value;



		$incomedata['receiver_id']=get_current_user_id();



		if($data['action']=='edit')



		{



			$expense_dataid['invoice_id']=sanitize_text_field($data['expense_id']);



			$result=$wpdb->update( $table_income, $incomedata ,$expense_dataid);



			return $result;



		}



		else



		{



			$incomedata['create_by']=get_current_user_id();



			$result=$wpdb->insert( $table_income,$incomedata);



			return $result;



		}



	}



	//get all expense data



	public function MJ_gmgt_get_all_expense_data()



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='expense'");



		return $result;		



	}



	//get all expense data by create_by



	public function MJ_gmgt_get_all_expense_data_by_created_by($user_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='expense' AND create_by=$user_id");



		return $result;		



	}



	//get one party income data



	public function MJ_gmgt_get_oneparty_income_data($party_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_results("SELECT * FROM $table_income where supplier_name= '".$party_id."' order by invoice_date desc");



		



		return $result;



	}



	//get one party income data by income id



	public function MJ_gmgt_get_oneparty_income_data_incomeid($income_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_id= '".$income_id."' order by invoice_date desc");



		return $result;



	}



//all income data



	public function MJ_gmgt_get_all_income_data_dashboard()



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' order by invoice_id desc limit 3");



		return $result;		



	}



//get all income data by member dashboard



	public function MJ_gmgt_get_all_income_data_by_member_dashboard()



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$member_id=get_current_user_id();



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND supplier_name=$member_id order by invoice_id desc limit 3");



		return $result;		



	}	



	//all income data by created_by dashboard



	public function MJ_gmgt_get_all_income_data_by_created_by_dashboard($user_id)



	{



		global $wpdb;



		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND create_by=$user_id order by invoice_id desc limit 3");



		return $result;		



	}	







	//------ New-design functon ------//



		//all income data - new design



		public function MJ_gmgt_get_new_all_income_data_dashboard()



		{



			global $wpdb;



			$table_income=$wpdb->prefix.'gmgt_income_expense';



			$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' order by invoice_id desc limit 5");



			return $result;		



		}

		public function MJ_gmgt_get_member_new_all_income_data_dashboard()



		{



			global $wpdb;



			$table_income=$wpdb->prefix.'gmgt_income_expense';



			$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' order by invoice_id desc limit 3");



			return $result;		



		}



	public function MJ_get_monthly_income()

	{

		global $wpdb;

		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$start_date = date('Y-m-d',strtotime('first day of this month'));

        $end_date = date('Y-m-d',strtotime('last day of this month'));



		$result=$wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='income' and invoice_date between '$start_date' and '$end_date'");

		return $result;		

	}

	public function MJ_get_monthly_expense()

	{

		global $wpdb;

		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$start_date = date('Y-m-d',strtotime('first day of this month'));

        $end_date = date('Y-m-d',strtotime('last day of this month'));



		$result=$wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='expense' and invoice_date between '$start_date' and '$end_date'");

		return $result;		

	}

	public function MJ_get_yearly_income()

	{

		global $wpdb;

		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$start_date = date("Y-m-d",strtotime("this year January 1st"));

        $end_date = date("Y-m-d",strtotime("this year December 31st"));



		$result=$wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='income' and invoice_date between '$start_date' and '$end_date'");

		return $result;		

	}

	public function MJ_get_yearly_expense()

	{

		global $wpdb;

		$table_income=$wpdb->prefix.'gmgt_income_expense';



		$start_date = date("Y-m-d",strtotime("this year January 1st"));

        $end_date = date("Y-m-d",strtotime("this year December 31st"));



		$result=$wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='expense' and invoice_date between '$start_date' and '$end_date'");

		return $result;		

	}



	public function MJ_gmgt_get_all_income_expense()



	{



		global $wpdb;



		$table_payment = $wpdb->prefix. 'gmgt_income_expense';



		$result = $wpdb->get_results("SELECT * FROM $table_payment");



		return $result;



	}

}



//PAYMENT CLASS END



?>