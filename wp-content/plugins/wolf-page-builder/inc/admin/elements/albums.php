<?php
/**
 * Albums plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Albums' ) ) {
	// Albums Shortcode
	wpb_add_element(
		array(
			'name' => esc_html__( 'Albums', 'wolf-page-builder' ),
			'description' => esc_html__( 'Showcase your photos sorted by albums', 'wolf-page-builder' ),
			'tags' => 'photo',
			'base' => 'wolf_last_albums',
			'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-albums',
			'params' => array(

				array(
					'type' => 'int',
					'label' => esc_html__( 'Count', 'wolf-page-builder' ),
					'param_name' => 'count',
					'value' => 4,
					'display' => true,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Columns', 'wolf-page-builder' ),
					'param_name' => 'col',
					'choices' => array( 4,3,2 ),
					'display' => true,
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Category', 'wolf-page-builder' ),
					'param_name' => 'category',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-page-builder' ),
					'display' => true,
				),
			)
		)
	);

	// Last Photos Shortcode
	wpb_add_element(
		array(
			'name' => esc_html__( 'Photos Widget (last photos)', 'wolf-page-builder' ),
			'description' => esc_html__( 'Display the last photos uploaded in your albums', 'wolf-page-builder' ),
			'base' => 'wolf_last_photos_widget',
			'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-albums',
			'params' => array(

				array(
					'type' => 'int',
					'label' => esc_html__( 'Count', 'wolf-page-builder' ),
					'param_name' => 'count',
					'value' => 4,
					'display' => true,
				),
			)
		)
	);
}