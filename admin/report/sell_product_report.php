<?php

$active_tab = isset($_GET['tab'])?$_GET['tab1']:'report_graph';

?>

<h3>

	<ul id="myTab" class="sub_menu_css line case_nav nav nav-tabs panel_tabs margin_left_1per" role="tablist">

        <li role="presentation" class="<?php echo $active_tab == 'report_graph' ? 'active' : ''; ?> menucss">

			<a href="?page=gmgt_report&tab=sell_product_report&tab1=report_graph">

				<?php echo esc_html__('Sale Product Report Graph', 'gym_mgt'); ?>

			</a>

        </li>

        <li role="presentation" class="<?php echo $active_tab == 'data_report' ? 'active' : ''; ?> menucss">

			<a href="?page=gmgt_report&tab=sell_product_report&tab1=data_report">

				<?php echo esc_html__('Sale Product Report Datatable', 'gym_mgt'); ?>

			</a>

        </li>

    </ul>	

</h3>

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

<?php

if($active_tab == 'report_graph')

{   

$month =array('1'=>esc_html__('January','gym_mgt'),'2'=>esc_html__('February','gym_mgt'),'3'=>esc_html__('March','gym_mgt'),'4'=>esc_html__('April','gym_mgt'),'5'=>esc_html__('May','gym_mgt'),'6'=>esc_html__('June','gym_mgt'),'7'=>esc_html__('July','gym_mgt'),'8'=>esc_html__('August','gym_mgt'),'9'=>esc_html__('September','gym_mgt'),'10'=>esc_html__('October','gym_mgt'),'11'=>esc_html__('November','gym_mgt'),'12'=>esc_html__('December','gym_mgt'),);

$year =isset($_POST['year'])?$_POST['year']:date('Y');

global $wpdb;

$table_name = $wpdb->prefix."gmgt_store";

$q="SELECT * FROM ".$table_name." WHERE YEAR(sell_date) =".$year." ORDER BY sell_date ASC";

$result=$wpdb->get_results($q);

$month_wise_count=array();

foreach($result as $key=>$value)

{

	$total_quantity=0;

	$all_entry=json_decode($value->entry);

	foreach($all_entry as $entry)

	{

		$total_quantity+=$entry->quentity;

	}	

	$sell_date = date_parse_from_format("Y-m-d",$value->sell_date);

	$month_wise_count[]=array('sell_date'=>$sell_date["month"],'quentity'=>$total_quantity);

}

$sumArray = array(); 

foreach ($month_wise_count as $value1) 

{ 

	$value2=(object)$value1;

	if(isset($sumArray[$value2->sell_date]))

	{

		$sumArray[$value2->sell_date] = $sumArray[$value2->sell_date] + (int)$value2->quentity;

	}

	else

	{

		$sumArray[$value2->sell_date] = (int)$value2->quentity; 

	}		

}

$chart_array = array();

//$chart_array[] = array('Month','Sale Product');

$chart_array[] = array(esc_html__('Month','gym_mgt'),esc_html__('Sale Product','gym_mgt'));

foreach($sumArray as $month_value=>$quentity)

{

	$chart_array[]=array( $month[$month_value],(int)$quentity);

}

$options = Array(

			'title' => esc_html__('Sale Product Report By Month','gym_mgt'),

			'titleTextStyle' => Array('color' => '#66707e'),

			'legend' =>Array('position' => 'right',

						'textStyle'=> Array('color' => '#66707e')),

			'hAxis' => Array(

				'title' => esc_html__('Month','gym_mgt'),

				'format' => '#',

				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

				'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

				'maxAlternation' => 2				

				),

			'vAxis' => Array(

				'title' => esc_html__('Sale Product','gym_mgt'),

				 'minValue' => 0,

				'maxValue' => 6,

				 'format' => '#',

				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif'),

				'textStyle'=> Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'sans-serif')

				),

 		'colors' => array('#ba170b')

			);

require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';

$GoogleCharts = new GoogleCharts;

$chart = $GoogleCharts->load( 'column' , 'chart_div' )->get( $chart_array , $options );

?>

<script type="text/javascript">

$(document).ready(function() 

{

	"use strict";

	$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);

	$('.sdate').datepicker({dateFormat: "yy-mm-dd"}); 

	$('.edate').datepicker({dateFormat: "yy-mm-dd"}); 

} );

