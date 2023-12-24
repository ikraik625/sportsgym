<?php 

$curr_user_id=get_current_user_id();



$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



$obj_membership=new MJ_gmgt_membership;



$obj_class=new MJ_gmgt_classschedule;



$obj_group=new MJ_gmgt_group;



$obj_member=new MJ_gmgt_member;



$obj_activity=new MJ_gmgt_activity;



$role=MJ_gmgt_get_roles(get_current_user_id());



if($role == 'administrator')



{



	$user_access_add=1;



	$user_access_edit=1;



	$user_access_delete=1;



	$user_access_view=1;



}



else



{



	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('member');



	$user_access_add=$user_access['add'];



	$user_access_edit=$user_access['edit'];



	$user_access_delete=$user_access['delete'];



	$user_access_view=$user_access['view'];



	if (isset ( $_REQUEST ['page'] ))



	{	



		if($user_access_view=='0')



		{	



			MJ_gmgt_access_right_page_not_access_message_for_management();



			die;



		}



		if(!empty($_REQUEST['action']))



		{



			if ('member' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



			{



				if($user_access_edit=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}			



			}



			if ('member' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))



			{



				if($user_access_delete=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			}



			if ('member' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



			{



				if($user_access_add=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			} 



		}



	}



}



?>



<!-- POP up code -->



<div class="popup-bg z_index_100000">



    <div class="overlay-content">



		<div class="modal-content">



			<div class="category_list"></div>     



		</div>



    </div>     



</div>



<!-- End POP-UP Code -->



<?php 



//Approve MEMBER 



if(isset($_REQUEST['action']) && $_REQUEST['action'] =='approve')



{



	if( get_user_meta(esc_attr(($_REQUEST['member_id'])), 'gmgt_hash', true))



	{



		//------------- SMS SEND -------------//



		$current_sms_service = get_option('gmgt_sms_service');



		if(is_plugin_active('sms-pack/sms-pack.php'))



		{



			$mobile_number=array(); 



			$args = array();



			$userinfo=get_userdata(esc_attr($_REQUEST['member_id']));



			$mobile_number[] = "+".MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' )).$userinfo->mobile;



			$gymname=get_option( 'gmgt_system_name' );		



			$message_content ="You are successfully registered at ".esc_html($gymname);



			$args['mobile']= esc_html($mobile_number);



			$args['message_from']="MEMBER Approved";



			$args['message']=$message_content;					



			if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking' || $current_sms_service == 'clickatell')



			{



				$send = send_sms($args);



			}



		}



		else



		{		



			$userinfo=get_userdata(esc_attr($_REQUEST['member_id']));



			$gymname=get_option( 'gmgt_system_name' );						



			$reciever_number = $userinfo->mobile;		



			$message_content ="You are successfully registered at ".$gymname. " Your profile has been approved by admin.";



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



		$obj_membership=new MJ_gmgt_membership;		



		$result = delete_user_meta(esc_attr($_REQUEST['member_id']), 'gmgt_hash');



		$user_info = get_userdata(esc_attr($_REQUEST['member_id']));



		$member_name= esc_attr($user_info->display_name);



		$to = esc_attr($user_info->user_email); 



		$login_link= esc_url(home_url());



		$membership = $obj_membership->MJ_gmgt_get_single_membership($user_info->membership_id);



		$subject =get_option( 'Member_Approved_Template_Subject' ); 



		$gymname=get_option( 'gmgt_system_name' );



		$sub_arr['[GMGT_GYM_NAME]']=$gymname;



	    $subject = MJ_gmgt_subject_string_replacemnet($sub_arr,$subject);



		$search=array('[GMGT_GYM_NAME]','[GMGT_LOGIN_LINK]','[GMGT_MEMBERNAME]');



		$membership_name=MJ_gmgt_get_membership_name($membership_id);



		$replace = array($gymname,$login_link,$member_name);



		$message_replacement = str_replace($search, $replace,get_option('Member_Approved_Template'));	



		MJ_gmgt_send_mail($to,$subject,$message_replacement);



		if($result)



		wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=4');



	}



}

// EXTEND MEMBERSHIP DATA
if(isset($_REQUEST['extend_membership']))
{
	$result=$obj_member->MJ_gmgt_extend_membership($_REQUEST);
	
	if($result){
		
		wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=15');

	}
}
//export Member in csv



if(isset($_POST['export_csv']))



{		



	foreach($_POST['selected_id'] as $m_id)



	{



		$member_list[]=get_userdata($m_id);



	}



	if(!empty($member_list))



	{



		$header = array();			



		$header[] = 'Username';



		$header[] = 'Email';



		$header[] = 'Password';



		$header[] = 'member_id';



		$header[] = 'first_name';



		$header[] = 'member_type';



		$header[] = 'last_name';			



		$header[] = 'gender';



		$header[] = 'birth_date';



		$header[] = 'blood_group';				



		$header[] = 'address';



		$header[] = 'city_name';



		$header[] = 'state_name';



		$header[] = 'country_name';



		$header[] = 'zip_code';



		$header[] = 'phonecode';



		$header[] = 'mobile';



		$header[] = 'phone';	



		$header[] = 'Weight';

		

		$header[] = 'Height';

		

		$header[] = 'Chest';



		$header[] = 'Waist';



		$header[] = 'Thigh';



		$header[] = 'Arms';



		$header[] = 'Fat';



		$header[] = 'Inquiry Date';



		$header[] = 'Trial End Date';



		$document_dir = WP_CONTENT_DIR;



		$document_dir .= '/uploads/export/';



		$document_path = $document_dir;



		if (!file_exists($document_path))



		{



			mkdir($document_path, 0777, true);		



		}



		



		$filename=$document_path.'export_member.csv';



		$fh = fopen($filename, 'w') or die("can't open file");



		fputcsv($fh, $header);



		foreach($member_list as $retrive_data)



		{



			$row = array();



			$user_info = get_userdata($retrive_data->ID);



			



			$row[] = $user_info->user_login;



			$row[] = $user_info->user_email;			



			$row[] = $user_info->user_pass;			



		



			$row[] =  get_user_meta($retrive_data->ID, 'member_id',true);



			$row[] =  get_user_meta($retrive_data->ID, 'first_name',true);



			$row[] =  get_user_meta($retrive_data->ID, 'member_type',true);



			$row[] =  get_user_meta($retrive_data->ID, 'last_name',true);



			$row[] =  get_user_meta($retrive_data->ID, 'gender',true);



			$row[] =  get_user_meta($retrive_data->ID, 'birth_date',true);



			$row[] =  get_user_meta($retrive_data->ID, 'blood_group',true);					



			$row[] =  get_user_meta($retrive_data->ID, 'address',true);					



			$row[] =  get_user_meta($retrive_data->ID, 'city_name',true);				



			$row[] =  get_user_meta($retrive_data->ID, 'state_name',true);				



			$row[] =  get_user_meta($retrive_data->ID, 'country_name',true);				



			$row[] =  get_user_meta($retrive_data->ID, 'zip_code',true);			



			$row[] =  get_user_meta($retrive_data->ID, 'phonecode',true);				



			$row[] =  get_user_meta($retrive_data->ID, 'mobile',true);				



			$row[] =  get_user_meta($retrive_data->ID, 'phone',true);								



			$row[] =  get_user_meta($retrive_data->ID, 'weight',true);



			$row[] =  get_user_meta($retrive_data->ID, 'height',true);



			$row[] =  get_user_meta($retrive_data->ID, 'chest',true);



			$row[] =  get_user_meta($retrive_data->ID, 'waist',true);



			$row[] =  get_user_meta($retrive_data->ID, 'thigh',true);



			$row[] =  get_user_meta($retrive_data->ID, 'arms',true);



			$row[] =  get_user_meta($retrive_data->ID, 'fat',true);



			$row[] =  get_user_meta($retrive_data->ID, 'inqiury_date',true);



			$row[] =  get_user_meta($retrive_data->ID, 'triel_date',true);

							



			fputcsv($fh, $row);



			



		}



		fclose($fh);







		//download csv file.



		ob_clean();



		$file=$document_path.'export_member.csv';//file location



		



		$mime = 'text/plain';



		header('Content-Type:application/force-download');



		header('Pragma: public');       // required



		header('Expires: 0');           // no cache



		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');



		header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file)).' GMT');



		header('Cache-Control: private',false);



		header('Content-Type: '.$mime);



		header('Content-Disposition: attachment; filename="'.basename($file).'"');



		header('Content-Transfer-Encoding: binary');			



		header('Connection: close');



		readfile($file);		



		exit;				



	}



	else



	{



		?>



		<div class="alert_msg alert alert-danger alert-dismissible fade in" role="alert">



			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>



			</button>



			<?php _e('Records not found.','gym_mgt');?>



		</div>



		<?php	



	}		



}



//upload Member csv	



if(isset($_REQUEST['upload_csv_file']))



{	



	if(isset($_FILES['csv_file']))



	{			



		$errors= array();



		$file_name = $_FILES['csv_file']['name'];



		$file_size =$_FILES['csv_file']['size'];



		$file_tmp =$_FILES['csv_file']['tmp_name'];



		$file_type=$_FILES['csv_file']['type'];







		$value = explode(".", $_FILES['csv_file']['name']);



		$file_ext = strtolower(array_pop($value));



		$extensions = array("csv");



		$upload_dir = wp_upload_dir();



		if(in_array($file_ext,$extensions )=== false){



			$errors[]="this file not allowed, please choose a CSV file.";



			wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=10');



		}



		if($file_size > 2097152)



		{



			$errors[]='File size limit 2 MB';



			wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=11');



		}



		



		if(empty($errors)==true)



		{	



			



			$rows = array_map('str_getcsv', file($file_tmp));		



			$header = array_map('strtolower',array_shift($rows));



				



			$csv = array();



			foreach ($rows as $row) 



			{	



				$header_size=sizeof($header);



				$row_size=sizeof($row);



				if($header_size == $row_size)



				{



					$csv = array_combine($header, $row);



					

					

					$username = $csv['username'];



					$email = $csv['email'];



					$user_id = 0;



					



					$password = $csv['password'];



					

					$problematic_row = false;



					

					if( email_exists( $email ) )



					{ // if the email is registered, we take the user from this



						$user_object = get_user_by( "email", $email );



						$user_id = $user_object->ID;					



						$problematic_row = true;



					



						if( !empty($password) )



							wp_set_password( $password, $user_id );



					}



					else{



						if( empty($password) ) // if user not exist and password is empty but the column is set, it will be generated



							$password = wp_generate_password();



					



						$user_id = wp_create_user($username, $password, $email);



					}



					



					if( is_wp_error($user_id) )



					{ // in case the user is generating errors after this checks



						echo '<script>alert("'.esc_html__('Problems with user','gym_mgt').'" : "'.esc_html__($username,'gym_mgt').'","'.esc_html__('we are going to skip','gym_mgt').'");</script>';



						continue;



					}



					



					if(!( is_array(MJ_gmgt_get_roles($user_id)) && in_array("administrator", MJ_gmgt_get_roles($user_id), FALSE) || is_multisite() && is_super_admin( $user_id ) ))

					$role="member";

					$lastmember_id=MJ_gmgt_get_lastmember_id($role);



					$nodate=substr($lastmember_id,0,-4);

			

					$memberno=substr($nodate,1);

			

					$test=(int)$memberno+1;

			
					$user_query = get_users( array ( 'orderby' => 'ID', 'order' => 'DESC', 'number' => 1 ) );
					$last_id = "";

					foreach ( $user_query as $user ) {
						$last_id = (int)$user->ID + 1;
						break;
					}
					$newmember='SVC000'. $last_id;

				

					wp_update_user(array ('ID' => $user_id, 'role' => 'member')) ;



					if(isset($csv['member_id']))

						add_user_meta( $user_id, 'member_id', $newmember);

				
					if(isset($csv['first_name']))



						update_user_meta( $user_id, "first_name", $csv['first_name'] );



					if(isset($csv['member_type']))



						update_user_meta( $user_id, "member_type", $csv['member_type'] );



					if(isset($csv['last_name']))



						update_user_meta( $user_id, "last_name", $csv['last_name'] );



					if(isset($csv['first_name']))



						update_user_meta( $user_id, "display_name", $csv['first_name'].' '.$csv['last_name'] );



					if(isset($csv['gender']))



						update_user_meta( $user_id, "gender", $csv['gender'] );



					if(isset($csv['birth_date']))



						update_user_meta( $user_id, "birth_date",$csv['birth_date']);



					if(isset($csv['address']))



						update_user_meta( $user_id, "address", $csv['address'] );		



					if(isset($csv['city_name']))



						update_user_meta( $user_id, "city_name", $csv['city_name'] );



					if(isset($csv['state_name']))



						update_user_meta( $user_id, "state_name", $csv['state_name'] );



					if(isset($csv['country_name']))



						update_user_meta( $user_id, "country_name", $csv['country_name'] );



					if(isset($csv['zip_code']))



						update_user_meta( $user_id, "zip_code", $csv['zip_code'] );



					if(isset($csv['phonecode']))



						update_user_meta( $user_id, "phonecode", $csv['phonecode'] );



					if(isset($csv['mobile']))



						update_user_meta( $user_id, "mobile", $csv['mobile'] );



					if(isset($csv['phone']))



						update_user_meta( $user_id, "phone", $csv['phone'] );	



					$success = 1;	



				



				}



				else



				{



					wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=12');						



				}



			}



		}



		else



		{



			foreach($errors as &$error) echo $error;



		}



		if(isset($success))



		{



		   wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=13');



		} 



	}



}











if(isset($_REQUEST['attendance']) && $_REQUEST['attendance'] == 1)



{



	$member_id=esc_attr($_REQUEST['member_id']);



	?>



	<script type="text/javascript">



	$(document).ready(function() 



	{



		"use strict";



		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



		$('.sdate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 



		$('.edate').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 



	});



	</script>



	<div class="page-inner min_height_1631"><!-- PAGE INNNER DIV START-->



		<div class="page-title"> 



			<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>



		</div>



		<div id="main-wrapper"><!-- MAIN WRAPPER DIV START-->



			<div class="row"><!--ROW DIV START-->



				<div class="panel panel-white "><!-- PANEL WHITE DIV START-->



					<div class="panel-body "><!-- PANEL BODY DIV START-->



						<h2 class="nav-tab-wrapper">



							<a href="?page=gmgt_member&view_member&member_id=<?php echo esc_attr($_REQUEST['member_id']); ?>&attendance=1" class="nav-tab nav-tab-active">



							<?php echo '<span class="dashicons dashicons-menu"></span>'.esc_html__('View Attendance', 'gym_mgt'); ?></a>



						</h2>



						<form name="wcwm_report" action="" method="post">



							<input type="hidden" name="attendance" value=1> 



							<input type="hidden" name="user_id" value=<?php echo esc_attr($_REQUEST['member_id']);?>>



							<div class="mb-3 row">



								<div class="form-group col-md-3">



									<label for="exam_id"><?php esc_html_e('Start Date','gym_mgt');?></label>



										<input type="text" class="form-control sdate" name="sdate"  value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);



											else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>



								</div>



								<div class="form-group col-md-3">



									<label for="exam_id"><?php esc_html_e('End Date','gym_mgt');?></label>



										<input type="text" class="form-control edate"  name="edate" value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']); else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>



								</div>



								<div class="form-group col-md-3 button-possition">



									<label for="subject_id">&nbsp;</label>



									<input type="submit" name="view_attendance" Value="<?php esc_html_e('Go','gym_mgt');?>"  class="btn btn-info"/>



								</div>



							</div>



						</form>



						<div class="clearfix"></div>



						<?php



							if(isset($_REQUEST['view_attendance']))



							{



								global $wpdb;



								$start_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['sdate']));



								$end_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['edate']));



								$user_id = esc_attr($_REQUEST['user_id']);



								$attendance = MJ_gmgt_view_member_attendance($start_date,$end_date,$user_id);



								$class_id = MJ_gmgt_get_class_id($user_id);



								if(!empty($class_id))



								{



									$class_name = MJ_gmgt_get_class_name_by_id($class_id);



								}



								else



								{



									$class_name="";



								}



								$curremt_date =$start_date;



								if($end_date >= $curremt_date)



								{



									$filename="Attendance Report.csv";



									$fp = fopen($filename, "w");



									// Get The Field Name



									$output="";



									$header = array();			



									$header[] = esc_html__('ID','gym_mgt');



									$header[] = esc_html__('Member Name','gym_mgt');



									$header[] = esc_html__('Class Name','gym_mgt');



									$header[] = esc_html__('Date','gym_mgt');



									$header[] = esc_html__('Day','gym_mgt');



									$header[] = esc_html__('Attendance','gym_mgt');



									fputcsv($fp, $header);



									$i=1;



									while ($end_date >= $curremt_date)



									{



										$name = MJ_gmgt_get_display_name($user_id);



										$row = array();



										$row[] = $i;



										$row[] = $name;



										$row[] = $class_name;



										$row[] = MJ_gmgt_getdate_in_input_box($curremt_date);



										$attendance_status = MJ_gmgt_get_attendence($user_id,$curremt_date);



										$row[] = date("D", strtotime($curremt_date));



										if(!empty($attendance_status))



										{



											$row[] = MJ_gmgt_get_attendence($user_id,$curremt_date);	



										}



										else



										{



											$row[] = esc_html__('Absent','gym_mgt');



										}



										$curremt_date = strtotime("+1 day", strtotime($curremt_date));



										$curremt_date = date("Y-m-d", $curremt_date);



										$i++;



									fputcsv($fp, $row);



									}



									// Download the file



									fclose($fp);



								   ?>



								<?php



								}



							}



							?>



						<?php



						//  DATA



						if(isset($_REQUEST['view_attendance']))



						{



							$start_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['sdate']));



							$end_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['edate']));



							$user_id = esc_attr($_REQUEST['user_id']);



							$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate_user_id($start_date,$end_date,$user_id);



							?>



						   <script type="text/javascript">



							$(document).ready(function() 



							{



								"use strict";



								jQuery('#tax_list').DataTable({



									// "responsive": true,



									"order": [[ 1, "asc" ]],



									dom: 'Bfrtip',



									buttons: [



										



										{



									extend: '<?php echo esc_html_e( 'print', 'gym_mgt' ) ;?>',



									title: '<?php echo esc_html_e( 'Attendance List', 'gym_mgt' ) ;?>',



									},



									'pdfHtml5',



									{



									extend: '<?php echo esc_html_e( 'excel', 'gym_mgt' ) ;?>',



									title: '<?php echo esc_html_e( 'Attendance List', 'gym_mgt' ) ;?>',



									}



																			



									],



									"aoColumns":[											  



												  {"bSortable": true},



												  {"bSortable": true},



												  {"bSortable": true},



												  {"bSortable": true}],



										language:<?php echo MJ_gmgt_datatable_multi_language();?>			  



									});



								



							} );



							</script>	



							<form name="wcwm_report" action="" method="post"><!--TAX LIST FORM START-->	



								<div class="panel-body"><!--PANEL BODY DIV START-->	



									<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->	



										<table id="tax_list" class="display" cellspacing="0" width="100%"><!--TAX LIST TABLE START-->	



											<thead>



												<tr>



													<th><?php esc_html_e('Class Name','gym_mgt');?></th>



													<th><?php esc_html_e('Date','gym_mgt');?></th>



													<th><?php esc_html_e('Day','gym_mgt');?> </th>



													<th><?php esc_html_e('Attendance','gym_mgt');?></th>



												</tr>



											</thead>



											<tfoot>



												<tr>



													<th><?php esc_html_e('Class Name','gym_mgt');?></th>



													<th><?php esc_html_e('Date','gym_mgt');?></th>



													<th><?php esc_html_e('Day','gym_mgt');?> </th>



													<th><?php esc_html_e('Attendance','gym_mgt');?></th>



												</tr>



											</tfoot>



											<tbody>



												<?php



													if(!empty($attendence_data))



													{



														foreach ($attendence_data as $retrieved_data)



														{



														?>



														<tr>



														<td class="name"><?php 



														echo MJ_gmgt_get_class_name($retrieved_data->class_id); ?>



														</td>



														<td class="name"><?php 



														 echo MJ_gmgt_getdate_in_input_box($retrieved_data->attendence_date); ?>



														</td>



														<td class="name">



														<?php 



														$day=date("D", strtotime($retrieved_data->attendence_date));



														echo esc_html__($day,"gym_mgt");



														 ?>



														</td>



														<td class="name"><?php 



														 echo esc_html__($retrieved_data->status,"gym_mgt"); ?>



														</td>



														</tr>



														<?php 



														}



													}



													?>



											</tbody>



										</table><!--TAX LIST TABLE END-->	



									</div><!--TABLE RESPONSIVE DIV END-->	



								</div><!--PANEL BODY DIV END-->	



							</form><!--TAX LIST FORM END-->	



						<?php



						}



						?>



					</div><!--PANEL BODY DIV END-->



				</div><!-- PANEL WHITE DIV END-->



			</div><!--ROW DIV END-->



		</div><!-- MAIN WRAPPER DIV END-->



	</div><!-- PAGE INNNER DIV END-->



	<?php 



}



