<?php
/**
 * Video opener shortcode
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

if ( ! function_exists( 'wpb_shortcode_video_opener' ) ) {
	/**
	 * Video opener
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_video_opener( $atts ) {
		extract( shortcode_atts(  array(
			'custom_play_button' => '',
			'button_image' => '',
			'alignment' => 'center',
			'video_url' => '',
			'animation' => '',
			'animation_delay' => '',
			'anchor' => '',
			'extra_class' => '',
			'inline_style' => '',
		), $atts ) );

		$class = $extra_class;
		$container_class = " wpb-video-opener wpb-video-opener-align-$alignment";

		if ( ! $button_image ) {
			$class .= 'wpb-video-opener-default-image';
		}

		if ( $animation ) {
			$container_class .= " wow $animation";
		}

		if ( $animation_delay && $animation ) {
			$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		if ( $button_image && 'yes' == $custom_play_button ) {

			$src = wpb_get_url_from_attachment_id( absint( $button_image ), 'wpb-XL' );

		} else {
			$src = esc_url( WPB_IMG . '/play.png' ); // default image
		}

		$output = '<div class="' . wpb_sanitize_html_classes( $container_class ) . '">';
		
		if ( $video_url ) {
			$output .= '<a href="' . esc_url( $video_url ) . '" class="wpb-video-lightbox">';
		}
		
		$output .= '<img src="' . esc_url( $src ) . '" alt="video-opener-play-button"';
		
		if ( $anchor ) {
			$output .= ' id="' . esc_attr( $anchor ) . '"';
		}

		if ( $inline_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $inline_style ) . '"';
		}

		$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '"';

		$output .= '>';

		if ( $video_url ) {
			$output .= '</a>';
		}

		$output .= '</div><!-- .wpb-video-opener -->';

		return $output;
	}
	add_shortcode( 'wpb_video_opener', 'wpb_shortcode_video_opener' );
}