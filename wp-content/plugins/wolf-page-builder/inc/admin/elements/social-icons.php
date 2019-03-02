<?php
/**
 * Social icons
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Social icons
wpb_add_element(
	array(
		'name' => esc_html__( 'Social Icons', 'wolf-page-builder' ),
		'base' => 'wpb_socials',
		'icon' => 'wpb-icon wpb-social-icons',
		'description' => esc_html__( 'A set of icons linked to your social profiles', 'wolf-page-builder' ),
		'category' => esc_html__( 'Social', 'wolf-page-builder' ),
		'params' => array(

			array(
				'type' => 'text',
				'label' => esc_html__( 'Services', 'wolf-page-builder' ),
				'param_name' => 'services',
				'placeholder' => 'facebook,twitter,instagram',
				'description' => sprintf(
					wp_kses(
						__( 'Enter the service names separated by a comma. Leave empty to display them all.<br>You can set your profiles in the <a href="%s" target="_blank">plugin settings</a>.', 'wolf-page-builder' ),
						array( 'br' => array(), 'a' => array( 'href' => array(), 'target' => array() ) )
					),
					esc_url( admin_url( 'admin.php?page=wpb-settings' ) )
				),
				'display' => true,
			),

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
				'label' => esc_html__( 'Icon color', 'wolf-page-builder' ),
				'param_name' => 'icon_color',
				'display' => true,
			),
		)
	)
);