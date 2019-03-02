<?php
/**
 * Sonic videos
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_videos_mods( $sonic_mods ) {

	if ( class_exists( 'Wolf_Videos' ) ) {
		$sonic_mods['wolf_videos'] = array(
			//'priority' => 45,
			'id' => 'wolf_videos',
			'title' => esc_html__( 'Videos Page', 'sonic' ),
			'icon' => 'editor-video',
			'options' => array(

				'videos_layout' => array(
					'id' => 'videos_layout',
					'label' => esc_html__( 'Layout', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'sonic' ),
						'fullwidth' => esc_html__( 'Full width', 'sonic' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'sonic' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'videos_padding' => array(
					'id' => 'videos_padding',
					'label' => esc_html__( 'Padding', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'sonic' ),
						'no' => esc_html__( 'No', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'videos_columns' => array(
					'id' => 'videos_columns',
					'label' => esc_html__( 'Columns', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						3 => 3, 
						2 => 2, 
						4 => 4, 
						5 => 5, 
						6 => 6,
					),
					'transport' => 'postMessage',
				),

				'videos_lightbox' => array(
					'id' => 'videos_lightbox',
					'label' => esc_html__( 'Open Videos in a Lightbox', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'sonic' ),
						'no' => esc_html__( 'No', 'sonic' ),
					),
					// 'transport' => 'postMessage',
				),

				// 'video_posts_per_page' => array(
				// 	'label' => esc_html__( 'Video posts per page', 'sonic' ),
				// 	'id' => 'video_posts_per_page',
				// 	'type' => 'text',
				// ),
			),
		);
	}

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_videos_mods' );