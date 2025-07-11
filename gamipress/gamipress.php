<?php
/**
 * Plugin Name:     	GamiPress
 * Plugin URI:      	https://gamipress.com
 * Description:     	The most flexible and powerful gamification system for WordPress.
 * Version:         	7.4.9
 * Author:          	GamiPress
 * Author URI:      	https://gamipress.com/
 * Text Domain:     	gamipress
 * Domain Path: 		/languages/
 * Requires PHP:        7.0
 * Requires at least: 	4.4
 * Tested up to: 		6.8
 * License:         	GPLv3
 *
 * @package         	GamiPress
 * @author          	GamiPress <contact@gamipress.com>, Ruben Garcia <rubengcdev@gmail.com>
 * @copyright       	Copyright (c) GamiPress
*/

final class GamiPress {

	/**
	 * @var         GamiPress $instance The one true GamiPress
	 * @since       1.0.0
	 */
	private static $instance;

	/**
	 * @var         array $settings GamiPress stored settings
	 * @since       1.0.2
	 */
	public $settings = null;

	/**
	 * @var         array $points_types GamiPress registered points types
	 * @since       1.0.0
	 */
	public $points_types = array();

	/**
	 * @var         array $achievement_types GamiPress registered achievement types
	 * @since       1.0.0
	 */
	public $achievement_types = array();

	/**
	 * @var         array $achievement_types GamiPress registered rank types
	 * @since       1.3.1
	 */
	public $rank_types = array();

	/**
	 * @var         array $requirement_types GamiPress registered requirement types
	 * @since       1.0.5
	 */
	public $requirement_types = array();

    /**
     * @var         array $activity_triggers GamiPress registered activity triggers
     * @since       1.0.0
     */
    public $activity_triggers = array();

	/**
	 * @var         array $shortcodes GamiPress registered shortcodes
	 * @since       1.0.0
	 */
	public $shortcodes = array();

	/**
	 * @var         GamiPress_Database $db GamiPress database object
	 * @since       1.4.0
	 */
	public $db;

	/**
	 * @var         bool $db GamiPress network wide active mark
	 * @since       1.4.0
	 */
	public $network_wide_active = null;

	/**
	 * @var         array $cache GamiPress cache class
	 * @since       1.4.0
	 */
	public $cache = array();

	/**
	 * Get active instance
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      GamiPress self::$instance The one true GamiPress
	 */
	public static function instance() {

		if( ! self::$instance ) {

			self::$instance = new GamiPress();
			self::$instance->constants();
			self::$instance->libraries();
			self::$instance->classes();
			self::$instance->compatibility();
			self::$instance->includes();
			self::$instance->hooks();

		}

		return self::$instance;

	}

	/**
	 * Setup plugin constants
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function constants() {

		// Plugin version
		define( 'GAMIPRESS_VER', '7.4.9' );

		// Plugin file
		define( 'GAMIPRESS_FILE', __FILE__ );

		// Plugin path
		define( 'GAMIPRESS_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin URL
		define( 'GAMIPRESS_URL', plugin_dir_url( __FILE__ ) );

	}

    /**
     * Include plugin libraries
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function libraries() {

		// Custom Tables
		require_once GAMIPRESS_DIR . 'libraries/ct/init.php';
		require_once GAMIPRESS_DIR . 'libraries/ct-ajax-list-table/ct-ajax-list-table.php';

		// CMB2
		require_once GAMIPRESS_DIR . 'libraries/cmb2/init.php';
		require_once GAMIPRESS_DIR . 'libraries/cmb2-metatabs-options/cmb2_metatabs_options.php';
		require_once GAMIPRESS_DIR . 'libraries/cmb2-tabs/cmb2-tabs.php';
		require_once GAMIPRESS_DIR . 'libraries/cmb2-field-edd-license/cmb2-field-edd-license.php';

		// GamiPress CMB2 fields
		require_once GAMIPRESS_DIR . 'libraries/advanced-select-field-type.php';
		require_once GAMIPRESS_DIR . 'libraries/size-field-type.php';
		require_once GAMIPRESS_DIR . 'libraries/display-field-type.php';
		require_once GAMIPRESS_DIR . 'libraries/button-field-type.php';
		require_once GAMIPRESS_DIR . 'libraries/html-field-type.php';
		require_once GAMIPRESS_DIR . 'libraries/points-field-type.php';

    }

    /**
     * Include plugin classes
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function classes() {

        require_once GAMIPRESS_DIR . 'classes/database.php';

    }

	/**
	 * Include compatibility files
	 *
	 * @access      private
	 * @since       1.2.8
	 * @return      void
	 */
	private function compatibility() {

		// WordPress backward compatibility
		require_once GAMIPRESS_DIR . 'includes/compatibility/wordpress.php';

		// GamiPress backward compatibility
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.2.8.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.3.1.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.4.3.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.4.7.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.5.0.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.5.1.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.6.5.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.8.0.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.8.6.php';
		require_once GAMIPRESS_DIR . 'includes/compatibility/1.8.7.php';

	}

