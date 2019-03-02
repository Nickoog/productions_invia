<?php
/**
 * Process shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_process_container' ) ) {
	/**
	 * Process container shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_process_container( $atts, $content = null ) {
		extract( shortcode_atts(  array(
			'inline_style' => '',
			'extra_class' => '',
			'anchor' => '',
		), $atts ) );

		wp_enqueue_script( 'wpb-process' );

		$output = $style = '';

		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= "wpb-process-container";

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		$style = ( $style ) ? " style='$style'" : '';

		$output .= "<section class='$class'$style><ul class='wpb-process-list wpb-clearfix'>";

		$output .= do_shortcode( $content );

		$output .= '</ul></section>';

		return $output;
	}
	add_shortcode( 'wpb_process_container', 'wpb_shortcode_process_container' );
}

if ( ! function_exists( 'wpb_shortcode_process' ) ) {
	/**
	 * Accordion shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_process( $atts ) {
		extract( shortcode_atts(  array(
			'title' => '',
			'text' => '',
			'icon' => 'line-icon-bulb',
			'title_tag' => '',
			'link_url' => '',
			'link_target' => '',
		), $atts ) );

		$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6' );
		$title_tag = ( in_array( $title_tag, $headings_array ) ) ? esc_attr( $title_tag ) : 'h3';

		$output = "<li>";

		$output .= '<div class="wpb-icon-box wpb-icon-position-top wpb-icon-box-medium wpb-icon-type-circle">
		<div class="wpb-icon-holder">';
		
		
		if ( $link_url ) {
			$output .= '<a class="wolf-process-item-link" href="' . esc_attr( $link_url ) . '" target="' . esc_attr( $link_target ) . '">';
		}

		$output .= '<span class="wpb-process-icon-container fa-stack fa-3x wpb-hover-fill-in wpb-icon-no-custom-style">
		<i class="fa ' . esc_attr( $icon ) . ' fa-stack-1x"></i></span>';

		if ( $link_url ) {
			$output .= '</a>';
		}
		
		$output .= '</div><!--.wpb-icon-holder-->
		</div><!--.wpb-icon-box-->';

		$output .= '<' . esc_attr( $title_tag ) . ' class="wpb-process-title">' . esc_attr( $title ) . '</' . esc_attr( $title_tag ) . '>';

		$text = wpb_decode_textarea( $text );
		$output .= '<p class="wpb-process-text">' . sanitize_text_field( $text ) . '</p>';

		$output .= '</li>';

		return $output;
	}
	add_shortcode( 'wpb_process_item', 'wpb_shortcode_process' );
}