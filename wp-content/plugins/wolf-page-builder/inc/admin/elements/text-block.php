<?php
/**
 * Text block
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Text block
wpb_add_element(
	array(
		'name' => esc_html__( 'Text Block', 'wolf-page-builder' ),
		'base' => 'wpb_text_block',
		'description' => esc_html__( 'A block of text with the Wordpress editor', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-text-block',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'params' => array(
			array(
				'type' => 'editor',
				'label' => esc_html__( 'Content', 'wolf-page-builder' ),
				'param_name' => 'editorcontent',
				'value' => wpb_encode_textarea_html( sprintf( esc_html__( 'This is a text block. %s', 'wolf-page-builder' ), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.' ) ),
				'display' => true,
			),
		)
	)
);