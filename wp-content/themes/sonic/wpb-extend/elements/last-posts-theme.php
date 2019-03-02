<?php
/**
 * Last posts with the theme display option
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$last_posts_theme_params = array(

	'count' => array(
		'type' => 'int',
		'label' => esc_html__( 'Count', 'sonic' ),
		'param_name' => 'count',
		'description' => esc_html__( 'Number of post to display', 'sonic' ),
		'value' => 4,
		'display' => true,
	),

	'columns' => array(
		'type' => 'select',
		'label' => esc_html__( 'Columns', 'sonic' ),
		'param_name' => 'columns',
		'choices' => array( 4,3,2,6 ),
		'display' => true,
	),

	'padding' => array(
		'type' => 'select',
		'label' => esc_html__( 'Padding', 'sonic' ),
		'param_name' => 'padding',
		'choices' => array(
			'yes' => esc_html__( 'Yes', 'sonic' ),
			'no' => esc_html__( 'No', 'sonic' ),
		),
		'display' => true,
	),

	array(
		'type' => 'text',
		'label' => esc_html__( 'Post IDs', 'sonic' ),
		'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'sonic' ),
		'param_name' => 'ids',
		'display' => true,
	),

	array(
		'type' => 'text',
		'label' => esc_html__( 'Exclude Post IDs', 'sonic' ),
		'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'sonic' ),
		'param_name' => 'exclude_ids',
		'display' => true,
	),

	array(
		'type' => 'text',
		'label' => esc_html__( 'Category', 'sonic' ),
		'param_name' => 'category',
		'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'sonic' ),
		'placeholder' => esc_html__( 'my-category, other-category', 'sonic' ),
	),

	array(
		'type' => 'text',
		'label' => esc_html__( 'Tags', 'sonic' ),
		'param_name' => 'tag',
		'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'sonic' ),
		'placeholder' => esc_html__( 'my-tag, other-tag', 'sonic' ),
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide category', 'sonic' ),
		'param_name' => 'hide_category',
		'class' => 'wpb-col-6 wpb-first',
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide tags', 'sonic' ),
		'param_name' => 'hide_tag',
		'class' => 'wpb-col-6 wpb-last',
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide thumbnail image', 'sonic' ),
		'param_name' => 'hide_cover',
		'class' => 'wpb-col-6 wpb-first',
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide author', 'sonic' ),
		'param_name' => 'hide_author',
		'class' => 'wpb-col-6 wpb-last',
	),

	array(
		'type' => 'checkbox',
		'label' => esc_html__( 'Hide text', 'sonic' ),
		'param_name' => 'hide_summary',
	),
);

$last_posts_elements_type = array( 
	'grid2' => esc_html__( 'Grid', 'sonic' ),
	'grid' => esc_html__( 'Square Grid', 'sonic' ),
	'grid3' => esc_html__( 'Portrait Grid', 'sonic' ),
	'photo' => esc_html__( 'Photo Style', 'sonic' ),
	'classic' =>  esc_html__( 'Classic', 'sonic' ),
);

// insert elements for each post display type
foreach ( $last_posts_elements_type as $type => $title ) {

	if ( 'classic' == $type ) {
		unset( $last_posts_theme_params['columns'] );
		unset( $last_posts_theme_params['padding'] );
	}

	/**
	 * Now we use a filter to add our shortcode to the plugin
	 * Don't need to have a custom prefix anymore (previously wpb_theme_posts_) as the shortode function
	 * is fired via the plugin
	 */
	$prefix = ( version_compare( WPB_VERSION, '2.3.2', '<' ) ) ? 'wpb_theme_posts_' : 'wpb_posts_';

	wpb_add_element(
		array(
			'name' => sprintf( esc_html__( 'Posts %s', 'sonic' ), $title ),
			'base' => $prefix . $type,
			'description' => sprintf( esc_html__( 'Display your posts with the %s display type', 'sonic' ), $title ),
			'category' => esc_html__( 'Content', 'sonic' ),
			'icon' => 'wpb-icon wpb-posts',
			'params' => array(),
		)
	);

	wpb_inject_param( $prefix . $type , $last_posts_theme_params );
}