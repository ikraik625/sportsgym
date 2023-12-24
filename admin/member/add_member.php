<?php $role="member"; ?>
<script type="text/javascript">

    jQuery(document).ready(function($)

	{

		"use strict";

		$('#member_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

		$('#add_staff_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

		$('#membership_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

		$('#class_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

		$("#group_form").validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

		$('#group_id').multiselect(

		{

			nonSelectedText :'<?php esc_html_e('Select Group','gym_mgt');?>',

			includeSelectAllOption: true,

			allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

			selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

			templates: {

					button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

				},

			buttonContainer: '<div class="dropdown" />'

		});	

		$('.classis_ids').multiselect(

		{

			nonSelectedText :'<?php esc_html_e('Select Class','gym_mgt');?>',

			includeSelectAllOption: true,

			allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

			selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

			templates: {

					button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

				},

			buttonContainer: '<div class="dropdown" />'

		});	

		$('#specialization').multiselect(

		{

			nonSelectedText :'<?php esc_html_e('Select Specialization','gym_mgt');?>',

			includeSelectAllOption: true,

			allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

			selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

			templates: {

	            button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

	        },

			buttonContainer: '<div class="dropdown" />'

		});	

		$('#day').multiselect(

		{

			nonSelectedText :'<?php esc_html_e('Select Day','gym_mgt');?>',

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

		$('#class_membership_id').multiselect(

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

			var checked = $(".multiselect_validation_specialization  .dropdown-menu input:checked").length;

			if(!checked)

			{

			  	alert("<?php esc_html_e('Please select atleast one specialization','gym_mgt');?>");

			  	return false;

			}

		});

		$(".class_submit").on('click',function()

		{

			var checked = $(".multiselect_validation_member .dropdown-menu input:checked").length;

			if(!checked)

			{

				var Member_type_val = $('.Member_type_val').val();

				if(Member_type_val != 'Prospect')

				{

			  		alert("<?php esc_html_e('Please select atleast one class','gym_mgt');?>");

					return false;

				}

			}

		});

		$(".day_validation_submit").on('click',function()

		{

			var checked = $(".day_validation_member .dropdown-menu input:checked").length;

			if(!checked)

			{

			  	alert("<?php esc_html_e('Please select atleast One Day','gym_mgt');?>");

			  	return false;

			}

		});

		$(".day_validation_submit").on('click',function()

		{

			var checked = $(".multiselect_validation_membership .dropdown-menu input:checked").length;

			if(!checked)

			{

			  	alert("<?php esc_html_e('Please select Atleast One membership.','gym_mgt');?>");

			  	return false;

			}

		});

		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

		jQuery('#birth_date').datepicker(

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

	        onChangeMonthYear: function(year, month, inst) 

	        {

	            jQuery(this).val(month + "/" + year);

	        }                    

		});

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

	        onChangeMonthYear: function(year, month, inst) 

	        {

	            jQuery(this).val(month + "/" + year);

	        }                    

		});

		var date = new Date();

		date.setDate(date.getDate()-0);

		$('#inqiury_date').datepicker({	

			<?php

			if(get_option('gym_enable_datepicker_privious_date')=='no')

			{

			?>

				startDate: date,

				minDate:'today',

			<?php

			}

			?>

			dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

			autoclose: true

	   	});

		var date = new Date();

		date.setDate(date.getDate()-0);

		 $('#triel_date').datepicker({

			<?php

			if(get_option('gym_enable_datepicker_privious_date')=='no')

			{

			?>

				minDate:'today',

				startDate: date,

			<?php

			}

			?>	

		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

		autoclose: true

	   	});

	   	var date = new Date();

		date.setDate(date.getDate()-0);

		$('#begin_date').datepicker({

			<?php

			if(get_option('gym_enable_datepicker_privious_date')=='no')

			{

			?>

				minDate:'today',

				startDate: date,

			<?php

			}

			?>	

		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

		autoclose: true

	   	});

		var date = new Date();

		date.setDate(date.getDate()-0);

		$('#first_payment_date').datepicker({

		  	dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

			<?php

			if(get_option('gym_enable_datepicker_privious_date')=='no')

			{

			?>

				startDate: date,

				minDate:'today',

			<?php

			}

			?>

		autoclose: true

	   	});

		//------ADD STAFF MEMBER AJAX----------

		$('#add_staff_form').on('submit', function(e) 

		{

			e.preventDefault();

			var form = $(this).serialize();

			var valid = $('#add_staff_form').validationEngine('validate');

			if (valid == true) 

			{				

				$.ajax(

				{

					type:"POST",

					url: $(this).attr('action'),

					data:form,

					success: function(data)

					{					

						if(data!='0')

						{ 

							if(data!="")

							{ 

								$('#add_staff_form').trigger("reset");

								$('#staff_id').append(data);

								$('#reference_id').append(data);

								$('.upload_user_avatar_preview').html('<img class="image_preview_css" src="<?php echo get_option( 'gmgt_member_logo' ); ?>">');

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

		//------ADD GROUP AJAX----------

		$('#group_form').on('submit', function(e)

		{

			e.preventDefault();

			var form = $(this).serialize();

			var valid = $("#group_form").validationEngine('validate');

			if (valid == true)

			{

				$('.modal').modal('hide');

			}

			else

			{

				return false;

			}

			var categCheck_group = $('#group_id').multiselect();	

			$.ajax(

			{

				type:"POST",

				url: $(this).attr('action'),

				data:form,

				success: function(data)

				{

					if(data!="")

					{ 

						$('#group_form').trigger("reset");

						$('#group_id').append(data);

						categCheck_group.multiselect('rebuild');	

					}

				},

				error: function(data)

				{

				}

			})

		});

		//------ADD MEMBERSHIP AJAX----------

		$('#membership_form').on('submit', function(e)

		{

			e.preventDefault();

			var form = $(this).serialize();

			var valid = $('#membership_form').validationEngine('validate');

			var categCheck_class_membership = $('#class_membership_id').multiselect();	

			if (valid == true)

			{				

				$.ajax(

				{

					type:"POST",

					url: $(this).attr('action'),

					data:form,

					success: function(data)

					{

						if(data!='0')

						{

							if(data!="")

							{

								$('#membership_form').trigger("reset");

								$('#membership_id').append(data);

								$('#class_membership_id').append(data);

								categCheck_class_membership.multiselect('rebuild');	

							}

							$('.modal').modal('hide');

							$('.show_msg').css('display','none');

						}

						else

						{				

							$('.show_msg').css('display','block');

						}	

					},

					error: function(data)

					{

					}

				})

			}

		});

		//------ADD CLASS AJAX----------

		$('#class_form').on('submit',function(e)

		{

			e.preventDefault();

			var form = $(this).serialize();

			var categCheck_class = $('#classis_id').multiselect();	

			var categCheck_day = $('#day').multiselect();	

			var categCheck_class_membership = $('#class_membership_id').multiselect();	

			var valid = $('#class_form').validationEngine('validate');

			// console.log(valid);

			// return false;

			if (valid == true)

			{			

				$.ajax(

				{

					type:"POST",

					url: $(this).attr('action'),

					data:form,

					success: function(data)

					{	

						if(data=="1")

						{ 

							alert("<?php esc_html_e('End Time should Be greater than Start Time','gym_mgt'); ?>");

							return false;

						}

						else

						{

							$('#class_form').trigger("reset");

							$('#classis_id').append(data);

							categCheck_class.multiselect('rebuild');	

							categCheck_day.multiselect('rebuild');	

							categCheck_class_membership.multiselect('rebuild');	

							$('.modal').modal('hide');

						}

					},

					error: function(data)

					{

					}

				})

			}

			if (valid == true)

			{

			}

		});

		$(".save_group_btn").on('click',function()

		{

			$('.image_preview_css_123').attr('src', '<?php echo get_option( 'gmgt_group_logo' );?>');

		});

    });

	jQuery(document).ready(function($)

	{

		// $('#class_form').on('submit',function(e)

		// {

		$("#end_date_class").change(function()

		{

			var class_date= $("#class_date").val();

			var end_date_class= $("#end_date_class").val();

			// console.log(class_date);

			// console.log(end_date_class);

			// return false;

			if (class_date > end_date_class) 

			{

				alert("<?php esc_html_e('End Date should be greater than Start Date','gym_mgt');?>");

				$("#end_date_class").val("");

				return false;

            }

		});

	});

</script>

<?php 	

if($active_tab == 'addmember')

{

  	$member_id=0;

	$edit=0;
	$user_query = get_users( array ( 'orderby' => 'ID', 'order' => 'DESC', 'number' => 1 ) );

	$last_id ="";
	foreach ( $user_query as $user ) {
		$last_id = (int)$user->ID + 1;
		break;
	}

	
	$selected_member_type="" ;
	if($edit){ 
		$selected_member_type = esc_attr($user_info->member_type);
	} elseif(isset($_POST['member_type'])) {
		$selected_member_type = esc_attr($_POST['member_type']);
	}
	if ( $selected_member_type === 'Dependent') {
		$last_id = "SVC000" . $last_id . "D1";
	} else {
		$last_id = "SVC000" . $last_id;
	}

	// if ( isset($_GET['check_id'] )) {
	// 	$check_id_user = reset(
	// 		get_users(
	// 			array(
	// 				'meta_key'   => 'member_id',
	// 				'meta_value' => $_GET['check_id'],
	// 				'number'    => 1,
	// 			)
	// 		)
	// 	);

	// 	if ( !empty( $check_id_user )) {
			
	// 		$getId = get_user_meta( $check_id_user->ID, 'total_dependent',1);
	// 		$primaryId =$_GET['check_id'];
	// 		if ( $getId) {
	// 			$getId = (int)$getId + 1;
	// 			$last_id = $primaryId .'D'. $getId;
	// 		} else {
	// 			$last_id = $primaryId . 'D1';
	// 		}
	// 	} else {
	// 		echo "Invalid Primary Id";
	// 	}

	// }
								
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

	{

		$member_id=esc_attr($_REQUEST['memberid']);

		$edit=1;

		$user_info = get_userdata($member_id);

		if($user_info->gmgt_hash)

		{

			$lastmember_id=MJ_gmgt_get_lastmember_id($role);

			$nodate=substr($lastmember_id,0,-4);

			$memberno=substr($nodate,1);

			$add="1";

			$test=(int)$memberno+(int)$add;

			$newmember=$last_id;

		}

	}

	else

	{

	    $lastmember_id=MJ_gmgt_get_lastmember_id($role);

		$nodate=substr($lastmember_id,0,-4);

		$memberno=substr($nodate,1);

		$test=(int)$memberno+1;

		$newmember=$last_id;

	}?>

    <div class="panel-body padding_0"><!-- PAGE INNNER DIV START-->

		<form name="member_form" action="" method="post" class="form-horizontal" id="member_form"><!-- MEMBER FROM START-->

			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

			<input type="hidden" name="role" value="<?php echo esc_attr($role);?>"  />

			<input type="hidden" name="user_id" value="<?php echo esc_attr($member_id);?>"  />

			<input type="hidden" name="gmgt_hash" value="<?php if($edit){ if($user_info->gmgt_hash){ echo esc_attr($user_info->gmgt_hash);}}?>" />

			<input type="hidden" class="user_coupon" name="coupon_id" value="" />

			<div class="header">	

				<h3 class="first_hed"><?php esc_html_e('Personal Information','gym_mgt');?></h3>

			</div>

			<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row">
				<div class="col-md-12" id="primary-member-data"></div>
			</div>

				<div class="row"><!--Row Div Strat--> 

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="member_id" class="form-control" type="text" value="<?php if($edit){  echo esc_attr($user_info->member_id);}else echo esc_attr($newmember);?>"  readonly name="member_id" >

								<label class="" for="member_id"><?php esc_html_e('Member Id','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<!--nonce-->	

					<?php wp_nonce_field( 'save_member_nonce' ); ?>

					<!--nonce-->

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<!-- <input id="member_type" class="form-control validate[custom[onlyLetter_specialcharacter] " type="text" maxlength="50"  value="<?php if($edit){ echo esc_attr($user_info->member_type);}elseif(isset($_POST['member_type'])) echo esc_attr($_POST['member_type']);?>" name="member_type"  placeholder="Primary/Dependent"> -->

								<?php
								$selected_member_type="" ;
								if($edit){ 
									$selected_member_type = esc_attr($user_info->member_type);
								} elseif(isset($_POST['member_type'])) {
									$selected_member_type = esc_attr($_POST['member_type']);
								}
								?>
								<label class="" for="member_type"><?php esc_html_e('Member Type','gym_mgt');?></label>
								<select id="member_type" class="form-control validate[custom[onlyLetter_specialcharacter] " name="member_type" onchange="toggleDependentFields()">
								<option value="Select">Select Member Type</option>	
								<option value="Primary" <?php echo $selected_member_type === "Primary" ? "selected": ""; ?>">Primary</option>
								<option value="Dependent" <?php echo $selected_member_type === "Dependent" ? "selected": ""; ?>">Dependent</option>
								</select>	
								<input type="hidden" id="check_id_user" name="check_id_user" value=""/>
								<div id="primary_id_div">
								<?php if( $selected_member_type === "Dependent" ) { ?>
									<br/>
									<span class="" for="primary_id"><?php esc_html_e('Primary Id','gym_mgt');?><span class="require-field">*</span></span>
									<input id="primary_id" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->first_name);}elseif(isset($_POST['primary_id'])) echo esc_attr($_POST['primary_id']);?>" name="primary_id">
	

									<?php } ?>
								</div>
							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->first_name);}elseif(isset($_POST['first_name'])) echo esc_attr($_POST['first_name']);?>" name="first_name">

								<label class="" for="first_name"><?php esc_html_e('Full Name','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">

						<div class="form-group">

							<div class="col-md-12 form-control">

								<div class="row padding_radio">

									<div class="input-group">

										<label class="custom-top-label" for="gender"><?php esc_html_e('Gender','gym_mgt');?><span class="require-field">*</span></label>

										<div class="d-inline-block gender_line_height_24px">

											<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=sanitize_text_field($_POST['gender']);}?>

											<label class="radio-inline custom_radio margin_right_5px">

												<input type="radio" value="male" class="tog" name="gender"  <?php checked('male',$genderval); ?>  /><?php esc_html_e('Male','gym_mgt');?>

											</label>

											<label class="radio-inline custom_radio">

												<input type="radio" value="female" class="tog" name="gender" <?php checked('female',$genderval); ?>/><?php esc_html_e('Female','gym_mgt');?>

											</label>

										</div>

									</div>

								</div>		

							</div>

						</div>

					</div>

					<div id="dependentFields">

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" style="display: inline-block;">

							<div class="form-group input">

								<div class="col-md-12 form-control" style="width:98%; margin-left:2%;">

									<input id="last_name" class="form-control text-input"  type="text" value="<?php if($edit){ echo esc_attr($user_info->last_name);}elseif(isset($_POST['last_name'])) echo esc_attr($_POST['last_name']);?>" name="last_name" >
									
									<label class="" for="last_name"><?php esc_html_e('Rank','gym_mgt');?></label>

								</div>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" style="display: inline-block; float:left">

							<div class="form-group input">

								<div class="col-md-12 form-control" style="width: 98%;">

									<input id="phone" class="form-control text-input" type="text" name="phone" value="<?php if($edit){ echo esc_attr($user_info->phone);}elseif(isset($_POST['phone'])) echo esc_attr($_POST['phone']);?>" >

									<label class="" for="phone"><?php esc_html_e('Unit Number','gym_mgt');?></label>

								</div>

							</div>

						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

							<div class="form-group input">

								<div class="col-md-12 form-control" style="width:98%">

									<input id="city_name" class="form-control " type="text"  name="city_name" value="<?php if($edit){ echo esc_attr($user_info->city_name);}elseif(isset($_POST['city_name'])) echo esc_attr($_POST['city_name']);?>" >

									<label class="" for="city_name"><?php esc_html_e('Unit Address','gym_mgt');?></label>

								</div>

							</div>

						</div>

					</div>


					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="birth_date" class="form-control validate[required] birth_date date_picker" type="text"  name="birth_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->birth_date));}elseif(isset($_POST['birth_date'])){ echo esc_attr(MJ_gmgt_getdate_in_input_box($_POST['birth_date']));}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); }?>" readonly  >

								<label class="date_of_birth_label date_label" for="birth_date"><?php esc_html_e('Date of birth','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End-->   

			<div class="header">	

				<h3 class="first_hed"><?php esc_html_e('Login Information','gym_mgt');?></h3>

			</div>

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input type="hidden" name="hidden_email" value="<?php if($edit){ echo esc_attr($user_info->user_email); } ?>">

								<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="100" type="text" name="email" value="<?php if($edit){ echo esc_attr($user_info->user_email);}elseif(isset($_POST['email'])) echo esc_attr($_POST['email']);?>" >

								<label class="" for="email"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 " style="display:none;">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="password" class="form-control space_validation <?php if(!$edit) echo esc_attr('validate[required]');?>" minlength="8" maxlength="12" type="password" name="password" value="Svisc@123$" readonly>

								<label class="" for="password"><?php esc_html_e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>

							</div>

						</div>

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End--> 

			<div class="header">	

				<h3 class="first_hed"><?php esc_html_e('Membership Information','gym_mgt');?></h3>

			</div>

			<div class="form-body user_form"> <!-- user_form Strat-->

				<div class="row"><!--Row Div Strat--> 

					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

						<label class="ml-1 custom-top-label top" for="refered"><?php esc_html_e('Member type','gym_mgt');?><span class="require-field">*</span></label>

						<select name="member_type" class="form-control validate[required] Member_type_val max_width_100" id="member_type" >

							<option value=""><?php esc_html_e('Select Member Type','gym_mgt');?></option>

							<?php 

							if($edit)

							{

								$mtype=$user_info->member_type;

							}

							elseif(isset($_POST['member_type']))

							{

								$mtype=sanitize_text_field($_POST['member_type']);

							}

							else

							{

								$mtype="";

							}

							$membertype_array=MJ_gmgt_member_type_array();

							if(!empty($membertype_array))

							{

								foreach($membertype_array as $key=>$type)

								{

									echo '<option value='.esc_attr($key).' '.selected(esc_attr($mtype),esc_attr($key)).'>'.esc_html($type).'</option>';

								}

							} ?>

						</select>

					</div>

					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>

						<?php $get_staff = array('role' => 'Staff_member');

							$staffdata=get_users($get_staff);

						?>

						<select name="staff_id" class="form-control validate[required] max_width_100" id="staff_id" >

							<option value=""><?php  esc_html_e('Select Staff Member','gym_mgt');?></option>

							<?php 

							if($edit)

							{

								$staff_data=$user_info->staff_id;

							}

							elseif(isset($_POST['staff_id']))

							{

								$staff_data=sanitize_text_field($_POST['staff_id']);

							}

							else

							{

								$staff_data="";

							}

							if(!empty($staffdata))

							{

								foreach($staffdata as $staff)

								{

									echo '<option value='.esc_attr($staff->ID).' '.selected(esc_html($staff_data),$staff->ID).'>'.esc_html($staff->display_name).'</option>';

								}

							}

							?>

						</select>

					</div>

					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">				

						<button type="button" class="btn add_btn " data-bs-toggle="modal" data-bs-target="#myModal_add_staff_member"> <?php esc_html_e('Add','gym_mgt');?></button>

					</div>

					<?php 

					if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

					{

					?>	

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">

							<div class="form-group">

								<div class="col-md-12 form-control">

									<div class="row padding_radio">

										<div class="">

											<label class="custom-top-label" for="member_convert"><?php esc_html_e(' Convert into Staff Member','gym_mgt');?></label>

											<input type="checkbox" class="member_convert check_box_input_margin margin_right_5px" name="member_convert" value="staff_member"><?php esc_attr_e('Convert into Staff Member','gym_mgt');?>

										</div>												

									</div>

								</div>

							</div>

						</div>

					<?php 

					}

					?>

					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

						<label class="ml-1 custom-top-label top" for="membership"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label>					

						<input type="hidden" name="membership_hidden" class="membership_hidden" value="<?php if($edit){ if(!empty($user_info->membership_id)) { echo esc_attr($user_info->membership_id); }else{ echo '0'; } }else{ echo '0';}?>">

						<?php $membershipdata=$obj_membership->MJ_gmgt_get_all_membership(); ?>

						<select name="membership_id" class="form-control coupon_membership_id payment_membership_detail validate[required] max_width_100" id="membership_id" >	

							<option value=""><?php esc_html_e('Select Membership','gym_mgt');?></option>

								<?php 

								$staff_data= $user_info ? $user_info->membership_id : "";

								if(!empty($membershipdata))

								{

									foreach ($membershipdata as $membership)

									{						

										echo '<option value='.esc_attr($membership->membership_id).' '.selected(esc_attr($staff_data),esc_attr($membership->membership_id)).'>'.esc_html($membership->membership_label).'</option>';

									}

								}

								?>

						</select>

					</div>

					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">			

						<button type="button" class="btn add_btn" data-bs-toggle="modal" data-bs-target="#myModal_add_membership"> <?php esc_html_e('Add','gym_mgt');?></button>

					</div>	

					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">

						<select id="classis_id" class="form-control classis_ids" multiple="multiple" name="class_id[]" >

							<?php 

							if($edit)					

							{	

								$obj_class=new MJ_gmgt_classschedule;

								$MemberShipClass = MJ_gmgt_get_class_id_by_membership_id($user_info->membership_id);

								$userclass  = MJ_gmgt_get_current_user_classis($member_id);

								foreach($MemberShipClass as $key=>$class_id)

								{

									$class_data=$obj_class->MJ_gmgt_get_single_class($class_id);

									if(!empty($class_data)){

								?>

									<option value="<?php echo esc_attr($class_id);?>" <?php if (is_array($userclass)){ if(in_array($class_id,$userclass)){ print "Selected"; } } ?>><?php echo MJ_gmgt_get_class_name(esc_html($class_id)); ?> ( <?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->start_time)).' - '.MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->end_time));?>)</option>

								<?php

									}

								}

							}

							?>

						</select>

					</div>

					<div class="col-sm-1 col-md-1 col-lg-1 res_margin_bottom_20px rtl_margin_top_15px">			

						<button type="button" class="btn btn-default add_btn" data-bs-toggle="modal" data-bs-target="#myModal_add_class"> <?php esc_html_e('Add','gym_mgt');?></button>

					</div>

					<?php 

					if($edit)

					{

						?>	

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px rtl_margin_top_15px">

							<div class="form-group">

								<div class="col-md-12 form-control">

									<div class="row padding_radio">

										<div class="input-group">

											<label class="custom-top-label" for="membership_status"><?php esc_html_e('Membership Status','gym_mgt');?><span class="require-field">*</span></label>

											<div class="d-inline-block gender_line_height_24px">

												<?php $membership_statusval = "Continue"; if($edit){ $membership_statusval=$user_info->membership_status; }elseif(isset($_POST['membership_status'])) {$membership_statusval=sanitize_text_field($_POST['membership_status']);}?>

												<label class="radio-inline custom_radio">

													<input type="radio" value="Continue" class="tog" name="membership_status" <?php checked( 'Continue', $membership_statusval); ?>/><?php esc_html_e('Continue','gym_mgt');?>

												</label>

												<label class="radio-inline custom_radio">

													<input type="radio" value="Expired" class="tog" name="membership_status" <?php  checked( 'Expired', $membership_statusval);  ?>/><?php esc_html_e('Expired','gym_mgt');?>

												</label>

												<label class="radio-inline custom_radio">

													<input type="radio" value="Dropped" class="tog" name="membership_status" <?php checked( 'Dropped', $membership_statusval); ?>/><?php esc_html_e('Dropped','gym_mgt');?> 

												</label>

											</div>

										</div>

									</div>

								</div>

							</div>

							<input type="hidden" name="auto_renew" value="No">		

						</div>		

						<?php 

					} ?>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="begin_date" class="form-control begin_date validate[required] date_picker" type="text" name="begin_date" value="<?php if($edit){ if($user_info->begin_date!=""){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->begin_date)); } }elseif(isset($_POST['begin_date'])) echo esc_attr($_POST['begin_date']);?>"  readonly>

								<label class="date_label" for="begin_date"><?php esc_html_e('Membership Valid From','gym_mgt');?><span class="require-field">*</span></label>	

							</div>							

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="end_date" class="form-control validate[required] date_picker" type="text" name="end_date" value="<?php if($edit){ if($user_info->end_date!=""){ echo MJ_gmgt_getdate_in_input_box($user_info->end_date); }} elseif(isset($_POST['end_date'])) echo esc_attr($_POST['end_date']);?>" readonly>

								<label class="date_label" for="begin_date"><?php esc_html_e('Membership Valid to','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<?php

						if($edit == 0){

					?>

					<!-- <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="coupon_code" class="form-control coupon_code" type="text" value="" name="coupon_code" >

								<label class="" for=""><?php esc_html_e('Add Coupon Code','gym_mgt');?></label>

							</div>

							<span class="coupon_span"></span>

						</div>

					</div> -->

					<!-- <div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">	

						<button id="" type="new_member" class="btn add_btn apply_coupon" ><?php esc_html_e('Apply','gym_mgt');?></button>

					</div> -->

					<div id="dependentFields">

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

							<div class="form-group input">

								<div class="col-md-12 form-control">

									<input id="total_amount" class="form-control" type="text" value="<?php if($edit){ echo esc_attr($user_info->membership_amount);}?>" name="membership_amount" readonly>

									<label class="" for="triel_date"><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>

								</div>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 discount_display">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="coupon_discount" class="form-control" type="text" value="" name="discount" readonly>

								<label class="" for=""><?php esc_html_e('Discount','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<?php } ?>

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

								<input id="address" class="form-control" maxlength="150" type="text"  name="address" value="<?php if($edit){ echo esc_attr($user_info->address);}elseif(isset($_POST['address'])) echo esc_attr($_POST['address']);?>" >

								<label class="" for="address"><?php esc_html_e('Home Address','gym_mgt');?></label>

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

					<!-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="state_name" class="form-control validate[custom[city_state_country_validation]]" maxlength="50" type="text" name="state_name" value="<?php if($edit){ echo esc_attr($user_info->state_name);}elseif(isset($_POST['state_name'])) echo esc_attr($_POST['state_name']);?>" >

								<label class="" for="state_name"><?php esc_html_e('State','gym_mgt');?></label>

							</div>

						</div>

					</div> -->

					<!-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="zip_code" class="form-control" maxlength="15" type="text" name="zip_code" value="<?php if($edit){ echo esc_attr($user_info->zip_code);}elseif(isset($_POST['zip_code'])) echo esc_attr($_POST['zip_code']);?>" >

								<label class="" for="zip_code"><?php esc_html_e('Zip Code','gym_mgt');?></label>

							</div>

						</div>

					</div> -->

				</div><!--Row Div End--> 

			</div><!-- user_form End-->  

			<!-- <div class="header">	

				<h3 class="first_hed"><?php esc_html_e('Physical Information','gym_mgt');?></h3>

			</div> -->

			<!-- <div class="form-body user_form"> 
				user_form Strat   

				<div class="row">
					Row Div Strat 

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="weight" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->weight);}elseif(isset($_POST['weight'])) echo esc_attr($_POST['weight']);?>" name="weight" placeholder="<?php echo  esc_html__(get_option( 'gmgt_weight_unit' ),'gym_mgt');?>" >		

								<label class="" for="weight"><?php esc_html_e('Weight','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="height" class="form-control text-input decimal_number"type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->height);}elseif(isset($_POST['height'])) echo esc_attr($_POST['height']);?>" name="height" placeholder="<?php echo esc_html__(get_option( 'gmgt_height_unit' ),'gym_mgt');?>" >

								<label class="" for="height"><?php esc_html_e('Height','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="Chest" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->chest);}elseif(isset($_POST['chest'])) echo esc_attr($_POST['chest']);?>" name="chest" placeholder="<?php echo  esc_html__(get_option( 'gmgt_chest_unit' ),'gym_mgt');?>" >

								<label class="" for="Chest"><?php esc_html_e('Chest','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="waist" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->waist);}elseif(isset($_POST['waist'])) echo esc_attr($_POST['waist']);?>" name="waist" placeholder="<?php echo  esc_html__(get_option( 'gmgt_waist_unit' ),'gym_mgt');?>" >

								<label class="" for="Waist"><?php esc_html_e('Waist','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="thigh" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->thigh);}elseif(isset($_POST['thigh'])) echo esc_attr($_POST['thigh']);?>" name="thigh" placeholder="<?php echo esc_html__(get_option( 'gmgt_thigh_unit' ),'gym_mgt');?>" >

								<label class="" for="thigh"><?php esc_html_e('Thigh','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="arms" class="form-control text-input decimal_number" type="number" min="0" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->arms);}elseif(isset($_POST['arms'])) echo esc_attr($_POST['arms']);?>" name="arms" placeholder="<?php echo  esc_html__(get_option( 'gmgt_arms_unit' ),'gym_mgt'); ?>" >

								<label class="" for="arms"><?php esc_html_e('Arms','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="fat" class="form-control text-input decimal_number" type="number" min="0" max="100" onkeypress="if(this.value.length==6) return false;" step="0.01" value="<?php if($edit){ echo esc_attr($user_info->fat);}elseif(isset($_POST['fat'])) echo esc_attr($_POST['fat']);?>" name="fat" placeholder="<?php echo esc_html__(get_option( 'gmgt_fat_unit' ),'gym_mgt');?>" >

								<label class="" for="fat"><?php esc_html_e('Fat','gym_mgt');?></label>

							</div>

						</div>

					</div>

				</div>
				Row Div End 

			</div> -->
			
			<!-- user_form End-->  

			<div class="header">	

				<h3 class="first_hed"><?php esc_html_e('Other Information','gym_mgt');?></h3>

			</div>

			<div class="form-body user_form">
				 <!-- user_form Strat    -->

				<div class="row">
					<!-- Row Div Strat  -->

					<!-- <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

						<label class="ml-1 custom-top-label top" for="intrest"><?php esc_html_e('Interest Area','gym_mgt');?></label>

						<select class="form-control max_width_100" name="intrest_area" id="intrest_area" >

							<option value=""><?php esc_html_e('Select Interest','gym_mgt');?></option>

							<?php

							if(isset($_REQUEST['intrest']))

							{

								$category =esc_attr($_REQUEST['intrest']);  

							}

							elseif($edit)

							{

								$category =$user_info->intrest_area;

							}

							else

							{ 

								$category = "";

							}

							$role_type=MJ_gmgt_get_all_category('intrest_area');

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

					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">

						<button id="addremove" model="intrest_area" class="btn add_btn " ><?php esc_html_e('Add','gym_mgt');?></button>

					</div>

					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

						<label class="ml-1 custom-top-label top" for="Source"><?php esc_html_e('Referral Source','gym_mgt');?></label>

						<select class="form-control reffer_source_font max_width_100" name="source" id="source" >

							<option value=""><?php esc_html_e('Select Referral Source','gym_mgt');?></option>

							<?php 								

							if(isset($_REQUEST['source']))

							{

								$category =esc_attr($_REQUEST['source']);  

							}

							elseif($edit)

							{

								$category =$user_info->source;

							}

							else

							{

								$category = "";

							}

							$role_type=MJ_gmgt_get_all_category('source');

							if(!empty($role_type))

							{

								foreach ($role_type as $retrive_data)

								{

									echo '<option value="'.esc_attr($retrive_data->ID).'" '.selected(esc_attr($category),esc_attr($retrive_data->ID)).'>'.esc_attr($retrive_data->post_title).'</option>';

								}

							}

							?>

						</select>

					</div>

					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">

						<button id="addremove"  class="btn add_btn " model="source" ><?php esc_html_e('Add','gym_mgt');?></button>

					</div>

					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 input">

						<label class="ml-1 custom-top-label top" for="refered"><?php esc_html_e('Referred By','gym_mgt');?></label>

						<?php 

							$staffdata=get_users([ 'role__in' => ['Staff_member', 'member']]);

						?>

						<select name="reference_id" class="form-control max_width_100" id="reference_id" >

							<option value=""><?php esc_html_e('Select Referred Member','gym_mgt');?></option>

							<?php 

							if($edit)

							{

								$staff_data=$user_info->reference_id;

							}

							elseif(isset($_POST['reference_id']))

							{

								$staff_data=sanitize_text_field($_POST['reference_id']);

							}

							else

							{

								$staff_data="";					

							}

							if(!empty($staffdata))

							{

								foreach($staffdata as $staff)

								{						

									echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).'</option>';

								}

							}

							?>

						</select>

					</div>

					<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3 rtl_margin_top_15px">			

						<button type="button" class="btn add_btn" data-bs-toggle="modal" data-bs-target="#myModal_add_staff_member"> <?php esc_html_e('Add','gym_mgt');?></button>

					</div>

					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_class smgt_multiple_select">

						<?php 

							$joingroup_list = $obj_member->MJ_gmgt_get_all_joingroup($member_id);

							$groups_array = $obj_member->MJ_gmgt_convert_grouparray($joingroup_list);

						?>

						<?php if($edit){ $group_id=$user_info->group_id; }elseif(isset($_POST['group_id'])){$group_id=sanitize_text_field($_POST['group_id']);}else{$group_id='';}?>

						<select id="group_id"  name="group_id[]" multiple="multiple" >

							<?php $groupdata=$obj_group->MJ_gmgt_get_all_groups();

							if(!empty($groupdata))

							{

								foreach ($groupdata as $group)

								{

									?>

									<option value="<?php echo esc_attr($group->id);?>" <?php if(in_array($group->id,$groups_array)) echo 'selected';  ?>><?php echo esc_html($group->group_name); ?></option>

									<?php 

								} 

							} 

							?>

						</select>

					</div>

					<div class="col-sm-1 col-md-1 col-lg-1 res_margin_bottom_20px rtl_margin_top_15px">				

						<button type="button" class="btn btn-default add_btn margin_top_10_res" data-bs-toggle="modal" data-bs-target="#myModal_add_group"> <?php esc_html_e('Add','gym_mgt');?></button>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="inqiury_date" class="form-control" type="text"  name="inqiury_date" value="<?php if($edit){ if($user_info->inqiury_date!=""){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->inqiury_date)); } }elseif(isset($_POST['inqiury_date'])) echo esc_attr($_POST['inqiury_date']);?>"  readonly>

								<label class="" for="inqiury_date"><?php esc_html_e('Inquiry Date','gym_mgt');?></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="triel_date" class="form-control date_picker" type="text"  name="triel_date" value="<?php if($edit){ if($user_info->triel_date!=""){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->triel_date)); } }elseif(isset($_POST['triel_date'])) echo esc_attr($_POST['triel_date']);?>" readonly>

								<label class="date_label" for="triel_date"><?php esc_html_e('Trial End Date','gym_mgt');?></label>

							</div>

						</div>

					</div> -->

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="form-group input">

							<div class="col-md-12 form-control upload-profile-image-patient">

								<label class="ustom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>

								<div class="col-sm-12 display_flex">

									<input type="text" id="gmgt_user_avatar_url" class="form-control" name="gmgt_user_avatar" readonly value="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar );elseif(isset($_POST['gmgt_user_avatar'])) echo esc_url($_POST['gmgt_user_avatar']); ?>" />

									<input id="upload_user_avatar_button" type="button" class="button upload_image_btn pload_user_cover_button" style="float: right;" value="<?php esc_html_e( 'Upload Image', 'gym_mgt' ); ?>" />

								</div>

							</div>

							<div class="clearfix"></div>

							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

								<div id="upload_user_avatar_preview" >

									<?php 

									if($edit) 

									{

										if($user_info->gmgt_user_avatar == "")

										{

											?>

											<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_member_logo' )); ?>">

											<?php

										}

										else

										{

												?>

											<img class="image_preview_css"  src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />

											<?php 

										}

									}

									else 

									{

										?>

										<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_member_logo' )); ?>">

										<?php 

									}

									?>

								</div>

							</div>

						</div>

					</div>

					<!-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="first_payment_date" class="form-control date_picker" type="text"  name="first_payment_date" value="<?php if($edit){ if($user_info->first_payment_date!=""){ echo esc_attr(MJ_gmgt_getdate_in_input_box($user_info->first_payment_date)); } }elseif(isset($_POST['first_payment_date'])) echo esc_attr($_POST['first_payment_date']);?>"  readonly>

								<label class="date_label" for="first_payment_date"><?php esc_html_e('First Payment Date','gym_mgt');?></label>

							</div>

						</div>

					</div> -->

					<div id="no_of_class"></div>

				</div>
				<!-- Row Div End  -->

			</div>
			
			<!-- user_form End--> 

			<!----------   save btn    --------------> 

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 

					<div class="col-md-6 col-sm-6 col-xs-12"> 	

						<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save Member','gym_mgt');}?>" name="save_member" class="btn save_btn class_submit "  />

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End--> 

		</form><!-- MEMBER FROM END-->

	</div><!-- PANEL BODY DIV END-->

<?php 

}

?>

<!----------ADD STAFF MEMBER POPUP------------->

<style type="text/css">

	.dropdown .multiselect {

    min-width: 105px;

}

</style>

<div class="modal fade" id="myModal_add_staff_member" tabindex="-1" aria-labelledby="myModal_add_staff_member" aria-hidden="true" role="dialog"><!-- MODAL MAIN DIV START-->

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

										<input id="member_type" class="form-control validate[custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($user_info->member_type);}elseif(isset($_POST['member_type'])) echo esc_attr($_POST['member_type']);?>" name="member_type" >

										<label class="" for="member_type"><?php esc_html_e('Member Type','gym_mgt');?></label>

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

													<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>

													<label class="radio-inline custom_radio margin_left_5px">

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

										<input  class="form-control validate[required] birth_date date_picker" type="text"  name="birth_date" value="<?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); ?>"  readonly>

										<label class="date_of_birth_label date_label" for="birth_date"><?php esc_html_e('Date of Birth','gym_mgt');?><span class="require-field">*</span></label>

									</div>

								</div>

							</div>

							<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">

								<label class="ml-1 custom-top-label top" for="role_type"><?php esc_html_e('Assign Role','gym_mgt');?><span class="require-field">*</span></label>

								<select class="form-control validate[required]" name="role_type" id="role_type" >

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

								<button id="addremove" model="activity_category" class="add_btn"><?php esc_html_e('Add','gym_mgt');?></button>

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



			<!-- <div class="modal-footer">



				<button type="button" class="btn btn-default margin_top_10_res" data-bs-dismiss="modal"><?php esc_html_e('Close','gym_mgt'); ?></button>



			</div> -->



		</div><!-- MODAL CONTENT DIV END-->



	</div><!-- MODAL DIALOG DIV END-->



</div><!-- MODAL MAIN DIV END-->



<!----------ADD GORUP POPUP------------->



<div class="modal fade" id="myModal_add_group" tabindex="-1" aria-labelledby="myModal_add_group" aria-hidden="true" role="dialog"><!-- MODAL MAIN DIV START-->



	<div class="modal-dialog modal-lg"><!-- MODAL DIALOG DIV START-->



		<div class="modal-content"><!-- MODAL CONTENT DIV START-->



			<div class="modal-header float_left_width_100 mb-3 pop_btn_bg">



				<h3 class="modal-title float_left"><?php esc_html_e('Add Group','gym_mgt');?></h3>



				<button type="button" class="close float_right" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></button>



			</div>



			<!-- <div class="modal-header mb-3">



				<a href="" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>



				<h4 class="modal-title"><?php esc_html_e('Add Group','gym_mgt');?></h4>



			</div> -->



			<div class="modal-body"><!-- MODAL BODY DIV START-->



				<form id="group_form" name="group_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" ><!-- GROUP FORM START-->



					<input type="hidden" name="action" value="MJ_gmgt_add_group">



					<input type="hidden" name="group_id" value=""  />



					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Group Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!--form-Body div Strat-->   



						<div class="row"><!--Row Div--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="group_name" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if(isset($_POST['group_name'])) echo esc_attr($_POST['group_name']);?>" name="group_name">



										<label class="" for="group_name"><?php esc_html_e('Group Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>







							<div class="col-md-6 note_text_notice">



								<div class="form-group input">



									<div class="col-md-12 note_border margin_bottom_15px_res">



										<div class="form-field">



											<textarea name="group_description" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="500" ></textarea>



											<span class="txt-title-label"></span>



											<label class="text-area address active" for=""><?php esc_html_e('Group Description','gym_mgt');?></label>



										</div>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control upload-profile-image-patient">



										<label class="ustom-control-label custom-top-label ml-2" for="gmgt_membershipimage"><?php esc_html_e('Group Image','gym_mgt');?></label>



										<div class="col-sm-12 display_flex">



											<input type="text" class="image_margin_right_10px" id="gmgt_gym_background_image" name="gmgt_groupimage" readonly value="<?php if(isset($_POST['gmgt_groupimage'])) echo esc_url($_POST['gmgt_groupimage']);?>" />	



											<input id="upload_image_button" type="button" class="button upload_image_btn upload_user_cover_button" style="float: right;" value="<?php esc_html_e( 'Upload Cover Image', 'gym_mgt' ); ?>" />



										</div>



									</div>



									<div class="clearfix"></div>



									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">



										<div id="upload_gym_cover_preview" >



											<img class="image_preview_css image_preview_css_123" src="<?php echo get_option( 'gmgt_group_logo' );?>" />



										</div>



									</div>



								</div>



							</div>



						</div>



					</div>



					<!------------   save btn  -------------->  



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn--> 



								<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_group" class="btn save_btn save_group_btn"/>



							</div>



						</div>



					</div>



				</form><!-- GROUP FORM END-->



			</div><!-- MODAL BODY DIV END-->



		</div><!-- MODAL CONTENT DIV END-->



	</div><!-- MODAL DIALOG DIV END-->



</div><!-- MODAL MAIN DIV END-->



<!----------ADD MEMBERSHIP POPUP------------->



<div class="modal fade" id="myModal_add_membership" tabindex="-1" aria-labelledby="myModal_add_membership" aria-hidden="true" role="dialog"><!-- MODAL MAIN DIV START-->

	

	<div class="modal-dialog modal-lg"><!-- MODAL DIALOG DIV START-->



		<div class="modal-content"><!-- MODAL ContENT DIV START-->



			<div class="modal-header float_left_width_100 mb-3 pop_btn_bg">



				<h3 class="modal-title float_left"><?php esc_html_e('Add Membership','gym_mgt');?></h3>



				<button type="button" class="close float_right" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></button>



			</div>







			<div id="message" class="updated below-h2 show_msg">



				<p><?php esc_html_e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?></p>



			</div>



			<div class="modal-body">







				<form name="membership_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="membership_form">



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



										<input id="membership_name" class="form-control validate[required,custom[popup_category_validation]] text-input"  maxlength="50" type="text" value="<?php if(isset($_POST['membership_name'])) echo esc_attr($_POST['membership_name']);?>" name="membership_name">



										<label class="" for="membership_name"><?php esc_html_e('Membership Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<!--nonce-->



							<?php wp_nonce_field( 'save_membership_nonce' ); ?>



							<!--nonce-->



							<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">



								<label class="ml-1 custom-top-label top" for="membership_category"><?php esc_html_e('Membership Category','gym_mgt');?><span class="require-field">*</span></label>									



								<select class="form-control validate[required] selectpicker span3 max_width_100" name="membership_category" id="membership_category">



									<option value=""><?php esc_html_e('Select Membership Category','gym_mgt');?></option>



									<?php 				



									if(isset($_REQUEST['membership_category']))



									{



										$category =esc_attr($_REQUEST['membership_category']);  



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



										<input id="membership_period" class="form-control validate[required,custom[number]] text-input" min="0" type="number" onKeyPress="if(this.value.length==3) return false;" value="<?php if(isset($_POST['membership_period'])) echo esc_attr($_POST['membership_period']);?>" name="membership_period" placeholder="<?php esc_html_e('Enter Total Number of Days','gym_mgt');?>">



										<label class="label_ml_10px" for="membership_period"><?php esc_html_e('Membership Period(Days)','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="membership_amount" class="form-control text-input" type="number" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" value="<?php if(isset($_POST['membership_amount'])) echo esc_attr($_POST['membership_amount']);?>" name="membership_amount" placeholder="<?php esc_html_e('Amount','gym_mgt');?>">



										<label class="label_ml_10px" for="installment_amount"><?php esc_html_e('Membership Amount','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>



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



													<?php $limitval = "unlimited"; if(isset($_POST['gender'])) {$limitval=sanitize_text_field($_POST['gender']);}?>



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



													<?php $limitvals = "unlimited"; if(isset($_POST['gender'])) {$limitvals=sanitize_text_field($_POST['gender']);}?>



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



								<div id="member_limit" class=""></div>





							</div>



							<div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div id="classis_limit" class=""></div>





							</div>



						</div><!--Row Div End--> 



					</div> <!-- user_form End-->  



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="installment_amount" class="form-control text-input" min="0" onkeypress="if(this.value.length==8) return false;" step="0.01" type="number" value="<?php if(isset($_POST['installment_amount'])) echo esc_attr($_POST['installment_amount']);?>" name="installment_amount" placeholder="<?php esc_html_e('Amount','gym_mgt');?>">



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



										<input id="signup_fee" class="form-control text-input" min="0"  onkeypress="if(this.value.length==8) return false;" step="0.01" type="number" value="<?php if(isset($_POST['membership_name'])) echo esc_attr($_POST['membership_name']);?>" name="signup_fee" placeholder="<?php esc_html_e('Amount','gym_mgt');?>" >



										<label class="" for="signup_fee"><?php esc_html_e('Signup Fee','gym_mgt');?>(<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?>)</label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 rtl_margin_top_15px col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



								<!-- <label class="col-sm-2 control-label form-label" for=""><?php esc_html_e('Tax','gym_mgt');?>(%)</label> -->



								<select  class="form-control tax_charge" name="tax[]" multiple="multiple">



									<?php





									$tax_id[]='';



									



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





									$activity_category_array[]='';





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



					<div class="form-body user_form">



						<div class="row">



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



<!----------ADD CLASS POPUP------------->



<div class="modal fade" id="myModal_add_class" tabindex="-1" aria-labelledby="myModal_add_staff_member" aria-hidden="true" role="dialog"><!--MODAL MAIN DIV START-->



	<div class="modal-dialog modal-lg"><!--MODAL DIALOG DIV START-->



		<div class="modal-content"><!--MODAL CONTENT DIV START-->



			<div class="modal-header float_left_width_100 mb-3 pop_btn_bg">



				<h3 class="modal-title float_left"><?php esc_html_e('Add Class','gym_mgt');?></h3>



				<button type="button" class="close float_right" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></button>



			</div>



						



			<div class="modal-body"><!--MODAL BODY DIV START-->



				<form name="class_form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="form-horizontal" id="class_form"><!--CLASS FORM START-->



					<input type="hidden" name="action" value="MJ_gmgt_add_ajax_class">



					<input type="hidden" name="class_id" value=""  />







					<div class="header">	



						<h3 class="first_hed"><?php esc_html_e('Class Information','gym_mgt');?></h3>



					</div>



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat-->







							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="class_name" class="form-control validate text-input validate[required,custom[popup_category_validation]]" maxlength="50" type="text" value="" name="class_name">



										<label class="" for="class_name"><?php esc_html_e('Class Name','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>











							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>



								<?php 



								$get_staff = array('role' => 'Staff_member');



								$staffdata=get_users($get_staff);?>



								<select name="staff_id" class="form-control validate[required] " id="staff_id">



									<option value=""><?php esc_html_e('Select Staff Member','gym_mgt');?></option>



									<?php 								



									$staff_data="";



									if(!empty($staffdata))



									{



										foreach($staffdata as $staff)



										{



											echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).'</option>';



										}



									}



									?>



								</select>



							</div>







							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



								<label class="ml-1 custom-top-label top" for="member_type"><?php esc_html_e('Select Assistant Staff Member','gym_mgt');?></label>



								<?php 



								$get_staff = array('role' => 'Staff_member');



								$staffdata=get_users($get_staff);?>



								<select name="asst_staff_id" class="form-control" id="asst_staff_id">



									<option value=""><?php esc_html_e('Select Assistant Staff Member ','gym_mgt');?></option>



									<?php



									$assi_staff_data="";



									if(!empty($staffdata))



									{



										foreach($staffdata as $staff)



										{



											echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($assi_staff_data),esc_attr($staff->ID)).'>'.esc_attr($staff->display_name).'</option>';



										}



									}



									?>



								</select>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px res_margin_bottom_20px day_validation_member smgt_multiple_select">



								<select name="day[]" class="form-control validate[required]" id="day" multiple="multiple">							



									<?php $class_days=array();



									foreach(MJ_gmgt_days_array() as $key=>$day)



									{



										$selected = "";



										if(in_array($key,$class_days))



											$selected = "selected";



										echo '<option value='.esc_attr($key).' '.esc_attr($selected).'>'.esc_html($day).'</option>';



									}?>



								</select>



							</div>







							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="class_date"  class="form-control class_date validate[required] date_picker" type="text" value="<?php  echo esc_attr(MJ_gmgt_getdate_in_input_box(date("Y-m-d"))); ?>" name="start_date">



										<label class="date_label" for="invoice_date"><?php esc_html_e('Start Date','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input id="end_date_class"  class="form-control class_date validate[required] date_picker" type="text" value="<?php echo esc_attr(MJ_gmgt_getdate_in_input_box(date("Y-m-d"))); ?>" name="end_date">



										<label class="date_label" for="End"><?php esc_html_e('End Date','gym_mgt');?><span class="text-danger"> *</span></label>



									</div>



								</div>



							</div>



							



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px res_margin_bottom_20px multiselect_validation_membership smgt_multiple_select">



								<!-- <label class="col-sm-2 control-label form-label" for="day"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label> -->



								<?php



									$membersdata=array();



									$data=array();



								?>



								<?php $membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>



								<select name="membership_id[]" class="form-control" multiple="multiple" id="class_membership_id">	



									<?php 					



									if(!empty($membershipdata))



									{



										foreach ($membershipdata as $membership)



										{



											$selected = "";



											if(in_array($membership->membership_id,$data))



												$selected="selected";



											echo '<option value='.esc_attr($membership->membership_id) .' '.esc_attr($selected).' >'.esc_html($membership->membership_label).'</option>';



										}



									}



									?>



								</select>



							</div>







							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



								<div class="form-group input">



									<div class="col-md-12 form-control">



										<input  class="form-control validate[required] text-input" min="0" onkeypress="if(this.value.length==3) return false;" type="number" value="" name="member_limit">



										<label class="" for="quentity"><?php esc_html_e('Member Limit','gym_mgt');?><span class="require-field">*</span></label>



									</div>



								</div>



							</div>	



							<div class="add_more_time_entry">



								<div class="time_entry">



									



									<div class="mb-3 row">



										<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">



											<label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label>



											<select name="start_time[]" class="form-control validate[required] max_width_100">



												<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



												<?php 



												for($i =0 ; $i <= 12 ; $i++)



												{



												?>



													<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>



												<?php



												}



												?>



											</select>



										</div>



										<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



											<select name="start_min[]" class="form-control validate[required]">



												<?php 



												foreach(MJ_gmgt_minute_array() as $key=>$value)



												{?>



													<option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option>



												<?php



												}



												?>



											</select>



										</div>



										<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



											<select name="start_ampm[]" class="form-control validate[required]">



												<option value="am"><?php esc_html_e('am','gym_mgt');?></option>



												<option value="pm"><?php esc_html_e('pm','gym_mgt');?></option>



											</select>



										</div>



									</div>



									<div class="mb-3 row">



										<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">



											<label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label>



											<select name="end_time[]" class="form-control validate[required]">



												<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



													<?php 



													for($i =0 ; $i <= 12 ; $i++)



													{



													?>



														<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>



													<?php



													}



													?>



											</select>



										</div>



										<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 rtl_margin_top_15px">



											<select name="end_min[]" class="form-control validate[required]">



												<?php 



												foreach(MJ_gmgt_minute_array() as $key=>$value)



												{



												?>



													<option value="<?php echo esc_attr($key);?>"><?php echo esc_html_e($value);?></option>



												<?php



												}



												?>



											</select>



										</div>



										<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">				



											<select name="end_ampm[]" class="form-control validate[required]">



												<option value="am"><?php esc_html_e('am','gym_mgt');?></option>



												<option value="pm"><?php esc_html_e('pm','gym_mgt');?></option>



											</select>



										</div>	



										<div class="col-md-2 symptoms_deopdown_div rtl_margin_top_15px">



											<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>"  id="add_new_entry" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr">



										</div>



									</div>



								</div>



							</div>



							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px">



								<div class="form-group">



									<div class="col-md-12 form-control">



										<div class="">



										<label class="custom-top-label" for="quentity"><?php esc_html_e('Class Color','gym_mgt');?></label>



										<input type="color" value="<?php if(isset($_POST['class_color'])) echo esc_attr($_POST['class_color']);?>" name="class_color">



									</div>



								</div>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 







					<!------------   save btn  -------------->  



					<div class="form-body user_form"> <!-- user_form Strat-->   



						<div class="row"><!--Row Div Strat--> 



							<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><!--save btn--> 



								<input type="submit" value="<?php esc_html_e('Save','gym_mgt');?>" name="save_class" class="btn save_btn day_validation_submit"/>



							</div>



						</div><!--Row Div End--> 



					</div><!-- user_form End--> 







				</form><!--CLASS FORM END-->



			</div><!--MODAL BODY DIV END-->



		</div><!--MODAL CONTENT DIV END-->



	</div><!--MODAL DIALOG DIV END-->



</div>	<!--MODAL MAIN DIV END-->



<script>	



$(document).ready(function() 



{



	"use strict";



	let member_type = document.querySelector('#member_type');
	if (member_type) {
		function checkId(id){
			jQuery.ajax({
				type: 'POST',
				url:"<?php echo admin_url( 'admin-ajax.php' );?>",
				data: {
				"action": "gms_get_user_ajax",
				"check_id" : id
				},
				success: function (data) {
					let wrapper = document.querySelector('#primary-member-data');
					if( data?.error ) {
						alert(data.error);
						if ( wrapper ) {
							wrapper.innerHTML = "";
						}
					} else {
						let member_id = document.querySelector('#member_id');
						let htmlData = '<div>'
						if ( member_id) {
							member_id.value = data?.new_member_id;
						}
						let check_id_user = document.querySelector( '#check_id_user');
						if ( check_id_user) {
							check_id_user.value = data?.primary_user_id
							htmlData += "<div><strong>Primary Member Id: </strong><span>" + data?.primary_user_id + "</span></div>";
						}
						htmlData += "<div><strong>Primary Member name: </strong><span>" + data?.name + "</span></div>";
						htmlData += "<div><strong>Member Ship: </strong><span>" + data?.get_membership_type + "</span></div>";
						htmlData += "<div><strong>Email: </strong><span>" + data?.email + "</span></div>";
						if ( wrapper ) {
							wrapper.innerHTML = htmlData + "<br/></div>"
						}
						let membership_id = document.querySelector('#membership_id');
						if (membership_id && data?.get_membership_type?.[1] ) {
							membership_id.value= data?.get_membership_type?.[1];
							membership_id.dispatchEvent(new Event('click'));
							membership_id.dispatchEvent(new Event('change', {bubbles:true}));
						}
						let begin_date = document.querySelector('#begin_date');
						if (begin_date && data?.begin_date ) {
							begin_date.value= data?.begin_date;
							membership_id.dispatchEvent(new Event('change', {bubbles:true}));
						}
						let end_date = document.querySelector('#end_date');
						if (end_date && data?.end_date ) {
							end_date.value= data?.end_date;
							membership_id.dispatchEvent(new Event('change', {bubbles:true}));
						}
					}
				}
			});
		}
		let primary_id_div = document.querySelector('#primary_id_div');
		member_type.addEventListener('change', (e) => {
			let member_id = document.querySelector('#member_id');
			if ( e.target.value === "Dependent") {
				member_id.value = member_id.value + "D1";
				primary_id_div.innerHTML = `<br/><span class="" for="primary_id">Enter Primary Id<span class="require-field">*</span></span><input id="primary_id" class="form-control text-input" maxlength="50" type="text" value="" name="primary_id"><br/><a href="javascript:void(0);" class="btn save_btn" style="margin-top:5px; display:inline-block;" id="check_primary_id">Check</a> <br/><br/> 
				<div><span class="" for="primary_id">Relation<span class="require-field">*</span><input id="relation" class="form-control validate[custom[city_state_country_validation]]" required type="text" name="relation" value=""></div>`;
				
			} else {
				member_id.value = member_id.value.replace("D1", "")
				primary_id_div.innerHTML = ""
			}
		});

		primary_id_div.addEventListener("click", (e)=> {
			let primary_id = document.querySelector('#primary_id');
			if( e.target.id === "check_primary_id") {
				if ( primary_id.value.length ) {
					checkId(primary_id.value);
					// let url = new URL(window.location.href);
					// url.searchParams.set("check_id",primary_id.value)
					// window.location.href =url.href;
				} else {
					alert("Please Enter Primary Id")
				}
			}
		})
	}

	function toggleDependentFields() {
		var memberType = document.getElementById("member_type").value;
		var dependentFields = document.getElementById("dependentFields");

		if (memberType === "Dependent") {
		dependentFields.style.display = "none";
		} else {
		dependentFields.style.display = "block";
		}
	}
	var date = new Date();



	date.setDate(date.getDate()-0);



	$('.class_date').datepicker({

		<?php

		if(get_option('gym_enable_datepicker_privious_date')=='no')

		{

		?>

			minDate:'today',

		<?php

		}

		?>

	startDate: date,



	dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



	autoclose: true

   });

});

//ADD ENTRY

function add_entry()

{

	//$(".add_more_time_entry").append('<div class="time_entry"><div class="mb-3 row"><div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input"><label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label><select name="start_time[]" class="form-control validate[required]"><option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>  <?php for($i =0 ; $i <= 12 ; $i++) { ?> <option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option> <?php } ?></select></div><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><select name="start_min[]" class="form-control validate[required]"> <?php foreach(MJ_gmgt_minute_array() as $key=>$value){ ?> <option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option><?php }?></select></div><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><select name="start_ampm[]" class="form-control validate[required]"><option value="am"><?php esc_html_e('am','gym_mgt');?></option><option value="pm"><?php esc_html_e('pm','gym_mgt');?></option></select></div></div><div class="mb-3 row"><div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input"><label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label><select name="end_time[]" class="form-control validate[required]"><option value=""><?php esc_html_e('Select Time','gym_mgt');?></option><?php for($i =0 ; $i <= 12 ; $i++){ ?><option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option><?php } ?></select></div><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><select name="end_min[]" class="form-control validate[required]"> <?php foreach(MJ_gmgt_minute_array() as $key=>$value) { ?><option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option><?php } ?> </select></div><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><select name="end_ampm[]" class="form-control validate[required]"><option value="am"><?php esc_html_e('am','gym_mgt');?></option><option value="pm"><?php esc_html_e('pm','gym_mgt');?></option></select></div><div class="col-sm-2 symptoms_deopdown_div"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div>');

	$(".add_more_time_entry").append('<div class="time_entry"><div class="form-group"><div class="mb-3 row"><div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input"><label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label><select name="start_time[]" class="form-control validate[required] max_width_100"><option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>  <?php for($i =0 ; $i <= 12 ; $i++) { ?> <option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option> <?php } ?></select></div><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><select name="start_min[]" class="form-control validate[required] rtl_margin_top_15pxmargin_top_10_res"> <?php foreach(MJ_gmgt_minute_array() as $key=>$value){ ?> <option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option><?php }?></select></div><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><select name="start_ampm[]" class="form-control validate[required] margin_top_10_res"><option value="am"><?php esc_html_e('am','gym_mgt');?></option><option value="pm"><?php esc_html_e('pm','gym_mgt');?></option></select></div></div></div><div class="form-group"><div class="mb-3 row"><div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input"><label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label><select name="end_time[]" class="form-control validate[required]"><option value=""><?php esc_html_e('Select Time','gym_mgt');?></option> <?php for($i =0 ; $i <= 12 ; $i++){ ?><option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option><?php } ?></select></div><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3"><select name="end_min[]" class="form-control validate[required] rtl_margin_top_15px margin_top_10_res"><?php foreach(MJ_gmgt_minute_array() as $key=>$value) { ?><option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option><?php } ?></select></div><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><select name="end_ampm[]" class="form-control validate[required] margin_top_10_res"><option value="am"><?php esc_html_e('am','gym_mgt');?></option><option value="pm"><?php esc_html_e('pm','gym_mgt');?></option></select></div><div class="col-sm-2 symptoms_deopdown_div"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""></div></div></div></div>');			

}

// REMOVING ENTRY

function deleteParentElement(n)

{

	alert("<?php esc_html_e('Do you really want to delete this time Slots?','gym_mgt');?>");

	n.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode.parentNode.parentNode);

}
</script>