<?php
/**
 * Button
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpb_icons;

$button_types = apply_filters( 'wpb_button_types', array(
	'wpb-flat' => esc_html__( 'Flat', 'wolf-page-builder' ),
	'wpb-outline' => esc_html__( 'Border', 'wolf-page-builder' ),
	'wpb-outline-inverted' => esc_html__( 'Border Hover', 'wolf-page-builder' ),
	'wpb-fill-in-up' => esc_html__( 'Fill-in-up', 'wolf-page-builder' ),
) );

// Buttons container
wpb_add_element(
	array(
		'name' => esc_html__( 'Button(s) Container', 'wolf-page-builder' ),
		'base' => 'wpb_button_container',
		'description' => esc_html__( 'A simple button or a set of buttons', 'wolf-page-builder' ),
		'has_child' => true,
		'child' => 'wpb_button',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-button',
		'params' => array(
			array(
				'type' => 'select',
				'label' => esc_html__( 'Alignment', 'wolf-page-builder' ),
				'param_name' => 'alignment',
				'choices' => array(
					'center' => esc_html__( 'center', 'wolf-page-builder' ),
					'left' => esc_html__( 'left', 'wolf-page-builder' ),
					'right' => esc_html__( 'right', 'wolf-page-builder' ),
				),
			),

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

$button_params = array();

$button_params[] = array(
	'type' => 'text',
	'label' => esc_html__( 'Button Text', 'wolf-page-builder' ),
	'param_name' => 'text',
	'value' => esc_html__( 'My Button', 'wolf-page-builder' ),
	'display' => true,
);

$button_params[] = array(
	'type' => 'text',
	'label' => esc_html__( 'Button Tagline', 'wolf-page-builder' ),
	'param_name' => 'tagline',
	'placeholder' => esc_html__( 'Optional additional text', 'wolf-page-builder' ),
	'display' => true,
);

// if ( function_exists( 'wolf_get_theme_mod' ) ) {
// 	$button_params[] =  array(
// 		'type' => 'checkbox',
// 		'label' => esc_html__( 'Use theme button style (deprecated: use "Theme Style" button type)', 'wolf-page-builder' ),
// 		'param_name' => 'theme_button_style',
// 		'description' => esc_html__( 'Check this option to use the theme\'s buttons style. It will overwrite the styling settings below.', 'wolf-page-builder' ),
// 	);
// }

$button_params[] = array(
	'type' => 'select',
	'label' => esc_html__( 'Size', 'wolf-page-builder' ),
	'param_name' => 'size',
	'choices' => array(
		'medium' => esc_html__( 'Medium', 'wolf-page-builder' ),
		'small' => esc_html__( 'Small', 'wolf-page-builder' ),
		'large' => esc_html__( 'Large', 'wolf-page-builder' ),
		'very-large' => esc_html__( 'Very large', 'wolf-page-builder' ),
	),
	'display' => true,
);

$button_params[] = array(
	'type' => 'select',
	'label' => esc_html__( 'Type', 'wolf-page-builder' ),
	'param_name' => 'type',
	'choices' => $button_types,
);

$button_params[] = array(
	'type' => 'select',
	'label' => esc_html__( 'Shape', 'wolf-page-builder' ),
	'param_name' => 'shape',
	'choices' => array(
		'default' => esc_html__( 'Default', 'wolf-page-builder' ),
		'square' => esc_html__( 'Square', 'wolf-page-builder' ),
		'round' => esc_html__( 'Round', 'wolf-page-builder' ),
	),
	'value' => apply_filters( 'wpb_default_button_shape', 'default' ),
);

$button_params[] =  array(
	'type' => 'colorpicker',
	'label' => esc_html__( 'Color', 'wolf-page-builder' ),
	'param_name' => 'color',
	'dependency' => array( 'element' => 'type', 'value' => array( 'wpb-flat', 'wpb-outline', 'wpb-outline-inverted' ) ),
);

$button_params[] = array(
	'type' => 'colorpicker',
	'label' => esc_html__( 'Color on Hover', 'wolf-page-builder' ),
	'param_name' => 'color_hover',
	'dependency' => array( 'element' => 'type', 'value' => array( 'wpb-flat', 'wpb-outline', 'wpb-outline-inverted' ) ),
);

$button_params[] = array(
	'type' => 'link',
	'label' => esc_html__( 'Link', 'wolf-page-builder' ),
	'param_name' => 'link',
	'placeholder' => 'http://',
	'display' => true,
);

$button_params[] = array(
	'type' => 'checkbox',
	'label' => esc_html__( 'Smooth scroll', 'wolf-page-builder' ),
	'param_name' => 'scroll_to_anchor',
	'description' => esc_html__( 'Check this option if your link is an anchor (eg: #my-section)', 'wolf-page-builder' ),
	'display' => true,
);

$button_params[] = array(
	'type' => 'select',
	'label' => esc_html__( 'Add Icon', 'wolf-page-builder' ),
	'param_name' => 'add_icon',
	'choices' => array(
		'' => esc_html__( 'No', 'wolf-page-builder' ),
		'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
	),
	'display' => true,
);

$button_params[] = array(
	'type' => 'icon',
	'label' => esc_html__( 'Icon', 'wolf-page-builder' ),
	'param_name' => 'icon',
	'choices' => $wpb_icons,
	'display' => true,
	'dependency' => array( 'element' => 'add_icon', 'value' => array( 'yes' ) ),
);

$button_params[] = array(
	'type' => 'select',
	'label' => esc_html__( 'Icon Position', 'wolf-page-builder' ),
	'param_name' => 'icon_position',
	'choices' => array(
		'before' => esc_html__( 'Before', 'wolf-page-builder' ),
		'after' => esc_html__( 'After', 'wolf-page-builder' ),
	),
	'dependency' => array( 'element' => 'add_icon', 'value' => array( 'yes' ) ),
	'display' => true,
);

// Call to action
wpb_add_element(
	array(
		'name' => esc_html__( 'Call to Action', 'wolf-page-builder' ),
		'base' => 'wpb_call_to_action',
		'icon' => 'wpb-icon wpb-call-to-action',
		'description' => esc_html__( 'Provoke an immediate response', 'wolf-page-builder' ),
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'params' => array(
			array(
				'type' => 'text',
				'label' => esc_html__( 'Text', 'wolf-page-builder' ),
				'param_name' => 'main_text',
				'value' => esc_html__( 'My call to action text', 'wolf-page-builder' ),
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Tagline', 'wolf-page-builder' ),
				'param_name' => 'main_tagline',
				'placeholder' => esc_html__( 'Optional tagline', 'wolf-page-builder' ),
				'display' => true,
			),
		),
	)
);

// Button
wpb_add_element(
	array(
		'name' => esc_html__( 'Button', 'wolf-page-builder' ),
		'base' => 'wpb_button',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'nested' => true,
		'parent' => 'wpb_button_container',
		'icon' => 'wpb-icon wpb-button',
		'params' => array(

			array(
				'type' => 'select',
				'label' => esc_html__( 'Full Width', 'wolf-page-builder' ),
				'param_name' => 'full_width',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
				'display' => true,
			),
		),
	)
);

wpb_inject_param( 'wpb_button', $button_params );
wpb_inject_param( 'wpb_call_to_action', $button_params );