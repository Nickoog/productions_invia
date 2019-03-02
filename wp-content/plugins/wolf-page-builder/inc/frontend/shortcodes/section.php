<?php
/**
 * Section shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_section' ) ) {
	/**
	 * Section Shortcode
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	function wpb_shortcode_section( $atts, $content = null ) {

		$output = $overlay_style = $inner_style = '';

		extract( shortcode_atts(  array(
			'section_type' => 'columns',
			'layout' => '2-cols',
			'skin' => 'dark',
			'background_color' => '',
			'background_type' => 'image',
			'background_img' => '',
			'background_position' => 'center center',
			'background_repeat' => 'no-repeat',
			'background_size' => 'cover',
			'background_effect' => '',
			'parallax' => '',
			'parallax_img' => '',
			'video_bg_type' => '',
			'video_bg_youtube_url' => '',
			'video_bg_vimeo_url' => '',
			'video_bg_mp4' => '',
			'video_bg_webm' => '',
			'video_bg_ogv' => '',
			'video_bg_img' => '',
			'video_bg_controls' => '',
			'slideshow_img_ids' => '',
			'slideshow_speed' => 4000, 
			'margin' => '',
			'padding_top' => '',
			'padding_bottom' => '',
			'full_height' => '',
			'arrow_down' => '',
			'arrow_down_style' => 'round',
			'arrow_down_text' => '',
			'overlay' => '',
			'overlay_image' => '',
			'overlay_color' => '',
			'overlay_opacity' => '100',
			'anchor' => '',
			'inline_style' => '',
			'extra_class' => '',
			'hide_class' => '',
		), $atts ) );

		$_image = ''; //  bg image URL var

		// class
		$class = $extra_class;
		$class .= " wpb-section wpb-section-$section_type";

		if ( 'blocks' == $section_type ) {
			$class .= " wpb-section-$layout";
		}

		if ( 'columns' == $section_type ) {
			$class .= " wpb-font-$skin";
		}

		if ( $hide_class ) {
			$class .= " $hide_class";
		}

		if ( $video_bg_mp4 ) {
			$class .= ' wpb-section-video-bg';
		}

		if ( $full_height ) {
			$class .= ' wpb-section-full-height';
		}

		if ( 'transparent' == $background_type ) {
			$class .= ' wpb-section-transparent-bg';
		}

		if ( 'slideshow' == $background_type ) {
			$class .= ' wpb-section-slideshow-bg';
		}

		// style
		$section_style = $inline_style;
		
		if ( 'image' == $background_type ) {

			if ( $background_color ) {
				$class .= ' wpb-section-has-bg-color';
				$section_style .= 'background:none;';
				$section_style .= 'background-color:' . wpb_sanitize_hex_color( $background_color ) . ';';
			}

			// Background effect
			$parallax = ( 'parallax' == $background_effect );
			
			if ( $background_img ) {

				if ( is_numeric( $background_img ) ) {

					$_image = wpb_get_url_from_attachment_id( $background_img, 'wpb-XL' );

				} else {
					$_image = esc_url( $background_img );
				}
				
				if ( $parallax && 'image' == $background_type && $_image ) {
					$class .= ' wpb-section-parallax';
				}

				if ( $background_img ) {
					$section_style .= 'background-image:url(' . esc_url( $_image ) . ');';
				}

				if ( $background_position ) {

					$section_style .= 'background-position:' . esc_attr( $background_position ) . ';';
				}

				if ( $background_repeat ) {
					$section_style .= 'background-repeat:' . esc_attr( $background_repeat ) . ';';
				}

				
				if ( $background_size == 'resize' ) {

					$section_style .= "-webkit-background-size: 100%; -o-background-size: 100%;-moz-background-size: 100%; background-size: 100%;";
				
				} elseif ( $background_size ) {
					
					$section_style .= 'background-size:' . esc_attr( $background_size ) . ';';
				}
			}

		} // endif image background

		// inner style
		if ( '' != $padding_top ) {
			$padding_top = ( is_numeric( $padding_top ) ) ? absint( $padding_top ) . 'px' : $padding_top;
			$inner_style .= 'padding-top:' . esc_attr( $padding_top ) . ';';
		}

		if ( '' != $padding_bottom ) {
			$padding_bottom = ( is_numeric( $padding_bottom ) ) ? absint( $padding_bottom ) . 'px' : $padding_bottom;
			$inner_style .= 'padding-bottom:' . esc_attr( $padding_bottom ) . ';';
		}

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

		// container style
		$container_style = '';
		if ( '' != $margin ) {
			$margin = ( is_numeric( $margin ) ) ? absint( $margin ) . 'px' : $margin;
			$container_style .= 'padding:' . $margin . ';';
		}
		
		// start section
		$output .= '<section class="wpb-section-container" style="' . wpb_esc_style_attr( $container_style ) . '">';
		$output .= '<div';

		if ( $anchor ) {
			$output .= ' id="' . esc_attr( $anchor ) . '"';
		}

		if ( $section_style ) {
			$output .= ' style="' . wpb_esc_style_attr( $section_style ) . '"';
		}
		
		$output .= ' class="' . wpb_sanitize_html_classes( $class ) . '"';

		$output .= '>';

			// parallax NEW
			if ( $_image && $parallax ) {
				$output .= '<div class="wpb-parallax-window" data-natural-width="" data-natural-height="" data-background-url="' . esc_url( $_image ) . '"></div>';
			} 

			// video background		
			if ( 'video' == $background_type ) {
				
				if ( $video_bg_img ) {
					if ( is_numeric( $video_bg_img ) ) {
						
						$video_bg_img = wpb_get_url_from_attachment_id( absint( $video_bg_img ), 'wpb-XL' );
					
					} else {
						$video_bg_img = esc_url( $video_bg_img );
					}
				}
				
				if ( $video_bg_mp4 && 'selfhosted' == $video_bg_type ) {
					
					if ( $video_bg_controls ) {
						$output .= '<ul class="wpb-video-bg-controls">';
							$output .= '<li class="wpb-video-bg-play-button"></li>';
							$output .= '<li class="wpb-video-bg-mute-button"></li>';
						$output .= '</ul>';
					}
					
					$output .= wpb_video_bg( $video_bg_mp4, $video_bg_webm, $video_bg_ogv, $video_bg_img );
				}
				
				elseif( $video_bg_youtube_url && 'youtube' == $video_bg_type ) {
					
					$output .= wpb_youtube_video_bg( $video_bg_youtube_url, $video_bg_img );
				}

				elseif( $video_bg_vimeo_url && 'vimeo' == $video_bg_type ) {
					
					$output .= wpb_vimeo_video_bg( $video_bg_vimeo_url, $video_bg_img );
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
				$output .= '<div class="wpb-section-overlay" style="' . wpb_esc_style_attr( $overlay_style ) . '"></div>';
			}
			
			$output .= '<div class="wpb-section-inner"';

			if ( $inner_style ) {
				$output .= ' style="' . wpb_esc_style_attr( $inner_style ) . '"';
			}

			$output .= '>';
			
			if ( 'blocks' == $section_type ) {
				$output .= '<div class="wpb-blocks-wrapper">';
			}
				$output .= do_shortcode( $content );

			if ( 'blocks' == $section_type ) {
				$output .= '</div><!--.wpb-blocks-wrapper-->';
			}
			
			$output .= "\n"; // end section wrap
			$output .= '</div><!--.wpb-section-inner-->';
			$output .= "\n"; // end section inner

			/* scroll to next seciton arrow */
			if ( $arrow_down && $full_height ) {
				
				$output .= '<span class="wpb-arrow-down wpb-arrow-down-' . esc_attr( $arrow_down_style ) . '" style="animation-delay: 2s;">';

				if ( $arrow_down_text ) {
					$output .= '<span class="wpb-arrow-down-text">';
					$output .= $arrow_down_text;
					$output .= '</span>';
				}

				$output .= '</span>';
			}

		$output .= '</div><!--.wpb-section-->';
		$output .= '</section><!--.wpb-section-container-->';

		return $output;
	}
	add_shortcode( 'wpb_section', 'wpb_shortcode_section' );
}