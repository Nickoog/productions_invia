<?php
/**
 * Custom colors
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Globals
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

global $custom_colors;

$custom_colors = array(

	array(
		'type' => 'select',
		'label' => esc_html__( 'Custom', 'wolf-page-builder' ),
		'param_name' => 'custom_style',
		'choices' => array(
			'no' => esc_html__( 'No', 'wolf-page-builder' ),
			'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
		),
	),

	array(
		'type' => 'colorpicker',
		'label' => esc_html__( 'Title Color', 'wolf-page-builder' ),
		'param_name' => 'title_color',
		'dependency' => array( 'element' => 'custom_style', 'value' => array( 'yes' ) ),
	),

	array(
		'type' => 'colorpicker',
		'label' => esc_html__( 'Text Color', 'wolf-page-builder' ),
		'param_name' => 'text_color',
		'dependency' => array( 'element' => 'custom_style', 'value' => array( 'yes' ) ),
	),

	array(
		'type' => 'colorpicker',
		'label' => esc_html__( 'Background Color', 'wolf-page-builder' ),
		'param_name' => 'bg_color',
		'dependency' => array( 'element' => 'custom_style', 'value' => array( 'yes' ) ),
	),

	array(
		'type' => 'colorpicker',
		'label' => esc_html__( 'Icon Color', 'wolf-page-builder' ),
		'param_name' => 'icon_color',
		'dependency' => array( 'element' => 'custom_style', 'value' => array( 'yes' ) ),
	),

	array(
		'type' => 'colorpicker',
		'label' => esc_html__( 'Border Color', 'wolf-page-builder' ),
		'param_name' => 'border_color',
		'dependency' => array( 'element' => 'custom_style', 'value' => array( 'yes' ) ),
	),

	array(
		'type' => 'colorpicker',
		'label' => esc_html__( 'Background Color on Hover', 'wolf-page-builder' ),
		'param_name' => 'bg_color_hover',
		'dependency' => array( 'element' => 'custom_style', 'value' => array( 'yes' ) ),
	),

	array(
		'type' => 'colorpicker',
		'label' => esc_html__( 'Icon Color on Hover', 'wolf-page-builder' ),
		'param_name' => 'icon_color_hover',
		'dependency' => array( 'element' => 'custom_style', 'value' => array( 'yes' ) ),
	),

	array(
		'type' => 'colorpicker',
		'label' => esc_html__( 'Border Color on Hover', 'wolf-page-builder' ),
		'param_name' => 'border_color_hover',
		'dependency' => array( 'element' => 'custom_style', 'value' => array( 'yes' ) ),
	)
);