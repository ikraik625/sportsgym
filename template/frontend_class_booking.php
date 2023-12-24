<?php

$obj_membership=new MJ_gmgt_membership;

if(isset($_REQUEST['message']))

{

	$message =$_REQUEST['message'];

	if($message == 1)

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Member Limit Is Full.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			</button>

		</div>

			<?php

	}

	elseif($message == 2)

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Class book successfully.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

			<?php 

		

	}

	elseif($message == 3) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Class Limit is over.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

	<?php

			

	}

	elseif($message == 4) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Already Book Class In This Date And Time.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

	<?php

	}

	elseif($message == 5) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Your Booking day is not between membership period.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

	<?php

			

	}

	elseif($message == 6) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("This class is not your current membership.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

	<?php

			

	}

	elseif($message == 7) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("This class is not Assigned to you.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

	<?php

			

	}

	elseif($message == 8) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Your Membership is expire.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

	<?php		

	}

	elseif($message == 9) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Class booked Successfully.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

	<?php		

	}

	elseif($message == 10) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Demo Class booked Successfully.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

	<?php		

	}

}

if(isset($_REQUEST['result']) && isset($_REQUEST['action']))

{

	$message =$_REQUEST['result'];

	if($message == 1)

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Member Limit Is Full.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

			<?php

	}

	elseif($message == 2)

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Class book successfully.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			

			</button>

		</div>

		<?php 

		

	}

	elseif($message == 3) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Class Limit is over.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></p>

			</button>

		</div>

		<?php

			

	}

	elseif($message == 4) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Already Book Class In This Date And Time.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></button></p>

		</div>

		<?php

			

	}

	elseif($message == 5) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Your Booking day is not between membership period.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></button></p>

		</div>

		<?php

			

	}

	elseif($message == 6) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("This class is not your current membership.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></button></p>

		</div>

		<?php

			

	}

	elseif($message == 7) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("This class is not Assigned to you.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></button></p>

		</div>

		<?php

			

	}

	elseif($message == 8) 

	{

		?>

		<div id="message" class="alert_msg message_div alert alert-success alert-dismissible " role="alert">

			<p><?php esc_html_e("Your Membership is expire.",'gym_mgt');?> <button type="button" class="btn-default message_destroy notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span></button></p>

		</div>

		<?php

			

	}

}



?>

<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery_3.6.0.js';?>">

</script>

<script type="text/javascript" src="<?php echo GMS_PLUGIN_URL.'/assets/js/jquery-ui-1.12.1.min.js';?>">

</script>

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/jquery-ui.css';?>" >

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/custom.css'; ?>">

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/frontend_calender.css'; ?>">

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/fullcalendar.css'; ?>">

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/gymmgt_min.css'; ?>">

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/css/validationEngine_jquery.css'; ?>">

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/moment_min.js'; ?>"></script>

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/fullcalendar_min.js'; ?>"></script>

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/popper.min.js'; ?>"></script>

<!-------------------- METERIAL DESIGN AND JS ------------------>

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/material/bootstrap-inputs.css'; ?>">

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/material/material.min.js'; ?>"></script>

<!-------------------- METERIAL DESIGN AND JS END ------------------>

<?php

if (is_rtl())

{

?>

	<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/custom_rtl.css'; ?>">

<?php		

}

?>



<?php /*--------Full calendar multilanguage---------*/

	$lancode=get_locale();

	$code=substr($lancode,0,2);

?>

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/calendar-lang/'.$code.'.js'; ?>"></script>

