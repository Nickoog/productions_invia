<?php
/**
 * Images slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_slider' ) ) {
	/**
	 * Image slider shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_slider( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'ids' => '',
			'layout' => 'default',
			'autoplay' => '',
			'transition' => 'auto',
			'animation' => '',
			'animation_delay' => '',
			'autoplay' => 'yes',
			'transition' => 'auto',
			'slideshow_speed' => 4000,
			'pause_on_hover' => 'yes',
			'nav_bullets' => 'yes',
			'nav_arrows' => 'yes',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'wpb-sliders' );

		$images = wpb_list_to_array( $ids );

		$size = ( 'default' == $layout ) ? 'wpb-slide' : 'wpb-slide-' . $layout;

		$style = '';
		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= "wpb-images-slider-container wpb-slider-background-$layout";

		if ( $animation )
			$class .= " wow $animation";

		if ( $animation_delay && 'none' != $animation ) {
			$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		$slider_data = "data-pause-on-hover='$autoplay'
		data-autoplay='$autoplay'
		data-transition='$transition'
		data-slideshow-speed='$slideshow_speed'
		data-nav-arrows='$nav_arrows'
		data-nav-bullets='$nav_bullets'";

		$output = '';
		$output .= '<div class="wpb-slider-style-container" style="' . wpb_esc_style_attr( $style ) . '">';
		$output .= '<div class="' . wpb_sanitize_html_classes( $class ) . '">';
		$output .= "<div $slider_data class='flexslider wpb-images-slider'>";
		$output .= '<ul class="slides">';

		foreach ( $images as $image_id ) {
			
			$is_file = wpb_get_url_from_attachment_id( absint( $image_id ), $size );

			if ( is_numeric( $image_id ) && $is_file ) {
				$image_id = absint( $image_id );
				$image_url = wpb_get_url_from_attachment_id( absint( $image_id ), $size );
				$attachment = get_post( $image_id );
				$alt = ( $attachment ) ? esc_attr( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ) : '';
				$post_excerpt = ( $attachment ) ? wpb_sample( wptexturize( $attachment->post_excerpt ), 14 ) : '';
			} else {
				global $wpb_image_placeholders;
				$image_url = ( $wpb_image_placeholders[ $size ] ) ? $wpb_image_placeholders[ $size ] : '';
				$alt = $post_excerpt = $href = '';

				if ( wpb_is_url( $image_id ) ) {

					$image_url = esc_url( $image_id );

				} else {
					global $wpb_image_placeholders;
					$image_url = ( isset( $wpb_image_placeholders[ $size ] ) ) ? $wpb_image_placeholders[ $size ] : '';
				}
			}

			$output .= '<li class="slide">';
			$output .= '<img src="' . esc_url( $image_url ) . '" alt="' . esc_url( $alt ) . '">';
			if ( $post_excerpt )
				$output .= '<p class="flex-caption">' . sanitize_text_field( $post_excerpt ) . '</p>';
			$output .= '</li><!--.slide-->';
		}

		$output .= '</ul><!--.slides-->';
		$output .= '</div><!--.wpb-images-slider-->';
		$output .= '</div><!--.wpb-images-slider-container-->';
		$output .= '</div><!--.wpb-slider-style-container-->';

		return $output;

	}
	add_shortcode( 'wpb_slider', 'wpb_shortcode_slider' );
}
