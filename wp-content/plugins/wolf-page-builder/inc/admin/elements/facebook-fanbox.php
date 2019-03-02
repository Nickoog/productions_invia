<?php
/**
 * Facebook plugin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// check if the plugin is activated
if ( class_exists( 'Wolf_Facebook_Page_Box' ) ) {
	// Facebook Box Shortcode
	wpb_add_element(
		array(
			'name' => 'Facebook Page Box',
			'base' => 'wolf_facebook_page_box',
			'description' => esc_html__( 'Display a facebook fan box', 'wolf-page-builder' ),
			'category' => esc_html__( 'Social', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-facebook',
			'params' => array(

				array(
					'type' => 'text',
					'label' => esc_html__( 'Facebook Page URL', 'wolf-page-builder' ),
					'param_name' => 'page_url',
					'value' => wpb_get_option( 'socials', 'facebook' ),
					'display' => true,
				),

				array(
					'label' => esc_html__( 'Height', 'wolf-page-builder' ),
					'type' => 'int',
					'param_name' => 'height',
					'value' => 400,
					'display' => true,
				),

				array(
					'label' => esc_html__( 'Show posts', 'wolf-page-builder' ),
					'class' => 'wpb-col-6 wpb-first',
					'type' => 'checkbox',
					'param_name' => 'show_posts',
					'value' => 'true',
				),

				array(
					'label' => esc_html__( 'Show faces', 'wolf-page-builder' ),
					'class' => 'wpb-col-6 wpb-last',
					'type' => 'checkbox',
					'param_name' => 'show_faces',
					'value' => 'true',
				),

				array(
					'label' => esc_html__( 'Hide cover', 'wolf-page-builder' ),
					'class' => 'wpb-col-6 wpb-first',
					'type' => 'checkbox',
					'param_name' => 'hide_cover',
					'value' => 'true',
				),

				array(
					'label' => esc_html__( 'Small header', 'wolf-page-builder' ),
					'class' => 'wpb-col-6 wpb-last',
					'type' => 'checkbox',
					'param_name' => 'small_header',
					'value' => 'true',
				),
			)
		)
	);
}