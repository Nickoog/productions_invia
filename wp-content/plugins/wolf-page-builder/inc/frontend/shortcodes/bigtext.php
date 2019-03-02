<?php
/**
 * BigText shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_bigtext' ) ) {
	/**
	 * BigText shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_bigtext( $atts ) {

		extract( shortcode_atts( array(
			'font_family' => '',
			'letter_spacing' => 0,
			'font_weight' => 700,
			'text_transform' => 'none',
			'color' => '',
			'animation' => '',
			'animation_delay' => '',
			'text' => '',
			'link_url' => '',
			'link_target' => '',
			'title_tag' => 'h4',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'bigtext' );

		$class = $extra_class;
		$text_transform = esc_attr( $text_transform );
		$font_weight = absint( $font_weight );
		$letter_spacing = preg_replace( "/[^0-9-]/", '', $letter_spacing );

		$url = esc_attr( $link_url );
		$do_link = ( 'http://' != $url && $url );

		$class .= ' wpb-bigtext wpb-text-center wpb-clearfix';

		$style = sanitize_text_field( $inline_style );
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

		$lines = wpb_texarea_lines_to_array( $text );

		if ( array() != $lines ) {

			$output = '<' . esc_attr( $title_tag ) .'';
			$output .= ' style="' . wpb_esc_style_attr( $style ) . '" class="' . wpb_sanitize_html_classes( $class ) . '">';
			
			if ( $do_link ) {
				$target = ( $link_target ) ? '_blank' : '_parent';
				// $output .= '<a style="' . wpb_esc_style_attr( $style ) . '" class="wpb-bigtext-link" href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '">';
			}
			
			foreach( $lines as $line ) {
				if ( $do_link ) {
					$output .= '<a class="wpb-bigtext-link" href="' . esc_attr( $url ) . '" target="' . esc_attr( $target ) . '">';

				} else {
					$output .= '<span>';
				}

				$output .= $line;
			
				if ( $do_link ) {
					$output .= '</a>';
				} else {
					$output .= '</span>';
				}
			}

			$output .= '</' . esc_attr( $title_tag ) .'>';
			return $output;
		}
	}
	add_shortcode( 'wpb_bigtext', 'wpb_shortcode_bigtext' );
}