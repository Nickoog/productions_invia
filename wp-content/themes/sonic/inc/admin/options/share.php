<?php
/**
 * Sonic share options
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_share_options( $sonic_options ) {

	$sonic_options[] = array(
		'type' => 'open', 
		'label' =>esc_html__( 'Social Sharing', 'sonic' )
	);

		$sonic_options[] = array(
			'label' => esc_html__( 'Display', 'sonic' ),
			'type' => 'section_open',
		);

		$sonic_options[] = array(
			'label' => esc_html__( 'Share Links', 'sonic' ),
			'desc' => esc_html__( 'Display "share" links below each single post ?', 'sonic' ),
			'id' => 'post_share_buttons',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => esc_html__( 'Generate Facebook & Google plus Meta', 'sonic' ),
			'desc' => wp_kses(
				sprintf( 
					__( 'Would you like to generate facebook, twitter and google plus metadata? Disable this function if you use a SEO plugin. In case <a href="%s" target="_blank">Yoast SEO</a> plugin is installed, it will be automatically disabled.', 'sonic' ),
					'https://wordpress.org/plugins/wordpress-seo/'
				),
				array(
					'br' => array(),
					'a' => array(
						'href' => array(),
						'target' => array(),
					),
				)
			),
			'id' => 'social_meta',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => esc_html__( 'Default Share Image (used for facebook and google plus)', 'sonic' ),
			'desc' => esc_html__( 'By default, the post featured image will be shown when you share a post/page on facebook. Here you can set the default image that will be displayed if no featured image is set', 'sonic' ),
			'id' => 'share_img',
			'type' => 'image',
		);

		$sonic_options[] = array(
			'label' => esc_html__( 'Share Text', 'sonic' ),
			'id' => 'share_text',
			'type' => 'text',
		);

		$sonic_options[] = array(
			'label' => 'facebook',
			'id' => 'share_facebook',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => 'twitter',
			'id' => 'share_twitter',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => 'pinterest',
			'id' => 'share_pinterest',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => 'google plus',
			'id' => 'share_google',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => 'tumblr',
			'id' => 'share_tumblr',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => 'stumbleupon',
			'id' => 'share_stumbleupon',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => 'linked in',
			'id' => 'share_linkedin',
			'type' => 'checkbox',
		);

		$sonic_options[] = array(
			'label' => 'email',
			'id' => 'share_mail',
			'type' => 'checkbox',
		);

		$sonic_options[] = array( 'type' => 'section_close' );


	$sonic_options[] = array( 'type' => 'close' );

	return $sonic_options;
}
add_filter( 'wolf_theme_options', 'sonic_set_share_options' );