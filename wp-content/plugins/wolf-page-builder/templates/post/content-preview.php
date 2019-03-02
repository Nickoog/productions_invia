<?php
/**
 * Post preview content
 *
 * This template is used inside the posts preview shortcode
 * 
 * @see inc/frontend/shortcodes/last-posts.php 
 */
?>
<article <?php wpb_post_attr() ?> <?php post_class( array( 'wpb-clearfix', 'wpb-post-preview' ) ); ?>>
	<div class="wpb-post-preview-entry-thumbnail">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
	</div>
	<div class="wpb-post-preview-entry-content">
		<h3 class="wpb-post-preview-entry-title wpb-entry-title entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark" class="wpb-post-preview-entry-link entry-link"><?php the_title(); ?></a>
		</h3>
		<div class="wpb-post-preview-entry-meta wpb-entry-meta entry-meta">
			<?php wpb_post_entry_meta(); ?>
			<?php edit_post_link( esc_html__( 'Edit', 'wolf' ), '<span class="edit-link wpb-edit-link">', '</span>' ); ?>
		</div>
		<div class="wpb-post-preview-entry-summary wpb-entry-summary entry-summary">
			<p><?php echo wpb_sample( get_the_excerpt() , 14 ); ?><p>
		</div>
	</div>
</article>
