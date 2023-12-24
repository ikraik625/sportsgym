<?php 	

//TAX CLASS START  

class MJ_gmgt_tax

{		

	//ADD TAX DATA

	public function MJ_gmgt_add_taxes($data)

	{		

		global $wpdb;

		$table_gmgt_taxes=$wpdb->prefix .'MJ_gmgt_gmgt_taxes';

		$taxdata['tax_title']=MJ_gmgt_strip_tags_and_stripslashes(sanitize_text_field($data['tax_title']));

		$taxdata['tax_value']=sanitize_text_field($data['tax_value']);

		$taxdata['created_date']=date("Y-m-d");	

		if($data['action']=='edit')
		{	

			$taxid['tax_id']=sanitize_text_field($data['tax_id']);

			$result=$wpdb->update( $table_gmgt_taxes, $taxdata ,$taxid);
			
			gym_append_audit_log(''.esc_html__('Tax Updated','gym_mgt').' ('.$data['tax_title'].')',$data['tax_id'],get_current_user_id(),'edit',$_REQUEST['page']);

			return $result;

		}
		else
		{

			$result=$wpdb->insert( $table_gmgt_taxes,$taxdata);	
			$tax_id = $wpdb->insert_id;
			gym_append_audit_log(''.esc_html__('Tax Added','gym_mgt').' ('.$data['tax_title'].')',$tax_id,get_current_user_id(),'insert',$_REQUEST['page']);

			return $result;		

		}

	}

	//get all taxes

	public function MJ_gmgt_get_all_taxes()

	{

		global $wpdb;

		$table_gmgt_taxes=$wpdb->prefix .'MJ_gmgt_gmgt_taxes';	

		$result = $wpdb->get_results("SELECT * FROM $table_gmgt_taxes");

		return $result;	

	}	

	//delete taxes

	public function MJ_gmgt_delete_taxes($id)

	{

		global $wpdb;

		$table_gmgt_taxes=$wpdb->prefix .'MJ_gmgt_gmgt_taxes';

		$tax_title = $wpdb->get_row("SELECT tax_title FROM $table_gmgt_taxes where tax_id= ".$id);

		gym_append_audit_log(''.esc_html__('Tax Deleted','gym_mgt').' ('.$tax_title->tax_title.')',$id,get_current_user_id(),'delete',$_REQUEST['page']);

		$result = $wpdb->query("DELETE FROM $table_gmgt_taxes where tax_id= ".$id);


		return $result;

	}

	//get single tax data

	public function MJ_gmgt_get_single_tax_data($tax_id)

	{

		global $wpdb;

		$table_gmgt_taxes=$wpdb->prefix .'MJ_gmgt_gmgt_taxes';

		$result = $wpdb->get_row("SELECT * FROM $table_gmgt_taxes where tax_id= ".$tax_id);

		return $result;

	}

}

//TAX CLASS END  

?>