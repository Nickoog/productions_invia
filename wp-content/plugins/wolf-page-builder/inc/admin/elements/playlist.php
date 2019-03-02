<?php
/**
 * Wolf Playlist Manager plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Playlist_Manager' ) ) {
	// Playlist Shortcode

	$choices = array();

	$playlists = get_posts( array( 'post_type' => 'wpm_playlist', 'posts_per_page' => -1, ) ); // get all playlist

	foreach ( $playlists as $playlist ) {
		$choices[ $playlist->ID ] = $playlist->post_title;
	}

	// if no result display "no playlist"
	if ( array() == $choices ) {
		$choices[0] = esc_html__( 'No playlist created yet', 'wolf-page-builder' );
	}

	wpb_add_element(
		array(
			'name' => esc_html__( 'Playlist', 'wolf-page-builder' ),
			'base' => 'wolf_playlist',
			'description' => esc_html__( 'Display one of your playlist', 'wolf-page-builder' ),
			'category' => esc_html__( 'Music', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-playlist',
			'params' => array(
				array(
					'type' => 'select',
					'label' => esc_html__( 'Playlist', 'wolf-page-builder' ),
					'param_name' => 'id',
					'choices' => $choices,
					'display' => true,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Tracklist Visibility', 'wolf-page-builder' ),
					'param_name' => 'show_tracklist',
					'choices' => array(
						'true' => esc_html__( 'show', 'wolf-page-builder' ),
						'false' => esc_html__( 'hide', 'wolf-page-builder' ),
					),
					'display' => true,
				),
			)
		)
	);
}