<?php
/**
 * The Sidebar containing the events widget areas.
 *
 * @package WordPress
 * @subpackage Sonic
 */
if ( is_active_sidebar( 'sidebar-events' ) ) : ?>
	<div id="secondary" class="sidebar-container sidebar-events" role="complementary" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-events' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #secondary .sidebar-container -->
<?php endif; ?>