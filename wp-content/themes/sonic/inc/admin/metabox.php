<?php
/**
 * Sonic metaboxes
 *
 * Register metabox for the theme with the sonic_do_metaboxes function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_do_metaboxes' ) ) {
	/**
	 * Set theme metaboxes
	 *
	 * Allow to add specific style options for each page
	 *
	 * @since Sonic 1.0.0
	 */
	function sonic_do_metaboxes() {

		/* Header params */
		$sonic_header_metaboxes = array(
			'header_settings' => array(
				'title' => esc_html__( 'Header Options', 'sonic' ),
				'page' => apply_filters( 'sonic_header_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'we_event', 'theme_documentation', 'plugin_documentation' ) ),
				'help' => esc_html__( 'It will overwrite all other header image settings.', 'sonic' ),

				'metafields' => array(

					array(
						'label'	=> esc_html__( 'Header Background Type', 'sonic' ),
						'id'	=> '_post_bg_type',
						'type'	=> 'select',
						'choices' => array(
							'image' => esc_html__( 'Image', 'sonic' ),
							'video' => esc_html__( 'Video', 'sonic' ),
						),
					),

					array(
						'label'	=> esc_html__( 'Header Background', 'sonic' ),
						'id'	=> '_post_bg',
						'type'	=> 'background',
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'image' ) ),
					),

					array(
						'label'	=> esc_html__( 'Header Background Effect', 'sonic' ),
						'id'	=> '_post_bg_effect',
						'type'	=> 'select',
						'choices' => array(
							'zoomin' => esc_html__( 'Zoom', 'sonic' ),
							'parallax' => esc_html__( 'Parallax', 'sonic' ),
							'none' => esc_html__( 'None', 'sonic' ),
						),
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'image' ) ),
					),

					// array(
					// 	'label'	=> esc_html__( 'Header font color', 'sonic' ),
					// 	'id'	=> '_post_font_color',
					// 	'type'	=> 'select',
					// 	'choices' => array(
					// 		'' => esc_html__( 'Auto', 'sonic' ),
					// 		'dark' => esc_html__( 'Dark', 'sonic' ),
					// 		'light' => esc_html__( 'Light', 'sonic' ),
					// 	),
					// ),

					array(
						'label'	=> esc_html__( 'Video Background Type', 'sonic' ),
						'id'	=> '_post_video_bg_type',
						'type'	=> 'select',
						'choices' => array(
							'selfhosted' => esc_html__( 'Self hosted', 'sonic' ),
							'youtube' => 'Youtube',
						),
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'video' ) ),
					),

					array(
						'label'	=> esc_html__( 'YouTube URL', 'sonic' ),
						'id'	=> '_post_video_bg_youtube_url',
						'type'	=> 'text',
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'video' ) ),
					),

					array(
						'label'	=> esc_html__( 'Video Background', 'sonic' ),
						'id'	=> '_post_video_bg',
						'type'	=> 'video',
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'video' ) ),
					),

					array(
						'label'	=> esc_html__( 'Add Header Overlay', 'sonic' ),
						//'desc'   =>esc_html__( 'Is your image too light or too dark to read the text?', 'sonic' ),
						'id'	=> '_post_overlay',
						'type'	=> 'select',
						'choices' => array(
							'yes' => esc_html__( 'Yes', 'sonic' ),
							'' => esc_html__( 'No', 'sonic' ),
						),
					),

					array(
						'label'	=> esc_html__( 'Overlay Color', 'sonic' ),
						'id'	=> '_post_overlay_color',
						'type'	=> 'colorpicker',
						'value' 	=> '#000000',
						'dependency' => array( 'element' => '_post_overlay', 'value' => array( 'yes' ) ),
					),

					array(
						'label'	=> esc_html__( 'Overlay Opacity (in percent)', 'sonic' ),
						'id'	=> '_post_overlay_opacity',
						'desc'	=> esc_html__( 'Adapt the header overlay opacity if needed', 'sonic' ),
						'type'	=> 'int',
						'value'	=> 40,
						'dependency' => array( 'element' => '_post_overlay', 'value' => array( 'yes' ) ),
					),

				),
			),
		);

		$common_params = array(

				array(
					'label'	=> '',
					'id'	=> '_post_subheading',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Menu Style', 'sonic' ),
					'id'	=> '_post_menu_type',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'Default (set in the customizer)', 'sonic' ),
						'standard' => esc_html__( 'Solid', 'sonic' ),
						'semi-transparent' => esc_html__( 'Semi-transparent White', 'sonic' ),
						'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'sonic' ),
						'transparent' => esc_html__( 'Transparent', 'sonic' ),
						'absolute' => esc_html__( 'Solid in absolute position', 'sonic' ),
						'none' => esc_html__( 'Hide menu', 'sonic' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Page Header Type', 'sonic' ),
					'id'	=> '_post_header_type',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'Default (set in the customizer)', 'sonic' ),
						'standard' => esc_html__( 'Standard', 'sonic' ),
						'big' => esc_html__( 'Big', 'sonic' ),
						'small' => esc_html__( 'Small', 'sonic' ),
						'breadcrumb' => esc_html__( 'Breadcrumb', 'sonic' ),
						'none' => esc_html__( 'No header', 'sonic' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Hide Title', 'sonic' ),
					'id'	=> '_post_hide_title_text',
					'type'	=> 'checkbox',
				),
				
				array(
					'label'	=> esc_html__( 'Hide featured image on single post/page (if displayed)', 'sonic' ),
					'id'	=> '_post_hide_featured_image',
					'type'	=> 'checkbox',
				),

				array(
					'label'	=> esc_html__( 'Hide Footer', 'sonic' ),
					'id'	=> '_post_hide_footer',
					'type'	=> 'checkbox',
				),

				array(
					'label'	=> esc_html__( 'Custom CSS', 'sonic' ),
					'id'	=> '_post_css',
					'type'	=> 'textarea',
				),
		);
		
		/************** Page options ******************/
		$sonic_page_metaboxes = array(

			'meta_options' => array(
					
				'title' => esc_html__( 'Page Options', 'sonic' ),
				'page' => apply_filters( 'sonic_page_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'we_event', 'theme_documentation', 'plugin_documentation' ) ),
				'metafields' => array(),
			),
		);

		foreach ( $common_params as $param ) {
			$sonic_page_metaboxes['meta_options']['metafields'][] = $param;
		}
		
		/************** Post options ******************/
		$sonic_post_metaboxes = array(

			'meta_options' => array(
				'title' => esc_html__( 'Post Options', 'sonic' ),
				'page' => array( 'post' ),
				'metafields' => array(
					array(
						'label'	=> esc_html__( 'Post Layout', 'sonic' ),
						'id'	=> '_single_post_layout',
						'type'	=> 'select',
						'choices' => array(
							'small-width' => esc_html__( 'Standard', 'sonic' ),
							'full-width' => esc_html__( 'Full width', 'sonic' ),
							'sidebar' => esc_html__( 'Sidebar', 'sonic' ),
							'split' => esc_html__( 'Split', 'sonic' ),
						),
					),

					array(
						'label'	=> esc_html__( 'Thumbnail Size (for metro layout only)', 'sonic' ),
						'id'	=> '_single_post_metro_thumbnail_size',
						'type'	=> 'select',
						'choices' => array(
							'' => esc_html__( 'Auto (depends on post format)', 'sonic' ),
							'small-square' => esc_html__( 'Small square', 'sonic' ),
							'big-square' => esc_html__( 'Big square', 'sonic' ),
							'landscape' => esc_html__( 'Landscape', 'sonic' ),
							'portrait' => esc_html__( 'Portrait', 'sonic' ),
						),
					),
				),
			),
		);

		foreach ( $common_params as $param ) {
			$sonic_post_metaboxes['meta_options']['metafields'][] = $param;
		}

		/************** Gallery options ******************/
		$sonic_gallery_metaboxes = array(

			'meta_options' => array(
				'title' => esc_html__( 'Gallery Options', 'sonic' ),
				'page' => array( 'gallery' ),
				'metafields' => array(
					array(
						'label'	=> esc_html__( 'Gallery Layout', 'sonic' ),
						'id'	=> '_single_gallery_layout',
						'type'	=> 'select',
						'choices' => array(
							'standard' => esc_html__( 'Standard', 'sonic' ),
							'large-width' => esc_html__( 'Large width', 'sonic' ),
							'full-width' => esc_html__( 'Full window', 'sonic' ),
						),
					),
				),
			),
		);

		foreach ( $common_params as $param ) {
			$sonic_gallery_metaboxes['meta_options']['metafields'][] = $param;
		}

		/************** Portfolio options ******************/
		$sonic_work_metaboxes = array(

			'meta_options' => array(
				'title' => esc_html__( 'Work Options', 'sonic' ),
				'page' => array( 'work' ),
				'metafields' => array(
					array(
						'label'	=> esc_html__( 'Work Layout', 'sonic' ),
						'id'	=> '_single_work_layout',
						'type'	=> 'select',
						'choices' => array(
							'small-width' => esc_html__( 'Standard', 'sonic' ),
							'full-width' => esc_html__( 'Full width', 'sonic' ),
							'sidebar' => esc_html__( 'Sidebar', 'sonic' ),
							'split' => esc_html__( 'Split', 'sonic' ),
						),
					),
				),
			),
		);

		foreach ( $common_params as $param ) {
			$sonic_work_metaboxes['meta_options']['metafields'][] = $param;
		}
		
		$sonic_do_page_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'sonic_page_metaboxes',  $sonic_page_metaboxes ) );
		$sonic_do_post_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'sonic_post_metaboxes',  $sonic_post_metaboxes ) );
		$sonic_do_gallery_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'sonic_gallery_metaboxes',  $sonic_gallery_metaboxes ) );
		$sonic_do_work_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'sonic_work_metaboxes',  $sonic_work_metaboxes ) );
		$sonic_do_header_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'sonic_header_metaboxes',  $sonic_header_metaboxes ) );
		
	}

	sonic_do_metaboxes(); // do metaboxes
}