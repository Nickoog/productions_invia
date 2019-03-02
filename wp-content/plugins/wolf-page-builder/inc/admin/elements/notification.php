<?php
/**
 * Notifications
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// message box
wpb_add_element(
	array(
		'name' => esc_html__( 'Notification', 'wolf-page-builder' ),
		'description' => esc_html__( 'A message box', 'wolf-page-builder' ),
		'base' => 'wpb_notification',
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'tags' => 'alert info message error box',
		'icon' => 'wpb-icon wpb-notification',
		'params' => array(

			array(
				'type' => 'select',
				'label' => esc_html__( 'Type', 'wolf-page-builder' ),
				'param_name' => 'type',
				'choices' => array(
					'success' => esc_html__( 'Success', 'wolf-page-builder' ),
					'info' => esc_html__( 'Info', 'wolf-page-builder' ),
					'alert' => esc_html__( 'Alert', 'wolf-page-builder' ),
					'error' => esc_html__( 'Error', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'textarea',
				'holder' => 'div',
				'label' => esc_html__( 'Message', 'wolf-page-builder' ),
				'param_name' => 'message',
				'value' => esc_html__( 'This is a notification message.', 'wolf-page-builder' ),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Display Icon', 'wolf-page-builder' ),
				'param_name' => 'display_icon',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
					'no' => esc_html__( 'No', 'wolf-page-builder' ),
				),
				'display' => true,
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Allow the visitor to dismiss the message', 'wolf-page-builder' ),
				'param_name' => 'close',
				'choices' => array(
					'no' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
				'display' => true,
			),
		),
	)
);