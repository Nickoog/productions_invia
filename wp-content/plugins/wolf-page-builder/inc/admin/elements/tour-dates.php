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

if ( class_exists( 'Wolf_Tour_Dates' ) ) {
	wpb_add_element(
		array(
			'name' => esc_html__( 'Tour Dates', 'wolf-page-builder' ),
			'description' => esc_html__( 'Display your event list from the Wolf Tour Dates plugin', 'wolf-page-builder' ),
			'base' => 'wolf_tour_dates',
			'category' => 'Music',
			'icon' => 'wpb-icon wpb-tour-dates',
			'params' => array(

				array(
					'type' => 'text',
					'label' => esc_html__( 'Count', 'wolf-page-builder' ),
					'param_name' => 'count',
					'value' => 10,
					'display' => true,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Link to Single Show Page', 'wolf-page-builder' ),
					'param_name' => 'link',
					'choices' => array(
						'false' => esc_html__( 'No', 'wolf-page-builder' ),
						'true' => esc_html__( 'Yes', 'wolf-page-builder' ),
					),
					'display' => true,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Display Past Shows', 'wolf-page-builder' ),
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
			)
		)
	);

	wpb_add_element(
		array(
			'name' => esc_html__( 'Tour Dates Widget', 'wolf-page-builder' ),
			'base' => 'wolf_upcoming_shows_widget',
			'description' => esc_html__( 'Events list widget', 'wolf-page-builder' ),
			'category' => 'Music',
			'icon' => 'wpb-icon wpb-tour-dates',
			'params' => array(

				array(
					'type' => 'hidden',
					'param_name' => 'linked',
					'value' => 'false',
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Count', 'wolf-page-builder' ),
					'param_name' => 'count',
					'value' => 8,
					'display' => true,
				),

				array(
					'type' => 'url',
					'label' => esc_html__( 'Tour Dates Page URL', 'wolf-page-builder' ),
					'param_name' => 'page_url',
					'display' => true,
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Link Text', 'wolf-page-builder' ),
					'param_name' => 'link_text',
					'value' => esc_html__( 'View all dates', 'wolf-page-builder' ),
					'display' => true,
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Artist Slug', 'wolf-page-builder' ),
					'param_name' => 'artist',
				),
			)
		)
	);
}