<?php
/**
 * Filter default options
 *
 * Filter default options in WP options on theme activation
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter default options
 *
 * @see inc/admin/admin-funtions.php wolf_theme_default_options_init function
 */
function sonic_set_default_font_option( $options ) {
	
	$options['google_fonts'] = 'Open+Sans:400,700|Poppins:400,500,300,600,700|Oswald:400,700|Open+Sans+Condensed:300,300italic,700|Amatic+SC|Hammersmith+One|Marcellus+SC|PT+Sans';

	return $options;
}
add_filter( 'sonic_default_options', 'sonic_set_default_font_option' );