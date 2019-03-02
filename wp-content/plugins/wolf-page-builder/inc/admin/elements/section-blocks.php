<?php
/**
 * Section blocks
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
		'name' => esc_html__( 'Section with Blocks', 'wolf-page-builder' ),
		'base' => 'section_blocks',
		'icon' => 'wpb-icon wpb-section-blocks',
		'params' => array(
			
			array(
				'type' => 'hidden',
				'param_name' => 'section_type',
				'value' => 'blocks',
			),

			array(
				'type' => 'hidden',
				'param_name' => 'layout',
				'value' => '2-cols',
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Margin', 'wolf-page-builder' ),
				'param_name' => 'margin',
				'placeholder' => '0',
				'description' => esc_html__( 'Empty space around the content', 'wolf-page-builder' ),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Section Visibility', 'wolf-page-builder' ),
				'param_name' => 'hide_class',
				'choices' => array(
					'' => esc_html__( 'Always visible', 'wolf-page-builder' ),
					'wpb-hide-tablet' => esc_html__( 'Hide on tablet and mobile', 'wolf-page-builder' ),
					'wpb-hide-mobile' => esc_html__( 'Hide on mobile', 'wolf-page-builder' ),
					'wpb-show-tablet' => esc_html__( 'Show on tablet and mobile only', 'wolf-page-builder' ),
					'wpb-show-mobile' => esc_html__( 'Show on mobile only', 'wolf-page-builder' ),
					'wpb-hide' => esc_html__( 'Always hidden', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'slug',
				'label' => esc_html__( 'Anchor', 'wolf-page-builder' ),
				'param_name' => 'anchor',
				'placeholder' => 'my-section',
				'description' => esc_html__( 'An unique identifier for your section.', 'wolf-page-builder' ),
			),

			array(
				'type' => 'slug',
				'label' => esc_html__( 'Extra Class', 'wolf-page-builder' ),
				'param_name' => 'extra_class',
				'placeholder' => '.my-class',
				'description' => esc_html__( 'Optional additional CSS class to add to the section', 'wolf-page-builder' ),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Inline Style', 'wolf-page-builder' ),
				'param_name' => 'inline_style',
				'placeholder' => 'margin-top:15px;',
				'description' => esc_html__( 'Additional inline CSS style', 'wolf-page-builder' ),
			),
		)
	)
);