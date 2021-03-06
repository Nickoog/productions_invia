<?php
/**
 * Sonic scripts
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_enqueue_scripts' ) ) {
	/**
	 * Register theme scripts for the theme
	 *
	 * We will use the wp_enqueue_scripts function in framework/wolf-core.php to enqueue scripts
	 *
	 * @since Sonic 1.0.0
	 */
	function sonic_enqueue_scripts() {

		// First, ensure to overwrite scripts enqueued by a plugin
		wp_dequeue_script( 'wolf-portfolio' );

		$lightbox = wolf_get_theme_mod( 'lightbox', 'swipebox' );

		// Media elements (for AJAX processed content)
		wp_enqueue_script( 'wp-mediaelement' );

		// Polyfill to remove click delays on browsers with touch UIs
		wp_enqueue_script( 'fastclick', WOLF_THEME_JS . '/lib/fastclick.js', array( 'jquery' ), '1.0.6', true );

		// Theme parallax
		wp_register_script( 'sonic-parallax', WOLF_THEME_JS . '/lib/parallax.min.js', array( 'jquery' ), '1.4.2c', true );
		
		// Register scripts that could be enqueued conditionally
		wp_register_script( 'flexslider', WOLF_THEME_JS . '/lib/jquery.flexslider.min.js', array( 'jquery' ), '2.2.2', true );
		wp_register_script( 'owlcarousel', WOLF_THEME_JS . '/lib/owl.carousel.min.js', array( 'jquery' ), '2.0.0', true );
		wp_register_script( 'swipebox', WOLF_THEME_JS . '/lib/jquery.swipebox.min.js', array( 'jquery' ), '1.2.9', true );
		wp_register_script( 'fancybox', WOLF_THEME_JS . '/lib/jquery.fancybox.pack.js', array( 'jquery' ), '2.1.5', true );
		wp_register_script( 'imagesloaded', WOLF_THEME_JS . '/lib/imagesloaded.pkgd.min.js', array( 'jquery' ), '4.1.0', true );
		wp_register_script( 'isotope', WOLF_THEME_JS . '/lib/isotope.pkgd.min.js', array( 'jquery' ), '3.0.0', true );
		wp_register_script( 'packery', WOLF_THEME_JS . '/lib/packery-mode.pkgd.min.js', array( 'jquery' ), '2.0.0', true );
		wp_register_script( 'flex-images', WOLF_THEME_JS . '/lib/jquery.flex-images.min.js', array( 'jquery' ), '1.0.4', true );
		wp_register_script( 'infinitescroll', WOLF_THEME_JS . '/lib/jquery.infinitescroll.min.js', array( 'jquery' ), '2.0.2', true );
		wp_register_script( 'lazyloadxt', WOLF_THEME_JS . '/lib/jquery.lazyloadxt.min.js', array( 'jquery' ), '1.1.0', true );

		// Check lightbox option
		if ( 'swipebox' == $lightbox ) {
			
			wp_enqueue_script( 'swipebox' );
		
		} elseif ( 'fancybox' == $lightbox ) {
			
			wp_enqueue_script( 'fancybox' );
			wp_enqueue_script( 'fancybox-media', WOLF_THEME_JS . '/lib/jquery.fancybox-media.min.js', array( 'jquery' ), '1.0.6', true );

		}
		
		// Enqueue theme libraries
		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'sonic-parallax' );

		if ( is_404() && sonic_has_wpb() ) {
			wp_enqueue_script( 'bigtext' );
		}

		// Register theme specific scripts
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

			/* Unminified scripts */

			// Theme specific scripts
			wp_enqueue_script( 'sonic-youtube-video-bg', WOLF_THEME_JS . '/youtube-video-bg.js',  array( 'jquery' ), WOLF_THEME_VERSION, true );
			wp_enqueue_script( 'sonic-theme-cookie', WOLF_THEME_JS . '/lib/jquery.memo.min.js', 'jquery', '1.0', true );
			wp_enqueue_script( 'wolftheme', WOLF_THEME_JS . '/functions.js', array( 'jquery' ), WOLF_THEME_VERSION, true );
		
			// Infinite scroll theme script
			wp_register_script( 'sonic-infinitescroll', WOLF_THEME_JS . '/infinitescroll.js', array( 'jquery' ), WOLF_THEME_VERSION, true );

			// Category filter theme script
			wp_register_script( 'sonic-filter', WOLF_THEME_JS . '/filter.js', array( 'jquery' ), WOLF_THEME_VERSION, true );

			// Masonry theme script
			wp_register_script( 'sonic-masonry', WOLF_THEME_JS . '/masonry.js', array( 'jquery' ), WOLF_THEME_VERSION, true );

			// Ajax navigation 
			wp_register_script( 'sonic-ajax-nav', WOLF_THEME_JS . '/ajax.js',  array( 'jquery' ), WOLF_THEME_VERSION, true );
			
		} else {

			/* Minified scripts */

			// Theme specific scripts minified
			wp_enqueue_script( 'wolftheme', WOLF_THEME_JS . '/min/app.min.js', array( 'jquery' ), WOLF_THEME_VERSION, true );
	
			// Infinite scroll theme script
			wp_register_script( 'sonic-infinitescroll', WOLF_THEME_JS . '/min/infinitescroll.min.js', array( 'jquery' ), WOLF_THEME_VERSION, true );

			// Category filter theme script
			wp_register_script( 'sonic-filter', WOLF_THEME_JS . '/min/filter.min.js', array( 'jquery' ), WOLF_THEME_VERSION, true );

			// Masonry theme script
			wp_register_script( 'sonic-masonry', WOLF_THEME_JS . '/min/masonry.min.js', array( 'jquery' ), WOLF_THEME_VERSION, true );

			// Ajax navigation 
			wp_register_script( 'sonic-ajax-nav', WOLF_THEME_JS . '/min/ajax.min.js',  array( 'jquery' ), WOLF_THEME_VERSION, true );
		}

		/*  Masonry script library */
		if ( sonic_do_masonry() ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
		}
		
		if ( sonic_do_infinitescroll() ) {

			// enqeue jPlayer scripts in case it is loaded with AJAX
			if ( class_exists( 'Wolf_jPlayer' ) ) {
				if ( wolf_get_jplayer_option( 'scrollbar' ) && 0 == wolf_get_jplayer_option( 'skin' ) ) {
					wp_enqueue_script( 'mCustomScrollbar' );
				}

				wp_enqueue_script( 'wolf-jplayer' );
			}

			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'infinitescroll' );
			wp_enqueue_script( "sonic-infinitescroll" );
		}
		
		/* Packery for metro display */
		if ( sonic_do_packery() ) {
			wp_enqueue_script( 'packery' );
		}

		/* Ajax category filter */
		if ( sonic_do_ajax_category_filter() ) {
			wp_enqueue_script( 'sonic-filter' );
		}	
		
		/* Theme masonry scripts */
		if ( sonic_do_masonry() ) {
			wp_enqueue_script( 'sonic-masonry' );
		}

		/* LazyLoad */
		wp_enqueue_script( 'lazyloadxt' );

		/**
		 * If AJAX navigation is enabled, we enqueued everything with may need from start
		 */
		if ( sonic_do_ajax_nav() ) {

			// Libraries
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'packery' );
			wp_enqueue_script( 'infinitescroll' );

			// Theme scripts
			wp_enqueue_script( 'sonic-filter' );
			wp_enqueue_script( 'sonic-masonry' );
			wp_enqueue_script( 'sonic-infinitescroll' );
						
			// Wolf plugins
			wp_enqueue_script( 'wolf-videos' );
			wp_enqueue_script( 'wolf-albums' );
			
			// WooCommerce scripts
			if ( class_exists( 'WooCommerce' ) ) {
				
				wp_enqueue_script( 'wc-single-product' );
				
				$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
				wp_enqueue_script( 'wc-jquery-ui-touchpunch', WC()->plugin_url() . '/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );
				wp_enqueue_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider', 'wc-jquery-ui-touchpunch' ), WC_VERSION, true );
			}
			
			wp_enqueue_script( 'sonic-ajax-nav' );
		}

		// Add JS global variables
		wp_localize_script(
			'wolftheme', 'SonicParams', array(
				'siteUrl' => esc_url( site_url( '/' ) ),
				'homeUrl' => esc_url( home_url( '/' ) ),
				'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'hasWPB' => sonic_has_wpb(),
				'themeSlug' => wolf_get_theme_slug(),
				'accentColor' => wolf_get_theme_mod( 'accent_color', '#007acc' ),
				'breakPoint' => apply_filters( 'sonic_menu_breakpoint', wolf_get_theme_mod( 'menu_breakpoint', 1100 ) ),
				'isStickyMenu' => wolf_get_theme_mod( 'sticky_menu' ),
				'menuLayout' => sonic_get_menu_layout(),
				'stickyMenuScrollPoint' => apply_filters( 'sonic_sticky_menu_scrollpoint', 250 ),
				'lightbox' => apply_filters( 'sonic_lightbox', wolf_get_theme_mod( 'lightbox', 'swipebox' ) ),
				'doWoocommerceLightbox' => ( 'no' == get_option( 'woocommerce_enable_lightbox' ) ),
				'doBackToTopAnimation' => ( 'arrow' == wolf_get_theme_mod( 'scroll_to_top_link_type' ) ),
				'isWooCommerce' => function_exists( 'WC' ),
				'WooCommerceCartUrl' => ( function_exists( 'WC' ) ) ? WC()->cart->get_cart_url() : '',
				'WooCommerceCheckoutUrl' => ( function_exists( 'WC' ) ) ? WC()->cart->get_checkout_url() : '',
				'WooCommerceAccountUrl' => ( function_exists( 'WC' ) ) ? get_permalink( get_option('woocommerce_myaccount_page_id') ) : '',
				'doVideoLightbox' => ( 'yes' == wolf_get_theme_mod( 'videos_lightbox' ) ),
				'infiniteScrollEmptyLoad' => wolf_get_theme_uri( 'assets/img/blank.gif' ),
				'isCustomizer' => sonic_is_customizer(),
				'isAjaxNav' => sonic_do_ajax_nav(),
				'is404' => is_404(),
				'isUserLoggedIn' => is_user_logged_in(),
				'allowedMimeTypes' => array_keys( get_allowed_mime_types() ),
				'language' => get_locale(),
				'l10n' => array(
					'replyTitle' => esc_html__( 'Post a comment', 'sonic' ),
					'editPost' => esc_html__( 'Edit Post', 'sonic' ),
					'infiniteScrollMsg' => esc_html__( 'Loading...', 'sonic' ),
					'infiniteScrollEndMsg' => esc_html__( 'No more post to load', 'sonic' ),
					'loadMoreMsg' => esc_html__( 'Load more', 'sonic' ),
					'infiniteScrollDisabledMsg' => esc_html__( 'The infinitescroll is disabled in live preview mode', 'sonic' ),
					'categoryFilterDisabledMsg' => esc_html__( 'The category filter is disabled in live preview mode', 'sonic' ),
				),
			)
		);

		// Add framework JS global variables
		wp_localize_script(
			'wolftheme', 'WolfFrameworkJSParams', array(
				'menuOffsetDesktop' => ( wolf_get_theme_mod( 'sticky_menu' ) ) ? 80 : 0,
				'menuOffsetBreakpoint' => ( wolf_get_theme_mod( 'sticky_menu' ) ) ? 60 : 0,
				'menuOffsetMobile' => ( wolf_get_theme_mod( 'sticky_menu' ) ) ? 50 : 0,
				'menuOffsetTopBar' => ( sonic_display_topbar() ) ? 38 : 0,
			)
		);

		// loads the javascript required for threaded comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'sonic_enqueue_scripts' );
} // end function check

/**
 * Force WPB to enqueue all scripts for AJAX
 *
 * Wolf Page Builder enqueue scripts conditionally. We need all scripts from start for AJAX navigation.
 * We set the wpb_force_enqueue_scripts filter to true right here
 */
function sonic_wpb_force_enqueue_scripts() {

	if ( sonic_do_ajax_nav() ) {
		return true;
	}
}
add_filter( 'wpb_force_enqueue_scripts', 'sonic_wpb_force_enqueue_scripts' );


/**
 * Dequeue WPB parallax script because we use a slightly modified version
 */
function sonic_dequeue_wpb_parallax() {
	wp_dequeue_script( 'wpb-parallax' );
}
add_action( 'wp_enqueue_scripts', 'sonic_dequeue_wpb_parallax', 101 );