<?php

	//START GET CLASS DATA CODE//

	$obj_class=new MJ_gmgt_classschedule;

	

	$class_data_all=array();

	$cal_array=array();

	if(isset($_POST['guset_book_front_filter']) )

	{

		if((!empty($_POST['membership_id'])) && empty($_POST['staff_id']))

		{

			$class_data_all=$obj_class->MJ_gmgt_get_all_classes_by_membership_frontend($_POST['membership_id']);

			

		}

		elseif((!empty($_POST['staff_id'])) && empty($_POST['membership_id']))

		{

			$class_data_all=$obj_class->MJ_gmgt_get_all_classes_by_staffmember_frontend($_POST['staff_id']);

			

		}

		elseif(!empty($_POST['membership_id']) && !empty($_POST['staff_id']))

		{

			$class_data_all=$obj_class->MJ_gmgt_get_all_classes_by_membership_and_satff_fronend($_POST['membership_id'],$_POST['staff_id']);

			

		}

		else

		{

			$class_data_all=$obj_class->MJ_gmgt_get_all_classes_frontend(); 

		}

	}

	else

	{

		$class_data_all=$obj_class->MJ_gmgt_get_all_classes_frontend(); 

	}

	if(!empty($class_data_all))

	{

		foreach ($class_data_all as $classdatas)			

		{

			

			$user_data= get_userdata($classdatas->staff_id);

			$staff_member_name=$user_data->display_name;

			$date_from = date('Y-m-d');

			if($date_from == "0000-00-00")

			{

				$date_from = date('Y-m-d');

				$date_from = strtotime($date_from);

			}	

			else

			{

				$date_from = date('Y-m-d');

				$date_from = strtotime($date_from);

			}				

			$date_check = $classdatas->end_date; 

			$member_limit = $classdatas->member_limit; 

			if($date_check == "0000-00-00")

			{

				$date_to = 2050-12-31;

				$date_to = strtotime($date_to);

			}	

			else

			{

				$date_to = $classdatas->end_date; 

				$date_to = strtotime($date_to);

			}

			

			$a=1;

			$i=1;

			$membership_id = get_membership_id_by_classid($classdatas->class_id);

			$result=array();

			$get_membership_name=array();

			$btn_submit=array();

			$bookedmembership_id=0;

			if(!empty($membership_id))

			{

				foreach($membership_id as $membership_id1)

				{

					$memberhip_approved=$obj_membership->MJ_gmgt_get_member_own_membership($membership_id1->membership_id);

					

					$gmgt_membership_book_approve=array();

					foreach($memberhip_approved as $memberhip_approved_option)

					{

						$gmgt_membership_book_approve[]=$memberhip_approved_option->gmgt_membership_class_book_approve;

					}

				

					$membership_price_symbol= MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));$membership_price=MJ_gmgt_get_membership_price($membership_id1->membership_id);

					

					$membership=$obj_membership->MJ_gmgt_get_single_membership($membership_id1->membership_id);

					if(!empty($membership->membership_length_id))

					{

						$validity=$membership->membership_length_id;

					}

					if (in_array("yes", $gmgt_membership_book_approve))

					{

						$get_membership_name[]='<div class="membership_name_front mb_10 padding_2 height_31"> <b>'.$a.'</b> .'.MJ_gmgt_get_membership_name_a($membership_id1->membership_id)." ".'('.$validity." ".esc_html__('Days','gym_mgt').' )<br></div>';

						$btn_submit[]='<div class="submit mb_10" id="buy_membership_class_div">

						<input type="submit" name="buy_membership" id="buy_membership_class" class="sumit save_btn min_width_130 buy_membership_'.$i.'" value="'.$membership_price_symbol."".$membership_price." ".esc_html__('Buy Now','gym_mgt').'" attr_="'.$membership_id1->membership_id.'" ids="'.$i.'"/>

						</div>';

						$a++; 

					}

					else

					{

						$get_membership_name[]="";

						$btn_submit[]="";

					}

					$g=$i;

					$bookedmembership_id=$membership_id1->membership_id;

					

					$i++;

				}

			}

			$new_time = DateTime::createFromFormat('h:i A', $classdatas->start_time);

			$startTime_24 = $new_time->format('H:i:s');

			$new_time_end = DateTime::createFromFormat('h:i A', $classdatas->end_time);

			$endTime_24 = $new_time_end->format('H:i:s');

			for ($i=$date_from; $i<=$date_to; $i+=86400)

			{  

				$date1=date("Y-m-d", $i);

				$day = date("l", strtotime($date1));

				$day_array=json_decode($classdatas->day);

				$class_id=$classdatas->class_id;

				$booked_class_data=$obj_class->MJ_gmgt_get_book_class_bydate($class_id,$date1); 

				$remaning_memmber= $member_limit-$booked_class_data;

				

				if (in_array($day, $day_array))

				{

					$cal_array [] = array (

					'type' =>  'class',

					'class_id' => $classdatas->class_id,

					'day' => $day,

					'title' => $classdatas->class_name,

					'trainer' => $staff_member_name,

					'start' => $date1."T".$startTime_24,

					'end' => $date1."T".$endTime_24,

					'color' => $classdatas->color,

					'Member_limit' => $member_limit,

					'remaning_memmber' => $remaning_memmber,

					'class_date' => $date1,

					'membership_name' => $get_membership_name,

					'membership_id' => $bookedmembership_id,

					'btn_submit' => $btn_submit,

					);

				}

			}

		} 

	 }

   	//END START GET CLASS DATA CODE //

?>

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap-multiselect.css'; ?>">	

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/bootstrap_min.css'; ?>">	

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap-multiselect.js'; ?>"></script>

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/bootstrap_min.js'; ?>"></script>



<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/new_style.css'; ?>">

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/responsive_new_design.css'; ?>">

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/material/bootstrap-inputs.css'; ?>">

<link rel="stylesheet"	href="<?php echo GMS_PLUGIN_URL.'/assets/css/popping_font.css'; ?>">

<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/assets/js/material/material.min.js'; ?>"></script>

