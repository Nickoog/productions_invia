<?php
/**
 * Tweet this button
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// FB like
wpb_add_element(
	array(
		'name' => esc_html__( 'Tweet This', 'wolf-page-builder' ),
		'description' => esc_html__( 'Tweet this button', 'wolf-page-builder' ),
		'tags' => 'twitter',
		'base' => 'wpb_tweet_this',
		'category' => esc_html__( 'Social', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-twitter',
		'params' => array(
			array(
				'type' => 'select',
				'label' => esc_html__( 'Button Type', 'wolf-page-builder' ),
				'param_name' => 'type',
				'choices' => array(
					'horizontal' => esc_html__( 'Horizontal', 'wolf-page-builder' ),
					'vertical' => esc_html__( 'Horizontal with count', 'wolf-page-builder' ),
					'none' => esc_html__( 'Vertical with count', 'wolf-page-builder' ),
				),
				'display' => true,
			),
		)
	)
);