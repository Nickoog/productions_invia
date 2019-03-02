<?php
/**
 * Youtube video
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Youtube
wpb_add_element(
	array(
		'name' => esc_html__( 'YouTube Video', 'wolf-page-builder' ),
		'base' => 'wpb_youtube',
		'description' => esc_html__( 'A youtube video with video preview', 'wolf-page-builder' ),
		'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-youtube',
		'params' => array(
			array(
				'type' => 'url',
				'label' => esc_html__( 'YouTube Video URL', 'wolf-page-builder' ),
				'param_name' => 'url',
				'placeholder' => 'https://www.youtube.com/watch?v=fKBweD2hyf4',
				'display' => true,
			),
			array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'wolf-page-builder' ),
				'param_name' => 'title',
				'placeholder' => esc_html__( 'My video title', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'image',
				'label' => esc_html__( 'Cover Image', 'wolf-page-builder' ),
				'param_name' => 'image',
				'display' => true,
			),

			array(
				'type' => 'file_video',
				'label' => esc_html__( 'Video Preview', 'wolf-page-builder' ),
				'param_name' => 'video_preview',
				'description' => esc_html__( 'A short mp4 video file', 'wolf-page-builder' ),
				'display' => true,
			),
		),
	)
);