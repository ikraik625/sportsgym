<?php 



$obj_user=new MJ_gmgt_member;



$active_tab = isset($_GET['tab'])?$_GET['tab']:'staff_memberlist';



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



	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('staff_member');



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



			if ('staff_member' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



			{



				if($user_access_edit=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}			



			}



			if ('staff_member' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))



			{



				if($user_access_delete=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			}



			if ('staff_member' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



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



<div class="popup-bg min_height_1631">



    <div class="overlay-content">



		<div class="modal-content">



			<div class="category_list">



			 </div>



        </div>



    </div> 



</div>



<!-- End POP-UP Code -->



<div class="page-inner min_height_1631"><!--PAGE INNER DIV STRAT-->



	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->



		<?php 



		//SAVE STAFF MEMBER DATA



		if(isset($_POST['save_staff']))



		{



		



			$nonce = $_POST['_wpnonce'];



			if (wp_verify_nonce( $nonce, 'save_staff_nonce' ) )



			{



				if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')



				{



					if($_POST['email'] == $_POST['hidden_email'])



					{



						$txturl=$_POST['gmgt_user_avatar'];



						$ext=MJ_gmgt_check_valid_extension($txturl);



						if(!$ext == 0)



						{



							$result=$obj_user->MJ_gmgt_gmgt_add_user($_POST);



							if($result)



							{



								wp_redirect ( admin_url() . 'admin.php?page=gmgt_staff&tab=staff_memberlist&message=2');



							}



						}			



						else



						{ ?>



							<div id="message" class="updated below-h2 ">



							<p>



								<?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>



							</p></div>				 



							<?php 



						}	



					}



					else



					{



						if( !email_exists( $_POST['email'] ))



						{



							$txturl=$_POST['gmgt_user_avatar'];



							$ext=MJ_gmgt_check_valid_extension($txturl);



							if(!$ext =member_type)



							{




								$result=$obj_user->MJ_gmgt_gmgt_add_user($_POST);



								if($result)



								{



									wp_redirect ( admin_url() . 'admin.php?page=gmgt_staff&tab=staff_memberlist&message=2');



								}



							}			



							else



							{ ?>



								<div id="message" class="updated below-h2 ">



								<p>



									<?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>



								</p></div>				 



								<?php 



							}	



						}



						else{}



						{



							?>



						<div id="message" class="updated below-h2">



							<p><p><?php esc_html_e('Email id exists already.','gym_mgt');?></p></p>



						</div>							



						<?php 



						}



					}



				}



				else



				{



					if( !email_exists( $_POST['email'] ))



					{



						$txturl=esc_url_raw($_POST['gmgt_user_avatar']);



						$ext=MJ_gmgt_check_valid_extension($txturl);



						if(!$ext == 0)



						{



							$result=$obj_user->MJ_gmgt_gmgt_add_user($_POST);



							if($result)



							{

								$wizard = MJ_gmgt_setup_wizard_steps_updates('step3_staff');

								wp_redirect ( admin_url() . 'admin.php?page=gmgt_staff&tab=staff_memberlist&message=1');



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



					{?>



						<div id="message" class="updated below-h2">



							<p><?php esc_html_e('Email id already exists.','gym_mgt');?></p>



						</div>	



			<?php }



				}



			}



		}



		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



		{



			$result=$obj_user->MJ_gmgt_delete_usedata($_REQUEST['staff_member_id']);



			if($result)



			{



				wp_redirect ( admin_url() . 'admin.php?page=gmgt_staff&tab=staff_memberlist&message=3');



			}



		}



		if(isset($_REQUEST['delete_selected']))



		{		



			if(!empty($_REQUEST['selected_id']))



			{



				foreach($_REQUEST['selected_id'] as $id)



				{



					$delete_staff_member=$obj_user->MJ_gmgt_delete_usedata($id);



				}



				if($delete_staff_member)



				{



					wp_redirect ( admin_url().'admin.php?page=gmgt_staff&tab=staff_memberlist&message=3');



				}



			}



else

			{



				echo '<script language="javascript">';



				echo 'alert("'.esc_html__('Please select at least one record.','gym_mgt').'")';



				echo '</script>';



			}



		};







		//export Member in csv



		if(isset($_POST['export_csv']))



		{		



			// $get_member = array('role' => 'staff_member');



			// $member_list=get_users($get_member);



		



			foreach($_POST['selected_id'] as $s_id)



			{



				$member_list[]=get_userdata($s_id);



			}



			if(!empty($member_list))



			{



				$header = array();			



				$header[] = 'Username';



				$header[] = 'Email';



				$header[] = 'Password';



				$header[] = 'first_name';



				$header[] = 'middle_name';



				$header[] = 'last_name';			



				$header[] = 'gender';



				$header[] = 'birth_date';				



				$header[] = 'address';



				$header[] = 'city_name';



				$header[] = 'state_name';



				$header[] = 'zip_code';



				$header[] = 'mobile';



				$header[] = 'phone';	



				



				$document_dir = WP_CONTENT_DIR;



				$document_dir .= '/uploads/export/';



				$document_path = $document_dir;



				if (!file_exists($document_path))



				{



					mkdir($document_path, 0777, true);		



				}



				



				$filename=$document_path.'export_staff_member.csv';



				$fh = fopen($filename, 'w') or die("can't open file");



				fputcsv($fh, $header);



				foreach($member_list as $retrive_data)



				{



					$row = array();



					$user_info = get_userdata($retrive_data->ID);



					



					$row[] = $user_info->user_login;



					$row[] = $user_info->user_email;			



					$row[] = $user_info->user_pass;			



		



					$row[] =  get_user_meta($retrive_data->ID, 'first_name',true);



					$row[] =  get_user_meta($retrive_data->ID, 'middle_name',true);



					$row[] =  get_user_meta($retrive_data->ID, 'last_name',true);



					$row[] =  get_user_meta($retrive_data->ID, 'gender',true);



					$row[] =  get_user_meta($retrive_data->ID, 'birth_date',true);					



					$row[] =  get_user_meta($retrive_data->ID, 'address',true);					



					$row[] =  get_user_meta($retrive_data->ID, 'city_name',true);

					

					$row[] =  get_user_meta($retrive_data->ID, 'state_name',true);



					$row[] =  get_user_meta($retrive_data->ID, 'zip_code',true);					



					$row[] =  get_user_meta($retrive_data->ID, 'mobile',true);				



					$row[] =  get_user_meta($retrive_data->ID, 'phone',true);								



									



					fputcsv($fh, $row);	



				}



				fclose($fh);



				//download csv file.



				ob_clean();



				$file=$document_path.'export_staff_member.csv';//file location



				



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



					<?php esc_html_e('Records not found.','gym_mgt');?>



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



					wp_redirect ( admin_url().'admin.php?page=gmgt_staff&tab=staff_memberlist&message=10');



				}



				if($file_size > 2097152)



				{



					$errors[]='File size limit 2 MB';



					wp_redirect ( admin_url().'admin.php?page=gmgt_staff&tab=staff_memberlist&message=11');



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



							



							if( username_exists($username) )



							{ // if user exists, we take his ID by login



								$user_object = get_user_by( "login", $username );



								$user_id = $user_object->ID;



								if( !empty($password) )



									wp_set_password( $password, $user_id );



							}



							elseif( email_exists( $email ) )



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



								



								wp_update_user(array ('ID' => $user_id, 'role' => 'staff_member')) ;



							if(isset($csv['first_name']))



								update_user_meta( $user_id, "first_name", $csv['first_name'] );



							if(isset($csv['middle_name']))



								update_user_meta( $user_id, "middle_name", $csv['middle_name'] );



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



							wp_redirect ( admin_url().'admin.php?page=gmgt_staff&tab=staff_memberlist&message=12');						



						}



					}



				}



				else



				{



					foreach($errors as &$error) echo $error;



				}



				if(isset($success))



				{



				?>



				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



					<p><?php esc_html_e('Staff Member CSV Successfully Uploaded.','gym_mgt');?></p>



					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



				</div>



				<?php



				} 



			}



		}















		if(isset($_REQUEST['message']))



		{



			$message =esc_attr($_REQUEST['message']);



			if($message == 1)



			{?>



				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



					<p><?php esc_html_e('Staff Member Added successfully.','gym_mgt');?></p>



					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



				</div>



			<?php



			}



			elseif($message == 2)



			{?>	



				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



					<p><?php esc_html_e("Staff Member updated successfully.",'gym_mgt');?></p>



					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



				</div>



			<?php 		



			}



			elseif($message == 3) 



			{?>



				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



					<p><?php esc_html_e('Staff Member deleted successfully.','gym_mgt');?></p>



					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



				</div>



				<?php	



			}



			elseif($message == 10) 



			{ ?>



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



		}



		?>



		



		<div class="row"><!--ROW DIV START-->



			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->



				<div class="panel-body"><!--PANEL BODY DIV START-->



					<?php						



					if($active_tab == 'staff_memberlist')



					{ 



						$get_staff = array('role' => 'Staff_member');



						$staffdata=get_users($get_staff);



						if(!empty($staffdata))



						{



							?>	



							<script type="text/javascript">



								$(document).ready(function()



								{



									"use strict";



									jQuery('#staff_list').DataTable({



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



												// {"bSortable": true},



												{"bSortable": true},



												{"bSortable": true},



												{"bVisible": true},	                 



												{"bSortable": false}



											],



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



								} );



							</script>



							<form name="wcwm_report" action="" method="post"><!--Staff MEMBER LIST FORM START-->



								<div class="panel-body padding_0"><!--PANEL BODY DIV START-->



									<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



										<table id="staff_list" class="display" cellspacing="0" width="100%"><!--Staff MEMBER LIST TABLE START-->



											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



												<tr id="height_50">



													<th class="padding_0"><input type="checkbox" class="select_all"></th>



													<th><?php esc_html_e('Photo','gym_mgt');?></th>



													<th><?php esc_html_e('Staff Member Name & Email','gym_mgt');?></th>



													<th><?php esc_html_e('Assign Role','gym_mgt');?></th>



													<th><?php esc_html_e('Mobile No.','gym_mgt');?></th>



													<th><?php esc_html_e('Specialization','gym_mgt');?></th>



													<th class="text_align_end"><?php esc_html_e('Action','gym_mgt');?></th>



												</tr>



											</thead>



											<tbody>



												<?php 



												//GET Staff MEMBER DATA

												if(!empty($staffdata))



												{



													foreach ($staffdata as $retrieved_data)



													{



														?>



														<tr>



															<td class="checkbox_width_10px">



																<input type="checkbox" name="selected_id[]" class="smgt_sub_chk sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->ID); ?>">



															</td>



															<td class="user_image width_50px padding_left_0">



																<?php $uid=$retrieved_data->ID;$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);



																if(empty($userimage))



																{



																	echo '<img src='.get_option( 'gmgt_Staffmember_logo' ).' height="50px" width="50px" class="img-circle" />';



																}



																else



																{



																	echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';



																}



																	



																?>



															</td>







															<td class="name">



																<a class="color_black" href="?page=gmgt_staff&tab=view_staffmember&action=view&staff_member_id=<?php echo esc_attr($retrieved_data->ID)?>" class="">



																	<?php 



																	// $display_name=get_user_meta($retrieved_data->ID,"display_name",true);



																	// if(!empty($display_name))



																	// {



																	// 	$display_name1=$display_name;



																	// }



																	// else



																	// {



																	// 	$display_name1=$retrieved_data->display_name;



																	// }



																	$display_name=MJ_gmgt_get_user_full_display_name($retrieved_data->ID);



																	echo esc_html($display_name);?>



																</a><br>



																<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>



																 <!-- <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member Name','gym_mgt');?>" ></i> -->



															</td>



															<td class="department">



																<?php



																$postdata=get_post(esc_html($retrieved_data->role_type));



																if(isset($postdata))



																{



																	echo esc_html($postdata->post_title);



																}else{

																	echo "N/A";

																}



																?>



																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Assign Role','gym_mgt');?>" ></i>



															</td>



															<!-- <td class="email">



																<?php echo esc_html($retrieved_data->user_email);?>



																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member Email','gym_mgt');?>" ></i>



															</td> -->



															<td class="mobile">



																+<?php echo MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>



																<?php echo esc_html($retrieved_data->mobile);?>



																<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Mobile No.','gym_mgt');?>" ></i>



															</td>



															<?php



															if(!empty($retrieved_data->activity_category))



															{



																$specilization_array=explode(',',$retrieved_data->activity_category);



																



																$specilization_name_array=array();



																if(!empty($specilization_array))



																{



																	foreach ($specilization_array as $data)



																	{



																		$specilization_name_array[]=get_the_title($data);



																	}



																}



																?>



																<td class="">



																	<?php echo implode(',',$specilization_name_array); ?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Specialization','gym_mgt');?>" ></i>



																</td>



																<?php



															}



															else



															{



																?>



																<td class="">



																	<?php echo "N/A"; ?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Specialization','gym_mgt');?>" ></i>



																</td>



															<?php



															}



															?>



															<td class="action"> 



																<div class="gmgt-user-dropdown">



																	<ul class="" style="margin-bottom: 0px !important;">



																		<li class="">



																			<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																				<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																			</a>



																			<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																				<li class="float_left_width_100">



																					<a href="?page=gmgt_staff&tab=view_staffmember&action=view&staff_member_id=<?php echo esc_attr($retrieved_data->ID)?>" class="float_left_width_100"><i class="fa fa-eye"></i> <?php esc_html_e('View', 'gym_mgt' ) ;?></a>



																				</li>



																				<?php if($user_access_edit == '1')



																				{?>	



																					<li class="float_left_width_100 border_bottom_item">



																						<a href="?page=gmgt_staff&tab=add_staffmember&action=edit&staff_member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																					</li>



																				<?php



																				}	







																				if($user_access_delete =='1')



																				{ ?>



																					<li class="float_left_width_100">



																						<a href="?page=gmgt_staff&tab=staff_memberlist&action=delete&staff_member_id=<?php echo esc_attr($retrieved_data->ID);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



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



												}



												?>



											</tbody>



										</table><!--Staff MEMBER LIST TABLE END-->



										<!-------- Delete And Select All Button ----------->



										<div class="print-button pull-left">



											<button class="btn btn-success btn-sms-color">



												<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">



												<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'gym_mgt' ) ;?></label>



											</button>



											<?php 



												if($user_access_delete =='1')



												{ ?>



													<button data-toggle="tooltip"  id="delete_selected" title="<?php esc_html_e('Delete Selected','gym_mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>



												<?php 



											} 



											?>



											<button data-toggle="tooltip" type="submit"  title="<?php esc_html_e('Export CSV','gym_mgt');?>"  name="export_csv" type="button" class="member_csv_export_alert member_csv_export_alert view_csv_popup export_import_csv_btn padding_0"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/export_csv.png" ?>" alt=""></button>



											<?php



											if($user_access_add == '1')



											{ ?>



											<button data-toggle="tooltip"  title="<?php esc_html_e('Import CSV','gym_mgt');?>" name="import_csv" type="button" class="importdata view_import_student_csv_popup export_import_csv_btn padding_0"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/import_csv.png" ?>" alt=""></button>



											<?php 



											} ?>







										</div>



										<!-------- Delete And Select All Button ----------->



									</div><!--TABLE RESPONSIVE DIV END-->



								</div><!--PANEL BODY DIV END-->



							</form><!--Staff MEMBER LIST FORM END-->



							<?php 



						}



						else



						{

							if($user_access_add == 1)

							{

								?>



								<div class="no_data_list_div row"> 



									<div class="offset-md-2 col-md-4">



										<a href="<?php echo admin_url().'admin.php?page=gmgt_staff&tab=add_staffmember';?>">



											<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



										</a>



										<div class="col-md-12 dashboard_btn margin_top_20px">



											<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



										</div> 



									</div>

									

									<div class="col-md-4">



										<a data-toggle="tooltip" name="import_csv" type="button" class="importdata">

										

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



					}



					if($active_tab == 'add_staffmember')



					{



					require_once GMS_PLUGIN_DIR. '/admin/staff-members/add_staff.php';



					}						



					if($active_tab == 'view_staffmember')



					{



					require_once GMS_PLUGIN_DIR. '/admin/staff-members/view_staffmember.php';



					}



					?>



				</div><!--PANEL BODY DIV END-->



			</div><!--COL 12 DIV END-->



		</div><!--ROW DIV END-->



	</div><!-- MAIN_LIST_MARGING_15px END -->



</div><!--PAGE INNER DIV END-->