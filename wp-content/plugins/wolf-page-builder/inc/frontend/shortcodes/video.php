<?php
/**
 * Video shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_video' ) ) {
	/**
	 * Video shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_video( $atts ) {

		extract( shortcode_atts( array(
			'url' => 'http://vimeo.com/86571319',
			'max_width' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$url = esc_url( $url );
		$class = $extra_class;
		$max_width = sanitize_text_field( $max_width );
		$class = sanitize_text_field( $class );
		$inline_style = sanitize_text_field( $inline_style );

		$output = $style = '';
		$embed = wp_oembed_get( $url );

		$class .= ' wpb-video-container';

		if ( $max_width ) {
			$max_width = ( is_numeric( $max_width ) ) ? $max_width . 'px' : $max_width;
			$inline_style .= "max-width:$max_width;";
		}

		$output .= '<div  class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $style ) . '">' . $embed . '</div>';

		return $output;
	}
	add_shortcode( 'wpb_video', 'wpb_shortcode_video' );
}