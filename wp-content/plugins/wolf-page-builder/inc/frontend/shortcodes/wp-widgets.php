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

if ( ! function_exists( 'wpb_shortcode_wp_widget' ) ) {
	/**
	 * Widget shortcode
	 *
	 * Output any WP widget with a shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_wp_widget( $atts ) {

		extract( shortcode_atts( array(
			'title' => '',
			'text' => '',
			'widget_id' => '',
			'sortby' => '',
			'exclude' => '',
			'sortby' => '',
			'dropdown' => '',
			'count' => '',
			'hierarchical' => '',
			'taxonomy' => '',
			'url' => '',
			'items' => '',
			'show_summary' => '',
			'show_author' => '',
			'show_date' => '',
			'number' => '',
			'nav_menu' => '',
		), $atts ) );

		// set options array
		$options = array();

		if ( 'WP_Widget_Text' == $widget_id ) {
			
			$options['title'] = sanitize_text_field( $title );
			$options['text'] = wpb_decode_textarea( $text );

		} elseif( 'WP_Widget_Pages' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );
			$options['sortby'] = sanitize_text_field( $sortby );
			$options['exclude'] = sanitize_text_field( $exclude );

		} elseif( 'WP_Widget_Archives' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );
			$options['dropdown'] = sanitize_text_field( $dropdown );
			$options['count'] = absint( $count );


		} elseif( 'WP_Widget_Categories' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );
			$options['dropdown'] = sanitize_text_field( $dropdown );
			$options['count'] = absint( $count );
			$options['hierarchical'] = sanitize_text_field( $hierarchical );

		} elseif( 'WP_Widget_Recent_Posts' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );
			$options['number'] = sanitize_text_field( $number );
			$options['show_date'] = sanitize_text_field( $show_date );
		
		} elseif( 'WP_Widget_Recent_Comments' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );
			$options['number'] = sanitize_text_field( $number );

		} elseif( 'WP_Widget_RSS' == $widget_id ) {

			$options['url'] = sanitize_text_field( $url );
			$options['title'] = sanitize_text_field( $title );
			$options['items'] = absint( $items );
			$options['show_summary'] = sanitize_text_field( $show_summary );
			$options['show_author'] = sanitize_text_field( $show_author );
			$options['show_date'] = sanitize_text_field( $show_date );

		} elseif( 'WP_Widget_Tag_Cloud' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );
			$options['taxonomy'] = sanitize_text_field( $dropdown );

		} elseif( 'WP_Widget_Calendar' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );

		} elseif( 'WP_Widget_Meta' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );

		} elseif( 'WP_Widget_Search' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );
		
		} elseif( 'WP_Nav_Menu_Widget' == $widget_id ) {

			$options['title'] = sanitize_text_field( $title );
			$options['nav_menu'] = esc_attr( $nav_menu );
		}

		$rand = rand( 0, 9999 );
		$widget_class = strtolower( str_replace( 'WP_', '', $widget_id ) );
		$before_widget_title_shortcode = '<h3 class="widget-title">';
		$after_widget_title_shortcode = '</h3>';
		$before_widget_shortcode = '<aside class="wpb-widget widget ' . sanitize_html_class( $widget_class ) . '"><div class="widget-content">';
		$after_widget_shortcode = '</div></aside>';

		ob_start();
		the_widget( $widget_id, $options, array(
			'widget_id'=> 'wpb-wp-widget-' . $rand,
			'before_widget' => $before_widget_shortcode,
			'after_widget' => $after_widget_shortcode,
			'before_title' => $before_widget_title_shortcode,
			'after_title' => $after_widget_title_shortcode,
		) );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	$widgets = array( 'text', 'pages', 'calendar', 'archives', 'meta', 'categories', 'recent-posts', 'recent-comments', 'rss', 'tag_cloud', 'search', 'nav_menu', );

	foreach ( $widgets as $widget ) {
		add_shortcode( 'wpb_wp_widget_' . $widget, 'wpb_shortcode_wp_widget'  );
	}
}