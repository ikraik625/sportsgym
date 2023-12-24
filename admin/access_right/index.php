<?php 
$active_tab = isset($_GET['tab'])?$_GET['tab']:'member';
?>
<!-- View Popup Code START-->	
<div class="popup-bg">
    <div class="overlay-content">
    	<div class="notice_content"></div>    
    </div> 
</div>	
<!-- View Popup Code END-->
<div class="page-inner min_height_1631 min_height_1200px_res"><!-- PAGE INNNER DIV START-->
	<div class="gms_main_list"><!-- MAIN_LIST_MARGING_15px START -->
		<div class="row notice_page"><!-- ROW DIV START-->
			<div class="col-md-12 padding_0"><!-- COL 12 DIV START-->
				<div class="panel-body "><!-- PANEL BODY DIV START-->
					<ul class="nav nav-tabs panel_tabs margin_left_1per mb-3" role="tablist"><!-- NAV TAB WRAPPER MENU START-->
						<li class="<?php if($active_tab=='member'){?>active<?php }?>">
							<a href="?page=gmgt_access_right&tab=member" class="padding_left_0 tab <?php echo $active_tab == 'member' ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Member', 'gym_mgt'); ?></a>
						</li>
						<li class="<?php if($active_tab=='staff_member'){?>active<?php }?>">
							<a href="?page=gmgt_access_right&tab=staff_member" class="padding_left_0 tab <?php echo $active_tab == 'staff_member' ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Staff Member', 'gym_mgt'); ?></a>
						</li>
						<li class="<?php if($active_tab=='accountant'){?>active<?php }?>">
							<a href="?page=gmgt_access_right&tab=accountant" class="padding_left_0 tab <?php echo $active_tab == 'accountant' ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Accountant', 'gym_mgt'); ?></a>
						</li>
						<li class="<?php if($active_tab=='management'){?>active<?php }?>">
							<a href="?page=gmgt_access_right&tab=management" class="padding_left_0 tab <?php echo $active_tab == 'management' ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Management', 'gym_mgt'); ?></a>
						</li>
					</ul><!-- NAV TAB WRAPPER MENU END-->
					<?php
					if($active_tab == 'member')
					{
						require_once GMS_PLUGIN_DIR. '/admin/access_right/member.php';
					}	 
					elseif($active_tab == 'staff_member')
					{
						require_once GMS_PLUGIN_DIR. '/admin/access_right/staff_member.php';
					}	 
					elseif($active_tab == 'accountant')
					{
						require_once GMS_PLUGIN_DIR. '/admin/access_right/accountant.php';
					}
					elseif($active_tab == 'management')
					{
						require_once GMS_PLUGIN_DIR. '/admin/access_right/management.php';
					}				
					?>
				</div><!-- PANEL BODY DIV END-->
			</div><!-- COL 12 DIV END-->
		</div><!-- ROW DIV END-->
	</div><!--MAIN_LIST_MARGING_15px END  -->
</div><!-- PAGE INNNER DIV END-->