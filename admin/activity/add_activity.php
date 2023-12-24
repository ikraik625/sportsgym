<?php ?>



<script type="text/javascript">



$(document).ready(function()



{



	"use strict";



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



	$('#activity_category1').multiselect(



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



	$('#membership_id').multiselect(



	{



		nonSelectedText :'<?php esc_html_e('Select Membership','gym_mgt');?>',



		includeSelectAllOption: true,



		allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



	    selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



		templates: {



	            button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



	        },



		buttonContainer: '<div class="dropdown" />'



	});	



	$('#acitivity_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



	$('#add_staff_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



	$('#membership_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



	$('#specialization').multiselect(



	{



		nonSelectedText :'<?php esc_html_e('Select specialization','gym_mgt');?>',



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



    $(".specialization_submit").on('click',function()



	{



		var checked;



		var checked = $(".multiselect_validation_specialization .dropdown-menu input:checked").length;



		if(!checked) 



		{



		  alert("<?php esc_html_e('Please select atleast one specialization name','gym_mgt');?>");



		  return false;



		}	



    }); 



   	$(".membership_submit").on('click',function()



	{



		var checked;



		//var value=$(".multiselect_validation .dropdown-menu input:checked").val();



		 checked = $(".multiselect_validation").val();



		if(checked == '')



		{



		  	alert("<?php esc_html_e('Please select atleast one membership','gym_mgt');?>");



		  	return false;



		}



	});



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



   jQuery('.birth_date').datepicker(



   {



		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



		maxDate : 0,



		changeMonth: true,



        changeYear: true,



        yearRange:'-65:+25',



		beforeShow: function (textbox, instance) 



		{



			instance.dpDiv.css(



			{



				marginTop: (-textbox.offsetHeight) + 'px'                   



			});



		},    



        onChangeMonthYear: function(year, month, inst) {



            jQuery(this).val(month + "/" + year);



        }                 



	});



	//------ADD STAFF MEMBER AJAX----------



	$('#add_staff_form').on('submit', function(e)



	{



		e.preventDefault();



		var form = $(this).serialize();



		var valid = $('#add_staff_form').validationEngine('validate');



		if (valid == true) 



		{		



			$.ajax({



				type:"POST",



				url: $(this).attr('action'),



				data:form,



				success: function(data){



					if(data!='0')



					{				



						if(data!="")



						{ 



							$('#add_staff_form').trigger("reset");



							$('#staff_id').append(data);



							$('.upload_user_avatar_preview').html('<img class="image_preview_css" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">');



							$('.gmgt_user_avatar_url').val('');



						}



						$('.modal').modal('hide');



						$('.show_msg').css('display','none');



					}



					else



					{				



						$('.show_msg').css('display','block');



					}					



				},



				error: function(data){



				}



			})



		}



	});



	//------ADD MEMBERSHIP AJAX----------



	$('#membership_form').on('submit', function(e) 



	{



		e.preventDefault();



		var form = $(this).serialize();



		var valid = $('#membership_form').validationEngine('validate');



		if (valid == true)



		{			



			var categCheck_membership = $('#membership_id').multiselect();



			$.ajax({



				type:"POST",



				url: $(this).attr('action'),



				data:form,



				success: function(data){



					if(data!='0')



					{



						if(data!="")



						{ 



							$('#membership_form').trigger("reset");



							$('#membership_id').append(data);



							categCheck_membership.multiselect('rebuild');	



						}



						$('.modal').modal('hide');



						$('.show_msg').css('display','none');



					}



					else



					{				



						$('.show_msg').css('display','block');



					}	



				},



				error: function(data){



				}



			})



		}



	});



} );



</script>



<?php	



if($active_tab == 'addactivity')



{



	$activity_id=0;



	$edit=0;



	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



	{



		$edit=1;



		$activity_id=esc_attr($_REQUEST['activity_id']);



		$result = $obj_activity->MJ_gmgt_get_single_activity($activity_id);



	}



	?>



	<div class="panel-body padding_0"><!-- PANEL BODY DIV START-->



		<form name="acitivity_form" action="" method="post" class="form-horizontal" id="acitivity_form"><!-- ACTIVITY FORM START-->



			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



			<input type="hidden" name="activity_id" value="<?php echo esc_attr($activity_id);?>" />



			



			<div class="header">	



				<h3 class="first_hed"><?php esc_html_e('Activity Information','gym_mgt');?></h3>



			</div>



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 







					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">



						<label class="ml-1 custom-top-label top" for="activity_category"><?php esc_html_e('Activity Category','gym_mgt');?><span class="require-field">*</span></label>	



						<select class="form-control activity_cat_to_staff validate[required] max_width_100" name="activity_cat_id" id="activity_select">



							<option value=""><?php esc_html_e('Select Activity Category','gym_mgt');?></option>



							<?php 



							if(isset($_REQUEST['activity_cat_id']))



							{



								$category =esc_attr($_REQUEST['activity_cat_id']);  



							}



							elseif($edit)



							{



								$category =$result->activity_cat_id;



							}



							else



							{ 



								$category = "";



							}



							$activity_category=MJ_gmgt_get_all_category('activity_category');



							if(!empty($activity_category))



							{



								foreach ($activity_category as $retrive_data)



								{



									echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';



								}



							}?>



						</select>



					</div>



					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">



						<button id="addremove" class="btn add_btn" model="activity_category"><?php esc_html_e('Add','gym_mgt');?></button>



					</div>



			



					<div class="col-member_type-6 col-lg-6 col-xl-6 ">member_typemember_typemember_typemember_type

member_type

						<div class="form-group input">



							<div class="col-md-12 form-control">



								<input id="activity_title" class="form-control validate[required,custom[popup_category_validation]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->activity_title);}elseif(isset($_POST['activity_title'])) echo esc_attr($_POST['activity_title']);?>" name="activity_title">



								<label class="" for="activity_title"><?php esc_html_e('Activity Title','gym_mgt');?><span class="require-field">*</span>



								</label>



							</div>



						</div>



					</div>



					<?php wp_nonce_field( 'save_activity_nonce' ); ?>







					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">



						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Assign to Staff Member','gym_mgt');?><span class="require-field">*</span>



						</label>	



						<select name="staff_id" class="form-control validate[required] category_to_staff_list max_width_100" id="staff_id">



							<option value=""><?php esc_html_e('Select Staff Member','gym_mgt');?></option>



							<?php 



							if($edit)



							{	



								$get_staff = array('role' => 'Staff_member');



								$staffdata=get_users($get_staff);	



								$staff_data=$result->activity_assigned_to;



								if(!empty($staffdata))



								{



									foreach($staffdata as $staff)



									{	



										$staff_specialization=explode(',',$staff->activity_category);



										if(in_array($result->activity_cat_id,$staff_specialization))



										{	



											echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).'</option>';



										}



									}



								} 



							}



							?>



						</select>



					</div>



					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">			



						<button type="button" class="btn add_btn" data-bs-toggle="modal" data-bs-target="#myModal_add_staff_member123"> <?php esc_html_e('Add','gym_mgt');?></button>			



					</div>



		



					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



						<?php $membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>



						<select name="membership_id[]" class="form-control  multiselect_validation" multiple="multiple" id="membership_id">



							<?php $getmembership_array=array();



							if($edit)



							{



								$getmembership_array=$obj_activity->MJ_gmgt_get_activity_membership($activity_id);



							}



							elseif(isset($_REQUEST['membership_id']))



							{



								$getmembership_array[]=esc_attr($_REQUEST['membership_id']);



							}



							if(!empty($membershipdata))



							{



								foreach ($membershipdata as $membership){?>



									<option value="<?php echo esc_attr($membership->membership_id);?>" <?php if(in_array($membership->membership_id,$getmembership_array)) echo "selected";?> ><?php echo esc_html($membership->membership_label);?></option>



							<?php }



							} ?>



						</select>



					</div>



					<div class="col-sm-1 col-md-1 col-lg-1 res_margin_bottom_20px rtl_margin_top_15px">				



						<button type="button" class="btn add_btn" data-bs-toggle="modal" data-bs-target="#myModal_add_membership"> <?php esc_html_e('Add','gym_mgt');?></button>



					</div>











					<div class="income_entry_div">



						<?php 					



						if($edit)



						{



							$all_entry=json_decode($result->video_entry);



						}



						else



						{



							if(isset($_POST['video_entry']))



							{		



								$all_data=$obj_activity->MJ_gmgt_get_entry_video($_POST);



								$all_entry=json_decode($all_data);



							}



						}



						if(!empty($all_entry))



						{



							$i=0;



							foreach($all_entry as $entry)



							{



								?>



								<div class="form-body user_form income_fld">



									<div class="row">



										<div class="col-md-6">



											<div class="form-group input">



												<div class="col-md-12 form-control">



													<input id="income_amount" class="form-control text-input" type="text"  value="<?php echo esc_attr($entry->video_title);?>" name="video_title[]" placeholder="<?php esc_html_e('Video title','gym_mgt');?>">



													<label class="" for="income_entry"><?php esc_html_e('Video title','gym_mgt');?></label>



												</div>



											</div>



										</div>



										<div class="col-md-5">



											<div class="form-group input">



												<div class="col-md-12 form-control">



													<input id="income_entry" class="form-control text-input onlyletter_space_validation1" type="text" maxlength="50" value="<?php echo esc_attr($entry->video_link);?>" name="video_link[]" placeholder="<?php esc_html_e('Ex: https://www.youtube.com/embed/X_9VoqR5ojM','gym_mgt');?>">



													<label class="" for="income_entry"><?php esc_html_e('Video Link','gym_mgt');?></label>



												</div>



											</div>



										</div>



										<?php



										if($i == 0 )



										{ 



											?>



											<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



											</div>



											<?php



										}



										else



										{



											?>



											<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt="">



											</div>



											<?php



										}



										?>



										



										<!-- <div class="col-sm-2">



											<button type="button" class="btn btn-default" onclick="deleteParentElement(this)"><i class="entypo-trash"><?php esc_html_e('Delete33','gym_mgt');?></i>



											</button>



										</div> -->



									</div>	



								</div>



								<?php



								$i++;



							}						



						}



						else



						{	?>



							<div class="form-body user_form">



								<div class="row">



									<div class="col-md-6">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="income_amount" class="form-control text-input" type="text"  value="" name="video_title[]" placeholder="<?php esc_html_e('Video title','gym_mgt');?>" >



												<label class="" for="income_entry"><?php esc_html_e('Video title','gym_mgt');?> </label>



											</div>



										</div>



									</div>



									<div class="col-md-5">



										<div class="form-group input">



											<div class="col-md-12 form-control">



												<input id="income_entry" class="form-control text-input"  type="text" value="" name="video_link[]" placeholder="<?php esc_html_e('Ex: https://www.youtube.com/embed/X_9VoqR5ojM','gym_mgt');?>">



												<label class="" for="income_entry"><?php esc_html_e('Video Link','gym_mgt');?> </label>



											</div>



										</div>



									</div>



									<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



										<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr" id="add_new_entry">



									</div>



								</div>



							</div>



							<?php 



						} ?>



					</div>			



				</div><!--Row Div End--> 



			</div><!-- user_form End--> 



			<!------------   save btn  -------------->  



			<div class="form-body user_form"> <!-- user_form Strat-->   



				<div class="row"><!--Row Div Strat--> 



					<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  



						<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_activity" class="btn save_btn membership_submit"/>



					</div>



				</div><!--Row Div End--> 



			</div><!-- user_form End-->



		</form><!--Activity FORM END-->



	</div><!-- PANEL BODY DIV END-->



	<script>



		// CREATING BLANK INVOICE ENTRY



		var blank_income_entry ='';



		$(document).ready(function()



		{



			"use strict"; 



			blank_income_entry = $('.income_entry_div').html();			



		});



		function add_entry()



		{   		



			jQuery(".income_entry_div").append('<div class="form-body user_form income_fld"><div class="row"><div class="col-md-6"><div class="form-group input"><div class="col-md-12 form-control"><input id="income_amount" class="form-control text-input" type="text"  value="" name="video_title[]" placeholder="<?php esc_html_e('Video title','gym_mgt');?>" ><label class="active" for="income_entry"><?php esc_html_e('Video title','gym_mgt');?> </label></div></div></div><div class="col-md-5"><div class="form-group input"><div class="col-md-12 form-control"><input id="income_entry" class="form-control text-input" placeholder="<?php esc_html_e('Ex: https://www.youtube.com/embed/X_9VoqR5ojM','gym_mgt');?>"  type="text" value="" name="video_link[]"><label class="active" for="income_entry"><?php esc_html_e('Video Link','gym_mgt');?></label></div></div></div><div class="col-md-1 symptoms_deopdown_div rtl_margin_top_15px mb-3"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div>');



		}







		// REMOVING INVOICE ENTRY



		function deleteParentElement(n)



		{



			"use strict";



			var alert_msg=confirm("<?php esc_html_e('Do you really want to delete this record','gym_mgt');?>");



			if(alert_msg == false)



			{



				return false;



			}



			else



			{



				n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);



				return true;



			}



		}



	 </script>



<?php 



}



?>



<!----------ADD STAFF MEMBER POPUP------------->



<style type="text/css">



	.dropdown .multiselect {



    min-width: 105px;



}



</style>



<div class="modal fade" id="myModal_add_staff_member123" tabindex="-1" aria-labelledby="myModal_add_staff_member123" aria-hidden="true" role="dialog"><!-- MODAL MAIN DIV START-->



    <div class="modal-dialog modal-lg"><!-- MODAL DIALOG DIV START-->



		<div class="modal-content float_and_width"><!-- MODAL CONTENT DIV START-->



			<div class="modal-header float_left_width_100 mb-3 pop_btn_bg">



				<h3 class="modal-title float_left"><?php esc_html_e('Add Staff Member','gym_mgt');?></h3>



				<button type="button" class="close float_right" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></button>



			</div>



			<div class="modal-body float_and_width"><!-- MODAL BODY DIV START-->



				<form name="staff_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal float_and_width" id="add_staff_form" enctype="multipart/form-data">	<!-- Staff MEMBER FORM START-->



					<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



					<input type="hidden" name="action" value="MJ_gmgt_add_staff_member">



					<input type="hidden" name="role" value="staff_member" />



					<input type="hidden" name="user_id" value="<?php echo esc_attr($staff_member_id);?>"  />



					



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Personal Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat-->



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->first_name);}elseif(isset($_POST['first_name'])) echo esc_attr($_POST['first_name']);?>" name="first_name" >



										<label class="" for="first_name"><?php esc_html_e('First Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="middle_name" class="form-control validate[custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->middle_name);}elseif(isset($_POST['middle_name'])) echo esc_attr($_POST['middle_name']);?>" name="middle_name" >



										<label class="" for="middle_name"><?php esc_html_e('Member Type','gym_mgt');?></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="last_name" class="form-control validate[custom[onlyLetter_specialcharacter]] text-input"  maxlength="50" text-input="" type="text" value="<?php if($edit){ echo esc_attr($user_info->last_name);}elseif(isset($_POST['last_name'])) echo esc_attr($_POST['last_name']);?>" name="last_name" >



										<label class="" for="last_name"><?php esc_html_e('Last Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



								<div class="form-group">



									<div class="col-md-12 form-control">



										<div class="row padding_radio">



											<div class="input-group">



												<label class="custom-top-label" for="gender"><?php esc_html_e('Gender','gym_mgt');?><span class="require-field">*</span></label>



												<div class="col-sm-7 marign_left_20_res">



													<?php $genderval = "male"; if(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>



													<label class="radio-inline custom_radio">



														<input type="radio" value="male" class="tog" name="gender" <?php checked( 'male', esc_html($genderval)); ?> /><?php esc_html_e('Male','gym_mgt');?>



													</label>



													<label class="radio-inline custom_radio">



														<input type="radio" value="female" class="tog" name="gender" <?php checked( 'female', esc_html($genderval)); ?>/><?php esc_html_e('Female','gym_mgt');?>



													</label>



												</div>



											</div>



										</div>



									</div>		



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input  class="form-control validate[required] birth_date" type="text"  name="birth_date" value="<?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); ?>"  readonly>



										<label class="date_of_birth_label" for="birth_date"><?php esc_html_e('Date of birth','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">



								<label class="ml-1 custom-top-label top" for="role_type"><?php esc_html_e('Assign Role','gym_mgt');?><span class="require-field">*</span></label>



								<select class="form-control" name="role_type" id="role_type" >



									<option value=""><?php esc_html_e('Select Role','gym_mgt');?></option>



									<?php



									if(isset($_REQUEST['role_type']))



									{



										$category =esc_attr($_REQUEST['role_type']);  



									}



									elseif($edit)



									{



										$category =$user_info->role_type;



									}



									else



									{ 



										$category = "";



									}



									$role_type=MJ_gmgt_get_all_category('role_type');



									if(!empty($role_type))



									{



										foreach ($role_type as $retrive_data)



										{



											echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_html($retrive_data->post_title).'</option>';



										}



									}



									?>



								</select>



							</div>	



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3 rtl_margin_top_15px">	



								<button id="addremove" model="role_type" class="add_btn"><?php esc_html_e('Add','gym_mgt');?></button>



							</div>







							<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_specialization smgt_multiple_select">



								<select class="form-control"  name="activity_category[]" id="specialization"  multiple="multiple" >



									<?php 



									if($edit)



									{



										$category =explode(',',$user_info->activity_category);



									}



									elseif(isset($_REQUEST['activity_category']))



									{



										$category =esc_attr($_REQUEST['activity_category']);  



									}



									else



									{ 



										$category = array();



									}



									$activity_category=MJ_gmgt_get_all_category('activity_category');



									if(!empty($activity_category))



									{



										foreach ($activity_category as $retrive_data)



										{



											$selected = "";



											if(in_array($retrive_data->ID,$category))



												$selected = "selected";



											echo '<option value="'.esc_attr($retrive_data->ID).'"'.esc_attr($selected).'>'.esc_attr($retrive_data->post_title).'</option>';



										}



									}



									?>



								</select>								



							</div>	



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 res_margin_bottom_20px rtl_margin_top_15px">



								<button id="addremove" model="activity_category_staff" class="add_btn"><?php esc_html_e('Add','gym_mgt');?></button>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End-->







					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Login Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text" name="email" value="<?php if($edit){ echo esc_attr($user_info->user_email);}elseif(isset($_POST['email'])) echo esc_attr($_POST['email']);?>" >



										<label class="" for="email"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?> space_validation" minlength="8" maxlength="12" type="password" name="password" value="" >



										<label class="" for="password"><?php esc_html_e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>



									</div>



								</div>



							</div>



							<div class="col-md-6">



								<div class="row">



									<div class="col-md-5">



										<div class="form-group input margin_bottom_0">



											<div class="col-md-12 form-control">



												<input type="text" readonly value="+<?php echo esc_attr(MJ_gmgt_get_countery_phonecode(get_option( 'gmgt_contry')));?>"  class="form-control" name="phonecode">



												<label for="phonecode" class="pl-2 popup_countery_code_css"><?php esc_html_e('Country Code','gym_mgt');?><span class="required red">*</span></label>



											</div>											



										</div>



									</div>



									<div class="col-md-7">



										<div class="form-group input margin_bottom_0">



											<div class="col-md-12 form-control">



												<input id="mobile" class="form-control margin_top_10_res validate[required,custom[phone_number]] text-input phone_validation" type="text" name="mobile" minlength="6" maxlength="15" value="<?php if($edit){ echo esc_attr($user_info->mobile);}elseif(isset($_POST['mobile'])) echo esc_attr($_POST['mobile']);?>" >



												<label class="" for="mobile"><?php esc_html_e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>



											</div>



										</div>



									</div>



								</div>



							</div> 



						</div><!--Row Div End--> 



					</div><!-- user_form End-->  



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Contact Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="address" class="form-control text-input" type="text" maxlength="150"  name="address" value="<?php if($edit){ echo esc_attr($user_info->address);}elseif(isset($_POST['address'])) echo esc_attr($_POST['address']);?>" >



										<label class="" for="address"><?php esc_html_e('Address','gym_mgt');?></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="city_name" class="form-control text-input" type="text" maxlength="50" name="city_name" value="<?php if($edit){ echo esc_attr($user_info->city_name);}elseif(isset($_POST['city_name'])) echo esc_attr($_POST['city_name']);?>" >



										<label class="" for="city_name"><?php esc_html_e('City','gym_mgt');?></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="zip_code" class="form-control " maxlength="15" type="text" name="zip_code" value="<?php if($edit){ echo esc_attr($user_info->zip_code);}elseif(isset($_POST['zip_code'])) echo esc_attr($_POST['zip_code']);?>" >



										<label class="" for="zip_code"><?php esc_html_e('Zip Code','gym_mgt');?></label>							



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="phone" class="form-control validate[custom[phone_number]] text-input phone_validation" minlength="6" maxlength="15" type="text" name="phone" value="<?php if($edit){ echo esc_attr($user_info->phone);}elseif(isset($_POST['phone'])) echo esc_attr($_POST['phone']);?>" >



										<label class="" for="phone"><?php esc_html_e('Phone','gym_mgt');?></label>



									</div>



								</div>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Profile Image','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control upload-profile-image-patient">



										<label class="ustom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>



										<div class="col-sm-12 display_flex">



											<input type="text" id="gmgt_user_avatar_url1" class="form-control gmgt_user_avatar_url" name="gmgt_user_avatar"  readonly value="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar );elseif(isset($_POST['gmgt_user_avatar'])) echo esc_url($_POST['gmgt_user_avatar']); ?>" />



											<input id="upload_user_avatar_button1" type="button" class="button upload_image_btn upload_user_avatar_button" style="float: right;" value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />



										</div>



									</div>



									<div class="clearfix"></div>



									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">



										<div id="upload_user_avatar_preview1" class="upload_user_avatar_preview" >



											<?php 



											if($edit) 



											{



												if($user_info->gmgt_user_avatar == "")



												{ ?>



													<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_Staffmember_logo' )); ?>">



													<?php 



												}



												else 



												{



													?>



													<img class="image_preview_css" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />



													<?php 



												}



											}



											else 



											{



												?>



												<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_Staffmember_logo' )); ?>">



												<?php 



											} ?>



										</div>



									</div>



								</div>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 



					<!------------   save btn  -------------->  



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->  



								<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Add Staff','gym_mgt');}?>" name="save_staff" id="add_staff_member" class="btn save_btn specialization_submit "  />



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 



				</form><!-- Staff MEMBER FORM END-->



			</div>	<!-- MODAL BODY DIV END-->	



		</div><!-- MODAL CONTENT DIV END-->



	</div><!-- MODAL DIALOG DIV END-->



</div><!-- MODAL MAIN DIV END-->



 <!----------ADD MEMBERSHIP POPUP------------->



<div class="modal fade" id="myModal_add_membership" tabindex="-1" aria-labelledby="myModal_add_membership" aria-hidden="true" role="dialog"><!-- MODAL MAIN DIV START-->



	<div class="modal-dialog modal-lg"><!-- MODAL DIALOG DIV START-->



		<div class="modal-content"><!-- MODAL ContENT DIV START-->



			<div class="modal-header float_left_width_100">



				<h3 class="modal-title float_left"><?php esc_html_e('Add Membership','gym_mgt');?></h3>



				<button type="button" class="close btn-close float_right mt-1" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>



			</div>



			<div id="message" class="updated below-h2 show_msg">



				<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>



			</div>



			<div class="modal-body"><!-- MODAL BODY DIV START-->



				<form name="membership_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="membership_form"><!-- MEMBERSHIP FORM START-->



					<input type="hidden" name="action" value="MJ_gmgt_add_ajax_membership">



					<input type="hidden" name="membership_id" class="membership_id_activity" value=""  />







					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Membership Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 







							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="membership_name" class="form-control validate[required,custom[popup_category_validation]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->membership_label);}elseif(isset($_POST['membership_name'])) echo esc_attr($_POST['membership_name']);?>" name="membership_name">



										<label class="" for="membership_name"><?php esc_html_e('Membership Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<!--nonce-->



							<?php wp_nonce_field( 'save_membership_nonce' ); ?>



							<!--nonce-->



							<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">



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



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3 rtl_margin_top_15px">		



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



							



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



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



							



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">



								<div class="form-group">



									<div class="col-md-12 form-control">



										<div class="row padding_radio">



											<div class="input-group">



												<label class="custom-top-label" for="classis_limit"><?php esc_html_e('Class Limit','gym_mgt');?></label>



												<div class="d-inline-block gender_line_height_24px">



													<?php $limitvals = "unlimited"; if($edit){ $limitvals=$result->classis_limit; }elseif(isset($_POST['gender'])) {$limitvals=sanitize_text_field($_POST['gender']);}?>



													<label class="radio-inline">



														<input type="radio" value="limited" class="classis_limit margin-top_2" name="classis_limit" <?php checked('limited',esc_html($limitvals)); ?>/><?php esc_html_e('limited','gym_mgt');?>



													</label>



													<label class="radio-inline">



														<input type="radio" value="unlimited" class="margin-top_2 classis_limit validate[required]" name="classis_limit" <?php checked('unlimited',esc_html($limitvals)); ?>/><?php esc_html_e('unlimited','gym_mgt');?> 



													</label>



												</div>



											</div>



										</div>



									</div>		



								</div>



							</div>







							<div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div id="member_limit" class="form-group input"></div>



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



										



									<?php } ?>



								<?php	



								}



								?>



							</div>







							<div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div id="classis_limit" class="form-group input"></div>



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



							<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">



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



							<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 mb-3 rtl_margin_top_15px">		



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







							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



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







							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px multiselect_validation_member smgt_multiple_select">



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



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control upload-profile-image-patient">



										<label class="ustom-control-label custom-top-label ml-2" for="gmgt_membershipimage"><?php esc_html_e('Image','gym_mgt');?></label>



										<div class="col-sm-12 display_flex">



											<input type="text" id="gmgt_user_avatar_url1" class="gmgt_user_avatar_url" name="gmgt_membershipimage" readonly value="<?php if(isset($_POST['gmgt_membershipimage'])) echo esc_attr($_POST['gmgt_membershipimage']);?>" />	



											<input id="upload_image_button1" type="button" class="button upload_image_btn upload_user_avatar_button" value="<?php esc_html_e('Upload Cover Image','gym_mgt'); ?>" />



										</div>



									</div>



									<div class="clearfix"></div>



									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">



										<div class="upload_user_avatar_preview" id="upload_user_avatar_preview1" >



										<img class="image_preview_css" src="<?php if(isset($_POST['gmgt_membershipimage'])) echo esc_url($_POST['gmgt_membershipimage']); else echo esc_url(get_option( 'gmgt_Membership_logo' ));?>" />



										</div>



									</div>



								</div>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End-->



					<!------------   save btn  -------------->  



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn--> 



								<input type="submit" value="<?php if($edit){ esc_html_e('Save Membership','gym_mgt'); }else{ esc_html_e('Add Membership','gym_mgt');}?>" name="save_membership" class="btn save_btn"/>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End-->



				</form><!-- MEMBERSHIP FORM END-->



			</div><!-- MODAL BODY DIV END-->



		</div><!-- MODAL ContENT DIV END-->



	</div><!-- MODAL DIALOG DIV END-->



</div><!--MODAL MAIN DIV END-->