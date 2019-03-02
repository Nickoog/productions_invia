<?php
/**
 * Pricing tables
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Testimonials container
wpb_add_element(
	array(
		'name' => esc_html__( 'Pricing Tables', 'wolf-page-builder' ),
		'base' => 'wpb_pricing_tables_container',
		'description' => esc_html__( 'Help users pick the most appropriate plan for them', 'wolf-page-builder' ),
		'has_child' => true,
		'child' => 'wpb_pricing_table',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-pricing-tables',
		'params' => array(

			array(
				'type' => 'select',
				'label' => esc_html__( 'Columns', 'wolf-page-builder' ),
				'param_name' => 'columns',
				'choices' => array(
					1,2,3,4,
				),
			),
		),
	)
);

// Testimonial
wpb_add_element(
	array(
		'name' => esc_html__( 'Pricing Table', 'wolf-page-builder' ),
		'base' => 'wpb_pricing_table',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'nested' => true,
		'parent' => 'wpb_pricing_tables_container',
		'icon' => 'wpb-icon wpb-pricing-tables',
		'params' => array(
			array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'wolf-page-builder' ),
				'param_name' => 'title',
				'value' => esc_html__( 'Basic Plan', 'wolf-page-builder' ),
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
				),
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Tagline', 'wolf-page-builder' ),
				'param_name' => 'tagline',
				'placeholder' => esc_html__( 'An optional tagline', 'wolf-page-builder' ),
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Price', 'wolf-page-builder' ),
				'param_name' => 'price',
				'placeholder' => 15,
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Currency', 'wolf-page-builder' ),
				'param_name' => 'currency',
				'display' => true,
				'description' => esc_html__( 'e.g: $ or €', 'wolf-page-builder' ),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Display Currency', 'wolf-page-builder' ),
				'param_name' => 'display_currency',
				'choices' => array(
					'before' => esc_html__( 'before', 'wolf-page-builder' ),
					'after' => esc_html__( 'after', 'wolf-page-builder' )
				),
			),
			array(
				'type' => 'select',
				'label' => esc_html__( 'Offer', 'wolf-page-builder' ),
				'param_name' => 'offer',
				'choices' => array(
					'no' => esc_html__( 'no', 'wolf-page-builder' ),
					'yes' => esc_html__( 'yes', 'wolf-page-builder' ),
				),
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Offer Price', 'wolf-page-builder' ),
				'param_name' => 'offer_price',
				'dependency' => array( 'element' => 'offer', 'value' => array( 'yes' ) ),
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Price Period', 'wolf-page-builder' ),
				'param_name' => 'price_period',
				'description' => esc_html__( 'e.g "monthly" or "per month"', 'wolf-page-builder' ),
				'display' => true,
			),
			array(
				'type' => 'select',
				'label' => esc_html__( 'Show Button', 'wolf-page-builder' ),
				'param_name' => 'show_button',
				'choices' => array(
					'yes' => esc_html__( 'yes', 'wolf-page-builder' ),
					'' => esc_html__( 'no', 'wolf-page-builder' )
				),
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Button Text', 'wolf-page-builder' ),
				'param_name' => 'button_text',
				'placeholder' => esc_html__( 'Buy now', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'show_button', 'value' => array( 'yes' ) ),
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Button Link', 'wolf-page-builder' ),
				'param_name' => 'link',
				'placeholder' => 'http://',
				'dependency' => array( 'element' => 'show_button', 'value' => array( 'yes' ) ),
			),
			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Open button link in a new window', 'wolf-page-builder' ),
				'param_name' => 'target',
				'dependency' => array( 'element' => 'show_button', 'value' => array( 'yes' ) ),
			),
			array(
				'type' => 'select',
				'label' => esc_html__( 'Featured', 'wolf-page-builder' ),
				'param_name' => 'featured',
				'choices' => array(
					'no' => esc_html__( 'no', 'wolf-page-builder' ),
					'yes' => esc_html__( 'yes', 'wolf-page-builder' ),
				),
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Featured Text', 'wolf-page-builder' ),
				'param_name' => 'featured_text',
				'placeholder' => esc_html__( 'Best Choice', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'featured', 'value' => array( 'yes' ) ),
				'display' => true,
			),

			array(
				'type' => 'textarea',
				'label' => esc_html__( 'Services', 'wolf-page-builder' ),
				'param_name' => 'services',
				'description' => esc_html__( 'Enter one service per line.' ),
				'display' => true,
			),
		),
	)
);