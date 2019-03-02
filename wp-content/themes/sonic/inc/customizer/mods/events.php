<?php
/**
 * Sonic events
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_events_mods( $sonic_mods ) {

	if ( class_exists( 'Wolf_Events' ) ) {
		$sonic_mods['wolf_events'] = array(
			'priority' => 45,
			'id' => 'wolf_events',
			'title' => esc_html__( 'Events Page', 'sonic' ),
			'icon' => 'calendar-alt',
			'options' => array(

				'events_layout' => array(
					'id' => 'events_layout',
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

				'events_padding' => array(
					'id' => 'events_padding',
					'label' => esc_html__( 'Padding', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'sonic' ),
						'no' => esc_html__( 'No', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'events_columns' => array(
					'id' => 'events_columns',
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

				'event_cover_thumbnail_size' => array(
					'id' => 'event_cover_thumbnail_size',
					'label' => esc_html__( 'Event Cover Size', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'sonic-thumb' => esc_html__( 'Standard', 'sonic' ),
						//'sonic-2x1' => esc_html__( 'Landscape', 'sonic' ),
						'sonic-2x2' => esc_html__( 'Square', 'sonic' ),
						'sonic-portrait' => esc_html__( 'Portrait', 'sonic' ),
					),
				),
			),
		);
	}

	return $sonic_mods;

}
add_filter( 'sonic_customizer_options', 'sonic_set_events_mods' );