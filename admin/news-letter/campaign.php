<?php 
$retval = $api->campaigns();
$api->useSecure(true);
$retval1 = $api->lists();
?>
<script type="text/javascript">
$(document).ready(function() 
{
	"use strict";
	$('#setting_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
} );
</script>
<div class="panel-body padding_0"><!--PANEL BODY DIV STRAT-->
    <form name="student_form" action="" method="post" class="form-horizontal" id="setting_form"><!--Campaign FORM STRAT-->
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Campaign Information','gym_mgt');?></h3>
		</div>
		<div class="form-body user_form"> <!-- user_form Strat-->   
			<div class="row"><!--Row Div Strat--> 
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">
					<label class="ml-1 custom-top-label top" for="quote_form"><?php esc_html_e('Mail Chimp list','gym_mgt');?><span class="require-field">*</span></label>
					<select name="list_id" id="quote_form"  class="form-control validate[required]">
						<option value=""><?php esc_html_e('Select list','gym_mgt');?></option>
						<?php 
						foreach ($retval1['data'] as $list)
						{						
							echo '<option value="'.esc_attr($list['id']).'">'.esc_html($list['name']).'</option>';
						}
						?>
					</select>
				</div>
				<!--nonce-->
				<?php wp_nonce_field( 'send_campign_nonce' ); ?>
				<!--nonce-->
				<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">
					<label class="ml-1 custom-top-label top" for="quote_form"><?php esc_html_e('Campaign list','gym_mgt');?><span class="require-field">*</span></label>
					<select name="camp_id" id="quote_form"  class="form-control validate[required]">
						<option value=""><?php esc_html_e('Select Campaign','gym_mgt');?></option>
						<?php 
						foreach ($retval['data'] as $c)
						{						
							echo '<option value="'.esc_attr($c['id']).'">'.esc_html($c['title']).'</option>';
						}
						?>
					</select>
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
						<input type="submit" value="<?php esc_html_e('Send Campaign', 'gym_mgt' ); ?>" name="send_campign" class="btn save_btn"/>
					</div>
				</div><!--Row Div End--> 
			</div><!-- user_form End--> 
			<?php 
		} ?>
    </form><!--Campaign FORM END-->
</div><!--PANEL BODYDIV END-->