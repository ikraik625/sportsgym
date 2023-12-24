<?php ?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	$('#store_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

	$('#product_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

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

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

        date.setDate(date.getDate()-0);

        $('#sell_date').datepicker({

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

	// $(".sale_product_sreach").select2();
	
	$('.product_id').multiselect(

	{

		nonSelectedText :'<?php esc_html_e('Select Product','gym_mgt');?>',

		includeSelectAllOption: true,

		allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

		selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

		templates: {

				button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

			},

		buttonContainer: '<div class="dropdown" />'

	});	

	//------ADD GROUP AJAX----------

	$('#product_form').on('submit', function(e) 

	{

		e.preventDefault();	

		var form = $(this).serialize();

		var valid = $("#product_form").validationEngine('validate');

		if (valid == true) 

		{

			$('.modal').modal('hide');

			$.ajax(

			{

				type:"POST",

				url: $(this).attr('action'),

				data:form,

				success: function(data)

				{

					if(data!="")

					{ 

						$('#product_form').trigger("reset");

						$('#product_id').append(data);

					}

				},

				error: function(data)

				{

				}

			})

		}

	});

} );

</script>

<?php 	

if($active_tab == 'sellproduct')

{        	

	$sell_id=0;

	if(isset($_REQUEST['sell_id']))

		esc_attr($sell_id=$_REQUEST['sell_id']);

		$edit=0;

		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

		{	

			$edit=1;

			$result = $obj_store->MJ_gmgt_get_single_selling($sell_id);	

		}

		?>		

		<div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->

			<form name="store_form" action="" method="post" class="form-horizontal" id="store_form"><!--sell product form STRAT-->

				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

				<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

				<input type="hidden" name="invoice_number" value="<?php if($edit){ echo esc_attr($result->invoice_no); } ?>">

				<input type="hidden" name="sell_id" value="<?php if($edit){ echo esc_attr($sell_id); }?>"  />

				<input type="hidden" name="paid_amount" value="<?php  if($edit){ echo esc_attr($result->paid_amount); }?>" />

				<div class="header">	

					<h3 class="first_hed"><?php esc_html_e('Sale Product Information','gym_mgt');?></h3>

				</div>

				<div class="form-body user_form"> <!-- user_form Strat-->   

					<div class="row"><!--Row Div Strat--> 

						<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

							<!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->

							<?php if($edit){ $member_id=$result->member_id; }elseif(isset($_REQUEST['member_id'])){$member_id=sanitize_text_field($_REQUEST['member_id']);}else{$member_id='';}?>

							<select id="member_list" class="form-control display-members" required="true" name="member_id">

								<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>

									<?php $get_members = array('role' => 'member');

									$membersdata=get_users($get_members);

									if(!empty($membersdata))

									{

										foreach ($membersdata as $member)

										{

											if( $member->membership_status == "Continue"  && $member->member_type == "Member")

											{		

										?>

											<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>

										<?php		

											}

										}

									}?>

							</select>

						</div>

						<?php wp_nonce_field( 'save_selling_nonce' ); ?>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="sell_date" class="form-control date_picker" type="text"  name="sell_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->sell_date));}elseif(isset($_POST['sell_date'])){ echo esc_attr($_POST['sell_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); } ?>" readonly>

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

				if(!empty($all_entry))

				{

					$i=0;

					foreach($all_entry as $entry)

					{

						$i--;

						?>

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row main_expnse_div"><!--Row Div Strat--> 

								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input display_none">

									<!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Sale Product','gym_mgt');?><span class="require-field">*</span></label> -->

									<select id="product_id" class="sale_product_sreach form-control validate[required]"  name="old_product_id[]">

										<option value=""><?php esc_html_e('Select Product','gym_mgt');?></option>

										<?php 

										$productdata=$obj_product->MJ_gmgt_get_all_product();

										if(!empty($productdata))

										{

											foreach ($productdata as $product)

											{	

											?>

												<option value="<?php echo esc_attr($product->id);?>" <?php selected(esc_attr($entry->entry),esc_attr($product->id));  ?>><?php echo esc_html($product->product_name); ?> </option>

											<?php

											}

										}

										?>

									</select>

								</div>

								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 display_none">

									<div class="form-group input">

										<div class="col-md-12 form-control">

											<input id="group_name" class="form-control validate[required] text-input decimal_number quantity" maxlength="6" type="text" value="<?php echo esc_attr($entry->quentity);?>" name="old_quentity[]" >

											<label class="" for="member_id"><?php esc_html_e('Quantity','gym_mgt');?><span class="require-field">*</span></label>

										</div>

									</div>

								</div>

							</div>

						</div>

						<div id="expense_entry">

							<div class="form-body user_form"> <!-- user_form Strat-->   

								<div class="row main_expnse_div"><!--Row Div Strat--> 

									<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

										<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Sale Product','gym_mgt');?><span class="require-field">*</span></label>

										<select id="" class="form-control validate[required] product_id<?php echo esc_attr($i); ?>" readonly row="<?php echo esc_attr($i); ?>" name="product_id[]">

											<?php 

											$productdata=$obj_product->MJ_gmgt_get_all_product();

											if(!empty($productdata))

											{

												foreach ($productdata as $product)

												{

													if($product->id == $entry->entry)

													{

													?>

													<option value="<?php echo esc_attr($product->id);?>" <?php selected(esc_attr($entry->entry),esc_attr($product->id)); ?>><?php echo esc_html($product->product_name); ?> </option>

													<?php

													}

												}

											}

											?>

										</select>

									</div>

									<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

										<div class="form-group input">

											<div class="col-md-12 form-control">

												<input id="group_name" readonly class="form-control validate[required] text-input decimal_number quantity<?php echo esc_attr($i); ?>" row="<?php echo esc_attr($i); ?>" onkeypress="if(this.value.length==4) return false;" placeholder="<?php esc_html_e('Quantity','gym_mgt'); ?>" type="number" min="1" value="<?php echo esc_attr($entry->quentity);?>" name="quentity[]" >

												<label class="" for="member_id"><?php esc_html_e('Quantity','gym_mgt');?><span class="require-field">*</span></label>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

						<?php

					}

				}

				else

				{

					?>

					<div id="expense_entry">

						<div class="form-body user_form"> <!-- user_form Strat-->   

							<div class="row main_expnse_div"><!--Row Div Strat--> 

								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input total_sale_product">

									<!-- <label class="ml-1 custom-top-label top" for="staff_name"><?php //esc_html_e('Sale Product','gym_mgt');?><span class="require-field">*</span></label> -->

									<select id="product_id" class="sale_product_sreach form-control product_value validate[required] product_id1" row="1" value="" name="product_id[]">

										<option value=""><?php esc_html_e('Select Product','gym_mgt');?></option>

										<?php 

											$productdata=$obj_product->MJ_gmgt_get_all_product();

											if(!empty($productdata))

											{

												foreach ($productdata as $product)

												{?>

												<option value="<?php echo esc_attr($product->id);?>"><?php echo esc_html($product->product_name); ?> </option>

											<?php

												} 

											} 

										?>

									</select>

								</div>

								<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

									<div class="form-group input">

										<div class="col-md-12 form-control">

											<input id="group_name" class="form-control validate[required] text-input decimal_number quantity margin_top_10_res quantity1" row="1" onkeypress="if(this.value.length==4) return false;" min="1" type="number" value="" name="quentity[]" >

											<label class="" for="member_id"><?php esc_html_e('Quantity','gym_mgt');?><span class="require-field">*</span></label>

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

					<div class="row"><!--Row Div Strat--> 

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="group_name" class="form-control text-input decimal_number discount_amount"  type="number" min="0" step="0.01" onKeyPress="if(this.value.length==6) return false;"  value="<?php if($edit){ echo esc_attr($result->discount);}elseif(isset($_POST['discount'])) echo esc_attr($_POST['discount']);?>"  name="discount">

									<label class="" for="member_id"><?php esc_html_e('Discount Amount ','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field"></span></label>

								</div>

							</div>

						</div>

						<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_class smgt_multiple_select">

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

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px">

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

				<div class="form-body user_form margin_top_15px" > <!-- user_form Strat-->   

					<div class="row"><!--Row Div Strat--> 

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Sell Product','gym_mgt');}?>" name="save_selling" class="btn save_btn save_member_validate save_product"/>

						</div>

					</div>

				</div>

				

			</form><!--sell product form end-->

        </div><!--PANEL BODY DIV end-->

<?php 

}

?>

<!----------ADD GORUP POPUP------------->

<div class="modal fade overflow_scroll" id="myModal_add_product" role="dialog"><!--MODAL MAIN DIV START-->

    <div class="modal-dialog modal-lg"><!--MODAL DIALOG DIV START-->

		<div class="modal-content"><!--MODAL CONTENT DIV START-->

			<div class="modal-header">

			  	<button type="button" class="close" data-dismiss="modal">&times;</button>

			  	<h3 class="modal-title"><?php esc_html_e('Add Product','gym_mgt');?></h3>

			</div>

			<div class="modal-body"><!--MODAL BODY DIV START-->

			  	<form name="product_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="product_form"><!--GROUP FORM START-->

					<input type="hidden" name="action" value="MJ_gmgt_add_ajax_product">

					<input type="hidden" name="product_id" value=""  />

					<div class="form-group">

						<div class="mb-3 row">

							<label class="col-sm-2 control-label form-label" for="product_name"><?php esc_html_e('Product Name','gym_mgt');?><span class="require-field">*</span></label>

							<div class="col-sm-8">

								<input id="product_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text" value="<?php if($edit){ echo esc_attr($result->product_name);}elseif(isset($_POST['product_name'])) echo esc_attr($_POST['product_name']);?>" name="product_name">

							</div>

						</div>

					</div>

					<div class="form-group">

						<div class="mb-3 row">

							<label class="col-sm-2 control-label form-label" for="product_price"><?php esc_html_e('Product Price','gym_mgt');?><span class="require-field">*</span></label>

							<div class="col-sm-8">

								<input id="product_price" class="form-control validate[required,custom[number]] text-input" type="text" value="<?php if($edit){ echo esc_attr($result->price);}elseif(isset($_POST['product_price'])) echo esc_attr($_POST['product_price']);?>" name="product_price">

							</div>

						</div>

					</div>

					<div class="form-group">

						<div class="mb-3 row">

							<label class="col-sm-2 control-label form-label margin_top_10_res" for="quentity"><?php esc_html_e('Product Quantity','gym_mgt');?><span class="require-field">*</span></label>

							<div class="col-sm-8">

								<input id="group_name" class="form-control validate[required,custom[number]] text-input" type="text" value="<?php if($edit){ echo esc_attr($result->quentity);}elseif(isset($_POST['quentity'])) echo esc_attr($_POST['quentity']);?>" name="quentity">

							</div>

						</div>

					</div>



					

					<div class="offset-sm-2 col-lg-8 col-md-8 col-sm-8 col-xs-12">

						<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_product" class="btn btn-success "/>

					</div>

				</form><!--GROUP FORM END-->

			</div><!--MODAL BODY DIV END-->

			<div class="modal-footer">

				<button type="button" class="btn btn-default" data-dismiss="modal"><?php esc_html_e('Close','gym_mgt');?></button>

			</div>

		</div><!--MODAL CONTENT DIV END-->

	</div><!--MODAL DIALOG DIV END-->

</div>	<!--MODAL MAIN DIV END-->

<script>

var value = 1;

function add_entry()

{

	value++;

	$(".main_expnse_div").append('<div class="form-body user_form"><div class="row"><div class="total_sale_product col-sm-12 col-md-6 col-lg-6 col-xl-6 input"><select id="product_id" class="sale_product_sreach form-control product_value validate[required] product_id'+value+'" row="'+value+'" name="product_id[]"><option value=""><?php esc_html_e('Select Product','gym_mgt');?></option><?php $productdata=$obj_product->MJ_gmgt_get_all_product();if(!empty($productdata)){foreach ($productdata as $product){?><option value="<?php echo esc_attr($product->id);?>"><?php echo esc_attr($product->product_name); ?></option> <?php } } ?></select></div><div class="col-sm-5 col-md-5 col-lg-5 col-xl-5"><div class="form-group input"><div class="col-md-12 form-control"><input id="group_name" class="form-control validate[required] text-input decimal_number margin_top_10_res quantity quantity'+value+'" row="'+value+'" onkeypress="if(this.value.length==4) return false;" type="number" min="1" value="" name="quentity[]" ><label class="active" for="member_id"><?php esc_html_e('Quantity','gym_mgt');?><span class="require-field">*</span></label></div></div></div><div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div>');

}

function deleteParentElement(n)

{

	alert("<?php esc_html_e('Do you really want to delete this record','gym_mgt');?>");

	n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);

}

</script> 