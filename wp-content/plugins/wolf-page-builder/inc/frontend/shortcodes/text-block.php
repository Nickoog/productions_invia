<?php
/**
 * Text block shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_text_block_shortcode' ) ) {
	/**
	 * Text block slider shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_text_block_shortcode( $atts ) {

		extract( shortcode_atts(  array(
			'editorcontent' => '',
			'animation' => '',
			'animation_delay' => '',
			'extra_class' => '',
			'inline_style' => '',
			'anchor' => '',
		), $atts ) );

		$output = '';
		$editorcontent = wpb_format_editor_content( $editorcontent );

		// debug( $editorcontent );
		
		// class
		$class = $extra_class;
		$class .= ' wpb-text-block';

		if ( $animation ) {
			$class .= " wow $animation";
		}

		if ( $animation_delay && $animation ) {
			$inline_style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		$output = '<div';

		if ( $anchor ) {
			$output .= ' id="' . sanitize_title( $anchor ) . '"';
		}

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '"';

		$output .= '>';

		$output .= $editorcontent;
		
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'wpb_text_block', 'wpb_text_block_shortcode'  );
}