<script type="text/javascript">

	$(document).ready(function() 

	{

		"use strict";

		$('#message_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

		$('[data-toggle="tooltip"]').tooltip(); 

		jQuery("body").on("change", ".input-file[type=file]", function ()

		{ 

			var file = this.files[0]; 		

			var ext = $(this).val().split('.').pop().toLowerCase(); 

			//Extension Check 

			if($.inArray(ext, [,'pdf','doc','docx','xls','xlsx','ppt','pptx','gif','png','jpg','jpeg','']) == -1)

			{

				alert('<?php esc_html_e("Only pdf,doc,docx,xls,xlsx,ppt,pptx,gif,png,jpg,jpeg formate are allowed.","gym_mgt") ?>');

				$(this).replaceWith('<input class="btn_top input-file" name="message_attachment[]" type="file" />');

				return false; 

			} 

			//File Size Check 

			if (file.size > 20480000) 

			{

				alert("<?php esc_html_e('Too large file Size. Only file smaller than 10MB can be uploaded.','gym_mgt');?>");

				$(this).replaceWith('<input class="btn_top input-file" name="message_attachment[]" type="file" />'); 

				return false; 

			}

		}); 

		$('.onlyletter_number_space_validation').keypress(function( e ) 

		{     

			var regex = new RegExp("^[0-9a-zA-Z \b]+$");

			var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);

			if (!regex.test(key)) 

			{

				event.preventDefault();

				return false;

			} 

		}); 
		$(".display-members").select2();

	} );

	function add_new_attachment()

	{

		$(".attachment_div").append('<div class="row"><div class="col-md-10"><div class="form-group input"><div class="col-md-12 form-control"><label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="photo"><?php esc_html_e('Attachment','gym_mgt');?></label><div class="col-sm-12"><input  class="col-md-12 input-file" name="message_attachment[]" type="file" /></div></div></div></div><div class="col-sm-2 mb-3 rtl_margin_top_15px"><input type="image" onclick="delete_attachment(this)" alt="" src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" class="remove_cirtificate doc_label float_right input_btn_height_width"></div></div>');

	}

	function delete_attachment(n)

	{

		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);				

	}

</script>

<div class="mailbox-content padding_0"><!--MAILBOX CONTENT DIV STRAT-->

	<h2>

		<?php  
	
		$edit=0;

		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

		{

			 echo esc_html__( 'Edit Message', 'gym_mgt');

			 $edit=1;

			 $exam_data= get_exam_by_id($_REQUEST['exam_id']);

		}

		?>

	</h2>

	<?php
	if(!empty($message))
	{
	
		if(isset($message))

		{

			echo '<div id="message" class="updated below-h2"><p>'.esc_html($message).'</p></div>';

		}
	}
	?>

	<form name="class_form" action="" method="post" class="form-horizontal padding_bottom_50" id="message_form" enctype="multipart/form-data"><!--COMPOSE MAIL FORM STRAT-->

		<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

					<!-- <label class="ml-1 custom-top-label top" for="to"><?php esc_html_e('Message To','gym_mgt');?><span class="require-field">*</span></label> -->

					<select name="receiver" class="form-control text-input receiver message_to display-members" id="to">

						<option value="member"><?php esc_html_e('Members','gym_mgt');?></option>	

						<option value="staff_member"><?php esc_html_e('Staff Members','gym_mgt');?></option>

						<option value="accountant"><?php esc_html_e('Accountants','gym_mgt');?></option>	

						<?php echo MJ_gmgt_get_all_user_in_message();?>

					</select>

				</div>

				<!--nonce-->

				<?php wp_nonce_field( 'save_message_nonce' ); ?>

				<!--nonce-->

				<div id="smgt_select_class" class="display_class_css col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

					<label class="ml-1 custom-top-label top" for="sms_template"><?php esc_html_e('Select Class','gym_mgt');?></label>

					<select name="class_id"  id="class_list" class="form-control">

						<option value="all"><?php esc_html_e('All','gym_mgt');?></option>

						<?php

						foreach(MJ_gmgt_get_allclass() as $classdata)

						{  

							?>

							<option  value="<?php echo esc_attr($classdata['class_id']);?>"><?php echo esc_html($classdata['class_name']);?></option>

							<?php 

						}?>

					</select>

				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="subject" class="form-control validate[required,custom[popup_category_validation]] text-input onlyletter_number_space_validation" maxlength="100" type="text" name="subject" >

							<label class="" for="subject"><?php esc_html_e('Subject','gym_mgt');?><span class="require-field">*</span></label>

						</div>

					</div>

				</div>

				<div class="col-md-6 note_text_notice">

					<div class="form-group input">

						<div class="col-md-12 note_border margin_bottom_15px_res">

							<div class="form-field">

								<textarea name="message_body" id="message_body" class="textarea_height_47px form-control validate[required] text-input" maxlength="500"></textarea>

								<span class="txt-title-label"></span>

								<label class="text-area address activ" for="subject"><?php esc_html_e('Message Comment','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

				</div>

				<div id="hmsg_message_sent" class="col-md-6 hmsg_message_none note_text_notice">

					<div class="form-group input">

						<div class="col-md-12 note_border margin_bottom_15px_res">

							<div class="form-field">

								<textarea name="sms_template" class="form-control validate[required,custom[address_description_validation]]" maxlength="160"></textarea>

								<span class="txt-title-label"></span>

								<label class="text-area address activ" for="sms_template"><?php esc_html_e('SMS Text','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

						<label><?php esc_html_e('Max. 160 Character','gym_mgt');?></label>

					</div>

				</div>

			</div><!--Row Div End--> 

		</div><!-- user_form End--> 

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-md-6 attachment_div">

					<div class="row">



						<div class="col-md-10">	

							<div class="form-group input">

								<div class="col-md-12 form-control">	



									<label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="photo"><?php esc_html_e('Attachment','gym_mgt');?></label>

									<div class="col-sm-12">	

										<input  class="col-md-12 input-file" name="message_attachment[]" type="file" />

									</div>

								</div>

							</div>

						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 mb-3 rtl_margin_top_15px">	

							<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_new_attachment()" alt="" class="more_attachment add_cirtificate float_right" id="add_more_sibling">

							<!-- <input type="button" value="<?php esc_html_e('Add More Attachment','gym_mgt') ?>"  onclick="add_new_attachment()" class="btn more_attachment btn-primary"> -->

						</div>

					</div>

				</div>	

			</div><!--Row Div End--> 

		</div><!-- user_form End--> 



		<?php 

		if($user_access_add == '1')

		{ ?>

		<!------------   save btn  -------------->  

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  	

					<input type="submit" value="<?php if($edit){ esc_html_e('Save Message','gym_mgt'); }else{ esc_html_e('Send Message','gym_mgt');}?>" name="save_message" class="btn save_btn"/>

				</div>

			</div><!--Row Div End--> 

		</div><!-- user_form End--> 

			<?php 

		} ?>



	</form><!--COMPOSE MAIL FORM END-->

</div><!--MAILBOX CONTENT DIV END-->