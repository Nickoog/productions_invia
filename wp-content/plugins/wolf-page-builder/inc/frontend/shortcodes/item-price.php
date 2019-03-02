<?php
/**
 * Item price shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_item_price' ) ) {
	/**
	 * Item price shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_item_price_shortcode( $atts ) {
		
		extract( shortcode_atts(  array(
			'layout' => 'text',
			'image' => '',
			'title' => '',
			'title_tag' => 'h3',
			'tagline' => '',
			'price' => '',
			'content' => '',
			'animation' => '',
			'animation_delay' => '',
			'anchor' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		// class
		$class = $extra_class;
		$class .= " wpb-item-price wpb-clearfix wpb-item-price-layout-$layout";

		if ( $animation ) {
			$class .= ' wow ' . esc_attr( $animation );
		}

		if ( $animation_delay && 'none' != $animation ) {
			$inline_style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		$output = '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		$class_text = '';
		$class_image = '';

		if ( 'small-image' == $layout ) {

			$class_image = 'wpb-alpha wpb-col-2';
			$class_text = 'wpb-omega wpb-col-10';

		} elseif ( 'medium-image' == $layout ) {
			
			$class_image = 'wpb-alpha wpb-col-6';
			$class_text = 'wpb-omega wpb-col-6';
		}

		if ( $image && 'text' != $layout ) {
			
			if ( is_numeric( $image ) ) {
			
				$src = wpb_get_url_from_attachment_id( absint( $image ), 'wpb-2x2' );
				$full_size_src = wpb_get_url_from_attachment_id( absint( $image ), 'wpb-XL' );
			} else {

				$src = esc_url( $image );
				$full_size_src = '';
				if( wpb_get_full_size_image_url_from_thumbnail_url( $image ) ) {
					$full_size_src = wpb_get_full_size_image_url_from_thumbnail_url( $image );
				}
			}

			$output .= '<div class="wpb-item-price-image-container ' . wpb_sanitize_html_classes( $class_image ) . '">';
			$output .= '<a class="wpb-lightbox" href="' . esc_url( $full_size_src ) . '" title="' . esc_attr( $title ) . '" data-wpb-rel="' . esc_attr( 'item-price' ) . '">';
			$output .= '<img class="wpb-item-price-image" src="' . esc_url( $src ) . '" alt="' . esc_attr( $title ) . '">';
			$output .= '</a>';
			$output .= '</div><!--.wpb-item-price-image-container-->';
		}

		$output .= '<div class="wpb-item-price-text ' . wpb_sanitize_html_classes( $class_text ) . '">';

		if ( $title ) {
			$output .= '<div class="wpb-item-price-title-container">';

				$output .= '<div class="wpb-item-price-title">' . sanitize_text_field( $title ) . '</div>';

				$output .= '<div class="wpb-item-price-dots"></div>';

			if ( $price ) {
				$output .= '<div class="wpb-item-price-price">' . sanitize_text_field( $price ) . '</div>';
			}

			$output .= '</div>';
		}

		$output .= '<div class="wpb-clear"></div>';

		// if ( $tagline ) {
		// 	$output .= '<span class="wpb-item-price-tagline">' . sanitize_text_field( $tagline ) . '</span>';
		// }

		if ( $content ) {
			$output .= '<span class="wpb-item-price-content">' . sanitize_text_field( $content ) . '</span>';
		}

		$output .= '</div><!--.wpb-item-price-text-->';

		$output .= '</div><!--.wpb-item-price-->';

		return $output;
	}
	add_shortcode( 'wpb_item_price', 'wpb_item_price_shortcode' );
}