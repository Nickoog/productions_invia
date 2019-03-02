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

if ( ! function_exists( 'wpb_shortcode_tweet_this' ) ) {
	/**
	 * Tabs container shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_tweet_this( $atts ) {

		extract( shortcode_atts( array(
			'type' => '',
			'anchor' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$class = $extra_class;
		$class .= ' twitter-share-button';

		$output = '<a href="http://twitter.com/share" class="'
		. wpb_sanitize_html_classes( $class ) . '" data-count="'
		. $type . '">'
		. esc_html__( 'Tweet', 'wolf-page-builder' ) . '</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';

		
		return $output;
	}
	add_shortcode( 'wpb_tweet_this', 'wpb_shortcode_tweet_this' );
}