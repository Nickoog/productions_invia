<?php
/**
 * Counter shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_counter' ) ) {
	/**
	 * Counter shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_counter( $atts ) {
		extract( shortcode_atts( array(
			'number' => '',
			'easing' => 'false',
			'grouping' => 'true',
			'seperator' => ',',
			'decimal' => '.',
			'prefix' => '',
			'suffix' => '',
			'shortcode' => '',
			'duration' => '',
			'delay' => '',
			'text' => '',
			'add_icon' => '',
			'icon' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'countup' );
		wp_enqueue_script( 'wpb-counter' );
		
		$class = $extra_class;
		$class .= ' wpb-counter-container';
		$output = '';
		$rand_id = rand( 0,999 );
		$duration = ( $duration ) ? float( $duration ) : null;
		$delay = ( $delay ) ? absint( $delay ) : null;

		$output = '';

		$number = ( $shortcode ) ? "[$number]" : $number;

		$output .= '<div id="wpb-counter-container-' . absint( $rand_id ) .'" class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		if ( 'yes' == $add_icon ) {
			$output .= '<span class="wpb-counter-icon-container"><i class="fa ' . esc_attr( $icon ) . ' fa-2x"></i></span>';
		}
		$output .= '<span class="wpb-counter" data-end="' . absint( do_shortcode( $number ) ) . '" data-duration="' . $duration . '" data-delay="' . $delay . '" id="wpb-counter-' . absint( $rand_id ) .'">0</span>';
		$output .= '<span class="wpb-counter-text">' . sanitize_text_field( $text ) . '</span>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'wpb_counter', 'wpb_shortcode_counter' );
}