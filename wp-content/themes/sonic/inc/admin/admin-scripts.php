<?php
/**
 * Sonic Admin scripts
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_enqueue_admin_scripts' ) ) {
	/**
	 * Enqueue admin scripts
	 *
	 * Styles and scripts for the theme options page
	 *
	 * @since Sonic 1.0.0
	 */
	function sonic_enqueue_admin_scripts() {
		
		$sonic_slug = wolf_get_theme_slug();

		// CSS
		wp_enqueue_media();
		wp_enqueue_style( $sonic_slug . '-admin', WOLF_THEME_CSS. '/admin/admin.css', array(), WOLF_THEME_VERSION );
	}
	add_action( 'admin_enqueue_scripts', 'sonic_enqueue_admin_scripts' );
}