else



{



	$active_tab = isset($_GET['tab'])?$_GET['tab']:'memberlist';



	?>



	<div class="page-inner min_height_1631"><!-- PAGE INNNER DIV START-->



		<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->



			<!-- <div class="page-title">



				<h3><img src="<?php echo esc_url(get_option( 'gmgt_system_logo', 'gym_mgt')); ?>" class="img-circle head_logo" width="40" height="40" /><?php echo esc_html(get_option('gmgt_system_name','gym_mgt'));?></h3>



			</div> -->



			<?php 	



			//SAVE MEMBER DATA



			if(isset($_POST['save_member']))

			{

				$nonce = $_POST['_wpnonce'];



				if (wp_verify_nonce( $nonce, 'save_member_nonce' ) )



				{

					if(!empty($_POST['relation'])){
						update_user_Meta($_REQUEST['member_id'], 'relation', $_POST['relation'] );
					}



					if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



					{



						if(sanitize_email($_POST['email']) == sanitize_email($_POST['hidden_email']))



						{



							$txturl=esc_url_raw($_POST['gmgt_user_avatar']);



							$ext=MJ_gmgt_check_valid_extension($txturl);



							if(!$ext == 0)



							{	



								$result=$obj_member->MJ_gmgt_gmgt_add_user($_POST);



								if($result)



								{



									wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=2');



								}	



							}			



							else



							{ ?>



								<div id="message" class="updated below-h2 ">



									<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>



								</div>



							<?php 



							}



						}



						else



						{



							if( !email_exists( sanitize_email($_POST['email']) ))



							{



								$txturl=esc_url_raw($_POST['gmgt_user_avatar']);



								$ext=MJ_gmgt_check_valid_extension($txturl);



								if(!$ext == 0)



								{	



									$result=$obj_member->MJ_gmgt_gmgt_add_user($_POST);



									if($result)



									{



										wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=2');



									}



								}



								else



								{



								?>



									<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



										<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>



										<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



									</div>



								<?php 



								}	



							}



							else



							{



							?>



								<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



									<p><?php esc_html_e('Email id exists already.','gym_mgt');?></p>



									<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



								</div>



							<?php 



							}



						}



					}



					else



					{



						if( !email_exists( sanitize_email($_POST['email']) ))



						{



							$txturl=esc_url_raw($_POST['gmgt_user_avatar']);



							$ext=MJ_gmgt_check_valid_extension($txturl);



							if(!$ext == 0)



							{	



								$result=$obj_member->MJ_gmgt_gmgt_add_user($_POST);		



								if($result>0)



								{

									$wizard = MJ_gmgt_setup_wizard_steps_updates('step6_member');

									wp_redirect ( admin_url() . 'admin.php?page=gmgt_member&tab=memberlist&message=1');



								}



							}



							else



							{ 



							?>



								<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



										<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>



										<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



									</div>



								



							<?php 



							}



						}



						else



						{?>



							<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



								<p><?php esc_html_e('Email id already exists.','gym_mgt');?></p>



								<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



							</div>



							<?php 



						}



					}			



				}



			}



			//Delete MEMBER DATA



			if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



			{



				$result=$obj_member->MJ_gmgt_delete_usedata(esc_attr($_REQUEST['member_id']));



				if($result)



				{



					wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=3');



				}



			}



			//delete selected MEMBER data//



			if(isset($_REQUEST['delete_selected']))



			{		



				if(!empty($_REQUEST['selected_id']))



				{



					foreach($_REQUEST['selected_id'] as $id)



					{



						$delete_member=$obj_member->MJ_gmgt_delete_usedata($id);



					}



					if($delete_member)



					{



						wp_redirect ( admin_url().'admin.php?page=gmgt_member&tab=memberlist&message=3');



					}



				}



				else



				{



					echo '<script language="javascript">';



					echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';



					echo '</script>';



				}



			}



			if(isset($_REQUEST['message']))



			{



				$message =esc_attr($_REQUEST['message']);



				if($message == 1)



				{



				?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Member added successfully.','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php	



				}



				elseif($message == 2)



				{



				?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e("Member updated successfully.",'gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php



				}



				elseif($message == 3) 



				{



				?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Member deleted successfully.','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php	



				}



				elseif($message == 4) 



				{?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Member Approved successfully','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php



				}



				elseif($message == 6) 



				{ ?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Class limit delete successfully','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php



				}



				elseif($message == 7) 



				{ ?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Class deleted successfully','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php



				}



				elseif($message == 9) 



				{ ?>



				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Class limit added successfully','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php		



				}



				elseif($message == 10) 



				{?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Only CSV file are allow.','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php		



				}



				elseif($message == 11) 



				{?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('File size limit 2 MB allow.','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



				<?php



				}



				elseif($message == 12) 



				{?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('This file formate not proper.Please select CSV file with proper formate.','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



					<?php				



				}



				elseif($message == 13) 



				{?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Member CSV Successfully Uploaded.','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



					<?php				



				}



				elseif($message == 14) 



				{?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Member ID are Same Please Upload Other Record.','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



					<?php				



				}
				elseif($message == 15) 



				{?>



					<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



						<p><?php esc_html_e('Membership Successfully Extended.','gym_mgt');?></p>



						<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



					</div>



					<?php				



				}


			}?>



			<div class="row"><!-- ROW DIV START-->



				<div class="col-md-12 padding_0"><!-- COL 12 DIV START-->



					<div class="panel-body "><!-- PANEL BODY DIV START-->



						<?php							



						if($active_tab == 'memberlist')



						{ 



							if(isset($_REQUEST['filter_membertype']) )



							{



								if(isset($_REQUEST['member_type']) && $_REQUEST['member_type'] != "")



								{



									$member_type= esc_attr($_REQUEST['member_type']);		



									$membersdata = get_users(array('meta_key' => 'member_type', 'meta_value' =>$member_type,'role'=>'member'));	



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







							$membertype_array=MJ_gmgt_member_type_array();



							if(!empty($membersdata))



							{



								?>	



								<script type="text/javascript">



									$(document).ready(function() 



									{



										"use strict";



										jQuery('#members_list').DataTable({



											// "responsive": true,



											"order": [[ 2, "asc" ]],



											dom: 'lifrtp',



											buttons: [



												'colvis'



											], 



											"aoColumns":[



												{"bSortable": false},



												{"bSortable": false},



												{"bSortable": true},



												{"bSortable": true},



												{"bSortable": true},



												{"bSortable": true},



												{"bSortable": true},



												{"bSortable": true},



												{"bSortable": true},



												{"bSortable": false}],



												language:<?php echo MJ_gmgt_datatable_multi_language();?>	



											});







										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



										$('.select_all').on('click', function(e)



										{



												if($(this).is(':checked',true))  



												{



												$(".sub_chk").prop('checked', true);  



												}  



												else  



												{  



												$(".sub_chk").prop('checked',false);  



												} 



										});



									



										$('.sub_chk').on('change',function()



										{ 



											if(false == $(this).prop("checked"))



											{ 



												$(".select_all").prop('checked', false); 



											}



											if ($('.sub_chk:checked').length == $('.sub_chk').length )



											{



												$(".select_all").prop('checked', true);



											}



										});







										$(".delete_selected").on('click', function()



										{	



											if ($('.select-checkbox:checked').length == 0 )



											{



												alert("<?php esc_html_e('Please select at least one record','gym_mgt');?>");



												return false;



											}



											else{



												var proceed = confirm("<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>");



												if (proceed) {



													  return true;



												} else {



													return false;



												}



											}



										});



										//------ Add class limit function ----------//



									$("body").on("click", ".add_classlimit_member", function(event)



									{



										var remaining_class_limit  = $(this).attr('remaining_class_limit');



										var total_class  = $(this).attr('total_class');



										var total_credit_class  = $(this).attr('total_credit_class');



										var membership_id  = $(this).attr('membership_id');



										var member_id  = $(this).attr('member_id');



									



										$(".membership_class_limit").val(total_class);



										$(".remaning_class_limit").val(remaining_class_limit);



										$(".total_credit_class").val(total_credit_class);



										$(".membership_id").val(membership_id);



										$(".member_id").val(member_id);



									



									});











									



									//------ delete class limit function ----------//



									$("body").on("click", ".del_classlimit_member", function(event)



									{



										var remaining_class_limit  = $(this).attr('remaining_class_limit');



										var total_class  = $(this).attr('total_class');



										var total_credit_class  = $(this).attr('total_credit_class');



										var membership_id  = $(this).attr('membership_id');



										var member_id  = $(this).attr('member_id');



									



										$(".membership_class_limit").val(total_class);



										$(".remaning_class_limit").val(remaining_class_limit);



										$(".total_credit_class").val(total_credit_class);



										$(".membership_id").val(membership_id);



										$(".member_id").val(member_id);



									});



									



									$('#add_class_limit_form').on('submit', function(e)



									{


										var valid = jQuery('#add_class_limit_form').validationEngine('validate');
										if (valid == true) {
										e.preventDefault();



										$('.save_add_class_btn').prop('disabled', true);



										var form = $(this).serialize();



											$.ajax(



											{



												type:"POST",



												url: $(this).attr('action'),



												data:form,



												success: function(data)



												{



													$('#add_class_limit_form').trigger("reset");



													$('.modal').modal('hide');



													window.location.href = window.location.href + "&message=9";								



												},



												error: function(data){



												}



											})

										}

									});



									



									//delete class limit for AJAX



									$('#delete_class_limit_form').on('submit', function(e)



									{

										var credit_class = $('.total_credit_class').val();
										var delete_classes = $('.delete_classes').val();
										if(delete_classes > credit_class){
											alert("Delete Class Limite is more than credit class");
											return false;
										}
										
										e.preventDefault();



										$('.delete_class_limit_btn').prop('disabled', true);



										var form = $(this).serialize();



											



										$.ajax(



										{



											type:"POST",



											url: $(this).attr('action'),



											data:form,												



											success: function(data)



											{



												if(data == 2)



												{



													alert('No Any Class Limit In This Member');



												}



												else



												{



													$('#delete_class_limit_form').trigger("reset");



													$('.modal').modal('hide');



													window.location.href = window.location.href + "&message=6";	



												}												



											},



											error: function(data){



											}



										})



									});



									$('#add_class_limit_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



									});



								</script>



								<form name="member_form" action="" method="post"><!-- MEMBER LIST FORM START-->



									<div class="panel-body padding_0"><!-- PANEL BODY DIV START-->



										<div class="table-responsive"><!-- TRABLE RESPONSIVE DIV START-->



											<table id="members_list" class="display" cellspacing="0" width="100%"><!-- PANEL LIST TABLE START-->



												<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



													<tr>



														<th class="padding_0"><input type="checkbox" class="select_all"></th>



														<th><?php esc_html_e('Photo','gym_mgt');?></th>



														<th><?php esc_html_e('Member Name & Email','gym_mgt');?></th>



														<th><?php esc_html_e('Member Id','gym_mgt');?></th>



														<th><?php esc_html_e('Member Type','gym_mgt');?></th>



														<th><?php esc_html_e('Joining Date','gym_mgt');?></th>



														<th><?php esc_html_e('Expiry Date','gym_mgt');?></th>



														<th><?php esc_html_e('Membership Status','gym_mgt');?></th>



														<th><?php esc_html_e('Remaining Class','gym_mgt' );?></th>



														<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>



													</tr>



												</thead>



												<tbody>



												<?php 



												if(!empty($membersdata))



												{



													



													foreach ($membersdata as $retrieved_data)



													{



														$membership_id = get_user_meta($retrieved_data->ID,'membership_id',true);



														$membershipdata=$obj_membership->MJ_gmgt_get_single_membership($membership_id);



														if(!empty($membershipdata))



														{

															// $remaining_class = "";

															if($membershipdata->classis_limit=='limited')



															{

																// $remaining_class = "";

																	$total_class=$membershipdata->on_of_classis;



																	$total_member_limit_class_data=$obj_membership->MJ_gmgt_get_member_credit_class($retrieved_data->ID,$membership_id);



																



																	$total_class_with_credit_limit=$membershipdata->on_of_classis + $total_member_limit_class_data  ;



																	if(empty($total_member_limit_class_data))



																	{



																		$total_member_limit_class='0';



																	}



																	else



																	{



																		$total_member_limit_class=$total_member_limit_class_data;



																	}



																



																	$remaining_class_with_memberlimit=$total_class+$total_member_limit_class;







																	$userd_class=MJ_gmgt_get_user_used_membership_class($membership_id,$retrieved_data->ID);



																	



																	$remaining_class_data=$total_class-$userd_class;



																	



																	$remaining_class=$remaining_class_data+$total_member_limit_class. esc_html__(' Out Of ','gym_mgt').$total_class_with_credit_limit;



																	$remaining_class_limit=$remaining_class_with_memberlimit-$userd_class;



															}



															else



															{



																$remaining_class='Unlimited';



															}



														}

														// var_dump($remaining_class);

														?>



														<tr>



															<td class="checkbox_width_10px">



																<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->ID); ?>">



															</td>



															<td class="user_image width_50px padding_left_0">



																<?php $uid=$retrieved_data->ID;



																$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



																if(empty($userimage))



																{



																	echo '<img src='.get_option( 'gmgt_member_logo' ).' height="50px" width="50px" class="img-circle" />';



																}



																else



																	echo '<img src='.esc_url($userimage).' height="50px" width="50px" class="img-circle"/>';



																?>



															</td>







															<td class="name">



																<a class="color_black" href="?page=gmgt_member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->ID)?>">



																	<?php $display_name=get_user_meta($retrieved_data->ID,"display_name",true);

																		$member_name = MJ_gmgt_get_user_full_display_name($retrieved_data->ID);

																		// var_dump($member_name);

																		// die;



																		// if(!empty($display_name))



																		// {



																		// 	$display_name1=$display_name;



																		// }



																		// else



																		// {



																		// 	$display_name1=$retrieved_data->display_name;



																		// }



																	echo esc_html($member_name);?>



																</a><br>



																<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>



															</td>







															<td class="memberid">



																<?php echo esc_html($retrieved_data->member_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Id','gym_mgt');?>" ></i>



															</td>



															



															<td class="memberid">



																<?php 



																if(isset($retrieved_data->member_type))



																{ 



																	 echo esc_html($membertype_array[$retrieved_data->member_type]);  



																}



																else



																{ 



																	echo esc_html__('Not Selected','gym_mgt');



																}



																?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Type','gym_mgt');?>" ></i>



															</td>



															



															<td class="joining date">



																<?php 



																if(!empty($retrieved_data->begin_date))



																{



																	echo MJ_gmgt_getdate_in_input_box($retrieved_data->begin_date); 



																}



																else



																{ 



																	echo "N/A";



																} 



																?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Joining Date','gym_mgt');?>" ></i>



															</td>



															<td class="joining date">



																<?php 



																if(!empty($retrieved_data->end_date)) 



																{ 



																	echo MJ_gmgt_getdate_in_input_box($retrieved_data->end_date); 



																}



																else



																{ 



																	echo "N/A"; 



																} ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Expiry Date','gym_mgt');?>" ></i>



															</td>



															<td class="status">



																<?php 



																if($retrieved_data->membership_status == "")



																{ 



																	echo "N/A";



																}



																elseif($retrieved_data->member_type != 'Prospect')



																{



																	esc_html_e($retrieved_data->membership_status,'gym_mgt');



																}



																else



																{ 



																	esc_html_e('Prospect','gym_mgt'); 



																} 



																?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Membership Status','gym_mgt');?>" ></i>



															</td>



															<td class="remaining_class">



																<span class="grn_color padding_3">



																	<?php 

																	if(isset($remaining_class) && $remaining_class == 'Unlimited')



																	{



																		echo esc_html_e('Unlimited','gym_mgt');



																	}



																	elseif(!empty($remaining_class))



																	{



																		echo esc_html($remaining_class); 



																	}else{



																		echo "N/A";



																	}



																	?>



																</span> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Remaining Class','gym_mgt');?>" ></i>



															</td>



															<td class="action"> 



																<div class="gmgt-user-dropdown">



																	<ul class="" style="margin-bottom: 0px !important;">



																		<li class="">



																			<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																				<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																			</a>



																			<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																				



																				<?php



																				if(!empty($membershipdata->classis_limit))



																				{



																					if($membershipdata->classis_limit=='limited')



																					{ 



																					?>



																						<li class="float_left_width_100">



																							<a href="#" member_id="<?php echo $retrieved_data->ID;?>" membership_id="<?php echo $membership_id;?>" total_class="<?php echo $total_class; ?>" total_credit_class="<?php echo $total_member_limit_class; ?>" remaining_class_limit="<?php echo $remaining_class_limit; ?>" class="float_left_width_100 add_classlimit_member" data-bs-toggle="modal" data-bs-target="#myModal_add_class_limit"><i class="fa fa-plus" aria-hidden="true"></i><?php esc_html_e('Add Class Limit', 'gym_mgt' ) ;?></a>



																						</li>	



																						<li class="float_left_width_100">



																							<a href="#" member_id="<?php echo $retrieved_data->ID;?>" membership_id="<?php echo $membership_id;?>" total_class="<?php echo $total_class; ?>"  total_credit_class="<?php echo $total_member_limit_class; ?>" remaining_class_limit="<?php echo $remaining_class_limit; ?>" class="float_left_width_100 list_delete_btn del_classlimit_member" data-bs-toggle="modal" data-bs-target="#myModal_delete_class_limit" ><i class="fa fa-trash"></i><?php esc_html_e( 'Delete Class Limit', 'gym_mgt' ) ;?> </a>



																						</li>	



																					<?php 



																					}



																				}



																				?>







																				<li class="float_left_width_100">



																					<a href="?page=gmgt_member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>



																				</li>	

																				<!-- <li class="float_left_width_100">



																					<a href="" class="float_left_width_100 extend_membership_popup" id="<?php echo esc_attr($retrieved_data->ID)?>" type="<?php echo 'extend_membership';?>"><i class="fa fa-level-up"></i> <?php esc_html_e('Extend Membership', 'gym_mgt' ) ;?></a>



																				</li> -->



																				<?php 



																				if(get_user_meta($retrieved_data->ID, 'gmgt_hash', true)!='')



																				{



																					?>



																					<li class="float_left_width_100">



																						<a href="?page=gmgt_member&tab=addmember&action=approve&member_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-thumbs-up"></i><?php esc_html_e('Approve', 'gym_mgt' ) ;?></a>



																					</li>



																				<?php



																				}



																				?>



																				<?php 



																				if($user_access_edit == '1')



																				{?>	



																					<li class="float_left_width_100 border_bottom_item">



																						<a href="?page=gmgt_member&tab=addmember&action=edit&memberid=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-edit"></i><?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																					</li>



																				<?php



																				}															



																				if($user_access_delete =='1')



																				{ ?>



																					<li class="float_left_width_100">



																						<a href="?page=gmgt_member&tab=memberlist&action=delete&member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i><?php esc_html_e( 'Delete', 'gym_mgt' ) ;?></a>



																					</li>



																				<?php 



																				} ?>



																					



																			</ul>



																		</li>



																	</ul>



																</div>	



															</td>



														</tr>



														<?php 



													}



												}	?>



												</tbody>



											</table><!-- MEMBER LIST TABLE END-->



											







											<!-------- Delete And Select All Button ----------->



											<div class="print-button pull-left">



												<button class="btn btn-success btn-sms-color">



													<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">



													<label for="checkbox" class="margin_right_5px"><?php esc_html_e('Select All', 'gym_mgt' ) ;?></label>



												</button>







												<?php 



													if($user_access_delete =='1')



													{ ?>



														<button data-toggle="tooltip"  id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>



													<?php 



												} 



												?>



												<button data-toggle="tooltip" type="submit"  title="<?php esc_html_e('Export CSV','gym_mgt');?>"  name="export_csv" type="button" class="member_csv_export_alert member_csv_export_alert view_csv_popup export_import_csv_btn padding_0"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/export_csv.png" ?>" alt=""></button>



												<button data-toggle="tooltip"  title="<?php esc_html_e('Import CSV','gym_mgt');?>" name="import_csv" type="button" class="importdata view_import_student_csv_popup export_import_csv_btn padding_0"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/import_csv.png" ?>" alt=""></button>



											



											</div>



											<!-------- Delete And Select All Button ----------->



										</div><!-- TABLE RESPONSIVE DIV END-->



									</div><!-- PANEL BODY DIV END-->



								</form><!-- MEMBER LIST FORM END-->



								<?php 



							}



							else



							{

								if($user_access_add == 1)

								{

									?>



									<div class="no_data_list_div row"> 



										<div class="offset-md-2 col-md-4">



											<a href="<?php echo admin_url().'admin.php?page=gmgt_member&tab=addmember';?>">



												<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



											</a>

									

											<div class="col-md-12 dashboard_btn margin_top_20px">



												<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



											</div> 



										</div>

										<div class="col-md-4">



											<a data-toggle="tooltip"  name="import_csv" type="button" class="importdata">

											

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/thumb_icon/Import_list.png" ?>" alt="">

											

											</a>



											<div class="col-md-12 dashboard_btn margin_top_20px">



												<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to import CSV.','gym_mgt'); ?> </label>

											

											</div> 

											

										</div>



									</div>		



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



							}



							?>



							<!----------ADD Class Limit POPUP------------->



						<div class="modal fade overflow_scroll" id="myModal_add_class_limit" role="dialog">



							<div class="modal-dialog modal-lg">



								<div class="modal-content">



									<div class="modal-header mb-3 float_left_width_100 pop_btn_bg">



										<h3 class="modal-title float_left"><?php esc_html_e('Add Class Limit','gym_mgt');?></h3>



										<button type="button" class="close  float_right" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></button>



									</div>







									<div class="modal-body">



										<form name="add_class_limit_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="add_class_limit_form">



											<input type="hidden" name="action" value="MJ_gmgt_add_class_limit">



											<input type="hidden" name="member_id" class="member_id" value=""  />



											<input type="hidden" name="membership_id" class="membership_id" value=""  />



											<div class="form-body user_form"> <!--form-Body div Strat-->   



												<div class="row"><!--Row Div--> 



													<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



														<div class="form-group input">



															<div class="col-md-12 form-control">



																<input  class="form-control text-input validate[required] membership_class_limit" type="text"  value="" name="membership_class_limit" disabled>



																<label class="" for="installment_amount"><?php esc_html_e('Membership Class Limit','gym_mgt');?><span class="require-field"></span></label>



															</div>



														</div>



													</div>



												



													<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



														<div class="form-group input">



															<div class="col-md-12 form-control">



																<input class="form-control text-input validate[required] total_credit_class" type="text"  value="" name="total_credit_class" disabled >



																<label class="" for="installment_amount"><?php esc_html_e('Total Credit Class','gym_mgt');?><span class="require-field"></span></label>



															</div>



														</div>



													</div>



												



													<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



														<div class="form-group input">



															<div class="col-md-12 form-control">



																<input class="form-control text-input validate[required] remaning_class_limit" type="text"  value="" name="remaning_class_limit" disabled >



																<label class="" for="installment_amount"><?php esc_html_e('Total Remaining Class','gym_mgt');?><span class="require-field"></span></label>



															</div>



														</div>



													</div>



													<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



														<div class="form-group input">



															<div class="col-md-12 form-control">



																<input class="form-control text-input validate[required]" type="number" min="0" onkeypress="if(this.value.length==6) return false;"  value="" name="add_classlimit_member">



																<label class="active" for="installment_amount"><?php esc_html_e('Add No Of Class Limit','gym_mgt');?><span class="require-field">*</span></label>



															</div>



														</div>



													</div>	



												</div>



											</div>	



											<div class="form-body user_form"> <!--form-Body div Strat-->   



												<div class="row"><!--Row Div--> 



													<div class="col-md-6 col-sm-6 col-xs-12 mt-2"><!--save btn--> 



														<input type="submit" value="<?php  esc_html_e('Save','gym_mgt'); ?>" name="save_class_limit" class="btn save_btn save_add_class_btn"/>



													</div>	



												</div>	



											</div>		



										</form>



									</div>



								</div>



							</div>



						</div>	



						<!----------Delete Class Limit POPUP------------->



						<div class="modal fade overflow_scroll" id="myModal_delete_class_limit" role="dialog">



							<div class="modal-dialog modal-lg">



								<div class="modal-content">



									<div class="modal-header mb-3 float_left_width_100 pop_btn_bg">



										<h3 class="modal-title float_left"><?php esc_html_e('Delete Class Limit','gym_mgt');?></h3>



										<button type="button" class="close float_right" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></button>



									</div>







									<div class="modal-body">



										<form name="delete_class_limit_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="delete_class_limit_form">



											<input type="hidden" name="action" value="MJ_gmgt_delete_class_limit_for_member">



											<input type="hidden" name="member_id" class="member_id" value=""  />



											<input type="hidden" name="membership_id" class="membership_id" value=""  />



											<div class="form-body user_form"> <!--form-Body div Strat-->   



												<div class="row"><!--Row Div--> 



													<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



														<div class="form-group input">



															<div class="col-md-12 form-control">



																<input  class="form-control text-input validate[required] membership_class_limit" type="text"  value="" name="membership_class_limit" disabled>



																<label class="" for="installment_amount"><?php esc_html_e('Membership Class Limit','gym_mgt');?><span class="require-field"></span></label>



															</div>



														</div>



													</div>



												



													<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



														<div class="form-group input">



															<div class="col-md-12 form-control">



																<input class="form-control text-input validate[required] total_credit_class" type="text"  value="" name="total_credit_class" disabled >



																<label class="" for="installment_amount"><?php esc_html_e('Total Credit Class','gym_mgt');?><span class="require-field"></span></label>



															</div>



														</div>



													</div>



												



													<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



														<div class="form-group input">



															<div class="col-md-12 form-control">



																<input class="form-control text-input validate[required] remaning_class_limit" type="text"  value="" name="remaning_class_limit" disabled >



																<label class="" for="installment_amount"><?php esc_html_e('Total Remaining Class','gym_mgt');?><span class="require-field"></span></label>



															</div>



														</div>



													</div>



													<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



														<div class="form-group input">



															<div class="col-md-12 form-control">



																<input class="form-control text-input validate[required] delete_classes" type="number" min="0" onkeypress="if(this.value.length==6) return false;"  value="" name="add_classlimit_member">



																<label class="active" for="installment_amount"><?php esc_html_e('Delete No Of Class Limit','gym_mgt');?><span class="require-field">*</span></label>



															</div>



														</div>



													</div>	



												</div>



											</div>	



											<div class="col-md-6 col-sm-6 col-xs-12 mt-2"><!--save btn--> 



												<input type="submit" value="<?php  _e('Delete','gym_mgt'); ?>" name="delete_class_limit" class="btn save_btn delete_class_limit_btn"/>



											</div>													



									</form>



									</div>



								</div>



							</div>



						</div>							



						<?php 



						}



						if($active_tab == 'addmember')



						{



							require_once GMS_PLUGIN_DIR. '/admin/member/add_member.php';



						}							 



						if($active_tab == 'viewmember')



						{



							



							require_once GMS_PLUGIN_DIR. '/admin/member/view_member.php';



						}



						?>



					</div><!-- PANEL BODY DIV END-->



				</div><!-- COL 12 DIV END-->



			</div><!-- ROW DIV END-->



		</div><!--MAIN_LIST_MARGING_15px END  -->



	</div><!-- PAGE INNNER DIV END-->



	<?php 



} 



?> 	