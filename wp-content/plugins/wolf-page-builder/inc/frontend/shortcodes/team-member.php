<?php
/**
 * Team member shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_team_member' ) ) {
	/**
	 * Team Member
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_team_member( $atts ) {
		
		global $wpb_team_member_socials, $ti_icons;

		extract( shortcode_atts( array(
			'image' => '',
			'image_style' => '',
			'image_size' => 'wpb-2x1',
			'alignment' => '',
			'name' => '',
			'title_tag' => 'h3',
			'role' => '',
			'tagline' => '',
			'show_socials' => '',
			'animation' => '',
			'animation_delay' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$image_size = sanitize_text_field( $image_size );
		$image_style = sanitize_text_field( $image_style );
		$name = sanitize_text_field( $name );
		$tagline = wpb_decode_textarea( $tagline );
		$role = sanitize_text_field( $role );
		$alignment = esc_attr( $alignment );
		$animation = sanitize_text_field( $animation );
		$animation_delay = absint( $animation_delay );
		$inline_style = sanitize_text_field( $inline_style );
		$title_tag = esc_attr( $title_tag );

		foreach ( $wpb_team_member_socials as $social ) {
			$default_atts[ $social ] = '';
		}

		if ( 'round' == $image_style ) {
			$image_size = 'wpb-2x2';
		}

		$style = '';
		$class = $extra_class;
		$class .= "wpb-team-member-container wpb-text-$alignment";

		if ( 'round' == $image_style )
			$class .= " wpb-round";

		if ( $animation ) {
			$class .= " wow $animation";
		}
			

		if ( $animation_delay && 'none' != $animation ) {
			$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
		}

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		$style = ( $style ) ? " style='$style'" : '';

		$output = "<div class='$class'$style>";

		if ( is_numeric( $image ) ) {
			
			$src = wpb_get_url_from_attachment_id( absint( $image ), $image_size );
		} else {
			$src = esc_url( $image );
		}

		if ( $src ) {
			$output .= '<div class="wpb-team-member-image"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( esc_html__( 'team member', 'wolf-page-builder' ) ) . '"></div>';
		}

		$headings_array = array( 'h2', 'h3', 'h4', 'h5', 'h6' );
		$title_tag = ( in_array( $title_tag, $headings_array ) ) ? $title_tag : 'h3';

		if ( $name ) {
			$output .= "<$title_tag class='wpb-team-member-name'>$name</$title_tag>";
		}

		if ( $role ) {
			$output .= "<span class='wpb-team-member-role'>$role</span>";
		}

		if ( $tagline ) {
			$output .= "<div class='wpb-team-member-tagline'><p>$tagline</p></div>";
		}

		if ( 'show' == $show_socials ) {
			$output .= '<div class="wpb-team-member-social-container">';

			foreach ( $wpb_team_member_socials as $social ) {
				if ( ! empty( $atts[ $social ] ) ) {
					$prefix = ( in_array( 'ti-' . $social, array_keys( $ti_icons ) ) ) ? 'ti' : 'fa fa';
					$output .= "<a href='" . $atts[ $social ] . "' class='$prefix-$social wpb-team-member-social' title='$social' target='_blank'></a>";
				}
			}

			$output .= '</div><!--.wpb-team-member-social-container-->';
		}

		$output .= '</div>';

		return $output;
	}
	add_shortcode( 'wpb_team_member', 'wpb_shortcode_team_member' );
}