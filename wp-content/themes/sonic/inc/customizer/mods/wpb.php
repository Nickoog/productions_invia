<?php
/**
 * Sonic Page Builder
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_wpb_mods( $sonic_mods ) {

	if ( class_exists( 'Wolf_Page_Builder' ) ) {
		$sonic_mods['blog']['options']['newsletter'] = array(
			'id' =>'newsletter_form_single_blog_post',
			'label' => esc_html__( 'Newsletter Form', 'sonic' ),
			'type' => 'checkbox',
			'description' => esc_html__( 'Display a newsletter sign up form at the bottom of each blog post.', 'sonic' ),
		);

		$sonic_mods['footer']['options']['footer_socials_services'] = array(
			'id' =>'footer_socials_services',
			'label' => esc_html__( 'Footer Socials', 'sonic' ),
			'description' => sprintf( wp_kses(
				__( 'Enter the social networks names separated by a comma. e.g "twitter, facebook, instagram". ( see Wolf Page Builder options <a href="%s">social profiles tab</a>).', 'sonic' ),
					array( 'a' => array( 'href' => array(), ) )
				),
				esc_url( admin_url( 'admin.php?page=wpb-socials' ) )
			),
			'type' => 'text',
		);

		$sonic_mods['light_background'] = array(
			'id' =>'light_background',
			'description' => esc_html__( 'Here you can set a custom background that will be used for the "light" page builder sections.', 'sonic' ),
			'label' => esc_html__( 'Page Builder Light Background', 'sonic' ),
			'background' => true,
		);

		$sonic_mods['dark_background'] = array(
			'id' =>'dark_background',
			'description' => esc_html__( 'Here you can set a custom background that will be used for the "dark" page builder sections.', 'sonic' ),
			'label' => esc_html__( 'Page Builder Dark Background', 'sonic' ),
			'background' => true,
		);
	}

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_wpb_mods' );