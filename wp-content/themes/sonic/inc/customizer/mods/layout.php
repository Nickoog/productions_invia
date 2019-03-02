<?php
/**
 * Sonic layout
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_layout_mods( $sonic_mods ) {

	$sonic_mods['layout'] = array(

		'id' => 'layout',
		'title' => esc_html__( 'Layout', 'sonic' ),
		'icon' => 'layout',
		// 'description' => esc_html__( 'The accent color used for links and keypoints', 'sonic' ),
		'options' => array(

			'site_layout' => array(
				'id' => 'site_layout',
				'label' => esc_html__( 'Site Layout', 'sonic' ),
				'type' => 'select',
				'default' => 'wide',
				'choices' => array(
					'wide' => esc_html__( 'Wide', 'sonic' ),
					'boxed' => esc_html__( 'Boxed', 'sonic' ),
					'frame' => esc_html__( 'Frame', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			'site_width' => array(
				'id' => 'site_width',
				'label' => esc_html__( 'Site Width for Boxed Layout', 'sonic' ),
				'type' => 'text',
				'description' => esc_html__( 'Set the width of the site wrapper here if your layout is set to "boxed" above', 'sonic' )
			),

			'site_margin' => array(
				'id' => 'site_margin',
				'label' => esc_html__( 'Site Margin for Frame Layout', 'sonic' ),
				'type' => 'text',
				'description' => sprintf( esc_html__( 'Supports CSS format like %s', 'sonic' ), '0px 0px 0px 0px' ),
			),

			'text_link_style' => array(
				'id' => 'text_link_style',
				'label' => esc_html__( 'Text Link Style', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'colored' => esc_html__( 'Colored', 'sonic' ),
					'colored_hover' => esc_html__( 'Colored on hover', 'sonic' ),
				),
				//'transport' => 'postMessage',
			),

			'button_style' => array(
				'id' => 'button_style',
				'label' => esc_html__( 'Button Style', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'default' => esc_html__( 'Default', 'sonic' ),
					'square' => esc_html__( 'Square', 'sonic' ),
					'round' => esc_html__( 'Round', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			'lightbox' => array(
				'id' => 'lightbox',
				'label' => esc_html__( 'Lightbox', 'sonic' ),
				'type' => 'select',
				'default' => 'swipebox',
				'choices' => array(
					'swipebox' => 'swipebox',
					'fancybox' => 'fancybox',
					'' => esc_html__( 'None', 'sonic' ),
				),
				//'transport' => 'postMessage',
			),

			'do_lazyload' => array(
				'id' => 'do_lazyload',
				'label' => esc_html__( 'Lazyload images if possible', 'sonic' ),
				'type' => 'checkbox',
			),
		),
	);

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_layout_mods' );