<?php
/**
 * Post slide content
 *
 * This template is used inside the posts slider shortcode
 * 
 * @see inc/frontend/shortcodes/last-posts.php 
 */
?>
<li <?php wpb_post_attr() ?> <?php post_class( array( 'slide', 'wpb-post-slide' ) ); ?>>
	<?php the_post_thumbnail( 'wpb-2x1' ); ?>
	<div class="wpb-post-slide-inner">
		<h3 class="wpb-post-slide-entry-title wpb-entry-title entry-title">
			<a class="wpb-post-slide-entry-link entry-link" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h3>
		<span class="wpb-post-slide-entry-meta wpb-entry-meta entry-meta">
			<?php wpb_post_entry_meta(); ?>
			<?php edit_post_link( esc_html__( 'Edit', 'wolf' ), '<span class="edit-link wpb-edit-link">', '</span>' ); ?>
		</span>
		<div class="wpb-post-slide-entry-summary wpb-entry-summary entry-summary">
			<p><?php echo wpb_sample( get_the_excerpt() , 22 ); ?></p>
		</div>
	</div>
</li>