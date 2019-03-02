<?php
/**
 * Single image shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_image' ) ) {
	/**
	 * Image link
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_image( $atts ) {
		extract( shortcode_atts( array(
			'image' => '',
			'add_image_hover' => '',
			'image_hover' => '',
			'image_size' => 'large',
			'full_width' => '',
			'alignment' => 'center',
			'display_caption' => '',
			'hover_effect' => '',
			'link_type' => '',
			'link_url' => '',
			'link_target' => '',
			'scroll_to_anchor' => '',
			'animation' => '',
			'animation_delay' => 0,
			'anchor' => '',
			'extra_class' => '',
			'inline_style' => '',
		), $atts ) );

		$style 			= '';
		$image_url 		= '';
		$image_hover_url 	= '';
		$anchor		= esc_attr( $anchor );

		$class = $extra_class = $post_excerpt = '';
		$image_class     	= sanitize_html_class( $class );
		$container_class 	= "wpb-image wpb-image-align-$alignment wpb-hover-$hover_effect";

		$image_css = ( $inline_style ) ? " style='$inline_style'" : '';

		if ( $animation ) {
			$container_class .= " wow $animation";
		}

		if ( $animation_delay && $animation ) {
			$inline_style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		$output = '<div class="' . wpb_sanitize_html_classes( $container_class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		$image_id = $image;
		$image_hover_id = $image_hover;

		$is_file = wpb_get_url_from_attachment_id( absint( $image_id ), $image_size );

		if ( is_numeric( $image_id ) && $is_file ) {
			$image_id = absint( $image_id );
			$image_hover_id = absint( $image_hover_id );
			$image_url = wpb_get_url_from_attachment_id( absint( $image_id ), $image_size );
			$image_hover_url = wpb_get_url_from_attachment_id( absint( $image_hover_id ), $image_size );
			$attachment = get_post( $image_id );
			$image_page = get_attachment_link( $image_id );
			$full_size  = esc_url( wpb_get_url_from_attachment_id( $image_id, 'wpb-XL' ) );
			$title = ( $attachment ) ? wptexturize( $attachment->post_title ) : '';
			$alt = ( $attachment ) ? esc_attr( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ) : '';
			$alt = ( $alt ) ? $alt : $title;
			$post_excerpt = ( $attachment ) ? wpb_sample( wptexturize( $attachment->post_excerpt ), 14 ) : '';
			$href = ( 'post' == $link_type || 'attachment' == $link_type ) ? $image_page : $full_size;
			$class = ( 'file' == $link_type ) ? 'wpb-lightbox wpb-image-inner' : 'wpb-image-inner';

			if ( 'url' == $link_type ) {
				$href = $link_url;
			}
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
			
			if ( $scroll_to_anchor ) {
				$class .= ' wpb-scroll';
			}

			$output .= "<a title='$title' href='$href' class='$class'";

			if ( 'url' == $link_type && $link_target ) {
				$output .= " target='_blank'";
			}
			
			$output .= ">";
		} else {
			$output .= "<span class='$class'>";
		}

		$image_style = '';

		if ( $full_width ) {
			$image_style .= 'width:100%;';
		}
				
		if ( $image_url ) {
			$output .= '<img style="' . wpb_esc_style_attr( $image_style ) . '" src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $title ) . '" class="' . wpb_sanitize_html_classes( $extra_class ) . '">';

			if ( $add_image_hover && $image_hover_url ) {
				$output .= "<img src='$image_hover_url' alt='$title' class='wpb-image-hover-image'>";
			}
		}			

		if ( 'none' != $link_type ) {
			$output .= '</a>';
		} else {
			$output .= '</span>';
		}

		if ( $post_excerpt && $display_caption ) {
			$output .= '<span class="wpb-image-caption">' . sanitize_text_field( $post_excerpt ) . '</span>';
		}

		$output .= '</div><!--.wpb-image-->';

		return $output;
	}
	add_shortcode( 'wpb_image', 'wpb_shortcode_image' );
}