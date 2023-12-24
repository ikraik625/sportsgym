<?php

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if(is_plugin_active('gym-management/gym-management.php'))

{
	
	$currency =  get_option('gmgt_currency_code');

	$fornt_end = "";

	if(isset($_POST['where_payment']))

	{

		$fornt_end = $_POST['where_payment'];

	}
	$coupon_id = $_REQUEST['coupon_id'];
	$pay_id = $_SESSION['mp_id'] = $_REQUEST['mp_id'];
	if(isset($_REQUEST['view_type']) && $_REQUEST['view_type'] == 'renew_upgrade_membership_plan')
	{
	   $amount = $_SESSION['amount']=$_REQUEST['total_amount'];
	}
	else
	{
		$amount = $_SESSION['amount']=$_REQUEST['amount'];
	}
	$data_user =$_REQUEST['member_id'];

	if(isset($_REQUEST['stripe_plan_id']))
	{
		$stripe_plan_id = $_SESSION['stripe_plan_id'] = $_REQUEST['stripe_plan_id'];

	}
	else{
		$stripe_plan_id = '';
	}
	$system_name =  get_option('gmgt_system_name');	

	$system_logo =  get_option('gmgt_gym_other_data_logo');

	if(isset($_POST['view_type']))

	{

		if($_POST['view_type'] == 'sale_payment')

		{

			$description = "Sales Payment";

			$payment_type = "Sales_Payment";

		}

		elseif($_POST['view_type'] == 'income')

		{

			$description = "Income Payment";

			$payment_type = "Income_Payment";

		}

		elseif($_POST['view_type'] == 'renew_upgrade_membership_plan')

		{

			$description = "Membership Payment";

			$payment_type = "Membership_Payment";

			$fornt_end = 'renew_upgrade_membership_plan';

		}

		else

		{

			$description = "Membership Payment";

			$payment_type = "Membership_Payment";

		}

	}

	else

	{

		$description = "Membership Payment";

		$payment_type = "Membership_Payment";

	}

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book')

	{

		$frontend_class_action=$_REQUEST['action'];

		$class_id1=$_REQUEST['class_id1'];

		$day_id1=$_REQUEST['day_id1'];

		$startTime_1=$_REQUEST['startTime_1'];

		$class_date=$_REQUEST['class_date'];

		$Remaining_Member_limit_1=$_REQUEST['Remaining_Member_limit_1'];

	}

}

$secret_key=get_option('gmgt_stripe_secret_key');

$publisable_key=get_option('gmgt_stripe_publishable_key');

?>

<form action="<?php print GMS_PLUGIN_URL.'/lib/stripe/charge.php'; ?>" method="POST"> 

	<input type="hidden" name="amount" value="<?php print $amount ?>">

	<input type="hidden" name="pay_id" value="<?php print $pay_id ?>">

	<input type="hidden" name="coupon_id" value="<?php print $coupon_id ?>">

	<input type="hidden" name="stripe_plan_id" value="<?php print $stripe_plan_id ?>">

	<input type="hidden" name="where_payment" value="<?php print isset($fornt_end)?$fornt_end:'' ?>">

	<input type="hidden" name="secret_key" value="<?php print $secret_key ?>">

	<input type="hidden" name="payment_type" value="<?php print $payment_type ?>">

	<input type="hidden" name="data_user" value="<?php print $data_user ?>">

	<?php

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='frontend_book')

	{

	?>

	<input type="hidden" name="frontend_class_action" value="<?php print $frontend_class_action ?>">

	<input type="hidden" name="class_id1" value="<?php print $class_id1 ?>">

	<input type="hidden" name="day_id1" value="<?php print $day_id1 ?>">

	<input type="hidden" name="startTime_1" value="<?php print $startTime_1 ?>">

	<input type="hidden" name="class_date" value="<?php print $class_date ?>">

	<input type="hidden" name="Remaining_Member_limit_1" value="<?php print $Remaining_Member_limit_1 ?>">

	<input type="hidden" name="bookedclass_membershipid" value="<?php print $bookedclass_membershipid ?>">

	<?php

	}

	?>

	<script src="//code.jquery.com/jquery-2.0.2.min.js"></script>

	<script

		src="https://checkout.stripe.com/checkout.js" class="stripe-button"

		data-key="<?php print $publisable_key; ?>" 

		data-image="<?php print $system_logo ?>" 

		data-name="<?php print $system_name ?>"

		data-description="<?php print $description ?>"

		data-currency="<?php print $currency ?>"

		data-locale="auto"

		data-amount="<?php print $amount*100; ?>" 

		data-user="<?php print $data_user; ?>">

	</script>

	<script>

	$(function()

	{

		$(".stripe-button-el").css("display","none");

		$(".stripe-button-el").get(0).click();

	});

	</script>

</form>