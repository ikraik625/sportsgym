<?php



$obj_payment= new MJ_gmgt_payment();

$fees_detail_result = '';



if($_REQUEST['invoice_type']=='membership_invoice')



{		



    $obj_membership_payment=new MJ_gmgt_membership_payment;	



    $membership_data=$obj_membership_payment->MJ_gmgt_get_single_membership_payment($_REQUEST['idtest']);



    $history_detail_result = MJ_gmgt_get_payment_history_by_mpid($_REQUEST['idtest']);



}



if($_REQUEST['invoice_type']=='income')



{



    $income_data=$obj_payment->MJ_gmgt_get_income_data($_REQUEST['idtest']);



    $history_detail_result = MJ_gmgt_get_income_payment_history_by_mpid($_REQUEST['idtest']);



}



if($_REQUEST['invoice_type']=='expense')



{



    $expense_data=$obj_payment->MJ_gmgt_get_income_data($_REQUEST['idtest']);



}



if($_REQUEST['invoice_type']=='sell_invoice')



{



    $obj_store=new MJ_gmgt_store;



    $selling_data=$obj_store->MJ_gmgt_get_single_selling($_REQUEST['idtest']);



    $history_detail_result = MJ_gmgt_get_sell_payment_history_by_mpid($_REQUEST['idtest']);



}



?>



