<?php
/**
 * Update instagram shortcode
 */
function wpb_update_instagram_shortcode() {
	
	$pages = get_pages();

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		$content = get_post_meta( $page_id, '_wpb_shortcode_content', true );
		$content = str_replace( 'wolfgram_gallery', 'wolf_instagram_gallery', $content );
		
		// update meta
		update_post_meta( $page_id, '_wpb_shortcode_content', $content );
	}
}

/**
 * Update button attr
 */
function wpb_update_button_attr() {
	
	$pages = get_pages();

	$_attrs_regex = '[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-я= {}0-9#@|\%_\.:;,+\/\/\?!\'%&€^¨°¤£$§~()`*"-]+';
	$_all_regex = '(.*?)';

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		$content = get_post_meta( $page_id, '_wpb_shortcode_content', true );

		$content = preg_replace_callback( '/\[wpb_button ' . $_attrs_regex . '\]/', function( $matches ) {

			$output = '';

			foreach ( $matches as $shortcode ) {
				$parsed_shortcode = shortcode_parse_atts( $shortcode );
				$args = str_replace( array( '[wpb_button', ']' ), '', $shortcode );
				$attrs = shortcode_parse_atts( $args );
				$string_to_replace = '';

				if ( isset( $attrs['theme_button_style'] ) && $attrs['theme_button_style'] ) {
					$string_to_replace = 'type="' . $attrs['type'] . '"';
				}

				$output .= str_replace( $string_to_replace, 'type="wolf-button"', $shortcode );
			}

			return $output;

		}, $content );

		// update meta
		update_post_meta( $page_id, '_wpb_shortcode_content', $content );
	}
}

/**
 * Update list fields seprator from comma to line break
 */
function wpb_update_list_field_separator() {
	$pages = get_pages();

	$_attrs_regex = '[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-я= {}0-9#@|\%_\.:;,+\/\/\?!\'%&€^¨°¤£$§~()`*"-]+';
	$_all_regex = '(.*?)';

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		$content = get_post_meta( $page_id, '_wpb_shortcode_content', true );

		$content = preg_replace_callback( '/\[wpb_pricing_table ' . $_attrs_regex . '\]/', function( $matches ) {

			$output = '';

			foreach ( $matches as $shortcode ) {
				$parsed_shortcode = shortcode_parse_atts( $shortcode );
				$args = str_replace( array( '[wpb_pricing_table', ']' ), '', $shortcode );
				$attrs = shortcode_parse_atts( $args );
				$old_services = ( isset( $attrs['services'] ) ) ? $attrs['services'] : null;
				
				if ( $old_services ) {
					$new_services = wpb_clean_list( $old_services );
					$new_services = wpb_encode_textarea_html( str_replace( ',', "\n", $new_services ) );
					$output .= str_replace( $old_services, $new_services, $shortcode );
				}
			}

			return $output;

		}, $content );

		$content = preg_replace_callback( '/\[wpb_services_table ' . $_attrs_regex . '\]/', function( $matches ) {

			$output = '';

			foreach ( $matches as $shortcode ) {
				$parsed_shortcode = shortcode_parse_atts( $shortcode );
				$args = str_replace( array( '[wpb_services_table', ']' ), '', $shortcode );
				$attrs = shortcode_parse_atts( $args );
				$old_services = ( isset( $attrs['services'] ) ) ? $attrs['services'] : null;
				
				if ( $old_services ) {
					$new_services = wpb_clean_list( $old_services );
					$new_services = wpb_encode_textarea_html( str_replace( ',', "\n", $new_services ) );
					$output .= str_replace( $old_services, $new_services, $shortcode );
				}
			}

			return $output;

		}, $content );

		$content = preg_replace_callback( '/\[wpb_typed ' . $_attrs_regex . '\]/', function( $matches ) {

			$output = '';

			foreach ( $matches as $shortcode ) {
				$parsed_shortcode = shortcode_parse_atts( $shortcode );
				$args = str_replace( array( '[wpb_typed', ']' ), '', $shortcode );
				$attrs = shortcode_parse_atts( $args );
				$old_text = ( isset( $attrs['text'] ) ) ? $attrs['text'] : null;
				
				if ( $old_text ) {
					$new_text = wpb_clean_list( $old_text );
					$new_text = wpb_encode_textarea_html( str_replace( ',', "\n", $new_text ) );
					$output .= str_replace( $old_text, $new_text, $shortcode );
				}
			}

			return $output;

		}, $content );

		// update meta
		update_post_meta( $page_id, '_wpb_shortcode_content', $content );
	}
}

/**
 * Update link attr
 */
