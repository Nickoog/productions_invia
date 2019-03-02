<?php
/**
 * Raw HTML
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Raw HTML
wpb_add_element(
	array(
		'name' => esc_html__( 'Raw HTML', 'wolf-page-builder' ),
		'base' => 'wpb_raw_html',
		'description' => esc_html__( 'Any HTML content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-raw-html',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'params' => array(

			array(
				'type' => 'textarea_html',
				'class' => 'wpb-raw-html-fieldset',
				'label' => esc_html__( 'Your HTML code', 'wolf-page-builder' ),
				'param_name' => 'html',
			),
		),
	)
);