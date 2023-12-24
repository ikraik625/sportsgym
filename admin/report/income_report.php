<?php 



	$active_tab = isset($_GET['tab'])?$_GET['tab1']:'report_graph';



?>



<script type="text/javascript">



	$(document).ready(function() 



	{



		"use strict";



		$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



		$('.sdate1').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



				maxDate : 0,



		}); 



		$('.edate1').datepicker({dateFormat: '<?php echo get_option('gmgt_datepicker_format');?>',



				maxDate : 0,



		}); 



	} );



</script>



<h3>



	<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs panel_tabs margin_left_1per" role="tablist">



        <li role="presentation" class="<?php echo $active_tab == 'report_graph' ? 'active' : ''; ?> menucss">



			<a href="?page=gmgt_report&tab=payment_report&tab1=report_graph">



				<?php echo esc_html__('Graph Report Yearly' , 'gym_mgt'); ?>



			</a>



        </li>



		<li role="presentation" class="<?php echo $active_tab == 'report_graph_monthly' ? 'active' : ''; ?> menucss">



			<a href="?page=gmgt_report&tab=payment_report&tab1=report_graph_monthly">



				<?php echo esc_html__('Graph Report Monthly' , 'gym_mgt'); ?>



			</a>



		</li>



        <li role="presentation" class="<?php echo $active_tab == 'data_report' ? 'active' : ''; ?> menucss">



			<a href="?page=gmgt_report&tab=payment_report&tab1=data_report">



				<?php echo esc_html__('Income Datatable', 'gym_mgt'); ?>



			</a>



        </li>



		<li role="presentation" class="<?php echo $active_tab == 'data_report_1' ? 'active' : ''; ?> menucss">



			<a href="?page=gmgt_report&tab=payment_report&tab1=data_report_1">



				<?php echo esc_html__('Expense Datatable', 'gym_mgt'); ?>



			</a>



        </li>



    </ul>	



</h3>



<?php

$obj_payment=new MJ_gmgt_payment;

if($active_tab == 'report_graph')

{

	?>

	<form method="post" id="attendance_list"  class="attendance_list">  

		<div class="form-body user_form margin_top_15px">

			<div class="row">

				<div class="col-md-3 mb-3 input">

					<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Year','gym_mgt');?><span class="require-field">*</span></label>

					<select name="year" class="line_height_30px form-control validate[required]">

						<!-- <option ><?php esc_attr_e('Selecte year','gym_mgt');?></option> -->

							<?php

							$current_year = date('Y');

							$min_year = $current_year - 10;

							

							for($i = $min_year; $i <= $current_year; $i++){

								$year_array[$i] = $i;

								$selected = ($current_year == $i ? ' selected' : '');

								echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n";

							}

							?>

					</select>       

				</div>



				<div class="col-md-3 mb-2">

					<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

				</div>

			</div>

		</div>

	</form>

	<?php

	$invoice_data= $obj_payment->MJ_gmgt_get_all_income_expense();



	foreach($invoice_data as $retrieved_data)
	{
		$datetime = DateTime::createFromFormat('Y-m-d',$retrieved_data->invoice_date);

		$year_new = $datetime->format('Y');

		if(isset($_REQUEST['view_attendance']))
		{
			$year = $_REQUEST['year'];
		}
		else
		{
			$year =isset($year_new)?$year_new:date('Y');
		}
	}

	$current_year = Date("Y");

	$month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);

	$result = array();

	$dataPoints_2 = array();

	array_push($dataPoints_2, array(esc_html__('Month','gym_mgt'),esc_html__('Income','gym_mgt'),esc_html__('Expense','gym_mgt')));

	$dataPoints_1 = array();

	$expense_array = array();

	$currency_symbol = MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));

	

	foreach($month as $key=>$value)

	{

		global $wpdb;

		$table_name = $wpdb->prefix."gmgt_income_expense";



		$q = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $year AND MONTH(invoice_date) = $key and invoice_type='income'";



		$q1 = "SELECT * FROM $table_name WHERE YEAR(invoice_date) = $year AND MONTH(invoice_date) = $key and invoice_type='expense'";



		$result=$wpdb->get_results($q);

		$result1=$wpdb->get_results($q1);

		$expense_yearly_amount = 0;

		foreach($result1 as $expense_entry)

		{

		

		$all_entry=json_decode($expense_entry->entry);

		$amount=0;

		foreach($all_entry as $entry)

		{

			$amount+=$entry->amount;

		}



		$expense_yearly_amount += $amount;

		

		}

		if($expense_yearly_amount == 0)

		{

			$expense_amount = null;

		}

		else

		{

			$expense_amount = "$expense_yearly_amount";

		}

		$expense_array[] = $expense_amount;

		$income_amount = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $year";

		$result_income=$wpdb->get_results($income_amount);



		array_push($dataPoints_2, array($value,$result[0]->amount,$expense_amount));

		

	}



	$new_array = json_encode($dataPoints_2);



	if(!empty($result_income))

	{

		$new_currency_symbol = html_entity_decode($currency_symbol);

	

		?>

		

		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		<script type="text/javascript">

			google.charts.load('current', {'packages':['bar']});

			google.charts.setOnLoadCallback(drawChart);



			function drawChart() {

				var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);



				var options = {

				

					bars: 'vertical', // Required for Material Bar Charts.

					colors: ['#104B73', '#FF9054'],

					

				};

			

				var chart = new google.charts.Bar(document.getElementById('barchart_material'));



				chart.draw(data, google.charts.Bar.convertOptions(options));

			}

		</script>

		<div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>

		<?php

	}

	else

	{

		?>

		<div class="calendar-event-new"> 

			<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

		</div>

		<?php	

	}

}

