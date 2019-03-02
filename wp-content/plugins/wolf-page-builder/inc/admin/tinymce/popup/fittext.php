<?php
/**
 * Headline dialog box
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

$title = esc_html__( 'Headline', 'wolf-page-builder' );
$params = array(

	array(
		'id' => 'text',
		'label' => esc_html__( 'Text', 'wolf-page-builder' ),
		'placeholder' => esc_html__( 'My Cool Headline', 'wolf-page-builder' ),
	),

	array(
		'id' => 'max_font_size',
		'label' => esc_html__( 'Font Size', 'wolf-page-builder' ),
		'placeholder' => '48px',
	),

	array(
		'id' => 'letter_spacing',
		'label' => esc_html__( 'Letter Spacing', 'wolf-page-builder' ),
		'placeholder' => '3px',
	),

	array(
		'id' => 'font_family',
		'label' => esc_html__( 'Font Family', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => $font_list,
	),

	array(
		'id' => 'text_transform',
		'label' => esc_html__( 'Font Transform', 'wolf-page-builder' ),
		'type' => 'select',
		'options' => array(
			'uppercase' => esc_html__( 'uppercase', 'wolf-page-builder' ),
			'none' => esc_html__( 'none', 'wolf-page-builder' ),
		),
	),
);
echo wpb_generate_tinymce_popup( 'wpb_headline', $params, $title );
