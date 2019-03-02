<?php
/**
 * Last Post Big Slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled_post_types = array();
$available_post_types = array( 
	'post' => esc_html__( 'Post', 'wolf-page-builder' ),
	'gallery' => esc_html__( 'Gallery', 'wolf-page-builder' ),
	'video' => esc_html__( 'Video', 'wolf-page-builder' ),
	'event' => esc_html__( 'Event', 'wolf-page-builder' ),
	'release' => esc_html__( 'Release', 'wolf-page-builder' ),
	'work' => esc_html__( 'Work', 'wolf-page-builder' ),
);

foreach ( $available_post_types as $post_type => $post_type_name ) {
	if ( post_type_exists( $post_type ) ) {
		$enabled_post_types[ $post_type ] = $post_type_name;
	}
}

wpb_add_element(
	array(
		'name' => esc_html__( 'Big Posts Slider', 'wolf-page-builder' ),
		'base' => 'wpb_posts_big_slider',
		'category' => esc_html__( 'Sliders', 'wolf-page-builder' ),
		'description' => esc_html__( 'Display your last posts in a slider', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-posts-slider',
		'params' => array(

			array(
				'type' => 'select',
				'label' => esc_html__( 'Post Type', 'wolf-page-builder' ),
				'param_name' => 'post_type',
				'choices' => $enabled_post_types,
				'display' => true,
			),
			
			array(
				'type' => 'text',
				'label' => esc_html__( 'Slider Height', 'wolf-page-builder' ),
				'description' => esc_html__( 'Enter a value in % or px', 'wolf-page-builder' ),
				'param_name' => 'slider_height',
				'value' => '650px',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Post IDs', 'wolf-page-builder' ),
				'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'wolf-page-builder' ),
				'param_name' => 'ids',
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Exclude Post IDs', 'wolf-page-builder' ),
				'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'wolf-page-builder' ),
				'param_name' => 'exclude_ids',
				'display' => true,
			),
			
			array(
				'type' => 'int',
				'label' => esc_html__( 'Count', 'wolf-page-builder' ),
				'param_name' => 'count',
				'description' => esc_html__( 'Number of post to display', 'wolf-page-builder' ),
				'placeholder' => 3,
				'display' => true,
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Category', 'wolf-page-builder' ),
				'param_name' => 'category',
				'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-page-builder' ),
				'placeholder' => esc_html__( 'my-category, other-category', 'wolf-page-builder' ),
				'display' => true,
				'dependency' => array( 'element' => 'post_type', 'value' => array( 'post' ) ),
			),

			array(
				'type' => 'text',
				'label' => esc_html__( 'Tags', 'wolf-page-builder' ),
				'param_name' => 'tag',
				'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'wolf-page-builder' ),
				'placeholder' => esc_html__( 'my-tag, other-tag', 'wolf-page-builder' ),
				'display' => true,
				'dependency' => array( 'element' => 'post_type', 'value' => array( 'post' ) ),
			),

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Hide Category', 'wolf-page-builder' ),
				'param_name' => 'hide_category',
				'class' => 'wpb-col-4 wpb-first',
				'display' => true,
				'dependency' => array( 'element' => 'post_type', 'value' => array( 'post' ) ),
			),

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Hide Tags', 'wolf-page-builder' ),
				'param_name' => 'hide_tag',
				'class' => 'wpb-col-4',
				'display' => true,
				'dependency' => array( 'element' => 'post_type', 'value' => array( 'post' ) ),
			),

			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Hide Author', 'wolf-page-builder' ),
				'param_name' => 'hide_author',
				'class' => 'wpb-col-4 wpb-last',
				'display' => true,
				'dependency' => array( 'element' => 'post_type', 'value' => array( 'post' ) ),
			),
		),
	)
);