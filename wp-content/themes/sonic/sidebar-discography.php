<?php
/**
 * The Sidebar containing the discography widget areas.
 *
 * @package WordPress
 * @subpackage Sonic
 */
if ( is_active_sidebar( 'sidebar-discography' ) ) : ?>
	<div id="secondary" class="sidebar-container sidebar-discography" role="complementary" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-discography' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #secondary .sidebar-container -->
<?php endif; ?>