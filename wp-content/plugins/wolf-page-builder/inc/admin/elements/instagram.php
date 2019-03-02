<?php
/**
 * Instagram plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Instagram' ) ) {
	// Instagram Shortcode
	wpb_add_element(
		array(
			'name' => esc_html__( 'Instagram Gallery', 'wolf-page-builder' ),
			'base' => 'wolf_instagram_gallery',
			'description' => esc_html__( 'Your last instagram photos', 'wolf-page-builder' ),
			'category' => esc_html__( 'Medias', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-instagram',
			'params' => array(
				array(
					'type' => 'int',
					'label' => esc_html__( 'Image Count', 'wolf-page-builder' ),
					'description' => esc_html__( 'A multiple of 6 is recommended. Note that the instagram API may limit the number of image to display', 'wolf-page-builder' ),
					'param_name' => 'count',
					'value' => 18,
					'display' => true,
				),

				array(
					'type' => 'checkbox',
					'label' => esc_html__( 'Display follow button', 'wolf-page-builder' ),
					'param_name' => 'button',
					'display' => true,
				),
			)
		)
	);
}
