<?php
/**
 * MailChimp
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wpb_add_element(
	array(
		'name' => esc_html__( 'MailChimp', 'wolf-page-builder' ),
		'base' => 'wpb_mailchimp',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'description' => esc_html__( 'Newsletter subscription form', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-mailchimp',
		'params' => array(
			array(
				'label' => esc_html__( 'List ID', 'wolf-page-builder' ),
				'param_name' => 'list',
				'description' => esc_html__( 'It can be found in your MailChimp account -> Lists -> Your List Name -> Settings -> List Name & default', 'wolf-page-builder' ),
				'value' => wpb_get_option( 'mailchimp', 'default_mailchimp_list_id' ),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Show Background', 'wolf-page-builder' ),
				'description' => esc_html__( 'You can set a background in the MailChimp plugin settings.', 'wolf-page-builder' ),
				'param_name' => 'use_bg',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
					'no' => esc_html__( 'No', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Size', 'wolf-page-builder' ),
				'param_name' => 'size',
				'choices' => array(
					'normal' => esc_html__( 'Normal', 'wolf-page-builder' ),
					'large' => esc_html__( 'Large', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Text Alignment', 'wolf-page-builder' ),
				'param_name' => 'text_alignment',
				'choices' => array(
					'center' => esc_html__( 'center', 'wolf-page-builder' ),
					'left' => esc_html__( 'left', 'wolf-page-builder' ),
					'right' => esc_html__( 'right', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Alignment', 'wolf-page-builder' ),
				'param_name' => 'alignment',
				'choices' => array(
					'center' => esc_html__( 'center', 'wolf-page-builder' ),
					'left' => esc_html__( 'left', 'wolf-page-builder' ),
					'right' => esc_html__( 'right', 'wolf-page-builder' ),
				),
				'display' => true,
			),
		),
	)
);