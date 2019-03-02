<?php
/**
 * Raw HTML shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_raw_html' ) ) {
	/**
	 * Raw HTML
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_raw_html( $atts ) {
		extract( shortcode_atts(  array(
			'html' => '',
		), $atts ) );

		return wpb_decode_textarea_html( $html );
	}
	add_shortcode( 'wpb_raw_html', 'wpb_shortcode_raw_html' );
}