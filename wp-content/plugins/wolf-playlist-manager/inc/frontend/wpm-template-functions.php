<?php
/**
 * Wolf Playlist template functions
 *
 * Functions for the templating system.
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPlaylistManager/Functions
 * @version 1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output generator tag to aid debugging.
 */
function wpm_generator_tag( $gen, $type ) {
	switch ( $type ) {
		case 'html':
			$gen .= "\n" . '<meta name="generator" content="WolfPlaylist ' . esc_attr( WPM_VERSION ) . '">';
			break;
		case 'xhtml':
			$gen .= "\n" . '<meta name="generator" content="WolfPlaylist ' . esc_attr( WPM_VERSION ) . '" />';
			break;
	}
	return $gen;
}

/**
 * Add body classes
 *
 * @param  array $classes
 * @return array
 */
function wpm_body_class( $classes ) {
	
	$classes = ( array ) $classes;

	$classes[] = 'wolf-playlist-manager';
	$classes[] = sanitize_title_with_dashes( get_template() ); // theme slug

	if ( get_option( '_wpm_bar' ) ) {
		$classes[] = 'is-wpm-bar-player';
	}

	return array_unique( $classes );
}