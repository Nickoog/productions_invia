<?php
/**
 * Sonic sidebars
 *
 * Register default sidebar for the theme with the sonic_sidebars_init function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_sidebars_init' ) ) {
	/**
	 * Register footer widget area and main sidebar
	 *
	 * Add a shop sidebar if WooCommerce is installed
	 *
	 * @since Sonic 1.0.0
	 */
	function sonic_sidebars_init() {

		// Blog Sidebar
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Blog Sidebar', 'sonic' ),
				'id'            		=> 'sidebar-main',
				'description'   		=> esc_html__( 'Appears in blog pages if it contains widgets', 'sonic' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title' 	 	=> '<h3 class="widget-title">',
				'after_title'  	 	=> '</h3>',
			)
		);

		// Page Sidebar
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Page Sidebar', 'sonic' ),
				'id'            		=> 'sidebar-page',
				'description'   		=> esc_html__( 'Appears in pages if it contains wigets', 'sonic' ),
				'before_widget' 	=> '<aside id="%1$s" class="clearfix widget %2$s"><div class="widget-content">',
				'after_widget'		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);

		// Woocommerce Siderbar
		if ( class_exists( 'Woocommerce' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Shop Sidebar', 'sonic' ),
					'id'            		=> 'woocommerce',
					'description'   		=> esc_html__( 'Appears in WooCommerce pages if a layout with sidebar is set', 'sonic' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  	=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Portfolio Siderbar
		if ( class_exists( 'Wolf_Portfolio' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Portfolio Sidebar', 'sonic' ),
					'id'            		=> 'sidebar-portfolio',
					'description'   		=> esc_html__( 'Appears on the portfolio pages if a layout with sidebar is set', 'sonic' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Discography Siderbar
		if ( class_exists( 'Wolf_Discography' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Discography Sidebar', 'sonic' ),
					'id'            		=> 'sidebar-discography',
					'description'   		=> esc_html__( 'Appears on the discography pages if a layout with sidebar is set', 'sonic' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Videos Siderbar
		if ( class_exists( 'Wolf_Videos' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Videos Sidebar', 'sonic' ),
					'id'            		=> 'sidebar-videos',
					'description'   		=> esc_html__( 'Appears on the videos pages if a layout with sidebar is set', 'sonic' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Albums Siderbar
		if ( class_exists( 'Wolf_Albums' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Albums Sidebar', 'sonic' ),
					'id'            		=> 'sidebar-albums',
					'description'   		=> esc_html__( 'Appears on the albums pages if a layout with sidebar is set', 'sonic' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Events Siderbar
		if ( class_exists( 'Wolf_Events' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Events Sidebar', 'sonic' ),
					'id'            		=> 'sidebar-events',
					'description'   		=> esc_html__( 'Appears on the events pages if a layout with sidebar is set', 'sonic' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Footer Sidebar
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Footer Widget Area', 'sonic' ),
				'id'            		=> 'sidebar-footer',
				'description'   		=> esc_html__( 'Appears in the footer section of the site', 'sonic' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}
	add_action( 'widgets_init', 'sonic_sidebars_init' );
} // end function check
