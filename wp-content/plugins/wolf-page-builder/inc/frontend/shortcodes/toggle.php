<?php
/**
 * Toggle shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_toggle' ) ) {
	/**
	 * Toggle shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_toggle( $atts ) {

		extract( shortcode_atts(  array(
			'title' => '',
			'editorcontent' => '',
			'open' => false,
		), $atts ) );

		wp_enqueue_script( 'wpb-toggles' );

		$output = '';
		$class = 'wpb-toggle';
		$content_class = 'wpb-toggle-content';
		
		if ( $open ) {
			$class .= ' wpb-toggle-open';
		} else {
			$class .= ' wpb-toggle-close';
		}
		
		$output .= '<div class="' . wpb_sanitize_html_classes( $class ) . '">';
			$output .= '<h5 class="wpb-toggle-title"><span class="wpb-toggle-plus"></span><span class="wpb-toggle-title-text">' . sanitize_text_field( $title ) . '</span></h5>';
			$output .= '<div class="' . wpb_sanitize_html_classes( $content_class ) . '">';
			$output .= wpb_format_editor_content( $editorcontent );
			$output .= '</div><!--.wpb-toggle-content-->';
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'wpb_toggle', 'wpb_shortcode_toggle' );
}