<script type="text/javascript">

	//var $ = jQuery.noConflict();

	var calendar_laungage ="<?php echo MJ_gmgt_get_current_lan_code();?>";

    document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

			  headerToolbar: {

		        left: 'prev,today next',

		        center: 'title',

		        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'

		      },

			  locale: calendar_laungage,

				editable: false,

			slotEventOverlap: false,

			

			dayMaxEventRows: true,

			eventTimeFormat: { // like '14:30:00'

		   		hour: 'numeric',

			   	minute: '2-digit',

			  	meridiem: 'short'

		  	},

			 // allow "more" link when too many events

			events: <?php echo json_encode($cal_array);?>,

			forceEventDuration : true,

			//start add class in pop up//

	        eventClick: function(event, jsEvent, view) 

	        {

				//console.log(event);

	        	"use strict";

				<?php $dformate=get_option('gmgt_datepicker_format'); ?>

				var dateformate_value='<?php echo $dformate;?>';	

				if(dateformate_value == 'yy-mm-dd')

				{	

				  var dateformate='YYYY-MM-DD h:mm A';

				}

				if(dateformate_value == 'yy/mm/dd')

				{	

				  var dateformate='YYYY/MM/DD h:mm A';	

				}

				if(dateformate_value == 'dd-mm-yy')

				{	

				  var dateformate='DD-MM-YYYY h:mm A';

				}

				if(dateformate_value == 'mm-dd-yy')

				{	

				  var dateformate='MM-DD-YYYY h:mm A';

				}

				if(dateformate_value == 'mm/dd/yy')

				{	

				  var dateformate='MM/DD/YYYY h:mm A';	

				}

				jQuery("#eventContent #class_name").html(event.event._def.title);

				jQuery("#eventContent #startTime").html(moment(event.event.start).format(dateformate));

				jQuery("#eventContent #endTime").html(moment(event.event.end).format(dateformate)); 

				jQuery("#eventContent #staff_member_name").html(event.event._def.extendedProps.trainer);

				jQuery("#eventContent #membership_name").html(event.event._def.extendedProps.membership_name);

				jQuery("#eventContent #Member_limit").html(event.event._def.extendedProps.Member_limit);

				jQuery("#eventContent #btn_submit").html(event.event._def.extendedProps.btn_submit);

				jQuery("#eventContent #Remaining_Member_limit ").html(event.event._def.extendedProps.remaning_memmber);

				jQuery("#eventContent #class_date_id ").html(event.event._def.extendedProps.class_date);

				jQuery("#class_name_1").val(event.event._def.title);

				jQuery("#class_name_2").val(event.event._def.title);

				jQuery("#class_name_1_guest").val(event.event._def.title);

				jQuery("#startTime_1").val(moment(event.event.start).format(dateformate));

				jQuery("#startTime_2").val(moment(event.event.start).format(dateformate));

				jQuery("#startTime_1_guest").val(moment(event.event.start).format(dateformate));

				jQuery("#endTime_1").val(moment(event.event.end).format(dateformate));

				jQuery("#endTime_2").val(moment(event.event.end).format(dateformate));

				jQuery("#endTime_1_guest").val(moment(event.event.end).format(dateformate));

				jQuery("#staff_member_name_1").val(event.event._def.extendedProps.trainer);

				jQuery("#staff_member_name_1_guest").val(event.event._def.extendedProps.trainer);

				jQuery("#Member_limit_1").val(event.event._def.extendedProps.Member_limit);

				jQuery("#Member_limit_1_guest").val(event.event._def.extendedProps.Member_limit);

				jQuery("#Remaining_Member_limit_1").val(event.event._def.extendedProps.remaning_memmber);

				jQuery("#Remaining_Member_limit_2").val(event.event._def.extendedProps.remaning_memmber);

				jQuery("#Remaining_Member_limit_1_guest").val(event.event._def.extendedProps.remaning_memmber);

				jQuery("#class_id1").val(event.event._def.extendedProps.class_id);

				jQuery("#class_id2").val(event.event._def.extendedProps.class_id);

				jQuery("#class_id1_guest").val(event.event._def.extendedProps.class_id);

				jQuery("#day_id1").val(event.event._def.extendedProps.day);

				jQuery("#day_id2").val(event.event._def.extendedProps.day);

				jQuery("#day_id1_guest").val(event.event._def.extendedProps.day);

				jQuery("#bookedclass_membershipid").val(event.event._def.extendedProps.membership_id);

				jQuery("#bookedclass_membershipid2").val(event.event._def.extendedProps.membership_id);

				jQuery("#bookedclass_membershipid_guest").val(event.event._def.extendedProps.membership_id);

				jQuery("#class_date1").val(event.event._def.extendedProps.class_date);

				jQuery("#class_date2").val(event.event._def.extendedProps.class_date);

				jQuery("#class_date1_guest").val(event.event._def.extendedProps.class_date);

				jQuery("#btn_submit").val(event.event._def.extendedProps.btn_submit);

				jQuery("#d_id").html();

				

				var remaning_memmber_0 = event.event._def.extendedProps.remaning_memmber;

				if(remaning_memmber_0 == '0')

				{

					jQuery("#d_id").css("display","none");

					jQuery("#show").css("display","none");

					jQuery("#buy_membership_class_div").css("display","none");

				}

				else

				{

					jQuery("#d_id").css("display","block");

					jQuery("#show").css("display","block");

					jQuery("#buy_membership_class_div").css("display","block");

				}

				

				var membership_name_1  = event.event._def.extendedProps.membership_name;

				if(membership_name_1 == '')

				{

					jQuery(".merbership_name_min").css("display","none");

					jQuery("#show").css("display","none");

					jQuery("#d_id").css("display","none");

				}

				else

				{

					jQuery(".merbership_name_min").css("display","block");

					jQuery("#show").css("display","block");

					jQuery("#d_id").css("display","block");

				}

				var today = new Date();

				var class_dates= event.event._def.extendedProps.class_date;

				var dd = today.getDate();

				var mm = today.getMonth()+1; 

				var yyyy = today.getFullYear();

				if(dd<10) 

				{

					dd='0'+dd;

				} 



				if(mm<10) 

				{

					mm='0'+mm;

				} 

				var new_today = yyyy+'-'+mm+'-'+dd;

				

				if(new_today <= class_dates )

				{

					$("#eventLink").attr('href', event.event._def.extendedProps.url);

					$("#eventContent").dialog({ modal: true, title: '<?php esc_html_e("Class Book","gym_mgt")?>',width:500, height:420 });

					$( "#eventContent" ).removeClass( "display_none" );

					$(".ui-dialog-titlebar-close").text('x');

					$(".ui-dialog-titlebar-close").css('height',30);

				}



		    },

			eventAfterRender: function (event, element, view) {

					var today = new Date();

					var class_dates= event.class_date;

					var dd = today.getDate();

					var mm = today.getMonth()+1; 

					var yyyy = today.getFullYear();

					if(dd<10) 

					{

						dd='0'+dd;

					} 



					if(mm<10) 

					{

						mm='0'+mm;

					} 

					var new_today = yyyy+'-'+mm+'-'+dd;

	

					if (class_dates < new_today)

					{

						element.css('opacity','0.5');

					}

				},

			//end  add class in pop up//

	})

calendar.render();	

});

</script>

<script>

