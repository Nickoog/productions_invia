<?php
/**
 * Testimonials slider shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_testimonials' ) ) {
	/**
	 * Testimonials slider shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_testimonials( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'title' => '',
			'autoplay' => 'yes',
			'transition' => 'auto',
			'slideshow_speed' => 4000,
			'pause_on_hover' => 'yes',
			'animation' => '',
			'animation_delay' => '',
			'nav_bullets' => 'yes',
			'nav_arrows' => 'yes',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'owlcarousel' );
		wp_enqueue_script( 'wpb-carousels' );

		$autoplay = esc_attr( $autoplay );
		$transition = esc_attr( $transition );
		$slideshow_speed = absint( $slideshow_speed );
		$pause_on_hover = esc_attr( $pause_on_hover );
		$animation_delay = absint( $animation_delay );
		$nav_bullets = esc_attr( $nav_bullets );
		$nav_arrows = esc_attr( $nav_arrows );
		$inline_style = sanitize_text_field( $inline_style );
		$title = esc_attr( $title );
		$style = '';
		$class = $extra_class;
		$class .= ' wpb-testimonials-container';

		if ( $animation )
			$class .= " wow $animation";

		if ( $animation_delay && 'none' != $animation ) {
			$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		$style = ( $style ) ? " style='$style'" : '';


		$slider_data = "data-pause-on-hover='$autoplay'
				data-autoplay='$autoplay'
				data-transition='$transition'
				data-slideshow-speed='$slideshow_speed'
				data-nav-arrows='$nav_arrows'
				data-nav-bullets='$nav_bullets'";

		$output = '<section  class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $style ) . '">';
		$output .= "<div $slider_data class='wpb-testimonials-slider'>";

		$output .= do_shortcode( $content );

		$output .= '</div></section>';

		return $output;
	}
	add_shortcode( 'wpb_testimonials', 'wpb_shortcode_testimonials' );
}

if ( ! function_exists( 'wpb_shortcode_testimonial' ) ) {
	/**
	 * Testimonial shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_testimonial( $atts ) {

		extract( shortcode_atts(  array(
			'name' => '',
			'avatar' => '',
			'text' => '',
			'link' => '',
		), $atts ) );


		$cite = '<cite class="wpb-testimonial-cite">';

		if ( $avatar ) {
			
			if ( is_numeric( $avatar ) ) {
			
				$avatar = wpb_get_url_from_attachment_id( absint( $avatar ), 'wpb-2x2' );
			
			} else {

				$avatar = wpb_get_image_by_size_from_url( esc_url( $avatar ), 'wpb-2x2' );
			}
		}

		if ( $name )
			$cite .= sanitize_text_field( $name );

		if ( $link ) {
			$link = esc_url( $link );
			$cite .= " | <a href='$link' target='_blank'>$link</a>";
		}

		$cite .= '</cite>';

		$output = "<div class='slide'><div class='wpb-testimonal-container'>";

		if ( $avatar ) {
			$output .= '<span class="wpb-testimonial-avatar"><img src="' . esc_url( $avatar ) . '" alt="testimonial-avatar"></span>';
		}

		$output .= "<blockquote class='wpb-testimonial-content'><p>";
		$output .= wpb_decode_textarea( $text );
		$output .= $cite;
		$output .= '<p></blockquote>';
		$output .= '</div>
		</div>';

		return $output;
	}
	add_shortcode( 'wpb_testimonial', 'wpb_shortcode_testimonial' );
}