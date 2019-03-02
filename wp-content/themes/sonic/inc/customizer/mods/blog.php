<?php
/**
 * Sonic blog
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_blog_mods( $sonic_mods ) {

	$sonic_mods['blog'] = array(
		'id' => 'blog',
		'icon' => 'welcome-write-blog',
		'title' => esc_html__( 'Blog', 'sonic' ),
		'options' => array(

			'blog_layout' => array(
				'id' =>'blog_layout',
				'label' => esc_html__( 'Blog Layout', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'sonic' ),
					'fullwidth' => esc_html__( 'Full width', 'sonic' ),
					'sidebar-right' => esc_html__( 'Sidebar at right', 'sonic' ),
					'sidebar-left' => esc_html__( 'Sidebar at left', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			'blog_display' => array(
				'id' =>'blog_display',
				'label' => esc_html__( 'Blog Display', 'sonic' ),
				'type' => 'select',
				'choices' => apply_filters( 'sonic_blog_display_options', array(
					'classic' => esc_html__( 'Classic', 'sonic' ),
					'grid2' => esc_html__( 'Grid', 'sonic' ),
				) ),
			),

			'blog_more_link_type' => array(
				'id' => 'blog_more_link_type',
				'label' => esc_html__( 'More Link Type', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'wolf-button' => esc_html__( 'Button', 'sonic' ),
					'wolf-more-text' => esc_html__( 'Text', 'sonic' ),
				),
				//'transport' => 'postMessage',
			),

			'blog_category_filter' => array(
				'label' => esc_html__( 'Display category filter for the masonry, metro and photo display', 'sonic' ),
				'id' => 'blog_category_filter',
				'type' => 'checkbox',
			),

			'blog_infinitescroll' => array(
				'label' => esc_html__( 'Infinite scroll', 'sonic' ),
				'id' => 'blog_infinitescroll',
				'type' => 'checkbox',
			),

			'blog_infinitescroll_trigger' => array(
				'label' => esc_html__( 'Trigger infinite scroll with button', 'sonic' ),
				'id' => 'blog_infinitescroll_trigger',
				'type' => 'checkbox',
			),

			'blog_grid_padding' => array(
				'id' => 'blog_grid_padding',
				'label' => esc_html__( 'Padding (for grid style display only)', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'sonic' ),
					'no' => esc_html__( 'No', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			'blog_post_navigation_type' => array(
				'id' =>'blog_post_navigation_type',
				'label' => esc_html__( 'Blog Single Post Navigation Type', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Previous and next post', 'sonic' ),
					'related' => esc_html__( 'Related posts', 'sonic' ),
					'both' => esc_html__( 'Standard navigation + Related posts', 'sonic' ),
					'none' => esc_html__( 'No Navigation', 'sonic' ),
				),
			),

			'date_format' => array(
				'id' =>'date_format',
				'label' => esc_html__( 'Date Format', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'sonic' ),
					'human_diff' => esc_html__( 'Differential ( e.g: 10 days ago )', 'sonic' ),
				),
			),

			'blog_hide_date' => array(
				'label' => esc_html__( 'Hide date', 'sonic' ),
				'id' => 'blog_hide_date',
				'type' => 'checkbox',
			),

			'blog_hide_author' => array(
				'label' => esc_html__( 'Hide author', 'sonic' ),
				'id' => 'blog_hide_author',
				'type' => 'checkbox',
			),

			'blog_hide_category' => array(
				'label' => esc_html__( 'Hide category', 'sonic' ),
				'id' => 'blog_hide_category',
				'type' => 'checkbox',
			),

			'blog_hide_tags' => array(
				'label' => esc_html__( 'Hide tags', 'sonic' ),
				'id' => 'blog_hide_tags',
				'type' => 'checkbox',
			),

			'blog_hide_comments_count' => array(
				'label' => esc_html__( 'Hide comments count', 'sonic' ),
				'id' => 'blog_hide_comments_count',
				'type' => 'checkbox',
			),

			'blog_hide_views' => array(
				'label' => esc_html__( 'Hide views', 'sonic' ),
				'id' => 'blog_hide_views',
				'type' => 'checkbox',
			),

			'blog_hide_likes' => array(
				'label' => esc_html__( 'Hide likes', 'sonic' ),
				'id' => 'blog_hide_likes',
				'type' => 'checkbox',
			),
		),
	);


	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_blog_mods' );