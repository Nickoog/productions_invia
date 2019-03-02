<?php
/**
 * Theme configuration file
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

/**
 * Set color scheme
 *
 * Add csutom color scheme
 *
 * @param array $color_scheme
 * @param array $color_scheme
 */
function sonic_set_color_schemes( $color_scheme ) {

	$color_scheme['light'] = array(
		'label'  => esc_html__( 'Light', 'sonic' ),
		'colors' => array(
			'#ffffff', // bg
			'#ffffff', // page bg
			'#d16f4e', // accent
			'#666', // main text
			'#777777', // second text
			'#333333', // strong text
			'#333333', // submenu
			'#ffffff', // content frame
			'#d16f4e', // shop tabs background
			'#ffffff', // shop tabs text
		)
	);

	$color_scheme['dark'] = array(
		'label'  => esc_html__( 'Dark', 'sonic' ),
		'colors' => array(
			'#262626', // bg
			'#1a1a1a', // page bg
			'#d16f4e', // accent
			'#e5e5e5', // main text
			'#c1c1c1', // second text
			'#FFFFFF', // strong text
			'#282828', // submenu
			'#0d0d0d', // content frame
			'#d16f4e', // shop tabs background
			'#ffffff', // shop tabs text
		)
	);

	return $color_scheme;
}
add_filter( 'sonic_color_schemes', 'sonic_set_color_schemes' );

/**
 * Add additional theme support
 */
function sonic_additional_theme_support() {

	/**
	 * Enable WooCommerce support
	 */
	add_theme_support( 'woocommerce' );

	/**
	 * Add theme support for Wolf Playlist player bar as the theme handles AJAX navigation
	 */
	add_theme_support( 'wpm_bar' );
}
add_action( 'after_setup_theme', 'sonic_additional_theme_support' );

/**
 * Add post display options
 *
 * @param array $options
 * @param array $options
 */
function sonic_add_blog_display_options( $options ) {

	$new_options = array(
		'standard' => esc_html__( 'Standard', 'sonic' ),
		'grid' => esc_html__( 'Square grid', 'sonic' ),
		'grid3' => esc_html__( 'Portrait grid', 'sonic' ),
		'column' => esc_html__( 'Columns', 'sonic' ),
		'masonry' => esc_html__( 'Masonry', 'sonic' ),
		'metro' => esc_html__( 'Metro', 'sonic' ),
		'medium-image' => esc_html__( 'Medium image', 'sonic' ),
		'photo' => esc_html__( 'Photo', 'sonic' ),
	);

	$options = array_merge( $new_options, $options );
	
	return $options;
}
add_filter( 'sonic_blog_display_options', 'sonic_add_blog_display_options' );

/**
 * Add Music Network Customizer settings
 *
 * @param array $options
 * @return array $options
 */
function sonic_add_music_network_customizer_options( $options ) {
	
	if ( class_exists( 'Wolf_Music_Network' ) ) {
		$options['music_network_bg'] = array(
			'id' =>'music_network_bg',
			'label' => esc_html__( 'Music Network Bar Background', 'sonic' ),
			'background' => true,
		);
	}
	return $options;
}
add_filter( 'sonic_customizer_options', 'sonic_add_music_network_customizer_options', 20 );

/**
 * Add shop product display options
 *
 * @param array $options
 * @param array $options
 */
function sonic_add_shop_display_options( $options ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$options['loren'] = esc_html__( 'Loren', 'sonic' );
		$options['agathe'] = esc_html__( 'Agathe', 'sonic' );
	}

	return $options;
}
add_filter( 'sonic_shop_display_options', 'sonic_add_shop_display_options' );

/**
 * Inject theme button style params
 *
 * @param array $button_types
 * @return array $button_types
 */
function sonic_add_theme_button_type( $button_types ) {
	
	$additional_button_types = array();
	$additional_button_types['wolf-wpb-button'] = esc_html__( 'Theme Accent Color', 'sonic' );

	return $additional_button_types + $button_types;
}
add_filter( 'wpb_button_types', 'sonic_add_theme_button_type' );