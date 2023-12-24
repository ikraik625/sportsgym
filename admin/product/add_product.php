<?php ?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	$('#product_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

		$('.manufacture_date').datepicker(

		{

			dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

			maxDate:'today',

			endDate: '+0d',

			autoclose: true

		}); 

} );

</script>

<?php 	

if($active_tab == 'addproduct')

{

	$product_id=0;

	if(isset($_REQUEST['product_id']))

		$product_id=esc_attr($_REQUEST['product_id']);

		$edit=0;

		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

		{

			$edit=1;

			$result = $obj_product->MJ_gmgt_get_single_product($product_id);

			

		}?>

        <div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->

		    <form name="product_form" action="" method="post" class="form-horizontal" id="product_form"><!--PRODUCT FORM STRAT-->

				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

				<input type="hidden" name="action" id="product_action" value="<?php echo esc_attr($action);?>">

				<input type="hidden" name="product_id" id="product_id" value="<?php echo esc_attr($product_id);?>"  />

				<div class="header">	

					<h3 class="first_hed"><?php esc_html_e('Product Information','gym_mgt');?></h3>

				</div>

				<div class="form-body user_form"> <!-- user_form Strat-->   

					<div class="row"><!--Row Div Strat--> 

						<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">

							<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Product Category','gym_mgt');?><span class="require-field">*</span></label>

							<select class="form-control validate[required] "  name="product_category" id="product_category">

								<option value=""><?php esc_html_e('Select Product Category','gym_mgt');?></option>

								<?php 				

								if(isset($_REQUEST['product_category']))

								{

									$category =esc_attr($_REQUEST['product_category']);  

								}

								elseif($edit)

								{

									$category =$result->product_cat_id;

								}

								else

								{ 

									$category = "";

								}

								$product_category=MJ_gmgt_get_all_category('product_category');

								if(!empty($product_category))

								{

									foreach ($product_category as $retrive_data)

									{

										echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';

									}

								}

								?>				

							</select>

						</div>

						<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3">				

							<button id="addremove" class="btn save_btn" model="product_category"><?php esc_html_e('Add','gym_mgt');?></button>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="product_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->product_name);}elseif(isset($_POST['product_name'])) echo esc_attr($_POST['product_name']);?>" name="product_name">

									<label class="" for="member_id"><?php esc_html_e('Product Name','gym_mgt');?><span class="require-field">*</span></label>

								</div>

							</div>

						</div>

						<?php wp_nonce_field( 'save_product_nonce' ); ?>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="product_price" class="form-control validate[required] text-input"  min="0"  step="0.01" onkeypress="if(this.value.length==10) return false;" type="number" value="<?php if($edit){ echo esc_attr($result->price);}elseif(isset($_POST['product_price'])) echo esc_attr($_POST['product_price']);?>" name="product_price">

									<label class="" for="member_id"><?php esc_html_e('Product Price','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>

								</div>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="group_name" class="form-control validate[required,custom[onlyNumberSp]] text-input" min="0" onkeypress="if(this.value.length==4) return false;" type="number" value="<?php if($edit){ echo esc_attr($result->quentity);}elseif(isset($_POST['quentity'])) echo esc_attr($_POST['quentity']);?>" name="quentity">

									<label class="" for="member_id"><?php esc_html_e('Product Quantity','gym_mgt');?><span class="require-field">*</span></label>

								</div>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="product_sku_number" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="20" type="text" value="<?php if($edit){ echo esc_attr($result->sku_number);}elseif(isset($_POST['sku_number'])) echo esc_attr($_POST['sku_number']);?>" name="sku_number">

									<label class="" for="member_id"><?php esc_html_e('SKU Number','gym_mgt');?><span class="require-field">*</span></label>

								</div>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input class="form-control validate[custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->manufacture_company_name);}elseif(isset($_POST['manufacture_company_name'])) echo esc_attr($_POST['manufacture_company_name']);?>" name="manufacture_company_name">

									<label class="" for="member_id"><?php esc_html_e('Manufacturer Company Name','gym_mgt');?></label>

								</div>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="manufacture_date" class="form-control manufacture_date date_picker" type="text"  name="manufacture_date" value="<?php if($edit){  if($result->manufacture_date!='0000-00-00' || $result->manufacture_date == '1970-01-01') { echo esc_attr(MJ_gmgt_getdate_in_input_box($result->manufacture_date)); } }?>" readonly>

									<label class="date_label" for="member_id"><?php esc_html_e('Manufacturer Date','gym_mgt');?></label>

								</div>

							</div>

						</div>

						<div class="col-md-6 note_text_notice">

							<div class="form-group input">

								<div class="col-md-12 note_border margin_bottom_15px_res">

									<div class="form-field">

										<textarea name="product_description" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="150"><?php if($edit){ echo trim(esc_textarea($result->product_description));}elseif(isset($_POST['product_description'])) echo esc_textarea($_POST['product_description']);?></textarea>

										<span class="txt-title-label"></span>

										<label class="text-area address active" for="notice_content"><?php esc_html_e('Product Description','gym_mgt');?></label>

									</div>

								</div>

							</div>

						</div>

						<div class="col-md-6 note_text_notice">

							<div class="form-group input">

								<div class="col-md-12 note_border margin_bottom_15px_res">

									<div class="form-field">

										<textarea name="product_specification" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="150"><?php if($edit){ echo trim(esc_textarea($result->product_specification));}elseif(isset($_POST['product_specification'])) echo esc_textarea($_POST['product_specification']);?></textarea>

										<span class="txt-title-label"></span>

										<label class="text-area address active" for="notice_content"><?php esc_html_e('Product Specification','gym_mgt');?></label>

									</div>

								</div>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<div class="form-group input">

								<div class="col-md-12 form-control upload-profile-image-patient">

									<label class="ustom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>

									<div class="col-sm-12 display_flex">

										<input type="text" id="gmgt_user_avatar_url1" readonly class="form-control gmgt_user_avatar_url" name="product_image" value="<?php if($edit)echo esc_url( $result->product_image );elseif(isset($_POST['product_image'])) echo esc_url($_POST['product_image']); ?>" />

										<input id="upload_user_avatar_button1" type="button" class="upload_image_btn button upload_user_avatar_button pload_user_cover_button" style="float: right;" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />

									</div>

								</div>

								<div class="clearfix"></div>

								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

									<div id="upload_user_avatar_preview" class="upload_user_avatar_preview">

										<?php 

										if($edit) 

										{

											if($result->product_image == "")

											{ ?>

												<img class="image_preview_css" src="<?php echo get_option( 'gmgt_Product_logo' ); ?>">

											<?php 

											}

											else

											{

											?>

												<img class="image_preview_css" src="<?php if($edit)echo esc_url( $result->product_image ); ?>" />

											<?php 

											}

										}

										else 

										{

											?>

											<img class="image_preview_css" src="<?php echo get_option( 'gmgt_Product_logo' ); ?>">

											<?php 

										}

										?>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="form-body user_form"> <!-- user_form Strat-->   

					<div class="row"><!--Row Div Strat--> 

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

							<input type="submit" id="product_save_btn" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_product" class="btn save_btn save_product"/>

						</div>

					</div>

				</div>

		    </form><!--PRODUCT FORM END-->

        </div><!--PANEL BODY DIV END-->

<?php 

}

?>