<?php
/**
 * Sonic site page hook functions
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
 * Output scroll arrow
 *
 * @since Sonic 1.0.0
 */
function sonic_top_anchor() {
	?>
	<div id="top"></div>
	<?php
}
add_action( 'wolf_body_start', 'sonic_top_anchor' );

/**
 * Scroll down arrow
 *
 * @since Sonic 1.0.0
 */
function sonic_scroll_top_top_link() {
	
	if ( 'none' != wolf_get_theme_mod( 'scroll_to_top_link_type' ) ) {
		?>
		<a href="#top" class="scroll" id="back-to-top"><?php esc_html_e( 'Back to the top', 'sonic' ); ?></a>
		<?php
	}
}
add_action( 'wolf_body_start', 'sonic_scroll_top_top_link' );

/**
 * Output loader overlay
 *
 * @since Sonic 1.0.0
 */
function sonic_page_loading_overlay() {

	if ( wolf_get_theme_mod( 'no_loading_overlay' ) ) {
		return;
	}
	?>
	<div id="loading-overlay" class="loading-overlay">
		<?php sonic_loader(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'wolf_body_start', 'sonic_page_loading_overlay' );

/**
 * Add mobile closer overlay
 */
function sonic_add_mobile_closer_overlay() {
	?>
	<div id="mobile-closer-overlay" class="mobile-menu-toggle-button"></div>
	<?php
}
add_action( 'wolf_body_start', 'sonic_add_mobile_closer_overlay' );

/**
 * Output ajax loader overlay
 */
function sonic_ajax_loading_overlay() {

	if ( wolf_get_theme_mod( 'no_transition_overlay' ) ) {
		return;
	}
	?>
	<div id="ajax-loading-overlay" class="loading-overlay">
		<?php sonic_loader(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'wolf_site_content_start', 'sonic_ajax_loading_overlay' );

/**
 * Output search form overlay
 */
function sonic_menu_overlay_search_form() {

	if ( 'overlay' == wolf_get_theme_mod( 'search_menu_item' ) ) {
		get_template_part( 'partials/search/search', 'overlay' );
	}

}
add_action( 'wolf_body_start', 'sonic_menu_overlay_search_form' );

/**
 * Output search form overlay
 */
function sonic_menu_product_search_form() {

	if ( 'woocommerce' == wolf_get_theme_mod( 'search_menu_item' ) && function_exists( 'get_product_search_form' ) ) {
		get_template_part( 'partials/search/search', 'woocommerce' );
	}

}
add_action( 'sonic_wooocommerce_search', 'sonic_menu_product_search_form' );

/**
 * Output blog pagination
 */
function sonic_output_blog_pagination() {
	
	if ( sonic_do_infinitescroll() ) {
		/**
		 * Theme standard pagination used for infinite scroll
		 */
		sonic_paging_nav();
	
	} else {
		/**
		 * Pagination numbers
		 */
		the_posts_pagination( array(
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>',
		) );
	}
}
add_action( 'sonic_blog_pagination', 'sonic_output_blog_pagination' );

/**
 * Output bottom bar with menu copyright text and social icons
 */
function sonic_bottom_bar() {
	$services = sanitize_text_field( wolf_get_theme_mod( 'footer_socials_services' ) );
	$display_menu = has_nav_menu( 'tertiary' );
	$credits = wolf_get_theme_mod( 'copyright' );

	if ( $services || $display_menu || $credits ) :
	?>
	<div class="site-infos clearfix">
		<div class="bottom-social-links">
			<?php
			
			if ( function_exists( 'wpb_socials' ) && $services ) {
				echo wpb_socials( array( 'services' => $services ) );
			}	
			?>
		</div><!-- .bottom-social-links -->
		<?php
			/**
			 * Fires in the Sonic bottom menu
			 *
			 */
			do_action( 'sonic_bottom_menu' );
		?>
		<?php if ( has_nav_menu( 'tertiary' ) ) : ?>
		<div class="clear"></div>
		<?php endif; ?>
		<div class="credits">
			<?php
				/**
				 * Fires in the Sonic footer text for customization.
				 *
				 * @since Sonic 1.0
				 */
				do_action( 'sonic_credits' );
			?>
		</div><!-- .credits -->
	</div><!-- .site-infos -->
	<?php
	endif;

}
add_action( 'sonic_bottom_bar', 'sonic_bottom_bar' );

/**
 * Copyright/site info text
 *
 * @since Sonic 1.0.0
 */
function sonic_site_infos() {

	$footer_text = wolf_get_theme_mod( 'copyright' );

	if ( $footer_text ) {
		$footer_text = '<span class="copyright-text">' . $footer_text . '</span>';
		echo apply_filters( 'sonic_copyright_text', $footer_text );
	}
}
add_action( 'sonic_credits', 'sonic_site_infos' );