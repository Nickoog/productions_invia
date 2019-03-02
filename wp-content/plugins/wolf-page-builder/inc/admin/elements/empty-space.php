<?php
/**
 * Empty space
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// empty space
wpb_add_element(
	array(
		'name' => esc_html__( 'Empty Space', 'wolf-page-builder' ),
		'description' => esc_html__( 'Add visual rhythm with some vertical space', 'wolf-page-builder' ),
		'base' => 'wpb_empty_space',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-empty-space',
		'params' => array(

			array(
				'type' => 'int',
				'label' => esc_html__( 'Height', 'wolf-page-builder' ),
				'param_name' => 'height',
				'value' => 50,
				'display' => true,
			),

			// array(
			// 	'type' => 'text',
			// 	'label' => esc_html__( 'Note', 'wolf-page-builder' ),
			// 	'param_name' => 'note',
			// 	'description' => esc_html__( 'Helping not to display on the admin.', 'wolf-page-builder' ),
			// 	'display' => true,
			// ),
		)
	)
);