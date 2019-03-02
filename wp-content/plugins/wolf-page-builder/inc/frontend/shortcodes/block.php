<?php
/**
 * Blocks shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_block' ) ) {
	/**
	 * Block shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_block( $atts, $content = null ) {

		extract( shortcode_atts(  array(
			'skin' => 'dark',
			'background_color' => '',
			'background_type' => 'image',
			'background_img' => '',
			'background_position' => 'center center',
			'background_repeat' => 'no-repeat',
			'background_size' => 'cover',
			'video_bg_type' => '',
			'video_bg_youtube_url' => '',
			'video_bg_mp4' => '',
			'video_bg_webm' => '',
			'video_bg_ogv' => '',
			'video_bg_img' => '',
			'slideshow_img_ids' => '',
			'slideshow_speed' => 4000, 
			'content_type' => 'text',
			'overlay' => '',
			'overlay_image' => '',
			'overlay_color' => '',
			'overlay_opacity' => '100',
			'anchor' => '',
			'extra_class' => '',
			'inline_style' => '',
		), $atts ) );

		$output = $overlay_style = '';

		// class
		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= "wpb-block wpb-block-$content_type wpb-font-$skin";


		if ( 'transparent' == $background_type ) {
			$class .= ' wpb-block-transparent-bg';
		}

		if ( 'image' == $background_type ) {

			$_image = '';
			if ( $background_img ) {

				if ( is_numeric( $background_img ) ) {
					$_image = wpb_get_url_from_attachment_id( $background_img, 'wpb-XL' );
				} else {
					$_image = esc_url( $background_img );
				}
			}

			if ( $background_color ) {
				$class .= ' wpb-block-has-bg-color';
				$inline_style .= 'background-color:' . wpb_sanitize_hex_color( $background_color ) . ';';
			}

			if ( $background_img ) {
				$inline_style .= 'background-image:url(' . esc_url( $_image ) . ');';
			}

			if ( $background_position ) {

				$inline_style .= 'background-position:' . esc_attr( $background_position ) . ';';
			}

			if ( $background_repeat ) {
				$inline_style .= 'background-repeat:' . esc_attr( $background_repeat ) . ';';
			}

			if ( $background_size == 'resize' ) {

				$inline_style .= "-webkit-background-size: 100%; -o-background-size: 100%;-moz-background-size: 100%; background-size: 100%;";
			
			} elseif ( $background_size ) {
				
				$inline_style .= 'background-size:' . esc_attr( $background_size ) . ';';
			}
		} // endif image background


		// overlay style
		$overlay_opacity = ( $overlay_opacity ) ? absint( $overlay_opacity ) / 100 : .4;

		if ( $overlay ) {
			$_overlay_image = '';
			if ( $overlay_image != '' && $overlay_image != ' ' ) {
				$_overlay_image = wolf_get_url_from_attachment_id( $overlay_image, 'wpb-XL' );
			}
			if ( $overlay_color ) {
				$overlay_style .= 'background-color:' . wpb_sanitize_hex_color( $overlay_color ) . ';';
			}
			if ( $overlay_image ) {
				$overlay_style .= 'background-image:url(' . esc_url( $_overlay_image ) . ');';
			}
			$overlay_style .= "opacity:$overlay_opacity;";
		}

		$output .= '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';

		// video background
		if ( 'video' == $background_type ) {
			
			$video_bg_img = ( $video_bg_img ) ? wpb_get_url_from_attachment_id( absint( $video_bg_img ), 'wpb-XL' ) : null;

			if ( $video_bg_mp4 && 'selfhosted' == $video_bg_type ) {
				
				$output .= wpb_video_bg( $video_bg_mp4, $video_bg_webm, $video_bg_ogv, $video_bg_img );
			}
			
			elseif ( $video_bg_youtube_url && 'youtube' == $video_bg_type ) {
				
				$output .= wpb_youtube_video_bg( $video_bg_youtube_url, $video_bg_img );
			}
		}

		// slideshow background
		if ( 'slideshow' == $background_type ) {

			wp_enqueue_script( 'flexslider' );
			wp_enqueue_script( 'wpb-sliders' );

			$image_ids = wpb_list_to_array( $slideshow_img_ids );

			if ( array() != $image_ids ) {

				$output .= '<div data-slideshow-speed="' . absint( $slideshow_speed ) . '" class="wpb-section-slideshow-background"><ul class="slides">';
				
				foreach ( $image_ids as $image_id ) {
					$src  = esc_url( wpb_get_url_from_attachment_id( $image_id, 'wpb-XL' ) );

					$output .= '<li style="background-image:url(' . $src . ')"></li>';
				}
			
				$output .= '</ul></div>';
			}
		}

		// overlay
		if ( $overlay ) {
			$output .= '<div class="wpb-block-overlay" style="' . wpb_esc_style_attr( $overlay_style ) . '"></div>';
		}

		$output .= '<div class="wpb-block-content">';
		$output .= '<div class="wpb-block-inner">' . do_shortcode( $content ) . '</div><!-- .wpb-block-inner -->';
		$output .= '</div><!-- .wpb-block-content --></div><!-- .wpb-block -->';

		return $output;
	}
	add_shortcode( 'wpb_block', 'wpb_shortcode_block'  );
}