if($active_tab == 'report_graph_monthly')

{

	?>

	<form method="post" id="attendance_list"  class="attendance_list">  

		<div class="form-body user_form margin_top_15px">

			<div class="row">

				<div class="col-md-3 mb-3 input">

					<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Month','gym_mgt');?><span class="require-field">*</span></label>

					<select id="month" name="month" class="line_height_30px form-control class_id_exam validate[required]">

						<!-- <option ><?php esc_attr_e('Selecte Month','gym_mgt');?></option> -->

						<?php

						$month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);

						foreach($month as $key=>$value)

						{

							$selected = (date('m') == $key ? ' selected' : '');

							echo '<option value="'.$key.'"'.$selected.'>'. $value.'</option>'."\n";

						}

							?>

					</select>       

				</div>



				<div class="col-md-3 mb-2">

					<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

				</div>

			</div>

		</div>

	</form>

	<?php



	

	$invoice_data= $obj_payment->MJ_gmgt_get_all_income_expense();



	foreach($invoice_data as $retrieved_data)

	{



		$datetime = DateTime::createFromFormat('Y-m-d',$retrieved_data->invoice_date);

		$year_new = $datetime->format('Y');

		$year =isset($year_new)?$year_new:date('Y');

	}

	

	$current_year = Date("Y");

	$day =array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

	// $day =array('1'=>esc_html__('Jan','gym_mgt'),'2'=>esc_html__('Feb','gym_mgt'),'3'=>esc_html__('Mar','gym_mgt'),'4'=>esc_html__('Apr','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('Jun','gym_mgt'),'7'=>esc_html__('Jul','gym_mgt'),'8'=>esc_html__('Aug','gym_mgt'),'9'=>esc_html__('Sep','gym_mgt'),'10'=>esc_html__('Oct','gym_mgt'),'11'=>esc_html__('Nov','gym_mgt'),'12'=>esc_html__('Dec','gym_mgt'),);

	$result = array();

	$dataPoints_2 = array();

	array_push($dataPoints_2, array(esc_html__('Month','gym_mgt'),esc_html__('Income','gym_mgt'),esc_html__('Expense','gym_mgt')));

	$dataPoints_1 = array();

	$expense_array = array();

	$currency_symbol = MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));



	if(isset($_REQUEST['view_attendance']))

	{

		$month = $_REQUEST['month'];

	}

	else

	{

		$month =Date('m');

	}

	foreach($day as $value)

	{

		

		

		global $wpdb;	

		$table_name = $wpdb->prefix."gmgt_income_expense";



		$q = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $current_year  AND MONTH(invoice_date) = $month  AND DAY(invoice_date) = $value and invoice_type='income'";

		// $q = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $year AND MONTH(invoice_date) = $value and invoice_type='income'";



		$q1 = "SELECT * FROM $table_name WHERE YEAR(invoice_date) = $current_year AND MONTH(invoice_date) = $month  AND DAY(invoice_date) = $value and invoice_type='expense'";



		$result=$wpdb->get_results($q);

		$result1=$wpdb->get_results($q1);

		$expense_yearly_amount = 0;

		foreach($result1 as $expense_entry)

		{

		

			$all_entry=json_decode($expense_entry->entry);

			$amount=0;

			foreach($all_entry as $entry)

			{

				$amount+=$entry->amount;

			}



			$expense_yearly_amount += $amount;

		

		}

		if($expense_yearly_amount == 0)

		{

			$expense_amount = null;

		}

		else

		{

			$expense_amount = "$expense_yearly_amount";

		}

		$expense_array[] = $expense_amount;

		$income_amount = "SELECT SUM(total_amount) as amount FROM $table_name WHERE YEAR(invoice_date) = $year";

		$result_income=$wpdb->get_results($income_amount);

		

		array_push($dataPoints_2, array($value,$result[0]->amount,$expense_amount));

		

	}



	$new_array = json_encode($dataPoints_2);

	

	if(!empty($result_income))

	{

		$new_currency_symbol = html_entity_decode($currency_symbol);

	

		?>

		

		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		<script type="text/javascript">

			google.charts.load('current', {'packages':['bar']});

			google.charts.setOnLoadCallback(drawChart);



			function drawChart() {

				var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);



				var options = {

				

					bars: 'vertical', // Required for Material Bar Charts.

					colors: ['#104B73', '#FF9054'],

					

				};

			

				var chart = new google.charts.Bar(document.getElementById('barchart_material'));



				chart.draw(data, google.charts.Bar.convertOptions(options));

			}

		</script>

		<div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>

		<?php

	}

	else

	{

		?>

		<div class="calendar-event-new"> 

			<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >

		</div>

		<?php	

	}

}



