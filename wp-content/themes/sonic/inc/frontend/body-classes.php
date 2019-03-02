<?php
/**
 * Sonic body classes
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_body_classes' ) ) {
	/**
	 * Add specific class to the body depending on theme options and page template
	 *
	 * @version 2.2.4
	 * @param array $classes
	 * @return array $classes
	 */
	function sonic_body_classes( $classes ) {

		if ( sonic_is_customizer() ) {
			$classes[] = 'is-customizer';
		}

		$classes[] = 'loading'; // will be removed with JS
		$classes[] = 'wolf';
		$classes[] = wolf_get_theme_slug();

		$classes[] = 'site-layout-' . wolf_get_theme_mod( 'site_layout', 'wide' ); // layout
		
		$classes[] = 'skin-' . sonic_get_color_scheme_option(); // skin
		
		$classes[] = 'text-link-style-' . wolf_get_theme_mod( 'text_link_style', 'default' ); // text link

		$classes[] = 'lightbox-' . apply_filters( 'sonic_lightbox', wolf_get_theme_mod( 'lightbox', 'swipebox' ) ); // lightbox

		if ( wolf_get_theme_mod( 'no_loading_overlay' ) ) {
			$classes[] = 'no-loading-overlay';
		}

		if ( get_header_image() ) {
			$classes[] = 'has-default-header';
		}

		/**
		 * Ajax navigation
		 */
		if ( sonic_do_ajax_nav() ) {
			$classes[] = 'is-ajax-nav';
		}

		if ( wolf_get_theme_mod( 'no_ajax_progress_bar' ) ) {
			$classes[] = 'hide-ajax-progress-bar';
		}

		$classes[] = 'blog-navigation-' . wolf_get_theme_mod( 'blog_post_navigation_type' ); // blog nav

		/* Blog pages */
		if ( sonic_is_blog() ) {

			$classes[] = 'is-blog';
			$classes[] = 'blog-layout-' . sonic_get_blog_layout(); // blog layout
			$classes[] = 'blog-display-' . sonic_get_blog_display(); // blog display
			$classes[] = 'blog-grid-padding-' . sonic_get_blog_padding(); // blog grid padding

			if ( wolf_get_theme_mod( 'blog_hide_date' ) ) {
				$classes[] = 'blog-hide-date';
			}

			if ( wolf_get_theme_mod( 'blog_hide_author' ) ) {
				$classes[] = 'blog-hide-author';
			}

			if ( wolf_get_theme_mod( 'blog_hide_category' ) ) {
				$classes[] = 'blog-hide-category';
			}

			if ( wolf_get_theme_mod( 'blog_hide_tags' ) ) {
				$classes[] = 'blog-hide-tags';
			}

			if ( wolf_get_theme_mod( 'blog_hide_comments_count' ) ) {
				$classes[] = 'blog-hide-comments-count';
			}

			if ( wolf_get_theme_mod( 'blog_hide_views' ) ) {
				$classes[] = 'blog-hide-views';
			}

			if ( wolf_get_theme_mod( 'blog_hide_likes' ) ) {
				$classes[] = 'blog-hide-likes';
			}

			if ( wolf_get_theme_mod( 'blog_hide_share' ) ) {
				$classes[] = 'blog-hide-share';
			}
		}

		if ( sonic_do_infinitescroll() ) {
			$classes[] = 'is-infinitescroll';
		}

		if ( sonic_do_infinitescroll_trigger() ) {
			$classes[] = 'is-infinitescroll-trigger';
		}

		if ( sonic_do_masonry() ) {
			$classes[] = 'is-masonry';
		}

		if ( sonic_do_ajax_category_filter() ) {
			$classes[] = 'is-ajax-category-filter';
		}
		
		/**
		 * Wolf plugins
		 */

		/* Portfolio pages */
		if ( sonic_is_portfolio() ) {
			
			$classes[] = 'is-portfolio';
			$classes[] = 'portfolio-layout-' . sonic_get_portfolio_layout(); // portfolio layout
			$classes[] = 'portfolio-display-' . sonic_get_portfolio_display(); // portfolio display
			$classes[] = 'portfolio-grid-padding-' . wolf_get_theme_mod( 'portfolio_grid_padding', 'yes' ); // portfolio grid padding

			if ( wolf_get_theme_mod( 'portfolio_hide_date' ) ) {
				$classes[] = 'portfolio-hide-date';
			}

			if ( wolf_get_theme_mod( 'portfolio_hide_author' ) ) {
				$classes[] = 'portfolio-hide-author';
			}

			if ( wolf_get_theme_mod( 'portfolio_hide_category' ) ) {
				$classes[] = 'portfolio-hide-category';
			}

			if ( wolf_get_theme_mod( 'portfolio_hide_tags' ) ) {
				$classes[] = 'portfolio-hide-tags';
			}

			if ( wolf_get_theme_mod( 'portfolio_hide_comments_count' ) ) {
				$classes[] = 'portfolio-hide-comments-count';
			}

			if ( wolf_get_theme_mod( 'portfolio_hide_views' ) ) {
				$classes[] = 'portfolio-hide-views';
			}

			if ( wolf_get_theme_mod( 'portfolio_hide_likes' ) ) {
				$classes[] = 'portfolio-hide-likes';
			}

			if ( wolf_get_theme_mod( 'portfolio_hide_share' ) ) {
				$classes[] = 'portfolio-hide-share';
			}
		}

		if ( sonic_is_discography() ) {
			// Discography
			$classes[] = 'is-discography';
			$classes[] = 'discography-layout-' . wolf_get_theme_mod( 'discography_layout', 'standard' );
			$classes[] = 'discography-display-' . wolf_get_theme_mod( 'discography_display', 'standard' );
			$classes[] = 'discography-columns-' . wolf_get_theme_mod( 'discography_columns', 4 );
			$classes[] = 'discography-padding-' . wolf_get_theme_mod( 'discography_padding', 'yes' );
		}
		
		if ( sonic_is_albums() ) {
			// Albums
			$classes[] = 'albums-layout-' . wolf_get_theme_mod( 'albums_layout', 'standard' );
			$classes[] = 'albums-columns-' . wolf_get_theme_mod( 'albums_columns', 4 );
			$classes[] = 'albums-padding-' . wolf_get_theme_mod( 'albums_padding', 'yes' );
			$classes[] = 'albums-display-' . sonic_get_albums_display();
		}

		if ( sonic_is_videos() ) {
			// Videos
			$classes[] = 'videos-layout-' . wolf_get_theme_mod( 'videos_layout', 'standard' );
			$classes[] = 'videos-padding-' . wolf_get_theme_mod( 'videos_padding', 'yes' );
			$classes[] = 'videos-columns-' . wolf_get_theme_mod( 'videos_columns', 3 );
			//$classes[] = 'videos-hover-' . wolf_get_theme_mod( 'videos_hover_effect', 'effect-1' );

			if ( wolf_get_theme_mod( 'videos_lightbox' ) ) {
				$classes[] = 'do-video-lightbox';
			}
		}

		if ( sonic_is_portfolio() ) {
			// Portfolio
			$classes[] = 'portfolio-layout-' . wolf_get_theme_mod( 'portfolio_layout', 'standard' );
			$classes[] = 'portfolio-columns-' . wolf_get_theme_mod( 'portfolio_columns', 4 );
			$classes[] = 'portfolio-padding-' . wolf_get_theme_mod( 'portfolio_padding', 'yes' );
			//$classes[] = 'portfolio-hover-' . wolf_get_theme_mod( 'portfolio_hover_effect', 'effect-1' );
		}

		if ( sonic_is_events() ) {
			// events
			$classes[] = 'events-layout-' . wolf_get_theme_mod( 'events_layout', 'standard' );
			$classes[] = 'events-columns-' . wolf_get_theme_mod( 'events_columns', 4 );
			$classes[] = 'events-padding-' . wolf_get_theme_mod( 'events_padding', 'yes' );
			//$classes[] = 'portfolio-hover-' . wolf_get_theme_mod( 'portfolio_hover_effect', 'effect-1' );
		}

		if ( sonic_is_woocommerce() ) {
			
			if ( is_singular( 'product' ) ) {
				$classes[] = 'shop-layout-' . wolf_get_theme_mod( 'shop_single_layout', 'fullwidth' );
			} else {
				$classes[] = 'shop-layout-' . wolf_get_theme_mod( 'shop_layout', 'sidebar-right' );
			}
			
			$classes[] = 'shop-columns-' . wolf_get_theme_mod( 'shop_columns', 4 );

			// display shop padding class on every page in case the shortcode it used
			//$classes[] = 'shop-padding-' . wolf_get_theme_mod( 'shop_padding', 'yes' );
		}

		// output this class on all pages in case shortcodes are used
		$classes[] = 'shop-display-' . apply_filters( 'sonic_shop_display', wolf_get_theme_mod( 'shop_display', 'grid' ) );

		/* Is WPB installed? */
		if ( sonic_has_wpb() ) {
			$classes[] = 'has-wpb';
		}

		/* Is VC used? */
		if ( sonic_is_vc() ) {
			$classes[] = 'is-vc';
		}

		/* No logo */
		if ( ! wolf_get_theme_mod( 'logo_light' ) && ! wolf_get_theme_mod( 'logo_dark' ) ) {
			$classes[] = 'no-logo';
		}

		/* Menu */
		if ( ! sonic_is_main_menu() ) {
			$classes[] = 'no-menu';
		}

		$classes[] = 'menu-search-' . wolf_get_theme_mod( 'search_menu_item', 'overlay' );

		/* Header has content */
		if ( sonic_has_hero() ) {
			
			$classes[] = 'has-hero';
		} else {
			
			$classes[] = 'no-hero';
		}

		/* Full screen home header */
		if ( wolf_get_theme_option( 'full_screen_header' ) ) {
			$classes[] = 'full-window-header';
		}

		/* Multi author */
		if ( is_multi_author() ) {
			$classes[] = 'is-multi-author';
		}

		/* Menu */
		if ( wolf_get_theme_mod( 'sticky_menu' ) ) {
			$classes[] = 'sticky-menu';
		}

		/* Menu layout */
		if ( sonic_display_topbar() ) {
			$classes[] = 'is-top-bar';
		}

		$menu_layout = sonic_get_menu_layout();
		$classes[] = 'menu-layout-' . $menu_layout;

		/* Menu width */
		$classes[] = 'menu-width-' . wolf_get_theme_mod( 'menu_width', 'boxed' );

		/* Menu centered aligment */
		$classes[] = 'menu-centered-alignment-' . wolf_get_theme_mod( 'menu_centered_alignment', 'boxed' );

		/* Sub menu width */
		$classes[] = 'submenu-width-' . wolf_get_theme_mod( 'submenu_width', 'boxed' );

		/* Menu type (transparent/solid etc..) */
		$classes[] = 'menu-type-' . sonic_get_menu_type();

		/* Menu hover style */
		$classes[] = 'menu-hover-style-' . wolf_get_theme_mod( 'menu_hover_style', 'none' );

		/* Button style */
		$classes[] = 'button-style-' . wolf_get_theme_mod( 'button_style', 'default' );

		/* Bottom bar layout */
		$classes[] = 'bottom-bar-layout-' . wolf_get_theme_mod( 'bottom_bar_layout', 'default' );

		if ( has_nav_menu( 'tertiary' ) ) {
			$classes[] = 'has-bottom-menu';
		} else {
			$classes[] = 'no-bottom-menu';
		}

		/* Post title area */

		$header_type = sonic_get_header_type();
		$classes[] = 'post-header-type-' . $header_type;

		if ( get_post_meta( sonic_get_header_post_id(), '_post_hide_title_text', true ) ) {
			$classes[] = 'post-hide-title-text';
		} else {
			$classes[] = 'post-is-title-text';
		}

		/* Post title area */
		if ( 'none' == sonic_get_header_type() ) {
			$classes[] = 'post-hide-title-area';
		} else {
			$classes[] = 'post-is-title-area';
		}

		/* Hide footer if post option is set */
		if ( get_post_meta( sonic_get_header_post_id(), '_post_hide_footer', true ) ) {
			$classes[] = 'post-hide-footer';
		}

		/* Hide featured image if post options is set */
		if ( get_post_meta( sonic_get_header_post_id(), '_post_hide_featured_image', true ) ) {
			$classes[] = 'post-hide-featured-image';
		}

		/* Page template clean classes */
		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'page-full-width';
		}

		if ( is_page_template( 'page-templates/page-sidebar-right.php' ) ) {
			$classes[] = 'page-sidebar-right';
		}
			
		if ( is_page_template( 'page-templates/page-sidebar-left.php' ) ) {
			$classes[] = 'page-sidebar-left';
		}

		if ( is_page_template( 'page-templates/post-archives.php' ) ) {
			$classes[] = 'page-post-archives';
		}

		/* Footer widget layout */
		$classes[] = 'footer-layout-' . wolf_get_theme_mod( 'footer_layout', 'boxed' );
		$classes[] = 'footer-widgets-layout-' . wolf_get_theme_mod( 'footer_widgets_layout', '4-cols' );

		/* Scroll to top link typ */
		$classes[] = 'scroll-to-top-' . wolf_get_theme_mod( 'scroll_to_top_link_type', 'arrow' );
		$classes[] = 'scroll-to-top-arrow-style-' . wolf_get_theme_mod( 'scroll_to_top_arrow_style', 'round' );

		/* Menu bottom */
		if ( wolf_get_theme_mod( 'menu_bottom_border', '' ) ) {
			$classes[] = 'menu-bottom-border';
		}

		/* Single post */
		if ( is_single() && 'post' == get_post_type() ) {
			$classes[] = 'single-post-layout-' . sonic_get_single_post_layout();
		}

		/* Single work */
		if ( is_singular( 'work' ) ) {
			$classes[] = 'single-work-layout-' . sonic_get_single_work_layout();
		}

		/* Single gallery */
		if ( is_singular( 'gallery' ) ) {
			$classes[] = 'single-gallery-layout-' . sonic_get_single_gallery_layout();
		}

		/* is 404 header image? */
		if ( is_404() ) {
			if ( wolf_get_theme_option( '404_bg' ) ) {
				$classes[] = 'has-404-bg';
			} else {
				$classes[] = 'no-404-bg';
			}
		}

		return $classes;
	}
	add_filter( 'body_class', 'sonic_body_classes' );
}