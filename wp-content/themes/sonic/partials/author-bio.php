<?php
/**
 * The template for displaying Author bio.
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */
?>
<div class="author-info clearfix">
	<div class="author-avatar col-2 alpha">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
	</div><!-- .author-avatar -->
	<div class="author-description col-10 omega" itemprop="author" itemscope itemtype="http://schema.org/Person">
		<h5><?php printf( esc_html__( 'About %s', 'sonic' ), '<span itemprop="name">' . get_the_author() . '</span>' ); ?></h5>
		<p>
			<?php the_author_meta( 'description' ); ?>
			<a itemprop="url" class="author-page-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( esc_html__( 'View all posts by %s &rarr;', 'sonic' ), get_the_author() ); ?>
			</a>
		</p>
		<p class="author-socials"><?php sonic_author_socials(); ?><p>
	</div><!-- .author-description -->
</div><!-- .author-info -->