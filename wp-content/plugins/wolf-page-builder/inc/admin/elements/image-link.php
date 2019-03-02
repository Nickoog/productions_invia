<?php
/**
 * Linked image
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpb_animations, $wpb_image_sizes;

wpb_add_element(
	array(
		'name' => esc_html__( 'Linked Image', 'wolf-page-builder' ),
		'description' => esc_html__( 'A linked image with a text overlay', 'wolf-page-builder' ),
		'base' => 'wpb_image_link',
		'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-image-link',
		'params' => array(

			array(
				'type' => 'image',
				'label' => esc_html__( 'Image', 'wolf-page-builder' ),
				'param_name' => 'image',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Image Size', 'wolf-page-builder' ),
				'param_name' => 'image_size',
				'choices' => $wpb_image_sizes,
				'description' => esc_html__( 'Some thumbnail sizes may be cropped version of the original image. You can set the "large", "medium" and "thumbnail" sizes in the WP media settings ', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Image Alignment', 'wolf-page-builder' ),
				'param_name' => 'alignment',
				'choices' => array(
					'center' => esc_html__( 'center', 'wolf-page-builder' ),
					'left' => esc_html__( 'left', 'wolf-page-builder' ),
					'right' => esc_html__( 'right', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Text Alignment', 'wolf-page-builder' ),
				'param_name' => 'text_alignment',
				'choices' => array(
					'center' => esc_html__( 'center', 'wolf-page-builder' ),
					'left' => esc_html__( 'left', 'wolf-page-builder' ),
					'right' => esc_html__( 'right', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Image Style', 'wolf-page-builder' ),
				'param_name' => 'image_style',
				'choices' => array(
					'default' => esc_html__( 'default', 'wolf-page-builder' ),
					'wpb-round' => esc_html__( 'rounded', 'wolf-page-builder' ),
					'wpb-shadow' => esc_html__( 'shadow', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Frame Style', 'wolf-page-builder' ),
				'param_name' => 'frame_style',
				'choices' => array(
					'' => esc_html__( 'none', 'wolf-page-builder' ),
					'wpb-frame-border' => esc_html__( 'border', 'wolf-page-builder' ),
				),
				'display' => true,
				//'dependency' => array( 'element' => 'image_style', 'value' => array( 'default' ) ),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Text', 'wolf-page-builder' ),
				'param_name' => 'text',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Tagline', 'wolf-page-builder' ),
				'param_name' => 'secondary_text',
				'display' => true,
			),

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Tagline as Button', 'wolf-page-builder' ),
				'param_name' => 'secondary_text_button',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Tag', 'wolf-page-builder' ),
				'param_name' => 'text_tag',
				'choices' => array(
					'h3',
					'span',
					'h5',
					'h4',
					'h2',
					'h1',
				),
				// 'description' => '',
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Text Color', 'wolf-page-builder' ),
				'param_name' => 'text_color',
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Overlay Color', 'wolf-page-builder' ),
				'param_name' => 'overlay_color',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Overlay Opacity in Percent', 'wolf-page-builder' ),
				'param_name' => 'overlay_opacity',
				'display' => true,
			),

			array(
				'type' => 'link',
				'label' => esc_html__( 'Link', 'wolf-page-builder' ),
				'param_name' => 'link',
				'placeholder' => 'http://',
				'display' => true,
			),
		)
	)
);