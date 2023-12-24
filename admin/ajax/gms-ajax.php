<?php
defined( 'ABSPATH' ) || exit; 
/**
 * The GMS_Admin_Files class handles admin files.
 *
 * @version 1.0.0
 */

if ( ! class_exists( 'GMS_Admin_Files' ) ) {
    class GMS_Admin_Files {
        
        public function __construct() {
            add_action('wp_ajax_nopriv_gms_get_user_ajax',  array( $this, 'gms_get_user_ajax' ));
            add_action('wp_ajax_gms_get_user_ajax',  array( $this, 'gms_get_user_ajax' ) );
        }

        public function get_membership_type($check_id_user) {
            $membership_id = get_user_meta($check_id_user, 'membership_id', true);
            if ( $membership_id ) {
                global $wpdb;
    
                $table_gmgt_membershiptype = $wpdb->prefix. 'gmgt_membershiptype';
    
                $membership_label = $wpdb->get_row("SELECT * FROM $table_gmgt_membershiptype WHERE membership_id=$membership_id");
                return ! empty( $membership_label ) ?[ $membership_label->membership_label, $membership_label->membership_id]: null;
            } else {
                return null;
            }

        }

        /**
         * Ajax Function to check primary member Id and rteurn required data
         */
        public function gms_get_user_ajax() {
            if ( !empty( $_POST['check_id'] ) ) {
                // var_dump($_POST);
                $check_id_user = reset(
                    get_users(
                        array(
                            'meta_key'   => 'member_id',
                            'meta_value' => $_POST['check_id'],
                            'number'     => 1,
                        )
                    )
                );
                if ( ! empty( $check_id_user )  ) {
                    $get_id = get_user_meta( $check_id_user->ID, 'total_dependent', 1 );
                    $primaryId = $_POST['check_id'];
                    if ( $get_id) {
                        $get_id = (int)$get_id + 1;
                        $newmember = $primaryId .'D'. $get_id;
                    } else {
                        $newmember = $primaryId . 'D1';
                    }

                    $get_membership_type = $this->get_membership_type($check_id_user->ID);
                    if (! empty($get_membership_type) && $get_membership_type[0] === "Family") {
                        wp_send_json(
                            array(
                                'primary_user_id'     => $check_id_user->ID,
                                'total_dependent'     => $get_id,
                                'get_membership_type' => $this->get_membership_type($check_id_user->ID),
                                'name'                => $check_id_user->data->display_name,
                                'email'               => $check_id_user->data->user_email,
                                'begin_date'          => get_user_meta( $check_id_user->ID, 'begin_date', 1 ),
                                'end_date'          => get_user_meta( $check_id_user->ID, 'end_date', 1 ),
                                'new_member_id'       => $newmember
                            )
                        );
                    } else {
                        wp_send_json(
                            array(
                            'error' => 'Please upgrade your membership plan to family'
                            )
                        );
                    }
                } else {
                    wp_send_json(
                        array(
                        'error' => 'Invalid Primary Id'
                        )
                    );
                }
                die;
            }
        }
        
    }

    new GMS_Admin_Files();
}
