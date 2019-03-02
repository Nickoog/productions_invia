<?php
/**
 * Advanced Slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpb_icons, $wpb_image_sizes;

$button_types = apply_filters( 'wpb_button_types', array(
	'wpb-flat' => esc_html__( 'Flat', 'wolf-page-builder' ),
	'wpb-outline' => esc_html__( 'Border', 'wolf-page-builder' ),
	'wpb-outline-inverted' => esc_html__( 'Border Hover', 'wolf-page-builder' ),
	'wpb-fill-in-up' => esc_html__( 'Fill-in-up', 'wolf-page-builder' ),
) );

// Advanced slider container
wpb_add_element(
	array(
		'name' => esc_html__( 'Advanced Slider', 'wolf-page-builder' ),
		'base' => 'wpb_advanced_slider',
		'description' => esc_html__( 'A powerful image/video slider', 'wolf-page-builder' ),
		'has_child' => true,
		'child' => 'wpb_advanced_slide',
		'category' => esc_html__( 'Sliders', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-images-slider',
		'params' => array(
			array(
				'type' => 'text',
				'label' => esc_html__( 'Slider Height', 'wolf-page-builder' ),
				'description' => esc_html__( 'Enter a value in % or px. 100% for a full height slider.', 'wolf-page-builder' ),
				'param_name' => 'slider_height',
				'value' => '650px',
				'display' => true,
			),
		),
	)
);

// Advanced slide
wpb_add_element(
	array(
		'name' => esc_html__( 'Advanced Slide', 'wolf-page-builder' ),
		'base' => 'wpb_advanced_slide',
		'category' => esc_html__( 'Sliders', 'wolf-page-builder' ),
		'nested' => true,
		'parent' => 'wpb_advanced_slider',
		'icon' => 'wpb-icon wpb-images-slider',
		'params' => array(

			// array(
			// 	'type' => 'select',
			// 	'label' => esc_html__( 'Main color tone', 'wolf-page-builder' ),
			// 	'param_name' => 'skin',
			// 	'choices' => array(
			// 		'dark' => esc_html__( 'Light', 'wolf-page-builder' ),
			// 		'light' => esc_html__( 'Dark', 'wolf-page-builder' ),
			// 	),
			// 	'description' => esc_html__( 'Choose the "Light" color tone if your slide background image is lighter than normal', 'wolf-page-builder' ),
			// ),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Background', 'wolf-page-builder' ),
				'param_name' => 'background_type',
				'choices' => array(
					'image' => esc_html__( 'Image', 'wolf-page-builder' ),
					'video' => esc_html__( 'Video', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'background',
				'label' => esc_html__( 'Background', 'wolf-page-builder' ),
				'param_name' => 'background',
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
			),

			array(
				'type' => 'video_background',
				'label' => esc_html__( 'Video Background', 'wolf-page-builder' ),
				'param_name' => 'video_bg',
				'video_type_option' => false,
				'dependency' => array( 
					'element' => 'background_type', 
					'value' => array( 'video' ),
				),
			),

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Show video background controls (play and mute buttons, only for self-hosted video)', 'wolf-page-builder' ),
				'param_name' => 'video_bg_controls',
				'dependency' => array( 
					'element' => 'background_type', 
					'value' => array( 'video' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Font Color', 'wolf-page-builder' ),
				'param_name' => 'font_color',
				'video_type_option' => false,
				'choices' => array(
					'light' => esc_html__( 'Light', 'wolf-page-builder' ),
					'dark' => esc_html__( 'Dark', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Title Type', 'wolf-page-builder' ),
				'param_name' => 'title_type',
				'video_type_option' => false,
				'choices' => array(
					'text' => esc_html__( 'Text', 'wolf-page-builder' ),
					'image' => esc_html__( 'Image', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'image',
				'label' => esc_html__( 'Image', 'wolf-page-builder' ),
				'param_name' => 'image',
				'dependency' => array( 
					'element' => 'title_type', 
					'value' => array( 'image' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Image Size', 'wolf-page-builder' ),
				'param_name' => 'image_size',
				'choices' => $wpb_image_sizes,
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings ', 'wolf-page-builder' ),
				'dependency' => array( 
					'element' => 'title_type', 
					'value' => array( 'image' ),
				),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'wolf-page-builder' ),
				'param_name' => 'title',
				'placeholder' => esc_html__( 'My Awesome Title', 'wolf-page-builder' ),
				'display' => true,
				'dependency' => array( 
					'element' => 'title_type', 
					'value' => array( 'text' ),
				),
			),

			array(
				'type' => 'font',
				'label' => esc_html__( 'Title Font', 'wolf-page-builder' ),
				'param_name' => 'title_font_family',
				'display' => true,
				'dependency' => array( 
					'element' => 'title_type', 
					'value' => array( 'text' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Caption Type', 'wolf-page-builder' ),
				'param_name' => 'caption_type',
				'choices' => array(
					'text' => esc_html__( 'Standard text', 'wolf-page-builder' ),
					'big-text' => esc_html__( 'Bigger text with semi-transparent background', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'textarea',
				'label' => esc_html__( 'Caption Text', 'wolf-page-builder' ),
				'param_name' => 'caption',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Caption Text Alignment', 'wolf-page-builder' ),
				'param_name' => 'caption_alignment',
				'choices' => array(
					'center' => esc_html__( 'Center', 'wolf-page-builder' ),
					'left' => esc_html__( 'Left', 'wolf-page-builder' ),
					'right' => esc_html__( 'Right', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Caption Width', 'wolf-page-builder' ),
				'param_name' => 'caption_width',
				'choices' => array(
					'large' => esc_html__( 'Large', 'wolf-page-builder' ),
					'small' => esc_html__( 'Small', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Caption Position', 'wolf-page-builder' ),
				'param_name' => 'caption_position',
				'choices' => array(
					'center' => esc_html__( 'Center', 'wolf-page-builder' ),
					'left' => esc_html__( 'Left', 'wolf-page-builder' ),
					'right' => esc_html__( 'Right', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Add a First Button', 'wolf-page-builder' ),
				'param_name' => 'button_1',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Button 1 Text', 'wolf-page-builder' ),
				'param_name' => 'button_1_text',
				'value' => esc_html__( 'My button', 'wolf-page-builder' ),
				//'display' => true,
				'dependency' => array( 'element' => 'button_1', 'value' => array( 'yes' ) ),
			),
			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Button 1 Tagline', 'wolf-page-builder' ),
				'param_name' => 'button_1_tagline',
				'placeholder' => esc_html__( 'Optional additional text', 'wolf-page-builder' ),
				//'display' => true,
				'dependency' => array( 'element' => 'button_1', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Button 1 Type', 'wolf-page-builder' ),
				'param_name' => 'button_1_type',
				'choices' => $button_types,
				'dependency' => array( 'element' => 'button_1', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Button 1 Shape', 'wolf-page-builder' ),
				'param_name' => 'button_1_shape',
				'choices' => array(
					'' => esc_html__( 'Default', 'wolf-page-builder' ),
					'square' => esc_html__( 'Square', 'wolf-page-builder' ),
					'round' => esc_html__( 'Round', 'wolf-page-builder' ),
				),
				'dependency' => array( 'element' => 'button_1', 'value' => array( 'yes' ) ),
				'value' => apply_filters( 'wpb_default_button_shape', 'default' ),
			),

			array(
				'type' => 'colorpicker',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Button 1 Color', 'wolf-page-builder' ),
				'param_name' => 'button_1_color',
				'dependency' => array( 'element' => 'button_1', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'colorpicker',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Button 1 Color on Hover', 'wolf-page-builder' ),
				'param_name' => 'button_1_color_hover',
				'dependency' => array( 'element' => 'button_1', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'link',
				'label' => esc_html__( 'Button 1 Link', 'wolf-page-builder' ),
				'param_name' => 'button_1_link',
				'placeholder' => 'http://',
				'dependency' => array( 'element' => 'button_1', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Add a Second Button', 'wolf-page-builder' ),
				'param_name' => 'button_2',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Button 2 Text', 'wolf-page-builder' ),
				'param_name' => 'button_2_text',
				'value' => esc_html__( 'My button', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'button_2', 'value' => array( 'yes' ) ),
			),
			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Button 2 Tagline', 'wolf-page-builder' ),
				'param_name' => 'button_2_tagline',
				'placeholder' => esc_html__( 'Optional additional text', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'button_2', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Button 2 Type', 'wolf-page-builder' ),
				'param_name' => 'button_2_type',
				'choices' => $button_types,
				'dependency' => array( 'element' => 'button_2', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Button 2 Shape', 'wolf-page-builder' ),
				'param_name' => 'button_2_shape',
				'choices' => array(
					'' => esc_html__( 'Default', 'wolf-page-builder' ),
					'square' => esc_html__( 'Square', 'wolf-page-builder' ),
					'round' => esc_html__( 'Round', 'wolf-page-builder' ),
				),
				'dependency' => array( 'element' => 'button_2', 'value' => array( 'yes' ) ),
				'value' => apply_filters( 'wpb_default_button_shape', 'default' ),
			),

			array(
				'type' => 'colorpicker',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Button 2 Color', 'wolf-page-builder' ),
				'param_name' => 'button_2_color',
				'dependency' => array( 'element' => 'button_2', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'colorpicker',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Button 2 Color on Hover', 'wolf-page-builder' ),
				'param_name' => 'button_2_color_hover',
				'dependency' => array( 'element' => 'button_2', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'link',
				'label' => esc_html__( 'Button 2 Link', 'wolf-page-builder' ),
				'param_name' => 'button_2_link',
				'placeholder' => 'http://',
				'dependency' => array( 'element' => 'button_2', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Add Overlay', 'wolf-page-builder' ),
				'param_name' => 'overlay',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Overlay Color', 'wolf-page-builder' ),
				'param_name' => 'overlay_color',
				'value' => '#000000',
				'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'image',
				'label' => esc_html__( 'Overlay Pattern', 'wolf-page-builder' ),
				'param_name' => 'overlay_image',
				// 'description' => esc_html__( 'A repeatable image', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Overlay Opacity in Percent', 'wolf-page-builder' ),
				'param_name' => 'overlay_opacity',
				'value' => '40',
				'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
			),
		),
	)
);