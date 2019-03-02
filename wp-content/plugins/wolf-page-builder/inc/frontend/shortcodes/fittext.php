<?php
/**
 * Headline shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_headline' ) ) {
	/**
	 * Headline shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_headline( $atts ) {

		extract( shortcode_atts( array(
			'max_font_size' => 72,
			'font_family' => '',
			'letter_spacing' => 0,
			'font_weight' => 700,
			'text_transform' => 'none',
			'color' => '',
			'animation' => '',
			'animation_delay' => '',
			'text' => '',
			'title_tag' => 'h4',
			'link_url' => '',
			'link_target' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'fittext' );

		$class = $extra_class;
		$text_transform = esc_attr( $text_transform );
		$font_weight = absint( $font_weight );
		$letter_spacing = preg_replace( "/[^0-9-]/", '', $letter_spacing );

		$url = esc_attr( $link_url );
		$do_link = ( 'http://' != $url && $url );

		$class .= ' wpb-fittext wpb-text-center wpb-clearfix';

		$style = 'line-height:1;';
		$style .= 'font-weight:' . absint( $font_weight ) . ';';
		$style .= 'letter-spacing:' . absint( $letter_spacing ) . 'px;';

		if ( $font_family ) {
			$style .= 'font-family:' . esc_attr( $font_family ) . ';';
		}

		if ( $text_transform ) {
			$style .= 'text-transform:' . esc_attr( $text_transform ) . ';';
		}

		if ( $color ) {
			$style .= 'color:' . wpb_sanitize_hex_color( $color ) . ';';
		}

		if ( $animation ) {
			$class .= " wow $animation";
		}

		if ( $animation_delay && 'none' != $animation ) {
			$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		$output = '<' . esc_attr( $title_tag ) .'';
		
		$output .= ' style="' . wpb_esc_style_attr( $style ) . '" class="' . wpb_sanitize_html_classes( $class ) . '" data-max-font-size="' . absint( $max_font_size ) . '">';
		
		if ( $do_link ) {
			$link_target = ( $link_target ) ? '_blank' : '_parent';
			$output .= '<a style="' . wpb_esc_style_attr( $style ) . '" class="wpb-fittext-link" href="' . esc_url( $url ) . '" target="' . esc_attr( $link_target ) . '">';
		}

		$output .= sanitize_text_field( $text );

		if ( $do_link ) {
			$output .= '</a>';
		}
		
		$output .= '</' . esc_attr( $title_tag ) .'>';
		
		return $output;
	}
	add_shortcode( 'wpb_headline', 'wpb_shortcode_headline' );
}