jQuery(document).ready(function($) 

{

	"use strict";

	// add the responsive classes after page initialization

	window.onload = function () {

		$('.fc-toolbar.fc-header-toolbar').addClass('row col-lg-12');

	};



	// add the responsive classes when navigating with calendar buttons

	$(document).on('click', '.fc-button', function(e) {

		$('.fc-toolbar.fc-header-toolbar').addClass('row col-lg-12');

	});

	

	//Open Guest Booking POP-UP

	$('#show').on('click', function ()

	{

		$('#eventContent').dialog('close')

		$('.center').show();

		$(this).hide();

	});

	

	//Close Guest Booking POP-UP

	$('#close').on('click', function () {

		$('.center').hide();

		$('#show').show();

	});

	$('#classis_id').multiselect(

	{

		nonSelectedText :'<?php esc_html_e('Select Class','gym_mgt');?>',

		includeSelectAllOption: true,

		allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',

		selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',

		templates: {

				button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',

			},

		buttonContainer: '<div class="dropdown" />'

	});	

	 $("body").on("click", "#buy_membership_class", function(event){	

	 

		var id = $(this).attr("ids");

		var membership_id =$(".buy_membership_"+id).attr("attr_");

		var class_id = $('#class_id1').val();

		var startTime_1 = $('#startTime_1').val();

		var class_date = $('#class_date1').val();

		var day_id1 = $('#day_id1').val();

		var bookedclass_membershipid = $(".buy_membership_"+id).attr("attr_");

		var Remaining_Member_limit_1 = $('#Remaining_Member_limit_1').val();

		//var action='?action=fronted_membership&membership_id='+membership_id+'&class_id='+class_id;

		var action='?action=frontend_class_book_with_membership_id&membership_id='+membership_id+'&class_id='+class_id+'&startTime_1='+startTime_1+'&class_date='+class_date+'&day_id1='+day_id1+'&bookedclass_membershipid='+bookedclass_membershipid+'&Remaining_Member_limit_1='+Remaining_Member_limit_1;

		var home="<?php echo home_url('member-registration-or-login')?>"+action;

		window.location.replace(home); 

	 });

});

</script>





<script type="text/javascript">

$(function () {

	$("body").on("click","td.fc-event-container a.fc-start",function(){

		$("body").addClass("calender-popup-open");

   });

   

});



jQuery(document).ready(function () {

	   $("body").on("click", ".ui-dialog-titlebar-close", function(event){

		  // $("body").removeClass("calender-popup-open");

	   });

	

	$("body").on("change", "#membership_id ", function(event){		

	event.preventDefault(); // disable normal link function so that it doesn't refresh the page

	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

	

	var res_json;

	var membership_id = $(this).val();

		

	var membership_hidden = $('.membership_hidden').val();

	var categCheck = jQuery('.classis_ids').multiselect();	



	if(membership_id!="")

	{		

		var curr_data = {

			url: ajaxurl,

			action: 'MJ_gmgt_get_class_id_by_membership',

			membership_id : membership_id,	 	

			membership_hidden : membership_hidden,	 	

			dataType: 'json'

		};

		

		$.post(ajaxurl, curr_data, function(response) 

		{		

			

			if(response == 1)

			{		

				alert(language_translate.membership_member_limit_alert);

								

				$('#membership_id').val('');	

				$('#classis_id').html('');		

				categCheck.multiselect('rebuild');						

			}

			else

			{		

				$('#classis_id').html('');	

				$('#classis_id').html(response);	

				categCheck.multiselect('rebuild');		

			}

			return true; 					

		});

	}

	else

	{

		$('#classis_id').html('');	

		categCheck.multiselect('rebuild');		

		return true; 

	}

});

});

</script>

<?php 

// $current_theme = get_current_theme();

$current_theme = wp_get_theme();

// var_dump($current_theme);

// die;

if($current_theme == 'Divi')

{

	?>

	<style>

		.et_divi_theme .ml_20.col-sm-2.search_responisve_pd_b_calendar{

			margin-top: 10px !important;

		}

	</style>

	<?php

}

if($current_theme == 'Twenty Twenty-Three')

{

	?>

	<style>

	footer

	{

		display: none;

	}

	</style>

	<?php

}

if($current_theme == 'Twenty Twenty-Two' || $current_theme == 'Twenty Twenty-Three')

{

	?>

	<style>

	@media (max-width: 768px)

	{

		.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-draggable.ui-resizable

		{

			width: 332px !important;

			/* left: -131px !important;

			top: 2878.5px !important; */

		}

		.wp-container-10.is-content-justification-space-between.wp-block-group.alignwide

		{

			display: none !important;

		}

		.fc-col-header 

		{

			width: 100% !important;

		}

		.fc-daygrid-body

		{

			width: 100% !important;

		}

		table.fc-scrollgrid-sync-table

		{

			width: 100% !important;

		}

		.wp-embed-responsive .float_initial

		{

			padding: 0 !important;

		}

		.fc-scroller

		{

			height: 100% !important;

			max-height: 100% !important;

		}

	}

	@media (min-width: 1020px) and (max-width: 1100px)

	{

		.class_booking_custom_div

		{

			top: 18% !important;

		}

		.fc-scroller

		{

			height: 100% !important;

			max-height: 100% !important;

		}

	}

		#message

		{

			left: 3%;

			position: absolute;

			top: 38%;

			margin: 0 10%;

			width: 75%;

			margin-top: 15px;

		}

		.wp-embed-responsive .filter_cal{

			padding: 20PX;

			margin-left: 28%;

			margin-top: 20px;

		}

		.wp-embed-responsive .float_initial{	

			padding: 20px;

    		margin-left: 8%;

		}

		.main_div_bookiing_popup_form .frontend_book_Class_div{

			width: 167px !important;

		}

		.class_booking_custom_div{

			position: absolute;

			width: 100%;

			top: 40%;

		}

		.wp-block-group .alignwide{

			padding-bottom: 0 !important;

			padding-top: 0 !important;

		}

		.wp-block-group h1{

			margin-bottom: 0 !important;

		}

		@media only screen and (max-width : 768px) {

			.wp-embed-responsive .filter_cal {

				padding: 20PX;

				/* margin-left: 28% !important;

				margin-top: 20% !important; */

			}

			.class_booking_custom_div

			{

				top: 23%;

			}

			.popup-bg

			{

				display: none;

			}

			#buy_membership_class {

				border-radius:0 !important;

			}

		}

		/* .wp-site-blocks .wp-block-template-part{

			position: absolute;

			width: 100%;

			top: 80%;

		} */

	</style>

	<?php

}

