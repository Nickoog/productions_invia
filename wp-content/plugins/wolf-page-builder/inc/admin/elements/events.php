<?php
/**
 * Tour Dates Plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Events' ) ) {
	wpb_add_element(
		array(
			'name' => esc_html__( 'Event List', 'wolf-page-builder' ),
			'description' => esc_html__( 'Display your event list from the Wolf Events plugin', 'wolf-page-builder' ),
			'base' => 'wolf_event_list',
			'category' => esc_html__( 'Music', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-events',
			'params' => array(

				array(
					'type' => 'text',
					'label' => esc_html__( 'Count', 'wolf-page-builder' ),
					'description' => esc_html__( 'Leave empty to display all', 'wolf-page-builder' ),
					'param_name' => 'count',
					'display' => true,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Link to Single Event Page', 'wolf-page-builder' ),
					'param_name' => 'link',
					'choices' => array(
						'false' => esc_html__( 'No', 'wolf-page-builder' ),
						'true' => esc_html__( 'Yes', 'wolf-page-builder' ),
					),
					'display' => true,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Display Past Events', 'wolf-page-builder' ),
					'param_name' => 'past',
					'choices' => array(
						'false' => esc_html__( 'No', 'wolf-page-builder' ),
						'true' => esc_html__( 'Yes', 'wolf-page-builder' ),
					),
					'display' => true,
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Artist Slug', 'wolf-page-builder' ),
					'param_name' => 'artist',
					'display' => true,
				),
			),
		)
	);
}