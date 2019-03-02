<?php
/**
 * Wolf Page Builder scripts functions
 *
 * Scripts related functions for frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FRontend
 * @version 2.9.3
 */

/**
 * Register scripts
 *
 * @since Wolf Page Builder 2.9.3
 */
function wpb_register_scripts() {

	// Lightbox
	wp_register_script( 'swipebox', WPB_JS . '/lib/jquery.swipebox.min.js', array( 'jquery' ), '1.2.9', true );
	wp_register_script( 'fancybox', WPB_JS . '/lib/jquery.fancybox.pack.js', array( 'jquery' ), '2.1.5', true );

	// Parallax
	wp_register_script( 'wpb-parallax', WPB_JS . '/lib/parallax.min.js', array( 'jquery' ), '1.4.2', true );

	// Lazyload
	wp_register_script( 'lazyloadxt', WPB_JS . '/lib/jquery.lazyloadxt.min.js', array( 'jquery' ), '1.1.0', true );

	// Flexslider
	wp_register_script( 'flexslider', WPB_JS . '/lib/jquery.flexslider.min.js', array( 'jquery' ), '2.6.1', true );

	// BigText
	wp_register_script( 'bigtext', WPB_JS . '/lib/jquery.bigtext.min.js', array( 'jquery' ), '0.1.8', true );

	// Concat and minifed libraries for theme that use AJAX
	wp_register_script( 'wpb-lib-min', WPB_JS . '/min/lib.min.js', array( 'jquery' ), WPB_VERSION, true );

	// Concat and minifed scripts for theme that use AJAX
	wp_register_script( 'wpb-scripts', WPB_JS . '/min/scripts.min.js', array( 'jquery' ), WPB_VERSION, true );

	/*
	Don't register script below if we use the wpb_force_enqueue_scripts filter
	When using the wpb_force_enqueue_scripts, we will enqueue all these scripts concatenated and minified
	*/
	if ( apply_filters( 'wpb_force_enqueue_scripts', false ) ) {
		return;
	}
	
	// Libraries
	wp_register_script( 'countdown', WPB_JS . '/lib/jquery.countdown.min.js', array( 'jquery' ), '2.0.1', true );
	//wp_register_script( 'counterup', WPB_JS . '/lib/jquery.counterup.min.js', array( 'jquery' ), '1.0', true );
	wp_register_script( 'countup', WPB_JS . '/lib/countUp.min.js', array( 'jquery' ), '1.8.1', true );
	wp_register_script( 'fittext', WPB_JS . '/lib/jquery.fittext.min.js', array( 'jquery' ), '1.2.0', true );
	wp_register_script( 'owlcarousel', WPB_JS . '/lib/owl.carousel.min.js', array( 'jquery' ), '2.0.0', true );
	wp_register_script( 'typed', WPB_JS . '/lib/typed.min.js', array( 'jquery' ), '2.0.1', true );
	wp_register_script( 'wow', WPB_JS . '/lib/wow.min.js', array( 'jquery' ), '1.1.2', true );
	wp_register_script( 'waypoints', WPB_JS . '/lib/jquery.waypoints.min.js', array( 'jquery' ), '1.6.2', true );
	
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WPB_VERSION;

	// Check if SCRIPT_DEBUG is enabled
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

		// Register scripts
		wp_register_script( 'wpb-accordion', WPB_JS . '/accordion.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-advanced-slider', WPB_JS . '/advanced-slider.js', array( 'jquery' ), $version, false );
		wp_register_script( 'wpb-buttons', WPB_JS . '/buttons.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-carousels', WPB_JS . '/carousels.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-countdown', WPB_JS . '/countdown.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-counter', WPB_JS . '/counter.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-icons', WPB_JS . '/icons.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-mailchimp', WPB_JS . '/mailchimp.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-process', WPB_JS . '/process.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-sliders', WPB_JS . '/sliders.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-tabs', WPB_JS . '/tabs.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-toggles', WPB_JS . '/toggles.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-typed', WPB_JS . '/autotyping.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-youtube', WPB_JS . '/youtube.js', array( 'jquery' ), $version, true );

		// Plugin scripts
		wp_register_script( 'wpb-youtube-video-bg', WPB_JS . '/youtube-video-bg.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-functions', WPB_JS . '/functions.js', array( 'jquery' ), $version, true );

	} else {

		// Register scripts
		wp_register_script( 'wpb-accordion', WPB_JS . '/min/accordion.min.js', array( 'jquery' ), $version, true );
		
		wp_register_script( 'wpb-advanced-slider', WPB_JS . '/min/advanced-slider.min.js', array( 'jquery' ), $version, false );
		wp_register_script( 'wpb-buttons', WPB_JS . '/min/buttons.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-carousels', WPB_JS . '/min/carousels.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-countdown', WPB_JS . '/min/countdown.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-counter', WPB_JS . '/min/counter.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-icons', WPB_JS . '/min/icons.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-mailchimp', WPB_JS . '/min/mailchimp.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-process', WPB_JS . '/min/process.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-sliders', WPB_JS . '/min/sliders.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-tabs', WPB_JS . '/min/tabs.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-toggles', WPB_JS . '/min/toggles.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-typed', WPB_JS . '/min/autotyping.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-youtube', WPB_JS . '/min/youtube.min.js', array( 'jquery' ), $version, true );

		// Plugin scripts
		wp_register_script( 'wpb-youtube-video-bg', WPB_JS . '/min/youtube-video-bg.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'wpb-functions', WPB_JS . '/min/functions.min.js', array( 'jquery' ), $version, true );
	}
}
add_action( 'wp_enqueue_scripts', 'wpb_register_scripts' );

