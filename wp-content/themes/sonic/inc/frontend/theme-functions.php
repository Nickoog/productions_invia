<?php
/**
 * Sonic frontend theme specific functions
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output music network icons
 *
 * @see Wolf Music Network http://wolfthemes.com/plugin/wolf-music-network/
 */
function sonic_output_music_network() {

	if ( function_exists( 'wolf_music_network' ) ) {
		echo '<div class="music-social-icons-container clearfix">';
			wolf_music_network();
		echo '</div><!--.music-social-icons-container-->';
	}

}
add_action( 'wolf_footer_before', 'sonic_output_music_network' );

/**
 * Overwrite video posts per page
 *
 * @param string $class
 * @return string $class
 * @see Wolf Events http://wolfthemes.com/plugin/wolf-events/
 */
function sonic_we_ticket_link_class( $class ) {

	return 'wolf-button';
}
add_filter( 'we_ticket_link_class', 'sonic_we_ticket_link_class' );

/**
 * Hook before release thumbnail
 *
 * @see Wolf Discography http://wolfthemes.com/plugin/wolf-discography/
 */
function sonic_before_thumbnail() {
	if ( is_singular( 'release' ) ) {
		return;
	}
	?>
	<span class="release-image-container">
	<?php
}
add_action( 'wd_before_thumbnail', 'sonic_before_thumbnail' );

/**
 * Hook after release thumbnail
 *
 * @see Wolf Discography http://wolfthemes.com/plugin/wolf-discography/
 */
function sonic_after_thumbnail() {
	if ( is_singular( 'release' ) ) {
		return;
	}
	?>
		<h3 class="release-title">
			<?php the_title(); ?>
		</h3>
	</span><!-- .release-image-container -->
	<?php
}
add_action( 'wd_after_thumbnail', 'sonic_after_thumbnail' );

/**
 * Overwrite release thumbnail size
 *
 * @param string $size
 * @see Wolf Discography http://wolfthemes.com/plugin/wolf-discography/
 */
function sonic_release_thumbnail_size( $size ) {

	$size = 'sonic-2x2';

	return $size;
}
add_filter( 'wd_thumbnail_size', 'sonic_release_thumbnail_size' );

/**
 * Overwrite posts per page
 *
 * @param int $posts_per_page
 * @see Wolf Discography http://wolfthemes.com/plugin/wolf-discography/
 */
function sonic_release_posts_per_page( $posts_per_page ) {

	$posts_per_page = wolf_get_theme_mod( 'release_posts_per_page', -1 );

	return $posts_per_page;
}
add_filter( 'wd_posts_per_page', 'sonic_release_posts_per_page' );