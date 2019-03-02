<?php
/**
 * Map shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_google_map' ) ) {
	/**
	 * Map shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_google_map( $atts ) {

		extract( shortcode_atts( array(
			'html' => '',
			'height' => 250,
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$class = $extra_class;
		$inline_style = sanitize_text_field( $inline_style );

		$output = '';

		$url = wpb_get_iframe_src( wpb_decode_textarea_html( $html ) );

		// debug( $url );

		$class .= 'wpb-map-container';

		$output .= '<div';

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '"';

		$output .= '>';
		$output .= '<iframe src="' . esc_url( $url ) .'" height="' . esc_attr( $height  ) . '" style="border:0" allowfullscreen></iframe>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'wpb_google_map', 'wpb_shortcode_google_map' );
}