if($active_tab == 'data_report')

{



	if(isset($_REQUEST['view_attendance']))

    {

		$date_type = $_POST['date_type'];



		if($date_type=="period")

		{

			$start_date = $_REQUEST['start_date'];

			$end_date = $_REQUEST['end_date'];

			

		}

		else

		{

			$result =  mj_gmgt_all_date_type_value($date_type);

	

			$response =  json_decode($result);

			$start_date = $response[0];

			$end_date = $response[1];



		}



	}

    else

	{



		$start_date = date('Y-m-d',strtotime('first day of this month'));



        $end_date = date('Y-m-d',strtotime('last day of this month'));



	}



	$result_merge_array=MJ_gmgt_get_all_income_report_beetween_satrt_date_to_enddate($start_date,$end_date);



	?>



	<div class="panel-body padding_0 mt-3">



		<form method="post" id="attendance_list" class="attendance_list">  

			<div class="form-body user_form margin_top_15px">

				<div class="row">

					<div class="col-md-3 mb-3 input">

						<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

							<select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

								<!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->

								<option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

								<option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

								<option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

								<option value="this_month" 	selected><?php esc_attr_e('This Month','gym_mgt');?></option>

								<option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

								<option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

								<option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

								<option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

								<option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

								<option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

								<option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

							</select>

					</div>



					<div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>



					<div class="col-md-3 mb-2">

						<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

					</div>

				</div>

			</div>

		</form>



	</div>



	<div class="panel-body padding_0 mt-3"><!--PANEL BODY DIV START-->



		<?php



		if(!empty($result_merge_array))



		{ 



			?>



			<script type="text/javascript">



				$(document).ready(function() 



				{



					"use strict";



					jQuery('#tblexpence').DataTable({



						// "responsive": true,



						"order": [[ 2, "Desc" ]],



						dom: 'lifrtp',



						//   buttons: [



						//     {



						// 	extend: '<?php echo esc_html_e('print', 'gym_mgt'); ?>',



						//     title: '<?php echo esc_html_e('Income List', 'gym_mgt'); ?>',



						//     },



						// 	'pdf',



						//     'csv'				



						// 	], 



						"aoColumns":[



								{"bSortable": false},



								{"bSortable": true},



								{"bSortable": true},



								{"bSortable": true},



								{"bSortable": true}



							],



						language:<?php echo MJ_gmgt_datatable_multi_language();?>		   



					});



					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



				} );



			</script>







			<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



				<form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->



					<table id="tblexpence" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->



						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



							<tr>



								<th><?php esc_html_e('Photo','gym_mgt');?></th>



								<th><?php esc_html_e('Member Name','gym_mgt');?></th>



								<th><?php esc_html_e('Amount','gym_mgt');?></th>



								<th><?php esc_html_e('Date','gym_mgt');?></th>



								<th><?php esc_html_e('Payment Description','gym_mgt');?></th>



								



							</tr>



						</thead>

						<tbody>



						<?php 



							if(!empty($result_merge_array))



							{



								$i=0;



								foreach ($result_merge_array as $retrieved_data)



								{ 



									if($i == 10)



									{



										$i=0;



									}



									if($i == 0)



									{



										$color_class='smgt_class_color0';



									}



									elseif($i == 1)



									{



										$color_class='smgt_class_color1';



									}



									elseif($i == 2)



									{



										$color_class='smgt_class_color2';



									}



									elseif($i == 3)



									{



										$color_class='smgt_class_color3';



									}



									elseif($i == 4)



									{



										$color_class='smgt_class_color4';



									}



									elseif($i == 5)



									{



										$color_class='smgt_class_color5';



									}



									elseif($i == 6)



									{



										$color_class='smgt_class_color6';



									}



									elseif($i == 7)



									{



										$color_class='smgt_class_color7';



									}



									elseif($i == 8)



									{



										$color_class='smgt_class_color8';



									}



									elseif($i == 9)



									{



										$color_class='smgt_class_color9';



									}



									?>



									<tr>



										<td class="user_image width_50px profile_image_prescription padding_left_0">	



											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



											</p>



										</td>



										<td class="party_name">



											<?php



											$user=get_userdata($retrieved_data->member_id);



											$memberid=get_user_meta($retrieved_data->member_id,'member_id',true);



											// $display_label=$user->display_name;



											$display_label = MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->member_id));



											if($display_label)

											{

												echo esc_html($display_label);

											}

											else {

												echo "N/A";

											}



											?>



											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



										</td>



										<td class="income_amount">



											<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($retrieved_data->amount),2);?>



											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Amount','gym_mgt');?>" ></i>



										</td>



										<td class="status">



											<?php



											if(!empty($retrieved_data->paid_by_date))



											{



												echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->paid_by_date));



											}



											else {



												echo "N/A";



											}



											?>



											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>



										</td>



										<td class="party_name">



											<?php



											if(!empty($retrieved_data->payment_description))	



											{



												echo esc_html($retrieved_data->payment_description);



											}



											else 



											{



												echo "N/A";



											}



											?>



											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Description','gym_mgt');?>" ></i>



										</td>



									</tr>



									<?php



									$i++;



								}



							}



						?>



						</tbody>



					</table><!--EXPENSE LIST TABLE END-->



				</form><!--EXPENSE LIST FORM END-->



			</div><!--TABLE RESPONSIVE DIV END-->



			<?php



		}



		else



		{



			?>



			<div class="calendar-event-new"> 



				<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



			</div>



			<?php



		} ?>



	</div><!--PANEL BODY DIV END-->



	<?php    



}

