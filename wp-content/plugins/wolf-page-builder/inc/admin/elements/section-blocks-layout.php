<?php
/**
 * Section layout
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wpb_add_element(
	array(

		'name' => '',
		'base' => 'section_blocks_layout',
		'icon' => 'wpb-icon wpb-section-columns',
		'params' => array(

			array(
				'type' => 'hidden',
				'param_name' => 'section_type',
				'value' => 'blocks',
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Layout', 'wolf-page-builder' ),
				'param_name' => 'layout',
				'choices' => array(
					'2-cols' => sprintf( esc_html__( '%d blocks', 'wolf-page-builder' ), 2 ),
					'3-cols' => sprintf( esc_html__( '%d blocks', 'wolf-page-builder' ), 3 ),
					'4-cols' => sprintf( esc_html__( '%d blocks', 'wolf-page-builder' ), 4 ),
					'6-cols' => sprintf( esc_html__( '%d blocks', 'wolf-page-builder' ), 6 ),
				),
			),
		)
	)
);