<?php
/**
 * Sonic gallery settings
 *
 * @package WordPress
 * @subpackage Sonic
 * @version 2.2.4
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'sonic_add_media_manager_options' ) ) {
	/**
	 * Add settings to gallery media manager
	 *
	 * @see http://wordpress.stackexchange.com/questions/90114/enhance-media-manager-for-gallery
	 * @since Sonic 1.0.0
	 */
	function sonic_add_media_manager_options() {
		// define your backbone template;
		// the "tmpl-" prefix is required,
		// and your input field should have a data-setting attribute
		// matching the shortcode name
		?>
		<script type="text/html" id="tmpl-custom-gallery-setting">

			<label class="setting">
				<span><?php esc_html_e( 'Layout', 'sonic' ); ?></span>
				<select data-setting="layout">
					<option value="simple"><?php esc_html_e( 'Simple', 'sonic' ); ?></option>
					<option value="mosaic"><?php esc_html_e( 'Mosaic', 'sonic' ); ?></option>
					<option value="slider"><?php esc_html_e( 'Slider (settings below won\'t be applied)', 'sonic' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Custom size', 'sonic' ); ?></span>
				<select data-setting="size">
					<option value="sonic-thumb"><?php esc_html_e( 'Standard', 'sonic' ); ?></option>
					<option value="sonic-2x2"><?php esc_html_e( 'Square', 'sonic' ); ?></option>
					<option value="sonic-portrait"><?php esc_html_e( 'Portrait', 'sonic' ); ?></option>
					<option value="thumbnail"><?php esc_html_e( 'Thumbnail', 'sonic' ); ?></option>
					<option value="medium"><?php esc_html_e( 'Medium', 'sonic' ); ?></option>
					<option value="large"><?php esc_html_e( 'Large', 'sonic' ); ?></option>
					<option value="full"><?php esc_html_e( 'Full', 'sonic' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Padding', 'sonic' ); ?></span>
				<select data-setting="padding">
					<option value="yes"><?php esc_html_e( 'Yes', 'sonic' ); ?></option>
					<option value="no"><?php esc_html_e( 'No', 'sonic' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Hover effect', 'sonic' ); ?></span>
				<select data-setting="hover_effect">
					<option value="default"><?php esc_html_e( 'Default', 'sonic' ); ?></option>
					<option value="scale-to-greyscale"><?php esc_html_e( 'Scale + Colored to Black and white', 'sonic' ); ?></option>
					<option value="greyscale"><?php esc_html_e( 'Black and white to colored', 'sonic' ); ?></option>
					<option value="to-greyscale"><?php esc_html_e( 'Colored to Black and white', 'sonic' ); ?></option>
					<option value="scale-greyscale"><?php esc_html_e( 'Scale + Black and white to colored', 'sonic' ); ?></option>
					<option value="none"><?php esc_html_e( 'None', 'sonic' ); ?></option>
				</select>
				<small><?php esc_html_e( 'Note that not all browser support the black and white effect', 'sonic' ); ?></small>
			</label>
		</script>

		<script>

		jQuery( document ).ready( function() {
			// add your shortcode attribute and its default value to the
			// gallery settings list; $.extend should work as well...
			_.extend(wp.media.gallery.defaults, {
				size : 'standard',
				padding : 'no',
				hover_effet : 'default'
			} );

			// merge default gallery settings template with yours
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend( {
				template: function( view ) {
					return wp.media.template( 'gallery-settings' )( view )
					+ wp.media.template( 'custom-gallery-setting' )( view );
				}
			} );
		} );
		</script>
		<?php

	}
	add_action( 'print_media_templates', 'sonic_add_media_manager_options' );
}