<?php
/**
 * Wolf Page Builder Template Hooks
 *
 * Action/filter hooks used for Wolf Page Builder functions/templates
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Templates
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Body class
 *
 * @see  wpb_body_class()
 */
add_filter( 'body_class', 'wpb_body_class' );

/**
 * WP Header
 *
 * @see  wpb_generator_tag()
 */
add_action( 'get_the_generator_html', 'wpb_generator_tag', 10, 2 );
add_action( 'get_the_generator_xhtml', 'wpb_generator_tag', 10, 2 );

/**
 * Content Wrappers
 *
 * @see wpb_output_content_wrapper()
 * @see wpb_output_content_wrapper_end()
 */
add_action( 'wpb_before_main_content', 'wpb_output_content_wrapper', 10 );
add_action( 'wpb_after_main_content', 'wpb_output_content_wrapper_end', 10 );