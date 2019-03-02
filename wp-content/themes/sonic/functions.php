<?php
/**
 * Sonic functions and definitions
 *
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! function_exists( 'sonic_setup_config' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features using the Wolf_Theme_Framework class
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function sonic_setup_config() {
		/**
		 * Set the content width based on the theme's design and stylesheet.
		 *
		 * @since Sonic 1.0.0
		 */
		$GLOBALS['content_width'] = apply_filters( 'sonic_content_width', 750 );

		/**
		 *  Require the wolf themes framework core file
		 */
		require_once get_template_directory() . '/wp-wolf-framework/wolf-framework.php';

		/**
		 * Set theme main settings
		 *
		 * We this array to configure the main theme settings
		 */
		$sonic_theme = array(

			/* Menus (id => name) */
			'menus' => array(
				'primary-left' => esc_html__( 'Main Menu Left Part', 'sonic' ),
				'primary-right' => esc_html__( 'Main Menu Right Part', 'sonic' ),
				'primary' => esc_html__( 'Main Menu Standard', 'sonic' ),
				'tertiary' => esc_html__( 'Bottom Menu', 'sonic' ),
			),

			/**
			 *  We define wordpress thumbnail sizes that we will use in our design
			 */
			'images' => array(

				/**
				 * Create Wolf Page Builder image sizes if the plugin is not installed
				 * We will use the same image size names to avoid duplicated image sizes in the case the plugin is active
				 */
				'sonic-thumb' => array( 640, 360, true ),
				'sonic-photo' => array( 640, 640, false ),
				'sonic-video-thumb' => array( 480, 270, true ),
				'sonic-portrait' => array( 600, 900, true ),
				'sonic-2x1' => array( 960, 480, true ), // landscape
				'sonic-2x2' => array( 960, 960, true ), // square
				'sonic-1x1' => array( 360, 360, true ), // square small
				'sonic-1x2' => array( 480, 960, true ), // portrait
				'sonic-XL' => array( 2000, 1500, false ), // XL
			),
		);
		WLFRMK( $sonic_theme );
	}
} // end if function exists
sonic_setup_config();