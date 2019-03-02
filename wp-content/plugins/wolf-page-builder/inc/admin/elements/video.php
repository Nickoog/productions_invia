<?php
/**
 * Video
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Video
wpb_add_element(
	array(
		'name' => esc_html__( 'Video', 'wolf-page-builder' ),
		'base' => 'wpb_video',
		'description' => esc_html__( 'An embed video', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-video',
		'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
		'tags' => 'embed',
		'params' => array(

			array(
				'type' => 'url',
				'label' => esc_html__( 'Video URL', 'wolf-page-builder' ),
				'param_name' => 'url',
				'placeholder' => 'https://vimeo.com/30391286',
				'description' => sprintf( wp_kses(
					__( 'Link to the video. More about supported formats at <a href="%s" target="_blank">WordPress codex page.</a>', 'wolf-page-builder' ),
						array( 'a' => array( 'href' => array() ) )
					),
					'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F'
				),
				'display' => true,
			),
		),
	)
);