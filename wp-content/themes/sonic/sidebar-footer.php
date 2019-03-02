<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */
if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
	<section id="tertiary" class="sidebar-footer">
		<div class="sidebar-footer-inner wrap">
			<div class="widget-area clearfix">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div>
		</div>
	</section><!-- #tertiary .sidebar-footer -->
<?php endif; ?>