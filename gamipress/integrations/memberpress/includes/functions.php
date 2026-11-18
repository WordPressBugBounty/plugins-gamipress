<?php
/**
 * Functions
 *
 * @package GamiPress\MemberPress\Functions
 * @since 1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Overrides GamiPress AJAX Helper for selecting posts
 *
 * @since 1.0.0
 */
function gamipress_memberpress_ajax_get_posts() {

    // Security check, forces to die if not security passed
    check_ajax_referer( 'gamipress_admin', 'nonce' );

    // Check if user can manage GamiPress
    if( ! current_user_can( gamipress_get_manager_capability() ) ) {
        wp_send_json_error( __( 'You\'re not allowed to perform this action.', 'gamipress' ) );
    }

    global $wpdb;

    $results = array();

    // Pull back the search string
    $search = isset( $_REQUEST['q'] ) ? $wpdb->esc_like( sanitize_text_field( $_REQUEST['q'] ) ) : '';

    if( isset( $_REQUEST['post_type'] ) && in_array( 'memberpress_recurring', $_REQUEST['post_type'] ) ) {

        $posts = gamipress_memberpress_get_posts();

        foreach ( $posts as $post ) {

            if( ! empty( $search ) ) {
                if( strpos( strtolower( $post['name'] ), strtolower( $search ) ) === false ) {
                    continue;
                }
            }

            // Results should meet same structure like posts
            $results[] = array(
                'ID' => $post['id'],
                'post_title' => $post['name'],
            );

        }

        // Return our results
        wp_send_json_success( $results );
        die;

    }

}
add_action( 'wp_ajax_gamipress_get_posts', 'gamipress_memberpress_ajax_get_posts', 5 );

/**
 * Get the posts
 *
 * @since 1.0.0
 *
 * @return array
 */
function gamipress_memberpress_get_posts(){

    $products = array();

    $args = array(
        'post_type'      => 'memberpressproduct', 
        'posts_per_page' => -1,                    
        'post_status'    => 'publish',             
        'orderby'        => 'ID',
        'order'          => 'ASC'
    );

    $posts = get_posts( $args );
    
    foreach ( $posts as $post ) {

        $period_type = get_post_meta( $post->ID, '_mepr_product_period_type', true );

        if ( $period_type === 'lifetime' ) continue;

        $products[] = array(
            'id'    => $post->ID,
            'name'  => get_the_title( $post->ID ),
        );
    }

    return $products;

}

/**
 * Get the post title
 *
 * @since 1.0.0
 *
 * @param int $post_id
 *
 * @return string|null
 */
function gamipress_memberpress_get_post_title( $post_id ) {

    // Empty title if no ID provided
    if( absint( $post_id ) === 0 ) {
        return '';
    }

    return get_the_title( $post_id );

}
