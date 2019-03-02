<?php
/**
 * Team member
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpb_animations;

wpb_add_element(
	array(
		'name' => esc_html__( 'Team Member', 'wolf-page-builder' ),
		'base' => 'wpb_team_member',
		'icon' => 'wpb-icon wpb-team-member',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'tags' => 'team band',
		'description' => esc_html__( 'Present your staff members', 'wolf-page-builder' ),
		'params' => array(
			array(
				'type' => 'image',
				'label' => esc_html__( 'Photo', 'wolf-page-builder' ),
				'param_name' => 'image',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Image Size', 'wolf-page-builder' ),
				'param_name' => 'image_size',
				'choices' => $wpb_image_sizes,
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings ', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Name', 'wolf-page-builder' ),
				'param_name' => 'name',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Role', 'wolf-page-builder' ),
				'param_name' => 'role',
				'display' => true,
			),

			array(
				'type' => 'textarea',
				'label' => esc_html__( 'Description', 'wolf-page-builder' ),
				'param_name' => 'tagline',
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Image Style', 'wolf-page-builder' ),
				'param_name' => 'image_style',
				'choices' => array(
					'default' => esc_html__( 'default', 'wolf-page-builder' ),
					'round' => esc_html__( 'round', 'wolf-page-builder' ),
					'shadow' => esc_html__( 'shadow', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Text Alignment', 'wolf-page-builder' ),
				'param_name' => 'alignment',
				'choices' => array(
					'center' => esc_html__( 'center', 'wolf-page-builder' ),
					'left' => esc_html__( 'left', 'wolf-page-builder' ),
					'right' => esc_html__( 'right', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Title Tag', 'wolf-page-builder' ),
				'param_name' => 'title_tag',
				'choices' => array(
					'h3',
					'span',
					'h1',
					'h2',
					'h4',
					'h5',
					'h6',
				),
			),
		)
	)
);

wpb_inject_param( 'wpb_team_member', array(
		array(
			'type' => 'select',
			'label' => esc_html__( 'Add Social Profiles', 'wolf-page-builder' ),
			'param_name' => 'show_socials',
			'choices' => array(
				'hide' => esc_html__( 'No', 'wolf-page-builder' ),
				'show' => esc_html__( 'Yes', 'wolf-page-builder' ),
			),
		),
	)
);

global $wpb_team_member_socials;

$add_params = array();
foreach ( $wpb_team_member_socials as $social ) {
	$add_params[] = array(
		'type' => 'url',
		'label' => $social,
		'param_name' => $social,
		'placeholder' => 'http://',
		'dependency' => array( 'element' => 'show_socials', 'value' => array( 'show' ) ),
	);
}
wpb_inject_param( 'wpb_team_member', $add_params );