<?php
/**
 * Post column content
 *
 * This template is used inside the posts column shortcode
 * 
 * @see inc/frontend/shortcodes/last-posts.php 
 */
$format = get_post_format() ? get_post_format() : 'standard';
$thumb_size = 'wpb-thumb';
?>
<article <?php wpb_post_attr() ?> <?php post_class( 'wpb-post-column' ); ?>>
	<?php if ( 'gallery' == $format ) : ?>
		<div class="wpb-post-column-entry-slider">
			<?php echo wpb_post_gallery_slider( $thumb_size ); ?>
		</div>
	<?php else : ?>
		<div class="wpb-post-column-entry-thumbnail">
			<a href="<?php the_permalink(); ?>" class="wpb-post-column-entry-thumbnail-link entry-link"><?php the_post_thumbnail( $thumb_size ); ?></a>
		</div>
	<?php endif; ?>
	<h3 class="wpb-post-column-entry-title wpb-entry-title entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark" class="wpb-post-column-entry-link entry-link"><?php the_title(); ?></a>
		</h3>
	<div class="wpb-post-column-entry-meta wpb-entry-meta entry-meta">
		<?php wpb_post_entry_meta(); ?>
		<?php edit_post_link( esc_html__( 'Edit', 'wolf' ), '<span class="edit-link wpb-edit-link">', '</span>' ); ?>
	</div>
	<div class="wpb-post-column-entry-summary wpb-entry-summary entry-summary">
		<p><?php echo wpb_sample( get_the_excerpt() , 10 ); ?><p>
	</div>
</article>