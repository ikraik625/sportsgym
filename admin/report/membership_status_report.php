<?php 

$mebmer = get_users(array('role'=>'member'));

global $wpdb;

$table_name = $wpdb->prefix."gmgt_membershiptype";

$q="SELECT * From $table_name";

$member_ship_array = array();

$result=$wpdb->get_results($q);

$membership_status = array('Continue','Expired','Dropped');

$membership_status1 =  array(esc_html__('Continue','gym_mgt'),esc_html__('Expired','gym_mgt'),esc_html__('Dropped','gym_mgt'));

foreach($membership_status as $key=>$retrive)

{

	$member_ship_count =  count(get_users(array('role'=>'member','meta_key' => 'membership_status', 'meta_value' => $retrive)));

	$member_ship_array[] = array('member_ship_id'=> $membership_status1[$key],

								 'member_ship_count'=>	$member_ship_count

								);

}

$chart_array = array();

$chart_array[] = array(esc_html__('Membership','gym_mgt'),esc_html__('Number Of Member','gym_mgt'));	

foreach($member_ship_array as $r)

{

	$chart_array[]=array( $r['member_ship_id'],$r['member_ship_count']);

}

$options = Array(

				'title' => esc_html__('Membership by status','gym_mgt'),

				'colors' => array('#22BAA0','#F25656','#12AFCB')

				);

require_once GMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';

$GoogleCharts = new GoogleCharts;

$chart = $GoogleCharts->load( 'PieChart' , 'chart_div' )->get( $chart_array , $options );

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

<div id="chart_div" class="chart_div"></div>

<!-- Javascript --> 

<script type="text/javascript" src="https://www.google.com/jsapi"></script> 

<script type="text/javascript">

		<?php echo $chart;?>

</script>