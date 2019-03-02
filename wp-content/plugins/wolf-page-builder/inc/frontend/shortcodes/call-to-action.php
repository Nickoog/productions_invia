<?php
/**
 * Call to action shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_call_to_action') ) {
	/**
	 * Call to action
	 */
	function wpb_shortcode_call_to_action( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'main_text' => '',
			'main_tagline' => '',
			'title_tag' => 'h4',
			'link_url' => '#',
			'link_target' => '',
			'color' => '',
			'color_hover' => '',
			'type' => 'flat',
			'custom_style' => 'no',
			'size' => 'medium',
			'shape' => 'default',
			'tagline' => '',
			'text' => '',
			'add_icon' => '',
			'icon' => '',
			'icon_position' => 'before',
			'custom_style' => 'no',
			'button_bg_color' => '',
			'button_font_color' => '',
			'button_border_color' => '',
			'button_bg_color_hover' => '',
			'button_font_color_hover' => '',
			'button_border_color_hover' => '',
			'scroll_to_anchor' => '',
			'anchor' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$class = $extra_class;
		$class .= " wpb-call-to-action wpb-clearfix";

		$output = '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';
		
		$output .= '<div class="wpb-call-to-action-text">';
		
		$output .= '<' . esc_attr( $title_tag ) . ' class="wpb-call-to-action-title">' . sanitize_text_field( $main_text ) . '</' . esc_attr( $title_tag ) . '>';

		if ( $main_tagline ) {
			$output .= '<p>' . sanitize_text_field( $main_tagline ) . '</p>';
		}

		$output .= '</div><!-- .wpb-call-to-action-text -->';
		$output .= '<div class="wpb-call-to-action-button">';
		$output .= wpb_do_button( $atts );
		$output .= '</div><!-- .wpb-call-to-action-button -->';
		$output .= '</div>';

		return $output;

	}
	add_shortcode( 'wpb_call_to_action', 'wpb_shortcode_call_to_action' );
}