<?php
/**
 * Sonic demo importer
 *
 * @package WordPress
 * @subpackage Sonic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Demo files
 *
 * @see http://proteusthemes.github.io/one-click-demo-import/
 */
function sonic_import_files() {

	$theme_slug = WOLF_THEME_SLUG;
	$domain_name = WOLF_UPDATE_URI;
	$root_url = $domain_name . '/' . $theme_slug . '/demos';

	return array(
		array(
			'import_file_name'           => esc_html__( 'Main Demo', 'sonic' ),
			'categories'                 => array( esc_html__( 'Standard', 'sonic' ) ),
			'import_file_url'            => $root_url . '/main/content.xml',
			'import_widget_file_url'     => $root_url . '/main/widgets.wie',
			'import_customizer_file_url' => $root_url . '/main/customizer.dat',
			'import_preview_image_url'   => $root_url . '/main/preview.jpg',
		),
		array(
			'import_file_name'           => esc_html__( 'One-Page', 'sonic' ),
			'categories'                 => array( esc_html__( 'One-Page', 'sonic' ) ),
			'import_file_url'            => $root_url . '/one-page/content.xml',
			'import_widget_file_url'     => $root_url . '/one-page/widgets.wie',
			'import_customizer_file_url' => $root_url . '/one-page/customizer.dat',
			'import_preview_image_url'   => $root_url . '/one-page/preview.jpg',
		),
		array(
			'import_file_name'           => esc_html__( 'Studio', 'sonic' ),
			'categories'                 => array( esc_html__( 'Standard', 'sonic' ) ),
			'import_file_url'            => $root_url . '/studio/content.xml',
			'import_widget_file_url'     => $root_url . '/studio/widgets.wie',
			'import_customizer_file_url' => $root_url . '/studio/customizer.dat',
			'import_preview_image_url'   => $root_url . '/studio/preview.jpg',
		),
		array(
			'import_file_name'           => esc_html__( 'Label', 'sonic' ),
			'categories'                 => array( esc_html__( 'Standard', 'sonic' ) ),
			'import_file_url'            => $root_url . '/label/content.xml',
			'import_widget_file_url'     => $root_url . '/label/widgets.wie',
			'import_customizer_file_url' => $root_url . '/label/customizer.dat',
			'import_preview_image_url'   => $root_url . '/label/preview.jpg',
		),
		array(
			'import_file_name'           => esc_html__( 'Classical', 'sonic' ),
			'categories'                 => array( esc_html__( 'Standard', 'sonic' ) ),
			'import_file_url'            => $root_url . '/classical/content.xml',
			'import_widget_file_url'     => $root_url . '/classical/widgets.wie',
			'import_customizer_file_url' => $root_url . '/classical/customizer.dat',
			'import_preview_image_url'   => $root_url . '/classical/preview.jpg',
		),
		array(
			'import_file_name'           => esc_html__( 'Metal', 'sonic' ),
			'categories'                 => array( esc_html__( 'Standard', 'sonic' ) ),
			'import_file_url'            => $root_url . '/metal/content.xml',
			'import_widget_file_url'     => $root_url . '/metal/widgets.wie',
			'import_customizer_file_url' => $root_url . '/metal/customizer.dat',
			'import_preview_image_url'   => $root_url . '/metal/preview.jpg',
		),
		array(
			'import_file_name'           => esc_html__( 'Hip Hop', 'sonic' ),
			'categories'                 => array( esc_html__( 'Standard', 'sonic' ) ),
			'import_file_url'            => $root_url . '/hip-hop/content.xml',
			'import_widget_file_url'     => $root_url . '/hip-hop/widgets.wie',
			'import_customizer_file_url' => $root_url . '/hip-hop/customizer.dat',
			'import_preview_image_url'   => $root_url . '/hip-hop/preview.jpg',
		),
		array(
			'import_file_name'           => esc_html__( 'Coming Soon', 'sonic' ),
			'categories'                 => array( esc_html__( 'Landing Page', 'sonic' ) ),
			'import_file_url'            => $root_url . '/coming-soon/content.xml',
			//'import_widget_file_url'     => $root_url . '/coming-soon/widgets.wie',
			'import_customizer_file_url' => $root_url . '/coming-soon/customizer.dat',
			'import_preview_image_url'   => $root_url . '/coming-soon/preview.jpg',
		),
		array(
			'import_file_name'           => esc_html__( 'Album Landing Page', 'sonic' ),
			'categories'                 => array( esc_html__( 'Landing Page', 'sonic' ) ),
			'import_file_url'            => $root_url . '/album-landing-page/content.xml',
			//'import_widget_file_url'     => $root_url . '/album-landing-page/widgets.wie',
			'import_customizer_file_url' => $root_url . '/album-landing-page/customizer.dat',
			'import_preview_image_url'   => $root_url . '/album-landing-page/preview.jpg',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'sonic_import_files' );

/**
 * Set menus after import
 */
function sonic_after_import_setup() {

	// Assign menus to their locations.
	sonic_set_menu_locations(
		array(
			'primary' => 'Main Menu',
			'tertiary' => 'Bottom Menu',
		)
	);
}
add_action( 'pt-ocdi/after_import', 'sonic_after_import_setup' );