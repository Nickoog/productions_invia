<?php
/**
 * jPlayer plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_jPlayer' ) ) {

	global $wpdb;
	$wolf_jplayer_playlists_table = esc_sql( $wpdb->prefix . 'wolf_jplayer_playlists' );

	$playlists = $wpdb->get_results( "SELECT * FROM $wolf_jplayer_playlists_table" );

	$args = array();

	if ( $playlists ) {

		$args = array(
			'name' => 'jPlayer',
			'base' => 'wolf_jplayer_playlist',
			'category' => esc_html__( 'Music', 'wolf-page-builder' ),
			'description' => esc_html__( 'A playlist of songs', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-jplayer',
			'params' => array(

				array(
					'type' => 'select',
					'label' => esc_html__( 'Playlist', 'wolf-page-builder' ),
					'param_name' => 'id',
					'choices' => array(),
					'display' => true,
				),
			)
		);

		foreach ( $playlists as $p ) {
			$args['params'][0]['choices'][ $p->id ] = $p->name;
		}

	} else {
		$args = array(
			'name' => 'jPlayer',
			'base' => 'wolf_jplayer_playlist',
			'category' => esc_html__( 'Music', 'wolf-page-builder' ),
			'description' => esc_html__( 'A playlist of songs', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-jplayer',
			'params' => array(

				array(
					'type' => 'select',
					'label' => esc_html__( 'Playlist', 'wolf-page-builder' ),
					'param_name' => 'id',
					'choices' => array( 0 => esc_html__( 'No playlist created yet', 'wolf-page-builder' ) ),
				),
			)
		);
	}

	// jPlayer Shortcode
	wpb_add_element( $args );
}