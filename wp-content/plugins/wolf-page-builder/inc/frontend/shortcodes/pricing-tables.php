<?php
/**
 * Pricing tables shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_pricing_tables' ) ) {
	/**
	 * Pricing Tables Shortcode
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	function wpb_shortcode_pricing_tables_container( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'columns' => '',
			'accent' => '',
			'inline_style' => '',
			'anchor' => '',
			'extra_class' => '',
		), $atts ) );

		$style = '';
		$class = $extra_class;
		$class = ( $class ) ? "$class " : ''; // add space
		$class .= 'wpb-pricing-tables wpb-clearfix wpb-pricing-tables-' . absint( $columns ) . '-cols';

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		$output = '<section class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $style ) . '">';

		$output .= do_shortcode( $content );

		$output .= '</section><!--.wpb-pricing-tables';

		return $output;
	}
	add_shortcode( 'wpb_pricing_tables_container', 'wpb_shortcode_pricing_tables_container' );
}

if ( ! function_exists( 'wpb_shortcode_pricing_table' ) ) {
	/**
	 * Pricing Table Shortcode
	 *
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	function wpb_shortcode_pricing_table( $atts, $content = null ) {

		extract( shortcode_atts(  array(
			'title' => '',
			'title_tag' => 'h3',
			'tagline' => '',
			'price' => '',
			'currency' => '',
			'display_currency' => 'before',
			'offer' => '',
			'offer_price' => '',
			'price_period' => '',
			'show_button' => '',
			'button_text' => __( 'Buy Now', 'wolf-page-builder' ),
			'link' => '',
			'target' => '',
			'featured' => '',
			'featured_text' => __( 'Best Choice', 'wolf-page-builder' ),
			'services' => '',
			'animation' => '',
			'animation_delay' => '',
			'inline_style' => '',
			'class' => '',
		), $atts ) );

		$class .= ' wpb-pricing-table-inner';
		$style = '';

		$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6' );
		$title_tag = ( in_array( $title_tag, $headings_array ) ) ? esc_attr( $title_tag ) : 'h3';

		if ( 'yes' == $featured ) {
			$class .= ' wpb-pricing-table-featured';
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

		$output = '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $style ) . '">';

		$output .= '<ul>';

		if ( $title ) {

			$output .= '<li class="wpb-pricing-table-title-cell">';

			if ( 'yes' == $featured ) {
				$output .= '<span class="wpb-pricing-table-featured-text"><span>' . sanitize_text_field( $featured_text ) . '</span></span>';
			}

			$output .= '<' . esc_attr( $title_tag ) . ' class="wpb-pricing-table-title">' . sanitize_text_field( $title ) . '</' . esc_attr( $title_tag ) . '>';

			if ( $tagline ) {
				$output .= '<span class="wpb-pricing-table-tagline">' . sanitize_text_field( $tagline ) . '</span>';
			}

			$output .= '</li>';
		}

		if ( $price ) {

			$output .= '<li class="wpb-pricing-table-main-content">';

			// Offer
			if ( 'yes' == $offer && $offer_price ) {

				$output .= '<span class="wpb-pricing-table-price-strike">';

				if ( $currency && 'before' == $display_currency ) {
					$output .= '<span class="wpb-pricing-table-currency-strike">' . sanitize_text_field( $currency ) . '</span>';
				}

				$output .= absint( $price );

				if ( $currency && 'after' == $display_currency ) {
					$output .= '<span class="wpb-pricing-table-currency-strike">' . sanitize_text_field( $currency ) . '</span>';
				}

				$output .= '</span>';

				if ( $currency && 'before' == $display_currency ) {
					$output .= '<span class="wpb-pricing-table-currency">' . sanitize_text_field( $currency ) . '</span>';
				}

				$output .= '<span class="wpb-pricing-table-price">' . sanitize_text_field( $offer_price ) . '</span>';

				if ( $currency && 'after' == $display_currency ) {
					$output .= '<span class="wpb-pricing-table-currency">' . sanitize_text_field( $currency ) . '</span>';
				}
			} else {

				if ( $currency && 'before' == $display_currency ) {
					$output .= '<span class="wpb-pricing-table-currency">' . sanitize_text_field( $currency ) . '</span>';
				}

				$output .= '<span class="wpb-pricing-table-price">' . sanitize_text_field( $price ) . '</span>';

				if ( $currency && 'after' == $display_currency ) {
					$output .= '<span class="wpb-pricing-table-currency">' . sanitize_text_field( $currency ) . '</span>';
				}
			}

			if ( $price_period ) {
				$output .= '<span class="wpb-pricing-table-price-period">' . sanitize_text_field( $price_period ) . '</span>';
			}

			$output .= '</li>';
		}

		if ( $services ) {
			$services = wpb_texarea_lines_to_array( $services );
			foreach ( $services as $service ) {
				$output .= '<li>';
				$output .= $service;
				$output .= '</li>';
			}
		}
		
		if ( $show_button ) {
			$output .= '<li class="wpb-pricing-table-button">';
			$output .= '<a href="' . esc_url( $link ) . '"';
			if ( $target ) {
				$output .= 'target="_blank"';
			}
			$output .= '>' . sanitize_text_field( $button_text ) . '</a>';
			$output .= '</li>';
		}

		$output .= '</ul>';

		$output .= '</div><!--.wpb-pricing-table-inner-->';

		return $output;

	}
	add_shortcode( 'wpb_pricing_table', 'wpb_shortcode_pricing_table' );
}