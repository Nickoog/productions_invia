<?php
/**
 * Google map
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Google map
wpb_add_element(
	array(
		'name' => esc_html__( 'Map', 'wolf-page-builder' ),
		'base' => 'wpb_google_map',
		'description' => esc_html__( 'Display a Google map', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-map',
		'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
		'tags' => 'google location',
		'params' => array(

			array(
				'type' => 'textarea_html',
				'label' => esc_html__( 'Google Map Embed Code', 'wolf-page-builder' ),
				'param_name' => 'html',
				// 'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d20238.607321029885!2d3.0885784999999997!3d50.64892415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sfr!4v1446653817778" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>',
				'placeholder' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d84484.06865363916!2d7.762094!3d48.56911355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4796c8495e18b2c1%3A0x971a483118e7241f!2sStrasbourg%2C+France!5e0!3m2!1sfr!2sru!4v1435838798968" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>',
				'description' => sprintf(
					wp_kses(
						__( 'Find your map embed code on <a href="%1$s" target="_blank">Google Map</a>. More instructions <a href="%2$s" target="_blank">here</a>.', 'wolf-page-builder' ),
						array(
							'a' => array(
								'href' => array(),
								'target' => array(),
							) 
						)
					),
					'https://www.google.com/maps/',
					'http://assets.cdn.wolfthemes.com/help/google-map.jpg'
				),
			),

			array(
				'type' => 'int',
				'label' => esc_html__( 'Map Height', 'wolf-page-builder' ),
				'description' => esc_html__( 'in pixel', 'wolf-page-builder' ),
				'param_name' => 'height',
				'value' => 250,
				'display' => true,
			),
		),
	)
);