<?php 
/**
 * The mobile top bar with the toggle icon and menu
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */
$menu_layout = sonic_get_menu_layout();
?>
<div id="mobile-bar">
	<?php if ( 'centered-shop' == $menu_layout ) : ?>
		<div class="table">
			<div class="table-cell mobile-cart-table-cell">
				<?php echo sonic_cart_menu_item(); ?>
			</div><!-- .table-cell -->
			<div class="table-cell mobile-logo-table-cell">
				<?php sonic_mobile_logo(); ?>
			</div><!-- .table-cell -->
			<div class="table-cell toggle-table-cell">
				<div id="toggle" class="mobile-menu-toggle-button"></div><!-- #toggle -->
			</div><!-- .table-cell -->
		</div><!-- .table -->
	<?php else : ?>
		<?php sonic_mobile_logo(); ?>
		<div id="toggle" class="mobile-menu-toggle-button"></div><!-- #toggle -->
	<?php endif; ?>
</div><!-- #mobile-bar -->