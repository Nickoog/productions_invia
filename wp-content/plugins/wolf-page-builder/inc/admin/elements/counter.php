<?php
/**
 * Counter
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpb_icons;

// Counter
wpb_add_element(
	array(
		'name' => esc_html__( 'Counter', 'wolf-page-builder' ),
		'description' => esc_html__( 'Animated numerical data', 'wolf-page-builder' ),
		'base' => 'wpb_counter',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-counter',
		'params' => array(

			array(
				'type' => 'text',
				'label' => esc_html__( 'Number', 'wolf-page-builder' ),
				'param_name' => 'number',
				'description' => esc_html__( 'It can be a shortcode that generate a number in this case paste your shortcode without the []', 'wolf-page-builder' ),
				'display' => true,
			),

			// array(
			// 	'type' => 'int',
			// 	'label' => esc_html__( 'Duration (in ms)', 'wolf-page-builder' ),
			// 	'param_name' => 'duration',
			// 	'placeholder' => 1000,
			// 	'display' => true,
			// ),

			// array(
			// 	'type' => 'int',
			// 	'label' => esc_html__( 'Delay (in ms)', 'wolf-page-builder' ),
			// 	'param_name' => 'delay',
			// 	'placeholder' => 10,
			// 	'display' => true,
			// ),

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Is your number generated by a shortcode?', 'wolf-page-builder' ),
				'param_name' => 'shortcode',
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Text', 'wolf-page-builder' ),
				'param_name' => 'text',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Add Icon', 'wolf-page-builder' ),
				'param_name' => 'add_icon',
				'choices' => array(
					'no' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'icon',
				'label' => esc_html__( 'Icon', 'wolf-page-builder' ),
				'param_name' => 'icon',
				'choices' => $wpb_icons,
				'dependency' => array( 'element' => 'add_icon', 'value' => array( 'yes' ) ),
				'display' => true,
			),
		)
	)
);