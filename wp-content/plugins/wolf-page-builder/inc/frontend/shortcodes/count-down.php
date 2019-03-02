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

if ( ! function_exists( 'wpb_shortcode_countdown' ) ) {
	/**
	 * Count down shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_countdown( $atts ) {
		
		extract( shortcode_atts( array(
			'date' => '12/24/2020 12:00:00',
			'offset' => -5,
			'message' => esc_html__( 'Done!', 'wolf-page-builder' ),
			'animation' => '',
			'animation_delay' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );
		
		wp_enqueue_script( 'countdown' );
		wp_enqueue_script( 'wpb-countdown' );

		$date = esc_attr( $date );
		$offset = esc_attr( $offset );
		$message = sanitize_text_field( $message );
		$inline_style = sanitize_text_field( $inline_style );

		$class = $extra_class;
		$class = esc_attr( $class );

		$rand_id = rand( 0,999 );
		$output = '';

		/* Format date */
		$format = explode( ' ' , $date );
		$date = $format[0];
		$hours =  $format[1];
		$date = explode( '/', $date );
		$year = $date[2];
		$month = $date[0];
		$day = $date[1];
		$hours = explode( ':', $hours );
		$hour = $hours[0];
		$min = $hours[1];
		$sec = $hours[2];

		// class
		$class .= " wpb-countdown-container wpb-clearfix";

		if ( $animation ) {
			$class .= " wow $animation";
		}

		if ( $animation_delay && $animation ) {
			$inline_style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		$output .= '<section class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';
		$output .= '<div 
			data-year="' . absint( $year ) . '"
			data-month="' . absint( $month ) . '"
			data-day="' . absint( $day ) . '"
			data-hour="' . absint( $hour ) . '"
			data-min="' . absint( $min ) . '"
			data-sec="' . absint( $sec ) . '"
			data-offset="' . intval( $offset ) . '"
			class="wpb-countdown" id="wpb-countdown-' . absint( $rand_id ) .'" style="color:#ffffff;"></div>';
		$output .= '</section>';

		return $output;
	}
	add_shortcode( 'wpb_countdown', 'wpb_shortcode_countdown' );
}