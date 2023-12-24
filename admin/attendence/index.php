<?php 



$curr_user_id=get_current_user_id();



$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



$obj_class=new MJ_gmgt_classschedule;



$obj_attend=new MJ_gmgt_attendence;



$active_tab = isset($_GET['tab'])?$_GET['tab']:'attendence';



$class_id =0;



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



	$user_access=MJ_gmgt_get_userrole_wise_manually_page_access_right_array_for_management('attendence');



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



			if ('attendence' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



			{



				if($user_access_edit=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}			



			}



			if ('attendence' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))



			{



				if($user_access_delete=='0')



				{	



					MJ_gmgt_access_right_page_not_access_message_for_management();



					die;



				}	



			}



			if ('attendence' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



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



<script type="text/javascript">



$(document).ready(function() 



{	



	"use strict";



	$('#member_attadence').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



	$('.curr_date').datepicker(



	{



		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



		endDate: '+0d',



		maxDate:'today',



		endDate: '+0d',



		autoclose: true



	});



	$("body").on("change",".checkAll",function(){



		var state = this.checked;



		state? $(':checkbox').prop('checked',true):$(':checkbox').prop('checked',false);



		state? $(this).next('b').text('Uncheck All') :$(this).next('b').text('Check All')



	});



	



	$("body").on("change",".checkbox1",function()



	{



		if(false == $(this).prop("checked"))



		{ 



			$(".checkAll").prop('checked', false); 



		}



		if ($('.checkbox1:checked').length == $('.checkbox1').length )



		{



			$(".checkAll").prop('checked', true);



		}



   });







	$("body").on("click",".Present_hide",function(){



	  $(".status_div_absent").hide();



	});



	$("body").on("click",".Absent_show",function(){



	  $(".status_div_absent").show();



	});



} );



</script>



<div class="page-inner min_height_1631"><!-- PAGE INNNER DIV START-->



	<?php	



	//SAVE Attendance DATA



	



	if(isset($_POST['save_attendence']))



	{		



		$attend_by=get_current_user_id();



		$attendance_type='web';



		$membersdata = get_users(array('meta_key' => 'class_id', 'meta_value' => $_POST['class_id'],'role'=>'member'));



		if(isset($_POST['attendence']))



		{



			$result=$obj_attend->MJ_gmgt_save_attendence($_POST['curr_date'],$_POST['class_id'],$_POST['attendence'],esc_html($attend_by),sanitize_text_field($_POST['status']),$attendance_type);







			if($result)



			{ 



				if(!empty($_POST['booking_status']))



				{



					if($_POST['booking_status'] == 'booking_status' &&  $_POST['status'] == 'Absent')



					{



						foreach($_POST['attendence'] as $member_id)



						{



							global $wpdb;		



							$table_booking_class = $wpdb->prefix. 'gmgt_booking_class';	



							



							$curr_date1= $_POST['curr_date'];



							$curr_date= MJ_gmgt_get_format_for_db($curr_date1);



							$class_id=$_POST['class_id'];



							



							$booking_list=$wpdb->get_results("SELECT * FROM $table_booking_class WHERE class_id='$class_id' AND member_id='$member_id' AND class_booking_date='$curr_date'");



							



							foreach($booking_list as $booking_list_data)



							{



								if(isset($booking_list))



								{



									$booking['id']=$booking_list_data->id;			



									$bookingdata['booking_status']='Absent';			



									$result=$wpdb->update( $table_booking_class, $bookingdata ,$booking);



								}



							}



						}



					}



				 }



			?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Attendance successfully saved!','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



			<?php



			}



		}



		else



		{



		?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Please select at least one member.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



			



		<?php



		}			



	}



	//SAVE STAFF Attendance DATA 



	if(isset($_REQUEST['save_staff_attendence']))



	{



		$attend_by=get_current_user_id();



		if(isset($_POST['attendence']))



		{



			



			$result=$obj_attend->MJ_gmgt_save_teacher_attendence(sanitize_text_field($_POST['tcurr_date']),$_POST['attendence'],esc_html($attend_by),sanitize_text_field($_POST['status']),'staff_member');



			if($result)



			{



				?>



				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



					<p><?php esc_html_e('Attendance added successfully.','gym_mgt');?></p>



					<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



				</div>



				<?php 



			}



		}



		else



		{



			?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Please select at least one staff member.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



			<?php



		}



	}



	//DELETE Attendance DATA



	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')



	{



		$result=$obj_product->MJ_gmgt_delete_product($_REQUEST['product_id']);



		if($result)



		{



			wp_redirect( admin_url().'admin.php?page=gmgt_product&tab=productlist&message=3');



		}



	}



	if(isset($_REQUEST['message']))



	{



		$message =esc_attr($_REQUEST['message']);



		if($message == 1)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Attendance added successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 2)



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e("Attendance updated successfully.",'gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php	



		}



		elseif($message == 3) 



		{?>



			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible ">



				<p><?php esc_html_e('Attendance deleted successfully.','gym_mgt');?></p>



				<button type="button" class="notice-dismiss" data-bs-dismiss="alert"><span class="screen-reader-text">Dismiss this notice.</span></button>



			</div>



		<?php		



		}



	}



	$past_attendance=get_option('gym_enable_past_attendance'); 



	?>



	<div class="attendance_list"><!-- MAIN WRAPPER DIV START-->



		<div class="row"><!-- ROW DIV START-->



			<div class="col-md-12"><!-- COL 12 DIV START-->



				<div class=""><!-- PANEL WHITE DIV START-->



					<div class=""><!-- PANEL BODY DIV START-->



						<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">



							<?php

							if($active_tab=='attendence_list' || $active_tab=='attendence' || $active_tab=='attendence_with_qr')

							{

								?>

								<li class="<?php if($active_tab=='attendence_list'){?>active<?php }?>">			



									<a href="?page=gmgt_attendence&tab=attendence_list" class="padding_left_0 tab <?php echo $active_tab == 'attendence_list' ? 'active' : ''; ?>">



									<?php esc_html_e('Member Attendance List', 'gym_mgt'); ?></a> 



								</li>



								<li class="<?php if($active_tab=='attendence'){?>active<?php }?>">			



									<a href="?page=gmgt_attendence&tab=attendence" class="padding_left_0 tab <?php echo $active_tab == 'attendence' ? 'active' : ''; ?>">



									<?php esc_html_e('Member Attendance', 'gym_mgt'); ?></a> 



								</li>



								<li class="<?php if($active_tab=='attendence_with_qr'){?>active<?php }?>">



									<a href="?page=gmgt_attendence&tab=attendence_with_qr" class="padding_left_0 tab <?php echo $active_tab == 'attendence_with_qr' ? 'active' : ''; ?>">



									<?php esc_html_e('Attendance With QR Code', 'gym_mgt'); ?></a> 



								</li>

								<?php

							} ?>

							<?php

							if($active_tab=='staff_attendence_list' || $active_tab=='staff_attendence')

							{

								?>

								<li class="<?php if($active_tab=='staff_attendence_list'){?>active<?php }?> res_margin_25px" >			



									<a href="?page=gmgt_attendence&tab=staff_attendence_list" class="padding_left_0 tab <?php echo $active_tab == 'staff_attendence_list' ? 'active' : ''; ?>">



									<?php esc_html_e('Staff Attendance List', 'gym_mgt'); ?></a> 



								</li>

								<li class="<?php if($active_tab=='staff_attendence'){?>active<?php }?>">



									<a href="?page=gmgt_attendence&tab=staff_attendence" class="padding_left_0 tab <?php echo $active_tab == 'staff_attendence' ? 'active' : ''; ?>">



									<?php esc_html_e('Staff  Attendance', 'gym_mgt'); ?></a> 



								</li>  

								<?php

							} ?>



							



						</ul>



						<?php 						



						if($active_tab == 'attendence')



						{



							?>



							<div class="panel-body attendence_penal_body"> <!-- PANEL BODY DIV START-->



								<form  name="member_attadence" id="member_attadence" method="post">  



									<input type="hidden" name="class_id" value="<?php if(isset($class_id))echo esc_attr($class_id);?>" />



									<div class="form-body user_form"> <!-- user_form Strat-->   



										<div class="row"><!--Row Div Strat--> 



											<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">



												<div class="form-group input">



													<div class="col-md-12 form-control">



														<?php



														if($past_attendance == "yes")



														{



															?>



															<input  class="form-control curr_date"  type="text" value="<?php if(isset($_POST['curr_date'])) echo $_POST['curr_date'];else echo  MJ_gmgt_getdate_in_input_box(date("Y-m-d"));?>" name="curr_date" readonly>



															<?php



														}



														else



														{



															?>



															<input  class="form-control"  type="text" value="<?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));?>" name="curr_date" readonly>



															<?php



														}



														?>



														<label class="" for="member_id"><?php esc_html_e('Date','gym_mgt');?></label>



													</div>



												</div>



											</div>



											<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 input">



												<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Class','gym_mgt');?><span class="require-field">*</span></label>



												<?php $class_id=0; if(isset($_POST['class_id'])){$class_id=sanitize_text_field($_POST['class_id']);}?>



												<select name="class_id"  id="class_id"  class="form-control validate[required]">



													<option value=" "><?php esc_html_e('Select class Name','gym_mgt');?></option>



													<?php



													$classdata=$obj_class->MJ_gmgt_get_all_classes();



													foreach($classdata as $class)



													{  



														?>



														<option  value="<?php echo esc_attr($class->class_id);?>" <?php selected($class->class_id,$class_id)?>><?php echo esc_html($class->class_name);?> ( <?php echo MJ_gmgt_timeremovecolonbefoream_pm($class->start_time).' - '.MJ_gmgt_timeremovecolonbefoream_pm($class->end_time);?>)</option>



													 	<?php 



													}



													?>



												</select>



											</div>



											<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 mb-3">



												<div class="form-group input">



													<input type="submit" value="<?php esc_html_e('Take/View  Attendance','gym_mgt');?>" name="attendence"  class="btn save_attendance_btn"/>



												</div>



											</div>



										</div>



									</div>



								</form>



							</div><!-- PANEL BODY DIV END-->



							<div class="clearfix"> </div>



							<?php 



							//SAVE Attendance DATA



							if(isset($_REQUEST['attendence']) || isset($_REQUEST['save_attendence']))



							{



								if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != " ")



								{



									$class_id =esc_attr($_REQUEST['class_id']);



								}



								else 



								{



									$class_id = 0;



								}



								if($class_id == 0)



								{



									?>



									<div class="panel-heading">



									   	<h4 class="panel-title panel-title-color"><?php esc_html_e('Please select any one class.','gym_mgt');?></h4> 



									</div>



									<?php 



								}



								else



								{



									$membersdata= array();



									$MemberClassData = MJ_gmgt_get_member_by_class_id(esc_attr($_REQUEST['class_id']));



									foreach($MemberClassData as $key=>$value)



									{



										$members= get_userdata($value->member_id);



										if($members!=false)



										{



											$role= $members->roles;					



											if($role[0]!='staff_member')



											{



												$membersdata[]=$members;						



											}



										}															 



									}



									?>									



							    	<div class="">  <!-- PANEL BODY DIV START-->



										<?php



										if(!empty($membersdata))



										{



											?>



											<form method="post"  class="form-horizontal">  



												<input type="hidden" name="class_id" value="<?php echo esc_attr($class_id);?>" />



												<input type="hidden" name="curr_date" value="<?php if(isset($_POST['curr_date'])) echo esc_attr($_POST['curr_date']); else echo  date("Y-m-d");?>" />







												<div class="panel-heading">



													<h4 class="panel-title">  <?php esc_html_e('Class','gym_mgt')?>: <?php echo esc_html($class_name=$obj_class->MJ_gmgt_get_class_name($class_id));?> , <?php esc_html_e('Date','gym_mgt')?> : <?php echo MJ_gmgt_getdate_in_input_box(MJ_gmgt_get_format_for_db($_POST['curr_date']));?></h4>



												</div>



												



												<?php



												if($past_attendance == "yes")



												{ 



													?>



													<div class="form-group m-3" >



														<label class="radio-inline">



															<input type="radio" name="status" value="Present" checked="checked" class="Present_hide"/> <?php esc_html_e('Present','gym_mgt');?>



														</label>



														&nbsp;



														<label class="radio-inline">



															<input type="radio" name="status" value="Absent" class="Absent_show"/> <?php esc_html_e('Absent','gym_mgt');?><br />



														</label>



														<label class="radio-inline status_div_absent display_none">



															<h4>



																<input type="checkbox" name="booking_status" value="booking_status"> <?php _e('Do you want to credit class for a selected member ?','gym_mgt');?>



															</h4>



														</label>



													</div> 



													<?php 



												}



												else



												{



													$curr_date=MJ_gmgt_get_format_for_db($_POST['curr_date']);



													if($curr_date == date("Y-m-d"))



													{ 



														?> 



														<div class="form-group m-3">



															<label class="radio-inline">



																<input type="radio" name="status" value="Present" checked="checked" class="Present_hide"/> <?php esc_html_e('Present','gym_mgt');?>



															</label>



															&nbsp;



															<label class="radio-inline">



																<input type="radio" name="status" value="Absent" class="Absent_show" /> <?php esc_html_e('Absent','gym_mgt');?><br />



															</label>



															<label class="radio-inline status_div_absent display_none">



																<h4>



																	<input type="checkbox" name="booking_status" value="booking_status"> <?php _e('Do you want to credit class for a selected member ?','gym_mgt');?>



																</h4>



															</label>



														</div>



														<?php 



													}



												}



												?>										



												<div class="col-md-12 atendance_div_res">



													<table class="table">



														<tr>



															<?php



															if($past_attendance == "yes")



															{ ?>



																<th id="width_46px"><input type="checkbox" name="selectall" class="checkAll" id="selectall"/></th>



																<?php 



															}



															else



															{



																if($curr_date == date("Y-m-d"))



																{ ?>



																<th class="table_heading_font_family" id="width_46px"><input type="checkbox" name="selectall" class="checkAll" id="selectall"/></th>



																<?php



																}



																



															} ?>



																<th class="table_heading_font_family" id="width_250px"><?php esc_html_e('Member Name','gym_mgt');?></th>



																<?php



															if($past_attendance == "yes")



															{?>



																<th class="table_heading_font_family" width="250px"><?php esc_html_e('Status','gym_mgt');?></th>



																<?php



															}



															else



															{



																if($curr_date == date("Y-m-d"))



																{?>



																	<th class="table_heading_font_family" id="width_250px"><?php esc_html_e('Status','gym_mgt');?></th>



																<?php 



																} 



																else



																{



																	?>



																	<th class="table_heading_font_family" id="width_70px"><?php esc_html_e('Status','gym_mgt');?></th>



																	<?php 



																}



															}?>



																<th class="table_heading_font_family" id="width_70px"><?php esc_html_e('Class Name','gym_mgt');?></th>



														</tr>



														<?php													



														foreach ( $membersdata as $user ) 



														{



															// if( $user->membership_status == "Continue"  && $user->member_type == "Member")



															// {	



																$date = $_POST['curr_date'];



																$date=MJ_gmgt_get_format_for_db($date);



																if(isset($user->ID))



																{



																	$check_result=$obj_attend->MJ_gmgt_check_attendence($user->ID,$class_id,$date);



																	echo '<tr class="gmgt_att_tbl_list ">';



																		if($past_attendance == "yes")



																		{ ?>



																			<td class="checkbox_field">



																				<span><input type="checkbox" class="checkbox1" name="attendence[]" value="<?php echo esc_attr($user->ID); ?>" <?php if($check_result == 'true'){ echo "checked=\'checked\'"; } ?> />



																				</span>



																			</td>



																			<?php 



																		}



																		else



																		{



																			if($curr_date == date("Y-m-d"))



																			{ ?> 



																				<td class="checkbox_field">



																					<span><input type="checkbox" class="checkbox1" name="attendence[]" value="<?php echo esc_attr($user->ID); ?>" <?php if($check_result == 'true'){ echo "checked=\'checked\'"; } ?> />



																					</span>



																				</td>



																				<?php 



																			}



																			



																		}



																		echo '<td><span>' .MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($user->ID)).'</span></td>';



																		if($past_attendance == "yes")



																		{



																			if(!empty($check_result))



																				{ 



																					echo '<td><span>' .esc_html($check_result->status).'</span></td>';



																				}



																				else



																				{							



																					echo '<td>&nbsp;</td>';



																				}



																		}



																		else



																		{



																			if($curr_date == date("Y-m-d"))



																			{



																				if(!empty($check_result))



																				{ 



																					// echo '<td><span>' .esc_html($check_result->status).'</span></td>';



																					if($check_result->status == "Absent")



																					{



																					echo '<td><span>' .esc_html__('Absent','gym_mgt').'</span></td>';



																					}



																					else



																					{



																						echo '<td><span>' .esc_html__('Present','gym_mgt').'</span></td>';



																					}



																				}



																				else



																				{							



																					echo '<td>N/A</td>';



																				}



																			}



																			else 



																			{



																				?>



																				<!-- <td>



																					<?php if($check_result=='true') esc_html_e('Present','gym_mgt'); else esc_html_e('Absent','gym_mgt');?>



																				</td> -->



																				<?php 



																				



																				if(!empty($check_result))



																				{ 



																					// echo '<td><span>' .esc_html($check_result->status).'</span></td>';



																					if($check_result->status == "Absent")



																					{



																					echo '<td><span>' .esc_html__('Absent','gym_mgt').'</span></td>';



																					}



																					else



																					{



																						echo '<td><span>' .esc_html__('Present','gym_mgt').'</span></td>';



																					}



																				}



																				else



																				{							



																					echo '<td>N/A</td>';



																				}



																				



																			}



																		}



																		echo '<td>';



																			echo esc_html($class_name=$obj_class->MJ_gmgt_get_class_name($class_id));



																		echo '</td>';



																	echo '</tr>';



																// } 



															} 



														}?> 



													</table>



												</div>



												<?php 



												if($user_access_add == '1')



												{ ?>



													<div class="col-sm-3 margin_top_10"> 



														<?php 



														if($past_attendance == "yes")



														{ 



															?>



															<input type="submit" value="<?php esc_html_e('Save Attendance','gym_mgt');?>" name="save_attendence" class="btn save_attendance_btn" />



															<?php 



														}



														else



														{



															if($curr_date == date("Y-m-d"))



															{



																?>       	



																<input type="submit" value="<?php esc_html_e('Save Attendance','gym_mgt');?>" name="save_attendence" class="btn save_attendance_btn" />



																<?php 



															}



														}



														?>



													</div>



													<?php 



												} ?>



											</form>	



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



									</div><!-- PANEL BODY DIV END-->



									<?php 



								}



							}



						} 



						if($active_tab == 'attendence_list')

						{

							?>

							<script type="text/javascript">



								$(document).ready(function() 



								{



									"use strict";	



									$(".display-members").select2();



									$('.sdate').datepicker({maxDate : 0,dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 



									$('.edate').datepicker({maxDate : 0,dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 



								} );



							</script>

						

							<form method="post" id="attendance_list" class="attendance_list">  

								<div class="form-body user_form margin_top_15px">

									<div class="row">

										<div class="col-md-3 mb-3 input">

											<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

												<select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

													<!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->

													<option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

													<option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

													<option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

													<option value="this_month" 	selected><?php esc_attr_e('This Month','gym_mgt');?></option>

													<option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

													<option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

													<option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

													<option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

													<option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

													<option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

													<option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

												</select>

										</div>



										<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



											<!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



											<!-- <?php if($edit){ $member_id=$result->member_id; }elseif(isset($_REQUEST['member_id'])){$member_id=sanitize_text_field($_REQUEST['member_id']);}else{$member_id='';}?> -->



											<select id="member_list" class="form-control display-members" name="member_id">



												<option value="all_member"><?php esc_html_e('All Member','gym_mgt');?></option>



													<?php $get_members = array('role' => 'member');



													$membersdata=get_users($get_members);



													if(!empty($membersdata))

													{

														foreach ($membersdata as $member)

														{

															if( $member->membership_status == "Continue"  && $member->member_type == "Member")

															{		

																?>

																<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID)); ?> </option>

																<?php		

															}

														}

													}?>

											</select>



										</div>

										<div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	

										<div class="col-md-3 mb-2">

											<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

										</div>

									</div>

								</div>

							</form> 



							<div class="clearfix"></div>



							<?php



							//  DATA







							if(isset($_REQUEST['view_attendance']))



							{



								// global $wpdb;



								// $start_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['sdate']));



								// $end_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['edate']));



								// $attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date);



								$date_type = $_POST['date_type'];

								if($date_type=="period")

								{

									$start_date = $_REQUEST['start_date'];

									$end_date = $_REQUEST['end_date'];



									$type='member';

									$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

									

								}

								else

								{

									$result =  mj_gmgt_all_date_type_value($date_type);

							

									$response =  json_decode($result);

									$start_date = $response[0];

									$end_date = $response[1];

									

									if(!empty($_REQUEST['member_id'])  && $_REQUEST['member_id'] != "all_member")

									{

										$member_id = $_REQUEST['member_id'];

										$attendence_data=MJ_gmgt_get_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date,$member_id);

									}else{

										$type='member';

										$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

									}

								}

							}else{

								$start_date = date('Y-m-d',strtotime('first day of this month'));



								$end_date = date('Y-m-d',strtotime('last day of this month'));



								$type='member';

								$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

								

							}



							if($start_date > $end_date )



							{



							echo '<script type="text/javascript">alert("'.esc_html__('End Date should be greater than the Start Date','gym_mgt').'");</script>';



							}



							if(!empty($attendence_data))



							{



								?>



								

								<script type="text/javascript">



									$(document).ready(function() 



									{



										"use strict";



										var table = jQuery('#attend_list').DataTable({



											// "responsive": true,



											"order": [[ 3, "desc" ]],



											dom: 'lifrtp',



											buttons:[

												{

													extend: 'csv',

													text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

													title: 'Attendance Report',

													exportOptions: {

														columns: [1, 2, 3,4,5,6], // Only name, email and role

													},

													charset: 'UTF-8',

													bom: true,

												},

												{

													extend: 'print',

													text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

													title: 'Attendance Report',

													exportOptions: {

														columns: [1, 2, 3,4,5,6], // Only name, email and role

													}

												},

											],



											"aoColumns":[



													{"bSortable": false},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true},



													{"bSortable": true}



												],



											language:<?php echo MJ_gmgt_datatable_multi_language();?>		   



										});

										$('.btn-place').html(table.buttons().container()); 

										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



									} );



								</script>







								<div class="table-div"><!-- PANEL BODY DIV START -->



									<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->

										<div class="btn-place"></div>	

										<table id="attend_list" class="display" cellspacing="0" width="100%">

											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

												<tr>

													<th><?php esc_html_e('Photo','gym_mgt');?></th>

													<th><?php esc_html_e('Member Name','gym_mgt');?></th>

													<th><?php esc_html_e('Class Name','gym_mgt');?></th>

													<th><?php esc_html_e('Date','gym_mgt');?></th>

													<th><?php esc_html_e('Day','gym_mgt');?></th>

													<th><?php esc_html_e('Attendance Status','gym_mgt');?></th>

													<th><?php esc_html_e('Attendance With QR','gym_mgt');?></th>

												</tr>

											</thead>

											<tbody>



												<?php



												$i=0;	



												if(!empty($attendence_data))



												{

													



													foreach ($attendence_data as $retrieved_data)



													{



														if(isset($retrieved_data->class_id) && $retrieved_data->class_id)

														{

															$member_data = get_userdata($retrieved_data->user_id);

															if(!empty($member_data->parent_id))

															{

																$parent_data = get_userdata($member_data->parent_id);

															}



															if($i == 10)



															{



																$i=0;



															}



															if($i == 0)



															{



																$color_class='smgt_class_color0';



															}



															elseif($i == 1)



															{



																$color_class='smgt_class_color1';







															}



															elseif($i == 2)



															{



																$color_class='smgt_class_color2';







															}



															elseif($i == 3)



															{



																$color_class='smgt_class_color3';







															}



															elseif($i == 4)



															{



																$color_class='smgt_class_color4';







															}



															elseif($i == 5)



															{



																$color_class='smgt_class_color5';







															}



															elseif($i == 6)



															{



																$color_class='smgt_class_color6';







															}



															elseif($i == 7)



															{



																$color_class='smgt_class_color7';







															}



															elseif($i == 8)



															{



																$color_class='smgt_class_color8';







															}



															elseif($i == 9)



															{



																$color_class='smgt_class_color9';







															}



															?>



															<tr>



																<td class="cursor_pointer user_image width_50px profile_image_prescription padding_left_0">



																	<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	



																		<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center" style="padding-top:12px;">



																	</p>



																</td>



																<td class="name">

																		

																	<?php

																	

												

																		echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->user_id)); 

																	



																		?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



																</td>

																<td class="name">



																	<?php echo MJ_gmgt_get_class_name($retrieved_data->class_id); ?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>



																</td>



																<td class="name">



																	<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->attendence_date); ?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>



																</td>



																<td class="name">



																	<?php 



																		$day=date("D", strtotime($retrieved_data->attendence_date));



																		echo esc_html__($day,"gym_mgt");



																	?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>



																</td>



																<td class="name">



																	<?php echo esc_html__($retrieved_data->status,"gym_mgt"); ?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance Status','gym_mgt');?>" ></i>



																</td>

																<td class="name">



																	<?php if($retrieved_data->attendance_type == 'QR') { echo _e('Yes','gym_mgt');}elseif($retrieved_data->attendance_type == 'web' || $retrieved_data->attendance_type == NULL){ echo esc_html__('No',"gym_mgt"); }?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance With QR','gym_mgt');?>" ></i>



																</td>





															</tr>



															<?php 

														}



														$i++;



													}



												}



												?>



											</tbody>



										</table>



									</div><!-- TABLE RESPONSIVE DIV END -->



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

						if($active_tab == 'staff_attendence_list')

						{

							?>

							<script type="text/javascript">



								$(document).ready(function() 



								{



									"use strict";



									$(".display-members").select2();	



									$('.sdate').datepicker({maxDate : 0,dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 



									$('.edate').datepicker({maxDate : 0,dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>'}); 



								} );



							</script>

						

							<form method="post" id="attendance_list" class="attendance_list">  

								<div class="form-body user_form margin_top_15px">

									<div class="row">

										<div class="col-md-3 mb-3 input">

											<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

												<select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

													<!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->

													<option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

													<option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

													<option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

													<option value="this_month" selected	><?php esc_attr_e('This Month','gym_mgt');?></option>

													<option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

													<option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

													<option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

													<option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

													<option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

													<option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

													<option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

												</select>

										</div>



										<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



											

											<select id="member_list" class="form-control display-members" name="staff_id">



												<option value="all_staff_member"><?php  esc_html_e('All Staff Member','gym_mgt');?></option>



												<?php $get_staff = array('role' => 'Staff_member');



												$staffdata=get_users($get_staff);



												



												if($edit)



												{



													$staff_data=$user_info->staff_id;



												}



												elseif(isset($_POST['staff_id']))



												{



													$staff_data=sanitize_text_field($_POST['staff_id']);



												}



												else



												{



													$staff_data="";



												}



												if(!empty($staffdata))



												{



													foreach($staffdata as $staff)



													{



														



														echo '<option value='.esc_attr($staff->ID).' '.selected(esc_html($staff_data),$staff->ID).'>'.MJ_gmgt_get_user_full_display_name(esc_html($staff->ID)).'</option>';



													}



												}



												?>

											</select>



										</div>

										<div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	

										<div class="col-md-3 mb-2">

											<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

										</div>

									</div>

								</div>

							</form> 



							<div class="clearfix"></div>

							<?php

							if(isset($_REQUEST['view_attendance']))

							{



								$date_type = $_POST['date_type'];

								if($date_type=="period")

								{

									$start_date = $_REQUEST['start_date'];

									$end_date = $_REQUEST['end_date'];



									$type='staff_member';

									$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

									

								}

								else

								{

									$result =  mj_gmgt_all_date_type_value($date_type);

							

									$response =  json_decode($result);

									$start_date = $response[0];

									$end_date = $response[1];

									

									if(!empty($_REQUEST['staff_id'])  && $_REQUEST['staff_id'] != "all_staff_member")

									{

										$staff_id = $_REQUEST['staff_id'];

										$attendence_data=MJ_gmgt_get_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date,$staff_id);

									}else{

										// $attendence_data=MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate_for_admin($start_date,$end_date);

										$type='staff_member';

										$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

									}

								}

							}else{

								$start_date = date('Y-m-d',strtotime('first day of this month'));



								$end_date = date('Y-m-d',strtotime('last day of this month'));



								$type='staff_member';

								$attendence_data = MJ_gmgt_get_all_member_attendence_beetween_satrt_date_to_enddate($start_date,$end_date,$type);

								

							}

							

							if($start_date > $end_date )



							{



							echo '<script type="text/javascript">alert("'.esc_html__('End Date should be greater than the Start Date','gym_mgt').'");</script>';



							}



							if(!empty($attendence_data))



							{

								

								?>



								

								<script type="text/javascript">



									$(document).ready(function() 



									{



										"use strict";



										var table = jQuery('#attend_list').DataTable({



											// "responsive": true,



											"order": [[ 3, "desc" ]],



											dom: 'lifrtp',

										

											buttons:[

												{

													extend: 'csv',

													text:'<?php esc_html_e('CSV', 'gym_mgt') ?>',

													title: 'Staff Member Attendance Report',

													exportOptions: {

														columns: [1, 2, 3,4], // Only name, email and role

													},

													charset: 'UTF-8',

													bom: true,

													

												},

												{

													extend: 'print',

													text:'<?php esc_html_e('Print', 'gym_mgt') ?>',

													title: 'Staff Member Attendance Report',

													exportOptions: {

														columns: [1, 2, 3,4], // Only name, email and role

													}

												},

											],



											"aoColumns":[



													{"bSortable": false},



													{"bSortable": true},



													{"bSortable": true},

												

													{"bSortable": true},



													{"bSortable": true}



												],



											language:<?php echo MJ_gmgt_datatable_multi_language();?>		   



										});

										$('.btn-place').html(table.buttons().container()); 

										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



									} );



								</script>







								<div class="table-div"><!-- PANEL BODY DIV START -->



									<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->

										<div class="btn-place"></div>	

										<table id="attend_list" class="display" cellspacing="0" width="100%">

											<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

												<tr>

													<th><?php esc_html_e('Photo','gym_mgt');?></th>

													<th><?php esc_html_e('Staff Member Name','gym_mgt');?></th>

													<th><?php esc_html_e('Date','gym_mgt');?></th>

													<th><?php esc_html_e('Day','gym_mgt');?></th>

													<th><?php esc_html_e('Attendance Status','gym_mgt');?></th>

												</tr>

											</thead>

											<tbody>



												<?php



												$i=0;	



												if(!empty($attendence_data))



												{

													



													foreach ($attendence_data as $retrieved_data)



													{



														

															$member_data = get_userdata($retrieved_data->user_id);

															if(!empty($member_data->parent_id))

															{

																$parent_data = get_userdata($member_data->parent_id);

															}



															if($i == 10)



															{



																$i=0;



															}



															if($i == 0)



															{



																$color_class='smgt_class_color0';



															}



															elseif($i == 1)



															{



																$color_class='smgt_class_color1';







															}



															elseif($i == 2)



															{



																$color_class='smgt_class_color2';







															}



															elseif($i == 3)



															{



																$color_class='smgt_class_color3';







															}



															elseif($i == 4)



															{



																$color_class='smgt_class_color4';







															}



															elseif($i == 5)



															{



																$color_class='smgt_class_color5';







															}



															elseif($i == 6)



															{



																$color_class='smgt_class_color6';







															}



															elseif($i == 7)



															{



																$color_class='smgt_class_color7';







															}



															elseif($i == 8)



															{



																$color_class='smgt_class_color8';







															}



															elseif($i == 9)



															{



																$color_class='smgt_class_color9';







															}



															?>



															<tr>



																<td class="cursor_pointer user_image width_50px profile_image_prescription padding_left_0">



																	<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	



																		<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center" style="padding-top:12px;">



																	</p>



																</td>



																<td class="name">

																		

																	<?php

																	

																		echo MJ_gmgt_get_user_full_display_name(esc_html($retrieved_data->user_id)); 

																	

																		?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Member Name','gym_mgt');?>" ></i>



																</td>



																<td class="name">



																	<?php echo MJ_gmgt_getdate_in_input_box($retrieved_data->attendence_date); ?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>



																</td>



																<td class="name">



																	<?php 



																		$day=date("D", strtotime($retrieved_data->attendence_date));



																		echo esc_html__($day,"gym_mgt");



																	?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>



																</td>



																<td class="name">



																	<?php echo esc_html__($retrieved_data->status,"gym_mgt"); ?>



																	<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Attendance Status','gym_mgt');?>" ></i>



																</td>

															</tr>



															<?php 

														



														$i++;



													}



												}



												?>



											</tbody>



										</table>



									</div><!-- TABLE RESPONSIVE DIV END -->



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

						if($active_tab == 'staff_attendence')



						{ 



							require_once GMS_PLUGIN_DIR. '/admin/attendence/staff-attendence.php';



						}



						if($active_tab == 'attendence_with_qr')



						{ 



							require_once GMS_PLUGIN_DIR. '/admin/attendence/attendence_qr.php';



						}



						?>



                    </div><!-- PANEL BODY DIV END-->



	            </div><!-- PNEL WHITE DIV END-->



	        </div><!-- COL 12 DIV END-->



        </div><!-- ROW DIV END-->



    </div><!-- MAIN WRAPPER DIV START-->



</div><!-- PAGE INNNER DIV END-->