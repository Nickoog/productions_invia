<?php
/**
 * Skill bar shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_skill_bar' ) ) {
	/**
	 * Skill bar shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_skill_bar( $atts ) {

		extract( shortcode_atts(  array(
			'label' => '',
			'value' => '',
			'color' => '#333',
			'text_color' => '#fff',
			'title_tag' => 'h5',
			'anchor' => '',
			'extra_class' => '',
			'inline_style' => '',
		), $atts ) );

		/// wp_enqueue_script( 'wpb-toggles', WPB_JS . '/toggles.js', array( 'jquery' ), WPB_VERSION, true );

		$output = '';

		$bar_id = 'wpb-skill-' . sanitize_title( $label ) . '-' . rand( 0, 99 ) ;

		$css = '<style type="text/css">

				.wpb-skill-bar{
					transition: width 1s ease-out;
					-moz-transition: width 1s ease-out;
		    			-webkit-transition: width 1s ease-out;
		    			background : ' . $color . ';
				}

				.wpb-skill-title{

				}

				.' . $bar_id . '{
					width :0;
					
				}

				.wpb-skill-bar.animated.' . $bar_id . '{
					width : '. absint( $value ) .'%;
				}

			</style>';

		$output .= wpb_clean_spaces( $css );

		$class = $extra_class;
		$class .= ' wpb-skill-bar-container';

		$output .= '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $inline_style ) . '">';
		$output .= '<div class="wpb-skill">
				<span class="' . $bar_id . ' wpb-skill-bar wow"></span>
				<' . esc_attr( $title_tag ) . ' class="wpb-skill-title">'  . $label .'</' . esc_attr( $title_tag ) . '>
				<span class="wpb-skill-value">' . absint( $value ) .'%</span>
			</div>';
		$output .= '</div><!--.wpb-skill-bar-container-->';

		return $output;
	}
	add_shortcode( 'wpb_skill_bar', 'wpb_shortcode_skill_bar' );
}