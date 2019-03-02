<?php
/**
 * Service table
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Service table
wpb_add_element(
	array(
		'name' => esc_html__( 'Service Table', 'wolf-page-builder' ),
		'description' => esc_html__( 'Show what your business is about', 'wolf-page-builder' ),
		'base' => 'wpb_services_table',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-service-table',
		'params' => array(

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Background Color', 'wolf-page-builder' ),
				'param_name' => 'bg_color',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Background Opacity', 'wolf-page-builder' ),
				'param_name' => 'bg_opacity',
				'placeholder' => 80,
				'description' => esc_html__( 'in percent', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Font Color', 'wolf-page-builder' ),
				'param_name' => 'font_color',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'wolf-page-builder' ),
				'param_name' => 'title',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Title Tag', 'wolf-page-builder' ),
				'param_name' => 'title_tag',
				'choices' => array(
					'h3',
					'span',
					'h1',
					'h2',
					'h4',
					'h5',
					'h6',
				),
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Title Color', 'wolf-page-builder' ),
				'param_name' => 'title_color',
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
			),

			array(
				'type' => 'icon',
				'label' => esc_html__( 'Icon', 'wolf-page-builder' ),
				'param_name' => 'icon',
				'choices' => $wpb_icons,
				'dependency' => array( 'element' => 'add_icon', 'value' => array( 'yes' ) ),
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Icon Color', 'wolf-page-builder' ),
				'param_name' => 'icon_color',
				'dependency' => array( 'element' => 'add_icon', 'value' => array( 'yes' ) ),
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