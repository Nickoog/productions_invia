<?php
/**
 * Music Network Plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Wolf_Music_Network' ) ) {
	wpb_add_element(
		array(
			'name' => esc_html__( 'Music Network', 'wolf-page-builder' ),
			'base' => 'wolf_music_network',
			'category' => esc_html__( 'Music', 'wolf-page-builder' ),
			'tags' => 'music',
			'description' => esc_html__( 'Display your music social network', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-music-network',
			'params' => array(

				array(
					'type' => 'int',
					'label' => esc_html__( 'Height', 'wolf-page-builder' ),
					'param_name' => 'height',
					'value' => 32,
				),

				array(
					'type' => 'select',
					'label' => esc_html__( 'Alignment', 'wolf-page-builder' ),
					'param_name' => 'align',
					'choices' => array(
						'center' => esc_html__( 'Centered', 'wolf-page-builder' ),
						'left' => esc_html__( 'Left', 'wolf-page-builder' ),
						'right' => esc_html__( 'Right', 'wolf-page-builder' ),
					),
				),

				array(
					'type' => 'text',
					'label' => esc_html__( 'Services', 'wolf-page-builder' ),
					'param_name' => 'services',
					'description' => esc_html__( 'separated by a comma (empty for all)', 'wolf-page-builder' ),
				),
			)
		)
	);
}