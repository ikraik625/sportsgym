<?php 



$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;



$cur_user_class_id = array();	



$obj_class=new MJ_gmgt_classschedule;



$curr_user_id=get_current_user_id();



$obj_gym=new MJ_gmgt_Gym_management($curr_user_id);



$cur_user_class_id = MJ_gmgt_get_current_user_classis($curr_user_id);



$class_cancel_booking=get_option('gym_class_cancel_booking');



$enable_service=get_option('gym_class_cancel_booking');



$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'classlist';



//access right



$user_access=MJ_gmgt_get_userrole_wise_page_access_right_array();



if (isset ( $_REQUEST ['page'] ))



{



	if($user_access['view']=='0')



	{	



		MJ_gmgt_access_right_page_not_access_message();



		die;



	}



	if(!empty($_REQUEST['action']))



	{



		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))



		{



			if($user_access['edit']=='0')



			{	



				MJ_gmgt_access_right_page_not_access_message();



				die;



			}			



		}



		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))



		{



			if($enable_service=='yes' AND $obj_gym->role = 'member')



	        {







	        }



			else



			{	



				MJ_gmgt_access_right_page_not_access_message();



				die;



			}	



		}



		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))



		{



			if($user_access['add']=='0')



			{	



				MJ_gmgt_access_right_page_not_access_message();



				die;



			}	



		}



	}



}



//SAVE CLASS DATA



if(isset($_POST['save_class']))



{



	$nonce = $_POST['_wpnonce'];



	if (wp_verify_nonce( $nonce, 'save_class_nonce' ) )



	{



		$start_date=MJ_gmgt_get_format_for_db($_POST['start_date']);



		$end_date=MJ_gmgt_get_format_for_db($_POST['end_date']);



		if($start_date <=  $end_date)



		{



		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')

		{

			$time_validation=0;

			/* start_ampm equal to end_ampm */

			if($_POST['start_ampm'] == $_POST['end_ampm'] )

			{		

				/* start_time is 12 & end_time less than 12 OR end_time is 12 & start_time greater than 12*/		

                if (sanitize_text_field($_POST['start_time']) == 12 && sanitize_text_field($_POST['end_time']) < 12 || sanitize_text_field($_POST['end_time']) == 12 && sanitize_text_field($_POST['start_time']) > 12) 

				{

					$time_validation ='0';	

				}

				/* Start_time greater than end_time */

				elseif(sanitize_text_field($_POST['end_time']) < sanitize_text_field($_POST['start_time']))

				{

					$time_validation ='1';	

				}

				/* start_time equal to end_time but start_min greater than end_min */

				elseif(sanitize_text_field($_POST['end_time']) ==  sanitize_text_field($_POST['start_time']) && sanitize_text_field($_POST['start_min']) > sanitize_text_field($_POST['end_min']) )

				{

					$time_validation ='1';

				}

				/* start_time & end_time are same or start_min & end_min are same */

				elseif(sanitize_text_field($_POST['end_time']) ==  sanitize_text_field($_POST['start_time']) && sanitize_text_field($_POST['start_min']) == sanitize_text_field($_POST['end_min']) )

				{

					$time_validation ='1';

				}

				else{

					$time_validation ='0';

				}

			}

			else

			{

				$time_validation='0';

			}	



			if($time_validation=='1')

			{

				?>

				<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



					<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



					</button>



					<p><?php esc_html_e('End Time should be greater than Start Time','gym_mgt');?></p>



				</div>



				<?php 

			}

			else

			{

                //Edit Class//				

				$result=$obj_class->MJ_gmgt_add_class($_POST);

				if($result)

				{

					if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')

					{

						wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&page_action=web_view_hide&class_list_app=classlist_app&message=2');

					}

					else

					{



						wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&message=2');



					}	

				}

			}		

		}

		else

		{

			$time_validation=0;



			if(!empty($_POST['start_time']))



			{



				foreach($_POST['start_time'] as $key=>$start_time)



				{

  					/* start_ampm equal to end_ampm */

					if($_POST['start_ampm'][$key] == $_POST['end_ampm'][$key] )

					{				

                      

					   /* start_time is 12 & end_time less than 12 OR end_time is 12 & start_time greater than 12*/

					   if(sanitize_text_field($_POST['start_time'][$key]) == 12 && sanitize_text_field($_POST['end_time'][$key]) < 12 || sanitize_text_field($_POST['end_time'][$key]) == 12 && sanitize_text_field($_POST['start_time'][$key]) > 12)

					   {

						   $time_validation = 0;

					   }

					   /* Start_time greater than end_time */

					   elseif(sanitize_text_field($_POST['end_time'][$key]) < sanitize_text_field($_POST['start_time'][$key]))

					   {

						   $time_validation ='1';	

					   }

					   /* start_time equal to end_time but start_min greater than end_min */

					   elseif(sanitize_text_field($_POST['end_time'][$key]) ==  sanitize_text_field($_POST['start_time'][$key]) && sanitize_text_field($_POST['start_min'][$key]) > sanitize_text_field($_POST['end_min'][$key]) )

					   {

						   $time_validation ='1';

					   }

					   /* start_time & end_time are same or start_min & end_min are same */

					   elseif(sanitize_text_field($_POST['end_time'][$key]) ==  sanitize_text_field($_POST['start_time'][$key]) && sanitize_text_field($_POST['start_min'][$key]) == sanitize_text_field($_POST['end_min'][$key]) )

					   {

						   $time_validation ='1';

					   }

					   else{

						   $time_validation ='0';

					   }				



					}

					else

					{

						$time_validation ='0';

					}	



				}



			}



			if($time_validation =='1')

			{

				?>



				<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



					<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



					</button>



					<p><?php esc_html_e('End Time should be greater than Start Time','gym_mgt');?></p>



				</div>



				<?php 

			}

			else

			{

				//ADD CLASS SCHEDULE//

				$result=$obj_class->MJ_gmgt_add_class($_POST);



				if($result)



				{



					if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



					{



						wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&page_action=web_view_hide&class_list_app=classlist_app&message=1');



					}



					else



					{



						wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&message=1');



					}	

				}	



			}			



		}



		}



		else



		{ ?>



			<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



				</button>



				 <p><?php esc_html_e('End Date should be greater than Start Date','gym_mgt');?></p>



			</div>  



		<?php 



		}



	}



}



//CLASS BOOKING DATA SAVE//



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='book_now')



{	



	if($_REQUEST['Remaining_Member_limit_1'] == "0")



	{



		wp_redirect ( home_url().'?dashboard=user&message=4'); 



	}



	else



	{ 



		$result=$obj_class->MJ_gmgt_booking_class($_REQUEST['class_id1'],$_REQUEST['day_id1'],$_REQUEST['startTime_1'],$_REQUEST['action'],'',$_REQUEST['class_date']);



		if($result)



		{ 



			?>



			<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



				</button>



				<?php print esc_html($result);?>



			</div>



			<?php



		}



	}



}



//DELERE CLASS DATA



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete' && isset($_REQUEST['class_id']))



{



	$result=$obj_class->MJ_gmgt_delete_class($_REQUEST['class_id']);



	if($result)



	{



		if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



		{



			wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&page_action=web_view_hide&class_list_app=classlist_app&message=3');



		}



		else



		{



			wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&message=3');



		}	



		//wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&message=3');



	}



}



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'  && isset($_REQUEST['class_booking_id']))



{



	$result=$obj_class->MJ_gmgt_delete_booked_class(esc_attr($_REQUEST['class_booking_id']));



	if($result)



	{



		if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



		{



			wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&page_action=web_view_hide&class_list_app=classlist_app&message=3');



		}



		else



		{



			wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=class_booking&message=5');



		}	



	}



}







if(isset($_POST['create_meeting']))



{



$nonce = $_POST['_wpnonce'];



if ( wp_verify_nonce( $nonce, 'create_meeting_admin_nonce' ) )



{



	



	$result = $obj_virtual_classroom->MJ_gmgt_create_meeting_in_zoom($_POST);



	if($result)



	{



		if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



		{



			wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&page_action=web_view_hide&class_list_app=classlist_app&message=1');



		}



		else



		{



			wp_redirect ( home_url().'?dashboard=user&page=class-schedule&tab=classlist&message=1');



		}	



		//wp_redirect ( home_url().'?dashboard=user&page=virtual_class&tab=meeting_list&message=1');



	}



		



}



}



