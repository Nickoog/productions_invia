<?php
/**
 * Dribbble plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Dribbble' ) ) {
	// Dribbble Shortcode
	wpb_add_element(
		array(
			'name' => esc_html__( 'Dribbble', 'wolf-page-builder' ),
			'base' => 'wolf_dribbble',
			'description' => esc_html__( 'Your last shots', 'wolf-page-builder' ),
			'category' => 'Social',
			'icon' => 'wpb-icon wpb-dribbble',
			'params' => array(

				array(
					'type' => 'text',
					'label' => esc_html__( 'Player ID', 'wolf-page-builder' ),
					'param_name' => 'player_id',
					'display' => true,
				),

				array(
					'type' => 'int',
					'label' => esc_html__( 'Count', 'wolf-page-builder' ),
					'param_name' => 'count',
					'display' => true,
				),
			)
		)
	);
}