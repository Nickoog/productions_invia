<?php
/**
 * Sonic discography
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_discography_mods( $sonic_mods ) {

	if ( class_exists( 'Wolf_Discography' ) ) {
		$sonic_mods['wolf_discography'] = array(
			'priority' => 45,
			'id' => 'wolf_discography',
			'title' => esc_html__( 'Discography Page', 'sonic' ),
			'icon' => 'album',
			'options' => array(
				'discography_layout' => array(
					'id' => 'discography_layout',
					'label' => esc_html__( 'Layout', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'sonic' ),
						'fullwidth' => esc_html__( 'Full width', 'sonic' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'sonic' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'discography_display' => array(
					'id' => 'discography_display',
					'label' => esc_html__( 'Display', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'sonic' ),
						'grid' => esc_html__( 'Grid', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'discography_padding' => array(
					'id' => 'discography_padding',
					'label' => esc_html__( 'Padding (for grid display only)', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'sonic' ),
						'no' => esc_html__( 'No', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'discography_columns' => array(
					'id' => 'discography_columns',
					'label' => esc_html__( 'Columns (for grid display only)', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						3 => 3, 
						2 => 2, 
						4 => 4, 
						5 => 5, 
						6 => 6,
					),
					'transport' => 'postMessage',
				),
			),
		);
	}

	return $sonic_mods;

}
add_filter( 'sonic_customizer_options', 'sonic_set_discography_mods' );