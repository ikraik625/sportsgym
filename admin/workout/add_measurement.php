<?php 



$edit = 0;



if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



{



	$edit=1;



	$result = $obj_workout->MJ_gmgt_get_single_measurement($_REQUEST['measurment_id']);



}



?>



<script type="text/javascript">



$(document).ready(function()



{



	"use strict";



	$('#workout_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	



	$(".display-members").select2();



	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



	var date = new Date();



	 date.setDate(date.getDate()-0);



	$('#result_date').datepicker(



	{



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



} );



</script>



<div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->



	<form name="workout_form" action="" method="post" class="form-horizontal" id="workout_form"><!--WORKOUT FORM STRAT-->



	   <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



		<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



		<input type="hidden" name="measurment_id" value="<?php if(isset($_REQUEST['measurment_id']))echo $_REQUEST['measurment_id'];?>">



		<div class="header">	



			<h3 class="first_hed"><?php esc_html_e('Measurement Information','gym_mgt');?></h3>



		</div>



		<div class="form-body user_form"> <!-- user_form Strat-->   



			<div class="row"><!--Row Div Strat-->



				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



					<!-- <label class="ml-1 custom-top-label top" for="refered"><?php //esc_html_e('Member','gym_mgt');?><span class="require-field">*</span></label> -->



					<?php if($edit){ $member_id=$result->user_id; }elseif(isset($_REQUEST['user_id'])){$member_id=esc_attr($_REQUEST['user_id']);}else{$member_id='';}?>



					<select id="member_list" class="form-control display-members" name="user_id">



						<option value=""><?php esc_html_e('Select Member','gym_mgt');?></option>



							<?php $get_members = array('role' => 'member');



							$membersdata=get_users($get_members);



							 if(!empty($membersdata))



							 {



								foreach ($membersdata as $member)



								{



									if( $member->membership_status == "Continue"  && $member->member_type == "Member")



									{?>



										<option value="<?php echo esc_attr($member->ID);?>" <?php selected(esc_attr($member_id),esc_attr($member->ID));?>><?php echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($member->ID))); ?> </option>



									<?php



									}



								}



							 }?>



				   </select>



				</div>



				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



					<label class="ml-1 custom-top-label top" for="refered"><?php esc_html_e('Result Measurement','gym_mgt');?><span class="require-field">*</span></label>



					<?php



					if($edit)



					{



						$measument=$result->result_measurment;



					}



					elseif(isset($_REQUEST['result_measurment']))



					{



						$measument = esc_attr($_REQUEST['result_measurment']);



					}



					else



					{



						$measument="";



					}?>



					<select name="result_measurment" class="form-control validate[required] " id="result_measurment">



						<option value=""><?php  esc_html_e('Select Result Measurement ','gym_mgt');?></option>



						<?php 	



						foreach(MJ_gmgt_measurement_array() as $key=>$element)



						{

						  if($element == 'Height')



							{



								$unit= get_option( 'gmgt_height_unit' );



							}



						   elseif($element == 'Weight')



						   {



							  $unit= get_option( 'gmgt_weight_unit' );



						   }



						   elseif($element == 'Chest')



						   {



							  $unit= get_option( 'gmgt_chest_unit' );



						   }



						   elseif($element == 'Waist')



						   {



							  $unit= get_option( 'gmgt_waist_unit' );



						   }



						   elseif($element == 'Thigh')



						   {



							  $unit= get_option( 'gmgt_thigh_unit' );



						   }



						   elseif($element == 'Arms')



						   {



							  $unit= get_option( 'gmgt_arms_unit' );



						   }



							elseif($element == 'Fat')



						   {



							  $unit= get_option( 'gmgt_fat_unit' );



						   }

          

							

							// var_dump(get_option( 'gmgt_height_unit' ));



							echo '<option value='.esc_attr($key).' '.selected(esc_attr($measument),esc_attr($key)).'>'.esc_html__($element,'gym_mgt').' - '.esc_html__($unit,'gym_mgt').'</option>';



						}



						?>



					</select>



				</div>



				<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="result" class="form-control validate[required] text-input decimal_number" min="0" step="0.01" onKeyPress="if(this.value.length==6) return false;" type="number" value="<?php if($edit){ echo esc_attr($result->result);}elseif(isset($_POST['result'])) echo esc_attr($_POST['result']);?>" name="result">



							<label class="" for="Description"><?php esc_html_e('Result','gym_mgt');?><span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				<?php wp_nonce_field( 'save_measurement_nonce' ); ?>



				<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">



					<div class="form-group input">



						<div class="col-md-12 form-control">



							<input id="result_date" class="form-control validate[required] date_picker"  type="text"  name="result_date" value="<?php if($edit){ echo esc_attr(MJ_gmgt_getdate_in_input_box($result->result_date));} elseif(isset($_POST['result_date'])){ echo $_POST['result_date'];} else echo MJ_gmgt_getdate_in_input_box(date("Y-m-d")); ?>" readonly>



							<label class="date_label" for="Description"><?php esc_html_e('Record Date','gym_mgt');?><span class="require-field">*</span></label>



						</div>



					</div>



				</div>



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



					<div class="form-group input">



						<div class="col-md-12 form-control upload-profile-image-patient">



							<label class="ustom-control-label custom-top-label ml-2" for="photo"><?php esc_html_e('Image','gym_mgt');?></label>



							<div class="col-sm-12 display_flex">



								<input type="text" id="gmgt_user_avatar_url" class="form-control" name="gmgt_progress_image"  readonly value="<?php if($edit) echo esc_url( $result->gmgt_progress_image );elseif(isset($_POST['gmgt_progress_image'])) echo esc_attr($_POST['gmgt_progress_image']); ?>" />



								<input id="upload_user_avatar_button" type="button" class="button upload_image_btn " value="<?php esc_html_e( 'Upload image', 'gym_mgt' ); ?>" />



							</div>



						</div>



						<div class="clearfix"></div>



						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">



							<div id="upload_user_avatar_preview" >



								<?php 



								if($edit) 



								{						



									if($result->gmgt_progress_image == "")



									{ 



											?>



										<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_measurement_thumb' )); ?>">



										<?php 



									}



									else 



									{



										?>



										<img class="image_preview_css" src="<?php if($edit) echo esc_url( $result->gmgt_progress_image ); ?>" />



										<?php 



									}



								}



								else 



								{



									?>



									<img class="image_preview_css" src="<?php echo esc_url(get_option( 'gmgt_measurement_thumb' )); ?>">



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



				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">



					<input type="submit" value="<?php if($edit){ esc_html_e('Save Measurement','gym_mgt'); }else{ esc_html_e('Save Measurement','gym_mgt');}?>" name="save_measurement" class="btn save_member_validate save_btn"/>



				</div>



			</div>



		</div>



    </form><!--WORKOUT FORM END-->



</div><!--PANEL BODY DIV END-->