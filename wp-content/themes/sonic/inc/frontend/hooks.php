<?php
/**
 * Sonic hook functions
 *
 * Inject content through template hooks
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Site page hooks
 */
include_once( 'hooks/site-page-hooks.php' );

/**
 * Navigation hooks
 */
include_once( 'hooks/navigation-hooks.php' );

/**
 * Posts hooks
 */
include_once( 'hooks/post-hooks.php' );

/**
 * Plugin hooks
 */
include_once( 'hooks/plugin-hooks.php' );