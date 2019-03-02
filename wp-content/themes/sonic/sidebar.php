<?php
/**
 * The Sidebar containing the main widget areas for blogs
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */
if ( sonic_should_display_sidebar() ) : // see includes/conditional-functions.php ?>
	<div id="secondary" class="sidebar-container sidebar-main" role="complementary" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-main' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #secondary .sidebar-container -->
<?php endif; ?>
