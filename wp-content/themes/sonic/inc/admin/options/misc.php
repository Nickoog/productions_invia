<?php
/**
 * Sonic misc options
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_misc_options( $sonic_options ) {

	$sonic_options[] = array(
		'type' => 'open',
		'label' => esc_html__( 'Misc', 'sonic' ),
	);

		$sonic_options[] = array(
			'label' => esc_html__( 'Misc', 'sonic' ),
			'type' => 'section_open',
			'desc' => '',
		);

		$sonic_options[] = array(
			'label' => esc_html__( 'Search Form Placeholder', 'sonic' ),
			'id' => 'search_placeholder_text',
			'type' => 'text',
		);

		$sonic_options[] = array(
			'label' => esc_html__( '404 Background', 'sonic' ),
			'id' => '404_bg',
			'type' => 'image',
		);

		$sonic_options[] = array( 'type' => 'section_close' );

	$sonic_options[] = array( 'type' => 'close' );

	return $sonic_options;
}
add_filter( 'wolf_theme_options', 'sonic_set_misc_options' );