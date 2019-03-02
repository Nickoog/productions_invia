<?php
/**
 * Sonic plugins hook functions
 *
 * Inject content through template hooks
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output top bar menu
 */
function sonic_top_bar() {

	if ( sonic_display_topbar() ) {
		get_template_part( 'partials/navigation/navigation', 'topbar' );
	}
}
add_action( 'wolf_header_start', 'sonic_top_bar' );

/**
 * Output desktop menu
 *
 * @since Sonic 1.0.0
 */
function sonic_main_menu() {

	get_template_part( 'partials/navigation/navigation', 'desktop' );
}
add_action( 'wolf_header_end', 'sonic_main_menu' );

/**
 * Output mobile bar
 */
function sonic_mobile_bar() {
	
	get_template_part( 'partials/navigation/navigation', 'mobile-bar' );

}
add_action( 'wolf_header_end', 'sonic_mobile_bar' );

/**
 * Output mobile menu
 *
 * @since Sonic 1.0.0
 */
function sonic_mobile_menu() {

	get_template_part( 'partials/navigation/navigation', 'mobile' );
}
add_action( 'wolf_body_start', 'sonic_mobile_menu' );

/**
 * Output social icons in main menu
 *
 * @since 1.0.0
 * @return void
 */
function sonic_main_menu_add_socials( $items, $args ) {

	if ( function_exists( 'wpb_socials' ) ) {

		$menu_layout = sonic_get_menu_layout();
		$is_top_bar = has_nav_menu( 'secondary' );

		$socials_item = '';

		if ( sonic_socials_menu_item() ) {
			$socials_item .= '<li class="socials-menu-item">';
			$socials_item .= sonic_socials_menu_item();
			$socials_item .= '</li>';
		}

		$supported_menu_layouts = array(
			'standard', 'centered', 'centered-blog', 'centered-shop', 'centered-wpml',
		);

		if ( in_array( $menu_layout, $supported_menu_layouts ) ) {
			if ( 'primary' == $args->theme_location || 'primary-right' == $args->theme_location ) {
				$items .= $socials_item;
			}
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'sonic_main_menu_add_socials', 10, 2 );

/**
 * Add a search menu item
 */
function sonic_add_search_menu_item( $items, $args ) {

	$menu_layout = sonic_get_menu_layout();

	$supported_menu_layouts = array(
		'standard', 'centered', 'centered-socials', 'centered-shop', 'centered-wpml',
	);

	if ( in_array( $menu_layout, $supported_menu_layouts ) ) {
		if ( ( $args->theme_location == 'primary' || $args->theme_location == 'primary-right' ) && wolf_get_theme_mod( 'search_menu_item' ) ) {
			$items .= '<li class="search-menu-item">';
			
			if ( 'woocommerce' == wolf_get_theme_mod( 'search_menu_item' ) && function_exists( 'get_product_search_form' ) ) {
				$items .= '<div class="mobile-product-search-form">';
				ob_start();
				get_product_search_form();
				$items .= ob_get_clean();
				$items .= '<span class="close-product-search-form">&times;</span>';
				$items .= '</div>';
			}

			$items .= sonic_search_menu_item();
			$items .= '</li>';
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'sonic_add_search_menu_item', 10, 2 );

/**
 * Add a cart menu item
 *
 * @since 1.0.0
 * @param
 * @return void
 */
function sonic_add_cart_menu_item ( $items, $args ) {

	$woo_item = '<li class="cart-menu-item">';
	$woo_item .= sonic_cart_menu_item();
	$woo_item .= '</li>';

	$menu_layout = sonic_get_menu_layout();

	$supported_menu_layouts = array(
		'standard', 'centered', 'centered-socials', 'centered-blog', 'centered-wpml',
	);

	if ( in_array( $menu_layout, $supported_menu_layouts ) ) {

		if ( ( $args->theme_location == 'primary' || $args->theme_location == 'primary-right' ) && wolf_get_theme_mod( 'cart_menu_item', true ) ) {
			$items .= $woo_item;
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'sonic_add_cart_menu_item', 10, 2 );

/**
 * Output bottom menu
 */
function sonic_bottom_menu() {
	if ( has_nav_menu( 'tertiary' ) ) {
	?>
		<nav id="site-navigation-tertiary" class="clearfix navigation tertiary-navigation">
			<?php wp_nav_menu(
				array(
					'theme_location' => 'tertiary',
					'menu_class' => 'nav-menu-tertiary inline-list',
					'fallback_cb'  => '',
					'depth' => 1,
					'after' => '<span class="bottom-menu-item-separator">' . wolf_get_theme_mod( 'bottom_menu_item_separator', '' ) . '</span>',
				)
			); ?>
		</nav><!-- #site-navigation-tertiary-->
	<?php
	}
}
add_action( 'sonic_bottom_menu', 'sonic_bottom_menu' );