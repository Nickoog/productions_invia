<?php
/**
 * Twitter plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Twitter' ) ) {

	// Twitter Shortcode
	wpb_add_element(
		array(
			'name' => esc_html__( 'Last Tweets', 'wolf-page-builder' ),
			'base' => 'wolf_tweet',
			'description' => esc_html__( 'Your last tweets', 'wolf-page-builder' ),
			'tags' => 'twitter',
			'category' => esc_html__( 'Social', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-twitter',
			'params' => array(

				array(
					'type' => 'text',
					'label' => esc_html__( 'Username', 'wolf-page-builder' ),
					'param_name' => 'username',
					'value' => wpb_get_twitter_usename(),
					'display' => true,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Type', 'wolf-page-builder' ),
					'param_name' => 'type',
					'choices' => array(
						'single' => esc_html__( 'single', 'wolf-page-builder' ),
						'list' => esc_html__( 'list', 'wolf-page-builder' ),
					),
					'display' => true,
				),

				array(
					'type' => 'int',
					'label' => esc_html__( 'Count', 'wolf-page-builder' ),
					'param_name' => 'count',
					'value' => 3,
					'dependency' => array( 'element' => 'type', 'value' => array( 'list' ) ),
					'display' => true,
				),
			)
		)
	);
}