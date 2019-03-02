<?php
/**
 * Default Google Fonts
 *
 * Load default fonts that will be added to the fonts loaded in the theme options
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add default fonts to load
 */
function sonic_set_google_fonts( $sonic_google_fonts ) {

	$sonic_google_fonts['Raleway'] = 'Raleway:300,400,700';
	$sonic_google_fonts['Roboto'] = 'Roboto:400,700';
	$sonic_google_fonts['Lato'] = 'Roboto:400,700';
	$sonic_google_fonts['Noto Serif'] = 'Noto+Serif:400,700';
	$sonic_google_fonts['Montserrat'] = 'Montserrat:400,700';
	$sonic_google_fonts['Oswald'] = 'Oswald:400,700';

	return $sonic_google_fonts;
}
add_filter( 'sonic_google_fonts', 'sonic_set_google_fonts' );
add_filter( 'wpb_google_fonts', 'sonic_set_google_fonts' );