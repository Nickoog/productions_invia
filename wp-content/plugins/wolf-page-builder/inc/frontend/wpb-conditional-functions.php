<?php
/**
 * Wolf Page Builder frontend functions
 *
 * General core functions available on admin.and frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FRontend
 * @version 2.9.3
 */

/**
 * Check if we're on the blog index page
 *
 * @return bool
 */
function wpb_is_blog_index() {

	global $wp_query;

	return is_object( $wp_query ) && isset( $wp_query->queried_object ) && isset( $wp_query->queried_object->ID ) && $wp_query->queried_object->ID == get_option( 'page_for_posts' );
}

if ( ! function_exists( 'is_wpb' ) ) {
	/**
	 * Check if we must display the page builder content
	 *
	 * @return bool
	 */
	function is_wpb() {

		$post_types = wpb_get_allowed_post_types();
		$post_id = get_the_ID();
		$wpb_on = ( 'on' == get_post_meta( get_the_ID(), '_wpb_status', true ) );
		$not_is_blog = ! wpb_is_blog_index();
		$not_wolf_events = ( $post_id != get_option( '_wolf_events_page_id' ) );
		$not_wolf_albums = ( $post_id != get_option( '_wolf_albums_page_id' ) );
		$not_wolf_videos = ( $post_id != get_option( '_wolf_videos_page_id' ) );
		$not_wolf_discography = ( $post_id != get_option( '_wolf_discography_page_id' ) );
		$not_wolf_portfolio = ( $post_id != get_option( '_wolf_portfolio_page_id' ) );
		$not_wolf_themes = ( $post_id != get_option( '_wolf_themes_page_id' ) );
		$not_wolf_plugins = ( $post_id != get_option( '_wolf_plugins_page_id' ) );
		$not_wolf_plugins_pages = $not_wolf_events && $not_wolf_albums && $not_wolf_videos && $not_wolf_discography && $not_wolf_portfolio && $not_wolf_themes && $not_wolf_plugins;

		if (
			in_array( get_post_type(), $post_types ) 
			&& $wpb_on
			&& $not_is_blog
			&& $not_wolf_plugins_pages
			&& ! post_password_required()
		) {
			return true;
		}
	}
}