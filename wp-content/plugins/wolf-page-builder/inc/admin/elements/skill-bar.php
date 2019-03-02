<?php
/**
 * Skill bar
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Skills bar
wpb_add_element(
	array(
		'name' => esc_html__( 'Skill Bar', 'wolf-page-builder' ),
		'description' => esc_html__( 'An animation to show your competence', 'wolf-page-builder' ),
		'tags' => 'skills',
		'base' => 'wpb_skill_bar',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-skill-bar',
		'params' => array(
			array(
				'type' => 'text',
				'label' => esc_html__( 'Label', 'wolf-page-builder' ),
				'param_name' => 'label',
				'display' => true,
			),

			array(
				'type' => 'int',
				'label' => esc_html__( 'Value', 'wolf-page-builder' ),
				'param_name' => 'value',
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Bar Color', 'wolf-page-builder' ),
				'param_name' => 'color',
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Text Color', 'wolf-page-builder' ),
				'param_name' => 'text_color',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Tag', 'wolf-page-builder' ),
				'param_name' => 'title_tag',
				'choices' => array(
					'h5',
					'span',
					'h4',
					'h3',
					'h2',
					'h1',
				),
			),
		),
	)
);