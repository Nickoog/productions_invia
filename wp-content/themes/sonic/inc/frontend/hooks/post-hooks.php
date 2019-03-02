<?php
/**
 * Sonic post hook functions
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
 * Display sidebar on single posts with sidebar layout
 *
 * @since Sonic 1.0.0
 */
function sonic_single_post_sidebar() {
	if ( 'sidebar' == sonic_get_single_post_layout() || 'sidebar-right' == sonic_get_single_post_layout() || 'sidebar-left' == sonic_get_single_post_layout() ) {
		get_sidebar();
	}
}
add_action( 'wolf_post_after', 'sonic_single_post_sidebar' );

/**
 * Share links below single posts
 *
 * @since Sonic 1.0.0
 */
function sonic_share_links() {

	if ( wolf_get_theme_option( 'post_share_buttons' ) ) { // is theme option checked
		if ( is_single() ) {
			get_template_part( 'partials/share', 'post' );
		}
	}
}
add_action( 'wolf_post_end', 'sonic_share_links' ); // display in single post
add_action( 'woocommerce_share', 'sonic_share_links' ); // display in single product
add_action( 'wpm_playlist_post_end', 'sonic_share_links' ); // display in single playlist
add_action( 'sonic_share', 'sonic_share_links' ); // display in single playlist

/**
 * Output newsletter form
 *
 * @see Wolf Page Builder plugin http://wolfthemes.com/plugin/wolf-page-builder/
 */
function sonic_author_meta() {

	if (
		function_exists( 'wpb_mailchimp' )
		&& wolf_get_theme_mod( 'newsletter_form_single_blog_post' )
	)
	{
		$list_id = wpb_get_option( 'mailchimp', 'default_mailchimp_list_id' );
		?>
		<div class="newsletter-signup">
			<?php echo wpb_mailchimp( array( 'size' => 'large' ) ); ?>
		</div><!-- .newsletter-signup -->
		<?php
	}
}
add_action( 'wolf_post_end', 'sonic_author_meta' );

/**
 * Output author bio box
 *
 * @since Sonic 1.0.0
 */
function sonic_author_info_blox() {

	if (
		is_single()
		&& get_the_author_meta( 'description' )
		&& ! wolf_get_theme_mod( 'blog_hide_author' )
		&& 'post' == get_post_type() || 'review' == get_post_type()
	)
	{
		get_template_part( 'partials/author-bio' );
	}
}
add_action( 'wolf_post_end', 'sonic_author_info_blox' );

/**
 * Output related post or post nav depending on single post option
 *
 * @since Sonic 1.0.0
 */
function sonic_print_post_navigation() {

	$nav_type = wolf_get_theme_mod( 'blog_post_navigation_type', 'standard' );
	$post_types = array( 'post', 'gallery' );

	if ( in_array( get_post_type(), $post_types ) ) {

		if ( 'related' == $nav_type || 'both' == $nav_type  ) {
			get_template_part( 'partials/post/related', 'posts' );
		}

		if ( 'standard' == $nav_type || 'both' == $nav_type ) {
			sonic_post_nav();
		}
	}
}
add_action( 'wolf_post_end', 'sonic_print_post_navigation' );