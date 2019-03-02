<?php
/**
 * Sonic plugins hook functions
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

/*-------------------------------------------------------------------------

	Wolf Message Bar

/*-------------------------------------------------------------------------*/

/**
 * Output message bar plugin function
 *
 * @since Sonic 1.0.0
 * @see Wolf Message Bar plugin http://wolfthemes.com/plugin/wolf-message-bar/
 */
function sonic_output_message_bar() {

	if ( function_exists( 'wolf_message_bar' ) ) {
		wolf_message_bar();
	}
}
add_action( 'wolf_body_start', 'sonic_output_message_bar' );

/*-------------------------------------------------------------------------

	Wolf Albums hooks and filters

/*-------------------------------------------------------------------------*/

/**
 * Overwrite release thumbnail size
 *
 * @param string $size
 * @see Wolf Albums http://wolfthemes.com/plugin/wolf-albums/
 */
function sonic_album_thumbnail_size( $size ) {

	$size = wolf_get_theme_mod( 'album_cover_thumbnail_size', 'sonic-2x1' );

	return $size;
}
add_filter( 'wa_thumbnail_size', 'sonic_album_thumbnail_size' );

/**
 * Overwrite album posts per page
 *
 * @param int $posts_per_page
 * @see Wolf Albums http://wolfthemes.com/plugin/wolf-albums/
 */
function sonic_album_posts_per_page( $posts_per_page ) {

	$posts_per_page = wolf_get_theme_mod( 'gallery_posts_per_page', -1 );

	return $posts_per_page;
}
add_filter( 'wa_posts_per_page', 'sonic_album_posts_per_page' );

/*-------------------------------------------------------------------------

	Wolf Videos hooks and filters

/*-------------------------------------------------------------------------*/

/**
 * Overwrite video posts per page
 *
 * @param int $posts_per_page
 * @see Wolf Videos http://wolfthemes.com/plugin/wolf-videos/
 */
function sonic_video_posts_per_page( $posts_per_page ) {

	$posts_per_page = wolf_get_theme_mod( 'video_posts_per_page', -1 );

	return $posts_per_page;
}
add_filter( 'wv_posts_per_page', 'sonic_video_posts_per_page' );

/*-------------------------------------------------------------------------

	Wolf Page Builder

/*-------------------------------------------------------------------------*/

/**
 * Big post slider summary
 *
 * Display the subheading on desired post type is available
 *
 * @param string $text
 * @return string $text
 */
function sonic_last_posts_big_slide_summary( $text ) {

	$post_type = get_post_type();

	if ( 'gallery' == $post_type ) {
		$text = sonic_get_the_subheading();
	}

	return $text;
}
add_filter( 'wpb_last_posts_big_slide_summary', 'sonic_last_posts_big_slide_summary' );