<div class="penal-body" id="invoice_print"><!----- penal Body --------->



    <div class="modal-body border_invoice_page margin_top_15px_rs invoice_model_body float_left_width_100 height_600px"><!---- model body  ----->



        <img class="rtl_image_set_invoice invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/gym-management/assets/images/invoice.png'); ?>" width="100%">



        <div class="main_div float_left_width_100 payment_invoice_popup_main_div">



            <div class="invoice_width_100 float_left_width_100" border="0">



                <h3 class="school_name_for_invoice_view"><?php echo get_option( 'gmgt_system_name' ) ?></h3>



                <div class="row margin_top_20px">



                    <div class="col-md-1 col-sm-2 col-xs-3">



                        <div class="width_1 rtl_width_80px">



                            <img class="system_logo"  src="<?php echo esc_url(get_option( 'gmgt_gym_other_data_logo' )); ?>">



                        </div>



                    </div>	



                    <div class="col-md-11 col-sm-10 col-xs-9 invoice_address invoice_address_css">	



                        <div class="row">	



                            <div class="col-md-12 col-sm-12 col-xs-12 invoice_padding_bottom_15px padding_right_0">	



                                <label class="popup_label_heading"><?php esc_html_e('Address','gym_mgt'); ?>



                                </label><br>



                                <label for="" class="label_value word_break_all">	<?php



                                        echo chunk_split(get_option( 'gmgt_gym_address' ),100,"<BR>").""; 



                                    ?></label>



                            </div>



                            <div class="row col-md-12 invoice_padding_bottom_15px">	



                                <div class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 email_width_auto">	



                                    <label class="popup_label_heading"><?php esc_html_e('Email','gym_mgt');?> </label><br>



                                    <label for="" class="label_value word_break_all"><?php echo get_option( 'gmgt_email' ),"<BR>";  ?></label>



                                </div>



                        



                                <div class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 padding_left_30px">



                                    <label class="popup_label_heading"><?php esc_html_e('Phone','gym_mgt');?> </label><br>



                                    <label for="" class="label_value"><?php echo get_option( 'gmgt_contact_number' )."<br>";  ?></label>



                                </div>



                            </div>	



                            <div align="right" class="width_24"></div>									



                        </div>				



                    </div>



                </div>



                <div class="col-md-12 col-sm-12 col-xl-12 mozila_display_css margin_top_20px">



                    <div class="row">



                        <div class="width_50a1 float_left_width_100">



                            <div class="col-md-8 col-sm-8 col-xs-5 padding_0 float_left display_grid display_inherit_res margin_bottom_20px rs_main_billed_to">



								<div class="billed_to float_left_width_100 display_flex invoice_address_heading rs_width_billed_to">				



                                    <?php



									$issue_date='DD-MM-YYYY';



                                    if(!empty($income_data))



                                    {



                                        $issue_date=$income_data->invoice_date;



                                        $payment_status=$income_data->payment_status;



                                        $invoice_no=$income_data->invoice_no;



                                    }



                                  



                                    if(!empty($membership_data))



                                    {



                                        $issue_date=$membership_data->created_date;



                                       



                                        if($membership_data->payment_status!='0')



                                        {	



                                            $payment_status=$membership_data->payment_status;



                                        }



                                        else



                                        {



                                            $payment_status='Unpaid';



                                        }		



                                        $invoice_no=$membership_data->invoice_no;



                                    }



                                    if(!empty($expense_data))



                                    {



                                        $issue_date=$expense_data->invoice_date;



                                        $payment_status=$expense_data->payment_status;



                                        $invoice_no=$expense_data->invoice_no;



                                    }



                                    if(!empty($selling_data))



                                    {



                                        $issue_date=$selling_data->sell_date;	



                                        if(!empty($selling_data->payment_status))



                                        {



                                            $payment_status=$selling_data->payment_status;



                                        }	



                                        else



                                        {



                                            $payment_status='Fully Paid';



                                        }		



                                        



                                        $invoice_no=$selling_data->invoice_no;



                                    }			



                                   



                                    ?>



									<h3 class="billed_to_lable invoice_model_heading bill_to_width_12 rs_bill_to_width_40"><?php esc_html_e('Bill To','gym_mgt');?> : </h3>



									



									<?php



									if(!empty($expense_data))



									{



										$party_name=$expense_data->supplier_name; 



										echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";



									}



									else{



										if(!empty($income_data))



                                            $member_id=$income_data->supplier_name;



                                        if(!empty($membership_data))



                                            $member_id=$membership_data->member_id;



                                        if(!empty($selling_data))



                                            $member_id=$selling_data->member_id;



										$patient=get_userdata($member_id);						



										echo "<h3 class='display_name invoice_width_100'>".chunk_split(MJ_gmgt_get_user_full_display_name(esc_html($member_id)),30,"<BR>"). "</h3>";







									}



									?>



                                </div> 



                                <div class="width_60b2 address_information_invoice">



                                    <?php 	



									if(!empty($expense_data))



									{



										// $party_name=$expense_data->supplier_name; 



										// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";



									}



									else



									{



										if(!empty($income_data))



                                            $member_id=$income_data->supplier_name;



                                        if(!empty($membership_data))



                                            $member_id=$membership_data->member_id;



                                        if(!empty($selling_data))



                                            $member_id=$selling_data->member_id;



										$patient=get_userdata($member_id);						



										// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";



										$address=get_user_meta( $member_id,'address',true );



                                        $city_name = get_user_meta( $member_id,'city_name',true );



                                        $zip_code = get_user_meta( $member_id,'zip_code',true );



										echo chunk_split($address,30,"<BR>"); 



                                        if(!empty($zip_code))



                                        {



                                            



                                            echo get_user_meta( $member_id,'zip_code',true ).",<BR>"; 



                                        }



                                        if(!empty($city_name))



                                        {



                                            echo get_user_meta( $member_id,'city_name',true ).","."<BR>"; ; 



                                        }



									}		



									?>	



                                </div>



                            </div> 



                            <div class="col-md-3 col-sm-4 col-xs-7 float_left">



                                <div class="width_50a1112">



                                    <div class="width_20c" align="center">



                                        <?php



                                        if($_REQUEST['invoice_type']!='expense')



                                        {



                                            ?>	



                                            <h3 class="invoice_lable"><?php echo esc_html__('INVOICE','gym_mgt')."  #".$invoice_no;?></h3>								



                                            <?php



                                        }



                                        ?>



                                        <h5 class="align_left"> <label class="popup_label_heading text-transfer-upercase"><?php   echo esc_html__('Date :','gym_mgt') ?> </label>&nbsp;  <label class="invoice_model_value"><?php echo MJ_gmgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label></h5>



                                        <h5 class="align_left"><label class="popup_label_heading text-transfer-upercase"><?php echo esc_html__('Status :','gym_mgt')?> </label>  &nbsp;<label class="invoice_model_value"><?php echo esc_html__($payment_status,'gym_mgt'); ?></h5>	



                                    </div> 



                                </div> 



                            </div> 



                        </div> 



                    </div>  



                </div>



                <table class="width_100 margin_top_10px_res">	



                    <tbody>		



                        <tr>



                            <td>



                                <?php



                                if($_REQUEST['invoice_type']=='membership_invoice')



                                { 



                                    ?>



                                    <h3 class="display_name"><?php esc_attr_e('Membership Entries','gym_mgt');?></h3>



                                    <?php



                                }



                                elseif($_REQUEST['invoice_type']=='income')



				                { 



                                    ?>



                                    <h3 class="display_name"><?php esc_attr_e('Income Entries','gym_mgt');?></h3>



                                    <?php



                                }



                                elseif($_REQUEST['invoice_type']=='sell_invoice')



				                { 



                                    ?>



                                    <h3 class="display_name"><?php esc_attr_e('Sale Product','gym_mgt');?></h3>



                                    <?php



                                }



                                else



				                {



                                    ?>



                                    <h3 class="display_name"><?php esc_attr_e('Expense Entries','gym_mgt');?></h3>



                                    <?php



                                }



                                ?>



                                



                            <td>	



                        </tr>



                    </tbody>



                </table>



                <div class="table-responsive table_max_height_180px rtl_padding-left_40px">



                    <table class="table model_invoice_table">



                        <thead class="entry_heading invoice_model_entry_heading">	



                            <?php



                            if($_REQUEST['invoice_type']=='membership_invoice')



                            {



                                ?>				



                                <tr>



                                    <th class="entry_table_heading align_center">#</th>



                                    <th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



                                    <th class="entry_table_heading align_center"><?php esc_attr_e('Membership Name','gym_mgt');?> </th>



                                    <th class="entry_table_heading align_center"><?php esc_attr_e('Amount','gym_mgt');?></th>



                                </tr>



                                <?php



                            }



                            elseif($_REQUEST['invoice_type']=='sell_invoice')



                            {



                                ?>				



                                <tr>



                                    <th class="entry_table_heading align_center">#</th>



                                    <th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



                                    <th class="entry_table_heading align_center"><?php esc_attr_e('Product Name','gym_mgt');?> </th>



                                    <th class="entry_table_heading align_center"><?php esc_attr_e('Quantity','gym_mgt');?></th>



                                    <th class="entry_table_heading align_center"><?php esc_attr_e('Price','gym_mgt');?> </th>



                                    <th class="entry_table_heading align_center"><?php esc_attr_e('Total','gym_mgt');?></th>



                                </tr>



                                <?php



                            }



                            else



                            {



                                ?>				



                                <tr>



                                    <th class="entry_table_heading align_center">#</th>



                                    <th class="entry_table_heading align_center"> <?php esc_attr_e('Date','gym_mgt');?></th>



                                    <th class="entry_table_heading align_center"><?php esc_attr_e('Entry','gym_mgt');?> </th>



                                    <th class="entry_table_heading align_center"><?php esc_attr_e('Amount','gym_mgt');?></th>



                                </tr>



                                <?php



                            }



                            ?>						



                        </thead>



                        <tbody>



                            <?php 



                            $id=1;



                            $i=1;



                            $total_amount=0;



                            if(!empty($income_data) || !empty($expense_data))



                            {



                                if(!empty($expense_data))



                                {



                                    $income_data=$expense_data;



                                }



                                



                                $member_income=$obj_payment->MJ_gmgt_get_oneparty_income_data_incomeid($income_data->invoice_id);



                                



                                foreach($member_income as $result_income)



                                {



                                    $income_entries=json_decode($result_income->entry);



                                    $discount_amount=$result_income->discount;



                                    $paid_amount=$result_income->paid_amount;



                                    $total_discount_amount= $result_income->amount - $discount_amount;



                                    if($result_income->tax_id!='')



                                    {									



                                        $total_tax=0;



                                        $tax_array=explode(',',$result_income->tax_id);



                                        foreach($tax_array as $tax_id)



                                        {



                                            $tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



                                                                



                                            $tax_amount=$total_discount_amount * $tax_percentage / 100;



                                            



                                            $total_tax=$total_tax + $tax_amount;				



                                        }



                                    }



                                    else



                                    {



                                        $total_tax=$total_discount_amount * $result_income->tax/100;



                                    }



                                    $due_amount=0;



                                    $due_amount=$result_income->total_amount - $result_income->paid_amount;



                                    $grand_total=$total_discount_amount + $total_tax;







                                    foreach($income_entries as $each_entry)



                                    {



                                        $total_amount+=$each_entry->amount;								



                                        ?>



                                        <tr>



                                            <td class="align_center invoice_table_data"><?php echo $id;?></td>



                                            <td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($result_income->invoice_date);?></td>



                                            <td class="align_center invoice_table_data"><?php echo $each_entry->entry; ?> </td>



                                            <td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($each_entry->amount,2); ?></td>



                                        </tr>



                                        <?php 



                                        $id+=1;



                                        $i+=1;



                                    }



                                    if($grand_total=='0')									



                                    {	



                                        if($income_data->payment_status=='Paid')



                                        {



                                            



                                            $grand_total=$total_amount;



                                            $paid_amount=$total_amount;



                                            $due_amount=0;										



                                        }



                                        else



                                        {



                                            



                                            $grand_total=$total_amount;



                                            $paid_amount=0;



                                            $due_amount=$total_amount;															



                                        }



                                    }



                                }



                            }



                            if(!empty($membership_data))



                            {



                                $membership_signup_amounts=$membership_data->membership_signup_amount;



                                ?>



                                <tr>



                                    <td class="align_center invoice_table_data"><?php echo $i;?></td>



                                    <td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td>



                                    <td class="align_center invoice_table_data"><?php echo MJ_gmgt_get_membership_name($membership_data->membership_id);?></td>



                                    <td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($membership_data->membership_fees_amount,2); ?></td>



                                </tr>



                                <?php 



                                if( $membership_signup_amounts  > 0) 



                                {



                                    ?>



                                    <tr class="">



                                        <td class="align_center invoice_table_data"><?php echo 2 ;?></td> 



                                        <td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($membership_data->created_date);?></td> 



                                        <td class="align_center invoice_table_data"><?php esc_html_e('Membership Signup Fee','gym_mgt');?></td>								



                                        <td class="align_center invoice_table_data"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($membership_data->membership_signup_amount,2); ?></td>



                                    </tr>



                                    <?php



                                }



                            }



                            if(!empty($selling_data))



						    {



                                $all_entry=json_decode($selling_data->entry);



                                if(!empty($all_entry))



                                {



                                    foreach($all_entry as $entry)



                                    {



                                        $obj_product=new MJ_gmgt_product;



									    $product = $obj_product->MJ_gmgt_get_single_product($entry->entry);



									



										$product_name=$product->product_name;					



										$quentity=$entry->quentity;	



										$price=$product->price;	







                                        ?>



                                        <tr class="">										



                                            <td class="align_center invoice_table_data"><?php echo $i;?></td> 



                                            <td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>



                                            <td class="align_center invoice_table_data"><?php echo $product_name;?> </td>



                                            <td  class="align_center invoice_table_data"> <?php echo $quentity; ?></td>



                                            <td class="align_center invoice_table_data"><?php echo MJ_gmgt_get_floting_value($price); ?></td>



                                            <td class="align_center invoice_table_data"><?php echo number_format($quentity * $price,2); ?></td>



                                        </tr>



                                        <?php



                                        $id+=1;



                                        $i+=1;



                                    }



                                }



                                else



                                {



                                    $obj_product=new MJ_gmgt_product;



                                    $product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id); 



                                    



                                    $product_name=$product->product_name;					



                                    $quentity=$selling_data->quentity;	



                                    $price=$product->price;	



                                    ?>



                                    <tr class="">										



                                        <td class="align_center invoice_table_data"><?php echo $i;?></td> 



                                        <td class="align_center invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($selling_data->sell_date);?></td>



                                        <td class="align_center invoice_table_data"><?php echo $product_name;?> </td>



                                        <td  class="align_center invoice_table_data"> <?php echo $quentity; ?></td>



                                        <td class="align_center invoice_table_data"> <?php echo $price; ?></td>



                                        <td class="align_center invoice_table_data"> <?php echo number_format($quentity * $price,2); ?></td>



                                    </tr>



                                    <?php



                                    $id+=1;



                                    $i+=1;



                                }



                            }



                            ?>



                        </tbody>



                    </table>



                </div>



                <div class="table-responsive rtl_padding-left_40px rtl_float_left_width_100px">



                    <?php 



                    if(!empty($membership_data))



                    {



                        $total_amount=$membership_data->membership_fees_amount+$membership_data->membership_signup_amount;



                        $total_tax=$membership_data->tax_amount;							



                        $paid_amount=$membership_data->paid_amount;



                        $due_amount=abs($membership_data->membership_amount - $paid_amount);



                        $grand_total=$membership_data->membership_amount;							



                    }



                    if(!empty($expense_data))



                    {



                        $grand_total=$total_amount;



                    }



                    if(!empty($selling_data))



                    {



                        $all_entry=json_decode($selling_data->entry);



                        



                        if(!empty($all_entry))



                        {



                            $total_amount=$selling_data->amount;



                            $discount_amount=$selling_data->discount;



                            $total_discount_amount=$total_amount-$discount_amount;



                            



                            if($selling_data->tax_id!='')



                            {									



                                $total_tax=0;



                                $tax_array=explode(',',$selling_data->tax_id);



                                foreach($tax_array as $tax_id)



                                {



                                    $tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



                                                        



                                    $tax_amount=$total_discount_amount * $tax_percentage / 100;



                                    



                                    $total_tax=$total_tax + $tax_amount;				



                                }



                            }



                            else



                            {



                                $tax_per=$selling_data->tax;



                                $total_tax=$total_discount_amount * $tax_per/100;



                            }



                            



                            $paid_amount=$selling_data->paid_amount;



                            $due_amount=abs($selling_data->total_amount - $paid_amount);



                            $grand_total=$selling_data->total_amount;



                        }



                        else



                        {	



                            $obj_product=new MJ_gmgt_product;



                            $product = $obj_product->MJ_gmgt_get_single_product($selling_data->product_id);



                            $price=$product->price;	



                            



                            $total_amount=$price*$selling_data->quentity;



                            $discount_amount=$selling_data->discount;



                            $total_discount_amount=$total_amount-$discount_amount;



                            



                            if($selling_data->tax_id!='')



                            {									



                                $total_tax=0;



                                $tax_array=explode(',',$selling_data->tax_id);



                                foreach($tax_array as $tax_id)



                                {



                                    $tax_percentage=MJ_gmgt_tax_percentage_by_tax_id($tax_id);



                                                        



                                    $tax_amount=$total_discount_amount * $tax_percentage / 100;



                                    



                                    $total_tax=$total_tax + $tax_amount;				



                                }



                            }



                            else



                            {



                                $tax_per=$selling_data->tax;



                                $total_tax=$total_discount_amount * $tax_per/100;



                            }



                                                            



                            $paid_amount=$total_amount;



                            $due_amount='0';



                            $grand_total=$total_amount;								



                        }		



                    }							



                    ?>



                    <div class="row width_100 col-md-12 col-sm-12 col-lg-12">



                        <div class="col-md-7 col-sm-7 col-lg-7 col-xs-12">



                            <h3 class="display_name align_left"><?php esc_attr_e('Payment Method','gym_mgt');?></h3>



                            <table width="100%" border="0">



                                <tbody>							



                                    <tr style="">



                                        <td class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Bank Name','gym_mgt');?></td>



                                        <td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_name' );?></td>



                                    </tr>



                                    <tr style="">



                                        <td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Account No.','gym_mgt');?></td>



                                        <td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_acount_number' );?></td>



                                    </tr>



                                    <tr style="">



                                        <td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('IFSC Code','gym_mgt');?></td>



                                        <td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_bank_ifsc_code' );?></td>



                                    </tr>



                                    <tr style="">



                                        <td  class="label_min_width_130px rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Paypal ID','gym_mgt');?></td>



                                        <td class="rtl_width_15px padding_bottom_15px total_value">:&nbsp;&nbsp;<?php echo get_option( 'gmgt_paypal_email' );?></td>



                                    </tr>



                                </tbody>



                            </table>



                        </div>



                        <div class="col-md-5 col-sm-5 col-lg-5 col-xs-12">



                            <table width="100%" border="0">



                                <tbody>							



                                    <tr style="">



                                        <td  align="right" class="rtl_float_left_label padding_bottom_15px total_heading"><?php esc_attr_e('Sub Total :','gym_mgt');?></td>



                                        <td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_amount,2);?></td>



                                    </tr>



                                    <?php



                                    if($_REQUEST['invoice_type']!='expense')



                                    {



                                        if($_REQUEST['invoice_type']!='membership_invoice')



                                        {



                                            ?>



                                            <tr>



                                                <td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Discount Amount :','gym_mgt');?></td>



                                                <td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo "-";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($discount_amount,2); ?></td>



                                            </tr>



                                            <?php



                                        }



                                        ?>



                                        <tr>



                                            <td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Tax Amount :','gym_mgt');?></td>



                                            <td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo "+";echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($total_tax,2); ?></td>



                                        </tr>



                                        <tr>



                                            <td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Due Amount :','gym_mgt');?></td>



                                            <?php if(!empty($fees_detail_result->total_amount)){ $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; } ?>



                                            <td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($due_amount,2); ?></td>



                                        </tr>



                                        <tr>



                                            <td width="85%" class="rtl_float_left_label padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Paid Amount :','gym_mgt');?></td>



                                            <td align="left" class="rtl_width_15px padding_bottom_15px total_value"><?php  echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ));?><?php echo number_format($paid_amount,2); ?></td>



                                        </tr>	



                                        <?php



                                    }	



                                    ?>		



                                </tbody>



                            </table>



                        </div>



                    </div>



                </div>



                <div class="rtl_float_left row margin_top_10px_res col-md-4 col-sm-4 col-xs-4 view_invoice_lable_css inovice_width_100px_rs float_left grand_total_div invoice_table_grand_total" style="float: right;margin-right:0px;">



                    <div class="width_50_res align_right col-md-5 col-sm-5 col-xs-5 view_invoice_lable padding_11 padding_right_0_left_0 float_left grand_total_label_div invoice_model_height line_height_1_5 padding_left_0_px"><h3 style="float: right;" class="padding color_white margin invoice_total_label"><?php esc_html_e('Grand Total','gym_mgt');?> </h3></div>



                    <div class="width_50_res align_right col-md-7 col-sm-7 col-xs-7 view_invoice_lable  padding_right_5_left_5 padding_11 float_left grand_total_amount_div"><h3 style="float: left;" class="padding margin text-right color_white invoice_total_value"><?php echo "<span>".MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."</span> ".number_format($grand_total,2); ?></h3></div>



                </div>



                <?php				



                if(!empty($history_detail_result))



                {



					?>



                    <hr class="width_100 flot_left_invoice_history_hr">



                    <table class="width_100">	



                        <tbody>	



                            <tr>



                                <td>



                                    <h3  class="display_name"><?php esc_html_e('Payment History','gym_mgt');?></h3>



                                </td>	



                            </tr>	



                        </tbody>



                    </table>



                    <div class="table-responsive rtl_padding-left_40px table_max_height_250px">



                        <table class="table model_invoice_table">



                            <thead class="entry_heading invoice_model_entry_heading">



                                <tr>



                                    <th class="entry_table_heading align_left"><?php esc_attr_e('Date','gym_mgt');?></th>



                                    <th class="entry_table_heading align_left"> <?php esc_attr_e('Amount','gym_mgt');?></th>



                                    <th class="entry_table_heading align_left"><?php esc_attr_e('Method','gym_mgt');?> </th>



                                    <th class="entry_table_heading align_left"><?php esc_html_e('Payment Details','gym_mgt');?></th>



                                </tr>



                            </thead>



                            <tbody>



                                <?php 



                                foreach($history_detail_result as  $retrive_data)



                                {



                                    ?>



                                    <tr>



                                        <td class="align_left invoice_table_data"><?php echo MJ_gmgt_getdate_in_input_box($retrive_data->paid_by_date);?></td>



                                        <td class="align_left invoice_table_data"><?php echo MJ_gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' )).MJ_gmgt_get_floting_value($retrive_data->amount); ?></td>



                                        <td class="align_left invoice_table_data"><?php echo esc_html__($retrive_data->payment_method,"gym_mgt"); ?></td>



                                        <td class="align_left invoice_table_data"><?php if(!empty($retrive_data->payment_description)){ echo  $retrive_data->payment_description; }else{ echo 'N/A'; }?></td>



                                    </tr>



                                    <?php 



                                } ?>



                            </tbody>



                        </table>



                    </div>



                    <?php



                }



                ?>



                <div class="col-md-12 grand_total_main_div total_padding_15px rtl_float_none">



                    <div class="row margin_top_10px_res width_50_res col-md-6 col-sm-6 col-xs-6 print-button pull-left invoice_print_pdf_btn">



                        <div class="col-md-2 print_btn_rs width_50_res">



                            <a href="?page=invoice&print=print&invoice_id=<?php echo $_REQUEST['idtest'];?>&invoice_type=<?php echo $_REQUEST['invoice_type'];?>" target="_blank" class="btn btn save_btn invoice_btn_div"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/print.png" ?>" > </a>



                        </div>



                        <div class="col-md-3 pdf_btn_rs width_50_res">



                            <a href="?page=invoice&pdf=pdf&invoice_id=<?php echo $_REQUEST['idtest'];?>&invoice_type=<?php echo $_REQUEST['invoice_type'];?>" target="_blank" class="btn color_white invoice_btn_div btn save_btn"><img src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/pdf.png" ?>" ></a>



                        </div>



                    </div>



                </div>



            </div>



        </div><!---------- Main Div ---------------->



    </div><!--------- Model Body --------------->



</div><!----- penal Body --------->