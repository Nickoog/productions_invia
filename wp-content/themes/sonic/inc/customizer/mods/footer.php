<?php
/**
 * Sonic footer
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_footer_mods( $sonic_mods ) {

	$sonic_mods['footer'] = array(

		'id' => 'footer',
		'title' => esc_html__( 'Footer', 'sonic' ),
		'icon' => 'minus',
		'options' => array(

			array(
				'label' => esc_html__( 'Footer Width', 'sonic' ),
				'id' => 'footer_layout',
				'type' => 'select',
				'choices' => array(
		 			'boxed' => esc_html__( 'Boxed', 'sonic' ),
					'wide' => esc_html__( 'Wide', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Foot Widgets Layout', 'sonic' ),
				'id' => 'footer_widgets_layout',
				'type' => 'select',
				'choices' => array(
		 			'3-cols' => esc_html__( '3 Columns', 'sonic' ),
					'4-cols' => esc_html__( '4 Columns', 'sonic' ),
					'one-half-two-quarter' => esc_html__( '1 Half/2 Quarters', 'sonic' ),
					'two-quarter-one-half' => esc_html__( '2 Quarters/1 Half', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Scroll to Top Link Type', 'sonic' ),
				'id' => 'scroll_to_top_link_type',
				'type' => 'select',
				'choices' => array(
		 			'arrow' => esc_html__( 'Arrow', 'sonic' ),
					// 'text' => esc_html__( 'Text in footer', 'sonic' ),
					'none' => esc_html__( 'None', 'sonic' ),
				),
			),

			array(
				'label' => esc_html__( 'Scroll to Top Arrow Style', 'sonic' ),
				'id' => 'scroll_to_top_arrow_style',
				'description' => esc_html__( 'If "arrow" if set above', 'sonic' ),
				'type' => 'select',
				'choices' => array(
		 			'round' => esc_html__( 'Round', 'sonic' ),
					'square' => esc_html__( 'Square', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Bottom Bar Layout', 'sonic' ),
				'id' => 'bottom_bar_layout',
				'type' => 'select',
				'choices' => array(
		 			'default' => esc_html__( 'Default', 'sonic' ),
					'centered' => esc_html__( 'Centered', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'id' => 'bottom_menu_item_separator',
				'label' => esc_html__( 'Botom Menu Separator', 'sonic' ),
				'type' => 'text',
			),

			'copyright' => array(
				'id' => 'copyright',
				'label' => esc_html__( 'Copyright Text', 'sonic' ),
				'type' => 'text',
			),
		),
	);

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_footer_mods' );