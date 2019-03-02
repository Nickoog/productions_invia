<?php
/**
 * Sonic background_image
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_background_image_mods( $sonic_mods ) {
	
	//* Move background image setting here and rename the seciton title */
	$sonic_mods['background_image'] = array(
		'id' => 'background_image',
		'title' => esc_html__( 'Background Image', 'sonic' ),
		'options' => array()
	);
	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_background_image_mods' );