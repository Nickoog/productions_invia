<?php
/**
 * Separator shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_separator' ) ) {
	/**
	 * Separator
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_separator( $atts ) {
		
		extract( shortcode_atts(  array(
			'alignment' => '',
			'width' => '',
			'height' => 1,
			'margin_top' => '',
			'margin_bottom' => '',
			'color' => '',
			'opacity' => '',
			'anchor' => '',
			'extra_class' => '',
			'inline_style' => '',
		), $atts ) );

		$class = $extra_class;
		$class .= " wpb-separator wpb-separator-align-$alignment wpb-clear";

		if ( $width ) {
			$width = ( is_numeric( $width ) ) ? absint( $width ) . 'px' : $width;
			$inline_style .="width:$width;";
		}

		if ( $height ) {
			$height = ( is_numeric( $height ) ) ? absint( $height ) . 'px' : $height;
			$inline_style .="height:$height;";
		}

		if ( $margin_top ) {
			$margin_top = ( is_numeric( $margin_top ) ) ? absint( $margin_top ) . 'px' : $margin_top;
			$inline_style .="margin-top:$margin_top;";
		}

		if ( $margin_bottom ) {
			$margin_bottom = ( is_numeric( $margin_bottom ) ) ? absint( $margin_bottom ) . 'px' : $margin_bottom;
			$inline_style .="margin-bottom:$margin_bottom;";
		}

		if ( $color ) {
			$inline_style .= "background-color:$color;";
		}

		if ( $opacity ) {
			$opacity = absint( $opacity ) / 100;
			$inline_style .= 'opacity:' . esc_attr( $opacity ) . ';';
		}

		$output = '<hr class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		return $output;
	}
	add_shortcode( 'wpb_separator', 'wpb_shortcode_separator' );
}