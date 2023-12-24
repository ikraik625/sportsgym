<?php ?>



<script type="text/javascript">



	$(document).ready(function() 



	{



		"use strict";



		var member_limit='';



		$('#membership_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



		$('#activity_id').multiselect(



		{



			nonSelectedText :'<?php esc_html_e('Select Activity','gym_mgt');?>',



			includeSelectAllOption: true,



			allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



			selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



			templates: {



					button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



				},



			buttonContainer: '<div class="dropdown" />'



		});	



		$('#activity_category').multiselect(



		{



			nonSelectedText :'<?php esc_html_e('Select Activity Category','gym_mgt');?>',



			includeSelectAllOption: true,



			allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



			selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



			templates: {



					button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



				},



			buttonContainer: '<div class="dropdown" />'



		});



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



	});



</script>



<?php 	



if($active_tab == 'addmembership')



{	



	$membership_id=0;



	$edit=0;



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$membership_id=esc_attr($_REQUEST['membership_id']);



		$edit=1;



		$result = $obj_membership->MJ_gmgt_get_single_membership($membership_id);			



	}  



	?>		



    <div class="panel-body padding_0"><!--PANEL BODY DIV START-->



        <form name="membership_form" action="" method="post" class="form-horizontal" id="membership_form"><!--MEMBERSHIP FORM START-->



			 <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



			<input type="hidden" name="membership_id" class="membership_id_activity" value="<?php echo esc_attr($membership_id);?>"  />



			<div class="header">	



				<h3 class="first_hed"><?php esc_html_e('Membership Information','gym_mgt');?></h3>



			</div>



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="membership_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->membership_label);}elseif(isset($_POST['membership_name'])) echo esc_attr($_POST['membership_name']);?>" name="membership_name">



								<label class="" for="membership_name"><?php esc_html_e('Membership Name','gym_mgt');?><span class="require-field">*</span></label>



							</div>



						</div>



					</div>

					<!--nonce-->



					<?php wp_nonce_field( 'save_membership_nonce' ); ?>



					<!--nonce-->



					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">



						<label class="ml-1 custom-top-label top" for="membership_category"><?php esc_html_e('Membership Category','gym_mgt');?><span class="require-field">*</span></label>									



						<select class="form-control validate[required]  selectpicker span3 max_width_100" name="membership_category" id="membership_category">



							<option value=""><?php esc_html_e('Select Membership Category','gym_mgt');?></option>



							<?php 				



							if(isset($_REQUEST['membership_category']))



							{



								$category =esc_attr($_REQUEST['membership_category']);  



							}



							elseif($edit)



							{



								$category =$result->membership_cat_id;



							}



							else



							{



								$category = "";



							}



							$mambership_category=MJ_gmgt_get_all_category('membership_category');



							if(!empty($mambership_category))



							{



								foreach ($mambership_category as $retrive_data)



								{



									echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title) .'</option>';



								}



							}



							?>				



						</select>



					</div>



					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">		



						<button  id="addremove" class="btn add_btn " model="membership_category"><?php esc_html_e('Add','gym_mgt');?></button>



					</div>











					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="membership_period" class="form-control validate[required,custom[number]] text-input" min="0" type="number" onKeyPress="if(this.value.length==3) return false;" value="<?php if($edit){ echo esc_attr($result->membership_length_id);}elseif(isset($_POST['membership_period'])) echo esc_attr($_POST['membership_period']);?>" name="membership_period" placeholder="<?php esc_html_e('Enter Total Number of Days','gym_mgt');?>">



								<label class="" for="membership_period"><?php esc_html_e('Membership Period(Days)','gym_mgt');?><span class="require-field">*</span></label>



							</div>



						</div>



					</div>



					



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="membership_amount" class="form-control text-input validate[required]" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($result->membership_amount);}elseif(isset($_POST['membership_amount'])) echo esc_attr($_POST['membership_amount']);?>" name="membership_amount" placeholder="<?php esc_html_e('Amount','gym_mgt');?>">



								<label class="" for="installment_amount"><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)<span class="require-field">*</span></label>



							</div>



						</div>



					</div>



				</div><!--Row Div End--> 



			</div> <!-- user_form End-->  		







			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 



					



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_15px rtl_margin_top_15px">



						<div class="form-group">



							<div class="col-md-12 form-control">



								<div class="row padding_radio">



									<div class="input-group">



										<label class="custom-top-label" for="member_limit"><?php esc_html_e('Members Limit','gym_mgt');?></label>



										<div class="d-inline-block gender_line_height_24px">



											<?php $limitval = "unlimited"; if($edit){ $limitval=$result->membership_class_limit; }elseif(isset($_POST['gender'])) {$limitval=sanitize_text_field($_POST['gender']);}?>



											<label class="radio-inline custom_radio">



												<input type="radio" value="limited" class="tog radio_class_member" name="member_limit" <?php checked('limited',esc_html($limitval)); ?>/><?php esc_html_e('limited','gym_mgt');?>



											</label>



											<label class="radio-inline custom_radio">



												<input type="radio" value="unlimited" class="tog radio_class_member" name="member_limit" <?php checked('unlimited',esc_html($limitval)); ?>/><?php esc_html_e('unlimited','gym_mgt');?> 



											</label>



										</div>



									</div>



								</div>		



							</div>



						</div>



					</div>



					



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_15px rtl_margin_top_15px">



						<div class="form-group">



							<div class="col-md-12 form-control">



								<div class="row padding_radio">



									<div class="input-group">



										<label class="custom-top-label" for="classis_limit"><?php esc_html_e('Class Limit','gym_mgt');?></label>



										<div class="d-inline-block gender_line_height_24px">



											<?php $limitvals = "unlimited"; if($edit){ $limitvals=$result->classis_limit; }elseif(isset($_POST['gender'])) {$limitvals=sanitize_text_field($_POST['gender']);}?>



											<label class="radio-inline">



												<input type="radio" value="limited" class="classis_limit" name="classis_limit" <?php checked('limited',esc_html($limitvals)); ?>/><?php esc_html_e('limited','gym_mgt');?>



											</label>



											<label class="radio-inline">



												<input type="radio" value="unlimited" class="classis_limit validate[required]" name="classis_limit" <?php checked('unlimited',esc_html($limitvals)); ?>/><?php esc_html_e('unlimited','gym_mgt');?> 



											</label>



										</div>



									</div>



								</div>



							</div>		



						</div>



					</div>







					<div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div id="member_limit" class=""></div>



						<?php 



						if($edit)



						{



							if($result->membership_class_limit!='unlimited')



							{ 



								?>



								<div id="on_of_member_box" class="form-group input">



									<div class="col-md-12 form-control">



										<input id="on_of_member" class="form-control text-input" type="number" min="0" onkeypress="if(this.value.length==4) return false;" value="<?php print esc_attr($result->on_of_member) ?>" name="on_of_member">



										<label class="active" for="on_of_member"><?php esc_html_e('No Of Member','gym_mgt');?></label>



									</div>



								</div>



								<?php 



							}



						}



						?>



					</div>







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div id="classis_limit" class=""></div>



						<?php



						if($edit)



						{



							if($result->classis_limit!='unlimited')



							{ 



							?>



								<div id="on_of_classis_box" class="form-group input">



									<div class="col-md-12 form-control">



										<input id="on_of_classis" class="form-control  text-input" type="number" min="0" onkeypress="if(this.value.length==4) return false;" value="<?php print esc_attr($result->on_of_classis) ?>" name="on_of_classis">



										<label class="active radio_class_member" for="on_of_classis"><?php esc_html_e('No Of Class','gym_mgt');?></label>



									</div>



								</div>



							<?php



							} 



						} 



						?>



					</div>



				</div><!--Row Div End--> 



			</div> <!-- user_form End-->  







			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 	







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="installment_amount" class="form-control text-input" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" type="number" value="<?php if($edit){ echo esc_attr($result->installment_amount);}elseif(isset($_POST['installment_amount'])) echo esc_attr($_POST['installment_amount']);?>" name="installment_amount" placeholder="<?php esc_html_e('Amount','gym_mgt');?>">



								<label class="" for="installment_plan"><?php esc_html_e('Installment Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>



							</div>



						</div>



					</div>



					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">



						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Installment Plan','gym_mgt');?></label>



						<select class="form-control form-label max_width_100" name="installment_plan" id="installment_plan">



							<option value=""><?php esc_html_e('Select Installment Plan','gym_mgt');?></option>



							<?php



							if(isset($_REQUEST['installment_plan']))



							{



								$category =esc_attr($_REQUEST['installment_plan']);  



							}



							elseif($edit)



							{



								$category =$result->install_plan_id;



							}



							else



							{	



								$category = "";



							}



							$installment_plan=MJ_gmgt_get_all_category('installment_plan');



							if(!empty($installment_plan))



							{



								foreach ($installment_plan as $retrive_data)



								{



									echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';



								}



							}



							?>



						</select>



					</div>



					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">		



						<button id="addremove"  class="btn add_btn " model="installment_plan"><?php esc_html_e('Add','gym_mgt');?></button>



					</div>



						



					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="signup_fee" class="form-control text-input" min="0"  onkeypress="if(this.value.length==8) return false;" step="0.01" type="number" value="<?php if($edit){ echo esc_attr($result->signup_fee);}elseif(isset($_POST['membership_name'])) echo esc_attr($_POST['membership_name']);?>" name="signup_fee" placeholder="<?php esc_html_e('Amount','gym_mgt');?>" >



								<label class="" for="signup_fee"><?php esc_html_e('Signup Fee','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>



							</div>



						</div>



					</div>







					<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



						<!-- <label class="col-sm-2 control-label form-label" for=""><?php esc_html_e('Tax','gym_mgt');?>(%)</label> -->



						<select  class="form-control tax_charge" name="tax[]" multiple="multiple">



							<?php



							if($edit)



							{



								$tax_id=explode(',',$result->tax);



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



									<option value="<?php echo esc_attr($data->tax_id); ?>" <?php echo esc_html($selected); ?> ><?php echo esc_html($data->tax_title);?> - <?php echo esc_html($data->tax_value);?></option>



								<?php



								}



							}



							?>



						</select>



					</div>







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



						<!-- <label class="col-sm-2 control-label form-label" for="activity_category"><?php esc_html_e('Select Activity Category','gym_mgt');?></label> -->



						<?php



						if($edit)



						{



						?>



							<input type="hidden" class="action_membership" value="edit_membership">



						<?php



						}



						else



						{



						?>



							<input type="hidden" class="action_membership" value="add_membership">



						<?php



						}



						?>



						<select class="form-control activity_category_list activity_width_title" name="activity_cat_id[]" multiple="multiple" id="activity_category"><?php 



							$activity_category=MJ_gmgt_get_all_category('activity_category');



							if($edit)



							{



								$activity_category_array=explode(',',$result->activity_cat_id);



							}



							else



							{	



								$activity_category_array[]='';



							}



							



							if(!empty($activity_category))



							{



								foreach ($activity_category as $retrive_data)



								{		



									$selected = "";



									if(in_array($retrive_data->ID,$activity_category_array))



										$selected = "selected";



									?>



										<option value="<?php echo esc_attr($retrive_data->ID);?>" <?php echo esc_html($selected); ?>><?php echo esc_html($retrive_data->post_title);?></option>



									<?php



								}



							}



							?>



						</select>



					</div>







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



						<!-- <label class="col-sm-2 control-label form-label" for="signup_fee"><?php esc_html_e('Select Activity','gym_mgt');?></label> -->



						<?php 



						$activitydata=$obj_activity->MJ_gmgt_get_all_activity_by_activity_category($activity_category_array); ?>



						<select name="activity_id[]" id="activity_id" multiple="multiple" class="activity_list_from_category_type">		 <?php 



							$activity_array = $obj_activity->MJ_gmgt_get_membership_activity($membership_id);



							if(!empty($activitydata))



							{



								foreach($activitydata as $activity)



								{



									?>



									<option value="<?php echo esc_attr($activity->activity_id);?>" <?php if(in_array($activity->activity_id,$activity_array)) echo "selected";?>><?php echo esc_html($activity->activity_title);?></option>



								<?php



								}



							}



							?>



						</select>



					</div>







					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



						<label class="ml-1 custom-top-label top" for="signup_fee"><?php esc_html_e('Membership Description','gym_mgt');?></label>



						<div class="form-control">



							<?php 



							wp_editor(isset($result->membership_description)?stripslashes($result->membership_description) : '','description'); 



							?>



						</div>



					</div>	







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px">



						<div class="form-group input">



							<div class="col-md-12 form-control upload-profile-image-patient">



								<label class="ustom-control-label custom-top-label ml-2" for="gmgt_membershipimage"><?php esc_html_e('Image','gym_mgt');?></label>



								<div class="col-sm-12 display_flex">



									<input type="text" id="gmgt_gym_background_image" class="form-control" name="gmgt_membershipimage" readonly value="<?php if($edit){ echo esc_attr($result->gmgt_membershipimage);}elseif(isset($_POST['gmgt_membershipimage'])) echo esc_attr($_POST['gmgt_membershipimage']);?>" />	



									<input id="upload_image_button" type="button" class="button upload_image_btn upload_user_cover_button" style="float: right;" value="<?php esc_html_e('Upload Cover Image','gym_mgt'); ?>" />



								</div>



							</div>



							<div class="clearfix"></div>



							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">



								



								<div id="upload_gym_cover_preview" >



									<?php 



									if($edit) 



									{



										if($result->gmgt_membershipimage == "")



										{ ?>



											<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_Membership_logo' )); ?>">



											<?php 



										}



										else 



										{



											?>



											<img class="image_preview_css" src="<?php if($edit)echo esc_url( $result->gmgt_membershipimage ); ?>" />



											<?php 



										}



									}



									else 



									{



										?>



										<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_Membership_logo' )); ?>">



										<?php 



									} 



									



									?>



								</div>



							</div>



						</div>



					</div>



					



				</div><!--Row Div End--> 



			</div><!-- user_form End-->



					



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat-->







					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px">



						<div class="form-group">



							<div class="col-md-12 form-control">



								<div class="row padding_radio">



									<div class="">



										<label class="custom-top-label" for="gmgt_membershipimage"><?php esc_html_e('Frontend Membership Booking','gym_mgt');?></label>



										<input type="checkbox" class="check_box_input_margin" name="gmgt_membership_class_book_approve" value="yes" <?php if($edit){ if($result->gmgt_membership_class_book_approve == 'yes') { echo 'checked'; } }?> /> <?php esc_html_e('Enable','gym_mgt'); ?>



									</div>												



								</div>



							</div>



						</div>



					</div>







					<?php



					$gym_recurring_enable=get_option("gym_recurring_enable");

					$gym_recurring_invoice_enable=get_option("gym_recurring_invoice_enable");



					if($gym_recurring_enable == "yes" || $gym_recurring_invoice_enable == "yes")



					{



						?>



						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 responsive_margin_20px rtl_margin_top_15px">



							<div class="form-group">



								<div class="col-md-12 form-control">



									<div class="row padding_radio">



										<div class="">



											<label class="custom-top-label" for="gmgt_membership_recurring"><?php esc_html_e('Membership Recurring Invoices','gym_mgt');?></label>



											<input type="checkbox" class="check_box_input_margin" name="gmgt_membership_recurring" value="yes" <?php if($edit){ if($result->gmgt_membership_recurring == 'yes') { echo 'checked'; } }?> /> <?php esc_html_e('Enable','gym_mgt'); ?>



										</div>												



									</div>



								</div>
								

							</div>

					
						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 responsive_margin_20px rtl_margin_top_15px">



							<div class="form-group">



								<div class="col-md-12 form-control">



									<div class="row padding_radio">



										<div class="">



											<label class="custom-top-label" for="gmgt_membership_recurring"><?php esc_html_e('Membership Recurring Invoices','gym_mgt');?></label>



											<input type="checkbox" class="check_box_input_margin" name="gmgt_membership_recurring" value="yes" <?php if($edit){ if($result->gmgt_membership_recurring == 'yes') { echo 'checked'; } }?> /> <?php esc_html_e('Enable','gym_mgt'); ?>



										</div>												



									</div>



								</div>
								

							</div>

					
						</div>



						<?php



					}



					?>



				</div><!--Row Div End--> 



			</div><!-- user_form End--> 



			<div class="form-body user_form">



				<div class="row">



					<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><!--save btn--> 



						<input type="submit" value="<?php if($edit){ esc_html_e('Save Membership','gym_mgt'); }else{ esc_html_e('Add Membership','gym_mgt');}?>" name="save_membership" class="btn save_btn"/>



					</div>



				</div><!--Row Div End--> 



			</div><!-- user_form End--> 



		</form><!--MEMBERSHIP FORM END-->



    </div>  <!--PANEL BODY DIV END-->



<?php 



}



?>