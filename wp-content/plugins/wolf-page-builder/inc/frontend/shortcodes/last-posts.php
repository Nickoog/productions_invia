<?php
/**
 * Last posts shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_last_posts_shortcode' ) ) {
	/**
	 * Last posts shortcode
	 *
	 * @param array $atts
	 * @param string $content
	 * @param string $type
	 * @return string
	 */
	function wpb_last_posts_shortcode( $atts, $content = null, $type ) {
		
		extract( shortcode_atts( array(
			'ids' => '',
			'exclude_ids' => '',
			'count' => 4,
			'columns' => 4,
			'padding' => 'yes',
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
			'hide_summary' => '',
		), $atts ) );

		$output = $style = '';

		$type = str_replace( 'wpb_posts_', '', $type );

		if ( 'slider' == $type ) {
			wp_enqueue_script( 'flexslider' );
			wp_enqueue_script( 'wpb-sliders' );
		}

		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= "wpb-last-posts wpb-last-posts-$type wpb-last-posts-padding-$padding";

		$no_column_types = apply_filters( 'wpb_posts_display_types_without_columns', array(
			'preview',
			'slider',
			'carousel',
		) );

		if ( ! in_array( $type, $no_column_types ) ) {
			$class .= ' wpb-last-posts-columns-' . absint( $columns );
		}

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

		if ( $hide_cover ) {
			$class .= ' wpb-hide-cover';
		}

		if ( $hide_summary ) {
			$class .= ' wpb-hide-summary';
		}

		if ( $animation ) {
			$class .= " wow $animation";
		}

		if ( $animation_delay && 'none' != $animation ) {
			$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		$output .= '<section';
		
		if ( $anchor ) {
			$output .= ' id="' . esc_attr( $anchor ) . '"';
		}
		
		$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		if ( 'slider' == $type ) {
			$slider_data = "data-pause-on-hover='$autoplay'
			data-autoplay='$autoplay'
			data-transition='$transition'
			data-slideshow-speed='$slideshow_speed'
			data-nav-arrows='$nav_arrows'
			data-nav-bullets='$nav_bullets'";
			$output .= "<div $slider_data class='flexslider'><ul class='slides'>";
		}

		ob_start();

		$args = array(
			'post_type' => array( 'post' ),
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

		$animation_class = '';
		if ( $animation ) {
			$animation_class .= "wow $animation";
		}

		$last_post_loop = new WP_Query( $args );

		if ( $last_post_loop->have_posts() ) :
			while ( $last_post_loop->have_posts() ) : $last_post_loop->the_post();
				if ( 'preview' == $type ) {
					echo "<div class='$animation_class'>";
				}
				
				wpb_get_template_part( 'post/content', $type );

				if ( 'preview' == $type ) {
					echo '</div>';
				}
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
		
		if ( 'slider' == $type ) {
			$output .= '</ul></div><!--.flexslider-->';
		}
		
		$output .= '</section><!--.wpb-last-posts-' . $type . '-->';

		return $output;
	}

	$types = apply_filters( 'wpb_posts_display_types', array(
		'preview',
		'grid',
		'slider',
		'columns',
		'carousel',
	) );

	foreach( $types as $type ) {
		add_shortcode( 'wpb_posts_' . $type, 'wpb_last_posts_shortcode' );
	}
}