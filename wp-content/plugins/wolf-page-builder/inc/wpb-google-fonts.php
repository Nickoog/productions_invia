<?php
/**
 * Wolf Page Builder Fonts Functions
 *
 * Enqueue google fonts depending on user settings
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get loaded google fonts as a clean array
 *
 * @return array
 */
function wpb_get_google_fonts_options() {

	$wpb_google_fonts = array();

	$font_option = ( wpb_get_option( 'fonts', 'google_fonts' ) ) ? wpb_get_option( 'fonts', 'google_fonts' ) . '|' : null;

	if ( $font_option ) {
		$raw_fonts = explode( '|', preg_replace( '/\s+/', '', $font_option ) );

		foreach ( $raw_fonts as $font ) {
			$font_name = str_replace( array( '+', ',', '|', ':' ), array( ' ', '' ), preg_replace( '/\d/', '', $font ) );
			$font_name = str_replace( array( 'italic' ), '', $font_name );
			
			if ( '' != $font_name ) {
				$wpb_google_fonts[ $font_name ] = $font;
			}
		}
	}

	$wpb_google_fonts = array_unique( $wpb_google_fonts );

	return apply_filters( 'wpb_google_fonts', $wpb_google_fonts );
}

/**
 * Get google font URL
 *
 * @since Wolf Page Builder 1.7
 */
function wpb_get_google_fonts_file_url() {


	$url = '';

	$wpb_google_fonts = wpb_get_google_fonts_options();

	if ( array() != $wpb_google_fonts ) {

		$subsets = 'latin,latin-ext';

		$fonts = array_unique( $wpb_google_fonts );
		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'wolf-page-builder' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		$url = add_query_arg( array(
			'family' => implode( urlencode( '|' ), $fonts ),
			'subset' => $subsets,
		), 'https://fonts.googleapis.com/css' );

		return esc_url( $url );
	}
}

/**
 * Loads our special font CSS file.
 *
 * @since Wolf Page Builder 1.0
 */
function wpb_enqueue_google_fonts() {

	if ( wpb_get_google_fonts_file_url() ) {
		wp_enqueue_style( 'wpb-google-fonts', wpb_get_google_fonts_file_url(), array(), null );
	}
}
add_action( 'admin_enqueue_scripts', 'wpb_enqueue_google_fonts' ); // enqueue google font CSS in admin
add_action( 'wp_enqueue_scripts', 'wpb_enqueue_google_fonts' ); // enqueue google font CSS in frontend

/**
 * Add preconnect for Google Fonts.
 *
 * @since Wolf Page Builder 2.4.8
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function wpb_resource_hints( $urls, $relation_type ) {
	
	if ( wp_style_is( 'wpb-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'wpb_resource_hints', 10, 2 );

/**
 * Add google font to editor style
 *
 * @since Wolf Page Builder 1.7
 */
function wpb_add_google_fonts_editor_styles() {

	if ( wpb_get_google_fonts_file_url() ) {
		$font_url = str_replace( ',', '%2C', wpb_get_google_fonts_file_url() );
		add_editor_style( $font_url );
	}
}
add_action( 'after_setup_theme', 'wpb_add_google_fonts_editor_styles' );