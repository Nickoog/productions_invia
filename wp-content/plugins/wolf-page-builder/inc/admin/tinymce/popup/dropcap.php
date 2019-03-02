<?php
/**
 * Dropcap dialog box
 *
 * @class WPB_Admin
 * @author WolfThemes
 * @category Admin
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */
$font_list = array( '' => esc_html__( 'Default heading font', 'wolf-page-builder' ) );
$wpb_google_fonts = wpb_get_google_fonts_options();

foreach ( $wpb_google_fonts as $key => $value ) {
	$font_list[ $key ] = $key;
}

$title = esc_html__( 'Dropcap', 'wolf-page-builder' );
$params = array(

	array(
		'id' => 'text',
		'label' => esc_html__( 'Letter', 'wolf-page-builder' ),
	),

	array(
		'id' => 'font',
		'label' => esc_html__( 'Font Family', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => $font_list,
	),
);
echo wpb_generate_tinymce_popup( 'wpb_dropcap', $params, $title );