<?php
/**
 * MailChimp shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_mailchimp' ) ) {
	/**
	 * MailChimp
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_mailchimp( $atts ) {
		
		extract( shortcode_atts( array(
			'list' => wpb_get_option( 'mailchimp', 'default_mailchimp_list_id' ),
			'size' => 'normal',
			'label' => wpb_get_option( 'mailchimp', 'label' ),
			'submit' => wpb_get_option( 'mailchimp', 'subscribe_text', esc_html__( 'Subscribe', 'wolf-page-builder' ) ),
			'bottom_line' => wpb_get_option( 'mailchimp', 'bottom_line' ),
			'image_id' => wpb_get_option( 'mailchimp', 'background' ),
			'use_bg' => true,
			'placeholder' =>  wpb_get_option( 'mailchimp', 'placeholder', esc_html__( 'enter your email address', 'wolf-page-builder' ) ),
			'button_style' => '',
			'alignment' => 'center',
			'text_alignment' => 'center',
			'enqueue_script' => true,
			'animation' => '',
			'animation_delay' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$use_bg = wpb_shortcode_bool( $use_bg );

		return wpb_mailchimp( $atts );
	}
	add_shortcode( 'wpb_mailchimp', 'wpb_shortcode_mailchimp' );
}

/**
 * Return a mailchimp Subscription form
 *
 * @param string $list
 * @param string $size
 * @param string $label
 * @param string $submit
 * @return string $output
 */
function wpb_mailchimp( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'list' => wpb_get_option( 'mailchimp', 'default_mailchimp_list_id' ),
		'size' => 'normal',
		'label' => wpb_get_option( 'mailchimp', 'label' ),
		'submit' => wpb_get_option( 'mailchimp', 'subscribe_text', esc_html__( 'Subscribe', 'wolf-page-builder' ) ),
		'bottom_line' => wpb_get_option( 'mailchimp', 'bottom_line' ),
		'image_id' => wpb_get_option( 'mailchimp', 'background' ),
		'use_bg' => true,
		'placeholder' =>  wpb_get_option( 'mailchimp', 'placeholder', esc_html__( 'enter your email address', 'wolf-page-builder' ) ),
		'button_style' => '',
		'alignment' => 'center',
		'text_alignment' => 'center',
		'animation' => '',
		'animation_delay' => '',
		'enqueue_script' => true,
		'inline_style' => '',
		'extra_class' => '',
	) );

	extract( $args );

	if ( $enqueue_script && ! wp_script_is( 'wpb-mailchimp' ) ) {
		wp_enqueue_script( 'wpb-mailchimp' );
		// add JS global variables
		wp_localize_script(
			'wpb-mailchimp', 'WPBMailchimpParams', array(
				'ajaxUrl' => esc_url( WPB()->ajax_url() ),
			)
		);
	}

	$use_bg = wpb_shortcode_bool( $use_bg );

	$class = ( $extra_class ) ? "$extra_class " : ''; // add space
	$class .= "wpb-mailchimp-form-container wpb-mailchimp-size-$size wpb-mailchimp-align-$alignment wpb-mailchimp-text-align-$text_alignment";
	$style = '';

	if ( $animation ) {
		$class .= " wow $animation";
	}

	if ( $animation_delay && 'none' != $animation ) {
		$style .= 'animation-delay:' . absint( $animation_delay ) / 1000 . 's;-webkit-animation-delay:' . absint( $animation_delay ) / 1000 . 's;';
	}

	if ( $inline_style ) {
		$style .= $inline_style;
	}

	$background = wpb_get_url_from_attachment_id( $image_id, 'WPB-2x2' );

	if ( $background && $use_bg ) {
		$class .= ' wpb-mailchimp-has-bg';
		$style .= 'background-image:url(' . $background . ')';
	}

	$output = '<div class="' . wpb_sanitize_html_classes( $class ) . '" style="' . wpb_esc_style_attr( $style ) . '">';
	
	$output .= '<form class="wpb-mailchimp-form"><input type="hidden" name="wpb-mailchimp-list" class="wpb-mailchimp-list" value="' . esc_attr( $list ) . '">';
	
	if ( $label ) {
		$output .= '<h3 class="wpb-mailchimp-title">' . $label . '</h3>';
	}
		
	$output .= '<div class="wpb-mailchimp-email-container">
		<input placeholder="' . $placeholder . '"  type="text" name="wpb-mailchimp-email" class="wpb-mailchimp-email">
		</div>';
	$output .= "<div class='wpb-mailchimp-submit-container'>
		<input type='submit' name='wpb-mailchimp-submit' class='wpb-mailchimp-submit $button_style' value='$submit'>
	</div>";
	$output .= '<div class="wpb-clear"></div>';
	$output .= '<span class="wpb-mailchimp-result">&nbsp;</span>';
	$output .= '</form>';
	$output .= '</div><!-- .wpb-mailchimp-form-container -->';

	if ( wpb_get_option( 'mailchimp', 'mailchimp_api_key' ) && ! empty( $list ) ) {

		return $output;

	} elseif ( is_user_logged_in() ) {

		$output = '<p class="wpb-text-center">';

		if ( ! wpb_get_option( 'mailchimp', 'mailchimp_api_key' ) ) {
			$output .= esc_html__( 'You must set your MailChimp API key in the plugin settings', 'wolf-page-builder' ) . '<br>';
		}

		if ( ! $list ) {
			$output .= esc_html__( 'You must set a list ID.', 'wolf-page-builder' );
		}

		$output .= '</p>';
		return $output;
	}
}