if($current_theme == 'Twenty Twenty-One')

{

	?>

	<style>

	.search_responisve_pd_b_calendar{

		padding-top: 5px;

	}

	@media only screen and (max-width : 768px) {

		

			.popup-bg

			{

				display: none;

			}

			

		}

	</style>

	<?php

}

if($current_theme == 'Avada')

{

	?>

	<style>

		.frontend_booking_btn

		{

			margin-top: 22px !important;

		}

	</style>

	<?php

}



if($current_theme == 'Twenty Twenty')

{

	?>

	<style>

		.search_responisve_pd_b_calendar{

			margin-top: 7px !important;

		}

		.fc-col-header 

		{

			margin: 0 !important;

			

		}

		.fc-col-header tbody tr th .fc-scrollgrid-sync-inner

		{

			padding: 5px;

		}

		.post-inner

		{

			padding-top: 4rem !important;

		}

		.singular .entry-header

		{

			padding: 0 !important;

		}

		.fc-scrollgrid-sync-table

		{

			margin: 0 !important;

			height: 506px;

		}

	</style>

	<?php

}

if($current_theme == 'Twenty Twenty-One Child')

{

	?>

	<style>

		body {

			background-color: #ba170b!important;

		}

		.entry-header{

			display: none;

		}

		.gmgt_Child_theme_class_cooking_heder{

			max-width: 80%;

			margin: auto;

			margin-bottom: 30px;

		}

		.entry-content .class_booking_custom_div {

			max-width: 80% !important;

			background-color: #ffff;

		}

		.gmgt_Child_theme_class_cooking_heder{

			font-weight: 500;

			font-size: 30px;

			line-height: 75px;

			text-align: center;

			color: #333333;

		}

		.gmgt_child_class_booking_form{

			display: inline-flex;

			margin-top: 5%;

			width: 100%;

		}

		.gmgt_child_login_book{

			width: 50%;

		}

		.frontend_book_Class_div {

			margin-top: 0!important;

			width: 50%;

			float: left;

		}

		.frontend_booking_btn {

			width: 80%;

		}

	</style>

	<?php

}

?>

<style>

	body

	{

		background-color: var(--global--color-background);

	}

	.search_responisve_pd_b_calendar .btn_filter{

			border-radius: 28px;

			padding: 4px 20px !important;

			background-color: #014D67 !important;

			border: 0px;

			color: #ffffff;

			font-size: 16px !important;

			text-transform: uppercase;

		}

	.btn_filter

	{

		margin-left: 10px !important;

		float: left!important;

		padding: 4px!important;

		margin-top: 2px!important;

		font-size: 15px!important;

	}

	#buy_membership_class

	{

		padding: 1px;

	}

	.min_width_300

	{

		max-width: 300px;

		min-width: 300px;

	}

	.mb_10 

	{

		margin-bottom:10px;

	}

	.margin_right_10

	{

		margin-right:10px;

	}

	.alert_msg

	{

		font-size: 16px;

   		color: red;

	}

	.msg2

	{

		font-size: 16px;

   		color: green;

	}

	.width_80

	{

		width:80%;

	}

	#calendar .fc-view-harness

	{

		height: 534px !important;

	}

	/* .calender_classbooking_div .row>*

	{

		width: auto !important;

	} */

</style>

<!------------ Twenty Nineteen CSS ----------->

<style>

	.image-filters-enabled .btn_filter 

	{

		margin-left: 10px !important;

		float: left!important;

		padding: 4px!important;

		margin-top: 26px!important;

		font-size: 15px!important;

	}

	.image-filters-enabled #buy_membership_class 

	{

    	padding: 5px;

	}

	@media only screen and (max-width : 768px) {

		.dis_flex {

			display: flow-root !important;

		}

		.ui-dialog {

			margin-left: 0% !important;

		}

		.center.hideform {

			left: 10px !important;

			width: 100%;

		}

		.fc-daygrid-event

		{

			overflow: hidden;

		}

		.fc-more-link

		{

			font-size: 11px !important;

		}

	}

</style>

<?php

if($current_theme == 'Twenty Twenty-One Child')

{

	if(!empty(get_custom_logo()))

	{

		echo get_custom_logo();

	}

	else

	{

		?>

		<span class="custom-logo-link">

			<img width="400" height="99" src="<?php  echo get_option( 'gmgt_system_logo' ); ?>" class="custom-logo" alt="">

		</span>



		<?php

	}

	?>

	<?php

}

?>

