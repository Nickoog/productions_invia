<?php
/**
 * Dropcap shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_dropcap' ) ) {
	/**
	 * Dropcap shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_dropcap( $atts ) {

		extract( shortcode_atts( array(
			'text' => '',
			'font' => '',
			'font_style' => 'normal',
		), $atts ) );

		$style = '';
		$style .= "font-style:$font_style;";

		if ( $font ) {
			$style .= "font-family:$font;";
		}

		return '<span class="wpb-dropcap" style="'. wpb_esc_style_attr( $style ) .'">' . sanitize_text_field( $text ) . '</span>';
	}
	add_shortcode( 'wpb_dropcap', 'wpb_shortcode_dropcap' );
}