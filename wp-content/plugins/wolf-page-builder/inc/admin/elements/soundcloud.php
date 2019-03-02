<?php
/**
 * Soundcloud
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Soundcloud
wpb_add_element(
	array(
		'name' => esc_html__( 'Soundcloud', 'wolf-page-builder' ),
		'base' => 'wpb_soundcloud',
		'description' => esc_html__( 'An embed Soundcloud playlist or song', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-soundcloud',
		'category' => esc_html__( 'Music', 'wolf-page-builder' ),
		'params' => array(

			array(
				'type' => 'url',
				'label' => esc_html__( 'Playlist or Song URL', 'wolf-page-builder' ),
				'param_name' => 'url',
				'placeholder' => 'https://',
				'display' => true,
			),
		),
	)
);