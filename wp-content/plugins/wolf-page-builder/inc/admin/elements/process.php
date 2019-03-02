<?php
/**
 * Process
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Process container
wpb_add_element(
	array(
		'name' => esc_html__( 'Process', 'wolf-page-builder' ),
		'base' => 'wpb_process_container',
		'description' => esc_html__( 'Your step-by-step way of working', 'wolf-page-builder' ),
		'has_child' => true,
		'child' => 'wpb_process_item',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-process',
		'help' => sprintf(
			esc_html__( 'It is recommended to insert %1$d to %2$d process elements and use the standard width for the parent row.', 'wolf-page-builder' ),
			2,
			5
		),
		'params' => array(
		
			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Margin Top', 'wolf-page-builder' ),
				'param_name' => 'margin_top',
				'placeholder' => '20px',
			),

			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Margin Bottom', 'wolf-page-builder' ),
				'param_name' => 'margin_bottom',
				'placeholder' => '20px',
			),
		),
	)
);

// process item
wpb_add_element(
	array(
		'name' => esc_html__( 'Process Item', 'wolf-page-builder' ),
		'base' => 'wpb_process_item',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'nested' => true,
		'parent' => 'wpb_process_container',
		'icon' => 'wpb-icon wpb-process',
		'params' => array(

			array(
				'type' => 'icon',
				'label' => esc_html__( 'Icon', 'wolf-page-builder' ),
				'param_name' => 'icon',
				'choices' => $wpb_icons,
				'value' => 'line-icon-bulb',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'wolf-page-builder' ),
				'param_name' => 'title',
				'display' => true,
				'value' => esc_html__( 'My title', 'wolf-page-builder' ),
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
				'type' => 'textarea',
				'label' => esc_html__( 'Text', 'wolf-page-builder' ),
				'param_name' => 'text',
				'placeholder' => esc_html__( 'Optional description text', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'link',
				'label' => esc_html__( 'Link', 'wolf-page-builder' ),
				'param_name' => 'link',
				'placeholder' => 'http://',
			),
		),
	)
);