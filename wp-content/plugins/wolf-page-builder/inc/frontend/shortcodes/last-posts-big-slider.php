<?php
/**
 * Last posts big slider shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_last_posts_big_slider_shortcode' ) ) {
	/**
	 * Last posts shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_last_posts_big_slider_shortcode( $atts ) {

		extract( shortcode_atts( array(
			'ids' => '',
			'exclude_ids' => '',
			'count' => 3,
			'category' => '',
			'tag' => '',
			'autoplay' => 'yes',
			'transition' => 'auto',
			'slideshow_speed' => 4000,
			'pause_on_hover' => 'yes',
			'nav_bullets' => 'yes',
			'nav_arrows' => 'yes',
			'animation' => '',
			'animation_delay' => '',
			'inline_style' => '',
			'extra_class' => '',
			'anchor' => '',
			'hide_category' => '',
			'hide_tag' => '',
			'hide_date' => '',
			'hide_author' => '',
			'hide_cover' => '',
			'slider_height' => '100%',
			'post_type' => 'post',
		), $atts ) );

		$output = $style = '';

		//$post_type = 'gallery';
		$post_type = ( post_type_exists( $post_type ) ) ? esc_attr( $post_type ) : 'post';

		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'wpb-sliders' );

		$slider_height_unit = '%';

		// percent
		if ( '%' == substr( $slider_height, -1) ) {
			$slider_height_unit = '%';

			if ( 100 < absint( $slider_height ) ) {
				$slider_height = 100;
			}
		// em
		} elseif ( 'em' == substr( $slider_height, -2) ) {
			$slider_height_unit = 'em';
		
		//px
		} elseif ( 'px' == substr( $slider_height, -2) ) {
			$slider_height_unit = 'px';
		}

		$slider_height = absint( $slider_height );

		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= 'wpb-last-posts wpb-last-posts-big-slider';

		if ( $hide_category ) {
			$class .= ' wpb-hide-category';
		}

		if ( $hide_tag ) {
			$class .= ' wpb-hide-tag';
		}

		if ( $hide_date ) {
			$class .= ' wpb-hide-date';
		}

		if ( $hide_author ) {
			$class .= ' wpb-hide-author';
		}

		$output .= '<section';
		
		if ( $anchor ) {
			$output .= ' id="' . esc_attr( $anchor ) . '"';
		}
		
		$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		$slider_data = "data-pause-on-hover='$autoplay'
			data-autoplay='$autoplay'
			data-transition='$transition'
			data-slideshow-speed='$slideshow_speed'
			data-nav-arrows='$nav_arrows'
			data-nav-bullets='$nav_bullets'
			data-height='$slider_height'
			data-height-unit='$slider_height_unit'";
			$output .= "<div $slider_data class='flexslider'><ul class='slides'>";

			$args = array(
				'post_type' => array( $post_type ),
				'posts_per_page' => absint( $count ),
				'ignore_sticky_posts' => 1,
				//'post__not_in' => $exclude,
				'meta_query' => array(
					array(
						'key' => '_thumbnail_id',
						'compare' => '!=',
						'value' => 'NULL'
					),
				),
			);

			if ( $ids ) {
				$args['post__in'] = wpb_list_to_array( $ids );
			}

			if ( $exclude_ids ) {
				$args['post__not_in'] = wpb_list_to_array( $exclude_ids );
			}

			if ( $category ) {
				$args['category_name'] = strtolower( str_replace( ' ', '', $category ) );
			}

			if ( $tag ) {
				$args['tag'] = strtolower( str_replace( ' ', '', $tag ) );
			}

		ob_start();

			$last_post_loop = new WP_Query( $args );

			if ( $last_post_loop->have_posts() ) :
				while ( $last_post_loop->have_posts() ) : $last_post_loop->the_post();
					
					wpb_get_template_part( 'post/content', 'big-slider' );

				endwhile;
			else :
				echo '<p class="wpb-text-center">';
				esc_html_e( 'No post found.', 'wolf-page-builder' );

				if ( is_user_logged_in() ) {
					echo '<br>';
					esc_html_e( 'Only posts with a featured image will be displayed.', 'wolf-page-builder' );
				}
				echo '</p>';

			endif;
			wp_reset_postdata();
			$output .= ob_get_clean();


			$output .= '</ul></div><!-- .flexslider -->';
		
		$output .= '</section><!-- .wpb-last-posts-big-slider -->';

		return $output;

	}
	add_shortcode( 'wpb_posts_big_slider', 'wpb_last_posts_big_slider_shortcode' );
}