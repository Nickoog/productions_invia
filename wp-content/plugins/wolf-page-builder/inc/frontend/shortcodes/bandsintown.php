<?php
/**
 * Bandsintown shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfPageBuilder/FrontEnd/Shortcodes
 * @version 2.9.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpb_shortcode_bandsintown_events' ) ) {
	/**
	 * Bandsintown shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wpb_shortcode_bandsintown_events( $atts ) {

		extract( shortcode_atts( array(
			'artist' => '',
			'inline_style' => '',
			'extra_class' => '',
		), $atts ) );

		$output = '';
		$artist = sanitize_text_field( $artist );
		$artist_slug = sanitize_title( $artist );

		if ( $artist ) {

			ob_start(); ?>
			<script type="text/javascript" src="https://widget.bandsintown.com/javascripts/bit_widget.js"></script>
			<script type="text/javascript">  
			jQuery( document ).ready( function( $ ) { 
				new BIT.Widget( { 
					'artist' : '<?php echo esc_js( $artist ); ?>',
					'div_id' : 'wpb-bandwintown-tour-dates-<?php echo sanitize_html_class( $artist_slug ); ?>'
				} ).insert_events();
			} );
			</script>
			<div id="wpb-bandwintown-tour-dates-<?php echo sanitize_html_class( $artist_slug ); ?>"></div>
			<?php
			$output = ob_get_clean();

		} else {
			if ( is_user_logged_in() ) {
				$output  = esc_html__( 'Please set an artist.', 'wolf-page-builder' );
			} else {
				$output  = esc_html__( 'No event scheduled.', 'wolf-page-builder' );
			}
		}
		
		return $output;
	}
	add_shortcode( 'wpb_bandsintown_events', 'wpb_shortcode_bandsintown_events' );
}