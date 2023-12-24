<?php 

$obj_gym = new MJ_gmgt_Gym_management(get_current_user_id());

$obj_message= new MJ_gmgt_message;

$active_tab = isset($_GET['tab'])?$_GET['tab']:'inbox';

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

			if($user_access['delete']=='0')

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

?>

<div class="panel-body panel-white padding_0"><!--PANEL BODY DIV START-->   

	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->

		<ul class="nav nav-tabs panel_tabs mb-3" role="tablist"><!--NAV TABS MENU START-->      

			<?php

			if(isset($_REQUEST['message_list_app_view']) && $_REQUEST['message_list_app_view'] == 'messagelist_app')

			{

				?>

				

					<li <?php if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox')){?>class="active"<?php }?>>

						<a href="?dashboard=user&page=message&tab=inbox&page_action=web_view_hide&message_list_app_view=messagelist_app">

							<?php esc_html_e("Inbox","gym_mgt");?> 

							<span class="gmgt_inbox_count_number badge font_weight_700 badge-success pull-right">

							<?php echo MJ_gmgt_count_unread_message(get_current_user_id());?></span>

						</a>

					</li> 							

					<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox'){?>class="active"<?php }?>><a href="?dashboard=user&page=message&tab=sentbox&page_action=web_view_hide&message_list_app_view=messagelist_app"><?php esc_html_e("Sent","gym_mgt");?></a></li>					   

				

				<?php

			}

			else

			{

				?>

					<li <?php if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox')){?>class="active"<?php }?>>

						<a href="?dashboard=user&page=message&tab=inbox" class="gmgt_inbox_tab">

							<?php esc_html_e("Inbox","gym_mgt");?> 

							<span class="gmgt_inbox_count_number badge font_weight_700 badge-success pull-right">

							<?php echo MJ_gmgt_count_unread_message(get_current_user_id());?></span>

						</a>

					</li> 							

					<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox'){?>class="active"<?php }?>><a href="?dashboard=user&page=message&tab=sentbox"><?php esc_html_e("Sent","gym_mgt");?></a></li>					   

				<?php

			}

			if($user_access['add']=='1')

			{

				if(isset($_REQUEST['message_list_app_view']) && $_REQUEST['message_list_app_view'] == 'messagelist_app')

				{

					?>	

					<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'compose'){?>class="active"<?php }?>>

						<a href="?dashboard=user&page=message&tab=compose&page_action=web_view_hide&message_list_app_view=messagelist_app" class="padding_left_0 tab"><?php esc_attr_e('Compose','gym_mgt');?></a>

					</li>	     	

					<?php

				}

				else

				{

					?>	

					<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'compose'){?>class="active"<?php }?>>

						<a href="?dashboard=user&page=message&tab=compose" class="padding_left_0 tab"><?php esc_attr_e('Compose','gym_mgt');?></a>

					</li>	      	

					<?php

				}

			}

			?>

		</ul><!--NAV TABS MENU END-->   



			<?php  

			if($active_tab == 'sentbox')

				require_once GMS_PLUGIN_DIR. '/template/message/sendbox.php';

			if($active_tab == 'inbox')

				require_once GMS_PLUGIN_DIR. '/template/message/inbox.php';

			if($active_tab == 'compose')

				require_once GMS_PLUGIN_DIR. '/template/message/composemail.php';

			if($active_tab == 'view_message')

				require_once GMS_PLUGIN_DIR. '/template/message/view_message.php';

			?>

		

	</div><!--MAIN_LIST_MARGING_15px END  -->

</div><!--PANEL BODY DIV END--> 