function wpb_update_link_attr() {
	// Big text
	// link -> link_url
	// target -> link_target

	$element_to_update = array(
		'wpb_bigtext' => array(
			'link=' => 'link_url=',
			'target=' => 'link_target=',
		),

		'wpb_headline' => array(
			'link=' => 'link_url=',
			'target=' => 'link_target=',
		),

		'wpb_image' => array(
			'url=' => 'link_url=',
			'target=' => 'link_target=',
		),

		'wpb_image_link' => array(
			'link=' => 'link_url',
			'target=' => 'link_target',
		),

		'wpb_icon_with_text' => array(
			'icon_link=' => 'link_url=',
			'icon_link_target=' => 'link_target=',
		),

		'wpb_process_item' => array(
			'link=' => 'link_url=',
			'target=' => 'link_target=',
		),

		'wpb_button' => array(
			'link=' => 'link_url=',
			'target=' => 'link_target=',
		),

		'wpb_call_to_action' => array(
			'link=' => 'link_url=',
			'target=' => 'link_target=',
		),

		'wpb_advanced_slider' => array(
			'button_1_link=' => 'button_1_link_url=',
			'button_1_target=' => 'button_1_link_target=',
			'button_2_link=' => 'button_2_link_url=',
			'button_2_target=' => 'button_2_link_target=',
		),
	);
	$pages = get_pages();

	$_attrs_regex = '[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-я= {}0-9#@|\%_\.:;,+\/\/\?!\'%&€^¨°¤£$§~()`*"-]+';
	$_all_regex = '(.*?)';

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		$content = get_post_meta( $page_id, '_wpb_shortcode_content', true );

		foreach ( $element_to_update as $basename => $values_to_replace ) {
			
			$content = preg_replace_callback( '/\[' . $basename . ' ' . $_attrs_regex . '\]/', function( $matches ) use( $basename, $values_to_replace ) {

				$output = '';

				foreach ( $matches as $shortcode ) {
					$parsed_shortcode = shortcode_parse_atts( $shortcode );
					$args = str_replace( array( '[' . $basename . '', ']' ), '', $shortcode );
					$attrs = shortcode_parse_atts( $args );

					$output .= str_replace( array_keys( $values_to_replace ), array_values( $values_to_replace ), $shortcode );
				}

				return $output;

			}, $content );

		} // endforeach element

		//debug( $content );

		// update meta
		update_post_meta( $page_id, '_wpb_shortcode_content', $content );
	}
}

/**
 * Update old settings indexes
 */
function wpb_update_settings() {

	$current_version = get_option( 'wpb_version' );
	
	if ( version_compare( $current_version, '1.8.7', '<' ) ) {

		if ( wpb_get_option( 'wpb_settings', 'mailchimp_api_key' ) ) {
			wpb_update_option( 'mailchimp', 'mailchimp_api_key', wpb_get_option( 'wpb_settings', 'mailchimp_api_key' ) );
		}

		if ( wpb_get_option( 'wpb_settings', 'css_min' ) ) {
			wpb_update_option( 'settings', 'css_min', wpb_get_option( 'wpb_settings', 'css_min' ) );
		}

		if ( wpb_get_option( 'wpb_settings', 'js_min' ) ) {
			wpb_update_option( 'settings', 'js_min', wpb_get_option( 'wpb_settings', 'js_min' ) );
		}

		if ( wpb_get_option( 'wpb_fonts', 'google_fonts' ) ) {
			wpb_update_option( 'fonts', 'google_fonts', wpb_get_option( 'wpb_fonts', 'google_fonts' ) );
		}

		if ( get_option( 'wpb_socials' ) ) {
			foreach ( get_option( 'wpb_socials' ) as $key => $value) {
				wpb_update_option( 'socials', $key, $value );
			}
		}
	}

	if ( version_compare( $current_version, '1.9.1', '<' ) ) {

		delete_option( 'wpb_settings' );

		if ( get_option( 'settings' ) && is_array( get_option( 'settings' ) ) ) {
			wpb_update_option_index( 'settings', get_option( 'settings' ) );
		}

		if ( get_option( 'mailchimp' ) && is_array( get_option( 'mailchimp' ) ) ) {
			wpb_update_option_index( 'mailchimp', get_option( 'mailchimp' ) );
		}

		if ( get_option( 'fonts' ) && is_array( get_option( 'fonts' ) ) ) {
			wpb_update_option_index( 'fonts', get_option( 'fonts' ) );
		}

		if ( get_option( 'socials' ) && is_array( get_option( 'socials' ) ) ) {
			wpb_update_option_index( 'socials', get_option( 'socials' ) );
		}
	}

	if ( version_compare( $current_version, '2.3.1', '<' ) ) {
		wpb_update_button_attr();
	}

	if ( version_compare( $current_version, '2.3.7', '<' ) ) {
		wpb_update_list_field_separator();
	}

	if ( version_compare( $current_version, '2.8.5', '<' ) ) {
		wpb_update_instagram_shortcode();
		wpb_update_link_attr();
		//debug( 'updated' );
	}
}
add_action( 'wpb_do_update', 'wpb_update_settings' );