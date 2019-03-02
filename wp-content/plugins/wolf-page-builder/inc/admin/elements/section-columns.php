<?php
/**
 * Section columns
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

		'name' => esc_html__( 'Section with Columns', 'wolf-page-builder' ),
		'base' => 'section_columns',
		'icon' => 'wpb-icon wpb-section-columns',
		'params' => array(

			array(
				'type' => 'hidden',
				'param_name' => 'section_type',
				'value' => 'columns',
			),

			array(
				'type' => 'hidden',
				'param_name' => 'layout',
				'value' => '1-cols',
			),

			array(
				'type' => 'slug',
				'label' => esc_html__( 'Anchor', 'wolf-page-builder' ),
				'param_name' => 'anchor',
				'placeholder' => 'my-section',
				'description' => esc_html__( 'An unique identifier for your section.', 'wolf-page-builder' ),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Main Color Tone', 'wolf-page-builder' ),
				'param_name' => 'skin',
				'choices' => array(
					'dark' => esc_html__( 'Light', 'wolf-page-builder' ),
					'light' => esc_html__( 'Dark', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Padding Top', 'wolf-page-builder' ),
				'param_name' => 'padding_top',
				'placeholder' => '50px',
				'description' => esc_html__( 'Empty space above the content', 'wolf-page-builder' ),
			),

			array(
				'type' => 'text',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Padding Bottom', 'wolf-page-builder' ),
				'param_name' => 'padding_bottom',
				'placeholder' => '50px',
				'description' => esc_html__( 'Empty space below the content', 'wolf-page-builder' ),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Margin', 'wolf-page-builder' ),
				'param_name' => 'margin',
				'placeholder' => '0',
				'description' => esc_html__( 'Empty space around the content (supports CSS format like 0px 0px 0px 0px)', 'wolf-page-builder' ),
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Background', 'wolf-page-builder' ),
				'param_name' => 'background_type',
				'choices' => array(
					'none' => esc_html__( 'Default', 'wolf-page-builder' ),
					'image' => esc_html__( 'Image', 'wolf-page-builder' ),
					'video' => esc_html__( 'Video', 'wolf-page-builder' ),
					'slideshow' => esc_html__( 'Slideshow', 'wolf-page-builder' ),
					'transparent' => esc_html__( 'Transparent', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Full Height', 'wolf-page-builder' ),
				'param_name' => 'full_height',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'checkbox',
				// 'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Add pointing down arrow', 'wolf-page-builder' ),
				'description' => esc_html__( 'Allow user to scroll to the next section when clicking on the arrow', 'wolf-page-builder' ),
				'param_name' => 'arrow_down',
				'dependency' => array( 'element' => 'full_height', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'select',
				// 'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Arrow Style (if set above)', 'wolf-page-builder' ),
				'param_name' => 'arrow_down_style',
				'choices' => array(
					'round' => esc_html__( 'Round', 'wolf-page-builder' ),
					'square' => esc_html__( 'Square', 'wolf-page-builder' ),
				),
				'dependency' => array( 'element' => 'full_height', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'text',
				// 'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Arrow Caption', 'wolf-page-builder' ),
				'param_name' => 'arrow_down_text',
				'placeholder' => esc_html__( 'Continue', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'full_height', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'background',
				'label' => esc_html__( 'Background', 'wolf-page-builder' ),
				'param_name' => 'background',
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
			),

			array(
				'type' => 'select',
				'style' => 'margin-top:-30px;margin-bottom:40px;',
				'label' => esc_html__( 'Background Effect', 'wolf-page-builder' ),
				'param_name' => 'background_effect',
				'choices' => array(
					'' => esc_html__( 'None', 'wolf-page-builder' ),
					'parallax' => esc_html__( 'Parallax', 'wolf-page-builder' ),
				),
				'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
			),

			// array(
			// 	'type' => 'select',
			// 	'style' => 'margin-top:-30px;margin-bottom:40px;',
			// 	'label' => esc_html__( 'Add Parallax', 'wolf-page-builder' ),
			// 	'param_name' => 'parallax',
			// 	'choices' => array(
			// 		'' => esc_html__( 'No', 'wolf-page-builder' ),
			// 		'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
			// 	),
			// 	'dependency' => array( 'element' => 'background_type', 'value' => array( 'image' ) ),
			// ),

			// array(
			// 	'type' => 'image',
			// 	'label' => esc_html__( 'Background', 'wolf-page-builder' ),
			// 	'param_name' => 'parallax_img',
			// 	'dependency' => array( 'element' => 'parallax', 'value' => array( 'yes' ) ),
			// ),

			array(
				'type' => 'video_background',
				'label' => esc_html__( 'Video Background', 'wolf-page-builder' ),
				'param_name' => 'video_bg',
				'dependency' => array( 
					'element' => 'background_type', 
					'value' => array( 'video' ),
				),
			),

			// array(
			// 	'type' => 'checkbox',
			// 	'label' => esc_html__( 'Video background controls', 'wolf-page-builder' ),
			// 	'param_name' => 'video_bg_controls',
			// 	'dependency' => array( 
			// 		'element' => 'background_type', 
			// 		'value' => array( 'video' ),
			// 	),
			// ),

			array(
				'type' => 'multiple_images',
				'label' => esc_html__( 'Slideshow Images', 'wolf-page-builder' ),
				'param_name' => 'slideshow_img_ids',
				'dependency' => array( 
					'element' => 'background_type', 
					'value' => array( 'slideshow' ),
				),
			),

			array(
				'type' => 'int',
				'label' => esc_html__( 'Slideshow Speed (in ms)', 'wolf-page-builder' ),
				'param_name' => 'slideshow_speed',
				'dependency' => array( 
					'element' => 'background_type', 
					'value' => array( 'slideshow' ),
				),
				'value' => 4000,
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-first',
				'label' => esc_html__( 'Add Overlay', 'wolf-page-builder' ),
				'param_name' => 'overlay',
				'choices' => array(
					'' => esc_html__( 'No', 'wolf-page-builder' ),
					'yes' => esc_html__( 'Yes', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'select',
				'class' => 'wpb-col-6 wpb-last',
				'label' => esc_html__( 'Section Visibility', 'wolf-page-builder' ),
				'param_name' => 'hide_class',
				'choices' => array(
					'' => esc_html__( 'Always visible', 'wolf-page-builder' ),
					'wpb-hide-tablet' => esc_html__( 'Hide on tablet and mobile', 'wolf-page-builder' ),
					'wpb-hide-mobile' => esc_html__( 'Hide on mobile', 'wolf-page-builder' ),
					'wpb-show-tablet' => esc_html__( 'Show on tablet and mobile only', 'wolf-page-builder' ),
					'wpb-show-mobile' => esc_html__( 'Show on mobile only', 'wolf-page-builder' ),
					'wpb-hide' => esc_html__( 'Always hidden', 'wolf-page-builder' ),
				),
			),

			array(
				'type' => 'colorpicker',
				'label' => esc_html__( 'Overlay Color', 'wolf-page-builder' ),
				'param_name' => 'overlay_color',
				'value' => '#000000',
				'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'image',
				'label' => esc_html__( 'Overlay Pattern', 'wolf-page-builder' ),
				'param_name' => 'overlay_image',
				// 'description' => esc_html__( 'A repeatable image', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Overlay Opacity in Percent', 'wolf-page-builder' ),
				'param_name' => 'overlay_opacity',
				'value' => '40',
				'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'select',
				'label' => esc_html__( 'Advanced Settings', 'wolf-page-builder' ),
				'param_name' => 'show_advanced_settings',
				'choices' => array(
					'hide' => esc_html__( 'Hide', 'wolf-page-builder' ),
					'show' => esc_html__( 'Show', 'wolf-page-builder' ),
				),
			),
			array(
				'type' => 'slug',
				'label' => esc_html__( 'Extra Class', 'wolf-page-builder' ),
				'param_name' => 'extra_class',
				'placeholder' => '.my-class',
				'description' => esc_html__( 'Optional additional CSS class to add to the section', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'show_advanced_settings', 'value' => array( 'show' ) ),
			),

			array(
				'type' => 'inline_css',
				'label' => esc_html__( 'Inline Style', 'wolf-page-builder' ),
				'param_name' => 'inline_style',
				'placeholder' => 'margin-top:15px;',
				'description' => esc_html__( 'Additional inline CSS style', 'wolf-page-builder' ),
				'dependency' => array( 'element' => 'show_advanced_settings', 'value' => array( 'show' ) ),
			),
		)
	)
);