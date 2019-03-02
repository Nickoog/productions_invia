<?php
/**
 * Testimonials Slider
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
		'name' => esc_html__( 'Testimonials Slider', 'wolf-page-builder' ),
		'base' => 'wpb_testimonials',
		'description' => esc_html__( 'Show the feedbacks submitted by your happy customers', 'wolf-page-builder' ),
		'has_child' => true,
		'child' => 'wpb_testimonial',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-testimonials',
		'params' => array(), // params will be added in wpb-elements-additional-settings.php
	)
);

// Testimonial
wpb_add_element(
	array(
		'name' => esc_html__( 'Testimonial', 'wolf-page-builder' ),
		'base' => 'wpb_testimonial',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'nested' => true,
		'parent' => 'wpb_testimonials',
		'icon' => 'wpb-icon wpb-testimonials',
		'params' => array(
			array(
				'type' => 'textarea',
				'label' => esc_html__( 'Text', 'wolf-page-builder' ),
				'param_name' => 'text',
				'value' => wpb_encode_textarea_html( esc_html__( 'I am very happy with everything.', 'wolf-page-builder' ) ),
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Signature', 'wolf-page-builder' ),
				'param_name' => 'name',
				'value' => esc_html__( 'Someone', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'image',
				'label' => esc_html__( 'Avatar', 'wolf-page-builder' ),
				'param_name' => 'avatar',
			),

			array(
				'type' => 'url',
				'label' => esc_html__( 'Link', 'wolf-page-builder' ),
				'param_name' => 'link',
			),
		),
	)
);