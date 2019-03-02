<?php
/**
 * Core functions
 *
 * General core functions available on admin and frontend
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get available blog display options
 *
 * Can be used in WPB extension
 *
 * @return array
 */
function sonic_get_blog_post_display_options() {
	return array(
		'grid2' => esc_html__( 'Grid', 'sonic' ),
		'grid' => esc_html__( 'Square Grid', 'sonic' ),
		'grid3' => esc_html__( 'Portrait Grid', 'sonic' ),
		'photo' => esc_html__( 'Photo Style', 'sonic' ),
		'classic' =>  esc_html__( 'Classic', 'sonic' ),
	);
}
 
if ( ! function_exists( 'sonic_format_number' ) ) {
	/**
	 * Format number : 1000 -> 1K
	 *
	 * @since Sonic 1.0.0
	 * @param int $n
	 * @return string
	 */
	function sonic_format_number( $n ) {

		$s   = array( 'K', 'M', 'G', 'T' );
		$out = '';
		while ( $n >= 1000 && count( $s ) > 0) {
			$n   = $n / 1000.0;
			$out = array_shift( $s );
		}
		return round( $n, max( 0, 3 - strlen( (int)$n ) ) ) ." $out";
	}
}

if ( ! function_exists( 'sonic_has_wpb' ) ) {
	/**
	 * Check if Wolf Page Builder is activated
	 *
	 * @since Sonic 1.0.0
	 * @return bool
	 */
	function sonic_has_wpb() {

		if ( class_exists( 'Wolf_Page_Builder' ) ) {
			return true;
		}
	}
}

/**
 * Filter theme menu layour mod
 *
 * If WPM is not installed and the menu with language switcher is set, return another menu layout instead
 *
 * @param $mod
 * @return $mod
 */
function sonic_filter_menu_layout_theme_mods( $mod ) {

	if ( 'centered-wpml' == $mod && ! function_exists( 'icl_object_id' ) ) {
		$mod = 'centered-socials';
	}

	return $mod;
}
add_filter( 'theme_mod_menu_layout', 'sonic_filter_menu_layout_theme_mods' );