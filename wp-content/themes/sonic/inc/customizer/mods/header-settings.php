<?php
/**
 * Sonic header_settings
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_header_settings_mods( $sonic_mods ) {

	$sonic_mods['header_settings'] = array(

		'id' => 'header_settings',
		'title' => esc_html__( 'Header Settings', 'sonic' ),
		'icon' => 'editor-table',
		'options' => array(

			'auto_header' => array(
				'id' =>'auto_header',
				'label' => esc_html__( 'Use the post featured image as header image.', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'sonic' ),
					'' => esc_html__( 'No', 'sonic' ),
				),
			),

			'auto_header_type' => array(
				'label'	=> esc_html__( 'Page Header Type', 'sonic' ),
				'id'	=> 'auto_header_type',
				'type'	=> 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'sonic' ),
					'big' => esc_html__( 'Big', 'sonic' ),
					'small' => esc_html__( 'Small', 'sonic' ),
					'breadcrumb' => esc_html__( 'Breadcrumb', 'sonic' ),
					'none' => esc_html__( 'No header', 'sonic' ),
				),
			),

			'auto_header_effect' => array(
				'id' =>'auto_header_effect',
				'label' => esc_html__( 'Header Image Effect', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'parallax' => esc_html__( 'Parallax', 'sonic' ),
					'zoomin' => esc_html__( 'Zoom', 'sonic' ),
					'none' => esc_html__( 'None', 'sonic' ),
				),
			),
		),
	);

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_header_settings_mods' );