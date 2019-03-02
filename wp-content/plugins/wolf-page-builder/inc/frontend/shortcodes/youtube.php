<?php
/**
 * YouTube shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_youtube' ) ) {
	/**
	 * YouTube shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_youtube( $atts ) {

		extract( shortcode_atts( array(
			'title' => '',
			'url' => '',
			'image' => '',
			'video_preview' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'wpb-youtube' );

		$output = '';
		$class = $extra_class;
		$inline_style = sanitize_text_field( $inline_style );
		$embed = wp_oembed_get( $url );

		$class .= "wpb-youtube-container";

		$output .= '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) .'">';

		$output .= $embed;

		$output .= '<div class="wpb-youtube-cover">';

		if ( $image && ! $video_preview ) {
			$image_url = wpb_get_url_from_attachment_id( $image, 'wpb-XL' );
			$output .= '<div class="wpb-youtube-cover-image" style="background-image:url(' . esc_url( $image_url ) . ');"></div>';
		}

		if ( $video_preview ) {
			$image_url = ( $image ) ?  wpb_get_url_from_attachment_id( $image, 'wpb-XL' ) : null;
			$output .= wpb_video_bg( $video_preview, null, null, $image_url );
		}

		$output .= '<span class="wpb-youtube-play-button"><i class="fa fa-youtube-play" aria-hidden="true"></i>';

		$output .= sprintf( esc_html__( 'Watch %s', 'wolf-page-builder' ), $title );

		$output .= '</span><!-- .wpb-youtube-play-button -->';

		$output .= '</div><!-- .wpb-youtube-cover -->';
		
		$output .= '</div><!-- .wpb-youtube-container -->';

		return $output;
	}
	add_shortcode( 'wpb_youtube', 'wpb_shortcode_youtube' );
}