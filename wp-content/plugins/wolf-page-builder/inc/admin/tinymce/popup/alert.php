<?php
/**
 * Notification dialog box
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */
$title = esc_html__( 'Notification', 'wolf-page-builder' );
$params = array(

	array(
		'id' => 'message',
		'label' => esc_html__( 'Message', 'wolf-page-builder' ),
		'placeholder' => esc_html__( 'Your notification message', 'wolf-page-builder' )
	),

	array(
		'id' => 'type',
		'label' => esc_html__( 'Type', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => array(
			'success' => esc_html__( 'success', 'wolf-page-builder' ),
			'info' => esc_html__( 'info', 'wolf-page-builder' ),
			'tip' => esc_html__( 'tip', 'wolf-page-builder' ),
			'error' => esc_html__( 'error', 'wolf-page-builder' ),
		),
	)
);
echo wpb_generate_tinymce_popup( 'wpb_alert_message', $params, $title );