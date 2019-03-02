<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage Sonic
 * @since Sonic 1.0.0
 */
?>
<article class="page">

	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'sonic' ); ?></h1>
	</header><!-- .page-header -->
	
	<div class="entry-content nothing-found">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	
			<p>
				<?php printf(
				wp_kses(
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'sonic' ), 
					array( 'a' => array( 'href' => array() ) )
				),
				admin_url( 'post-new.php' ) ); ?>
			</p>
	
		<?php elseif ( is_search() ) : ?>
	
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'sonic' ); ?></p>
			<?php get_search_form(); ?>
			<div class="clear"></div>
			<?php sonic_top_tags( esc_html__( 'Most used tags : ', 'sonic' ) ); ?>
	
		<?php else : ?>
	
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'sonic' ); ?></p>
			<?php get_search_form(); ?>
			<div class="clear"></div>
			<?php sonic_top_tags( esc_html__( 'Most used tags : ', 'sonic' ) ); ?>
	
		<?php endif; ?>
	</div><!-- .page-content -->
</article>