	/**
	 * Include plugin files
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function includes() {

		// The rest of files
		require_once GAMIPRESS_DIR . 'includes/admin.php';
		require_once GAMIPRESS_DIR . 'includes/custom-tables.php';
		require_once GAMIPRESS_DIR . 'includes/post-types.php';
		require_once GAMIPRESS_DIR . 'includes/privacy.php';
		require_once GAMIPRESS_DIR . 'includes/emails.php';
		require_once GAMIPRESS_DIR . 'includes/activity-functions.php';
		require_once GAMIPRESS_DIR . 'includes/ajax-functions.php';
		require_once GAMIPRESS_DIR . 'includes/api.php';
		require_once GAMIPRESS_DIR . 'includes/blocks.php';
		require_once GAMIPRESS_DIR . 'includes/cache.php';
		require_once GAMIPRESS_DIR . 'includes/functions.php';
		require_once GAMIPRESS_DIR . 'includes/listeners.php';
		require_once GAMIPRESS_DIR . 'includes/network.php';
		require_once GAMIPRESS_DIR . 'includes/scripts.php';
		require_once GAMIPRESS_DIR . 'includes/shortcodes.php';
		require_once GAMIPRESS_DIR . 'includes/filters.php';
		require_once GAMIPRESS_DIR . 'includes/rules-engine.php';
		require_once GAMIPRESS_DIR . 'includes/tags.php';
		require_once GAMIPRESS_DIR . 'includes/template-functions.php';
		require_once GAMIPRESS_DIR . 'includes/triggers.php';
		require_once GAMIPRESS_DIR . 'includes/users.php';
		require_once GAMIPRESS_DIR . 'includes/widgets.php';

	}

    /**
     * Include integrations files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function integrations() {

        $integrations_dir = GAMIPRESS_DIR . 'integrations';

        // Setup active plugins
        $active_plugins = array();

        if( function_exists( 'get_option' ) ) {
            $active_plugins = (array) get_option( 'active_plugins', array() );
        }

        // Setup active sitewide plugins
        $active_sitewide_plugins = array();

        if ( is_multisite() && function_exists( 'get_site_option' ) ) {
            $active_sitewide_plugins = get_site_option( 'active_sitewide_plugins' );

            if( ! is_array( $active_sitewide_plugins ) ) {
                $active_sitewide_plugins = array();
            }
        }

        $integrations = @opendir( $integrations_dir );

        while ( ( $integration = @readdir( $integrations ) ) !== false ) {

            if ( $integration === '.' || $integration === '..' || $integration === 'index.php' ) {
                continue;
            }

            /**
             * Filter to allow third party plugins skip any integration
             *
             * @since 1.0.0
             *
             * @param bool      $skip
             * @param string    $integration The integration slug as named in gamipress/includes/integrations
             * @param array     $active_plugins
             * @param array     $active_sitewide_plugins
             *
             * @return bool
             */
            if( apply_filters( 'gamipress_skip_integration', false, $integration, $active_plugins, $active_sitewide_plugins ) ) {
                continue;
            }

            // Skip if integration is already active
            if( $this->is_integration_active( $integration, $active_plugins, $active_sitewide_plugins ) ) {
                continue;
            }

            $integration_file = $integrations_dir . DIRECTORY_SEPARATOR . $integration . DIRECTORY_SEPARATOR . $integration . '.php';

            // Skip if no file to load
            if( ! file_exists( $integration_file ) ) {
                continue;
            }

