<?php
/**
 * Item price
 *
 * @package WordPress
 * @subpackage Wolf Page Builder
 * @since Wolf Page Builder 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpb_animations;

// Restaurant menu item
wpb_add_element(
	array(
		'name' => esc_html__( 'Item Price', 'wolf-page-builder' ),
		'description' => esc_html__( 'Presentation of an item or service to sale', 'wolf-page-builder' ),
		'base' => 'wpb_item_price',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'fa fa-2x fa-money',
		'params' => array(

			array(
				'type' => 'hidden',
				'param_name' => 'image_size',
				'value' => 'wpb-2x2',
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'wolf-page-builder' ),
				'param_name' => 'title',
				'placeholder' => esc_html__( 'Our special', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Title Tag', 'wolf-page-builder' ),
				'param_name' => 'title_tag',
				'choices' => array(
					'h3',
					'h1',
					'h2',
					'h4',
					'h5',
					'h6',
					'span',
				),
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Price', 'wolf-page-builder' ),
				'param_name' => 'price',
				'placeholder' => '$10.75',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Subtitle', 'wolf-page-builder' ),
				'param_name' => 'content',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Layout', 'wolf-page-builder' ),
				'param_name' => 'layout',
				'choices' => array(
					'text' => esc_html__( 'Text only', 'wolf-page-builder' ),
					'small-image' => esc_html__( 'Small image', 'wolf-page-builder' ),
					'medium-image' => esc_html__( 'Medium image', 'wolf-page-builder' ),
					'big-image' => esc_html__( 'Big image', 'wolf-page-builder' ),
				),
				'display' => true,
			),
			
			array(
				'type' => 'image',
				'label' => esc_html__( 'Image', 'wolf-page-builder' ),
				'param_name' => 'image',
				'dependency' => array( 'element' => 'layout', 'value' => array( 'small-image', 'medium-image', 'big-image' ) ),
				'display' => true,
			),
		)
	)
);