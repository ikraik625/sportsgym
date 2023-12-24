<?php ?>

<script type="text/javascript">

$(document).ready(function()
{promptPosition : "bottomLeft"
{

	"use strict";

	$('#payment_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

		    var date = new Date();

            date.setDate(date.getDate()-0);

            $('#due_date').datepicker({

			dateFormat:'<?php echo get_option('gmgt_datepicker_format'); ?>',

			minDate:'today',

	        startDate: date,

            autoclose: true

           });

		$(".display-members").select2();

} );

</script>

<?php

if($active_tab == 'addpayment')

{

	$payment_id=0;

	$edit=0;

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

	{

		$edit=1;

		$payment_id=esc_attr($_REQUEST['payment_id']);

		$result = $obj_payment->MJ_gmgt_get_single_payment($payment_id);

	}

	?>		

	<div class="panel-body"><!--PANEL BODY DIV START-->

		<form name="payment_form" action="" method="post" class="form-horizontal" id="payment_form"><!--PAYMENT FORM START-->

			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

			<input type="hidden" name="payment_id" value="<?php echo esc_attr($payment_id);?>"  />

			<div class="form-group">

				<div class="mb-3 row">

					<label class="col-sm-2 control-label form-label" for="day"><?php esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label>

					<div class="col-sm-8">

						<?php if($edit){ $member_id=$result->member_id; }elseif(isset($_POST['member_id'])){$member_id=sanitize_text_field($_POST['member_id']);}else{$member_id='';}?>

						<select id="member_list" class="display-members member-select2" required="true" name="member_id">

						<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>

							<?php $get_members = array('role' => 'member');

							$membersdata=get_users($get_members);

							 if(!empty($membersdata))

							 {

								foreach ($membersdata as $member)

								{?>

									<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>

								<?php

								}

							 }?>

					</select>

					</div>

				</div>

			</div>

			<!--nonce-->

			<?php wp_nonce_field( 'save_product_nonce' ); ?>

			<!--nonce-->

			<div class="form-group">

				<div class="mb-3 row">

					<label class="col-sm-2 control-label form-label" for="title"><?php esc_html_e('Title','gym_mgt');?></label>

					<div class="col-sm-8">

						<input id="payment_title" class="form-control validate[custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->title);}elseif(isset($_POST['payment_title'])) echo esc_attr($_POST['payment_title']);?>" name="payment_title">

					</div>

				</div>

			</div>

			<div class="form-group">

				<div class="mb-3 row">

					<label class="col-sm-2 control-label form-label" for="due_date"><?php esc_html_e('Due Date','gym_mgt');?></label>

					<div class="col-sm-8">

						<input id="due_date" class="form-control"  type="text" name="due_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->due_date));}elseif(isset($_POST['due_date'])){ echo esc_attr($_POST['due_date']);}else{ echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d'))); }?>" readonly>

					</div>

				</div>

			</div>

			<div class="form-group">

				<div class="mb-3 row">

					<label class="col-sm-2 control-label form-label" for="discount"><?php esc_html_e('Discount Amount','gym_mgt');?> </label>

					<div class="col-sm-8">

						<input id="discount" class="form-control" type="number" min="0" onkeypress="if(this.value.length==6) return false;"  value="<?php if($edit){ echo esc_attr($result->discount);}?>" name="discount">

					</div>

					<div class="col-sm-1">

						<span class="font_size_20"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>

					</div>

				</div>

			</div>

			<div class="form-group">

				<div class="mb-3 row">

					<label class="col-sm-2 control-label form-label" for="total_amount"><?php esc_html_e('Total Amount','gym_mgt');?><span class="require-field">*</span></label>

					<div class="col-sm-8">

						<input id="total_amount" class="form-control validate[required]" type="number" min="0" onkeypress="if(this.value.length==6) return false;" value="<?php if($edit){ echo esc_attr($result->total_amount);}?>" name="total_amount">

					</div>

					<div class="col-sm-1">

						<span class="font_size_20"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?></span>

					</div>

				</div>

			</div>

			<div class="form-group">

				<div class="mb-3 row">

					<label class="col-sm-2 control-label form-label" for="payment_status"><?php esc_html_e('Status','gym_mgt');?><span class="require-field">*</span></label>

					<div class="col-sm-8">

						<select name="payment_status" id="payment_status" class="form-control">

							<option value="<?php echo esc_html__('Paid','gym_mgt');?>"

							<?php if($edit)selected('Paid',$result->payment_status);?> class="validate[required]"><?php esc_html_e('Paid','gym_mgt');?></option>

							<option value="<?php echo esc_html__('Part Paid','gym_mgt');?>"

							<?php if($edit)selected('Part Paid',$result->payment_status);?> class="validate[required]"><?php esc_html_e('Part Paid','gym_mgt');?></option>

							<option value="<?php echo esc_html__('Unpaid','gym_mgt');?>"

							<?php if($edit)selected('Unpaid',$result->payment_status);?> class="validate[required]"><?php esc_html_e('Unpaid','gym_mgt');?></option>

						</select>

					</div>

				</div>

			</div>

			<div class="form-group">

				<div class="mb-3 row">

					<label class="col-sm-2 control-label form-label" for="description"><?php esc_html_e('Description','gym_mgt');?></label>

					<div class="col-sm-8">

						<textarea name="description" id="description" class="form-control" maxlength="150"> <?php if($edit){ echo esc_textarea($result->description);}?></textarea>

					</div>

				</div>

			</div>

			<div class="offset-sm-2 col-lg-8 col-md-8 col-sm-8 col-xs-12">					

				<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_product" class="btn btn-success"/>

			</div>

		</form><!--PAYMENT FORM END-->

	</div><!--PANEL BODY DIV END-->

<?php 

}

?>