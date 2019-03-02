<?php
/**
 * Sonic shop
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_shop_mods( $sonic_mods ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$sonic_mods['shop'] = array(
			'id' => 'shop',
			'title' => esc_html__( 'Shop', 'sonic' ),
			'icon' => 'cart',
			'options' => array(

				'shop_layout' => array(
					'id' => 'shop_layout',
					'label' => esc_html__( 'Products Layout', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'sonic' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'sonic' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'sonic' ),
						'fullwidth' => esc_html__( 'Full width', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'shop_single_layout' => array(
					'id' => 'shop_single_layout',
					'label' => esc_html__( 'Single Product Layout', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						'fullwidth' => esc_html__( 'Full width', 'sonic' ),
						//'standard' => esc_html__( 'Standard', 'sonic' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'sonic' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'sonic' ),
					),
					'transport' => 'postMessage',
				),

				'shop_display' => array(
					'id' => 'shop_display',
					'label' => esc_html__( 'Display', 'sonic' ),
					'type' => 'select',
					'choices' => apply_filters( 'sonic_shop_display_options', array(
						'grid' => esc_html__( 'Default Grid', 'sonic' ),
						'list' => esc_html__( 'List', 'sonic' ),
					) ),
				),

				// 'shop_padding' => array(
				// 	'id' => 'shop_padding',
				// 	'label' => esc_html__( 'Padding', 'sonic' ),
				// 	'type' => 'select',
				// 	'choices' => array(
				// 		'yes' => esc_html__( 'Yes', 'sonic' ),
				// 		'no' => esc_html__( 'No', 'sonic' ),
				// 	),
				// 	'transport' => 'postMessage',
				// ),

				'shop_columns' => array(
					'id' => 'shop_columns',
					'label' => esc_html__( 'Columns (for grid display only)', 'sonic' ),
					'type' => 'select',
					'choices' => array(
						3 => 3,
						2 => 2, 
						4 => 4, 
						5 => 5, 
						6 => 6,
					),
					'transport' => 'postMessage',
				),

				'cart_menu_item' => array(
					'label' => esc_html__( 'Add a Cart Menu Item', 'sonic' ),
					'id' => 'cart_menu_item',
					'type' => 'checkbox',
				),

				'cart_menu_item_icon' => array(
					'label' => esc_html__( 'Cart Menu Item Icon', 'sonic' ),
					'id' => 'cart_menu_item_icon',
					'type' => 'select',
					'choices' => array(
						'ti-basket' => esc_html__( 'Basket', 'sonic' ),
						'ti-cart' => esc_html__( 'Cart 1', 'sonic' ),
						'fa-shopping-cart' => esc_html__( 'Cart 2', 'sonic' ),
						'lnr-cart' => esc_html__( 'Cart 3', 'sonic' ),

					),
				),

				'cart_menu_panel_icon' => array(
					'label' => esc_html__( 'Cart Menu Panel Icon', 'sonic' ),
					'id' => 'cart_menu_panel_icon',
					'type' => 'select',
					'choices' => array(
						'ti-basket' => esc_html__( 'Basket', 'sonic' ),
						'ti-cart' => esc_html__( 'Cart 1', 'sonic' ),
						'fa fa-shopping-cart' => esc_html__( 'Cart 2', 'sonic' ),
						'lnr-cart' => esc_html__( 'Cart 3', 'sonic' ),
						'dashicons-cart' => esc_html__( 'Cart 4', 'sonic' ),

					),
				),

				'products_per_page' => array(
					'label' => esc_html__( 'Products per Page', 'sonic' ),
					'id' => 'products_per_page',
					'type' => 'text',
				),
			),
		);
	}

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_shop_mods' );