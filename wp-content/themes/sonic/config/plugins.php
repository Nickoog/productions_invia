<?php
/**
 * Sonic recommended plugins
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// delete_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice' );

require( WOLF_FRAMEWORK_DIR . '/inc/admin/class-tgm-plugin-activation.php' );

function wolf_theme_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'    => esc_html__( 'Wolf Page Builder', 'sonic' ),
			'slug'   => 'wolf-page-builder',
			'source'   => 'http://plugins.wolfthemes.com/wolf-page-builder/wolf-page-builder.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-page-builder/wolf-page-builder.zip',
		),

		array(
			'name'    => esc_html__( 'Wolf Albums', 'sonic' ),
			'slug'   => 'wolf-albums',
			'source'   => 'http://plugins.wolfthemes.com/wolf-albums/wolf-albums.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-albums/wolf-albums.zip',
		),

		array(
			'name'    => esc_html__( 'Wolf Videos', 'sonic' ),
			'slug'   => 'wolf-videos',
			'source'   => 'http://plugins.wolfthemes.com/wolf-videos/wolf-videos.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-videos/wolf-videos.zip',
		),

		array(
			'name'    => esc_html__( 'Wolf Discography', 'sonic' ),
			'slug'   => 'wolf-discography',
			'source'   => 'http://plugins.wolfthemes.com/wolf-discography/wolf-discography.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-discography/wolf-discography.zip',
		),

		array(
			'name'    => esc_html__( 'Wolf Tour Dates', 'sonic' ),
			'slug'   => 'wolf-tour-dates',
			'source'   => 'http://plugins.wolfthemes.com/wolf-tour-dates/wolf-tour-dates.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-tour-dates/wolf-tour-dates.zip',
		),

		array(
			'name'    =>esc_html__( 'Wolf Playlist', 'sonic' ),
			'slug'   => 'wolf-playlist-manager',
			'source'   => 'http://plugins.wolfthemes.com/wolf-playlist-manager/wolf-playlist-manager.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-playlist-manager/wolf-playlist-manager.zip',
		),
		
		array(
			'name'    => esc_html__( 'Wolf Twitter', 'sonic' ),
			'slug'   => 'wolf-twitter',
			'source'   => 'http://plugins.wolfthemes.com/wolf-twitter/wolf-twitter.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-twitter/wolf-twitter.zip',
		),

		array(
			'name'    => esc_html__( 'Wolf Instagram', 'sonic' ),
			'slug'   => 'wolf-gram',
			'source'   => 'http://plugins.wolfthemes.com/wolf-gram/wolf-gram.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-gram/wolf-gram.zip',
		),

		array(
			'name'    => esc_html__( 'Wolf Facebook Page Box', 'sonic' ),
			'slug'   => 'wolf-facebook-page-box',
			'source'   => 'http://plugins.wolfthemes.com/wolf-facebook-page-box/wolf-facebook-page-box.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-facebook-page-box/wolf-facebook-page-box.zip',
		),

		array(
			'name'    => esc_html__( 'Wolf Music Network', 'sonic' ),
			'slug'   => 'wolf-music-network',
			'source'   => 'http://plugins.wolfthemes.com/wolf-music-network/wolf-music-network.zip',
			'external_url' => 'http://plugins.wolfthemes.com/wolf-music-network/wolf-music-network.zip',
		),

		array(
			'name' 		=> esc_html__( 'One Click Demo Import', 'sonic' ),
			'slug' 		=> 'one-click-demo-import',
		),

		array(
			'name'    => esc_html__( 'Envato Market Items Updater', 'sonic' ),
			'slug'   => 'envato-market',
			'source'   => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'external_url' => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
		),

		array(
			'name' 		=> esc_html__( 'WooCommerce', 'sonic' ),
			'slug' 		=> 'woocommerce',
			'required' 	=> false,
		),

		array(
			'name' 		=> esc_html__( 'Contact Form 7', 'sonic' ),
			'slug' 		=> 'contact-form-7',
			'required' 	=> false,
		),
	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'sonic';

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'wolf_theme_register_required_plugins' );