<?php ?>



<script type="text/javascript">



$(document).ready(function() 



{



	"use strict";



	$('#payment_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



		    var date = new Date();



            date.setDate(date.getDate()-0);



            $('#begin_date').datepicker({



			dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



	       	<?php



			if(get_option('gym_enable_datepicker_privious_date')=='no')



			{



			?>



				minDate:'today',



			<?php



			}



			?>	



             	autoclose: true



           });



	$(".display-members").select2();



	$('.sl').select2(



	{



        placeholder:'Select'   



    })



} );



</script>



<?php



if($active_tab == 'addpayment')



{

	

  	$mp_id=0;	



	$edit=0;



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$mp_id=$_REQUEST['mp_id'];



	  	$edit=1;



	  	$result = $obj_membership_payment->MJ_gmgt_get_single_membership_payment($mp_id);



	}



	?>



    <div class="panel-body padding_0"><!--PANEL BODY DIV START-->



		<form name="payment_form" action="" method="post" class="form-horizontal" id="payment_form"><!--PAYMENT FORM START-->



			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



			<input type="hidden" name="mp_id" value="<?php if($edit){ echo esc_attr($mp_id); }?>"  />



			<input type="hidden" name="created_by" value="<?php echo get_current_user_id();?>"  />



			<input type="hidden" name="paid_amount" value="<?php if($edit){ echo esc_attr($result->paid_amount); }?>" />



			<input type="hidden" name="invoice_no" value="<?php if($edit){ echo esc_attr($result->invoice_no); }?>" />



			<input type="hidden" class="user_coupon" name="coupon_id" value=""/>



			<div class="header">	



				<h3 class="first_hed"><?php esc_html_e('Membership Payment Information','gym_mgt');?></h3>



			</div>



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat-->



					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



						<!-- <label class="ml-1 custom-top-label top" for="Source"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



						<?php if($edit){ $member_id=$result->member_id; }elseif(isset($_REQUEST['member_id'])){$member_id=$_REQUEST['member_id'];}else{$member_id='';} ?>



						<select id="member_list" class="form-control display-members member-select2" required="true" name="member_id">



							<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



							<?php $get_members = array('role' => 'member');



							$membersdata=get_users($get_members);



							 if(!empty($membersdata))

							 {

								foreach ($membersdata as $member)

								{

									?>

									<option value="<?php echo esc_attr($member->ID);?>" <?php selected($member_id,$member->ID);?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>

									<?php



								}



							 }?>



						</select>



					</div>



					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



						<label class="ml-1 custom-top-label top" for="Membership"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>

						<?php 	$obj_membership=new MJ_gmgt_membership;

						$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>

						<?php if($edit){ $membership_id=$result->membership_id; }elseif(isset($_POST['membership_id'])){$membership_id=$_POST['membership_id'];}else{$membership_id='';}?>

						<select name="membership_id" class="form-control payment_membership_detail coupon_membership_id validate[required]" type="renew_membership" id="membership_id">

							<option value=""><?php esc_html_e('Select Membership ','gym_mgt');?></option>

							<?php 

							if(!empty($membershipdata))

							{

								foreach ($membershipdata as $membership)

								{

									echo '<option value='.$membership->membership_id.' '.selected($membership_id,$membership->membership_id).'>'.$membership->membership_label.'</option>';

								}

							}

							?>

						</select>

					</div>

					<?php wp_nonce_field( 'save_membership_payment_nonce' ); ?>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="begin_date" class="form-control validate[required] date_picker" type="text"  name="start_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->start_date));}elseif(isset($_POST['start_date'])) echo esc_attr($_POST['start_date']);?>" readonly>

								<label class="date_label" for="triel_date"><?php esc_html_e('Membership Start Date','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="end_date" class="form-control validate[required] date_picker"  type="text" name="end_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->end_date));}elseif(isset($_POST['end_date'])) echo esc_attr($_POST['end_date']);?>" readonly>

								<label class="date_label" for="triel_date"><?php esc_html_e('Membership End Date','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<?php

					if($edit == 0){

					?>

						<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="coupon_code" class="form-control coupon_code" type="text" value="" name="coupon_code" >

									<label class="" for=""><?php esc_html_e('Add Coupon Code','gym_mgt');?></label>

								</div>

								<span class="coupon_span"></span>

							</div>

						</div>

						<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">	

							<button id=""  class="btn add_btn apply_coupon" ><?php esc_html_e('Apply','gym_mgt');?></button>

						</div>

					<?php

					}

					?>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="total_amount" class="form-control validate[required,custom[number]]" type="text" value="<?php if($edit){ echo esc_attr($result->membership_amount);}?>" name="membership_amount" readonly>

								<label class="" for="triel_date"><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<?php

					if($edit == 0){

					?>

				
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 discount_display">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="coupon_discount" class="form-control" type="text" value="" name="discount" readonly>



								<label class="" for=""><?php esc_html_e('Discount','gym_mgt');?></label>



							</div>



						</div>



					</div>

					<?php

					}

					?>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">



						<div class="form-group">



							<div class="col-md-12 form-control">



								<div class="row padding_radio">



									<div class="">



										<label class="custom-top-label" for="member_convert"><?php esc_html_e('Send SMS To Member','gym_mgt');?></label>



										<input id="chk_sms_sent" type="checkbox"  value="1" name="gmgt_sms_service_enable"><?php esc_html_e('Enable','gym_mgt'); ?>



									</div>												



								</div>



							</div>



						</div>



					</div>



				</div>



			</div>
			<span class="payment_detail_span"></span>
			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 



					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



						<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_membership_payment" class="btn save_member_validate save_btn"/>



					</div>



				</div>



			</div>



		</form><!--PAYMENT FORM END-->



    </div><!--PANEL BODY DIV END-->



<?php



}



?>