<?php
/**
 * Sonic category metaboxes
 *
 * Register category metabox for the theme with the sonic_do_category_metaboxes function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_do_category_metaboxes' ) ) {
	/**
	 * Set theme metaboxes
	 *
	 * Allow to add specific style options for each page
	 * @since Sonic 1.0.0
	 */
	function sonic_do_category_metaboxes() {
		$category_metaboxes = array(
			array(
				'label' => esc_html__( 'Blog layout', 'sonic' ),
				'id' =>'blog_layout',
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default (set in the customizer options)', 'sonic' ),
					'standard' => esc_html__( 'Standard', 'sonic' ),
					'fullwidth' => esc_html__( 'Full width', 'sonic' ),
					'sidebar-left' => esc_html__( 'Sidebar at left', 'sonic' ),
					'sidebar-right' => esc_html__( 'Sidebar at right', 'sonic' ),
				),
			),

			array(
				'label' => esc_html__( 'Blog display', 'sonic' ),
				'id' =>'blog_display',
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default (set in the customizer options)', 'sonic' ),
					'standard' => esc_html__( 'Standard', 'sonic' ),
					'classic' => esc_html__( 'Classic', 'sonic' ),
					'grid' => esc_html__( 'Square grid', 'sonic' ),
					'column' => esc_html__( 'Columns', 'sonic' ),
					'masonry' => esc_html__( 'Masonry', 'sonic' ),
					'metro' => esc_html__( 'Metro', 'sonic' ),
					'medium-image' => esc_html__( 'Medium image', 'sonic' ),
					'photo' => esc_html__( 'Photo', 'sonic' ),
				),
			),

			array(
				'id' => 'blog_grid_padding',
				'label' => esc_html__( 'Padding (for grid style display only)', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'sonic' ),
					'no' => esc_html__( 'No', 'sonic' ),
				),
				'transport' => 'postMessage',
			),
		);
		$sonic_do_category_metaboxes = new Wolf_Theme_Admin_Category_Meta( $category_metaboxes );
	}
	//sonic_do_category_metaboxes();
}