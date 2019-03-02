<?php
/**
 * The Sidebar containing the videos widget areas.
 *
 * @package WordPress
 * @subpackage Sonic
 */
if ( is_active_sidebar( 'sidebar-videos' ) ) : ?>
	<div id="secondary" class="sidebar-container sidebar-videos" role="complementary" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-videos' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #secondary .sidebar-container -->
<?php endif; ?>