<?php
/**
 * Video opener
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Video opener
wpb_add_element(
	array(
		'name' => esc_html__( 'Video Opener', 'wolf-page-builder' ),
		'base' => 'wpb_video_opener',
		'description' => esc_html__( 'Open a video in a overlay', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-video',
		'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
		'params' => array(

			array(
				'type' => 'select',
				'label' => esc_html__( 'Custom Play Button', 'wolf-page-builder' ),
				'param_name' => 'custom_play_button',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'image',
				'label' => esc_html__( 'Button Image', 'wolf-page-builder' ),
				'param_name' => 'button_image',
				'description' => esc_html__( 'If empty, a standard play button will be displayed', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'custom_play_button', 'value' => array( 'yes' ) ),
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
				'type' => 'url',
				'label' => esc_html__( 'Video URL', 'wolf-page-builder' ),
				'param_name' => 'video_url',
				'placeholder' => 'https://vimeo.com/124894010',
				'description' => sprintf( 
					esc_html__( 'Support %1$s and %2$s', 'wolf-page-builder' ),
					'YouTube',
					'Vimeo'
				),
				'display' => true,
			),
		),
	)
);