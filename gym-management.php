<?php

/*
Plugin Name: WPGYM - Gym management system



Plugin URI: https://mojoomla.com/



Description: WPGYM - Gym management system Plugin for wordpress is ideal way to manage complete gym. 



The system has different access rights for Admin, Staff Members, Accountant and Members.



Version: 63.0 (11-11-2023)



Author URI: https://codecanyon.net/search/mojoomla



Text Domain: gym_mgt



Domain Path: /languages/



License: GPLv2 or later



License URI: http://www.gnu.org/licenses/gpl-2.0.html



Copyright 2023 Mojoomla  (email : sales@mojoomla.com)



*/



define( 'GMS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );



define( 'GMS_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );



define( 'GMS_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );



define( 'GMS_CONTENT_URL',  content_url( ));



define( 'GMS_HOME_URL',  home_url( ));



define( 'WPNC_Login_LOG_DIR',  WP_CONTENT_DIR.'/uploads/logs/');
define( 'WPNC_Login_LOG_file', WPNC_Login_LOG_DIR.'/login_logs.txt' );
require_once GMS_PLUGIN_DIR . '/settings.php';
if (isset($_REQUEST['page']))

{

	if($_REQUEST['page'] == 'callback')

	{

	   require_once GMS_PLUGIN_DIR. '/callback.php';

	}

	if($_REQUEST['page'] == 'webhooks')

	{

		require_once GMS_PLUGIN_DIR. '/webhooks.php';

	}

}
?>