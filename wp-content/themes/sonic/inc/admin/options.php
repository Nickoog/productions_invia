<?php
/**
 * Sonic theme options
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) )  {
	exit; // Exit if accessed directly
}

/**
 * Create an array of options
 */
function sonic_create_options() {
	return array();
}
add_filter( 'wolf_theme_options', 'sonic_create_options' );

include_once( WOLF_THEME_DIR . '/inc/admin/options/fonts.php' );
include_once( WOLF_THEME_DIR . '/inc/admin/options/share.php' );
include_once( WOLF_THEME_DIR . '/inc/admin/options/misc.php' );
include_once( WOLF_THEME_DIR . '/inc/admin/options/css.php' );