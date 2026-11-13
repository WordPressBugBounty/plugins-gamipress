<?php
/**
 * Triggers
 *
 * @package GamiPress\User_Registration\Triggers
 * @since 1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register User Registration & Membership specific triggers
 *
 * @since  1.0.0
 *
 * @param array $triggers
 * @return mixed
 */
function gamipress_user_registration_activity_triggers( $triggers ) {

    $triggers[__( 'User Registration & Membership', 'gamipress' )] = array(
        'gamipress_user_registration_register'                  => __( 'Register new user', 'gamipress' ),
        'gamipress_user_registration_add_membership'            => __( 'Sign up for a membership', 'gamipress' ),
        'gamipress_user_registration_add_specific_membership'   => __( 'Sign up for a specific membership', 'gamipress' ),
    );

    return $triggers;

}
add_filter( 'gamipress_activity_triggers', 'gamipress_user_registration_activity_triggers' );

/**
 * Register specific activity triggers
 *
 * @since  1.0.0
 *
 * @param  array $specific_activity_triggers
 * @return array
 */
function gamipress_user_registration_specific_activity_triggers( $specific_activity_triggers ) {
    
    $specific_activity_triggers['gamipress_user_registration_add_specific_membership'] = array( 'ur_membership' );
    
    return $specific_activity_triggers;
}
add_filter( 'gamipress_specific_activity_triggers', 'gamipress_user_registration_specific_activity_triggers' );

/**
 * Register specific activity triggers labels
 *
 * @since  1.0.0
 *
 * @param  array $specific_activity_trigger_labels
 * @return array
 */
function gamipress_user_registration_specific_activity_trigger_label( $specific_activity_trigger_labels ) {

    $specific_activity_trigger_labels['gamipress_user_registration_add_specific_membership'] = __( 'Sign up for %s membership', 'gamipress' );
    
    return $specific_activity_trigger_labels;
}
add_filter( 'gamipress_specific_activity_trigger_label', 'gamipress_user_registration_specific_activity_trigger_label' );

/**
 * Get user for a given trigger action.
 *
 * @since  1.0.0
 *
 * @param  integer $user_id user ID to override.
 * @param  string  $trigger Trigger name.
 * @param  array   $args    Passed trigger args.
 * @return integer          User ID.
 */
function gamipress_user_registration_trigger_get_user_id( $user_id, $trigger, $args ) {

    switch ( $trigger ) {
        case 'gamipress_user_registration_register':
            $user_id = $args[0];
            break;    
        case 'gamipress_user_registration_add_membership':
        case 'gamipress_user_registration_add_specific_membership':
            $user_id = $args[1];
            break;
    }

    return $user_id;

}
add_filter( 'gamipress_trigger_get_user_id', 'gamipress_user_registration_trigger_get_user_id', 10, 3 );

/**
 * Get the id for a given specific trigger action.
 *
 * @since  1.0.0
 *
 * @param  integer $specific_id Specific ID to override.
 * @param  string  $trigger     Trigger name.
 * @param  array   $args        Passed trigger args.
 *
 * @return integer              Specific ID.
 */
function gamipress_user_registration_specific_trigger_get_id( $specific_id, $trigger, $args ) {

    switch ( $trigger ) {
        case 'gamipress_user_registration_add_specific_membership':
            $specific_id = $args[0];
            break;
    }

    return $specific_id;

}

add_filter( 'gamipress_specific_trigger_get_id', 'gamipress_user_registration_specific_trigger_get_id', 10, 3 );

/**
 * Extended meta data for event trigger logging
 *
 * @since 1.0.1
 *
 * @param array 	$log_meta
 * @param integer 	$user_id
 * @param string 	$trigger
 * @param integer 	$site_id
 * @param array 	$args
 *
 * @return array
 */
function gamipress_user_registration_log_event_trigger_meta_data( $log_meta, $user_id, $trigger, $site_id, $args ) {

    switch ( $trigger ) {
        case 'gamipress_user_registration_add_membership':
        case 'gamipress_user_registration_add_specific_membership':
            // Add the membership ID
            $log_meta['membership_id'] = $args[0];
            break;
    }

    return $log_meta;
}
add_filter( 'gamipress_log_event_trigger_meta_data', 'gamipress_user_registration_log_event_trigger_meta_data', 10, 5 );