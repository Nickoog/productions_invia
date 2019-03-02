<?php
/**
 * Toggle
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Toggle
wpb_add_element(
	array(
		'name' => esc_html__( 'Toggle', 'wolf-page-builder' ),
		'base' => 'wpb_toggle',
		'description' => esc_html__( 'Collapsible content', 'wolf-page-builder' ),
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-toggle',
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

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Open by default', 'wolf-page-builder' ),
				'param_name' => 'open',
			),
		),
	)
);