if(isset($_REQUEST['message']))



{



	$message =esc_attr($_REQUEST['message']);



	if($message == 1)



	{ ?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e('Class added successfully.','gym_mgt');?></p>



		</div>



	<?php 



	}



	elseif($message == 2)



	{ ?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e("Class updated successfully.",'gym_mgt');	?></p>



		</div>



	<?php 		



	}



	elseif($message == 3) 



	{ ?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e('Class deleted successfully.','gym_mgt'); ?></p>



		</div>



	<?php				



	}



	elseif($message == 5) 



	{ ?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e('Class Cancelled Successfully.','gym_mgt'); ?></p>



		</div>



	<?php				



	}



	elseif($message == 4) 



	{ ?>



		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">



			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Close.png"?>" alt=""></span>



			</button>



			<p><?php esc_html_e('Member Limit Is Full.','gym_mgt'); ?></p>



		</div>



	<?php			



	}



}



?>



<?php



$membership_id=get_user_meta( get_current_user_id(),'membership_id',true );



if($membership_id)



{

	

	if(MJ_gmgt_get_membership_class_status($membership_id)=="limited")



	{	



		$obj_membership = new MJ_gmgt_membership();



		$on_of_classis = $obj_membership->MJ_gmgt_get_single_membership($membership_id);



		$total_member_limit_class_data=$obj_membership->MJ_gmgt_get_member_credit_class(get_current_user_id(),$membership_id);



		$total_class_with_credit_limit=$on_of_classis->on_of_classis + $total_member_limit_class_data ;





	}	



}



?>



<script type="text/javascript">



