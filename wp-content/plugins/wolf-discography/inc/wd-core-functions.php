<?php
/**
 * Wolf Discography core functions
 *
 * General core functions available on admin and frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfDiscography/Core
 * @version 1.3.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add image sizes
 *
 * These size will be ued for galleries and sliders
 *
 * @since 1.2.6
 */
function wd_add_image_sizes() {

	// add discography image sizes
	add_image_size( 'CD', 400, 400, true );
	add_image_size( 'DVD', 400, 570, true );
}
add_action( 'init', 'wd_add_image_sizes' );

/**
 * wolf_discography page IDs
 *
 * retrieve page ids - used for the main discography page
 *
 * returns -1 if no page is found
 *
 * @param string $page
 * @return int
 */
function wolf_discography_get_page_id() {

	$page_id = -1;

	if ( -1 != get_option( '_wolf_discography_page_id' ) && get_option( '_wolf_discography_page_id' ) ) {

		$page_id = get_option( '_wolf_discography_page_id' );

	}

	if ( -1 != $page_id ) {
		$page_id = apply_filters( 'wpml_object_id', absint( $page_id ), 'page', false ); // filter for WPML
	}

	return $page_id;
}

/**
 * wolf_discography page link
 *
 * retrieve discography page permalink
 *
 *
 * @param string $page
 * @return string
 */
function wolf_discography_get_page_link() {

	$page_id = wolf_discography_get_page_id();

	if ( $page_id != -1 ) {
		return get_permalink( $page_id );
	}
}

/**
 * Get template part (for templates like the release-loop).
 *
 * @param mixed $slug
 * @param string $name (default: '')
 */
function wolf_discography_get_template_part( $slug, $name = '' ) {
	$template = '';

	$wolf_discography = WD();

	// Look in yourtheme/slug-name.php and yourtheme/wolf_discography/slug-name.php
	if ( $name )
		$template = locate_template( array( "{$slug}-{$name}.php", "{$wolf_discography->template_url}{$slug}-{$name}.php" ) );

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( $wolf_discography->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
		$template = $wolf_discography->plugin_path() . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wolf_discography/slug.php
	if ( ! $template )
		$template = locate_template( array( "{$slug}.php", "{$wolf_discography->template_url}{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
}


/**
 * Get other templates (e.g. ticket attributes) passing attributes and including the file.
 *
 * @param mixed $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 */
function wolf_discography_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

	if ( $args && is_array($args) )
		extract( $args );

	$located = wolf_discography_locate_template( $template_name, $template_path, $default_path );

	do_action( 'wolf_discography_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'wolf_discography_after_template_part', $template_name, $template_path, $located, $args );
}


/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @param mixed $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function wolf_discography_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	if ( ! $template_path ) $template_path = WD()->template_url;
	if ( ! $default_path ) $default_path = WD()->plugin_path() . '/templates/';

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters( 'wolf_discography_locate_template', $template, $template_name, $template_path );
}

/**
 * Widget function
 *
 * Displays the show list in the widget
 *
 * @param int $count, string $url, bool $link
 * @return string
 */
function wolf_get_release_option( $value, $default = null ) {

	$wolf_releases_settings = get_option( 'wolf_release_settings' );
	
	if ( isset( $wolf_releases_settings[ $value ] ) && '' != $wolf_releases_settings[ $value ] ) {
		
		return $wolf_releases_settings[ $value ];
	
	} elseif( $default ) {

		return $default;
	}
}