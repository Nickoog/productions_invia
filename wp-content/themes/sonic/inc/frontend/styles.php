<?php
/**
 * Sonic styles
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_remove_unwanted_plugin_style' ) ) {
	/**
	 * Remove several plugin styles and scripts
	 * Allow an easier customization
	 *
	 * @since Sonic 1.0.0
	 */
	function sonic_remove_unwanted_plugin_style() {
		
		// We will redesign the tour dates plugin from scratch so dequeue de stylesheet
		wp_dequeue_style( 'wolf-portfolio' );
		wp_deregister_style( 'wolf-portfolio' );
		wp_dequeue_style( 'wolf-videos' );
		wp_deregister_style( 'wolf-videos' );
		wp_dequeue_style( 'wolf-albums' );
		wp_deregister_style( 'wolf-albums' );
		wp_dequeue_style( 'wolf-discography' );
		wp_deregister_style( 'wolf-discography' );
		wp_dequeue_style( 'wolf-tour-dates' );
		wp_deregister_style( 'wolf-tour-dates' );
		wp_dequeue_style( 'wbounce-style' );
		wp_deregister_style( 'wbounce-style' );
	}
	add_action( 'wp_enqueue_scripts', 'sonic_remove_unwanted_plugin_style' );
}

if ( ! function_exists( 'sonic_enqueue_styles' ) ) {
	/**
	 * Enqueue CSS stylsheets
	 * JS scripts are separated and can be found in includes/scripts.php
	 * @since Sonic 1.0.0
	 */
	function sonic_enqueue_styles() {

		$lightbox = wolf_get_theme_mod( 'lightbox', 'swipebox' );
		$default_lightbox = 'swipebox';

		// WP icons
		wp_enqueue_style( 'dashicons' );

		// Media elements (for AJAX processed content)
		wp_enqueue_style( 'wp-mediaelement' );

		// Animate
		wp_enqueue_style( 'animate-css', WOLF_THEME_CSS . '/lib/animate.min.css', array(), '3.3.0' );

		// Check if WPB is activated
		if ( sonic_has_wpb() ) {
			// enqueue icons styles of the wolf page builder plugin if activated
			wp_enqueue_style( 'wpb-icon-pack' );
		
		} else {
			// enqeue icons from theme if WPB is not activated
			wp_enqueue_style( 'sonic-icon-pack', WOLF_THEME_CSS . '/lib/icon-pack.min.css', array(), WOLF_THEME_VERSION );
		}

		if ( 'swipebox' == $lightbox ) {
			
			// enqueue swipebox styles
			wp_enqueue_style( 'swipebox', WOLF_THEME_CSS. '/lib/swipebox.min.css', array(), '1.3.0' );
		
		} elseif ( 'fancybox' == $lightbox ) {
			
			// enqueue swipebox styles
			wp_enqueue_style( 'fancybox', WOLF_THEME_CSS. '/lib/fancybox.css', array(), '2.1.5' );
		}

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

			// Normalize
			wp_enqueue_style( 'normalize', WOLF_THEME_CSS. '/lib/normalize.min.css', array(), '3.0.0' );

			// Flexslider
			wp_enqueue_style( 'flexslider', WOLF_THEME_CSS. '/lib/flexslider.css', array(), '2.2.0' );

			// Main stylsheet
			wp_enqueue_style( 'sonic-style', WOLF_THEME_CSS. '/main.css', array(), WOLF_THEME_VERSION );

		} else {

			// Main stylsheet with libraries
			wp_enqueue_style( 'sonic-style', WOLF_THEME_CSS. '/main.min.css', array(), WOLF_THEME_VERSION );
		}

		wp_enqueue_style( 'sonic-single-post-style', WOLF_THEME_CSS. '/single-post.css', array(), WOLF_THEME_VERSION );

		// WP default Stylesheet
		wp_enqueue_style( 'sonic-default', get_stylesheet_uri(), array(), WOLF_THEME_VERSION );
	}
	add_action( 'wp_enqueue_scripts', 'sonic_enqueue_styles', 1 );
}

if ( ! function_exists( 'sonic_enable_rt_support' ) ) {
	/**
	 * Enable rtl support
	 *
	 * Enqueue rtl.css
	 *
	 * @since Sonic 1.0.0
	 */
	function sonic_enable_rt_support() {

		wp_enqueue_style( wolf_get_theme_slug() . '-rtl', WOLF_THEME_CSS. '/rtl.css', array(), WOLF_THEME_VERSION );

	}
	//add_action( 'wp_enqueue_scripts', 'wolf_enable_rt_support' );
}