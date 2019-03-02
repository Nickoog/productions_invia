<?php
/**
 * Social icons cuqstom shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_socials_custom' ) ) {
	/**
	 * Socials custom shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_socials_custom( $atts ) {

		global $wpb_team_member_socials;

		extract( shortcode_atts( array(
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

		// add social attributes
		foreach ( $wpb_team_member_socials as $social ) {
			//$atts[ $social ] = '';
		}

		$atts['services'] = array();

		foreach ( $wpb_team_member_socials as $social ) {
			if ( isset( $atts[ $social ] ) ) {
				$atts['services'][ $social ] = $atts[ $social ];
			}
		}

		return wpb_socials( $atts );
	}
	add_shortcode( 'wpb_socials_custom', 'wpb_shortcode_socials_custom' );
}