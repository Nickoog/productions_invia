<?php
/**
 * Tabs shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_tab_container' ) ) {
	/**
	 * Tabs container shortcode
	 *
	 * @param array $atts
	 * @param array $content
	 * @return string
	 */
	function wpb_shortcode_tab_container( $atts, $content = null ) {
		extract( shortcode_atts(  array(
			'anchor' => '',
			'extra_class' => '',
			'inline_style' => '',
		), $atts ) );

		$output = '';
		$class = $extra_class;
		$class = ' wpb-tabs wpb-clearfix';
		$rand = rand( 0,9999 );

		wp_enqueue_script( 'jquery-ui-tabs', true );
		wp_enqueue_script( 'wpb-tabs' );

		$GLOBALS['wpb_tab_count'] = 0;
		$i = 0;
		do_shortcode( $content );

		if ( is_array( $GLOBALS['tabs'] ) ) {
			foreach( $GLOBALS['tabs'] as $tab ) {
				$i++;
				$tabs[] = '<li><a class="" href="#wpb-tab-' . $i . '">' . sanitize_text_field( $tab['title'] ) . '</a></li>';
				$panes[] = '<div id="wpb-tab-' . $i . '">' . do_shortcode( $tab['content'] ) . '</div>';
			}
				$return = "\n".'<!-- tabs -->
				<ul class="wpb-tabs-menu">' . implode( "\n", $tabs ) . '</ul>
				<div class="wpb-clear"></div>
				<div class="wpb-tabs-container">' . implode( "\n", $panes ) . '</div>' . "\n";
		}
		$output .= '<div id="wpb-tabs-' . absint( $rand ) . '" class="' . wpb_sanitize_html_classes( $class ) . '">' . $return . '</div>';

		return $output;
	}
	add_shortcode( 'wpb_tab_container', 'wpb_shortcode_tab_container' );
}

if ( ! function_exists( 'wpb_shortcode_tab' ) ) {
	/**
	 * Tab shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_tab( $atts ) {
		
		extract( shortcode_atts( array(
			'title' => 'Tab %d',
			'editorcontent' => '',
		), $atts ) );

		$count = $GLOBALS['wpb_tab_count'];
		
		$GLOBALS['tabs'][ $count ] = array(
			'title' => sprintf( $title, $GLOBALS['wpb_tab_count'] ),
			'content' => wpb_format_editor_content( $editorcontent ),
		);

		$GLOBALS['wpb_tab_count']++;
	}
	add_shortcode( 'wpb_tab', 'wpb_shortcode_tab' );
}