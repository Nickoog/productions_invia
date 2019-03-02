<?php
/**
 * Sonic fonts
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_fonts_mods( $sonic_mods ) {

	$sonic_google_fonts = apply_filters( 'sonic_customizer_font_choices', sonic_get_google_fonts_options() );
	$sonic_font_choices = array( 'default' => esc_html__( 'Default', 'sonic' ) );

	foreach ( $sonic_google_fonts as $key => $value ) {
		$sonic_font_choices[ $key ] = $key;
	}

	$sonic_mods['fonts'] = array(
		'id' => 'fonts',
		'title' => esc_html__( 'Fonts', 'sonic' ),
		'icon' => 'editor-textcolor',
		'options' => array(),
	);

	$sonic_mods['fonts']['options']['body_font_name'] = array(
		'label' => esc_html__( 'Body Font Name', 'sonic' ),
		'id' => 'body_font_name',
		'type' => 'text',
		'description' => sprintf( wp_kses(
				__( 'A loaded google font or any <a href="%s" title="more infos" target="_blank">native browser fonts</a>.', 'sonic' ),
				array( 'a' => array( 'href' => array(), 'target' => array(), 'title' => array(), ), )
			),
			'http://www.w3schools.com/cssref/css_websafe_fonts.asp'
		),
	);

	/*************************Menu****************************/

	$sonic_mods['fonts']['options']['menu_font_size'] = array(
		'id' => 'menu_font_size',
		'label' => esc_html__( 'Menu Font Size for Desktop', 'sonic' ),
		'type' => 'text',
		//'transport' => 'postMessage',
	);

	$sonic_mods['fonts']['options']['menu_font_size_mobile'] = array(
		'id' => 'menu_font_size_mobile',
		'label' => esc_html__( 'Menu Font Size for Mobile', 'sonic' ),
		'type' => 'text',
		//'transport' => 'postMessage',
	);

	$sonic_mods['fonts']['options']['menu_font_name'] = array(
		'id' => 'menu_font_name',
		'label' => esc_html__( 'Menu Font', 'sonic' ),
		'type' => 'select',
		'choices' => $sonic_font_choices,
		//'transport' => 'postMessage',
	);

	$sonic_mods['fonts']['options']['menu_font_weight'] = array(
		'label' => esc_html__( 'Menu Font Weight', 'sonic' ),
		'id' => 'menu_font_weight',
		'type' => 'text',
	);

	$sonic_mods['fonts']['options']['menu_font_transform'] = array(
		'id' => 'menu_font_transform',
		'label' => esc_html__( 'Menu Font Transform', 'sonic' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'sonic' ),
			'uppercase' => esc_html__( 'Uppercase', 'sonic' ),
		),
		//'transport' => 'postMessage',
	);

	$sonic_mods['fonts']['options']['menu_font_style'] = array(
		'id' => 'menu_font_style',
		'label' => esc_html__( 'Menu Font Style', 'sonic' ),
		'type' => 'select',
		'choices' => array(
			'normal' => esc_html__( 'Normal', 'sonic' ),
			'italic' => esc_html__( 'Italic', 'sonic' )
		),
		//'transport' => 'postMessage',
	);

	$sonic_mods['fonts']['options']['menu_font_letter_spacing'] = array(
		'label' => esc_html__( 'Menu Letter Spacing (omit px)', 'sonic' ),
		'id' => 'menu_font_letter_spacing',
		'type' => 'int',
	);

	/*************************Heading****************************/

	$sonic_mods['fonts']['options']['heading_font_name'] = array(
		'id' => 'heading_font_name',
		'label' => esc_html__( 'Heading Font', 'sonic' ),
		'type' => 'select',
		'choices' => $sonic_font_choices,
		//'transport' => 'postMessage',
	);

	$sonic_mods['fonts']['options']['heading_font_weight'] = array(
		'label' => esc_html__( 'Heading Font weight', 'sonic' ),
		'id' => 'heading_font_weight',
		'type' => 'text',
		'description' => esc_html__( 'For example: 400 is normal, 700 is bold.The available font weights depend on the font. Leave empty to use the theme default style', 'sonic' ),
	);

	$sonic_mods['fonts']['options']['heading_font_transform'] = array(
		'id' => 'heading_font_transform',
		'label' => esc_html__( 'Heading Font Transform', 'sonic' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'sonic' ),
			'uppercase' => esc_html__( 'Uppercase', 'sonic' ),
		),
		//'transport' => 'postMessage',
	);

	$sonic_mods['fonts']['options']['heading_font_style'] = array(
		'id' => 'heading_font_style',
		'label' => esc_html__( 'Heading Font Style', 'sonic' ),
		'type' => 'select',
		'choices' => array(
			'normal' => esc_html__( 'Normal', 'sonic' ),
			'italic' => esc_html__( 'Italic', 'sonic' )
		),
		//'transport' => 'postMessage',
	);

	$sonic_mods['fonts']['options']['heading_font_letter_spacing'] = array(
		'label' => esc_html__( 'Heading Letter Spacing (omit px)', 'sonic' ),
		'id' => 'heading_font_letter_spacing',
		'type' => 'int',
	);

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_fonts_mods' );