<?php
/**
 * Images slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wpb_add_element(
	array(
		'name' => esc_html__( 'Image Slider', 'wolf-page-builder' ),
		'description' => esc_html__( 'An elegant image slideshow', 'wolf-page-builder' ),
		'base' => 'wpb_slider',
		'category' => esc_html__( 'Sliders', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-images-slider',
		'params' => array(
			array(
				'type' => 'multiple_images',
				'label' => esc_html__( 'Images', 'wolf-page-builder' ),
				'param_name' => 'ids',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Layout', 'wolf-page-builder' ),
				'param_name' => 'layout',
				'choices' => array(
					'default' => esc_html__( 'None', 'wolf-page-builder' ),
					'desktop' => esc_html__( 'Desktop Screen', 'wolf-page-builder' ),
					'laptop' => esc_html__( 'Laptop Screen', 'wolf-page-builder' ),
					'tablet' => esc_html__( 'Tablet Screen', 'wolf-page-builder' ),
					'mobile' => esc_html__( 'Mobile Screen', 'wolf-page-builder' ),
				),
				'description' => esc_html__( 'If you choose a custom layout your image may be cropped.', 'wolf-page-builder' ),
				'display' => true,
			),
		)
	)
);