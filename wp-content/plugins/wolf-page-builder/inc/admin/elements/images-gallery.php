<?php
/**
 * Images gallery
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
		'name' => esc_html__( 'Image Gallery', 'wolf-page-builder' ),
		'description' => esc_html__( 'A set of images', 'wolf-page-builder' ),
		'base' => 'wpb_gallery',
		'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-images-gallery',
		'params' => array(

			array(
				'type' => 'multiple_images',
				'label' => esc_html__( 'Images', 'wolf-page-builder' ),
				'param_name' => 'ids',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Layout', 'wolf-page-builder' ),
				'param_name' => 'layout',
				'choices' => array(
					'simple' => esc_html__( 'Simple', 'wolf-page-builder' ),
					'mosaic' => esc_html__( 'Mosaic', 'wolf-page-builder' ),
					'carousel' => esc_html__( 'Carousel', 'wolf-page-builder' ),
				),
				'description' => esc_html__( 'For the mosaic gallery layout a multiple of 12 images is recommended. Uploaded images must be 960x960px minimum.', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Image Size', 'wolf-page-builder' ),
				'param_name' => 'image_size',
				'choices' => $wpb_image_sizes,
				'description' => esc_html__( 'Some thumbnail sizes may be cropped version of the original image. You can set the "large", "medium" and "thumbnail" sizes in the WP media settings ', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'layout', 'value' => array( 'simple', 'carousel' ) ),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Columns', 'wolf-page-builder' ),
				'param_name' => 'columns',
				'choices' => array(
					4,1,2,3,5,6
				),
				'dependency' => array( 'element' => 'layout', 'value' => array( 'simple' ) ),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Padding', 'wolf-page-builder' ),
				'param_name' => 'padding',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
					'no' => esc_html__( 'No', 'wolf-page-builder' ),
				),
				'dependency' => array( 'element' => 'layout', 'value' => array( 'simple', 'carousel' ) ),
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
				'type' => 'select',
				'label' => esc_html__( 'Link Type', 'wolf-page-builder' ),
				'param_name' => 'link_type',
				'choices' => array(
					'file' => esc_html__( 'Open full size image in a lightbox', 'wolf-page-builder' ),
					'raw-file' => esc_html__( 'Full size image', 'wolf-page-builder' ),
					'attachment' => esc_html__( 'Attachment page', 'wolf-page-builder' ),
					'none' => esc_html__( 'Not linked', 'wolf-page-builder' ),
				),
			),
		)
	)
);