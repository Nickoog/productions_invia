<?php
/**
 * Sonic albums
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_albums_mods( $sonic_mods ) {

	if ( class_exists( 'Wolf_Albums' ) ) {
		$sonic_mods['wolf_albums'] = array(
			'priority' => 45,
			'id' => 'wolf_albums',
			'title' => esc_html__( 'Albums', 'sonic' ),
			'icon' => 'camera',
			'options' => array(

				'albums_layout' => array(
					'id' => 'albums_layout',
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

				'albums_padding' => array(
					'id' => 'albums_padding',
					'label' => esc_html__( 'Padding', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'sonic' ),
						'no' => esc_html__( 'No', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'albums_columns' => array(
					'id' => 'albums_columns',
					'label' => esc_html__( 'Columns', 'sonic' ),
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

				'album_cover_thumbnail_size' => array(
					'id' => 'album_cover_thumbnail_size',
					'label' => esc_html__( 'Album Cover Size', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'sonic-thumb' => esc_html__( 'Standard', 'sonic' ),
						'sonic-2x1' => esc_html__( 'Landscape', 'sonic' ),
						'sonic-2x2' => esc_html__( 'Square', 'sonic' ),
						'sonic-portrait' => esc_html__( 'Portrait', 'sonic' ),
					),
				),
			),
		);
	}

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_albums_mods' );