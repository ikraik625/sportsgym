<?php 



$obj_payment= new MJ_gmgt_payment();?>



<script type="text/javascript">



$(document).ready(function() 



{



	"use strict";



	$('#expense_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



	var date = new Date();



	date.setDate(date.getDate()-0);



	$('#invoice_date').datepicker({



	<?php



	if(get_option('gym_enable_datepicker_privious_date')=='no')



	{



	?>



		minDate:'today',



		startDate: date,



	<?php



	}



	?>	



	dateFormat:'<?php  echo get_option('gmgt_datepicker_format'); ?>',



	autoclose: true



   }); 					



} );



</script>



<?php 	



if($active_tab == 'addexpense')



{



	$expense_id=0;



	$edit=0;



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$edit=1;



		$expense_id=esc_attr($_REQUEST['expense_id']);



		$result = $obj_payment->MJ_gmgt_get_income_data($expense_id);			



	}



	?>



    <div class="panel-body padding_0">



		<form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">



			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



			<input type="hidden" name="expense_id" value="<?php echo esc_attr($expense_id);?>">



			<input type="hidden" name="invoice_type" value="expense">



			<div class="header">	



				<h3 class="first_hed"><?php esc_html_e('Expense Information','gym_mgt');?></h3>



			</div>



			<div class="form-body user_form">	



				<div class="row">



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="supplier_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->supplier_name);}elseif(isset($_POST['supplier_name'])) echo esc_attr($_POST['supplier_name']);?>" name="supplier_name">



								<label class="" for="member_id"><?php esc_html_e('Supplier Name','gym_mgt');?><span class="require-field">*</span></label>



							</div>



						</div>



					</div>



					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Status','gym_mgt');?><span class="require-field">*</span></label>



						<select name="payment_status" id="payment_status" class="form-control validate[required]">



							<option value="<?php echo esc_html__('Paid','gym_mgt');?>"<?php if($edit)selected('Paid',$result->payment_status);?> ><?php esc_html_e('Paid','gym_mgt');?></option>



							<option value="<?php echo esc_html__('Part Paid','gym_mgt');?>"<?php if($edit)selected('Part Paid',$result->payment_status);?>><?php esc_html_e('Part Paid','gym_mgt');?></option>



							<option value="<?php echo esc_html__('Unpaid','gym_mgt');?>"<?php if($edit)selected('Unpaid',$result->payment_status);?>><?php esc_html_e('Unpaid','gym_mgt');?></option>



						</select>



					</div>



					<?php wp_nonce_field( 'save_expense_nonce' ); ?>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="invoice_date"  class="form-control validate[required] date_picker" type="text" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->invoice_date));} elseif(isset($_POST['invoice_date'])){ echo $_POST['invoice_date'];} else{ echo esc_attr(MJ_gmgt_getdate_in_input_box(date("Y-m-d")));}?>" name="invoice_date" readonly>



								<label class="date_label" for="member_id"><?php esc_html_e('Date','gym_mgt');?><span class="require-field">*</span></label>



							</div>



						</div>



					</div>



				</div>



			</div>	



			<hr>



				<?php



				if($edit)



				{



					$all_entry=json_decode($result->entry);



				}



				else



				{



					if(isset($_POST['income_entry']))



					{	



						$all_data=$obj_payment->MJ_gmgt_get_entry_records($_POST);



						$all_entry=json_decode($all_data);



					}					



				}



				if(!empty($all_entry))



				{

					$i=1;

					foreach($all_entry as $entry)

					{
						


						?>



						<div id="expense_entry">



							<div class="form-body user_form"> <!-- user_form Strat-->   



								<div class="row"><!--Row Div Strat--> 



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php echo esc_attr($entry->amount);?>" name="income_amount[]">



												<label class="" for="membership_name"><?php esc_html_e('Expense Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



											</div>



										</div>



									</div>



									<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1" maxlength="50" type="text" value="<?php echo esc_attr($entry->entry);?>" name="income_entry[]">



												<label class="" for="membership_name"><?php esc_html_e('Expense Label','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>
									<?php
							if($i == 1)
							{
								?>


									<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



										<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



									</div>

								<?php
							}
							else{
								?>
								<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



										<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt="">



									</div>
								<?php
							}
								?>

									



								</div>



							</div>



						</div>



						<?php


						$i++;
					}



				}



				else



				{



					?>



					<div id="expense_entry">



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="" name="income_amount[]">



											<label class="active" for="membership_name"><?php esc_html_e('Expense Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1" maxlength="50" type="text" value="" name="income_entry[]">



											<label class="active" for="membership_name"><?php esc_html_e('Expense Label','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



									<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



								</div>



							</div>



						</div>



					</div>



					<?php



				}



				?>



			<hr>



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row "><!--Row Div Strat--> 



					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



						<input type="submit" value="<?php if($edit){ esc_html_e('Save Expense','gym_mgt'); }else{ esc_html_e('Add Expense','gym_mgt');}?>" name="save_expense" class="btn save_btn"/>



					</div>



				</div>



			</div>



		</form><!--Expense FORM END-->



    </div><!--PANEL BODY DIV END-->



	<script>



		// CREATING BLANK INVOICE ENTRY



		var value = 1;



		function add_entry()



		{



			"use strict";



			value++;



			$("#expense_entry").append('<div class="form-body user_form"><div class="row"><div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 "><div class="form-group input"><div class="col-md-12 form-control"><input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="" name="income_amount[]"><label class="active" for="membership_name"><?php esc_html_e('Expense Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label></div></div></div><div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 "><div class="form-group input"><div class="col-md-12 form-control"><input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1" maxlength="50" type="text" value="" name="income_entry[]" ><label class="active" for="membership_name"><?php esc_html_e('Expense Label','gym_mgt');?><span class="require-field">*</span></label></div></div></div><div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div>');			



		}



		// REMOVING INVOICE ENTRY



		function deleteParentElement(n)



		{



			"use strict";



			alert("<?php esc_html_e('Do you really want to delete this record','gym_mgt');?>");



			n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);



		}



	</script>



 	<?php



}



?>