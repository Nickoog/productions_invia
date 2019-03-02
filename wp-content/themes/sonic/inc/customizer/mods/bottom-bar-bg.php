<?php
/**
 * Sonic bottom_bar
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_bottom_bar_mods( $sonic_mods ) {

	$sonic_mods['bottom_bar_bg'] = array(
		'id' =>'bottom_bar_bg',
		'label' => esc_html__( 'Bottom Bar Background', 'sonic' ),
		'background' => true,
	);

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_bottom_bar_mods' );