<?php
/**
 *  Block
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Block
wpb_add_element(
	array(
		'name' => esc_html__( 'Block', 'wolf-page-builder' ),
		'base' => 'block',
		'icon' => 'wpb-icon wpb-section-columns',
		'params' => array(

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Content Type', 'wolf-page-builder' ),
				'param_name' => 'content_type',
				'choices' => array(
					'text' => esc_html__( 'Text', 'wolf-page-builder' ),
					'media' => esc_html__( 'Media (no padding)', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Main Color Tone', 'wolf-page-builder' ),
				'param_name' => 'skin',
				'choices' => array(
					'dark' => esc_html__( 'Light', 'wolf-page-builder' ),
					'light' => esc_html__( 'Dark', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Background Type', 'wolf-page-builder' ),
				'param_name' => 'background_type',
				'choices' => array(
					'none' => esc_html__( 'Default', 'wolf-page-builder' ),
					'image' => esc_html__( 'Image', 'wolf-page-builder' ),
					'video' => esc_html__( 'Video', 'wolf-page-builder' ),
					'slideshow' => esc_html__( 'Slideshow', 'wolf-page-builder' ),
					'transparent' => esc_html__( 'Transparent', 'wolf-page-builder' ),
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
				'dependency' => array( 
					'element' => 'background_type', 
					'value' => array( 'video' ),
				),
			),

			array(
				'type' => 'multiple_images',
				'label' => esc_html__( 'Slideshow Images', 'wolf-page-builder' ),
				'param_name' => 'slideshow_img_ids',
				'dependency' => array( 
					'element' => 'background_type', 
					'value' => array( 'slideshow' ),
				),
			),

			array(
				'type' => 'int',
				'label' => esc_html__( 'Slideshow Speed (in ms)', 'wolf-page-builder' ),
				'param_name' => 'slideshow_speed',
				'dependency' => array( 
					'element' => 'background_type', 
					'value' => array( 'slideshow' ),
				),
				'value' => 4000,
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
		)
	)
);