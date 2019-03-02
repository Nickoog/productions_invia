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
		'name' => esc_html__( 'Image', 'wolf-page-builder' ),
		'description' => esc_html__( 'A simple image with link options', 'wolf-page-builder' ),
		'base' => 'wpb_image',
		'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-single-image',
		'params' => array(

			array(
				'type' => 'image',
				'label' => esc_html__( 'Image', 'wolf-page-builder' ),
				'param_name' => 'image',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Add Another Image on Hover', 'wolf-page-builder' ),
				'param_name' => 'add_image_hover',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'image',
				'label' => esc_html__( 'Image on Hover', 'wolf-page-builder' ),
				'param_name' => 'image_hover',
				'dependency' => array( 'element' => 'add_image_hover', 'value' => array( 'yes' ) ),
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
				'label' => esc_html__( 'Hover Effect', 'wolf-page-builder' ),
				'param_name' => 'hover_effect',
				'choices' => array(
					'none' => esc_html__( 'None', 'wolf-page-builder' ),
					'default' => esc_html__( 'Default', 'wolf-page-builder' ),
					'greyscale' => esc_html__( 'Black and white to colored', 'wolf-page-builder' ),
					'to-greyscale' => esc_html__( 'Colored to Black and white', 'wolf-page-builder' ),
					'scale' => esc_html__( 'Scale', 'wolf-page-builder' ),
					'scale-greyscale' => esc_html__( 'Scale + Black and white to colored', 'wolf-page-builder' ),
					'scale-to-greyscale' => esc_html__( 'Scale + Colored to Black and white', 'wolf-page-builder' ),
				),
				'display' => true,
				'description' => esc_html__( 'Note that not all browsers support the black and white effect', 'wolf-page-builder' ),
			),

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Display caption', 'wolf-page-builder' ),
				'param_name' => 'display_caption',
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Link', 'wolf-page-builder' ),
				'param_name' => 'link_type',
				'display' => true,
				'choices' => array(
					'none' => esc_html__( 'Not linked', 'wolf-page-builder' ),
					'file' => esc_html__( 'Open full size image in a lightbox', 'wolf-page-builder' ),
					'raw-file' => esc_html__( 'Full size image', 'wolf-page-builder' ),
					'attachment' => esc_html__( 'Attachment page', 'wolf-page-builder' ),
					'url' => esc_html__( 'Link to a custom URL', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'link',
				'label' => esc_html__( 'Link', 'wolf-page-builder' ),
				'param_name' => 'link',
				'display' => true,
				'dependency' => array( 'element' => 'link_type', 'value' => array( 'url' ) ),
			),

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Scroll to anchor', 'wolf-page-builder' ),
				'param_name' => 'scroll_to_anchor',
				'display' => true,
				'dependency' => array( 'element' => 'link_type', 'value' => array( 'url' ) ),
			),
		)
	)
);