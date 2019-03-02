<?php
/**
 * Sonic footer_bg
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_footer_bg_mods( $sonic_mods ) {

	$sonic_mods['footer_bg'] = array(
		'id' =>'footer_bg',
		'label' => esc_html__( 'Footer Background', 'sonic' ),
		'background' => true,
		'icon' => 'format-image',
	);

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_footer_bg_mods' );