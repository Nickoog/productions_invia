<?php
/**
 * Gist
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'gist' ) ) {
	// oemebed gist
	wpb_add_element(
		array(
			'name' => esc_html__( 'Gist', 'wolf-page-builder' ),
			'description' => esc_html__( 'Display an Embed Gist', 'wolf-page-builder' ),
			'base' => 'gist',
			'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-oembed-gist',
			'params' => array(

				array(
					'type' => 'url',
					'label' => esc_html__( 'Gist URL', 'wolf-page-builder' ),
					'param_name' => 'url',
					'placeholder' => 'https://',
					'display' => true,
				),
			)
		)
	);
}