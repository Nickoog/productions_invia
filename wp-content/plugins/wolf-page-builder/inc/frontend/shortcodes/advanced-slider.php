<?php
/**
 * Advanced slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_advanced_slider' ) ) {
	/**
	 * Image slider shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_advanced_slider( $atts, $content = null ) {

		extract( shortcode_atts( array(
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
			'slider_height' => '100%',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'wpb-advanced-slider' );
		wp_enqueue_script( 'wpb-sliders' );
		wp_enqueue_script( 'fittext' );
		wp_enqueue_script( 'buttons' );

		$slider_height_unit = 'px';

		// percent
		if ( '%' == substr( $slider_height, -1) ) {
			$slider_height_unit = '%';

			if ( 100 < absint( $slider_height ) ) {
				$slider_height = 100;
			}
		// em
		} elseif ( 'em' == substr( $slider_height, -2) ) {
			$slider_height_unit = 'em';
		
		//px
		} elseif ( 'px' == substr( $slider_height, -2) ) {
			$slider_height_unit = 'px';
		}

		$slider_height = absint( $slider_height );

		// debug( $slider_height );

		$output = '';
		$style = '';
		$rand = rand( 0, 9999 );

		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= "wpb-images-slider-container wpb-advanced-slider-container";

		if ( '100%' == $slider_height ) {
			$class .= ' wpb-fullscreen-slider';
		}

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		$slider_data = "
		data-autoplay='$autoplay'
		data-transition='$transition'
		data-slideshow-speed='$slideshow_speed'
		data-nav-arrows='$nav_arrows'
		data-nav-bullets='$nav_bullets'
		data-height='$slider_height'
		data-height-unit='$slider_height_unit'
		data-pause-on-hover='$pause_on_hover'";

		$output .= '<div class="wpb-slider-style-container" style="' . wpb_esc_style_attr( $style ) . '">';
			$output .= '<div class="' . wpb_sanitize_html_classes( $class ) . '">';
				$output .= "<div $slider_data class='flexslider wpb-advanced-slider' id='wpb-advanced-slider-$rand'>";
					$output .= '<ul class="slides">';

						$output .= do_shortcode( $content );

					$output .= '</ul><!--.slides-->';
				$output .= '</div><!--.wpb-images-slider-->';
			$output .= '</div><!--.wpb-images-slider-container-->';
		$output .= '</div><!--.wpb-slider-style-container-->';

		return $output;

	}
	add_shortcode( 'wpb_advanced_slider', 'wpb_shortcode_advanced_slider' );
}

if ( ! function_exists( 'wpb_shortcode_advanced_slide' ) ) {
	/**
	 * Testimonial shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_advanced_slide( $atts ) {

		extract( shortcode_atts( array(
			'font_color' => 'light',
			'background_color' => '',
			'background_type' => 'image',
			'background_img' => '',
			'background_position' => 'center center',
			'background_repeat' => 'no-repeat',
			'background_size' => 'cover',
			'background_effect' => '',
			'video_bg_type' => '',
			'video_bg_youtube_url' => '',
			'video_bg_vimeo_url' => '',
			'video_bg_mp4' => '',
			'video_bg_webm' => '',
			'video_bg_ogv' => '',
			'video_bg_img' => '',
			'video_bg_controls' => '',
			'overlay' => '',
			'overlay_image' => '',
			'overlay_color' => '',
			'overlay_opacity' => '',
			'title_type' => 'text',
			'title_font_family' => '',
			'title' => '',
			'image' => '',
			'image_size' => 'large',
			'caption_type' => 'text',
			'caption_width' => 'large',
			'caption_position' => 'large',
			'caption' => '',
			'caption_alignment' => 'center',
			'button_1' => '',
			'button_1_text' => '',
			'button_1_link_url' => '#',
			'button_1_link_target' => '',
			'button_1_color' => '',
			'button_1_color_hover' => '',
			'button_1_type' => '',
			'button_1_custom_style' => 'no',
			'button_1_size' => 'medium',
			'button_1_shape' => '',
			'button_1_tagline' => '',
			'button_2' => '',
			'button_2_text' => '',
			'button_2_link_url' => '#',
			'button_2_link_target' => '',
			'button_2_color' => '',
			'button_2_color_hover' => '',
			'button_2_type' => '',
			'button_2_custom_style' => 'no',
			'button_2_size' => 'medium',
			'button_2_shape' => '',
			'button_2_tagline' => '',
			'button_2_text' => '',
		), $atts ) );

		$output = $image_url = $overlay_style = $slide_style_attr = '';
		$rand = rand( 0, 9999 );
		
		$slide_class = "slide wpb-advanced-slide wpb-slide-caption-width-$caption_width wpb-slide-caption-position-$caption_position wpb-slide-caption-text-align-$caption_alignment wpb-font-$font_color";

		if ( $background_color ) {
			$slide_style_attr .= 'background-color:' . wpb_sanitize_hex_color( $background_color ) . ';';
		}

		if ( 'image' == $background_type ) {

			if ( $background_img ) {

				$is_file = wpb_get_url_from_attachment_id( absint( $background_img ), 'wpb-XL' );

				if ( is_numeric( $background_img ) && $is_file ) {
					
					$image_url = wpb_get_url_from_attachment_id( absint( $background_img ), 'wpb-XL' );
				
				} else {

					if ( wpb_is_url( $background_img ) ) {

						$image_url = esc_url( $background_img );

					} else {
						global $wpb_image_placeholders;
						$image_url = ( $wpb_image_placeholders[ 'wpb-XL' ] ) ? $wpb_image_placeholders[ 'wpb-XL' ] : '';
					}
				}
			}
					
		} elseif ( 'video' == $background_type ) {

			$slide_class .= ' wpb-video-slide';

			if ( is_numeric( $video_bg_img ) ) {
				$image_url = wpb_get_url_from_attachment_id( $video_bg_img, 'wpb-XL' );
			}
		}

		if ( $image_url ) {
			$slide_style_attr .= 'background-position:' . $background_position . ';';
			$slide_style_attr .= 'background-repeat:' . $background_repeat . ';';
			$slide_style_attr .= 'background-image:url( ' . esc_url( $image_url ) . ' );-webkit-background-size: 100%; -o-background-size: 100%; -moz-background-size: 100%; background-size: 100%;-webkit-background-size: cover; -o-background-size: cover; background-size: cover;';
		}

		// overlay style
			$overlay_opacity = ( $overlay_opacity ) ? absint( $overlay_opacity ) / 100 : .4;

			if ( $overlay && ( 'image' == $background_type && $image_url || 'video' == $background_type && ( $video_bg_mp4 || $video_bg_youtube_url )  ) ) {
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

		$output .= '<li id="wpb-advanced-slide-' . absint( $rand ) . '" class="' . wpb_sanitize_html_classes( $slide_class ) . '" style="' . wpb_esc_style_attr( $slide_style_attr ) . '">';			
		
			// overlay
			if ( $overlay ) {
				$output .= '<div class="wpb-slide-overlay" style="' . wpb_esc_style_attr( $overlay_style ) . '"></div>';
			}

			if ( 'video' == $background_type ) {

				$output .= '<div class="wpb-slide-video-container">';

				//$video_bg_type = 'youtube';

				if ( 'youtube' == $video_bg_type ) {

					if ( $video_bg_youtube_url ) {
						//wpb_youtube_video_bg( $video_bg_youtube_url, $video_bg_img );
					}
				
				} else {

					$output .= '<video';
					$output .= ' data-video-id="' . absint( $rand ) . '"';
					$output .= ' data-video-mute="true"';
					$output .= ' data-video-play=""';
					$output .= ' id="wpb-slide-video-' . absint( $rand ) . '" class="wpb-slide-video" preload="auto" muted loop>';
					
					if ( $video_bg_webm ) {
						$output .= '<source src="' . esc_url( $video_bg_webm ) . '" type="video/webm">';
					}

					if ( $video_bg_mp4 ) {
						$output .= '<source src="' . esc_url( $video_bg_mp4 ) . '" type="video/mp4">';
					}

					if ( $video_bg_ogv ) {
						$output .= '<source src="' . esc_url( $video_bg_ogv ) . '" type="video/ogg">';
					}

					if ( $image_url ) {
						$output .= '<img src="' . esc_url( $image_url ) . '" alt="video-fallback">';
					}
				}
											
				$output .= '</video></div><!-- .wpb-slide-video-container -->';
			}

			if ( $video_bg_controls && 'video' == $background_type && $video_bg_mp4 )  {
				$output .= '<ul class="wpb-slide-video-bg-controls">';
				$output .= "<li class='wpb-slide-video-play-button' data-video-play-id='$rand'></li>";
				$output .= "<li class='wpb-slide-video-mute-button' data-video-mute-id='$rand'></li>";
				$output .= '</ul>';
			}

			$output .= '<div class="wpb-slide-caption-container">';

				$output .= '<div class="wpb-slide-caption">';

					$output .= '<div class="wpb-slide-caption-inner">';

					$output .= '<div class="wpb-slide-caption-wrapper">';


			if ( 'text' == $title_type ) {

				$title_inline_style = '';

				if ( $title_font_family ) {
					$title_inline_style = 'font-family:' . $title_font_family . ';';
				}

				if ( $title ) {
					$output .= '<h3 style="' . esc_attr( $title_inline_style ) . '" class="wpb-slide-title wpb-fittext">' . sanitize_text_field( $title ) . '</h3>';
				}
							
			} elseif ( 'image' == $title_type && $image ) {

				if ( $image ) {

					if ( is_numeric( $image ) ) {
						$image_url = esc_url( wpb_get_url_from_attachment_id( absint( $image ), esc_attr( $image_size ) ) );
					} else {
						$image_url = esc_url( $image );
					}

					$output .= '<div class="wpb-slide-image"><img src="' . $image_url . '" alt="' . esc_attr( strip_tags( wpb_decode_textarea( $caption ) ) ) . '"></div><div class="wpb-clear"></div>';
				}
			}

			if ( $caption ) {
				$output .= '<div class="wpb-slide-caption-text wpb-slide-caption-text-type-' . esc_attr( $caption_type ) . '">' . wpb_decode_textarea( $caption ) . '</div>';
			}

			if ( $button_1 || $button_2 ) {
				$output .= '<div class="wpb-slide-button-container">';
			}

			$button_1_args = array(
				'text' =>$button_1_text,
				'link_url' =>$button_1_link_url,
				'tagline' =>$button_1_tagline,
				'color' =>$button_1_color,
				'color_hover' =>$button_1_color_hover,
				'type' =>$button_1_type,
				'shape' =>$button_1_shape,
				'size' =>$button_1_size,
				'link_target' => $button_1_link_target,
			);

			if ( $button_1 ) {
				$output .= wpb_do_button( $button_1_args );
			}

			$button_2_args = array(
				'text' =>$button_2_text,
				'link_url' =>$button_2_link_url,
				'tagline' =>$button_2_tagline,
				'color' =>$button_2_color,
				'color_hover' =>$button_2_color_hover,
				'type' =>$button_2_type,
				'shape' =>$button_2_shape,
				'size' =>$button_2_size,
				'link_target' => $button_2_link_target,
			);

			if ( $button_2 ) {
				$output .= wpb_do_button( $button_2_args );
			}

			if ( $button_1 || $button_2 ) {
				$output .= '</div><!--.wpb-slide-button-container-->';
			}
			
		$output .= '</div><!-- .wpb-slide-caption-wrapper --></div><!-- .wpb-slide-inner --></div><!-- .wpb-slide-caption --></div><!-- .wpb-slide-caption-container --></li><!--.slide-->';

		return $output;
	}
	add_shortcode( 'wpb_advanced_slide', 'wpb_shortcode_advanced_slide' );
}