<div class="class_booking_custom_div">

	<?php 

	if($current_theme == 'Twenty Twenty-One Child')

	{

		?>

		<h4 class="gmgt_Child_theme_class_cooking_heder"><?php echo esc_html_e( "Class Booking", 'gym_mgt' ); ?></h4>

		<?php

	}

	else

	{

		?>

		<style>

			.theme_padding_top_20px

			{

				padding-top: 20px;

			}

		</style>

		<?php

	}

	?>



		<script type="text/javascript">



		jQuery(document).ready(function()

		{







			"use strict";







			jQuery('#front_class_booking').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



		});



		</script>







		<script type="text/javascript" src="<?php echo esc_url( plugins_url() . '/gym-management/assets/accordian/jquery-ui.js' ); ?>"></script> 







		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/js/languages/jquery.validationEngine-'.$code.'.js'; ?>"></script> 







		<script type="text/javascript"	src="<?php echo GMS_PLUGIN_URL.'/lib/validationEngine/js/jquery_validationEngine.js'; ?>"></script> 



	<form method="post" class="filter_cal" id="front_class_booking">

		<input type="hidden" name="membership_hidden" class="membership_hidden" value="<?php  echo '0'; ?>">

		<div class=" dis_block_res">

			<div class="form-body user_form theme_padding_top_20px"> <!--form-Body div Strat-->   

				<div class="row"><!--Row Div--> 

					<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input avada_custome_div">
						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Membership','gym_mgt');?><span class="require-field">*</span></label>
						<?php 	

						$membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>

						<select name="membership_id" class="form-control validate[required] width_300" id="membership_id">

							<option value=""><?php  esc_html_e('Select Membership ','gym_mgt');?></option>

							<?php 

							if(!empty($membershipdata))

							{

								foreach ($membershipdata as $membership)

								{						

									echo '<option value='.$membership->membership_id.' '.selected($staff_data,$membership->membership_id).'>'.$membership->membership_label.'</option>';

								}

							}

							?>

						</select>

					</div>

					<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input avada_custome_div2">
						<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>
						<?php

						$get_staff = array('role' => 'Staff_member');

						$staffdata=get_users($get_staff);

						?>

						<select name="staff_id" class="form-control validate[required] width_300" id="staff_id">

							<option value=""><?php  esc_html_e('Select Staff Member','gym_mgt');?></option>

							<?php 

							if(!empty($staffdata))

							{

								foreach($staffdata as $staff)

								{						

									echo '<option value='.$staff->ID.' '.selected($staff_id,$staff->ID).'>'.$staff->display_name.'</option>';

								}

							}

							?>

						</select>

					</div>

					<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 input">

						<input type="submit" value="<?php  esc_html_e('Search','gym_mgt'); ?>" name="guset_book_front_filter" class="save_btn" style="padding:10px;">

					</div>

				</div>

			</div>

		</div>

	</form>

	<!--task-event POP up code -->

	<div class="popup-bg">

		<div class="overlay-content content_width">

			<div class="modal-content" id="border_top_5">

				<div class="task_event_list">

				</div>     

			</div>

		</div>     

	</div>

	<!-- End task-event POP-UP Code -->

	<!-- CLASS BOOK IN CALANDER POPUP HTML CODE -->

	<div id="eventContent" class="modal-body display_none"><!--MODAL BODY DIV START-->

		<style>

			.ui-dialog-titlebar-close

			{

				font-size: 13px !important;

				border: 1px solid transparent !important;

				border-radius: 0 !important;

				outline: 0!important;

				background-color: #fff !important;

				background-image: url("<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>");

				background-repeat: no-repeat;

				float: right;

				color: #fff !important;

				width: 10% !important;

				height: 30px !important;

			}

			.ui-widget-header {

				border: 0px solid #aaaaaa !important;

				background: unset !important;

				font-size: 22px !important;

				color: #333333 !important;

				font-weight: 500 !important;

				font-style: normal!important;

				font-family: Poppins!important;

			}

			.ui-dialog {

				background: #ffffff none repeat scroll 0 0;

				border-radius: 4px;

				box-shadow: 0 0 5px rgb(0 0 0 / 90%);

				cursor: default;

			}

			.popup_padding_15px

			{

				padding: 0 15px 15px 15px;

			}

			@media (max-width: 768px)

			{

				.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-draggable.ui-resizable

				{

					width: 332px !important;

					/* left: -131px !important;

					top: 2878.5px !important; */

				}

			}

			.content_main_div_for_class_booking

			{

				height: 260px;

				overflow: scroll;

				overflow-x: hidden;

			}

			.margin_top_10px

			{

				margin-top: 10px !important;

			}

		</style>

		

		<input type="hidden" id="class_name_1" name="class_name_1" value="" />

		<input type="hidden" id="startTime_1" name="startTime_1" value="" />

		<input type="hidden" id="endTime_1" name="endTime_1" value="" />

		<input type="hidden" id="class_id1" name="class_id1" value="" />

		<input type="hidden" id="day_id1" name="day_id1" value="" />

		<input type="hidden" id="bookedclass_membershipid" name="bookedclass_membershipid" value="" />

		<input type="hidden" id="Remaining_Member_limit_1" name="Remaining_Member_limit_1" value="" />

		<input type="hidden" id="class_date1" name="class_date" value="" />

		<div class="content_main_div_for_class_booking">

			<div class="penal-body">

				<div class="row">

					<div class="col-md-6 popup_padding_15px">

						<label for="" class="popup_label_heading"><?php esc_html_e('Name','gym_mgt');?></label><br>

						<label for="" class="label_value" id="class_name"></label>

					</div>

					<div class="col-md-6 popup_padding_15px">

						<label for="" class="popup_label_heading"><?php esc_html_e('Start Date & Time','gym_mgt');?></label><br>

						<label for="" class="label_value" id="startTime"></label>

					</div>

					<div class="col-md-6 popup_padding_15px">

						<label for="" class="popup_label_heading"><?php esc_html_e('End Date & Time','gym_mgt');?></label><br>

						<label for="" class="label_value" id="endTime"></label>

					</div>

					<div class="col-md-6 popup_padding_15px">

						<label for="" class="popup_label_heading"><?php esc_html_e('Trainer Name:','gym_mgt');?></label><br>

						<label for="" class="label_value" id="staff_member_name"></label>

					</div>

					<div class="col-md-6 popup_padding_15px">

						<label for="" class="popup_label_heading"><?php esc_html_e('Member Limit','gym_mgt');?></label><br>

						<label for="" class="label_value" id="Member_limit"></label>

					</div>

					<div class="col-md-6 popup_padding_15px">

						<label for="" class="popup_label_heading"><?php esc_html_e('Remaining Member','gym_mgt');?></label><br>

						<label for="" class="label_value " id="Remaining_Member_limit"> </label>

					</div>

				</div>  

			</div>

		

			<div class="merbership_name_min">

				<b class="wdth_170"> <?php esc_html_e('Membership Name :','gym_mgt');?></b> 

				<div class="dis_flex"><span id="membership_name" class="min_width_300"></span>

				<span id="btn_submit" class="save_btn divi_display"></span></div>

			</div>

		</div>

		<div class="main_div_bookiing_popup_form gmgt_child_class_booking_form">

			<form method="post" class="gmgt_child_login_book" accept-charset="utf-8" action="?action=frontend_book">

				<input type="hidden" id="class_name_2" name="class_name_1" value="" />

				<input type="hidden" id="startTime_2" name="startTime_1" value="" />

				<input type="hidden" id="endTime_2" name="endTime_1" value="" />

				<input type="hidden" id="class_id2" name="class_id1" value="" />

				<input type="hidden" id="day_id2" name="day_id1" value="" />

				<input type="hidden" id="bookedclass_membershipid2" name="bookedclass_membershipid" value="" />

				<input type="hidden" id="Remaining_Member_limit_2" name="Remaining_Member_limit_1" value="" />

				<input type="hidden" id="class_date2" name="class_date" value="" />

				<div></div>

				<div class="frontend_booking_btn col-md-5 col-lg-5 submit margin_top_10px" style="float:left;">

					<?php if(get_option('gym_frontend_class_booking')== 'yes')

					{ ?>

						<input type="submit" name="frontend_guest_book" id="d_id" style="line-height:18px;" class=" sumit display save_btn book_buy_btn" value="<?php if (is_user_logged_in()){ esc_html_e('BOOK CLASS','gym_mgt');  }else{ echo esc_html_e('LOGIN TO BOOK','gym_mgt'); }?>"/>

					<?php 

					} ?>

				</div>	

				<div class="frontend_book_Class_div col-md-5" style="margin-top: 10px; float: right;">

				

					<a href="#" name="frontend_book_Class" class="save_btn btn" style="line-height: 34px;" id="show"><?php esc_html_e('Book Demo Class','gym_mgt');?></a>

				</div>

				

			</form>	

			

		</div>	

	</div><!--MODAL BODY DIV END-->



	<div class="cal_width col-md-12 float_initial calender_classbooking_div">		

		<div class="panel panel-white cad">

			<div class="panel-body">

				<div id="calendar" class="theme_design_text_align">

				</div>

			</div>

		</div>

	</div>

