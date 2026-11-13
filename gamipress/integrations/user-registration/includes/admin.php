<?php
/**
 * Admin
 *
 * @package GamiPress\User_Registration\Admin
 * @since 1.0.1
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * User Registration & Membership automatic updates
 *
 * @since  1.0.1
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_user_registration_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress'] = __( 'User Registration & Membership integration', 'gamipress' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_user_registration_automatic_updates' );