<?php
/**
 * Social icons shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_socials' ) ) {
	/**
	 * Socials shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_socials( $atts ) {

		extract( shortcode_atts( array(
			'services' 		=> '',
			'size' 			=> '2x',
			'type' 			=> 'normal',
			'target' 			=> '_blank',
			'custom_style' 		=> 'no',
			'hover_effect' 		=> 'none',
			'margin' 		=> '',
			'bg_color' 		=> '',
			'icon_color' 		=> '',
			'border_color' 		=> '',
			'bg_color_hover' 	=> '',
			'icon_color_hover' 	=> '',
			'border_color_hover' 	=> '',
			'alignment' 		=> 'center',
			'animation' 		=> '',
			'animation_delay' 	=> '',
			'inline_style'		=> '',
			'extra_class'		=> '',
		), $atts ) );

		return wpb_socials( $atts );
	}
	add_shortcode( 'wpb_socials', 'wpb_shortcode_socials' );
}