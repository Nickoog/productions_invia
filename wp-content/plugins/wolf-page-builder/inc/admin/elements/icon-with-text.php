<?php
/**
 * Icon with text
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Icon with Text
wpb_add_element( 
	array(
		'name' => esc_html__( 'Icon with Text', 'wolf-page-builder' ),
		'description' => esc_html__( '940+ icons with additional text', 'wolf-page-builder' ),
		'base' => 'wpb_icon_with_text',
		'icon' => 'wpb-icon wpb-icon-text',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'params' => array(

			array(
				'type' => 'icon',
				'label' => esc_html__( 'Icon', 'wolf-page-builder' ),
				'param_name' => 'icon',
				'choices' => $wpb_icons,
				'value' => 'fa-smile-o',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'wolf-page-builder' ),
				'param_name' => 'title',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Title Font Size', 'wolf-page-builder' ),
				'param_name' => 'title_font_size',
				'placeholder' => '18px',
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
			),

			array(
				'type' => 'textarea_html',
				'label' => esc_html__( 'Text', 'wolf-page-builder' ),
				'param_name' => 'text',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Type', 'wolf-page-builder' ),
				'param_name' => 'icon_type',
				'choices' => array(
					'normal' => esc_html__( 'Normal', 'wolf-page-builder' ),
					'circle' => esc_html__( 'Circle', 'wolf-page-builder' ),
					'square' => esc_html__( 'Square', 'wolf-page-builder' ),
					'ban' => esc_html__( 'Ban', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Position', 'wolf-page-builder' ),
				'param_name' => 'icon_position',
				'choices' => array(
					'top' => esc_html__( 'Top', 'wolf-page-builder' ),
					'left' => esc_html__( 'Left', 'wolf-page-builder' ),
					'left_from_title' => esc_html__( 'Left from Title', 'wolf-page-builder' ),
					'right' => esc_html__( 'Right', 'wolf-page-builder' ),
					'right_from_title' => esc_html__( 'Right from Title', 'wolf-page-builder' ),
				),
				//'dependency' => array( 'element' => 'box_type', 'value' => array( 'normal' ) ),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Size', 'wolf-page-builder' ),
				'param_name' => 'icon_size',
				'choices' => array(
					'fa-3x' =>esc_html__( 'Medium', 'wolf-page-builder' ),
					'fa-2x' =>esc_html__( 'Small', 'wolf-page-builder' ),
					'fa-4x' =>esc_html__( 'Large', 'wolf-page-builder' ),
					'fa-5x' =>esc_html__( 'Very Large', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Hover Transition', 'wolf-page-builder' ),
				'param_name' => 'hover_effect',
				'choices' => array(
					'none' => esc_html__( 'Normal', 'wolf-page-builder' ),
					'fill-in' => esc_html__( 'Fill in', 'wolf-page-builder' ),
				),
				'description' => esc_html__( 'Custom hover effects won\'t apply to icon with custom colors settings', 'wolf-page-builder' ),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Icon Animation', 'wolf-page-builder' ),
				'param_name' => 'icon_animation',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Icon Animation Delay', 'wolf-page-builder' ),
				'param_name' => 'icon_animation_delay',
				'dependency' => array( 'element' => 'icon_animation', 'value' => array( 'yes' ) ),
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