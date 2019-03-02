<?php
/**
 * The Sidebar containing the albums widget areas.
 *
 * @package WordPress
 * @subpackage Sonic
 */
if ( is_active_sidebar( 'sidebar-albums' ) ) : ?>
	<div id="secondary" class="sidebar-container sidebar-albums" role="complementary" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-albums' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #secondary .sidebar-container -->
<?php endif; ?>