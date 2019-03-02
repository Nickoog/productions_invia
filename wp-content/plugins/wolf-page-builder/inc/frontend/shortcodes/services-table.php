<?php
/**
 * Service table
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_services_table' ) ) {
	/**
	 * Services table shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_services_table( $atts ) {
		
		extract( shortcode_atts( array(
			'title' => '',
			'bg_color' => '',
			'bg_opacity' => '',
			'title_color' => '',
			'font_color' => '',
			'add_icon' => '',
			'icon' => '',
			'icon_color' => '',
			'title_tag' => 'h3',
			'services' => '',
			'animation' => '',
			'animation_delay' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$output = '';

		$class = $extra_class;
		$class .= ' wpb-services-table';
		$opacity = ( $bg_opacity ) ? absint( $bg_opacity ) / 100 : 1;

		if ( $bg_color ) {
			
			if ( $bg_opacity ) {
				$bg_color = 'background:none;background-color:rgba(' . wpb_hex_to_rgb( $bg_color )  . ', ' . esc_attr( $opacity ) . ');';
			}
			
			$inline_style .= "background-color:$bg_color;";
		}

		if ( $font_color )
			$inline_style .= "color:$font_color;";

		if ( $animation ) {
			$inline_style .= " wow $animation";
		}

		if ( $animation_delay && 'none' != $animation ) {
			$inline_style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		// Title style
		$title_style = '';

		if ( $title_color ) {
			$title_style .= "color:$title_color;";
		}

		// Icon style
		$icon_style = '';

		if ( $icon_color ) {
			$icon_style .= "color:$icon_color;";
		}

		$output .= '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		$output .= '<ul>';

		$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6' );
		$title_tag = ( in_array( $title_tag, $headings_array ) ) ? esc_attr( $title_tag ) : 'h3';

		if ( $title )
			$output .= '<li class="wpb-service-title-container">
				<' . esc_attr( $title_tag ) .' class="wpb-service-title" style="' . wpb_esc_style_attr( $title_style ) . '">' . sanitize_text_field( $title ) . '
				</' . esc_attr( $title_tag ) .'>
				</li>';

		if ( $icon )
			$output .= '<li class="wpb-service-icon-container"><i class="fa fa-3x ' . esc_attr( $icon ) . '" style="' . wpb_esc_style_attr( $icon_style ) . '"></i></li>';

		if ( $services ) {
			$services = wpb_texarea_lines_to_array( $services );
			foreach ( $services as $service ) {
				$output .= '<li>';
				$output .= $service;
				$output .= '</li>';
			}
		}

		$output .= '</ul>';

		$output .= '</div><!--.wpb-services-table-->';

		return $output;
	}
	add_shortcode( 'wpb_services_table', 'wpb_shortcode_services_table' );
}