            require_once $integration_file;

        }

        closedir( $integrations );

    }

    /**
     * Include integrations files
     *
     * @access      private
     * @since       1.0.0
     * @param       string  $integration
     * @param       array   $active_plugins
     * @param       array   $active_sitewide_plugins
     * @return      bool
     */
    private function is_integration_active( $integration, $active_plugins, $active_sitewide_plugins ) {

        $plugins = array(
            "gamipress-{$integration}-integration/gamipress-{$integration}.php",
            "gamipress-{$integration}-integration/gamipress-{$integration}-integration.php",
        );

        if( $integration === 'elementor' ) {
            $plugins = array(
                "gamipress-{$integration}-forms-integration/gamipress-{$integration}-forms.php",
            );
        }

        foreach( $plugins as $plugin ) {

            // Bail if plugin is active
            if( in_array( $plugin, $active_plugins, true ) ) {
                return true;
            }

            // Bail if plugin is network wide active
            if ( isset( $active_sitewide_plugins[$plugin] ) ) {
                return true;
            }

            // Consider integration active during it's activation
            if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'activate'
                && isset( $_REQUEST['plugin'] ) && $_REQUEST['plugin'] === $plugin ) {
                return true;
            }

            // Support for bulk activate
            if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'activate-selected'
                && isset( $_REQUEST['checked'] ) && is_array( $_REQUEST['checked'] )
                && in_array( $plugin, $_REQUEST['checked'] ) ) {
                return true;
            }

        }

        return false;

    }

	/**
	 * Setup plugin hooks
	 *
	 * @access      private
	 * @since       1.0.0
	 * @return      void
	 */
	private function hooks() {

		// Setup our activation and deactivation hooks
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		// Hook in all our important pieces
		add_action( 'plugins_loaded', array( $this, 'pre_init' ), 20 );
		add_action( 'plugins_loaded', array( $this, 'init' ), 50 );
        add_action( 'plugins_loaded', array( $this, 'post_init' ), 999 );
		add_action( 'init', array( $this, 'load_textdomain' ), 10 );

    }

	/**
	 * Pre init function
	 *
	 * @access      private
	 * @since       1.4.6
	 * @return      void
	 */
	function pre_init() {

        // Load all integrations
        $this->integrations();

		global $wpdb;

		$this->db = new GamiPress_Database();

		// Setup WordPress database tables
		$this->db->posts 				= $wpdb->posts;
		$this->db->postmeta 			= $wpdb->postmeta;
		$this->db->users 				= $wpdb->users;
		$this->db->usermeta 			= $wpdb->usermeta;

		// Setup GamiPress database tables
		$this->db->logs 				= $wpdb->gamipress_logs;
		$this->db->logs_meta 			= $wpdb->gamipress_logs_meta;
		$this->db->user_earnings 		= $wpdb->gamipress_user_earnings;
		$this->db->user_earnings_meta 	= $wpdb->gamipress_user_earnings_meta;

        // Trigger our action to let other plugins know that GamiPress is getting initialized
        do_action( 'gamipress_pre_init' );

	}

	/**
	 * Init function
	 *
	 * @access      private
	 * @since       1.4.0
	 * @return      void
	 */
	function init() {

		// Trigger our action to let other plugins know that GamiPress is ready
		do_action( 'gamipress_init' );

	}

    /**
     * Post init function
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    function post_init() {

        // Trigger our action to let other plugins know that GamiPress has been initialized
        do_action( 'gamipress_post_init' );

    }

	/**
	 * Activation hook for the plugin.
	 */
	function activate() {

		// Include our important bits
		$this->libraries();
		$this->includes();

		require_once GAMIPRESS_DIR . 'includes/install.php';

		gamipress_install();

	}

	/**
	 * Deactivation hook for the plugin.
	 */
	function deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Internationalization
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      void
	 */
	public function load_textdomain() {

		// Set filter for language directory
		$lang_dir = GAMIPRESS_DIR . '/languages/';
		$lang_dir = apply_filters( 'gamipress_languages_directory', $lang_dir );

		// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), 'gamipress' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'gamipress', $locale );

		// Setup paths to current locale file
		$mofile_local   = $lang_dir . $mofile;
		$mofile_global  = WP_LANG_DIR . '/gamipress/' . $mofile;

		if( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/gamipress/ folder
			load_textdomain( 'gamipress', $mofile_global );
		} elseif( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/gamipress/languages/ folder
			load_textdomain( 'gamipress', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'gamipress', false, $lang_dir );
		}

	}

}

/**
 * The main function responsible for returning the one true GamiPress instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GamiPress The one true GamiPress
 */
function GamiPress() {
	return GamiPress::instance();
}

GamiPress();