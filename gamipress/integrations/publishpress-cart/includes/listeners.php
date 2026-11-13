<?php
/**
 * Listeners
 *
 * @package GamiPress\PublishPress_Cart\Listeners
 * @since 1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Purchase complete
 *
 * @since 1.0.0
 *
 * @param string    $status
 * @param array     $order_data
 * @param string    $order_type
 */
function gamipress_publishpress_cart_purchase_completed( $status, $order_data, $order_type ) {

    $user_id = $order_data['user']->ID;

    // Bail if user is not logged
    if ($user_id === 0) {
        return;
    }

    if ( $status === 'paid' ) {
        // Purchase any product
        do_action( 'gamipress_publishpress_cart_any_product_purchase', $order_data['product_id'], $order_data['ID'], $user_id );

        // Purchase specific product
        do_action( 'gamipress_publishpress_cart_specific_product_purchase', $order_data['product_id'], $order_data['ID'], $user_id );
    }

}
add_action( 'ppcart_order_complete', 'gamipress_publishpress_cart_purchase_completed', 10, 3 );

/**
 * Refund order
 *
 * @since 1.0.0
 *
 * @param string    $status
 * @param array     $order_data
 * @param string    $order_type
 */
function gamipress_publishpress_cart_purchase_refunded( $status, $order_data, $order_type ) {
    
    $user_id = get_current_user_id();

    // Bail if user is not logged
    if ($user_id === 0) {
        return;
    }

    // Bail if order status is not refunded
    if ( $order_data['status'] !== 'refunded' ) {
        return;
    }

    // Refund order for any product
    do_action( 'gamipress_publishpress_cart_refund_any_product_order', $order_data['product_id'], $order_data['ID'], $user_id );

    // Refund order for specific product
    do_action( 'gamipress_publishpress_cart_refund_specific_product_order', $order_data['product_id'], $order_data['ID'], $user_id );

}
add_action( 'ppcart_order_refunded', 'gamipress_publishpress_cart_purchase_refunded', 10, 3 );

/**
 * Cancel subscription
 *
 * @since 1.0.0
 *
 * @param string    $status
 * @param array     $order_data
 * @param string    $order_type
 */
function gamipress_publishpress_cart_subscription_canceled( $status, $order_data, $order_type ) {
    
    $user_id = get_current_user_id();

    // Bail if user is not logged
    if ($user_id === 0) {
        return;
    }

    // Cancel subscription for any product
    do_action( 'gamipress_publishpress_cart_cancel_any_product_subscription', $order_data['product_id'], $order_data['ID'], $user_id );

    // Cancel subscription for specific product
    do_action( 'gamipress_publishpress_cart_cancel_specific_product_subscription', $order_data['product_id'], $order_data['ID'], $user_id );

}
add_action( 'ppcart_subscription_canceled', 'gamipress_publishpress_cart_subscription_canceled', 10, 3 );

/**
 * Renew subscription
 *
 * @since 1.0.0
 *
 * @param string    $status
 * @param array     $order_data
 * @param string    $order_type
 */
function gamipress_publishpress_cart_subscription_renewed( $status, $order_data, $order_type ) {
    
    $user_id = get_current_user_id();

    // Bail if user is not logged
    if ($user_id === 0) {
        return;
    }

    // Renew subscription for any product
    do_action( 'gamipress_publishpress_cart_renew_any_product_subscription', $order_data['product_id'], $order_data['ID'], $user_id );

    // Renew subscription for specific product
    do_action( 'gamipress_publishpress_cart_renew_specific_product_subscription', $order_data['product_id'], $order_data['ID'], $user_id );

}
add_action( 'ppcart_renewal_payment', 'gamipress_publishpress_cart_subscription_renewed', 10, 3 );

