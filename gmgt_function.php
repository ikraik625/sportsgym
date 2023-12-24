<?php



add_filter( 'login_redirect', 'mj_gmgt_login_redirect',10, 3 );



function mj_gmgt_login_redirect($redirect_to, $request, $user )



{



	if (isset($user->roles) && is_array($user->roles)) 



	{



		$roles = ['staff_member','accountant','member','management','administrator'];



		foreach($roles as $role)



		{



			if (in_array($role, $user->roles))



			{ 







		        if($user->roles == 'management' OR $user->roles == 'administrator')







				{







					$redirect_to = admin_url () . 'admin.php?page=gmgt_system';



					break;



				}



				else



				{



				   $redirect_to =  home_url('?dashboard=user');



				   break;



				}



			}



		} 



	}



	return $redirect_to;







}



//DATE FORAMTE FUNCTION//



function MJ_gmgt_datepicker_dateformat()







{







	$date_format_array = array(







	'Y-m-d'=>'yy-mm-dd',







	'Y/m/d'=>'yy/mm/dd',







	'd-m-Y'=>'dd-mm-yy',



	'm-d-Y'=>'mm-dd-yy',







	'm/d/Y'=>'mm/dd/yy'); 







	return $date_format_array;







}















//GET CURENT USER CLASSIS FUNCTION//







function MJ_gmgt_get_current_user_classis($member_id)







{







	global $wpdb;







	$table_memberclass = $wpdb->prefix. 'gmgt_member_class';







	$class_id = array();







	$ClassData = $wpdb->get_results("SELECT * FROM $table_memberclass WHERE member_id=$member_id");







	if(!empty($ClassData))







	{







		foreach($ClassData as $key=>$class_id)



		{



			$classids[]= $class_id->class_id;



		}







		return $classids;







	}		







}







//GET MEMBER_BY_CLASS_ID//







function MJ_gmgt_get_member_by_class_id($class_id)







{







	global $wpdb;







	$table_memberclass = $wpdb->prefix. 'gmgt_member_class';







	return $MemberClass = $wpdb->get_results("SELECT * FROM $table_memberclass WHERE class_id=$class_id ");



}











//GET MEMBERSHIP CLASS FUNCTION//







function MJ_gmgt_get_membership_class($membership_id)







{







	global $wpdb;







	$table_membership = $wpdb->prefix. 'gmgt_membershiptype';







	$result = $wpdb->get_row("Select * from $table_membership where membership_id=$membership_id ");







	return $result;







}







//GET MEMBERSHIP BY CLASS ID FUNCTION







function MJ_gmgt_get_class_id_by_membership_id($membership_id)







{







	global $wpdb;







	$table_gmgt_membership_class = $wpdb->prefix. 'gmgt_membership_class';







	$ClassMetaData = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_class WHERE membership_id=$membership_id");







	$class_id =array();







	foreach($ClassMetaData as $key=>$value)







	{







		$class_id[]=$value->class_id;







	}







	return $class_id;	







}







//GET MEMBERSHIP STATUS FUNCTION







function MJ_gmgt_get_membership_class_status($membership_id)







{







	global $wpdb;







	$table_gmgt_membershiptype = $wpdb->prefix. 'gmgt_membershiptype';







	 $class_limit = $wpdb->get_row("SELECT classis_limit FROM $table_gmgt_membershiptype WHERE membership_id=$membership_id");







	return $class_limit->classis_limit;







}







function MJ_gmgt_get_user_used_membership_class($membership_id,$member_id)







{







	global $wpdb;







	$result=0;







	$tbl_gmgt_booking_class = $wpdb->prefix . 'gmgt_booking_class';







	$begin_date = date('Y-m-d 00:00:00',strtotime(get_user_meta($member_id,'begin_date',true)));	 







	$end_date = date('Y-m-d 00:00:00',strtotime( get_user_meta($member_id,'end_date',true)));







	$sql =  "SELECT COUNT(*) FROM $tbl_gmgt_booking_class WHERE booking_date >= '$begin_date'   AND booking_date <=  '$end_date' AND member_id=$member_id AND membership_id=$membership_id AND booking_status='present'";	







	







	$result = $wpdb->get_var($sql);







	return $result;	







}







//GET PHPDATE FORAMTE FUNCTION







function MJ_gmgt_get_phpdateformat($dateformat_value)







{







	$date_format_array = MJ_gmgt_datepicker_dateformat();







	$php_format = array_search($dateformat_value, $date_format_array);







	return  $php_format;







}







//GET DATE IN DIAPLAY TIME FUNCTION







function MJ_gmgt_getdate_in_input_box($date)







{	







	return date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')),strtotime($date));	







}







//GET CURENCY SYMBOL FUNCTION







function MJ_gmgt_get_currency_symbol_api( $currency = '' )







{







	switch ( $currency ) 







	{







		case 'AED' :







		$currency_symbol = 'د.إ';







		break;







		case 'AUD' :







		$currency_symbol = '$';







		break;







		case 'CAD' :







		$currency_symbol = '$';







		break;







		case 'CRC' :







		$currency_symbol = '₡';







		break;







		case 'CLP' :







		case 'COP' :







		case 'HKD' :







		$currency_symbol = '$';







		break;







		case 'MXN' :







		$currency_symbol = '$';







		break;







		case 'NZD' :







		$currency_symbol = '$';







		break;







		case 'SGD' :







		case 'USD' :







		$currency_symbol = '$';







		break;







		case 'BDT':







		$currency_symbol = '৳';







		break;







		case 'BGN' :







		$currency_symbol = 'лв';







		break;







		case 'BRL' :







		$currency_symbol = 'R$';







		break;







		case 'CHF' :







		$currency_symbol = 'CHF';







		break;







		case 'CNY' :







		case 'JPY' :







		case 'RMB' :







		$currency_symbol = '¥';







		break;







		case 'CZK' :







		$currency_symbol = '&#75;&#269;';







		break;







		case 'DKK' :







		$currency_symbol = 'kr.';







		break;







		case 'DOP' :







		$currency_symbol = 'RD$';







		break;







		case 'EGP' :







		$currency_symbol = '£';







		break;







		case 'EUR' :







		$currency_symbol = '€';







		break;







		case 'GBP' :







		$currency_symbol = '£';







		break;







		case 'HRK' :







		$currency_symbol = 'Kn';







		break;







		case 'HUF' :







		$currency_symbol = 'Ft';







		break;







		case 'IDR' :







		$currency_symbol = 'Rp';







		break;







		case 'ILS' :







		$currency_symbol = '₪';







		break;







		case 'INR' :







		case 'LKR' :







		$currency_symbol = 'Rs.';







		break;







		case 'ISK' :







		$currency_symbol = 'Kr.';







		break;







		case 'KIP' :







		$currency_symbol = '₭';







		break;







		case 'KRW' :







		$currency_symbol = '₩';







		break;







		case 'MYR' :







		$currency_symbol = 'RM';







		break;







		case 'NGN' :







		$currency_symbol = '₦';







		break;







		case 'NOK' :







		$currency_symbol = 'kr';







		break;







		case 'NPR' :







		$currency_symbol = 'Rs.';







		break;







		case 'PHP' :







		$currency_symbol = '₱';







		break;







		case 'PLN' :







		$currency_symbol = 'zł';







		break;







		case 'PYG' :







		$currency_symbol = 'Gs';







		break;







		case 'RON' :







		$currency_symbol = 'lei';







		break;







		case 'RUB' :







		$currency_symbol = '₽';







		break;







		case 'SEK' :







		$currency_symbol = 'kr';







		break;







		case 'THB' :







		$currency_symbol = '฿';







		break;







		case 'TRY' :







		$currency_symbol = '₺';







		break;







		case 'TWD' :







		$currency_symbol = 'NT$';







		break;







		case 'UAH' :







		$currency_symbol = '₴';







		break;







		case 'VND' :







		$currency_symbol = '₫';







		break;







		case 'ZAR' :







		$currency_symbol = 'R';







		break;







		case 'AFA' :







		$currency_symbol = '؋';







		break;







		case 'ALL' :







		$currency_symbol = 'Lek';







		break;







		case 'DZD' :







		$currency_symbol = 'دج';







		break;







		case 'AOA' :







		$currency_symbol = 'Kz';







		break;







		case 'ARS' :







		$currency_symbol = '$';







		break;







		case 'AMD' :







		$currency_symbol = '֏';







		break;







		case 'AWG' :







		$currency_symbol = 'ƒ';







		break;







		case 'AZN' :







		$currency_symbol = 'm';







		break;







		case 'BSD' :







		$currency_symbol = 'B$';







		break;







		case 'BHD' :







		$currency_symbol = '.د.ب';







		break;







		case 'BBD' :







		$currency_symbol = 'Bds$';







		break;







		case 'BYR' :







		$currency_symbol = 'Br';







		break;







		case 'BEF' :







		$currency_symbol = 'fr';







		break;







		case 'BTN' :







		$currency_symbol = 'Nu.';







		break;







		case 'BTC' :







		$currency_symbol = '฿';







		break;







		case 'BTC' :







		$currency_symbol = 'B$';







		break;







		case 'BGN' :







		$currency_symbol = 'Лв.';







		break;







		case 'BGN' :







		case 'NAD' :







		case 'SRD' :







		$currency_symbol = '$';







		break;







		case 'XAF' :







		$currency_symbol = 'FCFA';







		break;







		case 'EEK' :







		$currency_symbol = 'kr';







		break;







		case 'FKP' :







		case 'GIP' :







		$currency_symbol = '£';







		break;







		case 'DEM' :







		$currency_symbol = 'DM';







		break;







		case 'NPR' :







		case 'PKR' :







		$currency_symbol = '₨';







		break;







		case 'QAR' :







		$currency_symbol = 'ق.ر';







		break;







		case 'RUB' :







		$currency_symbol = '₽';







		break;







		case 'RSD' :







		$currency_symbol = 'din';







		break;







		case 'SHP' :







		$currency_symbol = '£';







		break;







		case 'TMT' :







		$currency_symbol = 'T';







		break;







		case 'TMT' :







		$currency_symbol = '₴';







		break;







		case 'ZMK' :







		$currency_symbol = 'ZK';







		break;















		default :







		$currency_symbol = $currency;







		break;







	}







	return $currency_symbol;







}







//GET CURENCY SYMBOL FUNCTION







function MJ_gmgt_get_currency_symbol( $currency = '' ) 







{







			switch ( $currency ) 







			{







			case 'AED' :







			$currency_symbol = 'د.إ';







			break;







			case 'AUD' :







			$currency_symbol = '&#36;';







			break;







			case 'CAD' :







			$currency_symbol = 'C&#36;';







			break;







			case 'CRC' :







			$currency_symbol = '₡';







			break;







			case 'CLP' :







			case 'COP' :







			case 'HKD' :







			$currency_symbol = '&#36';







			break;







			case 'MXN' :







			$currency_symbol = '&#36';







			break;







			case 'NZD' :







			$currency_symbol = '&#36';







			break;







			case 'SGD' :







			case 'USD' :







			$currency_symbol = '&#36;';







			break;







			case 'BDT':







			$currency_symbol = '&#2547;&nbsp;';







			break;







			case 'BGN' :







			$currency_symbol = '&#1083;&#1074;.';







			break;







			case 'BRL' :







			$currency_symbol = '&#82;&#36;';







			break;







			case 'CHF' :







			$currency_symbol = '&#67;&#72;&#70;';







			break;







			case 'CNY' :







			case 'JPY' :







			case 'RMB' :







			$currency_symbol = '&yen;';







			break;







			case 'CZK' :







			$currency_symbol = '&#75;&#269;';







			break;







			case 'DKK' :







			$currency_symbol = 'kr.';







			break;







			case 'DOP' :







			$currency_symbol = 'RD&#36;';







			break;







			case 'EGP' :







			$currency_symbol = 'EGP';







			break;







			case 'EUR' :







			$currency_symbol = '&euro;';







			break;







			case 'GBP' :







			$currency_symbol = '&pound;';







			break;







			case 'HRK' :







			$currency_symbol = 'Kn';







			break;







			case 'HUF' :







			$currency_symbol = '&#70;&#116;';







			break;







			case 'IDR' :







			$currency_symbol = 'Rp';







			break;







			case 'ILS' :







			$currency_symbol = '&#8362;';







			break;







			case 'INR' :







			case 'LKR' :







			$currency_symbol = 'Rs.';







			break;







			case 'ISK' :







			$currency_symbol = 'Kr.';







			break;







			case 'KIP' :







			$currency_symbol = '&#8365;';







			break;







			case 'KRW' :







			$currency_symbol = '&#8361;';







			break;







			case 'MYR' :







			$currency_symbol = '&#82;&#77;';







			break;







			case 'NGN' :







			$currency_symbol = '&#8358;';







			break;







			case 'NOK' :







			$currency_symbol = '&#107;&#114;';







			break;







			case 'NPR' :







			$currency_symbol = 'Rs.';







			break;







			case 'PHP' :







			$currency_symbol = '&#8369;';







			break;







			case 'PLN' :







			$currency_symbol = '&#122;&#322;';







			break;







			case 'PYG' :







			$currency_symbol = '&#8370;';







			break;







			case 'RON' :







			$currency_symbol = 'lei';







			break;







			case 'RUB' :







			$currency_symbol = '&#1088;&#1091;&#1073;.';







			break;







			case 'SEK' :







			$currency_symbol = '&#107;&#114;';







			break;







			case 'THB' :







			$currency_symbol = '&#3647;';







			break;







			case 'TRY' :







			$currency_symbol = '&#8378;';







			break;







			case 'TWD' :







			$currency_symbol = '&#78;&#84;&#36;';







			break;







			case 'UAH' :







			$currency_symbol = '&#8372;';







			break;







			case 'VND' :







			$currency_symbol = '&#8363;';







			break;







			case 'ZAR' :







			$currency_symbol = '&#82;';







			break;















			case 'AFA' :







			$currency_symbol = '؋';







			break;







			case 'ALL' :







			$currency_symbol = 'Lek';







			break;







			case 'DZD' :







			$currency_symbol = 'دج';







			break;







			case 'AOA' :







			$currency_symbol = 'Kz';







			break;







			case 'ARS' :







			$currency_symbol = '$';







			break;







			case 'AMD' :







			$currency_symbol = '֏';







			break;







			case 'AWG' :







			$currency_symbol = 'ƒ';







			break;







			case 'AZN' :







			$currency_symbol = 'm';







			break;







			case 'BSD' :







			$currency_symbol = 'B$';







			break;







			case 'BHD' :







			$currency_symbol = '.د.ب';







			break;







			case 'BBD' :







			$currency_symbol = 'Bds$';







			break;







			case 'BYR' :







			$currency_symbol = 'Br';







			break;







			case 'BEF' :







			$currency_symbol = 'fr';







			break;







			case 'BTN' :







			$currency_symbol = 'Nu.';







			break;







			case 'BTC' :







			$currency_symbol = '฿';







			break;







			case 'BTC' :







			$currency_symbol = 'B$';







			break;







			case 'BGN' :







			$currency_symbol = 'Лв.';







			break;







			case 'BGN' :







			case 'NAD' :







			case 'SRD' :







			$currency_symbol = '$';







			break;







			case 'XAF' :







			$currency_symbol = 'FCFA';







			break;







			case 'EEK' :







			$currency_symbol = 'kr';







			break;







			case 'FKP' :







			case 'GIP' :







			$currency_symbol = '£';







			break;







			case 'DEM' :







			$currency_symbol = 'DM';







			break;







			case 'NPR' :







			case 'PKR' :







			$currency_symbol = '₨';







			break;







			case 'QAR' :







			$currency_symbol = 'ق.ر';







			break;







			case 'RUB' :







			$currency_symbol = '₽';







			break;







			case 'RSD' :







			$currency_symbol = 'din';







			break;







			case 'SHP' :







			$currency_symbol = '£';







			break;







			case 'TMT' :







			$currency_symbol = 'T';







			break;







			case 'TMT' :







			$currency_symbol = '₴';







			break;







			case 'ZMK' :







			$currency_symbol = 'ZK';







			break;















			default :







			$currency_symbol = $currency;







			break;







	}







	return $currency_symbol;







}







function MJ_gmgt_gym_change_dateformat($date)







{







	return mysql2date(get_option('date_format'),$date);







}







function MJ_gmgt_check_table_isempty($tablename)







{







     global	$wpdb;







	return $rows=$wpdb->get_row("select * from ".$tablename);	 







}







//GET REMOTE FILE FUNCTION







function MJ_gmgt_get_remote_file($url, $timeout = 30)







{







	$ch = curl_init();







	curl_setopt ($ch, CURLOPT_URL, $url);







	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);







	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);







	$file_contents = curl_exec($ch);







	curl_close($ch);







	return ($file_contents) ? $file_contents : FALSE;







}







//CHANGE MENU IN FRONTEND SIDE FUNCTION







function MJ_gmgt_change_menutitle($key)







{







	$menu_titlearray=array('staff_member'=>esc_html__('Staff Members','gym_mgt'),'membership'=>esc_html__('Membership Type','gym_mgt'),'group'=>esc_html__('Group','gym_mgt'),'member'=>esc_html__('Members','gym_mgt'),'activity'=>esc_html__('Activity','gym_mgt'),'class-schedule'=>esc_html__('Class Schedule','gym_mgt'),'virtual_class'=>esc_html__('Virtual Class Schedule','gym_mgt'),'attendence'=>esc_html__('Attendance','gym_mgt'),'assign-workout'=>esc_html__('Assigned Workouts','gym_mgt'),'workouts'=>esc_html__('Workouts','gym_mgt'),'accountant'=>esc_html__('Accountant','gym_mgt'),'membership_payment'=>esc_html__('Membership Payment','gym_mgt'),'subscription'=>esc_html__('Subscription','gym_mgt'),'payment'=>esc_html__('Payment','gym_mgt'),'tax'=>esc_html__('Tax','gym_mgt'),'product'=>esc_html__('Products','gym_mgt'),'store'=>esc_html__('Store','gym_mgt'),'news_letter'=>esc_html__('Newsletter','gym_mgt'),'message'=>esc_html__('Message','gym_mgt'),'notice'=>esc_html__('Notice','gym_mgt'),'nutrition'=>esc_html__('Nutrition Schedule','gym_mgt'),'reservation'=>esc_html__('Reservation','gym_mgt'),'report'=>esc_html__('Report','gym_mgt'),'sms_setting'=>esc_html__('SMS Setting','gym_mgt'),'subscription_history'=>esc_html__('Subscription History','gym_mgt'),'mail_template'=>esc_html__('Mail Template','gym_mgt'),'alumni'=>esc_html__('Alumni','gym_mgt'),'prospect'=>esc_html__('Prospect','gym_mgt'),'account'=>esc_html__('Account','gym_mgt'),'general_setting'=>esc_html__('General Settings','gym_mgt'));







	







	return $menu_titlearray[$key];







}







//STATUS  FUNCTION







function MJ_gmgt_change_read_status($id)







{







	global $wpdb;







	$table_name = $wpdb->prefix . "Gmgt_message";







	$data['status']=1;







	$whereid['message_id']=$id;







	return $retrieve_subject = $wpdb->update($table_name,$data,$whereid);







}







//IMAGE/DOCUMENT UPLOAD  FUNCTION







function MJ_gmgt_user_avatar_image_upload($type) 







{







	 $imagepath ="";







	 $parts = pathinfo($_FILES[$type]['name']);







	 $inventoryimagename = time()."-"."member".".".$parts['extension'];







	 $document_dir = WP_CONTENT_DIR ;







	 $document_dir .= '/uploads/gym_assets/';







	 $document_path = $document_dir;







	if($imagepath != "")







	{	







		if(file_exists(WP_CONTENT_DIR.$imagepath))







		unlink(WP_CONTENT_DIR.$imagepath);







	}







	if (!file_exists($document_path))







	{







		mkdir($document_path, 0777, true);







	}	







       if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) 







	   {







          $imagepath= $inventoryimagename;	







       }







	return $imagepath;







}







//LOAD DOCUMENT FUNCTION







function MJ_gmgt_load_documets($file,$type,$nm) 







{







	 $imagepath =$file;







	 $parts = pathinfo($file['name']);







	 $inventoryimagename = time()."-".$nm."-"."in".".".$parts['extension'];







	 $document_dir = WP_CONTENT_DIR ;







	 $document_dir .= '/uploads/gym_assets/';







	 $document_path = $document_dir;















	if (!file_exists($document_path)) 







	{







		mkdir($document_path, 0777, true);







	}	







	if (move_uploaded_file($file['tmp_name'], $document_path.$inventoryimagename))







	{







		$imagepath= $inventoryimagename;	







	}







    return $imagepath;







}







add_action( 'wp_login_failed', 'MJ_gmgt_login_failed' ); // hook failed login 







function MJ_gmgt_get_lastmember_id($role)







{







	global $wpdb;







    $args = array(







        'role'         => 'member', // authors only







        'orderby'      => 'registered', // registered date







        'order'        => 'DESC', // last registered goes first







        'number'       => 1 // limit to the last one, not required







    );







    $users = get_users( $args );



	if(!empty($users))



	{



		$userid = $users[0]; // the first user from the list



	}



	else



	{



		$userid = '';



	}



  







    if(!empty($userid))







    {







    	return get_user_meta($userid->ID,'member_id',true);







    }







    else







    {







    	return '';







    }







}







add_action( 'authenticate', 'MJ_gmgt_check_username_password', 1, 3);







function MJ_gmgt_check_username_password( $login, $username, $password ) 







{







// Getting URL of the login page







if(isset($_SERVER['HTTP_REFERER']))







{







	$referrer = $_SERVER['HTTP_REFERER'];







}







// if there's a valid referrer, and it's not the default log-in screen







if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {







    if( $username == "" || $password == "" ){







        wp_redirect( get_permalink( get_option('gmgt_login_page') ) . "?login=empty" ); 







     exit;







    }







} 







}







//LOGIN FAILD FUNCTION







function MJ_gmgt_login_failed( $user ) 







{







	// check what page the login attempt is coming from







	$referrer = $_SERVER['HTTP_REFERER'];







	 $curr_args = array(







				'page_id' => get_option('gmgt_login_page'),







				'login' => 'failed'







				);







				print_r($curr_args);







				$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('gmgt_login_page') ) );







	// check that were not on the default login page







	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null )







	{







		// make sure we don't already have a failed login attempt







		if ( !strstr($referrer, 'login=failed' )) 







		{







			// Redirect to the login page and append a querystring of login failed







			wp_redirect( $referrer_faild);







		} else 







		{







			wp_redirect( $referrer );







		}







		exit;







	}







}







//GMGT MENU FUNCTION







function MJ_gmgt_menu()







{







	$user_menu = array();







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/staff-member.png' ),'menu_title'=>esc_html__( 'Staff Members', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'staff_member');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/membership-type.png' ),'menu_title'=>esc_html__( 'Membership Type', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'membership');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/group.png' ),'menu_title'=>esc_html__( 'Group', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'group');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/member.png' ),'menu_title'=>esc_html__( 'Member', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'member');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/activity.png' ),'menu_title'=>esc_html__( 'Activity', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'activity');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/class-schedule.png' ),'menu_title'=>esc_html__( 'Class schedule', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'class-schedule');







	 $user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/attandance.png' ),'menu_title'=>esc_html__( 'Attendence', 'gym_mgt' ),'member'=>0,'staff_member' =>1,'accountant'=>0,'page_link'=>'attendence');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png' ),'menu_title'=>esc_html__( 'Assigned Workouts', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'assign-workout');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/workout.png' ),'menu_title'=>esc_html__( 'Workouts', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'workouts');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/accountant.png' ),'menu_title'=>esc_html__( 'Accountant', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'accountant');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/fee.png' ),'menu_title'=>esc_html__( 'Membership Payment', 'gym_mgt' ),'member'=>1,'staff_member' => 0,'accountant'=>1,'page_link'=>'membership_payment');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/payment.png' ),'menu_title'=>esc_html__( 'Payment', 'gym_mgt' ),'member'=>1,'staff_member' => 0,'accountant'=>1,'page_link'=>'payment');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/products.png' ),'menu_title'=>esc_html__( 'Product', 'gym_mgt' ),'member'=>0,'staff_member' => 1,'accountant'=>1,'page_link'=>'product');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/store.png' ),'menu_title'=>esc_html__( 'Store', 'gym_mgt' ),'member'=>0,'staff_member' => 1,'accountant'=>1,'page_link'=>'store');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/newsletter.png' ),'menu_title'=>esc_html__( 'Newsletter', 'gym_mgt' ),'member'=>0,'staff_member' => 1,'accountant'=>0,'page_link'=>'news_letter');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/message.png' ),'menu_title'=>esc_html__( 'Message', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'message');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/notice.png' ),'menu_title'=>esc_html__( 'Notice', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'notice');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png' ),'menu_title'=>esc_html__( 'Nutrition Schedule', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'nutrition');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/reservation.png' ),'menu_title'=>esc_html__( 'Reservation', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>0,'page_link'=>'reservation');







	$user_menu[] = array('menu_icone'=>plugins_url( 'gym-management/assets/images/icon/account.png' ),'menu_title'=>esc_html__( 'Account', 'gym_mgt' ),'member'=>1,'staff_member' => 1,'accountant'=>1,'page_link'=>'account');







	return $user_menu;







}







/*--------- FRONTEND SIDE MENU LIST--------------------*/







function MJ_gmgt_frontend_menu_list()







{







	$access_array=array('staff_member' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/staff-member.png'),







      'menu_title' =>'Staff Members',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'1',







      'page_link' =>'staff_member'),







	  







	  'membership' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),







     'menu_title' =>'Membership Type',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'membership'),







	  







	    'group' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/group.png'),







     'menu_title' =>'group',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'group'),







	  







	    'member' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/member.png'),







     'menu_title' =>'Member',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'1',







      'page_link' =>'member'),







	  







	 'activity' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/activity.png'),







     'menu_title' =>'Activity',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'activity'),







	  







	    'class-schedule' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/class-schedule.png'),







     'menu_title' =>'Class schedule',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'class-schedule'),







	  







	    'attendence' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/attandance.png'),







     'menu_title' =>'Attendence',







      'member' =>'0',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'attendence'),







	  







	    'assign-workout' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/assigne-workout.png'),







     'menu_title' =>'Assigned Workouts',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'assign-workout'),







	  







	    'workouts' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/workout.png'),







     'menu_title' =>'Workouts',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'workouts'),







	  







	    'accountant' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/accountant.png'),







     'menu_title' =>'Accountant',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'1',







      'page_link' =>'accountant'),







	  







	    'membership_payment' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/fee.png'),







     'menu_title' =>'Membership Payment',







      'member' =>'1',







      'staff_member' =>'0',







      'accountant' =>'1',







      'page_link' =>'membership_payment'),







	  







	    'payment' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/payment.png'),







     'menu_title' =>'Payment',







      'member' =>'1',







      'staff_member' =>'0',







      'accountant' =>'1',







      'page_link' =>'payment'),







	  







	     'product' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/products.png'),







     'menu_title' =>'Product',







      'member' =>'0',







      'staff_member' =>'1',







      'accountant' =>'1',







      'page_link' =>'product'),







	  







	     'store' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/store.png'),







     'menu_title' =>'Store',







      'member' =>'0',







      'staff_member' =>'1',







      'accountant' =>'1',







      'page_link' =>'store'),







	  







	     'news_letter' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/newsletter.png'),







     'menu_title' =>'Newsletter',







      'member' =>'0',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'news_letter'),







	  







	     'message' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/message.png'),







     'menu_title' =>'Message',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'1',







      'page_link' =>'message'),







	  







	  







	     'notice' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/notice.png'),







     'menu_title' =>'Notice',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'1',







      'page_link' =>'notice'),







	  







	     'nutrition' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/nutrition-schedule.png'),







     'menu_title' =>'Nutrition Schedule',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'nutrition'),







	  







	     'reservation' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/reservation.png'),







     'menu_title' =>'Reservation',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'reservation'),







	  







	     'account' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/account.png'),







     'menu_title' =>'Account',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'1',







      'page_link' =>'account'),







	  







	     'membership' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/membership-type.png'),







     'menu_title' =>'Membership Type',







      'member' =>'1',







      'staff_member' =>'1',







      'accountant' =>'0',







      'page_link' =>'membership'),







	  







	'subscription_history' => 







    array (







      'menu_icone' =>plugins_url( 'gym-management/assets/images/icon/subscription_history.png'),







     'menu_title' =>'Membership History',







      'member' =>'1',







      'staff_member' =>'0',







      'accountant' =>'0',







      'page_link' =>'subscription_history'),







	 );







	if ( !get_option('gmgt_access_right') )







	{







		update_option( 'gmgt_access_right', $access_array );







	}







}







add_action('init','MJ_gmgt_frontend_menu_list');







/*--------- GET SINGLE MEMBRSHIP PAYMENT RECORD --------------------*/







function MJ_gmgt_get_single_membership_payment_record($mp_id)







{







	global $wpdb;







		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';







		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_membership_payment where mp_id=".$mp_id);







		return $result;







}







/*--------- GET SINGLE PAYMENT HISTORY--------------------*/







function MJ_gmgt_get_payment_history_by_mpid($mp_id)







{







	global $wpdb;







	$result=array();







	$table_gmgt_membership_payment_history = $wpdb->prefix .'gmgt_membership_payment_history';







	







	$result =$wpdb->get_results("SELECT * FROM $table_gmgt_membership_payment_history WHERE mp_id=$mp_id ORDER BY payment_history_id DESC");







	return $result;







}







/*--------- GET INCOME PAYMENT HISTORY--------------------*/







function MJ_gmgt_get_income_payment_history_by_mpid($mp_id)







{







	global $wpdb;







	$result=array();







	$table_gmgt_income_payment_history = $wpdb->prefix .'gmgt_income_payment_history';







	







	$result =$wpdb->get_results("SELECT * FROM $table_gmgt_income_payment_history WHERE invoice_id=$mp_id ORDER BY payment_history_id DESC");







	return $result;







}







/*--------- GET SALE PAYMENT HISTORY BY MEMBERSHIP ID--------------------*/







function MJ_gmgt_get_sell_payment_history_by_mpid($mp_id)







{







	global $wpdb;







	$result=array();







	$table_gmgt_sales_payment_history = $wpdb->prefix .'gmgt_sales_payment_history';







	







	$result =$wpdb->get_results("SELECT * FROM $table_gmgt_sales_payment_history WHERE sell_id=$mp_id ORDER BY payment_history_id DESC");







	return $result;







}















function MJ_gmgt_pay_membership_amount_frontend_side()







{







	if(isset($_REQUEST['pay_id']) && isset($_REQUEST['amount']) && isset($_REQUEST['payment_request_id']) && isset($_REQUEST['customer_id']))







	{       







		$membership_id = $_REQUEST['pay_id'];







		$amount = $_REQUEST['amount'];







		$member_id = $_REQUEST['customer_id'];







		$trasaction_id ='';







		$payment_method='Instamojo';







		$result=MJ_gmgt_frontend_side_membership_payment_function($membership_id,$member_id,$amount,$trasaction_id,$payment_method);







		if($result)







		{







			wp_redirect(home_url() .'/?action=payment_success_message');	







			exit; 







		} 







	}







	if(isset($_REQUEST['skrill_mp_id']) && isset($_REQUEST['amount']) && isset($_REQUEST['member_id']))







	{







	







		$membership_id = $_REQUEST['skrill_mp_id'];







		$amount =  $_REQUEST['amount'];







		$member_id = $_REQUEST['member_id'];







		$trasaction_id ='';







		$payment_method='Skrill';







		$result=MJ_gmgt_frontend_side_membership_payment_function($membership_id,$member_id,$amount,$trasaction_id,$payment_method);







		/* var_dump($result);







		die; */







		if($result)







		{







			wp_redirect(home_url() .'/?action=payment_success_message');	







			exit; 	







		}







	} 







	//------------- PAYTM FRONTEND MEMBERSHIP PAYMENT ----------//







	if(isset($_REQUEST['paytm_mp_id']) && isset($_REQUEST['amount']) && isset($_REQUEST['member_id']))







	{

		





		$membership_id = $_REQUEST['paytm_mp_id'];







		$amount =  $_REQUEST['amount'];







		$member_id = $_REQUEST['member_id'];







		$trasaction_id =$_REQUEST["TXNID"];







		$payment_method='Paytm';







		$result=MJ_gmgt_frontend_side_membership_payment_function($membership_id,$member_id,$amount,$trasaction_id,$payment_method);







		if($result)







		{







			wp_redirect(home_url() .'/?action=payment_success_message');	







			exit; 







		} 







	} 







	//---------------------- PAYSTACK FRONTEND MEMBERSHIP PAYMENT -------------///







	if(isset($_REQUEST['paystack_mp_id']) && isset($_REQUEST['amount']) && isset($_REQUEST['user_id']))







	{







	 







		$obj_membership_payment=new MJ_gmgt_membership_payment;







		$reference='';







		$reference = isset($_GET['reference']) ? $_GET['reference'] : '';







		if($reference)







		{







			  $paystack_secret_key=get_option('paystack_secret_key');







			  $curl = curl_init();







			  curl_setopt_array($curl, array(







			  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),







			  CURLOPT_RETURNTRANSFER => true,







			  CURLOPT_HTTPHEADER => [







				"accept: application/json",







				"authorization: Bearer $paystack_secret_key",







				"cache-control: no-cache"







			  ],







			));







			$response = curl_exec($curl);







			$err = curl_error($curl);







			if($err)







			{







				// there was an error contacting the Paystack API







			  die('Curl returned error: ' . $err);







			}







			$tranx = json_decode($response);







			if(!$tranx->status)







			{







			  // there was an error from the API







			  die('API returned error: ' . $tranx->message);







			}







		 







			if('success' == $tranx->data->status)







			{







				$membership_id = $_REQUEST['paystack_mp_id'];







				$amount =$tranx->data->amount / 100;







				$member_id = $_REQUEST['user_id'];







				$trasaction_id =$tranx->data->reference;







				$payment_method='Paystack';







				$result=MJ_gmgt_frontend_side_membership_payment_function($membership_id,$member_id,$amount,$trasaction_id,$payment_method);







				if($result)







				{







					wp_redirect(home_url() .'/?action=payment_success_message');







					exit; 	







				}







			}







		}







	}







	if(isset($_REQUEST['pay_method']) && $_REQUEST['pay_method']=="ideal")







	{







		$membership_id = $_REQUEST['pay_id'];







		$amount =  $_REQUEST['amount'];







		$member_id = $_REQUEST['member_id'];







		$trasaction_id ='';







		$payment_method='iDeal';







		$result=MJ_gmgt_frontend_side_membership_payment_function($membership_id,$member_id,$amount,$trasaction_id,$payment_method);







		if($result)







		{







			wp_redirect(home_url() .'/?action=payment_success_message');	







			exit; 







		}







	}







}







/*--------- LOGIN LINK--------------------*/







function MJ_gmgt_login_link_for_plugin_theme()







{















	?>







	<?php 







	//$current_theme = get_current_theme();



	$current_theme = wp_get_theme();



	if($current_theme == 'Twenty Twenty-Three')



	{



		?>



		<style>



		footer



		{



			display: none;



		}



		</style>



		<?php



	}



	if($current_theme == 'Divi')







	{







		?>







		<style>







			.et_right_sidebar #left-area{







				padding-right: 0% !important;







			}







			#main-content{







				min-height: 492px !important;







			}







			







		</style>







		<?php







	}







	elseif($current_theme == 'Twenty Twenty Child')







	{







		?>







		<style>







			#loginform p{







				padding-bottom: 20px;







			}







		</style>







		<?php







	}







	elseif($current_theme == 'Twenty Nineteen')







	{







		?>







		<style>







		.login-password label{







			display: inline-flex !important;







		}







		.login-password label{







			margin-right: 20px;







		}







		.student_login_form .login-password label{







			margin-right: 0 !important;







		}







	







		</style>







		<?php







	}







	elseif($current_theme == 'Twenty Twenty-One')







	{







		?>







		<style>







		.login-password label{







			width: auto;



			display: block;



		}



		.login-username label



		{



			width: auto;



			display: block;



		}



		.login-password input , .login-username input



		{



			width: auto;



		}



		#loginform .login-remember input{







			margin: 0px;







			width: 20px;







			height: 20px;







			margin-bottom: -2px;







		}







		input[type=checkbox]:after{







			left: 4px !important;







    		top: 0px !important;







		}







		</style>







		<?php







	}



	



	elseif($current_theme == 'Twenty Twenty-Two' || $current_theme == 'Twenty Twenty-Three')







	{







		?>







		<style>







		#login-error







		{







			left: 3%;







			position: absolute;







			top: 38%;







			margin: 0 10%;







			width: 75%;







			margin-top: 15px;







			text-align: center;







		}







		.login-password label{







			display: inline-flex !important;







			width: 8%;







			margin-top: 10px !important;







		}







		.wp-block-template-part .wp-block-group .alignfull .alignwide p{







			display: none;







		}







		.registration_form_custom_div







		{







			position: absolute;







			top: 40%;







			margin: 0 10%;







   			width: 75%;







			margin-top: 15px;







		}







		.login-password input{







			height: 30px;







		}







		.login-username input{







			height: 30px;







		}







		



		



		.login-username label



		{



			width: auto;



			display: inline-block;



			text-align: left;



		}



		.login-username input , .login-password input



		{



			width: 28%;



		}



		/* .login-submit



		{



			padding-left: 10%;



		} */



		.wp-site-blocks .wp-block-group .wp-block-post-title{







			margin-bottom: 0 !important;







		}







		.wp-block-group .alignwide{







			padding-bottom: 0 !important;







			padding-top: 0 !important;







		}







		.wp-embed-responsive .login-username{







			width: 100%;







		}







		.user-choice-area{







			position: absolute;







			top: 37%;







			margin: 0 40%;







		}







		.wp-embed-responsive #loginform{







			text-align: center;







		}







		.wp-embed-responsive .avada_wifth_100{







			text-align: center;







		}







		.wp-embed-responsive .user-choice-block{







			float: left;







  			width: 17% !important;







		}







		.wp-embed-responsive .user-choice-area{







			margin-left: 36%;







    		/* margin-top: 3%; */







		}







		#registration_form .form-group{







			display: inline-flex;







		}







		#registration_form .form-group .col-sm-8{







			width: 40% !important;







			padding-top: 5px;







		}







		#registration_form .form-group .col-sm-7{







			width: 32% !important;







			padding-top: 5px;







		}







		#registration_form .form-group .col-sm-1{







			width: 6% !important;







			padding-top: 5px;







		}







		#registration_form .form-group .col-sm-7 input{







			height: 35px;







		}







		#registration_form .form-group .col-sm-1 input{







			height: 35px;







		}







		#registration_form .form-group .col-sm-8 input{







			height: 35px;







		}







		#registration_form .form-group .col-sm-8 .radio-inline input{







			height: 15px;







		}







		.header h3{







			text-align: center;







		}



		#loginform .login-submit input



		{



			width: auto !important;



		}



		@media only screen and (max-width : 768px) {







			.login-username label,.login-username input,.login-password label,.login-password input {







				padding-left: 0px;







				width:220px !important;







				margin-top:10px;







			}







			#loginform .login-submit input







			{







				width:220px;







			}







		}







		.login_div_Twenty







		{







			position: absolute;







			top: 60%;







			margin: 0px 13%;







			/* width: 74%; */







			margin-top: 15px;







        }







		</style>







		<?php







	}







	elseif($current_theme == 'Avada')







	{







		?>







		<style>







			.student_login_form .registration_form_custom_div







			{







				width: 100% !important;







			}







			.registration_form_custom_div







			{







				width: 50%;







				margin: auto;







			}







		</style>







		<?php







	}



	else



	{



		?>



		<style>



		.login-username



		{



			padding-top: 40px !important;



			float: none !important;



		}



		.student_login_form .registration_form_custom_div



		{



			width: 100% !important;



		}



		.registration_form_custom_div



		{



			width: 50%;



			margin: auto;



		}



		</style>



		<?php



	}



	?>







	<style>







		.et_divi_theme .login-username label







		{







			margin-top: 15px !important;







    		display: inline-flex !important;















		}







		#loginform .login-submit input{







			border-radius: 28px ;







			padding: 8px 60px !important;







			background-color: #ba170b;







			border: 0px !important;







			color: #ffffff !important;







			font-size: 20px !important;







			text-transform: uppercase !important;







			text-decoration: none !important;







			width: auto;



		}







		.et_divi_theme .login-password label 







		{







			margin-top: 15px!important;







			display: inline-flex!important;







			width: 180px!important;







		}







		.et_divi_theme .login-submit, .et_divi_theme .login-remember {







			margin-top: 1%;







		}







		.et_divi_theme p.login-username







		{







			display: inline-block !important;







		}







		.et_divi_theme .login-username







		{







			float: unset !important;







		}







		.avada-responsive p.login-username







		{







			float: left;







    		width: 100%;







		}







		.avada-responsive p.login-password







		{







			float: left;







    		width: 100%;







		}







		.avada-responsive p.login-remember







		{







			float: left;







    		width: 100%;







		}







		.avada-responsive p.login-submit







		{







			float: left;







    		width: 100%;







		}







		.avada-responsive .avada_wifth_100







		{







			float: left;







    		width: 100%;







		}







		.login-username



		{



			width: 100%;



		}



		.login-password label



		{



			width: auto;



		}







		.login-username



		{



			padding-bottom: 15px;



		}



		.login-username







		{







			padding-top: 20px;







			float: left;







		}







		.avada_wifth_100







		{







			text-decoration: none;







   			display: block;







		}







		.login-submit,.login-remember







		{







			margin-top: 3%;







		}







		.footer-top-visible .login-username







		{







			float: left;







			width:100%;







			margin-top: 4%;







		}







		.footer-top-visible label







		{







			font-size:inherit !important;







		}







	</style>







	<?php















	$args = array( 'redirect' => site_url() );







	







	if(isset($_GET['login']) && $_GET['login'] == 'failed')







	{?>







	<div id="login-error" class="login-error login-error-message" style="background-color:#f8d7da;border-radius: 10px;">







	  	<p style="Padding:10px;"><?php esc_html_e('Login failed: You have entered an incorrect Username or password, please try again.','gym_mgt');?></p>







	</div>







    <?php	







	}







	if(isset($_GET['login']) && $_GET['login'] == 'empty')







	{?>















	<div id="login-error" class="login-error login-error-message" style="background-color:#f8d7da;border-radius: 10px;">







	  	<p style="Padding:10px;"><?php esc_html_e('Login Failed: Username and/or Password is empty, please try again.','gym_mgt');?></p>







	</div>







    <?php	







	}







	if(isset($_GET['gmgt_activate']) && $_GET['gmgt_activate'] == 'gmgt_activate')







	{







	?>



	



	<div id="login-error" class="login-error login-error-message" style="background-color:#f8d7da;border-radius: 10px;">







	  	<p style="Padding:10px;"><?php esc_html_e('Login failed: Your account is inactive. Contact your administrator to activate it.','gym_mgt');?></p>







	</div>







    <?php	







	}







	if(isset($_GET['action']) && $_GET['action'] == 'success')







	{ ?>



		<div class="alert alert-success" role="alert">



			<p style="font-size: 17px;"><?php esc_html_e("Registration Successfully. You can access system using your Email ID and password.",'gym_mgt');?>



		</div>







	<?php







	}



	if(isset($_GET['action']) && $_GET['action'] == 'success1')



	{



		if(get_option('gmgt_member_approve')=='yes')







	    {



		?>



		<div class="alert alert-success" role="alert">



			<p style="font-size: 17px; float:left; "><?php esc_html_e("Your registration is completed. Your account will activate after admin approval.",'gym_mgt');?>



		</div>



		<?php



	   }







	   else







	   {





				$qr_code_urlnew ='WP_GYM,' . !empty( $_GET['id'] )? $_GET['id']: "";

				// $url = 'https://api.qrserver.com/v1/create-qr-code/?data=' . $qr_code_urlnew . '&amp;size=50x50';
				$user_id = !empty( $_GET['id'] )? $_GET['id']: "";
				$url = site_url() . "/customer-details/?accountant_id=" . $user_id;

				$url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=".urlencode( $url)."&choe=UTF-8";


		?>


			<div class="alert alert-success" role="alert">
	
				<p style="font-size: 17px; float:left;"><?php esc_html_e("Your registration is completed.You can access system using your Email ID and password.",'gym_mgt');?>
				</p>
				<img src="<?php echo $url; ?>" height="200" width="200" style="margin: auto; display:block;" alt="barcode"/>

			</div>



		<?php



	   }



	}







	elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'paystck_success' && isset($_REQUEST['paystack_mp_id']))







	{







		?>







		<div id="login-error" class="login-error">







		  <p><?php esc_html_e('Membership successfully buy.','gym_mgt');?></p>







		</div>	







		<?php







	}







	elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'paytm_success' && isset($_REQUEST['paytm_mp_id']))







	{







		?>







		<div id="login-error" class="login-error">







		  <p><?php esc_html_e('Membership successfully buy.','gym_mgt');?></p>







		</div>	







		<?php







	}







	elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'payumoney_success')







	{







		?>







		<div id="login-error" class="login-error">







		  <p><?php esc_html_e('Membership successfully buy.','gym_mgt');?></p>







		</div>	







		<?php







	}







	elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'skrill_success')







	{







		?>







		<div id="login-error" class="login-error">







		  <p><?php esc_html_e('Membership successfully buy.','gym_mgt');?></p>







		</div>	







		<?php







	}







	elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'instamojo_success')







	{







		?>







		<div id="login-error" class="login-error">







		  <p><?php esc_html_e('Membership successfully buy.','gym_mgt');?></p>







		</div>	







		<?php







	}







	elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'stripe_success')







	{







		?>







		<div id="login-error" class="login-error">







		  <p><?php esc_html_e('Membership successfully buy.','gym_mgt');?></p>







		</div>	







		<?php







	}







	elseif(isset($_GET['action']) && $_GET['action'] == 'success_membership')







	{ 







		if(isset($_REQUEST['membership_id']))







		{







			//Free Membership process







			$membership_id = $_REQUEST['membership_id'];







			$amount = 0;







			$member_id = get_current_user_id();







			$trasaction_id ='';







			$payment_method='-';







			$result=MJ_gmgt_frontend_side_membership_payment_function($membership_id,$member_id,$amount,$trasaction_id,$payment_method);







		}







		?>







	<div id="login-error" class="login-error">







	<p><?php esc_html_e('Membership successfully buy.','gym_mgt');?></p>







	</div>







	<?php







	}







	







	elseif(isset($_GET['action']) && $_GET['action'] == 'cencal')







	{ ?>







		<div id="login-error" class="login-error">







			<p><?php esc_html_e('Payment Cancel.','gym_mgt');?></p>







		</div>







	<?php







	}







	







	 $args = array(







			'echo' => true,







			'redirect' => site_url( $_SERVER['REQUEST_URI'] ),







			'form_id' => 'loginform',







			'label_username' => esc_html__( 'Email ID' , 'gym_mgt'),







			'label_password' => esc_html__( 'Password', 'gym_mgt' ),







			'label_remember' => esc_html__( 'Remember Me' , 'gym_mgt'),







			'label_log_in' => esc_html__( 'Log In' , 'gym_mgt'),







			'id_username' => 'user_login',







			'id_password' => 'user_pass',







			'id_remember' => 'rememberme',







			'id_submit' => 'wp-submit',







			'remember' => true,







			'value_username' => NULL,







	        'value_remember' => false ); 







			if(isset($_REQUEST['membership_id']))







			{







				$obj_membership=new MJ_gmgt_membership;







				$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($_REQUEST['membership_id']);







				if($retrieved_data->membership_amount > 0)







				{







					$page_id = get_option ( 'gmgt_membership_pay_page' );







						$referrer_ipn = array(				







							'page_id' => $page_id,







							'membership_id'=>$_REQUEST['membership_id']







						);







					$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );







					$args = array('redirect' =>$referrer_ipn);







				}







				else







				{







					$page_id = get_option ( 'gmgt_login_page' );			







					$referrer_ipn = array(				







						'page_id' => $page_id,







						'action'=>'success_membership',







						'membership_id'=>$_REQUEST['membership_id']







					);			







					$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );	







					$args = array('redirect' =>$referrer_ipn);







				}			







			}







		    elseif(isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book')







			{







				$page_id = get_option ('gmgt_class_booking_page');	







				$referrer_ipn = array(				







					'page_id' => $page_id,







					'action'=>$_REQUEST['action'],







					'class_id1'=>$_REQUEST['class_id1'],







					'startTime_1'=>$_REQUEST['startTime_1'],







					'class_date'=>$_REQUEST['class_date'],







					'day_id1'=>$_REQUEST['day_id1'],







					'bookedclass_membershipid'=>$_REQUEST['bookedclass_membershipid'],







					'Remaining_Member_limit_1'=>$_REQUEST['Remaining_Member_limit_1']







			







				);				







				$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );		







				$args = array('redirect' =>$referrer_ipn);







			}







			else







			{







				$args = array('redirect' => site_url('/?dashboard=user') );		







			}







			if(isset($_REQUEST['na']) && $_REQUEST['na']=='1')







			{ ?>







				<div id="login-error" class="login-error">







					<p><?php esc_html_e('You can login after admin approve your registration.','gym_mgt');?></p>







				</div>







			<?php 







			}







	if ( is_user_logged_in() )







	{







	 	?>







	   <div class="login_div_<?php echo $current_theme;?>">







			<a style="margin-left: 7%;" href="<?php echo home_url('/')."?dashboard=user"; ?>">







				<?php esc_html_e('Dashboard','gym_mgt');?>







			</a>







			<br />







			<a style="margin-left: 7%;" href="<?php echo wp_logout_url(); ?>"><?php esc_html_e('Logout','gym_mgt');?></a> 







	    </div>







		<?php 







	}







	else 







	{ 







		if($current_theme == 'Twenty Twenty-One Child')







		{







			if(!empty(get_custom_logo()))







			{







				echo get_custom_logo();







			}







			else







			{







				?>







				<span class="custom-logo-link">







					<img width="400" height="99" src="<?php  echo get_option( 'gmgt_system_logo' ); ?>" class="custom-logo" alt="">







				</span>















				<?php







			}







			?>







			<?php







		}







		?>







		<div class="registration_form_custom_div">







			<?php 







			if($current_theme == 'Twenty Twenty-One Child')







			{







				?>







				<h4 class="gmgt_Child_theme_heder"><?php echo esc_html_e( "GYM Management Login", 'gym_mgt' ); ?></h4>







				<?php







			}







			wp_login_form( $args );







			echo '<a href="'.wp_lostpassword_url().'" class="avada_wifth_100 gmgt_chile_theme_forgot_pass" title="Lost Password">'.esc_html__('Forgot your password?','gym_mgt').'</a> ';		







			?>







		</div>







		<?php







		if($current_theme == 'Twenty Twenty-One Child')







		{







			?>







			<footer class="gmgt_footer">







				<nav aria-label="Secondary menu" class="footer-navigation">







					<ul class="footer-navigation-wrapper">







						<!-- <li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url()); ?>"><span><?php echo esc_html_e( "Login", 'gym_mgt' ); ?></span></a></li> -->







						<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('class-booking')); ?>"><span><?php echo esc_html_e( "Class Booking", 'gym_mgt' ); ?></span></a></li>







						<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('member-registration-or-login')); ?>"><span><?php echo esc_html_e( "Member Registration", 'gym_mgt' ); ?></span></a></li>







						<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('membership-list-page')); ?>"><span><?php echo esc_html_e( "Membership List", 'gym_mgt' ); ?></span></a></li>







					</ul>







				</nav>







			</footer>







			<?php 







		}







	}	 







}







add_action( 'wp_ajax_MJ_gmgt_add_or_remove_category', 'MJ_gmgt_add_or_remove_category');







add_action( 'wp_ajax_MJ_gmgt_add_category', 'MJ_gmgt_add_category');



add_action( 'wp_ajax_MJ_gmgt_add_extend_data', 'MJ_gmgt_add_extend_data');



add_action( 'wp_ajax_MJ_gmgt_remove_category', 'MJ_gmgt_remove_category');







add_action( 'wp_ajax_MJ_gmgt_load_user', 'MJ_gmgt_load_user');







add_action( 'wp_ajax_MJ_gmgt_invoice_view', 'MJ_gmgt_invoice_view');







add_action( 'wp_ajax_MJ_gmgt_load_activity', 'MJ_gmgt_load_activity');







add_action( 'wp_ajax_MJ_gmgt_nutrition_schedule_view', 'MJ_gmgt_nutrition_schedule_view');







add_action( 'wp_ajax_MJ_gmgt_load_workout_measurement', 'MJ_gmgt_load_workout_measurement');







add_action( 'wp_ajax_MJ_gmgt_view_details_popup', 'MJ_gmgt_view_details_popup');



add_action( 'wp_ajax_MJ_gmgt_extend_membership_popup', 'MJ_gmgt_extend_membership_popup');



add_action( 'wp_ajax_MJ_gmgt_extend_membership_popup_data', 'MJ_gmgt_extend_membership_popup_data');



add_action( 'wp_ajax_MJ_Renew_popup_data', 'MJ_Renew_popup_data');







add_action( 'wp_ajax_MJ_gmgt_add_workout', 'MJ_gmgt_add_workout');







add_action( 'wp_ajax_MJ_gmgt_delete_workout', 'MJ_gmgt_delete_workout');







add_action( 'wp_ajax_MJ_gmgt_today_workouts', 'MJ_gmgt_today_workouts');







add_action( 'wp_ajax_MJ_gmgt_measurement_view', 'MJ_gmgt_measurement_view');







add_action( 'wp_ajax_MJ_gmgt_measurement_delete', 'MJ_gmgt_measurement_delete');







add_action( 'wp_ajax_MJ_gmgt_load_enddate', 'MJ_gmgt_load_enddate');







add_action( 'wp_ajax_nopriv_MJ_gmgt_load_enddate', 'MJ_gmgt_load_enddate');







add_action( 'wp_ajax_MJ_gmgt_load_enddate_frontend', 'MJ_gmgt_load_enddate_frontend');







add_action( 'wp_ajax_nopriv_MJ_gmgt_load_enddate_frontend', 'MJ_gmgt_load_enddate_frontend');







add_action( 'wp_ajax_MJ_gmgt_add_nutrition', 'MJ_gmgt_add_nutrition');







add_action( 'wp_ajax_MJ_gmgt_delete_nutrition', 'MJ_gmgt_delete_nutrition');







add_action( 'wp_ajax_MJ_gmgt_paymentdetail_bymembership', 'MJ_gmgt_paymentdetail_bymembership');







add_action( 'wp_ajax_MJ_gmgt_member_add_payment',  'MJ_gmgt_member_add_payment');







add_action( 'wp_ajax_MJ_gmgt_member_view_paymenthistory',  'MJ_gmgt_member_view_paymenthistory');







add_action( 'wp_ajax_MJ_gmgt_verify_pkey', 'MJ_gmgt_verify_pkey');







add_action( 'wp_ajax_MJ_gmgt_timeperiod_for_class_number', 'MJ_gmgt_timeperiod_for_class_number');







add_action( 'wp_ajax_MJ_gmgt_get_class_id_by_membership', 'MJ_gmgt_get_class_id_by_membership');







add_action( 'wp_ajax_nopriv_MJ_gmgt_get_class_id_by_membership', 'MJ_gmgt_get_class_id_by_membership');







add_action( 'wp_ajax_MJ_gmgt_check_membership_limit_status', 'MJ_gmgt_check_membership_limit_status');







add_action( 'wp_ajax_nopriv_MJ_gmgt_check_membership_limit_status', 'MJ_gmgt_check_membership_limit_status');







add_action( 'wp_ajax_MJ_gmgt_timeperiod_for_class_member', 'MJ_gmgt_timeperiod_for_class_member');







add_action( 'wp_ajax_MJ_gmgt_add_staff_member', 'MJ_gmgt_add_staff_member');







add_action( 'wp_ajax_MJ_gmgt_add_group', 'MJ_gmgt_add_group');







add_action( 'wp_ajax_MJ_gmgt_add_ajax_membership', 'MJ_gmgt_add_ajax_membership');







add_action( 'wp_ajax_MJ_gmgt_add_ajax_class', 'MJ_gmgt_add_ajax_class');







add_action( 'wp_ajax_MJ_gmgt_add_ajax_product', 'MJ_gmgt_add_ajax_product');







add_action( 'wp_ajax_MJ_gmgt_count_store_total', 'MJ_gmgt_count_store_total');







add_action( 'wp_ajax_MJ_gmgt_check_product_stock', 'MJ_gmgt_check_product_stock');







add_action( 'wp_ajax_MJ_gmgt_get_activity_from_category_type', 'MJ_gmgt_get_activity_from_category_type');







add_action( 'wp_ajax_nopriv_MJ_gmgt_get_activity_from_category_type', 'MJ_gmgt_get_activity_from_category_type');







add_action( 'wp_ajax_MJ_gmgt_get_staff_member_list_by_specilization_category_type', 'MJ_gmgt_get_staff_member_list_by_specilization_category_type');







add_action( 'wp_ajax_nopriv_MJ_gmgt_get_staff_member_list_by_specilization_category_type', 'MJ_gmgt_get_staff_member_list_by_specilization_category_type');







add_action( 'wp_ajax_MJ_gmgt_get_member_current_membership_activity_list', 'MJ_gmgt_get_member_current_membership_activity_list');







add_action( 'wp_ajax_MJ_gmgt_show_event_task', 'MJ_gmgt_show_event_task');







add_action( 'wp_ajax_nopriv_MJ_gmgt_show_event_task', 'MJ_gmgt_show_event_task');







add_action( 'wp_ajax_MJ_gmgt_add_class_limit', 'MJ_gmgt_add_class_limit');







add_action( 'wp_ajax_nopriv_MJ_gmgt_add_class_limit', 'MJ_gmgt_add_class_limit');







add_action( 'wp_ajax_MJ_gmgt_change_profile_photo','MJ_gmgt_change_profile_photo');







add_action( 'wp_ajax_MJ_gmgt_sms_service_setting','MJ_gmgt_sms_service_setting');







add_action( 'wp_ajax_MJ_gmgt_delete_class_limit_for_member', 'MJ_gmgt_delete_class_limit_for_member');







add_action( 'wp_ajax_nopriv_MJ_gmgt_delete_class_limit_for_member', 'MJ_gmgt_delete_class_limit_for_member');







add_action( 'wp_ajax_MJ_gmgt_import_data', 'MJ_gmgt_import_data');







add_action( 'wp_ajax_nopriv_MJ_gmgt_import_data', 'MJ_gmgt_import_data');







//check product stock FUNCTION







function MJ_gmgt_check_product_stock()







{







	$product_id=$_REQUEST['product_id'];







	$quantity=$_REQUEST['quantity'];







	$new_quantity=$_REQUEST['new_quantity'];







	$row_no=$_REQUEST['row_no'];







	global $wpdb;







	$table_product = $wpdb->prefix. 'gmgt_product';







	$result = $wpdb->get_row("SELECT * FROM $table_product where id=".$product_id);







	$before_quantity=$result->quentity;







	if($quantity > $before_quantity && $new_quantity > $before_quantity)







	{







	







		echo $row_no;







	}







	elseif($quantity > $before_quantity)







	{







		







		echo $row_no;







	}







	elseif($new_quantity > $before_quantity)







	{







		







		echo $row_no;







	}







	else







	{







	







		echo '';







	}







	







	die();







}







//----------ADD MEMBERSHIP AJAX CODE FUNCTION-----------







function MJ_gmgt_add_ajax_product()







{







	$obj_product=new MJ_gmgt_product;







	$result=$obj_product->MJ_gmgt_add_product($_POST);







	$option ="";







	$product_info=$obj_product->MJ_gmgt_get_single_product($result);







	if(!empty($product_info)){







		$option = "<option value='".$product_info->id."'>".$product_info->product_name."</option>";







	}







	echo $option;







	die();







}







//----------ADD MEMBERSHIP AJAX CODE FUNCTION-----------







function MJ_gmgt_add_ajax_class()







{	







	$time_validation=0;







	if(!empty($_POST['start_time']))







	{







		foreach($_POST['start_time'] as $key=>$start_time)







		{







			if($_POST['start_ampm'][$key] == $_POST['end_ampm'][$key] )







			{				







				if($_POST['end_time'][$key] < $start_time)







				{







					$time_validation=$time_validation+1;







				







				}







				elseif($_POST['end_time'][$key] == $start_time && $_POST['start_min'][$key] > $_POST['end_min'][$key] )







				{







					$time_validation=$time_validation+1;







				}				







			}







			else







			{







				if($_POST['start_ampm'][$key]!='am')







				{







					$time_validation= $time_validation+1;







				}	







			}	







		}







	}







	







	if($time_validation > 0)







	{







		echo '1';







	}







	else







	{ 







		$obj_class=new MJ_gmgt_classschedule;







		$result=$obj_class->MJ_gmgt_add_class_ajax($_POST);







		$option ="";







		$class_info=$obj_class->MJ_gmgt_get_single_class($result);















		if(!empty($class_info))







		{







			$option = "<option value='".$class_info->class_id."'>".$class_info->class_name."</option>";







		}







		echo $option;







	}







	die();







}







//----------ADD MEMBERSHIP AJAX CODE-----------







function MJ_gmgt_add_ajax_membership()







{







	$txturl=$_POST['gmgt_membershipimage'];







	$ext=MJ_gmgt_check_valid_extension($txturl);







	if(!$ext == 0)







	{







		$obj_membership=new MJ_gmgt_membership;







		$result=$obj_membership->MJ_gmgt_add_membership($_POST,$_POST['gmgt_membershipimage']);







		$option ="";







		$membership_info=$obj_membership->MJ_gmgt_get_single_membership($result);







		







		if(!empty($membership_info))







		{







			$option = "<option value='".$membership_info->membership_id."'>".$membership_info->membership_label."</option>";







		}







		echo $option;







	}







	else







	{







		echo 0;







	}	







	die();







}







//----------ADD GROUP AJAX CODE-----------







function MJ_gmgt_add_group()







{







	$obj_group=new MJ_gmgt_group;







	$result=$obj_group->MJ_gmgt_add_group($_POST,$_POST['gmgt_groupimage']);







	$option ="";







	$group_info=$obj_group->MJ_gmgt_get_single_group($result);















	if(!empty($group_info)){







		$option = "<option value='".$group_info->id."'>".$group_info->group_name."</option>";







	}







	echo $option;







	die();







}







//----------ADD STAFF MEMBER AJAX CODE-----------







function MJ_gmgt_add_staff_member()







{	







	$txturl=$_POST['gmgt_user_avatar'];







	$ext=MJ_gmgt_check_valid_extension($txturl);







	if(!$ext == 0)







	{







		$obj_member=new MJ_gmgt_member;







		$result=$obj_member->MJ_gmgt_gmgt_add_user($_POST);







		$user_info = get_userdata($result);







		$option ="";







		if(!empty($user_info)){







			$option = "<option value='".$user_info->ID."'>".$user_info->first_name." ".$user_info->last_name."</option>";







		}







		echo $option;







	}







	else







	{







		echo 0;







	}	







	die();







}







//---------- GET TODAY WORKOUT FOR MEMBER----------//







function MJ_gmgt_today_workouts()

{ 







    $user_id=$_POST['uid'];







	global $wpdb;







	$table_name = $wpdb->prefix."gmgt_assign_workout";







	$table_gmgt_workout_data = $wpdb->prefix."gmgt_workout_data";







	//$date = date('Y-m-d');







	$record_date = MJ_gmgt_get_format_for_db($_POST['record_date']);







	$day_name = date('l', strtotime($record_date));







	$sql = "Select *From $table_name as workout,$table_gmgt_workout_data as workoutdata where  workout.user_id = $user_id 







	AND  workout.workout_id = workoutdata.workout_id 







	AND workoutdata.day_name = '$day_name'







	AND '".$record_date."' between workout.Start_date and workout.End_date ";







	$result = $wpdb->get_results($sql);		







	if(!empty($result))



	{







		// echo $option="<div class='work_out_datalist_header'><div class='col-md-12 col-sm-12 col-xs-12'>







		// 		<span class='col-md-3 col-sm-3 col-xs-3 no-padding'>".esc_html__('Activity','gym_mgt')."</span>







		// 		<span class='col-md-2 col-sm-2 col-xs-2'>".esc_html__('Sets','gym_mgt')."</span>







		// 		<span class='col-md-2 col-sm-2 col-xs-2'>".esc_html__('Reps','gym_mgt')."</span>







		// 		<span class='col-md-2 col-sm-2 col-xs-2'>".esc_html__('KG','gym_mgt')."</span>







		// 		<span class='col-md-3 col-sm-3 col-xs-3'>".esc_html__('Rest Time','gym_mgt')."</span>







		// 		</div></div>";







		foreach ($result as $retrieved_data)







		{







			$workout_id=$retrieved_data->workout_id;







echo $option="<div class='work_out_datalist form-group'><div class='col-sm-12 col-md-12 col-xs-12 form-control title_background_color div_padding_bottom_0px'>







				<div class='header workout_detail_title_span'>	







					<h3 class='first_hed_activity first_hed'>".esc_html($retrieved_data->workout_name)."</h3>







				</div>







				<div class='row activity_background_white'>







					<div class='col-md-3 d-flex align-items-center padding_10px'>







						<span class='col-md-12 col-sm-12 col-xs-12 no-padding'>".esc_html("Assign Workout")."</span>







					</div>







					<input type='hidden' name='asigned_by' value='".$retrieved_data->create_by."'>







					<input type='hidden' name='workouts_array[]' value='".$retrieved_data->id."'>







					<input type='hidden' name='workout_name_".$retrieved_data->id."' value='".$retrieved_data->workout_name."'>







					<div class='col-md-9'>







						<div class='form-body user_form'>







							<div class='row'>







								<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>







									<div class='form-group input'>







										<div class='col-md-12 form-control'>







											<input class='form-control validate[required]' type='text' placeholder='".$retrieved_data->sets." ".esc_html__('Sets','gym_mgt')."' readonly disabled>







											<label class='active'>".esc_html__('Sets','gym_mgt')."</label>







										</div>







									</div>







								</div>







								<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>







									<div class='form-group input'>







										<div class='col-md-12 form-control'>







											<input class='form-control validate[required]' type='text' placeholder='".$retrieved_data->reps." ".esc_html__('Reps','gym_mgt')."' readonly disabled>







											<label class='active'>".esc_html__('Reps','gym_mgt')."</label>







										</div>







									</div>







								</div>







								<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>







									<div class='form-group input'>







										<div class='col-md-12 form-control'>







											<input class='form-control validate[required]' type='text' placeholder='".$retrieved_data->kg." ".esc_html__('Kg','gym_mgt')."' readonly disabled>







											<label class='active'>".esc_html__('Kg','gym_mgt')."</label>







										</div>







									</div>







								</div>







								<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>







									<div class='form-group input'>







										<div class='col-md-12 form-control'>







											<input class='form-control validate[required]' type='text' placeholder='".$retrieved_data->time." ".esc_html__('Min','gym_mgt')."' readonly disabled>







											<label class='active'>".esc_html__('Rest Time','gym_mgt')."</label>







										</div>







									</div>







								</div>







							</div>







						</div>







					</div>







				</div>";







			echo $option="<div class='row activity_background_white'>







					<div class='col-md-3 d-flex align-items-center padding_10px'>







					<span class='col-md-12 col-sm-12 col-xs-12 no-padding'>".esc_html("Your Workout")."</span>







				</div>







				<div class='col-md-9'>







					<div class='form-body user_form'>







						<div class='row'>







							<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>







								<div class='form-group input'>







									<div class='col-md-12 form-control'>







										<input class='form-control my-workouts validate[required,max[".$retrieved_data->sets."]]' value=".$retrieved_data->sets." id='sets' name='sets_".$retrieved_data->id."' type='number' min='0' onKeyPress='if(this.value.length==3) return false;' >







										<label class='active'>".esc_html__('Sets','gym_mgt')."</label>







									</div>







								</div>







							</div>







							<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>







								<div class='form-group input'>







									<div class='col-md-12 form-control'>







										<input class='form-control my-workouts validate[required,max[".$retrieved_data->reps."]]' value=".$retrieved_data->reps." id='reps' name='reps_".$retrieved_data->id."' type='number' min='0' onKeyPress='if(this.value.length==3) return false;'>







										<label class='active'>".esc_html__('Reps','gym_mgt')."</label>







									</div>







								</div>







							</div>







							<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>







								<div class='form-group input'>







									<div class='col-md-12 form-control'>







										<input class='form-control my-workouts validate[required,max[".$retrieved_data->kg."]]' step='0.01' value=".$retrieved_data->kg." id='kg' name='kg_".$retrieved_data->id."' type='number' min='0' onKeyPress='if(this.value.length==6) return false;'>







										<label class='active'>".esc_html__('Kg','gym_mgt')."</label>







									</div>







								</div>







							</div>







							<div class='col-md-3 col-lg-3 col-sm-3 col-xl-3 div_margin_top_15px rtl_margin_bottom_15px'>







								<div class='form-group input'>







									<div class='col-md-12 form-control'>







										<input class='form-control my-workouts validate[required,max[".$retrieved_data->time."]]' id='rest' value=".$retrieved_data->time." name='rest_".$retrieved_data->id."' type='number' min='0' onKeyPress='if(this.value.length==3) return false;'>







										<label class='active'>".esc_html__('Rest Time','gym_mgt')."</label>







									</div>







								</div>







							</div>







						</div>







					</div>







				</div>







				</div>







			</div></div>";







		}







			echo $option="<input type='hidden' value='$workout_id' name='user_workout_id'>";







	}







	else







	{







		echo $option = "<div class='work_out_datalist'><div class='col-sm-10'><span class='col-md-10'>".esc_html__('No Workout assigned for today','gym_mgt')."</span></div></div>";







	}







	die();







}







//---------- LOAD MEASUREMENT FUNCTION----------//







function MJ_gmgt_load_workout_measurement()







{







	global $wpdb;







		$table_workout = $wpdb->prefix. 'gmgt_workouts';







	$result = $wpdb->get_row("SELECT measurment_id FROM $table_workout where id=". $_REQUEST['workout_id']);







	echo get_the_title($result->measurment_id);	







	die();







}







//---------- ADD CATEGORY TYPE FUNCTION----------//







function MJ_gmgt_add_categorytype($data)







{







	global $wpdb;







	$result = wp_insert_post( array(















			'post_status' => 'publish',















			'post_type' => $data['category_type'],















			'post_title' => MJ_gmgt_strip_tags_and_stripslashes($data['category_name']) ));















	$id = $wpdb->insert_id;







	return $id;







}







//---------- ADD CATEGORY FUNCTION----------//







function MJ_gmgt_add_category($data)







{







	global $wpdb;







	$model = $_REQUEST['model'];







	$data = array();







	$status=1;







	$status_msg= esc_html__('You have entered value already exists. Please enter some other value.','gym_mgt');







	$array_var = array();







	$data = array();







	$data['category_name'] = MJ_gmgt_strip_tags_and_stripslashes($_POST['category_name']);







	$data['category_type'] = $_POST['model'];







    $posttitle =$_REQUEST['category_name'];







	$scr_image = GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png";







    $post = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_title = '".$posttitle."' AND  post_type ='". $model."'" );







    $postname=$post->post_title;







	







   if($postname == $posttitle )







   {







	   $status=0;







   }







   else







   { 







	$id = MJ_gmgt_add_categorytype($data);







	$row1 = '<div class="row new_popup_padding" id="cat-'.$id.'"><div class="col-md-10 width_70 ">'.MJ_gmgt_strip_tags_and_stripslashes($_REQUEST['category_name']).'</div><div class="col-md-2 padding_left_0_res width_30"><div class="col-md-12 edit_btn_padding_left_25px_res width_50_res padding_right_0"><a class="btn-delete-cat badge btn-delete-cat_new gmgt_btn_delet_right" href="#" id='.$id.' model="'.$model.'"><img src="'.$scr_image.'" alt=""></a></div></div></div>';







	$option = "<option value='$id'>".MJ_gmgt_strip_tags_and_stripslashes($_REQUEST['category_name'])."</option>";















	$array_var[] = $row1;















	$array_var[] = $option;







   }







    $array_var[2]=$status;







    $array_var[3]=$status_msg;







	echo json_encode($array_var);















	die();







	







}







//---------- GET CLASS NAME FUNCTION ----------//







function MJ_gmgt_get_class_name($cid)







{







	







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_class_schedule';







	$classname =$wpdb->get_row("SELECT class_name FROM $table_name WHERE class_id=".$cid);







	if(!empty($classname))







	{







		return $classname->class_name;







	}







	else







	{ 







	  return "N/A";







	}







}







//---------- GET MEMBERSHIP NAME FUNCTION ---------//







function MJ_gmgt_get_membership_name($mid)







{







	if($mid == '')







		return '';







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membershiptype';







	$result =$wpdb->get_row("SELECT membership_label FROM $table_name WHERE membership_id=$mid");







	if(!empty($result))







	{







		return $result->membership_label;







	}







	else







	{







		return " N/A";







	}







}







//---------- GET MEMBERSHIP NAME FUNCTION ---------//







function MJ_gmgt_get_membership_name_a($mid)







{







	if($mid == '')







		return '';







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membershiptype';















	$result =$wpdb->get_results("SELECT membership_label FROM $table_name WHERE membership_id=".$mid);







	







	if(!empty($result))







	{







		foreach($result as $test)







		{







			return $test->membership_label;







		}







	}







	else







	{







		return " ";







	}







}



//----------GET MEMBERSHIP AMOUNT FUNCTION--------//



function MJ_gmgt_get_membership_price($mid)



{







	if($mid == '')







	{







		return '';







	}







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membershiptype';







	$result =$wpdb->get_row("SELECT membership_amount FROM $table_name WHERE membership_id=".$mid);







	if(!empty($result))







	{







		return $result->membership_amount;







	}







	else







	{







		return "N/A";







	}







}







//----------GET MEMBERSHIP SIGNUP AMOUNT FUNCTION--------//







function MJ_gmgt_get_membership_signup_amount($mid)







{







	if($mid == '')







	{







		return '';







	}







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membershiptype';







	$result =$wpdb->get_row("SELECT signup_fee FROM $table_name WHERE membership_id=".$mid);







	if(!empty($result))







	{







		return $result->signup_fee;







	}







	else







	{







		return " ";







	}







}







//----------GET MEMBERSHIP Tax Amount FUNCTION--------//







function MJ_gmgt_get_membership_tax_amount($mid,$type)







{







	if($mid == '')







	{







		return 0;







	}







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membershiptype';







	$result =$wpdb->get_row("SELECT * FROM $table_name WHERE membership_id=".$mid);







	if(!empty($result))







	{







		$membership_amount=$result->membership_amount;







		$signup_fee=$result->signup_fee;



		



		if($type == 'renew_membership')



		{



			$membership_and_signup_fee_amount=$membership_amount;



		}



		else



		{



			$membership_and_signup_fee_amount=$membership_amount+$signup_fee;



		}



		



		$tax_array=explode(",",$result->tax);







	



		if(!empty($tax_array))

		{







			$total_tax=0;







			foreach($tax_array as $tax_id)







			{







				$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







				$tax_amount=$membership_and_signup_fee_amount * $tax_percentage / 100;







		



				$total_tax=$total_tax + $tax_amount;				







			}







			







			$total_tax_amount=$total_tax;







		}







		else







		{







			$total_tax_amount=0;			







		}







		







		return $total_tax_amount;







	}







	else







	{







		return 0;







	}







}







//----------GET MEMBERSHIP Tax Amount FUNCTION--------//







function MJ_gmgt_get_membership_tax($mid)







{







	if($mid == '')







	{







		return '';







	}







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membershiptype';







	$result =$wpdb->get_row("SELECT * FROM $table_name WHERE membership_id=".$mid);







	if(!empty($result))







	{		







		$tax_id=$result->tax;







				







		return $tax_id;







	}







	else







	{







		return '';







	}







}







//----------GET MEMBERSHIP DAY FUNCTION--------//







function MJ_gmgt_get_membership_days($mid)







{







	if($mid == '')







		return '';







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membershiptype';















	$result =$wpdb->get_row("SELECT membership_length_id FROM $table_name WHERE membership_id=".$mid);







	if(!empty($result))







		return $result->membership_length_id;







	else







		return " ";







}







//----------GET MEMBERSHIP PAYMENT STATUS FUNCTION--------//







function MJ_gmgt_get_membership_paymentstatus($mp_id)







{







	global $wpdb;







		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';		







		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_membership_payment where mp_id = $mp_id");		







	if($result->paid_amount >= $result->membership_amount)







		return 'Fully Paid';







	elseif($result->paid_amount > 0)







		return 'Partially Paid';







	else







		return 'Unpaid';







}







function MJ_gmgt_get_membership_paymentstatus_for_check($mp_id)







{







	global $wpdb;







		$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';		







		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_membership_payment where mp_id = $mp_id");		







	if($result->paid_amount >= $result->membership_amount)







		return 'Fully Paid';







	elseif($result->paid_amount > 0)







		return 'Partially Paid';







	else







		return 'Unpaid';







}







//----------GET STORE PAYMENT STATUS FUNCTION--------//







function MJ_gmgt_get_store_paymentstatus($mp_id)







{







	global $wpdb;







		$table_gmgt_store_payment = $wpdb->prefix. 'gmgt_store';		







		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_store_payment where id = $mp_id");		







	if($result->paid_amount >= $result->total_amount)







		return esc_html__('Fully Paid','gym_mgt');







	elseif($result->paid_amount > 0)







		return esc_html__('Partially Paid','gym_mgt');







	else







		return esc_html__('Unpaid','gym_mgt');







}







//GET ALL MEMBERRSHIP PAYMENT BY USER ID FUNCTION//







function MJ_gmgt_get_all_membership_payment_byuserid($member_id)







{







	global $wpdb;







	$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';







	







	$result = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_payment where member_id = $member_id");







	return $result;







}







//----------GET GROUP MEMBER --------//







function MJ_gmgt_get_groupmember($group_id)







{







	global $wpdb;







	$table_gmgt_groupmember = $wpdb->prefix. 'gmgt_groupmember';







	$result = $wpdb->get_results("SELECT member_id FROM $table_gmgt_groupmember where group_id=".$group_id);







	return $result;







}















//----------GETACTIVITY BY CATEGORY --------//







function MJ_gmgt_get_activity_by_category($cat_id)







{















	global $wpdb;







	$table_activity = $wpdb->prefix. 'gmgt_activity';







	$activitydata = $wpdb->get_results("SELECT * FROM $table_activity where activity_cat_id=$cat_id ORDER BY activity_title ASC");







	return $activitydata;







}







//GET ACTIVITY BY Staff_member FUNCTION//







function MJ_gmgt_get_activity_by_staffmember($staff_memberid)







{







	global $wpdb;







	$table_gmgt_activity = $wpdb->prefix. 'gmgt_activity';







	$result = $wpdb->get_results("SELECT * FROM $table_gmgt_activity where activity_assigned_to=".$staff_memberid);







	return $result;







}















//----------REMOVE  CATEGORY FUNCTION--------//







function MJ_gmgt_remove_category()







{







	wp_delete_post($_REQUEST['cat_id']);







	die();







}







//----------GET ALL CATEGORY FUNCTION --------//







function MJ_gmgt_get_all_category($model)







{







	$args= array('post_type'=> $model,'posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');















	$cat_result = get_posts( $args );







	return $cat_result;















}















//----------ADD OR REMOVE  CATEGORY FUNCTION--------//







function MJ_gmgt_add_or_remove_category()







{















	$model = $_REQUEST['model'];







	 







		$title = esc_html__("title",'gym_mgt');















		$table_header_title =  esc_html__("header",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("category Name",'gym_mgt');























	if($model == 'membership_category')







	{















		$title = esc_html__("Membership Category",'gym_mgt');















		$table_header_title =  esc_html__("Category Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Category Name",'gym_mgt');	















	}







	if($model == 'installment_plan')







	{















		$title = esc_html__("Installment Plan",'gym_mgt');















		$table_header_title =  esc_html__("Plan Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Installment Plan Name",'gym_mgt');	















	}







	if($model == 'membership_period')







	{















		$title = esc_html__("Membership Period",'gym_mgt');















		$table_header_title =  esc_html__("Membership Period Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Membership Period Name",'gym_mgt');	







		







		$placeholder_text=esc_html__("Only Number of Days",'gym_mgt');















	}







	if($model == 'role_type')







	{















		$title = esc_html__("Role Type",'gym_mgt');















		$table_header_title =  esc_html__("Role Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Role Name",'gym_mgt');	















	}







	if($model == 'specialization')







	{















		$title = esc_html__("Specialization",'gym_mgt');















		$table_header_title =  esc_html__("Specialization Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Specialization Name",'gym_mgt');	















	}







	if($model == 'intrest_area')



	{















		$title = esc_html__("Intrest Area",'gym_mgt');















		$table_header_title =  esc_html__("Intrest Area Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Intrest Area Name",'gym_mgt');	















	}







	if($model == 'source')







	{















		$title = esc_html__("Source",'gym_mgt');















		$table_header_title =  esc_html__("Source Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Source Name",'gym_mgt');	















	}







	if($model == 'event_place')







	{















		$title = esc_html__("Event Place",'gym_mgt');















		$table_header_title =  esc_html__("Place Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Place Name",'gym_mgt');	















	}







	if($model == 'activity_category_staff')







	{















		$title = esc_html__("Activity Category",'gym_mgt');















		$table_header_title =  esc_html__("Activity Category Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Activity Category Name",'gym_mgt');	















	}







	if($model == 'activity_category')







	{















		$title = esc_html__("Activity Category",'gym_mgt');















		$table_header_title =  esc_html__("Activity Category Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Activity Category Name",'gym_mgt');	















	}







	if($model == 'measurment')







	{















		$title = esc_html__("Measurement",'gym_mgt');















		$table_header_title =  esc_html__("Measurement Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Measurement Name",'gym_mgt');	















	}







	if($model == 'level_type')







	{















		$title = esc_html__("Level Type",'gym_mgt');















		$table_header_title =  esc_html__("Level Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Level Name",'gym_mgt');	















	}







	if($model == 'workout_limit')







	{















		$title = esc_html__("Workout Limit",'gym_mgt');















		$table_header_title =  esc_html__("Workout Limit",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Workout Limit",'gym_mgt');	















	}







	if($model == 'calories_category')







	{















		$title = esc_html__("Calories Category",'gym_mgt');















		$table_header_title =  esc_html__("Calories",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Calories",'gym_mgt');	















	}







	if($model == 'product_category')







	{















		$title = esc_html__("Product Category",'gym_mgt');















		$table_header_title =  esc_html__("Category Name",'gym_mgt');















		$button_text=  esc_html__("Add",'gym_mgt');















		$label_text =  esc_html__("Category Name",'gym_mgt');	















	}







	if($model == 'activity_category_staff')







	{







		$cat_result = MJ_gmgt_get_all_category("activity_category");







	}







	else







	{







		$cat_result = MJ_gmgt_get_all_category( $model );







	}







	?>







	<script type="text/javascript">







		$(document).ready(function() {







			"use strict";







			$('#category_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	







		} );







	</script>







	<div class="modal-header">







		 <a href="javascript:void(0);" class="close-btn badge badge-success dashboard_pop-up_design pull-right <?php echo $model ;?>"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







  		<h4 id="myLargeModalLabel" class="res_add_pop_title_font_20px modal-title"><?php echo esc_html($title);?></h4>







	</div>















	<div class="padding_15px">	







		<form name="category_form" action="" method="post" class="category_popup_float form-horizontal" id="category_form">







			<div class="form-body user_form">







				<div class="row">







					<div class="col-md-9">







						<div class="form-group input">







							<div class="col-md-12 form-control">







									<!-- <input id="category_name" maxlength="50" min="1" class="cat_value validate[required] form-control text-input onlyletter_number" type="number"  value=""  name="category_name"  placeholder="<?php esc_attr_e('Must Be Enter Number of Days','gym_mgt');?>"> -->







								<input id="category_name" class="cat_value validate[required,custom[popup_category_validation]] form-control text-input"  value="" name="category_name" maxlength="50" <?php if(isset($placeholder_text)){?> type="number" placeholder="<?php  echo esc_attr($placeholder_text);}else{?>" type="text" <?php }?>>







								<label class="active " for="category_name"><?php echo esc_html($label_text);?><span class="require-field">*</span></label>







							</div>







						</div>







					</div>







					<div class="col-sm-3 rtl_margin_top_15px" style="padding-bottom: 10px;">







						<input type="button" value="<?php echo esc_attr($button_text);?>" name="save_category" class="btn popup_save_btn btn-success" model="<?php echo esc_attr($model);?>" id="btn-add-cat"/>







					</div>







				</div>







			</div>







  		</form>



		



		<?php



		if(!empty($cat_result))



		{ 



			?>



			<div class="category_listbox gmgt_add_category"><!--  CATEGORY LIST BOX DIV 111   -->







				<div class="table-responsive">







					<div class="div_new">	







						<?php







						$i = 1;







							foreach ($cat_result as $retrieved_data)







							{







								?>







								<div class="row new_popup_padding " id="<?php echo "cat-".$retrieved_data->ID.""; ?>">







									<div class="col-md-10 width_70 ">







										<?php







										echo $retrieved_data->post_title;







										?>







									</div>







									<div class="col-md-2 padding_left_0_res width_30" id="<?php echo $retrieved_data->ID; ?>">







										<div class="col-md-12 edit_btn_padding_left_25px_res padding_right_0" id="<?php echo $retrieved_data->ID; ?>">







											<a class="btn-delete-cat badge btn-delete-cat_new gmgt_btn_delet_right"  model="<?php echo $model; ?>" href="#" id="<?php echo $retrieved_data->ID; ?>">







												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" alt="">







											</a>







										</div>







									</div>







								</div>







								<?php







								$i++;







							}



					



						?>







					</div>







				</div>







			</div><!--  END CATEGORY LIST BOX DIV    -->	



			



			<?php



		}



		?>







  	</div>







	<?php 







	die();	







}







// GET PHONE CODE BY COUNTRY CODE FUNCTION //







function MJ_gmgt_get_countery_phonecode($country_name)







{







	$url = plugins_url( 'countrylist.xml', __FILE__ );







	$xml =simplexml_load_string(MJ_gmgt_get_remote_file($url));







	foreach($xml as $country)







	{







		if($country_name == $country->name)







			return $country->phoneCode;







	}







}







// GET DAY FUNCTION //







function MJ_gmgt_days_array()







{







	return $week=array(	'Monday'=>esc_html__('Monday','gym_mgt'),







						'Tuesday'=>esc_html__('Tuesday','gym_mgt'),







						'Wednesday'=>esc_html__('Wednesday','gym_mgt'),







						'Thursday'=>esc_html__('Thursday','gym_mgt'),







						'Friday'=>esc_html__('Friday','gym_mgt'),







						'Saturday'=>esc_html__('Saturday','gym_mgt'),







						'Sunday'=>esc_html__('Sunday','gym_mgt'));







}







// GET MEMBER TYPE //







function MJ_gmgt_member_type_array()







{







	return $membertype=array('Member'=>esc_html__('Active Member','gym_mgt'),







						'Prospect'=>esc_html__('Prospect','gym_mgt'),







						'Alumni'=>esc_html__('Alumni','gym_mgt'));







}















// GET MINUITE AARAY FUNCTION //







function MJ_gmgt_minute_array()







{







	return $minute=array('00'=>'00','05'=>'05','10'=>'10','15'=>'15','20'=>'20','25'=>'25','30'=>'30','35'=>'35','40'=>'40','45'=>'45','50'=>'50','55'=>'55');







}















// GET MEASUREMENT AARAY FUNCTION //







function MJ_gmgt_measurement_array()



{







	return $measurment=array(	'Height'=>'Height',







								'Weight'=>'Weight',







								'Chest'=>'Chest',







								'Waist'=>'Waist',







								'Thigh'=>'Thigh',







								'Arms'=>'Arms',







								'Fat'=>'Fat');







}







function MJ_gmgt_get_single_class_name($class_id)







{







	global $wpdb;







		$table_class = $wpdb->prefix. 'gmgt_class_schedule';







	return $retrieve_subject = $wpdb->get_var( "SELECT class_name FROM $table_class WHERE class_id=".$class_id);	







}







//LOAD USER FUNCTION







function MJ_gmgt_load_user()







{	







	$class_id =$_POST['class_list'];







	







	global $wpdb;







	$retrieve_data=get_users(array('meta_key' => 'class_id', 'meta_value' => $class_id,'role'=>'member'));







	$defaultmsg=esc_html__( 'Select Member' , 'gym_mgt');







	echo "<option value=''>".$defaultmsg."</option>";	







	foreach($retrieve_data as $users)







	{







		echo "<option value=".$users->id.">".$users->display_name."</option>";







	}







	die();	







}







//LOAD ALL ACTIVITY FUNCTION







function MJ_gmgt_load_activity()







{







	global $wpdb;







		$table_activity = $wpdb->prefix. 'gmgt_activity';







	







		$activitydata = $wpdb->get_results("SELECT * FROM $table_activity where activity_cat_id=".$_REQUEST['activity_list']);







		$defaultmsg=esc_html__( 'Select Activity', 'gym_mgt');







		echo "<option value=''>".$defaultmsg."</option>";	







		foreach($activitydata as $activity)







		{







			echo "<option value=".$activity->activity_id.">".$activity->activity_title."</option>";







		}







		die();







}







//GET INVOICE DATA FUNCTION







function MJ_gmgt_get_invoice_data($invoice_id)







{







	global $wpdb;







		$table_invoice= $wpdb->prefix. 'gmgt_payment';







		$result = $wpdb->get_row("SELECT *FROM $table_invoice where payment_id = ".$invoice_id);







		return $result;







}







 







//VIEW INVOICE  FUNCTION BY INVOICE TYPE FUNCTION







function MJ_gmgt_invoice_view()







{







	$obj_payment= new MJ_gmgt_payment();







	if($_POST['invoice_type']=='membership_invoice')







	{		







		$obj_membership_payment=new MJ_gmgt_membership_payment;	







		$membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($_POST['idtest']);







		$history_detail_result = MJ_gmgt_get_payment_history_by_mpid($_POST['idtest']);







	}







	if($_POST['invoice_type']=='income')







	{







		$income_data=$obj_payment->MJ_gmgt_get_income_data($_POST['idtest']);







		$history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($_POST['idtest']);







	}







	if($_POST['invoice_type']=='expense')







	{







		$expense_data=$obj_payment->MJ_gmgt_get_income_data($_POST['idtest']);







	}







	if($_POST['invoice_type']=='sell_invoice')







	{







		$obj_store=new MJ_gmgt_store;







		$selling_data=$obj_store->MJ_gmgt_get_single_selling($_POST['idtest']);







		$history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($_POST['idtest']);







	}







	?>	







	<div class="modal-header">







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right">X</a>







		<h4 class="modal-title"><?php echo get_option('gmgt_system_name','gym_mgt'); ?></h4>		







	</div>







	<div class="modal-body invoice_body">







		<div id="invoice_print">







			<img class="invoicefont1 rtl_invoice_img invoice_img_fun" src="<?php echo plugins_url('/gym-management/assets/images/invoice.jpg'); ?>" width="100%">







			<div class="main_div">					







				<table class="width_100 rtl_invoice_header position_absolute" border="0">					







					<tbody>







						<tr>







							<td class="width_1">







								<img class="system_logo" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">







							</td>							







							<td class="only_width_20">







								<?php







								 echo esc_html_e('A. ','gym_mgt').chunk_split(get_option('gmgt_gym_address'),30,"<BR>"); 







								 echo esc_html_e('E. ','gym_mgt').get_option( 'gmgt_email' )."<br>"; 







								 echo esc_html_e('P. ','gym_mgt') .get_option( 'gmgt_contact_number' )."<br>"; 







								?> 







							</td>







							<td align="right" class="width_24">







							</td>







						</tr>







					</tbody>







				</table>







				<table class="width_50" border="0">







					<tbody>				







						<tr>







							<td colspan="2"  class="billed_to" align="center">								







								<h3 class="billed_to_lable"><?php esc_html_e('Bill To','gym_mgt');?>. </h3>







							</td>







							<td class="width_40">								







							<?php 







								if(!empty($expense_data))







								{



									if($expense_data->supplier_name){



								   		echo "<h3 class='display_name'>".chunk_split(ucwords($expense_data->supplier_name),30,"<BR>"). "</h3>"; 



									}



									else{



										echo'N/A';



									}



								}







								else







								{







									if(!empty($income_data))







										$member_id=$income_data->supplier_name;







									 if(!empty($membership_data))







										$member_id=$membership_data->member_id;







									 if(!empty($selling_data))







										$member_id=$selling_data->member_id;







									$patient=get_userdata($member_id);



									if($patient){



										echo "<h3 style='font-weight: bold;'>".chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>"). "</h3>"; 



									}



									else{



										echo'N/A';



									}



									 







									 $address=get_user_meta( $member_id,'address',true);







									 echo chunk_split($address,30,"<BR>");







									 $city_name = get_user_meta( $member_id,'city_name',true );







									$zip_code = get_user_meta( $member_id,'zip_code',true );







									echo chunk_split($address,30,"<BR>"); 







									if(!empty($zip_code))







									{







										







										echo get_user_meta( $member_id,'zip_code',true ).",<BR>"; 







									}







									if(!empty($city_name))







									{







										echo get_user_meta( $member_id,'city_name',true ).","."<BR>"; ; 







									}







									echo get_user_meta( $member_id,'mobile',true )."<br>"; 







								}







							?>			







							</td>







						</tr>									







					</tbody>







				</table>







					<?php 







					$issue_date='DD-MM-YYYY';







					if(!empty($income_data))







					{







						$issue_date=$income_data->invoice_date;







						$payment_status=$income_data->payment_status;







						$invoice_no=$income_data->invoice_no;







					}







					if(!empty($membership_data))







					{







						$issue_date=$membership_data->created_date;







						if($membership_data->payment_status!='0')







						{	







							$payment_status=$membership_data->payment_status;







						}







						else







						{







							$payment_status='Unpaid';







						}		







						$invoice_no=$membership_data->invoice_no;







					}







					if(!empty($expense_data))







					{







						$issue_date=$expense_data->invoice_date;







						$payment_status=$expense_data->payment_status;







						$invoice_no=$expense_data->invoice_no;







					}







					if(!empty($selling_data))







					{







						$issue_date=$selling_data->sell_date;	







						if(!empty($selling_data->payment_status))







						{







							$payment_status=$selling_data->payment_status;







						}	







						else







						{







							$payment_status='Fully Paid';







						}		







						







						$invoice_no=$selling_data->invoice_no;







					}			







						







					?>







				<table class="width_50 float_right_res" border="0">







					<tbody>				 







						<tr>	







							<td class="width_30">







							</td>







							<td class="width_20 sell_padding_0_res">







								<?php







								if($_POST['invoice_type']!='expense')







								{







								?>	







									<h3 class="invoice_lable"><?php echo esc_html__('INVOICE','gym_mgt')." </br> #".$invoice_no;?></h3>								







								<?php







								}







								?>								







								<h5><?php echo esc_html__('Date','gym_mgt')." : ".MJ_gmgt_getdate_in_input_box($issue_date);?></h5>







								<h5><?php echo esc_html__('Status','gym_mgt')." : ". esc_html__($payment_status,'gym_mgt');?></h5>									







							</td>							







						</tr>									







					</tbody>







				</table>						







				<?php







				if($_POST['invoice_type']=='membership_invoice')







				{ 







					?>	







					<table class="width_100">	







						<tbody>	







							<tr>







								<td>







									<h3  class="entry_lable"><?php esc_html_e('Membership Entries','gym_mgt');?></h3>







								</td>	







							</tr>	







						</tbody>







					</table>	







					







				<?php 	







				}				







				elseif($_POST['invoice_type']=='income')







				{ 







				?>	







					<table class="width_100">	







						<tbody>	







							<tr>







								<td>







									<h3  class="entry_lable"><?php esc_html_e('Income Entries','gym_mgt');?></h3>







								</td>	







							</tr>	







						</tbody>







					</table>







				







				<?php 	







				}







				elseif($_POST['invoice_type']=='sell_invoice')







				{ 







				   ?>







				   <table class="width_100">	







						<tbody>	







							<tr>







								<td>







									<h3  class="entry_lable"><?php esc_html_e('Sale Product','gym_mgt');?></h3>







								</td>	







							</tr>	







						</tbody>







					</table>







					







				  <?php







				}







				else







				{ ?>







					<table class="width_100">	







						<tbody>	







							<tr>







								<td>







									<h3  class="entry_lable"><?php esc_html_e('Expense Entries','gym_mgt');?></h3>







								</td>	







							</tr>	







						</tbody>







					</table>	







					 







				<?php 	







				}







			   ?>







					







				<table class="table table-bordered sell_product_oflow_y" class="width_93" border="1">







					<thead class="entry_heading">







						<?php







						if($_POST['invoice_type']=='membership_invoice')







						{







						?>







							<tr>







								<th class="color_white align_center">#</th>







								<th class="color_white align_center" style ="text-transform:uppercase; !important"> <?php esc_html_e('DATE','gym_mgt');?></th>







								<th class="width_40 color_white" style ="text-transform:uppercase; !important"><?php esc_html_e('Membership Name','gym_mgt');?> </th>







								<th class="color_white align_right" style ="text-transform:uppercase; !important"><?php esc_html_e('Amount','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>								







							</tr>	







						<?php







						}







						elseif($_POST['invoice_type']=='sell_invoice')







						{  







						?>







							<tr>







								<th class="color_white align_center">#</th>







								<th class="color_white align_center"> <?php esc_html_e('DATE','gym_mgt');?></th>







								<th class="width_40 color_white"><?php esc_html_e('PRODUCT NAME','gym_mgt');?> </th>







								<th class="width_3 color_white"><?php esc_html_e('QUANTITY','gym_mgt');?></th>







								<th class="color_white"><?php esc_html_e('PRICE','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>







								<th class="color_white align_right"><?php esc_html_e('TOTAL','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>								







							</tr>







						<?php 







						} 







						else







						{ 







						?>







							<tr>







								<th class="color_white align_center">#</th>







								<th class="color_white align_center"> <?php esc_html_e('DATE','gym_mgt');?></th>







								<th class="width_40 color_white"><?php esc_html_e('ENTRY','gym_mgt');?> </th>







								<th class="color_white align_right"><?php esc_html_e('Amount','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>								







							</tr>	 







						<?php 







						}	







						?>







					</thead>







					<tbody>







						<?php 







						$id=1;







						$i=1;







						$total_amount=0;







						if(!empty($income_data) || !empty($expense_data))







						{







							if(!empty($expense_data))







								$income_data=$expense_data;							







							$member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);







							







							foreach($member_income as $result_income)







							{







								$income_entries=json_decode($result_income->entry);







								$discount_amount=$result_income->discount;







								$paid_amount=$result_income->paid_amount;







								$total_discount_amount= $result_income->amount - $discount_amount;







								







								if($result_income->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$result_income->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$total_tax=$total_discount_amount * $result_income->tax/100;







								}				







								







								$due_amount=0;







								$due_amount=$result_income->total_amount - $result_income->paid_amount;







								$grand_total=$total_discount_amount + $total_tax;







								







							   foreach($income_entries as $each_entry)







							   {







									$total_amount+=$each_entry->amount;







									?>







									<tr class="entry_list">







										<td class="align_center"><?php echo $id;?></td>







										<td class="align_center"><?php echo MJ_gmgt_getdate_in_input_box($result_income->invoice_date);?></td>







										<td><?php echo $each_entry->entry; ?> </td>







										<td class="align_right"><?php echo number_format($each_entry->amount,2); ?></td>







									</tr>







									<?php







									$id+=1;







									$i+=1;







								}







								if($grand_total=='0')									







								{	







									if($income_data->payment_status=='Paid')







									{







										







										$grand_total=$total_amount;







										$paid_amount=$total_amount;







										$due_amount=0;										







									}







									else







									{







										







										$grand_total=$total_amount;







										$paid_amount=0;







										$due_amount=$total_amount;															







									}







								}







							}







						}







							







						if(!empty($membership_data))







						{







												







							$membership_signup_amounts=$membership_data->membership_signup_amount;







							?>







							<tr class="entry_list">







								<td class="align_center"><?php echo $i;?></td> 







								<td class="align_center"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td> 







								<td><?php echo MJ_gmgt_get_membership_name($membership_data->membership_id);?></td>								







								<td class="align_right"><?php echo number_format($membership_data->membership_fees_amount,2); ?></td>







							</tr>







							<?php 







							if( $membership_signup_amounts  > 0) 







							{







							?>







							<tr class="entry_list">







								<td class="align_center"><?php echo 2 ;?></td> 







								<td class="align_center"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td> 







								<td><?php esc_html_e('Membership Signup Fee','gym_mgt');?></td>								







								<td class="align_right"><?php echo number_format($membership_data->membership_signup_amount,2); ?></td>







							</tr>







							<?php







							}







						}







						if(!empty($selling_data))







						{								







							$all_entry=json_decode($selling_data->entry);







							







							if(!empty($all_entry))







							{







								foreach($all_entry as $entry)







								{







									$obj_product=new MJ_gmgt_product;







									$product = $obj_product->MJ_gmgt_get_single_product($entry->entry);







									







										$product_name=$product->product_name;					







										$quentity=$entry->quentity;	







										$price=$product->price;										







									?>







									<tr class="entry_list">										







										<td class="align_center"><?php echo $i;?></td> 







										<td class="align_center"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>







										<td><?php echo $product_name;?> </td>







										<td  class="width_3"> <?php echo $quentity; ?></td>







										<td><?php echo MJ_gmgt_get_floting_value($price); ?></td>







										<td class="align_right"><?php echo number_format($quentity * $price,2); ?></td>







									</tr>







								<?php 







								$id+=1;







								$i+=1;







								}







							}







							else







							{







								$obj_product=new MJ_gmgt_product;







								$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 







								







								$product_name=$product->product_name;					







								$quentity=$selling_data->quentity;	







								$price=$product->price;	







								?>







								<tr class="entry_list">										







									<td class="align_center"><?php echo $i;?></td> 







									<td class="align_center"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>







									<td><?php echo $product_name;?> </td>







									<td  class="width_3"> <?php echo $quentity; ?></td>







									<td> <?php echo $price; ?></td>







									<td class="align_right"> <?php echo number_format($quentity * $price,2); ?></td>







								</tr>







								<?php







								$id+=1;







								$i+=1;







							}	







						}







							







						?>							







					</tbody>







				</table>







				<table class="width_54 width_res_invoice" border="0">







					<tbody>







						<?php 







						if(!empty($membership_data))







						{







							$total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;







							$total_tax=$membership_data->tax_amount;							







							$paid_amount=$membership_data->paid_amount;







							$due_amount=abs($membership_data->membership_amount - $paid_amount);







							$grand_total=$membership_data->membership_amount;							







						}







						if(!empty($expense_data))







						{







							$grand_total=$total_amount;







						}







						if(!empty($selling_data))







						{







							$all_entry=json_decode($selling_data->entry);







							







							if(!empty($all_entry))







							{







								$total_amount=$selling_data->amount;







								$discount_amount=$selling_data->discount;







								$total_discount_amount=$total_amount-$discount_amount;







								







								if($selling_data->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$selling_data->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$tax_per=$selling_data->tax;







									$total_tax=$total_discount_amount * $tax_per/100;







								}







								







								$paid_amount=$selling_data->paid_amount;







								$due_amount=abs($selling_data->total_amount - $paid_amount);







								$grand_total=$selling_data->total_amount;







							}







							else







							{	







								$obj_product=new MJ_gmgt_product;







								$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id);







								$price=$product->price;	



								$total_amount=$price*$selling_data->quentity;







								$discount_amount=$selling_data->discount;







								$total_discount_amount=$total_amount-$discount_amount;







								







								if($selling_data->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$selling_data->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$tax_per=$selling_data->tax;







									$total_tax=$total_discount_amount * $tax_per/100;







								}







																







								$paid_amount=$total_amount;







								$due_amount='0';







								$grand_total=$total_amount;								







							}		







						}							







						?>







						<tr>







							<h4><td class="width_70 align_right"><h4 class="margin"><?php esc_html_e('Subtotal','gym_mgt');?>:</h4></td>







							<td class="align_right"> <h4 class="margin"><span><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo number_format($total_amount,2);?></h4></td>







						</tr>







						<?php







						if($_POST['invoice_type']!='expense')







						{







							if($_POST['invoice_type']!='membership_invoice')







							{







							?>	







							<tr>







								<td class="width_70 align_right"><h4><?php esc_html_e('Discount Amount','gym_mgt');?>:</h4></td>







								<td class="align_right"> <h4 class="margin"><span ><?php  echo "-";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo number_format($discount_amount,2); ?></h4></td>







							</tr>







							<?php







							}







							?>







							<tr>







								<td class="width_70 align_right"><h4><?php esc_html_e('Tax Amount','gym_mgt');?>:</h4></td>







								<td class="align_right"><h4 class="margin"> <span ><?php  echo "+";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo number_format($total_tax,2); ?></h4></td>







							</tr>							







							<tr>







								<td class="width_70 align_right"><h4><?php esc_html_e('Due Amount','gym_mgt');?>:</h4></td>







								<td class="align_right"> <h4 class="margin"><span ><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo number_format($due_amount,2); ?></h4></td>







							</tr>







							<tr>







								<td class="width_70 align_right"><h4><?php esc_html_e('Paid Amount','gym_mgt');?>:</h4></td>







								<td class="align_right"> <h4 class="margin"><span ><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span><?php echo number_format($paid_amount,2); ?></h4></td>







							</tr>







						<?php







						}







						?>







						<tr>							







							<td class="width_56 align_right grand_total_lable margin_right_2"><h3 class="color_white margin"><?php esc_html_e('Grand Total','gym_mgt');?>:</h3></td>







							<td class="align_right grand_total_amount"><h3 class="color_white margin">  <span><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format($grand_total,2); ?> </span></h3></td>







						</tr>							







					</tbody>







				</table>







				<?php







				if($_POST['invoice_type']!='expense')







				{







				?>		







				<table class="width_46 wdth_rsp_100" border="0">







					<tbody>						







						<tr>







							<td colspan="2">







								<h3 class="payment_method_lable" style ="text-transform:uppercase;"><?php esc_html_e('Payment Method','gym_mgt');?>







								</h3>







							</td>								







						</tr>							







						<tr>







							<td class="width_31 font_12"><?php esc_html_e('Bank Name','gym_mgt');  ?>:</td>







							<td class="font_12"><?php echo get_option( 'gmgt_bank_name' );?></td>







						</tr>







						<tr>







							<td class="width_31 font_12"><?php esc_html_e('Account No','gym_mgt'); ?>:</td>







							<td class="font_12"> <?php echo get_option( 'gmgt_bank_acount_number' );?></td>







						</tr>







						







						<tr>







							<td class="width_31 font_12"><?php esc_html_e('IFSC Code','gym_mgt'); ?>:</td>







							<td class="font_12"> <?php echo get_option( 'gmgt_bank_ifsc_code' );?></td>







						</tr>







						







						<tr>







							<td class="width_31 font_12"> <?php esc_html_e('Paypal Id','gym_mgt'); ?>:</td>







							<td class="font_12 demo"><?php echo get_option( 'gmgt_paypal_email' );?></td>







						</tr>







					</tbody>







				</table>







					<?php				







					if(!empty($history_detail_result))







					{







					?>







						<hr class="width_100 flot_left_invoice_history_hr">







						<table class="width_100">	







							<tbody>	







								<tr>







									<td>







										<h3  class="entry_lable"><?php esc_html_e('Payment History','gym_mgt');?></h3>







									</td>	







								</tr>	







							</tbody>







						</table>







						<table class="table table-bordered border_collapse sell_product_oflow_y" width="100%" border="1">







							<thead class="entry_heading">







								<tr>							







									<th class="color_white align_center" style ="text-transform:uppercase; !important"> <?php esc_html_e('Date','gym_mgt');?></th>







									<th class="width_40 color_white align_center" style ="text-transform:uppercase; !important"><?php esc_html_e('Amount','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>







									<th class="color_white align_center" style ="text-transform:uppercase; !important"><?php esc_html_e('Method','gym_mgt');?></th>







									<th class="color_white align_center" style ="text-transform:uppercase; !important"><?php esc_html_e('Payment Details','gym_mgt');?></th>







								</tr>	







							</thead>







							<tbody>







								<?php 







								foreach($history_detail_result as  $retrive_data)







								{







									?>







									<tr class="entry_list">







										<td class="align_center"><?php echo MJ_gmgt_getdate_in_input_box($retrive_data->paid_by_date);?></td> 







										<td class="align_center"><?php echo MJ_gmgt_get_floting_value($retrive_data->amount); ?></td> 







										<td class="align_center"><?php echo  esc_html__($retrive_data->payment_method,"gym_mgt"); ?></td>







										<td class="align_center"><?php if(!empty($retrive_data->payment_description)){ echo  $retrive_data->payment_description; }else{ echo '-'; }?></td>







									</tr>







									<?php 







								}







								?>







							</tbody>







						</table>







					<?php 







					}







				}







				?>







			</div>







		</div>







		<div class="print-button pull-left">







			<a  href="?page=invoice&print=print&invoice_id=<?php echo $_POST['idtest'];?>&invoice_type=<?php echo $_POST['invoice_type'];?>" target="_blank"class="btn btn-success"><?php esc_html_e('Print','gym_mgt');?></a>







			<?php







			if($_POST['invoice_type']!='expense')







			{







			?>	







				<a  href="?page=invoice&pdf=pdf&invoice_id=<?php echo $_POST['idtest'];?>&invoice_type=<?php echo $_POST['invoice_type'];?>" target="_blank"class="btn btn-success"><?php esc_html_e('PDF','gym_mgt');?></a>			







			<?php







			}







			?>







		</div>







	</div>		







	<?php 







	die();







}







//PRINT INIT FUNCTION







function MJ_gmgt_print_init()







{







	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'invoice')







	{







		?>







		<script>

			function printWithDelay() {

				setTimeout(function() {

					window.print();

				}, 200);

			}

			window.onload = printWithDelay;

		</script>







		<?php 







				







		MJ_gmgt_invoice_print($_REQUEST['invoice_id'],$_REQUEST['invoice_type']);







		exit;







	}			







}















add_action('init','MJ_gmgt_print_init');







//print invoice FUNCTION







function MJ_gmgt_invoice_print($invoice_id,$type)







{



	



	$obj_payment= new MJ_gmgt_payment();



	$fees_detail_result = '';



	if($type=='membership_invoice')







	{		







		$obj_membership_payment=new MJ_gmgt_membership_payment;	







		$membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($invoice_id);







		$history_detail_result = MJ_gmgt_get_payment_history_by_mpid($invoice_id);		







	}







	if($type=='income')







	{







		$income_data=$obj_payment->MJ_gmgt_get_income_data($invoice_id);







		$history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($invoice_id);







		







	}







	if($type=='expense')







	{







		$expense_data=$obj_payment->MJ_gmgt_get_income_data($invoice_id);







	}







	if($type=='sell_invoice')







	{ 







		$obj_store=new MJ_gmgt_store;







		$selling_data=$obj_store->MJ_gmgt_get_single_selling($invoice_id);







		$history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($invoice_id);







	}



	



  	echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/style.css', __FILE__).'"></link>';	















	if (is_rtl())







	{







		echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/custom_rtl.css', __FILE__).'"></link>';



		echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/new_design_rtl.css', __FILE__).'"></link>';		



  		echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/common-rtl.min.css', __FILE__).'"></link>';



  		echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap-rtl_min.css', __FILE__).'"></link>';



  		echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/validationEngine_jquery.css', __FILE__).'"></link>';







	}



	



	



	?>







	<style>







		@import url('https://fonts.googleapis.com/css?family=Poppins:400,700,900');







	







		body, body * 







		{







			font-family: 'Poppins' !important;







		}







		table thead 







		{







			-webkit-print-color-adjust:exact;







		}







		.invoice_table_grand_total{







			-webkit-print-color-adjust:exact;







			background-color: #ba170b;







		}







		.invoice_lable {







			-webkit-print-color-adjust:exact;







			background-color: #ba170b;







			color: white;







			padding: 10px;







		}







		#invoice_print .row .width_1 img







		{







			height: 54px !important;







   			width: 54px !important;







		}



		@media print {

			* {

				color-adjust: exact !important;

				-webkit-print-color-adjust: exact !important;

				print-color-adjust: exact !important;

				}



			td.total_heading {



				font-size: 15px;



			}



		}







	</style>







	<link rel="stylesheet" href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap_min.css'; ?>" type="text/css" />







	<link rel="stylesheet" href="<?php echo GMS_PLUGIN_URL.'/assets/css/dataTables.css'; ?>" type="text/css" />







	



		



	<div class="penal-body" id="Fees_invoice" ><!----- penal Body --------->







		<div id="invoice_print" class="modal-body border_invoice_page margin_top_15px_rs invoice_model_body float_left_width_100 height_600px padding_10px"><!---- model body  ----->







			<img class="rtl_image_set_invoice invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/gym-management/assets/images/invoice.png'); ?>" width="100%">







			<div class="main_div margin_20px_position float_left_width_100 payment_invoice_popup_main_div">







				<div class="invoice_width_100 float_left_width_100" border="0">







					<h3 class="school_name_for_invoice_view"><?php echo get_option( 'gmgt_system_name' ) ?></h3>







					<div class="row margin_top_20px width_100px">







						<div class="col-md-1 col-sm-2 col-xs-3 " style="width:8.3333%;">







							<div class="width_1 rtl_width_80px">







								<img class="system_logo"  src="<?php echo esc_url(get_option( 'gmgt_gym_other_data_logo' )); ?>">







							</div>







						</div>	







						<div class="col-md-11 col-sm-10 col-xs-9 invoice_address invoice_address_css" style="width:91.3333%;">	







							<div class="row width_100px">	







								<div class="col-md-12 col-sm-12 col-xs-12 invoice_padding_bottom_15px padding_right_0">	







									<label class="popup_label_heading"><?php esc_html_e('Address','gym_mgt'); ?>







									</label><br>







									<label style="padding-top:10px;padding-bottom:10px;" for="" class="label_value word_break_all">	<?php







											echo chunk_split(get_option( 'gmgt_gym_address' ),100,"<BR>").""; 







										?></label>







								</div>







								<div class="row col-md-12 invoice_padding_bottom_15px">	







									<div style="width:50%;" class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 email_width_auto">	







										<label class="popup_label_heading"><?php esc_html_e('Email','gym_mgt');?> </label><br>







										<label style="padding-top:10px;padding-bottom:10px;" for="" class="label_value word_break_all"><?php echo get_option( 'gmgt_email' ),"<BR>";  ?></label>







									</div>







							







									<div style="width:50%;" class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 padding_left_30px">







										<label class="popup_label_heading"><?php esc_html_e('Phone','gym_mgt');?> </label><br>







										<label style="padding-top:10px;padding-bottom:10px;" for="" class="label_value"><?php echo get_option( 'gmgt_contact_number' )."<br>";  ?></label>







									</div>







								</div>	







								<div align="right" class="width_24"></div>									







							</div>				







						</div>







					</div>







					<div class="col-md-12 col-sm-12 col-xl-12 mozila_display_css margin_top_20px">







						<div class="row">







							<div class="width_50a1 float_left_width_100">







								<div style="width: 65%" class="col-md-8 col-sm-8 col-xs-5 padding_0 float_left display_grid display_inherit_res margin_bottom_20px rs_main_billed_to">







									<div class="billed_to float_left_width_100 display_flex invoice_address_heading rs_width_billed_to">				







										<?php







										$issue_date='DD-MM-YYYY';







										if(!empty($income_data))







										{







											$issue_date=$income_data->invoice_date;







											$payment_status=$income_data->payment_status;







											$invoice_no=$income_data->invoice_no;







										}







										if(!empty($membership_data))







										{







											$issue_date=$membership_data->created_date;







											if($membership_data->payment_status!='0')







											{	







												$payment_status=$membership_data->payment_status;







											}







											else







											{







												$payment_status='Unpaid';







											}		







											$invoice_no=$membership_data->invoice_no;







										}







										if(!empty($expense_data))







										{







											$issue_date=$expense_data->invoice_date;







											$payment_status=$expense_data->payment_status;







											$invoice_no=$expense_data->invoice_no;







										}







										if(!empty($selling_data))







										{







											$issue_date=$selling_data->sell_date;	







											if(!empty($selling_data->payment_status))







											{







												$payment_status=$selling_data->payment_status;







											}	







											else







											{







												$payment_status='Fully Paid';







											}		







											







											$invoice_no=$selling_data->invoice_no;







										}			







											







										?>







										<h3 style="width:18%;" class="billed_to_lable invoice_model_heading bill_to_width_12 rs_bill_to_width_40"><?php esc_html_e('Bill To','gym_mgt');?> : </h3>







										







										<?php







										if(!empty($expense_data))







										{







											$party_name=$expense_data->supplier_name; 



											if($party_name){



												echo "<h3 style='width:75%; padding-top: 4px;' class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";



											}



											else{



												echo'N/A';



											}



										}







										else{







											if(!empty($income_data))







												$member_id=$income_data->supplier_name;







											if(!empty($membership_data))







												$member_id=$membership_data->member_id;







											if(!empty($selling_data))







												$member_id=$selling_data->member_id;







											$patient=get_userdata($member_id);						



											if($patient){



												echo "<h3 class='display_name invoice_width_100' style='padding-top: 4px;'>".chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>"). "</h3>";



											}



											else{



												echo'N/A';



											}











										}







										?>







									</div> 







									<div class="width_60b2 address_information_invoice">







										<?php 	







										if(!empty($expense_data))







										{







											// $party_name=$expense_data->supplier_name; 







											// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";







										}







										else







										{







											if(!empty($income_data))







												$member_id=$income_data->supplier_name;







											if(!empty($membership_data))







												$member_id=$membership_data->member_id;







											if(!empty($selling_data))







												$member_id=$selling_data->member_id;







											$patient=get_userdata($member_id);						







											// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";







											$address=get_user_meta( $member_id,'address',true );







											$city_name = get_user_meta( $member_id,'city_name',true );







											$zip_code = get_user_meta( $member_id,'zip_code',true );







											echo chunk_split($address,30,"<BR>"); 







											if(!empty($zip_code))







											{







												







												echo get_user_meta( $member_id,'zip_code',true ).",<BR>"; 







											}







											if(!empty($city_name))







											{







												echo get_user_meta( $member_id,'city_name',true ).","."<BR>"; ; 







											}







										}		







										?>	







									</div>







								</div> 







								<div class="col-md-3 col-sm-4 col-xs-7 float_left">







									<div class="width_50a1112">







										<div class="width_20c" align="center">







											<?php







											if($_REQUEST['invoice_type']!='expense')







											{







												?>	







												<h3 class="invoice_lable"><?php echo esc_html__('INVOICE','gym_mgt')."  #".$invoice_no;?></h3>								







												<?php







											}







											?>







											<h5 class="align_left"> <label class="popup_label_heading text-transfer-upercase"><?php   echo esc_html__('Date :','gym_mgt') ?> </label>&nbsp;  <label class="invoice_model_value"><?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label></h5>







											<h5 class="align_left"><label class="popup_label_heading text-transfer-upercase"><?php echo esc_html__('Status :','gym_mgt')?> </label>  &nbsp;<label class="invoice_model_value"><?php 



											if($payment_status == 'Unpaid')



											{



												echo '<span style="color:red;">'.esc_html__($payment_status,'gym_mgt').'</span>';



											}



											elseif($payment_status == 'Partially Paid')



											{



												echo '<span style="color:blue;">'.esc_html__($payment_status,'gym_mgt').'</span>';



											}



											else



											{



												echo '<span style="color:green;">'.esc_html__($payment_status,'gym_mgt').'</span>';



											}



											?></h5>	







										</div> 







									</div> 







								</div> 







							</div> 







						</div>  







					</div>







					<table class="width_100 margin_top_10px_res">	







						<tbody>		







							<tr>







								<td>







									<?php







									if($_REQUEST['invoice_type']=='membership_invoice')







									{ 







										?>







										<h3 class="display_name"><?php esc_attr_e('Membership Entries','gym_mgt');?></h3>







										<?php







									}







									elseif($_REQUEST['invoice_type']=='income')







									{ 







										?>







										<h3 class="display_name"><?php esc_attr_e('Income Entries','gym_mgt');?></h3>







										<?php







									}







									elseif($_REQUEST['invoice_type']=='sell_invoice')







									{ 







										?>







										<h3 class="display_name"><?php esc_attr_e('Sale Product','gym_mgt');?></h3>







										<?php







									}







									else







									{







										?>







										<h3 class="display_name"><?php esc_attr_e('Expense Entries','gym_mgt');?></h3>







										<?php







									}







									?>







									







								<td>	







							</tr>







						</tbody>







					</table>







					<div class="table-responsive table_max_height_180px rtl_padding-left_40px" style="padding-right:50px;">







						<table class="table model_invoice_table">







							<thead class="entry_heading invoice_model_entry_heading">	







								<?php







								if($_REQUEST['invoice_type']=='membership_invoice')







								{







									?>				







									<tr>







										<th class="entry_table_heading align_center">#</th>







										<th class="entry_table_heading align_center" style ="text-transform:uppercase; !important"> <?php esc_attr_e('Date','gym_mgt');?></th>







										<th class="entry_table_heading align_center" style ="text-transform:uppercase; !important"><?php esc_attr_e('Membership Name','gym_mgt');?> </th>







										<th class="entry_table_heading align_center" style ="text-transform:uppercase; !important"><?php esc_attr_e('Amount','gym_mgt');?></th>







									</tr>







									<?php







								}







								elseif($_REQUEST['invoice_type']=='sell_invoice')







								{







									?>				







									<tr>







										<th class="entry_table_heading align_center">#</th>







										<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>







										<th class="entry_table_heading align_center"><?php esc_attr_e('Product Name','gym_mgt');?> </th>







										<th class="entry_table_heading align_center"><?php esc_attr_e('Quantity','gym_mgt');?></th>







										<th class="entry_table_heading align_center"><?php esc_attr_e('Price','gym_mgt');?> </th>







										<th class="entry_table_heading align_center"><?php esc_attr_e('Total','gym_mgt');?></th>







									</tr>







									<?php







								}







								else







								{







									?>				







									<tr>







										<th class="entry_table_heading align_center">#</th>







										<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>







										<th class="entry_table_heading align_center"><?php esc_attr_e('Entry','gym_mgt');?> </th>







										<th class="entry_table_heading align_center"><?php esc_attr_e('Amount','gym_mgt');?></th>







									</tr>







									<?php







								}







								?>						







							</thead>







							<tbody>







								<?php 







								$id=1;







								$i=1;







								$total_amount=0;







								if(!empty($income_data) || !empty($expense_data))







								{







									if(!empty($expense_data))







									{







										$income_data=$expense_data;







									}







									







									$member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);







									







									foreach($member_income as $result_income)







									{



										if(!empty($result_income->tax_id)){



											$tax_name = MJ_gmgt_tax_name_by_tax_id_array_for_invoice(esc_html($result_income->tax_id));



										}



										else{



											$tax_name = '';



										}



										$discount_name = '';



										$income_entries=json_decode($result_income->entry);







										$discount_amount=$result_income->discount;







										$paid_amount=$result_income->paid_amount;







										$total_discount_amount= $result_income->amount - $discount_amount;







										if($result_income->tax_id!='')







										{									







											$total_tax=0;







											$tax_array=explode(',',$result_income->tax_id);







											foreach($tax_array as $tax_id)







											{







												$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







																	







												$tax_amount=$total_discount_amount * $tax_percentage / 100;







												







												$total_tax=$total_tax + $tax_amount;				







											}







										}







										else







										{







											$total_tax=$total_discount_amount * $result_income->tax/100;







										}







										$due_amount=0;







										$due_amount=$result_income->total_amount - $result_income->paid_amount;







										$grand_total=$total_discount_amount + $total_tax;















										foreach($income_entries as $each_entry)







										{







											$total_amount+=$each_entry->amount;								







											?>







											<tr>







												<td class="align_center invoice_table_data"><?php echo $id;?></td>







												<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($result_income->invoice_date);?></td>







												<td class="align_center invoice_table_data"><?php echo $each_entry->entry; ?> </td>







												<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($each_entry->amount,2); ?></td>







											</tr>







											<?php 







											$id+=1;







											$i+=1;







										}







										if($grand_total=='0')									







										{	







											if($income_data->payment_status=='Paid')







											{







												







												$grand_total=$total_amount;







												$paid_amount=$total_amount;







												$due_amount=0;										







											}







											else







											{







												







												$grand_total=$total_amount;







												$paid_amount=0;







												$due_amount=$total_amount;															







											}







										}







									}







								}







								if(!empty($membership_data))







								{







									$membership_signup_amounts=$membership_data->membership_signup_amount;







									?>







									<tr>







										<td class="align_center invoice_table_data"><?php echo $i;?></td>







										<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td>







										<td class="align_center invoice_table_data"><?php echo MJ_gmgt_get_membership_name($membership_data->membership_id);?></td>







										<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($membership_data->membership_fees_amount,2); ?></td>







									</tr>







									<?php 







									if( $membership_signup_amounts  > 0) 







									{







										?>







										<tr class="">







											<td class="align_center invoice_table_data"><?php echo 2 ;?></td> 







											<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td> 







											<td class="align_center invoice_table_data"><?php esc_html_e('Membership Signup Fee','gym_mgt');?></td>								







											<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($membership_data->membership_signup_amount,2); ?></td>







										</tr>







										<?php







									}







								}







								if(!empty($selling_data))







								{







									$all_entry=json_decode($selling_data->entry);







									if(!empty($all_entry))







									{







										foreach($all_entry as $entry)







										{







											$obj_product=new MJ_gmgt_product;







											$product = $obj_product->MJ_gmgt_get_single_product($entry->entry);







										







											$product_name=$product->product_name;					







											$quentity=$entry->quentity;	







											$price=$product->price;	















											?>







											<tr class="">										







												<td class="align_center invoice_table_data"><?php echo $i;?></td> 







												<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>







												<td class="align_center invoice_table_data"><?php echo $product_name;?> </td>







												<td  class="align_center invoice_table_data"> <?php echo $quentity; ?></td>







												<td class="align_center invoice_table_data"><?php echo MJ_gmgt_get_floting_value($price); ?></td>







												<td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($quentity * $price,2); ?></td>







											</tr>







											<?php







											$id+=1;







											$i+=1;







										}







									}







									else







									{







										$obj_product=new MJ_gmgt_product;







										$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 







										







										$product_name=$product->product_name;					







										$quentity=$selling_data->quentity;	







										$price=$product->price;	







										?>







										<tr class="">										







											<td class="align_center invoice_table_data"><?php echo $i;?></td> 







											<td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>







											<td class="align_center invoice_table_data"><?php echo $product_name;?> </td>







											<td  class="align_center invoice_table_data"> <?php echo $quentity; ?></td>







											<td class="align_center invoice_table_data"> <?php echo $price; ?></td>







											<td class="align_center invoice_table_data"> <?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($quentity * $price,2); ?></td>







										</tr>







										<?php







										$id+=1;







										$i+=1;







									}







								}







								?>







							</tbody>







						</table>







					</div>







					<div class="table-responsive rtl_padding-left_40px rtl_float_left_width_100px">







						<?php 







						if(!empty($membership_data))







						{



							if(!empty($membership_data->tax_id)){



								$tax_name = MJ_gmgt_tax_name_by_tax_id_array_for_invoice(esc_html($membership_data->tax_id));



							}



							else{



								$tax_name = '';



							}



						   



							if(!empty($membership_data->coupon_id)){



								$obj_coupon=new MJ_gmgt_coupon;



								$result = $obj_coupon->MJ_gmgt_get_single_coupondata($membership_data->coupon_id);



								if($result->discount_type =="amount"){



									$discount_name = MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$result->discount;



								}



								else{



									$discount_name = $result->discount.''.$result->discount_type;



								}



							}



							else{



								$discount_name = '';



							}







							$discount_amount = $membership_data->discount_amount;







							$total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;







							$total_tax=$membership_data->tax_amount;							







							$paid_amount=$membership_data->paid_amount;







							$due_amount=abs($membership_data->membership_amount - $paid_amount);







							$grand_total=$membership_data->membership_amount;							







						}







						if(!empty($expense_data))







						{







							$grand_total=$total_amount;



							$discount_name = '';



							$tax_name = "";



						}







						if(!empty($selling_data))







						{







							$all_entry=json_decode($selling_data->entry);







							$discount_name = '';



							$tax_name = "";



							if(!empty($all_entry))







							{







								$total_amount=$selling_data->amount;







								$discount_amount=$selling_data->discount;







								$total_discount_amount=$total_amount-$discount_amount;







								







								if($selling_data->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$selling_data->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$total_tax=0;







									$tax_array=explode(',',$selling_data->tax);

	

	

	

									foreach($tax_array as $tax)

	

	

	

									{

	

	

	

										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax);

	

	

	

															

	

	

	

										$tax_amount=$total_discount_amount * $tax_percentage / 100;

	

	

	

										

	

	

	

										$total_tax=$total_tax + $tax_amount;				

	

	

									}







								}







								







								$paid_amount=$selling_data->paid_amount;







								$due_amount=abs($selling_data->total_amount - $paid_amount);







								$grand_total=$selling_data->total_amount;







							}







							else







							{	







								$obj_product=new MJ_gmgt_product;







								$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id);







								$price=$product->price;	







								







								$total_amount=$price*$selling_data->quentity;







								$discount_amount=$selling_data->discount;







								$total_discount_amount=$total_amount-$discount_amount;







								







								if($selling_data->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$selling_data->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$tax_per=$selling_data->tax;







									$total_tax=$total_discount_amount * $tax_per/100;







								}







																







								$paid_amount=$total_amount;







								$due_amount='0';







								$grand_total=$total_amount;								







							}		







						}							







						?>







						<div class="row width_100 col-md-12 col-sm-12 col-lg-12">







							<div class="col-md-7 col-sm-7 col-lg-7 col-xs-12" style="width:50%">







								<h3 class="display_name " style ="text-transform:uppercase;"><?php esc_attr_e('Payment Method','gym_mgt');?></h3>







								<table width="100%" border="0">







									<tbody>							







										<tr style="">







											<td class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Bank Name','gym_mgt');?></td>







											<td style="word-break: break-all;" class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_name' );?></td>







										</tr>







										<tr style="">







											<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Account No.','gym_mgt');?></td>







											<td style="word-break: break-all;" class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_acount_number' );?></td>







										</tr>







										<tr style="">







											<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('IFSC Code','gym_mgt');?></td>







											<td style="word-break: break-all;" class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_ifsc_code' );?></td>







										</tr>







										<tr style="">







											<td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Paypal ID','gym_mgt');?></td>







											<td style="word-break: break-all;" class="rtl_width_15px padding_bottom_15px total_value paypal_width">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_paypal_email' );?></td>







										</tr>







									</tbody>







								</table>







							</div>







							<div class="col-md-5 col-sm-5 col-lg-5 col-xs-12" style="width:50%">







								<table width="90%" border="0">







									<tbody>							







										<tr style="">







											<td  align="right" class="rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Sub Total :','gym_mgt');?></td>







											<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_amount,2);?></td>







										</tr>







										<?php







										if($_REQUEST['invoice_type']!='expense')







										{



											



											?>



											



											<tr>







												<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php echo esc_attr__('Discount Amount','gym_mgt').'('.$discount_name.')'.' :';?></td>







												<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo "-";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php if(!empty($discount_amount)){ echo number_format($discount_amount,2);}else{ echo number_format('0',2);} ?></td>







											</tr>







											<tr>







												<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php echo esc_attr__('Tax Amount','gym_mgt').'('.$tax_name.')'.'  :';?></td>







												<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo "+";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_tax,2); ?></td>







											</tr>







											<tr>







												<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Due Amount :','gym_mgt');?></td>







												<?php if(!empty($fees_detail_result->total_amount)){ $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; } ?>







												<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($due_amount,2); ?></td>







											</tr>







											<tr>







												<td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Paid Amount :','gym_mgt');?></td>







												<td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($paid_amount,2); ?></td>







											</tr>	







											<?php







										}	







										?>		







									</tbody>







								</table>







							</div>







						</div>







					</div>







					<div class="rtl_float_left row margin_top_10px_res col-md-4 col-sm-4 col-xs-4 view_invoice_lable_css inovice_width_100px_rs float_left grand_total_div invoice_table_grand_total" style="float: right;margin-right:30px;width:50%;">







						<div style="width:50%;" class="width_50_res align_right col-md-8 col-sm-8 col-xs-8 view_invoice_lable padding_11 padding_right_0_left_0 float_left grand_total_label_div invoice_model_height line_height_1_5 padding_left_0_px"><h3 style="float: right;" class="padding color_white margin invoice_total_label"><?php esc_html_e('Grand Total','gym_mgt');?> </h3></div>







						<div style="width:50%;" class="width_50_res align_right col-md-4 col-sm-4 col-xs-4 view_invoice_lable  padding_right_5_left_5 padding_11 float_left grand_total_amount_div"><h3 style="float: right;" class="padding margin text-right color_white invoice_total_value"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($grand_total,2); ?></h3></div>







					</div>







					<?php				







					if(!empty($history_detail_result))







					{







						?>







						<hr class="width_100 flot_left_invoice_history_hr">







						<table class="width_100">	







							<tbody>	







								<tr>







									<td>







										<h3  class="display_name"><?php esc_html_e('Payment History','gym_mgt');?></h3>







									</td>	







								</tr>	







							</tbody>







						</table>







						<div class="table-responsive rtl_padding-left_40px table_max_height_250px" style="padding-right:30px;">







							<table class="table model_invoice_table">







								<thead class="entry_heading invoice_model_entry_heading">







									<tr>







										<th class="entry_table_heading align_left" style ="text-transform:uppercase; !important"><?php esc_attr_e('Date','gym_mgt');?></th>







										<th class="entry_table_heading align_left" style ="text-transform:uppercase; !important"> <?php esc_html_e('Amount','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>







										<th class="entry_table_heading align_left" style ="text-transform:uppercase; !important"><?php esc_attr_e('Method','gym_mgt');?> </th>







										<th class="entry_table_heading align_left" style ="text-transform:uppercase; !important"><?php esc_html_e('Payment Details','gym_mgt');?></th>







									</tr>







								</thead>







								<tbody>







									<?php 







									foreach($history_detail_result as  $retrive_data)







									{







										?>







										<tr>







											<td class="align_left invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($retrive_data->paid_by_date);?></td>







											<td class="align_left invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".MJ_gmgt_get_floting_value($retrive_data->amount); ?></td>







											<td class="align_left invoice_table_data"><?php echo  esc_html__($retrive_data->payment_method,"gym_mgt"); ?></td>







											<td class="align_left invoice_table_data"><?php if(!empty($retrive_data->payment_description)){ echo  $retrive_data->payment_description; }else{ echo 'N/A'; }?></td>







										</tr>







										<?php 







									} ?>







								</tbody>







							</table>







						</div>







						<?php







					}







					?>







				</div>







			</div>







		</div>







	</div>







	<?php







	die();







}











// invoice pdf FUNCTION



function MJ_gmgt_invoice_pdf($id,$type)







{







	$obj_payment= new MJ_gmgt_payment();







	if($type=='membership_invoice')







	{		







		$obj_membership_payment=new MJ_gmgt_membership_payment;	







		$membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($id);







		$history_detail_result = MJ_gmgt_get_payment_history_by_mpid($id);		







	}







	if($type=='income')







	{







		$income_data=$obj_payment->MJ_gmgt_get_income_data($id);







		$history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($id);







	}







	{







	if($type=='expense')







		$expense_data=$obj_payment->MJ_gmgt_get_income_data($id);







	}







	if($type=='sell_invoice')







	{







		$obj_store=new MJ_gmgt_store;







		$selling_data=$obj_store->MJ_gmgt_get_single_selling($id);







		$history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($id);







	}



   wp_enqueue_style( 'bootstrap_min-css', plugins_url( '/assets/css/bootstrap_min.css', __FILE__) );







   wp_enqueue_script('bootstrap_min-js', plugins_url( '/assets/js/bootstrap_min.js', __FILE__ ) );















	ob_clean();







	header('Content-type: application/pdf');







	header('Content-Disposition: inline; filename="invoice.pdf"');







	header('Content-Transfer-Encoding: binary');







	header('Accept-Ranges: bytes');	







	







	require_once GMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';







	$stylesheet = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/custom.css'); // Get css content







	$stylesheet1 = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content







	







    if (is_rtl())







    {	







    	$mpdf = new \Mpdf\Mpdf;







    	$mpdf->SetDirectionality('rtl');







		$stylesheet2 = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/custom_rtl.css'); // Get css content







		







		$mpdf->autoScriptToLang = true;







	    $mpdf->autoLangToFont = true;







    }







	else







	{







		$mpdf = new Mpdf\Mpdf;







	  







		$mpdf->autoScriptToLang = true;







	    $mpdf->autoLangToFont = true;







	}







	







	if (is_rtl())







	{







		$mpdf->WriteHTML('<html dir="rtl">');







	}







	else







	{







		$mpdf->WriteHTML('<html>');







	}







	$mpdf->WriteHTML('<head>');







	$mpdf->WriteHTML('<style></style>');







	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf







	$mpdf->WriteHTML($stylesheet1,1); // Writing style to pdf







	







	$mpdf->WriteHTML('</head>');







	$mpdf->WriteHTML('<body>');		







	$mpdf->SetTitle('Income Invoice');







		$mpdf->WriteHTML('<div class="modal-header">');







		$mpdf->WriteHTML('<h4 class="modal-title">'.get_option('gmgt_system_name').'</h4>');







		$mpdf->WriteHTML('</div>');







		$mpdf->WriteHTML('<div id="invoice_print">');







			if (is_rtl())







			{







				$mpdf->WriteHTML('<img class="rtl_main_top_full_img rtl1" src="'.plugins_url('/gym-management/assets/images/invoice-.jpg').'">');







			}







			else







			{







				$mpdf->WriteHTML('<img class="invoicefont1 rtl_invoice_img" src="'.plugins_url('/gym-management/assets/images/invoice.jpg').'">');







			}







			$mpdf->WriteHTML('<div class="main_div">');	







					







					if (is_rtl())







					{







						$mpdf->WriteHTML('<table class="width_100_print rtl_invoice_header rtl_pdf_view_invoice_header position_absolute" border="0">');







							$mpdf->WriteHTML('<tbody class="rtl_pdf_view_table_address">');







								$mpdf->WriteHTML('<tr>');







									$mpdf->WriteHTML('<td class="width_1_print rtl_width_1_print padding_top_110">');







										$mpdf->WriteHTML('<img class="system_logo padding_left_15" src="'.get_option( 'gmgt_system_logo' ).'">');







									$mpdf->WriteHTML('</td>');							







									$mpdf->WriteHTML('<td class="only_width_20_print rtl_only_width_20_print pd_tp_address padding_top_110" >');								







										$mpdf->WriteHTML(''.esc_html__('A','gym_mgt').'. '.chunk_split(get_option('gmgt_gym_address'),30).'<br>'); 







										 $mpdf->WriteHTML(''.esc_html__('E','gym_mgt').'. '.get_option( 'gmgt_email' ).'<br>'); 







										 $mpdf->WriteHTML(''.esc_html__('P','gym_mgt').'. '.get_option( 'gmgt_contact_number' ).'<br>'); 







									$mpdf->WriteHTML('</td>');







									$mpdf->WriteHTML('<td align="right" class="width_24">');







									$mpdf->WriteHTML('</td>');







								$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('</tbody>');







						$mpdf->WriteHTML('</table>');







						







							$mpdf->WriteHTML('<table>');







					 $mpdf->WriteHTML('<tr>');







						$mpdf->WriteHTML('<td>');







						







							$mpdf->WriteHTML('<table class="width_50_print"  border="0">');







								$mpdf->WriteHTML('<tbody>');				







								$mpdf->WriteHTML('<tr>');







									$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center" >');								







										$mpdf->WriteHTML('<h3 class="billed_to_lable"> | '.esc_html__('Bill To','gym_mgt').'. </h3>');







									$mpdf->WriteHTML('</td>');







									$mpdf->WriteHTML('<td class="width_40_print" >');								







									







										if(!empty($expense_data))







										{







										  $mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($expense_data->supplier_name),30,"<BR>").'</h3>'); 







										}







										else







										{







											if(!empty($income_data))







												$member_id=$income_data->supplier_name;







											 if(!empty($membership_data))







												$member_id=$membership_data->member_id;







											 if(!empty($selling_data))







												$member_id=$selling_data->member_id;







											$patient=get_userdata($member_id);







											







											$mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>").'</h3>'); 







											 $address=get_user_meta( $member_id,'address',true);									







											 $mpdf->WriteHTML(''.chunk_split($address,30,"<BR>").''); 







											  $mpdf->WriteHTML(''.get_user_meta( $member_id,'city_name',true ).','); 







											 $mpdf->WriteHTML(''.get_user_meta( $member_id,'zip_code',true ).'<br>'); 







											 $mpdf->WriteHTML(''.get_user_meta( $member_id,'mobile',true ).'<br>'); 







										}







											







									 $mpdf->WriteHTML('</td>');







								 $mpdf->WriteHTML('</tr>');									







							 $mpdf->WriteHTML('</tbody>');







						 $mpdf->WriteHTML('</table>');	















						$mpdf->WriteHTML('</td>');







						$mpdf->WriteHTML('<td>');







				







							   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');







								 $mpdf->WriteHTML('<tbody>');				







									 $mpdf->WriteHTML('<tr>');	







										 $mpdf->WriteHTML('<td class="width_30_print">');







										 $mpdf->WriteHTML('</td>');







										 $mpdf->WriteHTML('<td class="width_20_print invoice_lable padding_right_30 padding_top_30" align="left">');







											







											$issue_date='DD-MM-YYYY';







											if(!empty($income_data))







											{







												$issue_date=$income_data->invoice_date;







												$payment_status=$income_data->payment_status;







												$invoice_no=$income_data->invoice_no;







											}







											if(!empty($membership_data))







											{







												$issue_date=$membership_data->created_date;







												$payment_status=$membership_data->payment_status;







												$invoice_no=$membership_data->invoice_no;									







											}







											if(!empty($expense_data))







											{







												$issue_date=$expense_data->invoice_date;







												$payment_status=$expense_data->payment_status;







												$invoice_no=$expense_data->invoice_no;







											}







											if(!empty($selling_data))







											{







												$issue_date=$selling_data->sell_date;									







												if(!empty($selling_data->payment_status))







												{







													$payment_status=$selling_data->payment_status;







												}	







												else







												{







													$payment_status='Fully Paid';







												}	







												$invoice_no=$selling_data->invoice_no;







											} 







											







											if($type!='expense')







											{								







												$mpdf->WriteHTML('<h3>'.esc_html__('INVOICE','gym_mgt').' <br> #'.$invoice_no.'</h3>');										







											}																			







										 $mpdf->WriteHTML('</td>');							







									 $mpdf->WriteHTML('</tr>');







									 $mpdf->WriteHTML('<tr>');	







										 $mpdf->WriteHTML('<td class="width_30_print">');







										 $mpdf->WriteHTML('</td>');







										 $mpdf->WriteHTML('<td class="width_20_print padding_right_30" align="left">');







											$mpdf->WriteHTML('<h5>'.esc_html__('Date','gym_mgt').' : '.MJ_gmgt_getdate_in_input_box($issue_date).'</h5>');







										$mpdf->WriteHTML('<br><h5>'.esc_html__('Status','gym_mgt').' : '.esc_html__(''.$payment_status.'','gym_mgt').'</h5>');											







										 $mpdf->WriteHTML('</td>');							







									 $mpdf->WriteHTML('</tr>');						







								 $mpdf->WriteHTML('</tbody>');







							 $mpdf->WriteHTML('</table>');	







							$mpdf->WriteHTML('</td>');







						  $mpdf->WriteHTML('</tr>');







						$mpdf->WriteHTML('</table>');	







					}







					else







					{







						$mpdf->WriteHTML('<table class="width_100_print rtl_invoice_header pos_top_100" border="0">');					







							$mpdf->WriteHTML('<tbody>');







								$mpdf->WriteHTML('<tr>');







									$mpdf->WriteHTML('<td class="width_1_print rtl_width_1_print">');







										$mpdf->WriteHTML('<img class="system_logo padding_left_15" src="'.get_option('gmgt_system_logo').'">');







									$mpdf->WriteHTML('</td>');							







									$mpdf->WriteHTML('<td class="only_width_20_print rtl_only_width_20_print">');								







										$mpdf->WriteHTML(''.esc_html__('A','gym_mgt').'. '.chunk_split(get_option('gmgt_gym_address'),30).'<br>'); 







										 $mpdf->WriteHTML(''.esc_html__('E','gym_mgt').'. '.get_option( 'gmgt_email' ).'<br>'); 







										 $mpdf->WriteHTML(''.esc_html__('P','gym_mgt').'. '.get_option( 'gmgt_contact_number' ).'<br>'); 







									$mpdf->WriteHTML('</td>');







									$mpdf->WriteHTML('<td align="right" class="width_24">');







									$mpdf->WriteHTML('</td>');







								$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('</tbody>');







						$mpdf->WriteHTML('</table>');







						







						







						$mpdf->WriteHTML('<table>');







					    $mpdf->WriteHTML('<tr>');







						$mpdf->WriteHTML('<td>');







						







							$mpdf->WriteHTML('<table class="width_50_print"  border="0">');







								$mpdf->WriteHTML('<tbody>');				







								$mpdf->WriteHTML('<tr>');







									$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center">');								







										$mpdf->WriteHTML('<h3 class="billed_to_lable"> | '.esc_html__('Bill To','gym_mgt').'. </h3>');







									$mpdf->WriteHTML('</td>');







									$mpdf->WriteHTML('<td class="width_40_print">');								







									







										if(!empty($expense_data))







										{







										  $mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($expense_data->supplier_name),30,"<BR>").'</h3>'); 







										}







										else







										{







											if(!empty($income_data))







												$member_id=$income_data->supplier_name;







											 if(!empty($membership_data))







												$member_id=$membership_data->member_id;







											 if(!empty($selling_data))







												$member_id=$selling_data->member_id;







											$patient=get_userdata($member_id);







											







											$mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>").'</h3>'); 







											 $address=get_user_meta( $member_id,'address',true);									







											 $mpdf->WriteHTML(''.chunk_split($address,30,"<BR>").''); 







											  $mpdf->WriteHTML(''.get_user_meta( $member_id,'city_name',true ).','); 







											 $mpdf->WriteHTML(''.get_user_meta( $member_id,'zip_code',true ).'<br>'); 







											 $mpdf->WriteHTML(''.get_user_meta( $member_id,'mobile',true ).'<br>'); 







										}







											







									 $mpdf->WriteHTML('</td>');







								 $mpdf->WriteHTML('</tr>');									







							 $mpdf->WriteHTML('</tbody>');







						 $mpdf->WriteHTML('</table>');







						 







						 $mpdf->WriteHTML('</td>');







						$mpdf->WriteHTML('<td>');







				







							   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');







								 $mpdf->WriteHTML('<tbody>');				







									 $mpdf->WriteHTML('<tr>');	







										 $mpdf->WriteHTML('<td class="width_30_print">');







										 $mpdf->WriteHTML('</td>');







										 $mpdf->WriteHTML('<td class="width_20_print invoice_lable padding_right_30" align="left">');







											







											$issue_date='DD-MM-YYYY';







											if(!empty($income_data))







											{







												$issue_date=$income_data->invoice_date;







												$payment_status=$income_data->payment_status;







												$invoice_no=$income_data->invoice_no;







											}







											if(!empty($membership_data))







											{







												$issue_date=$membership_data->created_date;







												$payment_status=$membership_data->payment_status;







												$invoice_no=$membership_data->invoice_no;									







											}







											if(!empty($expense_data))







											{







												$issue_date=$expense_data->invoice_date;







												$payment_status=$expense_data->payment_status;







												$invoice_no=$expense_data->invoice_no;







											}







											if(!empty($selling_data))







											{







												$issue_date=$selling_data->sell_date;									







												if(!empty($selling_data->payment_status))







												{







													$payment_status=$selling_data->payment_status;







												}	







												else







												{







													$payment_status='Fully Paid';







												}	







												$invoice_no=$selling_data->invoice_no;







											} 







											







											if($type!='expense')







											{								







												$mpdf->WriteHTML('<h3>'.esc_html__('INVOICE','gym_mgt').' <br> #'.$invoice_no.'</h3>');										







											}																			







										 $mpdf->WriteHTML('</td>');							







									 $mpdf->WriteHTML('</tr>');







									 $mpdf->WriteHTML('<tr>');	







										 $mpdf->WriteHTML('<td class="width_30_print">');







										 $mpdf->WriteHTML('</td>');







										 $mpdf->WriteHTML('<td class="width_20_print padding_right_30" align="left">');







											$mpdf->WriteHTML('<h5>'.esc_html__('Date','gym_mgt').' : '.MJ_gmgt_getdate_in_input_box($issue_date).'</h5>');







										$mpdf->WriteHTML('<br><h5>'.esc_html__('Status','gym_mgt').' : '.esc_html__(''.$payment_status.'','gym_mgt').'</h5>');											







										 $mpdf->WriteHTML('</td>');							







									 $mpdf->WriteHTML('</tr>');						







								 $mpdf->WriteHTML('</tbody>');







							 $mpdf->WriteHTML('</table>');	







							$mpdf->WriteHTML('</td>');







						  $mpdf->WriteHTML('</tr>');







						$mpdf->WriteHTML('</table>');







						







					}







					







				if($type=='membership_invoice')







				{	







					$mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Membership Entries','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');				







					







				}		







				elseif($type=='income')







				{ 







					$mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Income Entries','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');







				







				}







				elseif($type=='sell_invoice')







				{ 







				  $mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Sale Product','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');







				  







				}







				else







				{ 







					$mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Expense Entries','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');	







				}		  







					







				$mpdf->WriteHTML('<table class="table table-bordered" class="width_93" border="1">');







					$mpdf->WriteHTML('<thead>');







						







						if($type=='membership_invoice')







						{						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('DATE','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_left" style ="text-transform:uppercase; !important">'.esc_html__('Membership Name','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_right" style ="text-transform:uppercase; !important">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');								







							$mpdf->WriteHTML('</tr>');







						}







						elseif($type=='sell_invoice')







						{  







						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('DATE','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.esc_html__('PRODUCT NAME','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.esc_html__('QUANTITY','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.esc_html__('PRICE','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.esc_html__('TOTAL','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');







								







							$mpdf->WriteHTML('</tr>');







						







						} 







						else







						{ 						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('DATE','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.esc_html__('ENTRY','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');								







							$mpdf->WriteHTML('</tr>');







						}	







						







					$mpdf->WriteHTML('</thead>');







					$mpdf->WriteHTML('<tbody>');







						







							$id=1;







							$i=1;







							$total_amount=0;







						if(!empty($income_data) || !empty($expense_data))







						{







							if(!empty($expense_data))







								$income_data=$expense_data;







						







							$member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);







							







							foreach($member_income as $result_income)







							{







								$income_entries=json_decode($result_income->entry);







								$discount_amount=$result_income->discount;







								$paid_amount=$result_income->paid_amount;







								$total_discount_amount= $result_income->amount - $discount_amount;								







				               







								if($result_income->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$result_income->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$total_tax=$total_discount_amount * $result_income->tax/100;







								}







								$due_amount=0;







								$due_amount=$result_income->total_amount - $result_income->paid_amount;







								$grand_total=$total_discount_amount + $total_tax;







								







							   foreach($income_entries as $each_entry)







							   {







									$total_amount+=$each_entry->amount;







									







									$mpdf->WriteHTML('<tr class="entry_list">');







										$mpdf->WriteHTML('<td class="align_center">'.$id.'</td>');







										$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($result_income->invoice_date).'</td>');







										$mpdf->WriteHTML('<td >'.$each_entry->entry.'</td>');







										$mpdf->WriteHTML('<td class="align_right">'.number_format($each_entry->amount,2).'</td>');







									$mpdf->WriteHTML('</tr>');







									 $id+=1;







									$i+=1;







								}







								if($grand_total=='0')									







								{







									if($income_data->payment_status=='Paid')







									{







										







										$grand_total=$total_amount;







										$paid_amount=$total_amount;







										$due_amount=0;										







									}







									else







									{







										







										$grand_total=$total_amount;







										$paid_amount=0;







										$due_amount=$total_amount;															







									}







								}







							}







						}







						







						if(!empty($membership_data))







						{







						







							$membership_signup_amounts=$membership_data->membership_signup_amount;







							







							$mpdf->WriteHTML('<tr class="entry_list">');







								$mpdf->WriteHTML('<td class="align_center">'.$i.'</td>'); 







								$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($membership_data->created_date).'</td>'); 







								$mpdf->WriteHTML('<td>'.MJ_gmgt_get_membership_name($membership_data->membership_id).'</td>');								







								$mpdf->WriteHTML('<td class="align_right">'.number_format($membership_data->membership_fees_amount,2).'</td>');







							$mpdf->WriteHTML('</tr>');







							







							if( $membership_signup_amounts  > 0) 







							{







                                $mpdf->WriteHTML('<tr class="entry_list">');







								$mpdf->WriteHTML('<td class="align_center">2</td>'); 







								$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($membership_data->created_date).'</td>'); 







								$mpdf->WriteHTML('<td>Membership Signup Fee</td>');								







								$mpdf->WriteHTML('<td class="align_right">'.number_format($membership_data->membership_signup_amount,2).'</td>');







							$mpdf->WriteHTML('</tr>');







							







							}







						}







						if(!empty($selling_data))







						{







								







							$all_entry=json_decode($selling_data->entry);







							







							if(!empty($all_entry))







							{







								foreach($all_entry as $entry)







								{







									$obj_product=new MJ_gmgt_product;







									$product = $obj_product->MJ_gmgt_get_single_product($entry->entry);







									







									$product_name=$product->product_name;					







									$quentity=$entry->quentity;	







									$price=$product->price;	







									







									







									$mpdf->WriteHTML('<tr class="entry_list">');										







										$mpdf->WriteHTML('<td class="align_center">'.$i.'</td> ');







										$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($selling_data->sell_date).'</td>');







										$mpdf->WriteHTML('<td>'.$product_name.'</td>');







										$mpdf->WriteHTML('<td>'.$quentity.'</td>');







										$mpdf->WriteHTML('<td><span>'.$price.'</td>');







										$mpdf->WriteHTML('<td class="align_right">'.number_format($quentity * $price,2).'</td>');







										







									$mpdf->WriteHTML('</tr>');		







								$id+=1;







								$i+=1;									







								}







							}







							else







							{







								$obj_product=new MJ_gmgt_product;







								$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 







								







								$product_name=$product->product_name;					







								$quentity=$selling_data->quentity;	







								$price=$product->price;	







								







								$mpdf->WriteHTML('<tr class="entry_list">');										







									$mpdf->WriteHTML('<td class="align_center">'.$i.'</td> ');







									$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($selling_data->sell_date).'</td>');







									$mpdf->WriteHTML('<td>'.$product_name.'</td>');







									$mpdf->WriteHTML('<td>'.$quentity.'</td>');







									$mpdf->WriteHTML('<td>'.$price.'</td>');







									$mpdf->WriteHTML('<td class="align_right">'.number_format($quentity * $price,2).'</td>');







									







								$mpdf->WriteHTML('</tr>');	







								







								$id+=1;







								$i+=1;







							}	







						}







										







					$mpdf->WriteHTML('</tbody>');







				$mpdf->WriteHTML('</table>');







				







				$mpdf->WriteHTML('<table>');







				 $mpdf->WriteHTML('<tr>');







				 $mpdf->WriteHTML('<td>');







					  $mpdf->WriteHTML('<table class="width_46_print" border="0">');







						$mpdf->WriteHTML('<tbody>');						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td colspan="2" class="padding_left_15">');







									$mpdf->WriteHTML('<h3 class="payment_method_lable" style ="text-transform:uppercase;">'.esc_html__('Payment Method','gym_mgt').'');







								$mpdf->WriteHTML('</h3>');







								$mpdf->WriteHTML('</td>');								







							$mpdf->WriteHTML('</tr>');							







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td  class="width_311 font_12 padding_left_15">'.esc_html__('Bank Name','gym_mgt').' </td>');







								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_name' ).'</td>');







							$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_311 font_12 padding_left_15">'.esc_html__('Account No','gym_mgt').'</td>');







								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_acount_number' ).'</td>');







							$mpdf->WriteHTML('</tr>');						







						$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_311 font_12 padding_left_15">'.esc_html__('IFSC Code','gym_mgt').' </td>');







								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_ifsc_code' ).'</td>');







							$mpdf->WriteHTML('</tr>');						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_311 font_12 padding_left_15">'.esc_html__('Paypal Id','gym_mgt').' </td>');







								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_paypal_email' ).'</td>');







							$mpdf->WriteHTML('</tr>');







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>'); 







					$mpdf->WriteHTML('</td>');







					$mpdf->WriteHTML('<td>');







					$mpdf->WriteHTML('<table class="width_54_print"  border="0">');







					$mpdf->WriteHTML('<tbody>');







						







						if(!empty($membership_data))







						{							







							$total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;







							$total_tax=$membership_data->tax_amount;	







							$paid_amount=$membership_data->paid_amount;







							$due_amount=abs($membership_data->membership_amount - $paid_amount);







							$grand_total=$membership_data->membership_amount;







							







						}







						if(!empty($expense_data))







						{







							$grand_total=$total_amount;







						} 







						if(!empty($selling_data))







						{







							$all_entry=json_decode($selling_data->entry);







							







							if(!empty($all_entry))







							{







								$total_amount=$selling_data->amount;







								$discount_amount=$selling_data->discount;







								$total_discount_amount=$total_amount-$discount_amount;







								







								if($selling_data->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$selling_data->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$tax_per=$selling_data->tax;







									$total_tax=$total_discount_amount * $tax_per/100;







								}







								







								$paid_amount=$selling_data->paid_amount;







								$due_amount=abs($selling_data->total_amount - $paid_amount);







								$grand_total=$selling_data->total_amount;







							}







							else







							{







								$obj_product=new MJ_gmgt_product;







								$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 							







								







								$price=$product->price;	







								







								$total_amount=$price*$selling_data->quentity;







								$discount_amount=$selling_data->discount;







								$total_discount_amount=$total_amount-$discount_amount;







								if($selling_data->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$selling_data->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$tax_per=$selling_data->tax;







									$total_tax=$total_discount_amount * $tax_per/100;







								}







								







								$paid_amount=$total_amount;







								$due_amount='0';







								$grand_total=$total_amount;







							}







							







						}		







						$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<h4><td  class="width_70 align_right"><h4 class="margin">'.esc_html__('Subtotal','gym_mgt').' :</h4></td>');







								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span>'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($total_amount,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>');







						if($type!='membership_invoice')







						{







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.esc_html__('Discount Amount','gym_mgt').' :</h4></td>');







								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >- '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($discount_amount,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>'); 







						}	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.esc_html__('Tax Amount','gym_mgt').'  :</h4></td>');







								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >+ '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($total_tax,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>');







						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.esc_html__('Due Amount','gym_mgt').'  :</h4></td>');







								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($due_amount,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.esc_html__('Paid Amount','gym_mgt').'  :</h4></td>');







								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($paid_amount,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('<tr>');							







								$mpdf->WriteHTML('<td  class="width_70 align_right grand_total_lable"><h3 class="color_white margin">'.esc_html__('Grand Total','gym_mgt').' :</h3></td>');







								$mpdf->WriteHTML('<td class="align_right grand_total_amount"><h3 class="color_white margin">  <span>'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($grand_total,2).'</h3></td>');







							$mpdf->WriteHTML('</tr>');







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');			







					$mpdf->WriteHTML('</td>');					







				  $mpdf->WriteHTML('</tr>');







				$mpdf->WriteHTML('</table>');







				







				if(!empty($history_detail_result))







				{







					$mpdf->WriteHTML('<hr>');					







					$mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Payment History','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');					







					$mpdf->WriteHTML('<table class="table table-bordered" class="width_93" border="1">');







					$mpdf->WriteHTML('<thead>');







						$mpdf->WriteHTML('<tr>');







							$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('DATE','gym_mgt').'</th>');







							$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');







							$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Method','gym_mgt').'</th>');







							$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Payment Details','gym_mgt').'</th>');







						$mpdf->WriteHTML('</tr>');







					$mpdf->WriteHTML('</thead>');







					$mpdf->WriteHTML('<tbody>');







						







						foreach($history_detail_result as  $retrive_data)







						{						







							$mpdf->WriteHTML('<tr>');







							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->paid_by_date.'</td>');







							$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_get_floting_value($retrive_data->amount).'</td>');







							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->payment_method.'</td>');







							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->payment_description.'</td>');







							$mpdf->WriteHTML('</tr>');







						}







					$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');







				}				







				$mpdf->WriteHTML('</div>');







			$mpdf->WriteHTML('</div>'); 







			$mpdf->WriteHTML('</body>'); 







			$mpdf->WriteHTML('</html>'); 







	







	$mpdf->Output();	







	ob_end_flush();







	unset($mpdf);	















}







//send mail for generated invoice FUNCTION  



function MJ_gmgt_send_invoice_generate_mail($emails,$subject,$message,$invoice_id,$type)







{	



	ob_start();







	//error_reporting(0);	







	$obj_payment= new MJ_gmgt_payment();







	if($type=='membership_invoice')







	{		



        



		$obj_membership_payment=new MJ_gmgt_membership_payment;	







		$membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($invoice_id);



		



		$history_detail_result = MJ_gmgt_get_payment_history_by_mpid($invoice_id);		







	}







	if($type=='income')







	{







		$income_data=$obj_payment->MJ_gmgt_get_income_data($invoice_id);







		$history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($invoice_id);







	}	







	if($type=='sell_invoice')







	{







		$obj_store=new MJ_gmgt_store;







		$selling_data=$obj_store->MJ_gmgt_get_single_selling($invoice_id);







		$history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($invoice_id);







	}







	/* echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap_min.css', __FILE__).'"></link>';















	echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap_min.js', __FILE__).'"></script>'; */















	wp_enqueue_style( 'bootstrap_min-css', plugins_url( '/assets/css/bootstrap_min.css', __FILE__) );







	wp_enqueue_script('bootstrap_min-js', plugins_url( '/assets/js/bootstrap_min.js', __FILE__ ) );







	







	header('Content-type: application/pdf');







	







	header('Content-Transfer-Encoding: binary');







	header('Accept-Ranges: bytes');	







	







	require_once GMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';







	







	$stylesheet = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/custom.css'); // Get css content







	$stylesheet1 = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content







	







	$mpdf = new Mpdf\Mpdf; 







	$mpdf->autoScriptToLang = true;







     $mpdf->autoLangToFont = true;







	$mpdf->WriteHTML('<html>');







	$mpdf->WriteHTML('<head>');







	$mpdf->WriteHTML('<style></style>');







	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf







	$mpdf->WriteHTML($stylesheet1,1); // Writing style to pdf







	$mpdf->WriteHTML('</head>');







	$mpdf->WriteHTML('<body>');		







	$mpdf->SetTitle('Income Invoice');	







		$mpdf->WriteHTML('<div class="modal-header">');







			$mpdf->WriteHTML('<h4 class="modal-title">'.get_option('gmgt_system_name').'</h4>');







		$mpdf->WriteHTML('</div>');







		$mpdf->WriteHTML('<div id="invoice_print">');		







			$mpdf->WriteHTML('<img class="invoicefont1" src="'.plugins_url('/gym-management/assets/images/invoice.png').'" width="100%">');







			$mpdf->WriteHTML('<div class="main_div">');	







	







					$mpdf->WriteHTML('<table class="width_100_print padding_top_80px" border="0">');					







					$mpdf->WriteHTML('<tbody>');







						$mpdf->WriteHTML('<tr>');







							$mpdf->WriteHTML('<td class="width_1_print">');







								$mpdf->WriteHTML('<img class="system_logo padding_left_15 " style="height:54px;width:54px;border-radius:15px;" src="'.get_option( 'gmgt_gym_other_data_logo' ).'">');







							$mpdf->WriteHTML('</td>');							







							$mpdf->WriteHTML('<td class="only_width_20_print">');								







							$mpdf->WriteHTML('<h4 class="popup_label_heading">Address</h4>'); 







							$mpdf->WriteHTML(chunk_split(get_option( 'gmgt_gym_address' ),30,"<BR>").'<br>'); 







							$mpdf->WriteHTML('<h4 class="popup_label_heading">Email</h4>'); 







							$mpdf->WriteHTML(get_option( 'gmgt_email' )."<BR>".'<br>'); 







							$mpdf->WriteHTML('<h4 class="popup_label_heading">Phone</h4>'); 







							$mpdf->WriteHTML(get_option( 'gmgt_contact_number' ).'<br>'); 







							// $mpdf->WriteHTML('Address. '.chunk_split(get_option( 'gmgt_gym_address' ),30,"<BR>").'<br>'); 







							// $mpdf->WriteHTML('Email. '.get_option( 'gmgt_email' ).'<br>'); 







							// $mpdf->WriteHTML('Phone. '.get_option( 'gmgt_contact_number' ).'<br>'); 







							$mpdf->WriteHTML('</td>');







							$mpdf->WriteHTML('<td align="right" class="width_24">');







							$mpdf->WriteHTML('</td>');







						$mpdf->WriteHTML('</tr>');







					$mpdf->WriteHTML('</tbody>');







				$mpdf->WriteHTML('</table>');







				







				$mpdf->WriteHTML('<table>');







			 $mpdf->WriteHTML('<tr>');







				$mpdf->WriteHTML('<td>');







				







					$mpdf->WriteHTML('<table class="width_50_print"  border="0">');







						$mpdf->WriteHTML('<tbody>');				







						$mpdf->WriteHTML('<tr>');







							$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center">');								







								$mpdf->WriteHTML('<h3 class="billed_to_lable">'.esc_html__('Bill To','gym_mgt').'. </h3>');







							$mpdf->WriteHTML('</td>');







							$mpdf->WriteHTML('<td class="width_40_print">');								







							







								if(!empty($expense_data))







								{







								  $mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($expense_data->supplier_name),30,"<BR>").'</h3>'); 







								}







								else







								{







									if(!empty($income_data))







										$member_id=$income_data->supplier_name;







									 if(!empty($membership_data))







										$member_id=$membership_data->member_id;







									 if(!empty($selling_data))







										$member_id=$selling_data->member_id;







									$patient=get_userdata($member_id);







									







									$mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>").'</h3>'); 







									$address=get_user_meta( $member_id,'address',true);									



									$city_name=get_user_meta( $member_id,'city_name',true );									



									$zip_code=get_user_meta( $member_id,'zip_code',true );									



									$mobile=get_user_meta( $member_id,'mobile',true );									



									if(!empty($address))



									{



										$mpdf->WriteHTML(''.chunk_split($address,30,"<BR>").''); 



									}



									if(!empty($city_name))



									{



									  $mpdf->WriteHTML(''.$city_name.','); 



									}



									if(!empty($zip_code))



									{



									 $mpdf->WriteHTML(''.$zip_code.'<br>'); 



									}



									if(!empty($mobile))



									{



									 $mpdf->WriteHTML(''.$mobile.'<br>');



									} 











								}







									







							 $mpdf->WriteHTML('</td>');







						 $mpdf->WriteHTML('</tr>');									







					 $mpdf->WriteHTML('</tbody>');







				 $mpdf->WriteHTML('</table>');







				







				$mpdf->WriteHTML('</td>');







				$mpdf->WriteHTML('<td>');







				







				   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');







					 $mpdf->WriteHTML('<tbody>');				







						 $mpdf->WriteHTML('<tr>');	







							 $mpdf->WriteHTML('<td class="width_30_print">');







							 $mpdf->WriteHTML('</td>');







							 $mpdf->WriteHTML('<td class="width_20_print invoice_lable padding_right_50" align="left">');







								







								$issue_date='DD-MM-YYYY';







								if(!empty($income_data))







								{







									$issue_date=$income_data->invoice_date;







									$payment_status=$income_data->payment_status;







									$invoice_no=$income_data->invoice_no;







								}







								if(!empty($membership_data))







								{







									$issue_date=$membership_data->created_date;







									if($membership_data->payment_status!='0')







									{	







										$payment_status=$membership_data->payment_status;







									}







									else







									{







										$payment_status='Unpaid';







									}		







									$invoice_no=$membership_data->invoice_no;									







								}







								if(!empty($expense_data))







								{







									$issue_date=$expense_data->invoice_date;







									$payment_status=$expense_data->payment_status;







									$invoice_no=$expense_data->invoice_no;







								}







								if(!empty($selling_data))







								{







									$issue_date=$selling_data->sell_date;									







									$payment_status=$selling_data->payment_status;







									$invoice_no=$selling_data->invoice_no;







								} 







								







								if($type!='expense')







								{								







									$mpdf->WriteHTML('<h3>'.esc_html__('INVOICE','gym_mgt').' <br> #'.$invoice_no.'</h3>');										







								}																			







							 $mpdf->WriteHTML('</td>');							







						 $mpdf->WriteHTML('</tr>');







						 $mpdf->WriteHTML('<tr>');	







							 $mpdf->WriteHTML('<td class="width_30_print">');







							 $mpdf->WriteHTML('</td>');







							 $mpdf->WriteHTML('<td class="width_20_print padding_right_30" align="left">');







								$mpdf->WriteHTML('<h5>'.esc_html__('Date','gym_mgt').' : '.MJ_gmgt_getdate_in_input_box($issue_date).'</h5>&nbsp;');







							$mpdf->WriteHTML('<h5>'.esc_html__('Status','gym_mgt').' : '.esc_html__(''.$payment_status.'','gym_mgt').'</h5>');											







							 $mpdf->WriteHTML('</td>');							







						 $mpdf->WriteHTML('</tr>');						







					 $mpdf->WriteHTML('</tbody>');







				 $mpdf->WriteHTML('</table>');	







				$mpdf->WriteHTML('</td>');







			  $mpdf->WriteHTML('</tr>');







			$mpdf->WriteHTML('</table>');







				if($type=='membership_invoice')







				{	







					$mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Membership Entries','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');				







					







				}		







				elseif($type=='income')







				{ 







					$mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Income Entries','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');







				







				}







				elseif($type=='sell_invoice')







				{ 







				  $mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Sells Product','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');







				  







				}







				else







				{ 







					$mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Expense Entries','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');	







				}		  







					







				$mpdf->WriteHTML('<table class="table table-bordered" class="width_93" border="1">');







					$mpdf->WriteHTML('<thead>');







						







						if($type=='membership_invoice')







						{						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<th class=" entry_heading align_center">#</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('DATE','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_left" style ="text-transform:uppercase; !important">'.esc_html__('Membership Name','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_right" style ="text-transform:uppercase; !important">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');								







							$mpdf->WriteHTML('</tr>');







						}







						elseif($type=='sell_invoice')







						{  







						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<th class=" entry_heading align_center">#</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_center">'.esc_html__('DATE','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_left">'.esc_html__('PRODUCT NAME','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_left">'.esc_html__('QUANTITY','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_left">'.esc_html__('PRICE','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_right">'.esc_html__('TOTAL','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');







								







							$mpdf->WriteHTML('</tr>');







						







						} 







						else







						{ 						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<th class=" entry_heading align_center">#</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_center">'.esc_html__('DATE','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_left">'.esc_html__('ENTRY','gym_mgt').'</th>');







								$mpdf->WriteHTML('<th class=" entry_heading align_right">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');								







							$mpdf->WriteHTML('</tr>');







						}	







						







					$mpdf->WriteHTML('</thead>');







					$mpdf->WriteHTML('<tbody>');







						







							$id=1;







							$i=1;







							$total_amount=0;







						if(!empty($income_data) || !empty($expense_data))







						{







							if(!empty($expense_data))







								$income_data=$expense_data;







						







							$member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);







							







							foreach($member_income as $result_income)







							{







								$income_entries=json_decode($result_income->entry);







								$discount_amount=$result_income->discount;







								$paid_amount=$result_income->paid_amount;







								$total_discount_amount= $result_income->amount - $discount_amount;								







				               







								if($result_income->tax_id!='')







								{									







									$total_tax=0;







									$tax_array=explode(',',$result_income->tax_id);







									foreach($tax_array as $tax_id)







									{







										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







															







										$tax_amount=$total_discount_amount * $tax_percentage / 100;







										







										$total_tax=$total_tax + $tax_amount;				







									}







								}







								else







								{







									$total_tax=$total_discount_amount * $result_income->tax/100;







								}







								







								$due_amount=0;







								$due_amount=$result_income->total_amount - $result_income->paid_amount;







								$grand_total=$total_discount_amount + $total_tax;







								







							   foreach($income_entries as $each_entry)







							   {







									$total_amount+=$each_entry->amount;







									







									$mpdf->WriteHTML('<tr class="entry_list">');







										$mpdf->WriteHTML('<td class="align_center">'.$id.'</td>');







										$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($result_income->invoice_date).'</td>');







										$mpdf->WriteHTML('<td >'.$each_entry->entry.'</td>');







										$mpdf->WriteHTML('<td class="align_right">'.number_format($each_entry->amount,2).'</td>');







									$mpdf->WriteHTML('</tr>');







								







									$id++;







									$i++;







								}







							}







						}







						







						if(!empty($membership_data))







						{







							







							$membership_signup_amounts=$membership_data->membership_signup_amount;







							







							$mpdf->WriteHTML('<tr class="entry_list">');







								$mpdf->WriteHTML('<td class="align_center">'.$i.'</td>'); 







								$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($membership_data->created_date).'</td>'); 







								$mpdf->WriteHTML('<td>'.MJ_gmgt_get_membership_name($membership_data->membership_id).'</td>');								







								$mpdf->WriteHTML('<td class="align_right">'.number_format($membership_data->membership_fees_amount,2).'</td>');







							$mpdf->WriteHTML('</tr>');







							// sign up entry //







							if( $membership_signup_amounts  > 0) 







							{







								$mpdf->WriteHTML('<tr class="entry_list">');







								$mpdf->WriteHTML('<td class="align_center">2</td>'); 







								$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($membership_data->created_date).'</td>'); 







								$mpdf->WriteHTML('<td>'.MJ_gmgt_get_membership_name($membership_data->membership_id).'</td>');								







								$mpdf->WriteHTML('<td class="align_right">'.number_format($membership_data->membership_signup_amount,2).'</td>');







							$mpdf->WriteHTML('</tr>');







							







							}







						}







						if(!empty($selling_data))







						{







								







							$all_entry=json_decode($selling_data->entry);







							







							if(!empty($all_entry))







							{







								foreach($all_entry as $entry)







								{







									$obj_product=new MJ_gmgt_product;







									$product = $obj_product->MJ_gmgt_get_single_product($entry->entry);







									







									$product_name=$product->product_name;					







									$quentity=$entry->quentity;	







									$price=$product->price;	







									







									







									$mpdf->WriteHTML('<tr class="entry_list">');										







										$mpdf->WriteHTML('<td class="align_center">'.$i.'</td> ');







										$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($selling_data->sell_date).'</td>');







										$mpdf->WriteHTML('<td>'.$product_name.'</td>');







										$mpdf->WriteHTML('<td>'.$quentity.'</td>');







										$mpdf->WriteHTML('<td>'.$price.'</td>');







										$mpdf->WriteHTML('<td class="align_right">'.number_format($quentity * $price,2).'</td>');







										







									$mpdf->WriteHTML('</tr>');								







								}







							}	







						}







										







					$mpdf->WriteHTML('</tbody>');







				$mpdf->WriteHTML('</table>');







				







				$mpdf->WriteHTML('<table>');







				 $mpdf->WriteHTML('<tr>');







				 $mpdf->WriteHTML('<td>');







					  $mpdf->WriteHTML('<table border="0">');







						$mpdf->WriteHTML('<tbody>');						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td colspan="2" class="padding_left_15">');







									$mpdf->WriteHTML('<h3 class="payment_method_lable" style ="text-transform:uppercase;">'.esc_html__('Payment Method','gym_mgt').'');







								$mpdf->WriteHTML('</h3>');







								$mpdf->WriteHTML('</td>');								







							$mpdf->WriteHTML('</tr>');							







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td  class="width_311 font_12 padding_left_15 pdf_label">'.esc_html__('Bank Name ','gym_mgt').' </td>');







								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_name' ).'</td>');







							$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_311 font_12 padding_left_15 pdf_label">'.esc_html__('Account No ','gym_mgt').'</td>');







								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_acount_number' ).'</td>');







							$mpdf->WriteHTML('</tr>');						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_311 font_12 padding_left_15 pdf_label">'.esc_html__('IFSC Code ','gym_mgt').' </td>');







								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_ifsc_code' ).'</td>');







							$mpdf->WriteHTML('</tr>');						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_311 font_12 padding_left_15 pdf_label">'.esc_html__('Paypal Id ','gym_mgt').' </td>');







								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_paypal_email' ).'</td>');







							$mpdf->WriteHTML('</tr>');







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>'); 







					$mpdf->WriteHTML('</td>');







					$mpdf->WriteHTML('<td>');







					$mpdf->WriteHTML('<table class="width_54_print"  border="0">');







					$mpdf->WriteHTML('<tbody>');







						







						if(!empty($membership_data))







						{							







							$total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;







							$total_tax=$membership_data->tax_amount;	



                            $discount_amount=$membership_data->discount_amount;







							$paid_amount=$membership_data->paid_amount;







							$due_amount=abs($membership_data->membership_amount - $paid_amount);







							$grand_total=$membership_data->membership_amount;







							







						}







						if(!empty($expense_data))







						{







							$grand_total=$total_amount;







						} 







						if(!empty($selling_data))







						{







							$total_amount=$selling_data->amount;







							$discount_amount=$selling_data->discount;







							$total_discount_amount=$total_amount-$discount_amount;







							







							if($selling_data->tax_id!='')







							{									







								$total_tax=0;







								$tax_array=explode(',',$selling_data->tax_id);







								foreach($tax_array as $tax_id)







								{







									$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







														







									$tax_amount=$total_discount_amount * $tax_percentage / 100;







									







									$total_tax=$total_tax + $tax_amount;				







								}







							}







							else







							{







								$tax_per=$selling_data->tax;







								$total_tax=$total_discount_amount * $tax_per/100;







							}







							$paid_amount=$selling_data->paid_amount;







							$due_amount=abs($selling_data->total_amount - $paid_amount);







							$grand_total=$selling_data->total_amount;







						}		







						$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<h4><td  class="width_70 align_right pdf_label"><h4 class="margin">'.esc_html__('Subtotal :','gym_mgt').'</h4></td>');







								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span>'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($total_amount,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>');







						if(!empty($discount_amount)){







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_70 align_right pdf_label"><h4 class="margin">'.esc_html__('Discount Amount :','gym_mgt').' </h4></td>');







								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >- '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($discount_amount,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>'); 



						}







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_70 align_right pdf_label"><h4 class="margin">'.esc_html__('Tax Amount :','gym_mgt').' </h4></td>');







								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >+ '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($total_tax,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>');







						







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_70 align_right pdf_label"><h4 class="margin">'.esc_html__('Due Amount :','gym_mgt').' </h4></td>');







								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($due_amount,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="width_70 align_right pdf_label"><h4 class="margin">'.esc_html__('Paid Amount :','gym_mgt').' </h4></td>');







								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($paid_amount,2).'</h4></td>');







							$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('<tr>');							







								$mpdf->WriteHTML('<td  class="width_56 align_right grand_total_lable"><h3 class="color_white margin">'.esc_html__('Grand Total :','gym_mgt').' </h3></td>');







								$mpdf->WriteHTML('<td class="align_right grand_total_amount"><h3 class="color_white margin">  <span>'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($grand_total,2).'</h3></td>');







							$mpdf->WriteHTML('</tr>');







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');			







					$mpdf->WriteHTML('</td>');					







				  $mpdf->WriteHTML('</tr>');







				$mpdf->WriteHTML('</table>');	















				if(!empty($history_detail_result))







				{







					$mpdf->WriteHTML('<hr>');					







					$mpdf->WriteHTML('<table class="width_100_print">');	







						$mpdf->WriteHTML('<tbody>');	







							$mpdf->WriteHTML('<tr>');







								$mpdf->WriteHTML('<td class="padding_left_20">');







									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Payment History','gym_mgt').'</h3>');







								$mpdf->WriteHTML('</td>');	







							$mpdf->WriteHTML('</tr>');	







						$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');					







					$mpdf->WriteHTML('<table class="table table-bordered" class="width_93" border="1">');







					$mpdf->WriteHTML('<thead>');







						$mpdf->WriteHTML('<tr>');







							$mpdf->WriteHTML('<th class=" entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('DATE','gym_mgt').'</th>');







							$mpdf->WriteHTML('<th class=" entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');







							$mpdf->WriteHTML('<th class=" entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Method','gym_mgt').'</th>');







							$mpdf->WriteHTML('<th class=" entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Payment Details','gym_mgt').'</th>');







						$mpdf->WriteHTML('</tr>');







					$mpdf->WriteHTML('</thead>');







					$mpdf->WriteHTML('<tbody>');







						







						foreach($history_detail_result as  $retrive_data)







						{						



							if(!empty($retrive_data->payment_description)){



								$payment_description = $retrive_data->payment_description;



							}else{



								$payment_description = "N/A";



							}



							$mpdf->WriteHTML('<tr>');







							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->paid_by_date.'</td>');







							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->amount.'</td>');







							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->payment_method.'</td>');







							if(!empty($retrive_data->payment_description))



							{



								$mpdf->WriteHTML('<td class="align_center">'.$payment_description.'</td>');



							}



							else



							{



								$mpdf->WriteHTML('<td class="align_center">'.esc_html__('NA','gym_mgt').'</td>');



							}











							$mpdf->WriteHTML('</tr>');







						}







					$mpdf->WriteHTML('</tbody>');







					$mpdf->WriteHTML('</table>');







				}







				$mpdf->WriteHTML('</div>');







			$mpdf->WriteHTML('</div>'); 







			$mpdf->WriteHTML('</body>'); 







			$mpdf->WriteHTML('</html>'); 







	ob_clean();







	$mpdf->Output(WP_CONTENT_DIR . '/uploads/'.$invoice_id.'-'.$type.'.pdf','F');







	ob_end_flush();







	unset($mpdf);	







	$system_name=get_option('gmgt_system_name');







	







	$headers = "From: ".$system_name.' <noreplay@gmail.com>' . "\r\n";	







	







	$mail_attachment = array(WP_CONTENT_DIR . '/uploads/'.$invoice_id.'-'.$type.'.pdf');



	



	$enable_notofication=get_option('gym_enable_notifications');





    $mail_result='';

	if($enable_notofication=='yes')

	{







		$mail_result=wp_mail($emails,$subject,$message,$headers,$mail_attachment); 



		



	}



	return $mail_result;

}

//VIEW Nutrition FUNCTION







function MJ_gmgt_nutrition_schedule_view()







{	







	$obj_nutrition=new MJ_gmgt_nutrition;







	$result = $obj_nutrition->MJ_gmgt_get_single_nutrition($_REQUEST['nutrition_id']);







	 ?>







		<div class="form-group"> <a href="javascript:void(0);" class="close-btn badge badge-success pull-right">X</a>







		  	<h4 class="modal-title" id="myLargeModalLabel">







			<?php echo esc_html($result->day).' '. esc_html__('Nutrition Schedule','gym_mgt'); ?>







		  	</h4>







		</div>







		<hr>







		<div class="panel panel-white form-horizontal">







		  	<div class="form-group">







			<label class="col-sm-3" for="Breakfast"><strong>







			<?php esc_html_e(' Breakfast','gym_mgt');?></strong>







			: </label>







			<div class="col-sm-9"> <?php echo esc_html($result->breakfast);?> </div>







		  	</div>







		  	<div class="form-group">







			<label class="col-sm-3" for="notice_title"><strong>







			<?php esc_html_e('Midmorning Snack','gym_mgt');?></strong>







			: </label>







			<div class="col-sm-9"> <?php echo esc_html($result->midmorning_snack);?> </div>







		  	</div>







		  	<div class="form-group">







			<label class="col-sm-3" for="lunch"><strong>







			<?php esc_html_e('Lunch','gym_mgt');?></strong>







			: </label>







			<div class="col-sm-9"> <?php echo esc_html($result->lunch);?> </div>







		  	</div>







		  	<div class="form-group">







			<label class="col-sm-3" for="afternoon_snack"><strong>







			<?php esc_html_e('Afternoon Snack','gym_mgt');?></strong>







			: </label>







			<div class="col-sm-9"> <?php echo esc_html($result->afternoon_snack);?> </div>







		  	</div>







		   	<div class="form-group">







			<label class="col-sm-3" for="dinner"><strong>







			<?php esc_html_e('Dinner','gym_mgt');?></strong>







			: </label>







			<div class="col-sm-9"> <?php echo esc_html($result->dinner);?> </div>







		  	</div>







		   	<div class="form-group">







			<label class="col-sm-3" for="afterdinner_snack"><strong>







			<?php esc_html_e('Afterdinner Snack','gym_mgt');?></strong>







			: </label>







			<div class="col-sm-9"> <?php echo esc_html($result->afterdinner_snack);?> </div>







		  	</div>







		  	<div class="form-group">







			<label class="col-sm-3" for="afterdinner_snack"><strong>







			<?php esc_html_e('Afterdinner Snack','gym_mgt');?></strong>







			: </label>







			<div class="col-sm-9"> <?php echo esc_html($result->start_date);?> </div>







		  	</div>







		  	<div class="form-group">







			<label class="col-sm-3" for="afterdinner_snack"><strong>







			<?php esc_html_e('Afterdinner Snack','gym_mgt');?></strong>







			: </label>







			<div class="col-sm-9"> <?php echo esc_html($result->expire_date);?> </div>







		  	</div>







			<?php 







			die();







}







//VIEW DETAILS POPUP FUNCTION







function MJ_gmgt_view_details_popup()







{	







	$recoed_id = $_REQUEST['record_id'];



	$type= $_REQUEST['type'];

	

	if($type == 'view_group')







	{ 







		$allmembers =MJ_gmgt_get_groupmember($recoed_id);







		?>







		<div class="form-group gmgt_pop_heder_p_20"> 	







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







			<h4 class="modal-title" id="myLargeModalLabel">







				<?php echo  esc_html__('Group Member','gym_mgt'); ?>







			</h4>







		</div>







		







		<div class="panel-body">







			<div class="slimScrollDiv">







				<div class="inbox-widget slimscroll">







					<?php 







					if(!empty($allmembers))







					foreach ($allmembers as $retrieved_data)







					{







						?>







						<div class="inbox-item">







							<?php







							$curr_user_id=get_current_user_id();







							$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);







							if($obj_gym->role == 'member' || $obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')







							{







								$member='member';







								$member=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($member);







								if($member['own_data'] == 1)







								{







									$redirct_link = "?dashboard=user&page=member&tab=viewmember&action=view&member_id=".esc_attr($retrieved_data->member_id)."";







								}







								else







								{







									$redirct_link = "?dashboard=user&page=member&tab=viewmember&action=view&member_id=".esc_attr($retrieved_data->member_id)."";







								}







							}







							else







							{







								$redirct_link = "?page=gmgt_member&tab=viewmember&action=view&member_id=".esc_attr($retrieved_data->member_id)."";







							}







							?>







							<a href="<?php echo $redirct_link; ?>">







								<div class="inbox-item-img margin_right_25">







								<?php 







								$uid=$retrieved_data->member_id;







								$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);







								if(empty($userimage))







								{







									echo '<img src='.get_option( 'gmgt_member_logo' ).' height="50px" width="50px" class="img-circle" />';







								}







								else







								{







									echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';	







								}







								?>







								</div>







								<p class="inbox-item-author margin_left_5"><?php echo MJ_gmgt_get_display_name(esc_html($retrieved_data->member_id));?></p>







							</a>







						</div>







					<?php







					}







					else 







					{







						?>







						<p><?php esc_html_e('No members yet','gym_mgt');?></p>







						<?php







					}







					?>				







				</div>







			</div>







		</div>







	<?php 







	}







	elseif($type == 'view_membership')







	{ 







		$obj_membership=new MJ_gmgt_membership;







		$membership_data = $obj_membership->MJ_gmgt_get_single_membership($recoed_id);	







		?>







		<div class="form-group gmgt_pop_heder_p_20"> 	







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







			<h4 class="modal-title res_pop_modal_title_font_22px" id="myLargeModalLabel">







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Membership.png"?>">







				<?php echo esc_html__('Membership Details','gym_mgt'); ?>







			</h4>







		</div>















		<div class="modal-body view_details_body_assigned_bed view_details_body">







			<div class="row">







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Membership Name','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($membership_data->membership_label); ?></label>







				</div>















				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Membership Category','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php if(!empty($membership_data->membership_cat_id)){ echo get_the_title(esc_html($membership_data->membership_cat_id)); }else{ echo "N/A"; } ?></label>







				</div>















				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Membership Period(Days)','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($membership_data->membership_length_id); ?></label>







				</div>















				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Members Limit','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php 







							if($membership_data->membership_class_limit!='unlimited')







							{







								echo esc_html($membership_data->on_of_member);







							}







							else







							{







								esc_html_e('Unlimited','gym_mgt');







							}







						?>







					</label>







				</div>















				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Class Limit','gym_mgt');?></label><br>







					<label for="" class="label_value">







						<?php 







							if($membership_data->classis_limit!='unlimited')







							{







								echo esc_html($membership_data->on_of_classis);







							}







							else







							{







								esc_html_e('Unlimited','gym_mgt');







							}				







						?>				







					</label>







				</div>















				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Membership Amount','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($membership_data->membership_amount); ?></label>







				</div>























				<div class="col-md-6 popup_padding_15px">















					<label for="" class="popup_label_heading"><?php esc_html_e('Installment Plan','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($membership_data->installment_amount)." ".get_the_title( esc_html($membership_data->install_plan_id) );?></label>







				







				</div>







				<div class="col-md-6 popup_padding_15px">















					<label for="" class="popup_label_heading"><?php esc_html_e('Signup Fee','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($membership_data->signup_fee); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Tax','gym_mgt');?>(%) </label><br>







					<label for="" class="label_value">







						<?php 



						if(!empty($membership_data->tax))







						{







							echo MJ_gmgt_tax_name_by_tax_id_array(esc_html($membership_data->tax)); 







						}







						else







						{







							echo "N/A";







						}







						







						?>







					</label>







				</div>







				<div class="col-md-6 popup_padding_15px">















					<label for="" class="popup_label_heading"><?php esc_html_e('Membership Description','gym_mgt');?></label><br>







					<label for="" class="label_value">







						<?php 







						if(!empty($membership_data->membership_description))







						{







							echo stripslashes($membership_data->membership_description);







						}







						else







						{







							echo "N/A";







						}







						?>







					</label>







				</div>







			</div>







		</div>  	







	<?php 







	}



	// VIEW COUPON POPUP



	elseif($type == 'view_coupon')



	{



		$obj_coupon=new MJ_gmgt_coupon;



		$coupondata = $obj_coupon->MJ_gmgt_get_single_coupondata($recoed_id);



		$coupon_time_used = MJ_gmgt_coupon_usage_count($coupondata->id);



		//var_dump($coupon_time_used);



		?>



		<div class="form-group gmgt_pop_heder_p_20"> 	







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







			<h4 class="modal-title res_pop_modal_title_font_22px" id="myLargeModalLabel">







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Membership.png"?>">







				<?php echo esc_html__('Coupon Details','gym_mgt'); ?>







			</h4>







		</div>



		



		<div class="modal-body view_details_body_assigned_bed view_details_body">







			<div class="row">



			



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Code','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($coupondata->code); ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Coupon For','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php if($coupondata->coupon_type == "all_member"){echo esc_html_e('All Member','gym_mgt');}else{ esc_html_e($coupondata->coupon_type,'gym_mgt');} ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Member Name','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php if(!empty($coupondata->member_id)){ echo MJ_gmgt_get_member_full_display_name_with_memberid($coupondata->member_id);}else{ esc_html_e('All Member','gym_mgt');} ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Recurring Type','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php esc_html_e($coupondata->recurring_type,'gym_mgt'); ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Membership','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php if($coupondata->membership == "all_membership"){echo esc_html_e('All Membership','gym_mgt');;}else{ echo MJ_gmgt_get_membership_name($coupondata->membership);} ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Discount','gym_mgt');?></label><br>







					<label for="" class="label_value">



						<?php



							if($coupondata->discount_type =="amount"){



								echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$coupondata->discount;



							}



							else{



								echo $coupondata->discount.''.$coupondata->discount_type;



							}



						?>



					</label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('No. Of Time','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($coupondata->time); ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('No. Of Time Used','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($coupon_time_used); ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('From Date','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_getdate_in_input_box($coupondata->from_date); ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('End Date','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_getdate_in_input_box($coupondata->end_date); ?></label>







				</div>



				



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Published','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html_e($coupondata->published,'gym_mgt'); ?></label>







				</div>



			



			</div>



			



		</div>



		



		<?php



	}







	elseif($type == 'view_class')







	{ 







		$obj_class=new MJ_gmgt_classschedule;







		







		$class_data = $obj_class->MJ_gmgt_get_single_class($recoed_id);







		?>







		<div class="gmgt_pop_heder_p_20"> 	







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







			<h4 class="modal-title" id="myLargeModalLabel">







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Class Schedule.png"?>">







				<?php echo  esc_html__('Class Details','gym_mgt'); ?>







			</h4>







		</div>		







		<div class="modal-body view_details_body_assigned_bed view_details_body">







			<div class="row">















				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Class Name','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($class_data->class_name); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Staff Member','gym_mgt');?></label><br>







					<label for="" class="label_value">







						<?php 







							$userdata=get_userdata( $class_data->staff_id );







							echo esc_html($userdata->display_name);







						?>







					</label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Start Date','gym_mgt');?> <?php esc_html_e('To','gym_mgt');?> <?php esc_html_e('End Date','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($class_data->start_date));?>  <?php esc_html_e('To','gym_mgt');?> <?php echo MJ_gmgt_getdate_in_input_box(esc_html($class_data->end_date));?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Day','gym_mgt');?></label><br>







					<label for="" class="label_value">







						<?php 







						$days_array=json_decode($class_data->day); 







						$days_string=array();







						if(!empty($days_array))







						{







							foreach($days_array as $day)







							{







								







								$days_membership_list=substr($day,0,3);







								$days_string[]=__($days_membership_list,'gym_mgt'); 







								







							}







						}







						echo implode(", ",$days_string);







						?>







					</label>







				</div>







				<!-- <div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('End Date','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($class_data->end_date));?></label>







				</div> -->







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Start Time','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->start_time));?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('End Time','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->end_time));?></label>







				</div>







				







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Membership Name','gym_mgt');?></label><br>







					<label for="" class="label_value">







						<?php







							$membersdata=array();







							$membersdata = $obj_class->MJ_gmgt_get_class_members($recoed_id);







							if(!empty($membersdata))







							{	







								foreach($membersdata as $key=>$val)







								{







									$data[]= MJ_gmgt_get_membership_name($val->membership_id);







								}







							}	







							echo implode(',',$data); 







						?>







					</label>







				</div>		







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Member Limit','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($class_data->member_limit); ?></label>







				</div>







			</div>







		</div>  







		<?php 







	}







	elseif($type == 'view_product')







	{ 







		$obj_product=new MJ_gmgt_product;







		$product_data = $obj_product->MJ_gmgt_get_single_product($recoed_id);







	  







		?>







		<div class="gmgt_pop_heder_p_20"> 	







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







			<h4 class="modal-title" id="myLargeModalLabel">







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Product.png"?>">







				<?php echo  esc_html__('Product Details','gym_mgt'); ?>







			</h4>







		</div>		







		<div class="modal-body view_details_body_assigned_bed view_details_body">







			<div class="row">







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Name','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($product_data->product_name); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Category','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo get_the_title(esc_html($product_data->product_cat_id));?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Price','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($product_data->price); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Quantity','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($product_data->quentity); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('SKU Number','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php echo esc_html($product_data->sku_number);?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Manufacturer Company Name','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php if(!empty($product_data->manufacture_company_name)){ echo esc_html($product_data->manufacture_company_name);}else{ echo 'N/A'; } ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Manufacturer Date','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php if($product_data->manufacture_date == '0000-00-00' || $product_data->manufacture_date =='1970-01-01'){ echo 'N/A'; }else{ echo MJ_gmgt_getdate_in_input_box(esc_html($product_data->manufacture_date)); } ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Description','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php if(!empty($product_data->product_description)){ echo esc_html($product_data->product_description); }else{ echo "N/A"; } ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Specification','gym_mgt');?></label><br>







					<label for="" class="label_value"><?php if(!empty($product_data->product_specification)){ echo esc_html($product_data->product_specification); }else{ echo "N/A"; } ?></label>







				</div>







			</div>	







		</div>







		<?php 







	}







	elseif($type == 'view_notice')







	{ 		







		$notice_data = get_post($recoed_id);		







		?>







		<div class="gmgt_pop_heder_p_20"> 	







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







			<h4 class="modal-title" id="myLargeModalLabel">







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/notice.png"?>" style="height:35px!important;">







				<?php echo  esc_html__('Notice Details','gym_mgt'); ?>







			</h4>







		</div>







			







		<div class="modal-body view_details_body_assigned_bed view_details_body">







			<div class="row">







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Title','gym_mgt'); ?></label><br>







					<label for="" class="label_value"><?php echo esc_html($notice_data->post_title); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Notice For','gym_mgt'); ?></label><br>







					<label for="" class="label_value">







						<?php 







							echo MJ_gmgt_GetRoleName(get_post_meta( esc_html($notice_data->ID), 'notice_for',true)); 







						?>	







					</label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"> <?php esc_html_e( 'Start Date', 'gym_mgt' ) ;?></label><br>







					<label class="label_value"><?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($notice_data->ID),'gmgt_start_date',true)); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"> <?php esc_html_e( 'End Date', 'gym_mgt' ) ;?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($notice_data->ID),'gmgt_end_date',true)); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Class Name','gym_mgt'); ?></label><br>







					<label for="" class="label_value">







						<?php 







						if(get_post_meta( $notice_data->ID, 'gmgt_class_id',true) !="" && get_post_meta( $notice_data->ID, 'gmgt_class_id',true) =="all")







						{







							esc_html_e('All','gym_mgt');







						}







						elseif(get_post_meta( $notice_data->ID, 'gmgt_class_id',true) !="")







						{







							







							echo MJ_gmgt_get_class_name(get_post_meta( esc_html($notice_data->ID), 'gmgt_class_id',true));







						}







						else







						{







							echo 'N/A';







						} 







						?>







					</label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Document','gym_mgt'); ?></label><br>







					<label for="" class="label_value">







						<?php 







						if(!empty(get_post_meta($notice_data->ID,'gmgt_notice_document',true)))







						{?>







							<a href="<?php echo content_url().'/uploads/gym_assets/'.$notice_data->gmgt_notice_document;?>" class="gmgt_doc_border btn" target="_blank"><i class="fa fa-download"></i> <?php esc_html_e('Document','hospital_mgt');?></a>







							<?php 







						}







						else







						{







							echo "N/A";







						}







						?>







					</label>







				</div>







				<div class="col-md-12 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e('Comment','gym_mgt'); ?></label><br>







					<label for="" class="label_value">







						<?php 







						if(!empty($notice_data->post_content))







						{







							echo esc_html($notice_data->post_content);







						}







						else{







							echo "N/A";







						}







						?>







					</label>







				</div>







				







					







			</div>







		</div>	







		<?php 







	}







	elseif($type == 'view_class_booking')







	{ 







		$obj_class=new MJ_gmgt_classschedule;







		$bookingdata =$obj_class->MJ_gmgt_get_single_booked_class_($recoed_id);







		?>







		<div class="gmgt_pop_heder_p_20"> 	







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







			<h4 class="modal-title" id="myLargeModalLabel">







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Class Schedule.png"?>">







				<?php echo  esc_html__('Booking Details','gym_mgt'); ?>







			</h4>







		</div>		







		<div class="modal-body view_details_body_assigned_bed view_details_body">



			<div class="row">







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e( 'Member Name', 'gym_mgt' ) ;?></label><br>







					<label for="" class="label_value"><?php echo MJ_gmgt_get_display_name($bookingdata->member_id); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"> <?php esc_html_e( 'Class Name', 'gym_mgt' ) ;?></label><br>







					<label for="" class="label_value"><?php  $classname = $obj_class->MJ_gmgt_get_class_name(esc_html($bookingdata->class_id)); if(!empty($classname)){ echo $classname; }else{ echo "N/A"; }?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"> <?php esc_html_e( 'Class Date', 'gym_mgt' ) ;?></label><br>







					<label for="" class="label_value"><?php print str_replace('00:00:00',"",esc_html($bookingdata->class_booking_date));?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e( 'Booking Date', 'gym_mgt' ) ;?></label><br>







					<label for="" class="label_value"><?php print str_replace('00:00:00',"",esc_html($bookingdata->booking_date)); ?></label>







				</div>







				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e( 'Day', 'gym_mgt' ) ;?></label><br>







					<label for="" class="label_value">



						<?php 



						if($bookingdata->booking_day == "Sunday")







						{







							$booking_day=esc_html__('Sunday','gym_mgt');







						}







						elseif($bookingdata->booking_day == "Monday")







						{







							$booking_day=esc_html__('Monday','gym_mgt');







						}







						elseif($bookingdata->booking_day == "Tuesday")







						{







							$booking_day=esc_html__('Tuesday','gym_mgt');







						}







						elseif($bookingdata->booking_day == "Wednesday")







						{







							$booking_day=esc_html__('Wednesday','gym_mgt');







						}







						elseif($bookingdata->booking_day == "Thursday")







						{







							$booking_day=esc_html__('Thursday','gym_mgt');







						}







						elseif($bookingdata->booking_day == "Friday")







						{







							$booking_day=esc_html__('Friday','gym_mgt');







						}







						elseif($bookingdata->booking_day == "Saturday")







						{







							$booking_day=esc_html__('Saturday','gym_mgt');







						}







						echo esc_html($booking_day);



						?>



					</label>







				</div>







				<?php $class_data = $obj_class->MJ_gmgt_get_single_class($bookingdata->class_id); ?>



				<div class="col-md-6 popup_padding_15px">







					<label for="" class="popup_label_heading"><?php esc_html_e( 'Start Time To End Time', 'gym_mgt' ) ;?></label><br>







					<label for="" class="label_value"><?php if(!empty($class_data)){ echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->start_time)).' '.esc_html__(' To ','gym_mgt').' '.MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->end_time));}else{echo 'N/A';} ?></label>







				</div>







			</div>  	



		</div>  



		<?php 







	}



	die();







}







//MEASUREMENT DELETE FUNCTION







function MJ_gmgt_measurement_delete()







{







	$obj_workout = new MJ_gmgt_workout();







	$measurement_id = $_REQUEST['measurement_id'];







	$measurement_data = $obj_workout->MJ_gmgt_get_measurement_deleteby_id($measurement_id);







	die();







}















// MEMBRSHIP LOAD END DATE FUNTION 







function MJ_gmgt_load_enddate()







{







$date = trim($_POST['start_date']);







$new_date = DateTime::createFromFormat(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), $date); 







$joiningdate=$new_date->format('Y-m-d');















$membership_id = $_POST['membership_id'];







$obj_membership=new MJ_gmgt_membership;	







$membership=$obj_membership->MJ_gmgt_get_single_membership($membership_id);







$validity=$membership->membership_length_id;







$expiredate= date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), strtotime($joiningdate. ' + '.$validity.' days'));







echo $expiredate;







die();







}







/* RENEW & UPGRADE LOAD END DATE */



function MJ_gmgt_load_enddate_frontend()



{



	$date = trim($_POST['start_date']);







$new_date = DateTime::createFromFormat(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), $date); 







$joiningdate=$new_date->format('Y-m-d');















$membership_id = $_POST['membership_id'];







$obj_membership=new MJ_gmgt_membership;	







$membership=$obj_membership->MJ_gmgt_get_single_membership($membership_id);







$validity=$membership->membership_length_id;







$expiredate= date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), strtotime($joiningdate. ' + '.$validity.' days'));







echo $expiredate;







die();



}























//VIEW MEASUREMENT FUNCTION







function MJ_gmgt_measurement_view()







{







	$obj_workout = new MJ_gmgt_workout();







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);







	$user_id = $_REQUEST['user_id'];	







	$page_action = $_REQUEST['page_action'];















	$measurement_data = $obj_workout->MJ_gmgt_get_all_measurement_by_userid($user_id);







	//access right







	$page_name='workouts';







	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array($page_name);







	







	?>







	<div class="form-group"> 







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>	







		<h4 class="modal-title" id="myLargeModalLabel">







			<?php 







				$userimage=get_user_meta($user_id, 'gmgt_user_avatar', true);







				if(empty($userimage))







				{







					echo '<img src='.get_option( 'gmgt_measurement_thumb' ).' height="50px" width="50px" class="img-circle" />';







				}







				else







					echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/> '; 







				?>







				<div class="display_inline_left_10">







				<?php







				echo  MJ_gmgt_get_display_name($user_id).esc_html__('\'s Measurement','gym_mgt'); ?>







				</div>







		</h4>







	</div>







	<div class="panel-body">







		<div id="measurement_div"  class="alert updated below-h2 notice is-dismissible alert-dismissible display_none_m">







			<p><?php esc_html_e('Measurement deleted successfully.','gym_mgt');?></p>







			<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>







		</div>







		<div class="table-responsive box-scroll">



		<?php



		if(!empty($measurement_data))







		{



		?>



       		<table id="measurement_list" class="display table" cellspacing="0" width="100%">







	        	 <thead>







	            	<tr>						







						<th><?php  esc_html_e( 'Photo', 'gym_mgt' ) ;?></th>







						<th><?php  esc_html_e( 'Measurement', 'gym_mgt' ) ;?></th>







						<th><?php  esc_html_e( 'Result', 'gym_mgt' ) ;?></th>			







					    <th><?php  esc_html_e( 'Record Date', 'gym_mgt' ) ;?></th>







						<?php 







						if($page_action == 'web')







						{ 







							if($obj_gym->role=='administrator' || $user_access['edit']=='1' || $user_access['delete']=='1')







							{







								?>







								<th><?php  esc_html_e( 'Action', 'gym_mgt' ) ;?></th>	







								<?php







							}







						}







						?>







		            </tr>		            	 







		        </thead>







		        <tbody>







		        <?php 







		        	foreach ($measurement_data as $retrieved_data)







		        	{ ?>







			        <tr id="row_<?php echo esc_attr($retrieved_data->measurment_id)?>">







						<td class="user_image"><?php $userimage=$retrieved_data->gmgt_progress_image;







							if(empty($userimage)){







								echo '<img src='.get_option( 'gmgt_measurement_thumb' ).' height="50px" width="50px" class="meserment_img" />';







							}







							else







								echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';







						?>







						</td>







			        	<td class="recorddate vertical_align_middle"><?php 







						if($retrieved_data->result_measurment == "Weight")







						{







							$result_measurment = esc_html_e('Weight','gym_mgt');







						}







						elseif($retrieved_data->result_measurment == "Height")







						{







							$result_measurment = esc_html_e('Height','gym_mgt');







						}







						elseif($retrieved_data->result_measurment == "Waist")







						{







							$result_measurment = esc_html_e('Waist','gym_mgt');







						}







						elseif($retrieved_data->result_measurment == "Thigh")







						{







							$result_measurment = esc_html_e('Thigh','gym_mgt');







						}







						elseif($retrieved_data->result_measurment == "Arms")







						{







							$result_measurment = esc_html_e('Arms','gym_mgt');







						}







						elseif($retrieved_data->result_measurment == "Fat")







						{







							$result_measurment = esc_html_e('Fat','gym_mgt');







						}







						elseif($retrieved_data->result_measurment == "Chest")







						{







							$result_measurment = esc_html_e('Chest','gym_mgt');







						}







						







						echo esc_html($result_measurment);?></td>







						<td class="duration vertical_align_middle"><?php echo esc_html($retrieved_data->result)." ".MJ_gmgt_measurement_counts_lable_array(esc_html($retrieved_data->result_measurment));?></td>







						<td class="result vertical_align_middle"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->result_date));?></td>







						<?php







						if($page_action == 'web')







						{







							if($obj_gym->role=='administrator' || $user_access['edit']=='1' || $user_access['delete']=='1')







							{







								?>







								<td class="action result"> 







									<div class="gmgt-user-dropdown">







										<ul class="" style="margin-bottom: 0px !important;">







											<li class="">







												<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">







													<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >







												</a>







												<ul class="dropdown-menu heder-dropdown-menu action_dropdawn measurement_popup_action_dropdown" aria-labelledby="dropdownMenuLink">







													<?php 







													if($obj_gym->role=='administrator')







													{







														?>







														<li class="float_left_width_100 border_bottom_item">







															<a href="?page=gmgt_workout&tab=addmeasurement&action=edit&measurment_id=<?php echo esc_attr($retrieved_data->measurment_id)?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>







														</li>







														<li class="float_left_width_100">







															<a href="#" class="float_left_width_100 measurement_delete list_delete_btn" data-val="<?php echo $retrieved_data->measurment_id?>"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>







														</li>







														<?php







													}







													else







													{







														if($user_access['edit']=='1' && $page_action == 'web')







														{







															?>







															<li class="float_left_width_100 border_bottom_item">







																<a href="?dashboard=user&page=workouts&tab=addmeasurement&action=edit&measurment_id=<?php echo $retrieved_data->measurment_id?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>







															</li>







															<?php







														}







														if($user_access['delete']=='1' && $page_action == 'web')







														{







															?>







															<li class="float_left_width_100">







																<a href="#" class="float_left_width_100 measurement_delete list_delete_btn" data-val="<?php echo $retrieved_data->measurment_id?>"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>







															</li>







															<?php







														}







													}







													?>







												</ul>







											</li>







										</ul>







									</div>	







								</td>







								<?php







							}







						}







						?>







			        </tr>







					<?php 







					}







				



				







				?>







		        </tbody>







		        	







		        </table>



				<?php



			}







			else 







			{







				?>







				<div class="calendar-event-new"> 







					<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >







				</div>	







				<?php







			}







?>











		</div>







		<?php







		die(); 







}















//ADD WORKOUT FUNCTION







function MJ_gmgt_add_workout()







{	



	



	if(isset($_REQUEST['data_array']))







	{







		$data_array = $_REQUEST['data_array'];







		$data_value = json_encode($data_array);







		







		echo "<input type='hidden' value='".htmlspecialchars($data_value,ENT_QUOTES)."' name='activity_list[]'>";







	}







	die();







}







//ADD Nutrition FUNCTION







function MJ_gmgt_add_nutrition()







{







	if(isset($_REQUEST['data_array']))







	{		







		$data_array =$_REQUEST['data_array'];







	







		$data_value = json_encode($data_array);







	







		echo "<input type='hidden' value='".htmlspecialchars($data_value,ENT_QUOTES)."' name='nutrition_list[]'>";







	}







	die();







}







//DELETE WORKOUT FUNCTION 







function MJ_gmgt_delete_workout()







{







	$work_out_id = $_REQUEST['workout_id'];







	global $wpdb;







	$table_workout = $wpdb->prefix. 'gmgt_assign_workout';







	$table_workout_data = $wpdb->prefix. 'gmgt_workout_data';







	$result = $wpdb->query("DELETE FROM $table_workout_data where workout_id= ".$work_out_id);







	$result = $wpdb->query("DELETE FROM $table_workout where workout_id= ".$work_out_id);







	die();







}







//DELETE nutrition FUNCTION







function MJ_gmgt_delete_nutrition()







{







	$work_out_id = $_REQUEST['workout_id'];







	global $wpdb;







	$table_gmgt_nutrition = $wpdb->prefix. 'gmgt_nutrition';







	$table_gmgt_nutrition_data = $wpdb->prefix. 'gmgt_nutrition_data';







	$result = $wpdb->query("DELETE FROM $table_gmgt_nutrition_data where nutrition_id= ".$work_out_id);







	$result = $wpdb->query("DELETE FROM $table_gmgt_nutrition where id = ".$work_out_id);







	die();







}















//GET PAYMENT DETAILS BY MEMBERSHIP







function MJ_gmgt_paymentdetail_bymembership()



{



	$type = $_REQUEST['type'];



	$membership_id = $_POST['membership_id'];



	global $wpdb;



	$gmgt_membershiptype = $wpdb->prefix.'gmgt_membershiptype';



	$sql = "SELECT * From $gmgt_membershiptype where membership_id = $membership_id";



	$result = $wpdb->get_row($sql);



	$membership_amount=$result->membership_amount;



	$signup_fee=$result->signup_fee;



	$membership_tax_amount=0;



	$total_amount=0;



	// AT RENEW MEMBERSHIP for admi/staff//



	if($type == 'renew_membership')	



	{



		$membership_and_fees_amount=$membership_amount;



	}



	// AT RENEW MEMBERSHIP for member//



	elseif($type == 'renew_membership_upgrade')



	{



		$membership_tax_amount=MJ_gmgt_get_membership_tax_amount($membership_id,'renew_membership');



	    $total_amount=$membership_amount + $membership_tax_amount;



		$membership_and_fees_amount=$membership_amount;



	}



	else



	{



		$membership_and_fees_amount=$membership_amount+$signup_fee;



	}



	$total_membership_amount=$membership_and_fees_amount;







	$payment_detail = array();







	$payment_detail['title'] = $result->membership_label;







	$payment_detail['price'] = str_replace(',','',number_format($total_membership_amount,2));



	$payment_detail['tax_amount'] = str_replace(',','',number_format($membership_tax_amount,2));



	$payment_detail['total_amount'] = str_replace(',','',number_format($total_amount,2));



	echo json_encode($payment_detail);



	die();



}







//ADD PAYMENT POPUP FUNCTION







function MJ_gmgt_member_add_payment()







{ 



	?>







	







	<script type="text/javascript">







	$(document).ready(function() {







		"use strict";







		$('#expense_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	







	} );







	</script>







	<?php 







		$mp_id = $_POST['idtest'];







		$member_id= $_POST['member_id'];







		$due_amount = $_POST['due_amount'];







		$view_type = $_POST['view_type'];	







		







	?>







	<!-- <div class="modal-header">







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right">X</a>







			<h4 class="modal-title"><?php echo get_option('gmgt_system_name');?></h4>







	</div> -->







	<div class="form-group gmgt_pop_heder_p_20"> 	







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







		<h4 class="modal-title" id="myLargeModalLabel">







		<?php echo get_option('gmgt_system_name');?>







		<!-- <?php esc_html__(get_option('gmgt_system_name'),"gym_mgt");?> -->







		</h4>







	</div>















	<div class="modal-body view_details_body_assigned_bed view_details_body frontend_width_100_per">







		<form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">







        	<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>







			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">







			<input type="hidden" name="mp_id" value="<?php echo esc_attr($mp_id);?>">







			<input type="hidden" name="member_id" value="<?php echo esc_attr($member_id);?>">







			<input type="hidden" name="view_type" value="<?php echo esc_attr($view_type);?>">







			<input type="hidden" name="created_by" value="<?php echo get_current_user_id();?>">















			<div class="form-body user_form"> <!--form-Body div Strat-->   







				<div class="row"><!--Row Div--> 







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







						<div class="form-group input">







							<div class="col-md-12 form-control">







								<input id="amount" class="form-control validate[required] text-input" type="number" onkeypress="if(this.value.length==10) return false;" step="0.01" min="0" max="<?php echo esc_attr($due_amount) ?>" value="<?php echo esc_attr($due_amount) ?>" name="amount">







								<label class="active" for="amount"><?php esc_html_e('Paid Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>







							</div>







						</div>







					</div>







					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">







						<input type="hidden" name="payment_status" value="paid">







						<label class="ml-1 custom-top-label top" for="payment_method" style ="text-transform:uppercase;"><?php esc_html_e('Payment Method','gym_mgt');?><span class="require-field">*</span></label>







						<?php 







						global $current_user;







						$user_roles = $current_user->roles;







						$user_role = array_shift($user_roles);







						?>







						<select name="payment_method" id="payment_method" class="form-control">







							<?php 







							if($user_role != 'member')







							{ ?>







								<option value="Cash"><?php esc_html_e('Cash','gym_mgt');?></option>







								<option value="Cheque"><?php esc_html_e('Cheque','gym_mgt');?></option>







								<option value="Bank Transfer"><?php esc_html_e('Bank Transfer','gym_mgt');?></option>		







								<?php







							} 







							else 







							{					







								if(is_plugin_active('paymaster/paymaster.php') && get_option('gmgt_paymaster_pack')=="yes")







								{ 







									$payment_method = get_option('pm_payment_method');







									print '<option value="'.$payment_method.'">'.$payment_method.'</option>';







								} 







								else







								{







									$gym_recurring_enable=get_option("gym_recurring_enable");







									$gmgt_one_time_payment_setting=get_option("gmgt_one_time_payment_setting");







									if($gym_recurring_enable == "yes" || $gmgt_one_time_payment_setting == '1')







									{







										print '<option value="stripe_gym">Stripe</option>';







									}







									else







									{







										print '<option value="Paypal">Paypal</option>';







									}







								} 







							}







							?>						







						</select>







					</div>







					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 payment_description note_text_notice">







						<div class="form-group input">







							<div class="col-md-12 note_border margin_bottom_15px_res">







								<div class="form-field">







									<textarea name="payment_description" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="150"></textarea>					







									<span class="txt-title-label"></span>







									<label class="text-area address active" for=""><?php esc_html_e('Payment Details','gym_mgt');?></label>







								</div>







							</div>







						</div>







					</div>







				</div>







			</div>	







			<!----------   save btn    --------------> 







			<div class="form-body user_form"> <!-- user_form Strat-->   







				<div class="row"><!--Row Div Strat--> 







					<div class="col-md-6 col-sm-6 col-xs-12"> 	







						<input type="submit" value="<?php esc_html_e('Add Payment','gym_mgt');?>" name="add_fee_payment" class="btn save_btn"/>







					</div>







				</div><!--Row Div End--> 







			</div><!-- user_form End--> 







		</form>







	</div>







	<?php







	die();







}















//VIEW PAYMENT HISTORY







function MJ_gmgt_member_view_paymenthistory()







{







	$mp_id = $_REQUEST['idtest'];







	$fees_detail_result = MJ_gmgt_get_single_membership_payment_record($mp_id);







	$fees_history_detail_result = MJ_gmgt_get_payment_history_by_mpid($mp_id);



	$fees_detail_result = '';



	?>







	<div class="modal-header">







			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right">X</a>







			<h4 class="modal-title"><?php echo get_option('gmgt_system_name');?></h4>







	</div>







	<div class="modal-body">







	







	<div id="invoice_print"> 







		<table width="100%" border="0">







						<tbody>







							<tr>







								<td width="70%">







									<img class="max_height_80" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">







								</td>







								<td align="right" width="24%">







									<h5><?php $issue_date='DD-MM-YYYY';			







									$issue_date=$fees_detail_result->created_date;







									echo esc_html__('Issue Date','gym_mgt')." : ".MJ_gmgt_getdate_in_input_box($issue_date);?></h5>







									







						<h5><?php echo esc_html__('Status','gym_mgt')." : "; echo "<span class='btn btn-success btn-xs'>";







					echo MJ_gmgt_get_membership_paymentstatus($fees_detail_result->mp_id);







					echo "</span>";?></h5>







								</td>







							</tr>







						</tbody>







					</table>







					<hr>







					<table width="100%" border="0">







						<tbody>







							<tr>







								<td align="left">







									<h4><?php esc_html_e('Payment To','gym_mgt');?> </h4>







								</td>







								<td align="right">







									<h4><?php esc_html_e('Bill To12','gym_mgt');?> </h4>







								</td>







							</tr>







							<tr>







								<td valign="top" align="left">







									<?php echo get_option( 'gmgt_system_name' )."<br>"; 







									 echo get_option( 'gmgt_gym_address' ).","; 







									 echo get_option( 'gmgt_contry' )."<br>"; 







									 echo get_option( 'gmgt_contact_number' )."<br>"; 







									?>







									







								</td>







								<td valign="top" align="right">







									<?php







									$member_id=$fees_detail_result->member_id;								







										







										$patient=get_userdata($member_id);







												







										echo MJ_gmgt_get_user_full_display_name(esc_html($member_id))."<br>"; 







										 echo get_user_meta( $member_id,'address',true ).","; 







										 echo get_user_meta( $member_id,'city_name',true ).","; 







										 echo get_user_meta( $member_id,'zip_code',true ).",<BR>"; 







										 echo get_user_meta( $member_id,'state_name',true ).","; 







										 echo get_option( 'gmgt_contry' ).","; 







										 echo get_user_meta( $member_id,'mobile',true )."<br>"; 







									







									?>







								</td>







							</tr>







						</tbody>







					</table>







					<hr>







					<table class="table table-bordered border_collapse" width="100%" border="1">







						<thead>







							<tr>







								<th class="text-center">#</th>







								<th class="text-center"> <?php esc_html_e('Membership Name','gym_mgt');?></th>







								<th><?php esc_html_e('Total','gym_mgt');?> </th>







								







							</tr>







						</thead>







						<tbody>







							<td>1</td>







							<td><?php echo MJ_gmgt_get_membership_name(esc_html($fees_detail_result->membership_id));?></td>







							<td><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($fees_detail_result->membership_amount);?></td>







						</tbody>







						</table>







						<table width="100%" border="0">







						<tbody>







							







							<tr>







								<td width="80%" align="right"><?php esc_html_e('Subtotal :','gym_mgt');?></td>







								<td align="right"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($fees_detail_result->membership_amount);?></td>







							</tr>







							<tr>







								<td width="80%" align="right"><?php esc_html_e('Payment Made :','gym_mgt');?></td>







								<td align="right"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_html($fees_detail_result->paid_amount);?></td>







							</tr>







							<tr>







								<td width="80%" align="right"><?php esc_html_e('Due Amount  :','gym_mgt');?></td>







								<td align="right"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php $dueamount=abs($fees_detail_result->membership_amount - $fees_detail_result->paid_amount); echo number_format($dueamount,2); ?></td>







							</tr>







						</tbody>







					</table>







					







					<?php if(!empty($fees_history_detail_result))







					{?>







					<hr class="width_100 flot_left_invoice_history_hr">







					<h4><?php esc_html_e('Payment History','gym_mgt');?></h4>







					<table class="table table-bordered border_collapse" width="100%" border="1">







					<thead>







							<tr>







								<th class="text-center"><?php esc_html_e('Date','gym_mgt');?></th>







								<th class="text-center"> <?php esc_html_e('Amount','gym_mgt');?> (<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</th>







								<th><?php esc_html_e('Method','gym_mgt');?> </th>







								







							</tr>







						</thead>







						<tbody>







							<?php 







							foreach($fees_history_detail_result as  $retrive_date)







							{







							?>







							<tr>







							<td><?php echo MJ_gmgt_getdate_in_input_box($retrive_date->paid_by_date);?></td>







							<td><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo esc_attr($retrive_date->amount);?></td>







							<td><?php echo esc_attr($retrive_date->payment_method);?></td>







							</tr>







							<?php }?>







						</tbody>







					</table>







					<?php }?>







				</div>







			</div>







		<?php







	die();







}







//CHECK MEMBERRSHIP FUNCTION







function MJ_gmgt_check_membership($userid)







{







	$validity=0;







	$obj_membership=new MJ_gmgt_membership;







	$membershipid=get_user_meta($userid,'membership_id',true);







	if(!empty($membershipid))







	{







		$membershistatus=get_user_meta($userid,'membership_status',true);







	







		$joiningdate=get_user_meta($userid,'begin_date',true);







		$autorenew=get_user_meta($userid,'auto_renew',true);







		$membership=$obj_membership->MJ_gmgt_get_single_membership($membershipid);







		if(!empty($membership))







			$validity=$membership->membership_length_id;







		$expiredate="";







		$today = date("Y-m-d");







		 $expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));







		if($membershistatus!="Dropped")







		{







			if($today <= $expiredate)







			{







				$returnans=update_user_meta( $userid, 'membership_status','Continue');		 







				 return $expiredate;







			}	 







			elseif($autorenew=="Yes")







			{







				$returnans=update_user_meta( $userid, 'begin_date',$today );







				  $bigindate=get_user_meta($userid,'begin_date',true);







				return $expiredate= date('Y-m-d', strtotime($bigindate. ' + '.$validity.' days')); 







			}







			else







			{







				$returnans=update_user_meta( $userid, 'membership_status','Expired');







				return $expiredate; 







			}







		}







		else







		{







			return $expiredate;







		}







	}







}







add_action('init','MJ_gmgt_send_alert_message');







add_action('init','MJ_gmgt_send_expired_message');







//SEND REMINDER MAIL FUNCTION







function MJ_gmgt_send_alert_message()







{







	$enable_service=get_option('gym_enable_membership_alert_message');







	if($enable_service=='yes')







	{







		$gmgt_system_name=get_option('gmgt_system_name');







		$search=array('[GMGT_MEMBERNAME]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[GMGT_GYM_NAME]');







		







		$before_days=get_option('gmgt_reminder_before_days');







		$today=date('Y-m-d');







		$get_members = array('role' => 'member');







				$membersdata=get_users($get_members);







			 if(!empty($membersdata))







			 {







				foreach ($membersdata as $retrieved_data){







					







					$expiredate=MJ_gmgt_check_membership($retrieved_data->ID);







					$start_date=$retrieved_data->begin_date;







					$membership_id=get_user_meta($retrieved_data->ID,'membership_id',true);







					$membership_name=MJ_gmgt_get_membership_name($membership_id);







					// reminder subject value//







					$subject_search=array('[GMGT_GYM_NAME]');







					$subject_content=get_option('gmgt_reminder_subject');







					$subject_replace = array($gmgt_system_name);







					$subject_content = str_replace($subject_search, $subject_replace, $subject_content);







					







					//reminder message value//







					$message_content=get_option('gym_reminder_message');







					$replace = array($retrieved_data->display_name,$retrieved_data->begin_date,$expiredate,$membership_name);







					$message_content = str_replace($search, $replace, $message_content);







					







					$mail_sent=MJ_gmgt_check_alert_mail_send($retrieved_data->ID,$expiredate,$start_date);







					$date1=date_create($today);







					$date2=date_create($expiredate);







					$interval = $date1->diff($date2);







					$difference=$interval->format('%R%a');







					







					if($difference<= +$before_days && $difference > 0)







					{					







						if($mail_sent==0)







						{







							$to=$retrieved_data->user_email;							







							$from=get_option('admin_email');







							$headers = 'From: <'.$from.'>' . "\r\n";







							$success=wp_mail( $to, $subject_content, $message_content, $headers ); 







							if($success)







								MJ_gmgt_insert_alert_mail($retrieved_data->ID,$expiredate,$start_date,$membership_id);







						}







					}					







				}







			 }







	}







	







}







//SEND REMINDER MAIL CHECK  FUNCTION







function MJ_gmgt_check_alert_mail_send($member_id,$expiredate,$start_date)







{







	global $wpdb;







	$table_gmgt_alert_mail_log = $wpdb->prefix . 'gmgt_alert_mail_log';







	







	$result= $wpdb->get_var("SELECT count(*) FROM ".$table_gmgt_alert_mail_log." WHERE member_id =".$member_id." and start_date='".$start_date."' and end_date='".$expiredate."'");







	return $result;







}







//INSER REMINDER MESGAE FUNCTION







function MJ_gmgt_insert_alert_mail($member_id,$expiredate,$start_date,$membership_id)







{







	global $wpdb;







	$table_gmgt_alert_mail_log = $wpdb->prefix . 'gmgt_alert_mail_log';







	$alertdata['member_id']=$member_id;







	$alertdata['membership_id']=$membership_id;







	$alertdata['start_date']=$start_date;







	$alertdata['end_date']=$expiredate;







	$alertdata['alert_date']=date("Y-m-d");







	$result=$wpdb->insert( $table_gmgt_alert_mail_log, $alertdata );







	return $result;







	







}







//Get Start Date of class







function MJ_gmgt_get_class_date_by_id($class_id)







{







	global $wpdb;







	$table_class = $wpdb->prefix. 'gmgt_booking_class';







	$result = $wpdb->get_row("SELECT booking_date FROM $table_class where class_id=$class_id");







	







	return $result->booking_date;







}







//Get Start time of class







function MJ_gmgt_get_class_time_by_id($class_id)







{







	global $wpdb;







	$table_class = $wpdb->prefix. 'gmgt_class_schedule';







	$result = $wpdb->get_row("SELECT start_time FROM $table_class where class_id=$class_id");







	return $result->start_time;







}















//GET CURENT USER CLASS







function MJ_gmgt_get_current_time($id)







{







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_class_schedule';







	$result =$wpdb->get_results("SELECT *  FROM $table_name where staff_id=$id OR asst_staff_id =$id");







	return $result;







}















function MJ_gmgt_send_expired_message()







{







	$enable_service=get_option('gym_enable_membership_expired_message');







	if($enable_service=='yes')







	{







		$gmgt_system_name=get_option('gmgt_system_name');







		$search=array('[GMGT_MEMBERNAME]','[GMGT_STARTDATE]','[GMGT_ENDDATE]','[GMGT_MEMBERSHIP]','[GMGT_GYM_NAME]');







		







	







		$today=date('Y-m-d');







		$get_members = array('role' => 'member');







				$membersdata=get_users($get_members);







			 if(!empty($membersdata))







			 {







				foreach ($membersdata as $retrieved_data){







					







					$expiredate=MJ_gmgt_check_membership($retrieved_data->ID);







					







					$start_date=$retrieved_data->begin_date;







					$membership_id=get_user_meta($retrieved_data->ID,'membership_id',true);







					$membership_name=MJ_gmgt_get_membership_name($membership_id);







					// reminder subject value//







					$subject_search=array('[GMGT_GYM_NAME]');







					$subject_content=get_option('gmgt_expire_subject');







					$subject_replace = array($gmgt_system_name);







					$subject_content = str_replace($subject_search, $subject_replace, $subject_content);







					







					//reminder message value//







					$message_content=get_option('gym_expire_message');







					$replace = array($retrieved_data->display_name,$retrieved_data->begin_date,$expiredate,$membership_name);







					$message_content = str_replace($search, $replace, $message_content);







					







					$mail_sent=MJ_gmgt_check_notification_mail_send($retrieved_data->ID,$expiredate,$start_date);







					$date1=date_create($today);







					$date2=date_create($expiredate);







					







					$interval = $date1->diff($date2);







					$difference=$interval->format('%R%a');







					







					if($today == $expiredate)







					{					







						if($mail_sent==0)







						{







							$to=$retrieved_data->user_email;							







							$from=get_option('admin_email');







							$headers = 'From: <'.$from.'>' . "\r\n";







							$success=wp_mail( $to, $subject_content, $message_content, $headers ); 







							if($success)







								MJ_gmgt_insert_alert_mail($retrieved_data->ID,$expiredate,$start_date,$membership_id);







						}







					}			 







				}







			 }







	}







	







}















//SEND REMINDER MAIL CHECK  FUNCTION







function MJ_gmgt_check_notification_mail_send($member_id,$expiredate,$start_date)







{







	global $wpdb;







	$table_gmgt_alert_mail_log = $wpdb->prefix . 'gmgt_alert_mail_log';







	







	$result= $wpdb->get_var("SELECT count(*) FROM ".$table_gmgt_alert_mail_log." WHERE member_id =".$member_id." and start_date='".$start_date."' and end_date='".$expiredate."'");







	return $result;







}







//GET MEMBER Attendance







function MJ_gmgt_view_member_attendance($start_date,$end_date,$user_id)







{







	







	global $wpdb;







	$tbl_name = $wpdb->prefix .'gmgt_attendence';







	







	$result =$wpdb->get_results("SELECT *  FROM $tbl_name where user_id=$user_id AND role_name = 'member' and attendence_date between '$start_date' and '$end_date'");







	return $result;







}







function MJ_gmgt_get_attendence($userid,$curr_date)







{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	$result=$wpdb->get_var("SELECT status FROM $table_name WHERE attendence_date='$curr_date'  and user_id=$userid");







	return $result;















}







function MJ_gmgt_get_all_attendence()







{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	







	$result=$wpdb->get_results("SELECT * FROM $table_name");







	return $result;















}







function MJ_gmgt_get_all_member_attendence()







{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	$result=$wpdb->get_results("SELECT * FROM $table_name WHERE role_name='member'");







	return $result;















}







function MJ_gmgt_get_class_id($userid)







{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	







	$result=$wpdb->get_var("SELECT class_id FROM $table_name WHERE user_id=$userid");







	return $result;















}







//GET CURENT USER CLASS







function MJ_gmgt_get_current_userclass($id)







{







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_class_schedule';







	$result =$wpdb->get_results("SELECT *  FROM $table_name where staff_id=$id OR asst_staff_id =$id");







	return $result;







}







//GET CURENT CLASS BY ID







function MJ_gmgt_get_class_name_by_id($id)







{







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_class_schedule';







	$result =$wpdb->get_var("SELECT class_name  FROM $table_name where class_id=$id");







	return $result;







}







//GET INBOX MESSGAE FUNCTION







function MJ_gmgt_get_inbox_message($user_id,$p=0,$lpm1=5)







{







	







	global $wpdb;







	$tbl_name_message = $wpdb->prefix .'Gmgt_message';







	$tbl_name_message_replies = $wpdb->prefix .'gmgt_message_replies';







	







	$inbox = $wpdb->get_results("SELECT DISTINCT b.message_id, a.* FROM $tbl_name_message a LEFT JOIN $tbl_name_message_replies b ON a.post_id = b.message_id WHERE ( a.receiver = $user_id OR b.receiver_id =$user_id)  group BY a.post_id ORDER BY date DESC limit $p , $lpm1");







	







	return $inbox;







}















//---GET INBOX SINGL MESSGAE FUNCTION ---//







function MJ_gmgt_get_message_by_id($id)







{







	global $wpdb;







	$tbl_name_message = $wpdb->prefix. 'Gmgt_message';







	$result = $wpdb->get_row("SELECT * FROM $tbl_name_message where message_id=".$id);







	return $result;







}















//COUNT UNREAD FUNCTION







function MJ_gmgt_count_unread_message($user_id)







{







	global $wpdb;







	$tbl_name_message = $wpdb->prefix .'Gmgt_message';







	$gmgt_message_replies = $wpdb->prefix . 'gmgt_message_replies';







	







	$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name_message where ((receiver = $user_id) AND (sender != $user_id)) AND (status=0)");















	$reply_msg =$wpdb->get_results("SELECT *  FROM $gmgt_message_replies where (receiver_id = $user_id) AND ((status=0) OR (status IS NULL))");















	$count_total_message=count($inbox) + count($reply_msg);







	







	return $count_total_message;







}







function MJ_gmgt_count_reply_item($id)







{







	global $wpdb;







	$tbl_gmgt_message = $wpdb->prefix .'Gmgt_message';







	$gmgt_message_replies = $wpdb->prefix .'gmgt_message_replies';	







	















	$user_id=get_current_user_id();







	$inbox_sent_box =$wpdb->get_results("SELECT *  FROM $tbl_gmgt_message where ((receiver = $user_id) AND (sender != $user_id)) AND (post_id = $id) AND (status=0)");







	







	$reply_msg =$wpdb->get_results("SELECT *  FROM $gmgt_message_replies where (receiver_id = $user_id) AND (message_id = $id) AND ((status=0) OR (status IS NULL))");







	







	$count_total_message=count($inbox_sent_box) + count($reply_msg); 







	







	return $count_total_message; 







}







function MJ_gmgt_change_read_status_reply($id)







{







	global $wpdb;







	$gmgt_message_replies = $wpdb->prefix . 'gmgt_message_replies';







	$data['status']=1;







	$whereid['message_id']=$id;







	$whereid['receiver_id']=get_current_user_id();







	$retrieve_message_reply_status = $wpdb->update($gmgt_message_replies,$data,$whereid);







	







	return $retrieve_message_reply_status;







}







//ADMIN SIDE INBOX PAGINATION FUNCTION







function MJ_gmgt_admininbox_pagination($totalposts,$p,$lpm1,$prev,$next)







{







	$adjacents = 1;







	$page_order = "";







	$pagination = "";







	$form_id = 1;







	if(isset($_REQUEST['form_id']))







		$form_id=$_REQUEST['form_id'];







	if(isset($_GET['orderby']))







	{







		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];







	}







	if($totalposts > 1)







	{







		$pagination .= '<div class="btn-group">';







		







		if ($p > 1)







			$pagination.= "<a href=\"?page=smgt_message&tab=inbox&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";







		else







			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";















		if ($p < $totalposts)







			$pagination.= " <a href=\"?page=smgt_message&tab=inbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";







		else







			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";







		$pagination.= "</div>\n";







	}







	return $pagination;







}







//GET DISPLAY NAME BY ID FUNCTION







function MJ_gmgt_get_display_name($user_id) 







{







	if (!empty($user = get_userdata($user_id))){



		return $user->data->display_name;



	}



	else{



		return "N/A";



	}







		







	







}







function MJ_gmgt_delete_message($mid)







{







	







	global $wpdb;







	$table_gmgt_message = $wpdb->prefix. 'Gmgt_message';







	$posts = $wpdb->prefix."posts";







	$result = $wpdb->query("DELETE FROM $table_gmgt_message where message_id= ".$mid);







	//$result =$wpdb->query("DELETE FROM ".$posts." Where post_type = 'hmgt_message' AND post_author = $mid");







	return $result;







}























//GET USER ALL MESSAGE FUNCTION







function MJ_gmgt_get_all_user_in_message()







{







	$staff_member = get_users(array('role'=>'staff_member'));







	$accountant = get_users(array('role'=>'accountant'));







	$member = get_users(array('role'=>'member'));







	







	$obj_gym = new MJ_gmgt_Gym_management(get_current_user_id());







		







	$all_user = array('member'=>$member,







			'staff member'=>$staff_member,







			'accountant'=>$accountant,







			







	);







	$return_array = array();







	







	foreach($all_user as $key => $value)







	{







		if(!empty($value))







		{







		 echo '<optgroup label="'.esc_html__($key,'gym_mgt').'" style = "text-transform: capitalize;">';







		 foreach($value as $user)







		 {



			if(!empty($user->member_id))



			{



				 echo '<option value="'.$user->ID.'">'.MJ_gmgt_get_member_full_display_name_with_memberid($user->ID).'</option>';



			}



			else



			{



				echo '<option value="'.$user->ID.'">'.MJ_gmgt_get_user_full_display_name($user->ID).'</option>';



			}







		 }







		}







	}







}







//GET ALL CLASSES FUNCTION







function MJ_gmgt_get_allclass()







{	







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_class_schedule';







	







	return $classdata =$wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);







	//print_r($classdata);







}







//GET USER NOTICE BY ROLE WISE FUNCTION







function MJ_gmgt_get_user_notice($role,$class_id)







{		







	if($class_id == 'all')







	{







		$userdata=get_users(array('role'=>$role));







	}







	else







	{			







		if($role=='member')







		{				







			foreach(MJ_gmgt_get_member_by_class_id($class_id) as $key=>$member_id)







			{







				$userdata[] = get_userdata($member_id->member_id);					







			}				







		}		







		else







		{	







			$userdata=get_users(array('role'=>$role));







		}		







	}







	







	return $userdata;







}







function MJ_gmgt_insert_record($tablenm,$records)







{







	global $wpdb;







	$table_name = $wpdb->prefix . $tablenm;







	return $result=$wpdb->insert( $table_name, $records);







	







}







//PAGINATION FUNCTION







function MJ_gmgt_pagination($totalposts,$p,$lpm1,$prev,$next)







{







	$adjacents = 1;







	$page_order = "";







	$pagination = "";







	$form_id = 1;







	if(isset($_REQUEST['form_id']))







		$form_id=$_REQUEST['form_id'];







	if(isset($_GET['orderby']))







	{







		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];







	}







	if($totalposts > 1)







	{







		$pagination .= '<div class="btn-group">';







		







		if ($p > 1)







			$pagination.= "<a href=\"?page=smgt_message&tab=sentbox&form_id=$form_id&pg=$prev$page_order\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";







		else







			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";







		







		if ($p < $totalposts)







			$pagination.= " <a href=\"?page=smgt_message&tab=sentbox&form_id=$form_id&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";







		else







			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";







		$pagination.= "</div>\n";







	}







	return $pagination;







}







//COUNT SEND MESSAGE IN MESSAGE BOX







function MJ_gmgt_count_send_item($id)







{







	global $wpdb;







	$posts = $wpdb->prefix."posts";







	$total =$wpdb->get_var("SELECT Count(*) FROM ".$posts." Where post_type = 'message' AND post_author = $id");







	return $total;







}







//SEND MESSAGE FUNCTION







function MJ_gmgt_get_send_message($user_id,$max=10,$offset=0)







{







	







	global $wpdb;







	$tbl_name = $wpdb->prefix .'Gmgt_message';







	







	$obj_gym = new MJ_gmgt_Gym_management($user_id);







	







	if(is_admin() || $obj_gym->role=='staff_member' || $obj_gym->role=='accountant' || $obj_gym->role == 'member')







	{







		







		$args['post_type'] = 'message';







		$args['posts_per_page'] =$max;







		$args['offset'] = $offset;







		$args['post_status'] = 'public';







		$args['author'] = $user_id;







		







		$q = new WP_Query();







		$sent_message = $q->query( $args );







	







	}







	else 







	{







		$sent_message =$wpdb->get_results("SELECT *  FROM $tbl_name where sender = $user_id ");







	}







	return $sent_message;







}







//GET EMAIL ID BY  USER ID FUNCTION







function MJ_gmgt_get_emailid_byuser_id($id)







{







	if (!$user = get_userdata($id))







		return false;







	return $user->data->user_email;







}







//INBOX MESSAGE COUNT FUNCTION







function MJ_gmgt_count_inbox_item($id)







{







	global $wpdb;







	$tbl_gmgt_message = $wpdb->prefix .'Gmgt_message';







	$gmgt_message_replies = $wpdb->prefix .'gmgt_message_replies';	







	







	$user_id=get_current_user_id();







	$inbox_sent_box =$wpdb->get_results("SELECT *  FROM $tbl_gmgt_message where ((receiver = $user_id) AND (sender != $user_id)) AND (post_id = $id) AND (status=0)");







	







	$reply_msg =$wpdb->get_results("SELECT *  FROM $gmgt_message_replies where (receiver_id = $user_id) AND (message_id = $id) AND ((status=0) OR (status IS NULL))");







	







	$count_total_message = count($inbox_sent_box) + count($reply_msg); 







	







	return $count_total_message; 







}







//INBOX MESSAGE COUNT FUNCTION







function MJ_gmgt_count_inbox_item_for_dashboard()







{







	global $wpdb;







	$tbl_gmgt_message = $wpdb->prefix .'Gmgt_message';







	$gmgt_message_replies = $wpdb->prefix .'gmgt_message_replies';	







	$user_id=get_current_user_id();







	$inbox_sent_box =$wpdb->get_results("SELECT *  FROM $tbl_gmgt_message where ((receiver = $user_id) AND (sender != $user_id))");







	$reply_msg =$wpdb->get_results("SELECT *  FROM $gmgt_message_replies where (receiver_id = $user_id) AND ((status=0) OR (status IS NULL))");







	$count_total_message = count($inbox_sent_box) + count($reply_msg); 







	return $count_total_message; 







}







//INBOX PAGINATION FUNCTION







function MJ_gmgt_inbox_pagination($totalposts,$p,$lpm1,$prev,$next)







{







	$adjacents = 1;







	$page_order = "";







	$pagination = "";







	$form_id = 1;







	if(isset($_REQUEST['form_id']))







		$form_id=$_REQUEST['form_id'];







	if(isset($_GET['orderby']))







	{







		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];







	}







	if($totalposts > 1)







	{







		$pagination .= '<div class="btn-group">';







		







		if ($p > 1)







			$pagination.= "<a href=\"?dashboard=user&page=message&tab=inbox&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";







		else







			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";







	







		if ($p < $totalposts)







			$pagination.= " <a href=\"?dashboard=user&page=message&tab=inbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";







		else







			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";







		$pagination.= "</div>\n";







	}







	return $pagination;







}















//FRONTED SIDE SENTBOX PAGINATIOBN FUNCTION







function MJ_gmgt_fronted_sentbox_pagination($totalposts,$p,$lpm1,$prev,$next)







{







	$adjacents = 1;







	$page_order = "";







	$pagination = "";







	$form_id = 1;







	if(isset($_REQUEST['form_id']))







		$form_id=$_REQUEST['form_id'];







	if(isset($_GET['orderby']))







	{







		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];







	}







	if($totalposts > 1)







	{







		$pagination .= '<div class="btn-group">';







		







		if ($p > 1)







			$pagination.= "<a href=\"?dashboard=user&page=message&tab=sentbox&pg=$prev$page_order\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";







		else







			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";















		if ($p < $totalposts)







			$pagination.= " <a href=\"?dashboard=user&page=message&tab=sentbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";







		else







			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";







		$pagination.= "</div>\n";







	}







	return $pagination;







}







//GET USER WORKOUT FUNCTION







function MJ_gmgt_get_userworkout($id)







{







	global $wpdb;







	$workouttable = $wpdb->prefix."gmgt_assign_workout";







	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where user_id = $id");







	return $workoutdata;







}



function MJ_gmgt_get_workout_by_workout_id($id)







{







	global $wpdb;







	$workouttable = $wpdb->prefix."gmgt_assign_workout";







	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where workout_id = $id");







	return $workoutdata;







}











//GET USER WORKOUT DATA FUNCTION







function MJ_gmgt_get_workoutdata($id)







{	







	global $wpdb;







	$workouttable = $wpdb->prefix."gmgt_workout_data";







	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where workout_id = $id");







	return $workoutdata;







	







}







//SET WORKOUT AARAY FUNCTION







function MJ_gmgt_set_workoutarray($data)







{







	$workout_array=array();







	foreach($data as $row)







	{







			$workout_array[$row->day_name][]= "<span class='col-md-3 col-sm-3 col-xs-12 float_left'>".$row->workout_name."</span>   







				<span class='col-md-3 col-sm-3 col-xs-6 float_left'>".$row->sets." ".esc_html__('Sets','gym_mgt')."</span>







			<span class='col-md-2 col-sm-2 col-xs-6 float_left'> ".$row->reps." ".esc_html__('Reps','gym_mgt')."</span>







				<span class='col-md-2 col-sm-2 col-xs-6 float_left'> ".$row->kg." ".esc_html__('KG','gym_mgt')."</span>







			<span class='col-md-2 col-sm-2  col-xs-6 float_left'> ".$row->time." ".esc_html__('Seconds','gym_mgt')."</span>";







		







	}







	return $workout_array;







	







}







//SET WORKOUT AARAY FUNCTION







function MJ_gmgt_set_workoutarray_new($data)







{







	$workout_array=array();







	foreach($data as $row)







	{







			$workout_array[$row->day_name][]=[







			'id' =>$row->id, 







			'workout_name' =>$row->workout_name, 







			'sets' =>$row->sets, 







			'reps' =>$row->reps, 







			'kg' =>$row->kg, 







			'time' =>$row->time







			];	







	}







	return $workout_array;







	







}







//CHECK USER WORKOUT







function MJ_gmgt_check_user_workouts($id,$date)







{







	global $wpdb;







	$workouttable = $wpdb->prefix."gmgt_daily_workouts";







	$count_rec =$wpdb->get_var("SELECT COUNT(*) FROM ".$workouttable." Where member_id = $id AND record_date='$date'");







	return $count_rec;







}







//GET USER NUTRISION







function MJ_gmgt_get_user_nutrition($id)







{







	global $wpdb;







	$workouttable = $wpdb->prefix."gmgt_nutrition";







	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where user_id = $id");







	return $workoutdata;







}







//GET NUTRISION DATA FUNCTION







function MJ_gmgt_get_nutritiondata($id)







{







	global $wpdb;







	$workouttable = $wpdb->prefix."gmgt_nutrition_data";







	$workoutdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where nutrition_id = $id");















	return $workoutdata;















}







//SET NUTRISION AARAY FUNCTION







function MJ_gmgt_set_nutrition_array($data)







{







	$workout_array=array();







	foreach($data as $row)







	{



		if(is_rtl()){



			$workout_array[$row->day_name][]= "&nbsp;<span class='col-md-3 col-sm-3 col-xs-12 nutrition_time float_left  width_50px_res'>".$row->nutrition_value."</span>







			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='col-md-9 col-sm-9 col-xs-12 display_nutrition_rtl width_50px_res'>".$row->nutrition_time." </span>";



		}



		else{



			$workout_array[$row->day_name][]= "<span class='col-md-3 col-sm-3 col-xs-12 nutrition_time float_left display_nutrition width_50px_res'>".$row->nutrition_time."</span>







			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='col-md-9 col-sm-9 col-xs-12 display_nutrition width_50px_res'>".$row->nutrition_value." </span>";



		}



		







		







	}







	return $workout_array;















}







//----------LICENCE KEY REGISTRAION CODE-------------







function MJ_gmgt_verify_pkey()







{







	$api_server = 'license.dasinfomedia.com';







	$fp = fsockopen($api_server,80, $errno, $errstr, 2);







	$location_url = admin_url().'admin.php?page=gmgt_system';







	if (!$fp)







              $server_rerror = 'Down';







        else







              $server_rerror = "up";







	if($server_rerror == "up")







	{







	$domain_name= $_SERVER['SERVER_NAME'];







	$licence_key = $_REQUEST['licence_key'];







	$email = $_REQUEST['enter_email'];







	$data['domain_name']= $domain_name;







	$data['licence_key']= $licence_key;







	$data['enter_email']= $email;







	$result = MJ_gmgt_check_productkey($domain_name,$licence_key,$email);







	if($result == '1')







	{







		$message = "".esc_html__('Please provide correct Envato purchase key.','gym_mgt')."";







			$_SESSION['gmgt_verify'] = '1';







	}







	elseif($result == '2')







	{







		$message = 'This purchase key is already registered with the different domain. If have any issue please contact us at sales@mojoomla.com';







			$_SESSION['gmgt_verify'] = '2';







	}







	elseif($result == '3')







	{







		$message = 'There seems to be some problem please try after sometime or contact us on sales@mojoomla.com';







			$_SESSION['gmgt_verify'] = '3';







	}







	elseif($result == '4')







	{







		$message = 'Please provide correct Envato purchase key for this plugin.';







			$_SESSION['gmgt_verify'] = '4';







	}







	else{







		update_option('domain_name',$domain_name,true);







	update_option('licence_key',$licence_key,true);







	update_option('gmgt_setup_email',$email,true);







		$message = 'Success fully register';







			$_SESSION['gmgt_verify'] = '0';







	}







	







	







		$result_array = array('message'=>$message,'gmgt_verify'=>$_SESSION['gmgt_verify'],'location_url'=>$location_url);







		echo json_encode($result_array);







	}







	else







	{







		$message = 'Server is down Please wait some time';







		$_SESSION['gmgt_verify'] = '3';







		$result_array = array('message'=>$message,'gmgt_verify'=>$_SESSION['gmgt_verify'],'location_url'=>$location_url);







	echo json_encode($result_array);







	}







	die();







}







//CHECK SYSTEM SEVER FUNCTION







function MJ_gmgt_check_ourserver()







{







	$api_server = 'license.dasinfomedia.com';







	$fp = @fsockopen($api_server,80, $errno, $errstr, 2);







	$location_url = admin_url().'admin.php?page=gmgt_system';







	if (!$fp)







              return false; /*server down*/







        else







              return true; /*Server up*/







}







//CHECK PRODUCT KEY FUNCTION







function MJ_gmgt_check_productkey($domain_name,$licence_key,$email)







{







	$api_server = 'license.dasinfomedia.com';







	$fp = @fsockopen($api_server,80, $errno, $errstr, 2);







	$location_url = admin_url().'admin.php?page=gmgt_system';







	if (!$fp)







              $server_rerror = 'Down';







        else







              $server_rerror = "up";







	if($server_rerror == "up")







	{







		$url = 'http://license.dasinfomedia.com/index.php';







		$fields = 'result=2&domain='.$domain_name.'&licence_key='.$licence_key.'&email='.$email.'&item_name=gym';







		//open connection







		$ch = curl_init();















		//set the url, number of POST vars, POST data







		curl_setopt($ch,CURLOPT_URL, $url);







		curl_setopt($ch,CURLOPT_POST,1);







		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);







		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);















		//execute post







		$result = curl_exec($ch);







		







		curl_close($ch);







		return $result;







	}







	else







	{







		return '3';







	}		







}







/* Setup form submit*/







function MJ_gmgt_submit_setupform($data)







{







	$domain_name= $data['domain_name'];







	$licence_key = $data['licence_key'];







	$email = $data['enter_email'];







	







	$result = MJ_gmgt_check_productkey($domain_name,$licence_key,$email);







	if($result == '1')







	{







		$message = 'Please provide correct Envato purchase key.';







			$_SESSION['gmgt_verify'] = '1';







	}







	elseif($result == '2')







	{







		$message = 'This purchase key is already registered with the different domain. If have any issue please contact us at sales@mojoomla.com';







			$_SESSION['gmgt_verify'] = '2';







	}







	elseif($result == '3')







	{







		$message = 'There seems to be some problem please try after sometime or contact us on sales@mojoomla.com';







			$_SESSION['gmgt_verify'] = '3';







	}







	elseif($result == '4')







	{







		$message = 'Please provide correct Envato purchase key for this plugin.';







			$_SESSION['gmgt_verify'] = '1';







	}







	else







	{







		update_option('domain_name',$domain_name,true);







		update_option('licence_key',$licence_key,true);







		update_option('gmgt_setup_email',$email,true);







		$message = 'Success fully register';







			$_SESSION['gmgt_verify'] = '0';







	}		







	







	$result_array = array('message'=>$message,'gmgt_verify'=>$_SESSION['gmgt_verify']);







	return $result_array;







}







/* check server live */







function MJ_gmgt_chekserver($server_name)







{







	if($server_name == 'localhost')







	{







		return true;	







	}		







}







/*Check is_verify*/







function MJ_gmgt_check_verify_or_not($result)







{	







	







	$server_name = $_SERVER['SERVER_NAME'];







	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';







	$pos = strrpos($current_page, "gmgt_");	







	







	if($pos !== false)			







	{







		if($server_name == 'localhost')







		{







			return true;







		}







		else







		{







			if($result == '0')







			{







				return true;







			}







		}







		return false;







	}







	







}







//GET PAGE FUNCTION







function MJ_gmgt_is_gmgtpage()







{







	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';







	$pos = strrpos($current_page, "gmgt_");	







	







	if($pos !== false)			







	{







		return true;







	}







	return false;







}







//GET TIME PERIOD FOR CLASS FUNCTUION







function MJ_gmgt_timeperiod_for_class_member()







{







	if($_REQUEST['timeperiod']=='limited')







	{ ?>







		<div class="form-group input">







			<div class="col-md-12 form-control">







				<input id="on_of_member" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==4) return false;" value="<?php if($edit){ echo $result->on_of_member;}elseif(isset($_POST['on_of_member'])) echo $_POST['on_of_member'];?>" name="on_of_member">







				<label class="active" for="on_of_member"><?php esc_html_e('No Of Member','gym_mgt');?><span class="require-field">*</span></label>







			</div>







		</div>







		<?php 







	}







die;







}







//NO OF CLASS IN MEMBRSHIP FUNCTION







function MJ_gmgt_timeperiod_for_class_number()







{







	if($_REQUEST['timeperiod']=='limited')







	{ ?>







			<div class="form-group input">







				<div class="col-md-12 form-control">







					<input id="on_of_classis" class="form-control validate[required] text-input phone_validation" type="number" min="0" onkeypress="if(this.value.length==4) return false;" value="<?php if($edit){ echo $result->on_of_classis;}elseif(isset($_POST['on_of_classis'])) echo $_POST['on_of_classis'];?>" name="on_of_classis">







					<label class="active" for="on_of_classis "><?php esc_html_e('No Of Class','gym_mgt');?><span class="require-field">*</span></label>







				</div>







			</div>







<?php }







die;







}







//GET CLASS BY MEMER ID







function MJ_gmgt_get_class_id_by_membership()







{ 







	global $wpdb;







	$tbl_gmgt_membershiptype = $wpdb->prefix."gmgt_membershiptype";	







	$membershipdata = $wpdb->get_row("SELECT * FROM $tbl_gmgt_membershiptype WHERE membership_id=".$_REQUEST['membership_id']);







	if($membershipdata->membership_class_limit == 'limited')







	{







		if($_REQUEST['membership_hidden'] == 0)







		{







			$membership_id = $_REQUEST['membership_id'];















			$assigned_membership = get_users(







						array(







							'role' => 'member',







							'meta_query' => array(







							array(







									'key' => 'membership_status',







									'value' =>'Continue',







									'compare' => '='







								),







							array(







									'key' => 'membership_id',







									'value' =>$membership_id,







									'compare' => '='







								),







							)







						));	







			$size_of_membershipdata_array=sizeof($assigned_membership);			







			







			if((string)$size_of_membershipdata_array >= $membershipdata->on_of_member)







			{







				echo '1'; die;







			} 		







		}







		else







		{







			if($_REQUEST['membership_hidden'] != $_REQUEST['membership_id'])







			{







				$membership_id = $_REQUEST['membership_id'];















				$assigned_membership = get_users(







							array(







								'role' => 'member',







								'meta_query' => array(







								array(







										'key' => 'membership_status',







										'value' =>'Continue',







										'compare' => '='







									),







								array(







										'key' => 'membership_id',







										'value' =>$membership_id,







										'compare' => '='







									),







								)







							));	







				$size_of_membershipdata_array=sizeof($assigned_membership);			







				







				if((string)$size_of_membershipdata_array >= $membershipdata->on_of_member)







				{







					echo '1'; die;







				} 		







			}







		}







	}







	$obj_class=new MJ_gmgt_classschedule;







	$tbl_gmgt_membership_class = $wpdb->prefix."gmgt_membership_class";	







	$table_class = $wpdb->prefix. 'gmgt_class_schedule';







	$retrive_data = $wpdb->get_results("SELECT * FROM $tbl_gmgt_membership_class WHERE membership_id=".$_REQUEST['membership_id']);



	



	if(!empty($retrive_data))







	{







		foreach($retrive_data as $key=>$value)







		{







			$class_data=$obj_class->MJ_gmgt_get_single_class($value->class_id);







			print '<option value="'.$value->class_id.'" selected>'.MJ_gmgt_get_class_name($value->class_id).' ( '.MJ_gmgt_timeremovecolonbefoream_pm($class_data->start_time).' - '.MJ_gmgt_timeremovecolonbefoream_pm($class_data->end_time).')</option>';







		}







	} 	 







die;







}







//CHECK MEMBERSHIP LIMIT STATUS FUNCTION







function MJ_gmgt_check_membership_limit_status()







{	







	global $wpdb;







	$obj_membership = new MJ_gmgt_membership();







	$tbl_membership = $wpdb->prefix .'gmgt_membershiptype';







	$result = $wpdb->get_row("SELECT * FROM $tbl_membership WHERE membership_id=".$_REQUEST['membership_id']);







	if($result->membership_class_limit=='limited')







	{		







		print '<input name="no_of_class" type="hidden" value="'.$result->on_of_classis .'">';







	}	







	die;







}







//GET USER ROLE FUNCTION







function MJ_gmgt_GetRoleName_front($rolename)







{







	if($rolename[0]=="staff_member")







	{







		$return_role=esc_html__('Staff Members','gym_mgt');







	}







	if($rolename[0]=="accountant")







	{







		$return_role=esc_html__('Accountant','gym_mgt');







	}







	







	if($rolename[0]=="member")







	{







		$return_role=esc_html__('Member','gym_mgt');







	}







	if($rolename[0]=="all")







	{







		$return_role=esc_html__('All','gym_mgt');







	}







	if($rolename[0]=="administrator")







	{







		$return_role=esc_html__('Administrator','gym_mgt');







	}







	return $return_role;







}















//GET USER ROLE FUNCTION







function MJ_gmgt_GetRoleName($rolename)







{







	if($rolename=="staff_member")







	{







		$return_role=esc_html__('Staff Members','gym_mgt');







	}







	if($rolename=="accountant")







	{







		$return_role=esc_html__('Accountant','gym_mgt');







	}







	







	if($rolename=="member")







	{







		$return_role=esc_html__('Member','gym_mgt');







	}







	if($rolename=="all")







	{







		$return_role=esc_html__('All','gym_mgt');







	}







	if($rolename=="administrator")







	{







		$return_role=esc_html__('Administrator','gym_mgt');







	}







	return $return_role;







}







function MJ_gmgt_check_approve_user($user_id)







{	







	return $userdata = get_user_meta($user_id,'gmgt_hash',true);







}







//GET MEASUREMENT LABLE ARRAY FUNCTION//







function MJ_gmgt_measurement_counts_lable_array($key)







{







	 /* $measurement_counts=array(	'Height'=>get_option('gmgt_height_unit'),







								'Weight'=>get_option('gmgt_weight_unit'),







								'Chest'=>get_option('gmgt_chest_unit'),







								'Waist'=>get_option('gmgt_waist_unit'),







								'Thigh'=>get_option('gmgt_thigh_unit'),







								'Arms'=>get_option('gmgt_arms_unit'),







								'Fat'=>get_option('gmgt_fat_unit')); */







		$measurement_counts=array(	'Height'=>esc_html__(get_option('gmgt_height_unit'),"gym_mgt"),







								'Weight'=>esc_html__(get_option('gmgt_weight_unit'),"gym_mgt"),







								'Chest'=>esc_html__(get_option('gmgt_chest_unit'),"gym_mgt"),







								'Waist'=>esc_html__(get_option('gmgt_waist_unit'),"gym_mgt"),







								'Thigh'=>esc_html__(get_option('gmgt_thigh_unit'),"gym_mgt"),







								'Arms'=>esc_html__(get_option('gmgt_arms_unit'),"gym_mgt"),







								'Fat'=>esc_html__(get_option('gmgt_fat_unit'),"gym_mgt"));







			







	return $measurement_counts[$key];		







}







//GET STAFF MEMBER BY ID FUNCTION







function MJ_gmgt_GetStaffMemberById($id)







{		







		global $wpdb;







		$table_class = $wpdb->prefix. 'gmgt_class_schedule';







		$result = $wpdb->get_results("select *FROM $table_class where class_id= ".$id);







		return $result;







}















// REPLACE STRING FUNTION FOR MAIL TEMPLATE







function MJ_gmgt_string_replacemnet($arr,$message)







{







	$data = str_replace(array_keys($arr),array_values($arr),$message);







	return $data;







}















// REPLACE STRING FUNTION FOR MAIL TEMPLATE







function MJ_gmgt_subject_string_replacemnet($sub_arr,$subject)







{







	$data = str_replace(array_keys($sub_arr),array_values($sub_arr),$subject);







	return $data;







} 







// SEND MAIL FUNCTION FOR NOTIFICATION







function MJ_gmgt_send_mail($emails,$subject,$message)







{	







	$gymname=get_option('gmgt_system_name');







	$headers="";







    $headers.= 'From: '.$gymname.' <noreplay@gmail.com>' . "\r\n";







	$headers.= "MIME-Version: 1.0\r\n";







    $headers.= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";







	$enable_notofication=get_option('gym_enable_notifications');







	if($enable_notofication=='yes')







	{







		return wp_mail($emails,$subject,$message,$headers);







	}







}  







// SEND MAIL WITH HTML FUNCTION FOR NOTIFICATION







function MJ_gmgt_send_mail_text_html($emails,$subject,$message)







{







    $gymname=get_option('gmgt_system_name');







	$headers="";







    $headers.= 'From: '.$gymname.' <noreplay@gmail.com>' . "\r\n";







	$headers .= "MIME-Version: 1.0\r\n";







	$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";







	$enable_notofication=get_option('gym_enable_notifications');







	if($enable_notofication=='yes'){







	return wp_mail($emails,$subject,$message,$headers);







	}







} 







//ASSIGNED WORKOUT HTML CONTENT FUNCTION







function MJ_gmgt_Assign_Workouts_Add_Html_Content($assign_workout_id)







{







	$message='';







	$message.='<html>







          <head>







         <title>A Responsive Email Template</title>







          <meta charset="utf-8">







	<meta name="viewport" content="width=device-width, initial-scale=1">







	<meta http-equiv="X-UA-Compatible" content="IE=edge" />







	<style type="text/css">







		/* CLIENT-SPECIFIC STYLES */







		body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */







		table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */







		img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */















		/* RESET STYLES */







		img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}







		table{border-collapse: collapse !important;}







		body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}















		/* iOS BLUE LINKS */







		a[x-apple-data-detectors] {







			color: inherit !important;







			text-decoration: none !important;







			font-size: inherit !important;







			font-family: inherit !important;







			font-weight: inherit !important;







			line-height: inherit !important;







		}















		/* MOBILE STYLES */







		@media screen and (max-width: 525px) {















			/* ALLOWS FOR FLUID TABLES */







			.wrapper {







			  width: 100% !important;







				max-width: 100% !important;







			}















			/* ADJUSTS LAYOUT OF LOGO IMAGE */







			.logo img {







			  margin: 0 auto !important;







			}















			/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */







			.mobile-hide {







			  display: none !important;







			}















			.img-max {







			  max-width: 100% !important;







			  width: 100% !important;







			  height: auto !important;







			}















			/* FULL-WIDTH TABLES */







			.responsive-table {







			  width: 100% !important;







			}







			















			/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */







			.padding {







			  padding: 10px 5% 15px 5% !important;







			  







			}















			.padding-meta {







			  padding: 30px 5% 0px 5% !important;







			  text-align: center;







			}















			.padding-copy {







				padding: 10px 5% 10px 5% !important;







			  text-align: center;







			}















			.no-padding {







			  padding: 0 !important;







			}















			.section-padding {







			  padding: 50px 15px 50px 15px !important;







			}















			/* ADJUST BUTTONS ON MOBILE */







			.mobile-button-container {







				margin: 0 auto;







				width: 100% !important;







			}















			.mobile-button {







				padding: 15px !important;







				border: 0 !important;







				font-size: 16px !important;







				display: block !important;







			}















		}















		/* ANDROID CENTER FIX */







		div[style*="margin: 16px 0;"] { margin: 0 !important; }







	</style>







	<!--[if gte mso 12]>







	<style type="text/css">







	.mso-right {







		padding-left: 20px;







	}







	</style>







	<![endif]-->







	</head>







	<body style="margin: 0 !important; padding: 0 !important;">';







		          







						global $wpdb;







						$table_workout = $wpdb->prefix. 'gmgt_assign_workout';







						$result = $wpdb->get_row("SELECT * FROM $table_workout where workout_id=".$assign_workout_id);







						







						$workoutid=$result->workout_id;







						







						$workouttable = $wpdb->prefix."gmgt_workout_data";







						$all_logdata =$wpdb->get_results("SELECT *FROM ".$workouttable." Where workout_id = $workoutid");







						







						$arranged_workout=MJ_gmgt_set_workoutarray($all_logdata); 







						$message.=esc_html__('Start From ','gym_mgt');







					 $message.='<span style="color: #f25656;







             font-style: italic;" >'.MJ_gmgt_getdate_in_input_box($result->start_date).'</span>';







					$message.=esc_html__(' To ','gym_mgt');







			  $message.='<span style="color: #f25656;







              font-style: italic;">'.MJ_gmgt_getdate_in_input_box($result->end_date).'</span> ';







					







					$message.='<table style="border-collapse: collapse; width: 100%; float: left;">







					  <thead>







						<tr>







							<th style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">'. esc_html__("Day Name","gym_mgt") .'</th>







							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;"> '.esc_html__("Activity","gym_mgt").'</th>







							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;">'. esc_html__("Sets","gym_mgt").'</th>







							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;">'. esc_html__("Reps","gym_mgt").'</th>







							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;">'.esc_html__("KG","gym_mgt").'</th>







							<th  style="padding: 3px; text-align: left; border-bottom: 2px solid #ddd;">'.esc_html__("Rest Time","gym_mgt").'</th>







						</tr>







					  </thead> <tbody>  ';







							  







				foreach($arranged_workout as $key=>$rowdata)







				{ 







					







					$i=count($rowdata)+1;







					$message.='<tr>







                      <td rowspan="'.$i.'" style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; "> '.$key.'</td>';







					 







						foreach($rowdata as $row)







						{						







							$asd = explode('<span',$row);







	 								$message.='<tr>







									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[1].'</td>







									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[2].'</td>







									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[3].'</td>







									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[4].'</td>







									<td style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[5].'</td></tr>';







									







						} 







						 $message.='</tr>';						







				







			    }







				$message.='







					</tbody>







	 				</table>';







					







		return $message;







}







//Assign Nutrition CONTENT MAIL FUNCTION







function MJ_gmgt_asign_nutristion_content_send_mail($id)







{







		 $message='';







		 $message.='<html>







         <head>







         <title>A Responsive Email Template</title>







         <meta charset="utf-8">







		<meta name="viewport" content="width=device-width, initial-scale=1">







	   <meta http-equiv="X-UA-Compatible" content="IE=edge" />







	   <style type="text/css">







		/* CLIENT-SPECIFIC STYLES */







		body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */







		table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */







		img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */















		







		.panel-title{







		font-size: 14px;







		float: left;







		margin: 0;







		padding: 0;







		font-weight: 600;







	}















		/* RESET STYLES */







		img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}







		table{border-collapse: collapse !important;}







		body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}















		/* iOS BLUE LINKS */







		a[x-apple-data-detectors] {







			color: inherit !important;







			text-decoration: none !important;







			font-size: inherit !important;







			font-family: inherit !important;







			font-weight: inherit !important;







			line-height: inherit !important;







		}















		/* MOBILE STYLES */







		@media screen and (max-width: 525px) {















			/* ALLOWS FOR FLUID TABLES */







			.wrapper {







			  width: 100% !important;







				max-width: 100% !important;







			}















			/* ADJUSTS LAYOUT OF LOGO IMAGE */







			.logo img {







			  margin: 0 auto !important;







			}















			/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */







			.mobile-hide {







			  display: none !important;







			}















			.img-max {







			  max-width: 100% !important;







			  width: 100% !important;







			  height: auto !important;







			}















			/* FULL-WIDTH TABLES */







			.responsive-table {







			  width: 100% !important;







			}















			/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */







			.padding {







			  padding: 10px 5% 15px 5% !important;







			}















			.padding-meta {







			  padding: 30px 5% 0px 5% !important;







			  text-align: center;







			}















			.padding-copy {







				padding: 10px 5% 10px 5% !important;







			  text-align: center;







			}















			.no-padding {







			  padding: 0 !important;







			}















			.section-padding {







			  padding: 50px 15px 50px 15px !important;







			}















			/* ADJUST BUTTONS ON MOBILE */







			.mobile-button-container {







				margin: 0 auto;







				width: 100% !important;







			}















			.mobile-button {







				padding: 15px !important;







				border: 0 !important;







				font-size: 16px !important;







				display: block !important;







			}















		}







		/* ANDROID CENTER FIX */







		div[style*="margin: 16px 0;"] { margin: 0 !important; }







		</style>







		<!--[if gte mso 12]>







		<style type="text/css">







		.mso-right {







			padding-left: 20px;







		}







		</style>







		<![endif]-->







		</head>







	    <body style="margin: 0 !important; padding: 0 !important;">';







		$obj_nutrition=new MJ_gmgt_nutrition;







		







		$result=$obj_nutrition->MJ_gmgt_get_single_nutrition($id);







		$all_logdata=MJ_gmgt_get_nutritiondata($result->id);







		$arranged_workout=MJ_gmgt_set_nutrition_array($all_logdata);







	   $message.=' Start From <span style="color: #f25656;







	   font-style: italic;" >'.MJ_gmgt_getdate_in_input_box($result->start_date).'</span> To <span style="color: #f25656;







	   font-style: italic;">'.MJ_gmgt_getdate_in_input_box($result->expire_date).'</span> ';







        







			if(!empty($arranged_workout))







			{







			$message.='<table style="border-collapse: collapse; width: 100%; float: left;">







						  <thead>







							<tr>







								<th style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">'. esc_html__("Day Name","gym_mgt") .'</th>







								<th  style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">'. esc_html__("Time","gym_mgt").'</th>







								<th  style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">'. esc_html__("Description","gym_mgt").'</th>







							</tr>







						  </thead> <tbody> ';







			foreach($arranged_workout as $key=>$rowdata){ 







		   $message.='<tr>







		  <td rowspan=6 colspan=0 style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; "> '.$key.'</td>







			';







				 foreach($rowdata as $row)







				 {







					  $asd = explode('<span',$row);					  







						$message.='<tr>







						<td rowspan=1 style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[1].'</td>







						<td rowspan=1 style="padding: 8px;border-bottom: 1px solid #ddd;"><span'.$asd[2].'</td></tr>';







				 }







				$message.=' </tr>';







				 }







		$message.='







		</tbody>







		</table>';







			}







	$message.='</body>







</html>';		







	return $message;







}







//SUBMIT WORKOUT HTML CONTENT FUNCTION







// add_action('init' , 'MJ_gmgt_submit_workout_html_content');







function MJ_gmgt_submit_workout_html_content($workoutmember_id,$tcurrent_date)







{







		// $workoutmember_id = "3";







		// $tcurrent_date = "2022-09-01";







	     $message='';







		 $message.='<html>







          <head>







         <title>A Responsive Email Template</title>







          <meta charset="utf-8">







		   <meta name="viewport" content="width=device-width, initial-scale=1">







		   <meta http-equiv="X-UA-Compatible" content="IE=edge" />







		   <style type="text/css">















			*   {







			/* CLIENT-SPECIFIC STYLES */







			body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */







			table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */







			img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */















			/* RESET STYLES */







			img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}







			table{border-collapse: collapse !important;}







			body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}







			







			/* iOS BLUE LINKS */







			a[x-apple-data-detectors] 







			{







				color: inherit !important;







				text-decoration: none !important;







				font-size: inherit !important;







				font-family: inherit !important;







				font-weight: inherit !important;







				line-height: inherit !important;







			}







				







			/* MOBILE STYLES */







			@media screen and (max-width: 525px) 







			{				







				.activity_width







				{







					width:80%;







				}







				/* ALLOWS FOR FLUID TABLES */







				.wrapper {







				  width: 100% !important;







					max-width: 100% !important;







				}















				/* ADJUSTS LAYOUT OF LOGO IMAGE */







				.logo img {







				  margin: 0 auto !important;







				}















				/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */







				.mobile-hide {







				  display: none !important;







				}















				.img-max {







				  max-width: 100% !important;







				  width: 100% !important;







				  height: auto !important;







				}















				/* FULL-WIDTH TABLES */







				.responsive-table {







				  width: 100% !important;







				}















				/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */







				.padding {







				  padding: 10px 5% 15px 5% !important;







				}















				.padding-meta {







				  padding: 30px 5% 0px 5% !important;







				  text-align: center;







				}















				.padding-copy {







					padding: 10px 5% 10px 5% !important;







				  text-align: center;







				}















				.no-padding {







				  padding: 0 !important;







				}















				.section-padding {







				  padding: 50px 15px 50px 15px !important;







				}















				/* ADJUST BUTTONS ON MOBILE */







				.mobile-button-container {







					margin: 0 auto;







					width: 100% !important;







				}















				.mobile-button {







					padding: 15px !important;







					border: 0 !important;







					font-size: 16px !important;







					display: block !important;







				}







			}















				/* ANDROID CENTER FIX */







				div[style*="margin: 16px 0;"] { margin: 0 !important; }







			</style>







			<!--[if gte mso 12]>







			<style type="text/css">







			.mso-right {







				padding-left: 20px;







			}







			.activity_width







			{







				width:20%;







			}







			</style>







			<![endif]-->







			</head>







		    <body style="margin: 0 !important; padding: 0 !important;">';







		           







		    $obj_workout=new MJ_gmgt_workout;







		    $message='';







			$today_workouts=$obj_workout->MJ_gmgt_get_member_today_workouts($workoutmember_id,$tcurrent_date); 







			//var_dump($today_workouts);die;







				foreach($today_workouts as $value)







				{







					$workoutid=$value->user_workout_id;







					$activity_name=$value->workout_name;







					$workflow_category=$obj_workout->MJ_gmgt_get_user_workouts($workoutid,$activity_name);







					if($workflow_category->sets!='0')







						{







							$sets_progress=$value->sets*100/$workflow_category->sets;







						}







						else







						{







							$sets_progress=100;







						}







						if($workflow_category->reps!='0')







						{							







							$reps_progress=$value->reps*100/$workflow_category->reps;







						}







						else







						{







							$reps_progress=100;







						}







						if($workflow_category->kg!='0')







						{







							$kg_progress=$value->kg*100/$workflow_category->kg;







						}







						else







						{







							$kg_progress=100;







						}







						if($workflow_category->time!='0')







						{







							$rest_time_progress=$value->rest_time*100/$workflow_category->time;







						}







						else







						{







							$rest_time_progress=100;







						}







					







				       $message.='<table style="border-collapse: collapse; margin-bottom: 20px; width: 100%;">







						<thead style="float: left;width: 100%;">







							<tr>







							<h2>







								<th style="float: left;font-weight: bold;font-size: 22px;">'.$value->workout_name .'</th></h2>







							</tr>







						</thead>







						<tbody style="float: left;width: 100%;">';







	







					$message.='<tr style="display: flex !important;width: 100%;background-color: #F2F5FA;">







							<td style="padding: 20px;margin-top: 10px;width: 25%;font-size: 14px;">







								<div class="workout_box row" style="border-radius: 7px;width: 280px !important;height: 95px !important;background: #FFFFFF;box-shadow: 0px 0px 20px 1px rgb(0 0 0 / 10%);float: left;display: flex;">







									<div style="background-color: #b5fafb4d;width: 60px !important;    height: 60px;margin: 0 auto;float: none!important;display: block;padding: 0!important;margin-top: 20px !important;">







											<h2 style="margin-left: 5px;margin-top: 10px !important;font-weight: 600;font-size: 30px;line-height: 26px;text-align: center;color: #37CFD1;margin-bottom: 10px !important;padding: 7px;position: relative;width: 40px;z-index: 1 !important;">'.'1'.'</h2>







									</div>







									<div style="width: 66.6666666667%;padding-right: 0 !important;margin-top: 10px !important;">







										<div style="float: left;width: 100%;height: 40px;">







											<h3 style="font-size: 22px;float: left;font-weight: 600;text-align: center;color: #333333;margin-top: 10px;line-height: 26px;">Sets</h3>







										</div>







										<div style="width: 90%;float: left;height: 4px;background: #D9D9D9;" class="activity_progress_line"><div style="height:3px;background-color:#44CB7F;width:'.$sets_progress.'%;"></div></div>







											<div class="gmgt-card-title" style="float: left;margin-top: 0 !important;height: 40px;font-size: 16px;color: #818386;text-align: center;line-height: 35px;">







												<span>'.$value->sets.' Out Of '.$workflow_category->sets.' Sets</span>







										</div>







									</div>







								</div>







							</td>







							<td style="padding: 20px;margin-top: 10px;width: 25%;font-size: 14px;">







								<div class="workout_box row" style="border-radius: 7px;width: 280px !important;height: 95px !important;background: #FFFFFF;box-shadow: 0px 0px 20px 1px rgb(0 0 0 / 10%);float: left;display: flex;">







									<div style="background-color: #ff90541f;width: 60px !important;    height: 60px;margin: 0 auto;float: none!important;display: block;padding: 0!important;margin-top: 20px !important;">







											<h2 style="margin-left: 5px;margin-top: 10px !important;font-weight: 600;font-size: 30px;line-height: 26px;text-align: center;color: #FF9054;margin-bottom: 10px !important;padding: 7px;position: relative;width: 40px;z-index: 1 !important;">'.'2'.'</h2>







									</div>







									<div style="width: 66.6666666667%;padding-right: 0 !important;margin-top: 10px !important;">







										<div style="float: left;width: 100%;height: 40px;">







											<h3 style="font-size: 22px;float: left;font-weight: 600;text-align: center;color: #333333;margin-top: 10px;line-height: 26px;">Reps</h3>







										</div>







										<div style="width: 90%;float: left;height: 4px;background: #D9D9D9;" class="activity_progress_line"><div style="height:3px;background-color:#44CB7F;width:'.$reps_progress.'%;"></div></div>







											<div class="gmgt-card-title" style="float: left;margin-top: 0 !important;height: 40px;font-size: 16px;color: #818386;text-align: center;line-height: 35px;">







												<span>'.$value->reps.' Out Of '.$workflow_category->reps.' Reps</span>







										</div>







									</div>







								</div>







							</td>







							<td style="padding: 20px;margin-top: 10px;width: 25%;font-size: 14px;">







								<div class="workout_box row" style="border-radius: 7px;width: 280px !important;height: 95px !important;background: #FFFFFF;box-shadow: 0px 0px 20px 1px rgb(0 0 0 / 10%);float: left;display: flex;">







									<div style="background-color: #ffca6126;width: 60px !important;    height: 60px;margin: 0 auto;float: none!important;display: block;padding: 0!important;margin-top: 20px !important;">







											<h2 style="margin-left: 5px;margin-top: 10px !important;font-weight: 600;font-size: 30px;line-height: 26px;text-align: center;color: #FFCA61;margin-bottom: 10px !important;padding: 7px;position: relative;width: 40px;z-index: 1 !important;">'.'3'.'</h2>







									</div>







									<div style="width: 66.6666666667%;padding-right: 0 !important;margin-top: 10px !important;">







										<div style="float: left;width: 100%;height: 40px;">







											<h3 style="font-size: 22px;float: left;font-weight: 600;text-align: center;color: #333333;margin-top: 10px;line-height: 26px;">KG</h3>







										</div>







										<div style="width: 90%;float: left;height: 4px;background: #D9D9D9;" class="activity_progress_line"><div style="height:3px;background-color:#44CB7F;width:'.$kg_progress.'%;"></div></div>







											<div class="gmgt-card-title" style="float: left;margin-top: 0 !important;height: 40px;font-size: 16px;color: #818386;text-align: center;line-height: 35px;">







												<span>'.$value->kg.' Out Of '.$workflow_category->kg.' Kg</span>







										</div>







									</div>







								</div>







							</td>







							<td style="padding: 20px;margin-top: 10px;width: 25%;font-size: 14px;">







								<div class="workout_box row" style="border-radius: 7px;width: 280px !important;height: 95px !important;background: #FFFFFF;box-shadow: 0px 0px 20px 1px rgb(0 0 0 / 10%);float: left;display: flex;">







									<div style="background-color: #44cb7f1a;width: 60px !important;    height: 60px;margin: 0 auto;float: none!important;display: block;padding: 0!important;margin-top: 20px !important;">







											<h2 style="margin-left: 5px;margin-top: 10px !important;font-weight: 600;font-size: 30px;line-height: 26px;text-align: center;color: #44CB7F;margin-bottom: 10px !important;padding: 7px;position: relative;width: 40px;z-index: 1 !important;">'.'4'.'</h2>







									</div>







									<div style="width: 66.6666666667%;padding-right: 0 !important;margin-top: 10px !important;">







										<div style="float: left;width: 100%;height: 40px;">







											<h3 style="font-size: 22px;float: left;font-weight: 600;text-align: center;color: #333333;margin-top: 10px;line-height: 26px;">Rest Time</h3>







										</div>







										<div style="width: 90%;float: left;height: 4px;background: #D9D9D9;" class="activity_progress_line"><div style="height:3px;background-color:#44CB7F;width:'.$rest_time_progress.'%;"></div></div>







											<div class="gmgt-card-title" style="float: left;margin-top: 0 !important;height: 40px;font-size: 16px;color: #818386;text-align: center;line-height: 35px;">







												<span>'.$value->time.' Out Of '.$workflow_category->time.' Rest Time</span>







										</div>







									</div>







								</div>







							</td>







						</tr>';					







										







					$message.='</tbody>







					</table>';







				} 		







		return $message;			 







}







//this function use in image validation in add time







function MJ_gmgt_check_valid_extension($filename)







{







	$flag = 2; 







	if($filename != '')







	{







		 $flag = 0;







		 $ext = pathinfo($filename, PATHINFO_EXTENSION);







		 $valid_extension = ['gif','png','jpg','jpeg','bmp',""];







		if(in_array($ext,$valid_extension) )







		{







		  $flag = 1;







		}







	}







      return $flag;







}			







//This function use in document validation in add time







function MJ_gmgt_check_valid_file_extension($filename)







{







	$flag = 2; 







	if($filename != '')







	{







		$flag = 0;







		$ext = pathinfo($filename, PATHINFO_EXTENSION);







		$valid_extension = ['pdf',""];







		if(in_array($ext,$valid_extension) )







		{







			$flag = 1;







		}







	}







	return $flag;







}







//count total in tax module







function MJ_gmgt_count_store_total()







{ 







	$total_amount_withtax=0;







	$discount=$_POST['discount_amount'];







	$quantity=$_POST['quantity'];







	$Product=$_POST['Product'];







	$tax=$_POST['tax'];







	$obj_product=new MJ_gmgt_product();







	 $product_data=$obj_product->MJ_gmgt_get_single_product($Product);







	 $price=$product_data->price;







	 $total_price=(int)$price * (int)$quantity;







	 $total_amount_minusdiscount=$total_price - $discount;







	 $total_tax=$total_amount_minusdiscount * $tax/100;







	 $total_amount_withtax=$total_amount_minusdiscount + $total_tax;







	echo $total_amount_withtax;







	die();







} 







//GET DATE FORMATE FOR DATABASE FUNCTION







function MJ_gmgt_get_format_for_db($date)







{







	if(!empty($date))







	{







		$date = trim($date);







		$new_date = DateTime::createFromFormat(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), $date);



		



		$new_date=$new_date->format('Y-m-d');







		return $new_date;







	}







	else







	{







		$new_date ='';







		return $new_date;







	}







}







//GET DATE FORMATE FOR DATABASE FUNCTION API







function MJ_gmgt_get_format_for_db_api($date)







{







	if(!empty($date))







	{







		$date = trim($date);







		$new_date = DateTime::createFromFormat(MJ_gmgt_get_phpdateformat('yy-mm-dd'), $date);







		$new_date=$new_date->format('Y-m-d');







		return $new_date;







	}







	else







	{







		$new_date ='';







		return $new_date;







	}







}







//userwise access Right array







function MJ_gmgt_userwise_access_right()







{







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







		







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');







	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}







	return $menu;







}







//page wise access right







function MJ_gmgt_get_userrole_wise_page_access_right_array()







{







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







		







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');







	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}







	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{				







			if ($_REQUEST ['page'] == $value['page_link'])







			{				







				return $value;







			}







		}







	}	







}







//manually page wise access right







function MJ_gmgt_get_userrole_wise_manually_page_access_right_array($page)







{







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







		







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');







	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}







	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{				







			if ($page == $value['page_link'])







			{				







				return $value;







			}







		}







	}	







}







//dashboard page access right







function MJ_gmgt_page_access_rolewise_accessright_dashboard($page)







{







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







		







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');







	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{				







				if($value['view']=='0')







				{			







					$flage=0;







				}







				else







				{







					$flage=1;







				}







			}







		}







	}	







	







	return $flage;







} 







//dashboard  count total member by access right







function MJ_gmgt_count_total_member_dashboard_by_access_right($page)







{







	$curr_user_id=get_current_user_id();







	 







	 







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







	 







 







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');







		







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	







	foreach ( $menu as $key1=>$value1 ) 







	{		







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{		







				if($obj_gym->role == 'member')







				{	







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();







						$membersdata=array();







						$membersdata[] = get_userdata($user_id);			







					}







					else







					{







						$membersdata =get_users( array('role' => 'member'));







					}	







				}







				elseif($obj_gym->role == 'staff_member')







				{







					if($value['own_data']=='1')







					{







						$membersdata = get_users(array('meta_key' => 'staff_id', 'meta_value' =>$curr_user_id ,'role'=>'member'));		







					}







					else







					{







						$membersdata =get_users( array('role' => 'member'));







					}







				}







				else







				{







					$membersdata =get_users( array('role' => 'member'));







				}







				$membersdata_count= count($membersdata);







				return $membersdata_count;







			}







		}







	}	







}







//dashboard count total staff member by access right







function MJ_gmgt_count_total_staff_member_dashboard_by_access_right($page)







{







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







		







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{		







				if($obj_gym->role == 'member')







				{	







					if($value['own_data']=='1')







					{







						







						$user_id=get_current_user_id();







						$staff_id = get_user_meta( $user_id,'staff_id', true ); 







						$staffdata=array();







						$staffdata[] = get_userdata($staff_id);







						







					}







					else







					{







						







						$get_staff = array('role' => 'Staff_member');







						$staffdata=get_users($get_staff);







					}	







				}







				elseif($obj_gym->role == 'staff_member')







				{







					if($value['own_data']=='1')







					{







						$staff_id=get_current_user_id();







						







						$staffdata=array();







						$staffdata[] = get_userdata($staff_id);







						







					}







					else







					{







						$get_staff = array('role' => 'Staff_member');







						$staffdata=get_users($get_staff);







					}







				}	







				else







				{







					$get_staff = array('role' => 'Staff_member');







					$staffdata=get_users($get_staff);







				}







				







				$staffdata_count= count($staffdata);







				return $staffdata_count;







			}







		}







	}	







}







//dashboard count total GROUP by access right







function MJ_gmgt_count_total_group_dashboard_by_access_right($page)







{







	$obj_group=new MJ_gmgt_group;







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







		







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{		







				if($obj_gym->role == 'member')







				{	







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();







						$groupdata=$obj_group->MJ_gmgt_get_member_all_groups($user_id);			







					}







					else







					{







						$groupdata=$obj_group->MJ_gmgt_get_all_groups();







					}	







				}







				elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')







				{







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();							







						$groupdata=$obj_group->MJ_gmgt_get_all_groups_by_created_by($user_id);			







					}







					else







					{







						$groupdata=$obj_group->MJ_gmgt_get_all_groups();







					}







				}







				







				$groupdata_count= count($groupdata);







				return $groupdata_count;







			}







		}







	}	







}







//dashboard count total MEMBERRSHIP by access right







function MJ_gmgt_count_total_membership_dashboard_by_access_right($page)







{







	$obj_membership=new MJ_gmgt_membership;







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







		







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{		







				if($obj_gym->role == 'member')







				{	







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();







						$membership_id = get_user_meta( $user_id,'membership_id', true ); 







						$membershipdata=$obj_membership->MJ_gmgt_get_member_own_membership($membership_id);		







						 







					}







					else







					{







						$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();







					}	







				}







				elseif($obj_gym->role == 'staff_member' || $obj_gym->role == 'accountant')







				{







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();							







						$membershipdata=$obj_membership->MJ_gmgt_get_membership_by_created_by($user_id);			







					}







					else







					{







						$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();







					}







				}







				







				$membershipdata_count= count($membershipdata);







				return $membershipdata_count;







			}







		}







	}	







}







//dashboard count total class by access right







function MJ_gmgt_count_total_class_dashboard_by_access_right($page)







{







	$obj_class=new MJ_gmgt_classschedule;







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







		







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{		







				//GET CLASS LIST DATA







				if($obj_gym->role == 'staff_member')







				{







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();							







						$classdata=$obj_class->MJ_gmgt_get_all_classes_by_staffmember($user_id);	







					}







					else







					{







						$classdata=$obj_class->MJ_gmgt_get_all_classes();







					}







				}







				elseif($obj_gym->role == 'member')







				{		







					if($value['own_data']=='1')







					{







						$cur_user_class_id = array();







						$curr_user_id=get_current_user_id();







						$cur_user_class_id = MJ_gmgt_get_current_user_classis($curr_user_id);







						$classdata=$obj_class->MJ_gmgt_get_all_classes_by_member($cur_user_class_id);	







					}







					else







					{







						$classdata=$obj_class->MJ_gmgt_get_all_classes();







					}







				}







				else







				{		







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();							







						$classdata=$obj_class->MJ_gmgt_get_all_classes_by_class_created_id($user_id);	







					}







					else







					{







						$classdata=$obj_class->MJ_gmgt_get_all_classes();







					}







				}







			 







				$classdata_count= count($classdata);







				return $classdata_count;







			}







		}







	}	







}







//dashboard count total reservation by access right







function MJ_gmgt_count_total_reservation_dashboard_by_access_right($page)







{







	$obj_reservation=new MJ_gmgt_reservation;







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{		







				//GET CLASS LIST DATA







				if($obj_gym->role == 'staff_member')







				{







					if($value['own_data']=='1')







					{







						$reservationdata=$obj_reservation->MJ_gmgt_get_reservation_by_created_by();







					}







					else







					{







						$reservationdata=$obj_reservation->MJ_gmgt_get_all_reservation();







					}	







				}







				elseif($obj_gym->role == 'member')







				{		







					if($value['own_data']=='1')







					{







						$reservationdata=$obj_reservation->MJ_gmgt_get_reservation_by_created_by();







					}







					else







					{







						$reservationdata=$obj_reservation->MJ_gmgt_get_all_reservation();







					}	







				}







				else







				{		







					if($value['own_data']=='1')







					{







						$reservationdata=$obj_reservation->MJ_gmgt_get_reservation_by_created_by();







					}







					else







					{







						$reservationdata=$obj_reservation->MJ_gmgt_get_all_reservation();







					}	







				}







			 







				$reservationdata_count= count($reservationdata);







				return $reservationdata_count;







			}







		}







	}	







}







//dashboard count total product by access right







function MJ_gmgt_count_total_product_dashboard_by_access_right($page)







{







	$obj_product=new MJ_gmgt_product;







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{		







				//GET CLASS LIST DATA







				if($obj_gym->role == 'staff_member')







				{







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();







						$productdata=$obj_product->MJ_gmgt_get_all_product_by_created_by($user_id);







					}







					else







					{







						$productdata=$obj_product->MJ_gmgt_get_all_product();







					}	







				}







				elseif($obj_gym->role == 'member')







				{		







					if($value['own_data']=='1')







					{







						$user_id=get_current_user_id();







						$productdata=$obj_product->MJ_gmgt_get_all_product_by_created_by($user_id);







					}







					else







					{







						$productdata=$obj_product->MJ_gmgt_get_all_product();







					}







				}







				else







				{		







					if($value['own_data']=='1')







						{







							$user_id=get_current_user_id();







							$productdata=$obj_product->MJ_gmgt_get_all_product_by_created_by($user_id);







						}







						else







						{







							$productdata=$obj_product->MJ_gmgt_get_all_product();







						}	







				}







			 







				$productdata_count= count($productdata);







				return $productdata_count;







			}







		}







	}	







}







//dashboard count total product by access right







function MJ_gmgt_count_total_notice_dashboard_by_access_right($page)







{







	$obj_notice=new MJ_gmgt_notice;







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);















	$role = $obj_gym->role;







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');	







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}	







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{		







				//GET CLASS LIST DATA







				if($obj_gym->role == 'staff_member')







				{







					if($value['own_data']=='1')







					{







						$noticedata =$obj_notice->MJ_gmgt_get_notice($obj_gym->role);







					}







					else	







					{







						$noticedata =$obj_notice->MJ_gmgt_get_all_notice();







					}	







				}







				elseif($obj_gym->role == 'member')







				{		







					if($value['own_data']=='1')







					{







						$noticedata =$obj_notice->MJ_gmgt_get_notice($obj_gym->role);







					}







					else	







					{







						$noticedata =$obj_notice->MJ_gmgt_get_all_notice();







					}	







				}







				else







				{		







					if($value['own_data']=='1')







					{







						$noticedata =$obj_notice->MJ_gmgt_get_notice($obj_gym->role);







					}







					else	







					{







						$noticedata =$obj_notice->MJ_gmgt_get_all_notice();







					}	







				}







			 







				$noticedata_count= count($noticedata);







				return $noticedata_count;







			}







		}







	}	







}







//ACCESS PERMISION ALERT MESSAGE FUNCTION







function MJ_gmgt_access_right_page_not_access_message()







{







	?>







	<script type="text/javascript">







		$(document).ready(function() 







		{







			"use strict";			







			alert("<?php esc_html_e('You do not have permission to perform this operation.','gym_mgt');?>");







			window.location.href='?dashboard=user';







		});







	</script>







<?php







}	







//REMOVE TAG AND SLASH FROM STRING FUNCTION 







function MJ_gmgt_strip_tags_and_stripslashes($post_string)



{







	$string = str_replace('&nbsp;', ' ', $post_string);







    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');







    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');







    $string = html_entity_decode($string);







    $string = htmlspecialchars_decode($string);







    $string = strip_tags($string);







	return $string;







}







function MJ_gmgt_password_validation($post_string)







{







	$string = str_replace('&nbsp;', ' ', $post_string);







    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');







    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');







    $string = html_entity_decode($string);







    $string = htmlspecialchars_decode($string);







    $string = strip_tags($string);







	return $string;







}







//TIME AM PM BEFORE COLON REMOVE FUNCTION







function MJ_gmgt_timeremovecolonbefoream_pm($timevalue)







{















	if (strpos($timevalue, 'am') == true)







	{







		$time=str_replace(":am"," am",$timevalue);







		$am_translate=esc_html__('am','gym_mgt');







		$time_translate=str_replace(" am"," ".$am_translate,$time);







	}







	elseif (strpos($timevalue, 'pm') == true)







	{







		$time=str_replace(":pm"," pm",$timevalue);







		$am_translate=esc_html__('pm','gym_mgt');







		$time_translate=str_replace(" pm"," ".$am_translate,$time);







	}







	else







	{







		$time_translate='';







	}







	return $time_translate;







}







//FRONTED MEMBERRSHIP PAYMENT FUNCTION







function MJ_gmgt_frontend_side_membership_payment_function($pay_id,$customer_id,$amount,$trasaction_ids,$payment_method)







{







   global $wpdb;







	$obj_membership_payment=new MJ_gmgt_membership_payment;







	$obj_membership=new MJ_gmgt_membership;	







	$obj_member=new MJ_gmgt_member;







	if(isset($trasaction_ids))







	{







		$trasaction_id  = $trasaction_ids;







	}







	else







	{







	  $trasaction_id  = '';







	}







	$joiningdate=date("Y-m-d");







	$membership=$obj_membership->MJ_gmgt_get_single_membership($pay_id);







	$validity=$membership->membership_length_id;







	$expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));







	$membership_status = 'continue';







	$payment_data = array();







	 







		global $wpdb;







		//invoice number generate







		$table_income=$wpdb->prefix.'gmgt_income_expense';







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







		$payment_data['invoice_no']=$invoice_no;







		$payment_data['member_id'] = $customer_id;







		$payment_data['membership_id'] = $pay_id;







		$payment_data['membership_fees_amount'] = $amount;







		$payment_data['membership_signup_amount'] = MJ_gmgt_get_membership_signup_amount($pay_id);







		$payment_data['tax_amount'] = MJ_gmgt_get_membership_tax_amount($pay_id,'');







		$membership_amount=$payment_data['membership_fees_amount'] + $payment_data['membership_signup_amount'];







		$payment_data['membership_amount'] = $membership_amount;







		$payment_data['start_date'] = $joiningdate;







		$payment_data['end_date'] = $expiredate;







		$payment_data['membership_status'] = $membership_status;







		$payment_data['payment_status'] = 0;







		$payment_data['created_date'] = date("Y-m-d");







		$payment_data['created_by'] = $customer_id;







		$plan_id = $obj_member->MJ_gmgt_add_membership_payment_detail($payment_data);







		//save membership payment data into income table							







		$membership_name=MJ_gmgt_get_membership_name($pay_id);







		$entry_array[]=array('entry'=>$membership_name,'amount'=>MJ_gmgt_get_membership_price($pay_id));







		$entry_array1[]=array('entry'=>esc_html__("Membership Signup Fee","gym_mgt"),'amount'=>$amount);	







		$entry_array_merge=array_merge($entry_array,$entry_array1);		







		$incomedata['entry']=json_encode($entry_array_merge);	







		$incomedata['invoice_type']='income';







		$incomedata['invoice_label']=esc_html__("Fees Payment","gym_mgt");







		$incomedata['supplier_name']=$customer_id;







		$incomedata['invoice_date']=date('Y-m-d');







		$incomedata['receiver_id']=$customer_id;







		$incomedata['amount']=$membership_amount;







		$incomedata['total_amount']=$membership_amount;







		$incomedata['invoice_no']=$invoice_no;







		$incomedata['paid_amount']=$amount;







		$incomedata['tax_id']=MJ_gmgt_get_membership_tax($pay_id);







		$incomedata['payment_status']='Fully Paid';







		$result_income=$wpdb->insert( $table_income,$incomedata); 







	$feedata['mp_id']=$plan_id;	







	$feedata['amount']=$amount;







	$feedata['payment_method']=$payment_method;







	$feedata['trasaction_id']=$trasaction_id;







	$feedata['created_by']=$customer_id;







	$result=$obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);







	if($result)







	{







		$u = new WP_User($customer_id);







		$u->remove_role( 'subscriber' );







		$u->add_role( 'member' );







		







		//$gmgt_hash=delete_user_meta($customer_id, 'gmgt_hash');







		







		update_user_meta( $customer_id, 'membership_id', $pay_id );					







	}







    return $result;			







}







//get tax Name by tax id array







function MJ_gmgt_tax_name_by_tax_id_array($tax_id_string)







{







	$obj_tax=new MJ_gmgt_tax;







	







	$tax_name=array();







	$tax_id_array=explode(",",$tax_id_string);







	$tax_name_string="";







	if(!empty($tax_id_string))







	{







		foreach($tax_id_array as $tax_id)







		{







			$gmgt_taxs=$obj_tax->MJ_gmgt_get_single_tax_data($tax_id);	







			if(!empty($gmgt_taxs))







			{	







				$tax_name[]=$gmgt_taxs->tax_title.' - '.$gmgt_taxs->tax_value;







			}







		}	







		$tax_name_string=implode(",",$tax_name);		







	}	







	return $tax_name_string;







	die;







}







//get tax percentage by tax id







function MJ_gmgt_tax_percentage_by_tax_id($tax_id)







{







	$obj_tax=new MJ_gmgt_tax;







	if(!empty($tax_id))







	{	







		$gmgt_taxs=$obj_tax->MJ_gmgt_get_single_tax_data($tax_id);		







	}







	else







	{







		$gmgt_taxs='';







	}







	







	if(!empty($gmgt_taxs))







	{







		return $gmgt_taxs->tax_value;







	}







	else







	{







		return 0;







	}







	die;







}







//get reservation time convert in 24 hour







function MJ_gmgt_get_reservation_time_in_24_hours($time)







{







	$time_array = explode(":",$time);







	$time_array_new = $time_array[0].":".$time_array[1]."".$time_array[2];







	$time_formate =  date("H:i", strtotime($time_array_new)); 







	return $time_formate;







	die;







}







//Html Tags special character remove from sring







function MJ_gmgt_remove_tags_and_special_characters($string)







{	







	$search = array('!','@','#','$','%','^','&','*','(',')','.','{','}','<','>',',','+','-','*');







	$replace = array('','','','','','','','','','','','','','','','','','','');







	$new_string=str_replace($search, $replace,strip_tags($string));















	return $new_string;







}







//activity category list from activity category type in membership







function MJ_gmgt_get_activity_from_category_type()







{







	$obj_activity=new MJ_gmgt_activity;







	$action_membership=$_REQUEST['action_membership'];







	$membership_id_activity=$_REQUEST['membership_id_activity'];







	$selected_activity_category_list=$_REQUEST['selected_activity_category_list'];







	$category_array_to_string = implode("','",$selected_activity_category_list);







	$array_var= array();







	







	global $wpdb;







	$table_gmgt_activity = $wpdb->prefix. 'gmgt_activity';







	$activities = $wpdb->get_results("SELECT * FROM $table_gmgt_activity where activity_cat_id IN ('".$category_array_to_string."')");







		







	if(!empty($activities))







	{







		foreach($activities as $activity)







		{			







			if($action_membership=='add_membership')







			{







				$array_var[]='<option value="'.$activity->activity_id.'">'.$activity->activity_title.'</option>';		 







			}







			else







			{







				$activity_array = $obj_activity->MJ_gmgt_get_membership_activity($membership_id_activity);







				$selected = "";







				if(in_array($activity->activity_id,$activity_array))







					$selected = "selected";







				







				$array_var[]='<option value="'.$activity->activity_id.'" '.$selected.'>'.$activity->activity_title.'</option>';







			}		







		}	







	}	







	







	echo json_encode($array_var);







	die();







}







// activity category on change to  specialization staff member list in activity//







function MJ_gmgt_get_staff_member_list_by_specilization_category_type()







{







	$obj_activity=new MJ_gmgt_activity;







	$activity_category=$_REQUEST['activity_category'];	







	$array_var= array();







	







	$get_staff = array('role' => 'Staff_member');







	$staffdata=get_users($get_staff);		







	







	$staff_data=$result->activity_assigned_to;







	$array_var[]='<option value="">'.esc_html__('Select Staff Member','gym_mgt').'</option>';







	if(!empty($staffdata))







	{







		foreach($staffdata as $staff)







		{		







			$staff_specialization=explode(',',$staff->activity_category);







			if(in_array($activity_category,$staff_specialization))







			{	







				$array_var[]='<option value="'.$staff->ID.'">'.$staff->display_name.'</option>';







			}			







		}	







	}	







	echo json_encode($array_var);







	die();







}







//Get member Current membership  Activity list in Assign Workout //







function MJ_gmgt_get_member_current_membership_activity_list()







{







	global $wpdb;







	$table_membership = $wpdb->prefix. 'gmgt_membershiptype';







	$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';







	







	$member_id=$_REQUEST['member_id'];	







	$array_var= array();







	$membersip_activity_array= array();







	$membership_id=get_user_meta( $member_id,'membership_id',true);







	







	$result = $wpdb->get_row("SELECT * FROM $table_membership where membership_id= $membership_id");







	$result1 = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where membership_id= $membership_id");







	if(!empty($result1))







	{







		foreach ($result1 as $data)







		{







			$membersip_activity_array[]=$data->activity_id;







		}







	}	







	if(!empty($result->activity_cat_id))







	{







		$activity_cat_id=explode(',',$result->activity_cat_id);	







	}







	else







	{







		$activity_cat_id='';







	}







	$membersip_activity_category_array=$activity_cat_id;







	







	$activity_category=MJ_gmgt_get_all_category('activity_category');







	







	if(!empty($membersip_activity_category_array))







	{







		if(!empty($activity_category))







		{







			foreach ($activity_category as $retrive_data)







			{	







				if (in_array((string)$retrive_data->ID, $membersip_activity_category_array))







				{					







					$array_var[]='<label class="activity_title"><strong>'.$retrive_data->post_title.'</strong></label>';			







					$activitydata =MJ_gmgt_get_activity_by_category($retrive_data->ID);







					foreach($activitydata as $activity)







					{ 	







						if (in_array((string)$activity->activity_id, $membersip_activity_array))







						{				







							$array_var[]='<div class="checkbox child marign_left_20_res">







								<label class="col-sm-2 padding_top_bottom_7">







								<input type="checkbox"   value="" name="avtivity_id[]" value="'.$activity->activity_id.'" class="activity_check" id="'.$activity->activity_id.'" data-val="activity" activity_title = "'.$activity->activity_title.'">'.$activity->activity_title.'</label><div id="reps_sets_'.$activity->activity_id.'" class="col-sm-12 padding_0"></div>







							</div><div class="clear"></div>';	







						}						







					}







								







					$array_var[]='<div class="clear"></div>';				







				}







			}







		}







	}







	else







	{







		$array_var[]='<p>'.esc_html__('No Any Activity Added In This Member Current Membership Please Add Activity Into This Member Current Membership.','gym_mgt').'</p>';







	}















	echo json_encode($array_var); 







	die();







}







//-------DATA TABLE MULTILANGUAGE----------- //







function MJ_gmgt_datatable_multi_language()







{







	$datatable_attr=array("sEmptyTable"=> esc_html__("No data available in table","gym_mgt"),







						"sInfo"=>esc_html__("Showing _START_ to _END_ of _TOTAL_ entries","gym_mgt"),







						"sInfoEmpty"=>esc_html__("Showing 0 to 0 of 0 entries","gym_mgt"),







						"sInfoFiltered"=>esc_html__("(filtered from _MAX_ total entries)","gym_mgt"),







						"sInfoPostFix"=> "",







						"sInfoThousands"=>",",







						"sLengthMenu"=>esc_html__(" _MENU_ ","gym_mgt"),







						







						"sLoadingRecords"=>esc_html__("Loading...","gym_mgt"),







						"sProcessing"=>esc_html__("Processing...","gym_mgt"),







						"sSearch"=>esc_html__("","gym_mgt"),







						"sZeroRecords"=>esc_html__("No matching records found","gym_mgt"),







						"oPaginate"=>array(







							"sFirst"=>esc_html__("First","gym_mgt"),







							"sLast"=>esc_html__("Last","gym_mgt"),







							"sNext"=>esc_html__("Next","gym_mgt"),







							"sPrevious"=>esc_html__("Previous","gym_mgt")







						),







						"oAria"=>array(







							"sSortAscending"=>esc_html__(": activate to sort column ascending","gym_mgt"),







							"sSortDescending"=>esc_html__(": activate to sort column descending","gym_mgt")







						),







						"buttons"=>array(







							"colvis"=>esc_html__("Column Visibility","gym_mgt"),







							"print"=>esc_html__("Print","gym_mgt"),







							"pdf"=>esc_html__("PDF","gym_mgt")







						)















	);







	







	return $data=json_encode( $datatable_attr);







}







//show event and task model code







function MJ_gmgt_show_event_task()







{	







	$id = $_REQUEST['id'];	







	 







	$model = $_REQUEST['model'];







	$obj_class=new MJ_gmgt_classschedule;







	if($model=='Membership Details')







	{







		$obj_membership=new MJ_gmgt_membership;







		$membershipdata=$obj_membership->MJ_gmgt_get_single_membership($id);







	}







	if($model=='Activities Details')







	{







		$obj_activity=new MJ_gmgt_activity;







		$activitydata =$obj_activity->MJ_gmgt_get_single_activity($id);







	}







	if($model=='Invoice Details')







	{







		$obj_payment=new MJ_gmgt_payment;







		$paymentdata=$obj_payment->MJ_gmgt_update_incomedata_bymp_id($id);







	}







	if($model=='Reservation Details')







	{







		$obj_reservation=new MJ_gmgt_reservation;







		$reservationdata=$obj_reservation->MJ_gmgt_get_single_reservation($id);







	}







	if($model=='Notice Details')







	{







		$noticedata =get_post($id);







	}







	if($model=='Group Details')







	{







		$obj_group=new MJ_gmgt_group;







		$groupdata =$obj_group->MJ_gmgt_get_single_group($id);







	}







	if($model=='Class Details')







	{







		$classdata =$obj_class->MJ_gmgt_get_single_class($id);







	}







	if($model=='Booking Details')







	{







		$bookingdata =$obj_class->MJ_gmgt_get_single_booked_class_($id);







	}







	if($model=='Message Details')







	{







		







		$messagedata =MJ_gmgt_get_message_by_id($id);







	}







	?>







     <div class="modal-header model_header_padding dashboard_model_header"> 







		<a href="javascript:void(0);" class="event_close-btn badge badge-success pull-right dashboard_pop-up_design">







			<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt="">







		</a>







  		<h4 id="myLargeModalLabel" class="modal-title">







			<?php 







			if($model=='Membership Details')







			{ ?>







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Membership.png"?>">







				<?php







				esc_html_e('Membership Details','gym_mgt'); 







			} 







			if($model=='Activities Details')







			{ ?>







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Payment.png"?>">







				<?php







				esc_html_e('Activity Details','gym_mgt'); 







			} 







			elseif($model=='Invoice Details')







			{ 







				?>







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Payment.png"?>">







				<?php







				esc_html_e('Invoice Details','gym_mgt'); 







			} 



		



			elseif($model=='Reservation Details')







			{ 







				esc_html_e('Reservation Details','gym_mgt'); 







			} 







			elseif($model=='Notice Details')







			{?>







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/notice.png"?>">







				<?php







				 esc_html_e('Notice Details','gym_mgt'); 







			} 







			elseif($model=='Group Details')







			{ 







				esc_html_e('Group Details','gym_mgt'); 







			} elseif($model=='Class Details')







			{ 







				esc_html_e('Class Details','gym_mgt'); 







			} 







			elseif($model=='Booking Details')







			{ 



				?>







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Class Schedule.png"?>">







				<?php



				esc_html_e('Booking Details','gym_mgt'); 







			}







			elseif($model=='Message Details')







			{ ?>







				<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Message.png"?>">







				<?php







				esc_html_e('Message Details','gym_mgt'); 







			}







			?>







			







		</h4>







	</div>















	<div class="panel-white">







		<?php







		if($model=='Membership Details')







		{







		?>







			<div class="modal-body view_details_body_assigned_bed view_details_body">







				<div class="row">







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Name', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo esc_html($membershipdata->membership_label); ?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e('Category','gym_mgt');?>







						</label><br>







						<label for="" class="label_value">







							<?php echo get_the_title(esc_html($membershipdata->membership_cat_id)); ?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e('Members Limit','gym_mgt');?>







						</label><br>







						<label for="" class="label_value">







							<?php 







								if($membershipdata->membership_class_limit!='unlimited')







								{







									echo esc_html($membershipdata->on_of_member);







								}







								else







								{







									esc_html_e('Unlimited','gym_mgt');







								}







							?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e('Class Limit','gym_mgt');?>







						</label><br>







						<label for="" class="label_value">







							<?php 







								if($membershipdata->classis_limit!='unlimited')







								{







									echo esc_html($membershipdata->on_of_classis);







								}







								else







								{







									esc_html_e('Unlimited','gym_mgt');







								}				







							?>			







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e( 'Period(Days)', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo esc_html($membershipdata->membership_length_id); ?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e( 'Membership Amount', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($membershipdata->membership_amount); ?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e( 'Installment Plan', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo $membershipdata->installment_amount." ".get_the_title( $membershipdata->install_plan_id ); ?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e( 'Signup Fee', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo esc_html($membershipdata->signup_fee); ?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e( 'Tax', 'gym_mgt' ) ;?>(%) 







						</label><br>







						<label for="" class="label_value">







							<?php 







							if(!empty($membershipdata->tax)) 







							{ 







								echo MJ_gmgt_tax_name_by_tax_id_array($membershipdata->tax); 







							}







							else







							{ 







								echo 'N/A'; 







							} ?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e( 'Frontend Booking', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php



							$class_book_approve = $membershipdata->gmgt_membership_class_book_approve;



							if($class_book_approve == 'no')



							{



								echo esc_html_e('No','gym_mgt');



							}elseif ($class_book_approve == 'yes') {



								echo esc_html_e('Yes','gym_mgt');



							}



							else{



								echo "N/A";



							}



							?>



						</label>







					</div>















					<div class="col-md-12 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php esc_html_e('Description','gym_mgt');?>







						</label><br>







						<label for="" class="label_value">







							<?php 







							if(!empty($membershipdata->membership_description))







							{







								echo stripslashes($membershipdata->membership_description);







							}







							else







							{







								echo "N/A";







							}







							?>







						</label>







					</div>







				</div>







			</div>   		







		<?php







		}







		?>















		<?php







		if($model=='Message Details')







		{







		?>







			<div class="modal-body view_details_body_assigned_bed view_details_body">







				<div class="row">







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Message From', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo MJ_gmgt_get_display_name(esc_html($messagedata->sender));?>







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Subject', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo $messagedata ->subject; ?>







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Date', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo MJ_gmgt_getdate_in_input_box($messagedata->date); ?>







						</label>







					</div>















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Description', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo $messagedata ->message_body; ?>







						</label>







					</div>















					







				</div>







			</div>   		







		<?php







		}







		?>















		<?php







		if($model=='Activities Details')







		{







		?>







			<div class="modal-body view_details_body_assigned_bed view_details_body">







				<div class="row">















					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Category', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo esc_html (get_the_title($activitydata->activity_cat_id)); ?>







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Title', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php echo esc_html($activitydata->activity_title); ?>







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Membership Name', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php















								$activity_id=$activitydata->activity_id;







								$obj_activity=new MJ_gmgt_activity;







								$activity_membership_list = $obj_activity->MJ_gmgt_get_activity_membership($activity_id);







								if(!empty($activity_membership_list))







								{







									







									foreach($activity_membership_list as $retrieved_data)







									{







										







										$obj_membership=new MJ_gmgt_membership;







										$membership_data = $obj_membership->MJ_gmgt_get_single_membership($retrieved_data);







									







										$membership_name[]=$membership_data->membership_label;







										







									}







										$member_all_name=implode(" ,",$membership_name);







										echo esc_html($member_all_name);







								}







								else







								{







									echo "N/A";







								}







								







							?>







							







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading">







							<?php  esc_html_e( 'Staff Member Name', 'gym_mgt' ) ;?>







						</label><br>







						<label for="" class="label_value">







							<?php 







							if(!empty($activitydata->activity_assigned_to))







							{







								$user=get_userdata($activitydata->activity_assigned_to);







								if(!empty($user->display_name))







								{







									echo esc_html($user->display_name);







								}







								else







								{







									echo "N/A";







								}







							}







							else







							{







								echo "N/A";







							}







							?>







						</label>







					</div>







				</div>







			</div>   		







		<?php







		}







		?>







		<?php







		if($model=='Invoice Details')







		{







		?>







			<div class="modal-body view_details_body_assigned_bed view_details_body">







				<div class="row">







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_attr_e('Invoice No.', 'gym_mgt'); ?></label><br>







						<label for="" class="label_value"><?php echo esc_html($paymentdata->invoice_no); ?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Income Type', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo esc_html($paymentdata->invoice_label); ?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Member Name', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value">







							<?php $user=get_userdata($paymentdata->supplier_name);







								$memberid=get_user_meta($paymentdata->supplier_name,'member_id',true);







								$display_label=$user->display_name;







								if($memberid)







								$display_label.=" (".$memberid.")";







								echo esc_html($display_label);







							?>







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Total Amount', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($paymentdata->total_amount),2);?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php  esc_html_e( 'Discount Amount', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($paymentdata->discount),2);?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php  esc_html_e( 'Tax Amount', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value">







							<?php







							$total_tax=0;







							$tax_array=explode(',',$paymentdata->tax_id);







							$total_discount_amount= $paymentdata->amount - $paymentdata->discount;







						







						







							foreach($tax_array as $tax_id)







							{







								$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







								







								$tax_amount=$total_discount_amount * $tax_percentage / 100;







							







							}







							?>







						<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($tax_amount),2);?>







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php  esc_html_e( 'Paid Amount', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($paymentdata->paid_amount),2);?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php  esc_html_e( 'Due Amount', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value">







							<?php  







								$due_amount=abs($paymentdata->total_amount-$paymentdata->paid_amount);







								echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); 







							?> 







							<?php echo number_format(esc_html($due_amount),2);?>







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Date', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo MJ_gmgt_getdate_in_input_box(esc_html($paymentdata->invoice_date)); ?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php  esc_html_e( 'Payment Status', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo esc_html__("$paymentdata->payment_status","gym_mgt");; ?></label>







					</div>







				</div>







			</div>  







		<?php







		}







		?>







		<?php







		if($model=='Reservation Details')







		{







		?>







			<div class="modal-body">







				<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">







					<tbody>







						<tr>







							<td><?php esc_html_e( 'Event Name', 'gym_mgt' ) ;?></td>







							<td><?php echo esc_html($reservationdata->event_name); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Event Date', 'gym_mgt' ) ;?></td>







							<td><?php echo MJ_gmgt_getdate_in_input_box(esc_html($reservationdata->event_date)); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Place', 'gym_mgt' ) ;?></td>







							<td><?php echo get_the_title( esc_html($reservationdata->place_id) ); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Start Time', 'gym_mgt' ) ;?></td>







							<td><?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($reservationdata->start_time)); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'End Time', 'gym_mgt' ) ;?></td>







							<td><?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($reservationdata->end_time)); ?></td>







						</tr>







						<tr>







							<td><?php  esc_html_e( 'Reserved By', 'gym_mgt' ) ;?></td>







							<td><?php echo MJ_gmgt_get_display_name(esc_html($reservationdata->staff_id)); ?></td>







						</tr>







					</tbody>







				</table>







			</div>  		







		<?php







		}







		?>







		<?php







		if($model=='Notice Details')







		{







			?>







			<div class="modal-body view_details_body_assigned_bed view_details_body">







				<div class="row">







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Title', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo esc_html($noticedata->post_title); ?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"> <?php esc_html_e( 'Notice For', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo esc_html__(ucwords(str_replace("_"," ",get_post_meta( $noticedata->ID, 'notice_for',true))),"gym_mgt");?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"> <?php esc_html_e( 'Start Date', 'gym_mgt' ) ;?></label><br>







						<label class="label_value"><?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($noticedata->ID),'gmgt_start_date',true)); ?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"> <?php esc_html_e( 'End Date', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php echo MJ_gmgt_getdate_in_input_box(get_post_meta(esc_html($noticedata->ID),'gmgt_end_date',true)); ?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"> <?php esc_html_e( 'Class', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value">







							<?php if(get_post_meta( $noticedata->ID, 'gmgt_class_id',true) !="" && get_post_meta( $noticedata->ID, 'gmgt_class_id',true) =="all")







							{







								esc_html_e('All','gym_mgt');







							}







							elseif(get_post_meta( $noticedata->ID, 'gmgt_class_id',true) !="")







							{







								







								echo MJ_gmgt_get_class_name(get_post_meta( esc_html($noticedata->ID), 'gmgt_class_id',true));







							}







							else







							{







								echo 'N/A';







							} 







							?>







						</label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e('Document','gym_mgt'); ?></label><br>







						<label for="" class="label_value">







							<?php 







							if(!empty(get_post_meta($noticedata->ID,'gmgt_notice_document',true)))







							{?>







								<a href="<?php echo content_url().'/uploads/gym_assets/'.$noticedata->gmgt_notice_document;?>" class="gmgt_doc_border btn" target="_blank"><i class="fa fa-download"></i> <?php esc_html_e('Document','gym_mgt');?></a>







								<?php 







							}else{







								echo 'N/A';







							} ?>







						</label>







					</div>







					<div class="col-md-12 popup_padding_15px">







						<label for="" class="popup_label_heading"> <?php esc_html_e( 'Comment', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value">







							<?php







								if(!empty($noticedata->post_content))







								{







									echo esc_html($noticedata->post_content); 







								}







								else







								{







									echo "N/A";







								}







							 	







							?>







						</label>







					</div>















				</div>  	







			</div>  		







			<?php







		}







		?>







		<?php







		if($model=='Group Details')







		{







		?>







			<div class="modal-body">







				<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">







					<tbody>







						<tr>







							<td><?php esc_html_e( 'Group Name', 'gym_mgt' ) ;?></td>







							<td><?php echo esc_html($groupdata->group_name); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Group Description', 'gym_mgt' ) ;?></td>







							<td><?php  







								if(!empty($groupdata->group_description)) { echo esc_html($groupdata->group_description); }else{ echo '-'; }?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Total Group Members', 'gym_mgt' ) ;?></td>







							<td><?php echo $obj_group->MJ_gmgt_count_group_members(esc_html($groupdata->id)); ?></td>







						</tr>







					</tbody>







				</table>







			</div>  		







		<?php







		}







		?>







		<?php







		if($model=='Class Details')







		{







		?>







			<div class="modal-body">







				<table id="examlist" class="table table-striped" cellspacing="0" width="100%" align="center">







					<tbody>







						<tr>







							<td><?php esc_html_e( 'Class Name', 'gym_mgt' ) ;?></td>







							<td><?php echo esc_html($classdata->class_name); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Staff Name', 'gym_mgt' ) ;?></td>







							<td><?php  







								$userdata=get_userdata( $classdata->staff_id );







								echo esc_html($userdata->display_name);?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Start Time', 'gym_mgt' ) ;?></td>







							<td><?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($classdata->start_time)); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'End Time', 'gym_mgt' ) ;?></td>







							<td><?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($classdata->end_time)); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Day', 'gym_mgt' ) ;?></td>







							<td><?php $days_array=json_decode($classdata->day); 







								$days_string=array();







								if(!empty($days_array))







								{







									foreach($days_array as $day)







									{







										$days_class_schedule=substr($day,0,3);







										$days_string[]=__($days_class_schedule,'gym_mgt');







										//$days_string[]=substr($day,0,3);







									}







								}







								echo implode(", ",$days_string);







								?>







							</td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Membership Name', 'gym_mgt' ) ;?></td>







							<td><?php  







								$membersdata=array();







									$membersdata = $obj_class->MJ_gmgt_get_class_members($id);







									if(!empty($membersdata))







									{	







										foreach($membersdata as $key=>$val)







										{







											$data[]= MJ_gmgt_get_membership_name($val->membership_id);







										}







									}	







									echo implode(',',$data); ?></td>







						</tr>







						<tr>







							<td> <?php esc_html_e( 'Member Limit', 'gym_mgt' ) ;?></td>







							<td><?php  







								echo esc_html($classdata->member_limit); ?>







							</td>







						</tr>







					</tbody>







				</table>







			</div>  		







		<?php







		}







		?>







		<?php







		if($model=='Booking Details')







		{







			?>







			<div class="modal-body view_details_body_assigned_bed view_details_body">







				<div class="row">







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Member Name', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php if(!empty($bookingdata->member_id)){echo MJ_gmgt_get_display_name($bookingdata->member_id);}else{echo "N/A";} ?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"> <?php esc_html_e( 'Class Name', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php if(!empty($bookingdata->class_id)){print $obj_class->MJ_gmgt_get_class_name(esc_html($bookingdata->class_id));}else{echo "N/A";}?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"> <?php esc_html_e( 'Class Date', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php print str_replace('00:00:00',"",esc_html($bookingdata->class_booking_date));?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Booking Date', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php print str_replace('00:00:00',"",esc_html($bookingdata->booking_date)); ?></label>







					</div>







					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Day', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value">



							<?php 



							if($bookingdata->booking_day == "Sunday")







							{







								$booking_day=esc_html__('Sunday','gym_mgt');







							}







							elseif($bookingdata->booking_day == "Monday")







							{







								$booking_day=esc_html__('Monday','gym_mgt');







							}







							elseif($bookingdata->booking_day == "Tuesday")







							{







								$booking_day=esc_html__('Tuesday','gym_mgt');







							}







							elseif($bookingdata->booking_day == "Wednesday")







							{







								$booking_day=esc_html__('Wednesday','gym_mgt');







							}







							elseif($bookingdata->booking_day == "Thursday")







							{







								$booking_day=esc_html__('Thursday','gym_mgt');







							}







							elseif($bookingdata->booking_day == "Friday")







							{







								$booking_day=esc_html__('Friday','gym_mgt');







							}







							elseif($bookingdata->booking_day == "Saturday")







							{







								$booking_day=esc_html__('Saturday','gym_mgt');







							}







							echo esc_html($booking_day);



						 	?>



						 </label>







					</div>







					<?php $class_data = $obj_class->MJ_gmgt_get_single_class($bookingdata->class_id); 

					var_dump($class_data);die;?>



					<div class="col-md-6 popup_padding_15px">







						<label for="" class="popup_label_heading"><?php esc_html_e( 'Start To End Time', 'gym_mgt' ) ;?></label><br>







						<label for="" class="label_value"><?php if(!empty($class_data)){ echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->start_time)).' '.esc_html__(' To ','gym_mgt').' '.MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->end_time));}else{ echo "N/A";} ?></label>







					</div>







				</div>  	







			</div>  	



			



			<?php







		}







		?>







    </div> 







	<?php   







	die();	 







}







//user role wise access right array







function MJ_gmgt_get_userrole_wise_access_right_array_in_api($user_id,$page_link)







{







	$role=MJ_gmgt_get_roles($user_id);







	







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}







	foreach ( $menu as $key1=>$value1 ) 







	{								







		foreach ( $value1 as $key=>$value ) 







		{				







			if ($page_link == $value['page_link'])







			{				







			   $menu_array1['view'] = $value['view'];







			   $menu_array1['own_data'] = $value['own_data'];







			   $menu_array1['add'] = $value['add'];







			   $menu_array1['edit'] = $value['edit'];







			   $menu_array1['delete'] = $value['delete'];







			   return $menu_array1;







			}







		}







	}	







}







//get role by id







function MJ_gmgt_get_roles($user_id)







{







	$roles = array();







	$user = new WP_User( $user_id );















	if ( !empty( $user->roles ) && is_array( $user->roles ) )







	{







		foreach ( $user->roles as $role )







			 return $role;







	}	







}







function MJ_gmgt_get_roles_for_dashboard($user_id)







{







	$roles = array();







	$user = new WP_User( $user_id );















	if ( !empty( $user->roles ) && is_array( $user->roles ) )







	{







		foreach ( $user->roles as $roles )



		$role[] = $roles;



			 return $role;







	}	







}















//Cancel class by Hours







function MJ_gmgt_cancel_class($class_booking_date,$start_time)







{







	// $dt = new DateTime("now");







	// $new_date=$dt->format("Y-m-d H:i:s");







	$new_date = date_i18n('Y-m-d H:i:s', current_time('timestamp'));







	$new_start_time=MJ_gmgt_timeremovecolonbefoream_pm($start_time);







	$hours_before=get_option('gym_cancel_before_time');







	$time_in_24_hour_format = DATE("H:i:s", STRTOTIME($new_start_time));







	$time_in_24_hour = date('H:i:s', strtotime($time_in_24_hour_format.'-'.$hours_before.' hour'));







	$class_date_time=$class_booking_date.' '.$time_in_24_hour;







	if($new_date <= $class_date_time)







	{







	   return 1;







	}







	else







	{







	   return 0;







	}







}















//PRINT INIT FUNCTION







function MJ_gmgt_workout_print_init()







{







	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'assign-workout')







	{







		?>







		<script>window.onload = function(){ window.print(); };</script>







		<?php 	







		MJ_gmgt_workout_print($_REQUEST['workout_id']);







		exit;







	}			







}















add_action('init','MJ_gmgt_workout_print_init');







//print Workout FUNCTION







function MJ_gmgt_workout_print($workout_id)







{







 echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/style.css', __FILE__).'"></link>';	







	?>







	<?php







	if (is_rtl())







	{







	?>







		<div class="modal-header" dir="rtl">







	<?php







	}







	else







	{







	?>







		<div class="modal-header">







	<?php







	}







	?>	







	<h4 class="modal-title"><img class="system_logo" src="<?php echo esc_url(get_option( 'gmgt_gym_other_data_logo' )); ?>"></h4>			







	<h4 class="modal-title"><?php echo get_option('gmgt_system_name','gym_mgt'); ?></h4>			







	</div>







	<?php







	if (is_rtl())







	{







	?>







		<div class="title" dir="rtl">







	<?php







	}







	else







	{







	?>







		<div class="title">







	<?php







	}







	?>







	<h2 class="print_title">







	<?php esc_html_e('Assigned Workouts','gym_mgt');?></h2>







	</div>







	<?php







	if (is_rtl())







	{







	?>







		<div class="panel panel-white" dir="rtl"><!-- PANEL WHITE DIV START -->







	<?php







	}







	else







	{







	?>







		<div class="panel panel-white"><!-- PANEL WHITE DIV START -->







	<?php







	}







	?>







		<?php







		$workout_logdata=MJ_gmgt_get_workout_by_workout_id($workout_id);







		if(!empty($workout_logdata))







		{







			foreach($workout_logdata as $row)







			{



				



				$all_logdata=MJ_gmgt_get_workoutdata($row->workout_id); 







				$arranged_workout=MJ_gmgt_set_workoutarray($all_logdata);







				if(!empty($arranged_workout))







				{







			?>







				<div class="workout_<?php echo $row->workout_id;?> workout-block"><!-- WORKOUT BLOCK DIV START -->







					<div class="panel-heading pading_class_print">







						<h3 class="panel-title abc"><i class="fa fa-calendar"></i> 







							<?php 







							esc_html_e('Start From ','gym_mgt');







							echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->start_date)."</span>";







							esc_html_e(' To ','gym_mgt');







							echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->end_date)."</span>&nbsp;&nbsp;";







							if(!empty($row->description))







							{







								esc_html_e('Description : ','gym_mgt');







								echo "<span class='work_date'>".$row->description."</span>";







							}







							?>







						</h3>						







					</div>







					<div class="panel-white"><!-- PANEL WHITE DIV START -->







						<?php







							if(!empty($arranged_workout))







							{







							?>







								<div class="work_out_datalist_header">







									<div class="col-md-4 col-sm-4 col-xl-4 workout_day">  







										<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>







									</div>







									<div class="col-md-8 col-sm-8 hidden-xs1">







										<span class="col-md-3 workout_span "><?php esc_html_e('Activity','gym_mgt');?></span>







										<span class="col-md-3 workout_span"><?php esc_html_e('Sets','gym_mgt');?></span>







										<span class="col-md-2 workout_span"><?php esc_html_e('Reps','gym_mgt');?></span>







										<span class="col-md-2 workout_span"><?php esc_html_e('KG','gym_mgt');?></span>







										<span class="col-md-2 workout_span"><?php esc_html_e('Rest Time','gym_mgt');?></span>







									</div>







								</div>







								<?php 







								foreach($arranged_workout as $key=>$rowdata)







								{







									?>







									<div class="work_out_datalist">







										<div class="col-md-4 workout_day">  







											<?php esc_html_e($key,'gym_mgt');?>







										</div>







										<div class="col-md-8 col-xs-12 aa">







											<?php 







											foreach($rowdata as $row)







											{







												echo $row."<br>"."<br>";







											}?>







										</div>







									</div>







								 <?php 







								} 







							}







							?>







					</div><!-- PANEL WHITE DIV END -->







				</div><!-- WORKOUT BLOCK DIV END -->







<?php







	}







}		







}







	die();







}







?>







<?php







// pdf fuction call on init







 function MJ_gmgt_workout_pdf_init()







{







	if (is_user_logged_in ()) 







	{







		if(isset($_REQUEST['workout_pdf']) && $_REQUEST['workout_pdf'] == 'workout_pdf')







		{			







			MJ_gmgt_workout_pdf($_REQUEST['workout_id']);







			exit;







		}	







	}







} 







add_action('init','MJ_gmgt_workout_pdf_init');







?>







<?php







function MJ_gmgt_set_workoutarray1($data)







{



	// wp_enqueue_style( 'bootstrap_min-css', plugins_url( '/assets/css/bootstrap_min.css', __FILE__) );







	// wp_enqueue_script('bootstrap_min-js', plugins_url( '/assets/js/bootstrap_min.js', __FILE__ ) );



	$workout_array=array();







	foreach($data as $row)







	{



			$workout_array[$row->day_name][]= "<span class='col-md-3 col-sm-3 col-xs-12'>".$row->workout_name."</span>   







				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='col-md-3 col-sm-3 col-xs-6'>".$row->sets." ".esc_html__('Sets','gym_mgt')."</span>



		



				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='col-md-2 col-sm-2 col-xs-6'> ".$row->reps." ".esc_html__('Reps','gym_mgt')."</span>







				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='col-md-2 col-sm-2 col-xs-6'> ".$row->kg." ".esc_html__('KG','gym_mgt')."</span>







				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='col-md-2 col-sm-2  col-xs-6'> ".$row->time." ".esc_html__('Min','gym_mgt')."</span>";







	}







	return $workout_array;







}







?>







<?php







// invoice pdf FUNCTION







function MJ_gmgt_workout_pdf($workout_id)







{



	?>



	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">



	<?php



error_reporting(0);







/* echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap_min.css', __FILE__).'"></link>';







echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap_min.js', __FILE__).'"></script>'; */















wp_enqueue_style( 'bootstrap_min-css', plugins_url( '/assets/css/bootstrap_min.css', __FILE__) );







wp_enqueue_script('bootstrap_min-js', plugins_url( '/assets/js/bootstrap_min.js', __FILE__ ) );















header('Content-type: application/pdf');







header('Content-Disposition: inline; filename="workout.pdf"');







header('Content-Transfer-Encoding: binary');







header('Accept-Ranges: bytes');







//require GMS_PLUGIN_DIR. '/lib/mpdf/mpdf.php';







require_once GMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';







$stylesheet = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content



$mpdf = new Mpdf\Mpdf; 



if (is_rtl())







{







	// $mpdf = new mPDF('ar-s','A4','','' , 5 , 5 , 5 , 0 , 0 , 0);



	$mpdf->WriteHTML('<html dir="rtl">');







}







else







{







	//$mpdf =	new mPDF('c','A4','','' , 5 , 5 , 5 , 0 , 0 , 0);



	$mpdf->WriteHTML('<html>');







}







$mpdf->autoScriptToLang = true;







$mpdf->autoLangToFont = true;







$mpdf->WriteHTML('<head>');







$mpdf->WriteHTML('<style>.work_out_datalist_header {"display:flex;"}</style>');







$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf







$mpdf->WriteHTML('</head>');







$mpdf->WriteHTML('<body>');







$mpdf->SetTitle('Assigned Workout');







$mpdf->WriteHTML('<div class="modal-header new_class" >');







$mpdf->WriteHTML('<img class="system_logo" src="'.esc_url(get_option( 'gmgt_gym_other_data_logo' )).'">');







$mpdf->WriteHTML('<h4 class="system">'.get_option('gmgt_system_name').'</h4>');







$mpdf->WriteHTML('<h3 class="print_title">'.esc_html__('Assigned Workout','gym_mgt').'</h3>');







$mpdf->WriteHTML('<div class="panel panel-white">');







$workout_logdata=MJ_gmgt_get_workout_by_workout_id($workout_id);







if(!empty($workout_logdata))







{







foreach($workout_logdata as $row)







{







$all_logdata=MJ_gmgt_get_workoutdata($row->workout_id);







$arranged_workout=MJ_gmgt_set_workoutarray1($all_logdata);







if(!empty($arranged_workout))







{







$mpdf->WriteHTML('<div class="workout_ echo $row->workout_id; workout-block">');







$mpdf->WriteHTML('<div class="panel-heading">');







$mpdf->WriteHTML('<h3 class="panel-title abc">');







							$mpdf->WriteHTML(''.esc_html__('Start From ','gym_mgt')." : ".'<span class="work_date color_style1">'.MJ_gmgt_getdate_in_input_box($row->start_date).'</span>'. "  ".esc_html__('To','gym_mgt'). "  ".'<span class="work_date color_style1">'.MJ_gmgt_getdate_in_input_box($row->end_date).'</span>');







							if(!empty($row->description))







							{







								$mpdf->WriteHTML(''.esc_html__('Description :','gym_mgt').'<span class="work_date color_style1">'.$row->description.'</span>');







							}







						$mpdf->WriteHTML('</h3>');







					$mpdf->WriteHTML('</div>');	







					$mpdf->WriteHTML('<div class="panel panel-white">');







						if(!empty($arranged_workout))







						{







						







						$mpdf->WriteHTML('<div class="work_out_datalist_header" style=" -webkit-flex !important";>');







							$mpdf->WriteHTML('<div class="col-md-4 col-sm-4 col-xl-4">');







								$mpdf->WriteHTML('<div class="col-md-3" >'.esc_html__('Day Name','gym_mgt').'</div>');







								if (is_rtl())







								{







									$mpdf->WriteHTML('<div class="col-md-3 activity_print activity_print_2">'.esc_html__('Activity','gym_mgt').'</div>');







								}







								else







								{







									$mpdf->WriteHTML('<div class=" activity_print activity_print_3" style = "margin-left:130px; margin-top:-35px;">'.esc_html__('Activity','gym_mgt').'</div>');







								}







								if (is_rtl())







								{







									$mpdf->WriteHTML('<div class="col-md-3 activity_print activity_print_4">'.esc_html__('Sets','gym_mgt').'</div>');







								}







								else







								{







									$mpdf->WriteHTML('<div class=" activity_print activity_print_5" style="margin-left:225px; margin-top:-37px; width: 100px;">'.esc_html__('Sets','gym_mgt').'</div>');







								}







								if (is_rtl())







								{







									$mpdf->WriteHTML('<div class="col-md-3 activity_print activity_print_6">'.esc_html__('Reps','gym_mgt').'</div>');







								}







								else







								{







									$mpdf->WriteHTML('<div class=" activity_print activity_print_7" style = "margin-left:300px;margin-top:-37px;width: 100px;">'.esc_html__('Reps','gym_mgt').'</div>');







								}







								if (is_rtl())







								{







									$mpdf->WriteHTML('<div class="col-md-3 activity_print activity_print_8">'.esc_html__('KG','gym_mgt').'</div>');







								}







								else







								{







									$mpdf->WriteHTML('<div class=" activity_print activity_print_9" style = "margin-left:385px;margin-top:-37px;width: 100px;">'.esc_html__('KG','gym_mgt').'</div>');







								}







								if (is_rtl())







								{







									$mpdf->WriteHTML('<div class="col-md-3 activity_print activity_print_10">'.esc_html__('Rest Time','gym_mgt').'</div>');







								}







								else







								{







									$mpdf->WriteHTML('<div class=" activity_print activity_print_11" style="margin-left:445px;margin-top:-37px;width: 100px;">'.esc_html__('Rest Time','gym_mgt').'</div>');







								}







							$mpdf->WriteHTML('</div>');







						$mpdf->WriteHTML('</div>');







						







								foreach($arranged_workout as $key=>$rowdata)







								{







								$mpdf->WriteHTML('<div class="work_out_datalist" style="margin-top:-20px; ">');







									$mpdf->WriteHTML('<div class="col-md-4 day_name margin_top_10">');







										$mpdf->WriteHTML(esc_html__($key,'gym_mgt'));







									$mpdf->WriteHTML('</div>');	







									$mpdf->WriteHTML('<div class="margin_right_100">');







										foreach($rowdata as $row)







										{







											if (is_rtl())







											{







												$mpdf->WriteHTML('<div class="margin_right_150_top_20">' .$row."<br>"."<br>". '</div>');







											}







											else







											{







												$mpdf->WriteHTML('<div style="margin-left:19%;margin-top:-20px;" class="">' .$row."<br>"."<br>". '</div>');







											}







										}					







									$mpdf->WriteHTML('</div>');	







								$mpdf->WriteHTML('</div>');	







								}







						}







					$mpdf->WriteHTML('</div>');







				$mpdf->WriteHTML('</div>');







				}







			}







		}	







		$mpdf->WriteHTML('</div>');







	$mpdf->WriteHTML('</div>');







	$mpdf->WriteHTML("</body>");







	$mpdf->WriteHTML("</html>"); 







	$mpdf->Output();	







	unset($mpdf);	







} 







?>







<?php







//PRINT INIT FUNCTION







function MJ_gmgt_nutrition_print_init()







{







	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'nutrition')







	{







		?>







		<script>window.onload = function(){ window.print(); };</script>







		<?php 







				







		MJ_gmgt_nutrition_print();







		exit;







	}			







}















add_action('init','MJ_gmgt_nutrition_print_init');







//print Workout FUNCTION







function MJ_gmgt_nutrition_print()







{







 echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/style.css', __FILE__).'"></link>';	



//  echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/new_design_rtl.css', __FILE__).'"></link>';



	?>



	<style>



		* {



			color-adjust: exact !important;



 			-webkit-print-color-adjust: exact !important;



			print-color-adjust: exact !important;



 		}



		.system_logo{



			background:#ba170b;



		}



	</style>



	<?php







	if (is_rtl())







	{







	?>







		<div class="modal-header" dir="rtl">







	<?php







	}







	else







	{







	?>







		<div class="modal-header">







	<?php







	}







	?>	







	<h4 class="modal-title"><img class="" style="height: 100px; !important" src="<?php echo get_option( 'gmgt_gym_other_data_logo' ); ?>"></h4>			







	<h4 class="modal-title"><?php echo get_option('gmgt_system_name','gym_mgt'); ?></h4>			







	</div>







	<?php







	if (is_rtl())







	{







	?>







		<div class="title" dir="rtl"><h2 class="print_title"><?php esc_html_e('Nutrition Schedule List','gym_mgt');?></h2>







		</div>







	<?php







	}







	else







	{







	?>







		<div class="title"><h2 class="print_title"><?php esc_html_e('Nutrition Schedule List','gym_mgt');?></h2>







		</div>







	<?php







	}







	?>







	<?php







	if (is_rtl())







	{







	?>







		<div class="panel panel-white panel_rtl" dir="rtl"><!-- PANEL WHITE DIV START -->







	<?php







	}







	else







	{







	?>







		<div class="panel panel-white"><!-- PANEL WHITE DIV START -->







	<?php







	}







	?>







		<?php







		$nutrition_logdata=MJ_gmgt_get_user_nutrition(get_current_user_id());







		if(isset($nutrition_logdata))







		foreach($nutrition_logdata as $row)







		{







		$all_logdata=MJ_gmgt_get_nutritiondata($row->id); 







		$arranged_workout=MJ_gmgt_set_nutrition_array($all_logdata);







		?>







		 <div class="workout_<?php echo $row->id;?> workout-block"><!-- WORKOUT BLOCK DIV START -->







			<div class="panel-heading pading_class_print">







				<h3 class="panel-title"><i class="fa fa-calendar"></i> 







				<?php 







				esc_html_e('Start From ','gym_mgt');







				echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box( $row->start_date )."</span>";







				esc_html_e(' To ','gym_mgt');







				echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->expire_date ); 







				?></h3>						







			</div>											







			<div class="panel panel-white"><!-- PANEL WHITE DIV START -->







				<?php







					if(!empty($arranged_workout))







					{ ?>







						<div class="work_out_datalist_header">







							<div class="col-md-4 col-sm-4 col-xs-4 nutrition_day">  







								<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>







							</div>







							<?php







							if (is_rtl())







							{







							?>







							 	<div class="col-md-8 col-sm-8 col-xs-8 nutrition_top nutrition_margin_right">







								<span class="col-md-3 hidden-xs"><?php esc_html_e('Time','gym_mgt');?></span>







								<span class="col-md-3 nutrition_margin_right_100"><?php esc_html_e('Description','gym_mgt');?></span>







								</div>







							<?php







							}







							else







							{







							?>







								<div class="col-md-8 col-sm-8 col-xs-8 nutrition_top margin_left_160">







								<span class="col-md-3 hidden-xs"><?php esc_html_e('Time','gym_mgt');?></span>







								<span class="col-md-3 margin_left_245"><?php esc_html_e('Description','gym_mgt');?></span>







								</div>







							<?php







							}







							?>







						</div>







						<?php 







						foreach($arranged_workout as $key=>$rowdata)







							{







								?>







								<div class="work_out_datalist">







									<div class="col-md-3 col-sm-3 col-xs-12 nutrition_day">  







										<?php echo $key;?>







									</div>







									<?php







									if (is_rtl())







									{







									?>







										<div class="col-md-9 col-sm-9 col-xs-12 xyz_print margin_right_190">







									<?php







									}







									else







									{







									?>







										<div class="col-md-9 col-sm-9 col-xs-12 xyz_print">







									<?php







									}







									?>







										<?php







										foreach($rowdata as $row)







										{ 







											echo $row."<br>";									







										} 







										?>







									</div>







								</div>







					  <?php }	







					} ?>											







			</div><!-- PANEL WHITE DIV END -->







			</div><!-- WORKOUT BLOCK DIV END -->







	<?php







		}		







	die();







}







?>







<?php







// pdf fuction call on init







 function MJ_gmgt_nutrition_pdf_init()







{







	if (is_user_logged_in ()) 







	{







		if(isset($_REQUEST['nutrition_pdf']) && $_REQUEST['nutrition_pdf'] == 'nutrition_pdf')







		{			



			error_reporting(0);



			MJ_gmgt_nutirion_pdf();



			$out_put = ob_get_contents();



			ob_clean();



			header('Content-type: application/pdf');



			header('Content-Disposition: inline; filename="result"');



			header('Content-Transfer-Encoding: binary');



			header('Accept-Ranges: bytes');



			



			require_once GMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';



			$mpdf = new Mpdf\Mpdf;



			$mpdf->SetTitle('Payment');



			$mpdf->autoScriptToLang = true;



			$mpdf->autoLangToFont = true;



			



			if (is_rtl())



			{



				$mpdf->autoScriptToLang = true;



				$mpdf->autoLangToFont = true;



				$mpdf->SetDirectionality('rtl');



			}   



			



			$mpdf->WriteHTML($out_put);



			$mpdf->Output();



			unset( $out_put );



			unset( $mpdf );



			exit;







		}	







	}







} 







add_action('init','MJ_gmgt_nutrition_pdf_init');







?>







<?php







//SET NUTRISION AARAY FUNCTION







function MJ_gmgt_set_nutrition_array1($data)







{







	$workout_array=array();







	foreach($data as $row)







	{







		$workout_array[$row->day_name][]= "







		







			<table>







			<tr>







			<td class='col-md-5 col-sm-5 col-xs-12 nutrition_time' style='width: 200px !important;color:red;'>".$row->nutrition_time."</td>







			







				







			<td class='col-md-7 col-sm-7 col-xs-12 abc'>".$row->nutrition_value." </td>







			</tr></table>







		";







	}







	return $workout_array;















}







?>







<?php







// Nutrition pdf FUNCTION







function MJ_gmgt_nutirion_pdf()



{



	echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/style.css', __FILE__).'"></link>';

	echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/new_design_rtl.css', __FILE__).'"></link>';



	if (is_rtl())



	{



			?>



		<div class="modal-header" dir="rtl">



			<?php



	}



	else



	{



			?>



		<div class="modal-header">



			<?php



	}



	?>	







	<h4 class="modal-title"><img class="system_logo" src="<?php echo esc_url(get_option( 'gmgt_gym_other_data_logo' )); ?>"></h4>			







	<h4 class="modal-title"><?php echo get_option('gmgt_system_name','gym_mgt'); ?></h4>			







   	</div>



	<?php



	if (is_rtl())



	{



		?>



		<div class="title" dir="rtl"><h2 class="print_title"><?php esc_html_e('Nutrition Schedule List','gym_mgt');?></h2></div>



		<?php



	}



	else



	{



		?>



		<div class="title"><h2 class="print_title"><?php esc_html_e('Nutrition Schedule List','gym_mgt');?></h2></div>



		<?php



	}







	if (is_rtl())



	{



		?>



		<div class="panel panel-white" dir="rtl"><!-- PANEL WHITE DIV START -->



		<?php



	}



	else



	{



		?>



		<div class="panel panel-white"><!-- PANEL WHITE DIV START -->



		<?php



	}



	$nutrition_logdata=MJ_gmgt_get_user_nutrition(get_current_user_id());



	if(isset($nutrition_logdata))



	{



		foreach($nutrition_logdata as $row)



		{



			$all_logdata=MJ_gmgt_get_nutritiondata($row->id); 



			$arranged_workout=MJ_gmgt_set_nutrition_array($all_logdata);



			?>



			<div class="workout_<?php echo $row->id;?> workout-block"><!-- WORKOUT BLOCK DIV START -->



				<div class="panel-heading pading_class_print">







					<h3 class="panel-title">







					<?php 







					esc_html_e('Start From ','gym_mgt');







					echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box( $row->start_date )."</span>";







					esc_html_e(' To ','gym_mgt');







					echo "<span class='work_date'>".MJ_gmgt_getdate_in_input_box($row->expire_date ); 







					?></h3>						







				</div>



				<div class="panel panel-white"><!-- PANEL WHITE DIV START -->







					<?php







						if(!empty($arranged_workout))







						{ ?>







							<div class="work_out_datalist_header">







								<div class="col-md-4 col-sm-4 col-xs-4 ">  







									<strong><?php esc_html_e('Day Name','gym_mgt');?></strong>







								</div>







								<?php







								if (is_rtl())







								{







									?>







									<div class="col-md-8 col-sm-8 col-xs-8 abc_print nutrition_pdf_margin_right">







										<span class="col-md-3 hidden-xs"><?php esc_html_e('Time','gym_mgt');?></span>







										<div class="col-md-3 nutrition_pdf_margin_right_description" ><?php esc_html_e('Description','gym_mgt');?></span>







									</div>







									<?php







								}







								else







								{







									?>







									<div class="col-md-8 col-sm-8 col-xs-8 abc_print margin_left_160">







										<span class="col-md-6 hidden-xs nutrition_pdf"><?php esc_html_e('Time','gym_mgt');?></span>



									</div>



									<div class="col-md-8 col-sm-8 col-xs-8 abc_print margin_left_360">



										<span class="col-md-6 margin_left_245 nutrition_pdf"><?php esc_html_e('Description','gym_mgt');?></span>







									</div>







									<?php







								}







								?>







							</div>







							<?php 







							foreach($arranged_workout as $key=>$rowdata)







								{







									?>







									<div class="work_out_datalist">







										<div class="col-md-3 col-sm-3 col-xs-12 day_name">  







											<?php echo $key;?>







										</div>







										<?php







										if (is_rtl())







										{







										?>







											<div class="col-md-9 col-sm-9 col-xs-12 xyz_print margin_right_190">







										<?php







										}







										else







										{







										?>







											<div class="col-md-9 col-sm-9 col-xs-12 xyz_print">







										<?php







										}







										?>







											<?php







											foreach($rowdata as $row)







											{ 







												echo $row."<br>";									







											} 







											?>







										</div>







									</div>







							<?php }	







						} ?>											







				</div><!-- PANEL WHITE DIV END -->



			</div>	



			<?php



		}



	}



}







// CHANGE PROFILE PHOTO IN USER DASHBOARD //







function MJ_gmgt_change_profile_photo()







{







	?>







	<div class="gmgt_pop_heder_p_20"> 	







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







		<h4 class="modal-title" id="myLargeModalLabel">







			<?php echo  esc_html__('Update Profile Picture','gym_mgt'); ?>







		</h4>







	</div>















	<form class="form-horizontal margin_top_20px padding_left_15px padding_15_per_res" action="#" method="post" enctype="multipart/form-data">







		<div class="form-body user_form staff_padding_top_15px"> <!-- user_form Strat-->   







			<div class="row"><!--Row Div Strat-->







				<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">







					<div class="form-group input cmgt_document_list">







						<div class="col-md-12 form-control">







							<label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="Document"><?php esc_html_e('Upload Image','gym_mgt');?></label>







							<div class="row">







								<div class="col-sm-12">







									<input id="input-1" name="profile" type="file" onchange="MJ_gmgt_fileCheck(this);" style="border:0px;"  class="form-control profile_file file">







								</div>







							</div>







						</div>







					</div>







				</div>







				<div class="col-md-3 col-lg-3 col-sm-12 col-xl-3">







					<input name="save_profile_pic" type="submit" class="btn save_upload_profile_btn save_btn" value="<?php esc_html_e('Save','gym_mgt');?>">







				</div>







			</div>







		</div>







	</form>







    <?php 







	die();







}







//GET MEMBERRSHIP ID BY CLASSID







function get_multiple_membership_id_by_classid($class_id)







{







	global $wpdb;







	$result=array();







	$table_gmgt_membership_class = $wpdb->prefix. 'gmgt_membership_class';







	$membership = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_class where class_id= ".$class_id);







	







	if(!empty($membership)){







		foreach($membership as $row)







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







//GET MEMBERRSHIP ID BY CLASSID







function get_membership_id_by_classid($class_id)







{







	global $wpdb;







	$tbl_membership_class = $wpdb->prefix. 'gmgt_membership_class';







	$result =$wpdb->get_results("SELECT membership_id FROM $tbl_membership_class WHERE class_id=".$class_id);















	return $result;







}







//Add Member Class Limit







function MJ_gmgt_add_class_limit()







{







	$member_id=$_POST['member_id'];







	$membership_id=$_POST['membership_id'];







	$no_of_classlimit=$_POST['add_classlimit_member']; 







	global $wpdb;







	$gmgt_member_class_limit = $wpdb->prefix. 'gmgt_member_class_limit';







	$member_class_limit = $wpdb->get_row("SELECT * FROM $gmgt_member_class_limit where member_id=$member_id AND membership_id=$membership_id");







	if(empty($member_class_limit))







	{







		$class_limit['member_id']=$_POST['member_id'];







	    $class_limit['membership_id']=$_POST['membership_id'];







	    $class_limit['class_limit']=$_POST['add_classlimit_member'];







		$result=$wpdb->insert( $gmgt_member_class_limit, $class_limit );







		







	}







	else







	{







		$class_limit_member=$member_class_limit->class_limit;







		$total_class=$class_limit_member + $no_of_classlimit;







		 $class_limit_id['id']=$member_class_limit->id;







		 $class_limit['class_limit']=$total_class;







		$result=$wpdb->update( $gmgt_member_class_limit, $class_limit ,$class_limit_id);







	}







	die;







}







//delete class for memerlimit







function MJ_gmgt_delete_class_limit_for_member()







{















	$member_id=$_POST['member_id'];







	$membership_id=$_POST['membership_id'];







	$no_of_classlimit=$_POST['add_classlimit_member']; 







	global $wpdb;







	$gmgt_member_class_limit = $wpdb->prefix. 'gmgt_member_class_limit';







	$member_class_limit = $wpdb->get_row("SELECT * FROM $gmgt_member_class_limit where member_id=$member_id AND membership_id=$membership_id");







	if(empty($member_class_limit))







	{







	  echo 2;







		







	}







	else







	{







	    $class_limit_member=$member_class_limit->class_limit;







		$total_class=$class_limit_member - $no_of_classlimit;







	     $class_limit_id['id']=$member_class_limit->id;







	     $class_limit['class_limit']=$total_class;







		$result=$wpdb->update( $gmgt_member_class_limit, $class_limit ,$class_limit_id);







			







	}







	die; 







}







function MJ_gmgt_get_receiver_name_array($message_id,$sender_id,$created_date,$message_comment)







{







	$message_id=(int)$message_id;







	$sender_id=(int)$sender_id;







	global $wpdb;







	$new_name_array=array();







	$receiver_name=array();







	$tbl_name = $wpdb->prefix .'gmgt_message_replies';







	$reply_msg =$wpdb->get_results("SELECT receiver_id  FROM $tbl_name where message_id = $message_id AND sender_id = $sender_id AND message_comment='$message_comment' OR created_date='$created_date'");







	if (!empty($reply_msg)) 







	{







		foreach ($reply_msg as $receiver_id) 







		{







			$receiver_name[]=MJ_gmgt_get_display_name($receiver_id->receiver_id);







		}







	}







	$new_name_array=implode(", ",$receiver_name);







	return $new_name_array;







}







// CONVERT TIME FORMATE //







function MJ_gmgt_gmgtConvertTime( $time ) 







{







	$timestamp = strtotime( $time ); // Converting time to Unix timestamp







	$offset = get_option( 'gmt_offset' ) * 60 * 60; // Time offset in seconds







	$local_timestamp = $timestamp + $offset;







	$local_time = date_i18n(get_option('gmgt_datepicker_format') . ' H:i:s', $local_timestamp );







	return $local_time;







}







add_action('wp_ajax_datatable_storelist_ajax_to_load','datatable_storelist_ajax_to_load');







function datatable_storelist_ajax_to_load()







{







    global $wpdb;







	$obj_store=new MJ_gmgt_store;







	$storedata=$obj_store->MJ_gmgt_get_all_selling();







	if(!empty($storedata))







	{







		foreach ($storedata as $retrieved_data)







		{







			if(empty($retrieved_data->invoice_no))







			{







				$obj_product=new MJ_gmgt_product;







				$product = $obj_product->MJ_gmgt_get_single_product($retrieved_data->product_id);







				$price=$product->price;	







				$quentity=$retrieved_data->quentity;







				$invoice_no='-';					







				$total_amount=$price*$quentity;







				$paid_amount=$price*$quentity;







				$due_amount='0';







			}







			else







			{







				$invoice_no=$retrieved_data->invoice_no;







				$total_amount=$retrieved_data->total_amount;







				$paid_amount=$retrieved_data->paid_amount;







				$due_amount=$total_amount-$paid_amount;







			}







		}







	}







	







	 $sLimit = "";







	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )







	 {







	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".







	   intval( $_REQUEST['iDisplayLength'] );







	 }







	   $ssearch = $_REQUEST['sSearch'];







 	    if($ssearch)







		{







		







	   $sQuery = "







	   SELECT p.post_title,p.post_content,p.post_type,p1.meta_value AS event_start_date,p2.meta_value AS event_end_date ,p3.meta_value AS event_place FROM $sTable p JOIN $sTable_wp_postmeta p1 ON (p1.post_id = p.ID AND p1.meta_key ='event_start_date' ) JOIN $sTable_wp_postmeta p2 ON (p2.post_id = p.ID AND p2.meta_key ='event_end_date' )JOIN $sTable_wp_postmeta p3 ON (p3.post_id = p.ID AND p3.meta_key ='event_place' ) where p.post_type='hrmgt_events' AND p.post_title LIKE '%$ssearch%' OR p.post_content LIKE '%$ssearch%' OR p1.meta_key LIKE 'event_start_date' AND p3.meta_value LIKE '%$ssearch%' OR p1.meta_key LIKE 'event_end_date' AND p3.meta_value LIKE '%$ssearch%' OR p1.meta_key LIKE 'event_place' AND p3.meta_value LIKE '%$ssearch%' Group BY p.id , p.id DESC $sLimit"; 







	   }







	   else







	   {







	   $sQuery = "SELECT p.id,p.post_title,p.post_content,p.post_type,p1.meta_value AS event_start_date,p2.meta_value AS event_end_date ,p3.meta_value AS event_place FROM $sTable p JOIN $sTable_wp_postmeta p1 ON (p1.post_id = p.ID AND p1.meta_key ='event_start_date' ) JOIN $sTable_wp_postmeta p2 ON (p2.post_id = p.ID AND p2.meta_key ='event_end_date' )JOIN $sTable_wp_postmeta p3 ON (p3.post_id = p.ID AND p3.meta_key ='event_place' ) where p.post_type='hrmgt_events'  Group BY p.id , p.id DESC $sLimit";







	   }







         







		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);







		  $wpdb->get_results("SELECT p.id,p.post_title,p.post_content,p.post_type,p1.meta_value AS event_start_date,p2.meta_value AS event_end_date ,p3.meta_value AS event_place FROM $sTable p JOIN $sTable_wp_postmeta p1 ON (p1.post_id = p.ID AND p1.meta_key ='event_start_date' ) JOIN $sTable_wp_postmeta p2 ON (p2.post_id = p.ID AND p2.meta_key ='event_end_date' )JOIN $sTable_wp_postmeta p3 ON (p3.post_id = p.ID AND p3.meta_key ='event_place' ) where p.post_type='hrmgt_events'  Group BY p.id , p.id DESC $sLimit");







		  $iFilteredTotal = $wpdb->num_rows;







		   $wpdb->get_results("SELECT * From $sTable");







		  $iTotal = $wpdb->num_rows;















  







		  $output = array(







		  "sEcho" => intval($_REQUEST['sEcho']),







		  "iTotalRecords" => $iTotal,







		  "iTotalDisplayRecords" => $iFilteredTotal,







		  "aaData" => array()







		 );







         







		 foreach($rResult as $aRow)







		 {







			$row[0] = stripslashes($aRow['post_title']);







			$row[1] = hrmgt_change_dateformat($aRow['event_start_date']);







			$row[2] = hrmgt_change_dateformat($aRow['event_end_date']);







			$row[3]= $aRow['event_place'];







			$row[4]= stripslashes(wp_trim_words( $aRow['post_content'],3,'...'));







			$row[5]=' <a href="#" class="btn btn-primary view-event" id="'.$aRow['id'].'">'.esc_html__('View','hr_mgt').'</a>







				<a href="?page=hrmgt-event&tab=add_event&action=edit&event_id='.$aRow['id'].'" class="btn btn-info">'.esc_html__('Edit','hr_mgt').'</a>







                <a href="?page=hrmgt-event&tab=event_list&action=delete&event_id='.$aRow['id'].'" class="btn btn-danger deletealert" >'.esc_html__('Delete','hr_mgt').' </a>';







			$output['aaData'][] = $row;







		 }







 echo json_encode( $output );







 die();







}







function MJ_gmgt_get_receiver_id($message_id,$sender_id,$created_date,$message_comment)







{







	$message_id=(int)$message_id;







	$sender_id=(int)$sender_id;







	global $wpdb;







	$new_name_array=array();







	







	$tbl_name = $wpdb->prefix .'gmgt_message_replies';







	$reply_msg =$wpdb->get_results("SELECT receiver_id  FROM $tbl_name where message_id = $message_id AND sender_id = $sender_id AND message_comment='$message_comment' OR created_date='$created_date'");







	if (!empty($reply_msg)) 







	{







		foreach ($reply_msg as $receiver_id) 







		{







			







			$receiver_name=$receiver_id->receiver_id;







		}







	}







	return $receiver_name;







}







function MJ_gmgt_get_sender_id($message_id,$receiver_id,$created_date,$message_comment)







{







	$message_id=(int)$message_id;







	$receiver_id=(int)$receiver_id;







	global $wpdb;







	$new_name_array=array();















	$tbl_name = $wpdb->prefix .'gmgt_message_replies';







	$reply_msg =$wpdb->get_results("SELECT sender_id  FROM $tbl_name where message_id = $message_id AND receiver_id = $receiver_id AND message_comment='$message_comment' OR created_date='$created_date'");







	if (!empty($reply_msg)) 







	{







		foreach ($reply_msg as $sender_id) 







		{







			







			$receiver_name=$sender_id->sender_id;







		}







	}







	return $receiver_name;







}







function MJ_gmgt_get_sender_name_array($message_id,$receiver_id,$created_date,$message_comment)







{







	$message_id=(int)$message_id;







	$sender_id=(int)$sender_id;







	global $wpdb;







	$new_name_array=array();







	$receiver_name=array();







	$tbl_name = $wpdb->prefix .'gmgt_message_replies';







	$reply_msg =$wpdb->get_results("SELECT sender_id  FROM $tbl_name where message_id = $message_id AND receiver_id = $receiver_id AND message_comment='$message_comment' OR created_date='$created_date'");







	if (!empty($reply_msg)) 







	{







		foreach ($reply_msg as $receiver_id) 







		{







			$receiver_name[]=MJ_gmgt_get_display_name($receiver_id->sender_id);







		}







	}







	$new_name_array=implode(", ",$receiver_name);







	return $new_name_array;







}







// invoice pdf API FUNCTION







function MJ_gmgt_api_translate_invoice_pdf($id,$type,$current_user_id)







{


	




	$invoice_new_id=$id;







	$document_dir = WP_CONTENT_DIR;







	$document_dir .= '/uploads/translate_invoice_pdf/';







	$document_path = $document_dir;







	if (!file_exists($document_path))







	{







		mkdir($document_path, 0777, true);		







	}







	







	$obj_payment= new MJ_gmgt_payment();







	if($type=='membership_invoice')







	{		







		$obj_membership_payment=new MJ_gmgt_membership_payment;	







		$membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($id);

		





		$history_detail_result = MJ_gmgt_get_payment_history_by_mpid($id);		

		




	}







	if($type=='income')







	{







		$income_data=$obj_payment->MJ_gmgt_get_income_data($id);

	




		$history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($id);







	}







	{







	if($type=='expense')







		$expense_data=$obj_payment->MJ_gmgt_get_income_data($id);







	}







	if($type=='sell_invoice')







	{







		$obj_store=new MJ_gmgt_store;







		$selling_data=$obj_store->MJ_gmgt_get_single_selling($id);







		$history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($id);







	}

   /*  echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap_min.css', __FILE__).'"></link>';

    echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap_min.js', __FILE__).'"></script>'; */

	wp_enqueue_style( 'bootstrap_min-css', plugins_url( '/assets/css/bootstrap_min.css', __FILE__) );

	wp_enqueue_script('bootstrap_min-js', plugins_url( '/assets/js/bootstrap_min.js', __FILE__ ) );

	require_once GMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	
	// ob_clean();

	// header('Content-type: application/pdf');

	// header('Content-Disposition: inline; filename="invoice.pdf"');

	// header('Content-Transfer-Encoding: binary');

	// header('Accept-Ranges: bytes');	

	$stylesheet = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/custom.css'); // Get css content

	$stylesheet1 = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content

    if (is_rtl())

    {	

    	$mpdf = new \Mpdf\Mpdf;

    	$mpdf->SetDirectionality('rtl');

		$stylesheet2 = file_get_contents(GMS_PLUGIN_DIR. '/assets/css/custom_rtl.css'); // Get css content

		$mpdf->autoScriptToLang = true;

	    $mpdf->autoLangToFont = true;

    }

	else

	{

		$mpdf = new Mpdf\Mpdf;

		$mpdf->autoScriptToLang = true;

	}

	if (is_rtl())

	{

		$mpdf->WriteHTML('<html dir="rtl">');

	}

	else

	{

		$mpdf->WriteHTML('<html>');

	}

	$mpdf = new \Mpdf\Mpdf([

		'default_font' => 'freesans'

	]);

	$mpdf->SetFont('freesans');

	$mpdf->WriteHTML('<head>');

	$mpdf->WriteHTML('<style></style>');

	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf

	$mpdf->WriteHTML($stylesheet1,1); // Writing style to pdf

	$mpdf->WriteHTML('</head>');

	$mpdf->WriteHTML('<body style="font-family: freesans!important; ">');		

	$mpdf->SetTitle('Income Invoice');

		$mpdf->WriteHTML('<div class="modal-header">');

		$mpdf->WriteHTML('<h4 class="modal-title">'.get_option('gmgt_system_name').'</h4>');

		$mpdf->WriteHTML('</div>');

		$mpdf->WriteHTML('<div id="invoice_print">');

			if (is_rtl())

			{

				$mpdf->WriteHTML('<img class="rtl_main_top_full_img" src="'.plugins_url('/gym-management/assets/images/invoice-.jpg').'" style="float: left;width: 50%;transform: scale(-1,1);">');

			}

			else

			{

				$mpdf->WriteHTML('<img class="invoicefont1 rtl_invoice_img" src="'.plugins_url('/gym-management/assets/images/invoice.jpg').'">');

			}

			$mpdf->WriteHTML('<div class="main_div">');	

			
			
					if (is_rtl())

					{

						$mpdf->WriteHTML('<table class="width_100_print rtl_invoice_header rtl_pdf_view_invoice_header" border="0">');					







							$mpdf->WriteHTML('<tbody class="rtl_pdf_view_table_address">');







								$mpdf->WriteHTML('<tr>');







									$mpdf->WriteHTML('<td class="width_1_print rtl_width_1_print" style="padding-top: 110px;">');







										$mpdf->WriteHTML('<img class="system_logo" style="padding-left:15px;"  src="'.get_option( 'gmgt_system_logo' ).'">');







									$mpdf->WriteHTML('</td>');							







									$mpdf->WriteHTML('<td class="only_width_20_print rtl_only_width_20_print pd_tp_address" style="padding-top: 110px;" >');								







										$mpdf->WriteHTML(''.esc_html__('A','gym_mgt').'. '.chunk_split(get_option('gmgt_gym_address'),30).'<br>'); 







										 $mpdf->WriteHTML(''.esc_html__('E','gym_mgt').'. '.get_option( 'gmgt_email' ).'<br>'); 







										 $mpdf->WriteHTML(''.esc_html__('P','gym_mgt').'. '.get_option( 'gmgt_contact_number' ).'<br>'); 







									$mpdf->WriteHTML('</td>');







									$mpdf->WriteHTML('<td align="right" class="width_24">');







									$mpdf->WriteHTML('</td>');







								$mpdf->WriteHTML('</tr>');







							$mpdf->WriteHTML('</tbody>');







						$mpdf->WriteHTML('</table>');







						







							$mpdf->WriteHTML('<table>');







					 $mpdf->WriteHTML('<tr>');







						$mpdf->WriteHTML('<td>');







						







							$mpdf->WriteHTML('<table class="width_50_print"  border="0">');







								$mpdf->WriteHTML('<tbody>');				







								$mpdf->WriteHTML('<tr>');







									$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center" >');								







										$mpdf->WriteHTML('<h3 class="billed_to_lable"> | '.esc_html__('Bill To','gym_mgt').'. </h3>');







									$mpdf->WriteHTML('</td>');







									$mpdf->WriteHTML('<td class="width_40_print" >');								







									







										if(!empty($expense_data))







										{







										  $mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($expense_data->supplier_name),30,"<BR>").'</h3>'); 







										}







										else







										{







											if(!empty($income_data))







												$member_id=$income_data->supplier_name;







											 if(!empty($membership_data))







												$member_id=$membership_data->member_id;







											 if(!empty($selling_data))







												$member_id=$selling_data->member_id;







											$patient=get_userdata($member_id);







											







											$mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>").'</h3>'); 







											 $address=get_user_meta( $member_id,'address',true);									







											 $mpdf->WriteHTML(''.chunk_split($address,30,"<BR>").''); 







											  $mpdf->WriteHTML(''.get_user_meta( $member_id,'city_name',true ).','); 







											 $mpdf->WriteHTML(''.get_user_meta( $member_id,'zip_code',true ).'<br>'); 







											 $mpdf->WriteHTML(''.get_user_meta( $member_id,'mobile',true ).'<br>'); 







										}







											







									 $mpdf->WriteHTML('</td>');







								 $mpdf->WriteHTML('</tr>');									







							 $mpdf->WriteHTML('</tbody>');







						 $mpdf->WriteHTML('</table>');	















						$mpdf->WriteHTML('</td>');







						$mpdf->WriteHTML('<td>');







				







							   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');







								 $mpdf->WriteHTML('<tbody>');				







									 $mpdf->WriteHTML('<tr>');	







										 $mpdf->WriteHTML('<td class="width_30_print">');







										 $mpdf->WriteHTML('</td>');







										 $mpdf->WriteHTML('<td class="width_20_print invoice_lable" style="padding-right:30px;padding-top: 30px;" align="left">');







											







											$issue_date='DD-MM-YYYY';







											if(!empty($income_data))







											{







												$issue_date=$income_data->invoice_date;







												$payment_status=$income_data->payment_status;







												$invoice_no=$income_data->invoice_no;







											}







											if(!empty($membership_data))







											{







												$issue_date=$membership_data->created_date;







												$payment_status=$membership_data->payment_status;







												$invoice_no=$membership_data->invoice_no;									







											}







											if(!empty($expense_data))







											{







												$issue_date=$expense_data->invoice_date;







												$payment_status=$expense_data->payment_status;







												$invoice_no=$expense_data->invoice_no;







											}







											if(!empty($selling_data))







											{







												$issue_date=$selling_data->sell_date;									







												if(!empty($selling_data->payment_status))







												{







													$payment_status=$selling_data->payment_status;







												}	







												else







												{







													$payment_status='Fully Paid';







												}	







												$invoice_no=$selling_data->invoice_no;







											} 







											







											if($type!='expense')







											{								







												$mpdf->WriteHTML('<h3>'.esc_html__('INVOICE','gym_mgt').' <br> #'.$invoice_no.'</h3>');										







											}																			







										 $mpdf->WriteHTML('</td>');							







									 $mpdf->WriteHTML('</tr>');







									 $mpdf->WriteHTML('<tr>');	







										 $mpdf->WriteHTML('<td class="width_30_print">');







										 $mpdf->WriteHTML('</td>');







										 $mpdf->WriteHTML('<td class="width_20_print" style="padding-right:30px;" align="left">');







											$mpdf->WriteHTML('<h5>'.esc_html__('Date','gym_mgt').' : '.MJ_gmgt_getdate_in_input_box($issue_date).'</h5>');







										$mpdf->WriteHTML('<br><h5>'.esc_html__('Status','gym_mgt').' : '.esc_html__(''.$payment_status.'','gym_mgt').'</h5>');											







										 $mpdf->WriteHTML('</td>');							







									 $mpdf->WriteHTML('</tr>');						







								 $mpdf->WriteHTML('</tbody>');







							 $mpdf->WriteHTML('</table>');	







							$mpdf->WriteHTML('</td>');







						  $mpdf->WriteHTML('</tr>');







						$mpdf->WriteHTML('</table>');	







					}

					else

					{
						
						$mpdf->WriteHTML('<table class="width_100_print rtl_invoice_header" border="0">');					

							$mpdf->WriteHTML('<tbody>');

								$mpdf->WriteHTML('<tr>');

									$mpdf->WriteHTML('<td class="width_1_print rtl_width_1_print">');

										$mpdf->WriteHTML('<img class="system_logo" style="padding-left:15px;"  src="'.get_option( 'gmgt_system_logo' ).'">');

									$mpdf->WriteHTML('</td>');							

									$mpdf->WriteHTML('<td class="only_width_20_print rtl_only_width_20_print" style="">');								

										$mpdf->WriteHTML(''.esc_html__('A','gym_mgt').'. '.chunk_split(get_option('gmgt_gym_address'),30).'<br>'); 

										 $mpdf->WriteHTML(''.esc_html__('E','gym_mgt').'. '.get_option( 'gmgt_email' ).'<br>'); 

										 $mpdf->WriteHTML(''.esc_html__('P','gym_mgt').'. '.get_option( 'gmgt_contact_number' ).'<br>'); 

									$mpdf->WriteHTML('</td>');

									$mpdf->WriteHTML('<td align="right" class="width_24">');

									$mpdf->WriteHTML('</td>');

								$mpdf->WriteHTML('</tr>');

							$mpdf->WriteHTML('</tbody>');

						$mpdf->WriteHTML('</table>');

							$mpdf->WriteHTML('<table>');

					 $mpdf->WriteHTML('<tr>');

						$mpdf->WriteHTML('<td>');

							$mpdf->WriteHTML('<table class="width_50_print"  border="0">');

								$mpdf->WriteHTML('<tbody>');				

								$mpdf->WriteHTML('<tr>');

									$mpdf->WriteHTML('<td colspan="2" class="billed_to_print" align="center">');								

										$mpdf->WriteHTML('<h3 class="billed_to_lable"> | '.esc_html__('Bill To','gym_mgt').'. </h3>');

									$mpdf->WriteHTML('</td>');

									$mpdf->WriteHTML('<td class="width_40_print">');								
									
										if(!empty($expense_data))
										{

										  $mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(ucwords($expense_data->supplier_name),30,"<BR>").'</h3>'); 

										}

										else

										{

											if(!empty($income_data))

												$member_id=$income_data->supplier_name;

											 if(!empty($membership_data))

												$member_id=$membership_data->member_id;
												
											 if(!empty($selling_data))

												$member_id=$selling_data->member_id;

											$patient=get_userdata($member_id);

											$mpdf->WriteHTML('<h3 class="display_name">'.chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>").'</h3>'); 

											 $address=get_user_meta( $member_id,'address',true);									

											 $mpdf->WriteHTML(''.chunk_split($address,30,"<BR>").''); 

											  $mpdf->WriteHTML(''.get_user_meta( $member_id,'city_name',true ).','); 

											 $mpdf->WriteHTML(''.get_user_meta( $member_id,'zip_code',true ).'<br>'); 

											 $mpdf->WriteHTML(''.get_user_meta( $member_id,'mobile',true ).'<br>'); 

										}

									 $mpdf->WriteHTML('</td>');

								 $mpdf->WriteHTML('</tr>');									

							 $mpdf->WriteHTML('</tbody>');

						 $mpdf->WriteHTML('</table>');

						 $mpdf->WriteHTML('</td>');

						$mpdf->WriteHTML('<td>');

							   $mpdf->WriteHTML('<table class="width_50_print"  border="0">');

								 $mpdf->WriteHTML('<tbody>');				

									 $mpdf->WriteHTML('<tr>');	

										 $mpdf->WriteHTML('<td class="width_30_print">');

										 $mpdf->WriteHTML('</td>');

										 $mpdf->WriteHTML('<td class="width_20_print invoice_lable" style="padding-right:30px;" align="left">');

											$issue_date='DD-MM-YYYY';

											if(!empty($income_data))

											{

												$issue_date=$income_data->invoice_date;

												$payment_status=$income_data->payment_status;

												$invoice_no=$income_data->invoice_no;

											}

											if(!empty($membership_data))

											{

												$issue_date=$membership_data->created_date;
												
												$payment_status=$membership_data->payment_status;

												$invoice_no=$membership_data->invoice_no;									
												
											}

											if(!empty($expense_data))

											{

												$issue_date=$expense_data->invoice_date;

												$payment_status=$expense_data->payment_status;

												$invoice_no=$expense_data->invoice_no;

											}

											if(!empty($selling_data))

											{

												$issue_date=$selling_data->sell_date;									

												if(!empty($selling_data->payment_status))

												{

													$payment_status=$selling_data->payment_status;

												}	

												else

												{

													$payment_status='Fully Paid';

												}	

												$invoice_no=$selling_data->invoice_no;

											} 


											if($type!='expense')

											{							

												$mpdf->WriteHTML('<h3>'.esc_html__('INVOICE','gym_mgt').' <br> #'.$invoice_no.'</h3>');										

											}																			

										 $mpdf->WriteHTML('</td>');							

									 $mpdf->WriteHTML('</tr>');

									 $mpdf->WriteHTML('<tr>');	

										 $mpdf->WriteHTML('<td class="width_30_print">');

										 $mpdf->WriteHTML('</td>');
										
										 $mpdf->WriteHTML('<td class="width_20_print" style="padding-right:30px;" align="left">');

											$mpdf->WriteHTML('<h5>'.esc_html__('Date','gym_mgt').' : '.MJ_gmgt_getdate_in_input_box($issue_date).'</h5>');

										$mpdf->WriteHTML('<br><h5>'.esc_html__('Status','gym_mgt').' : '.esc_html__(''.$payment_status.'','gym_mgt').'</h5>');											

										 $mpdf->WriteHTML('</td>');							

									 $mpdf->WriteHTML('</tr>');						

								 $mpdf->WriteHTML('</tbody>');

							 $mpdf->WriteHTML('</table>');	

							$mpdf->WriteHTML('</td>');

						  $mpdf->WriteHTML('</tr>');

						$mpdf->WriteHTML('</table>');

					}

				if($type=='membership_invoice')

				{	

					$mpdf->WriteHTML('<table class="width_100_print">');	

						$mpdf->WriteHTML('<tbody>');	

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td style="padding-left:20px;">');

									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Membership Entries','gym_mgt').'</h3>');

								$mpdf->WriteHTML('</td>');	

							$mpdf->WriteHTML('</tr>');	

						$mpdf->WriteHTML('</tbody>');

					$mpdf->WriteHTML('</table>');				
					
				}		

				elseif($type=='income')

				{ 

					$mpdf->WriteHTML('<table class="width_100_print">');	

						$mpdf->WriteHTML('<tbody>');	

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td style="padding-left:20px;">');

									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Income Entries12','gym_mgt').'</h3>');

								$mpdf->WriteHTML('</td>');	

							$mpdf->WriteHTML('</tr>');	

						$mpdf->WriteHTML('</tbody>');

					$mpdf->WriteHTML('</table>');

				}

				elseif($type=='sell_invoice')

				{ 

				  $mpdf->WriteHTML('<table class="width_100_print">');	

						$mpdf->WriteHTML('<tbody>');	

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td style="padding-left:20px;">');

									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Sale Product','gym_mgt').'</h3>');

								$mpdf->WriteHTML('</td>');	

							$mpdf->WriteHTML('</tr>');	

						$mpdf->WriteHTML('</tbody>');

					$mpdf->WriteHTML('</table>');

				}

				else

				{ 

					$mpdf->WriteHTML('<table class="width_100_print">');	

						$mpdf->WriteHTML('<tbody>');	

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td style="padding-left:20px;">');

									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Expense Entries','gym_mgt').'</h3>');

								$mpdf->WriteHTML('</td>');	

							$mpdf->WriteHTML('</tr>');	

						$mpdf->WriteHTML('</tbody>');

					$mpdf->WriteHTML('</table>');	

				}		  
				
				$mpdf->WriteHTML('<table class="table table-bordered" class="width_93" border="1">');

					$mpdf->WriteHTML('<thead>');

						if($type=='membership_invoice')

						{						

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('DATE','gym_mgt').'</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_left" style ="text-transform:uppercase; !important">'.esc_html__('Membership Name','gym_mgt').'</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_right" style ="text-transform:uppercase; !important">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');								

							$mpdf->WriteHTML('</tr>');

						}

						elseif($type=='sell_invoice')

						{  

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('DATE','gym_mgt').'</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.esc_html__('PRODUCT NAME','gym_mgt').'</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.esc_html__('QUANTITY','gym_mgt').'</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.esc_html__('PRICE','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.esc_html__('TOTAL','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');

							$mpdf->WriteHTML('</tr>');

						} 

						else

						{ 						

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">#</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_center">'.esc_html__('DATE','gym_mgt').'</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_left">'.esc_html__('ENTRY','gym_mgt').'</th>');

								$mpdf->WriteHTML('<th class="color_white entry_heading align_right">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');								

							$mpdf->WriteHTML('</tr>');

						}	

					$mpdf->WriteHTML('</thead>');

					$mpdf->WriteHTML('<tbody>');

						$id=1;

						$i=1;

						$total_amount=0;

						if(!empty($income_data) || !empty($expense_data))

						{

							if(!empty($expense_data))

								$income_data=$expense_data;

							$member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);

							foreach($member_income as $result_income)

							{

								$income_entries=json_decode($result_income->entry);

								$discount_amount=$result_income->discount;

								$paid_amount=$result_income->paid_amount;

								$total_discount_amount= $result_income->amount - $discount_amount;								

								if($result_income->tax_id!='')

								{									

									$total_tax=0;

									$tax_array=explode(',',$result_income->tax_id);

									foreach($tax_array as $tax_id)

									{

										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);

										$tax_amount=$total_discount_amount * $tax_percentage / 100;

										$total_tax=$total_tax + $tax_amount;				

									}

								}

								else

								{

									$total_tax=$total_discount_amount * $result_income->tax/100;

								}

								$due_amount=0;

								$due_amount=$result_income->total_amount - $result_income->paid_amount;

								$grand_total=$total_discount_amount + $total_tax;

							   foreach($income_entries as $each_entry)

							   {

									$total_amount+=$each_entry->amount;

									$mpdf->WriteHTML('<tr class="entry_list">');

										$mpdf->WriteHTML('<td class="align_center">'.$id.'</td>');

										$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($result_income->invoice_date).'</td>');

										$mpdf->WriteHTML('<td >'.$each_entry->entry.'</td>');

										$mpdf->WriteHTML('<td class="align_right">'.number_format($each_entry->amount,2).'</td>');

									$mpdf->WriteHTML('</tr>');

									 $id+=1;

									$i+=1;

								}

								if($grand_total=='0')									

								{

									if($income_data->payment_status=='Paid')

									{

										$grand_total=$total_amount;

										$paid_amount=$total_amount;

										$due_amount=0;										

									}

									else

									{

										$grand_total=$total_amount;

										$paid_amount=0;

										$due_amount=$total_amount;															

									}

								}

							}

						}

						if(!empty($membership_data))

						{

							$membership_signup_amounts=$membership_data->membership_signup_amount;

							$mpdf->WriteHTML('<tr class="entry_list">');

								$mpdf->WriteHTML('<td class="align_center">'.$i.'</td>'); 

								$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($membership_data->created_date).'</td>'); 

								$mpdf->WriteHTML('<td>'.MJ_gmgt_get_membership_name($membership_data->membership_id).'</td>');								

								$mpdf->WriteHTML('<td class="align_right">'.number_format($membership_data->membership_fees_amount,2).'</td>');

							$mpdf->WriteHTML('</tr>');
							
							if( $membership_signup_amounts  > 0) 

							{
								
                                $mpdf->WriteHTML('<tr class="entry_list">');

								$mpdf->WriteHTML('<td class="align_center">2</td>'); 

								$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($membership_data->created_date).'</td>'); 

								$mpdf->WriteHTML('<td>Membership Signup Fee</td>');								

								$mpdf->WriteHTML('<td class="align_right">'.number_format($membership_data->membership_signup_amount,2).'</td>');

							$mpdf->WriteHTML('</tr>');

							}

						}

						if(!empty($selling_data))

						{

							$all_entry=json_decode($selling_data->entry);

							if(!empty($all_entry))

							{

								foreach($all_entry as $entry)

								{

									$obj_product=new MJ_gmgt_product;

									$product = $obj_product->MJ_gmgt_get_single_product($entry->entry);

									$product_name=$product->product_name;					

									$quentity=$entry->quentity;	

									$price=$product->price;	

									$mpdf->WriteHTML('<tr class="entry_list">');										

										$mpdf->WriteHTML('<td class="align_center">'.$i.'</td> ');

										$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($selling_data->sell_date).'</td>');

										$mpdf->WriteHTML('<td>'.$product_name.'</td>');

										$mpdf->WriteHTML('<td>'.$quentity.'</td>');

										$mpdf->WriteHTML('<td><span>'.$price.'</td>');

										$mpdf->WriteHTML('<td class="align_right">'.number_format($quentity * $price,2).'</td>');

									$mpdf->WriteHTML('</tr>');		

								$id+=1;

								$i+=1;									

								}

							}

							else

							{

								$obj_product=new MJ_gmgt_product;

								$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 

								$product_name=$product->product_name;					

								$quentity=$selling_data->quentity;	

								$price=$product->price;	

								$mpdf->WriteHTML('<tr class="entry_list">');										

									$mpdf->WriteHTML('<td class="align_center">'.$i.'</td> ');

									$mpdf->WriteHTML('<td class="align_center">'.MJ_gmgt_getdate_in_input_box($selling_data->sell_date).'</td>');

									$mpdf->WriteHTML('<td>'.$product_name.'</td>');

									$mpdf->WriteHTML('<td>'.$quentity.'</td>');

									$mpdf->WriteHTML('<td>'.$price.'</td>');

									$mpdf->WriteHTML('<td class="align_right">'.number_format($quentity * $price,2).'</td>');

								$mpdf->WriteHTML('</tr>');	

								$id+=1;

								$i+=1;

							}	

						}
					
					$mpdf->WriteHTML('</tbody>');

				$mpdf->WriteHTML('</table>');

				$mpdf->WriteHTML('<table>');

				 $mpdf->WriteHTML('<tr>');

				 $mpdf->WriteHTML('<td>');

					  $mpdf->WriteHTML('<table class="width_46_print" border="0">');

						$mpdf->WriteHTML('<tbody>');						

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td colspan="2" style="padding-left:15px;">');

									$mpdf->WriteHTML('<h3 class="payment_method_lable" style ="text-transform:uppercase;">'.esc_html__('Payment Method','gym_mgt').'');

								$mpdf->WriteHTML('</h3>');

								$mpdf->WriteHTML('</td>');								

							$mpdf->WriteHTML('</tr>');							

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td  class="width_311 font_12" style="padding-left:15px;">'.esc_html__('Bank Name','gym_mgt').' </td>');

								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_name' ).'</td>');

							$mpdf->WriteHTML('</tr>');

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td class="width_311 font_12" style="padding-left:15px;">'.esc_html__('Account No','gym_mgt').'</td>');

								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_acount_number' ).'</td>');

							$mpdf->WriteHTML('</tr>');						

						$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td class="width_311 font_12" style="padding-left:15px;">'.esc_html__('IFSC Code','gym_mgt').' </td>');

								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_bank_ifsc_code' ).'</td>');

							$mpdf->WriteHTML('</tr>');						

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td class="width_311 font_12" style="padding-left:15px;">'.esc_html__('Paypal Id','gym_mgt').' </td>');

								$mpdf->WriteHTML('<td class="font_12">: '.get_option( 'gmgt_paypal_email' ).'</td>');

							$mpdf->WriteHTML('</tr>');

						$mpdf->WriteHTML('</tbody>');

					$mpdf->WriteHTML('</table>'); 

					$mpdf->WriteHTML('</td>');

					$mpdf->WriteHTML('<td>');

					$mpdf->WriteHTML('<table class="width_54_print"  border="0">');

					$mpdf->WriteHTML('<tbody>');

						if(!empty($membership_data))

						{					
							
							$total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;

							$total_tax=$membership_data->tax_amount;	

                            $discount_amount=$membership_data->discount_amount;

							if(empty($discount_amount))
							{

								$discount_amount = 0;

							}
							else
							{

								$discount_amount = $discount_amount;

							}
							
							$paid_amount=$membership_data->paid_amount;

							$due_amount=abs($membership_data->membership_amount - $paid_amount);
							
							$grand_total=$membership_data->membership_amount;	
						}

						if(!empty($expense_data))

						{

							$grand_total=$total_amount;

						} 

						if(!empty($selling_data))

						{

							$all_entry=json_decode($selling_data->entry);

							if(!empty($all_entry))

							{

								$total_amount=$selling_data->amount;

								$discount_amount=$selling_data->discount;

								if(empty($discount_amount))
								{

									$discount_amount = 0;

								}
								else
								{

									$discount_amount = $discount_amount;

								}

								$total_discount_amount=$total_amount-$discount_amount;

								if($selling_data->tax_id!='')

								{									

									$total_tax=0;

									$tax_array=explode(',',$selling_data->tax_id);

									foreach($tax_array as $tax_id)

									{

										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);

										$tax_amount=$total_discount_amount * $tax_percentage / 100;

										$total_tax=$total_tax + $tax_amount;				

									}

								}

								else

								{

									$tax_per=$selling_data->tax;

									$total_tax=$total_discount_amount * $tax_per/100;

								}

								$paid_amount=$selling_data->paid_amount;

								$due_amount=abs($selling_data->total_amount - $paid_amount);

								$grand_total=$selling_data->total_amount;

							}

							else

							{

								$obj_product=new MJ_gmgt_product;

								$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 							

								$price=$product->price;	

								$total_amount=$price*$selling_data->quentity;

								$discount_amount=$selling_data->discount;

								if(empty($discount_amount))
								{

									$discount_amount = 0;

								}
								else
								{

									$discount_amount = $discount_amount;

								}
								
								$total_discount_amount=$total_amount-$discount_amount;

								if($selling_data->tax_id!='')

								{									

									$total_tax=0;

									$tax_array=explode(',',$selling_data->tax_id);

									foreach($tax_array as $tax_id)

									{

										$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);

										$tax_amount=$total_discount_amount * $tax_percentage / 100;

										$total_tax=$total_tax + $tax_amount;				

									}

								}

								else

								{

									$tax_per=$selling_data->tax;

									$total_tax=$total_discount_amount * $tax_per/100;

								}

								$paid_amount=$total_amount;

								$due_amount='0';

								$grand_total=$total_amount;

							}

						}		
						
							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<h4><td  class="width_70 align_right"><h4 class="margin">'.esc_html__('Subtotal','gym_mgt').' :</h4></td>');

								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span style="">'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($total_amount,2).'</h4></td>');

							$mpdf->WriteHTML('</tr>');

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.esc_html__('Discount Amount','gym_mgt').' :</h4></td>');

								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >- '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($discount_amount,2).'</h4></td>');

							$mpdf->WriteHTML('</tr>'); 
							
							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.esc_html__('Tax Amount','gym_mgt').' :</h4></td>');

								$mpdf->WriteHTML('<td class="align_right"><h4 class="margin"> <span >+ '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($total_tax,2).'</h4></td>');

							$mpdf->WriteHTML('</tr>');

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.esc_html__('Due Amount','gym_mgt').' :</h4></td>');

								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($due_amount,2).'</h4></td>');

							$mpdf->WriteHTML('</tr>');

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td class="width_70 align_right"><h4 class="margin">'.esc_html__('Paid Amount','gym_mgt').' :</h4></td>');

								$mpdf->WriteHTML('<td class="align_right"> <h4 class="margin"><span >'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($paid_amount,2).'</h4></td>');

							$mpdf->WriteHTML('</tr>');

							$mpdf->WriteHTML('<tr>');							

								$mpdf->WriteHTML('<td  class="width_70 align_right grand_total_lable"><h3 class="color_white margin">'.esc_html__('Grand Total','gym_mgt').' :</h3></td>');

								$mpdf->WriteHTML('<td class="align_right grand_total_amount"><h3 class="color_white margin">  <span>'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).'</span>'.number_format($grand_total,2).'</h3></td>');

							$mpdf->WriteHTML('</tr>');

						$mpdf->WriteHTML('</tbody>');

					$mpdf->WriteHTML('</table>');			

					$mpdf->WriteHTML('</td>');					

				  $mpdf->WriteHTML('</tr>');

				$mpdf->WriteHTML('</table>');

				if(!empty($history_detail_result))

				{

					$mpdf->WriteHTML('<hr>');					

					$mpdf->WriteHTML('<table class="width_100_print">');	

						$mpdf->WriteHTML('<tbody>');	

							$mpdf->WriteHTML('<tr>');

								$mpdf->WriteHTML('<td style="padding-left:20px;">');

									$mpdf->WriteHTML('<h3 class="entry_lable">'.esc_html__('Payment History','gym_mgt').'</h3>');

								$mpdf->WriteHTML('</td>');	

							$mpdf->WriteHTML('</tr>');	

						$mpdf->WriteHTML('</tbody>');

					$mpdf->WriteHTML('</table>');					

					$mpdf->WriteHTML('<table class="table table-bordered" class="width_93" border="1">');

					$mpdf->WriteHTML('<thead>');

						$mpdf->WriteHTML('<tr>');

							$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('DATE','gym_mgt').'</th>');

							$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')</th>');

							$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Method','gym_mgt').'</th>');

							$mpdf->WriteHTML('<th class="color_white entry_heading align_center" style ="text-transform:uppercase; !important">'.esc_html__('Payment Details','gym_mgt').'</th>');

						$mpdf->WriteHTML('</tr>');

					$mpdf->WriteHTML('</thead>');

					$mpdf->WriteHTML('<tbody>');

						foreach($history_detail_result as  $retrive_data)

						{						

							$mpdf->WriteHTML('<tr>');

							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->paid_by_date.'</td>');

							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->amount.'</td>');

							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->payment_method.'</td>');

							$mpdf->WriteHTML('<td class="align_center">'.$retrive_data->payment_description.'</td>');

							$mpdf->WriteHTML('</tr>');

						}

					$mpdf->WriteHTML('</tbody>');

					$mpdf->WriteHTML('</table>');

				}				

				$mpdf->WriteHTML('</div>');

			$mpdf->WriteHTML('</div>'); 

			$mpdf->WriteHTML('</body>'); 

			$mpdf->WriteHTML('</html>'); 

		$mpdf->Output($document_path.'invoice_'.$invoice_new_id.'_'.$current_user_id.'.pdf','F');

		$result = get_site_url().'/wp-content/uploads/translate_invoice_pdf/'.'invoice_'.$invoice_new_id.'_'.$current_user_id.'.pdf';

	return $result;

}






function gmdate_to_mydate($gmdate){







	







	$timezone=date_default_timezone_get();







	$userTimezone = new DateTimeZone($timezone);







	$gmtTimezone = new DateTimeZone('GMT');







	$myDateTime = new DateTime($gmdate, $gmtTimezone);







	$offset = $userTimezone->getOffset($myDateTime);







	return date("Y-m-d H:i:s", strtotime($gmdate)+$offset);







}















//SMS Servcie







function MJ_gmgt_sms_service_setting()







{







	?>







	<?php







	$select_serveice = $_POST['select_serveice'];















	if($select_serveice == 'clickatell')







	{







		$clickatell=get_option( 'gmgt_clickatell_sms_service');







		?>







		<div class="form-body user_form"> <!-- user_form Strat-->   







			<div class="row"><!--Row Div Strat--> 















				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="username" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['username'])) echo $clickatell['username'];?>" name="username">







							<label class="active" for="username"><?php esc_html_e('Username','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>







				</div>







				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="password" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['password'])) echo $clickatell['password'];?>" name="password">







							<label class="active" for="password"><?php esc_html_e('Password','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>







				</div>







				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="api_key" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['api_key'])) echo $clickatell['api_key'];?>" name="api_key">







							<label class="active" for="api_key"><?php esc_html_e('API Key','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>







				</div>







				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="sender_id" class="form-control validate[required]" type="text" value="<?php echo $clickatell['sender_id'];?>" name="sender_id">







							<label class="active" for="sender_id"><?php esc_html_e('Sender Id','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>







				</div>







			</div><!--Row Div End--> 







		</div><!-- user_form End-->







	<?php 







	}







	if($select_serveice == 'msg91')







	{







		$msg91=get_option( 'gmgt_msg91_sms_service');







		?>







		<div class="form-body user_form"> <!-- user_form Strat-->   







			<div class="row"><!--Row Div Strat--> 







				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="sms_auth_key" class="form-control validate[required]" type="text" value="<?php echo $msg91['sms_auth_key'];?>" name="sms_auth_key">







							<label class="active" for="sms_auth_key"><?php esc_html_e('Authentication Key','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>







				</div>







				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="msg91_senderID" class="form-control validate[required] text-input" type="text" name="msg91_senderID" value="<?php echo $msg91['msg91_senderID'];?>">







							<label class="active" for="msg91_senderID"><?php esc_html_e('SenderID','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>







				</div>







				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="sms_route" class="form-control validate[required] text-input" type="text" name="sms_route" value="<?php echo $msg91['sms_route'];?>">







							<label class="active" for="wpnc_sms_route"><?php esc_html_e('Route','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>







				</div>







			</div><!--Row Div End--> 







		</div><!-- user_form End--> 







	







	<?php 







	}







	die();







}















//SEND SMS NOTIFICTION FUNCTION FOR MSG91 SMS//







function gmgt_msg91_send_mail_function($mobiles,$message,$countary_code)







{	







	$msg91= get_option('gmgt_msg91_sms_service');







	$sender= $msg91['msg91_senderID'];







	$authkey= $msg91['sms_auth_key'];







	$route= $msg91['sms_route'];















	$curl = curl_init();	







    $curl_url="http://api.msg91.com/api/sendhttp.php?route=$route&sender=$sender&mobiles=$mobiles&authkey=$authkey&encrypt=1&message=$message&country=$countary_code";















	 curl_setopt_array($curl, array(







	 CURLOPT_URL =>$curl_url ,







	 CURLOPT_RETURNTRANSFER => true,







	 CURLOPT_ENCODING => "",







	 CURLOPT_MAXREDIRS => 10,







	 CURLOPT_TIMEOUT => 30,







	 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,







	 CURLOPT_CUSTOMREQUEST => "GET",







	 CURLOPT_SSL_VERIFYHOST => 0,







	 CURLOPT_SSL_VERIFYPEER => 0,







     ));







	$response = curl_exec($curl);







	$err = curl_error($curl);







	curl_close($curl);







	if ($err) {







		echo "err";







	  echo "cURL Error #:" . $err;







	}  







}















// Import data function //







function MJ_gmgt_import_data()







{







	?>







	<script type="text/javascript">







		$(document).ready(function() {







			"use strict";







			$('#inport_csv').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	







		} );







	</script>







	<div class="modal-header import_csv_popup">







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







		<h4 class="modal-title"><?php esc_html_e('Import Data','gym_mgt');?></h4>







	</div>







	<form class="form-horizontal import_csv_popup_form" id="inport_csv" action="#" method="post" enctype="multipart/form-data">







		<div class="form-body user_form">







			<div class="row">







				<div class="col-md-9 input">







					<div class="form-group Product_popup_rtl input">







						<div class="col-md-12 form-control">	







							<label for="inputEmail" class="custom-control-label custom-top-label ml-2 margin_left_30px"><?php esc_html_e('Select CSV File','gym_mgt');?><span class="require-field">*</span></label>







							<div class="col-sm-12">







								<input id="input-1" name="csv_file" type="file" class="form-control file validate[required]">







							</div>







						</div>







					</div>







				</div>







				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 margin_bottom_15">







					<button type="submit" class="btn save_btn" name="upload_csv_file"><?php esc_html_e('Save','gym_mgt');?></button>







				</div>







			</div>







		</div>







	</form>















    <?php 







	die();







}







//SET WORKOUT AARAY FUNCTION







function MJ_gmgt_set_workoutarray_video($data,$activity_id)







{







	$workout_array=array();







	







	foreach($data as $row)







	{







			$workout_array[$row->day_name][]= "<span class='col-md-2 col-sm-3 col-xs-12 float_left'>".$row->workout_name."</span>   







				<span class='col-md-2 col-sm-3 col-xs-6 float_left'>".$row->sets." ".esc_html__('Sets','gym_mgt')."</span>







			<span class='col-md-2 col-sm-2 col-xs-6 float_left'> ".$row->reps." ".esc_html__('Reps','gym_mgt')."</span>







				<span class='col-md-2 col-sm-2 col-xs-6 float_left'> ".$row->kg." ".esc_html__('KG','gym_mgt')."</span>







			<span class='col-md-2 col-sm-2  col-xs-6 float_left'> ".$row->time." ".esc_html__('Seconds','gym_mgt')."</span>







			<span class='col-md-2 col-sm-2  col-xs-6 float_left'>







			<a href='?page=gmgt_workouttype&tab=view_video&&action=view_video&activity_id=". $activity_id ."'>". esc_html__('View Video','gym_mgt')."</a></span>";







		







	}







	return $workout_array;







	







}







function compressImage($source, $destination, $quality) 







{















	$info = getimagesize($source);







  







	if ($info['mime'] == 'image/jpeg') 







	  $image = imagecreatefromjpeg($source);







  







	elseif ($info['mime'] == 'image/gif') 







	  $image = imagecreatefromgif($source);







  







	elseif ($info['mime'] == 'image/png') 







	  $image = imagecreatefrompng($source);







  







   return $destination;







  







}







  function  MJ_gmgt_get_activity_membership_api($id)







{







	global $wpdb;







	$result=array();







	$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';







	$memberships = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where activity_id= ".$id);







	if(!empty($memberships))







	{







		foreach($memberships as $row)







		{







			$result[]=MJ_gmgt_get_membership_name($row->membership_id);







		}







		//$memberhsuip_name=implode(",",$result);







		$memberhsuip_name=implode(",",array_diff($result, array(' ')));







		return $memberhsuip_name;







	}







	else







	{







		return $result;







	}







}







//GET MESSAGE BY ID FUNCTION







function MJ_gmgt_get_message_by_post_id($id)







{







	global $wpdb;







	$table_name = $wpdb->prefix . "Gmgt_message";







	$qry = $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id= %d ",$id);







	return $retrieve_subject = $wpdb->get_row($qry);















}







function MJ_gmgt_get_attendence_api_function($userid,$curr_date,$class_id)







{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	$result=$wpdb->get_var("SELECT status FROM $table_name WHERE attendence_date=$curr_date and user_id = $userid AND role_name = 'member' AND class_id=$class_id");







	return $result;















}







//GET MEMBER_BY_CLASS_ID//







function MJgmgt_get_member_by_class_id_api($class_id,$member_id)







{







	global $wpdb;







	$table_memberclass = $wpdb->prefix. 'gmgt_member_class';







	return $MemberClass = $wpdb->get_results("SELECT * FROM $table_memberclass WHERE class_id=$class_id and member_id=$member_id");







}















add_action( 'wp_ajax_nopriv_MJ_gmgt_generate_access_token',  'MJ_gmgt_generate_access_token');







add_action( 'wp_ajax_MJ_gmgt_generate_access_token',  'MJ_gmgt_generate_access_token');







/*Zoom Access Token*/







//add_action('init','MJgmgt_generate_access_token');







function MJ_gmgt_generate_access_token()







{







	$CLIENT_ID = get_option('gmgt_virtual_classschedule_client_id');







	$REDIRECT_URI = site_url().'/?page=callback';







	







	wp_redirect ("https://zoom.us/oauth/authorize?response_type=code&client_id=".$CLIENT_ID."&redirect_uri=".$REDIRECT_URI);







}















add_action( 'wp_ajax_MJ_gmgt_create_meeting', 'MJ_gmgt_create_meeting');







add_action( 'wp_ajax_nopriv_MJ_gmgt_create_meeting', 'MJ_gmgt_create_meeting');















//add_action( 'wp_ajax_create_meeting',  'ajax_create_meeting');







// CREATE MEETING FUNCTION







function MJ_gmgt_create_meeting()







{







	$obj_class=new MJ_gmgt_classschedule;







	$class_id = $_REQUEST['class_id'];







	//$class_id = "1";







	$route_data = $obj_class->MJ_gmgt_get_single_class($class_id);







	/* var_dump($route_data);







	die; */







	?>







	<style>







	 .modal-header{







		 height:auto;







	 }







	</style>







	<script type="text/javascript">







	$(document).ready(function() {







		$('#meeting_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});







	} );







	</script>







	<div class="modal-header">







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







		<h4 class="modal-title"><?php _e('Create Virtual Class','gym_mgt');?></h4>







	</div>







	<div class="">







	  	<div class="panel-body">   







        	<form name="route_form" action="" method="post" class="form-horizontal" id="meeting_form">







				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>







				<input type="hidden" name="action" value="<?php echo $action;?>">







				<input type="hidden" name="class_id" value="<?php echo $class_id;?>">







				<input type="hidden" name="class_name" value="<?php echo $route_data->class_name;?>">







				<?php $days=json_decode($route_data->day); ?>







				<input type="hidden" name="days" value="<?php echo implode(",",$days);?>">







				<input type="hidden" name="staff_id" value="<?php echo $route_data->staff_id;?>">







				<input type="hidden" name="start_time" value="<?php echo $route_data->start_time;?>">







				<input type="hidden" name="end_time" value="<?php echo $route_data->end_time;?>">







				<input type="hidden" name="class_created_id" value="<?php echo $route_data->class_created_id;?>">







				<input type="hidden" name="start_date" value="<?php echo $route_data->start_date;?>">







				<input type="hidden" name="end_date" value="<?php echo $route_data->end_date;?>">	







				<div class="form-body user_form"> <!-- user_form Strat-->   







					<div class="row"><!--Row Div Strat-->







						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







							<div class="form-group input">







								<div class="col-md-12 form-control">







									<input id="class_name" class="form-control" maxlength="50" type="text" value="<?php echo $route_data->class_name; ?>" name="class_name" disabled>







									<label class="active" for="member_id"><?php esc_html_e('Class Name','gym_mgt');?></label>







								</div>







							</div>







						</div>







						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







							<div class="form-group input">







								<div class="col-md-12 form-control">







									<input id="start_time" class="form-control" type="text" value="<?php echo $route_data->start_time; ?>" name="start_time" disabled>







									<label class="active" for="member_id"><?php esc_html_e('Start Time','gym_mgt');?></label>







								</div>







							</div>







						</div>







						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







							<div class="form-group input">







								<div class="col-md-12 form-control">







									<input id="end_time" class="form-control" type="text" value="<?php echo $route_data->end_time; ?>" name="end_time" disabled>







									<label class="active" for="member_id"><?php esc_html_e('End Time','gym_mgt');?></label>







								</div>







							</div>







						</div>







						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







							<div class="form-group input">







								<div class="col-md-12 form-control">







									<input id="start_date" class="form-control validate[required] text-input" type="text" name="start_date" value="<?php echo $route_data->start_date; ?>" disabled>







									<label class="active" for="member_id"><?php esc_html_e('Start Date','gym_mgt');?></label>







								</div>







							</div>







						</div>







						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







							<div class="form-group input">







								<div class="col-md-12 form-control">







									<input id="end_date" class="form-control validate[required] text-input" type="text" name="end_date" value="<?php echo $route_data->end_date; ?>" disabled>







									<label class="active" for="member_id"><?php esc_html_e('End Date','gym_mgt');?></label>







								</div>







							</div>







						</div>







						<?php $days=json_decode($route_data->day); ?>







						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







							<div class="form-group input">







								<div class="col-md-12 form-control">







									<input id="days" class="form-control validate[required] text-input" type="text" name="days" value="<?php echo implode(",",$days); ?>" disabled>







									<label class="active" for="member_id"><?php esc_html_e('Days','gym_mgt');?></label>







								</div>







							</div>







						</div>







						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 note_text_notice">







							<div class="form-group input">







								<div class="col-md-12 note_border margin_bottom_15px_res">







									<div class="form-field">







										<textarea name="agenda" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="500" id=""></textarea>







										<span class="txt-title-label"></span>







										<label class="text-area address active" for=""><?php esc_html_e('Description','gym_mgt');?></label>







									</div>







								</div>







							</div>







						</div>







						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">







							<div class="form-group input">







								<div class="col-md-12 form-control">







									<input id="password" class="form-control validate[minSize[8],maxSize[12]]" type="password" value="" name="password">







									<label class="active" for="member_id"><?php esc_html_e('Password','gym_mgt');?></label>







								</div>







							</div>







						</div>







						<?php wp_nonce_field( 'create_meeting_admin_nonce' ); ?>







					</div>







				</div> 







				<div class="form-body user_form"> <!-- user_form Strat-->   







					<div class="row"><!--Row Div Strat-->







						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">        	







							<input type="submit" value="<?php if($edit){ _e('Save Virtual Class','gym_mgt'); }else{ _e('Create Virtual Class','gym_mgt');}?>" name="create_meeting" class="btn save_btn" />







						</div>    







					</div>







				</div>     







     		</form>







   		</div>







	</div>







	<?php







	exit;







}







add_action( 'wp_ajax_MJ_gmgt_view_meeting_detail', 'MJ_gmgt_view_meeting_detail');







add_action( 'wp_ajax_nopriv_MJ_gmgt_view_meeting_detail', 'MJ_gmgt_view_meeting_detail');







//add_action( 'wp_ajax_view_meeting_detail',  'ajax_view_meeting_detail');







// VIEW MEETING DATA FUNCTION







function MJ_gmgt_view_meeting_detail()







{







	$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;







	$meeting_id = $_REQUEST['meeting_id'];







	$class_data = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_data_in_zoom($meeting_id);







	?>







	<script type="text/javascript">







		function copy_text()







		{















			var temp = $("<input>");







		  	$("body").append(temp);







		 	temp.val($('.copy_text').text()).select();







		  	document.execCommand("copy");















		}







	</script>







	<div class="modal-header">







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







		<h4 class="modal-title"><?php _e('View Virtual Class Details','gym_mgt');?></h4>







	</div>







	<div class="modal-body view_details_body_assigned_bed view_details_body margin_top_20px float_left">







		<div class="row">







			<div class="col-md-6 popup_padding_15px">







				<label for="" class="popup_label_heading"><?php esc_attr_e('Meeting ID', 'gym_mgt'); ?></label><br>







				<label for="" class="label_value"><?php echo esc_html($class_data->zoom_meeting_id); ?></label>







			</div>







			<div class="col-md-6 popup_padding_15px">







				<label for="" class="popup_label_heading"><?php esc_attr_e('Meeting Title','gym_mgt'); ?></label><br>







				<label for="" class="label_value"><?php echo $class_data->title; ?></label>







			</div>







			<div class="col-md-6 popup_padding_15px">







				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','gym_mgt'); ?></label><br>







				<label for="" class="label_value"><?php echo mj_gmgt_getdate_in_input_box($class_data->start_date); ?></label>







			</div>







			<div class="col-md-6 popup_padding_15px">







				<label for="" class="popup_label_heading"><?php esc_attr_e('End Date','gym_mgt'); ?></label><br>







				<label for="" class="label_value"><?php echo mj_gmgt_getdate_in_input_box($class_data->end_date); ?></label>







			</div>







			<div class="col-md-6 popup_padding_15px">







				<label for="" class="popup_label_heading"><?php esc_attr_e('Password', 'gym_mgt'); ?></label><br>







				<label for="" class="label_value"><?php echo esc_html($class_data->password); ?></label>







			</div>







			<div class="col-md-6 popup_padding_15px ">







				<label for="" class="popup_label_heading"><?php esc_attr_e('Join Virtual Class Link', 'gym_mgt'); ?></label><br>







				<label for="" class="copy_text label_value"><?php echo esc_html($class_data->meeting_join_link); ?></label>







			</div>







			<div class="col-md-12 popup_padding_15px">







				<label for="" class="popup_label_heading"><?php esc_attr_e('Topic','gym_mgt'); ?></label><br>







				<label for="" class="label_value"><?php if(!empty($class_data->agenda)){ echo $class_data->agenda; }else{ echo "N/A"; }  ?></label>







			</div>







			<div class="col-md-3">







				<button type="button" onclick="copy_text();" class="save_btn btn btn-success"><?php esc_attr_e('Copy Link','gym_mgt');?></button>







			</div>







		</div>







	</div>







	<?php







	exit;







}







function refresh_token()







{







	require_once GMS_PLUGIN_DIR. '/lib/vendor/autoload.php'; 







	$CLIENT_ID = get_option('gmgt_virtual_classschedule_client_id');







	$CLIENT_SECRET = get_option('gmgt_virtual_classschedule_client_secret_id');







	$arr_token = get_option('gmgt_virtual_classschedule_access_token');







    $token_decode = json_decode($arr_token);







    $refresh_token = $token_decode->refresh_token;







	$client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);







    $response = $client->request('POST', '/oauth/token', [







        'headers' => [







            "Authorization" => "Basic ". base64_encode($CLIENT_ID.':'.$CLIENT_SECRET)







        ],







        'query' => [







            "grant_type" => "refresh_token",







            "refresh_token" => $refresh_token







        ],







    ]); 







    $token = $response->getBody()->getContents();







    update_option( 'gmgt_virtual_classschedule_access_token', $token );







}







function MJ_gmgt_browser_javascript_check()







{







	$plugins_url = plugins_url('gym-management/ShowErrorPage.php');







	?>







	<noscript><meta http-equiv="refresh" content="0;URL=<?php echo $plugins_url;?>"></noscript> 







	<?php







}







// Schedule an action if it's not already scheduled







if ( ! wp_next_scheduled( 'isa_add_every_thirty_minutes' ) ) 







{







    wp_schedule_event( time(), 'every_thirty_minutes', 'isa_add_every_thirty_minutes' );







}















// Hook into that action that'll fire every three minutes







add_action( 'isa_add_every_thirty_minutes', 'every_thirty_minutes_event_func' );







function every_thirty_minutes_event_func() 







{







    refresh_token();







}







// Hook into that action that'll fire every three minutes







add_action( 'isa_add_every_five_minutes', 'every_five_minutes_event_func' );







function every_five_minutes_event_func() 







{







    MJ_gmgt_virtual_class_mail_reminder();







}







// VIRTUAL CLASS MAIL REMINDER FUNCTION







//add_action('init','MJgmgt_virtual_class_mail_reminder');







function MJ_gmgt_virtual_class_mail_reminder()







{







	$obj_virtual_classroom = new MJgmgt_virtual_classroom;







	$virtual_classroom_enable = get_option('gmgt_enable_virtual_classschedule');







	$virtual_classroom_reminder_enable = get_option('gmgt_enable_virtual_class_reminder');







	$virtual_classroom_reminder_time = get_option('gmgt_virtual_class_reminder_before_time');







	







	if($virtual_classroom_enable == 'yes' OR $virtual_classroom_reminder_enable == 'yes')







	{







		// day code counvert zoom data wise







		$virtual_classroom_data = $obj_virtual_classroom->MJ_gmgt_get_all_meeting_data_in_zoom();







		if (!empty($virtual_classroom_data))







		{ 







			 foreach ($virtual_classroom_data as $data)







			{ 







				//var_dump(strtotime($data->start_time));







				$currunt_time = current_time('h:i:s');







				// minuse time in minutes







				$duration = '-'.$virtual_classroom_reminder_time.' minutes';







				//var_dump($duration);







				$class_time = strtotime($duration, $data->start_time);







				$befour_class_time = date('h:i:s', $class_time);







				// check time cundition







				/*var_dump($currunt_time);







				var_dump($befour_class_time);







				die;*/







				if($currunt_time >= $befour_class_time)







				{ 







					MJ_gmgt_virtual_class_staff_mail_reminder($data->meeting_id);







					MJ_gmgt_virtual_class_member_mail_reminder($data->meeting_id);







				}







			}







		}







	}







}







// VIRTUAL CLASS TEACHER MAIL REMINDER FUNCTION







function MJ_gmgt_virtual_class_staff_mail_reminder($meeting_id)







{







	







	







	$obj_virtual_classroom = new MJgmgt_virtual_classroom;







	$meeting_data = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_data_in_zoom($meeting_id);







	







	$today_date = date(get_option('date_format'));







	$staff_name = MJ_gmgt_get_display_name($meeting_data->staff_id);







	$staff_id_all_data = get_userdata($meeting_data->staff_id);







	







	$time = $meeting_data->start_time.' TO '.$meeting_data->end_time;







	$start_zoom_virtual_class_link = "<p><a href=".$meeting_data->meeting_start_link." class='btn btn-primary'>".__('Start Virtual Class','gym_mgt')."</a></p><br><br>";







	$log_date = date("Y-m-d", strtotime($today_date));







	$mail_reminder_log_data = MJ_gmgt_cheack_virtual_class_mail_reminder_log_data($meeting_data->staff_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);







	if(empty($mail_reminder_log_data))







	{







		// send mail data







		$string = array();







		$string['{{staff_name}}'] = "<span>".$staff_name."</span><br><br>";







		$string['{{class_name}}'] = "<span>".$meeting_data->title."</span><br><br>";







		$string['{{date}}'] = "<span>".$today_date."</span><br><br>";







		$string['{{time}}'] = "<span>".$time."</span><br><br>";







		$string['{{virtual_class_id}}'] = "<span>".$meeting_data->zoom_meeting_id."</span><br><br>";







		$string['{{password}}'] = "<span>".$meeting_data->password."</span><br><br>";







		$string['{{start_zoom_virtual_class}}'] = $start_zoom_virtual_class_link;







		$string['{{GMGT_GYM_NAME}}'] = "<span>".get_option('gmgt_system_name')."</span><br><br>";







		$MsgContent = get_option('virtual_class_staff_reminder_mail_content');







		$MsgSubject	= get_option('virtual_class_staff_reminder_mail_subject');







		$message = MJgmgt_string_replacemnet($string,$MsgContent);







		$MsgSubject = MJgmgt_string_replacemnet($string,$MsgSubject);







		$email= $staff_id_all_data->user_email;







		$headers = "MIME-Version: 1.0\r\n";







		$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";







		if(get_option('gym_enable_notifications') == 'yes')







		{







			wp_mail($email,$MsgSubject,$message,$headers);	







		}







		MJ_gmgt_insert_virtual_class_mail_reminder_log($meeting_data->staff_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);







	}







}







// VIRTUAL CLASS STUDENTS MAIL REMINDER FUNCTION







function MJ_gmgt_virtual_class_member_mail_reminder($meeting_id)







{







	$obj_virtual_classroom = new MJgmgt_virtual_classroom;







	$meeting_data = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_data_in_zoom($meeting_id);







	$clasname = $meeting_data->title;







	$member_details=MJ_gmgt_get_member_by_class_id($meeting_data->class_id);







	$today_date = date(get_option('date_format'));







	$staff_name = MJ_gmgt_get_display_name($meeting_data->staff_id);







	$time = $meeting_data->start_time.' TO '.$meeting_data->end_time;







	$join_zoom_virtual_class_link = "<p><a href=".$meeting_data->meeting_join_link." class='btn btn-primary'>".__('Join Virtual Class','gym_mgt')."</a></p><br><br>";







	foreach($member_details as $member)







	{







		$log_date = date("Y-m-d", strtotime($today_date));







		$mail_reminder_log_data = MJ_gmgt_cheack_virtual_class_mail_reminder_log_data($member->member_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);







		if(empty($mail_reminder_log_data))







		{







			







			$member_info = get_userdata($member->member_id);







			//var_dump($member_info);







			$string = array();







			$string['{{member_name}}'] = "<span>".$member_info->display_name."</span><br><br>";







			$string['{{class_name}}'] = "<span>".$clasname."</span><br><br>";







			$string['{{staff_name}}'] = "<span>".$staff_name."</span><br><br>";







			$string['{{date}}'] = "<span>".$today_date."</span><br><br>";







			$string['{{time}}'] = "<span>".$time."</span><br><br>";







			$string['{{virtual_class_id}}'] = "<span>".$meeting_data->zoom_meeting_id."</span><br><br>";







			$string['{{password}}'] = "<span>".$meeting_data->password."</span><br><br>";







			$string['{{join_zoom_virtual_class}}'] = $join_zoom_virtual_class_link;







			$string['{{GMGT_GYM_NAME}}'] = "<span>".get_option('gmgt_system_name')."</span><br><br>";







			$MsgContent = get_option('virtual_class_member_reminder_mail_content');







			$MsgSubject	= get_option('virtual_class_member_reminder_mail_subject');







			$message = MJgmgt_string_replacemnet($string,$MsgContent);







			$MsgSubject = MJgmgt_string_replacemnet($string,$MsgSubject);







			$email= $member_info->user_email;







			$headers = "MIME-Version: 1.0\r\n";







			$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";







			if(get_option('gym_enable_notifications') == 'yes')







			{







				wp_mail($email,$MsgSubject,$message,$headers);







			}







			MJ_gmgt_insert_virtual_class_mail_reminder_log($member->member_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);







		}







	}







}







// INSERT VIRTUAL CLASS MAIL REMINDER LOG FUNCTION







function MJ_gmgt_insert_virtual_class_mail_reminder_log($user_id,$meeting_id,$class_id,$date)







{







	global $wpdb;







	$table_zoom_meeting_mail_reminder_log= $wpdb->prefix. 'gmgt_reminder_zoom_meeting_mail_log';







	$meeting_log_data['user_id'] = $user_id;







	$meeting_log_data['meeting_id'] = $meeting_id;







	$meeting_log_data['class_id'] = $class_id;







	$meeting_log_data['alert_date'] = $date;







	$result=$wpdb->insert( $table_zoom_meeting_mail_reminder_log, $meeting_log_data );







}







// CHEACK VIRTUAL CLASS MAIL REMINDER LOG FUNCTION







function MJ_gmgt_cheack_virtual_class_mail_reminder_log_data($user_id,$meeting_id,$class_id,$date)







{







	global $wpdb;







	$table_zoom_meeting_mail_reminder_log= $wpdb->prefix. 'gmgt_reminder_zoom_meeting_mail_log';







	$result = $wpdb->get_row("SELECT * FROM $table_zoom_meeting_mail_reminder_log WHERE user_id=$user_id AND meeting_id=$meeting_id AND class_id=$class_id AND alert_date='$date'");







	return $result;







}















add_action('init','MJ_gmgt_app_css_load');







function MJ_gmgt_app_css_load()







{



	if(isset($_REQUEST['page_action']))



	{



		



		if(isset($_REQUEST['page_action']) == 'web_view_hide' &&  $_REQUEST ['page'] )



		{	



		?>



		<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-3-6-0.js';?>"></script>



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/staff_member_app.css'; ?>">	



		<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/staff_member_app_responsive.css'; ?>">



		<?php







		}



	



	}



}



add_action( 'wp_ajax_nopriv_MJ_gmgt_qr_code_take_attendance',  'MJ_gmgt_qr_code_take_attendance');







add_action( 'wp_ajax_MJ_gmgt_qr_code_take_attendance',  'MJ_gmgt_qr_code_take_attendance');







function MJ_gmgt_qr_code_take_attendance()







{















	$attendance_url=$_REQUEST['attendance_url'];	















	$obj_attend= new MJ_gmgt_attendence();















	















	$qrcode_attendance=explode('_',$attendance_url);















	$member_id=$qrcode_attendance[0];















	$qr_class_id=$qrcode_attendance[1];















	$curr_date=$qrcode_attendance[2];















	$status ='Present';















	$attend_by = get_current_user_id();		











	$attendance_type = 'QR';



	







	$user_info = get_userdata($member_id);



	$currrent__date = date("Y-m-d");







	if($currrent__date < $user_info->end_date)



	{



		$savedata = $obj_attend->MJ_gmgt_add_attendence($curr_date,$qr_class_id,$member_id,$attend_by,$status,$attendance_type);



		$result = "1";



	}



	else



	{



		$result = "2";



	}



	echo $result;



	die;







}







function MJ_gmgt_check_membership_recurring_option($membership_id)



{



	global $wpdb;



	$table_membership = $wpdb->prefix. 'gmgt_membershiptype';



	$result = $wpdb->get_row("SELECT * FROM $table_membership where membership_id=$membership_id");



	if($result)



	{



	   return $result->gmgt_membership_recurring;	



	}



	else



	{



		return NULL;	



	}



}



function MJ_gym_frontend_membership_payment($user_id,$membership_id,$membership_start_date,$membership_end_date,$subscription_id,$subscription_amount)



{   



	global $wpdb;



	include_once(ABSPATH . 'wp-includes/pluggable.php');







	$table_income=$wpdb->prefix.'gmgt_income_expense';







	$table_gmgt_membership_payment_history = $wpdb->prefix .'gmgt_membership_payment_history';







	







	$updated1 = update_user_meta( $user_id, 'begin_date', $membership_start_date,'');







	$updated2 = update_user_meta( $user_id, 'end_date', $membership_end_date,'' );







	$updated3 = update_user_meta( $user_id, 'membership_id', $membership_id,'');







	$updated4 = update_user_meta( $user_id, 'subscription_id', $subscription_id,'');







	$updated5 = update_user_meta( $user_id, 'membership_status', 'continue','');







	//END Begin_date ANd end_date daye in member data//







		







   //Generate Membership Invoice//







   //invoice number generate //







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







	//End Invocie Number generate//







	//Add Entery In membership Payment Table//







	$membership_status = 'continue';







	$payment_data = array();







	$trasaction_id  = '';







	







	$payment_data['invoice_no']=$invoice_no;







	$payment_data['member_id'] = $user_id;







	$payment_data['membership_id'] = sanitize_text_field($membership_id);







	$payment_data['membership_fees_amount'] =$subscription_amount;







	$payment_data['membership_signup_amount'] = 0;







	$payment_data['tax_amount'] = 0;







	$membership_amount=$payment_data['membership_fees_amount'] + $payment_data['membership_signup_amount'] + $payment_data['tax_amount'];







	$payment_data['paid_amount'] = $membership_amount;







	$payment_data['membership_amount'] = $membership_amount;







	$payment_data['start_date'] = $membership_start_date;







	$payment_data['end_date'] = $membership_end_date;







	$payment_data['membership_status'] = $membership_status;







	//$payment_data['payment_status'] = 0;







	$payment_data['payment_status'] = 'Fully Paid';







	$payment_data['created_date'] = date("Y-m-d");







	$payment_data['created_by'] = $user_id;







	







	$plan_id=MJ_gmgt_add_membership_payment_detail_fun($payment_data);







	//End Entery In membership Payment Table//







		







	$insert_id=$plan_id;







	







	//save membership payment data into income table//	







	$table_income=$wpdb->prefix.'gmgt_income_expense';







	$membership_name=MJ_gmgt_get_membership_name($membership_id);







	$entry_array[]=array('entry'=>$membership_name,'amount'=>$subscription_amount);	







	$incomedata['entry']=json_encode($entry_array);	















	$incomedata['invoice_type']='income';







	$incomedata['invoice_label']=__("Fees Payment","gym_mgt");







	$incomedata['supplier_name']=$user_id;







	$incomedata['invoice_date']=date('Y-m-d');







	$incomedata['receiver_id']=$user_id;					







	$incomedata['amount']=$subscription_amount;					







	$incomedata['total_amount']=$subscription_amount;







	$incomedata['invoice_no']=$invoice_no;







	$incomedata['tax_id']='';







	







	$incomedata['paid_amount']=$subscription_amount;







	$incomedata['payment_status']='Fully Paid';







	$result_income=$wpdb->insert($table_income,$incomedata);







		







	//End save membership payment data into income table







	$feedata['mp_id']=$plan_id;			







	$feedata['amount']=$subscription_amount;







	$feedata['payment_method']='Stripe';		







	$feedata['trasaction_id']='';







	$feedata['created_by']=$user_id;







	$feedata['payment_description']='Recurring Membership Payment';







	$feedata['paid_by_date']=date("Y-m-d");







	$result=$wpdb->insert( $table_gmgt_membership_payment_history,$feedata );







	//Upgrade  Premium Plan to Premium Plan //







	//END Upgrade  Premium Plan to Premium Plan //







	return $plan_id;







}







//add membership payment details







function MJ_gmgt_add_membership_payment_detail_fun($data)







{







	global $wpdb;







	$table_gmgt_membership_payment = $wpdb->prefix. 'Gmgt_membership_payment';







	$result = $wpdb->insert($table_gmgt_membership_payment,$data);







	$lastid = $wpdb->insert_id;







	return $lastid;







}







add_action( 'wp_ajax_MJ_gmgt_start_new_subcription', 'MJ_gmgt_start_new_subcription');







add_action( 'wp_ajax_nopriv_MJ_gmgt_start_new_subcription', 'MJ_gmgt_start_new_subcription');







function MJ_gmgt_start_new_subcription()







{







	$member_id=$_REQUEST['member_id'];	







	$stripe_plan_id=$_REQUEST['stripe_plan_id'];	







	$membership_id=$_REQUEST['membership_id'];	







	







	?>







	







	<script type="text/javascript">







	$(document).ready(function() {







		"use strict";







		$('#expense_form1').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	







	} );







	</script>







	<div class="modal-header">







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







		<h4 class="modal-title"><?php echo get_option('gmgt_system_name');?></h4>







	</div>







	<div class="modal-body">







		<form name="expense_form1" action="" method="post" class="expense_form1 form-horizontal" id="expense_form1">







        	<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>







			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">







			<!-- <input type="hidden" name="payment_method" value="stripe_gym"> -->







			<input type="hidden" name="member_id" value="<?php echo esc_attr($member_id);?>">







			<div class="form-body user_form"> <!-- user_form Strat-->   







				<div class="row"><!--Row Div Strat--> 







					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">







						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>







						<?php 







						$obj_membership = new MJ_gmgt_membership();







						$membership_data=$obj_membership->MJ_gmgt_get_recurring_membership_list();







						?>







						<select name="selected_membership" id="selected_membership" class="form-control">







							<option value=""><?php esc_html_e('Select Membership','gym_mgt');?></option>







							<?php







							if(!empty($membership_data))







							{







								foreach($membership_data as $data)







								{







									?>







									<option value="<?php echo $data->membership_id; ?>"><?php echo $data->membership_label; ?></option>







									<?php







								}







							}







							?>







						</select>







					</div>







					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">







						<input type="submit" value="<?php esc_html_e('Add Subscription Payment','gym_mgt');?>" name="start_subscription_for_exsting_member" class="btn save_btn"/>







					</div>







				</div>







			</div>







		</form>







	</div>







	<?php







	die();







}







add_action( 'wp_ajax_MJ_gmgt_change_subcription', 'MJ_gmgt_change_subcription');







add_action( 'wp_ajax_nopriv_MJ_gmgt_change_subcription', 'MJ_gmgt_change_subcription');







function MJ_gmgt_change_subcription()







{







	$member_id=$_REQUEST['member_id'];	







	$stripe_plan_id=$_REQUEST['stripe_plan_id'];	







	$membership_id=$_REQUEST['membership_id'];	







	$stripe_customer_id=$_REQUEST['stripe_customer_id'];	







	$sub_id=$_REQUEST['sub_id'];	







	$subscription_id=$_REQUEST['subscription_id'];	







	







	?>







	







	<script type="text/javascript">







	$(document).ready(function() {







		"use strict";







		$('#expense_form1').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	







	} );







	</script>







	<div class="modal-header">







		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







		<h4 class="modal-title"><?php echo get_option('gmgt_system_name');?></h4>







	</div>







	<div class="modal-body">







		<form name="expense_form1" action="" method="post" class="expense_form1 form-horizontal" id="expense_form1">







        	<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>







			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">







			<!-- <input type="hidden" name="payment_method" value="stripe_gym"> -->







			<input type="hidden" name="member_id" value="<?php echo esc_attr($member_id);?>">







			<input type="hidden" name="stripe_plan_id" value="<?php echo esc_attr($stripe_plan_id);?>">







			<input type="hidden" name="stripe_customer_id" value="<?php echo esc_attr($stripe_customer_id);?>">







			<input type="hidden" name="subscription_id" value="<?php echo esc_attr($subscription_id);?>">







			<input type="hidden" name="sub_id" value="<?php echo esc_attr($sub_id);?>">







			<div class="form-body user_form"> <!-- user_form Strat-->   







				<div class="row"><!--Row Div Strat--> 







					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">







						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>







						<?php 







						$obj_membership = new MJ_gmgt_membership();







						$membership_data=$obj_membership->MJ_gmgt_get_recurring_membership_list_without_current_membership($membership_id);







						?>







						<select name="selected_membership" id="selected_membership" class="form-control validate[required]">







							<option value=""><?php esc_html_e('Select Membership','gym_mgt');?></option>







							<?php







							if(!empty($membership_data))







							{







								foreach($membership_data as $data)







								{







									?>







									<option value="<?php echo $data->membership_id; ?>"><?php echo $data->membership_label; ?></option>







									<?php







								}







							}







							?>







						</select>







					</div>







					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">







						<input type="submit" value="<?php esc_html_e('Subscription Payment','gym_mgt');?>" name="change_subscription_for_exsting_member" class="btn save_btn"/>







					</div>







				</div>







			</div>







		</form>







	</div>







	<?php







	die();







}







function MJ_gmgt_get_member_activity_by_membership_id()







{







	global $wpdb;







	$activity_id_implode="";







	$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';







	$user_id=get_current_user_id();







	$membership_id=get_user_meta($user_id , "membership_id", true);







	$result = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where membership_id=$membership_id");







	if(!empty($result))







	{







		foreach($result as $activity_data)







		{







			$activity_id[]=$activity_data->activity_id;







		}







		$activity_id_implode=implode(",",$activity_id);







	}







	return $activity_id_implode;







}







function MJ_gmgt_get_member_activity_by_membership_id_Api($user_id)







{







	global $wpdb;







	$activity_id_implode="";







	$table_gmgt_membership_activities = $wpdb->prefix. 'gmgt_membership_activities';







	$membership_id=get_user_meta($user_id , "membership_id", true);







	$result = $wpdb->get_results("SELECT * FROM $table_gmgt_membership_activities where membership_id=$membership_id");







	if(!empty($result))







	{







		foreach($result as $activity_data)







		{







			$activity_id[]=$activity_data->activity_id;







		}







		$activity_id_implode=implode(",",$activity_id);







	}







	return $activity_id_implode;







}







function MJ_gmgt_get_current_lan_code()







{







	$lancode=get_locale();







	$code=substr($lancode,0,2);







	return $code;







}







function MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type)







{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	$result=$wpdb->get_results("SELECT * FROM $table_name WHERE role_name='$type' and attendence_date between '$start_date' and '$end_date'");







	return $result;







}







function MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate_user_id($start_date,$end_date,$user_id)







{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	$result=$wpdb->get_results("SELECT * FROM $table_name WHERE user_id=$user_id and attendence_date between '$start_date' and '$end_date'");







	return $result;







}







function MJ_gmgt_get_user_display_name($user_id) 







{







    if (!$user = get_userdata($user_id))







        return false;







    return $user->data->display_name;







}







function MJ_gmgt_get_all_income_report_beetween_satrt_date_to_enddate($start_date,$end_date)







{







	global $wpdb;







	$table_name = $wpdb->prefix."gmgt_income_payment_history";







	$table_name1 = $wpdb->prefix."gmgt_sales_payment_history";







	$result=$wpdb->get_results("SELECT * FROM $table_name WHERE paid_by_date between '$start_date' and '$end_date'");







	$result1=$wpdb->get_results("SELECT * FROM $table_name1 WHERE paid_by_date between '$start_date' and '$end_date'");







	$result_merge_array=array_merge($result,$result1);







	return $result_merge_array;







}







function MJ_gmgt_get_all_expense_report_beetween_satrt_date_to_enddate($start_date,$end_date)







{







	 global $wpdb;







	 $table_income=$wpdb->prefix.'gmgt_income_expense';







	 $result=$wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='expense' and invoice_date between '$start_date' and '$end_date'");







	 return $result;







}







function MJ_gmgt_get_all_feespayment_report_beetween_start_date_to_enddate($start_date,$end_date)







{







	global $wpdb;







	$table_name = $wpdb->prefix."gmgt_membership_payment_history";







	$result=$wpdb->get_results("SELECT * FROM $table_name WHERE paid_by_date between '$start_date' and '$end_date'");







	return $result;







}















// Get All Sell Report //







function MJ_gmgt_get_all_sell_report_beetween_start_date_to_enddate($start_date,$end_date)







{







	global $wpdb;







	$table_name = $wpdb->prefix."gmgt_store";







	$result=$wpdb->get_results("SELECT * FROM $table_name WHERE sell_date between '$start_date' and '$end_date'");







	return $result;







}















// Get membership id by mp_id 







function MJ_gmgt_membership_id($mid)







{







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membership_payment';







	$result =$wpdb->get_row("SELECT membership_id FROM $table_name WHERE mp_id=".$mid);







	if(!empty($result))







	{







		return $result->membership_id;







	}







	else







	{







		return " ";







	}







}







//manually page wise access right for management //







function MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management($page)







{







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);







	$role = $obj_gym->role;







	if($role=='management')







	{ 







		$menu = get_option( 'gmgt_access_right_management');







	}







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{				







				return $value;







			}







		}







	}	







}















//user role wise access right array by fix page admin side //







function MJ_gmgt_get_userrole_wise_access_right_array_by_page($page)







{







	$curr_user_id=get_current_user_id();







	$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);







	$role = $obj_gym->role;



	$flage = 0;



	if($role=='management')







	{







		$menu = get_option( 'gmgt_access_right_management');







	}







	foreach ( $menu as $key1=>$value1 ) 







	{									







		foreach ( $value1 as $key=>$value ) 







		{	







			if ($page == $value['page_link'])







			{				







				if($value['view']=='0')







				{			







					$flage=0;







				}







				else







				{







				  $flage=1;







				}







			}







		}







	}	







	return $flage;







}



//ACCESS PERMISION ALERT MESSAGE FUNCTION for managemnt //



function MJ_gmgt_access_right_page_not_access_message_for_management()



{



	?>







	<script type="text/javascript">







		$(document).ready(function() 







		{







			"use strict";			







			alert("<?php esc_html_e('You do not have permission to perform this operation.','gym_mgt');?>");







			window.location.href='?page=gmgt_system';







		});







	</script>







	<?php







}







function MJ_gmgt_get_floting_value($value)







{







	return number_format((float)$value, 2, '.', '');







}	







function MJ_gmgt_get_user_total_active_member(){







	$active_member = get_users(







		array(







			'role' => 'member',







			'meta_query' => array(







				array(







					'key' => 'membership_status',







					'value' => 'Continue'







				)







			)







		)







	);







	$active_member_value=count($active_member);







	return $active_member_value;







}







function MJ_gmgt_get_user_total_expired_member(){







	$expired_member = get_users(







		array(







			'role' => 'member',







			'meta_query' => array(







				array(







					'key' => 'membership_status',







					'value' => 'Expired'







				)







			)







		)







	);		







	$expired_member_value=count($expired_member);







	return $expired_member_value;







}







//---------- Generate Invoice PDF ---------------//



function mj_gmgt_generate_invoice_pdf($invoice_id,$type)







{ 



	



	$obj_payment= new MJ_gmgt_payment();







	if($type=='membership_invoice')







	{		







		$obj_membership_payment=new MJ_gmgt_membership_payment;	







		$membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($invoice_id);







		$history_detail_result = MJ_gmgt_get_payment_history_by_mpid($invoice_id);		







	}







	if($type=='income')







	{







		$income_data=$obj_payment->MJ_gmgt_get_income_data($invoice_id);







		$history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($invoice_id);







		







	}







	if($type=='expense')







	{







		$expense_data=$obj_payment->MJ_gmgt_get_income_data($invoice_id);







	}







	if($type=='sell_invoice')







	{ 







		$obj_store=new MJ_gmgt_store;







		$selling_data=$obj_store->MJ_gmgt_get_single_selling($invoice_id);







		$history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($invoice_id);







	}







  	?>







	<style>







		.popup_label_heading{







			color: #818386;







			font-size: 14px !important;







			line-height: 0px;







			font-weight: 500;







			font-family: 'Poppins' !important;







			text-transform: uppercase;







		}

		





	</style>







	







	<h3 class=""><?php echo get_option( 'gmgt_system_name' ) ?></h3>







	<?php



	



	if (is_rtl())







	{



		?>







		<table style="float: right;position: absolute;vertical-align: top;background-repeat: no-repeat;">







			<tbody>







				<tr>







					<td>







						<img class=" invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/gym-management/assets/images/invoice_rtl.png'); ?>" width="100%">







					</td>







				</tr>







			</tbody>







		</table>







		<?php







	}







	else







	{



		



		?>







		<table style="float: right;position: absolute;vertical-align: top;background-repeat: no-repeat;">







			<tbody>







				<tr>







					<td>







						<img style="float: left;position: absolute1;vertical-align: top;background-repeat: no-repeat;" class="invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/gym-management/assets/images/invoice.png'); ?>" width="100%">







					</td>







				</tr>







			</tbody>







		</table>



		







		<?php



		



		



	}



	



	



	?>







	<table style="float: left;width: 100%;position: absolute!important;margin-top:-140px;">







		<tbody>







			<tr>







				<td width="80%">







					<table>







						<tbody>







							<tr>







								<td >







									<img style="height:54px;width:54px;border-radius:15px;" class="system_logo"  src="<?php echo esc_url(get_option( 'gmgt_gym_other_data_logo' )); ?>">	







								</td>







								<td  style="padding-left: 20px;">







									<h4 class="popup_label_heading"><?php esc_html_e('Address','gym_mgt'); ?></h4>







									<label for="" class="label_value word_break_all" style="font-size: 16px !important;color: #333333 !important;font-weight: 400;"><?php echo chunk_split(get_option( 'gmgt_gym_address' ),100,"<BR>").""; ?></label><br>







									







									<h4 class="popup_label_heading"><?php esc_html_e('Email','gym_mgt');?> </h4>







									<label for="" style="font-size: 16px !important;color: #333333 !important;font-weight: 400;" class="label_value word_break_all"><?php echo get_option( 'gmgt_email' ),"<BR>";  ?></label><br>















									<h4 class="popup_label_heading"><?php esc_html_e('Phone','gym_mgt');?> </h4>







									<label for="" style="font-size: 16px !important;color: #333333 !important;font-weight: 400;" class="label_value"><?php echo get_option( 'gmgt_contact_number' )."<br>";  ?></label>







								</td>







							</tr>







						</tbody>







					</table>







					







				</td>







			</tr>







		</tbody>







	</table>







	<br>







	<table>







		<tbody>







			<tr>







				<td width="72%">







					<?php







					$issue_date='DD-MM-YYYY';







					if(!empty($income_data))







					{







						$issue_date=$income_data->invoice_date;







						$payment_status=$income_data->payment_status;







						$invoice_no=$income_data->invoice_no;







					}







					if(!empty($membership_data))







					{







						$issue_date=$membership_data->created_date;







						if($membership_data->payment_status!='0')







						{	







							$payment_status=$membership_data->payment_status;







						}







						else







						{







							$payment_status='Unpaid';







						}		







						$invoice_no=$membership_data->invoice_no;







					}







					if(!empty($expense_data))







					{







						$issue_date=$expense_data->invoice_date;







						$payment_status=$expense_data->payment_status;







						$invoice_no=$expense_data->invoice_no;







					}







					if(!empty($selling_data))







					{







						$issue_date=$selling_data->sell_date;	







						if(!empty($selling_data->payment_status))







						{







							$payment_status=$selling_data->payment_status;







						}	







						else







						{







							$payment_status='Fully Paid';







						}		







						







						$invoice_no=$selling_data->invoice_no;







					}			







						







					?>







					<h3 class="billed_to_lable invoice_model_heading bill_to_width_12"><?php esc_html_e('Bill To','gym_mgt');?> : </h3>







					







					<?php







					if(!empty($expense_data))







					{







						$party_name=$expense_data->supplier_name; 







						echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";







					}







					else{







						if(!empty($income_data))







							$member_id=$income_data->supplier_name;







						if(!empty($membership_data))







							$member_id=$membership_data->member_id;







						if(!empty($selling_data))







							$member_id=$selling_data->member_id;







						$patient=get_userdata($member_id);						







						echo "<h3 class='display_name invoice_width_100'>".chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>"). "</h3>";















					}					







					?>







					<div>







						<?php 







						if(!empty($expense_data))







						{







							



						}







						else







						{







							if(!empty($income_data))







								$member_id=$income_data->supplier_name;







							if(!empty($membership_data))







								$member_id=$membership_data->member_id;







							if(!empty($selling_data))







								$member_id=$selling_data->member_id;







							$patient=get_userdata($member_id);						







							$address=get_user_meta( $member_id,'address',true );







							$city_name = get_user_meta( $member_id,'city_name',true );







							$zip_code = get_user_meta( $member_id,'zip_code',true );







							echo chunk_split($address,30,"<BR>"); 







							if(!empty($zip_code))







							{







								







								echo get_user_meta( $member_id,'zip_code',true ).",<BR>"; 







							}







							if(!empty($city_name))







							{







								echo get_user_meta( $member_id,'city_name',true ).","."<BR>"; ; 







							}







						}		







						?>	







					</div>







					







				</td>







				<td width="28%">







					<?php







					if($_REQUEST['invoice_type']!='expense')







					{







						?>	







						<table>







							<tbody>







								<tr>







									<td  style="background-color: #ba170b;color: #fff;padding:10px;">







										<h3><?php echo esc_html__('INVOICE','gym_mgt')."  #".$invoice_no;?></h3>







									</td>		







								</tr>







							</tbody>







						</table>







						<?php







					}







					?>







					<label style="color: #818386 !important;font-size: 14px !important;text-transform: uppercase;font-weight: 500;line-height: 0px;"><?php echo esc_html__('Date','gym_mgt') ?> :</label><label class="invoice_model_value" style="font-weight: 600;color: #333333;font-size: 16px !important;"><?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label><br>







					<label style="color: #818386 !important;font-size: 14px !important;text-transform: uppercase;font-weight: 500;line-height: 0px;"><?php echo esc_html__('Status','gym_mgt')?> :</label><label class="invoice_model_value" style="font-weight: 600;color: #333333;font-size: 16px !important;"> <?php

                                        if($payment_status == 'Unpaid')

                                        {

                                            echo '<span style="color:red;">'.esc_html__($payment_status,'gym_mgt').'</span>';

                                        }

                                        elseif($payment_status == 'Partially Paid')

                                        {

                                            echo '<span style="color:blue;">'.esc_html__($payment_status,'gym_mgt').'</span>';

                                        }

                                        elseif($payment_status == 'Part Paid')

                                        {

                                            echo '<span style="color:blue;">'.esc_html__($payment_status,'gym_mgt').'</span>';

                                        }

                                        elseif($payment_status == 'Paid')

                                        {

                                            echo '<span style="color:green;">'.esc_html__($payment_status,'gym_mgt').'</span>';

                                        } 

                                        else

                                        {

                                            echo '<span style="color:green;">'.esc_html__($payment_status,'gym_mgt').'</span>';

                                        }

                                        ?></label>







				</td>







			</tr>







		</tbody>







	</table>







	<?php







	if($_REQUEST['invoice_type']=='membership_invoice')







	{ 







		?>







		<h4 style="font-size: 16px;font-weight: 600;color: #333333;"><?php esc_attr_e('Membership Entries','gym_mgt');?></h4>







		<?php







	}







	elseif($_REQUEST['invoice_type']=='income')







	{ 







		?>







		<h4 style="font-size: 16px;font-weight: 600;color: #333333;"><?php esc_attr_e('Income Entries','gym_mgt');?></h4>







		<?php







	}







	elseif($_REQUEST['invoice_type']=='sell_invoice')







	{ 







		?>







		<h4 style="font-size: 16px;font-weight: 600;color: #333333;"><?php esc_attr_e('Sale Product','gym_mgt');?></h4>







		<?php







	}







	else







	{







		?>







		<h4 style="font-size: 16px;font-weight: 600;color: #333333;"><?php esc_attr_e('Expense Entries','gym_mgt');?></h4>







		<?php







	}







	?>







	







	<table class="table table-bordered" width="100%" style="">







		<thead style="background-color: white !important;">







			<?php







			if($_REQUEST['invoice_type']=='membership_invoice')







			{







				?>				







				<tr style="background-color: white !important;">







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;">#</th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php esc_attr_e('Date','gym_mgt');?></th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Membership Name','gym_mgt');?> </th>







					<th class="align_left" style="color: #818386 !important;font-weight: 600;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Amount','gym_mgt');?></th>







				</tr>







				<?php







			}







			elseif($_REQUEST['invoice_type']=='sell_invoice')







			{







				?>				







				<tr style="background-color: #F2F2F2 !important;">







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;">#</th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php esc_attr_e('Date','gym_mgt');?></th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Product Name','gym_mgt');?> </th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Quantity','gym_mgt');?></th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Price','gym_mgt');?> </th>







					<th class="align_left" style="color: #818386 !important;font-weight: 600;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Total','gym_mgt');?></th>







				</tr>







				<?php







			}







			else







			{







				?>				







				<tr style="background-color: #F2F2F2 !important;">







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;">#</th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php esc_attr_e('Date','gym_mgt');?></th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Entry','gym_mgt');?> </th>







					<th class="align_left" style="color: #818386 !important;font-weight: 600;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Amount','gym_mgt');?></th>







				</tr>







				<?php







			}







			?>	







		</thead>







		<tbody>







			<?php 







			$id=1;







			$i=1;







			$total_amount=0;







			if(!empty($income_data) || !empty($expense_data))







			{







				if(!empty($expense_data))







				{







					$income_data=$expense_data;







				}







				







				$member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);







				







				foreach($member_income as $result_income)







				{







					$income_entries=json_decode($result_income->entry);







					$discount_amount=$result_income->discount;







					$paid_amount=$result_income->paid_amount;







					$total_discount_amount= $result_income->amount - $discount_amount;







					if($result_income->tax_id!='')







					{									







						$total_tax=0;







						$tax_array=explode(',',$result_income->tax_id);







						foreach($tax_array as $tax_id)







						{







							$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







												







							$tax_amount=$total_discount_amount * $tax_percentage / 100;







							







							$total_tax=$total_tax + $tax_amount;				







						}







					}







					else







					{







						$total_tax=$total_discount_amount * $result_income->tax/100;






					}







					$due_amount=0;







					$due_amount=$result_income->total_amount - $result_income->paid_amount;







					$grand_total=$total_discount_amount + $total_tax;















					foreach($income_entries as $each_entry)







					{







						$total_amount+=$each_entry->amount;								







						?>







						<tr style=" border-bottom: 1px solid #E1E3E5 !important;">







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $id;?></td>







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_getdate_in_input_box($result_income->invoice_date);?></td>







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $each_entry->entry; ?> </td>







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo number_format($each_entry->amount,2); ?></td>







						</tr>







						<?php 







						$id+=1;







						$i+=1;







					}







					if($grand_total=='0')									







					{	







						if($income_data->payment_status=='Paid')







						{







							







							$grand_total=$total_amount;







							$paid_amount=$total_amount;







							$due_amount=0;										







						}







						else







						{







							







							$grand_total=$total_amount;







							$paid_amount=0;







							$due_amount=$total_amount;															







						}







					}







				}







			}







			if(!empty($membership_data))







			{







				$membership_signup_amounts=$membership_data->membership_signup_amount;







				?>







				<tr>







					<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $i;?></td>







					<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td>







					<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_get_membership_name($membership_data->membership_id);?></td>







					<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo number_format($membership_data->membership_fees_amount,2); ?></td>







				</tr>







				<?php 







				if( $membership_signup_amounts  > 0) 







				{







					?>







					<tr class="">







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo 2 ;?></td> 







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td> 







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_html_e('Membership Signup Fee','gym_mgt');?></td>								







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo number_format($membership_data->membership_signup_amount,2); ?></td>







					</tr>







					<?php







				}







			}







			if(!empty($selling_data))







			{







				$all_entry=json_decode($selling_data->entry);







				if(!empty($all_entry))







				{







					foreach($all_entry as $entry)







					{







						$obj_product=new MJ_gmgt_product;







						$product = $obj_product->MJ_gmgt_get_single_product($entry->entry);







					







						$product_name=$product->product_name;					







						if(!empty($entry->quentity))



						{



							$quentity=$entry->quentity;



						}else{



							$quentity=0;	



						}











						if(isset($product->price))



						{



							$price=$product->price;	



						}else{



							$price=0;	



						}















						?>







						<tr class="">										







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $i;?></td> 







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $product_name;?> </td>







							<td  class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php echo $quentity; ?></td>







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_get_floting_value($price); ?></td>







							<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo number_format($quentity * $price,2); ?></td>







						</tr>







						<?php







						$id+=1;







						$i+=1;







					}







				}







				else







				{







					$obj_product=new MJ_gmgt_product;







					$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 







					







					$product_name=$product->product_name;					







					$quentity=$selling_data->quentity;	







					$price=$product->price;	







					?>







					<tr class="">										







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $i;?></td> 







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $product_name;?> </td>







						<td  class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php echo $quentity; ?></td>







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php echo $price; ?></td>







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php echo number_format($quentity * $price,2); ?></td>







					</tr>







					<?php







					$id+=1;







					$i+=1;







				}







			}







			?>







		</tbody> 







	</table>







	<?php 







	if(!empty($membership_data))







	{







		$total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;







		$total_tax=$membership_data->tax_amount;							



		



        $discount_amount=$membership_data->discount_amount;



        



		$paid_amount=$membership_data->paid_amount;







		$due_amount=abs($membership_data->membership_amount - $paid_amount);







		$grand_total=$membership_data->membership_amount;							







	}







	if(!empty($expense_data))







	{







		$grand_total=$total_amount;







	}







	if(!empty($selling_data))







	{







		$all_entry=json_decode($selling_data->entry);







		







		if(!empty($all_entry))







		{







			$total_amount=$selling_data->amount;







			$discount_amount=$selling_data->discount;







			$total_discount_amount=$total_amount-$discount_amount;







			







			if($selling_data->tax_id!='')







			{									







				$total_tax=0;







				$tax_array=explode(',',$selling_data->tax_id);







				foreach($tax_array as $tax_id)







				{







					$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







										







					$tax_amount=$total_discount_amount * $tax_percentage / 100;







					







					$total_tax=$total_tax + $tax_amount;				


				}







			}







			else







			{







				$total_tax=0;



                                $tax_array=explode(',',$selling_data->tax);



                                foreach($tax_array as $tax)



                                {



                                    $tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax);



                                                        



                                    $tax_amount=$total_discount_amount * $tax_percentage / 100;



                                    



                                    $total_tax=$total_tax + $tax_amount;				


                                }




			}







			







			$paid_amount=$selling_data->paid_amount;







			$due_amount=abs($selling_data->total_amount - $paid_amount);







			$grand_total=$selling_data->total_amount;







		}







		else







		{	







			$obj_product=new MJ_gmgt_product;







			$product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id);







			$price=$product->price;	







			







			$total_amount=$price*$selling_data->quentity;







			$discount_amount=$selling_data->discount;







			$total_discount_amount=$total_amount-$discount_amount;







			







			if($selling_data->tax_id!='')







			{									







				$total_tax=0;







				$tax_array=explode(',',$selling_data->tax_id);







				foreach($tax_array as $tax_id)







				{







					$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);







										







					$tax_amount=$total_discount_amount * $tax_percentage / 100;







					







					$total_tax=$total_tax + $tax_amount;				


					



				}







			}







			else







			{







				$tax_per=$selling_data->tax;







				$total_tax=$total_discount_amount * $tax_per/100;

				





			}




			


											



			



			$paid_amount=$total_amount;







			$due_amount='0';







			$grand_total=$total_amount;								







		}		







	}							







	?>







	<table width="100%" border="0">



		<tbody>



			<tr>



				<td>



					<table width="100%" border="0">





 

						<h3 class="display_name align_center" style ="text-transform:uppercase;"><?php esc_attr_e('Payment Method','gym_mgt');?></h3>







						<tr style="">







							<td width="25%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e('Bank Name','gym_mgt');?></td>







							<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_name' );?></td>







						</tr>







						<tr style="">







							<td  width="25%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e('Account No.','gym_mgt');?></td>







							<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_acount_number' );?></td>







						</tr>







						<tr style="">







							<td  width="25%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e('IFSC Code','gym_mgt');?></td>







							<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_ifsc_code' );?></td>







						</tr>







						<tr style="">







							<td  width="25%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e('Paypal ID','gym_mgt');?></td>







							<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_paypal_email' );?></td>







						</tr>







					</table>



				</td>



				<td>



					<table width="100%"  border="0">







						<tbody>







							<tr style="">







								<td width="80%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e('Sub Total :','gym_mgt');?></td>







								<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_amount,2);?></td>







							</tr>







							<?php







							if($_REQUEST['invoice_type']!='expense')







							{




									?>







									<tr>







										<td width="80%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e('Discount Amount :','gym_mgt');?></td>







										<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;"><?php  echo "-";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php if(!empty($discount_amount)){ echo number_format($discount_amount,2);}else{ echo number_format('0',2);} ?></td>







									</tr>







									<tr>



										



										<td width="80%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e( 'Tax Amount :','gym_mgt' ); ?></td>







										<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;"><?php  echo "+";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?><?php echo number_format($total_tax,2); ?></td>







									</tr>







									<tr>







										<td width="80%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e('Due Amount :','gym_mgt'); ?></td>







										<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($due_amount,2); ?></td>







									</tr>







									<tr>







										<td width="80%" align="right" style="padding-bottom: 10px;font-size: 32px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e( 'Paid Amount :','gym_mgt' ); ?></td>







										<td align="left" style="padding-bottom: 10px;font-size: 32px;color: #333333 !important;font-weight: 700;"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($paid_amount,2); ?></td>







									</tr>







									<?php







								







							}



							



							?>







						</tbody>







					</table>



				</td>



			</tr>



		</tbody>



	</table>







	<table style="width:100%;">







		<tbody>







			<tr>







				<td width="65%"></td>







				<td style="background-color: #ba170b;color: #fff;">







					<table style="background-color: #ba170b;color: #fff;">







						<tbody>







							<tr>







								<td  style="background-color: #ba170b;color: #fff;padding:10px">







									<h3 >







										<?php esc_html_e('Grand Total','gym_mgt');?>







									</h3>







								</td>







								<td  style="background-color: #ba170b;color: #fff;padding:10px;">







									<h3><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($grand_total,2); ?></h3>







								</td>







							</tr>







						</tbody>







					</table>







				</td>







			</tr>







		</tbody>







	</table>











	<?php 



	



	if(!empty($history_detail_result))







	{ 



		?>







		<h4 style="font-size: 16px;font-weight: 600;color: #333333;"><?php esc_attr_e('Payment History','gym_mgt');?></h4>







		<table class="table table-bordered" width="100%" style="">







			<thead style="background-color: #F2F2F2 !important;">







				<tr style="background-color: #F2F2F2 !important;">







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px; text-transform:uppercase; !important"><?php esc_attr_e('Date','gym_mgt');?></th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px; text-transform:uppercase; !important"> <?php esc_attr_e('Amount','gym_mgt');?></th>







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px; text-transform:uppercase; !important"><?php esc_attr_e('Method','gym_mgt');?> </th>				







					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px; text-transform:uppercase; !important"><?php esc_attr_e('Payment Details','gym_mgt');?> </th>	







				</tr>







			</thead>







			<tbody>







				<?php 







				foreach($history_detail_result as  $retrive_data)







				{







					?>







					<tr style=" border-bottom: 1px solid #E1E3E5 !important;">







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_getdate_in_input_box($retrive_data->paid_by_date);?></td>







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo MJ_gmgt_get_floting_value($retrive_data->amount); ?></td>







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo  esc_html__($retrive_data->payment_method,"gym_mgt"); ?></td>







						<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php if(!empty($retrive_data->payment_description)){ echo  $retrive_data->payment_description; }else{ echo 'N/A'; }?></td>







					</tr>







					<?php 







				} ?>







			</tbody>







		</table>







		<?php 







	} 	







}







function mj_gmgt_get_user_role($id){	







	$result = get_userdata($id);







	$role = implode(', ', $result->roles);







	return $role;







}















function gettext_filter($translation, $orig, $domain) {







    switch($orig) {







        case 'Username or Email Address':







            $translation = esc_html__( 'Email ID' , 'gym_mgt');







            break;







        case 'Username':







            $translation = esc_html__( 'Email ID' , 'gym_mgt');







            break;







    }







    return $translation;







}



add_filter('gettext', 'gettext_filter', 10, 3);



ob_clean();



function MJ_gmgt_send_pushnotification($payload)







{







    $curl = curl_init();







    curl_setopt_array($curl, array(







		CURLOPT_URL => "https://exp.host/--/api/v2/push/send",







		CURLOPT_RETURNTRANSFER => true,







		CURLOPT_ENCODING => "",







		CURLOPT_MAXREDIRS => 10,







		CURLOPT_TIMEOUT => 30,







		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,







		CURLOPT_CUSTOMREQUEST => "POST",







		CURLOPT_POSTFIELDS => json_encode($payload),







		CURLOPT_HTTPHEADER => array(







			"Accept: application/json",







			"Accept-Encoding: gzip, deflate",







			"Content-Type: application/json",







			"cache-control: no-cache",







			"host: exp.host"







		),







    ));











    $response = curl_exec($curl);







    $err = curl_error($curl);







	curl_close($curl);



	



    return $response;







}



add_filter( 'cron_schedules', 'create_cron_for_recurring_membership' );



function create_cron_for_recurring_membership( $schedules ) 



{



    $schedules['every_minute'] = array(



            'interval'  => 60,



            'display'   => esc_html__('Every minute', 'textdomain' )



    );



    return $schedules;



} 



if ( ! wp_next_scheduled( 'create_cron_for_recurring_membership' ) )



{



    wp_schedule_event( time(), 'every_minute', 'create_cron_for_recurring_membership' );



}



add_action( 'create_cron_for_recurring_membership', 'MJ_gmgt_menual_create_invoices_for_recurring_membership' );



//add_action( "init", "MJ_gmgt_menual_create_invoices_for_recurring_membership");



function MJ_gmgt_menual_create_invoices_for_recurring_membership()



{



	global $wpdb;



	$current_date=date("Y-m-d");



	$end_member = get_users(



	array(



		'role' => 'member',



		'meta_query' => array(



		array(



				'key' => 'membership_status',



				'value' =>'Continue',



				'compare' => '='



			),



		array(



				'key' => 'member_type',



				'value' =>"Member",



				'compare' => '='



			),



		array(



				'key' => 'end_date',



				'value' =>$current_date,



				'compare' => '='



			),



		)



	));	







	if(!empty($end_member))



	{



		foreach($end_member as $member)



		{	



			$user_id=$member->ID;



			$membership_id=get_user_meta( $user_id, "membership_id", true );



			//invoice number generate



			$table_income=$wpdb->prefix.'gmgt_income_expense';



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



			$obj_MJ_gmgt_member=new MJ_gmgt_member;



			$obj_membership=new MJ_gmgt_membership;	



			$membership=$obj_membership->MJ_gmgt_get_single_membership($membership_id);



			$membership_status = 'continue';



			$payment_data = array();



			$payment_data['invoice_no']=$invoice_no;



			$payment_data['member_id'] = $user_id;



			$payment_data['membership_id'] = sanitize_text_field($membership_id);



			$payment_data['membership_fees_amount'] = MJ_gmgt_get_membership_price($membership_id);



			$payment_data['tax_amount'] = MJ_gmgt_get_membership_tax_amount($membership_id,'renew_membership');



			$payment_data['tax_id'] = MJ_gmgt_get_membership_tax($membership_id);



			$membership_amount= (int)$payment_data['membership_fees_amount'] + (float)$payment_data['tax_amount'];



			$payment_data['membership_amount'] = $membership_amount;



			$joiningdate=date("Y-m-d");



			$validity=$membership->membership_length_id;



			$expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));



			$payment_data['start_date'] = $joiningdate;



			$payment_data['end_date'] = $expiredate;



			$payment_data['membership_status'] = $membership_status;



			$payment_data['payment_status']='Unpaid';



			$payment_data['created_date'] = date("Y-m-d");



			$payment_data['created_by'] = get_current_user_id();



			$plan_id = $obj_MJ_gmgt_member->MJ_gmgt_add_membership_payment_detail($payment_data);



			//membership invoice mail send



			$insert_id=$plan_id;



			$paymentlink=home_url().'?dashboard=user&page=membership_payment';



			$gymname=get_option( 'gmgt_system_name' );



			$userdata=get_userdata(sanitize_text_field($user_id));



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



			//save membership payment data into income table			



			$table_income=$wpdb->prefix.'gmgt_income_expense';



			$membership_name=MJ_gmgt_get_membership_name($membership_id);



			$entry_array[]=array('entry'=>$membership_name,'amount'=>MJ_gmgt_get_membership_price($membership_id));	



			$entry_array1[]=array('entry'=>esc_html__("Membership Signup Fee","gym_mgt"),'amount'=>MJ_gmgt_get_membership_signup_amount($membership_id));	



			$entry_array_merge=array_merge($entry_array,$entry_array1);



			$incomedata['entry']=json_encode($entry_array_merge);	



			$incomedata['invoice_type']='income';



			$incomedata['invoice_label']=esc_html__("Fees Payment","gym_mgt");



			$incomedata['supplier_name']=$user_id;



			$incomedata['invoice_date']=date('Y-m-d');



			$incomedata['receiver_id']=get_current_user_id();					



			$incomedata['amount']=$membership_amount;					



			$incomedata['total_amount']=$membership_amount;



			$incomedata['invoice_no']=$invoice_no;



			$incomedata['tax_id']=MJ_gmgt_get_membership_tax($membership_id);



			$incomedata['paid_amount']=0;



			$incomedata['payment_status']='Unpaid';



			$result_income=$wpdb->insert($table_income,$incomedata); 



			update_user_meta( $user_id, 'begin_date', $joiningdate );	



			update_user_meta( $user_id, 'end_date', $expiredate );	



		}



	}	







}



function MJ_gmgt_datatable_heder()



{



	$datatbl_heder_value = get_option( 'gmgt_heder_enable' ); 



	if($datatbl_heder_value == "no")



	{



		$gmgt_datatbl_heder= "gmgt_heder_none";



	}



	else



	{		



		$gmgt_datatbl_heder= "gmgt_heder_block";



	}



	return $gmgt_datatbl_heder;



}







add_action( 'wp_ajax_MJ_gmgt_product_validation', 'MJ_gmgt_product_validation');



function MJ_gmgt_product_validation()



{



	$obj_product=new MJ_gmgt_product;







	if($_REQUEST['product_action']=='edit')



	{



		$data=$obj_product->MJ_gmgt_get_all_product_by_name_count(sanitize_text_field($_REQUEST['product_name']),sanitize_text_field($_REQUEST['product_id']));



		$data1=$obj_product->MJ_gmgt_get_all_product_by_sku_number_count(sanitize_text_field($_REQUEST['sku_number']),sanitize_text_field($_REQUEST['product_id']));



		$data2=$obj_product->MJ_gmgt_get_all_product_by_name_and_sku_number_Count(sanitize_text_field($_REQUEST['product_name']),sanitize_text_field($_REQUEST['sku_number']),sanitize_text_field($_REQUEST['product_id']));



	}



	else



	{



		$data=$obj_product->MJ_gmgt_get_all_product_by_name(sanitize_text_field($_REQUEST['product_name']));



		$data1=$obj_product->MJ_gmgt_get_all_product_by_sku_number(sanitize_text_field($_REQUEST['sku_number']));



		$data2=$obj_product->MJ_gmgt_get_all_product_by_name_and_sku_number(sanitize_text_field($_REQUEST['product_name']),sanitize_text_field($_REQUEST['sku_number']));



	}







	if(!empty($data2))



	{



		echo "1";



	}



	else



	{



		if(!empty($data))



		{



			echo "2";



		}				



		elseif(!empty($data1))



		{



			echo "3";



		}	



	}



	die();



}







function MJ_gmgt_frontend_dashboard_card_access()



{



	$user_id = get_current_user_id();



	$role=MJ_gmgt_get_roles($user_id);







	if($role=='member')



	{ 



		$card_access = get_option( 'gmgt_dashboard_card_for_member');



	}



	elseif($role=='staff_member')



	{



		$card_access = get_option( 'gmgt_dashboard_card_for_staffmember');



	}



	elseif($role=='accountant')



	{



		$card_access = get_option( 'dashboard_card_access_for_accountant');



	}



	return $card_access;



}











//--------- AUTO SUGGEST OF ASSIGN WORKOUT --------------//



add_action( 'wp_ajax_BindControls', 'BindControls');



function BindControls() 



{



	$activity_category=MJ_gmgt_get_all_category('activity_category');



	$activity_array = array();







	foreach($activity_category as $activity)



	{



		$post_title[] = $activity->post_title;



		$post_id[] = $activity->ID;



	}



	



	$activity_array[] = array("post_id"=>$post_id,"post_title"=>$post_title);



	echo json_encode($activity_array);



	die();



}







add_action( 'wp_ajax_append_activity_by_auto_suggest', 'append_activity_by_auto_suggest');

add_action( 'wp_ajax_nopriv_append_activity_by_auto_suggest', 'append_activity_by_auto_suggest');

function append_activity_by_auto_suggest()



{



	$activity_title = $_REQUEST['search_value'];



	global $wpdb;



	$query = 'SELECT * FROM ' . $wpdb->posts . '



        WHERE post_title=\'' . $activity_title . '\'';



	$retrive_data = $wpdb->get_row($query);







	if($_REQUEST['number'] == 1)



	{

		

		

		?>



		<!-- <script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/workout_activity.js';?>"></script> -->



		<?php



	}



	?>



	<div class="col-sm-12 col-xs-12 margin_top_20px">



		<div class="form-group padding_20px activity_main_div has-search col-sm-12 col-xs-12 activity_name_<?php echo $retrive_data->ID ?>">



			<h3>



				<label name="" class="activity_title">



					<strong><?php echo esc_attr($retrive_data->post_title); ?></strong>



				</label>



			</h3>	



			<div class="col-md-12 form-control">



				<div class="form-group col-sm-12 col-xs-12 has-search position_relative">



					<span class="fa fa-search form-control-activity"></span><input type="text" data-value="<?php echo $retrive_data->ID; ?>" class="form-control activity_input_value activity_category_input activity_cat_id_<?php echo $retrive_data->ID; ?> min_height" placeholder="<?php esc_html_e('Search Activity','gym_mgt');?>" id="" />



				</div>



			</div>	



			<input type="hidden" value="<?php echo $retrive_data->ID; ?>" class="activity_id_hidden activity_id_<?php echo $retrive_data->ID; ?>" id="activity_id_hidden">



				<div id="activity_data_list" class="height_auto activity_data_list_<?php echo $retrive_data->ID; ?>">



			</div>



		</div>



	</div>



	<?php



	die();



}

add_action( 'wp_ajax_activity_controlar', 'activity_controlar');

add_action( 'wp_ajax_nopriv_activity_controlar', 'activity_controlar');

function activity_controlar() 



{



	$activity_id = $_REQUEST['activity_id'];



	



	global $wpdb;



	$table_activity = $wpdb->prefix. 'gmgt_activity';







	$query = 'SELECT * FROM ' .$table_activity. '



	WHERE activity_cat_id= \'' . $activity_id .'\'';



	



	$activity_title = array();



	foreach ($wpdb->get_results($query) as $row) {



		$activity_title[] = $row->activity_title;



	}







	echo json_encode($activity_title);



	die();



}







add_action( 'wp_ajax_append_activity_name_by_auto_suggest', 'append_activity_name_by_auto_suggest');



add_action( 'wp_ajax_nopriv_append_activity_name_by_auto_suggest', 'append_activity_name_by_auto_suggest');



function append_activity_name_by_auto_suggest()



{



	$activity_title = $_REQUEST['activity_value'];







	global $wpdb;



	$table_activity = $wpdb->prefix. 'gmgt_activity';







	$query = 'SELECT * FROM ' .$table_activity. '



	WHERE activity_title= \'' . $activity_title .'\'';







	$activity_data =$wpdb->get_row($query);



	



	?>



	<div class="checkbox" id="checkbox">



		<div class="col-sm-12 col-xs-12 row">



			<label class="col-sm-2 col-xs-12" style="padding-top: 25px;padding-bottom: 7px;">



			<input type="checkbox" checked name="avtivity_id[]" value="<?php echo esc_attr($activity_data->activity_id);?>" class="activity_check" id="<?php echo esc_attr($activity_data->activity_id);?>" activity_type="" data-val="activity" activity_title = "<?php echo esc_attr($activity_data->activity_title); ?>" >



			<?php echo esc_html($activity_data->activity_title); ?>



			</label> 



			<div id="reps_sets_<?php echo esc_attr($activity_data->activity_id);?>" class="col-sm-10 col-xs-12" style="padding:0px;">



				<div style="margin-top:10px;" class="form-body user_form activity_values">



					<div class="row">



						<div class="rtl_margin_bottom_15px col-md-3 col-lg-3 col-sm-3 col-xl-3"><div class="form-group input"><div class="col-md-12 form-control"><input class="form-control validate[required]" pattern="[0-9]" min="0" maxlength="150" type="number" name="sets_<?php echo esc_attr($activity_data->activity_id);?>" onKeyPress="if(this.value.length==3) return false;" id = "sets_<?php echo esc_attr($activity_data->activity_id);?>" onKeyPress="if(this.value.length==3) return false;" placeholder="Sets"></div></div></div>



						<div class="rtl_margin_bottom_15px col-md-3 col-lg-3 col-sm-3 col-xl-3"><div class="form-group input"><div class="col-md-12 form-control"><input class="form-control validate[required]" maxlength="150" type="number" name="reps_<?php echo esc_attr($activity_data->activity_id);?>" id = "reps_<?php echo esc_attr($activity_data->activity_id);?>" pattern="[0-9]" min="0" placeholder="Reps"  onKeyPress="if(this.value.length==3) return false;"></div></div></div>



						<div class="rtl_margin_bottom_15px col-md-3 col-lg-3 col-sm-3 col-xl-3"><div class="form-group input"><div class="col-md-12 form-control"><input class="form-control validate[required]" maxlength="150" type="number" name="kg_<?php echo esc_attr($activity_data->activity_id);?>" id = "kg_<?php echo esc_attr($activity_data->activity_id);?>" pattern="[0-9]" min="0" placeholder="KG"  onKeyPress="if(this.value.length==3) return false;"></div></div></div>



						<div class="rtl_margin_bottom_15px col-md-2 col-lg-2 col-sm-2 col-xl-2"><div class="form-group input"><div class="col-md-12 form-control"><input class="form-control validate[required]" maxlength="150" type="number" name="time_<?php echo esc_attr($activity_data->activity_id);?>" id = "time_<?php echo esc_attr($activity_data->activity_id);?>" pattern="[0-9]" min="0" placeholder="Seconds"  onKeyPress="if(this.value.length==3) return false;"></div></div></div>



						<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div>



					</div>



				</div>



			</div>



		</div>



	</div>



	<div class="clear"></div>



	<script>



	function deleteParentElement(n)



	{



		var isconfirm = confirm("<?php esc_html_e('Do you really want to delete this record','gym_mgt');?>");



		if(isconfirm){

			const child = document.getElementById("checkbox");



			child.parentNode.removeChild(child);

		}



			







	}



	</script>



	<?php



	die();



}



//-----Get all Date Type to star_date and end_date  - Start ------//



function mj_gmgt_all_date_type_value($date_type)



{



	$start_date = "";



	$end_date = "";



	$array_res = array();



	if($date_type=="today")



	{



		$start_date = date('Y-m-d');



		$end_date= date('Y-m-d');



	}



	elseif($date_type=="this_week")



	{



		//check the current day



		if(date('D')!='Mon')



		{    



		//take the last monday



		$start_date = date('Y-m-d',strtotime('last sunday'));    







		}else{



			$start_date = date('Y-m-d');   



		}



		//always next saturday



		if(date('D')!='Sat')



		{



			$end_date = date('Y-m-d',strtotime('next saturday'));



		}else{



			$end_date = date('Y-m-d');



		}



	}



	elseif($date_type=="last_week")



	{



		$previous_week = strtotime("-1 week +1 day");



		$start_week = strtotime("last sunday midnight",$previous_week);



		$end_week = strtotime("next saturday",$start_week);







		$start_date = date("Y-m-d",$start_week);



		$end_date = date("Y-m-d",$end_week);



	}



	elseif($date_type=="this_month")



	{



		$start_date = date('Y-m-d',strtotime('first day of this month'));



		$end_date = date('Y-m-d',strtotime('last day of this month'));



	}



	elseif($date_type=="last_month")



	{



		$start_date = date('Y-m-d',strtotime("first day of previous month"));



		$end_date =  date('Y-m-d',strtotime("last day of previous month"));



	}



	elseif($date_type=="last_3_month")



	{



		$month_date =  date('Y-m-d', strtotime('-2 month'));



		$start_date = date("Y-m-01", strtotime($month_date));



		$end_date = date('Y-m-d',strtotime('last day of this month'));



		



	}



	elseif($date_type=="last_6_month")



	{



		$month_date =  date('Y-m-d', strtotime('-5 month'));



		$start_date = date("Y-m-01", strtotime($month_date));



		$end_date = date('Y-m-d',strtotime('last day of this month'));



	}



	elseif($date_type=="last_12_month")



	{



		$month_date =  date('Y-m-d', strtotime('-11 month'));



		$start_date = date("Y-m-01", strtotime($month_date));



		$end_date = date('Y-m-d',strtotime('last day of this month'));



	}



	elseif($date_type=="this_year")



	{



		$start_date = date("Y-01-01", strtotime("0 year"));



		$end_date = date("Y-12-t", strtotime($start_date));







	}



	elseif($date_type=="last_year")



	{



		$start_date = date("Y-01-01", strtotime("-1 year"));



		$end_date = date("Y-12-t", strtotime($start_date));



	}



	elseif($date_type=="period")



	{



		//$result= mj_smgt_admission_repot_load_date();







	}



	$array_res[] = $start_date;



	$array_res[] = $end_date;



	return json_encode($array_res);



}



add_action( 'wp_ajax_mj_gmgt_admission_repot_load_date', 'mj_gmgt_admission_repot_load_date');



add_action( 'wp_ajax_nopriv_mj_gmgt_admission_repot_load_date',  'mj_gmgt_admission_repot_load_date');



function mj_gmgt_admission_repot_load_date()



{



	 $date_type = $_REQUEST['date_type'];



	 ?>



	



	<script type="text/javascript">



		jQuery(document).ready(function($)



		{



			"use strict";	



			$("#report_sdate").datepicker({



				dateFormat: "yy-mm-dd",



				changeYear: true,



				changeMonth: true,



				maxDate:0,



				<?php







				if(get_option('gym_enable_datepicker_privious_date')=='no')



				{



				?>



					startDate: date,



					minDate:'today',



				<?php







				}







			?>



				onSelect: function (selected) {



					var dt = new Date(selected);



					dt.setDate(dt.getDate() + 0);



					$("#report_edate").datepicker("option", "minDate", dt);



				}



			});







			$("#report_edate").datepicker({



			dateFormat: "yy-mm-dd",



			changeYear: true,



			changeMonth: true,



			maxDate:0,



				onSelect: function (selected) {



					var dt = new Date(selected);



					dt.setDate(dt.getDate() - 0);



					$("#report_sdate").datepicker("option", "maxDate", dt);



				}



			});



		} );



	</script>



	<?php



	if($date_type=='period')



	{ 



		?>



		<div class="row">



		<div class="col-md-6 mb-2">



			<div class="form-group input">



				<div class="col-md-12 form-control">



					<input type="text" id="report_sdate" class="form-control" name="start_date" value="<?php if(isset($_REQUEST['start_date'])) echo $_REQUEST['start_date'];else echo date('Y-m-d');?>" readonly>



					<label for="userinput1" class="active"><?php esc_html_e('Start Date','gym_mgt');?></label>



				</div>



			</div>



		</div>



		<div class="col-md-6 mb-2">



			<div class="form-group input">



				<div class="col-md-12 form-control">



					<input type="text" id="report_edate" class="form-control" name="end_date" value="<?php if(isset($_REQUEST['edate'])) echo $_REQUEST['end_date'];else echo date('Y-m-d');?>" readonly>



					<label for="userinput1" class="active"><?php esc_html_e('End Date','gym_mgt');?></label>



				</div>



			</div>



		</div> 



		</div>



		<?php 



	} 



	die();



	



}







function MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date)



{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	$member_result=$wpdb->get_results("SELECT * FROM $table_name WHERE attendence_date between '$start_date' and '$end_date'");



	



	return $member_result;







}



function MJ_gmgt_get_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date,$member_id)



{







	global $wpdb;







	$table_name = $wpdb->prefix . "gmgt_attendence";







	$member_result=$wpdb->get_results("SELECT * FROM $table_name WHERE user_id='$member_id' and attendence_date between '$start_date' and '$end_date'");



	



	return $member_result;







}







//user role wise access right array







function MJ_gmgt_get_userrole_wise_access_right_array_for_member($user_id)







{







	$role=MJ_gmgt_get_roles($user_id);







	







	if($role=='member')







	{ 







		$menu = get_option( 'gmgt_access_right_member');







	}







	elseif($role=='staff_member')







	{







		$menu = get_option( 'gmgt_access_right_staff_member');







	}







	elseif($role=='accountant')







	{







		$menu = get_option( 'gmgt_access_right_accountant');







	}



	foreach ( $menu as $key1=>$value1 ) 







	{								







		foreach ( $value1 as $key=>$value ) 







		{				



			



			



			if($key == "member")



			{



				



			   $menu_array1['view'] = $value['view'];







			   $menu_array1['own_data'] = $value['own_data'];







			   $menu_array1['add'] = $value['add'];







			   $menu_array1['edit'] = $value['edit'];







			   $menu_array1['delete'] = $value['delete'];







			   return $menu_array1;







			}



		}







	}	







}



function MJ_gmgt_get_member_for_member_info_report($membership_id,$membership_status)



{



	if($membership_id == "all_membership" && $membership_status == "all_membership_status")



    {



        $get_members = array(



			'role' => 'member',



			'meta_query'=>



			 array(



				'relation' => 'AND',



				array(



					'key'	  =>'membership_status',



				)	



		   )



		);



	}



	elseif($membership_id == "all_membership" && $membership_status != "all_membership_status")



	{



		$get_members = array(



            'role' => 'member',



            'meta_query'=>



             array(



                'relation' => 'AND',



				array(



                    'key'	  =>'membership_status',



                    'value'	=>	$membership_status,



                    'compare' => '=',



				)



           )



        );



	}



	elseif($membership_id != "all_membership"  && $membership_status == "all_membership_status")



	{



		$get_members = array(



            'role' => 'member',



            'meta_query'=>



             array(



                'relation' => 'AND',



                array(



                    'key'	  =>'membership_id',



                    'value'	=>	$membership_id,



                    'compare' => '=',



				),



				array(



                    'key'	  =>'membership_status',



				)



           )



        );



	}



	else



	{







		$get_members = array(



            'role' => 'member',



            'meta_query'=>



             array(



                'relation' => 'AND',



                array(



                    'key'	  =>'membership_id',



                    'value'	=>	$membership_id,



                    'compare' => '=',



				),



				array(



                    'key'	  =>'membership_status',



                    'value'	=>	$membership_status,



                    'compare' => '=',



				)



           )



        );



	}



	return $get_members;



}



function gym_append_user_log($user_login,$role)



{



	global $wpdb;



	$table_gmgt_user_log=$wpdb->prefix. 'gmgt_user_log';



	$ip_address = getHostByName(getHostName());



	$data['user_login']="$user_login";



	$data['role']="$role";



	$data['ip_address']=$ip_address;



	$data['created_at']=date("Y-m-d");



	$data['deleted_status']=0;



	$data['date_time']=date("Y-m-d H:i:s");







	$result=$wpdb->insert( $table_gmgt_user_log,$data);



	return $result;



}



function gym_append_audit_log($audit_action,$user_id,$created_by,$action,$module)



{



	global $wpdb;



	$table_gmgt_audit_log=$wpdb->prefix. 'gmgt_audit_log';



	$ip_address = getHostByName(getHostName());



	$data['audit_action']=$audit_action;



	$data['user_id']=$user_id;



	$data['action']=$action;



	$data['ip_address']=$ip_address;



	$data['created_by']=$created_by;



	$data['module']=$module;



	$data['created_at']=date("Y-m-d");



	$data['deleted_status']=0;



	$data['date_time']=date("Y-m-d H:i:s");



	



	$result=$wpdb->insert( $table_gmgt_audit_log,$data);



	return $result;



}







function mj_gmgt_delete_audit_log($id){



		global $wpdb;



		$table_gmgt_audit_log = $wpdb->prefix. 'gmgt_audit_log';



		$result = $wpdb->query("DELETE FROM $table_gmgt_audit_log where id= ".$id);



		return $result;



}











add_action( 'wp_ajax_MJ_gmgt_get_currency_symbols','MJ_gmgt_get_currency_symbols');



add_action( 'wp_ajax_nopriv_MJ_gmgt_get_currency_symbols','MJ_gmgt_get_currency_symbols');



function MJ_gmgt_get_currency_symbols()



{



	$gmgt_currency_code=$_REQUEST['gmgt_currency_code'];



	echo MJ_gmgt_get_currency_symbol($gmgt_currency_code);



	die;



}







function MJ_gmgt_get_user_full_display_name($user_id)



{



	$get_userdata = get_userdata($user_id);



	if(!empty($get_userdata)){



		$first_name = $get_userdata->first_name;



		$member_type = $get_userdata->member_type;



		$last_name = $get_userdata->last_name;



	



		$display_name = $first_name.' '.$member_type.' '.$last_name;



	



		return $display_name;



	}



	else{



		return 'N/A';



	}



	







}







function MJ_gmgt_get_member_full_display_name_with_memberid($user_id)



{



	$get_userdata = get_userdata($user_id);



	if(!empty($get_userdata)){



		$first_name = $get_userdata->first_name;



		$member_type = $get_userdata->member_type;



		$last_name = $get_userdata->last_name;



		$member_id = $get_userdata->member_id;



	



		$display_name_id = $first_name.' '.$member_type.' '.$last_name.' ('.$member_id.')';



	



		return $display_name_id;



	}



	else{



		return 'N/A';



	}



	







}











add_action( 'wp_ajax_MJ_gmgt_get_monthly_income_expense','MJ_gmgt_get_monthly_income_expense');



add_action( 'wp_ajax_nopriv_MJ_gmgt_get_monthly_income_expense','MJ_gmgt_get_monthly_income_expense');



function MJ_gmgt_get_monthly_income_expense()



{







	$month=$_REQUEST['month_value'];







	global $wpdb;



	$table_income=$wpdb->prefix.'gmgt_income_expense';







	$get_monthly_income = $wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='income' and MONTH(invoice_date) = $month");







	$get_monthly_expense=$wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='expense' and MONTH(invoice_date) = $month");







	$income_amount = 0;



	if(!empty($get_monthly_income))



	{



		foreach($get_monthly_income as $income)



		{



			$all_entry=json_decode($income->entry);



			$incomeamount=0;



			foreach($all_entry as $entry)



			{



				if(isset($entry->amount))



				{



					$incomeamount+=$entry->amount;



				}



			}







			$income_amount += $incomeamount;



		}



	}







	$expense_amount = 0;



	if(!empty($get_monthly_expense))



	{



		foreach($get_monthly_expense as $expense)



		{



			$all_entry=json_decode($expense->entry);



			$amount=0;



			foreach($all_entry as $entry)



			{



				$amount+=$entry->amount;



			}



			$expense_amount += $amount;



		}



	}







	$net_profit = $income_amount - $expense_amount;







	$result = "<table class='table workour_edit_table' width='100%'>



			<thead>



				<tr class='assign_workout_table_header_tr'>



					<th class='assign_workout_table_header assign_workout_right_border' scope='col'>Total Income</th>



					<th class='assign_workout_table_header assign_workout_right_border' scope='col'>Total Expense</th>



					<th class='assign_workout_table_header assign_workout_right_border' scope='col'>Net Profit</th>



				</tr>



			</thead>



			<tbody>



				<tr class='assign_workout_table_body_tr'>



					<th class='assign_workout_table_body table_body_border_right' scope='row'>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))." ".$income_amount."</th>



					<th class='assign_workout_table_body table_body_border_right' scope='row'>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))." ".$expense_amount."</th>



					<th class='assign_workout_table_body table_body_border_right' scope='row' style=''>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))." ".$net_profit."</th>



				</tr>



			</tbody>



		</table>";







	echo $result;



	die;



}







add_action( 'wp_ajax_MJ_gmgt_get_yearly_income_expense','MJ_gmgt_get_yearly_income_expense');



add_action( 'wp_ajax_nopriv_MJ_gmgt_get_yearly_income_expense','MJ_gmgt_get_yearly_income_expense');



function MJ_gmgt_get_yearly_income_expense()



{



	$year=$_REQUEST['year_value'];







	global $wpdb;



	$table_income=$wpdb->prefix.'gmgt_income_expense';







	$get_yearly_income=$wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='income' and YEAR(invoice_date) = $year");







	$get_yearly_expense=$wpdb->get_results("SELECT * FROM $table_income WHERE invoice_type='expense' and YEAR(invoice_date) = $year");



	



	$income_yearly_amount = 0;



	if(!empty($get_yearly_income))



	{



		foreach($get_yearly_income as $income)



		{



			$all_entry=json_decode($income->entry);



			$incomeamount=0;



			foreach($all_entry as $entry)



			{



				$all_entry=json_decode($income->entry);



				$incomeamount=0;



				foreach($all_entry as $entry)



				{



					if(isset($entry->amount))



					{



						$incomeamount+=$entry->amount;



					}



				}



				$income_yearly_amount += $incomeamount;



			}







		}



	}



	



	$expense_yearly_amount = 0;



	if(!empty($get_yearly_expense))



	{



		foreach($get_yearly_expense as $expense)



		{



			$all_entry=json_decode($expense->entry);



			$amount=0;



			foreach($all_entry as $entry)



			{



				$amount+=$entry->amount;



			}







			$expense_yearly_amount += $amount;



		}



	}







	$net_profit = $income_yearly_amount - $expense_yearly_amount;







	$result = "<table class='table workour_edit_table' width='100%'>



			<thead>



				<tr class='assign_workout_table_header_tr'>



					<th class='assign_workout_table_header assign_workout_right_border' scope='col'>Total Income</th>



					<th class='assign_workout_table_header assign_workout_right_border' scope='col'>Total Expense</th>



					<th class='assign_workout_table_header assign_workout_right_border' scope='col'>Net Profit</th>



				</tr>



			</thead>



			<tbody>



				<tr class='assign_workout_table_body_tr'>



					<th class='assign_workout_table_body table_body_border_right' scope='row'>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))." ".$income_yearly_amount."</th>



					<th class='assign_workout_table_body table_body_border_right' scope='row'>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))." ".$expense_yearly_amount."</th>



					<th class='assign_workout_table_body table_body_border_right' scope='row' style=''>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))." ".$net_profit."</th>



				</tr>



			</tbody>



		</table>";







	echo $result;



	die;



}







function MJ_gmgt_add_membership_payment_by_member($data)



{



	global $wpdb;







	$table_gmgt_membership_payment=$wpdb->prefix.'Gmgt_membership_payment';







	$tbl_gmgt_member_class = $wpdb->prefix .'gmgt_member_class';	







	$table_income=$wpdb->prefix.'gmgt_income_expense';







	$payment_data['member_id']=$data['member_id'];







	$payment_data['membership_id']=$data['membership_id'];







	$payment_data['membership_fees_amount'] = MJ_gmgt_get_membership_price($data['membership_id']);







	$payment_data['membership_signup_amount'] = MJ_gmgt_get_membership_signup_amount($data['membership_id']);







	$payment_data['tax_amount'] = MJ_gmgt_get_membership_tax_amount($data['membership_id'],'');		







	$payment_data['membership_amount']=$data['membership_amount'];				







	$payment_data['start_date']=MJ_gmgt_get_format_for_db($data['start_date']);	







	$payment_data['end_date']=MJ_gmgt_get_format_for_db($data['end_date']);			











	$membershipclass = MJ_gmgt_get_class_id_by_membership_id($data['membership_id']);







	$DaleteWhere['member_id']=$data['member_id'];







	$wpdb->delete( $tbl_gmgt_member_class, $DaleteWhere);







	$inserClassData['member_id']=$data['member_id'];







	if($membershipclass)



	{



		foreach($membershipclass as $key=>$class_id)



		{







			$inserClassData['class_id']=$class_id;







			$inset = $wpdb->insert($tbl_gmgt_member_class,$inserClassData);				







		}



	}		







	update_user_meta($data['member_id'],'membership_id',$data['membership_id']);		







	update_user_meta( $data['member_id'],'begin_date',MJ_gmgt_get_format_for_db($data['start_date']));	







	update_user_meta( $data['member_id'],'end_date',MJ_gmgt_get_format_for_db($data['end_date']));







	$payment_data['created_by']=get_current_user_id();







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







	$payment_data['invoice_no']=$invoice_no;







	$payment_data['payment_status']='Unpaid';







	$payment_data['created_date']=date('Y-m-d');







	$membership_status = 'continue';		







	$payment_data['membership_status'] = $membership_status;







	$result=$wpdb->insert( $table_gmgt_membership_payment,$payment_data);	







	$mem_payment_id = $wpdb->insert_id;



	



	$user_data = get_userdata($data['member_id']);







	gym_append_audit_log(''.esc_html__('Membership Payment Added','gym_mgt').' ('.$user_data->display_name.')',$mem_payment_id,get_current_user_id(),'insert',$_REQUEST['page']);







	// require_once GMS_PLUGIN_DIR. '/lib/stripe/index.php';



		



	return $result;



}



/* MEMBERSHIP PAYMENT BY MEMBERSHIP ID */



function MJ_gmgt_get_membership_payment_by_id($id){



	



	global $wpdb;



	$payment = $wpdb->prefix. 'gmgt_membership_payment';



	$payment_data = $wpdb->get_results("SELECT * FROM $payment WHERE membership_id=$id");



	return $payment_data;



}







/* RENEW & UPGRADE MEMBERSHIP POPUP*/



function MJ_Renew_popup_data()



{



	?>



	<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/popup.js'; ?>"></script>



	<?php



	$user_id = get_current_user_id();



	$user_info = get_user_meta($user_id);



	$membership_id = $user_info['membership_id'][0];



	$membership_amount = MJ_gmgt_get_membership_price($membership_id);



	$discount_amount = 0;



	$membership_tax_amount=MJ_gmgt_get_membership_tax_amount($membership_id,'renew_membership');



	$total_amount=$membership_amount + $membership_tax_amount;



	$date = date("Y-m-d");



	$new_date = DateTime::createFromFormat(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), $date); 



	$joiningdate = $new_date->format('Y-m-d');



	$obj_membership=new MJ_gmgt_membership;	



	$membership=$obj_membership->MJ_gmgt_get_single_membership($membership_id);



	$validity=$membership->membership_length_id;



	$expiredate= date(MJ_gmgt_get_phpdateformat(get_option('gmgt_datepicker_format')), strtotime($joiningdate. ' + '.$validity.' days'));



	 



	if(is_plugin_active('paymaster/paymaster.php') && get_option('gmgt_paymaster_pack')=="yes")



	{ 



	   $payment_method = get_option('pm_payment_method');



	}



	else



	{



		$gmgt_one_time_payment_setting=get_option("gmgt_one_time_payment_setting");



		$gym_recurring_enable=get_option("gym_recurring_enable");



		if($gym_recurring_enable == "yes" || $gmgt_one_time_payment_setting == '1')



		{



			$payment_method = 'Stripe';



		}



		else



		{



			$payment_method = 'Paypal';



		}



	}



	?>



<script type="text/javascript">



	$(document).ready(function() {



		"use strict";



		$('#renew_payment').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	});



</script>







	<div class="form-group Payment_body">



	<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>







	<h4 class="modal-title" id="myLargeModalLabel">



		<?php esc_html_e('Renew & Upgrade Membership','gym_mgt');?>



	</h4>



	</div>



	<div class="Payment_body">



		<form name="renew_payment" action="" method="post" class="form-horizontal" id="renew_payment">







			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'renew';?>



			<input type="hidden" name="action" value="renew_upgrade_membership_plan">



			<input type="hidden" name="view_type" value="renew_upgrade_membership_plan" class="view_type">



			<input type="hidden" name="member_id" id="member_list" value="<?php echo $user_id;?>">



			<input type="hidden" name="payment_method" value="<?php echo $payment_method;?>">



			<input type="hidden" class="user_coupon" name="coupon_id" value=""/>



			<div class="row">



				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



					<label class="ml-1 custom-top-label top" for="Membership"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>



					<?php 	$obj_membership=new MJ_gmgt_membership;



					$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>



					<select name="mp_id" class="form-control payment_membership_detail validate[required] coupon_membership_id" type="renew_membership_upgrade" id="membership_id" style="height:100%;">



						<option value=""><?php esc_html_e('Select Membership ','gym_mgt');?></option>



						<?php 



						if(!empty($membershipdata))



						{



							foreach ($membershipdata as $membership)



							{



								echo '<option value='.$membership->membership_id.' '.selected($membership_id,$membership->membership_id).'>'.$membership->membership_label.'('.$membership->membership_length_id.')'.'</option>';



							}



						}



						?>



					</select>



				</div>



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="total_amount" class="form-control validate[required,custom[number]]" type="text" value="<?php echo esc_attr($membership_amount);?>" name="amount" readonly>



							<label class="active" for="triel_date"><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="" class="form-control validate[required,custom[number]] discount_amount" type="text" value="<?php echo esc_attr($discount_amount);?>" name="discount_amount" readonly>



							<label class="active" for="triel_date"><?php esc_html_e('Discount Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="" class="form-control validate[required,custom[number]] tax_amount" type="text" value="<?php echo esc_attr($membership_tax_amount);?>" name="tax_amount" readonly>



							<label class="active" for="triel_date"><?php esc_html_e('Tax Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="" class="form-control validate[required,custom[number]] final_amount" type="text" value="<?php echo esc_attr($total_amount);?>" name="total_amount" readonly>



							<label class="active" for="triel_date"><?php esc_html_e('Total Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				



				<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 ">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="coupon_code" class="form-control coupon_code" type="text" value="" name="coupon_code" >



							<label class="" for=""><?php esc_html_e('Coupon Code','gym_mgt');?></label>



						</div>



						<span class="coupon_span"></span>



					</div>



				</div>



				<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3 rtl_margin_top_15px">	



					<button id=""  class="btn add_btn apply_coupon" ><?php esc_html_e('Apply','gym_mgt');?></button>



				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="start_date" class="form-control validate[required]" type="text"  name="start_date" value="<?php echo date("Y-m-d");?>" readonly>



							<label class="active" for="triel_date"><?php esc_html_e('Membership Start Date','gym_mgt');?><span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="after_date" class="form-control validate[required]"  type="text" name="end_date" value="<?php echo $expiredate;?>" readonly>



							<label class="active" for="triel_date"><?php esc_html_e('Membership End Date','gym_mgt');?><span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				



			</div>



			<div class="row"> 



				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



					<input type="submit" value="<?php esc_html_e('Save','gym_mgt');?>" name="renew_upgrade_membership_plan" class="btn save_btn"/>



				</div>



			</div>



		</form>



	</div>



	<?php



	die;



}



//Renew or Upgrade Membership Plan//



// if(isset($_POST['renew_upgrade_membership_plan'])) 



// {



	



// 	if($_POST['payment_method'] == 'Stripe')



// 	{



// 	   require_once GMS_PLUGIN_DIR. '/lib/stripe/index.php';



// 	}



// 	elseif($_POST['payment_method'] == 'Paypal')



// 	{



// 		require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';	



// 	}



// 	else



// 	{



// 		require_once GMS_PLUGIN_DIR. '/lib/paypal/paypal_process.php';



// 	}



// }



function MJ_gmgt_generate_membership_end_income_invoice_with_payment_online_payment($customer_id,$pay_id,$amount,$payment_type,$action,$payment_method,$coupon_id,$type)



{



	$obj_coupon=new MJ_gmgt_coupon;



	$obj_membership_payment=new MJ_gmgt_membership_payment;



	$obj_membership=new MJ_gmgt_membership;	



	$obj_member=new MJ_gmgt_member;



	$membership_price= MJ_gmgt_get_membership_price($pay_id);



	if($type == 'upgrade_membership')



	{



		$signup_amount= 0;



		



	}



	else



	{



		$signup_amount=MJ_gmgt_get_membership_signup_amount(sanitize_text_field($pay_id));



	}



	$trasaction_id  = '';



	$joiningdate=date("Y-m-d");



	$membership=$obj_membership->MJ_gmgt_get_single_membership($pay_id);



	$validity=$membership->membership_length_id;



	$expiredate= date('Y-m-d', strtotime($joiningdate. ' + '.$validity.' days'));



	$membership_status = 'continue';



	$payment_data = array();



	$membershippayment=$obj_membership_payment->MJ_gmgt_checkMembershipBuyOrNot($customer_id,$joiningdate,$expiredate);



	if(!empty($membershippayment))



	{



		global $wpdb;



		$table_gmgt_membership_payment=$wpdb->prefix.'Gmgt_membership_payment';



		$payment_data['payment_status'] = 0;



		$whereid['mp_id']=$membershippayment->mp_id;



		$wpdb->update( $table_gmgt_membership_payment, $payment_data ,$whereid);



		$plan_id =$membershippayment->mp_id;



	}



	else



	{



		global $wpdb;



		//invoice number generate



		$table_income=$wpdb->prefix.'gmgt_income_expense';



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



		$payment_data['invoice_no']=$invoice_no;



		$payment_data['member_id'] = $customer_id;



		$payment_data['membership_id'] = $pay_id;



		$payment_data['membership_signup_amount'] = $signup_amount;



		



		if($type == 'upgrade_membership')



	    {



			if(!empty($coupon_id))



		    {



				$discount_amount=get_discount_amount_by_membership_id($pay_id,$coupon_id,'renew_membership');



				$tax_amount=MJ_gmgt_after_discount_tax_amount_by_membership_id($pay_id,$coupon_id,'renew_membership');



			}



			else



			{



				$discount_amount= 0;



			    $tax_amount = MJ_gmgt_get_membership_tax_amount($pay_id,'renew_membership');



			}



		}



		else



		{



			if(!empty($coupon_id))



			{



				$tax_amount = MJ_gmgt_after_discount_tax_amount_by_membership_id($pay_id,$coupon_id,'');



				$discount_amount = get_discount_amount_by_membership_id($pay_id,$coupon_id,'');



			}



			else



			{



				$discount_amount = 0;



				$tax_amount = MJ_gmgt_get_membership_tax_amount($pay_id,'');



			}



		}







		$payment_data['tax_amount']=$tax_amount;



		$payment_data['discount_amount']=$discount_amount;







		$membership_amount=$membership_price + $payment_data['membership_signup_amount'] - (int)$payment_data['discount_amount'] + $payment_data['tax_amount'];



		$membership_amount_with_signup=$membership_price + $payment_data['membership_signup_amount'];



		



		



		$payment_data['membership_fees_amount'] = $membership_price;



		$payment_data['membership_amount']=$amount;



		$payment_data['start_date'] = $joiningdate;



		$payment_data['end_date'] = $expiredate;



		$payment_data['membership_status'] = $membership_status;



		$payment_data['payment_status'] = 0;



		$payment_data['created_date'] = date("Y-m-d");



		$payment_data['created_by'] = $customer_id;



		$payment_data['coupon_id'] = $coupon_id;



		$payment_data['coupon_usage_id'] = '';



		$payment_data['tax_id'] = MJ_gmgt_get_membership_tax($pay_id);



		$plan_id = $obj_member->MJ_gmgt_add_membership_payment_detail($payment_data);



		if($coupon_id)



		{



			// ADD DATA TO COUPON USAGE



			$coupon_data = $obj_coupon->MJ_gmgt_get_single_coupondata($coupon_id);



			$couponusage_data = array();



			$couponusage_data['member_id'] = $customer_id;



			$couponusage_data['mp_id'] = $plan_id;



			$couponusage_data['membership_id'] = sanitize_text_field($pay_id);



			$couponusage_data['coupon_id'] = sanitize_text_field($coupon_id);



			$couponusage_data['coupon_usage'] = '';



			$couponusage_data['discount_type'] = $coupon_data->discount_type;



			$couponusage_data['discount_amount'] = $coupon_data->discount;



			$couponusage_id = $obj_member->MJ_gmgt_add_coupon_usage_detail($couponusage_data);



		}



		//save membership payment data into income table							



		$membership_name=MJ_gmgt_get_membership_name($pay_id);



		$entry_array[]=array('entry'=>$membership_name,'amount'=>$membership_price);	



		if($signup_amount > 0 )



		{



			$entry_array[]=array('entry'=>esc_html__("Membership Signup Fee","gym_mgt"),'amount'=>$signup_amount);



		}



		



		$incomedata['entry']=json_encode($entry_array);	



		$incomedata['invoice_type']='income';



		$incomedata['invoice_label']=__("Fees Payment","gym_mgt");



		$incomedata['supplier_name']=$customer_id;



		$incomedata['invoice_date']=date('Y-m-d');



		$incomedata['receiver_id']=$customer_id;



		$incomedata['amount']=$membership_amount_with_signup;



		$incomedata['total_amount']=$amount;







		



		$incomedata['tax'] = $tax_amount;



		$incomedata['discount'] = $discount_amount;







		



		$incomedata['invoice_no']=$invoice_no;



		$incomedata['paid_amount']=$amount;



		$incomedata['payment_status']='Fully Paid';



		$incomedata['tax_id']=MJ_gmgt_get_membership_tax($pay_id);



		$result_income=$wpdb->insert( $table_income,$incomedata);







		$payment_data['coupon_usage_id'] = $couponusage_id;



		$invoice['mp_id'] = $plan_id;



		$membership_payment_id = $obj_member->MJ_gmgt_update_membership_payment_detail($payment_data,$invoice);



	}



	$feedata['mp_id']=$plan_id;



	$feedata['amount']=$amount;



	$feedata['payment_method']=$payment_method;



	$feedata['payment_description']='Membership Payment';



	$feedata['trasaction_id']='';



	$feedata['created_by']=$customer_id;



	$result=$obj_membership_payment->MJ_gmgt_add_feespayment_history($feedata);



    return $result;



} 







/* SETUP WIZARD FUNCTION */



function MJ_gmgt_setup_wizard_steps_updates($step){



	$wizard_status = get_option('gmgt_setup_wizard_status');



	if($wizard_status == 'no'){



		$setup_wizard = get_option('gmgt_setup_wizard_step');



		$setup_wizard[$step] = "yes";



		$setup_wizard = update_option('gmgt_setup_wizard_step',$setup_wizard);



	}



	$wizard_step = get_option('gmgt_setup_wizard_step');



	if(!in_array('no',$wizard_step)){



		$gmgt_setup_wizard_status = 'yes';



		$setup_wizard_status_update = update_option('gmgt_setup_wizard_status',$gmgt_setup_wizard_status);



	}



}







add_action( 'wp_ajax_MJ_gmgt_coupon_apply', 'MJ_gmgt_coupon_apply');







add_action( 'wp_ajax_nopriv_MJ_gmgt_coupon_apply', 'MJ_gmgt_coupon_apply');



// APPLY COUPON TO MEMBERSHP PAYMENT



function MJ_gmgt_coupon_apply()



{



	$attributeValue = $_REQUEST['attributeValue'];



	$view_type = $_REQUEST['view_type'];



	$coupon_code = $_REQUEST['coupon_code'];



	$member_id = $_REQUEST['member_id'];



	$membership_id = $_REQUEST['membership_id'];



	$obj_coupon=new MJ_gmgt_coupon;



	$coupondata=$obj_coupon->MJ_gmgt_get_coupon_by_code($coupon_code);



	$coupon_publish = $coupondata->published;



	$coupon_end_date = $coupondata->end_date;



	$coupon_start_date = $coupondata->from_date;



	$coupon_type = $coupondata->coupon_type;



	$coupon_member_id = $coupondata->member_id;



	$coupon_membership = $coupondata->membership;



	$coupon_discount_type = $coupondata->discount_type;



	$coupon_discount = $coupondata->discount;



	$coupon_recurring_type = $coupondata->recurring_type;



	$coupon_time = $coupondata->time;



	$coupon_time_used = MJ_gmgt_coupon_usage_count($coupondata->id);



	$coupon_time_used_member = MJ_gmgt_coupon_usage_count_for_member($coupondata->id,$member_id);



	$array_var = array();



	



	if($coupon_discount_type =="amount")



	{



		$data = $coupon_discount.' '.'Amount';



	}



	else



	{



		$data = $coupon_discount.''.$coupon_discount_type;



	}







	// FOR COUPON MATCH



	if(!empty($coupondata))



	{



		// FOR CHECK COUPON USAGE LIMIT



		if($coupon_time > $coupon_time_used)



		{



			// FOR CHECK PUBLISHED & BETWEEN START-DATE AND END-DATE



			if(($coupon_publish == 'yes') && ($coupon_end_date >= date("Y-m-d")) && ($coupon_start_date <= date("Y-m-d")))



			{



				// FOR ADD NEW MEMBER



				if($attributeValue == 'new_member')



				{



					// FOR CHECK ALL MEMBER, MEMBERSHIP



					if($coupon_type == "all_member" && ($coupon_membership == $membership_id || $coupon_membership == 'all_membership'))



					{



						$id = $coupondata->id;



					}



					else



					{



						$data = esc_html__('This coupon code is invalid.','gym_mgt');



						$id = 'error';



					}



				}



				else



				{	



					// FOR CHECK COUPONTYPE



					if(($coupon_type == "individual"))



					{



						if(($coupon_member_id == $member_id) && ($coupon_membership == $membership_id) || ($coupon_membership == 'all_membership'))



						{



							if($coupon_recurring_type == 'recurring')



							{



								$id = $coupondata->id;



							}



							elseif($coupon_recurring_type == 'onetime')



							{



								if($coupon_time_used_member < 1)



								{



									$id = $coupondata->id;



								}

								else



								{



									$data = esc_html__('Coupon Already Used.','gym_mgt');



									$id = 'error';



								}



							}



							else



							{



								$data = esc_html__('This coupon code is invalid.','gym_mgt');



								$id = 'error';



							}



						}



						else



						{



							$data = esc_html__('This coupon code is invalid.','gym_mgt');



							$id = 'error';



						}



					}



					else



					{



						if(($coupon_membership == $membership_id) || ($coupon_membership == 'all_membership'))



						{



							if($coupon_recurring_type == 'recurring')



							{



								$id = $coupondata->id;



							}



							elseif($coupon_recurring_type == 'onetime')



							{



								if($coupon_time_used_member < 1)



								{



									$id = $coupondata->id;



							    }



							   else



							    {



								   $data = esc_html__('Coupon Already Used','gym_mgt');



								   $id = 'error';



							    }



							}



							else



							{



								$data = esc_html__('This coupon code is invalid.','gym_mgt');



								$id = 'error';



								



								



							}



						}



						else



						{



							$data = esc_html__('This coupon code is invalid.','gym_mgt');



							$id = 'error';



						}



					}



				}



			}



			else



			{



				$data = esc_html__('This coupon code is disabled or has expired.','gym_mgt');



				$id = 'error';



			}



		}



		else



		{



				$data = esc_html__('Coupon code usage limit exceeded.','gym_mgt');



				$id = 'error';



		}



	}



	else



	{



		$data = esc_html__('This coupon is not matched.','gym_mgt');



		$id = 'error';



	}



	$array_var[] = $id;



	$array_var[1] = $data;



	



	$membership_amount_before_discount = MJ_gmgt_get_membership_price($membership_id);



	if($coupon_discount_type =="amount")



	{



	   $membership_amount = $membership_amount_before_discount - $coupon_discount;



	   $discount_amount = $coupon_discount;



	}



	else



	{



		$membership_amount =$membership_amount_before_discount - $membership_amount_before_discount * ($coupon_discount/100);



		$discount_amount = $membership_amount_before_discount * ($coupon_discount/100);



	}



	//For Renew & Upgrade Membership Plan //



	if($view_type ==  'renew_upgrade_membership_plan')



	{



		if($id !='error')



		{



			$membership_tax_amount=MJ_gmgt_after_discount_tax_amount_by_membership_id($membership_id,$id,'renew_membership');



			$total_amount=$membership_amount + $membership_tax_amount;



			$array_var[2] = $membership_amount_before_discount;



			$array_var[3] = $membership_tax_amount;



			$array_var[4] = $total_amount;



			//$array_var[6] = 100;



		}



	}



	//add Message in span //



	$tax_id = MJ_gmgt_get_tax_id_from_membership_id($membership_id);



	if($id !='error')



	{



		$membership_tax_amount=MJ_gmgt_after_discount_tax_amount_by_membership_id($membership_id,$id,'renew_membership');



		$total_amount=$membership_amount + $membership_tax_amount;



		$array_var[5] = "<span><p> 1) ".esc_html__('Membership Amount','gym_mgt').' = '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$membership_amount_before_discount."</p><p> 2) ".esc_html__('Discount Amount','gym_mgt').'('.MJ_gmgt_discount_type_label($coupon_discount_type,$coupon_discount).')'.' = '.'-'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$discount_amount."</p><p> 3) ".esc_html__('After Discount Amount','gym_mgt').' = '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$membership_amount."</p><p> 4) ".esc_html__('Tax Amount','gym_mgt').'('.MJ_gmgt_tax_name_by_tax_id_array_for_invoice($tax_id).')'.' = '.'+'.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$membership_tax_amount."</p><p> 5) ".esc_html__('Total Amount','gym_mgt').' = '.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).''.$total_amount."</p><span>";

		$array_var[6] = esc_html__('Coupon code applied successfully.','gym_mgt');

	}



	//End For Renew Or Upgrade Plan



	



	echo json_encode($array_var);



	die;



}







// COUNT COUPON USAGE



function MJ_gmgt_coupon_usage_count($id)



{



	global $wpdb;



	$table_gmgt_coupon_usage = $wpdb->prefix . 'gmgt_coupon_usage';



	$id = (int) $id; // Ensure $id is treated as an integer for security.



	// Prepare the SQL statement using a placeholder for the $id.



	$sql = $wpdb->prepare("SELECT COUNT(coupon_id) FROM $table_gmgt_coupon_usage WHERE coupon_id = %d", $id);



	// Retrieve the count using get_var() with LIMIT 1.



	$count = $wpdb->get_var($sql);



	return $count;



}



// COUNT COUPON USAGE



function MJ_gmgt_coupon_usage_count_for_member($id,$member_id)



{



	global $wpdb;



	$table_gmgt_coupon_usage = $wpdb->prefix . 'gmgt_coupon_usage';



	$id = (int) $id; // Ensure $id is treated as an integer for security.



	// Prepare the SQL statement using a placeholder for the $id.



	$sql = $wpdb->prepare("SELECT COUNT(coupon_id) FROM $table_gmgt_coupon_usage WHERE coupon_id =$id && member_id=$member_id");



	// Retrieve the count using get_var() with LIMIT 1.



	$count = $wpdb->get_var($sql);



	return $count;



}



// MEMBERSHIP PAYMENT OFFLINE CODE



function MJ_gmgt_generate_membership_end_income_invoice_with_payment_offline_payment($invoice_no,$user_id,$membership_id,$start_date,$end_date,$status,$coupon_id){



	$obj_member=new MJ_gmgt_member;



	global $wpdb;



	// MEMBERSHIP PAYMENT DATA



	$payment_data = array();



	$payment_data['invoice_no']=$invoice_no;



	$payment_data['member_id'] = $user_id;



	$payment_data['membership_id'] = $membership_id;



	$payment_data['membership_fees_amount'] = MJ_gmgt_get_membership_price($membership_id);



	$payment_data['membership_signup_amount'] = MJ_gmgt_get_membership_signup_amount(sanitize_text_field($membership_id));



	



	if(!empty($coupon_id))



	{



		$payment_data['coupon_id'] = $coupon_id;



		$tax_amount = MJ_gmgt_after_discount_tax_amount_by_membership_id($membership_id,$coupon_id,'');



		$discount_amount = get_discount_amount_by_membership_id($membership_id,$coupon_id,'');



	}



	else



	{



		$payment_data['coupon_id'] = '';



		$discount_amount = 0;



		$tax_amount = MJ_gmgt_get_membership_tax_amount($membership_id,'');



	}



	$payment_data['discount_amount'] = number_format($discount_amount,2);



	$payment_data['tax_amount'] = number_format($tax_amount,2);



	$membership_amount= (int)$payment_data['membership_fees_amount'] + (int)$payment_data['membership_signup_amount'] - (float)$payment_data['discount_amount'] + (float) $payment_data['tax_amount'];



	$payment_data['membership_amount'] =$membership_amount;



	$payment_data['start_date'] = MJ_gmgt_get_format_for_db(sanitize_text_field($start_date));



	$payment_data['end_date'] = MJ_gmgt_get_format_for_db(sanitize_text_field($end_date));



	$payment_data['membership_status'] = 'continue';



	$payment_data['payment_status']=$status;



	$payment_data['created_date'] = date("Y-m-d");



	$payment_data['created_by'] = get_current_user_id();



	$payment_data['coupon_id'] = sanitize_text_field($coupon_id);



	$payment_data['coupon_usage_id'] = '';



	$payment_data['tax_id'] = MJ_gmgt_get_membership_tax($membership_id);



	$plan_id = $obj_member->MJ_gmgt_add_membership_payment_detail($payment_data);



	// ADD DATA TO COUPON USAGE



	if(!empty($coupon_id))



	{



		$obj_coupon=new MJ_gmgt_coupon;



		$coupon_data = $obj_coupon->MJ_gmgt_get_single_coupondata($coupon_id);



		$couponusage_data = array();



		$couponusage_data['member_id'] = $user_id;



		$couponusage_data['mp_id'] = $plan_id;



		$couponusage_data['membership_id'] = sanitize_text_field($membership_id);



		$couponusage_data['coupon_id'] = sanitize_text_field($coupon_id);



		$couponusage_data['coupon_usage'] = '';



		$couponusage_data['discount_type'] = $coupon_data->discount_type;



		$couponusage_data['discount_amount'] = $coupon_data->discount;



		$couponusage_id = $obj_member->MJ_gmgt_add_coupon_usage_detail($couponusage_data);



	}



	// save membership payment data into income table



	$table_income=$wpdb->prefix.'gmgt_income_expense';



	$membership_name = MJ_gmgt_get_membership_name($membership_id);



	$entry_array[] = array('entry'=>$membership_name,'amount'=>MJ_gmgt_get_membership_price($membership_id));



	$entry_array1[]=array('entry'=>esc_html__("Membership Signup Fee","gym_mgt"),'amount'=>MJ_gmgt_get_membership_signup_amount($membership_id));



	$entry_array_merge=array_merge($entry_array,$entry_array1);



	$incomedata['entry']=json_encode($entry_array_merge);	



	$incomedata['invoice_type']='income';



	$incomedata['invoice_label']=esc_html__("Fees Payment","gym_mgt");



	$incomedata['supplier_name']=$user_id;



	$incomedata['invoice_date']=date('Y-m-d');



	$incomedata['receiver_id']=get_current_user_id();					



	$incomedata['amount'] = (int)$payment_data['membership_fees_amount'] + (int)$payment_data['membership_signup_amount'];



	$incomedata['total_amount'] = $membership_amount;



	// APPLY COUPON CODE



	if(!empty($coupon_id))



	{



		$incomedata['tax'] = MJ_gmgt_after_discount_tax_amount_by_membership_id($membership_id,$coupon_id,'');



		$incomedata['discount'] = get_discount_amount_by_membership_id($membership_id,$coupon_id,'');



	}







	else{



		$incomedata['discount'] = '';



		$incomedata['tax'] = MJ_gmgt_get_membership_tax_amount($membership_id,$type);



	}







	$incomedata['invoice_no']=$invoice_no;



	$incomedata['tax_id']=MJ_gmgt_get_membership_tax($membership_id);



	$incomedata['paid_amount']=0;



	$incomedata['payment_status']=$status;



	$result_income=$wpdb->insert($table_income,$incomedata);







	// UPDATE MEMBERSHIP PAYMENT			



	$payment_data = array();



	$payment_data['coupon_usage_id'] = $couponusage_id;



	$invoice['mp_id'] = $plan_id;



	$membership_payment_id = $obj_member->MJ_gmgt_update_membership_payment_detail($payment_data,$invoice);







	return $plan_id;



}







// GET TAX NAME BY TAX ID FOR INVOICE



function MJ_gmgt_tax_name_by_tax_id_array_for_invoice($tax_id_string)







{







	$obj_tax=new MJ_gmgt_tax;







	







	$tax_name=array();







	$tax_id_array=explode(",",$tax_id_string);







	$tax_name_string="";







	if(!empty($tax_id_string))







	{







		foreach($tax_id_array as $tax_id)







		{







			$gmgt_taxs=$obj_tax->MJ_gmgt_get_single_tax_data($tax_id);	







			if(!empty($gmgt_taxs))







			{	







				$tax_name[]=$gmgt_taxs->tax_title.'('.$gmgt_taxs->tax_value.'%)';







			}







		}	







		$tax_name_string=implode(",",$tax_name);		







	}	







	return $tax_name_string;







	die;







}



// GET DISCOUNT AMOUNT AFTER DISCOUNT BY MEMBERSHIP ID



function get_discount_amount_by_membership_id($membership_id,$coupon_id,$type)



{



	



	if(!empty($coupon_id))



	{



		$obj_membership=new MJ_gmgt_membership;



		$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($membership_id);



		$obj_coupon=new MJ_gmgt_coupon;



		$coupon_data = $obj_coupon->MJ_gmgt_get_single_coupondata($coupon_id);



		$singup=($retrieved_data->signup_fee);



		$amount_member=($retrieved_data->membership_amount);



		if($type == 'renew_membership')



		{



			$membership_amount= $amount_member;



		}



		else



		{



			$membership_amount= $singup + $amount_member;



		}



		



		if($coupon_data->discount_type == 'amount'){



			$total_amount = $coupon_data->discount;



			return $total_amount;



		}



		else{



			$total_amount = $membership_amount*($coupon_data->discount/100);



			return $total_amount;



		}



	}		



}



// GET TAX AMOUNT AFTER DISCOUNT BY MEMBERSHIP ID



function MJ_gmgt_after_discount_tax_amount_by_membership_id($membership_id,$coupon_id,$type)



{



	if(!empty($coupon_id))



	{



		$obj_membership=new MJ_gmgt_membership;



		$retrieved_data=$obj_membership->MJ_gmgt_get_single_membership($membership_id);



		$obj_coupon=new MJ_gmgt_coupon;



		$coupon_data = $obj_coupon->MJ_gmgt_get_single_coupondata($coupon_id);



		$singup=($retrieved_data->signup_fee);



		$amount_member=($retrieved_data->membership_amount);



		if($type == 'renew_membership')



		{



			$membership_amount = $amount_member;



		}



		else



		{



			$membership_amount= $singup + $amount_member;



		}



		



		if($coupon_data->discount_type == 'amount'){



			$discount_amount = $membership_amount - $coupon_data->discount;



		}



		else{



			$discount_amount = $membership_amount - $membership_amount*($coupon_data->discount/100);



		}



		$tax_array=explode(",",$retrieved_data->tax);



		if(!empty($tax_array))



		{



			$total_tax=0;



			foreach($tax_array as $tax_id)



			{



				$tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



				$tax_amount=$discount_amount * $tax_percentage / 100;



				$total_tax=$total_tax + $tax_amount;				



			}



			$total_tax_amount=$total_tax;



		}



		else



		{



			$total_tax_amount=0;			



		}



		return $total_tax_amount;



	}	



}







// Discount Label



function MJ_gmgt_discount_type_label($coupon_discount_type,$coupon_discount){







	if($coupon_discount_type =="amount")



	{



		$data = $coupon_discount.' '.'Amount';



	}



	else



	{



		$data = $coupon_discount.''.$coupon_discount_type;



	}



	return $data;



}



function MJ_gmgt_get_tax_id_from_membership_id($mid)



{



	if($mid == '')







	{







		return '';







	}







	global $wpdb;







	$table_name = $wpdb->prefix .'gmgt_membershiptype';







	$result =$wpdb->get_row("SELECT tax FROM $table_name WHERE membership_id=".$mid);







	return $result->tax;



}



// EXTEND MEMBERSHIP POPUP

function MJ_gmgt_extend_membership_popup()

{

	

	$member_id = $_REQUEST['member_id'];

	$user_info = get_userdata($member_id);

	$membership_id = $user_info->membership_id;

	?>



	<script type="text/javascript">



		$(document).ready(function() {



			"use strict";



			$('#extend_membership').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



		});



	</script>



	<div class="form-group gmgt_pop_heder_p_20"> 	



		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>



		<h4 class="modal-title res_pop_modal_title_font_22px" id="myLargeModalLabel">



			<img class="gms_popup_header_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Membership.png"?>">



			<?php echo esc_html__('Extend Membership','gym_mgt'); ?>



		</h4>



	</div>



	<div class="panel-body ">



		<form name="extend_membership" action="" method="post" class="form-horizontal" id="extend_membership">



			<input type="hidden" name="member_id" class="member_id" value="<?php echo $member_id; ?>"  />



			<input type="hidden" name="membership_id" class="membership_id" value="<?php echo $membership_id; ?>"  />



			<div class="row">

			

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="begin_date" class="form-control begin_date validate[required] date_picker" type="text" name="begin_date" value="<?php echo esc_html(MJ_gmgt_getdate_in_input_box($user_info->begin_date)); ?>"  readonly>



							<label class="date_label active" for="begin_date"><?php esc_html_e('Membership Valid From','gym_mgt');?><span class="require-field">*</span></label>	



						</div>							



					</div>



				</div>



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="end_date" class="form-control validate[required] membership_end_date date_picker" type="text" name="end_date" value="<?php echo esc_html(MJ_gmgt_getdate_in_input_box($user_info->end_date)); ?>" readonly>



							<label class="date_label active" for="begin_date"><?php esc_html_e('Membership Valid to','gym_mgt');?><span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="extend_day" class="form-control extend_day validate[required] text-input" type="number" onkeypress="if(this.value.length==10) return false;" step="0.01" min="0" max="" value="" name="extend_day">



							<label class="active" for="extend_day"><?php esc_html_e('Extend Days','gym_mgt');?><span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="new_end_date" class="form-control new_end_date validate[required]" type="text" name="new_end_date" value="" readonly>



							<label class="date_label active" for="new_end_date"><?php esc_html_e('New End Date','gym_mgt');?><span class="require-field">*</span></label>



						</div>



					</div>



				</div>



			</div>



			<div class="row"><!--Row Div Strat--> 



				<div class="col-md-6 col-sm-6 col-xs-12"> 	



					<input type="submit" value="<?php esc_html_e('Extend Membership','gym_mgt');?>" name="extend_membership" class="btn save_btn" id="save_extend_membership"/>



				</div>



			</div><!--Row Div End--> 



		</form>

		<script type="text/javascript">

			$(document).ready(function() 

			{

				"use strict";

				jQuery('#extend_list').DataTable({

				"aoColumns":

					[

						{"bSortable": true},

						{"bSortable": true},

						{"bSortable": true},

						{"bSortable": true},

						{"bSortable": true}

					],

					language:<?php echo MJ_gmgt_datatable_multi_language();?>	

				});

				$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

			});

		</script>

		<?php

		$extend_data = MJ_gmgt_get_extend_membership_data_by_member_id($member_id);

		if(!empty($extend_data)){

		?>

		<div class="mt-3 extend_popup_width">

			<table id="extend_list" class="display" cellspacing="0" width="100%">

				<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

					<tr>

						<th><?php esc_html_e('Member Name','gym_mgt');?></th>

						<th><?php esc_html_e('Membership Valid From','gym_mgt');?></th>

						<th><?php esc_html_e('Membership Valid To','gym_mgt');?></th>

						<th><?php esc_html_e('Extend Days','gym_mgt');?></th>

						<th><?php esc_html_e('New End Date','gym_mgt');?></th>

					</tr>

				</thead>

				<tbody>

					<?php

					foreach ($extend_data as $retrieved_data)

					{

					?>

						<tr>

							<td class="">

								<?php echo MJ_gmgt_get_user_full_display_name($retrieved_data->member_id);

								?>

							</td>

							<td class="">

								<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->begin_date);

								?>

							</td>

							<td class="">

								<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date);

								?>

							</td>

							<td class="">

								<?php echo $retrieved_data->extend_day.' '.esc_html__('Days','gym_mgt');

								?>

							</td>

							<td class="">

								<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->new_end_date);

								?>

							</td>

						</tr>

					<?php

					}

					?>

				</tbody>

			</table>

		</div>

		<?php

		}

		?>

	</div>



	

	<?php

	die();

}



// GET MEMBERSHIP PAYMENT DATA BY MEMBER_ID, MEMBERSHIP_ID & START_DATE

function MJ_gmgt_get_membership_payment_data_by_memberid_membership_id_start_date($member_id, $membership_id, $start_date)

{

    global $wpdb;



    $table_gmgt_membership_payment = $wpdb->prefix . 'Gmgt_membership_payment';



    // Use prepared statements to prevent SQL injection

    $sql = $wpdb->prepare(

        "SELECT mp_id FROM $table_gmgt_membership_payment WHERE membership_id = %d AND member_id = %d AND start_date = %s",

        $membership_id,

        $member_id,

        $start_date

    );



    $result = $wpdb->get_row($sql);



    if ($result) {

        

        return $result;

    } 

}



function MJ_gmgt_get_extend_membership_data_by_member_id($member_id)

{

	global $wpdb;

    $gmgt_extend_membership = $wpdb->prefix . 'gmgt_extend_membership';

	$result =$wpdb->get_results("SELECT * FROM $gmgt_extend_membership WHERE member_id=".$member_id);

	return $result;

}

add_action( 'init', function() {
	
	if( get_option( 'gmgt_customer_view_page') === false) {
		$curr_page = array(
			'post_title' => esc_html__('Customer Details', 'gym_mgt'),
			'post_content' => '[gmgt_qr_view_details]',
			'post_status' => 'publish',
			'post_type' => 'page',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_category' => array(1),
			'post_parent' => 0 
		);		
	
		$curr_created = wp_insert_post( $curr_page );
		
		update_option( 'gmgt_customer_view_page', $curr_created );

	}

});

add_shortcode('gmgt_qr_view_details', function() {

	if ( isset( $_GET['accountant_id'] ) ) {
		$accountant_id = $_GET['accountant_id'];
		$user_access_edit = false;
		ob_start();
		$user_info = get_userdata($accountant_id);
		require_once GMS_PLUGIN_DIR. '/admin/accountant/view_accountant2.php';
		return ob_get_clean();

	}
	return '';

})

?>