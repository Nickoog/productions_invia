<?php
/**
 * Empty space shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_empty_space' ) ) {
	/**
	 * Video shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_empty_space( $atts ) {

		extract( shortcode_atts( array(
			'height' => 50,
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$height = absint( $height );
		$height = ( is_numeric( $height ) ) ? absint( $height ) . 'px' : $height;

		$style = $inline_style;
		$style .= " height:$height;";

		// class
		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= 'wpb-clear';

		$output = '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $style ) . '"></div>';

		return $output;
	}
	add_shortcode( 'wpb_empty_space', 'wpb_shortcode_empty_space' );
}