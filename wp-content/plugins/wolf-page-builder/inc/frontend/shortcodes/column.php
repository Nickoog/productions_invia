<?php
/**
 * Column shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_col' ) ) {
	/**
	 * Column shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_col( $atts, $content = null ) {

		extract( shortcode_atts(  array(
			'col' => '',
			'first' => '',
			'last' => '',
			'anchor' => '',
			'class' => '',
			'extra_class' => '',
			'inline_style' => '',
		), $atts ) );

		$output = '';
		$class .= ' wpb-col wpb-column ' . $extra_class;

		if ( $col ) {
			$class .= " $col";
		}

		if ( $first ) {
			$class .= ' wpb-first';
		}

		if ( $last ) {
			$class .= ' wpb-last';
		}

		$output .= '<div';

		if ( $anchor ) {
			$output .= ' id="' . sanitize_title( $anchor ) . '"';
		}

		if ( $class ) {
			$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '"';
		}

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		$output .= '>';

		$output .= do_shortcode( $content ) . '</div><!--.wpb-col-->';

		if ( preg_match( '#wpb-last#', $class ) ) {
			//$output .= '<div class="wpb-clearfix"></div>';
		}

		return $output;
	}
	add_shortcode( 'wpb_col', 'wpb_shortcode_col' );
}