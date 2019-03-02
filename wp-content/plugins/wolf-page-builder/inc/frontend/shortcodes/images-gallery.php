<?php
/**
 * Images gallery
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_gallery' ) ) {
	/**
	 * Gallery shortcode
	 *
	 * Will overwrite the default gallery shortcode
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	function wpb_shortcode_gallery( $atts ) {

		extract( shortcode_atts( array(
			'ids' => '',
			'layout' => 'simple',
			'columns' => '3',
			'image_size' => 'wpb-2x1',
			'link_type' => 'file',
			'padding' => 'no',
			'hover_effect' => 'default',
			'orderby' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$class = $extra_class;
		$images = wpb_list_to_array( $ids );

		if ( 'mosaic' == $layout ) {
			
			$output = wpb_mosaic_gallery( $images, $link_type, $hover_effect, $orderby, $inline_style, $class );

		} elseif ( 'carousel' == $layout ) {
			
			$output = wolf_carousel_gallery( $images, $link_type, $image_size, $padding, $hover_effect, $orderby, $inline_style, $class );

		} elseif ( 'simple' == $layout ) {

			$output = wpb_simple_gallery( $images, $link_type, $image_size, $padding, $columns, $hover_effect, $orderby, $inline_style, $class );
		}

		return $output;
	}
	add_shortcode( 'wpb_gallery', 'wpb_shortcode_gallery' );
}

if ( ! function_exists( 'wpb_simple_gallery' ) ) {
	/**
	 * Generate a simple gallery
	 *
	 * @access public
	 * @param array $images
	 * @param string $link_type
	 * @param string $image_size
	 * @param string $padding
	 * @param int $columns
	 * @param string $hover_effect
	 * @param string $orderby
	 * @return string $output
	 */
	function wpb_simple_gallery( $images = array(), $link_type = 'file', $image_size = 'wpb-2x1', $padding = 'no', $columns = 3, $hover_effect = 'default', $orderby = '', $inline_style = '', $class = '' ) {

		if ( 'rand' == $orderby ) {
			shuffle( $images );
		}

		$rand_id = rand( 0,999 );
		$selector = "wpb-gallery-$rand_id";

		$class .= " wpb-images-gallery wpb-clearfix wpb-simple-gallery wpb-hover-$hover_effect";

		if ( 'yes' == $padding ) {
			$class .= " wpb-padding";
		}

		$columns = absint( $columns );
		$itemwidth = $columns > 0 ? round( 100 / $columns, 2,  PHP_ROUND_HALF_DOWN ) - 0.01 : 100;
		// $float = is_rtl() ? 'right' : 'left';

		// $css = "<style scoped>
		// 	#{$selector} .wpb-block {
		// 		float: {$float};
		// 		width: {$itemwidth}%;";

		// if ( 1 == $columns ) {
		// 	$css .= 'padding-bottom:10px!important;';
		// }

		// $css .= '}</style>';

		$output = '';

		$class .= ' wpb-images-gallery-columns-' . $columns;

		if ( 1 == $columns ) {
			$image_size = 'wpb-XL';
		}

		$output .= '<div id="' . esc_attr( $selector ) . '" class="' . wpb_sanitize_html_classes( $class ) . '"';

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		$output .= '>';
		

		if ( array() != $images ) {

			foreach ( $images as $image_id ) {

				$is_file = wpb_get_url_from_attachment_id( absint( $image_id ), $image_size );

				if ( is_numeric( $image_id ) && $is_file ) {
					$image_id = absint( $image_id );
					$image_url = wpb_get_url_from_attachment_id( absint( $image_id ), $image_size );
					$attachment = get_post( $image_id );
					$full_size  = esc_url( wpb_get_url_from_attachment_id( $image_id, 'wpb-XL' ) );
					$image_page = get_attachment_link( $image_id );
					$title = ( $attachment ) ? wptexturize( $attachment->post_title ) : '';
					$alt = ( $attachment ) ? esc_attr( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ) : '';
					$alt = ( $alt ) ? $alt : $title;
					$post_excerpt = ( $attachment ) ? wpb_sample( wptexturize( $attachment->post_excerpt ), 88 ) : '';
					$href = ( 'post' == $link_type || 'attachment' == $link_type ) ? $image_page : $full_size;
					$class = ( 'file' == $link_type ) ? 'wpb-lightbox wpb-image-inner' : 'wpb-image-inner';
				} else {
					
					$alt = $post_excerpt = $href = $title = '';

					if ( wpb_is_url( $image_id ) ) {

						$image_url = esc_url( $image_id );

					} else {
						global $wpb_image_placeholders;
						$image_url = ( isset( $wpb_image_placeholders[ $image_size ] ) ) ? $wpb_image_placeholders[ $image_size ] : '';
					}
				}

				$output .= "<div class='wpb-block'>";

				if ( 'none' != $link_type ) {
					
					$output .= "<a";

					if ( $title ) {
						$output .= ' title="' . esc_attr( $title ) . '"';
					}

					$output .= ' href="' . esc_url( $href ) . '" class="' . wpb_sanitize_html_classes( $class ) . '" data-wpb-rel="' . esc_attr( $selector ) . '">';
				
				} else {
					$output .= '<span class="' . wpb_sanitize_html_classes( $class ) . '">';
				}

				$do_lazy_load = wpb_get_option( 'settings', 'do_lazyload' );
				$src = ( $do_lazy_load ) ? WPB_URI . '/assets/img/blank.gif' : $image_url;
				$lazy_load = ( $do_lazy_load ) ? ' class="lazy-hidden" data-src="' . esc_url( $image_url ) . '"' : '';
				$output .= '<img' . $lazy_load . ' src="' . esc_url( $src ) . '" alt="' .esc_attr( $title ) . '">';

				if ( 'none' != $link_type ) {
					$output .= '</a>';
				} else {
					$output .= '</span>';
				}

				$output .= '</div><!-- .wpb-block -->';
			}

		}

		$output .= '</div><!--.wpb-simple-gallery-->';

		if ( array() != $images ) {
			return $output;
		}
	}
}