</script>

<div id="chart_div" class="chart_div">

<?php 

if(empty($result)) 

{?>

    <div class="clear col-md-12"><h3><?php esc_html_e("There is not enough data to generate report.",'gym_mgt');?> </h3></div>

<?php 

} ?>

</div>

<div id="chart_div" class="chart_div"></div>

<!-- Javascript --> 

<script type="text/javascript" src="https://www.google.com/jsapi"></script> 

<script type="text/javascript">

	<?php 

	if(!empty($result))

	{

		echo $chart;

	}

	?>

</script>

<?php

}

if($active_tab == 'data_report')

{ 

$obj_class=new MJ_gmgt_classschedule;

$obj_product=new MJ_gmgt_product;

$obj_store=new MJ_gmgt_store;



	if(isset($_REQUEST['sell_report_datatable']))

    {

		$start_date =MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['sdate']));

		$end_date = MJ_gmgt_get_format_for_db(esc_attr($_REQUEST['edate']));

	}

    else

	{

		$start_date = date('Y-m-d',strtotime('first day of this month'));

        $end_date = date('Y-m-d',strtotime('last day of this month'));

	}

	$storedata=MJ_gmgt_get_all_sell_report_beetween_start_date_to_enddate($start_date,$end_date);



?>

<div class="panel-body padding_0 mt-3">

	<form method="post">  

		<div class="form-body user_form">

			<div class="row"> 

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ipad_res">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input type="text"  class="form-control sdate1" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo esc_attr($_REQUEST['sdate']);else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>

							<label for="exam_id"><?php esc_html_e('Start Date','gym_mgt');?></label>	

						</div>

					</div>

				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

					<div class="form-group input">

						<div class="col-md-12 form-control">

							<input type="text"  class="form-control edate1"  name="edate" value="<?php if(isset($_REQUEST['edate'])) echo esc_attr($_REQUEST['edate']);else echo esc_attr(MJ_gmgt_getdate_in_input_box(date('Y-m-d')));?>" readonly>

							<label for="exam_id"><?php esc_html_e('End Date','gym_mgt');?></label>

						</div>

					</div>

				</div>

			</div><!--Row Div End--> 

		</div><!-- user_form End--> 

		<!------------   save btn  -------------->  

		<div class="form-body user_form"> <!-- user_form Strat-->   

			<div class="row"><!--Row Div Strat--> 

				<div class="col-md-6 col-sm-6 col-xs-12"><!--save btn--> 

					<input type="submit" name="sell_report_datatable" Value="<?php esc_html_e('Go','gym_mgt');?>"  class="btn save_btn"/>

				</div>

			</div><!--Row Div End--> 

		</div><!-- user_form End--> 

	</form>

