<?php
/**
 * Discography Plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Discography' ) ) {
	// Discography Shortcode
	wpb_add_element(
		array(
			'name' => esc_html__( 'Last Releases', 'wolf-page-builder' ),
			'description' => esc_html__( 'Display your discography', 'wolf-page-builder' ),
			'base' => 'wolf_last_releases',
			'category' => esc_html__( 'Music', 'wolf-page-builder' ),
			'tags' => 'discography',
			'icon' => 'wpb-icon wpb-releases',
			'params' => array(

				array(
					'type' => 'text',
					'label' => esc_html__( 'Count', 'wolf-page-builder' ),
					'param_name' => 'count',
					'value' => 3,
					'display' => true,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Columns', 'wolf-page-builder' ),
					'param_name' => 'col',
					'choices' => array( 3,2,4 ),
					'display' => true,
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Label', 'wolf-page-builder' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-page-builder' ),
					'display' => true,
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Band', 'wolf-page-builder' ),
					'param_name' => 'band',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-page-builder' ),
					'display' => true,
				),
			)
		)
	);

	wpb_add_element(
		array(
			'name' => esc_html__( 'Last Release', 'wolf-page-builder' ),
			'description' => esc_html__( 'Display your last release', 'wolf-page-builder' ),
			'base' => 'wolf_last_release',
			'category' => esc_html__( 'Music', 'wolf-page-builder' ),
			'tags' => 'discography',
			'icon' => 'wpb-icon wpb-releases',
			'params' => array(

				array(
					'type' => 'text',
					'label' => esc_html__( 'Label', 'wolf-page-builder' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-page-builder' ),
					'display' => true,
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Band', 'wolf-page-builder' ),
					'param_name' => 'band',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-page-builder' ),
					'display' => true,
				),

				// array(
				// 	'label' => esc_html__( 'Show title', 'wolf-page-builder' ),
				// 	'class' => 'wpb-col-6 wpb-first',
				// 	'type' => 'checkbox',
				// 	'param_name' => 'display_title',
				// 	'value' => 'true',
				// ),

				// array(
				// 	'label' => esc_html__( 'Show buttons', 'wolf-page-builder' ),
				// 	'class' => 'wpb-col-6 wpb-first',
				// 	'type' => 'checkbox',
				// 	'param_name' => 'display_button',
				// 	'value' => 'true',
				// ),
			)
		)
	);
}