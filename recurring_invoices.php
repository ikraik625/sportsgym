<?php
//--------- UPDATE PLUGIN PATH -------//
//require_once("public_html/wp-load.php");
$root = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($root.'/wp-load.php')) 
{
require_once($root.'/wp-load.php');
} 
else 
{
  require_once($root.'/wp-config.php');
}
MJ_gmgt_menual_create_invoices_for_recurring_membership();
MJ_gmgt_check_unpaid_invoices();
?>