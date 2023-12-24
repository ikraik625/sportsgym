<?php ?>
<script type="text/javascript">
$(document).ready(function() 
{
	"use strict";
	$('#tax_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
} );
</script>
<?php 	
if($active_tab == 'addtax')
{
	$tax_id=0;
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$tax_id=esc_attr($_REQUEST['tax_id']);
		$result = $obj_tax->MJ_gmgt_get_single_tax_data($tax_id);
	}?>
	<div class="panel-body padding_0"><!--PANEL BODY DIV START-->	
		<form name="tax_form"  action="" method="post" class="form-horizontal" id="tax_form"><!--TAX FORM START-->	
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">
			<input type="hidden" name="tax_id" value="<?php echo esc_attr($tax_id);?>"  />
			<div class="header">	
				<h3 class="first_hed"><?php esc_html_e('Tax Information','gym_mgt');?></h3>
			</div>
			<div class="form-body user_form"> <!-- user_form Strat-->   
				<div class="row"><!--Row Div Strat-->
					<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input id="" maxlength="30" class="form-control validate[required,custom[address_description_validation]] text-input" type="text" value="<?php if($edit){ echo esc_attr($result->tax_title);}elseif(isset($_POST['tax_title'])) echo esc_attr($_POST['tax_title']);?>" name="tax_title">
								<label class="" for="date"><?php esc_html_e('Tax Name','gym_mgt');?><span class="require-field">*</span></label>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-6 col-sm-12 col-xl-6">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input id="tax" class="form-control validate[required,custom[number]] text-input" onkeypress="if(this.value.length==6) return false;" step="0.01" type="number" value="<?php if($edit){ echo esc_attr($result->tax_value);}elseif(isset($_POST['tax_value'])) echo esc_attr($_POST['tax_value']);?>" name="tax_value" min="0" max="100">
								<label class="" for="date"><?php esc_html_e('Tax Value','gym_mgt');?>(%)<span class="require-field">*</span></label>
							</div>
						</div>
					</div>
					<?php wp_nonce_field( 'save_tax_nonce' ); ?>
				</div>
			</div>
			<div class="form-body user_form"> <!-- user_form Strat-->   
				<div class="row"><!--Row Div Strat-->
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_tax" class="btn save_btn"/>
					</div>
				</div>
			</div>
		</form><!--TAX FORM END-->	
	</div><!--PANEL BODY DIV END-->	
 <?php 
}
?>