<?php
/**
 * Highlight shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_highlight' ) ) {
	/**
	 * Highlight  shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_highlight( $atts, $content = null ) {
		$color = ( isset( $atts['color'] ) ) ? $atts['color'] : 'yellow';
		return '<span class="wpb-highlight-' . esc_attr( $atts['color'] ) . '">' . sanitize_text_field( $content ) . '</span>';

	}
	add_shortcode( 'wpb_highlight', 'wpb_shortcode_highlight' );
}