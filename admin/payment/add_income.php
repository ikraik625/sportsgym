<?php 
$obj_payment= new MJ_gmgt_payment();
?>
<script type="text/javascript">
$(document).ready(function()
{



	"use strict";



	$('#income_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	$('.tax_charge').multiselect(



	{



		nonSelectedText :'<?php esc_html_e('Select Tax','gym_mgt');?>',



		includeSelectAllOption: true,



		allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



		selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



		templates: {



				button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



			},



		buttonContainer: '<div class="dropdown" />'



	});	







	var date = new Date();



	date.setDate(date.getDate()-0);



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



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



		dateFormat: '<?php  echo get_option('gmgt_datepicker_format'); ?>',	



		autoclose: true



	}); 	



	$(".display-members").select2();



} );



</script>



<?php 	



if($active_tab == 'addincome')



{



	$income_id=0;



	$edit=0;



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$edit=1;



		$income_id=esc_attr($_REQUEST['income_id']);



		$result = $obj_payment->MJ_gmgt_get_income_data($income_id);



	}



	?>



    <div class="panel-body padding_0"><!--PANEL BODY DIV START-->



		<form name="income_form" action="" method="post" class="form-horizontal" id="income_form"><!--INCOME FORM START-->



			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



			<input type="hidden" name="income_id" value="<?php if($edit){ echo esc_attr($income_id); }?>">



			<input type="hidden" name="income_id_1" value="<?php echo esc_attr($income_id); ?>">



			<input type="hidden" name="invoice_type" value="income">



			<input type="hidden" name="invoice_no" value="<?php if($edit){ echo esc_attr($result->invoice_no); }?>">



			<input type="hidden" name="paid_amount" value="<?php if($edit){ echo esc_attr($result->paid_amount); } ?>">



			<div class="header">	



				<h3 class="first_hed"><?php esc_html_e('Income Information','gym_mgt');?></h3>



			</div>



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 



					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">


						<?php if($edit){ $member_id=$result->supplier_name; }elseif(isset($_POST['member_id'])){$member_id=$_POST['member_id'];}else{$member_id='';}?>



						<select id="member_list" class="form-control display-members" required="true" name="supplier_name">



							<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



								<?php $get_members = array('role' => 'member');



								$membersdata=get_users($get_members);



								if(!empty($membersdata))



								{



									foreach ($membersdata as $member){?>



										<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



									<?php }



								}?>



						</select>



					</div>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="invoice_label" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->invoice_label);}elseif(isset($_POST['invoice_label'])) echo esc_attr($_POST['invoice_label']);?>" name="invoice_label">



								<label class="" for="member_id"><?php esc_html_e('Income Title','gym_mgt');?><span class="require-field">*</span></label>



							</div>



						</div>



					</div>



					<?php wp_nonce_field( 'save_income_nonce' ); ?>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="invoice_date"  class="form-control date_picker" type="text" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->invoice_date));} elseif(isset($_POST['invoice_date'])){ echo esc_attr($_POST['invoice_date']);} else{ echo esc_attr(MJ_gmgt_getdate_in_input_box(date("Y-m-d")));}?>" name="invoice_date" readonly>



								<label class="date_label" for="member_id"><?php esc_html_e('Date','gym_mgt');?><span class="require-field">*</span></label>



							</div>



						</div>



					</div>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px multiselect_validation_member smgt_multiple_select">



						<select  class="form-control tax_charge" name="tax[]" multiple="multiple">



							<?php



							if($edit)



							{



								$tax_id=explode(',',$result->tax_id);



							}



							else



							{	



								$tax_id[]='';



							}



							$obj_tax=new MJ_gmgt_tax;



							$gmgt_taxs=$obj_tax->MJ_gmgt_get_all_taxes();



							if(!empty($gmgt_taxs))



							{



								foreach($gmgt_taxs as $data)



								{



									$selected = "";



									if(in_array($data->tax_id,$tax_id))



										$selected = "selected";



									?>



									<option value="<?php echo esc_attr($data->tax_id); ?>" <?php echo esc_html($selected); ?> ><?php echo esc_html($data->tax_title);?>-<?php echo esc_html($data->tax_value);?></option>



								<?php



								}



							}



							?>



						</select>



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

						$all_data=$obj_invoice->MJ_gmgt_get_entry_records($_POST);

						$all_entry=json_decode($all_data);

					}

				}
				
				if(!empty($all_entry))
				{
					$i=1;
					?>
				<div class="income_entry_div">
					<?php
					foreach($all_entry as $entry)
					{
					
						?>

						

							<div class="form-body user_form"> <!-- user_form Strat-->   



								<div class="row"><!--Row Div Strat--> 



									<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php echo esc_attr($entry->amount);?>" name="income_amount[]" placeholder="<?php esc_html_e('Income Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)">



												<label class="" for="membership_name"><?php esc_html_e('Income Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



											</div>



										</div>



									</div>



									<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1" type="text" maxlength="50" value="<?php echo esc_attr($entry->entry);?>" name="income_entry[]">



												<label class="" for="membership_name"><?php esc_html_e('Income Entry Label','gym_mgt');?><span class="require-field">*</span></label>



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

						

						<?php



						$i++;



					}
					?>
					</div>
					<?php


				}



				else



				{



					?>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row income_entry_div"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="" name="income_amount[]" >



										<label class="active" for="membership_name"><?php esc_html_e('Income Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1"   maxlength="50" type="text" value="" name="income_entry[]">



										<label class="active" for="membership_name"><?php esc_html_e('Income Entry Label','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



								<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



							</div>



						</div>



					</div>



					<?php



				}



				?>



			<hr>	



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row "><!--Row Div Strat--> 



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="group_name" class="form-control text-input decimal_number" step="0.01" type="number" onKeyPress="if(this.value.length==8) return false;"  min="0" value="<?php if($edit){ echo esc_attr($result->discount);}elseif(isset($_POST['discount'])) echo esc_attr($_POST['discount']);?>" name="discount">



								<label class="active" for="membership_name"><?php esc_html_e('Discount Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>



							</div>



						</div>



					</div>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



						<div class="form-group">



							<div class="col-md-12 form-control">



								<div class="row padding_radio">



									<div class="">



										<label class="custom-top-label" for="gmgt_membership_recurring"><?php esc_html_e('Send SMS To Member','gym_mgt');?></label>



										<input id="chk_sms_sent" type="checkbox"  value="1" name="gmgt_sms_service_enable"> <?php esc_html_e('Enable','gym_mgt'); ?>



									</div>												



								</div>



							</div>



						</div>



					</div>



				</div>



			</div>



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row "><!--Row Div Strat--> 



					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



						<input type="submit" value="<?php if($edit){ esc_html_e('Save Income','gym_mgt'); }else{ esc_html_e('Add Income','gym_mgt');}?>" name="save_income" class="save_member_validate btn save_btn"/>



					</div>



				</div>



			</div>



		</form><!--INCOME FORM END-->



    </div><!--PANEL BODY DIV END-->



	<script>

		//ADD INCOME ENTRY

		var value = 1;

		function add_entry()



		{

			"use strict";

			value++;



			$(".income_entry_div").append('<div class="form-body user_form"><div class="row"><div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 "><div class="form-group input"><div class="col-md-12 form-control"><input id="income_amount" class="form-control validate[required] text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="" name="income_amount[]" ><label class="active" for="membership_name"><?php esc_html_e('Income Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label></div></div></div><div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 "><div class="form-group input"><div class="col-md-12 form-control"><input id="income_entry" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_space_validation1"   maxlength="50" type="text" value="" name="income_entry[]" ><label class="active" for="membership_name"><?php esc_html_e('Income Entry Label','gym_mgt');?><span class="require-field">*</span></label></div></div></div><div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div>');			



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