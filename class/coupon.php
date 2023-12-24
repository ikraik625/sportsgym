<?php
// COUPON CLASS START
class MJ_gmgt_coupon
{
	
	public function MJ_gmgt_add_coupon($data)
	{
		global $wpdb;
		
		$table_coupon = $wpdb->prefix. 'gmgt_coupon';
		
		$coupondata['code'] = sanitize_text_field($data['coupon_code']);
		$coupondata['coupon_type'] =  sanitize_text_field($data['coupon_for']);
		if($data['coupon_for'] == 'all_member'){
			$coupondata['member_id'] = 0;
		}else{
			$coupondata['member_id'] =  sanitize_text_field($data['member_id']);
		}
		$coupondata['recurring_type'] =  sanitize_text_field($data['recurring_type']);
		$coupondata['membership'] = sanitize_text_field($data['membership']);
		$coupondata['discount'] = sanitize_text_field($data['discount']);
		$coupondata['discount_type'] = sanitize_text_field($data['discount_type']);
		$coupondata['time'] = sanitize_text_field($data['time']);
		$coupondata['from_date'] = MJ_gmgt_get_format_for_db($data['from_date']);
		$coupondata['end_date'] = MJ_gmgt_get_format_for_db($data['end_date']);
		$coupondata['published'] = sanitize_text_field($data['publish']);
		
		// EDIT COUPONDATA
		if($data['action']=='edit'){
			$coupon_id['id'] = sanitize_text_field($data['coupon_id']);
			$result=$wpdb->update( $table_coupon, $coupondata ,$coupon_id);
			return $result;
		}
		// ADD COUPONDATA
		else{
			$result=$wpdb->insert( $table_coupon, $coupondata );
			return $result;
		}
		
	}

	// GET ALL COUPONDATA
	public function MJ_gmgt_get_all_coupondata()
	{

		global $wpdb;

		$table_coupon = $wpdb->prefix. 'gmgt_coupon';

		$result = $wpdb->get_results("SELECT * FROM $table_coupon ORDER BY id DESC");

		return $result;	

	}
	
	// GET SINGLE COUPONDATA BY ID
	public function MJ_gmgt_get_single_coupondata($id)
	{
		if($id == '')

		return '';

		global $wpdb;

		$table_coupon = $wpdb->prefix. 'gmgt_coupon';

		$result = $wpdb->get_row("SELECT * FROM $table_coupon where id= ".$id);

		return $result;
	}

	// GET SINGLE COUPONDATA BY USER ID
	public function MJ_gmgt_get_coupondata_by_user_id($id)
	{
		if($id == '')

		return '';

		global $wpdb;

		$table_coupon = $wpdb->prefix. 'gmgt_coupon';

		$result = $wpdb->get_results("SELECT * FROM $table_coupon where member_id= ".$id);
		return $result;
	}
	
	// GET COUPONDATA BY CODE
	public function MJ_gmgt_get_coupon_by_code($code)
	{
		if ($code == '') {
			return '';
		}

		global $wpdb;
		$table_coupon = $wpdb->prefix . 'gmgt_coupon';

		$query = $wpdb->prepare("SELECT * FROM $table_coupon WHERE code = %s", $code);
		$result = $wpdb->get_row($query);

		return $result;
	}
	
	// DELETE COUPON DATA
	public function MJ_gmgt_delete_coupon($id)
	{
		global $wpdb;

		$table_coupon = $wpdb->prefix. 'gmgt_coupon';

		$result = $wpdb->query("DELETE FROM $table_coupon where id= ".$id);

		return $result;

	}
}
?>