<?php
/**
 * Image link shortcode
 *
 * 
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_image_link' ) ) {
	/**
	 * Image link
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_image_link( $atts ) {
		
		extract( shortcode_atts( array(
			'image' => '',
			'alignment' => 'center',
			'text_alignment' => 'center',
			'image_style' => '',
			'frame_style' => '',
			'full_size' => '',
			'link_url' => '',
			'link_target' => '',
			'text' => '',
			'secondary_text' => '',
			'secondary_text_button' => '',
			'overlay_color' => '#000',
			'overlay_opacity' => '33',
			'text_color' => '#fff',
			'text_tag' => 'h3',
			'font' => '',
			'image_size' => 'wpb-2x1',
			'animation' => '',
			'animation_delay' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$href = $image_css = '';
		$class = $extra_class;
		$image_class     = $class;
		$image_style     = sanitize_text_field( $image_style );
		$container_class = "wpb-linked-image wpb-text-$alignment $image_style $frame_style";
		$overlay_opacity = ( $overlay_opacity ) ? absint( $overlay_opacity ) / 100 : null;
		$text = sanitize_text_field( $text );

		$url = esc_url( $link_url );
		$title = esc_attr( $text );

		$secondary_text = sanitize_text_field( $secondary_text );
		
		$secondary_text_class = "wpb-linked-image-secondary-text text-$text_alignment $secondary_text_button";

		if ( $secondary_text_button ) {
			$secondary_text_class = ' wpb-linked-image-button';
		}

		$secondary_text = "<span class='$secondary_text_class' style='color:$text_color'>$secondary_text</span>";
		
		$text_color = ( $text_color ) ? sanitize_text_field( $text_color ) : '#fff';
		$caption = "<$text_tag class='wpb-linked-image-caption text-$text_alignment' style='color:$text_color'>$text</$text_tag>";

		if ( $inline_style ) {
			$image_css .= $inline_style;
		}

		if ( 'wpb-round' == $image_style ) {
			$image_size = 'wpb-2x2';
		}

		$image_css = ( $inline_style ) ? " style='$inline_style'" : '';

		if ( $animation ) {
			$container_class .= " wow $animation";
		}
		
		$is_file = wpb_get_url_from_attachment_id( absint( $image ), $image_size );

		if ( is_numeric( $image ) && $is_file ) {
			
			$src = wpb_get_url_from_attachment_id( absint( $image ), $image_size );

		} elseif( wpb_is_url( $image ) ) {

			$src = esc_url( $image );
		
		} else {

			global $wpb_image_placeholders;
			$src = ( isset( $wpb_image_placeholders[ $image_size ] ) ) ? $wpb_image_placeholders[ $image_size ] : '';
		}
		
		$output = "<div class='$container_class'>";

		if ( 'http://' != $url && $url ) {
			$link_target = ( $link_target ) ? 'target="' . esc_attr( $link_target ) . '"' : '';
			$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '"' . $link_target .' class="wpb-image-inner">';
		
		} else {
			$output .= "<div class='wpb-image-inner'>";
		}

		$output .= "<img src='$src' alt='single-image' $image_css class='$image_class'>";
		$output .= "<span class='wpb-linked-image-overlay' style='opacity:$overlay_opacity;background-color:$overlay_color'></span>";
		$output .= "<div class='wpb-linked-image-caption-container'><div class='wpb-linked-image-caption-table'>
		<div class='wpb-linked-image-caption-table-cell'>
		$caption
		$secondary_text
		</div>
		</div></div>";

		if ( $full_size || ( 'http://' != $link_url && $link_url ) )
			$output .= "</a>";

		else
			$output .= "</div>";

		$output .= '</div><!-- .wpb-linked-image -->';

		return $output;
	}
	add_shortcode( 'wpb_image_link', 'wpb_shortcode_image_link' );
}