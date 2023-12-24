<?php 

$api->useSecure(true);

$retval = $api->lists();

?>

<script type="text/javascript">

	$(document).ready(function() 

	{

		"use strict";

		$('#setting_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	

	} );

</script>

<div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->

    <form name="template_form" action="" method="post" class="form-horizontal" id="setting_form"><!--Mailing LIST SYNCRONIZE USER FORM STRAT-->

		<div class="header">	

			<h3 class="first_hed"><?php esc_html_e('Sync Mail Information','gym_mgt');?></h3>

		</div>

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 



				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 rtl_margin_top_15px mb-3">

					<div class="form-group">

						<div class="col-md-12 form-control">

							<div class="row padding_radio">

								<div class="checkbox">

									<label class="custom-top-label" for="enable_quote_tab"><?php esc_html_e('Class List','gym_mgt');?></label>

									<div class="checkbox">

										<div class="row margin_top_15px_rs">

											<?php 

											//GET ALL Class DATA

											$classdata=$obj_class->MJ_gmgt_get_all_classes();

											if(!empty($classdata))

											{

												foreach ($classdata as $retrieved_data)

												{ ?>							

													<div class="col-md-6 mb-2 rtl_sync_three_dots">

														<input type="checkbox" class="margin_left_0_res" name="syncmail[]"  value="<?php echo esc_attr($retrieved_data->class_id)?>"/><?php echo esc_html($retrieved_data->class_name);?> ( <?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->start_time)).' - '.MJ_gmgt_timeremovecolonbefoream_pm($retrieved_data->end_time);?>)

													</div>

													<?php 

												}

											}

											?>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>



				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">

					<label class="ml-1 custom-top-label top" for="list_id"><?php esc_html_e('Mailing List','gym_mgt');?><span class="require-field">*</span></label>

					<select name="list_id" id="list_id"  class="form-control validate[required]">

						<option value=""><?php esc_html_e('Select list','gym_mgt');?></option>

						<?php 

						//Mailing LIST DATA

						foreach ($retval['data'] as $list)

						{						

							echo '<option value="'.esc_attr($list['id']).'">'.esc_html($list['name']).'</option>';

						}

						?>

					</select>

				</div>



			</div><!--Row Div End--> 

		</div><!-- user_form End--> 

		<?php 

		if($user_access_add == '1')

		{

			?>

			<!------------   save btn  -------------->  

			<div class="form-body user_form"> <!-- user_form Strat-->   

				<div class="row"><!--Row Div Strat--> 

					<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn-->    	

						<input type="submit" value="<?php esc_html_e('Sync Mail', 'gym_mgt' ); ?>" name="sychroniz_email" class="btn save_btn"/>

					</div>

				</div><!--Row Div End--> 

			</div><!-- user_form End-->

			<?php 

		} ?>

    </form><!--Mailing LIST SYNCRONIZE USER FORM END-->

</div><!--PANEL BODY DIV END-->