<?php
/**
 * Sonic header_image
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_header_image_mods( $sonic_mods ) {
	
	/* Move header image setting here and rename the seciton title */
	$sonic_mods['header_image'] = array(
		'id' => 'header_image',
		'title' => esc_html__( 'Default Header Image', 'sonic' ),
		'icon' => 'format-image',
		'options' => array()
	);

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_header_image_mods' );