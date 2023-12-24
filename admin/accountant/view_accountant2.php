<?php 



 $active_tab1 = isset($_REQUEST['tab1'])?$_REQUEST['tab1']:'general';



$obj_gyme = new MJ_gmgt_Gym_management(); 



$accountant_id=0;



$edit=0;	

$dependent_member = null;

if(isset($_REQUEST['accountant_id']) )



{	



	$accountant_id=esc_attr($_REQUEST['accountant_id']);			



	$edit=1;



	$user_info = get_userdata($accountant_id);

    global $wpdb;
    $dependent_member = $wpdb->get_results("SELECT user_id FROM {$wpdb->prefix}usermeta WHERE `meta_key`='member_id' AND NOT user_id ='$accountant_id' AND meta_value like '%$user_info->member_id%'", ARRAY_A);
   

}



?>	

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Member Details</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .member-details-container {
        max-width: 800px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-picture img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .member-info h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .member-info p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .member-info strong {
        font-weight: bold;
    }

    .dependent-section {
        margin-top: 30px;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .dependent-member {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
    }

    .dependent-member img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    /* Add more styles as needed */

</style>
</head>
<body>

<div class="member-details-container">
    <!-- First Section for Primary Member -->
    <h1 style="text-align: center;">Primary Member</h1>
    <div class="profile-picture">
        <!-- <?php if($user_info->gmgt_user_avatar == "") { ?><img class="user_view_profile_image" alt="" src="<?php echo get_option('gmgt_Account_logo' ); ?>"> <?php } else { ?> <img class="user_view_profile_image" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" /> <?php }?> -->
        <img class="user_view_profile_image" alt="" src="<?php echo esc_url( $user_info->gmgt_user_avatar ); ?>" >
        <!-- <?php echo chunk_split(esc_html($user_info->gmgt_user_avatar),32,"<BR>");?> -->
    </div>
    <div class="member-info">
        <h1><?php echo chunk_split(esc_html($user_info->first_name),32,"<BR>");?></h1>
		<p><strong>RANK :</strong> <?php echo chunk_split(esc_html($user_info->last_name),32,"<BR>");?></p>
		<p><strong>EMAIL-ID : </strong><?php echo chunk_split(esc_html($user_info->user_email),32,"<BR>");?></p>
        <p><strong>MEMBERSHIP ID:</strong> <?php echo chunk_split(esc_html($user_info->member_id),32,"<BR>");?> </p>
        <p><strong>MEMBERSHIP TYPE:</strong> <?php echo MJ_gmgt_get_membership_name(esc_html($user_info->membership_id));?></p>
        <p><strong>MOBILE NO:</strong><?php echo esc_html($user_info->mobile);?></p>
        <p><strong>ADDRESS:</strong> <?php if($user_info->address != '') {															echo chunk_split(esc_html($user_info->address)); }  ?></p>
        <p><strong>NO OF DEPENDENTS:</strong> <?php echo get_user_meta( $user_info->ID, 'total_dependent', true ); ?></p>
        <p><strong>JOINING DATE:</strong> <?php echo chunk_split(esc_html($user_info->begin_date),32,"<BR>");?></p>
        <p><strong>MEMBERSHIP STATUS:</strong> <?php echo chunk_split(esc_html($user_info->membership_status),32,"<BR>");?></p>
    </div>

    <!-- Second Section for Dependent Members -->
    <div class="dependent-section">
        <h1 style="text-align: center;">Dependent Members</h1>
        
        <!-- Grid Container for Dependent Members -->
        <div class="grid-container">
            <?php
                if ( ! empty( $dependent_member ) )  {
                    foreach ($dependent_member as $key => $user) {
	                    $user_info_dependent = get_userdata($user['user_id']);
                        ?>
                        <div class="dependent-member">
                            <img src="<?php echo esc_url( $user_info_dependent->gmgt_user_avatar ); ?>" alt="<?php echo esc_url( $user_info_dependent->first_name ); ?>">
                            <h2><?php echo chunk_split(esc_html($user_info_dependent->first_name),32,"<BR>");?></h2>
                            <p><strong>Relation:</strong> <?php echo chunk_split(esc_html($user_info_dependent->relation),32,"<BR>");?></p>
                        </div>
                        <?php
                        # code...
                    }
                }
            ?>
        </div>
    </div>
</div>

</body>
</html>
