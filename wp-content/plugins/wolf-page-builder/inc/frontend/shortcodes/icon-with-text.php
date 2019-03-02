<?php
/**
 *  Icon with text shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_icon_with_text' ) ) {
	/**
	 * Icon with text shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_icon_with_text( $atts ) {
		extract( shortcode_atts(  array(
			'icon_size'             		=> '',
			'use_custom_icon_size'  	=> '',
			'custom_icon_size'      		=> '',
			'custom_icon_size_inner'	=> '',
			'custom_icon_margin'    	=> '',
			'icon'                  		=> '',
			'icon_animation'        		=> '',
			'icon_animation_delay'  	=> '',
			'image'                 		=> '',
			'icon_type'             		=> 'normal',
			'icon_position'         		=> '',
			'custom_style'			=> 'no',
			'icon_margin'           		=> '',
			'box_type'              		=> '',
			'box_border_color'      		=> '',
			'box_background_color'  	=> '',
			'title'                 			=> '',
			'title_font_size'                 	=> '',
			'title_tag'             		=> 'h5',
			'title_color'           		=> '',
			'text'                  			=> '',
			'text_color'            		=> '',
			'link_url'                  		=> '',
			'link_target'                		=> '',
			'link_text'             		=> '',
			'link_color'            		=> '',
			'hover_effect' 			=> 'none',
			'custom_style'			=> 'no',
			'bg_color' 			=> '',
			'icon_color' 			=> '',
			'border_color' 			=> '',
			'bg_color_hover' 		=> '',
			'icon_color_hover'		=> '',
			'border_color_hover' 		=> '',
			'animation'			=> '',
			'animation_delay' 		=> '',
			'inline_style' 			=> '',
			'extra_class'			=> '',
		), $atts ) );

		wp_enqueue_script( 'wpb-icons' );

		$class = $extra_class;
		$output = '';
		$icon_html = '';
		$title_html = '';
		$p_style = '';
		$icon_style = '';
		$title_style = '';
		$box_style = '';
		$text = wpb_decode_textarea_html( $text );

		if ( $inline_style ) {
			$box_style .= $inline_style;
		}

		if ( $animation_delay && 'none' != $animation ) {
			$box_style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		$style = '';
		$style .= ( $icon_animation_delay ) ? 'animation-delay:' . absint( $icon_animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $icon_animation_delay ) / 1000 . 's;' : '' ;

		$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6', 'span' );
		$title_tag = ( in_array( $title_tag, $headings_array ) ) ? esc_attr( $title_tag ) : 'h3';

		switch ( $icon_size ) {

			case 'fa-2x':
				$box_size = 'small';
				break;
			case 'fa-3x':
				$box_size = 'medium';
				break;
			case 'fa-4x':
				$box_size = 'large';
				break;
			case 'fa-5x':
				$box_size = 'very-large';
				break;
			default:
				$box_size = 'tiny';
		}

		$box_class = "$class wpb-icon-box wpb-clearfix wpb-icon-position-$icon_position wpb-icon-box-$box_size wpb-icon-type-$icon_type";

		if ( $animation ) {
			$box_class .= " wow $animation";
		}
			
		$icon_container_class = 'wpb-icon-container ' .  $icon_size;

		if ( 'normal' != $icon_type ) {
			$icon_container_class .= ' fa-stack';
		}

		//debug( $icon_container_class );

		$data = '';
		$data_icon_hover_color = '';
		
		if ( 'yes' == $custom_style ) {

			if ( $bg_color )
				$style .= "background-color:$bg_color;";

			if ( $icon_color )
				$icon_style .= "color:$icon_color;";

			if ( $icon_color_hover )
				$data_icon_hover_color .= $icon_color_hover;

			if ( $border_color )
				$style .= "border-color:$border_color;";

			// hover style
			if ( $bg_color_hover )
				$data .= " data-bg-hover-color='$bg_color_hover'";

			if ( $border_color_hover )
				$data .= " data-border-hover-color='$border_color_hover'";

			$p_style = ( $text_color ) ? "color:$text_color;" : '';
			$title_style = ( $title_color ) ? "color:$title_color;" : '';
		}

		if ( $icon_animation ) {
			$icon_container_class .= ' wow bounceIn';
		}

		$icon_container_class .= " wpb-hover-$hover_effect";

		$icon_container_class .= ( 'yes' == $custom_style ) ? ' wpb-icon-custom-style' : ' wpb-icon-no-custom-style';

		$open_icon_html_tag = 'div';

		if ( $link_url ) {
			$icon_html_link_target = ( $link_target ) ? ' target="_blank"' : '';
			$open_icon_html_tag = 'a href="' . esc_attr( $link_url ) . '"' . $icon_html_link_target;
		}

		$output .= '<' . $open_icon_html_tag .  ' class="' . wpb_sanitize_html_classes( $box_class ) .'" style="' . wpb_esc_style_attr( $box_style ) . '">';

		$icon_html .= '<div class="' . wpb_sanitize_html_classes( $icon_container_class ) . '" style="' . wpb_esc_style_attr( $style ) . '" ' . $data . '>';

			if ( 'circle' == $icon_type ) {

				$icon_html .= '<i data-icon-hover-color="' . wpb_esc_style_attr( $data_icon_hover_color ) . '" style="' . wpb_esc_style_attr( $icon_style ) . '" class="wpb-icon fa '. esc_attr( $icon ) . ' fa-stack-1x"></i>';

			} elseif ( 'square' == $icon_type ) {

				$icon_html .= '<i data-icon-hover-color="' . wpb_esc_style_attr( $data_icon_hover_color ) . '" style="' . wpb_esc_style_attr( $icon_style ) . '" class="wpb-icon fa '. esc_attr( $icon ) . ' fa-stack-1x"></i>';


			} elseif ( 'ban' == $icon_type ) {

				$icon_html .= '<i data-icon-hover-color="' . wpb_esc_style_attr( $data_icon_hover_color ) . '" style="' . wpb_esc_style_attr( $icon_style ) . '" class="wpb-icon fa '. esc_attr( $icon ) . ' fa-stack-1x"></i>';
				$icon_html .= '<i data-icon-hover-color="' . wpb_esc_style_attr( $data_icon_hover_color ) . '" style="' . wpb_esc_style_attr( $icon_style ) . '" class="wpb-icon fa fa-ban fa-stack-2x wpb-text-danger"></i>';

			} else {

				$icon_html .= '<i data-icon-hover-color="' . wpb_esc_style_attr( $data_icon_hover_color ) . '" style="' . wpb_esc_style_attr( $icon_style ) . '" class="wpb-icon fa '. esc_attr( $icon ) . '"></i>';
			}

		$icon_html .= '</div>'; // end icon container

		/**
		 *  Title tag
		 */
		if ( $title_font_size ) {
			$title_font_size = ( is_numeric( $title_font_size ) ) ? absint( $title_font_size ) . 'px' : $title_font_size;
			$title_style .= 'font-size:' . esc_attr( $title_font_size ) . ';';
		}
		
		$title_html .= '<' . esc_attr( $title_tag  ). ' style="' . wpb_esc_style_attr( $title_style ) . '" class="wpb-icon-title">';

		$title_html .= sanitize_text_field( $title );

		$title_html .= '</' . esc_attr( $title_tag ) . '>';

		/**
		 * Display the layout differently depending on the position option
		 */
		if ( 'left_from_title' == $icon_position ) {

			$output .= "<div class='wpb-icon-text-holder'>";
			$output .= "<div class='wpb-icon-text-inner'>";
			$output .= "<div class='wpb-icon-title-holder'>";
			$output .= "<div class='wpb-icon-holder'>";
			
			// icon
			$output .= wp_kses(
				$icon_html,
				array(
					'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
					'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
					'h1' => array( 'class' => array(), 'style' => array(), ),
					'h2' => array( 'class' => array(), 'style' => array(), ),
					'h3' => array( 'class' => array(), 'style' => array(), ),
					'h4' => array( 'class' => array(), 'style' => array(), ),
					'h5' => array( 'class' => array(), 'style' => array(), ),
					'h6' => array( 'class' => array(), 'style' => array(), ),
					'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
				)
			);
			$output .= '</div><! --.wpb-icon-holder-->';
			
			if ( $title ) {
				$output .= wp_kses(
					$title_html,
					array(
						'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
						'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
						'h1' => array( 'class' => array(), 'style' => array(), ),
						'h2' => array( 'class' => array(), 'style' => array(), ),
						'h3' => array( 'class' => array(), 'style' => array(), ),
						'h4' => array( 'class' => array(), 'style' => array(), ),
						'h5' => array( 'class' => array(), 'style' => array(), ),
						'h6' => array( 'class' => array(), 'style' => array(), ),
						'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
					)
				);
			}
			$output .= '</div><! --.wpb-icon-title-holder-->';
			
			if ( $text ) $output .= '<p style="' . wpb_esc_style_attr( $p_style ) . '">' . sanitize_text_field( $text ) . '</p>';
			
			$output .= '</div><! --.wpb-icon-text-inner-->';
			$output .= '</div><! --.wpb-icon-text-holder-->';

		} elseif ( 'right_from_title' == $icon_position ) {
			
			$output .= "<div class='wpb-icon-text-holder'>";
				$output .= "<div class='wpb-icon-text-inner'>";
				$output .= "<div class='wpb-icon-title-holder'>";
				
				if ( $title ) {
					$output .= wp_kses(
						$title_html,
						array(
							'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
							'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
							'h1' => array( 'class' => array(), 'style' => array(), ),
							'h2' => array( 'class' => array(), 'style' => array(), ),
							'h3' => array( 'class' => array(), 'style' => array(), ),
							'h4' => array( 'class' => array(), 'style' => array(), ),
							'h5' => array( 'class' => array(), 'style' => array(), ),
							'h6' => array( 'class' => array(), 'style' => array(), ),
							'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
						)
					);
				}
				$output .= "<div class='wpb-icon-holder'>";
				
				// icon
				$output .= wp_kses(
					$icon_html,
					array(
						'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
						'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
						'h1' => array( 'class' => array(), 'style' => array(), ),
						'h2' => array( 'class' => array(), 'style' => array(), ),
						'h3' => array( 'class' => array(), 'style' => array(), ),
						'h4' => array( 'class' => array(), 'style' => array(), ),
						'h5' => array( 'class' => array(), 'style' => array(), ),
						'h6' => array( 'class' => array(), 'style' => array(), ),
						'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
					)
				);
				$output .= '</div><!--.wpb-icon-holder-->';

				$output .= '</div><!--.wpb-icon-title-holder-->';
				
				if ( $text ) $output .= '<p style="' . wpb_esc_style_attr( $p_style ) . '">' . sanitize_text_field( $text ) . '</p>';
				
				$output .= '</div><!--.wpb-icon-text-inner-->';
			$output .= '</div><!--.wpb-icon-text-holder-->';

		} else {
			$output .= "<div class='wpb-icon-holder'>";
			
			// icon
			$output .= wp_kses(
				$icon_html,
				array(
					'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
					'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
					'h1' => array( 'class' => array(), 'style' => array(), ),
					'h2' => array( 'class' => array(), 'style' => array(), ),
					'h3' => array( 'class' => array(), 'style' => array(), ),
					'h4' => array( 'class' => array(), 'style' => array(), ),
					'h5' => array( 'class' => array(), 'style' => array(), ),
					'h6' => array( 'class' => array(), 'style' => array(), ),
					'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
				)
			);
			$output .= '</div>';

			$output .= "<div class='wpb-icon-text-holder'>";
			$output .= "<div class='wpb-icon-text-inner'>";
			
			if ( $title ) {
				$output .= wp_kses(
					$title_html,
					array(
						'i' => array( 'class' => array(), 'style' => array(), 'data-icon-hover-color' => array(), ),
						'div' => array( 'class' => array(), 'style' => array(), 'data-bg-hover-color' => array(), 'data-border-hover-color' => array(), ),
						'h1' => array( 'class' => array(), 'style' => array(), ),
						'h2' => array( 'class' => array(), 'style' => array(), ),
						'h3' => array( 'class' => array(), 'style' => array(), ),
						'h4' => array( 'class' => array(), 'style' => array(), ),
						'h5' => array( 'class' => array(), 'style' => array(), ),
						'h6' => array( 'class' => array(), 'style' => array(), ),
						'a' => array( 'href' => array(), 'target' => array(), 'style' => array(), 'class' => array(), ),
					)
				);
			}
			
			if ( $text ) $output .= '<p style="' . wpb_esc_style_attr( $p_style ) . '">' . sanitize_text_field( $text ) . '</p>';
			
			$output .= '</div><!--.wpb-icon-text-inner-->';
			$output .= '</div><!--.wpb-icon-text-holder-->';
		}

		$end_icon_html_tag = 'div';

		if ( $link_url ) {
			$end_icon_html_tag = 'a';
		}

		$output .= '</' . $end_icon_html_tag . '><!-- .wpb-icon-box -->';

		return $output;
	}
	add_shortcode( 'wpb_icon_with_text', 'wpb_shortcode_icon_with_text' );
}