if ( ! function_exists( 'wolf_carousel_gallery' ) ) {
	/**
	 * Generate a simple carouel layout gallery
	 *
	 * @access public
	 * @param array $images
	 * @param string $link_type
	 * @param string $image_size
	 * @param string $padding
	 * @param int $columns
	 * @param string $hover_effect
	 * @param string $orderby
	 * @return string $output
	 */
	function wolf_carousel_gallery( $images = array(), $link_type = 'file', $image_size = 'wpb-2x1', $padding = 'no', $hover_effect = 'default', $orderby = '', $inline_style = '', $class = '' ) {

		wp_enqueue_script( 'owlcarousel' );
		wp_enqueue_script( 'wpb-carousels' );

		if ( 'rand' == $orderby ) {
			shuffle( $images );
		}

		$rand_id = rand( 0,999 );
		$selector = "wpb-gallery-$rand_id";

		$class .= " wolf-images-gallery wpb-clearfix wpb-carousel-gallery wpb-hover-$hover_effect owl-carousel";

		if ( 'yes' == $padding ) {
			$class .= " wpb-padding";
		}

		$output = '<div id="' . esc_attr( $selector ) . '" class="' . wpb_sanitize_html_classes( $class ) . '"';

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		$output .= '>';

		if ( array() != $images ) {

			foreach ( $images as $image_id ) {

				if ( is_numeric( $image_id ) ) {
					$image_id = absint( $image_id );
				} else {
					$image_id = wpb_get_id_from_attachment_url( esc_url( $image_id ) );
				}

				$attachment = get_post( $image_id );

				if ( ! $attachment ) {
					continue; // skip to the next id if the attachment doesn't exist
				}

				$image_url = esc_url( wpb_get_url_from_attachment_id( $image_id, $image_size ) );

				$file = esc_url( wpb_get_url_from_attachment_id( $image_id, 'wpb-XL' ) );
				$image_page = get_attachment_link( $image_id );
				$href = ( 'post' == $link_type || 'attachment' == $link_type ) ? $image_page : $file;
				$class = ( 'file' == $link_type ) ? 'wpb-lightbox wpb-image-inner' : 'wpb-image-inner';

				$title = wptexturize( $attachment->post_title );
				$post_excerpt = wpb_sample( wptexturize( $attachment->post_excerpt ), 88 );
				$title_attr = ( $post_excerpt ) ? $post_excerpt : '';

				$output .= "<div class='wpb-block'>";

				if ( 'none' != $link_type ) {
					
					$output .= "<a";

					if ( $title ) {
						$output .= ' title="' . esc_attr( $title_attr ) . '"';
					}

					$output .= ' href="' . esc_url( $href ) . '" class="' . wpb_sanitize_html_classes( $class ) . '" data-wpb-rel="' . esc_attr( $selector ) . '">';
				
				} else {
					$output .= '<span class="' . wpb_sanitize_html_classes( $class ) . '">';
				}
									
				$output .= '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $title ) . '">';

				if ( 'none' != $link_type ) {
					$output .= '</a>';
				} else {
					$output .= '</span>';
				}

				$output .= '</div><!--.wpb-block-->';
			}
		}

		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'wpb_mosaic_gallery' ) ) {
	/**
	 * Generate a mosaic layout gallery
	 *
	 * @access public
	 * @param array $images
	 * @param string $link_type
	 * @param string $hover_effect
	 * @param string $orderby
	 * @param bool $carousel
	 * @return string $output
	 */
	function wpb_mosaic_gallery( $images = array(), $link_type = 'file', $hover_effect = 'default', $orderby = '', $inline_style = '', $class = '' ) {

		if ( 'rand' == $orderby ) {
			shuffle( $images );
		}

		$rand_id = rand( 0,999 );
		$selector = "wpb-gallery-$rand_id";

		$class .= " wpb-images-gallery wpb-mosaic-gallery wpb-clearfix wpb-hover-$hover_effect";

		$output = '<div id="' . esc_attr( $selector ) . '" class="' . wpb_sanitize_html_classes( $class ) . '"';

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		$output .= '>';

		$i = 0;

		if ( array() != $images ) {

			foreach ( $images as $image_id ) {
				
				if ( $i%6 == 0) {
					if ( $i == 0 ) {
						$output .= "\n";
						$output .= '<div class="wpb-images-block">';
						$output .= "\n";
					} elseif ( $i != count( $images ) ) {
						$output .= '</div><!--.wpb-images-block-->';
						$output .= "\n";
						$output .= '<div class="wpb-images-block">';
						$output .= "\n";
					} else {
						$output .= '</div><!--.wpb-images-block-->';
						$output .= "\n";
					}
				}

				/* Images sizes */
				if ( $i%6 == 1) {
					$image_size = 'wpb-2x1';

				} elseif ($i%6 == 3 ) {
					$image_size = 'wpb-1x2';

				} elseif( $i%6 == 5 ) {
					$image_size = 'wpb-2x1';

				} else {
					$image_size = 'wpb-2x2';
				}

				$i++;

				$is_file = wpb_get_url_from_attachment_id( absint( $image_id ), $image_size );

				if ( is_numeric( $image_id ) && $is_file ) {
					$image_id = absint( $image_id );
					$image_url = wpb_get_url_from_attachment_id( absint( $image_id ), $image_size );
					$attachment = get_post( $image_id );
					$image_page = get_attachment_link( $image_id );
					$full_size  = esc_url( wpb_get_url_from_attachment_id( $image_id, 'wpb-XL' ) );
					$title = ( $attachment ) ? wptexturize( $attachment->post_title ) : '';
					$alt = ( $attachment ) ? esc_attr( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ) : '';
					$alt = ( $alt ) ? $alt : $title;
					$post_excerpt = ( $attachment ) ? wpb_sample( wptexturize( $attachment->post_excerpt ), 14 ) : '';
					$href = ( 'post' == $link_type || 'attachment' == $link_type ) ? $image_page : $full_size;
					$class = ( 'file' == $link_type ) ? 'wpb-lightbox wpb-image-inner' : 'wpb-image-inner';
				} else {
					$alt = $title = $post_excerpt = $href = '';
					$link_type = 'none';
					$class= 'wpb-image-inner';
					
					if ( wpb_is_url( $image_id ) ) {

						$image_url = esc_url( $image_id );

					} else {
						global $wpb_image_placeholders;
						$image_url = ( isset( $wpb_image_placeholders[ $image_size ] ) ) ? $wpb_image_placeholders[ $image_size ] : '';
					}
				}

				if ( 'none' != $link_type ) {
					$output .= "<a title='$title' href='$href' class='$class' data-wpb-rel='$selector'>";
				} else {
					$output .= "<span class='$class'>";
				}
									
				$do_lazy_load = wpb_get_option( 'settings', 'do_lazyload' );
				$src = ( $do_lazy_load ) ? WPB_URI . '/assets/img/blank.gif' : $image_url;
				$lazy_load = ( $do_lazy_load ) ? ' class="lazy-hidden" data-src="' . esc_url( $image_url ) . '"' : '';
				$output .= '<img' . $lazy_load . ' src="' . esc_url( $src ) . '" alt="' .esc_attr( $title ) . '">';

				if ( 'none' != $link_type ) {
					$output .= '</a>';
				} else {
					$output .= '</span>';
				}

			} // end for each

		}

		$output .= '</div>';
		$output .= "\n";
		$output .= '</div><!--.wpb-mosaic-gallery-->';

		if ( array() != $images ) {
			return $output;
		}
	}
}