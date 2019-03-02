<?php
/**
 * Wolf Page Builder template functions
 *
 * Functions for the templating system.
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Functions
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output generator tag to aid debugging.
 */
function wpb_generator_tag( $gen, $type ) {
	switch ( $type ) {
		case 'html':
			$gen .= "\n" . '<meta name="generator" content="WolfPageBuiler ' . esc_attr( WPB_VERSION ) . '">';
			break;
		case 'xhtml':
			$gen .= "\n" . '<meta name="generator" content="WolfPageBuiler ' . esc_attr( WPB_VERSION ) . '" />';
			break;
	}
	return $gen;
}

/**
 * Add body classes for WPB pages
 *
 * @param  array $classes
 * @return array
 */
function wpb_body_class( $classes ) {
	
	$classes = ( array ) $classes;

	if ( is_wpb() ) {
		$classes[] = 'wolf-page-builder';
		$classes[] = sanitize_title_with_dashes( get_template() ); // theme slug
	}

	return array_unique( $classes );
}

/** Template pages ********************************************************/

if ( ! function_exists( 'wpb_content' ) ) {
	/**
	 * Output Wolf Page Builder content.
	 *
	 * This function is only used in the optional 'wpb.php' template
	 * which people can add to their themes to add basic WPB support
	 * without hooks or modifying core templates.
	 *
	 */
	function wpb_content() {

		// Start the loop.
		while ( have_posts() ) : the_post();

			echo wpb_get_content();

		// End the loop.
		endwhile;
	}
}

/** Global ****************************************************************/

if ( ! function_exists( 'wpb_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 *
	 */
	function wpb_output_content_wrapper() {
		wpb_get_template( 'global/wrapper-start.php' );
	}
}

if ( ! function_exists( 'wpb_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 *
	 */
	function wpb_output_content_wrapper_end() {
		wpb_get_template( 'global/wrapper-end.php' );
	}
}