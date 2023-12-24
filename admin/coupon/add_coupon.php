<?php



if($active_tab == 'add_coupon')



{	



	$edit=0;



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$coupon_id=esc_attr($_REQUEST['id']);



		$edit=1;



		$result = $obj_coupon->MJ_gmgt_get_single_coupondata($coupon_id);



	}



?>



<script>



$(document).ready(function() 



{







	"use strict";







	$('#coupon_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});







	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);







	var date = new Date();







	date.setDate(date.getDate()-0);







	$('.from_date').datepicker({







		<?php







		if(get_option('gym_enable_datepicker_privious_date')=='no')



		{



		?>



			minDate:'today',







			startDate: date,



		<?php



		}



		?>



	dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',







	autoclose: true







	});



	$(".display-members").select2();



	<?php



	if($edit && $result->coupon_type == "individual"){



	?>



		$(".coupon_member").css("display", "block");



	<?php



	}



	?>







});



</script>















<div class="panel-body padding_0">







	<form name="coupon_form" action="" method="post" class="form-horizontal" id="coupon_form">



	



		<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>







		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



		



		<input type="hidden" name="coupon_id" class="" value="<?php echo esc_attr($coupon_id);?>"  />



		



		<div class="header">	







			<h3 class="first_hed"><?php esc_html_e('Coupon Information','gym_mgt');?></h3>







		</div>



		



		<div class="form-body user_form">



		



			<div class="row">



			



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">







					<div class="form-group">







						<div class="col-md-12 form-control">







							<div class="row padding_radio">







								<div class="input-group">







									<label class="custom-top-label" for="coupon_type"><?php esc_html_e('Coupon For','gym_mgt');?><span class="require-field">*</span></label>







									<div class="d-inline-block gender_line_height_24px">



										



										<?php $limitval = "all_member"; if($edit){ $limitval=$result->coupon_type; }elseif(isset($_POST['coupon_for'])) {$limitval=sanitize_text_field($_POST['coupon_for']);}?>







										<label class="radio-inline custom_radio">







											<input type="radio" id="all_member" value="all_member" class="tog coupon_type" name="coupon_for" <?php checked('all_member',esc_html($limitval)); ?>/><?php esc_html_e('All Member','gym_mgt');?>







										</label>







										<label class="radio-inline custom_radio margin_right_5px">







											<input type="radio" id="individual" value="individual" class="tog coupon_type" name="coupon_for" <?php checked('individual',esc_html($limitval)); ?>/><?php esc_html_e('Individual','gym_mgt');?>







										</label>







									</div>







								</div>







							</div>		







						</div>







					</div>







				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 coupon_member res_margin_bottom_20px rtl_margin_top_15px">



				



					<select id="coupon_member_list" class="display-members form-control member-select2" name="member_id">







						<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>







							<?php $get_members = array('role' => 'member');







							$membersdata=get_users($get_members);



							if($edit){



								$member_id = $result->member_id;



							}



							else{



								$member_id = '';



							}



							if(!empty($membersdata))







							{







								foreach ($membersdata as $member)







								{?>







									<option value="<?php echo esc_attr($member->ID);?>" <?php selected($member_id,$member->ID);?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>







								<?php







								}







							}?>







					</select>







				</div>



					



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					



					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="coupon_code" class="form-control validate[required] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo $result->code;} ?>" name="coupon_code" placeholder="Eg. SALE50OFF">







							<label class="" for="coupon_code"><?php esc_html_e('Coupon Code','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>



					



				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">







					<div class="form-group">







						<div class="col-md-12 form-control">







							<div class="row padding_radio">







								<div class="input-group">







									<label class="custom-top-label" for="publish"><?php esc_html_e('Recurring Type','gym_mgt');?><span class="require-field">*</span></label>







									<div class="d-inline-block gender_line_height_24px">



										



										<?php $limitval = "onetime"; if($edit){ $limitval=$result->recurring_type; }elseif(isset($_POST['recurring_type'])) {$limitval=sanitize_text_field($_POST['recurring_type']);}?>







										<label class="radio-inline custom_radio">







											<input type="radio" value="onetime" class="tog" name="recurring_type" <?php checked('onetime',esc_html($limitval)); ?>/><?php esc_html_e('Onetime','gym_mgt');?>







										</label>







										<label class="radio-inline custom_radio margin_right_5px">







											<input type="radio" value="recurring" class="tog" name="recurring_type" <?php checked('recurring',esc_html($limitval)); ?>/><?php esc_html_e('Recurring','gym_mgt');?>







										</label>







									</div>







								</div>







							</div>		







						</div>







					</div>







				</div>



				



				<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">







						<!--<label class="col-sm-2 control-label form-label" for=""><?php esc_html_e('Membership','gym_mgt');?></label> -->







						<select  class="form-control validate[required]" name="membership">



							<option value="all_membership"><?php esc_html_e('All Membership','gym_mgt');?></option>



							<?php











							$obj_membership=new MJ_gmgt_membership;







						$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();



						



							if(!empty($membershipdata))







							{







								foreach ($membershipdata as $membership)







								{



									



									echo '<option value='.esc_attr($membership->membership_id).' '.selected(esc_attr($result->membership),esc_attr($membership->membership_id)).'>'.esc_html($membership->membership_label).'</option>';



								



								}







							}







							?>







						</select>







					</div>



				



				<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">



					



					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="discount" class="form-control text-input validate[required]" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php if($edit){echo $result->discount;} ?>" name="discount" placeholder="">







							<label class="" for="discount"><?php esc_html_e('Discount','gym_mgt');?><span class="require-field">*</span></label>







						</div>







					</div>



					



				</div>



				



				<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 res_margin_bottom_20px rtl_margin_top_15px">







					<select class="form-control max_width_100" name="discount_type" id="discount_type">







						<option value="%" <?php  if($edit) if(isset($result->discount_type)) selected(esc_attr($result->discount_type),'%'); ?>>%</option>	



						



						<option value="amount" <?php  if($edit) if(isset($result->discount_type)) selected(esc_html($result->discount_type),'amount'); ?>><?php echo esc_html__('Amount','gym_mgt').'('.MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).')';?></option>



					</select>



					



				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



					



					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="times" class="form-control validate[required] text-input"  maxlength="50" type="number" value="<?php if($edit){ echo $result->time;}else{ echo'1';}?>" name="time" >







							<label class="" for="times"><?php esc_html_e('Times','gym_mgt');?><span class="require-field">*</span></label>







						</div>





						 



					</div>



					



				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="from_date"  class="form-control from_date validate[required] date_picker" type="text" value="<?php if($edit){ echo MJ_gmgt_getdate_in_input_box($result->from_date);}else{echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));} ?>" name="from_date">







							<label class="date_label" for="from_date"><?php esc_html_e('Valid From Date','gym_mgt');?><span class="require-field">*</span></label>                                  







						</div>







					</div>







				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">







					<div class="form-group input">







						<div class="col-md-12 form-control">







							<input id="end_date" class="form-control from_date validate[required] date_picker" type="text" value="<?php if($edit){ echo MJ_gmgt_getdate_in_input_box($result->end_date);}else{echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));} ?>" name="end_date">







							<label class="date_label" for="end_date"><?php esc_html_e('Valid To Date','gym_mgt');?><span class="require-field">*</span></label>                                  







						</div>







					</div>







				</div>



				



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">







					<div class="form-group">







						<div class="col-md-12 form-control">







							<div class="row padding_radio">







								<div class="input-group">







									<label class="custom-top-label" for="publish"><?php esc_html_e('Publish','gym_mgt');?><span class="require-field">*</span></label>







									<div class="d-inline-block gender_line_height_24px">



										



										<?php $limitval = "yes"; if($edit){ $limitval=$result->published; }elseif(isset($_POST['publish'])) {$limitval=sanitize_text_field($_POST['publish']);}?>







										<label class="radio-inline custom_radio">







											<input type="radio" value="yes" class="tog" name="publish" <?php checked('yes',esc_html($limitval)); ?>/><?php esc_html_e('Yes','gym_mgt');?>







										</label>







										<label class="radio-inline custom_radio margin_right_5px">







											<input type="radio" value="no" class="tog" name="publish" <?php checked('no',esc_html($limitval)); ?>/><?php esc_html_e('No','gym_mgt');?>







										</label>







									</div>







								</div>







							</div>		







						</div>







					</div>







				</div>



			



			</div>



			



		</div>



		<div class="form-body user_form">







			<div class="row">







				<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn--> 







					<input type="submit" value="<?php if($edit){ esc_html_e('Save Coupon','gym_mgt'); }else{ esc_html_e('Add Coupon','gym_mgt');}?>" name="save_coupon" class="btn save_btn"/>







				</div>







			</div><!--Row Div End--> 







		</div>



		



	</form>



	



</div>



<?php	



}



?>