<?php
/**
 * The Template for displaying all single blog posts.
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */
get_header();
wolf_post_before();
?>
	<div id="primary" class="content-area">
		<main id="content" class="site-content clearfix" role="main">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
					/**
					 * Get a different file depending on the layout option
					 */
					get_template_part( 'partials/post/single/single-post-content', sonic_get_single_post_layout() );
				?>
			<?php endwhile; ?>
		</main><!-- main#content .site-content-->
	</div><!-- #primary .content-area -->
<?php
wolf_post_after();
get_footer(); 
?>