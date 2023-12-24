<script type="text/javascript">

jQuery(document).ready(function($)

{

	"use strict";

	$('#notice_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

	$(".start_date").datepicker({

        dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

		minDate:0,

        onSelect: function (selected) {

            var dt = new Date(selected);

            dt.setDate(dt.getDate() + 0);

            $(".end_date").datepicker("option", "minDate", dt);

        }

    });

    $(".end_date").datepicker({

       	dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',
		   minDate:0,
        onSelect: function (selected) {

            var dt = new Date(selected);

            dt.setDate(dt.getDate() - 0);

            $(".start_date").datepicker("option", "maxDate", dt);

        }

    });	

	

} );

</script>

<script type="text/javascript">

	function fileCheck(obj)

	{   //FILE VALIDATIONENGINE

		"use strict";

		var fileExtension = ['pdf','doc','jpg','jpeg','png'];

		if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)

		{

			alert("<?php esc_html_e('Sorry, only JPG, JPEG, PNG And GIF files are allowed.','gym_mgt');?>");

			$(obj).val('');

		}	

	}

</script>

<?php 	

if($active_tab == 'addnotice')

{

	$notice_id=0;

	$edit=0;

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

	{	

		$notice_id=esc_attr($_REQUEST['notice_id']);				

		$edit=1;

		$result = get_post($notice_id);

	}

	?>

    <div class="panel-body padding_0"><!--PANEL BODY DIV START-->

		<form name="notice_form" action="" method="post" class="form-horizontal" id="notice_form" enctype="multipart/form-data"><!--NOTICE FORM START-->

			<?php 

			$action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

			<input type="hidden" name="notice_id" value="<?php echo esc_attr($notice_id);?>"  />

			<input type="hidden" name="notice_id" value="<?php if($edit){ echo esc_attr($result->ID);}?>"/> 

			<div class="header">	

				<h3 class="first_hed"><?php esc_html_e('Notice Information','gym_mgt');?></h3>

			</div>

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="notice_title" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->post_title);}?>" name="notice_title">

						 		<!-- <input type="hidden" name="notice_id" value="<?php if($edit){ echo esc_attr($result->ID);}?>"/>  -->

								<label class="" for="notice_title"><?php esc_html_e('Notice Title','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<!--nonce-->

					<?php wp_nonce_field( 'save_notice_nonce' ); ?>

					<!--nonce-->



					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

						<label class="ml-1 custom-top-label top" for="notice_for"><?php esc_html_e('Notice For','gym_mgt');?></label>

						<select name="notice_for" id="notice_for" class="form-control notice_for">

							<option value = "all"><?php esc_html_e('All','gym_mgt');?></option>

							<option value="staff_member" <?php if($edit) echo selected(get_post_meta( $result->ID, 'notice_for',true),'staff_member');?>><?php esc_html_e('Staff Members','gym_mgt');?></option>

							<option value="member" <?php if($edit) echo selected(get_post_meta( $result->ID, 'notice_for',true),'member');?>><?php esc_html_e('Member','gym_mgt');?></option>

							<option value="accountant" <?php if($edit) echo selected(get_post_meta( $result->ID, 'notice_for',true),'accountant');?>><?php esc_html_e('Accountant','gym_mgt');?></option>

						</select>

					</div>



					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 class_div input">

						<label class="ml-1 custom-top-label top" for="class_id"><?php esc_html_e('Class','gym_mgt');?></label>

						<?php 

						if($edit)

						{

							$class_id=get_post_meta($result->ID,'gmgt_class_id',true);

						}

						elseif(isset($_POST['class_id']))

						{

							$class_id=sanitize_text_field($_POST['class_id']);

						}

						else

						{

							$class_id='';

						}

						?>

						<select id="class_id" class="form-control" name="class_id">

							<option value=""><?php esc_html_e('Select Class','gym_mgt');?></option>

								<?php $classdata=$obj_class->MJ_gmgt_get_all_classes();

								if(!empty($classdata))

								{

									foreach ($classdata as $class)

									{?>

										<option value="<?php echo esc_attr($class->class_id);?>" <?php selected($class_id,$class->class_id);  ?>><?php echo esc_html($class->class_name); ?> </option>

										<?php 

									} 

								} ?>

						</select>

					</div>



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="notice_Start_date" class="start_date form-control validate[required] text-input date_picker"  type="text" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box(get_post_meta($result->ID,'gmgt_start_date',true)));}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));}?>" name="start_date" readonly>

								<label class="date_label" for="notice_content"><?php esc_html_e('Notice Start Date','gym_mgt');?><span class="require-field">*</span></label>

								

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="notice_end_date" class="end_date form-control validate[required] text-input date_picker"  type="text" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box(get_post_meta($result->ID,'gmgt_end_date',true)));}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));}?>" name="end_date" readonly>

								<label class="date_label" for="notice_content"><?php esc_html_e('Notice End Date','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>



					<div class="col-md-6 note_text_notice">

						<div class="form-group input">

							<div class="col-md-12 note_border margin_bottom_15px_res">

								<div class="form-field">

									<textarea name="notice_content" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="500" id="notice_content"><?php if($edit){ echo esc_attr($result->post_content);}?></textarea>

									<span class="txt-title-label"></span>

									<label class="text-area address active" for="notice_content"><?php esc_html_e('Notice Comment','gym_mgt');?></label>

								</div>

							</div>

						</div>

					</div>

					

					

					<div class="col-md-6">

						<div class="form-group input cmgt_document_list">

							<div class="col-md-12 form-control">

								<label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="Document"><?php esc_html_e('Document','gym_mgt');?></label>

								<!-- <div class="col-sm-2">

									<input type="text" readonly id="notice_document_url" class="form-control" name="notice_document"  

									value="<?php if($edit){ echo get_post_meta($result->ID,'gmgt_notice_document',true); } elseif(isset($_POST['notice_document'])){ echo $_POST['notice_document']; }?>" />

								</div>	 -->

								<div class="row">

									<div class="col-sm-8">

										<input type="hidden" name="hidden_upload_document" value="<?php if($edit){ echo get_post_meta($result->ID,'gmgt_notice_document',true); }elseif(isset($_POST['upload_document'])) echo $_POST['upload_document'];?>">

										<input id="upload_document" name="upload_document"  type="file" onchange="fileCheck(this);" class=""  />		

									</div>

									<div class="col-sm-3 col-md-3">

									<?php 

										if($edit)

										{

											if(!empty(get_post_meta($result->ID,'gmgt_notice_document',true)))

											{ ?>

												<a href="<?php echo content_url().'/uploads/gym_assets/'.$result->gmgt_notice_document;?>" class="btn btn-default" target="_blank"><i class="fa fa-download"></i> <?php esc_html_e('Download','gym_mgt');?></a>

												<?php 

											}

										}						

										?>

									</div>

								</div>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">

						<div class="form-group">

							<div class="col-md-12 form-control">

								<div class="row padding_radio">

									<div class="">

										<label class="custom-top-label" for="enable"><?php esc_html_e('Send Mail','gym_mgt');?></label>

										<input id="chk_sms_sent_mail" type="checkbox" <?php $gym_enable_notifications = 0;if($gym_enable_notifications) echo "checked";?> value="1" name="gym_enable_notifications"><?php esc_html_e('Enable','gym_mgt'); ?>

									</div>				 

								</div>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">

						<div class="form-group">

							<div class="col-md-12 form-control">

								<div class="row padding_radio">

									<div class="">

										<label class="custom-top-label" for="enable"><?php esc_html_e('Send SMS','gym_mgt');?></label>

										<input id="chk_sms_sent" type="checkbox" <?php $gmgt_sms_service_enable = 0;if($gmgt_sms_service_enable) echo "checked";?> value="1" name="gmgt_sms_service_enable"><?php esc_html_e('Enable','gym_mgt'); ?>

									</div>				 

								</div>

							</div>

						</div>

					</div>



					<div id="hmsg_message_sent" class="hmsg_message_none col-md-6 note_text_notice rtl_margin_top_15px">

						<div class="form-group input">

							<div class="col-md-12 note_border margin_bottom_15px_res">

								<div class="form-field">

									<textarea name="sms_template" class="textarea_height_47px form-control validate[required]" maxlength="160"></textarea>

									<span class="txt-title-label"></span>

									<label class="text-area address active" for="sms_template"><?php esc_html_e('SMS Text','gym_mgt');?><span class="require-field">*</span></label>

								</div>

							</div>

							<label><?php esc_html_e('Max. 160 Character','gym_mgt');?></label>

						</div>

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End--> 

			<!------------   save btn  -------------->  

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 

					<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  	

						<input type="submit" value="<?php if($edit){ esc_html_e('Save Notice','gym_mgt'); }else{ esc_html_e('Save Notice','gym_mgt');}?>" name="save_notice" class="btn save_btn"/>

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End--> 

		</form><!--NOTICE FORM END-->

    </div><!--PANEL BODY DIV START-->

<?php 

}

?>