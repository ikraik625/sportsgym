<?php 



$class_id =0;



?>



<script type="text/javascript">



	$(document).ready(function() 



	{



		"use strict";



		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



		$('#product_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});



		$('.curr_date').datepicker(



		{



			dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



			endDate: '+0d',



			maxDate:'today',



			autoclose: true



		});	



		$('.checkAll').on('change',function()



		{



			var state = this.checked;



			state? $(':checkbox').prop('checked',true):$(':checkbox').prop('checked',false);



			state? $(this).next('b').text('Uncheck All') :$(this).next('b').text('Check All')



		});



	} );



</script>



<?php



if($active_tab == 'staff_attendence') 



{

	$past_attendance=get_option('gym_enable_past_attendance');

	?>



	<style>



		#your-profile label+a, label 



		{



			vertical-align: unset !important;



		}



	</style>



	<div class="panel-body attendence_penal_body"><!-- PANEL BODY DIV START-->



		<form method="post"> 



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



						<div class="form-group input">



							<div class="col-md-12 form-control">

							<?php



								if($past_attendance == "yes")



								{



							?>

								<input class="form-control curr_date" type="text"  value="<?php if(isset($_POST['tcurr_date'])) echo esc_attr($_POST['tcurr_date']);else echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));;?>" name="tcurr_date" readonly>

								<?php

								}

								else

								{

									?>

								<input class="form-control" type="text"  value="<?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));;?>" name="tcurr_date" readonly>

								<?php

								}

								?>

								<label class="" for="member_id"><?php esc_html_e('Date','gym_mgt');?></label>



							</div>



						</div>



					</div>   



					<?php wp_nonce_field( 'staff_attendence_nonce' ); ?>



					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 mb-3">



						<input type="submit" value="<?php esc_html_e('Take/View  Attendance','gym_mgt');?>" name="staff_attendence"  class="btn save_btn"/>



					</div>



				</div>    



			</div>



		 </form>



	</div> <!-- PANEL BODY DIV END-->



	<div class="clearfix"> </div>		  



	<?php 



	if(isset($_REQUEST['staff_attendence']) || isset($_REQUEST['save_staff_attendence']))



	{



	  	$past_attendance=get_option('gym_enable_past_attendance'); ?>



			<div class="hight_auto_res_div test_res"> <!-- PANEL BODY DIV START--> 



				<form method="post"> 



					<input type="hidden" name="class_id" value="<?php echo esc_attr($class_id);?>" />



					<input type="hidden" name="tcurr_date" value="<?php echo esc_attr($_POST['tcurr_date']);?>" />



					<div class="panel-heading">



						<h4 class="panel-title"><?php esc_html_e('Staff Attendance','gym_mgt');?> , 



						<?php esc_html_e('Date')?> :  <?php echo MJ_gmgt_getdate_in_input_box(MJ_gmgt_get_format_for_db(sanitize_text_field($_POST['tcurr_date'])));?></h4>



					</div>



					<?php



						$date=MJ_gmgt_get_format_for_db(sanitize_text_field($_POST['tcurr_date']));



						$i=1;



						$teacher = get_users(array('role'=>'staff_member'));



						if($past_attendance == "yes")



						{ ?>



							<div class="form-group m-3">



								<label class="radio-inline">



									<input type="radio" name="status" value="Present" checked="checked" class="marign_left_0_res"/> <?php esc_html_e('Present','gym_mgt');?>



								</label>



								&nbsp;



								<label class="radio-inline">



									<input type="radio" name="status" value="Absent" class="marign_left_0_res"/> <?php esc_html_e('Absent','gym_mgt');?><br />



								</label>



							</div>



							<?php



						}



						else



						{



							if($date == date("Y-m-d"))



							{ 



								?> 



								<div class="form-group m-3">



									<label class="radio-inline">



										<input type="radio" name="status" value="Present" checked="checked" class="marign_left_0_res"/> <?php esc_html_e('Present','gym_mgt');?>



									</label>



									&nbsp;



									<label class="radio-inline">



										<input type="radio" name="status" value="Absent" class="marign_left_0_res" /> <?php esc_html_e('Absent','gym_mgt');?><br />



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



										<th id="width_50px"><input type="checkbox" name="selectall" class="checkAll" id="selectall"/></th>



										<?php 



									}



									else



									{



										if($date == date("Y-m-d"))



										{ ?> 



											<th class="table_heading_font_family" id="width_50px"><input type="checkbox" name="selectall" class="checkAll" id="selectall"/></th>



											<?php



										}	



										



									}



									?>



										<th class="table_heading_font_family" id="width_250px"><?php esc_html_e('Staff Member Name','gym_mgt');?></th>



									<?php



									if($past_attendance == "yes")



									{ ?>



										<th class="table_heading_font_family" id=""><?php esc_html_e('Status','gym_mgt');?>



										</th>



									<?php



									}



									else



									{



										if($date == date("Y-m-d"))



										{?> 



											<th class="table_heading_font_family" id=""><?php esc_html_e('Status','gym_mgt');?>



											</th>



										<?php



										}



										else 



										{



											?>



											<th class="table_heading_font_family" id=""><?php esc_html_e('Status','gym_mgt');?></th>



											<?php 



										}



										



									}?>



								</tr>



								<?php



								$teacher = get_users(array('role'=>'staff_member'));



								$date=MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['tcurr_date']));



								foreach ( $teacher as $user )



								{



									$date=MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['tcurr_date']));



									$check_result=$obj_attend->MJ_gmgt_check_staff_attendence($user->ID,$date);



									echo '<tr class="gmgt_att_tbl_list ">';



									if($past_attendance == "yes")



									{ 



										?>



										<td class="checkbox_field">



											<span><input type="checkbox" class="checkbox1" name="attendence[]" value="<?php echo esc_attr($user->ID); ?>" 



											<?php if($check_result=='true'){ echo "checked=\'checked\'"; } ?> /></span>



										</td>



										<?php



									}



									else



									{



										if($date== date("Y-m-d"))



										{



											?> 



											<td class="checkbox_field">



												<span><input type="checkbox" class="checkbox1" name="attendence[]" value="<?php echo esc_attr($user->ID); ?>" <?php if($check_result=='true'){ echo "checked=\'checked\'"; } ?> /></span>



											</td>



											<?php



										}



										



									}



									echo '<td><span>' .MJ_gmgt_get_user_full_display_name(esc_html($user->ID)).'</span></td>';



										if(!empty($check_result))



										{ 



											echo '<td><span>' .esc_html__($check_result->status,"gym_mgt").'</span></td>';



										}



										else 



										{



											?>



											<!-- <td><?php if($check_result=='true') esc_html_e('Present','gym_mgt'); else esc_html_e('Absent','gym_mgt');?></td> -->



											<td><?php if($check_result=='true') esc_html_e('Present','gym_mgt'); else echo 'N/A';?></td>



											<?php 



										}



									echo '</tr>';



								}?>



							</table>



						</div>



						<div class="cleatrfix"></div>



						<?php



						if($user_access_add == '1')



						{ ?>



							<div class="col-sm-3 margin_top_10">    



							<?php



							if($past_attendance == "yes")



							{ ?>



								<input type="submit" value="<?php esc_html_e('Save Attendance','gym_mgt');?>" name="save_staff_attendence" class="btn save_btn" />



							<?php 



							}



							else



							{



							if($date == date("Y-m-d")){?>       	    	



							<input type="submit" value="<?php esc_html_e('Save Attendance','gym_mgt');?>" name="save_staff_attendence" class="btn save_btn" />



							<?php }



							}?>



						</div>



						<?php



						}



						?>



				</form>



			</div> <!-- PANEL BODY DIV END-->



		<?php



	}



}?>