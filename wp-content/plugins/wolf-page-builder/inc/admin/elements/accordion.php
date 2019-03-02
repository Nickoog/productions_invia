<?php
/**
 * Accordion
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Accordion container
wpb_add_element(
	array(
		'name' => esc_html__( 'Accordion', 'wolf-page-builder' ),
		'base' => 'wpb_accordion_container',
		'description' => esc_html__( 'Expanding and collapsing elements', 'wolf-page-builder' ),
		'has_child' => true,
		'child' => 'wpb_accordion',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-accordion',
		'params' => array(
			array(
				'type' => 'text',
				'label' => esc_html__( 'Anchor', 'wolf-page-builder' ),
				'param_name' => 'anchor',
				'placeholder' => 'my-element',
				'description' => esc_html__( 'An unique identifier for your element.', 'wolf-page-builder' ),
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Extra Class', 'wolf-page-builder' ),
				'param_name' => 'extra_class',
				'placeholder' => '.my-class',
				'description' => esc_html__( 'Optional additional CSS class to add to the element', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'inline_css',
				'label' => esc_html__( 'Inline Style', 'wolf-page-builder' ),
				'param_name' => 'inline_style',
				'placeholder' => 'margin-top:15px;',
				'description' => esc_html__( 'Additional inline CSS style', 'wolf-page-builder' ),
				'display' => true,
			),
		),
	)
);

// Accordion
wpb_add_element(
	array(
		'name' => esc_html__( 'Accordion Tab', 'wolf-page-builder' ),
		'base' => 'wpb_accordion',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'nested' => true,
		'parent' => 'wpb_accordion_container',
		'icon' => 'wpb-icon wpb-accordion',
		'params' => array(
			array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'wolf-page-builder' ),
				'param_name' => 'title',
				'value' => esc_html__( 'My Title', 'wolf-page-builder' ),
				'display' => true,
			),
			array(
				'type' => 'editor',
				'label' => esc_html__( 'Content', 'wolf-page-builder' ),
				'param_name' => 'editorcontent',
				'value' => wpb_encode_textarea_html( sprintf( esc_html__( 'This is a text block. Click on the edit button to change this text.  %s', 'wolf-page-builder' ), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.' ) ),
				'display' => true,
			),
		),
	)
);