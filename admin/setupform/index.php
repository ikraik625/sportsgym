<?php 

$active_tab = isset($_GET['tab'])?$_GET['tab']:'setup';

?>

<div id="cmgt_imgSpinner1">	

</div>

<div class="gmgt_ajax-ani"></div>

<div class="gmgt_ajax-img">

	<img src="<?php echo GMS_PLUGIN_URL.'/assets/images/loading.gif';?>" height="50px" width="50px">

</div>

<div class="page-inner min_height_1088"><!--PAGE INNER DIV START-->

	<?php 

	if(isset($_REQUEST['varify_key']))

	{
		// promptPosition : "bottomLeft",

		$verify_result = MJ_gmgt_submit_setupform($_POST);
	
		if($verify_result['gmgt_verify'] != '0')

		{

			echo '<div id="message" class="updated notice notice-success is-dismissible"><p>'.$verify_result['message'].'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';

		}

	}

	?>

	<script type="text/javascript">

	$(document).ready(function() 

	{

		"use strict";

		$('#verification_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});	

	});

	</script>

	<?php 

	if(isset($_SESSION['gmgt_verify']) && $_SESSION['gmgt_verify'] == '3')

	{

	?>

		<div id="message" class="updated notice notice-success">

			<?php esc_html_e('There seems to be some problem please try after sometime or contact us on sales@dasinfomeida.com','gym_mgt');?>

		</div>

	<?php 

	}

	elseif(isset($_SESSION['gmgt_verify']) && $_SESSION['gmgt_verify'] == '1')

	{

	?>

		<div id="message" class="updated notice notice-success">

			<?php esc_html_e('Please provide correct Envato purchase key.','gym_mgt');?>

		</div>

	<?php 

	}

	else

	{

	?>

	<div id="message" class="updated notice notice-success display_none"></div>

	<?php }?>

	<div id="" class="gms_main_list"><!--MAIN WRAPPER DIV START-->

		<div class="row "><!--ROW DIV START-->

			<div class="col-md-12 padding_0"><!--COL 12 DIV START-->

				<div class=""><!--PANEL WHITE DIV START-->

					<div class="panel-body"><!--PANEL BODY DIV START-->	

					  <form name="verification_form" action="" method="post" class="form-horizontal" id="verification_form"><!--VERIFICATION FORM START-->

							<div class="form-body user_form"> <!-- user_form Strat-->   

								<div class="row"><!--Row Div Strat-->

									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">

										<div class="form-group input">

											<div class="col-md-12 form-control">

												<input id="server_name" class="form-control validate[required]" type="text"value="<?php echo esc_attr($_SERVER['SERVER_NAME']);?>" name="domain_name" readonly>

												<label class="" for="Description"><?php esc_html_e('Domain','gym_mgt');?><span class="require-field">*</span></label>

											</div>

										</div>

									</div>

									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">

										<div class="form-group input">

											<div class="col-md-12 form-control">

												<input id="licence_key" class="form-control validate[required]" type="text"  value="" name="licence_key">

												<label class="" for="Description"><?php esc_html_e('Envato License key','gym_mgt');?><span class="require-field">*</span></label>

											</div>

										</div>

									</div>

									<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">

										<div class="form-group input">

											<div class="col-md-12 form-control">

												<input id="enter_email" class="form-control validate[required,custom[email]]" type="text" value="" name="enter_email">

												<label class="" for="Description"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>

											</div>

										</div>

									</div>

								</div>

							</div>

							<div class="form-body user_form"> <!-- user_form Strat-->   

								<div class="row"><!--Row Div Strat-->

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

										<input type="submit" value="<?php esc_html_e('Submit','gym_mgt');?>" name="varify_key" id="varify_key" class="btn save_btn"/>

									</div>

								</div>

							</div>

						</form>	<!--VERIFICATION FORM END-->

					</div><!--PANEL BODY DIV END-->		

				</div><!--PANEL WHITE DIV END-->

			</div><!--COL 12 DIV END-->

		</div><!--ROW DIV END-->

	</div><!--MAIN WRAPPER DIV END-->

</div><!--PAGE INNER DIV END-->