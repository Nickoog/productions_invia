<?php
/**
 * Accordion shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_accordion_container' ) ) {
	/**
	 * Accordion container shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_accordion_container( $atts, $content = null ) {
		
		extract( shortcode_atts(  array(
			'anchor' => '',
			'extra_class' => '',
			'inline_style' => '',
		), $atts ) );

		$output = '';
		$class = $extra_class;
		$rand = rand( 0,9999 );
		$anchor = ( $anchor ) ? $anchor : 'wpb-accordion-' . absint( $rand );

		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'wpb-accordion' );

		$class .= ' wpb-accordion wpb-clearfix';
		
		$output .= '<div';

		$output .= ' id="' . esc_attr( $anchor ) . '"';

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		if ( $class ) {
			$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '"';
		}

		$output .= '>';
		
		$output .= do_shortcode( $content );
		
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'wpb_accordion_container', 'wpb_shortcode_accordion_container' );
}

if ( ! function_exists( 'wpb_shortcode_accordion' ) ) {
	/**
	 * Accordion shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_accordion( $atts ) {
		extract( shortcode_atts(  array(
			'title' => '',
			'editorcontent' => '',
		), $atts ) );

		$output = '';
		$output .= '<h5 class="wpb-accordion-tab"><a href="#">' . sanitize_text_field( $title ) . '</a></h5>';
		$output .= '<div>';
		$output .= wpb_format_editor_content( $editorcontent );
		// $output .= $editorcontent;
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'wpb_accordion', 'wpb_shortcode_accordion' );
}