if($active_tab == 'data_report_1')

{



	if(isset($_REQUEST['view_attendance']))

    {

		$date_type = $_POST['date_type'];



		if($date_type=="period")

		{

			$start_date = $_REQUEST['start_date'];

			$end_date = $_REQUEST['end_date'];

			

		}

		else

		{

			$result =  mj_gmgt_all_date_type_value($date_type);

	

			$response =  json_decode($result);

			$start_date = $response[0];

			$end_date = $response[1];



		}



	}

    else

	{



		$start_date = date('Y-m-d',strtotime('first day of this month'));



        $end_date = date('Y-m-d',strtotime('last day of this month'));



	}



	$expense_report_data=MJ_gmgt_get_all_expense_report_beetween_satrt_date_to_enddate($start_date,$end_date);



    $obj_payment= new MJ_gmgt_payment();



	?>



	<div class="panel-body padding_0 mt-3">



	    <form method="post" id="attendance_list" class="attendance_list">  

			<div class="form-body user_form margin_top_15px">

				<div class="row">

					<div class="col-md-3 mb-3 input">

						<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date','gym_mgt');?><span class="require-field">*</span></label>			

							<select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">

								<!-- <option value=""><?php esc_attr_e('Select','gym_mgt');?></option> -->

								<option value="today"><?php esc_attr_e('Today','gym_mgt');?></option>

								<option value="this_week"><?php esc_attr_e('This Week','gym_mgt');?></option>

								<option value="last_week"><?php esc_attr_e('Last Week','gym_mgt');?></option>

								<option value="this_month" 	selected><?php esc_attr_e('This Month','gym_mgt');?></option>

								<option value="last_month"><?php esc_attr_e('Last Month','gym_mgt');?></option>

								<option value="last_3_month"><?php esc_attr_e('Last 3 Months','gym_mgt');?></option>

								<option value="last_6_month"><?php esc_attr_e('Last 6 Months','gym_mgt');?></option>

								<option value="last_12_month"><?php esc_attr_e('Last 12 Months','gym_mgt');?></option>

								<option value="this_year"><?php esc_attr_e('This Year','gym_mgt');?></option>

								<option value="last_year"><?php esc_attr_e('Last Year','gym_mgt');?></option>

								<option value="period"><?php esc_attr_e('Period','gym_mgt');?></option>

							</select>

					</div>



					<div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>



					<div class="col-md-3 mb-2">

						<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','gym_mgt');?>"  class="btn btn-info save_btn"/>

					</div>

				</div>

			</div>

		</form>



	</div>



	



	<div class="panel-body padding_0 mt-3"><!--PANEL BODY DIV START-->



		<?php



		if(!empty($expense_report_data))



		{



			?>



			<script type="text/javascript">



				$(document).ready(function() 



				{



					"use strict";



					jQuery('#tblexpence').DataTable({



						// "responsive": true,



						"order": [[ 2, "Desc" ]],



						dom: 'lifrtp',



						// buttons: [



						// 	{



						// 	extend: '<?php echo esc_html_e('print', 'gym_mgt'); ?>',



						// 	title: '<?php echo esc_html_e('Expense List', 'gym_mgt'); ?>',



						// 	},



						// 	'pdf',



						// 	'csv'



						// 	], 



						"aoColumns":[



							{"bSortable": false},



							{"bSortable": true},



							{"bSortable": true},



							{"bSortable": true}



						],



						language:<?php echo MJ_gmgt_datatable_multi_language();?>		   



					});



					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



				} );



			</script>



			<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->



				<form name="wcwm_report" action="" method="post"><!--EXPENSE LIST FORM START-->



					<table id="tblexpence" class="display" cellspacing="0" width="100%"><!--EXPENSE LIST TABLE START-->



						<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

							<tr>



								<th><?php esc_html_e('Photo','gym_mgt');?></th>



								<th><?php esc_html_e('Supplier Name','gym_mgt');?></th>



								<th><?php esc_html_e('Amount','gym_mgt');?></th>



								<th><?php esc_html_e('Date','gym_mgt');?></th>



								



							</tr>



						</thead>



						<tbody>



							<?php



							if(!empty($expense_report_data))



							{		



								$i=0;			   



								foreach($expense_report_data as $retrieved_data)



								{ 



									$all_entry=json_decode($retrieved_data->entry);



									$total_amount=0;



									foreach($all_entry as $entry)



									{



										$total_amount+=$entry->amount;



									}







									if($i == 10)



									{



										$i=0;



									}



									if($i == 0)



									{



										$color_class='smgt_class_color0';



									}



									elseif($i == 1)



									{



										$color_class='smgt_class_color1';



									}



									elseif($i == 2)



									{



										$color_class='smgt_class_color2';



									}



									elseif($i == 3)



									{



										$color_class='smgt_class_color3';



									}



									elseif($i == 4)



									{



										$color_class='smgt_class_color4';



									}



									elseif($i == 5)



									{



										$color_class='smgt_class_color5';



									}



									elseif($i == 6)



									{



										$color_class='smgt_class_color6';



									}



									elseif($i == 7)



									{



										$color_class='smgt_class_color7';



									}



									elseif($i == 8)



									{



										$color_class='smgt_class_color8';



									}



									elseif($i == 9)



									{



										$color_class='smgt_class_color9';



									}



									?>



									<tr>



										<td class="user_image width_50px profile_image_prescription padding_left_0">	



											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	



												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



											</p>



										</td>



										<td class="party_name">



											<?php echo esc_html($retrieved_data->supplier_name);?>



											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Supplier Name','gym_mgt');?>" ></i>



										</td>



										<td class="income_amount">



											<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($total_amount),2);?>



											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Amount','gym_mgt');?>" ></i>



										</td>



										<td class="status">



											<?php echo MJ_gmgt_getdate_in_input_box(esc_html($retrieved_data->invoice_date));?>



											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date','gym_mgt');?>" ></i>



										</td>



									</tr>



									<?php



									$i++;



								}



							}



							?>



						</tbody>



					</table><!--EXPENSE LIST TABLE END-->



				</form><!--EXPENSE LIST FORM END-->



			</div><!--TABLE RESPONSIVE DIV END-->



			<?php



		}



		else



		{



			?>



			<div class="calendar-event-new"> 



				<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



			</div>



			<?php



		}



			?>



	</div><!--PANEL BODY DIV END-->



	<?php    



}

?>



 