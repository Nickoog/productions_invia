<?php
/**
 * Contact form
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'WPCF7_VERSION' ) ) { // check if the plugin is activated

	$choices = array();

	// get contact form posts
	$args = array(
		'post_type' => 'wpcf7_contact_form',
		'posts_per_page' => -1,
	);

	if ( $cf7_forms = get_posts( $args ) ){
		foreach( $cf7_forms as $cf7_form ){
			$choices[ $cf7_form->ID ] = $cf7_form->post_title;
		}
	}

	// Contact from 7
	wpb_add_element(
		array(
			'name' => esc_html__( 'Contactform7', 'wolf-page-builder' ),
			'description' => esc_html__( 'Add a contact form to your page', 'wolf-page-builder' ),
			'base' => 'contact-form-7',
			'category' => esc_html__( 'Content', 'wolf-page-builder' ),
			'icon' => 'wpb-icon wpb-contactform7',
			'params' => array(
				array(
					'type' => 'select',
					'label' => esc_html__( 'Contact Form', 'wolf-page-builder' ),
					'param_name' => 'id',
					'choices' => $choices,
					'display' => true,
				),
			)
		)
	);
}