<?php
/**
 * Video carousel
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Video carousel
wpb_add_element(
	array(
		'name' => esc_html__( 'Video Carousel', 'wolf-page-builder' ),
		'base' => 'wpb_video_carousel',
		'description' => esc_html__( 'A list of videos displayed in a carousel', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-video',
		'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
		'params' => array(

			array(
				'type' => 'textarea',
				'label' => esc_html__( 'Video URLs', 'wolf-page-builder' ),
				'param_name' => 'urls',
				'placeholder' => '',
				'description' => esc_html__( 'Enter your YouTube or Vimeo URLs separated by a comma.', 'wolf-page-builder' ),
				'display' => true,
			),
		),
	)
);