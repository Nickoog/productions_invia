<?php
/**
 * Social icons custom
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wpb_team_member_socials;

// Social icons custom
wpb_add_element(
	array(
		'name' => esc_html__( 'Social Icons Custom URLs', 'wolf-page-builder' ),
		'base' => 'wpb_socials_custom',
		'icon' => 'wpb-icon wpb-social-icons',
		'description' => esc_html__( 'A set of icons linked to your chosen URLs', 'wolf-page-builder' ),
		'category' => esc_html__( 'Social', 'wolf-page-builder' ),
		'params' => array(
			

			array(
				'type' => 'select',
				'label' => esc_html__( 'Alignment', 'wolf-page-builder' ),
				'param_name' => 'alignment',
				'choices' => array(
					'center' => esc_html__( 'Center', 'wolf-page-builder' ),
					'left' => esc_html__( 'Left', 'wolf-page-builder' ),
					'right' => esc_html__( 'Right', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Type', 'wolf-page-builder' ),
				'param_name' => 'type',
				'choices' => array(
					'normal' => esc_html__( 'Normal', 'wolf-page-builder' ),
					'circle' => esc_html__( 'Circle', 'wolf-page-builder' ),
					'square' => esc_html__( 'Square', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Size', 'wolf-page-builder' ),
				'param_name' => 'size',
				'choices' => array(
					'2x' => esc_html__( 'Medium', 'wolf-page-builder' ),
					'1x' => esc_html__( 'Small', 'wolf-page-builder' ),
					'3x' => esc_html__( 'Large', 'wolf-page-builder' ),
					'4x' => esc_html__( 'Very Large', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Target', 'wolf-page-builder' ),
				'param_name' => 'target',
				'choices' => array(
					'',
					'_self',
					'_blank',
					'_parent',
				),
				'display' => true,
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Icon Color', 'wolf-page-builder' ),
				'param_name' => 'icon_color',
				'display' => true,
			),
		)
	)
);

$add_params = array();
foreach ( $wpb_team_member_socials as $social ) {
	$add_params[] = array(
		'type' => 'url',
		'label' => $social,
		'param_name' => $social,
		'placeholder' => 'http://',
	);
}
wpb_inject_param( 'wpb_socials_custom', $add_params );