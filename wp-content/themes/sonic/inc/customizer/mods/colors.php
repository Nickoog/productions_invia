<?php
/**
 * Sonic colors
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_color_scheme_mods( $sonic_mods ) {

	$color_scheme = sonic_get_color_scheme();

	$sonic_mods['colors'] = array(
		'id' => 'colors',
		'icon' => 'admin-customizer',
		'title' => esc_html__( 'Colors', 'sonic' ),
		'options' => array(
			array(
				'label' => esc_html__( 'Color scheme', 'sonic' ),
				'id' => 'color_scheme',
				'type' => 'select',
				'choices'  => sonic_get_color_scheme_choices(),
				'transport' => 'postMessage',
			),
			array(
				'id' => 'body_background_color',
				'label' => esc_html__( 'Background Color', 'sonic' ),
				'description' => esc_html__( 'Only visible with the boxed layout.', 'sonic' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[0],
			),
			array(
				'id' => 'page_background_color',
				'label' => esc_html__( 'Page Background Color', 'sonic' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[1],
			),
			array(
				'id' => 'accent_color',
				'label' => esc_html__( 'Accent Color', 'sonic' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[2],
			),
			array(
				'id' => 'main_text_color',
				'label' => esc_html__( 'Main Text Color', 'sonic' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[3],
			),
			array(
				'id' => 'secondary_text_color',
				'label' => esc_html__( 'Secondary Text Color', 'sonic' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[4],
			),
			array(
				'id' => 'strong_text_color',
				'label' => esc_html__( 'Strong Text Color', 'sonic' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[5],
			),

			array(
				'id' =>'submenu_background_color',
				'label' => esc_html__( 'Submenu Background Color', 'sonic' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[6],
			),

			array(
				'id' =>'entry_content_background_color',
				'label' => esc_html__( 'Entry Content Background Color', 'sonic' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[7],
			),
		),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$sonic_mods['colors']['options'][] = array(
			'id' =>'product_tabs_background_color',
			'label' => esc_html__( 'Product Tabs Background Color', 'sonic' ),
			'type' => 'color',
			'transport' => 'postMessage',
			'default' => $color_scheme[8],
		);

		$sonic_mods['colors']['options'][] = array(
			'id' =>'product_tabs_text_color',
			'label' => esc_html__( 'Product Tabs Text Color', 'sonic' ),
			'type' => 'color',
			'transport' => 'postMessage',
			'default' => $color_scheme[9],
		);
	}

	return $sonic_mods;

}
add_filter( 'sonic_customizer_options', 'sonic_set_color_scheme_mods' );