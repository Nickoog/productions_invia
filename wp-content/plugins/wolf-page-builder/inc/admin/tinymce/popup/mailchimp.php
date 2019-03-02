<?php
/**
 * Mailchimp dialog box
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */
$title = esc_html__( 'Mailchimp signup', 'wolf-page-builder' );
$params = array(

	array(
		'id' => 'list',
		'label' => esc_html__( 'List', 'wolf-page-builder' ),
		'desc' => esc_html__( 'Your mailchimp list ID.', 'wolf-page-builder' ),
		'placeholder' => 'mb0sd78fg8',
	),

	array(
		'id' => 'size',
		'label' => esc_html__( 'Size', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => array(
			'normal' => esc_html__( 'Normal', 'wolf-page-builder' ),
			'large' => esc_html__( 'Large', 'wolf-page-builder' ),
		),
	),

	array(
		'id' => 'submit',
		'label' => esc_html__( 'Submit', 'wolf-page-builder' ),
		'placeholder' => 'Submit',
	),
);
echo wpb_generate_tinymce_popup( 'wpb_mailchimp', $params, $title );