<?php
/**
 * Sonic navigation
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function sonic_set_navigation_mods( $sonic_mods ) {

	$sonic_mods['navigation'] = array(
		'id' => 'navigation',
		'icon' => 'menu',
		'title' => esc_html__( 'Navigation', 'sonic' ),
		'options' => array(

			'ajax_nav' => array(
				'id' =>'ajax_nav',
				'label' => esc_html__( 'AJAX Navigation', 'sonic' ),
				'type' => 'checkbox',
				'description' => esc_html__( 'Navigate without reloading the page.', 'sonic' ),
			),

			'menu_layout' => array(
				'id' => 'menu_layout',
				'label' => esc_html__( 'Main Menu Layout', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'sonic' ),
					'centered' => esc_html__( 'Logo Centered', 'sonic' ),
					'centered-socials' => esc_html__( 'Centered with Social Icons at Right', 'sonic' ),
					'centered-blog' => esc_html__( 'Centered with Search Icon at Right', 'sonic' ),
				),
				'description' => esc_html__( 'Create your menu(s) accordingly in the menu admin panel.', 'sonic' ),
			),

			'menu_width' => array(
				'id' => 'menu_width',
				'label' => esc_html__( 'Main Menu Width for Standard Style', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'boxed' => esc_html__( 'Boxed', 'sonic' ),
					'wide' => esc_html__( 'Wide', 'sonic' ),
					'fullwidth' => esc_html__( '100% Width', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			'menu_centered_alignment' => array(
				'id' => 'menu_centered_alignment',
				'label' => esc_html__( 'Main Menu Alignment for Logo Centered Style', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'boxed' => esc_html__( 'Boxed (menu item close to the logo)', 'sonic' ),
					'wide' => esc_html__( 'Wide (menu items far from the logo)', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			'auto_menu_type' => array(
				'id' =>'auto_menu_type',
				'label' => esc_html__( 'Main Menu Style', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'semi-transparent' => esc_html__( 'Semi-transparent White', 'sonic' ),
					'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'sonic' ),
					'standard' => esc_html__( 'Solid', 'sonic' ),
					'absolute' => esc_html__( 'Absolute position', 'sonic' ),
					'transparent' => esc_html__( 'Transparent', 'sonic' ),
				),
			),

			'menu_hover_style' => array(
				'id' => 'menu_hover_style',
				'label' => esc_html__( 'Main Menu Hover Style', 'sonic' ),
				'type' => 'select',
				'choices' => apply_filters( 'sonic_main_menu_hover_style_options', array(
					'none' => esc_html__( 'None', 'sonic' ),
					'opacity' => esc_html__( 'Opacity', 'sonic' ),
					'line' => esc_html__( 'Line', 'sonic' ),
					'line2' => esc_html__( 'Line 2', 'sonic' ),
					'border' => esc_html__( 'Border', 'sonic' ),
					'plain' => esc_html__( 'Plain', 'sonic' ),
				) ),
				'transport' => 'postMessage',
			),

			'main_menu_item_separator' => array(
				'id' => 'main_menu_item_separator',
				'label' => esc_html__( 'Main Menu Item Separator', 'sonic' ),
				'type' => 'text',
				'description' => sprintf( wp_kses(
					__( 'This will be output via CSS, so you need to use ISO format if you want to use special characters (<a href="%s" target="_blank">cheat sheet</a>).', 'sonic' ),
						array( 'a' => array( 'href' => array(), 'target' => array(), ) )
					),
					esc_url( 'https://brajeshwar.github.io/entities/' )
				),
			),

			// 'sub_menu_color' => array(
			// 	'id' =>'sub_menu_color',
			// 	'label' => esc_html__( 'Submenu Color', 'sonic' ),
			// 	'type' => 'color',
			// ),

			'submenu_width' => array(
				'id' => 'submenu_width',
				'label' => esc_html__( 'Mega Menu Width', 'sonic' ),
				'type' => 'select',
				'choices' => array(
					'boxed' => esc_html__( 'Boxed', 'sonic' ),
					'wide' => esc_html__( 'Wide', 'sonic' ),
				),
				'transport' => 'postMessage',
			),

			'menu_height' => array(
				'id' =>'menu_height',
				'label' => esc_html__( 'Menu Height in px', 'sonic' ),
				'type' => 'text',
				//'transport' => 'postMessage',
			),

			'menu_item_padding' => array(
				'id' =>'menu_item_padding',
				'label' => esc_html__( 'Menu item horizontal padding in px', 'sonic' ),
				'type' => 'text',
			),

			// 'menu_font_size' => array(
			// 	'id' =>'menu_font_size',
			// 	'label' => esc_html__( 'Menu font size', 'sonic' ),
			// 	'type' => 'text',
			// ),

			'menu_breakpoint' => array(
				'id' =>'menu_breakpoint',
				'label' => esc_html__( 'Main Menu Breakpoint', 'sonic' ),
				'type' => 'text',
				'description' => esc_html__( 'Below each width would you like to display the mobile menu? 0 will always show the desktop menu and 99999 will always show the mobile menu.', 'sonic' ),
			),

			'sticky_menu' => array(
				'id' =>'sticky_menu',
				'label' => esc_html__( 'Sticky Menu', 'sonic' ),
				'type' => 'checkbox',
				'description' => esc_html__( 'The menu will stay at the top while scrolling.', 'sonic' ),
			),

			'menu_bottom_border' => array(
				'label' => esc_html__( 'Menu Bottom Border', 'sonic' ),
				'id' => 'menu_bottom_border',
				'type' => 'checkbox',
			),

			'search_menu_item' => array(
				'label' => esc_html__( 'Search Menu Item', 'sonic' ),
				'id' => 'search_menu_item',
				'type' => 'select',
				'choices' => array(
					'overlay' => esc_html__( 'Overlay', 'sonic' ),
					'' => esc_html__( 'No Search Menu Item', 'sonic' ),
				),
			),

			'search_menu_item_icon' => array(
				'label' => esc_html__( 'Search Menu Item Icon', 'sonic' ),
				'id' => 'search_menu_item_icon',
				'type' => 'select',
				'choices' => array(
					'fa-search' => esc_html__( 'Icon 1', 'sonic' ),
					'line-icon-search' => esc_html__( 'Icon 2', 'sonic' ),
				),
			),
		),
	);

	if ( apply_filters( 'sonic_display_topbar', '' ) ) {
		$sonic_mods['navigation']['options']['topbar_content'] = array(
			'label' => esc_html__( 'Optional content to display in the top bar.', 'sonic' ),
			'id' => 'topbar_content',
			'type' => 'text',
		);
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$sonic_mods['navigation']['options']['menu_layout']['choices']['centered-shop'] = esc_html__( 'Centered with Cart Icon at Right', 'sonic' );
	}

	if ( function_exists( 'icl_object_id' ) ) {
		$sonic_mods['navigation']['options']['menu_layout']['choices']['centered-wpml'] = esc_html__( 'Centered with Language Switcher at Right', 'sonic' );
	}

	if ( class_exists( 'Wolf_Page_Builder' ) ) {
		$sonic_mods['navigation']['options']['menu_socials_services'] = array(
			'id' =>'menu_socials_services',
			'label' => esc_html__( 'Menu Socials', 'sonic' ),
			'description' => sprintf( wp_kses(
				__( 'Enter the social networks names separated by a comma. e.g "twitter, facebook, instagram". ( see Wolf Page Builder options <a href="%s">social profiles tab</a>).', 'sonic' ),
					array( 'a' => array( 'href' => array(), ) )
				),
				esc_url( admin_url( 'admin.php?page=wpb-socials' ) )
			),
			'type' => 'text',
		);
	}

	return $sonic_mods;
}
add_filter( 'sonic_customizer_options', 'sonic_set_navigation_mods' );