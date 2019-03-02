<?php
/**
 * Facebook like button
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// FB like
wpb_add_element(
	array(
		'name' => esc_html__( 'Facebook Like', 'wolf-page-builder' ),
		'description' => esc_html__( 'Facebook "Like" button', 'wolf-page-builder' ),
		'base' => 'wpb_facebook_like',
		'category' => esc_html__( 'Social', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-facebook',
		'params' => array(
			array(
				'type' => 'select',
				'label' => esc_html__( 'Button Type', 'wolf-page-builder' ),
				'param_name' => 'type',
				'choices' => array(
					'standard' => esc_html__( 'Horizontal', 'wolf-page-builder' ),
					'button_count' => esc_html__( 'Horizontal with count', 'wolf-page-builder' ),
					'box_count' => esc_html__( 'Vertical with count', 'wolf-page-builder' ),
				),
				'display' => true,
			),
		)
	)
);