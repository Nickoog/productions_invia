<?php
/**
 * Sonic extend Wolf Page Builder functions
 *
 * Add element to WPB that are available in the theme
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

/**
 * Add blog display type
 *
 * We will use the theme style to display the last posts
 */
function sonic_add_wpb_post_display_types( $types ) {

	$types[] = 'classic';
	$types[] = 'grid';
	$types[] = 'grid2';
	$types[] = 'grid3';
	$types[] = 'photo';

	return $types;
}
add_filter( 'wpb_posts_display_types', 'sonic_add_wpb_post_display_types' );

/**
 * Add blog display type without column
 *
 * Specify the display type that we want without column setting
 */
function sonic_add_wpb_post_display_types_without_columns( $types ) {

	$types[] = 'classic';

	return $types;
}
add_filter( 'wpb_posts_display_types_without_columns', 'sonic_add_wpb_post_display_types_without_columns' );

/**
 * Add elements
 *
 * @param array $elements
 * @return array $elements
 */
function sonic_add_wpb_elements( $elements ) {

	$elements[] = 'last-posts-theme';

	return $elements;

}
add_filter( 'wpb_element_list', 'sonic_add_wpb_elements' );