/**
 * Enqueue conditional scripts
 *
 * @since Wolf Page Builder 2.9.3
 */
function wpb_enqueue_common_scripts() {

	if ( apply_filters( 'wpb_force_enqueue_scripts', false ) ) {
		return;
	}

	// Lightbox
	$lightbox = wpb_get_option( 'settings', 'lightbox', 'swipebox' );

	// Check lightbox option
	if ( 'swipebox' == $lightbox ) {
		
		wp_enqueue_script( 'swipebox' );
	
	} elseif ( 'fancybox' == $lightbox ) {
		
		wp_enqueue_script( 'fancybox' );
		wp_enqueue_script( 'fancybox-media', WPB_JS . '/lib/jquery.fancybox-media.min.js', array( 'jquery' ), '1.0.6', true );
	}

	wp_enqueue_script( 'wow' );
	wp_enqueue_script( 'waypoints' );
	wp_enqueue_script( 'wpb-parallax' );
	
	if ( wpb_get_option( 'settings', 'do_lazyload' ) ) {
		wp_enqueue_script( 'lazyloadxt' );
	}

	// Plugin common scripts
	wp_enqueue_script( 'wpb-youtube-video-bg' );
	wp_enqueue_script( 'wpb-functions' ); // common functions

	// Recently added elements, need theme update before enqueuing elsewhere
	wp_enqueue_script( 'typed' );
	wp_enqueue_script( 'wpb-typed' );

	// add JS global variables
	wp_localize_script(
		'wpb-functions', 'WPBParams', array(
			'ajaxUrl' => esc_url( WPB()->ajax_url() ),
			'lightbox' => wpb_get_option( 'settings', 'lightbox', 'swipebox' ),
			'doParallaxOnMobile' => wpb_get_option( 'settings', 'do_parallax_mobile' ),
			'doAnimationOnMobile' => wpb_get_option( 'settings', 'do_animation_mobile' ),
			'doLazyLoad' => wpb_get_option( 'settings', 'do_lazyload' ),
			'language' => get_locale(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'wpb_enqueue_common_scripts' );

/**
 * Force Enqueue  JS
 *
 * @since Wolf Page Builder 2.9.3
 */
function wpb_force_enqueue_scripts() {

	/* If the theme need scripts on every page for AJAX, we enqueue everything */
	if ( apply_filters( 'wpb_force_enqueue_scripts', false ) ) {

		// in case these libraries are used by 3rd party plugins
		wp_dequeue_script( 'bigtext' );
		wp_dequeue_script( 'countdown' );
		wp_dequeue_script( 'countup' );
		wp_dequeue_script( 'fittext' );
		wp_dequeue_script( 'owlcarousel' );
		wp_dequeue_script( 'typed' );
		wp_dequeue_script( 'wow' );
		wp_dequeue_script( 'waypoints' );

		// Lightbox
		$lightbox = wpb_get_option( 'settings', 'lightbox', 'swipebox' );

		// Check lightbox option
		if ( 'swipebox' == $lightbox ) {
			
			wp_enqueue_script( 'swipebox' );
		
		} elseif ( 'fancybox' == $lightbox ) {
			
			wp_enqueue_script( 'fancybox' );
			wp_enqueue_script( 'fancybox-media', WPB_JS . '/lib/jquery.fancybox-media.min.js', array( 'jquery' ), '1.0.6', true );
		}

		// WPB lib
		wp_enqueue_script( 'wpb-parallax' );
		wp_enqueue_script( 'wpb-lib-min' ); // all lib files
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-tabs' );

		if ( wpb_get_option( 'settings', 'do_lazyload' ) ) {
			wp_enqueue_script( 'lazyloadxt' );
		}

		// WPB scripts
		wp_enqueue_script( 'wpb-scripts' );
		
		// add JS global variables
		wp_localize_script(
			'wpb-scripts', 'WPBParams', array(
				'ajaxUrl' => esc_url( WPB()->ajax_url() ),
				'lightbox' => wpb_get_option( 'settings', 'lightbox', 'swipebox' ),
				'doParallaxOnMobile' => wpb_get_option( 'settings', 'do_parallax_mobile' ),
				'doAnimationOnMobile' => wpb_get_option( 'settings', 'do_animation_mobile' ),
				'doLazyLoad' => wpb_get_option( 'settings', 'do_lazyload' ),
				'language' => get_locale(),
			)
		);

		// MailChimp
		wp_enqueue_script( 'wpb-mailchimp', WPB_JS . '/min/mailchimp.min.js', array( 'jquery' ), WPB_VERSION, true );
		
		// Add MailChimp JS global variables
		wp_localize_script(
			'wpb-mailchimp', 'WPBMailchimpParams', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'wpb_force_enqueue_scripts', 100 );