<?php
/**
 * Headline
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Fittext
wpb_add_element(
	array(
		'name' => esc_html__( 'Headline', 'wolf-page-builder' ),
		'description' => esc_html__( 'A big title with flexible font size', 'wolf-page-builder' ),
		'base' => 'wpb_headline',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-headline',
		'params' => array(

			array(
				'type' => 'text',
				'label' => esc_html__( 'Text', 'wolf-page-builder' ),
				'param_name' => 'text',
				'value' => esc_html__( 'My Headline', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Maximum Font Size', 'wolf-page-builder' ),
				'param_name' => 'max_font_size',
				'value' => 72,
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Text Color', 'wolf-page-builder' ),
				'param_name' => 'color',
			),


			array(
				'type' => 'text',
				'label' => esc_html__( 'Font Weight', 'wolf-page-builder' ),
				'param_name' => 'font_weight',
				'value' => 700,
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Text Transform', 'wolf-page-builder' ),
				'param_name' => 'text_transform',
				'choices' => array(
					'none' => esc_html__( 'none', 'wolf-page-builder' ),
					'uppercase' => esc_html__( 'uppercase', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'int',
				'label' => esc_html__( 'Letter Spacing', 'wolf-page-builder' ),
				'param_name' => 'letter_spacing',
				'display' => true,
			),

			array(
				'type' => 'font',
				'label' => esc_html__( 'Font', 'wolf-page-builder' ),
				'param_name' => 'font_family',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Tag', 'wolf-page-builder' ),
				'param_name' => 'title_tag',
				'choices' => array(
					'h2',
					'p',
					'h5',
					'h4',
					'h3',
					'h1',
				),
			),

			array(
				'type' => 'link',
				'label' => esc_html__( 'Link', 'wolf-page-builder' ),
				'param_name' => 'link',
				'placeholder' => 'http://',
				'display' => true,
			),
		)
	)
);