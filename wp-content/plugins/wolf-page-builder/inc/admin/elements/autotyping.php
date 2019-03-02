<?php
/**
 * Autotyping
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bigtext
wpb_add_element(
	array(
		'name' => esc_html__( 'Autotyping', 'wolf-page-builder' ),
		'description' => esc_html__( 'An animated typing text', 'wolf-page-builder' ),
		'base' => 'wpb_typed',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-autotyping',
		'params' => array(

			array(
				'type' => 'textarea',
				'label' => esc_html__( 'Animated Text', 'wolf-page-builder' ),
				'param_name' => 'text',
				'display' => true,
				'description' => esc_html__( 'Enter one sentence per line.' ),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Text Before', 'wolf-page-builder' ),
				'param_name' => 'text_before',
				'placeholder' => esc_html__( 'My sentence starts with this', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Text After', 'wolf-page-builder' ),
				'param_name' => 'text_after',
				'placeholder' => esc_html__( 'My sentence ends with this', 'wolf-page-builder' ),
				'display' => true,
			),

			// array(
			// 	'type' => 'colorpicker',
			// 	'label' => esc_html__( 'Text Color', 'wolf-page-builder' ),
			// 	'param_name' => 'color',
			// ),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Text Alignment', 'wolf-page-builder' ),
				'param_name' => 'text_alighment',
				'choices' => array(
					'left' => esc_html__( 'left', 'wolf-page-builder' ),
					'right' => esc_html__( 'right', 'wolf-page-builder' ),
					'center' => esc_html__( 'center', 'wolf-page-builder' ),
				),
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
				'label' => esc_html__( 'Text Style', 'wolf-page-builder' ),
				'param_name' => 'font_style',
				'choices' => array(
					'normal' => esc_html__( 'normal', 'wolf-page-builder' ),
					'italic' => esc_html__( 'italic', 'wolf-page-builder' ),

				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Text Transform', 'wolf-page-builder' ),
				'param_name' => 'text_transform',
				'choices' => array(
					'uppercase' => esc_html__( 'uppercase', 'wolf-page-builder' ),
					'none' => esc_html__( 'none', 'wolf-page-builder' ),

				),
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
				'param_name' => 'tag',
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
				'type' => 'select',
				'label' => esc_html__( 'Loop', 'wolf-page-builder' ),
				'param_name' => 'loop',
				'choices' => array(
					'true' => esc_html__( 'Yes', 'wolf-page-builder' ),
					'false' => esc_html__( 'No', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Speed in ms', 'wolf-page-builder' ),
				'param_name' => 'speed',
				'value' => 100,
				'display' => true,
			),
		)
	)
);