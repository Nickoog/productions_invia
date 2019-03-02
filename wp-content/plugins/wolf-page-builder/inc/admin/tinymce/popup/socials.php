<?php
/**
 * Socials dialog box
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */
$title = esc_html__( 'Socials', 'wolf-page-builder' );
$params = array(

	array(
		'id' => 'services',
		'label' => esc_html__( 'Services', 'wolf-page-builder' ),
		'desc' => wp_kses(
			__( 'Leave empty to display them all.<br>* See the social networks available in the plugin options.', 'wolf-page-builder' ),
			array( 'br' => array() )
		),
		'placeholder' => 'facebook,twitter',
	),

	array(
		'id' => 'type',
		'label' => esc_html__( 'Type', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => array(
			'normal' => esc_html__( 'Normal', 'wolf-page-builder' ),
			'circle' => esc_html__( 'Circle', 'wolf-page-builder' ),
			'square' => esc_html__( 'Square', 'wolf-page-builder' ),
		),
	),

	array(
		'id' => 'size',
		'label' => esc_html__( 'Size', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => array(
			'1x' => esc_html__( 'Small', 'wolf-page-builder' ),
			'2x' => esc_html__( 'Medium', 'wolf-page-builder' ),
			'3x' => esc_html__( 'Large', 'wolf-page-builder' ),
			'4x' => esc_html__( 'Very Large', 'wolf-page-builder' ),
		),
	),
);
echo wpb_generate_tinymce_popup( 'wpb_socials', $params, $title );