</div>

<?php

	if($current_theme == 'Twenty Twenty-One Child')

	{

		?>

		<footer class="gmgt_footer">

			<nav aria-label="Secondary menu" class="footer-navigation">

				<ul class="footer-navigation-wrapper">

					<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url()); ?>"><span><?php echo esc_html_e( "Login", 'gym_mgt' ); ?></span></a></li>

					<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('member-registration-or-login')); ?>"><span><?php echo esc_html_e( "Member Registration", 'gym_mgt' ); ?></span></a></li>

					<li id="menu-item" class="menu-item "><a href="<?php echo wp_logout_url(home_url('membership-list-page')); ?>"><span><?php echo esc_html_e( "Membership List", 'gym_mgt' ); ?></span></a></li>

				</ul>

			</nav>

		</footer>

		<?php 

	}

	elseif($current_theme == 'Kallyas')

	{

		?>

		<style>

			#membership_id, #staff_id{

				height: 46px !important;

			}

			.col-sm-4.col-md-3{

				top: 1245px !important;

				position: absolute !important;

			}

			.site-footer{

				margin-top: 105% !important;

			}.frontend_book_Class_div {

				margin-top: 11px !important;

				padding-right: 3px;

			}

			.height_35px{

				height : 35px !important;

			}

			.divi_display input[type=email]{

				height : 35px !important;

			}

			.csspointerevents {

				scroll-behavior: unset !important;

			}

			.kl-skin--dark .page-title {

				color: #7e7979 !important;

			}

		</style>

		<?php

	}

