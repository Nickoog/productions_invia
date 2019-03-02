<?php
/**
 * Separator
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// empty space
wpb_add_element(
	array(
		'name' => esc_html__( 'Separator', 'wolf-page-builder' ),
		'description' => esc_html__( 'Add a line to organize your content', 'wolf-page-builder' ),
		'base' => 'wpb_separator',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-separator',
		'params' => array(

			array(
				'type' => 'text',
				'label' => esc_html__( 'Width', 'wolf-page-builder' ),
				'param_name' => 'width',
				'value' => '100%',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Height', 'wolf-page-builder' ),
				'param_name' => 'height',
				'placeholder' => '1px',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Aligment', 'wolf-page-builder' ),
				'param_name' => 'alignment',
				'choices' => array(
					'center' => esc_html__( 'Center', 'wolf-page-builder' ),
					'left' => esc_html__( 'Left', 'wolf-page-builder' ),
					'right' => esc_html__( 'Right', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Color', 'wolf-page-builder' ),
				'param_name' => 'color',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Opacity', 'wolf-page-builder' ),
				'param_name' => 'opacity',
				'description' => esc_html__( 'in percent', 'wolf-page-builder' ),
				'placeholder' => 100,
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Margin Top', 'wolf-page-builder' ),
				'param_name' => 'margin_top',
				'placeholder' => '30px',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Marign Bottom', 'wolf-page-builder' ),
				'param_name' => 'margin_bottom',
				'placeholder' => '30px',
				'display' => true,
			),
		)
	)
);