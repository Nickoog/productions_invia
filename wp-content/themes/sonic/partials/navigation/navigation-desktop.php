<?php
/**
 * The main navigation for desktop
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */
if ( sonic_is_main_menu() ) :
$menu_layout = sonic_get_menu_layout();
$centered_menu_layouts = array( 'centered-socials', 'centered-blog', 'centered-shop', 'centered-wpml', );
?>
<div id="navbar-container" class="clearfix">
	<div class="wrap">
		<?php if ( 'centered' == $menu_layout  ) : ?>
			<div id="navbar-left" class="navbar clearfix">
				<nav id="site-navigation-primary-desktop-left" class="site-navigation-primary navigation main-navigation clearfix" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<?php
						if ( has_nav_menu( 'primary-left' ) ) {
							/**
							 * Main Navigation left
							 */
							wp_nav_menu(
								array(
									'theme_location' => 'primary-left',
									'menu_class' => 'nav-menu',
									'depth'           => 3,
									'walker'         => new Sonic_Custom_Fields_Nav_Walker(),
									'fallback_cb' => '',
								)
							);
						} else {
							echo '&nbsp;'; // force the logo to be centered when no menu
						}
					?>
				</nav><!-- #site-navigation-primary -->
			</div><!-- #navbar -->
			<?php sonic_logo(); ?>
			<div id="navbar-right" class="navbar clearfix">
				<?php
					/**
					 * sonic_wooocommerce_search hook
					 * @see sonic_menu_product_search_form
					 */
					do_action( 'sonic_wooocommerce_search' );
				?>
				<nav id="site-navigation-primary-desktop-right" class="site-navigation-primary navigation main-navigation clearfix" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<?php
						if ( has_nav_menu( 'primary-right' ) ) {
							/**
							 * Main Navigation right
							 */
							wp_nav_menu(
								array(
									'theme_location' => 'primary-right',
									'menu_class' => 'nav-menu',
									'depth'           => 3,
									'walker'         => new Sonic_Custom_Fields_Nav_Walker(),
									'fallback_cb' => '',
								)
							);
						} else {
							echo '&nbsp;'; // force the logo to be centered when no menu
						}
					?>
				</nav><!-- #site-navigation-primary -->
			</div><!-- #navbar -->
		<?php elseif ( 'standard' == $menu_layout  ) : ?>
			<?php sonic_logo(); ?>
			<div id="navbar" class="navbar clearfix">
				<?php
					/**
					 * sonic_wooocommerce_search hook
					 * @see sonic_menu_product_search_form
					 */
					do_action( 'sonic_wooocommerce_search' );
				?>
				<nav id="site-navigation-primary-desktop" class="site-navigation-primary navigation main-navigation clearfix" itemscope itemtype="http://schema.org/SiteNavigationElement">
					<?php
					wp_nav_menu(
						array(
							'theme_location' 	=> 'primary',
							'menu_class' 		=> 'nav-menu',
							'depth'			=> 3,
							'walker'			=> new Sonic_Custom_Fields_Nav_Walker(),
							'fallback_cb'		=> '',
						)
					);
					?>
			</nav><!-- #site-navigation-primary -->
		</div><!-- #navbar -->

	<?php elseif ( in_array( $menu_layout, $centered_menu_layouts)  ) : ?>
		<div class="table">
			<div class="table-cell logo-table-cell">
				<?php sonic_logo(); ?>
			</div>
			<div class="table-cell menu-table-cell">
				<div id="navbar" class="navbar clearfix">
					<?php
						/**
						 * sonic_wooocommerce_search hook
						 * @see sonic_menu_product_search_form
						 */
						do_action( 'sonic_wooocommerce_search' );
					?>
					<nav id="site-navigation-primary-desktop" class="site-navigation-primary navigation main-navigation clearfix" itemscope itemtype="http://schema.org/SiteNavigationElement">
							<?php
							wp_nav_menu(
								array(
									'theme_location' 	=> 'primary',
									'menu_class' 		=> 'nav-menu',
									'depth'			=> 3,
									'walker'			=> new Sonic_Custom_Fields_Nav_Walker(),
									'fallback_cb'		=> '',
								)
							);
							?>
					</nav><!-- #site-navigation-primary -->
				</div><!-- #navbar -->
			</div>
			<div class="table-cell icons-table-cell">
				<?php
					if ( 'centered-socials' == $menu_layout ) {
						
						echo sonic_socials_menu_item();
					
					} elseif ( 'centered-blog' == $menu_layout ) {
						
						if ( wolf_get_theme_mod( 'search_menu_item' ) ) {
							echo sonic_search_menu_item();
						}
						
					} elseif ( 'centered-shop' == $menu_layout ) {
						
						// echo sonic_wishlist_menu_item();
						
						echo sonic_cart_menu_item();
					
					} elseif ( 'centered-wpml' == $menu_layout ) {
						
						do_action( 'wpml_add_language_selector' );
					}
				?>
			</div>
		</div>
	<?php endif; ?>
	</div><!-- .wrap -->
	<div class="clear"></div>
</div><!-- #navbar-container -->
<div class="clear"></div>
<?php endif; ?>