</div>

	<div class="panel-body padding_0 mt-3"><!--PANEL BODY DIV START-->

		<?php

		if(!empty($storedata))

		{ 

			?>

			<script type="text/javascript">

				$(document).ready(function() 

				{

					"use strict";

					$('#selling_list').DataTable({

					// "responsive": true,

					"order": [[ 1, "asc" ]],

					dom: 'lifrtp',

					// buttons: [

					// {

					// extend: '<?php esc_html_e( 'print', 'gym_mgt' ) ;?>',

					// title: '<?php esc_html_e( 'Sales Payment List', 'gym_mgt' ) ;?>',

					// },

					// 'pdfHtml5'										

					// ],

					"aoColumns":[

							{"bSortable": false},

							{"bSortable": true},

							{"bSortable": true},

							{"bSortable": true},

							{"bSortable": true},

							{"bSortable": true},

							{"bSortable": true},

							{"bSortable": true},

						],

						language:<?php echo MJ_gmgt_datatable_multi_language();?>		  

					});

					$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");

				} );

			</script>

			<form name="wcwm_report" action="" method="post"><!--SELL Product LIST FORM START-->	

				<div class="panel-body"><!--PANEL BODY DIV START-->

					<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->

						<table id="selling_list" class="display" cellspacing="0" width="100%"><!--SELL Product LIST TABLE START-->

							<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">

								<tr>

									<th><?php esc_html_e('Photo','gym_mgt');?></th>

									<th><?php esc_html_e('Invoice No.','gym_mgt');?></th>

									<th><?php esc_html_e('Member Name','gym_mgt');?></th>

									<th><?php esc_html_e('Product Name=>Product Quantity','gym_mgt');?></th>

									<th><?php esc_html_e('Total Amount','gym_mgt');?></th>

									<th><?php esc_html_e('Paid Amount','gym_mgt');?></th>

									<th><?php esc_html_e('Due Amount','gym_mgt');?></th>

									<th><?php esc_html_e('Payment Status','gym_mgt');?></th>

								</tr>

							</thead>

							<tbody>

								<?php 		

								//GET SELL PRODUCT DATA


							if(!empty($storedata))

							{

								$i=0;

								foreach ($storedata as $retrieved_data)

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

								

									if(empty($retrieved_data->invoice_no))

									{

										$obj_product=new MJ_gmgt_product;

										$product = $obj_product->MJ_gmgt_get_single_product($retrieved_data->product_id);

										$price=$product->price;	

										$quentity=$retrieved_data->quentity;

										$invoice_no='-';					

										$total_amount=$price*$quentity;

										$paid_amount=$price*$quentity;

										$due_amount='0';

									}

									else

									{

										$invoice_no=$retrieved_data->invoice_no;

										$total_amount=$retrieved_data->total_amount;

										$paid_amount=$retrieved_data->paid_amount;

										$due_amount=$total_amount-$paid_amount;

									}

									?>

									<tr>

										<td class="user_image width_50px profile_image_prescription padding_left_0">	

											<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	

												<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">

											</p>

										</td>

										<td class="productquentity">

											<?php echo esc_html($invoice_no); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Invoice No.','gym_mgt');?>" ></i>

										</td>	

										<td class="membername">

											<?php $userdata=get_userdata(($retrieved_data->member_id)); echo esc_html(MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->member_id)));?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>

										</td>

										<td class="productname">

											<?php 

												$entry_valuea=json_decode($retrieved_data->entry);

												

												if(!empty($entry_valuea))

												{

													foreach($entry_valuea as $entry_valueb)

													{

														$product = $obj_product->MJ_gmgt_get_single_product($entry_valueb->entry);

														if(!empty($product))

														{

														$product_name=$product->product_name;

														$quentity=$entry_valueb->quentity;

														$product_quantity=$product_name . " => " . $quentity . ",";

														echo rtrim(esc_html($product_quantity),',');

														}

														else {

															echo "N/A";

														}

														?>

														<br>

													<?php

													}

												}

												else

												{

													$obj_product=new MJ_gmgt_product;

													$product = $obj_product->MJ_gmgt_get_single_product($retrieved_data->product_id);

													$product_name=$product->product_name;

													$quentity=$retrieved_data->quentity;	

													echo  esc_html($product_name). " => " .esc_html($quentity);

												}

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Product Name=>Product Quantity','gym_mgt');?>" ></i>

										</td>		

										<td class="productquentity">

											<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($total_amount),2); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Total Amount','gym_mgt');?>" ></i>

										</td>

										<td class="productquentity">

											<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($paid_amount),2); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Paid Amount','gym_mgt');?>" ></i>

										</td>

										<td class="totalamount">

											<?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )); ?> <?php echo number_format(esc_html($due_amount),2); ?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Due Amount','gym_mgt');?>" ></i>

										</td>

										<td class="paymentdate">

											<?php

											if($retrieved_data->payment_status == 'Unpaid')

											{

												echo "<span class='Unpaid_status_color'>";

											}

											elseif($retrieved_data->payment_status == 'Partially Paid')

											{

												echo "<span class='paid_status_color'>";

											}

											else

											{

												echo "<span class='fullpaid_status_color'>";

											}															

											echo  esc_html__("$retrieved_data->payment_status","gym_mgt");

											echo "</span>";

											?>

											<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Payment Status','gym_mgt');?>" ></i>

										</td>

									</tr>

									<?php  

									$i++;

								}

							}

							?>

							</tbody>

						</table><!--SELL Product LIST TABLE END-->	

					</div><!--TABLE RESPONSIVE DIV END-->	

				</div>	<!--PANEL BODY END-->			   

			</form><!--SELL Product LIST FORM END-->

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

	</div>

	<?php							

}

?>