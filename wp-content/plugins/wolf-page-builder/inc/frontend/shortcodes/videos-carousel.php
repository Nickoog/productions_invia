<?php
/**
 * Video carousel shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_last_videos_carousel' ) ) {
	/**
	 * Video shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_last_videos_carousel( $atts ) {

		extract( shortcode_atts( array(
			'count' => 3,
			'category' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'owlcarousel' );
		wp_enqueue_script( 'wpb-carousels' );

		$class = $extra_class;
		$class = sanitize_text_field( $class );
		$inline_style = sanitize_text_field( $inline_style );

		$output = $style = '';

		$class .= ' wpb-last-videos-carousel-container wpb-video-carousel-container';

		$args = array(
			'post_type' => 'video',
			'posts_per_page' => absint( $count ),
		);

		if ( $category ) {
			$args['video_type'] = $category;
		}

		$loop = new WP_Query( $args );

		if ( $loop->have_posts() ) {

			$output .= '<div  class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $style ) . '">';
			$output .= '<div class="wpb-video-carousel">';

				while( $loop->have_posts() ) {
					$loop->the_post();

					$video_url = wpb_get_first_video_url();
					$thumbnail_url = wpb_get_post_thumbnail_url();

					if ( $video_url )
						$output .= '<div class="item-video" data-merge="2" style="background-image:url(' . esc_url( $thumbnail_url ) . ');"><a class="owl-video" href="' . esc_url( $video_url ) . '"></a></div>';
				}
			
			$output .= '</div><!-- .wpb-video-carousel -->';

			$output .= '</div><!-- .wpb-last-videos-carousel-container -->';

		}

		return $output;
	}
	add_shortcode( 'wpb_last_videos_carousel', 'wpb_shortcode_last_videos_carousel' );
}