<?php
/**
 * Facebook like button
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_facebook_like' ) ) {
	/**
	 * Tabs container shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_facebook_like( $atts ) {

		extract( shortcode_atts( array(
			'type' => '',
			'anchor' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$url = get_permalink();
		$output = '<div id="' . esc_attr( $anchor ) . '" class="' . wpb_sanitize_html_classes( $extra_class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '"><iframe src="http://www.facebook.com/plugins/like.php?href='
			. esc_url( $url ) . '&amp;layout='
			. $type . '&amp;show_faces=false&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>';

		return $output;

	}
	add_shortcode( 'wpb_facebook_like', 'wpb_shortcode_facebook_like' );
}