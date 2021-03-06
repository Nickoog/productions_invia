<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main section and all content after
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */
?>					
						</div><!-- .content-wrapper -->
					</div><!-- .content-inner -->
					<?php wolf_content_end(); ?>
				</div><!-- .site-content -->
			</div><!-- #main -->
		</div><!-- #page-content -->
		<?php wolf_content_after(); ?>
		<div class="clear"></div>
		<?php wolf_footer_before(); ?>
		<footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
			<div class="footer-inner clearfix">
				<?php wolf_footer_start(); ?>

				<?php get_sidebar( 'footer' ); ?>

				<div class="footer-end wrap">
					<?php wolf_footer_end(); ?>
				</div><!-- .footer-end -->
			</div><!-- .footer-inner -->
			<?php
				/**
				 * Fires the Sonic bottom bar
				 *
				 * @since Sonic 1.1.2
				 */
				do_action( 'sonic_bottom_bar' );
			?>
		</footer><!-- footer#colophon .site-footer -->
		<?php wolf_footer_after(); ?>
	</div><!-- #page .hfeed .site -->
</div><!-- .site-container -->
<?php wolf_body_end(); ?>
<?php wp_footer(); ?>
</body>
</html>