<?php
/**
 * Last posts
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin/Elements
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$last_posts_params = array(

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
		'type' => 'text',
		'label' => esc_html__( 'Category', 'wolf-page-builder' ),
		'param_name' => 'category',
		'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'wolf-page-builder' ),
		'placeholder' => esc_html__( 'my-category, other-category', 'wolf-page-builder' ),
	),

	array(
		'type' => 'text',
		'label' => esc_html__( 'Tags', 'wolf-page-builder' ),
		'param_name' => 'tag',
		'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'wolf-page-builder' ),
		'placeholder' => esc_html__( 'my-tag, other-tag', 'wolf-page-builder' ),
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide Category', 'wolf-page-builder' ),
		'param_name' => 'hide_category',
		'class' => 'wpb-col-6 wpb-first',
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide Tags', 'wolf-page-builder' ),
		'param_name' => 'hide_tag',
		'class' => 'wpb-col-6 wpb-last',
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide Thumbnail Image', 'wolf-page-builder' ),
		'param_name' => 'hide_cover',
		'class' => 'wpb-col-6 wpb-first',
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide Author', 'wolf-page-builder' ),
		'param_name' => 'hide_author',
		'class' => 'wpb-col-6 wpb-last',
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide Text', 'wolf-page-builder' ),
		'param_name' => 'hide_summary',
	),
);

// Posts slider
wpb_add_element(
	array(
		'name' => esc_html__( 'Posts Slider', 'wolf-page-builder' ),
		'base' => 'wpb_posts_slider',
		'description' => esc_html__( 'Display your last posts in a slider', 'wolf-page-builder' ),
		'category' => esc_html__( 'Sliders', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-posts-slider',
		'params' => array(),
	)
);
wpb_inject_param( 'wpb_posts_slider', $last_posts_params );

// Posts preview
wpb_add_element(
	array(
		'name' => esc_html__( 'Posts Preview', 'wolf-page-builder' ),
		'base' => 'wpb_posts_preview',
		'description' => esc_html__( 'Display a sneak peak or your last posts', 'wolf-page-builder' ),
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-posts',
		'params' => array(),
	)
);
wpb_inject_param( 'wpb_posts_preview', $last_posts_params );

// Posts columns
wpb_add_element(
	array(
		'name' => esc_html__( 'Posts Columns', 'wolf-page-builder' ),
		'base' => 'wpb_posts_columns',
		'description' => esc_html__( 'Display your last posts in columns', 'wolf-page-builder' ),
		'category' => esc_html__( 'Content', 'wolf-page-builder' ),
		'icon' => 'wpb-icon wpb-posts',
		'params' => array(
			array(
				'type' => 'select',
				'label' => esc_html__( 'Columns', 'wolf-page-builder' ),
				'param_name' => 'columns',
				'description' => esc_html__( 'Number of column to display', 'wolf-page-builder' ),
				'display' => true,
				'choices' => array(
					3,2,4,5,6
				),
			),
		),
	)
);
wpb_inject_param( 'wpb_posts_columns', $last_posts_params );