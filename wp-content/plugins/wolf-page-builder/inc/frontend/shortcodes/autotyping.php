<?php
/**
 * Countdown shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_typed' ) ) {
	/**
	 * Count down shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_typed( $atts ) {
		
		extract( shortcode_atts( array(
			'text' => '',
			'tag' => 'h2',
			'text_transform' => '',
			'text_alignment' => 'center',
			'font_weight' => '',
			'font_family' => '',
			'font_style' => '',
			'text_before' => '',
			'text_after' => '',
			'loop' => true,
			'speed' => 100,
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );
		
		wp_enqueue_script( 'typed' );
		wp_enqueue_script( 'wpb-typed' );

		// class
		$class = $extra_class;
		$class = esc_attr( $class );
		$class .= " wpb-typed-container wpb-text-$text_alignment";
		$text_style = '';
		$speed = ( $speed ) ? $speed : 100; //  be sure that speed is not null

		$text_style = "font-style:$font_style;font-family:$font_family;font-weight:$font_weight;font-style:$font_style;text-transform:$text_transform";

		$rand_id = rand( 0,999 );
		$output = '';
		
		$strings_data = '';
		
		$strings_array = wpb_texarea_lines_to_array( $text );
		foreach ( $strings_array as $string ) {
			$strings_data .= '"' . trim( $string ) . '",';
		}

		$strings_data = substr( $strings_data, 0, -1 );

		$output .= '<section class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		$output .= '<' . $tag . '>';

		if ( $text_before ) {
			$output .= $text_before . ' ';
		}

		$output .= '<span';
		$output .= ' data-string="[' . esc_js( $strings_data ) . ']" 
		data-loop="' . wpb_shortcode_bool( $loop ) . '"
		data-speed="' . absint( $speed ) . '"';

		$output .= ' class="wpb-typed" id="wpb-typed-' . absint( $rand_id ) .'" style="' . wpb_esc_style_attr( $text_style ) . '"></span>';

		if ( $text_after ) {
			$output .= '' . $text_after;
		}

		$output .= '</' . $tag . '>';


		$output .= '</section>';

		return $output;
	}
	add_shortcode( 'wpb_typed', 'wpb_shortcode_typed' );
}