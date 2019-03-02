<?php
/**
 * Sonic logo
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_logo_mods( $sonic_mods ) {

	$sonic_mods['logo'] = array(
		'id' => 'logo',
		'title' => esc_html__( 'Logo', 'sonic' ),
		'icon' => 'visibility',
		'description' => sprintf(
			wp_kses(
				__( 'Your theme recommends a logo size of <strong>%d &times; %d</strong> pixels.', 'sonic' ),
				array(
					'strong' => array(),
				)
			),
			200, 80
		),
		'options' => array(
			'logo_dark' => array(
				'id' => 'logo_dark',
				'label' => esc_html__( 'Logo - dark version', 'sonic' ),
				'type' => 'image',
			),

			'logo_light' => array(
				'id' => 'logo_light',
				'label' => esc_html__( 'Logo - light version', 'sonic' ),
				'type' => 'image',
			),

			'logo_width' => array(
				'id' => 'logo_width',
				'label' => esc_html__( 'Desktop Logo Width', 'sonic' ),
				'type' => 'int',
			),

			'logo_mobile_dark' => array(
				'id' => 'logo_mobile_dark',
				'label' => esc_html__( 'Logo for Mobile Devices - dark version (optional)', 'sonic' ),
				'type' => 'image',
			),

			'logo_mobile_light' => array(
				'id' => 'logo_mobile_light',
				'label' => esc_html__( 'Logo for Mobile Devices - light version (optional)', 'sonic' ),
				'type' => 'image',
			),

			'logo_shrink_menu' => array(
				'id' =>'logo_shrink_menu',
				'label' => esc_html__( 'Forces Logo to fit the menu height. The menu height must be set in the navigation section', 'sonic' ),
				'type' => 'checkbox',
			),

			'logo_vertical_align' => array(
				'id' =>'logo_vertical_align',
				'label' => esc_html__( 'Align the logo image vertically', 'sonic' ),
				'type' => 'checkbox',
			),

			// 'shrink_logo_sticky_menu' => array(
			// 	'id' =>'shrink_logo_sticky_menu',
			// 	'label' => esc_html__( 'Shrink Logo in Sticky Menu', 'sonic' ),
			// 	'type' => 'checkbox',
			// 	'description' => esc_html__( 'Force logo to fit the menu height', 'sonic' ),
			// ),
		),
	);

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_logo_mods' );