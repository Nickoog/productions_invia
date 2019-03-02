<?php
/**
 * Row shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_row' ) ) {
	/**
	 * Wrapper Shortcode
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	function wpb_shortcode_row( $atts, $content = null ) {

		extract( shortcode_atts(  array(
			'layout' => '1-cols',
			'content_type' => 'standard',
			'margin_top' => '',
			'margin_bottom' => '',
			'anchor' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		// class
		$class = $extra_class;
		$class .= " wpb-row wpb-row-$content_type-width wpb-row-$layout";

		if ( '' != $margin_top ) {
			$margin_top = ( is_numeric( $margin_top ) ) ? absint( $margin_top ) . 'px' : $margin_top;
			$inline_style .= 'margin-top:' . esc_attr( $margin_top ) . ';';
		}

		if ( '' != $margin_bottom ) {
			$margin_bottom = ( is_numeric( $margin_bottom ) ) ? absint( $margin_bottom ) . 'px' : $margin_bottom;
			$inline_style .= 'margin-bottom:' . esc_attr( $margin_bottom ) . ';';
		}

		$output = '<div';

		if ( $anchor ) {
			$output .= ' id="' . esc_attr( $anchor ) . '"';
		}

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '"';

		$output .= '>';
		
			$output .= do_shortcode( $content );
		
		$output .= '</div><!--.wpb-row-->';

		return $output;
	}
	add_shortcode( 'wpb_row', 'wpb_shortcode_row' );
}