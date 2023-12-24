<?php ?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	$('#group_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

});

</script>

<?php 	

if($active_tab == 'addgroup')

{

	$group_id=0;

	if(isset($_REQUEST['group_id']))

	{

		$group_id=$_REQUEST['group_id'];

	}

	$edit=0;

	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')

	{

		$edit=1;

		$result = $obj_group->MJ_gmgt_get_single_group($group_id);

	}

	?>

    <div class="panel-body padding_0"><!-- PANEL BODY DIV START-->

		<form name="group_form"  action="" method="post" class="form-horizontal" id="group_form"><!-- GROUP FORM START-->

			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>

			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">

			<input type="hidden" name="group_id" value="<?php echo esc_attr($group_id);?>"  />



			<div class="header">	

				<h3 class="first_hed"><?php esc_html_e('Group Information','gym_mgt');?></h3>

			</div>

			<div class="form-body user_form"> <!--form-Body div Strat-->   

				<div class="row"><!--Row Div--> 

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input id="group_name" class="form-control validate[required,custom[popup_category_validation]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo esc_attr($result->group_name);}elseif(isset($_POST['group_name'])) echo esc_attr($_POST['group_name']);?>" name="group_name">

								<label class="" for="group_name"><?php esc_html_e('Group Name','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<!--nonce-->

					<?php wp_nonce_field( 'save_group_nonce' ); ?>

					<!--nonce-->

					<div class="col-md-6 note_text_notice">

						<div class="form-group input">

							<div class="col-md-12 note_border margin_bottom_15px_res">

								<div class="form-field">

									<textarea name="group_description" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="500" ><?php if($edit){ echo esc_attr($result->group_description);}?></textarea>

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

									<input type="text" id="gmgt_gym_background_image" class="form-control group_image_upload" name="gmgt_groupimage" readonly value="<?php if($edit){ echo esc_url($result->gmgt_groupimage);}elseif(isset($_POST['gmgt_groupimage'])) echo esc_url($_POST['gmgt_groupimage']);?>" />

									<input id="upload_image_button" type="button" class="button upload_image_btn upload_user_cover_button" style="float: right;" value="<?php esc_html_e('Upload Image','gym_mgt'); ?>" />

								</div>

							</div>

							<div class="clearfix"></div>

							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

								<div id="upload_gym_cover_preview" >

									<?php if($edit) 

									{

										if($result->gmgt_groupimage != '')

										{?>

											<img class="image_preview_css" src="<?php if($edit)echo esc_url($result->gmgt_groupimage); ?>" />

											<?php 

										}

										else 

										{

											?>

											<img class="image_preview_css" src="<?php echo get_option( 'gmgt_group_logo' ) ?>">

											<?php 

										}

									}

									else 

									{

										?>

										<img class="image_preview_css" src="<?php echo get_option( 'gmgt_group_logo' ) ?>">

										<?php  

									} ?>

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

						<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_group" class="btn save_btn"/>

					</div><!--save btn--> 

				</div>

			</div>

		</form><!-- GROUP FORM END-->

	</div><!-- PANEL BODY DIV END-->

 <?php 

}

?>