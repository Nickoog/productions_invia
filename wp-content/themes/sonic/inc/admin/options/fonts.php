<?php
/**
 * Sonic fonts options
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_font_options( $sonic_options ) {

	$sonic_options[] = array(
		'type' => 'open',
		'label' => esc_html__( 'Fonts Loader', 'sonic' ),
	);

		$sonic_options[] = array(
			'label' => esc_html__( 'Fonts', 'sonic' ),
			'type' => 'section_open',
			'desc' => sprintf(
				wp_kses(
						__( 'Loads your fonts here then select which font to use in the <a href="%s">customizer</a>.', 'sonic' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'customize.php' ) )
				),
		);

			$sonic_options[] = array(
				'label' => esc_html__( 'Google Font Loader', 'sonic' ),
				'id' => 'google_fonts',
				'desc' => sprintf( wp_kses(
						__( 'You can get your fonts on the <a href="%s" target="_blank">Google Fonts</a> website.', 'sonic' ),
						array( 'a' => array( 'href' => array(), 'target' => array() ) )
					),
					esc_url( 'https://www.google.com/fonts' )
				),
				'placeholder' => 'Lora:400,700|Roboto:400,700',
				'type' => 'text',
				'size' => 'long',
				'help' => 'google-fonts.jpg',
			);

			$sonic_options[] = array(
				'label' => esc_html__( 'Typekit Font Loader', 'sonic' ),
				'id' => 'typekit_fonts',
				'desc' => sprintf(
					wp_kses_post(
						__( 'You need <a href="%s" target="_blank">Typekit Fonts for WordPress</a> plugin to import your font kit into your website. Once your font kit is imported, add your font names separted by a "|"  in this field to be able to select them in the customizer. <a href="%s" target="_blank">More infos</a>', 'sonic' )
					),
					esc_url( 'https://wordpress.org/plugins/typekit-fonts-for-wordpress/' ),
					esc_url( 'https://docs.wolfthemes.com/document/add-typekit-fonts-theme/' )
				),
				'placeholder' => 'adobe-caslon-pro|other-font',
				'type' => 'text',
				'size' => 'long',
				'help' => 'typekit.png',
			);

		$sonic_options[] = array( 'type' => 'section_close' );

	$sonic_options[] = array( 'type' => 'close' );

	return $sonic_options;
}
add_filter( 'wolf_theme_options', 'sonic_set_font_options' );
