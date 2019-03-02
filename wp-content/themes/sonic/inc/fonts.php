<?php
/**
 * Sonic Fonts helper
 *
 * This file will be enqueued in the admin and front-end
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Include default fonts if any
 */
wolf_include( 'config/default-fonts.php' );

/**
 * Get loaded google fonts as a clean array
 *
 * @return array
 */
function sonic_get_google_fonts_options() {

	$wolf_google_fonts = array();

	$font_option = ( wolf_get_theme_option( 'google_fonts' ) ) ? wolf_get_theme_option( 'google_fonts' ) . '|' : null;

	if ( $font_option ) {
		$raw_fonts = explode( '|', preg_replace( '/\s+/', '', $font_option ) );

		foreach ( $raw_fonts as $font ) {
			$font_name = str_replace( array( '+', ',', '|', ':' ), array( ' ', '' ), preg_replace( '/\d/', '', $font ) );
			$font_name = str_replace( array( 'italic' ), '', $font_name );
			
			if ( '' != $font_name ) {
				$wolf_google_fonts[ $font_name ] = $font;
			}
		}
	}

	$wolf_google_fonts = array_unique( $wolf_google_fonts );

	return apply_filters( 'sonic_google_fonts', $wolf_google_fonts );
}

/**
 * Get google font URL
 *
 */
function sonic_get_google_fonts_file_url() {

	$url = '';

	$wolf_google_fonts = sonic_get_google_fonts_options();

	if ( array() != $wolf_google_fonts ) {

		$subsets = 'latin,latin-ext';

		$fonts = array_unique( $wolf_google_fonts );
		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'sonic' );

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
 * @since Sonic 1.0
 */
function sonic_enqueue_google_fonts() {

	// Dequeue WPB fonts to avoid duplicated
	wp_dequeue_style( 'wpb-google-fonts' );

	if ( sonic_get_google_fonts_file_url() ) {
		wp_enqueue_style( 'sonic-google-fonts', sonic_get_google_fonts_file_url(), array(), null );
	}
}
add_action( 'admin_enqueue_scripts', 'sonic_enqueue_google_fonts' ); // enqueue google font CSS in admin
add_action( 'wp_enqueue_scripts', 'sonic_enqueue_google_fonts' ); // enqueue google font CSS in frontend

/**
 * Filter the customizer settings to add your fonts to the list
 *
 * @param array $fonts
 * @return array $fonts
 */
function sonic_add_typekit_fonts( $fonts ) {

	$typekit_fonts_option = ( wolf_get_theme_option( 'typekit_fonts' ) ) ? wolf_get_theme_option( 'typekit_fonts' ) . '|' : null;

	if ( $typekit_fonts_option ) {
		
		$raw_fonts = explode( '|', $typekit_fonts_option );

		foreach ( $raw_fonts as $font_name ) {

			if ( '' != $font_name ) {
				$font_slug = sanitize_title( $font_name );
				$fonts[ $font_slug ] = $font_name;
			}
		}
	}

	$fonts = array_unique( $fonts );

	return $fonts;
}
add_filter( 'sonic_customizer_font_choices', 'sonic_add_typekit_fonts' ); // add the fonts to the customizer
add_filter( 'wpb_google_fonts', 'sonic_add_typekit_fonts' ); // add the fonts to the Page Builder settings


