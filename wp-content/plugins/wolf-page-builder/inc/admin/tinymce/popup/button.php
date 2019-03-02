<?php
/**
 * Button dialog box
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */
$button_color_array = array(
	'accent-color'  => esc_html__( 'theme color', 'wolf-page-builder' ),
	'accent-color-bnw'  => esc_html__( 'theme color black/white on hover', 'wolf-page-builder' ),
	'border-button'  => esc_html__( 'black/white', 'wolf-page-builder' ),
	'border-button-accent-hover'  => esc_html__( 'black/white theme color on hover', 'wolf-page-builder' ),
);

$button_type_array =  array(
	'square' => esc_html__( 'Square', 'wolf-page-builder' ),
	'round' => esc_html__( 'Round', 'wolf-page-builder' ),
);

$button_size_array =  array(
	'medium' => esc_html__( 'Medium', 'wolf-page-builder' ),
	'small' => esc_html__( 'Small', 'wolf-page-builder' ),
	'large' => esc_html__( 'Large', 'wolf-page-builder' ),
);

global $wpb_icons;

$title = esc_html__( 'Button', 'wolf-page-builder' );
$params = array(

	array(
		'id' => 'text',
		'label' => esc_html__( 'Text', 'wolf-page-builder' ),
		'value' => esc_html__( 'Button', 'wolf-page-builder' ),
	),

	array(
		'id' => 'url',
		'label' => esc_html__( 'Link', 'wolf-page-builder' ),
		'placeholder' => esc_html__( 'http://', 'wolf-page-builder' ),
	),

	array(
		'id' => 'tagline',
		'label' => esc_html__( 'Tagline', 'wolf-page-builder' ),
	),

	// array(
	// 	'id' => 'color',
	// 	'label' => esc_html__( 'Color', 'wolf-page-builder' ),
	// 	'type' => 'select',
	// 	'options' => $button_color_array,
	// ),

	array(
		'id' => 'size',
		'label' => esc_html__( 'Size', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => $button_size_array,
	),

	array(
		'id' => 'type',
		'label' => esc_html__( 'Type', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => $button_type_array,
	),

	array(
		'id' => 'target',
		'label' => esc_html__( 'Open link in a new tab', 'wolf-page-builder' ),
		'type' => 'checkbox',
		'value' => '_blank',
	),

	array(
		'id' => 'scroll_to_anchor',
		'label' => esc_html__( 'Scroll to anchor', 'wolf-page-builder' ),
		'type' => 'checkbox',
		'value' => true,
	),

	array(
		'id' => 'add_button_icon',
		'label' => esc_html__( 'Add Icon', 'wolf-page-builder' ),
		'type' => 'checkbox',
		'value' => 'yes',
	),

	array(
		'id' => 'icon',
		'label' => esc_html__( 'Icon', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => $wpb_icons,
	),

	array(
		'id' => 'icon_position',
		'label' => esc_html__( 'Icon position', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => array(
			'after' => esc_html__( 'after', 'wolf-page-builder' ),
			'before' => esc_html__( 'before', 'wolf-page-builder' ),
		),
	),
);
echo wpb_generate_tinymce_popup( 'wpb_button', $params, $title );