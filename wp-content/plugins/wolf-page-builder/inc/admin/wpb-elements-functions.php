<?php
/**
 * Wolf Page Builder elements Functions
 *
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/Admin
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize elements array
 */
global $wpb_elements;
$wpb_elements = ( isset( $wpb_elements ) ) ? $wpb_elements : array();

/**
 * Add an element to the list
 *
 * @param array $args
 */
function wpb_add_element( $args ) {
	global $wpb_elements;
	$wpb_elements[ $args['base'] ] = $args;
}

/**
 * Add a parameter to an element
 *
 * @param string $base
 * @param array $new_params
 */
function wpb_inject_param( $base, $new_params = array() ) {
	global $wpb_elements;
	if ( isset( $wpb_elements[ $base ] ) ) {
		foreach ( $new_params as $k => $param ) {
			array_push( $wpb_elements[ $base ]['params'], $param );
		}
	}
}

/**
 * Remove a parameter from an element
 *
 * @param string $base
 * @param array $new_params
 */
function wpb_remove_param( $base, $param_name ) {
	global $wpb_elements;
	if ( isset( $wpb_elements[ $base ] ) ) {
		foreach ( $wpb_elements[ $base ]['params'] as $k => $param ) {
			if ( $param_name == $param['param_name'] ) {
				unset( $wpb_elements[ $base ]['params'][$k] );
			}
		}
	}
}

/**
 * Remove element from the list
 *
 * @param string $base
 */
function wpb_remove_element( $base ) {
	global $wpb_elements;
	if ( isset( $wpb_elements[ $base ] ) ) {
		unset( $wpb_elements[ $base ] );
	}
}

/**
 * Get element categories
 *
 * @return array $categories
 */
function wpb_get_element_categories() {
	$categories = array();
	global $wpb_elements;

	foreach ( $wpb_elements as $element ) {
		$category = isset( $element['category'] ) ? $element['category'] : '';
		array_push( $categories, $category );
	}
	$categories = array_unique( $categories );
	sort( $categories );
	return $categories;
}

/**
 * Get all elements in array
 *
 * @return array $wpb_elements
 */
function wpb_get_elements() {
	global $wpb_elements;

	//  move the text block element at the begginging of the array
	//$wpb_elements = array( 'wpb_text_block' => $wpb_elements['wpb_text_block'] ) + $wpb_elements;

	return $wpb_elements;
}

/**
 * Get all elements that have children
 *
 * @return array $wpb_elements
 */
function wpb_get_parent_elements() {
	global $wpb_elements;
	$parent_elements = array();

	foreach ( $wpb_elements as $base => $args ) {
		if ( isset( $args['has_child'] ) && true == $args['has_child'] ) {
			$parent_elements[ $base ] = $args;
		}
	}
	return $parent_elements;
}

/**
 * Get all elements that have prent
 *
 * @return array $wpb_elements
 */
function wpb_get_child_elements() {
	global $wpb_elements;
	$child_elements = array();

	foreach ( $wpb_elements as $base => $args ) {
		if ( isset( $args['parent'] ) ) {
			$child_elements[ $base ] = $args;
		}
	}
	return $child_elements;
}