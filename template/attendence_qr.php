<script type="text/javascript">
$(document).ready(function() 
{	
	"use strict";
	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

	$('#curr_date').datepicker(
	{
		dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',

		endDate: '+0d',

		maxDate:'today',

		endDate: '+0d',

		autoclose: true,

		beforeShow: function (textbox, instance) 

		{

			instance.dpDiv.css(

			{

				marginTop: (-textbox.offsetHeight) + 'px'                   

			});

		}

	});

} );

</script>

<div class="panel-body attendence_penal_body"> 

	<form method="post">

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input id="curr_date" class="form-control qr_date"  type="text" value="<?php if(isset($_POST['curr_date'])) echo esc_attr($_POST['curr_date']); else echo  MJ_gmgt_getdate_in_input_box(date("Y-m-d"));?>" name="curr_date" readonly>

							<label class="" for="member_id"><?php esc_html_e('Date','gym_mgt');?></label>

						</div>

					</div>

				</div>   

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input">

					<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Class','gym_mgt');?><span class="require-field">*</span></label>

					<?php $class_id=0; if(isset($_POST['class_id'])){$class_id=$_POST['class_id'];}?>

					<select name="class_id" id="class_id" class="form-control qr_class_id">

						<option value=" "><?php esc_html_e('Select Class Name','gym_mgt');?></option>

						<?php 

						$classdata=$obj_class->MJ_gmgt_get_all_classes();

						foreach($classdata as $class)

						{  

						?>

							<option  value="<?php echo esc_attr($class->class_id);?>" <?php selected(esc_attr($class->class_id),esc_attr($class_id))?>><?php echo esc_html($class->class_name);?> ( <?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class->start_time)).' - '.MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class->end_time));?>)</option>

						<?php

						}

						?>

					</select>

				</div>

			</div>

		</div>	

        <script type="text/javascript" src="<?php echo GMS_PLUGIN_URL. '/lib/jsqrscanner/jsqrscanner.nocache.js'; ?>"></script>
      
		<div class="panel-heading">

			<h4 class="panel-title"><?php _e('Scan QR Code To Take Attendance','gym_mgt');?> 			

		</div>	
	<div class="col-md-12">
		<div class="qrscanner" id="scanner">
		<hr>
		<!-- SweetAlert2 -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
		<script type="text/javascript">
		function onQRCodeScanned(scannedText)
		{
		    var qr_name = scannedText.substr(0, 6);
		    var member_id = scannedText.substr(7, 8);
		    if (qr_name == 'WP_GYM')
            {
    			var qr_class_id = $(".qr_class_id").val();
    			var qr_date = $(".qr_date").val();
    			var attendance_url=member_id+'_'+qr_class_id+'_'+qr_date;
    			var serch = attendance_url.search("data");
    			if(qr_class_id != " ")
    			{	
    				if(qr_date != " ")
    				{	
    					var myString = attendance_url.substr(attendance_url.indexOf("=") + 1)
    					$.ajax({
    					type: "POST",  
    					url: "<?php echo admin_url('admin-ajax.php'); ?>",
    					data: { action: 'MJ_gmgt_qr_code_take_attendance',attendance_url:myString},
    					dataType: "json",
    					complete: function (e)
    					{
    						if(e.responseText == '1')
    						{
    						  swal("<?php esc_html_e('Success!','gym_mgt'); ?>", "<?php esc_html_e('Attendance successfully','gym_mgt'); ?>", "success");
    						}
    						else if(e.responseText == '2')
    						{
    						  swal("<?php esc_html_e('Warning!','gym_mgt'); ?>", "<?php esc_html_e('Your membership has expired!','gym_mgt'); ?>", "warning");
    						}
    						else if(e.responseText == '3')
    						{
    							swal("<?php esc_html_e('Oops!','gym_mgt'); ?>", "<?php esc_html_e('Something went wrong, you should choose again!','gym_mgt'); ?>", "error");
    
    						}
    						else
    						{
    						  swal("<?php esc_html_e('Oops!','gym_mgt'); ?>", "<?php esc_html_e('Something went wrong, you should choose again!','gym_mgt'); ?>", "error");
    						}
    
    					}
    					});						 
    				}
    				else
    				{
    
    					swal("<?php esc_html_e('Warning!','gym_mgt'); ?>", "<?php esc_html_e('Please select date!','gym_mgt'); ?>", "warning");
    				}	
    			}
        		else
        		{
        
        			swal("<?php esc_html_e('Warning!','gym_mgt'); ?>", "<?php esc_html_e('Please select  class!','gym_mgt'); ?>", "warning");
        		}
			}
			else if(scannedText == 'Invalid constraint')
			{
			}
			else if (scannedText == 'Requested device not found')
			{
			}
			else
			{
			    swal("<?php esc_html_e('Oops!','gym_mgt'); ?>", "<?php esc_html_e('QR code does not match, you should choose again!','gym_mgt'); ?>", "error"); 
			}
        }
		//this function will be called when JsQRScanner is ready to use
		function JsQRScannerReady()
		{

			//create a new scanner passing to it a callback function that will be invoked when

			//the scanner succesfully scan a QR code

			var jbScanner = new JsQRScanner(onQRCodeScanned);

			//reduce the size of analyzed images to increase performance on mobile devices

			jbScanner.setSnapImageMaxSize(200);

			var scannerParentElement = document.getElementById("scanner");

			if(scannerParentElement)

			{

				//append the jbScanner to an existing DOM element

				jbScanner.appendTo(scannerParentElement);

			}        

		}
		</script>
		
	    </div>
	</div>
	</form>

</div>