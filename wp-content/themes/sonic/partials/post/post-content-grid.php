<?php
/**
 * The post content displayed in the loop for the "grid" display 
 *
 * @package WordPress
 * @subpackage Sonic
 */
$format = get_post_format() ? get_post_format() : 'standard';
$thumb_size = sonic_get_image_size_fallback( 'sonic-2x2', 'sonic-1x1' );
$link = sonic_get_first_url();
$quote = 'quote' == $format && sonic_featured_quote();
$permalink = ( 'link' == $format && $link ) ? $link : get_permalink();
?>
<?php if ( has_post_thumbnail() ) : ?>
	<article <?php sonic_post_attr(); ?> <?php sonic_article_schema(); ?> <?php post_class( array( 'entry-display-grid' ) ); ?>>
		<?php wolf_post_start(); ?>
		<div class="post-grid-container">
			<a href="<?php echo esc_url( $permalink ); ?>" class="entry-thumbnail entry-link post-grid-container-entry-link">
				<?php the_post_thumbnail( $thumb_size, array( 'itemprop' => 'image' ) ); ?>
				<div class="post-grid-title-container">
					<div class="post-grid-title-inner table">
						<div class="post-grid-content table-cell">
							<?php

							if ( is_sticky() && ! is_paged() ) {
								echo '<span class="sticky-post">' . esc_html__( 'Featured', 'sonic' ) . '</span>';
							}

							$format_to_show_title = array( 'standard', 'video', 'gallery', 'image', 'audio' );

							if ( in_array( $format, $format_to_show_title ) ) :

								if ( sonic_get_first_category() ) {
									echo '<span class="post-grid-category category-label">' . sanitize_text_field( sonic_get_first_category() ) . '</span>';
								}
								?>
								<h2 class="entry-title"><?php the_title(); ?></h2>
								<span class="post-grid-divider"></span>
								<span class="post-grid-entry-meta">
									<?php 
										/* Avatar */
										echo '<span class="author-meta">';
										echo get_avatar( get_the_author_meta( 'user_email' ), 20 );
										printf(
											'<span class="author vcard">by %s</span> &mdash; &nbsp;',
											get_the_author()
										);
										echo '</span>';

										/* Date */
										echo '<span class="date">';
										printf( esc_html__( '%s ago', 'sonic' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
										echo '</span>';
									?>
								</span><!-- .post-grid-entry-meta -->

							<?php elseif( 'status' == $format ) : ?>
								
								<span class="post-grid-status-avatar text-center">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
								</span>
								
								<?php echo wolf_sample( get_the_excerpt(), 20 ); ?>

							<?php elseif( $quote ) : ?>
								<blockquote class="post-grid-featured-quote">
								<?php echo wolf_sample( preg_replace( '#<a.*?>(.*?)</a>#i', '\1', sonic_featured_quote() ), 140 ) ; ?>
								</blockquote>
							<?php elseif( 'link' == $format ) : ?>

								<h2 class="post-grid-entry-title entry-title"><?php the_title(); ?></h2>
								<?php if ( $link ) : ?>
									<p><?php echo esc_url( $link ); ?></p>
								<?php endif; ?>

							<?php else : ?>

								<?php echo wolf_sample( get_the_excerpt(), 20 ); ?>

							<?php endif; ?>
						</div><!-- .post-grid-content -->
					</div><!-- .post-grid-title-inner -->
				</div><!-- .post-grid-title-container -->
			</a><!-- .post-grid-container-entry-link -->
		</div><!-- .post-grid-container -->
	</article><!-- article.post -->
<?php endif; ?>