<?php
/**
 * Button shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_do_button' ) ) {
	/**
	 * Output a button with paramters from shortcode
	 *
	 * @param
	 * @return string $button
	 */
	function wpb_do_button( $args ) {

		$args = wp_parse_args( $args, array(
			'text' => '',
			'link_url' => '#',
			'link_target' => '',
			'tagline' => '',
			'color' => '',
			'color_hover' => '',
			'type' => 'flat',
			'shape' => 'default',
			'size' => 'medium',
			'custom_style' => 'no',
			'button_bg_color' => null,
			'button_font_color' => null,
			'button_border_color' => null,
			'button_bg_color_hover' => null,
			'button_font_color_hover' => null,
			'button_border_color_hover' => null,
			'add_icon' => false,
			'icon' => null,
			'icon_position' => 'before',
			'scroll_to_anchor' => '',
			'inline_style' => '',
			'class' => '',
			'id' => ''
		) );

		extract( $args );

		wp_enqueue_script( 'wpb-buttons' );

		$custom_button_type = false;
		$default_button_types = array(
			'wpb-flat',
			'wpb-outline',
			'wpb-outline-inverted',
		);

		$old_theme_button_type = ( $type == 'wolf-button' );

		if ( ! in_array( $type, $default_button_types ) ) {
			$custom_button_type = true;
		}

		// style
		$style = '';
		$data_bg_color = '';
		$data_font_color = '';
		$data_border_color = '';

		if ( 'yes' == $custom_style && ! $custom_button_type ) {
			if ( $button_bg_color ) {
				$style .= "background-color:$button_bg_color;";
			}

			if ( $button_font_color ) {
				$style .= "color:$button_font_color;";
			}

			if ( $button_border_color ) {
				$style .= "border-color:$button_border_color;";
			}

			// hover style
			if ( $button_bg_color_hover ) {
				$data_bg_color = " data-hover-bg-color='$button_bg_color_hover'";
			}

			if ( $button_font_color_hover ) {
				$data_font_color = " data-hover-font-color='$button_font_color_hover'";
			}

			if ( $button_border_color_hover ) {
				$data_border_color = " data-hover-border-color='$button_border_color_hover'";
			}
		}

		if ( $scroll_to_anchor ) {
			$href = $link_url;
		} else {
			$href = esc_url( $link_url );
		}

		if ( ! $old_theme_button_type ) {
			$class .= ' wpb-button';

			if ( $shape ) {
				$class .= ' wpb-' . $shape;
			}
		}

		// class
		if ( ! $custom_button_type ) {
			
			$class .= ( 'yes' == $custom_style ) ? ' wpb-button-custom-style' : '';
			$class .= ( ! $color && ! $color_hover ) ? ' wpb-button-default-color' : '';
		}

		$class .= ' wpb-button-' . $size;

		if ( 'no' == $custom_style ) {
			$class .= ' ' . $type;
		}

		$class .= ' wpb-button-icon-' . esc_attr( $icon_position );
		
		if ( $tagline ) {
			$class .= ' wpb-has-tagline';
		}

		if ( $scroll_to_anchor ) {
			$class .= ' wpb-scroll';
		}

		// icon
		$icon = ( 'yes' == $add_icon ) ? '<i class="fa ' . esc_attr( $icon ) . '"></i> ' : '';
		$tagline = ( $tagline ) ? '<span class="wpb-button-tagline">' . sanitize_text_field( $tagline ) . '</span>' : '';
		$button = '';
		$button .= '<a'; // beggin button

		if ( ! $custom_button_type ) {
			// main color
			if ( $color ) {
				$button .= ' data-color="' . wpb_sanitize_hex_color( $color ) . '"';
			}

			if ( $color_hover ) {
				$button .= ' data-color-hover="' . wpb_sanitize_hex_color( $color_hover ) . '"';
			}
			
			if ( $style ) {
				$button .= ' style="' . wpb_esc_style_attr( $style ) . '"';
			}
		}
		
		if ( $class ) {
			$button .= ' class="' . wpb_sanitize_html_classes( $class  ) . '"';
		}
		
		$button .= ' href="' . esc_url( $href ) . '"';
		
		if ( $link_target ) {
			$button .= ' target="_blank"';
		}
		$button .= sanitize_text_field( $data_bg_color . $data_font_color . $data_border_color );
		$button .= '>';

		if ( 'before' == $icon_position ) {
			$button .= $icon; // icon before
		}

		$button .= sanitize_text_field( $text ); // text

		if ( 'after' == $icon_position ) {
			$button .= $icon; // icon after
		}

		$button .= $tagline; // tagline

		$button .= '</a>'; // end button

		return $button;
	}
}

if ( ! function_exists( 'wpb_button_container_shortcode' ) ) {
	/**
	 * Buttons container shortcodes function
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	function wpb_button_container_shortcode( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'alignment' => 'left',
			'margin_top' => '',
			'margin_bottom' => '',
			'animation' => '',
			'animation_delay' => '',
			'anchor' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$style = '';
		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= 'wpb-button-container';

		if ( '' != $margin_top ) {
			$margin_top = is_numeric( $margin_top ) ? absint( $margin_top ) . 'px' : sanitize_text_field( $margin_top );
			$style .= "margin-top:$margin_top;";
		}

		if ( '' != $margin_bottom ) {
			$margin_bottom = is_numeric( $margin_bottom ) ? absint( $margin_bottom ) . 'px' : sanitize_text_field( $margin_bottom );
			$style .= "margin-top:$margin_bottom;";
		}

		if ( $animation ) {
			$class .= " wow $animation";
		}

		if ( $animation_delay && 'none' != $animation ) {
			$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		$class .= " wpb-text-$alignment";
		$output = '<div class="' . wpb_sanitize_html_classes( $class ) . '"';

		if ( $style ) {
			$output .= ' style="' . wpb_esc_style_attr( $style ) . '"';
		}

		$output .= '>';
		
		$output .= do_shortcode( $content );
		$output .= '</div>';
		return $output;
	}
	add_shortcode( 'wpb_button_container', 'wpb_button_container_shortcode' );

}

if ( ! function_exists( 'wpb_button') ) {
	/**
	 * Button shortcodes function
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_button( $atts ) {

		extract( shortcode_atts( array(
			'link_url' => '#',
			'link_target' => '',
			'color' => '',
			'color_hover' => '',
			'type' => 'flat',
			'custom_style' => 'no',
			'size' => 'medium',
			'full_width' => '',
			'shape' => '',
			'tagline' => '',
			'text' => '',
			'add_icon' => '',
			'icon' => '',
			'icon_position' => 'before',
			'custom_style' => 'no',
			'button_bg_color' => '',
			'button_font_color' => '',
			'button_border_color' => '',
			'button_bg_color_hover' => '',
			'button_font_color_hover' => '',
			'button_border_color_hover' => '',
			'alignment' => 'left',
			'scroll_to_anchor' => '',
			'inline_style' => '',
			'class' => '',
			'anchor' => '',
		), $atts ) );

		$container_class = "wpb-button-inner";

		if ( 'yes' == $full_width ) {
			$container_class .= ' wpb-full-width-button-inner';
		}

		$output = '<span class="' . wpb_sanitize_html_classes( $container_class ) . '">';

		$output .= wpb_do_button( $atts );

		$output .= '</span>';

		return $output;
	}
	add_shortcode( 'wpb_button', 'wpb_button' );
}