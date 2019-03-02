<?php
/**
 * RevSlider shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_revslider' ) ) {
	/**
	 * RevSlider shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_revslider( $atts ) {

		extract( shortcode_atts( array(
			'slider' => '',
		), $atts ) );

		$output = '';
		ob_start();
		if ( function_exists( 'putRevSlider' ) ) {
			putRevSlider( esc_attr( $slider ) );
		}
		$output .= ob_get_clean();

		return $output;
	}
	add_shortcode( 'wpb_revslider', 'wpb_shortcode_revslider' );
}