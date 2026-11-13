<?php
/**
 * Listeners
 *
 * @package GamiPress\User_Registration\Listeners
 * @since 1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Add Membership plan
 *
 * @since  1.0.0
 *
 * @param array $form_data
 * @param int $form_id
 * @param int $user_id
 */
function gamipress_user_registration_register_user( $form_data, $form_id, $user_id ) {
    
    // Register user
    do_action( 'gamipress_user_registration_register', $user_id );

}

add_action( 'user_registration_after_register_user_action', 'gamipress_user_registration_register_user', 10, 3 );

/**
 * Add Membership plan
 *
 * @since  1.0.0
 *
 * @param array $payload
 */
function gamipress_user_registration_add_membership( $payload ) {
    
    $membership = new WPEverest\URMembership\Admin\Repositories\MembersRepository();
    $membership_data = $membership->get_member_memberships_by_id( $payload['member_id'] );
    $membership_id = $membership_data[0]['post_id'];
    $user_id = $membership_data[0]['user_id'];

    // Add any membership plan
    do_action( 'gamipress_user_registration_add_membership', $membership_id, $user_id );

    // Add specific membership plan
    do_action( 'gamipress_user_registration_add_specific_membership', $membership_id, $user_id );

}

add_action( 'ur_membership_subscription_event_triggered', 'gamipress_user_registration_add_membership' );
