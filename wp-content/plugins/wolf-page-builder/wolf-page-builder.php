<?php
/**
 * Plugin Name: Wolf Page Builder
 * Plugin URI: https://wolfthemes.com/plugin/wolf-page-builder
 * Description: A Super Easy-to-use WordPress Page Builder.
 * Version: 2.9.3
 * Author: WolfThemes
 * Author URI: https://wolfthemes.com
 * Requires at least: 4.6
 * Tested up to: 4.7.2
 *
 * Text Domain: wolf-page-builder
 * Domain Path: /languages/
 *
 * @package WolfPageBuilder
 * @category Core
 * @author WolfThemes
 * 
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at https://themeforest.net/user/Wolf-Themes/portfolio?ref=Wolf-Themes
 * will have access to support for this plugin in the forums
 * https://docs.wolfthemes.com/
 *
 * Copyright (C) 2016 Constantin Saguin
 * This WordPress Plugin is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * It is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * See https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Page_Builder' ) ) :
/**
 * Main Wolf Page Builder Class
 *
 * @class Wolf_Page_Builder
 * @version 2.9.3
 */
final class Wolf_Page_Builder {

	/**
	 * @var string
	 */
	private $required_php_version = '5.4.0';

	/**
	 * @var string
	 */
	public $version = '2.9.3';

	/**
	 * @var Wolf Page Builder The single instance of the class
	 */
	protected static $_instance = null;

	/**
	 * @var the URL where to fetch the updated files
	 */
	private $update_url = 'https://plugins.wolfthemes.com/update';

	/**
	 * @var the support forum URL
	 */
	private $support_url = 'https://docs.wolfthemes.com/';

	/**
	 * Main Wolf Page Builder Instance
	 *
	 * Ensures only one instance of Wolf Page Builder is loaded or can be loaded.
	 *
	 * @static
	 * @see WPB()
	 * @return Wolf Page Builder - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wolf-page-builder' ), '1.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'wolf-page-builder' ), '1.0' );
	}

	/**
	 * Wolf Page Builder Constructor.
	 */
	public function __construct() {

		if ( phpversion() < $this->required_php_version ) {
			add_action( 'admin_notices', array( $this, 'warning_php_version' ) );
			return;
		}
		
		// $this->version = time();
		$this->define_constants();
		$this->includes();
		$this->init_hooks();

		do_action( 'wolf_page_builder_loaded' );
	}

	/**
	 * Display error notice if PHP version is too low
	 */
	public function warning_php_version() {
		?>
		<div class="notice notice-error">
			<p><?php

			printf(
				esc_html__( '%1$s needs at least PHP %2$s installed on your server. You have version %3$s currently installed. Please contact your hosting service provider if you\'re not able to update PHP by yourself.', 'wolf-page-builder' ),
				'Wolf Page Builder',
				$this->required_php_version,
				phpversion()
			);
			?></p>
		</div>
		<?php
	}

	/**
	 * Hook into actions and filters
	 */
	private function init_hooks() {
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
		add_action( 'init', array( $this, 'init' ), 0 );

		// Includes element after init hook to allow filtering by theme
		add_action( 'init', array( $this, 'include_elements' ) );
	}

	/**
	 * Activation function
	 */
	public function activate() {
		
		do_action( 'wpb_activated' );
	}

	/**
	 * Define WPB Constants
	 */
	private function define_constants() {
		
		// Upload dir
		$wpb_upload_dir = wp_upload_dir();

		if ( is_file( $this->plugin_path() . '/dev.config.php' ) ) {
			include_once( 'dev.config.php' );
		}

		$constants = array(
			'WPB_DEV' => false,
			'WPB_DIR' => $this->plugin_path(),
			'WPB_URI' => $this->plugin_url(),
			'WPB_CSS' => $this->plugin_url() . '/assets/css',
			'WPB_JS' => $this->plugin_url() . '/assets/js',
			'WPB_IMG' => $this->plugin_url() . '/assets/img',
			'WPB_SLUG' => plugin_basename( dirname( __FILE__ ) ),
			'WPB_PATH' => plugin_basename( __FILE__ ),
			'WPB_VERSION' => $this->version,
			'WPB_UPDATE_URL' => $this->update_url,
			'WPB_SUPPORT_URL' => $this->support_url,
			'WPB_DOC_URI' => 'https://docs.wolfthemes.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
			'WPB_WOLF_DOMAIN' => 'wolfthemes.com',
			'WPB_UPLOAD_DIR' => $wpb_upload_dir['basedir'] . '/wpb-export-tmp',
			'WPB_UPLOAD_URI' => $wpb_upload_dir['baseurl'] . '/wpb-export-tmp',
		);

		foreach ( $constants as $name => $value ) {
			$this->define( $name, $value );
		}

		// var_dump( WPB_UPLOAD_URI );
	}

