<?php
/**
 * Bandsintown Plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'the_bandsintown_events' ) ) {
	wpb_add_element(
		array(
			'name' => 'Bandsintown',
			'description' => esc_html__( 'Display Your Bandsintown Event List', 'wolf-page-builder' ),
			'tags' => 'tour dats event list',
			'base' => 'wpb_bandsintown_events',
			'category' => esc_html__( 'Music', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-bandsintown',
			'params' => array(
				array(
					'type' => 'text',
					'label' => esc_html__( 'Artist Name', 'wolf-page-builder' ),
					'param_name' => 'artist',
					'display' => true,
				),
			),
		)
	);
}