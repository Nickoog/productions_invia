<?php
/**
 * Spacer dialog box
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */
$title = esc_html__( 'Height', 'wolf-page-builder' );
$params = array(

	array(
		'id' => 'height',
		'label' => esc_html__( 'Height', 'wolf-page-builder' ),
		'value' => '100px',
	),
);
echo wpb_generate_tinymce_popup( 'wpb_empty_space', $params, $title );