?>

	<style>

		.center {

		margin: auto;

		width: 50%;

		padding: 20px;

		box-shadow: 0 5px 15px rgb(0 0 0 / 50%);

		}

		.divi_text_center .fnt_color{

			margin: 0.5rem auto 2rem !important;

		}

		.class_booking_custom_div .cal_width{

			max-width: 80%!important;

   			margin: auto;

		}

		.class_booking_custom_div .cal_width .cad{

			margin-top: 20px;

		}

		.class_booking_custom_div .filter_cal{

			max-width: 80%;

			margin: auto;

			margin-bottom: 20px;

		}

		.class_booking_custom_div{

			max-width: 100% !important;

		}

		.hideform {

			display: none;

		}

		.center.hideform

		{

			position: fixed;

			top: 41px;

			left: 391px;

			z-index: 999999;

			background: #ffffff url("images/ui-bg_flat_75_ffffff_40x100.png") 50% 50% repeat-x;

			border: 1px solid #aaaaaa;

			color: #222222;

			box-shadow: none;

		}

		.classs_booking_div_main_class_guest .col-sm-12{

			padding-bottom: 10px;

		}

		.booking_class_btn{

			border-radius: 28px !important;

			padding: 6px 30px !important;

			background-color: #ba170b !important;

			border: 0px !important;

			color: #ffffff !important;

			font-size: 20px !important;

			text-transform: uppercase;

			text-decoration: none !important;

		}



		.clas_booking_cls_btn_css

		{

			font-size: 13px !important;

			border: 1px solid transparent !important;

			border-radius: 0 !important;

			outline: 0!important;

			background-color: #fff !important;

			background-image: url("<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>");

			background-repeat: no-repeat;

			float: right;

			color: #fff !important;

			width: 10% !important;

			height: 30px !important;

		}

		.divi_text_center .fnt_color{

			font-size: 22px !important;

			color: #333333 !important;

			font-weight: 500 !important;

			font-style: normal!important;

			font-family: 'Poppins'!important;

		}

	</style>

	


	<div class="center hideform" id="guset_booking">

		<div class="col-sm-12 col-md-12" style="float: left;width: 100%;">

			<div class="col-sm-10 col-md-10 divi_text_center" style="float: left;">

				<h4 class="fnt_color"><?php esc_html_e('Book Demo Class','gym_mgt');?> </h4>

			</div>

			<div class="col-sm-2 col-md-2 clas_booking_cls" style="float: right;">

				<button id="close" class="model_close clas_booking_cls_btn_css" style="padding: 10px;line-height: 10px; margin-top: 10%;"></button>

			</div>

		</div>
		<script type="text/javascript">
		jQuery(document).ready(function()
		{
			"use strict";
			jQuery('#book_demo_class').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		});
		</script>
		<form action="" id="book_demo_class" method="post" id="guest_book_form">

			<input type="hidden" id="class_name_1_guest" name="class_name_1" value="" />

			<input type="hidden" id="startTime_1_guest" name="startTime_1" value="" />

			<input type="hidden" id="endTime_1_guest" name="endTime_1" value="" />

			<input type="hidden" id="class_id1_guest" name="class_id1" value="" />

			<input type="hidden" id="day_id1_guest" name="day_id1" value="" />

			<input type="hidden" id="bookedclass_membershipid_guest" name="bookedclass_membershipid" value="" />

			<input type="hidden" id="Remaining_Member_limit_1_guest" name="Remaining_Member_limit_1" value="" />

			<input type="hidden" id="class_date1_guest" name="class_date" value="" />

				<br>

				<div class="row">

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input type="text" name="firstname" maxlength="20" class="form-control text-input validate[required,custom[onlyLetter_specialcharacter]]">

								<label class="material_label" for="first_name"><?php esc_html_e('First Name','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input type="text" name="lastname" maxlength="20" class="form-control text-input validate[required,custom[onlyLetter_specialcharacter]]">

								<label class="material_label" for="lastname"><?php esc_html_e('Last Name','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input type="email"  name="email" maxlength="100" class="form-control text-input validate[required,custom[email]]" >

								<label class="material_label" for="email"><?php esc_html_e('Email','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">

						<div class="form-group input">

							<div class="col-md-12 form-control">

								<input type="text" name="phonenumber" maxlength="15" class="form-control text-input validate[required,custom[number]]" maxlength="15" >

								<label class="material_label" for="phonenumber"><?php esc_html_e('Phone Number','gym_mgt');?><span class="require-field">*</span></label>

							</div>

						</div>

					</div>

				</div>

				<div class="row"><!--Row Div Strat--> 

					<div class="col-md-6 col-sm-6 col-xs-12">

						<input type="submit" value="<?php esc_html_e('Class Booking','gym_mgt');?>" name="guset_book_front" class="save_btn">

					</div>

				</div>

		</form>

	</div>

<?php

if(isset($_POST['guset_book_front']))

{

	$obj_guest_booking = new MJ_gmgt_guest_booking;

	$obj_class=new MJ_gmgt_classschedule;

	$action='frontend_book';

	$guest_booking=1;

	

	

	$result=$obj_guest_booking->MJ_gmgt_add_guest_booking($_POST);

	if($result)

	{

		wp_redirect( home_url('class-booking').'?action=success&message=10');

	}

}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book')

{

	

	if (! is_user_logged_in ())

	{			

	   $page_id = get_option ('gmgt_login_page');	

		$referrer_ipn = array(				

			'page_id' => $page_id,

			'action'=>$_REQUEST['action'],

			'class_id1'=>$_REQUEST['class_id1'],

			'startTime_1'=>$_REQUEST['startTime_1'],

			'class_date'=>$_REQUEST['class_date'],

			'day_id1'=>$_REQUEST['day_id1'],

			'bookedclass_membershipid'=>$_REQUEST['bookedclass_membershipid'],

			'test'=>"test",

			'Remaining_Member_limit_1'=>$_REQUEST['Remaining_Member_limit_1']

		);				

		

		$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );		

		wp_redirect ($referrer_ipn);

				

		exit;

	}

	else

	{

	

			$obj_class=new MJ_gmgt_classschedule;

			$result=$obj_class->booking_class_shortcode($_REQUEST['class_id1'],$_REQUEST['day_id1'],$_REQUEST['startstartTime_1Time_2'],$_REQUEST['action'],'',$_REQUEST['class_date']);



			if($result)

			{	

				$page_id = get_option ( 'gmgt_class_booking_page' );	

			

				$referrer_ipn = array(				

					'page_id' => $page_id,

					'message'=>$result					

				);				

			

				$referrer_ipn = add_query_arg( $referrer_ipn, home_url() );	

				wp_redirect ($referrer_ipn);

			}

	}

}

?>