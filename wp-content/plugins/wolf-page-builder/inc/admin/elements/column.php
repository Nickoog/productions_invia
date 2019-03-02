<?php
/**
 * Columns
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
		'name' => esc_html__( 'Column', 'wolf-page-builder' ),
		'base' => 'column',
		'icon' => 'wpb-icon wpb-section-columns',
		'params' => array(
			array(
				'type' => 'text',
				'label' => esc_html__( 'Anchor', 'wolf-page-builder' ),
				'param_name' => 'anchor',
				'placeholder' => 'my-column',
				'description' => esc_html__( 'An unique identifier for your column.', 'wolf-page-builder' ),
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Extra Class', 'wolf-page-builder' ),
				'param_name' => 'extra_class',
				'placeholder' => '.my-class',
				'description' => esc_html__( 'Optional additional CSS class to add to the column', 'wolf-page-builder' ),
			),

			array(
				'type' => 'inline_css',
				'label' => esc_html__( 'Inline Style', 'wolf-page-builder' ),
				'param_name' => 'inline_style',
				'placeholder' => 'margin-top:15px;',
				'description' => esc_html__( 'Additional inline CSS style', 'wolf-page-builder' ),
			),
		),
	)
);