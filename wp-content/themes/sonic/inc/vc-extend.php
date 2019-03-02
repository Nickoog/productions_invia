<?php
/**
 * Sonic Visual Composer Extend
 *
 * Add Visual Composer Compatiblity
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Vc_Manager' ) ) {
	return;
}

/* Removing unwanted parameters */
if ( function_exists( 'vc_remove_param' ) ) {
	//vc_remove_param( 'vc_row', 'full_width' );
}

// Content inner width 
vc_add_param( 'vc_row', array(
	'type' => 'dropdown',
	'class' => '',
	'show_settings_on_create' => true,
	'heading' => esc_html__( 'Content Type', 'sonic' ),
	'param_name' => 'content_type',
	'value' => array(
		sprintf( esc_html__( 'Standard width (%s centered)', 'sonic' ), '1140px' ) => 'standard',
		sprintf( esc_html__( 'Small width (%s centered)', 'sonic' ), '750px' ) => 'small',
		sprintf( esc_html__( 'Large width (%s centered)', 'sonic' ), '98%' ) => 'large',
		sprintf( esc_html__( 'Full width (%s)', 'sonic' ), '100%' ) => 'full',
	)
) );

// Padding top
vc_add_param( 'vc_row', array(
	'type' => 'textfield',
	'class' => '',
	'heading' => esc_html__( 'Padding top', 'sonic' ),
	'param_name' => 'padding_top',
	'description' => '',
	'value' => '50px',
) );

// Padding bottom
vc_add_param( 'vc_row', array(
	'type' => 'textfield',
	'class' => '',
	'heading' => esc_html__( 'Padding bottom', 'sonic' ),
	'param_name' => 'padding_bottom',
	'description' => '',
	'value' => '50px',
) );

// Font color
vc_add_param( 'vc_row', array(
	'type' => 'dropdown',
	'class' => '',
	'show_settings_on_create' => true,
	'heading' => esc_html__( 'Font Color', 'sonic' ),
	'param_name' => 'font_color',
	'value' => array(
		esc_html__( 'Dark', 'sonic' ) => 'dark',
		esc_html__( 'Light', 'sonic' ) => 'light',
	),
) );

// Overlay
vc_add_param( 'vc_row', array(
	'type' => 'dropdown',
	'class' => '',
	'show_settings_on_create' => true,
	'heading' => esc_html__( 'Add Overlay', 'sonic' ),
	'param_name' => 'overlay',
	'value' => array(
		esc_html__( 'No', 'sonic' ) => '',
		esc_html__( 'Yes', 'sonic' ) => 'yes',
	),
) );

// Overlay color
vc_add_param( 'vc_row', array(
	'type' => 'colorpicker',
	'class' => '',
	'show_settings_on_create' => true,
	'heading' => esc_html__( 'Overlay Color', 'sonic' ),
	'param_name' => 'overlay_color',
	'value' => '#000000',
	'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
) );

// Overlay opacity
vc_add_param( 'vc_row', array(
	'type' => 'textfield',
	'class' => '',
	'heading' => esc_html__( 'Overlay Opacity in Oercent', 'sonic' ),
	'param_name' => 'overlay_opacity',
	'description' => '',
	'value' => 40,
	'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
) );