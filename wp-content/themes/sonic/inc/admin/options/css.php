<?php
/**
 * Sonic custom CSS
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_css_options( $sonic_options ) {

	if ( is_child_theme() ) {
		$help = esc_html__( 'Want to add any custom CSS code? Put in here, and the rest is taken care of.', 'sonic' );
	} else {
		$help = sprintf(
			__( 'Want to add any custom CSS code? Put in here, and the rest is taken care of. If you need more advanced style customization, it is strongly recommended to use a <a href="%s" target="_blank">child theme</a>.', 'sonic' ),
			'http://codex.wordpress.org/Child_Themes'
		);
	}

	$sonic_options[] =  array(
		'type' => 'open',
		'label' =>esc_html__( 'CSS', 'sonic' ),
	);

		$sonic_options[] =  array(
			'label' => esc_html__( 'Custom CSS', 'sonic' ),
			'type' => 'section_open',
			'desc' => $help,
		);

		$sonic_options[] =  array(
			// 'label' => esc_html__( 'Custom CSS', 'sonic' ),
			'id' => 'custom_css',
			'type' => 'css',
		);

		$sonic_options[] =  array( 'type' => 'section_close' );

	$sonic_options[] =  array( 'type' => 'close' );

	return $sonic_options;
}
add_filter( 'wolf_theme_options', 'sonic_set_css_options' );