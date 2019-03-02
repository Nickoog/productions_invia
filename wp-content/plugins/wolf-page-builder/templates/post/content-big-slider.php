<?php
/**
 * Post big slide content
 *
 * This template is used inside the big posts slider shortcode
 * 
 * @see inc/frontend/shortcodes/last-posts-big-slider.php 
 */
$background_img = wpb_get_post_thumbnail_url( 'wpb-XL' );
?>
<li style="background-image:url(<?php echo esc_url( $background_img ); ?>);" <?php post_class( array( 'slide', 'wpb-post-big-slide' ) ); ?>>
	<div class="wpb-last-posts-big-slide-caption-container">
		<div class="wpb-last-posts-big-slide-caption">
			<div class="wpb-last-posts-big-slide-caption-wrapper">
				<div class="wpb-last-posts-big-slide-caption-inner">
					<a class="wpb-last-posts-big-slide-category-link" href="<?php echo esc_url( wpb_get_first_category_url() ); ?>">
						<?php echo apply_filters( 'wpb_last_posts_big_slide_category', wpb_get_first_category() ); ?>
					</a>
					<h2 class="wpb-post-big-slide-entry-title wpb-entry-title">
						<a class="wpb-post-slide-entry-link" href="<?php the_permalink(); ?>" rel="bookmark">
							<?php the_title(); ?>
						</a>
					</h2>
					<p class="wpb-last-posts-big-slide-summary">
						<?php echo apply_filters( 'wpb_last_posts_big_slide_summary', wpb_sample( get_the_excerpt(), 14 ) ); ?>
					</p>
					<a class="<?php echo esc_attr( apply_filters( 'wpb_last_posts_big_slide_button_class', 'wpb-last-post-big-slide-button' ) ); ?>" href="<?php the_permalink(); ?>">
						<?php echo apply_filters( 'wpb_last_posts_big_slide_button_text', esc_html__( 'Continue reading', 'wolf-page-builder' ) ); ?>
					</a>
				</div><!-- .wpb-last-posts-big-slide-caption-inner -->
			</div><!-- .wpb-last-posts-big-slide-caption-wrapper -->
		</div><!-- .wpb-last-posts-big-slide-caption -->
	</div><!-- .wpb-last-posts-big-slide-caption-container -->
</li>