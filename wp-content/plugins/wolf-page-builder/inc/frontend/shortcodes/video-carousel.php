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

if ( ! function_exists( 'wpb_shortcode_video_carousel' ) ) {
	/**
	 * Video shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_video_carousel( $atts ) {

		extract( shortcode_atts( array(
			'urls' => 'http://vimeo.com/86571319',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'owlcarousel' );
		wp_enqueue_script( 'wpb-carousels' );

		$urls = wpb_clean_spaces( wpb_decode_textarea( $urls ) );
		$urls = wpb_list_to_array( $urls );

		$class = $extra_class;
		$class = sanitize_text_field( $class );
		$inline_style = sanitize_text_field( $inline_style );

		$output = $style = '';

		$class .= ' wpb-video-carousel-container';


		$output .= '<div  class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $style ) . '">';
		$output .= '<div class="wpb-video-carousel">';

		foreach ( $urls as $url) {
			$output .= '<div class="item-video" data-merge="2"><a class="owl-video" href="' . esc_url( $url ) . '"></a></div>';
		}

		$output .= '</div><!-- .wpb-video-carousel -->';

		$output .= '</div><!-- .wpb-video-carousel-container -->';

		return $output;
	}
	add_shortcode( 'wpb_video_carousel', 'wpb_shortcode_video_carousel' );
}