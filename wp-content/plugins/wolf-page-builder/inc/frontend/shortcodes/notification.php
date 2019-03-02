<?php
/**
 * Message box shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_notification' ) ) {
	/**
	 * Alert message shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_notification( $atts ) {

		extract( shortcode_atts( array(
			'type' => 'info',
			'message' => '',
			'close' => '',
			'display_icon' => 'yes',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$type = sanitize_text_field( $type );
		$message = wpb_decode_textarea( $message );
		$class = $extra_class;
		$class .= "wpb-notification wpb-$type";
		$icon = '';

		if ( 'alert' == $type ) {

			$icon = 'fa-exclamation-circle';

		} elseif ( 'info' == $type ) {

			$icon = 'fa-info-circle';

		} elseif ( 'success' == $type ) {

			$icon = 'fa-thumbs-o-up';

		} elseif ( 'error' == $type ) {

			$icon = 'fa-exclamation-triangle';
		}

		$output = '<div class="' . wpb_sanitize_html_classes( $class ) . '" style"' . wpb_esc_style_attr( $inline_style ) . '">';
		$output .= '<p>';

		if ( 'yes' == $display_icon ) {
			$output .= "<i class='fa $icon fa-lg'></i>";
		}

		$output .= sanitize_text_field( $message );
		$output .= '<p>';

		if ( 'yes' == $close ) {
			$output .= '<span class="wpb-notification-close">&times;</span>';
		}

		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'wpb_notification', 'wpb_shortcode_notification' );
}