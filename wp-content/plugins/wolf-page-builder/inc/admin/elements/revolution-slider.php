<?php
/**
 * Revolution slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'RevSlider' ) ) {
	// revslider
	wpb_add_element(
		array(
			'name' => esc_html__( 'Slider Revolution', 'wolf-page-builder' ),
			'description' => esc_html__( 'Display a Revolution slider', 'wolf-page-builder' ),
			'base' => 'wpb_revslider',
			'category' => esc_html__( 'Sliders', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-revslider',
			'params' => array(
				array(
					'type' => 'select',
					'label' => esc_html__( 'Choose a slider', 'wolf-page-builder' ),
					'param_name' => 'slider',
					'choices' => wpb_get_revsliders()
				),
				'display' => true,
			)
		)
	);
}