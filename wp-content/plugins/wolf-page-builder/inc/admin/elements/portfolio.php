<?php
/**
 * Portfolio plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Portfolio' ) ) {
	// Portfolio Shortcode
	wpb_add_element(
		array(
			'name' => esc_html__( 'Last Works', 'wolf-page-builder' ),
			'base' => 'wolf_last_works',
			'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-works',
			'params' => array(

				array(
					'type' => 'int',
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
					'dependency' => array(
						'element' => 'layout', 'value' => array( 'classic', 'grid', 'grid-square', 'masonry' )
					),
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
}