$(document).ready(function() 



{



	"use strict";	



	$('#group_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});



});



</script>







<script type="text/javascript">



	$(document).ready(function() 



	{



		"use strict";







			$('#membership_id').multiselect(



			{



				nonSelectedText :'<?php esc_html_e('Select Membership','gym_mgt');?>',



				includeSelectAllOption: true,



				allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



				selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



				templates: {



						button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



					},



				buttonContainer: '<div class="dropdown" />'



			});	



			$('#day').multiselect(



			{



				nonSelectedText :'<?php esc_html_e('Select Day','gym_mgt');?>',



				includeSelectAllOption: true,



				allSelectedText :'<?php esc_html_e('All Selected','gym_mgt'); ?>',



				selectAllText : '<?php esc_html_e('Select all','gym_mgt'); ?>',



				templates: {



						button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',



					},



				buttonContainer: '<div class="dropdown" />'



			});	



			



			$(".day_validation_submit").on('click',function()



			{	



			checked = $(".day_validation_class .dropdown-menu input:checked").length;



				if(!checked)



				{



					alert("<?php esc_html_e('Please select Atleast One Day','gym_mgt');?>");



					return false;



				}	  



			}); 



			$(".day_validation_submit").on('click',function()



			{



				checked = $(".multiselect_validation_membership .dropdown-menu input:checked").length;



				if(!checked)



				{



					alert("<?php esc_html_e('Please select Atleast One membership.','gym_mgt');?>");



					return false;



				}	  



			}); 



	} );



</script>



<!-- POP up code -->



<div class="popup-bg z_index_100000">



    <div class="overlay-content">



		<div class="modal-content">



		   <div class="category_list notice"></div>



		</div>



    </div> 



</div>







<!-- End POP-UP Code -->



<div class="panel-body panel-white padding_0"><!--PANEL BODY DIV START-->   



	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->



		<?php



		if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app' || isset($_REQUEST['page_action']) && $_REQUEST['page_action'] == 'web_view_hide')



		{



			?>



			<ul class="nav nav-tabs panel_tabs mb-3" role="tablist"><!--NAV TABS MENU START-->      



				<li class="margin_top_5 <?php if($active_tab == 'classlist') echo "active";?>">



					<a href="?dashboard=user&page=class-schedule&tab=classlist&class_list_app=classlist_app&page_action=web_view_hide">



					<?php esc_html_e('Class List', 'gym_mgt'); ?></a>



				</li>



				<li class="margin_top_5 <?php if($active_tab=='addclass'){?>active<?php }?>">



					<?php  



					if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['class_id']))



					{ ?>



						<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_list_app=classlist_app&page_action=web_view_hide&class_id=<?php echo esc_attr($_REQUEST['class_id']);?>" class="nav-tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Edit Class', 'gym_mgt'); ?></a>



						<?php 



					}



					else



					{



						if($user_access['add']=='1')



						{



							?>



							<a href="?dashboard=user&page=class-schedule&tab=addclass&action=insert&class_list_app=classlist_app&page_action=web_view_hide" class="nav-tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Add Class', 'gym_mgt'); ?></a>



							<?php 



						}



					}



					?>	  



				</li>



				<?php		



				if( $obj_gym->role != 'member')



				{



					?>



					<li class="margin_top_5 <?php if($active_tab == 'schedulelist') {?>active<?php }?>">



						<a href="?dashboard=user&page=class-schedule&class_list_app=classlist_app&page_action=web_view_hide&tab=schedulelist"><?php esc_html_e('Schedule List', 'gym_mgt'); ?></a>



					</li>



					<?php 



				}



				if( $obj_gym->role == 'member' || $obj_gym->role == 'staff_member') 



				{ ?>



					<li class="margin_top_5 <?php if($active_tab == 'class_booking') {?>active<?php }?>">



						<a href="?dashboard=user&page=class-schedule&class_list_app=classlist_app&page_action=web_view_hide&tab=class_booking"><?php esc_html_e('Booking List', 'gym_mgt'); ?></a>



					</li>



					<?php



				}



				if( $obj_gym->role == 'staff_member') 



				{ ?>



					<li class="margin_top_5 <?php if($active_tab == 'guest_list') {?>active<?php }?>">



						<a href="?dashboard=user&page=class-schedule&class_list_app=classlist_app&page_action=web_view_hide&tab=guest_list"><?php esc_html_e('Guest Booking List', 'gym_mgt'); ?></a>



					</li>



					<?php



				}



				?>



			</ul><!--NAV TABS MENU END-->   



			<?php



		}



		else



		{



			?>



			<ul class="nav nav-tabs panel_tabs mb-3" role="tablist"><!--NAV TABS MENU START-->      



				<li class="margin_top_5 <?php if($active_tab == 'classlist') echo "active";?>">



					<a href="?dashboard=user&page=class-schedule&tab=classlist">



					<?php esc_html_e('Class List', 'gym_mgt'); ?></a>



				</li>



				<li class="margin_top_5 <?php if($active_tab=='addclass'){?>active<?php }?>">



					<?php  



					if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['class_id']))



					{ ?>



						<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id=<?php echo esc_attr($_REQUEST['class_id']);?>" class="nav-tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Edit Class', 'gym_mgt'); ?></a>



						<?php 



					}



					else



					{



						if($user_access['add']=='1')



						{



							?>



							<a href="?dashboard=user&page=class-schedule&tab=addclass&&action=insert" class="nav-tab <?php echo $active_tab == 'addclass' ? 'nav-tab-active' : ''; ?>"> <?php esc_html_e('Add Class', 'gym_mgt'); ?></a>



							<?php 



						}



					}



					?>	  



				</li>



				<?php		



				if( $obj_gym->role != 'member')



				{



					?>



					<li class="margin_top_5 <?php if($active_tab == 'schedulelist') {?>active<?php }?>">



						<a href="?dashboard=user&page=class-schedule&tab=schedulelist"><?php esc_html_e('Schedule List', 'gym_mgt'); ?></a>



					</li>



					<?php 



				}



				if( $obj_gym->role == 'member' || $obj_gym->role == 'staff_member') 



				{ ?>



					<li class="margin_top_5 <?php if($active_tab == 'class_booking') {?>active<?php }?>">



						<a href="?dashboard=user&page=class-schedule&tab=class_booking"><?php esc_html_e('Booking List', 'gym_mgt'); ?></a>



					</li>



					<?php



				}



				if( $obj_gym->role == 'staff_member') 



				{ ?>



					<li class="margin_top_5 <?php if($active_tab == 'guest_list') {?>active<?php }?>">



						<a href="?dashboard=user&page=class-schedule&tab=guest_list"><?php esc_html_e('Guest Booking List', 'gym_mgt'); ?></a>



					</li>



					<?php



				}



				?>



			</ul><!--NAV TABS MENU END-->   



			<?php



		}



		?>	



		<div class="tab-content padding_0"><!--TAB CONTENT DIV START-->   



			<?php 



			if($active_tab == 'class_booking')



			{ 



				//GET USER BOOKING CLASS BY USER ID	



				if ($obj_gym->role == 'member')



				{



					$bookingdata=$obj_class->MJ_gmgt_get_member_book_class(get_current_user_id());



				}



				elseif ($obj_gym->role == 'staff_member')



				{



					$bookingdata=$obj_class->MJ_gmgt_get_all_booked_class();



				}







				if(!empty($bookingdata))



				{



					?>



				







					<script type="text/javascript">



						$(document).ready(function() 



						{



							"use strict";



							jQuery('#booking_list').DataTable({



								// "responsive": true,



								dom: 'lifrtp',



								"aoColumns":[



											{"bSortable": false},



											{"bSortable": false},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": false}],



								language:<?php echo MJ_gmgt_datatable_multi_language();?>			  



							});



							$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



						} );



					</script>



					



					<div class="panel-body padding_0"><!--PANEL BODY DIV START-->   



						<div class="table-responsive"><!--TABLE RESPONSIVE DIV START-->   



							<table id="booking_list" class="display" cellspacing="0" width="100%"><!--TABLE BOOKING LIST START-->   



								<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



									<tr>



									<th><?php esc_html_e('Photo','gym_mgt');?></th>



										<th><?php esc_html_e('Member Name', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('Class Name', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('Class Date', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('Booking Date', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('Day', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('Start Time', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('End Time', 'gym_mgt' ) ;?></th>



										<th class="text_align_end"><?php esc_html_e('Action', 'gym_mgt' ) ;?></th>            



									</tr>



								</thead>



								<tbody>



									<?php 



									if(!empty($bookingdata))



									{



										$i=0;



										foreach ($bookingdata as $retrieved_data)



										{ 



											if($i == 10)



											{



												$i=0;



											}



											if($i == 0)



											{



												$color_class='smgt_class_color0';



											}

member_type

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



														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



													</p>



												</td>



												<td class="membername">



													<a href="?dashboard=user&page=member&tab=viewmember&action=view&member_id=<?php echo esc_attr($retrieved_data->member_id);?>">



														<?php



														if(!empty($retrieved_data->member_id))



														{



															echo MJ_gmgt_get_member_full_display_name_with_memberid(esc_html($retrieved_data->member_id));



														}



														else



														{



															echo "N/A";



														}?>



													</a>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Member Name','gym_mgt');?>" ></i>



												</td>



												<td class="class_name">



													<?php  



													if(!empty($obj_class->MJ_gmgt_get_class_name(esc_html($retrieved_data->class_id))))



													{



														print $obj_class->MJ_gmgt_get_class_name(esc_html($retrieved_data->class_id));



													}



													else



													{



														echo "N/A";



													}?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>



												</td>



												<td class="class_name">



													<?php print  str_replace('00:00:00',"",esc_html($retrieved_data->class_booking_date))?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Date','gym_mgt');?>" ></i>



												</td>



												<td class="class_name">



													<?php print  str_replace('00:00:00',"",esc_html($retrieved_data->booking_date))?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Booking Date','gym_mgt');?>" ></i>



												</td>



												<td class="starttime">



													<?php 



													if($retrieved_data->booking_day == "Sunday")



													{



														$booking_day=esc_html__('Sunday','gym_mgt');



													}



													elseif($retrieved_data->booking_day == "Monday")



													{



														$booking_day=esc_html__('Monday','gym_mgt');



													}



													elseif($retrieved_data->booking_day == "Tuesday")



													{



														$booking_day=esc_html__('Tuesday','gym_mgt');



													}



													elseif($retrieved_data->booking_day == "Wednesday")



													{



														$booking_day=esc_html__('Wednesday','gym_mgt');



													}



													elseif($retrieved_data->booking_day == "Thursday")



													{



														$booking_day=esc_html__('Thursday','gym_mgt');



													}



													elseif($retrieved_data->booking_day == "Friday")



													{



														$booking_day=esc_html__('Friday','gym_mgt');



													}



													elseif($retrieved_data->booking_day == "Saturday")



													{



														$booking_day=esc_html__('Saturday','gym_mgt');



													}



													echo $booking_day;?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>



												</td>



												<?php $class_data = $obj_class->MJ_gmgt_get_single_class($retrieved_data->class_id); ?>



												<td class="starttime">



													<?php 



													if(isset($class_data->start_time))



													{



														echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->start_time));



													}



													else



													{



														echo "N/A";



													}



													?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time','gym_mgt');?>" ></i>



												</td>



												<td class="endtime">



													<?php



													if(isset($class_data->start_time))



													{



														echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($class_data->end_time));



													}



													else



													{



														echo "N/A";



													}



													?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Time','gym_mgt');?>" ></i>



												</td>



												<td class="action"> 



													<div class="gmgt-user-dropdown">



														<ul class="" style="margin-bottom: 0px !important;">



															<li class="">



																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																</a>

																

																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

																	<li class="float_left_width_100">

																		<a href="#" class="view_details_popup float_left_width_100" type="<?php echo 'view_class_booking';?>" id="<?php echo esc_attr($retrieved_data->id)?>"><i class="fa fa-eye"></i><?php esc_html_e('View', 'gym_mgt' ) ;?></a>

																	</li>	

																	<?php



																	if($enable_service=='yes')



																	{



																		if(MJ_gmgt_cancel_class($retrieved_data->class_booking_date,$class_data->start_time) == '1' ) 



																		{ 



																			if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



																			{



																				?>



																				<li class="float_left_width_100">



																					<a href="?dashboard=user&page=class-schedule&tab=class_booking&action=delete&class_list_app=classlist_app&page_action=web_view_hide&class_booking_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Do you really want to cancel this class?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e('Cancel','gym_mgt');?> 



																				</li>



																				<?php



																			}



																			else



																			{



																				?>



																				<li class="float_left_width_100">



																					<a href="?dashboard=user&page=class-schedule&tab=class_booking&action=delete&class_booking_id=<?php echo esc_attr($retrieved_data->id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Do you really want to cancel this class?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e('Cancel','gym_mgt');?> 



																				</li>



																				<?php



																			}



																		}



																	}



																	if(get_option('gmgt_enable_virtual_classschedule') == 'yes')



																	{



																		$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;



																		$meeting_data_join_link = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_join_link__class_id_in_zoom($retrieved_data->class_id);



																		if(!empty($meeting_data_join_link))



																		{



																			?>



																			<li class="float_left_width_100">



																				<a href="<?php echo $meeting_data_join_link; ?>" class="btn btn-success" target="_blank"><i class="fa fa-video-camera" aria-hidden="true"></i> <?php esc_html_e('Join Virtual Class','gym_mgt');?> </a>



																			</li>



																			<?php



																		}



																	}



																	?>



																</ul>



															</li>



														</ul>



													</div>	



												</td>



											</tr>



											<?php 



											$i++;



										} 



									}



									?>     



								</tbody>        



							</table><!--TABLE BOOKING LIST END-->   



						</div><!--TABLE REAPONSIVE DIV END-->   



					</div><!--PANEL BODY DIV END-->   			



					<?php 



				}



				else



				{



					?>



					<div class="calendar-event-new margin_top_12p"> 



						<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



					</div>



					<?php



				}



			}



			if($active_tab == 'classlist')



			{ 



				//GET CLASS LIST DATA



				if($obj_gym->role == 'staff_member')



				{



					if($user_access['own_data']=='1')



					{



						$user_id=get_current_user_id();							



						$classdata=$obj_class->MJ_gmgt_get_all_classes_by_staffmember($user_id);



					}



					else



					{



						$classdata=$obj_class->MJ_gmgt_get_all_classes();



					}



				}



				elseif($obj_gym->role == 'member')



				{		



					if($user_access['own_data']=='1')



					{



						$classdata=$obj_class->MJ_gmgt_get_all_classes_by_member($cur_user_class_id);	



					}



					else



					{



						$classdata=$obj_class->MJ_gmgt_get_all_classes();



					}



				}



				else



				{		



					if($user_access['own_data']=='1')



					{



						$user_id=get_current_user_id();							



						$classdata=$obj_class->MJ_gmgt_get_all_classes_by_class_created_id($user_id);	



					}



					else



					{



						$classdata=$obj_class->MJ_gmgt_get_all_classes();



					}



				}







				if(!empty($classdata))



				{



					?>



					<script type="text/javascript">



						$(document).ready(function() 



						{



							"use strict";



							jQuery('#class_list').DataTable({



								// "responsive": true,



								dom: 'lifrtp',



								// "order": [[ 1, "asc" ]],



								"aoColumns":[



									{"bSortable": false},



									{"bSortable": true},



									{"bSortable": true},



									{"bSortable": true},



									{"bSortable": true},



									{"bSortable": true},			 



									{"bSortable": false}],



									language:<?php echo MJ_gmgt_datatable_multi_language();?>	



							});



							$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



						} );



					</script>



					<div class="panel-body padding_0"><!--PANEL BODY DIV START-->  



						<div class="table-responsive"><!--TABLE RESPONSIVE DIV STRAT-->  



							<table id="class_list" class="display" cellspacing="0" width="100%"><!--TABLE CLASS LIST START-->  



								<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



									<tr>



									<th><?php esc_html_e('Photo','gym_mgt');?></th>



										<th><?php esc_html_e('Class Name', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('Staff Name', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('Start Time', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('End Time', 'gym_mgt' ) ;?></th>



										<th><?php esc_html_e('Day', 'gym_mgt' ) ;?></th>



										<th class="text_align_end"><?php esc_html_e('Action', 'gym_mgt' ) ;?></th>



										



									</tr>



								</thead>

								<tbody>



									<?php



									if(!empty($classdata))



									{



										$i=0;



										foreach ($classdata as $retrieved_data)



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



														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



													</p>



												</td>



												<td class="classname">



													<a href="#" class="view_details_popup " id="<?php echo esc_attr($retrieved_data->class_id)?>" type="<?php echo 'view_class';?>">	



														<?php echo esc_html($retrieved_data->class_name);?>



													</a>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','gym_mgt');?>" ></i>



												</td>



												<td class="staff">



													<?php $display_name=MJ_gmgt_get_user_full_display_name($retrieved_data->staff_id);echo esc_html($display_name);?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Staff Name','gym_mgt');?>" ></i>



												</td>



												<td class="starttime">



													<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->start_time));?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time','gym_mgt');?>" ></i>



												</td>



												<td class="endtime">



													<?php echo MJ_gmgt_timeremovecolonbefoream_pm(esc_html($retrieved_data->end_time));?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Time','gym_mgt');?>" ></i>



												</td>



												<td class="day">



													<?php $days_array=json_decode($retrieved_data->day); 



													$days_string=array();



													if(!empty($days_array))



													{



														foreach($days_array as $day)



														{



															$days_class_schedule=substr($day,0,3);



															$days_string[]=__($days_class_schedule,'gym_mgt');



														}



													}



													echo implode(", ",$days_string);



													?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Day','gym_mgt');?>" ></i>



												</td>



												<td class="action"> 



													<div class="gmgt-user-dropdown">



														<ul class="" style="margin-bottom: 0px !important;">



															<li class="">



																<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">



																	<img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >



																</a>



																<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">



																	<li class="float_left_width_100">



																		<a href="#" class="view_details_popup float_left_width_100" id="<?php echo esc_attr($retrieved_data->class_id)?>" type="<?php echo 'view_class';?>"><i class="fa fa-eye"></i><?php esc_html_e('View','gym_mgt');?> </a>



																	</li>



																	<?php



																	if($user_access['edit']=='1')



																	{



																		if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



																		{



																			?>



																			<li class="float_left_width_100 border_bottom_item">



																				<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_list_app=classlist_app&page_action=web_view_hide&class_id=<?php echo esc_attr	($retrieved_data->class_id) ?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																			</li>



																			<?php



																		}



																		else



																		{



																			?>



																				<li class="float_left_width_100 border_bottom_item">



																					<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id=<?php echo esc_attr	($retrieved_data->class_id) ?>" class="float_left_width_100"><i class="fa fa-edit"></i> <?php esc_html_e('Edit', 'gym_mgt' ) ;?></a>



																				</li>



																			<?php



																		}



																	}



																	if($user_access['delete']=='1')



																	{



																		if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



																		{



																			?>		



																				<li class="float_left_width_100">



																					<a href="?dashboard=user&page=class-schedule&tab=classlist&action=delete&class_list_app=classlist_app&page_action=web_view_hide&class_id=<?php echo esc_attr($retrieved_data->class_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																				</li>



																			<?php



																		}



																		else



																		{



																			?>		



																			<li class="float_left_width_100">



																				<a href="?dashboard=user&page=class-schedule&tab=classlist&action=delete&class_id=<?php echo esc_attr($retrieved_data->class_id);?>" class="float_left_width_100 list_delete_btn" onclick="return confirm('<?php esc_html_e('Are you sure you want to delete this record?','gym_mgt');?>');"><i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'gym_mgt' ) ;?> </a>



																			</li>



																			<?php



																		}



																	}



																	?>



																</ul>



															</li>



														</ul>



													</div>	



												</td>



											</tr>



											<?php 



											$i++;



										}



									}?>     



								</tbody>        



							</table><!--TABLE CLASS LIST END--> 



						</div><!--TABLE REAPONSIVE DIV END--> 



					</div><!--PANEL BODY DIV END-->  



					<?php 



				}



				else



				{



					if($user_access['add']=='1')



					{



						?>



						<div class="no_data_list_div"> 



							<a href="<?php echo home_url().'?dashboard=user&page=class-schedule&tab=addclass&&action=insert';?>">



								<img class="width_100px" src="<?php echo get_option( 'gmgt_no_data_img' ) ?>" >



							</a>



							<div class="col-md-12 dashboard_btn margin_top_20px">



								<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','gym_mgt'); ?> </label>



							</div> 



						</div>      



						<?php



					}



					else



					{



						?>



						<div class="calendar-event-new margin_top_12p"> 



							<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



						</div>



						<?php



					}



				}



			} 



			if($active_tab == 'addclass')



			{



				$obj_class=new MJ_gmgt_classschedule;



				$obj_membership=new MJ_gmgt_membership;



				$class_id=0;



				if(isset($_REQUEST['class_id']))



					$class_id=$_REQUEST['class_id'];



				$edit=0;



				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')



				{



					$edit=1;



					$result = $obj_class->MJ_gmgt_get_single_class($class_id);



				} ?>

				

				<div class="panel-body"><!--PANEL BODY DIV START-->  



					<form name="group_form" action="" method="post" class="form-horizontal" id="group_form"><!-- CLASS FORM START-->



						<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>



						<input type="hidden" name="action" value="<?php echo esc_attr($action);?>">



						<input type="hidden" name="class_id" value="<?php echo esc_attr($class_id);?>" />



						



						<div class="header">	



							<h3 class="first_hed"><?php esc_html_e('Class Information','gym_mgt');?></h3>



						</div>



						<div class="form-body user_form"> <!-- user_form Strat-->   



							<div class="row"><!--Row Div Strat--> 







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="group_name" class="form-control validate[required,custom[popup_category_validation]]  text-input" type="text" maxlength="50" value="<?php if($edit){ echo esc_attr($result->class_name);}elseif(isset($_POST['class_name'])) echo esc_attr($_POST['class_name']);?>" name="class_name">



											<label class="" for="class_name"><?php esc_html_e('Class Name','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>



								<!--nonce-->



								<?php wp_nonce_field( 'save_class_nonce' ); ?>



								<!--nonce-->







								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<label class="ml-1 custom-top-label top" for="staff_name"><?php esc_html_e('Select Staff Member','gym_mgt');?><span class="require-field">*</span></label>



									<?php 



									$get_staff = array('role' => 'Staff_member');



									$staffdata=get_users($get_staff);?>



									<select name="staff_id" class="form-control validate[required] max_width_100" id="staff_id">



										<option value=""><?php esc_html_e('Select Staff Member ','gym_mgt');?></option>



										<?php



										if($edit)



										{



											$staff_data=$result->staff_id;



										}



										elseif(isset($_POST['staff_id']))



										{



											$staff_data=sanitize_text_field($_POST['staff_id']);



										}



										else



										{



											$staff_data="";



										}



										if(!empty($staffdata))



										{



											foreach($staffdata as $staff)



											{



												$role_title="";



												$postdata=get_post($staff->role_type);



												if(isset($postdata))



													$role_title=$postdata->post_title;



												



												echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).' ('.esc_html($role_title).') </option>';



											}



										}



										?>



									</select>



								</div>



								



								<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



									<label class="ml-1 custom-top-label top" for="middle_name"><?php esc_html_e('Select Assistant Staff Member','gym_mgt');?></label>



									<?php 



									$get_staff = array('role' => 'Staff_member');



									$staffdata=get_users($get_staff);?>



									<select name="asst_staff_id" class="form-control max_width_100" id="asst_staff_id">



										<option value=""><?php esc_html_e('Select Assistant Staff Member ','gym_mgt');?></option>



										<?php if($edit)



										{



											$assi_staff_data=$result->asst_staff_id;



										}



										elseif(isset($_POST['asst_staff_id']))



										{



											$assi_staff_data=sanitize_text_field($_POST['asst_staff_id']);



										}



										else



										{



											$assi_staff_data="";



										}



										if(!empty($staffdata))



										{



											foreach($staffdata as $staff)



											{



												$role_title="";



												$postdata=get_post($staff->role_type);



												if(isset($postdata))



												{



													$role_title=$postdata->post_title;



													echo '<option value='.esc_attr($staff->ID).' '.selected(esc_attr($assi_staff_data),esc_attr($staff->ID)).'>'.esc_html($staff->display_name).' ('.esc_html($role_title).')</option>';



												}



											}



										}



										?>



									</select>



								</div>







								<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_member smgt_multiple_select">



									<!-- <label class="col-sm-2 control-label form-label" for="day"><?php esc_html_e('Select Day','gym_mgt');?><span class="require-field">*</span></label> -->



									<select class="form-control validate[required]"  name="day[]" id="day"  multiple="multiple">



										<?php



										$class_days=array();



										if($edit)



										{



											$class_days=json_decode($result->day);



										}



										foreach (MJ_gmgt_days_array() as $key=>$day)



										{



											$selected = "";



											if(in_array($key,$class_days))



												$selected = "selected";



											echo '<option value="'.esc_attr($key).'"'.esc_attr($selected).'>'.esc_html($day).'</option>';



										}



										?>



									</select>



								</div>







								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="class_date"  class="form-control class_date validate[required] date_picker" type="text"  



											value="<?php if($edit){ echo MJ_gmgt_getdate_in_input_box($result->start_date);}elseif(isset($_POST['start_date'])){ echo esc_attr($_POST['start_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));}?>" name="start_date">



											<label class="date_label" for="invoice_date"><?php esc_html_e('Start Date','gym_mgt');?><span class="require-field">*</span></label>                                  



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input id="end_date"  class="form-control class_date validate[required] date_picker" type="text" value="<?php if($edit){ echo MJ_gmgt_getdate_in_input_box($result->end_date);}elseif(isset($_POST['end_date'])){ echo esc_attr($_POST['end_date']);}else{ echo MJ_gmgt_getdate_in_input_box(date("Y-m-d"));}?>" name="end_date">



											<label class="date_label" for="End"><?php esc_html_e('End Date','gym_mgt');?><span class="text-danger"> *</span></label>



										</div>



									</div>



								</div>







								<div class="rtl_margin_top_15px col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px multiselect_validation_membership smgt_multiple_select">



									<!-- <label class="col-sm-2 control-label form-label" for="day"><?php esc_html_e('Membership','gym_mgt');?><span class="require-field">*</span></label> -->



									<select class="form-control validate[required]"  name="membership_id[]" id="membership_id"  multiple="multiple">



										<?php 



										$membersdata=array();



										$data=array();



										if($edit)



										{



											$membersdata = $obj_class->MJ_gmgt_get_class_members($class_id);



											foreach($membersdata as $key=>$val)



											{



												$data[]= $val->membership_id;



											}



										}



										?>



										<?php $membershipdata=$obj_membership->MJ_gmgt_get_all_membership();?>



										<?php



										if (!empty($membershipdata)) 



										{



											foreach ($membershipdata as $membership)



											{



												$selected = "";



												if(in_array($membership->membership_id,$data))



													$selected = "selected";



												echo '<option value="'.esc_attr($membership->membership_id).'"'.esc_attr($selected).'>'.esc_html($membership->membership_label).'</option>';



											}



										}



										?>



									</select>	



								</div>



								



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">



									<div class="form-group input">



										<div class="col-md-12 form-control">



											<input  class="form-control validate[required] text-input" min="0" onkeypress="if(this.value.length==3) return false;" type="number" value="<?php if($edit){ echo esc_attr($result->member_limit);}elseif(isset($_POST['member_limit'])) echo esc_attr($_POST['member_limit']);?>" name="member_limit">



											<label class="" for="quentity"><?php esc_html_e('Member Limit','gym_mgt');?><span class="require-field">*</span></label>



										</div>



									</div>



								</div>







								<?php	



								if($edit)



								{



									?>



									<div class="mb-3 row">



										<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



											<label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label>



											<?php 



											if($edit)



											{



												$start_time_data = explode(":", $result->start_time);



											



											}



											?>



											<select name="start_time" class="form-control validate[required]">



												<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



												<?php 



													for($i =1 ; $i <= 12 ; $i++)



													{



													?>



														<option value="<?php echo esc_attr($i);?>" <?php  if($edit) selected(esc_attr($start_time_data[0]),esc_attr($i));  ?>><?php echo esc_html($i);?></option>



														<?php



													}



													?>



											</select>



										</div>



										<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



											<select name="start_min" class="form-control validate[required]">



												<?php 



												foreach(MJ_gmgt_minute_array() as $key=>$value)



												{?>



													<option value="<?php echo esc_attr($key);?>" <?php  if($edit) selected(esc_attr($start_time_data[1]),esc_attr($key));  ?>><?php echo esc_html($value);?></option>



												<?php



												}



												?>



											</select>



										</div>



										<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



											<select name="start_ampm" class="form-control validate[required]">



												<option value="am" <?php  if($edit) if(isset($start_time_data[2])) selected(esc_attr($start_time_data[2]),'am');  ?>><?php esc_html_e('am','gym_mgt');?></option>



												<option value="pm" <?php  if($edit) if(isset($start_time_data[2])) selected(esc_attr($start_time_data[2]),'pm');  ?>><?php esc_html_e('pm','gym_mgt');?></option>



											</select>



										</div>



									</div>



									<div class="mb-3 row">



										<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



											<label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label>



											<?php 



											if($edit)



											{



												$end_time_data = explode(":", $result->end_time);



											}



											?>



											<select name="end_time" class="form-control validate[required]">



												<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



												<?php 



													for($i =1 ; $i <= 12 ; $i++)



													{



													?>



														<option value="<?php echo esc_attr($i);?>" <?php  if($edit) selected(esc_attr($end_time_data[0]),esc_attr($i));  ?>><?php echo esc_html($i);?></option>



													<?php



													}



												?>



											</select>



										</div>



										<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">



											<select name="end_min" class="form-control validate[required]">



												<?php 



												foreach(MJ_gmgt_minute_array() as $key=>$value)



												{



												?>



													<option value="<?php echo esc_attr($key);?>" <?php  if($edit) selected(esc_attr($end_time_data[1]),esc_attr($key));  ?>><?php echo esc_html($value);?></option>



												<?php



												}



												?>



											</select>



										</div>



										<div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 input">	



											<select name="end_ampm" class="form-control validate[required]">				



												<option value="am" <?php  if($edit) if(isset($end_time_data[2])) selected(esc_attr($end_time_data[2]),'am'); ?>><?php esc_html_e('am','gym_mgt');?></option>



												<option value="pm" <?php  if($edit) if(isset($end_time_data[2])) selected(esc_attr($end_time_data[2]),'pm');  ?>><?php esc_html_e('pm','gym_mgt');?></option>	



											</select>



										</div>	



									</div>	



									<?php



								}



								else



								{



									?>



										<div class="add_more_time_entry">



											<div class="time_entry">



												<div class="mb-3 row">



													<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



														<label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label>



														<select name="start_time[]" class="form-control validate[required] max_width_100">



															<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



																<?php 



																for($i =1 ; $i <= 12 ; $i++)



																{



																?>



																	<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>



																<?php



																}



																?>



														</select>



													</div>



													<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input">



														<select name="start_min[]" class="form-control validate[required] margin_top_10_res">



															<?php 



															foreach(MJ_gmgt_minute_array() as $key=>$value)



															{?>



																<option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option>



															<?php



															}



															?>



														</select>



													</div>



													<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input">



														<select name="start_ampm[]" class="form-control validate[required] margin_top_10_res">



															<option value="am"><?php esc_html_e('am','gym_mgt');?></option>



															<option value="pm"><?php esc_html_e('pm','gym_mgt');?></option>



														</select>



													</div>



												</div>



												



												<div class="mb-3 row">



													<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input">



														<label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label>



														<select name="end_time[]" class="form-control validate[required]">



															<option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>



																<?php 



																	for($i =1 ; $i <= 12 ; $i++)



																	{



																	?>



																		<option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option>



																	<?php



																	}



																?>



														</select>



													</div>



													<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input">



														<select name="end_min[]" class="form-control validate[required] margin_top_10_res">



															<?php 



															foreach(MJ_gmgt_minute_array() as $key=>$value)



															{



															?>



																<option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option>



															<?php



															}



															?>



														</select>



													</div>



													<div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input">	



														<select name="end_ampm[]" class="form-control validate[required] margin_top_10_res">



															<option value="am"><?php esc_html_e('am','gym_mgt');?></option>



															<option value="pm"><?php esc_html_e('pm','gym_mgt');?></option>



														</select>



													</div>	



													<div class="col-md-1 symptoms_deopdown_div mb-3 rtl_margin_top_15px">



														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>"  id="add_new_entry" onclick="add_entry()" alt="" name="add_new_entry" class="daye_name_onclickr">



													</div>



												</div>



												<hr>



												<!-- <div class="mb-3 row">



													<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 input">



														<hr>



													</div>



												</div> -->



											</div>



										</div>







									<?php



								}



								?>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 res_margin_bottom_20px">



									<div class="form-group">



										<div class="col-md-12 form-control input_color_height">



											<div class="">



												<label class="custom-top-label" for="quentity"><?php esc_html_e('Class Color','gym_mgt');?></label>



												<input type="color" value="<?php if($edit){ echo esc_attr($result->color);}elseif(isset($_POST['class_color'])) echo esc_attr($_POST['class_color']);?>" name="class_color" >



											</div>



										</div>



									</div>



								</div>



								<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">



									<div class="form-group">



										<div class="col-md-12 form-control">



											<div class="row padding_radio">



												<div class="">



													<label class="custom-top-label" for="gmgt_membershipimage"><?php esc_html_e('Frontend Class Booking','gym_mgt');?></label>



													<input type="checkbox" name="gmgt_class_book_approve" class="check_box_input_margin" value="yes" <?php if($edit){ if($result->gmgt_class_book_approve == 'yes') { echo 'checked'; } }?> /> <?php esc_html_e('Enable','gym_mgt'); ?>



												</div>



											</div>



										</div>



									</div>



								</div>







							</div><!--Row Div End--> 



						</div><!-- user_form End-->   



						<div class="form-body user_form">



							<div class="row">



								<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><!--save btn--> 



									<input type="submit" value="<?php if($edit){ esc_html_e('Save','gym_mgt'); }else{ esc_html_e('Save','gym_mgt');}?>" name="save_class" class="btn save_btn day_validation_submit"/>



								</div>



							</div><!--Row Div End--> 



						</div><!-- user_form End-->



					</form><!-- CLASS FORM END-->



				</div><!--PANEL BODY DIV END--> 



				<script>



				$(document).ready(function() 



				{



					"use strict";



					var date = new Date();



					date.setDate(date.getDate()-0);



					$.datepicker.setDefaults($.datepicker.regional['<?php echo MJ_gmgt_get_current_lan_code(); ?>']);



					$('.class_date').datepicker({



					dateFormat:' <?php echo get_option('gmgt_datepicker_format'); ?>',



					minDate:'today',



					startDate: date,



					autoclose: true



				});



				} );



				function add_entry()



				{



					$(".add_more_time_entry").append('<div class="time_entry"><div class="form-group"><div class="mb-3 row"><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><label class="ml-1 custom-top-label top" for="starttime"><?php esc_html_e('Start Time','gym_mgt');?><span class="require-field">*</span></label><select name="start_time[]" class="form-control validate[required] max_width_100"><option value=""><?php esc_html_e('Select Time','gym_mgt');?></option>  <?php for($i =0 ; $i <= 12 ; $i++) { ?> <option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option> <?php } ?></select></div><div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input"><select name="start_min[]" class="form-control validate[required] margin_top_10_res"> <?php foreach(MJ_gmgt_minute_array() as $key=>$value){ ?> <option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option><?php }?></select></div><div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input"><select name="start_ampm[]" class="form-control validate[required] margin_top_10_res"><option value="am"><?php esc_html_e('am','gym_mgt');?></option><option value="pm"><?php esc_html_e('pm','gym_mgt');?></option></select></div></div></div><div class="form-group"><div class="mb-3 row"><div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 input"><label class="ml-1 custom-top-label top" for="weekday"><?php esc_html_e('End Time','gym_mgt');?><span class="require-field">*</span></label><select name="end_time[]" class="form-control validate[required]"><option value=""><?php esc_html_e('Select Time','gym_mgt');?></option> <?php for($i =0 ; $i <= 12 ; $i++){ ?><option value="<?php echo esc_attr($i);?>"><?php echo esc_html($i);?></option><?php } ?></select></div><div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input"><select name="end_min[]" class="form-control validate[required] margin_top_10_res"><?php foreach(MJ_gmgt_minute_array() as $key=>$value) { ?><option value="<?php echo esc_attr($key);?>"><?php echo esc_html($value);?></option><?php } ?></select></div><div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 input"><select name="end_ampm[]" class="form-control validate[required] margin_top_10_res"><option value="am"><?php esc_html_e('am','gym_mgt');?></option><option value="pm"><?php esc_html_e('pm','gym_mgt');?></option></select></div><div class="col-sm-1 symptoms_deopdown_div rtl_margin_top_15px"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" onclick="deleteParentElement(this)" alt=""> </div></div><hr></div></div>');			



				}



				// REMOVING INVOICE ENTRY



				function deleteParentElement(n)



				{



					alert("<?php esc_html_e('Do you really want to delete this time Slots?','gym_mgt');?>");



					n.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode.parentNode.parentNode);



				}



				</script> 



				<?php



			}



			if($active_tab == 'schedulelist')



			{ 	



				$obj_virtual_classroom = new MJ_gmgt_virtual_classroom;



				?>



				<div class="popup-bg z_index_100000">



					<div class="overlay-content">



						<div class="modal-content">



						<div class="create_meeting_popup"></div>



						</div>



					</div> 



				</div>







				<div class="panel-body padding_0 class_border_div gmgt_schedule_table rtl_margin_top_15px"><!--PANEL BODY DIV START--> 



					<table class="table table-bordered"><!--CLASS SCHEDULE TABLE START--> 



						<?php        



						foreach(MJ_gmgt_days_array() as $daykey => $dayname)



						{



							?>



							<tr>



								<th width="100"><?php echo esc_html($dayname);?></th>



								<td>



									<?php



									$period = $obj_class->MJ_gmgt_get_schedule_byday($daykey);



									if(!empty($period))



										foreach($period as $period_data)



										{



											if(!empty($period_data))



											{						



												if($obj_gym->role=='staff_member')



												{



													if($user_access['own_data']=='1')



													{



														if($period_data['staff_id']==$curr_user_id || $period_data['asst_staff_id']==$curr_user_id)



														{



														echo '<div class="btn-group m-b-sm dropdownschedulelist_new">';



														echo '<button id="dropdownschedulelist" data-toggle="dropdown"  class="btn btn-primary class_list_button dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" ><span class="period_box" id='.$period_data['class_id'].'>'.MJ_gmgt_get_single_class_name($period_data['class_id']);



														echo '<span class="time"> ('.MJ_gmgt_timeremovecolonbefoream_pm($period_data['start_time']).'- '.MJ_gmgt_timeremovecolonbefoream_pm($period_data['end_time']).') </span>';



														echo '</span></span><span class="caret"></span></button>';



														echo '<ul role="menu" class="dropdown-menu" aria-labelledby="dropdownschedulelist">';



														if($user_access['edit']=='1')



														{



															if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



															{



															echo '<li>



																<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&page_action=web_view_hide&class_list_app=classlist_app&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a>



																</li>';



															}



															else



															{



																echo '<li>



																<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a>



																</li>';



															}



														}



														if($user_access['delete']=='1')



														{	



															if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



															{



																echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&page_action=web_view_hide&class_list_app=classlist_app&class_id='.$period_data['class_id'].'" onclick="return confirm(\''.esc_html__( 'Are you sure, you want to delete?', 'gym_mgt' ).'\');">'.esc_html__('Delete','gym_mgt').'</a></li>';



															}																																														



															else



															{



																echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\''.esc_html__( 'Are you sure, you want to delete?', 'gym_mgt' ).'\');">'.esc_html__('Delete','gym_mgt').'</a></li>';



															}		



															//echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\'Are you sure, you want to delete?\')">'.esc_html__('Delete','gym_mgt').'</a></li>';



														}



														$virtual_classroom_page_name = 'virtual_class';



														$virtual_classroom_access_right = MJ_gmgt_get_userrole_wise_manually_page_access_right_array($virtual_classroom_page_name);	



														if (get_option('gmgt_enable_virtual_classschedule') == 'yes')



														{



															if($virtual_classroom_access_right['add']=='1')



															{	



																$meeting_data = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_by_class_data_in_zoom($period_data['class_id']);



																if(empty($meeting_data))



																{



																	echo '<li><a href="#" id="'.$period_data['class_id'].'" class="show-popup">'.esc_html__('Create Virtual Class','gym_mgt').'</a></li>';



																}



																else



																{



																	$create_meeting = '';



																}







																if(!empty($meeting_data))



																{



																	if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



																	{



																		echo  '<li><a href="?dashboard=user&page=virtual_class&tab=edit_meeting&action=edit&page_action=web_view_hide&class_list_app=classlist_app&meeting_id='.$meeting_data->meeting_id.'">'.esc_html__('Edit Virtual Class','gym_mgt').'</a></li>';



																		echo '<li><a href="?dashboard=user&page=virtual_class&tab=meeting_list&action=delete&page_action=web_view_hide&class_list_app=classlist_app&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.esc_html__( 'Are you sure you want to delete this record?', 'gym_mgt' ).'\');">'.esc_html__('Delete Virtual Class','gym_mgt').'</a></li>';



																	}	



																	else



																	{



																		echo  '<li><a href="?dashboard=user&page=virtual_class&tab=edit_meeting&action=edit&meeting_id='.$meeting_data->meeting_id.'">'.esc_html__('Edit Virtual Class','gym_mgt').'</a></li>';



																		echo '<li><a href="?dashboard=user&page=virtual_class&tab=meeting_list&action=delete&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.esc_html__( 'Are you sure you want to delete this record?', 'gym_mgt' ).'\');">'.esc_html__('Delete Virtual Class','gym_mgt').'</a></li>';



																	}



																	echo '<li><a href="'.$meeting_data->meeting_start_link.'" target="_blank">'.esc_html__('Virtual Class Start','gym_mgt').'</a></li>';



																}



																else



																{



																	$update_meeting = '';



																	$delete_meeting = '';



																	$meeting_statrt_link = '';



																}



															}	



														}



														echo '</ul>';



														echo '</div>';



														}



													}



													else



													{



														



														echo '<div class="btn-group m-b-sm dropdownschedulelist_new">';



														echo '<button id="dropdownschedulelist" data-toggle="dropdown"  class="btn btn-primary class_list_button  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" ><span class="period_box" id='.$period_data['class_id'].'>'.MJ_gmgt_get_single_class_name($period_data['class_id']);



														echo '<span class="time"> ('.MJ_gmgt_timeremovecolonbefoream_pm($period_data['start_time']).'- '.MJ_gmgt_timeremovecolonbefoream_pm($period_data['end_time']).') </span>';



														echo '</span></span><span class="caret"></span></button>';



														echo '<ul role="menu" class="dropdown-menu" aria-labelledby="dropdownschedulelist">';



														if($user_access['edit']=='1')



														{



															if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



															{



															echo '<li>



																<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&page_action=web_view_hide&class_list_app=classlist_app&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a>



																</li>';



															}



															else



															{



																echo '<li>



																<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a>



																</li>';



															}



															/* echo '<li>



																<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a>



																</li>'; */



														}



														if($user_access['delete']=='1')



														{		



															if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



															{



																echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&page_action=web_view_hide&class_list_app=classlist_app&class_id='.$period_data['class_id'].'" onclick="return confirm(\''.esc_html__( 'Are you sure, you want to delete?', 'gym_mgt' ).'\');">'.esc_html__('Delete','gym_mgt').'</a></li>';



															}



															else



															{



																echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\''.esc_html__( 'Are you sure, you want to delete?', 'gym_mgt' ).'\');">'.esc_html__('Delete','gym_mgt').'</a></li>';



															}	



														}	



														$virtual_classroom_page_name = 'virtual_class';



														$virtual_classroom_access_right = MJ_gmgt_get_userrole_wise_manually_page_access_right_array($virtual_classroom_page_name);	



														if (get_option('gmgt_enable_virtual_classschedule') == 'yes')



														{



															if(isset($virtual_classroom_access_right['add']) && $virtual_classroom_access_right['add'] =='1')



															{



																$meeting_data = $obj_virtual_classroom->MJ_gmgt_get_singal_meeting_by_class_data_in_zoom($period_data['class_id']);



																if(empty($meeting_data))



																{



																	echo '<li><a href="#" id="'.$period_data['class_id'].'" class="show-popup">'.esc_html__('Create Virtual Class','gym_mgt').'</a></li>';



																}



																else



																{



																	$create_meeting = '';



																}







																if(!empty($meeting_data))



																{/* 



																	echo  '<li><a href="?dashboard=user&page=virtual_class&tab=edit_meeting&action=edit&meeting_id='.$meeting_data->meeting_id.'">'.esc_html__('Edit Virtual Class','gym_mgt').'</a></li>';



																	echo '<li><a href="?dashboard=user&page=virtual_class&tab=meeting_list&action=delete&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.esc_html__( 'Are you sure you want to delete this record?', 'gym_mgt' ).'\');">'.esc_html__('Delete Virtual Class','gym_mgt').'</a></li>'; */



																	if(isset($_REQUEST['class_list_app']) && $_REQUEST['class_list_app'] == 'classlist_app')



																	{



																		echo  '<li><a href="?dashboard=user&page=virtual_class&tab=edit_meeting&action=edit&page_action=web_view_hide&class_list_app=classlist_app&meeting_id='.$meeting_data->meeting_id.'">'.esc_html__('Edit Virtual Class','gym_mgt').'</a></li>';



																		echo '<li><a href="?dashboard=user&page=virtual_class&tab=meeting_list&action=delete&page_action=web_view_hide&class_list_app=classlist_app&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.esc_html__( 'Are you sure you want to delete this record?', 'gym_mgt' ).'\');">'.esc_html__('Delete Virtual Class','gym_mgt').'</a></li>';



																	}	



																	else



																	{



																		echo  '<li><a href="?dashboard=user&page=virtual_class&tab=edit_meeting&action=edit&meeting_id='.$meeting_data->meeting_id.'">'.esc_html__('Edit Virtual Class','gym_mgt').'</a></li>';



																		echo '<li><a href="?dashboard=user&page=virtual_class&tab=meeting_list&action=delete&meeting_id='.$meeting_data->meeting_id.'" onclick="return confirm(\''.esc_html__( 'Are you sure you want to delete this record?', 'gym_mgt' ).'\');">'.esc_html__('Delete Virtual Class','gym_mgt').'</a></li>';



																	}



																	echo '<li><a href="'.$meeting_data->meeting_start_link.'" target="_blank">'.esc_html__('Virtual Class Start','gym_mgt').'</a></li>';



																}



																else



																{



																	$update_meeting = '';



																	$delete_meeting = '';



																	$meeting_statrt_link = '';



																}



															}	



														}



														echo '</ul>';



														echo '</div>';



													}		



												}



												elseif($obj_gym->role == 'member')



												{			



													if(is_array($cur_user_class_id))	



													{								



														if(in_array($period_data['class_id'],$cur_user_class_id))



														{



															echo '<div class="btn-group m-b-sm dropdownschedulelist_new">';



															echo '<button id="dropdownschedulelist" data-toggle="dropdown"  class="btn btn-primary class_list_button  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" ><span class="period_box" id='.$period_data['class_id'].'>'.MJ_gmgt_get_single_class_name($period_data['class_id']);



															echo '<span class="time"> ('.MJ_gmgt_timeremovecolonbefoream_pm($period_data['start_time']).'- '.MJ_gmgt_timeremovecolonbefoream_pm($period_data['end_time']).') </span>';



															if( MJ_gmgt_get_membership_class_status(get_user_meta(get_current_user_id(),'membership_id',true))=='limited')



															{



																echo '</span></span><span class="caret"></span></button>';



																echo '<ul role="menu" class="dropdown-menu" aria-labelledby="dropdownschedulelist">



																	<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=book&class_id='.$period_data['class_id'].'&dayname='.$dayname.'">'.esc_html__('Book','gym_mgt').'</a></li>';



																	if($user_access['edit']=='1')



																	{



																		echo '<li>



																			<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a>



																			</li>';



																	}



																	if($user_access['delete']=='1')



																	{		



																		echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\''.esc_html__( 'Are you sure, you want to delete?', 'gym_mgt' ).'\');">'.esc_html__('Delete','gym_mgt').'</a></li>';



																	}	



																	echo  '</ul>';



																	echo '</div>';



															}



														}	



													}											



												}



												else



												{		



													if($user_access['own_data']=='1')



													{													



														if($period_data['class_created_id'] == $curr_user_id)		



														{



															echo '<div class="btn-group m-b-sm dropdownschedulelist_new">';



															echo '<button id="dropdownschedulelist" data-toggle="dropdown"  class="btn btn-primary class_list_button  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" ><span class="period_box" id='.$period_data['class_id'].'>'.MJ_gmgt_get_single_class_name($period_data['class_id']);



															echo '<span class="time"> ('.MJ_gmgt_timeremovecolonbefoream_pm($period_data['start_time']).'- '.MJ_gmgt_timeremovecolonbefoream_pm($period_data['end_time']).') </span>';



															



															echo '</span></span><span class="caret"></span></button>';



															echo '<ul role="menu" class="dropdown-menu" aria-labelledby="dropdownschedulelist">';



															if($user_access['edit']=='1')



															{



																echo '<li>



																	<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a>



																	</li>';



															}



															if($user_access['delete']=='1')



															{		



																echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\''.esc_html__( 'Are you sure, you want to delete?', 'gym_mgt' ).'\');">'.esc_html__('Delete','gym_mgt').'</a></li>';



															}	



																echo '</ul>';



															echo '</div>';	



														}												



													}



													else



													{



														echo '<div class="btn-group m-b-sm dropdownschedulelist_new">';



														echo '<button id="dropdownschedulelist" data-toggle="dropdown"  class="btn btn-primary class_list_button dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" ><span class="period_box" id='.$period_data['class_id'].'>'.MJ_gmgt_get_single_class_name($period_data['class_id']);



														echo '<span class="time"> ('.MJ_gmgt_timeremovecolonbefoream_pm($period_data['start_time']).'- '.MJ_gmgt_timeremovecolonbefoream_pm($period_data['end_time']).') </span>';



														echo '</span></span><span class="caret"></span></button>';



														if($user_access['edit']=='1' || $user_access['delete']=='1')



														{



															echo '<ul role="menu" class="dropdown-menu" aria-labelledby="dropdownschedulelist">';



															if($user_access['edit']=='1')



															{



																echo '<li>



																	<a href="?dashboard=user&page=class-schedule&tab=addclass&action=edit&class_id='.$period_data['class_id'].'">'.esc_html__('Edit','gym_mgt').'</a>



																	</li>';



															}



															if($user_access['delete']=='1')



															{		



																echo '<li><a href="?dashboard=user&page=class-schedule&tab=schedulelist&action=delete&class_id='.$period_data['class_id'].'" onclick="return confirm(\''.esc_html__( 'Are you sure, you want to delete?', 'gym_mgt' ).'\');">'.esc_html__('Delete','gym_mgt').'</a></li>';



															}																																																						



															echo '</ul>';

														}



														echo '</div>';



													}	



												}		



											}						



										}



									?>



								</td>



							</tr>



							<?php	



						}



					?>



					</table><!--CLASS SCHEDULE TABLE END--> 



				</div><!--PANEL BODY DIV END-->   



				<?php



			}



			if($active_tab == 'guest_list')



			{



				$obj_guest_booking = new MJ_gmgt_guest_booking;



				$guestbookingdata=$obj_guest_booking->MJ_gmgt_get_all_guest_booking();



				if(!empty($guestbookingdata))



				{



					?>



					<div class="popup-bg">



						<div class="overlay-content">



							<div class="modal-content">



								<div class="category_list"></div>	



							</div>



						</div> 



					</div>



					<!-- End POP-UP Code -->



					<script type="text/javascript">



						$(document).ready(function() 



						{



							"use strict";



							jQuery('#booking_list113').DataTable({



								// "responsive": true,



								dom: 'lifrtp',



								//"order": [[ 2, "desc" ]],



								



								"aoColumns":[



											{"bSortable": false},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											{"bSortable": true},



											],



									language:<?php echo MJ_gmgt_datatable_multi_language();?> 



								});



								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'gym_mgt') ?>");



						});



					</script>



					<form name="wcwm_report" action="" method="post">



						<div class="panel-body padding_0"> <!-- PANEL BODY DIV START-->



							<div class="table-responsive"> <!-- TABLE RESPONSIVE DIV START-->



								<table id="booking_list113" class="display booking_list" cellspacing="0" width="100%"> <!-- Booking LIST TABEL START-->



									<thead class="<?php echo MJ_gmgt_datatable_heder(); ?>">



										<tr>



										<th><?php esc_html_e('Photo','gym_mgt');?></th>



											<th><?php esc_html_e('Guest Name','gym_mgt');?></th>



											<th><?php esc_html_e('Email','gym_mgt');?></th>



											<th><?php esc_html_e('Phone','gym_mgt');?></th>



											<th><?php esc_html_e('Booking Date','gym_mgt');?></th>



											



										</tr>



									</thead>

									<tbody>



									<?php 



									



									if(!empty($guestbookingdata))



									{



										$i=0;



										foreach ($guestbookingdata as $retrieved_data)



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



														<img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class Schedule.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">



													</p>



												</td>



												<td class="membername">



													<a href="#"><?php echo esc_html($retrieved_data->first_name).' '.esc_html($retrieved_data->last_name);?></a>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Guest Name','gym_mgt');?>" ></i>



												</td>



												<td class="emailid">



													<?php echo esc_html($retrieved_data->email_id);  ?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Email Id','gym_mgt');?>" ></i>



												</td>



												<td class="phonenumber">



													<?php echo esc_html($retrieved_data->phone_number); ?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Phone','gym_mgt');?>" ></i>



												</td>



												<td class="date">



													<?php echo esc_html($retrieved_data->created_date); ?>



													<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Booking Date','gym_mgt');?>" ></i>



												</td>



											</tr>



											<?php 



											$i++;



										} 



									}?>     



									</tbody>        



								</table><!-- Booking LIST TABEL END-->



								



							</div><!-- TABLE RESPONSIVE DIV END-->



						</div><!-- PANEL BODY DIV END-->



					</form><!-- CLASS LIST FORM END-->



					<?php



				}



				else



				{



					?>



					<div class="calendar-event-new margin_top_12p"> 



						<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >



					</div>



					<?php



				}



			}



			



			?>



		</div><!--TAB CONTENT DIV END-->   



	</div><!--MAIN_LIST_MARGING_15px END  -->



</div><!--PANEL BODY DIV END-->   