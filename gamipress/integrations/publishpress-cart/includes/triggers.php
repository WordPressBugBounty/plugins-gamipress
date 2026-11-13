<?php
/**
 * Triggers
 *
 * @package GamiPress\PublishPress_Cart\Triggers
 * @since 1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register plugin specific triggers
 *
 * @since 1.0.0
 *
 * @param array $triggers
 * @return mixed
 */
function gamipress_publishpress_cart_activity_triggers( $triggers ) {

    $triggers[__( 'PublishPress Cart', 'gamipress' )] = array(

        'gamipress_publishpress_cart_any_product_purchase'                      => __( 'Purchase any product', 'gamipress' ),
        'gamipress_publishpress_cart_specific_product_purchase'                 => __( 'Purchase a specific product', 'gamipress' ),
        'gamipress_publishpress_cart_refund_any_product_order'                  => __( 'Refund an order for any product', 'gamipress' ),
        'gamipress_publishpress_cart_refund_specific_product_order'             => __( 'Refund an order for a specific product', 'gamipress' ),
        'gamipress_publishpress_cart_cancel_any_product_subscription'           => __( 'Cancel a subscription for any product', 'gamipress' ),
        'gamipress_publishpress_cart_cancel_specific_product_subscription'      => __( 'Cancel a subscription for a specific product', 'gamipress' ),
        'gamipress_publishpress_cart_renew_any_product_subscription'            => __( 'Renew a subscription for any product', 'gamipress' ),
        'gamipress_publishpress_cart_renew_specific_product_subscription'       => __( 'Renew a subscription for a specific product', 'gamipress' ),
        
    );

    return $triggers;

}
add_filter( 'gamipress_activity_triggers', 'gamipress_publishpress_cart_activity_triggers' );

/**
 * Register PublishPress_Cart specific activity triggers
 *
 * @since  1.0.0
 *
 * @param  array $specific_activity_triggers
 * @return array
 */
function gamipress_publishpress_cart_specific_activity_triggers( $specific_activity_triggers ) {

    $specific_activity_triggers['gamipress_publishpress_cart_specific_product_purchase'] = array( 'ppcart_product' );
    $specific_activity_triggers['gamipress_publishpress_cart_refund_specific_product_order'] = array( 'ppcart_product' );
    $specific_activity_triggers['gamipress_publishpress_cart_cancel_specific_product_subscription'] = array( 'ppcart_product' );
    $specific_activity_triggers['gamipress_publishpress_cart_renew_specific_product_subscription'] = array( 'ppcart_product' );
    
    return $specific_activity_triggers;
}
add_filter( 'gamipress_specific_activity_triggers', 'gamipress_publishpress_cart_specific_activity_triggers' );

/**
 * Register plugin specific activity triggers labels
 *
 * @since  1.0.0
 *
 * @param  array $specific_activity_trigger_labels
 * @return array
 */
function gamipress_publishpress_cart_specific_activity_trigger_label( $specific_activity_trigger_labels ) {

    $specific_activity_trigger_labels['gamipress_publishpress_cart_specific_product_purchase'] = __( 'Purchase %s', 'gamipress' );
    $specific_activity_trigger_labels['gamipress_publishpress_cart_refund_specific_product_order'] = __( 'Refund an order for %s', 'gamipress' );
    $specific_activity_trigger_labels['gamipress_publishpress_cart_cancel_specific_product_subscription'] = __( 'Cancel subscription for %s', 'gamipress' );
    $specific_activity_trigger_labels['gamipress_publishpress_cart_renew_specific_product_subscription'] = __( 'Renew subscription for %s', 'gamipress' );

    return $specific_activity_trigger_labels;
}
add_filter( 'gamipress_specific_activity_trigger_label', 'gamipress_publishpress_cart_specific_activity_trigger_label' );

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
function gamipress_publishpress_cart_trigger_get_user_id( $user_id, $trigger, $args ) {

    switch ( $trigger ) {

        case 'gamipress_publishpress_cart_any_product_purchase':
        case 'gamipress_publishpress_cart_specific_product_purchase':
        case 'gamipress_publishpress_cart_refund_any_product_order':
        case 'gamipress_publishpress_cart_refund_specific_product_order':
        case 'gamipress_publishpress_cart_cancel_any_product_subscription':
        case 'gamipress_publishpress_cart_cancel_specific_product_subscription':
        case 'gamipress_publishpress_cart_renew_any_product_subscription':
        case 'gamipress_publishpress_cart_renew_specific_product_subscription':
            $user_id = $args[2];
            break;

    }

    return $user_id;

}
add_filter( 'gamipress_trigger_get_user_id', 'gamipress_publishpress_cart_trigger_get_user_id', 10, 3 );

/**
 * Get the id for a given specific trigger action.
 *
 * @since  1.0.0
 *
 * @param  integer  $specific_id Specific ID.
 * @param  string  $trigger Trigger name.
 * @param  array   $args    Passed trigger args.
 *
 * @return integer          Specific ID.
 */
function gamipress_publishpress_cart_specific_trigger_get_id( $specific_id, $trigger = '', $args = array() ) {

    switch ( $trigger ) {

        case 'gamipress_publishpress_cart_specific_product_purchase':
        case 'gamipress_publishpress_cart_refund_specific_product_order':
        case 'gamipress_publishpress_cart_cancel_specific_product_subscription':
        case 'gamipress_publishpress_cart_renew_specific_product_subscription':
            $specific_id = $args[0];
            break;

    }

    return $specific_id;
}
add_filter( 'gamipress_specific_trigger_get_id', 'gamipress_publishpress_cart_specific_trigger_get_id', 10, 3 );

/**
 * Extended meta data for event trigger logging
 *
 * @since 1.0.0
 *
 * @param array 	$log_meta
 * @param integer 	$user_id
 * @param string 	$trigger
 * @param integer 	$site_id
 * @param array 	$args
 *
 * @return array
 */
function gamipress_publishpress_cart_log_event_trigger_meta_data( $log_meta, $user_id, $trigger, $site_id, $args ) {

    switch ( $trigger ) {

        case 'gamipress_publishpress_cart_any_product_purchase':
        case 'gamipress_publishpress_cart_specific_product_purchase':
        case 'gamipress_publishpress_cart_refund_any_product_order':
        case 'gamipress_publishpress_cart_refund_specific_product_order':
        case 'gamipress_publishpress_cart_cancel_any_product_subscription':
        case 'gamipress_publishpress_cart_cancel_specific_product_subscription':
        case 'gamipress_publishpress_cart_renew_any_product_subscription':
        case 'gamipress_publishpress_cart_renew_specific_product_subscription':
            $log_meta['product_id'] = $args[0];
            $log_meta['order_id'] = $args[1];
            break;

    }

    return $log_meta;
}
add_filter( 'gamipress_log_event_trigger_meta_data', 'gamipress_publishpress_cart_log_event_trigger_meta_data', 10, 5 );