	/**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {

		include_once( 'inc/wpb-core-functions.php' );
		include_once( 'inc/wpb-google-fonts.php' );
		
		include_once( 'inc/class-wpb-mailchimp.php' );
		require_once( 'inc/class-widget-mailchimp.php' );

		// Includes all files containing global variables
		include_once( 'inc/globals/custom-colors.php' );
		include_once( 'inc/globals/icons.php' );
		include_once( 'inc/globals/image-sizes.php' );
		include_once( 'inc/globals/team-member-socials.php' );

		if ( $this->is_request( 'admin' ) ) {
			include_once( 'inc/admin/class-wpb-admin.php' );
		}

		if ( $this->is_request( 'ajax' ) ) {
			$this->ajax_includes();
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->frontend_includes();
		}
	}

	/**
	 * Include required ajax files.
	 */
	public function ajax_includes() {
		include_once( 'inc/ajax/wpb-ajax-functions.php' );
	}

	/**
	 * Include required frontend files.
	 */
	public function frontend_includes() {

		include_once( 'inc/frontend/wpb-conditional-functions.php' );
		include_once( 'inc/frontend/wpb-functions.php' );
		include_once( 'inc/frontend/wpb-template-hooks.php' );
		include_once( 'inc/frontend/class-wpb-template-loader.php' ); // Template Loader
		include_once( 'inc/frontend/wpb-scripts.php' );
	}

	/**
	 * Include element files
	 */
	public function include_elements() {
		// Includes all shortcode files
		
		// Get elements list
		$elements_slugs = wpb_get_element_list();

		foreach ( $elements_slugs as $slug ) {
			
			if ( is_file( wpb_locate_file( 'shortcodes/' . sanitize_title_with_dashes( $slug ) . '.php', 'frontend' ) ) ) {
				include_once( wpb_locate_file( 'shortcodes/' . sanitize_title_with_dashes( $slug ) . '.php', 'frontend' ) );
			}
		}
	}

	/**
	 * Function used to Init Wolf Page Builder Template Functions - This makes them pluggable by plugins and themes.
	 */
	public function include_template_functions() {
		include_once( 'inc/frontend/wpb-template-functions.php' );
	}

	/**
	 * Init Wolf Page Builder when WordPress Initialises.
	 */
	public function init() {
		// Before init action
		do_action( 'before_wolf_page_builder_init' );

		// Set up localisation
		$this->load_plugin_textdomain();

		// Init action
		do_action( 'wolf_page_builder_init' );
	}

	/**
	 * Loads the plugin text domain for translation
	 */
	public function load_plugin_textdomain() {

		$domain = 'wolf-page-builder';
		$locale = apply_filters( 'wolf-page-builder', get_locale(), $domain );
		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Get the plugin url.
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Get the extension path.
	 * @return string
	 */
	public function extension_path() {
		return apply_filters( 'wpb_extension_path', 'wpb-extend/' );
	}

	/**
	 * Get the template path.
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'wpb_template_path', 'wpb-extend/templates/' );
	}

	/**
	 * Get Ajax URL.
	 * @return string
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}
}
endif;

/**
 * Returns the main instance of WPB to prevent the need to use globals.
 *
 * @return Wolf_Page_Builder
 */
function WPB() {
	return Wolf_Page_Builder::instance();
}

WPB(); // Go